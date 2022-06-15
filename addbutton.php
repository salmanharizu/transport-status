<?php
include "connect.php";
session_start();
$myusername = $_SESSION['sid'];
$mystaffname = $_SESSION['sname'];
$mystaffemail = $_SESSION['semail'];
$mystaffcategory = $_SESSION['scategory'];

$result = mysqli_query($db,"SELECT * FROM booking_master WHERE staff_id = '$myusername'");

$result2= mysqli_query($db,"SELECT a.*, b.ref_desc
                            FROM booking_master a
                            JOIN reference_master b
                            ON a.book_status = b.ref_code
                            WHERE ref_type = 'BOOKING STATUS'
                            AND a.book_status not in ('2','4') /* 2:cancel book, 4:car key was returned
                            AND a.book_start_date >= CURRENT_DATE*/
                            /*and (DATE_FORMAT(book_start_date,'%m-%Y') = month(curdate()) or DATE_FORMAT(book_start_date,'%m-%Y') = month (curdate())+1)*/
                            and book_end_date >= CURRENT_DATE
                            order by book_start_date desc");

$qselect2 = "SELECT staff_shortname, staff_email, ref_desc
              FROM staff a
              JOIN reference_master b
              ON a.staff_category = b.ref_code
              WHERE ref_type = 'STAFF CATEGORY'
              AND staff_id = '$myusername';";
$qresult2 = mysqli_query($db, $qselect2);
$qrow2 = mysqli_fetch_array($qresult2);

?>
<!DOCTYPE html>
<html lang="en" dir="ltr" xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta charset="utf-8">
    <title>IP Fokus</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>


    <script>
      $(function(){
      var dtToday = new Date();

      var month = dtToday.getMonth() + 1;
      var day = dtToday.getDate();
      var year = dtToday.getFullYear();
      if(month < 10)
          month = '0' + month.toString();
      if(day < 10)
          day = '0' + day.toString();

      var maxDate = year + '-' + month + '-' + day;

      //alert(maxDate);
      $('#bstartdate').attr('min', maxDate);
      $('#benddate').attr('min', maxDate);
      });
    </script>

    <script>
    function getCurrentTime(date) {
        var hours = date.getHours(),
            minutes = date.getMinutes(),
            ampm = hours >= 12 ? 'pm' : 'am';

      hours = hours % 12;
      hours = hours ? hours : 12; // the hour '0' should be '12'
      minutes = minutes < 10 ? '0'+minutes : minutes;

      return hours + ':' + minutes + ' ' + ampm;
    }

    var timeOptions = {
        'timeFormat': 'h:i A',
        'minTime': getCurrentTime(new Time())
    };
    </script>

    <style>
    .form-time {
      display: flex;
      flex-flow: row wrap;
      align-items: center;
    }

    .form-time input {
      vertical-align: middle;
      margin: 5px 10px 5px 0;
      padding: 10px;
      background-color: #fff;
      border: 1px solid #ddd;
    }

    .form-time label {
      margin: 5px 10px 5px 0;
    }

    .form-time {
       flex-direction: column;
       align-items: stretch;
     }
    </style>

    <style type="text/css">
    .auto-style1 {
      text-align: left;
    }
    </style>
  </head>

  <body>
    <div class="container vh-100">
      <div class="row justify-content-center h-100">
        <div class="card w-55 my-auto shadow">
          <div class="card-header text-center bg-primary text-white">
            <form action=addProcess.php method="post" enctype="multipart/form-data">
              <h2>New Car Booking</h2>
          </div>
          <div class="card-body">

          <table width=100%; style="border: 0px;">
            <tr>
            <!--<div class="form-group">-->
                <th style="border: 0px; width: 80px; height: 23px;">Applied By </th>
            		<td style="border: 0px; width: 200px; height: 23px;">
                  <input type="text" style="font-weight:bold;" id="sid" class="form-control" placeholder="ID" name="sid" value="<?php echo $myusername ."-" . $mystaffname ?>" readonly/>
                </td>
                <th style="border: 0px; width: 120px; height: 23px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Staff Category </th>
            		<td style="border: 0px; width: 200px; height: 23px; ">
                  <input type="text" style="font-weight:bold;" id="scat" class="form-control" placeholder="SCAT" name="scat" value="<?php echo $qrow2["ref_desc"]; ?>" readonly/>
                </td>
              <!--</div>-->
            </tr>
          </table>

          <table width=100%; style="border: 0px;">

            <div class="form-group">
              <input type="hidden" id="idd" class="form-control" placeholder="idd" name="idd" value="<?php echo $myusername ?>" readonly/>
              <input type="hidden" id="sname" class="form-control" placeholder="sname" name="sname" value="<?php echo $mystaffname ?>" readonly/>
              <input type="hidden" id="emailid" class="form-control" placeholder="email" name="emailid" value="<?php echo $mystaffemail ?>" readonly/>
            </div>
            <!--<tr>
          		<td style="border: 0px; width: 10px; height: 23px;"></td>
          		<td style="border: 0px; width: 40px; height: 23px;"></td>
          		<td style="border: 0px; width: 40px; height: 23px;"></td>
          		<td style="border: 0px; width: 40px; height: 23px; "></td>
          	</tr>-->
            <tr>
          		<td style="border-style: none; border-color: inherit; border-width: 0px; width: 80px; height: 23px;"></td>
          		<td style="border-style: none; border-color: inherit; border-width: 0px; width: 200px; height: 23px;"></td>
          		<td style="border-style: none; border-color: inherit; border-width: 0px; width: 120px; height: 23px;"></td>
          		<td style="border-style: none; border-color: inherit; border-width: 0px; width: 200px; height: 23px; "></td>
          	</tr>

          	<tr>
              <div class="form-group">
            		<th style="border: 0px;">Depart Date :</th>
            		<td style="border: 0px; width: 10px">
                <input type="date" id="bstartdate" class="form-control" placeholder="Date" name="bstartdate" value="" required/></td>
            		<th style="border: 0px; width: 50px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Return Date :</th>
            		<td style="border: 0px; width: 50px">
                <input type="date" id="benddate" class="form-control" placeholder="Date" name="benddate" value="" required/>
              </div>
            </tr>
          	<tr>
              <div class="form-time">
          		<th style="border: 0px; width: 50px">Depart Time :</th>
          		<td style="border: 0px; width: 50px"><input type="time" id="bstarttime" class="form-control" placeholder="Time" name="bstarttime" value="" required/></td>
          		<th style="border: 0px; width: 50px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Return Time :</th>
          		<td style="border: 0px; width: 50px"><input type="time" id="bendtime" class="form-control" placeholder="Time" name="bendtime" value="" required/></td>
            </div>
          	</tr>
          </table>

          <table width=100%; style="border: 0px;">
            <tr>
              <div class="form-group">
                  <th style="border: 0px; width: 85px; height: 23px;">Car : </th>
              		<td style="border: 0px; width: 250px">
                    <select id='bcarno' name ='bcarno' style="width: 250px" required>
                    <option disabled selected value="">-- Select Car --</option>
                      <?php
                        $records = mysqli_query($db, "SELECT * from car_master WHERE car_status ='1'");  // Use select query here

                        while($data = mysqli_fetch_array($records))
                        {
                          echo "<option value='". $data['car_no'] ."'>" .$data['car_no'] ." - ". $data['car_name'] ."</option>";  // displaying data in option menu
                        }
                      ?>
                  </select></td>
                  <td style="border: 0px; width: 110px"><strong>&nbsp;Car To Service?</strong></td>
                  <td style="border: 0px; width: 100px"><input type="radio" id="yes" name="cartoservice" value="1">
                    <label for="Yes"><strong>Yes</strong></label></td>
                  <td style="border: 0px; width: 100px"><input type="radio" id="no" name="cartoservice" value="0" checked>
                    <label for="No"><strong>No</strong></label></td>
              </div>
            </tr>
          </table>

          <!--<div class="form-group">
            <strong>&nbsp;&nbsp;&nbsp;Car :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong>
              <select id='bcarno' name ='bcarno' style="width: 250px">
                <option disabled selected>-- Select Car --</option>
                  <?php
                    include "connect.php";  // Using database connection file here

                    $records = mysqli_query($db, "SELECT * from car_master WHERE car_status ='1'");  // Use select query here

                    while($data = mysqli_fetch_array($records))
                    {
                      echo "<option value='". $data['car_no'] ."'>" .$data['car_no'] ." - ". $data['car_name'] ."</option>";  // displaying data in option menu
                    }
                  ?>
              </select>
          </div>-->

          <table width=100%; style="border: 0px;">
            <tr>
            <div class="form-group">
                <th style="border: 0px; width: 78px; height: 23px;">Remarks : </th>
            		<td style="border: 0px; width: 520px; height: 23px;">
                  <input type="text" style="font-weight:bold;" maxlength="180" id="book_desc" class="form-control" placeholder="Description" name="bdesc" value="" required/>
                </td>
              </div>
            </tr>
          </table>
          <br>

          <!--<div class="form-group">
            <input type="text" style="font-weight:bold;" id="book_desc" class="form-control" placeholder="Description" name="bdesc" value="" required/>
          </div>-->

          <div class="form-group">
            <input type="submit" class="btn btn-primary w-100" name="save" value="Submit Book"  onclick = "test();" >
          </div>
          <div class="form-group">
            <center><a href="choicebutton.php" class="btn btn-danger">Back</a></center>
          </div>

          </form>
        </div>

        <div class="card-footer text-right">
          <small><?php echo $mystaffemail ?></small>
          <img src="logoipfokus.jpeg" alt="IPF" width="150" height="40" align="center">
          <!--<small>&copy; IP Fokus</small>-->
        </div>
      </div>

      <head>
  	  <style type="text/css">
  	  .auto-style1 {
  		  text-align: left;
  	  }
      div.b {
        text-align: left;
      }
  	  </style>
  	  </head>

      <div class="b">
        <h2></h2>
      <div>
        <td><strong><u>LIST OF CURRENT BOOKING</strong></u></td>
      </div>

      <div class="card-body">
        <!--<div style="height:500px;width:1095px;border:1px solid #ccc;font:15px/20px Georgia, Garamond, Serif;overflow:auto;">
          <style>
          table,td
          {
           border: 0px solid black;
           border-collapse: collapse;
           padding-right: 35px;
           padding-left: 35px;
           width: 100%;
          }
          </style>

          <table style="width: 100%; height: 51px;" align="left">

            <tr>
              <td style="border: 1px solid black; width: 10px;">No.</td>
              <td style="border: 1px solid black; width: 10%;">Book ID</td>
              <td style="border: 1px solid black; width: 11%;">Car No</td>
              <td style="border: 1px solid black; width: 15%;">Start Book</td>
              <td style="border: 1px solid black; width: 17%;">End Book</td>
              <td style="border: 1px solid black; width: 12%;">Applied By</td>
              <td style="border: 1px solid black; width: 20%;">Description</td>
              <td style="border: 1px solid black; width: 19%;">Status</td>
            </tr>-->


            <div style="height:100%;border:1px solid #ccc;font:15px/20px Georgia, Garamond, Serif;overflow:auto;">
            <style>
            table, th, td
            {
              border: 1px solid black;
              border-collapse: collapse;
              padding-right: 15px;
              padding-left: 15px;
              table-layout: fixed;
              text-align: left;
            }
          </style>

            <table>
              <tr>
                <th style="border: 1px solid black; width: 50px">No.</th>
                <th style="border: 1px solid black; width: 100px">BookID</th>
                <th style="border: 1px solid black; width: 140px">Car No</th>
                <th style="border: 1px solid black; width: 140px">Start Book</th>
                <th style="border: 1px solid black; width: 140px">End Book</th>
                <th style="border: 1px solid black; width: 150px">Applied By</th>
                <th style="border: 1px solid black; width: 350px">Description</th>
                <th style="border: 1px solid black; width: 130px">Status</th>
              </tr>
              <?php

              $i=1;
              while($row2 = mysqli_fetch_array($result2))
              //echo $row["a.book_id"];
              {
                $qselect = "SELECT staff_shortname, staff_email
                              FROM staff
                              WHERE staff_id = '$row2[staff_id]';";
                $qresult = mysqli_query($db, $qselect);
                $qrow = mysqli_fetch_array($qresult);
                ?>

                <tr class="<?php if(isset($classname)) echo $classname;?>">
                <td style="border: 1px solid black;"><?php echo $i."."; ?></td>
                <td style="border: 1px solid black;"><?php echo $row2["book_id"]; ?></td>
                <td style="border: 1px solid black;"><?php echo $row2["book_carno"]; ?></td>
                <td style="border: 1px solid black;"><?php echo date('d-m-Y', strtotime($row2["book_start_date"])) . ' ' . date('h:i a', strtotime($row2["book_start_time"])); ?></td>
                <td style="border: 1px solid black;"><?php echo date('d-m-Y', strtotime($row2["book_end_date"])) . ' ' . date('h:i a', strtotime($row2["book_end_time"])); ?></td>
                <td style="border: 1px solid black;"><?php echo $qrow["staff_shortname"]; ?></td>
                <td style="border: 1px solid black;"><?php echo $row2["book_desc"]; ?></td>
                <td style="border: 1px solid black;"><?php echo $row2["ref_desc"]; ?></td>
                </tr>
                <?php
                $i++;
              }

                ?>
            </table>

       </div>
     </div>

     <?php
            mysqli_close($db);  // close connection
     ?>
    </div>
  </div>
</body>

</html>

<script type = "text/javascript" >
    function preventBack() { window.history.forward(); }
    setTimeout("preventBack()", 0);
    window.onunload = function () { null };
  </script>

  <script type="text/javascript">
  $(function () {
      $('#datetimepickerDemo').datetimepicker({
          minDate:new Date()
      });
  });
  </div></script>

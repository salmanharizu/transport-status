<?php
session_start();
include "connect.php";

$myusername = $_SESSION['sid'];
$mystaffname = $_SESSION['sname'];
$mystaffemail = $_SESSION['semail'];
//$bookid = $_SESSION['bookid'];

$sql=mysqli_query($db,"SELECT * FROM booking_master Where staff_id = '$myusername' And book_id='".$_GET['book_id']."'");
//$sql=mysqli_query($db,"SELECT * FROM booking_master Where staff_id = '$myusername' And book_id='$bookid'");
$row=mysqli_fetch_array($sql);

$vstartdatetime = date('Y-m-d', strtotime($row['book_start_date']));
$venddatetime = date('Y-m-d', strtotime($row['book_end_date']));
//$vstarttime = date('h:i a', strtotime($row['book_start_time']));
//$vendtime = date('h:i a', strtotime($row['book_end_time']));
//echo $row['book_start_date'];
//echo $vstartdatetime;
$vstarttime = $row['book_start_time'];
$vendtime = $row['book_end_time'];

//echo $row['book_start_date'];
//echo $vstartdatetime;
//echo $vstarttime;
//echo $vendtime;
//print_r($row);
?>

<!--<?php echo date('d-m-Y', strtotime($row['book_start_date']))?>;-->

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>IP Fokus</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
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

    //textbox for alert localhost date
    //alert(maxDate);
    $('#bstartdate').attr('min', maxDate);
    $('#benddate').attr('min', maxDate);
});

</script>

</head>
  <body>
    <div class="container vh-100">
      <div class="row justify-content-center h-100">
        <div class="card w-55 my-auto shadow">
          <div class="card-header text-center bg-primary text-white">
            <form action ="editProcess.php" method="post" enctype="multipart/form-data">
              <h2>Edit Booking</h2>
          </div>
          <div class="card-body">

              <div class="form-group">
                <input type="text" style="font-weight:bold;" id="sidnamedisplay" class="form-control" placeholder="ID" name="sidnamedisplay" value="&nbsp;&nbsp;Applied By : <?php echo $row['staff_id'] ."-".$mystaffname ."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Booking ID : ". $row['book_id'] ?>" readonly/>
              </div>

              <div class="form-group">
                <!--<label for='booking_id' >Booking ID:</label>-->
                <input type="hidden" id="sidname" class="form-control" placeholder=""  name="sidname" value="<?php echo $row['staff_id'] ."-".$mystaffname ?>" readonly/>
                <input type="hidden" id="book_id" class="form-control" placeholder=""  name="bid" value="<?php echo $row['book_id']?>" readonly/>
              </div>

              <table>

                <tr>
                  <td style="width: 100px; height: 23px;"></td>
                  <td style="width: 50px; height: 23px;"></td>
                  <td style="width: 200px; height: 23px;"></td>
                  <td style="width: 50px; height: 23px; "></td>
                </tr>
                <tr>
                  <div class="form-group">
                    <td style="width: 100px"><strong>Depart Date</strong></td>
                    <td style="width: 50px">
                      <input type="date" id="bstartdate" class="form-control" placeholder="date" name="bstartdate" value="<?php echo $vstartdatetime ?>" required/></td>
                    <td style="width: 200px"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Return Date</strong></td>
                    <td style="width: 50px">
                      <input type="date" id="benddate" class="form-control" placeholder="Date" name="benddate" value="<?php echo $venddatetime ?>" required/>
                    </div>
                </tr>

                <tr>
    						  <td style="width: 150px"><label for='booking_id'><strong>Depart Time</strong></label></td>
    						  <td><input type="time" id="bstarttime" class="form-control" placeholder="time"  name="bstarttime" value="<?php echo $vstarttime?>" required/></td>
    						  <td style="width: 178px"><label for='booking_id'><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Return Time</strong></label></td>
    						  <td><input type="time" id="bendtime" class="form-control" placeholder="time"  name="bendtime" value="<?php echo $vendtime?>" required/></td>
    					  </tr>
  				    </table>

              <div class="form-group">
                <input type="hidden" id="idd" class="form-control" placeholder="idd" name="idd" value="<?php echo $myusername ?>" readonly/>
              </div>

              <div class="form-group">
                <input type="hidden" id="sname" class="form-control" placeholder="sname" name="sname" value="<?php echo $mystaffname ?>" readonly/>
              </div>

              <div class="form-group">
                <input type="hidden" id="emailid" class="form-control" placeholder="email" name="emailid" value="<?php echo $mystaffemail ?>" readonly/>
              </div>

              <div class="form-group">
                <label for='book_carno'><strong>Car &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong></label>
                <select  name ='bcarno' id='book_carno' style="width: 200px">
                  <option selected><?php echo $row["book_carno"] ?></option>
                    <?php

                      //$records = mysqli_query($db, "SELECT * from car_details WHERE car_status ='0' OR car_no = '" . $row["book_carno"]."'" );  // Use select query here
                      $records = mysqli_query($db, "SELECT * from car_master WHERE car_status ='1' OR car_no = '" . $row["book_carno"]."'" );  // Use select query here

                      while($data = mysqli_fetch_array($records))
                      {
                        echo "<option value='". $data['car_no'] ."'>" .$data['car_no'] ." - ". $data['car_name'] ."</option>";  // displaying data in option menu
                      }
                    ?>
                </select>
              </div>
              <?php
                mysqli_close($db);  // close connection
              ?>

              <table>
                <tr>
                  <td style="border: 0px; width: 150px">Car To Service?</td>
                  <td style="width: 150px">
                    <input type="radio" id="yes" name="cartoservice" value="1"
                      <?php
                      if ($row['car_to_service'] == '1')
                      {
                        echo "checked";
                      }
                      ?>>&nbsp;Yes &nbsp;&nbsp;&nbsp;
                      <input type="radio" id="no" name="cartoservice" value="0"
                      <?php
                      if ($row['car_to_service'] == '0')
                      {
                        echo "checked";
                      }
                      ?>
                      >&nbsp;No
                    </td>
                </tr>
              </table>

              <table>
                <div class="form-group">
                    <tr>
                      <td style="border: 0px; width: 150px">Description</td>
                      <td style="border: 0px; width: 600px"><input type="text" maxlength="180" id="book_desc" class="form-control" placeholder="" name="bdesc" value="<?php echo $row['book_desc']?>" required/></td>
                    </tr>
                </div>
              </table>
              <br>
              <div class="form-group">
                <input type="submit" class="btn btn-primary w-100" name="save" value="Submit"  onclick = "Warn();" >
              </div>
              <div class="form-group">
                <center><a href="editbutton.php" class="btn btn-danger">Back</a></center>
              </div>

            </form>
            </div>

          <div class="card-footer text-right">
            <small><?php echo $mystaffemail ?></small>
            <small>&copy; IP Fokus</small>
          </div>
        </div>

      </div>

    </div>
  </body>

</html>

<!-- javascript for disable back button -->
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
</script>

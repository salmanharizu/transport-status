<?php
include "connect.php";
session_start();
$myusername = $_SESSION['sid'];
$mystaffname = $_SESSION['sname'];
$mystaffemail = $_SESSION['semail'];

$result = mysqli_query($db,"SELECT * FROM booking_master WHERE staff_id = '$myusername'");
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
      //$('#bstartdate').attr('min', maxDate);
      //$('#benddate').attr('min', maxDate);
      });
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
  </head>

  <body>
    <div class="container vh-100">
      <div class="row justify-content-center h-100">
        <div class="card w-50 my-auto shadow">
          <div class="card-header text-center bg-primary text-white">
            <form action=allbook.php method="post" enctype="multipart/form-data">
              <h2>Search</h2>
          </div>
          <div class="card-body">
          <table style="width: 100%">
            <div class="form-group">
               <strong> Booking ID:  </strong> <br>
               <div class="form-group">
                 <input type="text" id="book_id" class="form-control" placeholder="Booking ID" name="book_id" value="" style="width: 30%"/>
               </div>
            </div>
            <div class="form-group">
               <strong> Staff Name:  </strong> <br>
               <select id='staff_id' name ='staff_id'>
                  <option able selected>-- Select All --</option>
                    <?php
                      include "connect.php";  // Using database connection file here

                      $records = mysqli_query($db, "SELECT * from staff");  // Use select query here

                      while($data = mysqli_fetch_array($records))
                      {
                        echo "<option value='". $data['staff_id'] ."'>" .$data['staff_id'].' - '.$data['staff_name'] ."</option>";  // displaying data in option menu
                      }

                    ?>
               </select>
            </div>
            <div class="form-group">
               <strong> Cars:  </strong> <br>
               <select id='bcbarno' name ='bcarno'>
                  <option able selected>-- Select All --</option>
                    <?php
                      include "connect.php";  // Using database connection file here

                      $records = mysqli_query($db, "SELECT * from car_master WHERE car_status ='1'");  // Use select query here

                      while($data = mysqli_fetch_array($records))
                      {
                        //echo "<option selected='selected' value='". $data['car_no'] ."'>" .$data['car_no'] ."</option>";  // displaying data in option menu
                        echo "<option value='". $data['car_no'] ."'>" .$data['car_name'] ." - ". $data['car_no'] ."</option>";  // displaying data in option menu

                      }
                    ?>
                </select>
            </div>

            <tr>
              <div class="form-group">
              <th style="width: 100px">Departure Date: </th>
            </tr>
            <tr>
              <td style="width: 10px">
              <input type="date" id="bstartdate" class="form-control" placeholder="Date" name="bstartdate" value="" style="width: 40%"/></td>
            </tr>

            <?php
              mysqli_close($db);  // close connection
            ?>
          </table>
          <br>
          <div class="form-group">
            <input type="submit" class="btn btn-primary w-100" name="save" value="Submit"  onclick = "test();" >
          </div>
          <br>
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
</script>

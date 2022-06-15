<?php
session_start();
include "connect.php";

$myusername = $_SESSION['sid'];
$mystaffname = $_SESSION['sname'];
$mystaffemail = $_SESSION['semail'];

//echo $myusername;;
//echo $mystaffname;
//echo $mystaffemail;

$sql=mysqli_query($db,"SELECT * FROM booking_master Where staff_id = '$myusername' And book_id='".$_GET['book_id']."' and book_status in ('0','1')");
$row=mysqli_fetch_array($sql);

$bkdate=date_create($row["book_start_date"]);
$book_date = date_format($bkdate,"d-m-Y");
//print_r($row);
?>


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

    //alert(maxDate);
    $('#book_start_date').attr('min', maxDate);
});

</script>

</head>
  <body>
    <div class="container-fluid">
      <div class="row justify-content-center h-100">
        <div class="card w-50 my-auto shadow">
          <div class="card-header text-center bg-primary text-white">
            <form action ="cancelProcess.php" method="post" enctype="multipart/form-data">
              <h2>Cancel Booking </h2>
          </div>
          <div class="card-body">
              <div class="form-group">
                <input type="hidden" id="sid" class="form-control" placeholder="ID" name="sid" value="<?php echo $row['staff_id'] ?>" readonly/>
                <label for='booking_id' >Booking ID:</label>
                <input type="text" id="book_id" class="form-control" placeholder=""  name="bid" value="<?php echo $row['book_id']?>" readonly/>
              </div>
              <table>
                <tr>
    						  <td style="width: 200px"><label for='booking_id' >Depart Date</label></td>
    						  <td style="width: 200px"><input type="text" id="bstartdate" class="form-control" placeholder=""  name="bstartdate" value="<?php echo date('d-m-Y', strtotime($row['book_start_date']))?>" readonly/></td>
    						  <td style="width: 200px"><label for='booking_id' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Return Date</label></td>
    						  <td style="width: 200px"><input type="text" id="benddate" class="form-control" placeholder=""  name="benddate" value="<?php echo date('d-m-Y', strtotime($row['book_end_date']))?>" readonly/></td>
    					  </tr>

                <tr>
    						  <td style="width: 125px"><label for='booking_id' >Depart Time</label></td>
    						  <td><input type="text" id="bstarttime" class="form-control" placeholder=""  name="bstarttime" value="<?php echo date('h:i a', strtotime($row['book_start_time']))?>" readonly/></td>
    						  <td style="width: 178px"><label for='booking_id' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Return Time</label></td>
    						  <td><input type="text" id="bendtime" class="form-control" placeholder=""  name="bendtime" value="<?php echo date('h:i a', strtotime($row['book_end_time']))?>" readonly/></td>
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
                <label for='book_carno' >Cars:</label> <br>
                <div class="form-group">
                  <input type="text" id="book_carno" class="form-control" placeholder="bcarno" name="bcarno" value="<?php echo $row["book_carno"] ?>" readonly/>
                </div>
              </div>

              <?php
                mysqli_close($db);  // close connection
              ?>

              <div class="form-group">
                <label for='bdesc' >Booking Description:</label> <br>
                <input type="text" id="book_desc" class="form-control" placeholder="" name="bdesc" value="<?php echo $row['book_desc']?>" readonly/>
              </div>

              <div class="form-group">
                <label for='bdesc' >Reason To Cancel:</label> <br>
                <input type="text" id="book_reason" class="form-control" placeholder="" name="breason" value=" " required/>
              </div>

              <div class="form-group">
                <input type="submit" class="btn btn-primary w-100" name="save" value="Submit"  onclick = "Warn();" >
              </div>
              <div class="form-group">
                <!--<center><a href="choicebutton.php" class="btn btn-danger">Back</a></center>-->
                <center><a href="cancelbutton.php" class="btn btn-danger">Back</a></center>
              </div>

            </form>
            </div>

          <div class="card-footer text-right">
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

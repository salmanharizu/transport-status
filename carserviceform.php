<?php
session_start();
include "connect.php";

$myusername = $_SESSION['sid'];
$mystaffname = $_SESSION['sname'];
$mystaffemail = $_SESSION['semail'];

//echo $myusername;;
//echo $mystaffname;
//echo $mystaffemail;
//echo $_GET['book_id'];
//echo $myusername;
//echo $row['book_id'];

$qcar = "SELECT *
				 		FROM car_master
						WHERE car_no = '$_GET[car_no]'
						AND car_status = '1'";
$qresultcar = mysqli_query($db, $qcar);
$qcardet = mysqli_fetch_assoc($qresultcar);

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
            <form action ="returnbuttonProcess.php" method="post" enctype="multipart/form-data">
              <h2>Update Car Milleage </h2>
          </div>
          <div class="card-body">
            <table>
                <tr>
                  <td style="width: 50px"><label for='carno' >Car No</label>
                  <td style="width: 100px"><input type="text" id="carno" class="form-control" placeholder=""  name="carno" value="<?php echo $_GET['car_no'] ?>" readonly/>
                  <td style="width: 50px"><label for='book_carno' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Car</label></td>
                  <td style="width: 100px"><input type="text" id="carname" class="form-control" placeholder="" name="carname" value="<?php echo $_GET['car_name']." - ". $qcardet['car_name']?>" readonly/>
                  <!--<td style="width: 200px"><input type="text" id="bcarno" class="form-control" placeholder="" name="bcarno" value="<?php echo $myusername ?>" readonly/>-->
                </tr>
                <tr>
    						  <td style="width: 150px"><label for='depart_date' >Depart Date</label></td>
    						  <td style="width: 200px"><input type="text" id="bstartdate" class="form-control" placeholder=""  name="bstartdate" value="<?php echo date('d-m-Y', strtotime($_GET['book_startdate']))?>" readonly/></td>
    						  <td style="width: 50px"><label for='return_date' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Return Date</label></td>
    						  <td style="width: 200px"><input type="text" id="benddate" class="form-control" placeholder=""  name="benddate" value="<?php echo date('d-m-Y', strtotime($_GET['book_enddate']))?>" readonly/></td>
    					  </tr>
                <tr>
    						  <td style="width: 150px"><label for='depart_time' >Depart Time</label></td>
    						  <td style="width: 200px"><input type="text" id="bstarttime" class="form-control" placeholder=""  name="bstarttime" value="<?php echo date('h:i a', strtotime($_GET['book_starttime']))?>" readonly/></td>
    						  <td style="width: 178px"><label for='return_time' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Return Time</label></td>
    						  <td style="width: 200px"><input type="text" id="bendtime" class="form-control" placeholder=""  name="bendtime" value="<?php echo date('h:i a', strtotime($_GET['book_endtime']))?>" readonly/></td>
    					  </tr>
  				  </table>

            <table>
            <div class="form-group">
              <tr>
                <td style="width: 115px"><label for='bdesc' >Description</label></td>
                <td style="width: 520px"><input type="text" id="bookdesc" class="form-control" placeholder=""  name="bookdesc" value="<?php echo $_GET['book_desc']?>" readonly/></td>
              </tr>
            </div>

            <div class="form-group">
                <tr>
                  <td style="width: 115px"><label for='returnby' >Return By</label></td>
                  <td style="width: 520px"><input type="text" id="returnby" class="form-control" placeholder=""  name="returnby" value="<?php echo $_GET['staffid'].' - '.$_GET['staffshortname'].' ('. $_GET['staffemail'].')' ?>" readonly/></td>
                </tr>
              </div>
            </table>

            <!--<div class="form-group">
              <tr>
                <td style="width: 135px"><label for='bdesc' >Return By</label></td>
                <td style="width: 520px"><input type="text" id="returnby" class="form-control" placeholder=""  name="returnby" value="<?php echo $_GET['staffid'].' - '.$_GET['staffshortname'].' ('. $_GET['staffemail'].')'?>" readonly/></td>
              </tr>
            </div>-->




            <div class="form-group">
                <input type="hidden" id="idd" class="form-control" placeholder="idd" name="idd" value="<?php echo $myusername ?>" readonly/>
                <input type="hidden" id="sid" class="form-control" placeholder="ID" name="sid" value="<?php echo $myusername ?>" readonly/>
                <input type="hidden" id="sname" class="form-control" placeholder="sname" name="sname" value="<?php echo $mystaffname ?>" readonly/>
            </div>


            <?php
                mysqli_close($db);  // close connection
            ?>

            <table>
              <div class="form-group">
                <br>
                <label for='pls_keyin'><b>PLEASE KEY IN : </b></label><br>
                <td style="width: 130px"><label for='bdesc'><b>Odometer Start</b></label></td>
                <td style="width: 170px"><input type="text" id="odo_start" class="form-control" placeholder=""  name="odostart" value="- start milleage -" required/>
                <td style="width: 160px"><label for='book_carno' ><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Odometer End&nbsp;&nbsp;&nbsp;</b></label></td>
                <td style="width: 170px"><input type="text" id="odo_end" class="form-control" placeholder="" name="odoend" value="- end milleage -" required/>
              </div>
            </table>
            <br>
            <div class="form-group">
                <input type="submit" class="btn btn-primary w-100" name="save" value="Submit"  onclick = "Warn();" >
            </div>

            <div class="form-group">
                <center><a href="carservicebutton.php" class="btn btn-danger">Back</a></center>
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

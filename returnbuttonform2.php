<?php
session_start();
include "connect.php";

//passing parameter from sessions
$myusername = $_SESSION['sid'];
$mystaffname = $_SESSION['sname'];
$mystaffemail = $_SESSION['semail'];

$bookid = $_SESSION['bookid'];
$bookcarno = $_SESSION['bookcarno'];
$bookstartdate = $_SESSION['bstartdate'];
$bookenddate = $_SESSION['benddate'];
$bookstarttime = $_SESSION['bstarttime'];
$bookendtime = $_SESSION['bendtime'];
$bookdesc = $_SESSION['bdesc'];
$carodoend = $_SESSION['carodoend'];
//$cartoservice = $_SESSION['cartoservice'];

$date_nextservice = $_SESSION['new_nextdateservice'];
$mileage_nextservice = $_SESSION['new_nextmilservice'];

$staffid = $_SESSION['staffid'];
$staffname = $_SESSION['staffname'];
$staffemail = $_SESSION['staffemail'];

//$_SESSION['bookcarno'] = $bookcarno;
//echo $myusername;;
//echo $mystaffname;
//echo $mystaffemail;
//echo $_GET['book_id'];
//echo $myusername;
//echo $row['book_id'];

$qcar = "SELECT *
				 		FROM car_master
						WHERE car_no = '$bookcarno'
						AND car_status = '1'";
$qresultcar = mysqli_query($db, $qcar);
$qcardet = mysqli_fetch_assoc($qresultcar);

$qbook = "SELECT * FROM booking_master WHERE book_id = '$bookid';";
$resultbook = mysqli_query($db, $qbook);
$rowbook = mysqli_fetch_array($resultbook);


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
    $('#date_nextservice').attr('min', maxDate);
});

</script>

</head>
  <body>
    <div class="container-fluid">
      <div class="row justify-content-center h-100">
        <div class="card w-50 my-auto shadow">
          <div class="card-header text-center bg-primary text-white">
            <form action ="returnbuttonProcess2.php" method="post" enctype="multipart/form-data">
              <h2>Return Key Process </h2>
          </div>
          <div class="card-body">
            <table>
                <tr>
                  <td style="width: 1400px"><label for='booking_id' >Booking ID</label>
                  <td style="width: 3300px"><input type="text" id="book_id" class="form-control" placeholder=""  name="bid" value="<?php echo $bookid ?>" readonly/>
                  <td style="width: 1200px"><label for='book_carno' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Car</label></td>
                  <td style="width: 3200px"><input type="text" id="bcarnoname" class="form-control" placeholder="" name="bcarnoname" value="<?php echo $bookcarno." - ". $qcardet['car_name']?>" readonly/>
                  <td style="width: 200px"><input type="hidden" id="bcarno" class="form-control" placeholder="" name="bcarno" value="<?php echo $bookcarno ?>" readonly/>
                </tr>
                <tr>
    						  <td style="width: 150px"><label for='depart_date' >Depart Date</label></td>
    						  <td style="width: 200px"><input type="text" id="bstartdate" class="form-control" placeholder=""  name="bstartdate" value="<?php echo date('d-m-Y', strtotime($bookstartdate))?>" readonly/></td>
    						  <td style="width: 50px"><label for='return_date' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Return Date</label></td>
    						  <td style="width: 200px"><input type="text" id="benddate" class="form-control" placeholder=""  name="benddate" value="<?php echo date('d-m-Y', strtotime($bookenddate))?>" readonly/></td>
    					  </tr>
                <tr>
    						  <td style="width: 150px"><label for='depart_time' >Depart Time</label></td>
    						  <td style="width: 200px"><input type="text" id="bstarttime" class="form-control" placeholder=""  name="bstarttime" value="<?php echo date('h:i a', strtotime($bookstarttime))?>" readonly/></td>
    						  <td style="width: 178px"><label for='return_time' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Return Time</label></td>
    						  <td style="width: 200px"><input type="text" id="bendtime" class="form-control" placeholder=""  name="bendtime" value="<?php echo date('h:i a', strtotime($bookendtime))?>" readonly/></td>
    					  </tr>
  				  </table>

            <table>
            <div class="form-group">
              <tr>
                <td style="width: 135px"><label for='bdesc' >Description</label></td>
                <td style="width: 510px"><input type="text" id="book_desc" class="form-control" placeholder=""  name="bdesc" value="<?php echo $bookdesc ?>" readonly/></td>
              </tr>
            </div>

            <div class="form-group">
                <tr>
                  <td style="width: 130px"><label for='returnby' >Return By</label></td>
                  <td style="width: 570px"><input type="text" id="returnby" class="form-control" placeholder=""  name="returnby" value="<?php echo $staffid.' - '.$staffname.' ('. $staffemail.')' ?>" readonly/></td>
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
                <input type="hidden" id="sid" class="form-control" placeholder="idd" name="sid" value="<?php echo $myusername ?>" readonly/>
								<input type="hidden" id="sname" class="form-control" placeholder="sname" name="sname" value="<?php echo $mystaffname ?>" readonly/>
                <input type="hidden" id="emailid" class="form-control" placeholder="ID" name="emailid" value="<?php echo $emailid ?>" readonly/>
								<input type="hidden" id="staffid" class="form-control" placeholder=""  name="staffid" value="<?php echo $staffid ?>" readonly/>
								<input type="hidden" id="staffname" class="form-control" placeholder=""  name="staffname" value="<?php echo $staffname ?>" readonly/>
								<input type="hidden" id="staffemail" class="form-control" placeholder=""  name="staffemail" value="<?php echo $staffemail ?>" readonly/>
            </div>

            <?php
                mysqli_close($db);  // close connection
            ?>

						<table>
							<tr>
								<td style="width: 145px"><p for='bdesc'><b>Total Mileage</b></p></td>
								<td style="width: 200px"><input type="text" style="text-align: center; font-weight: bold;" id="totmileage" class="form-control" placeholder="" name="totmil" value="<?php echo $qcardet['car_total_mileage'] ?>" readonly/></td>
								<td style="width: 80px"></td>
								<td style="border: 0px; width: 120px"><b>Car To Service?</b></td>
										<td style="width: 10px">
										<input type="radio" id="yes" name="cartoservice" value="0" disabled="disabled"
											<?php
											if ($rowbook['car_to_service'] == '1')
											{
												echo "checked";
											}
											?>/>&nbsp;<b>Yes</b> &nbsp;&nbsp;&nbsp;
											<input type="radio" id="no" name="cartoservice" value="1" disabled="disabled"
											<?php
											if ($rowbook['car_to_service'] == '0')
											{
												echo "checked";
											}
											?>/>&nbsp;<b>No</b>
										</td>
								</td>
							</tr>

							<tr>
								<td style="width: 0px"><p for='book_carno'><b>Odometer Start</b></p></td>
								<td style="width: 0px"><input type="text" style="text-align: center; font-weight: bold;" id="odo_start" class="form-control" placeholder=""  name="odostart" value="<?php echo $qcardet['car_total_mileage']?>" required maxlength="6"/></td>
								<td style="width: 0px"></td>
								<td style="width: 0px"><p for='date_nextservice'><b>Next Service</b></p></td>
								<td style="width: 0px">
									<input type="date" style="text-align: center; font-weight: bold;" id="date_nextservice" class="form-control" placeholder="" name="date_nextservice" value="<?php echo $qcardet['car_next_date_service']?>"
										<?php
											if ($rowbook['car_to_service'] == '1')
											{
												echo "required";
											}
											elseif ($rowbook['car_to_service'] == '0')
											{
												echo "readonly";
											}
										?>/>
								</td>
							</tr>
							<tr>
								<td style="width: 0px"><p for='book_carno'><b>Odometer End</b></p></td>
								<!--<td style="width: 150px"><p for='book_carno' style="text-align: center;"><b>Odometer End</b></p></td>-->
								<td style="width: 0px"><input type="text" style="text-align: center; font-weight: bold;" id="odo_end" class="form-control" placeholder="" name="odoend" maxlength="6" value="- end mileage -" required /></td>
								<td style="width: 0px"></td>
								<td style="width: 0px"><p for='mileage_nextservice'><b>Next Mileage</b></p></td>
								<td style="width: 0px"><input type="text" style="text-align: center; font-weight: bold;" id="mileage_nextservice" class="form-control" placeholder=""  name="mileage_nextservice" required maxlength="6" value="<?php echo $qcardet['car_next_mileage_service']?>"
									<?php
										if ($rowbook['car_to_service'] == '1')
										{
											echo "required";
										}
										elseif ($rowbook['car_to_service'] == '0')
										{
											echo "readonly";
										}
									?>/>
								</td>
							</tr>
						</table>
						<!--<label for='pls_keyin'><b>PLEASE UPDATE: <br> </b></label><br>-->
						<p><strong>*Fill Up Odometer Start & Odometer End</strong></p>

            <div class="form-group">
                <input type="submit" class="btn btn-primary w-100" name="save" value="Submit"  onclick = "Warn();" >
            </div>

            <div class="form-group">
                <center><a href="returnbutton.php" class="btn btn-danger">Back</a></center>
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

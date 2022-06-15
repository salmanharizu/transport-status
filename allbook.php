<?php
include_once "connect.php";
session_start();

//echo $_SERVER['REQUEST_URI'];
//echo $_SERVER['PHP_SELF'];
//echo __FILE__;
//echo basename($_SERVER['PHP_SELF']);

$myusername = $_SESSION['sid'];
$mystaffname = $_SESSION['sname'];
$mystaffemail = $_SESSION['semail'];

$bookid = $_POST['book_id'];
$bookstaffid = $_POST['staff_id'];
$bookcarno = $_POST['bcarno'];
$bookstartdate = $_POST['bstartdate'];

/*if ($bookstartdate == "")
{
  $bookstartdate = "xde apa2";
}*/

//echo "BOOKID $bookid STAFF $bookstaffid CAR $bookcarno DATE $bookstartdate ";
//echo $bookid;
if ($bookid != "")
{
  // "if keyin bookid";

  $q1 = "SELECT count(*) as total
          FROM booking_master
          WHERE book_id = '$bookid'";
  $result1 = mysqli_query($db, $q1);
  $row1 = mysqli_fetch_assoc($result1);

  if ($row1['total'] != '0')
  {
    $sql = "SELECT a.*, b.ref_desc
              FROM booking_master a
              JOIN reference_master b
              ON a.book_status = b.ref_code
              WHERE ref_type = 'BOOKING STATUS'
              AND book_id = $bookid
              order by book_start_date desc;";
    $result = mysqli_query($db,$sql) or die("Fail to connect to database".mysql_error());
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);

    $result1=mysqli_query($db,"SELECT a.*, b.ref_desc
                              FROM audit_trail a
                              JOIN reference_master b
                              ON a.at_code = b.ref_code
                              WHERE book_id='$bookid'
                              ORDER BY at_time asc");

  } else {
    header("location: error_norecord_search.php");
  }
}

//if select all without conditions
elseif (($bookstaffid == "-- Select All --") and ($bookcarno == "-- Select All --") and ($bookstartdate == ""))
{
  //echo "if1";

  $q1 = "SELECT count(*) as total
          FROM booking_master";
  $result1 = mysqli_query($db, $q1);
  $row1 = mysqli_fetch_assoc($result1);

  if ($row1['total'] != '0')
  {
    $result = mysqli_query($db,"SELECT a.*, b.ref_desc
                                FROM booking_master a
                                JOIN reference_master b
                                ON a.book_status = b.ref_code
                                WHERE ref_type = 'BOOKING STATUS'
                                order by book_start_date desc");
  } else {
    // "error if1";
    header("location: error_norecord_search.php");
  }
}
//if select by staffid only
elseif (($bookstaffid != "-- Select All --") and (($bookcarno == "-- Select All --") and ($bookstartdate == "")))
  {
    //echo "if2";

    $q1 = "SELECT count(*) as total
            FROM booking_master
            WHERE staff_id = '$bookstaffid'";
  	$result1 = mysqli_query($db, $q1);
  	$row1 = mysqli_fetch_assoc($result1);

	  if ($row1['total'] != '0')
    {
      $result = mysqli_query($db,"SELECT a.*, b.ref_desc
                                FROM booking_master a
                                JOIN reference_master b
                                ON a.book_status = b.ref_code
                                WHERE a.staff_id = '$bookstaffid'
                                AND ref_type = 'BOOKING STATUS'
                                order by book_start_date desc");
     } else {
      //echo "error if2";
       header("location: error_norecord_search.php");
     }
  }
//if select staffid and car only. Date all
elseif ((($bookstaffid != "-- Select All --") and ($bookcarno != "-- Select All --")) and ($bookstartdate == ""))
{
  //echo "if3";

  $q1 = "SELECT count(*) as total
          FROM booking_master
          WHERE staff_id = '$bookstaffid' and book_carno = '$bookcarno'";
  $result1 = mysqli_query($db, $q1);
  $row1 = mysqli_fetch_assoc($result1);

  if ($row1['total'] != '0')
  {
    $result = mysqli_query($db,"SELECT a.*, b.ref_desc
                              FROM booking_master a
                              JOIN reference_master b
                              ON a.book_status = b.ref_code
                              WHERE a.staff_id = '$bookstaffid' and book_carno = '$bookcarno'
                              AND ref_type = 'BOOKING STATUS' order by book_start_date desc");
   } else {
     //echo "error if3";
     header("location: error_norecord_search.php");
   }
}
//if select staffid and date only. Car all
elseif ((($bookstaffid != "-- Select All --") and ($bookstartdate != "")) and ($bookcarno == "-- Select All --"))
{
  //echo "if4";

  $q1 = "SELECT count(*) as total
          FROM booking_master
          WHERE staff_id = '$bookstaffid'
          AND DATE_FORMAT(book_start_date,'%d-%m-%Y') = DATE_FORMAT('$bookstartdate','%d-%m-%Y')";
  $result1 = mysqli_query($db, $q1);
  $row1 = mysqli_fetch_assoc($result1);

  if ($row1['total'] != '0')
  {
    $result = mysqli_query($db,"SELECT a.*, b.ref_desc
                              FROM booking_master a
                              JOIN reference_master b
                              ON a.book_status = b.ref_code
                              WHERE a.staff_id = '$bookstaffid'
                              AND DATE_FORMAT(book_start_date,'%d-%m-%Y') = DATE_FORMAT('$bookstartdate','%d-%m-%Y')
                              AND ref_type = 'BOOKING STATUS' order by book_start_date desc");

   } else {
     //echo "error if4";
     header("location: error_norecord_search.php");
   }
}
//if select car and date only. Staff all
elseif ((($bookcarno != "-- Select All --") and ($bookstartdate != "")) and ($bookstaffid == "-- Select All --"))
{
  //echo "if5";

  $q1 = "SELECT count(*) as total
          FROM booking_master
          WHERE book_carno = '$bookcarno'
          and DATE_FORMAT(book_start_date,'%d-%m-%Y') = DATE_FORMAT('$bookstartdate','%d-%m-%Y')";
  $result1 = mysqli_query($db, $q1);
  $row1 = mysqli_fetch_assoc($result1);

  if ($row1['total'] != '0')
  {
    $result = mysqli_query($db,"SELECT a.*, b.ref_desc
                              FROM booking_master a
                              JOIN reference_master b
                              ON a.book_status = b.ref_code
                              WHERE a.book_carno = '$bookcarno'
                              AND DATE_FORMAT(book_start_date,'%d-%m-%Y') = DATE_FORMAT('$bookstartdate','%d-%m-%Y')
                              AND ref_type = 'BOOKING STATUS' order by book_start_date desc");
   } else {
     //echo "error if5";
     header("location: error_norecord_search.php");
   }
}

//if select by car only
elseif (($bookcarno != "-- Select All --") and (($bookstaffid == "-- Select All --") and ($bookstartdate == "")))
{
  //echo "if6";

  $q1 = "SELECT count(*) as total
          FROM booking_master
          WHERE book_carno = '$bookcarno'";
  $result1 = mysqli_query($db, $q1);
  $row1 = mysqli_fetch_assoc($result1);

  if ($row1['total'] != '0')
  {
    $result = mysqli_query($db,"SELECT a.*, b.ref_desc
                              FROM booking_master a
                              JOIN reference_master b
                              ON a.book_status = b.ref_code
                              WHERE book_carno = '$bookcarno'
                              AND ref_type = 'BOOKING STATUS' order by book_start_date desc");
   } else {
     //echo "error if6";
     header("location: error_norecord_search.php");
   }
}
//if select by departure date only
elseif (($bookstartdate != "") and (($bookstaffid == "-- Select All --") and ($bookcarno == "-- Select All --")))
{
  //echo "if7";

  $q1 = "SELECT count(*) as total
          FROM booking_master
          WHERE DATE_FORMAT(book_start_date,'%d-%m-%Y') = DATE_FORMAT('$bookstartdate','%d-%m-%Y')";
  $result1 = mysqli_query($db, $q1);
  $row1 = mysqli_fetch_assoc($result1);

  if ($row1['total'] != '0')
  {
    $result = mysqli_query($db,"SELECT a.*, b.ref_desc
                              FROM booking_master a
                              JOIN reference_master b
                              ON a.book_status = b.ref_code
                              WHERE DATE_FORMAT(book_start_date,'%d-%m-%Y') = DATE_FORMAT('$bookstartdate','%d-%m-%Y')
                              AND ref_type = 'BOOKING STATUS' order by book_start_date desc");
   } else {
     //echo "error if7";
     header("location: error_norecord_search.php");
   }
}
else
{
  //echo "endiflast";
  header("location: error_norecord_search.php");
}

//search by bookid only
if ($bookid != "")
{
?>
  <!DOCTYPE html>
  <html lang="en" dir="ltr">
    <head>
      <meta charset="utf-8">
      <title>IP Fokus</title>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	  <link rel="stylesheet" type="text/css" href="print.css" media="print">
    </head>

    <body>
      <div class="container-fluid">
        <div class="row justify-content-center h-100">
          <div class="card w-300 shadow">
            <div class="card-header text-center bg-primary text-white">
              <form>
                <h2> Booking Details </h2>
              </form>
            </div>
            <div class="card-body">
              <!--<div style="height:100%;width:100%;border:1px solid #ccc;font:16px/26px Georgia, Garamond, Serif;overflow:auto;">
                <div style="height:100%;border:1px solid #ccc;font:16px/26px Georgia, Garamond, Serif;overflow:auto;">-->
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
                <br>
                <?php $qselect = "SELECT staff_id, staff_name, staff_shortname, staff_email FROM staff WHERE staff_id = '$row[staff_id]';";
                $qresult = mysqli_query($db, $qselect);
                $qrow = mysqli_fetch_array($qresult);
                ?>
                <table align=center>
                  <tr>
         						<th style="width: 300px">Book ID &nbsp;: &nbsp;&nbsp;<?php echo $row["book_id"]?></th>
         						<!--<th style="width: 250px"><?php echo $_GET['book_id']?></th>
         						<th style="width: 275px">Departure : </th>-->
         						<th style="width: 630px">Booking By &nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row["staff_id"] .' - '. $qrow["staff_name"]?></th>

         					</tr>
         					<tr>
         						<th>Car No &nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;<?php echo $row["book_carno"]?></th>
         						<!--<th style="width: 230px; height: 28px;"><?php echo $_GET['book_carno']?></th>
         						<th style="width: 275px; height: 28px;">Return : </th>-->
         						<th>Departure &nbsp&nbsp&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp&nbsp<?php echo date('d-m-Y h:i a', strtotime($row["book_start_date"]))?> / Return :&nbsp;&nbsp;&nbsp;<?php echo date('d-m-Y h:i a', strtotime($row["book_end_date"]))?></th>
         					</tr>
         					<tr>
         						<th>Status &nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;<?php echo $row["ref_desc"]?></th>
                    <th>Details &nbsp&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp&nbsp<?php echo $row["book_desc"]?></th>
           					</tr>
       				  </table>
                <!--<table align=center>
                  <tr>
                    <th style="width: 150px; height: 27px; border-right: 0px solid">Book ID &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </th>
                    <th style="width: 200px; height: 27px; border-left: 0px solid"><?php echo $row["book_id"] ?></th>
                    <th style="width: 200px; height: 27px; border-right: 0px solid">Departure  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </th>
        						<th style="width: 480px; height: 27px; border-left: 0px solid"><?php echo date('d-m-Y', strtotime($row["book_start_date"]))?>&nbsp;:&nbsp;<?php echo date('h:i a', strtotime($row["book_start_time"]))?></th>
                    <th style="width: 10px; height: 27px; border-right: 0px solid">Book ID &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </th>
         					</tr>
         					<tr>
         						<th style="border-right: 0px solid">Car No &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </th>
         						<th style="border-left: 0px solid"><?php echo $row["book_carno"]?></th>
         						<th style="border-right: 0px solid">Return &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </th>
         						<th style="border-left: 0px solid"><?php echo date('d-m-Y', strtotime($row["book_end_date"]))?>&nbsp;:&nbsp;<?php echo date('h:i a', strtotime($row["book_end_time"]))?></th>
         					</tr>
         					<tr>
         						<th style="border-right: 0px solid">Status &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </th>
         						<td colspan="3" style="border-left: 0px solid"><?php echo $row["ref_desc"]?></td>
         					</tr>
                  <tr>
         						<th style="border-right: 0px solid">Details &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </th>
         						<th colspan="3" style="border-left: 0px solid"><?php echo $row["book_desc"]?></th>
         					</tr>
       				  </table>-->
       				  <br>
       				  <br>
                <table>
                  <tr>
                    <th style="width: 50px">No.</th>
                    <th style="width: 140px">Process</th>
                    <!--<th style="width: 120px">Process ID</th>-->
                    <th style="width: 120px">Process By</th>
                    <th style="width: 130px">Trans Time</th>
                    <th style="width: 400px">Description</th>
                    <th style="width: 400px">Details</th>
                  </tr>
                  <?php
                  $i=1;
                  while($row = mysqli_fetch_array($result1))
                  {
                      $qselect1 = "SELECT staff_id, staff_name, staff_shortname, staff_email FROM staff WHERE staff_id = '$row[staff_id]';";
                      $qresult1 = mysqli_query($db, $qselect1);
                      $qrow1 = mysqli_fetch_array($qresult1);
                    ?>
                    <tr class="<?php if(isset($classname)) echo $classname;?>">
                      <td><?php echo $i."."; ?></td>
                      <td><?php echo $row["ref_desc"]; ?></td>
                      <!--<td><?php echo $row["at_id"]; ?></td>-->
                      <td><?php echo $qrow1["staff_id"] .' - '. $qrow1["staff_shortname"]; ?></td>
                      <td><?php
                        echo date('d-m-Y', strtotime($row["at_date"])) ." ". date('h:i a', strtotime($row["at_time"]));?>
                      </td>
                      <td><?php echo $row["at_desc_old"]; ?></td>
                      <td><?php echo $row["at_desc_new"]; ?></td>
                    </tr>
                    <?php
                    $i++;
                  }
                    ?>
                </table>
					<br>
					<center><button onClick="window.print();" class="btn btn-danger" id="print-btn">Print</button></center>
					<br>
					<center><a href="sorting.php" class="btn btn-danger" id="back-btn">Back</a></center>
					<br>
            </div>
            <br>
            <!--</form>-->
                <!--<div class="form-group">
                  <center><a href="choicebutton.php" class="btn btn-danger">Back</a></center>
                </div>-->
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
<?php
}
else //search all
{
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>IP Fokus</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="print.css" media="print">
  </head>

  <body>
    <div class="container-fluid">
      <div class="row justify-content-center h-100">
        <div class="card w-300 shadow">
          <div class="card-header text-center bg-primary text-white">
            <form>
              <h2>All Booking</h2>
            </form>
          </div>
          <div class="card-body">
            <!--<div style="height:100%;width:100%;border:1px solid #ccc;font:16px/26px Georgia, Garamond, Serif;overflow:auto;">-->
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
                  <th style="width: 50px">No.</th>
                  <th style="width: 100px">BookID</th>
                  <th style="width: 140px">Book By</th>
                  <th style="width: 140px">Car No</th>
                  <th style="width: 140px">Departure</th>
                  <th style="width: 150px">Return</th>
                  <th style="width: 130px">Status</th>
                  <th style="width: 350px">Description</th>
                  <th style="width: 100px"></th>
                </tr>

                <?php
                $i=1;
                while($row = mysqli_fetch_array($result))
                {
                  $qselect = "SELECT staff_shortname, staff_email FROM staff WHERE staff_id = '$row[staff_id]';";
                  $qresult = mysqli_query($db, $qselect);
                  $qrow = mysqli_fetch_array($qresult);
                  ?>
                  <tr class="<?php if(isset($classname)) echo $classname;?>">
                    <td><?php echo $i."."; ?></td>
                    <td><?php echo $row["book_id"]; ?></td>
                    <td><?php echo $qrow["staff_shortname"]; ?></td>
                    <td><?php echo $row["book_carno"]; ?></td>
                    <td><?php
                      echo date('d-m-Y', strtotime($row["book_start_date"])) ." ". date('h:i a', strtotime($row["book_start_time"]));?>
                    </td>
                    <td><?php
                      echo date('d-m-Y', strtotime($row["book_end_date"])) ." ". date('h:i a', strtotime($row["book_end_time"]));?>
                    </td>
                    <td><?php echo $row["ref_desc"]; ?></td>
                    <td><?php echo $row["book_desc"]; ?></td>
                    <td><a id="hide_details" href="allbook_details.php?book_id=<?php echo $row["book_id"];?>&amp;
                      book_startdate=<?php echo date('d-m-Y', strtotime($row["book_start_date"]));?>&amp;
                      book_starttime=<?php echo date('h:i a', strtotime($row["book_start_time"]))?>&amp;
                      book_enddate=<?php echo date('d-m-Y', strtotime($row["book_end_date"]));?>&amp;
                      book_endtime=<?php echo date('h:i a', strtotime($row["book_end_time"]))?>&amp;
                      book_carno=<?php echo $row["book_carno"];?>&amp;
                      ref_desc=<?php echo $row["ref_desc"];?>&amp;
                      staff_id=<?php echo $row["staff_id"];?>&amp;
                      bookby=<?php echo $qrow["staff_shortname"];?>&amp;
                      book_desc=<?php echo $row["book_desc"];?>">Details</a></td>
                  </tr>
                  <?php
                  $i++;
                }
                  ?>
              </table>
				<br>
				<center><button onClick="window.print();" class="btn btn-danger" id="print-btn">Print</button></center>
				<br>
				<center><a href="sorting.php" class="btn btn-danger" id="back-btn">Back</a></center>
				<br>
          </div>
          <br>
          <!--</form>
              <div class="form-group">
                <center><a href="choicebutton.php" class="btn btn-danger">Back</a></center>
              </div>
              </div>-->
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
<?php
}
?>

<!-- javascript for disable back button -->
<script type = "text/javascript" >
    function preventBack() { window.history.forward(); }
    setTimeout("preventBack()", 0);
    window.onunload = function () { null };
</script>

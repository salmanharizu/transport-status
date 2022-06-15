<?php
include_once "connect.php";
session_start();

$myusername = $_SESSION['sid'];
$mystaffname = $_SESSION['sname'];
$mystaffemail = $_SESSION['semail'];

$result=mysqli_query($db,"SELECT a.*, b.ref_desc
                          FROM audit_trail a
                          JOIN reference_master b
                          ON a.at_code = b.ref_code
                          WHERE book_id='".$_GET['book_id']."'
                          ORDER BY at_time asc");

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
              <br>
              <?php
                $qselect = "SELECT staff_id, staff_name, staff_shortname, staff_email FROM staff WHERE staff_id = '$_GET[staff_id]';";
                $qresult = mysqli_query($db, $qselect);
                $qrow = mysqli_fetch_array($qresult);
              ?>
              <table align=center>
                <tr>
       						<th style="width: 300px">Book ID &nbsp;: &nbsp;&nbsp;<?php echo $_GET['book_id']?></th>
       						<!--<th style="width: 250px"><?php echo $_GET['book_id']?></th>
       						<th style="width: 275px">Departure : </th>-->
       						<th style="width: 630px">Booking By &nbsp;:&nbsp;&nbsp;&nbsp;<?php echo $_GET['staff_id'] .' - '. $qrow["staff_name"]?></th>
       					</tr>
       					<tr>
       						<th>Car No &nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;<?php echo $_GET['book_carno']?></th>
       						<!--<th style="width: 230px; height: 28px;"><?php echo $_GET['book_carno']?></th>
       						<th style="width: 275px; height: 28px;">Return : </th>-->
       						<th>Departure &nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;<?php echo $_GET['book_startdate']?>&nbsp;&nbsp;<?php echo $_GET['book_starttime']?> / Return &nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;<?php echo $_GET['book_enddate']?>&nbsp;&nbsp;<?php echo $_GET['book_endtime']?></th>
       					</tr>
       					<tr>
       						<th>Status &nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;<?php echo $_GET['ref_desc']?></th>
                  <th>Details &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;<?php echo $_GET['book_desc']?></th>
         					</tr>
     				  </table>
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
                while($row = mysqli_fetch_array($result))
                {
                    $qselect1 = "SELECT staff_id, staff_name, staff_shortname, staff_email FROM staff WHERE staff_id = '$row[staff_id]';";
                    $qresult1 = mysqli_query($db, $qselect1);
                    $qrow1 = mysqli_fetch_array($qresult1);
                  ?>
                  <tr class="<?php if(isset($classname)) echo $classname;?>">
                    <td><?php echo $i."."; ?></td>
                    <td><?php echo $row["ref_desc"]; ?></td>
                    <!--<td><?php echo $row["at_id"]; ?></td>-->
                    <td><?php echo $qrow1["staff_id"] .' - '. $qrow1["staff_shortname"]?></td>
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
                <center><a href="allbook2.php" class="btn btn-danger" id="back-btn">Back</a></center>
				<br>
          </div>
          <br>
          <!--</form>
            <div class="form-group">
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
<!-- javascript for disable back button -->
<script type = "text/javascript" >
    function preventBack() { window.history.forward(); }
    setTimeout("preventBack()", 0);
    window.onunload = function () { null };
</script>

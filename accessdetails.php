<?php
include_once "connect.php";
session_start();

$myusername = $_SESSION['sid'];
$mystaffname = $_SESSION['sname'];
$mystaffemail = $_SESSION['semail'];

$q1 = "SELECT count(*) as total
        FROM staff a, audit_trail b
        where a.staff_id = b.book_id
        and at_code in ('NR','CP')
        and b.book_id = '$_GET[staffid]'";
$result1 = mysqli_query($db, $q1);
$row1 = mysqli_fetch_assoc($result1);

if ($row1['total'] != '0')
{
$result = mysqli_query($db,"SELECT a.*, b.*
                              FROM reference_master a, audit_trail b
                              where a.ref_code = b.at_code
                              and at_code in ('NR','CP')
                              and b.book_id = '$_GET[staffid]'
                              order by b.book_id asc");
} else {
  header("location: error_norecord_accessdetails.php");
}


?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>IP Fokus</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  </head>

  <body>
    <div class="container-fluid">
      <div class="row justify-content-center h-100">
        <div class="card w-300 shadow">
          <div class="card-header text-center bg-primary text-white">
            <form>
              <h2> Access Details History </h2>
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
              <table align=center>
                <tr>
       						<th style="width: 400px">Staff ID &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;<?php echo $_GET['staffid']?></th>
       						<th style="width: 500px">Staff Name &nbsp;:&nbsp;&nbsp;&nbsp;<?php echo $_GET["staffname"]?></th>
       					</tr>
       					<tr>
       						<th>Shortname &nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;<?php echo $_GET['staffshortname']?></th>
       						<th>Email  &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;<?php echo $_GET['staffemail']?></th>
       					</tr>
       					<tr>
       						<th>Status &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;<?php echo $_GET['staffcategory']?></th>
                  <th>Category &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;<?php echo $_GET['staffstatus']?></th>
         					</tr>
     				  </table>
     				  <br>
     				  <br>
              <table>
                <tr>
                  <th style="width: 50px">No.</th>
                  <th style="width: 205px">Process</th>
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
                    <td><?php echo $row['staff_id'] .' - '. $qrow1['staff_shortname']?></td>
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
              </table><br>
              <center><a href="access.php" class="btn btn-danger">Back</a></center>
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

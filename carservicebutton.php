<?php
include_once "connect.php";
session_start();
$myusername = $_SESSION['sid'];
$mystaffname = $_SESSION['sname'];
$mystaffemail = $_SESSION['semail'];

$q1 = "SELECT count(*) as total
        FROM car_master
        WHERE car_status != '2'";
$result1 = mysqli_query($db, $q1);
$row1 = mysqli_fetch_assoc($result1);

if ($row1['total'] != '0')
{
  $result = mysqli_query($db,"SELECT *
                              FROM car_master
                              WHERE car_status = '1'");
} else {
header("location: error_norecord.php");
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
              <h2>Service Details</h2>
          </div>
          <div class="card-body">
            <div style="height:100%;border:1px solid #ccc;font:15px/20px Georgia, Garamond, Serif;overflow:auto;">
              <style>
              table, th, td
              {
                border: 1px solid black;
                border-collapse: collapse;
                padding-right: 15px;
                padding-left: 15px;
                table-layout: fixed;
              }
              </style>

              <table>
                <tr>
                  <th style="width: 50px">No.</th>
                  <th style="width: 100px">Car No</th>
                  <th style="width: 140px">Car Name</th>
                  <th style="width: 200px">Total Milleage (km/h)</th>
                  <th style="width: 180px">Next Service Date</th>
                  <th style="width: 300px">Next Service Milleage (km/h)</th>
                  <th style="width: 70px"></th>
                </tr>

                <?php
                $i=1;
                while($row = mysqli_fetch_array($result))
                {
                  $qselect = "SELECT * FROM staff WHERE staff_id = '$myusername';";
                  $qresult = mysqli_query($db, $qselect);
                  $qrow = mysqli_fetch_array($qresult);

                  ?>
                  <tr class="<?php if(isset($classname)) echo $classname;?>">
                    <td><?php echo $i."."; ?></td>
                    <td><?php echo $row["car_no"]; ?></td>
                    <td><?php echo  $row["car_name"]; ?></td>
                    <td style="text-align: center"><?php echo  $row["car_total_mileage"]; ?></td>
                    <td style="text-align: center"><?php echo date('d-m-Y', strtotime($row["car_next_date_service"]));?></td>
                    <td style="text-align: center"><?php echo $row["car_next_mileage_service"]; ?></td>
                    <td><a href="carservicedetails.php?car_no=<?php echo $row["car_no"];?>&amp;
                          car_name=<?php echo $row["car_name"];?>&amp;
                          car_total_mileage=<?php echo $row["car_total_mileage"];?>&amp;
                          car_next_date_service=<?php echo date('d-m-Y', strtotime($row["car_next_date_service"]));?>&amp;
                          car_next_mileage_service=<?php echo $row["car_next_mileage_service"];?>&amp;
                          staffid=<?php echo $qrow["staff_id"];?>&amp;
                          staffname=<?php echo $qrow["staff_name"];?>&amp;
                          staffshortname=<?php echo $qrow["staff_shortname"];?>&amp;
                          staffemail=<?php echo $qrow["staff_email"];?>">Details</a></td>
                  </tr>
                  <?php
                  $i++;
                }
                  ?>
              </table>
              <br>
              <div class="form-group">
                <center><a href="choicebutton.php" class="btn btn-danger">Back</a></center>
              </div>
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

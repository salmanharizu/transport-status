<?php
include_once "connect.php";
session_start();
$myusername = $_SESSION['sid'];
$mystaffname = $_SESSION['sname'];
$mystaffemail = $_SESSION['semail'];

$q1 = "SELECT count(*) as total
        FROM staff
        WHERE staff_status != '5'";
$result1 = mysqli_query($db, $q1);
$row1 = mysqli_fetch_assoc($result1);

if ($row1['total'] != '0')
{
  $result = mysqli_query($db,"SELECT *
                              FROM staff
                              WHERE staff_status != '5'");
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
              <h2>Staff Access Details</h2>
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
                  <th style="width: 100px">Staff ID</th>
                  <th style="width: 140px">Staff Name</th>
                  <th style="width: 200px">Staff Short Name</th>
                  <th style="width: 180px">Staff Email</th>
                  <th style="width: 250px">Staff Category</th>
                  <th style="width: 170px">Staff Status</th>
                  <th style="width: 100px"></th>
                </tr>

                <?php
                $i=1;
                while($row = mysqli_fetch_array($result))
                {
                  $qselstatus = "SELECT * FROM reference_master
                                  WHERE ref_type = 'STAFF STATUS'
                                  AND ref_code = $row[staff_status];";
                  $qresstatus = mysqli_query($db, $qselstatus);
                  $qrowstatus = mysqli_fetch_array($qresstatus);

                  $qselcategory = "SELECT * FROM reference_master
                                  WHERE ref_type = 'STAFF CATEGORY'
                                  AND ref_code = $row[staff_category];";
                  $qrescategory = mysqli_query($db, $qselcategory);
                  $qrowcategory = mysqli_fetch_array($qrescategory);

                  ?>
                  <tr class="<?php if(isset($classname)) echo $classname;?>">
                    <td><?php echo $i."."; ?></td>
                    <td><?php echo $row["staff_id"]; ?></td>
                    <td><?php echo  $row["staff_name"]; ?></td>
                    <td><?php echo  $row["staff_shortname"]; ?></td>
                    <td><?php echo $row["staff_email"]; ?></td>
                    <td><?php echo $qrowcategory["ref_desc"]; ?></td>
                    <td><?php echo $qrowstatus["ref_desc"]; ?></td>
                    <td><a href="accessdetails.php?
                          staffid=<?php echo $row["staff_id"];?>&amp;
                          staffname=<?php echo $row["staff_name"];?>&amp;
                          staffshortname=<?php echo $row["staff_shortname"];?>&amp;
                          staffemail=<?php echo $row["staff_email"];?>&amp;
                          staffcategory=<?php echo $qrowcategory["ref_desc"];?>&amp;
                          staffstatus=<?php echo $qrowstatus["ref_desc"];?>">Details</a></td>                              
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

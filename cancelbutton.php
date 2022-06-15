<?php
include_once "connect.php";
session_start();
$myusername = $_SESSION['sid'];
$mystaffname = $_SESSION['sname'];
$mystaffemail = $_SESSION['semail'];


$q1 = "SELECT count(*) as total
        FROM booking_master
        WHERE staff_id = '$myusername' and book_status in ('0','1')";
$result1 = mysqli_query($db, $q1);
$row1 = mysqli_fetch_assoc($result1);

if ($row1['total'] != '0')
{
  $result = mysqli_query($db,"SELECT a.*, b.ref_desc
                              FROM booking_master a
                              JOIN reference_master b
                              ON a.book_status = b.ref_code
                              WHERE a.staff_id = '$myusername'
                              AND a.book_status in ('0','1')
                              AND book_start_date >= current_date
                              AND ref_type = 'BOOKING STATUS'");
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
              <h2>Cancel Booking</h2>
          </div>
          <div class="card-body">
            <div style="height:100%;border:1px solid #ccc;font:15px/20px Georgia, Garamond, Serif;overflow:auto;">
              <style>
              table, th, td
              {
                border: 1px solid black;
                border-collapse: collapse;
                padding-right: 15px;
                padding-left: 15px;;
                table-layout: fixed;
              }
              </style>

              <table>
                <tr>
                  <th style="width: 50px">No.</th>
                  <th style="width: 100px">Book ID</th>
                  <th style="width: 140px">Applied By</th>
                  <th style="width: 140px">Departure</th>
                  <th style="width: 140px">Return</th>
                  <th style="width: 140px">Car No</th>
                  <th style="width: 400px">Description</th>
                  <th style="width: 130px">Status</th>
                  <th style="width: 70px"></th>
                </tr>

                <?php
                $i=1;
                while($row = mysqli_fetch_array($result))
                {
                  $qselect = "SELECT staff_name, staff_shortname, staff_email FROM staff WHERE staff_id = '$row[staff_id]';";
                  $qresult = mysqli_query($db, $qselect);
                  $qrow = mysqli_fetch_array($qresult);

                  ?>
                  <tr class="<?php if(isset($classname)) echo $classname;?>">
                    <td><?php echo $i."."; ?></td>
                    <td><?php echo $row["book_id"]; ?></td>
                    <td><?php echo  $qrow["staff_shortname"]; ?></td>
                    <td><?php
                      echo date('d-m-Y', strtotime($row["book_start_date"])) ." ". date('h:i a', strtotime($row["book_start_time"]));?>
                    </td>
                    <td><?php
                      echo date('d-m-Y', strtotime($row["book_end_date"])) ." ". date('h:i a', strtotime($row["book_end_time"]));?>
                    </td>
                    <td><?php echo $row["book_carno"]; ?></td>
                    <td><?php echo $row["book_desc"]; ?></td>
                    <td><?php echo $row["ref_desc"]; ?></td>
                    <td><a href="cancelbuttonform.php?book_id=<?php echo $row["book_id"];?>&amp;
                          book_carno=<?php echo $row["book_carno"];?>&amp;
                          book_desc=<?php echo $row["book_desc"];?>&amp;
                          book_startdate=<?php echo date('d-m-Y', strtotime($row["book_start_date"]));?>&amp;
                          book_starttime=<?php echo date('h:i a', strtotime($row["book_start_time"]))?>&amp;
                          book_enddate=<?php echo date('d-m-Y', strtotime($row["book_end_date"]));?>&amp;
                          book_endtime=<?php echo date('h:i a', strtotime($row["book_end_time"]))?>&amp;
                          staffid=<?php echo $row["staff_id"];?>&amp;
                          staffname=<?php echo $qrow["staff_name"];?>&amp;
                          staffshortname=<?php echo $qrow["staff_shortname"];?>&amp;
                          staffemail=<?php echo $qrow["staff_email"];?>">Cancel</a></td>

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

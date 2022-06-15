<?php
session_start();
include "connect.php";
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

  <?php
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

    //$carodostart = $_SESSION['carodostart'];
    $carodoend = $_SESSION['carodoend'];
    $date_nextservice = $_SESSION['new_nextdateservice'];
    $mileage_nextservice = $_SESSION['new_nextmilservice'];

    $staffid = $_SESSION['staffid'];
    $staffname = $_SESSION['staffname'];
    $staffemail = $_SESSION['staffemail'];

  ?>

  <body>
    <div class="container vh-100">
      <div class="row justify-content-center h-100">
        <div class="card w-50 my-auto shadow">
          <div class="card-header text-center bg-primary text-white">
            <form action ="returnbutton.php">
              <h2></h2>
          </div>
          <div class="card-body">
            <form>
              <br>
              <center><h4>Odometer Start Cannot Less And Equal Than Current Total Mileage</h4></center>
              <br>
              <center><a href="returnbuttonform2.php" class="btn btn-danger" value="1">Back</a></center>
            </form>
          </div>

          <div class="card-footer text-right">
            <small>&copy; IP Fokus</small>
          </div>
        </div>

      </div>

    </div>
  </body>

  <?php
    $_SESSION['sid'] = $myusername;
    $_SESSION['sname'] = $mystaffname;
    $_SESSION['semail'] = $mystaffemail;

    $_SESSION['bookid'] = $bookid;
    $_SESSION['bookcarno'] = $bookcarno;
    $_SESSION['bstartdate'] = $bookstartdate;
    $_SESSION['benddate'] = $bookenddate;
    $_SESSION['bstarttime'] = $bookstarttime;
    $_SESSION['bendtime'] = $bookendtime;
    $_SESSION['bdesc'] = $bookdesc;

    $_SESSION['carodostart'] = $carodostart;
    $_SESSION['carodoend'] = $carodoend;
    $_SESSION['new_nextdateservice'] = $date_nextservice;
    $_SESSION['new_nextmilservice'] = $mileage_nextservice;

    $_SESSION['staffid'] = $staffid;
    $_SESSION['staffname'] = $staffname;
    $_SESSION['staffemail'] = $staffemail;

  ?>
</html>
<!-- javascript for disable back button -->
<script type = "text/javascript" >
    function preventBack() { window.history.forward(); }
    setTimeout("preventBack()", 0);
    window.onunload = function () { null };
</script>
?>

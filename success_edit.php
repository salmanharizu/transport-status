<?php
session_start();
include_once 'connect.php';

$myusername = $_SESSION['sid'];
$mystaffname = $_SESSION['sname'];
$mystaffemail = $_SESSION['semail'];

/*$bookstartdate = $_SESSION['book_start_date'];
$bookenddate = $_SESSION['book_end_date'];
$bookstarttime = $_SESSION['bstarttime'];
$bookendtime = $_SESSION['bendtime'];
$bookcarno = $_SESSION['bcarno'];
$bookdesc = $_SESSION['bdesc'];*/

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
    <div class="container vh-100">
      <div class="row justify-content-center h-100">
        <div class="card w-50 my-auto shadow">
          <div class="card-header text-center bg-primary text-white">
            <!--<form action ="addbutton_choose_other_carr.php">-->
              <h2></h2>
          </div>
          <div class="card-body">
            <form>
              <br>
              <center><h4>Record Successfully Updated!</h4></center>
              <br>
              <center><a href="editbutton.php" class="btn btn-danger">Back</a></center>
              <!--<a href="error_exist.html?bookstartdate=<?php echo $bookstartdate;?>&amp;bookenddate=<?php echo $bookenddate;?>">&nbsp</a>-->

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

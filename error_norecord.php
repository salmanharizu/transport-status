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
              <h2></h2>
          </div>
          <div class="card-body">
            <form>
              <br>
              <center><h4>No Record Found</h4></center>
              <br>
              <center><a href="choicebutton.php" class="btn btn-danger">Back</a></center>
              <!--<a href="error_exist.html?bookstartdate=<?php echo $bookstartdate;?>&amp;bookenddate=<?php echo $bookenddate;?>">&nbsp</a>-->

            </form>
          </div>

          <div class="card-footer text-right">
            <!--<img src="logoipfokus.jpeg" alt="IPF" width="150" height="40" align="center">-->
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

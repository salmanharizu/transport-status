<?php
include_once "connect.php";
session_start();

$myusername = $_SESSION['sid'];
$mystaffname = $_SESSION['sname'];
$mystaffemail = $_SESSION['semail'];
$mystaffcategory = $_SESSION['scategory'];

$sql = "SELECT * FROM staff WHERE staff_id = '$myusername' AND staff_status != '5'";
$result = mysqli_query($db,$sql);
$row = mysqli_fetch_array($result);


//stay_category = 1 : normal staff (create new car booking)
//            2: admin (approve booking)
//            3: admin (pass and return key)
if ($row['staff_category']== '1')
{
?>


  <!DOCTYPE html>
  <html lang="en" dir="ltr">

    <head>
      <meta charset="utf-8">
      <title>IP Fokus</title>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
  </html>

  <body>
    <div class="container vh-100">
      <div class="row justify-content-center h-100">
        <div class="card w-50 my-auto shadow">
          <div class="card-header text-center bg-primary text-white">
              <?php
                echo "Welcome back ".$myusername." !";
                echo " " . $mystaffname;
                //echo " " . $mystaffemail;
              ?>
              <h2>Car Booking</h2>
              <!--<img src="logoKE.png" alt="IPF" width="120" height="80">-->
          </div>
          <div class="card-body">
              <div class="form-group">  <a href="addbutton.php">
                <input type="button" class="btn btn-primary w-100" name="add" value="Add New Book"> <br>
              </div>

              <div class="form-group"> <a href ="editbutton.php">
                <input type="button" class="btn btn-primary w-100" name="edit" value="Edit Book">  <br>
              </div>

              <div class="form-group"> <a href ="cancelbutton.php">
                <input type="button" class="btn btn-primary w-100" name="cancel" value="Cancel Book">
              </div>

              <div class="form-group"> <a href ="sorting.php">
                <input type="button" class="btn btn-primary w-100" name="" value="Search">
              </div>
            <?php
}
else if ($row['staff_category']== '2')
{
?>
  <!DOCTYPE html>
  <html lang="en" dir="ltr">
    <head>
      <meta charset="utf-8">
      <title>IP Fokus</title>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
  </html>
  <body>
    <div class="container vh-100">
      <div class="row justify-content-center h-100">
        <div class="card w-50 my-auto shadow">
          <div class="card-header text-center bg-primary text-white">
              <?php
                echo "Welcome back ".$myusername." !";
                echo " " . $mystaffname;
              ?>
              <h2>Car Booking</h2>
          </div>
          <div class="card-body">
            <div class="form-group">  <a href="addbutton.php">
              <input type="button" class="btn btn-primary w-100" name="add" value="Add New Book"> <br>
            </div>
            <div class="form-group"> <a href ="editbutton.php">
              <input type="button" class="btn btn-primary w-100" name="edit" value="Edit Book">  <br>
            </div>
            <div class="form-group"> <a href ="cancelbutton.php">
              <input type="button" class="btn btn-primary w-100" name="cancel" value="Cancel Book">
            </div>
            <div class="form-group"> <a href ="approvalbutton.php">
              <input type="button" class="btn btn-primary w-100" name="approval" value="Approval">
            </div>
            <div class="form-group"> <a href ="access.php">
              <input type="button" class="btn btn-primary w-100" name="" value="User Access/ Access Details">
            </div>
            <div class="form-group"> <a href ="sorting.php">
              <input type="button" class="btn btn-primary w-100" name="" value="Search">
            </div>

<?php
}
else //staff category = 3: pass, return key, update odemeter start, odometer end and update milleage dnd date car after service
{
?>
  <!DOCTYPE html>
  <html lang="en" dir="ltr">
    <head>
      <meta charset="utf-8">
      <title>IP Fokus</title>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
  </html>
  <body>
  <div class="container vh-100">
    <div class="row justify-content-center h-100">
      <div class="card w-50 my-auto shadow">
        <div class="card-header text-center bg-primary text-white">
          <?php
            echo "Welcome back ".$myusername." !";
            echo " " . $mystaffname;
          ?>
          <h2>Car Booking</h2>
        </div>
        <div class="card-body">
          <div class="form-group">  <a href="addbutton.php">
            <input type="button" class="btn btn-primary w-100" name="add" value="Add New Book"> <br>
          </div>
        <div class="form-group"> <a href ="editbutton.php">
          <input type="button" class="btn btn-primary w-100" name="edit" value="Edit Book">  <br>
        </div>
        <div class="form-group"> <a href ="cancelbutton.php">
          <input type="button" class="btn btn-primary w-100" name="cancel" value="Cancel Book">
        </div>
        <div class="form-group"> <a href ="passbutton.php">
          <input type="button" class="btn btn-primary w-100" name="passkey" value="Pass Key">
        </div>
        <div class="form-group"> <a href ="returnbutton.php">
          <input type="button" class="btn btn-primary w-100" name="return" value="Return Key">
        </div>
        <div class="form-group"> <a href ="carservicebutton.php">
          <input type="button" class="btn btn-primary w-100" name="carservice" value="Car Maintenance">
        </div>
        <div class="form-group"> <a href ="sorting.php">
          <input type="button" class="btn btn-primary w-100" name="" value="Search">
        </div>
<?php
}
?>
        <!--</div>-->
        <div class="form-group">
            <center><a href="logout.php" class="btn btn-danger">Sign Out</a></center>
        </div>

        <?php
        if ($row['staff_category']== '2')
        { ?>
          <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="changepwd.php">Change Password</a></p>
          <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="register.php">New User Register!</a></p>
        <?php
        }
        else {?>
          <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="changepwd.php">Change Password</a></p>
        <?php } ?>

        <!--<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="changepwd.php">Change Password</a></p>-->
        <div class="card-footer text-right">
            <small><?php echo $mystaffemail ?></small>
            <img src="logoipfokus.jpeg" alt="IPF" width="150" height="40" align="center">
            <!--<small>&copy; IP Fokus</small>-->
        </div>
      </div>
      </div>
    </div>
  </body>


<script type = "text/javascript" >
    function preventBack() { window.history.forward(); }
    setTimeout("preventBack()", 0);
    window.onunload = function () { null };
</script>

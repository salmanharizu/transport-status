<?php
include "connect.php";
session_start();

$myusername = $_SESSION['sid'];
$mystaffname = $_SESSION['sname'];
$mystaffemail = $_SESSION['semail'];

if($_SERVER['REQUEST_METHOD'] == "POST")
{
   // Username and Password sent from Form
   $npwd = mysqli_real_escape_string($db,$_POST['pwd']);
   $nnewpwd = mysqli_real_escape_string($db,$_POST['newpwd']);
   $nconfirmnewpwd = mysqli_real_escape_string($db,$_POST['confirmnewpwd']);
   $npwd = md5($npwd); //Password Encrypted
   $nnewpwd = md5($nnewpwd); //Password Encrypted
   $nconfirmnewpwd = md5($nconfirmnewpwd); //Password Encrypted

   //echo $myusername;
   //echo $mypassword;
   //echo $npwd;
   // verify staffid and password
   $sql = "SELECT * FROM staff WHERE BINARY staff_id = '$myusername' AND BINARY staff_pwd = '$npwd' AND staff_status != 5;";
   $result = mysqli_query($db,$sql) or die("Fail to connect to database".mysql_error());
   $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
   $count = mysqli_num_rows($result);

   $sql2 = "SELECT ref_seq_no FROM reference_master WHERE ref_code = 'CP' AND ref_status = '1' AND ref_type = 'AUDIT TRAIL';";
   $result2 = mysqli_query($db,$sql2) or die("Fail to connect to database".mysql_error());
   $row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC);
   //echo $row2['ref_seq_no'];

   // If $myusername and $mypassword verified (correct staffid same with password)
   //echo $count;
   If ($count == '1')
   {
     //echo "if1";
     If ($nnewpwd == $nconfirmnewpwd)
     {
       //echo "if2";
       $sql = "UPDATE staff
                SET staff_pwd = BINARY('$nconfirmnewpwd')
                WHERE BINARY staff_id = '$myusername' AND BINARY staff_pwd = '$npwd' AND staff_status != '2';";
       $resultupd = mysqli_query($db,$sql) or die("Fail to connect to database".mysql_error());

       $sql = "INSERT INTO audit_trail (staff_id, book_id, at_code, at_id, at_desc_old, at_desc_new)
               VALUES ('$myusername','$myusername','CP','$row2[ref_seq_no]', CONCAT('Old Password',' : ','$npwd'),CONCAT('New Password',' : ','$nnewpwd'));";
       $result = mysqli_query($db, $sql);

       $sql = "UPDATE reference_master SET ref_seq_no = ref_seq_no + 1 WHERE ref_code = 'CP' AND ref_status ='1';";
       $result = mysqli_query($db, $sql);

       echo " Successfully Change Password !";
       //header("location: login.html");
     }
     else
     {
       echo "Not Matching New Password and Confirm New Password ";
     }
   }
   else
   {
    echo " Your Current Password Not Match !";
    //header("location: error_user_exist.html");
   }
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>IP Fokus | New User Login</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js"></script>
  <script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/md5.js"></script>
</head>
<body>
  <div class="container vh-100">
    <div class="row justify-content-center h-100">
      <div class="card w-50 my-auto shadow">
        <div class="card-header text-center bg-primary text-white">
          <h2>Change Password</h2>
        </div>
        <form action="<?php $_SERVER['PHP_SELF'];?>" method="post">
          <div class="card-body">
            <div class="form-group" align="center">
              <input type="text" style="font-weight:bold; width: 500px;" id="sid" class="form-control" placeholder="ID" name="sid" value="Hi <?php echo $mystaffname  ." (" .  $myusername .")"?>" readonly/>
            </div>
            <div class="form-group">
              <label for="pwd">Password</label>
              <input type="password" id="pwd" class="form-control" placeholder="Enter Your Password" name="pwd" value="" required/>
            </div>
            <div class="form-group">
              <label for="newpwd">New Password</label>
              <input type="password" id="newpwd" class="form-control" placeholder="Enter New Password" name="newpwd" value="" required/>
            </div>
            <div class="form-group">
              <label for="confirmnewpwd">Confirm New Password</label>
              <input type="password" id="confirmnewpwd" class="form-control" placeholder="Confirm New Password" name="confirmnewpwd" value="" required/>
            </div>
            <input type="submit" class="btn btn-primary w-100" style="float: right;" name="save" value="Submit">
        </div>
        <br><br>
        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="login.html">Login</a></p>
      </form>
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

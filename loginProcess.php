<?php
include("connect.php");
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST")
{
  // username and password sent from form
  $myusername = mysqli_real_escape_string($db,$_POST['sid']);
  $mypassword = mysqli_real_escape_string($db,$_POST['spwd']);
  $mypassword = md5($mypassword); //Password Encrypted

  $sql = "SELECT * FROM staff WHERE staff_id = '$myusername' AND staff_pwd = '$mypassword' AND staff_status != 5;";
  $result = mysqli_query($db,$sql) or die("Fail to connect to database".mysql_error());
  $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
  $count = mysqli_num_rows($result);
  // If result matched $myusername and $mypassword, table row must be 1 row

  if($count == 1)
  {
    $_SESSION['sid'] = $row['staff_id'];
    $_SESSION['stype'] = $row['staff_type'];
    $_SESSION['sname'] = $row['staff_name'];
    $_SESSION['semail'] = $row['staff_email'];
    $_SESSION['scategory'] = $row['staff_category'];
    header("location: choicebutton.php");
  }
  else
  {
    header("location: error.html");
  }
}

?>

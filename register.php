<?php
include "connect.php";
session_start();

$myusername = $_SESSION['sid'];
if($_SERVER['REQUEST_METHOD'] == "POST")
{
 // Username and Password sent from Form
 $newregid = mysqli_real_escape_string($db,$_POST['nregid']);
 $newregpwd = mysqli_real_escape_string($db,$_POST['nregpwd']);
 $newregname = mysqli_real_escape_string($db,ucwords($_POST['nregname']));
 $newregemail = mysqli_real_escape_string($db,strtolower($_POST['nregemail']));
 $newregcategory = mysqli_real_escape_string($db,$_POST['nregcategory']);
 $newregpwd = md5($newregpwd); //Password Encrypted

 //echo $myusername;
 //echo $mypassword;

 //$sql = "SELECT * FROM staff WHERE BINARY staff_id = '$newregid' AND BINARY staff_pwd = '$newregpwd' AND staff_status != 2;";
 $sql = "SELECT * FROM staff WHERE BINARY staff_id = '$newregid' AND staff_status != 5;";
 $result = mysqli_query($db,$sql) or die("Fail to connect to database".mysql_error());
 $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
 $count = mysqli_num_rows($result);

 $sql2 = "SELECT * FROM reference_master WHERE ref_code = 'NR' AND ref_status = '1';";
 $result2 = mysqli_query($db,$sql2) or die("Fail to connect to database".mysql_error());
 $row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC);
 //echo $row2['ref_seq_no'];
 $newdesc = $newregid.':'.$newregname.':'.$newregemail.':'.$newregpwd;
 // If result matched $myusername and $mypassword, table row must be 1 row
 //echo $count;
 If ($count == '0')
 {
   $sql = "INSERT INTO staff(staff_id, staff_pwd, staff_name, staff_shortname, staff_email, staff_status, staff_category)
            values(BINARY(UPPER('$newregid')), BINARY('$newregpwd'),'$newregname',SUBSTR('$newregname',1,10),'$newregemail','1','$newregcategory')";
   $result = mysqli_query($db, $sql);

   $sql = "INSERT INTO audit_trail (staff_id, book_id, at_code, at_id, at_desc_old, at_desc_new)
           VALUES ('$myusername',UPPER('$newregid'),'NR','$row2[ref_seq_no]', 'New User Register:NewUser:Name:Email:Pwd','$newdesc')";
   $result = mysqli_query($db, $sql);

   $sql = "UPDATE reference_master SET ref_seq_no = ref_seq_no + 1 WHERE ref_code = 'NR' AND ref_status ='1';";
   $result = mysqli_query($db, $sql);

   echo "Created Successfully!";
   //header("location: login.html");
 }
 else
 {
   header("location: error_user_exist.html");
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
          <h2>New User Login</h2>
        </div>
        <form action="<?php $_SERVER['PHP_SELF'];?>" method="post">
          <div class="card-body">
            <div class="form-group">
              <label for="nregid">Staff ID</label>
              <input style="text-transform: uppercase" type="text" id="nregid" class="form-control" placeholder="Enter Your Staff ID" name="nregid" value="" required maxlength="6"/>
            </div>
            <div class="form-group">
              <label for="nregpwd">Password</label>
              <input type="password" id="nregpwd" class="form-control" placeholder="Enter Your Password" name="nregpwd" value="" required/>
            </div>
            <div class="form-group">
              <label for="sname">Name</label>
              <input type="text" id="nregname" class="form-control" placeholder="Enter Your Full Name" name="nregname" value="" required/>
            </div>
            <div class="form-group">
              <label for="nregemail">Email</label>
              <input type="text" id="nregemail" class="form-control" placeholder="Enter Your Email Address" name="nregemail" value="" required/>
            </div>
            <div class="form-group">
              <label for="nregcategory">Category</label>
              <!--<input type="text" id="nregcategory" class="form-control" placeholder="Select Your Category" name="nregcategory" value="" required/>-->
              <br>
                <select id='nregcategory' name ='nregcategory'>
                  <option disabled selected>-- Select Category --</option>
                    <?php
                      include "connect.php";  // Using database connection file here

                      $records = mysqli_query($db, "SELECT * from reference_master WHERE ref_type = 'STAFF CATEGORY' AND ref_status ='1'");  // Use select query here

                      while($data = mysqli_fetch_array($records))
                      {
                        echo "<option value='". $data['ref_code'] ."'>" .$data['ref_desc'] ."</option>";  // displaying data in option menu
                      }
                    ?>
                </select>
            </div>
            <input type="submit" class="btn btn-primary w-100" style="float: right;" name="save" value="Create">
        </div>
        <br>
        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="login.html">Login</a></p>
      </form>
      <div class="card-footer text-right">
        <img src="logoipfokus.jpeg" alt="IPF" width="150" height="40" align="center">
        <!--<small>&copy; IP Fokus</small>-->
      </div>
    </div>
  </div>
</div>
</body>
</html>

<?php
include_once 'connect.php';  //database connectivity
session_start();
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/vendor/phpmailer/phpmailer/src/Exception.php';
require_once __DIR__ . '/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/vendor/phpmailer/phpmailer/src/SMTP.php';

date_default_timezone_set('Asia/Kuala_Lumpur');
$date = date('d-m-Y', time());
$time1 = date('H:i:s',time());

if(isset($_POST['submit']))
{
		$cartoservice = $_POST['cartoservice'];
		echo $cartoservice;
    //echo $radio_value = $_POST["radio"];
}
//passing parameter from sessions
$myusername = $_SESSION['sid'];
$mystaffname = $_SESSION['sname'];
$mystaffemail = $_SESSION['semail'];
//$bookid = $_SESSION['bookid'];
//$carodoend = $_SESSION['carodoend'];

//passing parameter from text input item
$myusername = $_POST['sid'];
$mystaffname = $_POST['sname'];
$myemail = $_POST['emailid'];
$bookid = $_POST['bid'];
$bookstartdate = $_POST['bstartdate'];
$bookenddate = $_POST['benddate'];
$bookstarttime = $_POST['bstarttime'];
$bookendtime = $_POST['bendtime'];
$bookcarno = $_POST['bcarno'];
$bookdesc = $_POST['bdesc'];
$cartotmil = $_POST['totmil'];
$carodostart = $_POST['odostart'];
$carodoend = $_POST['odoend'];

$staffid = $_POST['staffid'];
$staffname = $_POST['staffname'];
$staffemail = $_POST['staffemail'];

$date_nextservice = $_POST['date_nextservice'];
$mileage_nextservice = $_POST['mileage_nextservice'];

/*$staffid = $_GET['staffid'];
$staffname = $_GET['staffname'];
$staffshortname = $_GET['staffshortname'];
$staffemail = $_GET['staffemail'];*/

echo $carodostart;
echo " ";
echo $cartotmil;

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
$_SESSION['carodoend'] = $carodoend;
$_SESSION['new_nextdateservice'] = $date_nextservice;
$_SESSION['new_nextmilservice'] = $mileage_nextservice;

$_SESSION['staffid'] = $staffid;
$_SESSION['staffname'] = $staffname;
$_SESSION['staffemail'] = $staffemail;

if ($carodostart < $cartotmil)
{
	//echo "odometer start cannot less than current total millege";
	header("location: error_odostartlessthantotal.php");
	return;
}

if ($carodoend <= $carodostart)
{
	//echo "Odometer End Must Greater Than Odometer Start";
	header("location: error_odoendlessthanodostart.php");
	return;
}

$qsel = "SELECT count(*) as total
				 		FROM audit_trail a, booking_master b
						WHERE a.book_id = b.book_id
						AND at_time = trans_date
						AND a.book_id = '$bookid'
						AND at_code = 'RK'";
$qresult = mysqli_query($db, $qsel);
$qtotal = mysqli_fetch_assoc($qresult);

echo $qtotal['total'];
if ($qtotal['total'] == '0')
{

	$qbook = "SELECT * FROM booking_master WHERE book_id = '$bookid';";
	$resultbook = mysqli_query($db, $qbook);
	$rowbook = mysqli_fetch_array($resultbook);

	$qcar = "SELECT * FROM car_master WHERE car_no = '$bookcarno';";
	$resultcar = mysqli_query($db, $qcar);
	$rowcar = mysqli_fetch_array($resultcar);

	$query = "SELECT ref_seq_no FROM reference_master WHERE ref_code = 'RK' and ref_status = '1';";
	$result = mysqli_query($db, $query);
	$row = mysqli_fetch_array($result);

	$qtotalmileage = "SELECT ref_seq_no FROM reference_master WHERE ref_code = 'TM' and ref_status = '1';";
	$rtotalmileage = mysqli_query($db, $qtotalmileage);
	$rtm = mysqli_fetch_array($rtotalmileage);

	$qcarservice = "SELECT ref_seq_no FROM reference_master WHERE ref_code = 'CS' and ref_status = '1';";
	$rcarservice = mysqli_query($db, $qcarservice);
	$rcs = mysqli_fetch_array($rcarservice);

	$car_total_mileage = $rowcar['car_total_mileage'];
	//$_SESSION['car_total_mileage'] = $car_total_mileage;

	$sql = "UPDATE booking_master
						SET book_status = '4', trans_date = CURRENT_TIME,
								odometer_start = '$carodostart', odometer_end = '$carodoend'
						WHERE book_status = '3'
						AND book_id='$bookid';";

	$sql .= "UPDATE reference_master SET ref_seq_no = ref_seq_no + 1 WHERE ref_code in ('RK','TM','CS') AND ref_status ='1';";

	$sql .= "INSERT INTO audit_trail (staff_id, book_id, at_code, at_id, at_date, at_time, at_desc_old, at_desc_new)
							VALUES ('$myusername','$bookid','RK','$row[ref_seq_no]', CURRENT_DATE, CURRENT_TIME, 'Change Status Pass Key(3) To Return Key(4)',
											 CONCAT('Received $bookcarno Key By: $myusername', ' ; ','Returned Key By: $rowbook[staff_id]'));";

  $sql .= "INSERT INTO audit_trail (staff_id, book_id, at_code, at_id, at_date, at_time, at_desc_old, at_desc_new)
					 		VALUES ('$myusername','$bookid','TM','$rtm[ref_seq_no]', CURRENT_DATE, CURRENT_TIME, 'Old Mileage : $car_total_mileage','New Mileage : $carodoend');";

	if ($rowbook['car_to_service'] == '0') // car not to service
	{
		/*echo "car tak perlu service";
		echo $staffemail;*/
		$sql .= "UPDATE car_master
							 SET car_total_mileage = '$carodoend'
		 					 WHERE car_no = '$bookcarno';";
	}
	elseif ($rowbook['car_to_service'] == '1')//car to service
	{
		/*echo "car perlu service";
		echo $staffemail;
		echo $mystaffemail;*/
		// normally utk date next service tambah 6 bulan dari date_service dpt dr service center
		if ($date_nextservice <= $rowcar['car_next_date_service'])
		{
			//echo "New Service Date Must Later Than Old Service Date";
			header("location: error_newservicedatemustlaterthanold.php");
			return;
		}

		// normally utk date next mileage tambah 5000km/h dari date_service dpt dr service center
		if ($mileage_nextservice <= $rowcar['car_next_mileage_service'])
		{
			//echo "New Service Mileage Must More Than Old Service Mileage";
			header("location: error_newservicemilagemustmorethanold.php");
			return;
		}

		$sql .= "UPDATE car_master
							 SET car_total_mileage = '$carodoend',
							 		 car_next_date_service = '$date_nextservice',
									 car_next_mileage_service = '$mileage_nextservice'
		 					 WHERE car_no = '$bookcarno';";

		$old_nextdateservice = $rowcar['car_next_date_service'];
		//$_SESSION['old_nextdateservice'] = $old_nextdateservice;

		$old_nextmilservice = $rowcar['car_next_mileage_service'];
		//$_SESSION['old_nextmilservice'] = $old_nextmilservice;

		$sql .= "INSERT INTO audit_trail (staff_id, book_id, at_code, at_id, at_date, at_time, at_desc_old, at_desc_new)
							VALUES ('$myusername','$bookcarno','CS','$rcs[ref_seq_no]', CURRENT_DATE, CURRENT_TIME,
											CONCAT('Old Service Date : $old_nextdateservice',' ; ', 'Old Service Mileage : $old_nextmilservice'),
											CONCAT('New Service Date : $date_nextservice',' ; ', 'New Service Mileage : $mileage_nextservice'));";
	}

	if (mysqli_multi_query($db, $sql))  //to run the query
	{
		do
		{
			if ($result = mysqli_store_result($db))
				{
					while ($row = mysqli_fetch_assoc($result))
					{
						//echo "apa niiiiii";
						//header("location: returnbuttonProcess_audittrail1111.php"); 	//redirect to delete page
					}
					mysqli_free_result($result);
				}
		}

		while (mysqli_next_result($db));
		/*$_SESSION['sid'] = $myusername;
		$_SESSION['sname'] = $mystaffname;
		$_SESSION['semail'] = $mystaffemail;
		$_SESSION['bookid'] = $bookid;
		$_SESSION['bookcarno'] = $bookcarno;
		$_SESSION['bstartdate'] = $bookstartdate;
		$_SESSION['benddate'] = $bookenddate;
		$_SESSION['bstarttime'] = $bookstarttime;
		$_SESSION['bendtime'] = $bookendtime;
		$_SESSION['bdesc'] = $bookdesc;
		$_SESSION['carodoend'] = $carodoend;
		$_SESSION['new_nextdateservice'] = $date_nextservice;
		$_SESSION['new_nextmilservice'] = $mileage_nextservice;

		$_SESSION['staffid'] = $staffid;
		$_SESSION['staffname'] = $staffname;*/

		//header("location: returnbuttonProcess_audittrail.php");
		header("location: error_recreturnkey.php");
		$mail = new PHPMailer();
		try
		{
			$mail->SMTPDebug = SMTP::DEBUG_SERVER; // for detailed debug output
			$mail->isSMTP();
			$mail->Host = 'smtp.gmail.com';
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
			$mail->Port = 587;

			$mail->Username = 'ipfokusmis@gmail.com';
			$mail->Password = '565083IPFOKUS';
			//$mail->SMTPSecure = 'ssl';

			$mail->setFrom('ipfokusmis@gmail.com', 'noreply:IPFOKUS.MIS');
			$mail->addAddress($staffemail, $staffname);//1 email
			$mail->addAddress($mystaffemail, $mystaffname);//2 email
			$mail->addReplyTo('ipfokusmis@gmail.com', 'IPFOKUS.MIS');

			// Setting the email content 1
			$mail->isHTML(true);
			$mail->Subject = "Return Car's Key By: $staffid-$staffname";
			//$mail->Body = 'HTML message body. <b>Gmail</b> SMTP email body.';
			$mail->Body = "BookID: $bookid <br> Depart date: $bookstartdate <br> Return date: $bookenddate <br>
										 Depart time: $bookstarttime <br> Return time: $bookendtime <br> Car No: $bookcarno <br>
										 Description: $bookdesc <br> Date Return Car's Key: $date $time1 <br>
										 Received By: $mystaffname ($myusername)";
			$mail->AltBody = 'Plain text message body for non-HTML email client. Gmail SMTP email body.';

			$mail->send();
				echo "Email message sent.";
		}

		catch (Exception $e)
		{
			echo "Error in sending email. Mailer Error: {$mail->ErrorInfo}";
		}
	}
	else
	{
		echo "Error: " . $sql . " " . mysqli_error($db);
	}
	mysqli_close($db);
}
else
{
	header("location: error_recordupdated.html");
}
?>

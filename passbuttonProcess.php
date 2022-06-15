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

//passing parameter from sessions
$myusername = $_SESSION['sid'];
$mystaffname = $_SESSION['sname'];
$mystaffemail = $_SESSION['semail'];

//passing parameter from url
$bookid = $_GET['book_id'];
$bookcarno = $_GET['book_carno'];
$bookdesc = $_GET['book_desc'];
$bookstartdate = $_GET['book_startdate'];
$bookstarttime = $_GET['book_starttime'];
$bookenddate = $_GET['book_enddate'];
$bookendtime = $_GET['book_endtime'];

$staffid = $_GET['staffid'];
$staffname = $_GET['staffname'];
$staffshortname = $_GET['staffshortname'];
$staffemail = $_GET['staffemail'];

$qsel = "SELECT count(*) as total
				 		FROM audit_trail a, booking_master b
						WHERE a.book_id = b.book_id
						AND at_time = trans_date
						AND a.book_id = '$_GET[book_id]'
						AND at_code = 'PK'";
$qresult = mysqli_query($db, $qsel);
$qtotal = mysqli_fetch_assoc($qresult);

$qcar = "SELECT *
				 		FROM car_master
						WHERE car_no = '$bookcarno'
						AND car_status = '1'";
$qresultcar = mysqli_query($db, $qcar);
$qcardet = mysqli_fetch_assoc($qresultcar);

echo $qtotal['total'];
if ($qtotal['total'] == '0')
{
	//echo " rrrrrrrr";
	$query = "SELECT ref_seq_no FROM reference_master WHERE ref_code = 'PK' and ref_status = '1';";
	$result = mysqli_query($db, $query);
	$row = mysqli_fetch_array($result);

	$sql = "UPDATE booking_master SET book_status = '3', trans_date = CURRENT_TIME WHERE book_status = '1' AND book_id='" . $_GET['book_id'] . "';";									//sql query
	/*$sql .= "UPDATE car_details SET car_status = '0' WHERE car_no ='" . $_GET['book_carno'] . "';";*/
	$sql .= "UPDATE reference_master SET ref_seq_no = ref_seq_no + 1 WHERE ref_code = 'PK' AND ref_status ='1';";
	$sql .= "INSERT INTO audit_trail (staff_id, book_id, at_code, at_id, at_date, at_time, at_desc_old, at_desc_new)
						VALUES ('$myusername','" . $_GET["book_id"] . "','PK','$row[ref_seq_no]', CURRENT_DATE, CURRENT_TIME, 'Change Status Approved(1) To Pass Key(3)',
							CONCAT('Pass $bookcarno Key To: $staffid', ' ; ','Process Done By: $myusername'));";

	if (mysqli_multi_query($db, $sql))  //to run the query
	{
		do
		{
			if ($result = mysqli_store_result($db))
				{
					while ($row = mysqli_fetch_assoc($result))
					{
						//header("location: passbutton.php"); 	//redirect to delete page
					}
					mysqli_free_result($result);
				}

		}
		while (mysqli_next_result($db));
		header("location: error_recpasskey.php");
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
			$mail->Subject = "Pass Car's Key To: $staffname-$staffid";
			//$mail->Body = 'HTML message body. <b>Gmail</b> SMTP email body.';
			$mail->Body = "BookID: $bookid <br> Depart date: $bookstartdate <br> Return date: $bookenddate <br>
										 Depart time: $bookstarttime <br> Return time: $bookendtime <br> Car No: $bookcarno <br>
										 Description: $bookdesc <br> Date Pass Key: $date $time1 <br>
										 Process Done By: $mystaffname ($myusername)";
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

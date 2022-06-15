<?php
session_start();
include_once 'connect.php';  //database connectivity
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/vendor/phpmailer/phpmailer/src/Exception.php';
require_once __DIR__ . '/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/vendor/phpmailer/phpmailer/src/SMTP.php';

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

date_default_timezone_set('Asia/Kuala_Lumpur');
$date = date('d/m/Y', time());
$time1 = date('H:i:s',time());

$qsysdate = "SELECT CURRENT_TIMESTAMP from dual";
$resultqsysdate = mysqli_query($db, $qsysdate);
$rowqsys = mysqli_fetch_assoc($resultqsysdate);

$qsel = "SELECT count(*) as total
				 		FROM audit_trail a, booking_master b
						WHERE a.book_id = b.book_id
						AND at_date = trans_date
						AND a.book_id = '$_GET[book_id]'
						AND at_code = 'AB'";
$qresult = mysqli_query($db, $qsel);
$qtotal = mysqli_fetch_assoc($qresult);

echo $qtotal['total'];
if ($qtotal['total'] == '0')
{

	//$sql = "DELETE FROM booking_master WHERE book_id='" . $_GET["book_id"] . "';";
	//sql query
	$q1 = "SELECT ref_seq_no FROM reference_master WHERE ref_code = 'AB' and ref_status = '1'";
	$qref = mysqli_query($db, $q1);
	$qseqno = mysqli_fetch_array($qref);

	$sql = "UPDATE booking_master SET book_status = '1', trans_date = CURRENT_TIMESTAMP WHERE book_id ='" . $_GET["book_id"] . "';";

	$sql .= "UPDATE reference_master SET ref_seq_no = ref_seq_no + 1 WHERE ref_code = 'AB' AND ref_status = '1';";

	$sql .= "INSERT INTO audit_trail (staff_id, book_id, at_code, at_id, at_date, at_time, at_desc_old, at_desc_new)
					   VALUES ('$myusername','" . $_GET["book_id"] . "','AB','$qseqno[ref_seq_no]', CURRENT_DATE, CURRENT_TIME, 'Change status In Process(0) To Approved(1)',
										CONCAT('Approved By: $myusername', ' : ','Requested By: $staffid'));";

	if (mysqli_multi_query($db, $sql))  //to run the query
	{
		do
		{
				if ($result = mysqli_store_result($db))
				{
					while ($row = mysqli_fetch_assoc($result))
					{
						//header("location: deletebutton.php"); 	//redirect to delete page
						header("location: error_recapproved.php");
					}
					mysqli_free_result($result);
				}
		}
		while (mysqli_next_result($db));
	 			header("location: error_recapproved.php");

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

	 		  // Setting the email content
	 		  $mail->isHTML(true);
	 		  $mail->Subject = "Approved Car Booking By: $myusername-$mystaffname";
	 		  //$mail->Body = 'HTML message body. <b>Gmail</b> SMTP email body.';
	 			$mail->Body = "Applied By: $staffid-$staffshortname <br> BookID: $bookid <br> Depart date: $bookstartdate <br> Return date: $bookenddate <br> Depart Time: $bookstarttime <br> Return Time: $bookendtime <br> Car No: $bookcarno <br> Description: $bookdesc ";
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
	msqli_close($db);
}
else
{
	header("location: error_recordupdated.html");
}

?>

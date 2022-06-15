<?php
include_once 'connect.php';
session_start();

$myusername = $_SESSION['sid'];
$mystaffname = $_SESSION['sname'];
$mystaffemail = $_SESSION['semail'];

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/vendor/phpmailer/phpmailer/src/Exception.php';
require_once __DIR__ . '/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/vendor/phpmailer/phpmailer/src/SMTP.php';

$bookid = $_POST['bid'];
$bookdesc = $_POST['bdesc'];
$bookreason = $_POST['breason'];
$myemail = $_POST['emailid'];
$bookcarno = $_POST['bcarno'];
$bookdate = $_POST['book_date'];
$bookstartdate = $_POST['bstartdate'];
$bookenddate = $_POST['benddate'];
$bookstarttime = $_POST['bstarttime'];
$bookendtime = $_POST['bendtime'];

$query = "SELECT ref_seq_no FROM reference_master WHERE ref_code = 'CB' and ref_status = '1';";
$result = mysqli_query($db, $query);
$row = mysqli_fetch_array($result);

$sql = "UPDATE booking_master SET book_status = '2', trans_date = CURRENT_TIME, book_desc = CONCAT(book_desc,' - ','$bookreason')
					WHERE book_id ='$bookid'
					AND staff_id = '$myusername';";	//sql query

$sql .= "INSERT INTO audit_trail (staff_id, book_id, at_code, at_id, at_date, at_time, at_desc_old, at_desc_new)
				   VALUES ('$myusername','$bookid', 'CB','$row[ref_seq_no]', CURRENT_DATE, CURRENT_TIME, CONCAT('$bookcarno',' : ','$bookdesc',' : ','$bookstartdate',' : ','$bookenddate',' : ','$bookstarttime',' : ','$bookendtime'),'Reason To Cancel: $bookreason')";



if (mysqli_multi_query($db, $sql))  //to run the query
{
	do
	{
		if ($result = mysqli_store_result($db))
		{
			while ($row = mysqli_fetch_assoc($result))
			{
				 //header("location: cancelbutton.php"); 	//redirect to cancel page
			}
				 mysqli_free_result($result);
		}
	}


	while (mysqli_next_result($db));

		//$sql .= "UPDATE car_details SET car_status = '0' WHERE car_no ='$bookcarno';";

		$sql .= "UPDATE reference_master SET ref_seq_no = ref_seq_no + 1 WHERE ref_code = 'CB' AND ref_status ='1';";

		header("location: cancelbutton.php");

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
			$mail->addAddress($myemail, $mystaffname);
			$mail->addReplyTo('ipfokusmis@gmail.com', 'IPFOKUS.MIS');

		 	// Setting the email content
		 	$mail->isHTML(true);
		 	$mail->Subject = "Booking Cancelled by $myusername-$mystaffname";
		 	//$mail->Body = 'HTML message body. <b>Gmail</b> SMTP email body.';
			$mail->Body = "BookID: $bookid <br> Reason To Cancel: $bookreason <br> Depart Date: $bookstartdate <br> Return Date: $bookenddate <br> Depart Time: $bookstarttime <br> Return Time: $bookendtime <br> Car No: $bookcarno <br> Description: $bookdesc ";

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
?>

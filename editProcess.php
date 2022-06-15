<?php

session_start();
include_once 'connect.php';

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

// ini adalah process retrieve data dari page sebelum dalam bentuk text dan appoint to new variable
// new data adjustment

$sidname = $_POST['sidname'];
$bookid = $_POST['bid'];
$mystaffname = $_POST['sname'];
$myemail = $_POST['emailid'];
$bookstartdate = $_POST['bstartdate'];
$bookenddate = $_POST['benddate'];
$bookstarttime = $_POST['bstarttime'];
$bookendtime = $_POST['bendtime'];
$bookcarno = $_POST['bcarno'];
$bookdesc = $_POST['bdesc'];
$cartoservice = $_POST['cartoservice'];

$vbookstartdatetime = $bookstartdate ." ". $bookstarttime;
$vbookenddatetime = $bookenddate ." ". $bookendtime;

//1)if semua data adalah sama (no changes)
$qcount = "select count(*) as total
						from booking_master
						WHERE book_carno = '$bookcarno'
						AND book_start_date = '$vbookstartdatetime'
						AND book_end_date = '$vbookenddatetime'
						AND book_desc = '$bookdesc'
						AND book_status != '2'
						AND car_to_service = 'cartoservice'
						AND book_id = '$bookid'";
$resultqcount = mysqli_query($db, $qcount);
$rowqcount = mysqli_fetch_assoc($resultqcount);
echo "if1".$rowqcount['total'];

if ($rowqcount['total'] != '0')
{
    header("location: error_same_data.php");
		return;
}
//endif data no changes (no updating process)
else
{
	echo "if2";
//2) changes on booking details
$q2 = "SELECT * from booking_master
				WHERE book_id = '$bookid'";
$result2 = mysqli_query($db, $q2);
$row2 = mysqli_fetch_assoc($result2);

//2.1) changes on description only
if ($bookdesc != $row2['book_desc'] and $bookcarno == $row2['book_carno']
		and $vbookstartdatetime == $row2['book_start_date'] and $vbookenddatetime == $row2['book_end_date']
		and $bookstarttime  == $row2['book_start_time'] and $bookendtime  == $row2['book_end_time']
		and $cartoservice == $row2['car_to_service'])
		{
			echo "if3 edit bookdesc only(info2 lain semua sama)";
			$sql1 = "SELECT ref_seq_no FROM reference_master WHERE ref_code = 'EB' and ref_status = '1';";
			$result1 = mysqli_query($db, $sql1);
			$row1 = mysqli_fetch_array($result1);

			$sql = "UPDATE reference_master SET ref_seq_no = ref_seq_no + 1 WHERE ref_code = 'EB' AND ref_status ='1';";

			//update old data to new data (adjustment)
			$sql .= "UPDATE booking_master
									set book_desc = '$bookdesc',
											trans_date = CURRENT_TIMESTAMP
									WHERE book_id = '$bookid' AND book_status = '0' AND staff_id = '$myusername';";

			$sql .= "INSERT INTO audit_trail (staff_id, book_id, at_code, at_id, at_desc_old, at_desc_new)
							   VALUES ('$myusername', '$bookid', 'EB','$row1[ref_seq_no]', '$row2[book_desc]', '$bookdesc')";

			$bookenddate = date('d-m-Y', strtotime($bookenddate));
			$bookstartdate = date('d-m-Y', strtotime($bookstartdate));
			$bookstarttime = date('h:i a', strtotime($bookstarttime));
			$bookendtime = date('h:i a', strtotime($bookendtime));

			if (mysqli_multi_query($db, $sql))  //to run the query
			{
				do
				{
					if ($result = mysqli_store_result($db))
					{
						while ($row = mysqli_fetch_assoc($result));
						mysqli_free_result($result);
					}
				}
				while (mysqli_next_result($db));
				header("location: success_edit.php");

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
					$mail->Subject = "Car Booking Description Was Edited by $sidname";
					//$mail->Body = 'HTML message body. <b>Gmail</b> SMTP email body.';
					$mail->Body = "BookID: $bookid <br> Depart Date: $bookstartdate <br> Return Date: $bookenddate <br> Depart Time: $bookstarttime <br> Return Time: $bookendtime <br> Car No: $bookcarno <br> Description: $bookdesc ";
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
//2.2) changes on all info or either one
else
	{
			echo "if4";
			$q1 = "SELECT count(*) as total from booking_master
							WHERE book_carno = '$bookcarno'
							AND ('$vbookstartdatetime' BETWEEN book_start_date and book_end_date
							or '$vbookenddatetime' BETWEEN book_start_date and book_end_date)
							AND book_status != '2'
							AND book_id != '$bookid'";
			$result1 = mysqli_query($db, $q1);
			$row1 = mysqli_fetch_assoc($result1);
			echo $row1['total'];

			if ($row1['total'] != '0')//car not available
			{
				//echo "if5 car not available";
				//header("location: error_exist_edit.php");
				header("location: error_exist_edit.php");
				//echo "Error: " . $q1 . " " . mysqli_error($db);

				// PHP program to pop an alert
				// message box on the screen
				// Function definition
				/*function function_alert($message) {
						// Display the alert box
						echo "<script>alert('$message');</script>";
				}

				// Function call
				function_alert("if5 car not available");*/

			}
			elseif ($row1['total'] == '0') //car available based on selected date
			{
				echo "if6 car available";
				if ($row2['car_to_service'] == '0')
				{
					$vcartoservice = 'No-Car Not To Service';
				}
				else
				{
					$vcartoservice = 'Yes-Car To Service';
				}

				$at_desc_old = date('d-m-Y', strtotime($row2['book_start_date'])).' : '.date('d-m-Y', strtotime($row2['book_end_date'])).' : '.
											 date('h:i a', strtotime($row2['book_start_time'])).' : '.date('h:i a', strtotime($row2['book_end_time'])).' : '.
											 $row2['book_carno'].' : '.$row2['book_desc'].' : '.$vcartoservice;

				// old data
				/*$_SESSION['bookid'] = $bookid;
				$_SESSION['myusername'] = $myusername;
				$_SESSION['book_start_date'] = $bookstartdate;
				$_SESSION['book_end_date'] = $bookenddate;
				$_SESSION['bstarttime'] =  $bookstarttime;
				$_SESSION['bendtime'] = $bookendtime;
				$_SESSION['bcarno'] =  $bookcarno;
				$_SESSION['bdesc'] =  $bookdesc;*/

				if ($cartoservice == '0')
				{
					$vnewcartoservice = 'No-Car Not To Service';
				}
				else
				{
					$vnewcartoservice = 'Yes-Car To Service';
				}

				$at_desc_new =  date('d-m-Y', strtotime($bookstartdate)).' : '.date('d-m-Y', strtotime($bookenddate)).' : '.
												date('h:i a', strtotime($bookstarttime)).' : '.date('h:i a', strtotime($bookendtime)).' : '.
												$bookcarno.' : '.$bookdesc.' : '.$vnewcartoservice;

				$sql1 = "SELECT ref_seq_no FROM reference_master WHERE ref_code = 'EB' and ref_status = '1';";
				$result1 = mysqli_query($db, $sql1);
				$row1 = mysqli_fetch_array($result1);

				$sql = "UPDATE reference_master SET ref_seq_no = ref_seq_no + 1 WHERE ref_code = 'EB' AND ref_status ='1';";

				//update old data to new data (adjustment)
				$sql .= "UPDATE booking_master
										set book_start_date = date_format('$vbookstartdatetime','%Y-%m-%d %T'),
												book_end_date = date_format('$vbookenddatetime','%Y-%m-%d %T'),
												book_start_time = '$bookstarttime',
												book_end_time = '$bookendtime',
												book_carno = '$bookcarno', book_desc = '$bookdesc', car_to_service = '$cartoservice',
												trans_date = CURRENT_TIMESTAMP
										WHERE book_id = '$bookid' AND book_status = '0' AND staff_id = '$myusername';";

				$sql .= "INSERT INTO audit_trail (staff_id, book_id, at_code, at_id, at_desc_old, at_desc_new)
								   VALUES ('$myusername', '$bookid', 'EB','$row1[ref_seq_no]', '$at_desc_old','$at_desc_new')";


				$bookstartdate = date('d-m-Y', strtotime($bookstartdate));
				$bookenddate = date('d-m-Y', strtotime($bookenddate));
				$bookstarttime = date('h:i a', strtotime($bookstarttime));
				$bookendtime = date('h:i a', strtotime($bookendtime));

				if (mysqli_multi_query($db, $sql))  //to run the query
				{
					do
					{
						if ($result = mysqli_store_result($db))
						{
							while ($row = mysqli_fetch_assoc($result));
							mysqli_free_result($result);
						}
					}
					while (mysqli_next_result($db));
					header("location: success_edit.php");

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
						$mail->Password = 'IPFokusMIS123';
						//$mail->SMTPSecure = 'ssl';

						$mail->setFrom('ipfokusmis@gmail.com', 'noreply:IPFOKUS.MIS');
						$mail->addAddress($myemail, $mystaffname);
						$mail->addReplyTo('ipfokusmis@gmail.com', 'IPFOKUS.MIS');

						// Setting the email content
						$mail->isHTML(true);
						$mail->Subject = "Edited Car Booking by: $sidname";
						//$mail->Body = 'HTML message body. <b>Gmail</b> SMTP email body.';
						$mail->Body = "BookID: $bookid <br> Depart Date: $bookstartdate <br> Return Date: $bookenddate <br> Depart Time: $bookstarttime <br> Return Time: $bookendtime <br> Car No: $bookcarno <br> Description: $bookdesc <br> Car To Service: $vcartoservice";
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
					//echo "test";
					echo "Error: " . $sql . " " . mysqli_error($db);
				}
				mysqli_close($db);
			}
	}
}
?>

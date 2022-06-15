<?php

include "connect.php";
session_start();

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/vendor/phpmailer/phpmailer/src/Exception.php';
require_once __DIR__ . '/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/vendor/phpmailer/phpmailer/src/SMTP.php';

// ini adalah process retrieve data dari page sebelum dalam bentuk text dan appoint to new variable
$myusername = $_POST['sid'];
$mystaffname = $_POST['sname'];
$myemail = $_POST['emailid'];
$bookstartdate = $_POST['bstartdate'];
$bookenddate = $_POST['benddate'];
$bookstarttime = $_POST['bstarttime'];
$bookendtime = $_POST['bendtime'];
$bookcarno = $_POST['bcarno'];
$bookdesc = $_POST['bdesc'];
$cartoservice = $_POST['cartoservice'];


$vbookstarttime = $bookstarttime .":00";
$vbookendtime = $bookendtime .":00";
$at_desc = date('d-m-Y', strtotime($bookstartdate)).' : '.date('d-m-Y', strtotime($bookenddate)).' : '.date('h:i a', strtotime($bookstarttime)).' : '.date('h:i a', strtotime($bookendtime)).' : '.$bookcarno.' : '.$bookdesc;

//echo $bookstarttime;
//echo $bookendtime;

$idd = $_POST['idd'];
$vbookstartdatetime = $bookstartdate ." ". $vbookstarttime;
$vbookenddatetime = $bookenddate ." ". $vbookendtime;

echo $vbookstartdatetime;
echo 'testdatetime';
echo $vbookenddatetime;
//echo 'kkkkk';

$qsysdate = "SELECT CURRENT_TIMESTAMP, CURRENT_TIME from dual";
$resultqsysdate = mysqli_query($db, $qsysdate);
$rowqsys = mysqli_fetch_assoc($resultqsysdate);

if (($vbookstartdatetime < $rowqsys['CURRENT_TIMESTAMP']) or ($vbookenddatetime < $rowqsys['CURRENT_TIMESTAMP']))
{
    header("location: error_date_not_allowed.html");
    return;
}

if ($vbookstartdatetime < $vbookenddatetime)
{
	$q1 = "SELECT count(*) as total from booking_master
						WHERE book_carno = '$bookcarno'
						AND ('$vbookstartdatetime' BETWEEN book_start_date and book_end_date
						or '$vbookenddatetime' BETWEEN book_start_date and book_end_date)
						AND book_status != '2'";
	$result1 = mysqli_query($db, $q1);
	$row1 = mysqli_fetch_assoc($result1);
	echo $row1['total'];

	 //record not exist in booking_master
    if ($row1['total'] == '0')
  	{
  		$q2 = "SELECT ref_seq_no FROM reference_master WHERE ref_code = 'BK' and ref_status = '1'";
  		$result2 = mysqli_query($db, $q2);
  		$row2 = mysqli_fetch_array($result2);

  		$q3 = "SELECT ref_seq_no FROM reference_master WHERE ref_code = 'NB' and ref_status = '1'";
  		$result3 = mysqli_query($db, $q3);
  		$row3 = mysqli_fetch_array($result3);

      $q4 = "SELECT * FROM car_master WHERE car_no = '$bookcarno' and car_status = '1'";
  		$result4 = mysqli_query($db, $q4);
  		$row4 = mysqli_fetch_array($result4);


  		$sql = "UPDATE reference_master SET ref_seq_no = ref_seq_no + 1 WHERE ref_code in ('NB','BK') AND ref_status ='1';";

  		$sql .= "INSERT INTO booking_master (book_id,staff_id,book_start_date,book_end_date,book_start_time,book_end_time,book_carno,book_desc, car_to_service, odometer_start, odometer_end)
  						VALUES ('$row2[ref_seq_no]','$idd','$vbookstartdatetime','$vbookenddatetime','$bookstarttime','$bookendtime','$bookcarno','$bookdesc','$cartoservice','$row4[car_total_mileage]','$row4[car_total_mileage]');";
  		$sql .= "INSERT INTO audit_trail (staff_id, book_id, at_code, at_id, at_date, at_time, at_desc_old, at_desc_new)
  	          VALUES ('$idd','$row2[ref_seq_no]','NB','$row3[ref_seq_no]', CURRENT_DATE, CURRENT_TIME, 'Booking status is In Process(0)','$at_desc' )";

  						//ini adalah process carry variable ke next page .php
  						/*$_SESSION['sid'] = $idd;
  						$_SESSION['bid'] = $row['ref_seq_no'];
  						$_SESSION['emailid'] = $myemail;
  						$_SESSION['spwd'] = $staffpwd;
  						$_SESSION['bstartdate'] = $bookstartdate;
  						$_SESSION['benddate'] = $bookendtime;
  						$_SESSION['bstarttime'] = $bookstarttime;
  						$_SESSION['bendtime'] = $bookendtime;
  						$_SESSION['bcarno'] = $bookcarno;
  						$_SESSION['bdesc'] = $bookdesc;*/



  						$bookenddate = date('d-m-Y', strtotime($bookenddate));
  						$bookstartdate = date('d-m-Y', strtotime($bookstartdate));
  						$bookstarttime = date('h:i a', strtotime($bookstarttime));
  						$bookendtime = date('h:i a', strtotime($bookendtime));

      //if dbase
  		if (mysqli_multi_query($db, $sql))
  		{
  			do
  			{
  					if ($result = mysqli_store_result($db))
  					{
  						while ($row = mysqli_fetch_array($result))
  						{
  							header("location: addbutton.php");
  						}
  						mysqli_free_result($result);
  					}
  			}
  			while (mysqli_next_result($db));
  				//$myusername = $_SESSION['sid'];
          header("location: success.php");
  				//header("location: addbutton.php");
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
  				$mail->addAddress($myemail, $mystaffname);//1 email
          $mail->addAddress('yuni.zhry@gmail.com', "YUNI ZAHAR");//2 email
  				$mail->addReplyTo('ipfokusmis@gmail.com', 'IPFOKUS.MIS');

  				// Setting the email content
  				$mail->isHTML(true);
  				//$mail->Subject = "Car Booking was made by: $myusername $mystaffname ";
  				$mail->Subject = "New Car Booking by: $myusername ";
  				$mail->Body = "BookID: $row2[ref_seq_no] <br> Depart Date: $bookstartdate <br> Return Date: $bookenddate <br> Depart Time: $bookstarttime <br> Return Time: $bookendtime <br> Car No: $bookcarno <br> Description: $bookdesc ";
  				$mail->AltBody = 'Plain text message body for non-HTML email client. Gmail SMTP email body.';

  				$mail->send();
  				echo "Email message sent.";
  			}
  			catch (Exception $e)
  			{
  				echo "Error in sending email. Mailer Error: {$mail->ErrorInfo}";
  			} //end while
        echo "Welcome";
  		}
  		else
  		{
  			echo "Error: " . $sql . " " . mysqli_error($db);
  		} // end if dbase
    mysqli_close($db);
    }
    else
    {
      header("location: error_exist.html");
    }// end if count(*) = 0 : record exist
}
else
{
  header("location: error_date.html");
}// end of checking date


?>

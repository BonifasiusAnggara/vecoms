<?php
/**
 * This example shows settings to use when sending via Google's Gmail servers.
 */

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Asia/Jakarta');

require 'phpmailer/PHPMailerAutoload.php';

//Create a new PHPMailer instance
$mail = new PHPMailer;

//Tell PHPMailer to use SMTP
$mail->isSMTP();

//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 0;

//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';

//Set the hostname of the mail server
$mail->Host = 'smtp.gmail.com';
// use
// $mail->Host = gethostbyname('smtp.gmail.com');
// if your network does not support SMTP over IPv6

//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
$mail->Port = '' ;

//Set the encryption system to use - ssl (deprecated) or tls
$mail->SMTPSecure = '';

//Whether to use SMTP authentication
$mail->SMTPAuth = false;

//Username to use for SMTP authentication - use full email address for gmail
$mail->Username = "";

//Password to use for SMTP authentication
$mail->Password = "";

//Set who the message is to be sent from
$mail->setFrom('adm.sukabumi@enseval.com', 'Vecoms | Endframe');

//Set who the message is to be sent to
$mail->addAddress('jajah.zahruddin@enseval.com', 'Jajah Zahruddin EXP Sukabumi');
$mail->addAddress('didi.wulyanto@enseval.com', 'Didi Wulyanto DBM Sukabumi');

//Set the subject line
$mail->Subject = 'STNK ED Dekat';

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$body = '<!DOCTYPE HTML>
					<html>
					<head>
						<meta name="viewport" content="width:device-width, initial-scale=1.0">
						<title>Request Ganti Sparepart</title>
					</head>
					<body>
					<div style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
						<p></p>
						<p>Yth Ka. Exp, ABM</p>
						<br><br>
						<p>Mobil dengan Plat Nomor '.$row[plat_no].'.</p>
						<p>Masa berlaku STNK nya sudah mau habis, kurang '.$row[stnk].' lagi.</p>
						<p>Mohon segera lakukan perpanjangan !!</p>
						<br></br>
						<p>Klik link berikut untuk melihat data mobil.</p>
						<p><a href="epm.sukabumi.com/vecoms">epm.sukabumi.com/vecoms</a></p>
					</div>
					</body>
					</html>';
$mail->msgHTML($body);

//Replace the plain text body with one created manually
$mail->AltBody = 'This is a plain-text message body';

//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}

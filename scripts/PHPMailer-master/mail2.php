<?php
require 'PHPMailerAutoload.php'; //Your path to PHPMailer's directory
//require 'class.phpmailer.php';
$Mail = new PHPMailer();
//print_R($Mail);
$Mail->IsSMTP(); // Use SMTP
$Mail->Host        = "smtp.gmail.com"; // Sets SMTP server for gmail
$Mail->SMTPDebug   = 0; // 2 to enable SMTP debug information
$Mail->SMTPAuth    = TRUE; // enable SMTP authentication
$Mail->SMTPSecure  = "tls"; //Secure conection
$Mail->Port        = 587; // set the SMTP port to gmail's port
$Mail->Username    = 'elntool@gmail.com'; // gmail account username
$Mail->Password    = 'elnelneln'; // gmail account password
$Mail->Priority    = 1; // Highest priority - Email priority (1 = High, 3 = Normal, 5 =   low)
$Mail->CharSet     = 'UTF-8';
$Mail->Encoding    = '8bit';
$Mail->Subject     = 'Mail test';
$Mail->ContentType = 'text/html; charset=utf-8\r\n';
$Mail->From        = 'elntool@gmail.com'; //Your email adress (Gmail overwrites it anyway)
$Mail->FromName    = 'Test';
$Mail->WordWrap    = 900; // RFC 2822 Compliant for Max 998 characters per line

$Mail->addAddress('elntool@gmail.com'); // To: test1@gmail.com
$Mail->isHTML( TRUE );
$Mail->Body    = '<b>This is a test mail from localhost using PHP</b>';
$Mail->AltBody = 'This is a test mail from localhost using PHP';
$Mail->Send();
$Mail->SmtpClose();

if(!$Mail->send()) {
echo 'Message could not be sent.';
echo 'Mailer Error: ' . $Mail->ErrorInfo;
exit;
}

echo 'Message has been sent';

?>
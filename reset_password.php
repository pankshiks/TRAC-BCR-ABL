<?php
include($_SERVER['DOCUMENT_ROOT'].'/ELN/includes/ezsql/ezsql_conn.inc');
require 'scripts/PHPMailer-master/PHPMailerAutoload.php'; //Your path to PHPMailer's directory
ini_set('display_errors',false);
//require 'class.phpmailer.php';
 //echo $_SERVER['DOCUMENT_ROOT'].'/ELN/includes/layout/default_page_layout.inc';
 
if(trim($_POST['mailid']))
{
    
  if(!filter_var($_POST['mailid'], FILTER_VALIDATE_EMAIL) === false)
{
      $master_arr=$db->get_results("select * from msom_settings where mail_uname='".trim($_POST['mailid'])."'",ARRAY_A);
      
    
    if($master_arr)
    {
        
    
  
    
$settings_arr=$db->get_results("select mail_server,mail_port,mail_uname,mail_pword,mail_sender,mail_subject from msom_settings where sid=1",ARRAY_A);

    
            
        
$Mail = new PHPMailer();
//print_R($Mail);
$Mail->IsSMTP(); // Use SMTP
$Mail->Host        = trim($settings_arr[0]['mail_server']); // Sets SMTP server for gmail
$Mail->SMTPDebug   = 0; // 2 to enable SMTP debug information
$Mail->SMTPAuth    = TRUE; // enable SMTP authentication
$Mail->SMTPSecure  = "ssl"; //Secure conection
$Mail->Port        = trim($settings_arr[0]['mail_port']);//587; // set the SMTP port to gmail's port
$Mail->Username    = trim($settings_arr[0]['mail_uname']);//'eln20142015@gmail.com'; // gmail account username
$Mail->Password    = trim($settings_arr[0]['mail_pword']);//'elnadmin'; // gmail account password
$Mail->Priority    = 1; // Highest priority - Email priority (1 = High, 3 = Normal, 5 =   low)
$Mail->CharSet     = 'UTF-8';
$Mail->Encoding    = '8bit';
$Mail->Subject     = 'Password Reset link from eln registry';
$Mail->ContentType = 'text/html; charset=utf-8\r\n';
$Mail->From        = trim($settings_arr[0]['mail_uname']);//'akaldoss75@gmail.com'; //Your email adress (Gmail overwrites it anyway)
$Mail->FromName    = trim($settings_arr[0]['mail_sender']);//'Test';
$Mail->WordWrap    = 900; // RFC 2822 Compliant for Max 998 characters per line

$Mail->addAddress(trim($_POST['mailid'])); // To: test1@gmail.com
$Mail->isHTML(TRUE);

$Mail->Body    = 'Dear User<br>
    To reset your password please click the below link '."<a href=\"http://127.0.0.1//ELN/reset_upwd.html\">Click here...</a>";



if($Mail->Send()) {
$arr[0]['succ']='Mail has been sent successfully';
}
else
    $arr[0]['err']= 'Message could not be sent.please check settings page details...';

$Mail->SmtpClose();
    
    
     }
    else
        $arr[0]['ref']="Please enter the registered email id";
}
else
    $arr[0]['ref']='Please enter a valid email id';
    

}
else
    $arr[0]['err']='Please enter the email id';
    
    
    echo '{"json_return_array":'.json_encode($arr).'}';    
    
    
?>
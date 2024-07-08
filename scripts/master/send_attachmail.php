<?php
ini_set('display_errors',false);
include($_SERVER['DOCUMENT_ROOT'].'/ELN/includes/layout/default_page_layout.inc');
require '../../PHPMailer-master/PHPMailerAutoload.php'; //Your path to PHPMailer's directory

//require 'class.phpmailer.php';

if(trim($_POST['mailid']))
{
    
    $id=$_SESSION['mso_eln']['pviewid'];

if($id)
{
      $patient_arr=$db->get_results("select
    p.patient_id,p.pcode,p.pname,p.sur_name,p.gender,DATE_FORMAT(p.dob,'%d-%m-%Y') as dob,p.protocol_no,p.pmail,p.authorized_by1,p.authorized_by2,p.authorized_by3,p.physician_name,p.phy_mail,p.diagnosis,p.bcr_apl,DATE_FORMAT(p.start_date,'%d-%m-%Y') as tsdate,p.treatment_type,
    
    t.test_id,DATE_FORMAT(date,'%d-%m-%Y') as test_date,t.sample_type,t.sample_sent_from,t.sample_no,t.bcr_apl_no,t.controlgene_no,t.conversion_fact 	


     from msom_patient p
     left join msom_test t on t.patient_id=p.patient_id
     where p.patient_id=$id",ARRAY_A);
 
    
    if($patient_arr)
    {
        
        $marr=gender_arr();
        $bcr_apl_stype_arr=bcr_apl_stype();
        $type_of_treatment_arr=treatment_type();
        
$get_max_id=$db->get_var("select max(graph_id) from msom_graph where patient_id=$id");
$report_date=$db->get_var("select DATE_FORMAT(report_date,'%d-%m-%Y') from msom_graph where graph_id=$get_max_id");

$body_str.="<center><h3>Bcr-Abl1</h3></center><table width=100% >
        
<tr><td width=15%><strong>Patient Name, Surname</strong></td><td width=15%> : ".$patient_arr[0]['pname'].' '.$patient_arr[0]['sur_name']."</td><td width=25%></td><td width=16%><strong>Sample Delivery date</strong></td><td width=15%> : ".date('d-m-Y')."</td></tr>
<tr><td><strong>Age Gender</strong></td><td > : ".$patient_arr[0]['age'].'/'.$marr[$patient_arr[0]['gender']]."</td><td></td><td><strong>Report Date</strong></td><td >  : $report_date</td></tr>
<tr><td><strong>Sent From and Dr.Name</strong></td><td > : ".$patient_arr[0]['sample_sent_from'].' / '.$patient_arr[0]['physician_name']."</td><td></td><td><strong>Hospital ID</strong></td><td >  : ".$patient_arr[0]['protocol_no']."</td></tr>


        </table>
        <table id=ftbl width=100% style='border:1px solid black;border-collapse:collapse;'>
        <tr>
        <th style='border:1px solid black;width:20%;'>Date of Test</th>
        <th style='border:1px solid black;'>Copy Count</th>
        </tr>";
        
       
        foreach($patient_arr as $k=>$v)
        {
            
        $body_str.=" <tr>
        <td style='border:1px solid black;' align=center>".($v['test_date'])."&nbsp;</td>
        <td style='border:1px solid black;' align=center>".($v['bcr_apl_no'])."&nbsp;</td></tr>";
        
            
        }
        $body_str.="</table>";
    }
    
    
    
 
//$body_1="<br><Br><div style=\"width:1300px\" align=left><strong>Diagnosis Procedure</strong> ".$patient_arr[0]['diagnosis']." &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Sample Type</strong> ".$patient_arr[0]['sample_type']."&nbsp;&nbsp;&nbsp;&nbsp;<strong>Bcr-Abl Transaction Subtype</strong> ".$patient_arr[0]['bcr_apl']."</div>";
    
  
    
$settings_arr=$db->get_results("select mail_server,mail_port,mail_uname,mail_pword,mail_sender,mail_subject from msom_settings where sid=1",ARRAY_A);

    
        chmod("../../master/graph/$get_max_id.png", 0777); 
        $filename="../../master/graph/$get_max_id.png";
            
        
$Mail = new PHPMailer();
//print_R($Mail);
$Mail->IsSMTP(); // Use SMTP
$Mail->Host        = "smtp.gmail.com"; // Sets SMTP server for gmail
$Mail->SMTPDebug   = 0; // 2 to enable SMTP debug information
$Mail->SMTPAuth    = TRUE; // enable SMTP authentication
$Mail->SMTPSecure  = "tls"; //Secure conection
$Mail->Port        = $settings_arr[0]['mail_port'];//587; // set the SMTP port to gmail's port
$Mail->Username    = $settings_arr[0]['mail_uname'];//'eln20142015@gmail.com'; // gmail account username
$Mail->Password    = $settings_arr[0]['mail_pword'];//'elnadmin'; // gmail account password
$Mail->Priority    = 1; // Highest priority - Email priority (1 = High, 3 = Normal, 5 =   low)
$Mail->CharSet     = 'UTF-8';
$Mail->Encoding    = '8bit';
$Mail->Subject     = 'Patient Details'?'Patient Details':$settings_arr[0]['mail_subject'];
$Mail->ContentType = 'text/html; charset=utf-8\r\n';
$Mail->From        = $settings_arr[0]['mail_uname'];//'akaldoss75@gmail.com'; //Your email adress (Gmail overwrites it anyway)
$Mail->FromName    = $settings_arr[0]['mail_uname'];//'Test';
$Mail->WordWrap    = 900; // RFC 2822 Compliant for Max 998 characters per line

$Mail->addAddress(trim($_POST['mailid'])); // To: test1@gmail.com
$Mail->isHTML( TRUE );
$Mail->AddEmbeddedImage($filename, 'community-i');
//$mail->Body = 'Embedded Image: <img alt="PHPMailer" src="cid:community-i">';
//$Mail->AddEmbeddedImage($filename, 'logoimg', $filename); // attach file logo.jpg, and later link to it using identfier logoimg
$Mail->Body    = $body_str.'  <img alt="Attachment missing" src="cid:community-i">';
$Mail->AltBody = 'Mail content missing';



if($Mail->Send()) {
$arr[0]['succ']='Mail has been sent successfully';
}
else
    $arr[0]['err']= 'Message could not be sent.please check settings page details...';

$Mail->SmtpClose();
    
    
    
}
else
    $arr[0]['ref']='Please try again later';
    

}
else
    $arr[0]['err']='Please enter the mail id';
    
    
    echo '{"json_return_array":'.json_encode($arr).'}';    
    
    
?>
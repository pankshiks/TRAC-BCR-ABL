<?php
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
    
    t.test_id,DATE_FORMAT(date,'%d-%m-%Y') as test_date,t.sample_type,t.sample_sent_from,t.sample_no,t.bcr_apl_no,DATE_FORMAT(p.diag_st_date,'%d-%m-%Y') as diag_stdate,p.medication_id,p.bcr_apl_others


     from msom_patient p
     left join msom_test t on t.patient_id=p.patient_id
     where p.patient_id=$id order by t.date asc",ARRAY_A);
    
  
   if($patient_arr)
    {
        $marr=gender_arr();
        $bcr_apl_stype_arr=bcr_apl_stype();
        $type_of_treatment_arr=treatment_type();
        $diagnosis_arr=diagnosis_arr();
        $medication_arr=medication_arr();

$body_str="<center><h3>Report</h3></center>
        <table width=\"100%\" style=\"border:1px solid;\">
        
<tr><td width=\"18%\">Name</td><td width=\"25%\"> : ".$patient_arr[0]['pname']."</td><td width=\"25%\">Physician's name</td><td width=\"25%\"> : ".$patient_arr[0]['physician_name']."</td></tr>
<tr><td>Surname</td><td > : ".$patient_arr[0]['sur_name']."</td><td>Physician's e-mail address</td><td > : ".$patient_arr[0]['phy_mail']."</td></tr>
<tr><td>Gender</td><td > : ".$marr[$patient_arr[0]['gender']]."</td><td>The diagnosis and the phase at the time of diagnosis</td><td > : ".$diagnosis_arr[$patient_arr[0]['diagnosis']]."</td></tr>
<tr><td>Date of birth</td><td > : ".$patient_arr[0]['dob']."</td><td>BCR-ABL transcript subtype</td><td > : ".$bcr_apl_stype_arr[$patient_arr[0]['bcr_apl']]."<br>".$patient_arr[0]['bcr_apl_others']."</td></tr>
<tr><td>Hospital ID</td><td > : ".$patient_arr[0]['protocol_no']."</td><td>Date of diagnosis</td><td > : ".$patient_arr[0]['diag_stdate']."</td></tr>
<tr><td>Patient's e-mail address</td><td> : ".$patient_arr[0]['pmail']."</td><td>Medication name</td><td > : ".$medication_arr[$patient_arr[0]['medication_id']]."</td></tr>
<tr><td>Report authorized by</td><td> : ".$patient_arr[0]['authorized_by1']."</td><td>Treatment start date </td><td> : ".$patient_arr[0]['tsdate']."</td></tr>
<tr><td>Report authorized by</td><td> : ".$patient_arr[0]['authorized_by2']."</td><td>Type of treatment </td><td> : ".$type_of_treatment_arr[$patient_arr[0]['treatment_type']]."</td></tr>
<tr><td>Report authorized by</td><td> : ".$patient_arr[0]['authorized_by3']."</td><td> </td><td></td></tr>
<tr></tr>




        </table><br>
        <table width=\"100%\" style='border:1px solid black;border-collapse:collapse;'>
        <tr><th style='border:1px solid black;' align=center>#</th>
        <th style='border:1px solid black;' align=center>Date of Test</th>
        <th style='border:1px solid black;' align=center>Sample Type</th>
        <th style='border:1px solid black;' align=center>Sample sent from<br />(Hospital)</th>
        <th style='border:1px solid black;' align=center>Sample #</th>
        <th style='border:1px solid black;' align=center>BCR-ABL1 Result %<br />(International Scale)</th></tr>";
        
        
       

       
        foreach($patient_arr as $k=>$v)
        {

            $body_str.= "<tr><td style='border:1px solid black;' align=center>".($k+1)."</td>
            <td style='border:1px solid black;' align=center>".($v['test_date'])."</td>
            <td style='border:1px solid black;'>".($v['sample_type'])."</td>
            <td style='border:1px solid black;'>".($v['sample_sent_from'])."</td>
            <td style='border:1px solid black;' align=center>".($v['sample_no'])."</td>
            <td style='border:1px solid black;' align=center>".($v['bcr_apl_no'])."</td></tr>";

        }

       $body_str.='</table>';

    }
    else
      $arr[0]['err']="Please check the patient details";;


    
    
    
    
    
    
    
    
    
    
    
    
    
    
$settings_arr=$db->get_results("select mail_server,mail_port,mail_uname,mail_pword,mail_sender,mail_subject from msom_settings where sid=1",ARRAY_A);
    
    
$Mail = new PHPMailer();
//print_R($Mail);
$Mail->IsSMTP(); // Use SMTP
$Mail->Host        = trim($settings_arr[0]['mail_server']); // Sets SMTP server for gmail
$Mail->SMTPDebug   = 0; // 2 to enable SMTP debug information
$Mail->SMTPAuth    = TRUE; // enable SMTP authentication
$Mail->SMTPSecure  = "ssl"; //Secure conection
$Mail->Port        = trim($settings_arr[0]['mail_port']);//587; // set the SMTP port to gmail's port
$Mail->Username    = trim($settings_arr[0]['mail_uname']);// gmail account username
$Mail->Password    = trim($settings_arr[0]['mail_pword']);//gmail account password
$Mail->Priority    = 1; // Highest priority - Email priority (1 = High, 3 = Normal, 5 =   low)
$Mail->CharSet     = 'UTF-8';
$Mail->Encoding    = '8bit';
$Mail->Subject     = $settings_arr[0]['mail_subject']?trim($settings_arr[0]['mail_subject']):'Patient Details';
$Mail->ContentType = 'text/html; charset=utf-8\r\n';
$Mail->From        = trim($settings_arr[0]['mail_uname']);//''; //Your email adress (Gmail overwrites it anyway)
$Mail->FromName    = trim($settings_arr[0]['mail_sender']);//'Test';
$Mail->WordWrap    = 900; // RFC 2822 Compliant for Max 998 characters per line

$Mail->addAddress(trim($_POST['mailid'])); // To: test1@gmail.com
$Mail->isHTML( TRUE );
$Mail->Body    = $body_str;
$Mail->AltBody = '';//Mail content missing



if($Mail->Send()) {
$arr[0]['succ']='Mail has been sent successfully';
}
else
    $arr[0]['err']= 'Message could not be sent.please check settings page details.'.$Mail->ErrorInfo;
    
    $Mail->SmtpClose();
    
    
}
else
    $arr[0]['ref']='Please try again later...';
    

}
else
    $arr[0]['err']='Please enter the mail id...';
    
    
    echo '{"json_return_array":'.json_encode($arr).'}';    
    
    
  
?>
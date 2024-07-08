<?php
include($_SERVER['DOCUMENT_ROOT'].'/ELN/includes/layout/default_page_layout.inc');
require '../../PHPMailer-master/PHPMailerAutoload.php'; //Your path to PHPMailer's directory

//require 'class.phpmailer.php';

if(trim($_POST['mailid']))
{
    
    $id=$_SESSION['mso_eln']['pviewid'];

if($id)
{
    
        $get_max_idt=$db->get_var("select max(graph_id) from msom_graph where patient_id=".$id);;
       $report_date_rem_arr=$db->get_results("select DATE_FORMAT(report_date,'%d-%m-%Y') as rdate,remarks,treatment_type  from msom_graph where graph_id=".$get_max_idt,ARRAY_A);
       
      $patient_arr=$db->get_results("select
    p.patient_id,p.pcode,p.pname,p.sur_name,p.gender,DATE_FORMAT(p.dob,'%d-%m-%Y') as dob,p.protocol_no,p.pmail,p.authorized_by1,p.authorized_by2,p.authorized_by3,p.physician_name,p.phy_mail,p.diagnosis,p.bcr_apl,DATE_FORMAT(p.start_date,'%d-%m-%Y') as tsdate,p.treatment_type,
    
    t.test_id,DATE_FORMAT(date,'%d-%m-%Y') as test_date,t.sample_type,t.sample_sent_from,t.sample_no,t.bcr_apl_no,t.controlgene_no,t.conversion_fact,DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.dob)), '%Y')+0 AS age	,DATE_FORMAT(p.diag_st_date,'%d-%m-%Y') as diag_stdate,p.medication_id


     from msom_patient p
     left join msom_test t on t.patient_id=p.patient_id and t.treatment_type=".$report_date_rem_arr[0]['treatment_type']."
     where p.patient_id=$id order by t.date asc",ARRAY_A);
 
    
    if($patient_arr)
    {
        
        $marr=gender_arr();
        $bcr_apl_stype_arr=bcr_apl_stype();
        $type_of_treatment_arr=treatment_type();
        $medication_arr=medication_arr();
        
        
$get_max_id=$db->get_var("select max(graph_id) from msom_graph where patient_id=$id");
$report_date_rem_arr=$db->get_results("select DATE_FORMAT(report_date,'%d-%m-%Y') as rdate,remarks,treatment_type  from msom_graph where graph_id=".$get_max_id,ARRAY_A);

$body_str.="<center><h3>BCR-ABL1</h3></center><table width=100% >
        
<tr><td width=15%><strong>Patient Name, Surname</strong></td><td width=15%> : ".$patient_arr[0]['pname'].' '.$patient_arr[0]['sur_name']."</td><td width=25%></td><td width=16%><strong>Sample Delivery date</strong></td><td width=15%> : ".date('d-m-Y')."</td></tr>
<tr><td><strong>Age / Gender</strong></td><td > : ".$patient_arr[0]['age'].'/'.$marr[$patient_arr[0]['gender']]."</td><td></td><td><strong>Report Date</strong></td><td >  : ".$report_date[0]['rdate']."</td></tr>
<tr><td><strong>Sent From and Dr.Name</strong></td><td > : ".$patient_arr[0]['sample_sent_from'].' / '.$patient_arr[0]['physician_name']."</td><td></td><td><strong>Hospital Id</strong></td><td >  : ".$patient_arr[0]['protocol_no']."</td></tr>
<tr><td><strong>Date of diagnosis</strong></td><td > : ".$patient_arr[0]['diag_stdate']."</td><td></td><td></td><td></td></tr>
<tr><td><strong>Medication name</strong></td><td > : ".$medication_arr[$patient_arr[0]['medication_id']]."</td><td></td><td></td><td></td></tr>


        </table>
        <table align=center id=ftbl width=50%   style='border-collapse:collapse;border:2px solid #F79F81;'>
        <tr>
        <th style='width:20%;border:2px solid #F79F81;'>Date of Test</th>
        <th style='border:2px solid #F79F81;'>BCR-ABL1 Result % (International Scale)</th>
        </tr>";
        
       
        foreach($patient_arr as $k=>$v)
        {
             $td_class='style='.($k%2?"'border:2px solid #F79F81; height:24px;'":"'background-color: #F6CECE; border:2px solid #F79F81; height:24px;'");
        $body_str.=" <tr>
        <td $td_class align=center>".($v['test_date'])."&nbsp;</td>
        <td $td_class align=center>".($v['bcr_apl_no'])."&nbsp;</td></tr>";
        
            
        }
        $body_str.="</table>
        
        <table id=ftbl width=100%><tr><th>Start Date</th><td>".$_GET['sdate']."</td><th>End Date</th><td>".$_GET['edate']."</td><th>Treatment Type</th><td>".$type_of_treatment_arr[$_GET['ttype']]."</td></tr></table>";
    }
    
    
    
 
//$body_1="<br><Br><div style=\"width:1300px\" align=left><strong>Diagnosis Procedure</strong> ".$patient_arr[0]['diagnosis']." &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Sample Type</strong> ".$patient_arr[0]['sample_type']."&nbsp;&nbsp;&nbsp;&nbsp;<strong>Bcr-Abl Transaction Subtype</strong> ".$patient_arr[0]['bcr_apl']."</div>";
    
  
    
$settings_arr=$db->get_results("select mail_server,mail_port,mail_uname,mail_pword,mail_sender,mail_subject from msom_settings where sid=1",ARRAY_A);

    
        chmod("../../master/graph/$get_max_id.png", 0777); 
        $filename="../../master/graph/$get_max_id.png";
            
        
$Mail = new PHPMailer();
//print_R($Mail);
$Mail->IsSMTP(); // Use SMTP
$Mail->Host        = trim($settings_arr[0]['mail_server']); // Sets SMTP server for gmail
$Mail->SMTPDebug   = 0; // 2 to enable SMTP debug information
$Mail->SMTPAuth    = TRUE; // enable SMTP authentication
$Mail->SMTPSecure  = "ssl"; //Secure conection
$Mail->Port        = trim($settings_arr[0]['mail_port']);//587; // set the SMTP port to gmail's port
$Mail->Username    = trim($settings_arr[0]['mail_uname']);// // gmail account username
$Mail->Password    = trim($settings_arr[0]['mail_pword']);// gmail account password
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
$Mail->AddEmbeddedImage($filename, 'community-i');
//$mail->Body = 'Embedded Image: <img alt="PHPMailer" src="cid:community-i">';
//$Mail->AddEmbeddedImage($filename, 'logoimg', $filename); // attach file logo.jpg, and later link to it using identfier logoimg
$Mail->Body    = $body_str.'  <img alt="" src="cid:community-i">  Reference: Baccarani M, Deininger MW,Rosti G, et al.European LeukemiaNet recommendations for the management of chronic myeloid leukemia:2013. Blood 2013;122(6):872-84.doi:10.1182/blood-2013-05-501569'."\n
".treatment_graph($report_date_rem_arr[0]['treatment_type'])."
\n
<b>Evaluation of the report :</b>".$report_date_rem_arr[0]['remarks'];
$Mail->AltBody = '';



if($Mail->Send()) {
$arr[0]['succ']='Mail has been sent successfully';
}
else
    $arr[0]['err']= 'Message could not be sent.please check settings details...';

$Mail->SmtpClose();
    
    
    
}
else
    $arr[0]['ref']='Please try again later';
    

}
else
    $arr[0]['err']='Please enter the mail id';
    
    
    echo '{"json_return_array":'.json_encode($arr).'}';    
    
    
?>
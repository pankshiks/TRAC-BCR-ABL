<?php
include($_SERVER['DOCUMENT_ROOT'].'/ELN/includes/layout/default_page_layout.inc');
require '../../PHPMailer-master/PHPMailerAutoload.php'; //Your path to PHPMailer's directory

//require 'class.phpmailer.php';

if(trim($_POST['mailid']))
{
         
    $condition.=$_POST['pcode'] && $_POST['pcode']!='undefined'?" and p.pcode like '%".$_POST['pcode']."%'":'';
    $condition.=$_POST['name'] && $_POST['name']!='undefined'?" and p.pname like '%".$_POST['name']."%'":'';
    $condition.=$_POST['surname'] && $_POST['surname']!='undefined'?" and p.sur_name like '%".$_POST['surname']."%'":'';
    $condition.=$_POST['gender'] && $_POST['gender']!='undefined'?" and p.gender like '%".$_POST['gender']."%'":'';    
    $condition.=$_POST['dob'] && $_POST['dob']!='undefined'?" and p.dob='".GetFormattedDate($_POST['dob'])."'":'';
    $condition.=$_POST['prot_no'] && $_POST['prot_no']!='undefined'?" and p.protocol_no like '%".$_POST['prot_no']."%'":'';
    
    $condition.=$_POST['pemail'] && $_POST['pemail']!='undefined'?" and p.pmail like '%".$_POST['pemail']."%'":'';
    $condition.=$_POST['authorized1'] && $_POST['authorized1']!='undefined'?" and p.authorized_by1 like '%".$_POST['authorized1']."%'":'';
    $condition.=$_POST['phy_name'] && $_POST['phy_name']!='undefined'?" and p.physician_name like '%".$_POST['phy_name']."%'":'';
    $condition.=$_POST['phy_mail'] && $_POST['phy_mail']!='undefined'?" and p.phy_mail like '%".$_POST['phy_mail']."%'":'';
    $condition.=$_POST['diag'] && $_POST['diag']!='undefined'?" and p.diagnosis like '%".$_POST['diag']."%'":'';
    $condition.=$_POST['bcr_apl_stype'] && $_POST['bcr_apl_stype']!='undefined'?" and p.bcr_apl like '%".$_POST['bcr_apl_stype']."%'":'';
    $condition.=$_POST['tsdate'] && $_POST['tsdate']!='undefined'?" and p.start_date='".GetFormattedDate($_POST['tsdate'])."'":'';
    $condition.=$_POST['type_of_treatment'] && $_POST['type_of_treatment']!='undefined'?" and p.treatment_type like '%".$_POST['type_of_treatment']."%'":'';

      $patient_arr=$db->get_results("select
    p.patient_id,p.pcode,p.pname,p.sur_name,p.gender,DATE_FORMAT(p.dob,'%d-%m-%Y') as dob,p.protocol_no,p.pmail,p.authorized_by1,p.authorized_by2,p.authorized_by3,p.physician_name,p.phy_mail,p.diagnosis,p.bcr_apl,DATE_FORMAT(p.start_date,'%d-%m-%Y') as tsdate,p.treatment_type,p.bcr_apl_others
    
     from msom_patient p
     where p.status='act' $condition ",ARRAY_A);
    
  
   if($patient_arr)
    {
        $marr=gender_arr();
        $bcr_apl_stype_arr=bcr_apl_stype();
        $type_of_treatment_arr=treatment_type();
        $diagnosis_arr=diagnosis_arr();   

$body_str="<center><h3>Patient Report</h3></center>
        <table width=\"100%\" style=\"border:1px solid black;border-collapse:collapse;\">
        <tr>
       
        <th style='border:1px solid black;'>#</th>";
        if($_POST['c1'] && $_POST['c1']!='undefined')
        $body_str.= "<th style='border:1px solid black;'>Name</th>";
        if($_POST['c2'] && $_POST['c2']!='undefined')
        $body_str.= "<th style='border:1px solid black;'>Surname</th>";
        if($_POST['c3'] && $_POST['c3']!='undefined')
        $body_str.= "<th style='border:1px solid black;'>Gender</th>";
        if($_POST['c4'] && $_POST['c4']!='undefined')
        $body_str.= "<th style='border:1px solid black;'>DOB</th>";
        if($_POST['c5'] && $_POST['c5']!='undefined')
        $body_str.= "<th style='border:1px solid black;'>Hospital ID</th>";
        if($_POST['c6'] && $_POST['c6']!='undefined')
        $body_str.= "<th style='border:1px solid black;'>Patient's e-mail Address</th>";
        if($_POST['c7'] && $_POST['c7']!='undefined')
        {
            $body_str.= "<th style='border:1px solid black;'>Report authorized by</th>";
            $body_str.= "<th style='border:1px solid black;'>Report authorized by</th>";
            $body_str.= "<th style='border:1px solid black;'>Report authorized by</th>";
        }
        if($_POST['c8'] && $_POST['c8']!='undefined')
        $body_str.= "<th style='border:1px solid black;'>Physician's name</th>";
        if($_POST['c9'] && $_POST['c9']!='undefined')
        $body_str.= "<th style='border:1px solid black;'>Physician's e-mail address</th>";
        if($_POST['c10'] && $_POST['c10']!='undefined')
        $body_str.= "<th style='border:1px solid black;'>The diagnosis and the phase at the time of diagnosis</th>";
        if($_POST['c11'] && $_POST['c11']!='undefined')
        $body_str.= "<th style='border:1px solid black;'>BCR-ABL transcript subtype</th>";
        if($_POST['c12'] && $_POST['c12']!='undefined')
        $body_str.= "<th style='border:1px solid black;'>Treatment start date</th>";
        if($_POST['c13'] && $_POST['c13']!='undefined')
        $body_str.= "<th style='border:1px solid black;'>Type of treatment</th>";
        $body_str.= "</tr>";
        
        
        $ij=1;
        foreach($patient_arr as $pk=>$pv)
        {
  $body_str.="<tr>
        
        <td style='border:1px solid black;'>$ij</td>";
        if($_POST['c1'] && $_POST['c1']!='undefined')
        $body_str.= "<td style='border:1px solid black;'>".$pv['pname']."</td>";
        if($_POST['c2'] && $_POST['c2']!='undefined')
        $body_str.= "<td style='border:1px solid black;'>".$pv['sur_name']."</td>";
        if($_POST['c3'] && $_POST['c3']!='undefined')
        $body_str.= "<td style='border:1px solid black;'>".$marr[$pv['gender']]."</td>";
        if($_POST['c4'] && $_POST['c4']!='undefined')
        $body_str.= "<td style='border:1px solid black;'>".$pv['dob']."</td>";
        if($_POST['c5'] && $_POST['c5']!='undefined')
        $body_str.= "<td style='border:1px solid black;'>".$pv['protocol_no']."</td>";
        if($_POST['c6'] && $_POST['c6']!='undefined')
        $body_str.= "<td style='border:1px solid black;'>".$pv['pmail']."</td>";
        if($_POST['c7'] && $_POST['c7']!='undefined')
        {
        $body_str.= "<td style='border:1px solid black;'>".$pv['authorized_by1']."</td>";
        $body_str.= "<td style='border:1px solid black;'>".$pv['authorized_by2']."</td>";
        $body_str.= "<td style='border:1px solid black;'>".$pv['authorized_by3']."</td>";
        }
        if($_POST['c8'] && $_POST['c8']!='undefined')
        $body_str.= "<td style='border:1px solid black;'>".$pv['physician_name']."</td>";
        if($_POST['c9'] && $_POST['c9']!='undefined')
        $body_str.= "<td style='border:1px solid black;'>".$pv['phy_mail']."</td>";
        if($_POST['c10'] && $_POST['c10']!='undefined')
        $body_str.= "<td style='border:1px solid black;'>".$diagnosis_arr[$pv['diagnosis']]."</td>";
        if($_POST['c11'] && $_POST['c11']!='undefined')
        $body_str.= "<td style='border:1px solid black;'>".$bcr_apl_stype_arr[$pv['bcr_apl']]."<br>".$pv['bcr_apl_others']."</td>";
        if($_POST['c12'] && $_POST['c12']!='undefined')
        $body_str.= "<td style='border:1px solid black;'>".$pv['tsdate']."</td>";
        if($_POST['c13'] && $_POST['c14']!='undefined')
        $body_str.= "<td style='border:1px solid black;'>".$type_of_treatment_arr[$pv['treatment_type']]."</td>";
        
        $body_str.= "</tr>";
        $ij++;
        }
       $body_str.="</table>";


   
    
    
    
    
    
    
    
    
    
    
$settings_arr=$db->get_results("select mail_server,mail_port,mail_uname,mail_pword,mail_sender,mail_subject from msom_settings where sid=1",ARRAY_A);
    
    
$Mail = new PHPMailer();
//print_R($Mail);
$Mail->IsSMTP(); // Use SMTP
$Mail->Host        = trim($settings_arr[0]['mail_server']); // Sets SMTP server for gmail
$Mail->SMTPDebug   = 0; // 2 to enable SMTP debug information
$Mail->SMTPAuth    = TRUE; // enable SMTP authentication
$Mail->SMTPSecure  = "ssl"; //Secure conection
$Mail->Port        = trim($settings_arr[0]['mail_port']);//587; // set the SMTP port to gmail's port
$Mail->Username    = trim($settings_arr[0]['mail_uname']);//// gmail account username
$Mail->Password    = trim($settings_arr[0]['mail_pword']);// // gmail account password
$Mail->Priority    = 1; // Highest priority - Email priority (1 = High, 3 = Normal, 5 =   low)
$Mail->CharSet     = 'UTF-8';
$Mail->Encoding    = '8bit';
$Mail->Subject     = $settings_arr[0]['mail_subject']?trim($settings_arr[0]['mail_subject']):'Patient Report Details';
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
    $arr[0]['err']= 'Message could not be sent. Please check settings page details.'.$Mail->ErrorInfo;
    
    $Mail->SmtpClose();
    
    

     }
    else
      $arr[0]['err']="Please check the patient details";;



}
else
    $arr[0]['err']='Please enter the mail id';
    
    
    echo '{"json_return_array":'.json_encode($arr).'}';    
    
    
  
?>
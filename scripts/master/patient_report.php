<?PHP
ini_set('display_errors',false);
include($_SERVER['DOCUMENT_ROOT'].'/ELN/includes/layout/default_page_layout.inc');
//ini_set('display_errors',true);
//$db->debug=1;
//$_SESSION['mso_eln']['pviewid']=5;

   
    $condition.=$_POST['pcode']?" and p.pcode like '%".$_POST['pcode']."%'":'';
    $condition.=$_POST['name']?" and p.pname like '%".$_POST['name']."%'":'';
    $condition.=$_POST['surname']?" and p.sur_name like '%".$_POST['surname']."%'":'';
    $condition.=$_POST['gender']?" and p.gender like '%".$_POST['gender']."%'":'';    
    $condition.=$_POST['dob']?" and p.dob='".GetFormattedDate($_POST['dob'])."'":'';
    $condition.=$_POST['prot_no']?" and p.protocol_no like '%".$_POST['prot_no']."%'":'';
    
    $condition.=$_POST['pemail']?" and p.pmail like '%".$_POST['pemail']."%'":'';
    $condition.=$_POST['authorized1']?" and p.authorized_by1 like '%".$_POST['authorized1']."%'":'';
    $condition.=$_POST['phy_name']?" and p.physician_name like '%".$_POST['phy_name']."%'":'';
    $condition.=$_POST['phy_mail']?" and p.phy_mail like '%".$_POST['phy_mail']."%'":'';
    $condition.=$_POST['diag']?" and p.diagnosis like '%".$_POST['diag']."%'":'';
    $condition.=$_POST['bcr_apl_stype']?" and p.bcr_apl like '%".$_POST['bcr_apl_stype']."%'":'';
    $condition.=$_POST['tsdate']?" and p.start_date='".GetFormattedDate($_POST['tsdate'])."'":'';
    $condition.=$_POST['type_of_treatment']?" and p.treatment_type like '%".$_POST['type_of_treatment']."%'":'';
    
    
    
    $patient_arr=$db->get_results("select
    p.patient_id,p.pcode,p.pname,p.sur_name,p.gender,DATE_FORMAT(p.dob,'%d-%m-%Y') as dob,p.protocol_no,p.pmail,p.authorized_by1,p.authorized_by2,p.authorized_by3,p.physician_name,p.phy_mail,p.diagnosis,p.bcr_apl,DATE_FORMAT(p.start_date,'%d-%m-%Y') as tsdate,p.treatment_type,p.bcr_apl_others
    
     from msom_patient p
     where p.status='act' $condition",ARRAY_A);
   
    //echo "<pre>";
    //print_r($patient_arr);
    
    //$smarty->assign('pcnt',$patient_arr[0]['test_id']?(count($patient_arr)+1):count($patient_arr));

    if($patient_arr)
        $smarty->assign('report_arr',$patient_arr);
    else
        $smarty->assign('show_errors',"<div class=error>No records to view...</div>");
    


    $smarty->assign('column_arr',array("<input type=checkbox name=\"c1\" id=\"c1\" value=\"1\" ".($_POST['c1']=='1' || !$_POST?'checked':'')."/>Name",
    "<input type=checkbox name=\"c2\" id=\"c2\" value=\"1\" ".($_POST['c2']=='1' || !$_POST?'checked':'')."/>Surname",
    "<input type=checkbox name=\"c3\" id=\"c3\"  value=\"1\" ".($_POST['c3']=='1' || !$_POST?'checked':'')."/>Gender",
    "<input type=checkbox name=\"c4\" id=\"c4\" value=\"1\" ".($_POST['c4']=='1' || !$_POST?'checked':'')."/>DOB",
    "<input type=checkbox name=\"c5\" id=\"c5\" value=\"1\" ".($_POST['c5']=='1' || !$_POST?'checked':'')."/>Hospital ID",
    "<input type=checkbox name=\"c6\" id=\"c6\" value=\"1\" ".($_POST['c6']=='1' ?'checked':'')."/>Patient's e-mail Address",
    "<input type=checkbox name=\"c7\" id=\"c7\" value=\"1\" ".($_POST['c7']=='1'?'checked':'')."/>Report authorized by",
    "<input type=checkbox name=\"c8\" id=\"c8\" value=\"1\" ".($_POST['c8']=='1'?'checked':'')."/>Physician's name",
    "<input type=checkbox name=\"c9\" id=\"c9\" value=\"1\" ".($_POST['c9']=='1'?'checked':'')."/>Physician's e-mail address",
    "<input type=checkbox name=\"c10\" id=\"c10\" value=\"1\" ".($_POST['c10']=='1'?'checked':'')."/>The diagnosis and the phase at the time of diagnosis",
    "<input type=checkbox name=\"c11\" id=\"c11\" value=\"1\" ".($_POST['c11']=='1'?'checked':'')."/>BCR-ABL transcript subtype",
    "<input type=checkbox name=\"c12\" id=\"c12\" value=\"1\" ".($_POST['c12']=='1'?'checked':'')."/>Treatment start date",
    "<input type=checkbox name=\"c13\" id=\"c13\" value=\"1\" ".($_POST['c13']=='1'?'checked':'')."/>Type of treatment",
    "<input type=checkbox name=\"c14\" id=\"c14\" value=\"1\" ".($_POST['c14']=='1' || !$_POST?'checked':'')."/>Delete"));


$smarty->assign('diagnosis_arr',diagnosis_arr());
//$smarty->assign('output_arr',getoutarray(1));
$smarty->assign('default_select2','hometoplink25');
$smarty->assign('bcr_apl_stype_arr',bcr_apl_stype());
$smarty->assign('type_of_treatment_arr',treatment_type());
$smarty->assign('marr',gender_arr());
$smarty->assign('page_title','List Of Patients');
$smarty->display('patient_report.tpl');
?>
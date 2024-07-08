<?PHP
ini_set('display_errors',false);
include($_SERVER['DOCUMENT_ROOT'].'/ELN/includes/layout/default_page_layout.inc');

//$db->debug=1;
//$_SESSION['mso_eln']['pviewid']=5;
$pid=$_SESSION['mso_eln']['pviewid'];


     
if($pid)
{
    $patient_arr=$db->get_results("select
    p.patient_id,p.pcode,p.pname,p.sur_name,p.gender,DATE_FORMAT(p.dob,'%d-%m-%Y') as dob,p.protocol_no,p.pmail,p.authorized_by1,p.authorized_by2,p.authorized_by3,p.physician_name,p.phy_mail,p.diagnosis,p.bcr_apl,DATE_FORMAT(p.start_date,'%d-%m-%Y') as tsdate,DATE_FORMAT(p.diag_st_date,'%d-%m-%Y') as diag_stdate,p.treatment_type,

    t.test_id,DATE_FORMAT(date,'%d-%m-%Y') as test_date,t.sample_type,t.sample_sent_from,t.sample_no,t.bcr_apl_no,p.medication_id,DATE_FORMAT(p.sstart_date,'%d-%m-%Y') as stsdate,p.med_others,t.treatment_type as ttreatment_type,bcr_apl_others

     from msom_patient p
     left join msom_test t on t.patient_id=p.patient_id
     where p.patient_id=$pid and p.status='act' order by t.date asc",ARRAY_A);
    
    //echo "<pre>";
    //print_r($patient_arr);
    
    $smarty->assign('pcnt',$patient_arr[0]['test_id']?(count($patient_arr)+1):count($patient_arr));    
    $smarty->assign('patient_arr',$patient_arr);
    
}

if(!$patient_arr || !$pid)
   {
        header("location:../master/index.php");
   }

 $treatment_type_arr=treatment_type();
if($patient_arr[0]['treatment_type']=='2')
    unset($treatment_type_arr['1'],$treatment_type_arr['3']);
elseif($patient_arr[0]['treatment_type']=='3')
    unset($treatment_type_arr['1'],$treatment_type_arr['2']);

$smarty->assign('date_valid_1',$date_validation_string);
$smarty->assign('medication_arr',medication_arr());
$smarty->assign('diagnosis_arr',diagnosis_arr());
$smarty->assign('bcr_apl_stype_arr',bcr_apl_stype());
$smarty->assign('type_of_treatment_arr',$treatment_type_arr);
$smarty->assign('marr',gender_arr());
$smarty->assign('page_title','Add Patient Test');
$smarty->display('add_patient_test.tpl');
?>
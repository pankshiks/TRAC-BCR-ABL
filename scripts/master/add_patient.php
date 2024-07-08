<?PHP
ini_set('display_errors',false);
include($_SERVER['DOCUMENT_ROOT'].'/ELN/includes/layout/default_page_layout.inc');
    

$id=$_SESSION['mso_eln']['peditid'];

if($id)
{
    $patient_arr=$db->get_results("select
    patient_id,pcode,pname,sur_name,gender,DATE_FORMAT(dob,'%d-%m-%Y') as dob,protocol_no,pmail,authorized_by1,authorized_by2,authorized_by3,physician_name,phy_mail,diagnosis,bcr_apl,DATE_FORMAT(start_date,'%d-%m-%Y') as tsdate,DATE_FORMAT(diag_st_date,'%d-%m-%Y') as diag_st_date,treatment_type ,medication_id,med_others,DATE_FORMAT(sstart_date,'%d-%m-%Y') as stsdate,bcr_apl_others
     
     from msom_patient where patient_id=$id",ARRAY_A);
    
   //echo "<br><pre>";
   //print_r($patient_arr);
   if($patient_arr)
    {
        $smarty->assign('patient_arr',$patient_arr);
    }
    else
      $show_errors="<div class=error>There are no records to view...</div>";

}
else
    $smarty->assign('disabled',"disabled=\"\"");
    


 $treatment_type_arr=treatment_type();
if($patient_arr[0]['treatment_type']=='2')
    unset($treatment_type_arr['1'],$treatment_type_arr['3']);
elseif($patient_arr[0]['treatment_type']=='3')
    unset($treatment_type_arr['1'],$treatment_type_arr['2']);

$smarty->assign('date_valid_1',$date_validation_string);
$smarty->assign('show_errors',$show_errors);
$smarty->assign('default_select1','hometoplink25');
$smarty->assign('medication_arr',medication_arr());
$smarty->assign('bcr_apl_stype_arr',bcr_apl_stype());
$smarty->assign('type_of_treatment_arr',$treatment_type_arr);
$smarty->assign('diagnosis_arr',diagnosis_arr());

$smarty->assign('marr',gender_arr());
$smarty->assign('page_title','Add Patient');
$smarty->display('add_patient.tpl');
?>
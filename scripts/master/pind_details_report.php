<?PHP
ini_set('display_errors',false);
include($_SERVER['DOCUMENT_ROOT'].'/ELN/includes/layout/default_page_layout.inc');
//ini_set('display_errors',true);
//$db->debug=1;

$id=$_SESSION['mso_eln']['pviewid'];

if($id)
{
      $patient_arr=$db->get_results("select
    p.patient_id,p.pcode,p.pname,p.sur_name,p.gender,DATE_FORMAT(p.dob,'%d-%m-%Y') as dob,p.protocol_no,p.pmail,p.authorized_by1,p.authorized_by2,p.authorized_by3,p.physician_name,p.phy_mail,p.diagnosis,p.bcr_apl,DATE_FORMAT(p.start_date,'%d-%m-%Y') as tsdate,p.treatment_type,

g.remarks,DATE_FORMAT(g.report_date,'%d-%m-%Y') as edate,g.graph_id


     from msom_patient p
     join msom_graph g on g.patient_id=p.patient_id
     where p.patient_id=$id order by graph_id asc",ARRAY_A);
 
   
 
   if($patient_arr)
    {
       
         $smarty->assign('patient_arr',$patient_arr);
         $smarty->assign('pcnt',count($patient_arr));
 

    }
    else
      $show_errors="<div class=error>There are no records to view...</div>";




}

if(!$patient_arr || !$id)
   {
    header("location:../master/index.php");
   }


$smarty->assign('show_errors',$show_errors);
//$pcode_no=$db->get_var("select substr(pcode,3,10) from msom_patient order by patient_id desc")+1;

//$smarty->assign('max_ccode',('P-'.str_pad($pcode_no,3,"0",STR_PAD_LEFT)));
//$smarty->assign('bcr_apl_stype_arr',bcr_apl_stype());
//$smarty->assign('type_of_treatment_arr',treatment_type());
//$smarty->assign('marr',gender_arr());
$smarty->assign('back_button',"<input class=\"button\" type=\"button\" value=\"Back\" onclick=\"goback(".$patient_arr[0]['patient_id'].",'patient_details_report.php')\"/>");
$smarty->assign('page_title','Individual Patient Report');
$smarty->display('pind_details_report.tpl');
?>
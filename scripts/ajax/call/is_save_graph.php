<?php
include($_SERVER['DOCUMENT_ROOT'].'/ELN/includes/layout/default_page_layout.inc');
session_start();
    if($_POST['id'])
    {
        $_SESSION['mso_eln']['pviewid']=$_POST['id'];
        
        $patient_narr=$db->get_results("select p.graph_id
     from msom_patient p
     where p.patient_id=".$_POST['id']." and p.status='act' ",ARRAY_A);
   $get_treatment_type_id=$db->get_var("select treatment_type from msom_graph where patient_id=".$_POST['id']." order by graph_id desc");
    
     if($patient_narr)
     {
        if($patient_narr[0]['graph_id']=='1' && $get_treatment_type_id==$_POST['tid'])
            $arr[0]['succ']='1';
        else
            $arr[0]['salert']='1';
     }
     else
        $arr[0]['err']='This patient details already deleted';
        
    }
    else
        $arr[0]['err']='Please try again later';
    
    
echo '{"json_return_array":'.json_encode($arr).'}';    
?>
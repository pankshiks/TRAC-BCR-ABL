<?PHP
ini_set('display_errors',false);
include($_SERVER['DOCUMENT_ROOT'].'/ELN/includes/layout/default_page_layout.inc');
//ini_set('display_errors',true);
    //$db->debug=1;

 $condition.=$_POST['name']?" and (p.pname like '%".$_POST['name']."%' OR p.sur_name like '%".$_POST['name']."%')":'';
 $condition.=$_POST['dod']?" and p.diag_st_date='".GetFormattedDate($_POST['dod'])."'":'';
 $condition.=$_POST['tdate']?" and p.start_date='".GetFormattedDate($_POST['tdate'])."'":'';
 $condition.=$_POST['medic_id']?" and p.medication_id='".$_POST['medic_id']."'":'';
 $condition.=$_POST['phy_name']?" and p.physician_name='".$_POST['phy_name']."'":'';
 

    
      $patient_arr=$db->get_results("select
    p.patient_id,p.pcode,p.pname,p.sur_name,DATE_FORMAT(p.start_date,'%d-%m-%Y') as tsdate,DATE_FORMAT(p.diag_st_date,'%d-%m-%Y') as dof_diagnosis,p.medication_id,DATEDIFF('".date('Y-m-d')."',p.start_date) as treatment_time, concat(FORMAT((DATEDIFF('".date('Y-m-d')."',p.start_date)/30),1),' month(s)')  AS treatment_month
    ,p.physician_name


     from msom_patient p
   
     where p.patient_id IS NOT NULL $condition and p.status='act'  order by patient_id asc",ARRAY_A);
  
  
   if($patient_arr)
   {
  $wrcondition.=$_POST['hospital']?" where sample_sent_from='".$_POST['hospital']."'":'';
  $last_bcr_abl_arr=$db->get_results("select patient_id,bcr_apl_no,sample_sent_from as hospital from msom_test $wrcondition order by test_id asc",ARRAY_A);
  $last_graph_arr=$db->get_results("select patient_id,max(graph_id) as graph_id from msom_graph  group by patient_id ",ARRAY_A);
  if($last_graph_arr)
  {
    foreach($last_graph_arr as $lgk=>$lgv)
        $last_grapharr[$lgv['patient_id']]=$lgv['graph_id'];
    
  }
  
  if($last_bcr_abl_arr)
  {
    foreach($last_bcr_abl_arr as $lbk=>$lbv)
       {   
        $mark="";
          if($lbv['bcr_apl_no']<=0.0032)
            $mark='MR4.5';
          elseif($lbv['bcr_apl_no']<=0.01)
            $mark='MR4';
          elseif($lbv['bcr_apl_no']<=0.1)
            $mark='MMR';            
          elseif($lbv['bcr_apl_no']<1)
            $mark='CCYR';
          else
            $mark="";
            
          
            
        if(!$_POST['mstone'] || $mark==$_POST['mstone'])
        {
          $last_bcrabl_arr[$lbv['patient_id']]['bcr_apl_no']=$lbv['bcr_apl_no'];
          $last_bcrabl_arr[$lbv['patient_id']]['hospital']=$lbv['hospital'];
          $last_bcrabl_arr[$lbv['patient_id']]['milestone']=$mark;
        }
         
       }
    
  }
  

  
         
         $smarty->assign('patient_arr',$patient_arr);
         $smarty->assign('pcnt',count($patient_arr));
         $smarty->assign('last_grapharr',$last_grapharr);
         $smarty->assign('last_bcrabl_arr',$last_bcrabl_arr);
 

    }
    else
      $show_errors="<div class=error>There are no records to view...</div>";






$smarty->assign('medication_arr',medication_arr());
$smarty->assign('default_select3','hometoplink25');
$smarty->assign('show_errors',$show_errors);
$smarty->assign('page_title','Overall Patient Report');
$smarty->display('poverall_details_report.tpl');
?>
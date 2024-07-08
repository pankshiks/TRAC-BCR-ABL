<?PHP
ini_set('display_errors',false);
include($_SERVER['DOCUMENT_ROOT'].'/ELN/includes/layout/default_page_layout.inc');
//ini_set('display_errors',true);
//$db->debug=1;

$id=$_SESSION['mso_eln']['pviewid'];

if($id)
{
      $jcond=$_POST['sel_type_of_treatment']?" and t.treatment_type=".$_POST['sel_type_of_treatment']:" and t.treatment_type=p.treatment_type";
         //$db->debug_all=true;

$patient_arr=$db->get_results("select
p.patient_id,p.pcode,p.pname,p.sur_name,p.gender,DATE_FORMAT(p.dob,'%d-%m-%Y') as dob,p.protocol_no,p.pmail,p.authorized_by1,p.authorized_by2,
p.authorized_by3,p.physician_name,p.phy_mail,p.diagnosis,p.bcr_apl,p.treatment_type,

t.test_id,DATE_FORMAT(date,'%d-%m-%Y') as test_date,DATE_FORMAT(p.diag_st_date,'%d-%m-%Y') as diag_st_date,t.sample_type,t.sample_sent_from,t.sample_no,t.bcr_apl_no,t.date as gdate,DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.dob)), '%Y')+0 AS age,p.medication_id
,DATE_FORMAT(p.start_date,'%d-%m-%Y') as tsdate,p.start_date
,DATE_FORMAT(p.sstart_date,'%d-%m-%Y') as stsdate,p.sstart_date,DATE_FORMAT(t.date,'%d/%m/%Y') as dis_date


     from msom_patient p
     left join msom_test t on t.patient_id=p.patient_id $jcond
     where p.patient_id=$id and p.status='act' order by t.date asc",ARRAY_A);
     
      $patient_chk_arr=$db->get_results("select t.test_id


     from msom_patient p
      join msom_test t on t.patient_id=p.patient_id 
     where p.patient_id=$id and p.status='act' order by t.date asc",ARRAY_A);
    // echo '<pre>';
    // print_R($patient_arr);
    // $db->debug_all=true;
    // exit;
    
    
    //$tcond.=" and t.treatment_type='".($_POST['type_of_treatment']?$_POST['type_of_treatment']:$patient_arr[0]['treatment_type'])."'";
    
    $marr=gender_arr();
    $bcr_apl_stype_arr=bcr_apl_stype();
    $type_of_treatment_arr=treatment_type();
    $medication_arr=medication_arr();
    

   if($patient_arr && ($patient_arr[0]['test_id'] || $patient_chk_arr[0]['test_id']))
   {

        $body_str.="<table width=100%>
        
<tr><td width=15%><strong>Patient Name, Surname</strong></td><td width=15%> : ".$patient_arr[0]['pname'].' '.$patient_arr[0]['sur_name']."</td><td width=25%></td><td width=16%><strong>Sample Delivery date</strong></td><td width=15%> : ".date('d-m-Y')."</td></tr>
<tr><td><strong>Age / Gender</strong></td><td > : ".$patient_arr[0]['age'].'/'.$marr[$patient_arr[0]['gender']]."</td><td></td><td><strong>Report Date</strong></td><td> : <input type=\"text\" readonly=\"\" name=\"rep_date\" id=\"rep_date\" {$date_validation_string} onFocus=\"displayCalendar(document.pat_report.rep_date,'dd-mm-yyyy',this)\"  size=\"8\"  autocomplete=\"off\" value=\"".date('d-m-Y')."\" /></td></tr>
<tr><td><strong>Sent From and Dr.Name</strong></td><td > : ".$patient_arr[0]['sample_sent_from'].' / '.$patient_arr[0]['physician_name']."</td><td></td><td><strong>Hospital Id</strong></td><td> : ".$patient_arr[0]['protocol_no']."</td></tr>
<tr><td><strong>Date of diagnosis</strong></td><td > : ".$patient_arr[0]['diag_st_date']."</td><td></td><td></td><td></td></tr>
<tr><td><strong>Medication name</strong></td><td > : ".$medication_arr[$patient_arr[0]['medication_id']]."</td><td></td><td></td><td></td></tr>




        </table>";
        
        if($patient_arr[0]['test_id'])
        {
           $body_str.="<br><br><center>
        <table id=ftbl class=ntbl width=50% style='border-collapse:collapse;'>
         <tr>
        <th  class=ntbl style='width:18%'>Date of test</th>
        <th  class=ntbl>BCR-ABL1 Result % <br>(International Scale)</th>
        
        </tr>";
        
         foreach($patient_arr as $k=>$v)
        {
            $td_class='class='.($k%2?'ntd1':'ntd2');
            
            
            $body_str.=" <tr>
            <td $td_class  align=center>".($v['test_date'])."&nbsp;</td>
            <td $td_class  align=center>".($v['bcr_apl_no'])."&nbsp;</td>
            </tr>";
        }
        
         $body_str.="</table></center><br><br>";
         }
         
    
    if($_POST['sdate'] && $_POST['edate'])
        $tcond.=" and t.date between '".GetFormattedDate($_POST['sdate'])."' and '".GetFormattedDate($_POST['edate'])."'";
    else
    {
        $tcond.=$_POST['sdate']?" and t.date>='".GetFormattedDate($_POST['sdate'])."'":'';
        $tcond.=$_POST['edate']?" and t.date<='".GetFormattedDate($_POST['edate'])."'":'';
    }
    
        $tcond.=" and t.treatment_type='".($_POST['sel_type_of_treatment']?$_POST['sel_type_of_treatment']:$patient_arr[0]['treatment_type'])."'";
    
    
//$db->debug_all=true;
$patient_narr=$db->get_results("select
    p.patient_id,t.bcr_apl_no,t.date as gdate,DATE_FORMAT(t.date,'%d/%m/%Y') as dis_date


     from msom_patient p
     left join msom_test t on t.patient_id=p.patient_id
     where p.patient_id=$id and p.status='act' and t.date>='".(($_POST['sel_type_of_treatment']=='1' || (!$_POST && $patient_arr[0]['treatment_type']=='1'))?$patient_arr[0]['start_date']:$patient_arr[0]['sstart_date'])."' $tcond
     order by t.date asc",ARRAY_A);
     // echo '<pre>';
    // print_R($patient_narr);
     
    // exit;
    
    
   // exit;
     
    if($patient_narr)
    {
        foreach($patient_narr as $k=>$v)
        {

            $data_arr[0][]=$v['bcr_apl_no'];//>1000?1000:$pv['bcr_apl_no']);
            $data_arr[1][]=$v['gdate'];
            $tlast_date=$v['dis_date'];
        }
       
    $gid=base64_decode($_GET['id']);
      // if(count($data_arr[0])>1)
      // {
         $_SESSION['mso_eln']['Bcr-AplArr']=$data_arr;
         $_SESSION['mso_eln']['Bcr-AplArr'][2]=$_POST['sel_type_of_treatment']?$_POST['sel_type_of_treatment']:$patient_arr[0]['treatment_type'];
         $_SESSION['mso_eln']['Bcr-AplArr'][3]=$type_of_treatment_arr[$_POST['sel_type_of_treatment']?$_POST['sel_type_of_treatment']:$patient_arr[0]['treatment_type']];
         $_SESSION['mso_eln']['Bcr-AplArr'][4]=($_POST['sel_type_of_treatment']=='1' || (!$_POST && $patient_arr[0]['treatment_type']=='1'))?$patient_arr[0]['tsdate']:$patient_arr[0]['stsdate'];//$patient_arr[0]['test_date'];//
          $_SESSION['mso_eln']['Bcr-AplArr'][5]=$patient_narr[0]['dis_date'];
         $_SESSION['mso_eln']['Bcr-AplArr'][6]=$tlast_date;
         $_SESSION['mso_eln']['Bcr-AplArr'][7]=$_POST['sdate']?$_POST['sdate']:$_POST['sel_type_of_treatment'];
       //  exit;
         if($_POST['sdate'] && $_POST['edate'])// || $_POST['type_of_treatment'])
         {
           // echo 'min:'.min($data_arr[0]).' : max:'.max($data_arr[0]);
            
             $min=findminmax_yaxix(min($data_arr[0]));;
             $max=findminmax_yaxix(max($data_arr[0]))+1;
             //$min=($min=='0'?'-1':$min);
             $_SESSION['mso_eln']['Bcr-AplArr'][8]=$min;//($min=='0'?'-1':$min);
             $_SESSION['mso_eln']['Bcr-AplArr'][9]=($max==$min)?$max+1:$max;
         }

           //  echo '<prE>';
           //  print_R($_SESSION['mso_eln']['Bcr-AplArr']);
           //  exit;

         $smarty->assign('graph',"<img src=\"bcr_apl_graph.php\"/>");
         $ttype_id=$_POST['sel_type_of_treatment']?$_POST['sel_type_of_treatment']:$patient_arr[0]['treatment_type'];
         $smarty->assign('html_table',treatment_graph($ttype_id));
         //Reference:Baccarani M, Deininger MW,Rosti G, et al.European LeukemiaNet recommendations for the management of chronic meloid leukemia:2013. Blood 2013;122(6):872-84.doi:10.1182/blood-2013-05-501569
      // }
      }
      elseif($_POST['sdate'] && $_POST['edate'])
        $show_errors1="<div class=error>There are no records to view for the particular period...</div>";
      else
        $show_errors1="<div class=error>There are no records to view...</div>";


         $ttype_id=$gid?$gid:$patient_arr[0]['treatment_type'];
         $smarty->assign('patient_arr',$patient_arr);
         $smarty->assign('body_str',$body_str);
         $smarty->assign('gid',$gid);
         $smarty->assign('sgid',$ttype_id);
        
 


    }
    else
      $show_errors="<div class=error>There are no records to view...</div>";




}
if(!$patient_arr || !$id)
   {
    header("location:../master/index.php");
   }
/*if($_POST)
{
    if($_POST['pid'])
    {
     $patient_narr=$db->get_results("select
    p.patient_id,p.pcode,p.pname,p.sur_name,p.gender,DATE_FORMAT(p.dob,'%d-%m-%Y') as dob,p.protocol_no,p.pmail,p.authorized_by1,p.authorized_by2,p.authorized_by3,p.physician_name,p.phy_mail,p.diagnosis,p.bcr_apl,DATE_FORMAT(p.start_date,'%d-%m-%Y') as tsdate,p.treatment_type,

t.test_id,DATE_FORMAT(date,'%d-%m-%Y') as test_date,t.sample_type,t.sample_sent_from,t.sample_no,t.controlgene_no,t.conversion_fact,t.bcr_apl_no


     from msom_patient p
     left join msom_test t on t.patient_id=p.patient_id
     where p.patient_id=".$_POST['pid'],ARRAY_A);
     
     
    if($patient_narr)
    {
        foreach($patient_narr as $pkk=>$pkv)
            $data_narr[]=$pkv['bcr_apl_no'];
            
            
         $_SESSION['mso_eln']['Bcr-AplArr']=$data_narr;
         


         $get_max_id=$db->get_var("select max(graph_id) from msom_graph")+1;
         include("bcr_apl_graph.php");
      
         $insert=$db->query("insert into msom_graph(graph_id,patient_id,remarks,e_user)values($get_max_id,".$_POST['pid'].",'".$_POST['evalution']."',$guser_id);");
       
         if(in_array($insert,array('0','1')))
            $show_errors="<div class=success>Saved...</div>";
            
        
 

    }
    else
      $show_errors="<div class=error>There are no records to view...</div>";
     }
}*/


//if($id)
//$smarty->assign('alread_saved_arr',$db->get_results("select graph_id,remarks from msom_graph where patient_id=".$id." order by graph_id desc limit 1",ARRAY_A));

if($patient_arr[0]['treatment_type']=='1')
    unset($type_of_treatment_arr['2'],$type_of_treatment_arr['3']);
elseif($patient_arr[0]['treatment_type']=='2')
    unset($type_of_treatment_arr['3']);
elseif($patient_arr[0]['treatment_type']=='3')
    unset($type_of_treatment_arr['2']);
    

$smarty->assign('type_of_treatment_arr',$type_of_treatment_arr);
//else
   // $smarty->assign('type_of_treatment_arr',array('2'=>'Second line'));
    
$smarty->assign('show_errors1',$show_errors1);
$smarty->assign('show_errors',$show_errors);
$smarty->assign('is_saved',$db->get_var("select max(graph_id) from msom_graph where patient_id=".$id));
//$pcode_no=$db->get_var("select substr(pcode,3,10) from msom_patient order by patient_id desc")+1;

//$smarty->assign('max_ccode',('P-'.str_pad($pcode_no,3,"0",STR_PAD_LEFT)));
//$smarty->assign('bcr_apl_stype_arr',bcr_apl_stype());
//$smarty->assign('type_of_treatment_arr',treatment_type());
//$smarty->assign('marr',gender_arr());
//$smarty->assign('back_button',"<input class=\"button\" type=\"button\" value=\"Back\" onclick=\"goback(".$patient_arr[0]['patient_id'].",'add_patient_test.php')\"/>");

$smarty->assign('page_title','Patient Data Report');
$smarty->display('patient_details_report.tpl');
?>
<?PHP
ini_set('display_errors',false);
include($_SERVER['DOCUMENT_ROOT'].'/ELN/includes/layout/default_page_layout.inc');
//ini_set('display_errors',true);
//$db->debug=1;

$id=$_SESSION['mso_eln']['pviewid'];

if($id)
{
      $patient_arr=$db->get_results("select
    p.patient_id,p.pcode,p.pname,p.sur_name,p.gender,DATE_FORMAT(p.dob,'%d-%m-%Y') as dob,p.protocol_no,p.pmail,p.authorized_by1,p.authorized_by2,p.authorized_by3,p.physician_name,p.phy_mail,p.diagnosis,p.bcr_apl,p.treatment_type,

t.test_id,DATE_FORMAT(date,'%d-%m-%Y') as test_date,DATE_FORMAT(p.diag_st_date,'%d-%m-%Y') as diag_st_date,t.sample_type,t.sample_sent_from,t.sample_no,t.bcr_apl_no,t.date as gdate,DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.dob)), '%Y')+0 AS age,p.medication_id,DATE_FORMAT(t.date,'%d/%m/%Y') as dis_date

,DATE_FORMAT(p.start_date,'%d-%m-%Y') as tsdate,p.start_date
,DATE_FORMAT(p.sstart_date,'%d-%m-%Y') as stsdate,p.sstart_date

     from msom_patient p
     left join msom_test t on t.patient_id=p.patient_id
     where p.patient_id=$id and p.status='act' order by t.date asc",ARRAY_A);
    
    
    $type_of_treatment_arr=treatment_type();
   

   if($patient_arr && $patient_arr[0]['test_id'])
   {

   if($_POST)
   {
    if($_POST['sdate'] && $_POST['edate'])
        $tcond.=" and t.date between '".GetFormattedDate($_POST['sdate'])."' and '".GetFormattedDate($_POST['edate'])."'";
    else
    {
        $tcond.=$_POST['sdate']?" and t.date>='".GetFormattedDate($_POST['sdate'])."'":'';
        $tcond.=$_POST['edate']?" and t.date<='".GetFormattedDate($_POST['edate'])."'":'';
    }
   }
   $tcond.=" and t.treatment_type='".($_POST['type_of_treatment']?$_POST['type_of_treatment']:$patient_arr[0]['treatment_type'])."'";
   
$patient_narr=$db->get_results("select
    p.patient_id,t.bcr_apl_no,t.date as gdate,DATE_FORMAT(t.date,'%d/%m/%Y') as dis_date


     from msom_patient p
     left join msom_test t on t.patient_id=p.patient_id
     where p.patient_id=$id and p.status='act' and t.date>='".(($_POST['type_of_treatment']=='1' || (!$_POST && $patient_arr[0]['treatment_type']=='1'))?$patient_arr[0]['start_date']:$patient_arr[0]['sstart_date'])."' $tcond
     order by t.date asc",ARRAY_A);
     
    
    
      foreach($patient_narr as $k1=>$v1)
        {
            $tlast_date=$v1['dis_date'];
        }
       
    if($patient_narr)
    {
        foreach($patient_narr as $k=>$v)
        {
            $data_arr[0][]=$v['bcr_apl_no'];//>1000?1000:$pv['bcr_apl_no']);
            $data_arr[1][]=$v['gdate'];
            
        }
       
       
       
       ///$min=min($data_arr[0]);
       //$max=max($data_arr[0]);
       
      //echo "->".findminmax_yaxix(min($data_arr[0])).':'.findminmax_yaxix(max($data_arr[0]));
      //exit;
        $gid=base64_decode($_GET['id']);
      // if(count($data_arr[0])>1)
      // {
      
         unset($_SESSION['mso_eln']['Bcr-AplArr']);
         $_SESSION['mso_eln']['Bcr-AplArr']=$data_arr;
         $_SESSION['mso_eln']['Bcr-AplArr'][2]=$_POST['type_of_treatment']?$_POST['type_of_treatment']:$patient_arr[0]['treatment_type'];
         $_SESSION['mso_eln']['Bcr-AplArr'][3]=$type_of_treatment_arr[$_POST['type_of_treatment']?$_POST['type_of_treatment']:$patient_arr[0]['treatment_type']];
         $_SESSION['mso_eln']['Bcr-AplArr'][4]=$_POST['type_of_treatment']=='1' || (!$_POST && $patient_arr[0]['treatment_type']=='1')?$patient_arr[0]['tsdate']:$patient_arr[0]['stsdate'];//$patient_arr[0]['test_date'];//
         $_SESSION['mso_eln']['Bcr-AplArr'][5]=$patient_narr[0]['dis_date'];
         $_SESSION['mso_eln']['Bcr-AplArr'][6]=$tlast_date;
         $_SESSION['mso_eln']['Bcr-AplArr'][7]=$_POST['sdate']?$_POST['sdate']:$_POST['type_of_treatment'];
         if($_POST['sdate'] || $_POST['type_of_treatment'])
         {
         $min=findminmax_yaxix(min($data_arr[0]));;
         $max=findminmax_yaxix(max($data_arr[0]))+1;
         //$min=($min=='0'?'-1':$min);
         $_SESSION['mso_eln']['Bcr-AplArr'][8]=$min;//($min=='0'?'-1':$min);
         $_SESSION['mso_eln']['Bcr-AplArr'][9]=($max==$min)?$max+1:$max;
         }
         
   
       
         $smarty->assign('graph',"<img src=\"bcr_apl_graph_det.php\"/>");
         $smarty->assign('patient_arr',$patient_arr);
         
         //$ttype_id=$gid?$gid:$patient_arr[0]['treatment_type'];0-2
      // }
      }
      else
        $show_errors="<div class=error>There are no records to view...</div>";
      
 


    }
    else
      $show_errors="<div class=error>There are no records to view...</div>";




}
if(!$patient_arr || !$id)
   {
    header("location:../master/index.php");
   }







    $smarty->assign('type_of_treatment_arr',$type_of_treatment_arr);

    
$smarty->assign('show_errors',$show_errors);


$smarty->assign('page_title','Patient Individual View');
$smarty->display('ind_graph_det.tpl');
?>
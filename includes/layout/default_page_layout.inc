<?php
ini_set('display_errors',false);  
session_start();
date_default_timezone_set('Asia/Calcutta');

  if(!$_SESSION['mso_eln']["guser_id"])
    {
        $msg=("Login+time+out+");
       	$msg=urlencode(base64_encode($msg));
        header("location:../../index.php?msg=$msg");
    }
    



include($_SERVER['DOCUMENT_ROOT'].'/ELN/includes/cosmic/functions.inc');
include($_SERVER['DOCUMENT_ROOT'].'/ELN/includes/ezsql/ezsql_conn.inc');
include($_SERVER['DOCUMENT_ROOT'].'/ELN/includes/Smarty306/libs/Smarty.class.php');
//include("xajax0.5/xajax_core/xajax.inc.php");
//include("cosmic/ferror.inc");
//  include("cosmic/gerror.inc");

    $guser_id=$_SESSION['mso_eln']["guser_id"];
    $guser_name=$_SESSION['mso_eln']["guser_name"];
    $gucat_id=$_SESSION['mso_eln']["gcategory_id"];
    $gucat_name=$_SESSION['mso_eln']["gcategory"];
   


//$page->header_path="../../";
//$report = new cReport();
//$report->sql=$sql;
//$report->db=$db;
//$guser_id=$_SESSION["guser_id"];
$sw_vendor="Minerva Soft - ";

//$smarty = new Smarty;





$smarty=new Smarty();
$smarty->allow_php_tag = true ;
//$smarty->force_compile = true;
//$smarty->debugging = true;
$smarty->caching = false;

//$smarty->cache_lifetime = 120;
$smarty->template_dir = "../templates";
$smarty->compile_dir = "../templates_c";

if($_SESSION['mso_eln']['pviewid'])
{
    $dob=$db->get_var("select DATE_FORMAT(dob,'%d-%m-%Y') from msom_patient where patient_id=".$_SESSION['mso_eln']['pviewid']);
    $val=" var d=CompareDates(this.value,'$dob','-');if (d==0){alert('Selected Date cannot be before date of birth');this.value=''};";
        
}

//onchange="var c=CompareDates('{date('d-m-Y')}',this.value,'-');if(c==0){ldelim}alert('Selected Date cannot be on future date');this.value=''{rdelim}; var c=CompareDates(this.value,'{$patient_arr[0]['dob']}','-');if(c==0){ldelim}alert('Selected Date cannot be before date of birth');this.value=''{rdelim};"


$date_validation_string="onchange=\"var c=CompareDates('".date('d-m-Y')."',this.value,'-');if (c==0){alert('Selected Date cannot be on future date');this.value=''}; $val \""
?>
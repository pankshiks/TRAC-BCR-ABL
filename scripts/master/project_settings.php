<?PHP
ini_set('display_errors',false);
include($_SERVER['DOCUMENT_ROOT'].'/ELN/includes/layout/default_page_layout.inc');
//$db->debug=1;


    $report_arr=$db->get_results("select user_name,access_code,institution,sprocedure,mail_server,mail_port,mail_uname,mail_pword,mail_sender,mail_subject from msom_settings where sid=1",ARRAY_A);
    
   //echo "<br><pre>";
   //print_r($report_arr);
   if($report_arr)
    {
        $smarty->assign('report_arr',$report_arr);
    }
   


$smarty->assign('show_errors',$show_errors);

$smarty->assign('page_title','Settings');
$smarty->display('project_settings.tpl');
?>
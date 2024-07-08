<?PHP
ini_set('display_errors',false);
include($_SERVER['DOCUMENT_ROOT'].'/ELN/includes/layout/default_page_layout.inc');
//ini_set('display_errors',true);


$smarty->assign('page_title','Welcome to Home page');
$smarty->assign('default_select','hometoplink25');
$smarty->display('index.tpl');
?>
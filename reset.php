<?php
include($_SERVER['DOCUMENT_ROOT'].'/ELN/includes/ezsql/ezsql_conn.inc');
ini_set('display_errors',false);
//require 'class.phpmailer.php';
 //echo $_SERVER['DOCUMENT_ROOT'].'/ELN/includes/layout/default_page_layout.inc';
 
if(trim($_POST['mail']) && trim($_POST['uname']) && trim($_POST['pword']) && trim($_POST['cpword']))
{

if(!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL) === false)
{
      $master_arr=$db->get_results("select sid from msom_settings where mail_uname='".trim($_POST['mail'])."' and user_name='".trim($_POST['uname'])."'",ARRAY_A);
      
    
    if($master_arr)
    {
        
    if($_POST['pword']==$_POST['cpword'])
    {
  
    $pword=SHA1($_POST['cpword']);
    
    $update="update msom_settings set access_code='$pword' where sid=".$master_arr[0]['sid'];
        
        if(!$db->query($update))
            $arr[0]['err']="Something went wrong please contact admin";
        else
            $arr[0]['succ']="Your password has been reset successfully";

    }
    else
        $arr[0]['err']="New Password and Confirm Password doesn't match";
    
     }
    else
        $arr[0]['err']="Please check the E-Mail ID and User Name";
}
else
    $arr[0]['err']='Please enter a valid mail id';
    

}
else
    $arr[0]['err']='Please fill all the fields';
    
    
    echo '{"json_return_array":'.json_encode($arr).'}';    
    
    
?>
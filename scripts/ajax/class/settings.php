<?php
class ProjectSettings
{
function insert()
{
global $db,$guser_id;

        	
   //   print_R($_POST);
      
    //$db->debug_all=true;
    //$db->show_errors();
   // $db->escape();
       $db->query('begin');
     
     if(trim($_POST['def_password']))
     {
        $def_pword=SHA1(trim($_POST['def_password']));

            $default_access_code=$db->get_var("select access_code from msom_settings where sid=1");
            if($default_access_code==$def_pword)
            {
                if(trim($_POST['new_password']))
                {
                    if($_POST['new_password']==$_POST['re_new_password'])
                    {
                        $update_str=",access_code='".SHA1($_POST['new_password'])."'";
                    }
                    else
                    {
                        $arr[0]['err']='Please verify the new password';
                        $error='1';
                    }
                }
                
                
                
                
if(!$error)
{
    $update=$db->query("update msom_settings set user_name='".$_POST['luname']."',institution='".$_POST['instit']."',sprocedure='".$_POST['pro_dure']."',mail_server='".$_POST['mserver']."',mail_port='".$_POST['mport']."',mail_uname='".$_POST['musername']."',mail_pword='".$_POST['mail_password']."',mail_sender='".$_POST['msender']."',mail_subject='".$_POST['msubject']."',e_user=$guser_id$update_str where sid=1 ");
                
                
               
                if(in_array($update,array('0','1')))
                {
                    $db->query('commit;');
                    $arr[0]['succ']='Settings updated successfully';
                }
                else
                {
                    $db->query('rollback;');
                    $arr[0]['err']='Please try again later';
                }
}
            }
            else
                $arr[0]['err']="Default password mismatch";

     }
     else
        $arr[0]['err']="Please enter your default password";


  
 
  
echo '{"json_return_array":'.json_encode($arr).'}';    
}


}
?>
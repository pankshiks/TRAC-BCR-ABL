<?php

session_start();
if($_SESSION['mso_eln']['pviewid'])
    $arr[0]['succ']=$_SESSION['mso_eln']['pviewid'];
else
{
    unset($_SESSION['mso_eln']['pviewid']);
    $arr[0]['err']='Please try again later...';
}
    

echo '{"json_return_array":'.json_encode($arr).'}';    
?>
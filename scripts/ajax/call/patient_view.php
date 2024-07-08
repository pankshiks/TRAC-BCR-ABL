<?php
if($_POST['pid'])
{
session_start();
$_SESSION['mso_eln']['pviewid']=$_POST['pid'];
$arr[0]['succ']=$_POST['pid'];
}
else
    $arr[0]['err']='Please try again later...';
    

echo '{"json_return_array":'.json_encode($arr).'}';    
?>
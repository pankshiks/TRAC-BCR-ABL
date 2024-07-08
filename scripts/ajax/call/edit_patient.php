<?php
if($_POST['id'])
{
    session_start();
    $_SESSION['mso_eln']['peditid']=$_POST['id'];
    $arr[0]['succ']=$_POST['id'];
    echo '{"json_return_array":'.json_encode($arr).'}';
}
?>
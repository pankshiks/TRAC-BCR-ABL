<?php
session_start();
unset($_SESSION['mso_eln']['pviewid']);
$_SESSION['mso_eln']['pviewid']=$_POST['id'];     

?>
<?php
session_start();
unset($_SESSION['mso_eln']);
session_destroy();


	$msg=("You+have+been+successfully+logged+out");
	$msg=urlencode(base64_encode($msg));
	header("Location:../../../index.php?msg=$msg");
	exit;

?>

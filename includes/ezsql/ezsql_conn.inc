<?php
    include_once "ez_sql_core.php";
	include_once "ez_sql_mysql.php";
	$db = new ezSQL_mysql('root','admin123','medtrix_eln','localhost:4308');
    ini_set('display_errors',false);
?>
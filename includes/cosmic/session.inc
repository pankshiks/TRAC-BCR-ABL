<?php
/* =============================================================================
 File Name    : global_session.php
 Created on   : 23.09.2007
 Created By   :
 Modified  on :
 Modified By  :
 Purpose      :
 Notes        :
/==============================================================================*/

session_start();
if($_SESSION["cache"]["page"] !=$_SERVER["PHP_SELF"] || $_POST || !$_GET)
        {
        unset($_SESSION["cache"]);
        }
list($usec, $sec) = explode(" ", microtime());
$startTime=((float)$usec + (float)$sec);
?>

<?php
include($_SERVER['DOCUMENT_ROOT'].'/ELN/includes/layout/default_page_layout.inc');
include('../class/settings.php');

$add_pat = new ProjectSettings();
$add_pat->insert();
?>
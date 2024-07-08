<?php
include($_SERVER['DOCUMENT_ROOT'].'/ELN/includes/layout/default_page_layout.inc');
include('../class/add_patient.php');

$add_pat = new AddPatient();
$add_pat->remove_test();
?>
<?php

        include($_SERVER['DOCUMENT_ROOT'].'/ELN/includes/layout/default_page_layout.inc');
        unset($_SESSION['mso_eln']['pviewid'],$_SESSION['mso_eln']['peditid']);
        echo $_POST['id'];
?>
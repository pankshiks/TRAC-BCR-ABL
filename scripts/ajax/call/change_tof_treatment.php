<?php

if($_POST['id'])
{
    $arr[0]['succ']='patient_details_report.php?id='.base64_encode($_POST['id']);
   
}
else
    $arr[0]['err']='1';
    
 echo '{"json_return_array":'.json_encode($arr).'}';    


?>
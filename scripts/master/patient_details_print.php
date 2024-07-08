<?PHP
ini_set('display_errors',false);
session_start();
 if(!$_SESSION['mso_eln']["guser_id"])
    {
        $msg=("Login+time+out+.");
       	$msg=urlencode(base64_encode($msg));
        header("location:../../index.php?msg=$msg");
    }
include($_SERVER['DOCUMENT_ROOT'].'/ELN/includes/ezsql/ezsql_conn.inc');
include($_SERVER['DOCUMENT_ROOT'].'/ELN/includes/cosmic/functions.inc');
//$db->debug=1;

$id=$_SESSION['mso_eln']['pviewid'];

if($id)
{
      $patient_arr=$db->get_results("select
    p.patient_id,p.pcode,p.pname,p.sur_name,p.gender,DATE_FORMAT(p.dob,'%d-%m-%Y') as dob,p.protocol_no,p.pmail,p.authorized_by1,p.authorized_by2,p.authorized_by3,p.physician_name,p.phy_mail,p.diagnosis,p.bcr_apl,DATE_FORMAT(p.start_date,'%d-%m-%Y') as tsdate,p.treatment_type,
    
    t.test_id,DATE_FORMAT(date,'%d-%m-%Y') as test_date,t.sample_type,t.sample_sent_from,t.sample_no,t.bcr_apl_no,DATE_FORMAT(p.diag_st_date,'%d-%m-%Y') as diag_st_date,p.medication_id,p.bcr_apl_others


     from msom_patient p
     left join msom_test t on t.patient_id=p.patient_id
     where p.patient_id=$id",ARRAY_A);
    
  
   if($patient_arr)
    {
        $marr=gender_arr();
        $bcr_apl_stype_arr=bcr_apl_stype();
        $type_of_treatment_arr=treatment_type();
        $diagnosis_arr=diagnosis_arr();  
        $medication_arr=medication_arr();
        
        
        
?>
<style type="text/css">
tr{
    height: 26px;
    
}
td{
    /*border: 1px;
    border-top-style: solid;
    border-right-style: solid;
    border-bottom-style: solid;
    border-left-style: solid;*/
    font-size: 13px;
    
}
th{
    text-align: center;
}
</style>
<title>Patient Details - Print</title>
<body onload="print();"> 
<div style="width: 98.5%;">


<center><h3>Patient Details</h3></center>
        <table width="100%" style="border:1px solid;">
        
<tr><td width="18%">Name</td><td width="30%"> :<strong><?php echo $patient_arr[0]['pname']; ?></strong></td><td width="30%">Physician's name</td><td width="22%"> : <strong><?php echo $patient_arr[0]['physician_name']; ?></strong></td></tr>
<tr><td>Surname</td><td > : <strong><?php echo $patient_arr[0]['sur_name']; ?></strong></td><td>Physician's e-mail address</td><td> : <strong><?php echo $patient_arr[0]['phy_mail']; ?></strong></td></tr>
<tr><td>Gender</td><td > : <strong><?php echo $marr[$patient_arr[0]['gender']]; ?></strong></td><td>The diagnosis and the phase at the time of diagnosis</td><td > : <strong><?php echo $diagnosis_arr[$patient_arr[0]['diagnosis']]; ?></strong></td></tr>
<tr><td>Date of birth</td><td > : <strong><?php echo $patient_arr[0]['dob']; ?></strong></td><td>BCR-ABL transcript subtype</td><td> : <strong><?php echo $bcr_apl_stype_arr[$patient_arr[0]['bcr_apl']]; ?></strong><br /><?php echo $patient_arr[0]['bcr_apl_others']; ?></td></tr>
<tr><td>Hospital ID</td><td > : <strong><?php echo $patient_arr[0]['protocol_no']; ?></strong></td><td>Date of diagnosis</td><td> : <strong><?php echo $patient_arr[0]['diag_st_date']; ?></strong></td></tr>
<tr><td>Patient's e-mail address</td><td > : <strong><?php echo $patient_arr[0]['pmail']; ?></strong></td><td>Medication name</td><td> : <strong><?php echo $medication_arr[$patient_arr[0]['medication_id']]; ?></strong></td></tr>
<tr><td>Report authorized by</td><td> : <strong><?php echo $patient_arr[0]['authorized_by1']; ?></strong></td><td>Treatment start date</td><td>: <strong><?php echo $patient_arr[0]['tsdate']; ?></strong></td></tr>
<tr><td>Report authorized by</td><td> : <strong><?php echo $patient_arr[0]['authorized_by2']; ?></strong></td><td>Type of treatment</td><td> : <strong><?php echo $type_of_treatment_arr[$patient_arr[0]['treatment_type']]; ?></strong></td></tr>
<tr><td>Report authorized by</td><td> : <strong><?php echo $patient_arr[0]['authorized_by3']; ?></strong></td><td></td><td></td></tr>


  
 
        </table><br />
        <table width="100%" style="border:1px solid black;border-collapse:collapse;">
        <tr>
        <th style="border:1px solid black;">#</th>
        <th style="border:1px solid black;">Date of Test</th>
        <th style="border:1px solid black;">Sample Type</th>
        <th style="border:1px solid black;">Sample sent from<br />(Hospital)</th>
        <th style="border:1px solid black;">Sample #</th>
        <th style="border:1px solid black;">BCR-ABL1 Result %<br />(International Scale)</th>
        
        
        
        
         	 	 	 	 	 	 	
        <?php

       
        foreach($patient_arr as $k=>$v)
        {
            
        echo "<tr><td style=\"border:1px solid black;\" align=center>".($k+1)."</td>
        <td style=\"border:1px solid black;\" align=center>".($v['test_date'])."</td>
        <td style=\"border:1px solid black;\">".($v['sample_type'])."</td>
        <td style=\"border:1px solid black;\">".($v['sample_sent_from'])."</td>
        <td style=\"border:1px solid black;\" align=center>".($v['sample_no'])."</td>
        <td style=\"border:1px solid black;\" align=center>".($v['bcr_apl_no'])."</td></tr>";
        
            
        }
        ?>
        </table>

</div>
        </body>
        <?php

    }
    else
      $show_errors="<div class=error>There are no records to view...</div>";

}


$smarty->assign('show_errors',$show_errors);
//$pcode_no=$db->get_var("select substr(pcode,3,10) from msom_patient order by patient_id desc")+1;

//$smarty->assign('max_ccode',('P-'.str_pad($pcode_no,3,"0",STR_PAD_LEFT)));
$smarty->assign('bcr_apl_stype_arr',bcr_apl_stype());
$smarty->assign('type_of_treatment_arr',treatment_type());
$smarty->assign('marr',gender_arr());
$smarty->assign('page_title','Add Patient');
$smarty->display('add_patient.tpl');
?>
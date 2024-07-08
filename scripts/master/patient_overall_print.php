<?PHP
ini_set('display_errors',false);
include($_SERVER['DOCUMENT_ROOT'].'/ELN/includes/layout/default_page_layout.inc');
//ini_set('display_errors',true);

  
      
    $condition.=$_POST['pcode'] && $_POST['pcode']!='undefined'?" and p.pcode like '%".$_POST['pcode']."%'":'';
    $condition.=$_POST['name'] && $_POST['name']!='undefined'?" and p.pname like '%".$_POST['name']."%'":'';
    $condition.=$_POST['surname'] && $_POST['surname']!='undefined'?" and p.sur_name like '%".$_POST['surname']."%'":'';
    $condition.=$_POST['gender'] && $_POST['gender']!='undefined'?" and p.gender like '%".$_POST['gender']."%'":'';    
    $condition.=$_POST['dob'] && $_POST['dob']!='undefined'?" and p.dob='".GetFormattedDate($_POST['dob'])."'":'';
    $condition.=$_POST['prot_no'] && $_POST['prot_no']!='undefined'?" and p.protocol_no like '%".$_POST['prot_no']."%'":'';
    
    $condition.=$_POST['pemail'] && $_POST['pemail']!='undefined'?" and p.pmail like '%".$_POST['pemail']."%'":'';
    $condition.=$_POST['authorized1'] && $_POST['authorized1']!='undefined'?" and p.authorized_by1 like '%".$_POST['authorized1']."%'":'';
    $condition.=$_POST['phy_name'] && $_POST['phy_name']!='undefined'?" and p.physician_name like '%".$_POST['phy_name']."%'":'';
    $condition.=$_POST['phy_mail'] && $_POST['phy_mail']!='undefined'?" and p.phy_mail like '%".$_POST['phy_mail']."%'":'';
    $condition.=$_POST['diag'] && $_POST['diag']!='undefined'?" and p.diagnosis like '%".$_POST['diag']."%'":'';
    $condition.=$_POST['bcr_apl_stype'] && $_POST['bcr_apl_stype']!='undefined'?" and p.bcr_apl like '%".$_POST['bcr_apl_stype']."%'":'';
    $condition.=$_POST['tsdate'] && $_POST['tsdate']!='undefined'?" and p.start_date='".GetFormattedDate($_POST['tsdate'])."'":'';
    $condition.=$_POST['type_of_treatment'] && $_POST['type_of_treatment']!='undefined'?" and p.treatment_type like '%".$_POST['type_of_treatment']."%'":'';

    $patient_arr=$db->get_results("select
    p.patient_id,p.pcode,p.pname,p.sur_name,p.gender,DATE_FORMAT(p.dob,'%d-%m-%Y') as dob,p.protocol_no,p.pmail,p.authorized_by1,p.authorized_by2,p.authorized_by3,p.physician_name,p.phy_mail,p.diagnosis,p.bcr_apl,DATE_FORMAT(p.start_date,'%d-%m-%Y') as tsdate,p.treatment_type,p.bcr_apl_others
    
     from msom_patient p
     where p.status='act' $condition ",ARRAY_A);
     if($patient_arr)
     {
        
         $marr=gender_arr();
        $bcr_apl_stype_arr=bcr_apl_stype();
        $type_of_treatment_arr=treatment_type();
        $diagnosis_arr=diagnosis_arr();
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
    
}
</style>
<title>Patient Report - Print</title>
<body onload="print();">
<center><h3>Patient Report</h3></center>
        <table style="border:1px solid black;border-collapse:collapse;">
        <tr>
       
        <th style='border:1px solid black;'>Name</th>
        <th style='border:1px solid black;'>Surname</th>
        <th style='border:1px solid black;'>Gender</th>
        <th style='border:1px solid black;'>DOB</th>
        <th style='border:1px solid black;'>Hospital ID</th>
        <th style='border:1px solid black;'>Patient's e-mail address</th>
        <th style='border:1px solid black;'>Report authorized by</th>
        <th style='border:1px solid black;'>Report authorized by</th>
        <th style='border:1px solid black;'>Report authorized by</th>
        <th style='border:1px solid black;'>Physician's name</th>
        <th style='border:1px solid black;'>Physician's e-mail address</th>
        <th style='border:1px solid black;'>The diagnosis and the phase at the time of diagnosis</th>
        <th style='border:1px solid black;'>BCR-ABL transcript subtype</th>
        <th style='border:1px solid black;'>Treatment start date</th>
        <th style='border:1px solid black;'>Type of treatment</th></tr>
        <?php
        foreach($patient_arr as $pk=>$pv)
        {
  echo "<tr>
        
        <td style='border:1px solid black;'>".$pv['pname']."</td>
        <td style='border:1px solid black;'>".$pv['sur_name']."</td>
        <td style='border:1px solid black;'>".$marr[$pv['gender']]."</td>
        <td style='border:1px solid black;'>".$pv['dob']."</td>
        <td style='border:1px solid black;'>".$pv['protocol_no']."</td>
        <td style='border:1px solid black;'>".$pv['pmail']."</td>
        <td style='border:1px solid black;'>".$pv['authorized_by1']."</td>
        <td style='border:1px solid black;'>".$pv['authorized_by2']."</td>
        <td style='border:1px solid black;'>".$pv['authorized_by3']."</td>
        <td style='border:1px solid black;'>".$pv['physician_name']."</td>
        <td style='border:1px solid black;'>".$pv['phy_mail']."</td>
        <td style='border:1px solid black;'>".$diagnosis_arr[$pv['diagnosis']]."</td>
        <td style='border:1px solid black;'>".$bcr_apl_stype_arr[$pv['bcr_apl']].($pv['bcr_apl_others']?'<br>'.$pv['bcr_apl_others']:'')."</td>
        <td style='border:1px solid black;'>".$pv['tsdate']."</td>
        <td style='border:1px solid black;'>".$type_of_treatment_arr[$pv['treatment_type']]."</td>
        </tr>";
        }
        ?>
        
        </table>
        </body>
        <?php
       
     }
   
  
    

?>
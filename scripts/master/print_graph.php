<link href="../../style/minerv_stylesheet.css" rel="stylesheet" type="text/css" />
<?php
ini_set('display_errors',false);
include($_SERVER['DOCUMENT_ROOT'].'/ELN/includes/layout/default_page_layout.inc');
//ini_set('display_erros',true);

$id=$_SESSION['mso_eln']['pviewid'];
if($id)
{
    //$db->debug_all=true;
      
     $get_max_id=$db->get_var("select max(graph_id) from msom_graph where patient_id=".$id);
     $report_date_rem_arr=$db->get_results("select DATE_FORMAT(report_date,'%d-%m-%Y') as rdate,remarks,treatment_type  from msom_graph where graph_id=".$get_max_id,ARRAY_A);
    // print_R($report_date_rem_arr);
      
    
 $patient_arr=$db->get_results("select
    p.patient_id,p.pcode,p.pname,p.sur_name,p.gender,DATE_FORMAT(p.dob,'%d-%m-%Y') as dob,p.protocol_no,p.pmail,p.authorized_by1,p.authorized_by2,p.authorized_by3,p.physician_name,p.phy_mail,p.diagnosis,p.bcr_apl,DATE_FORMAT(p.start_date,'%d-%m-%Y') as tsdate,p.treatment_type,DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.dob)), '%Y')+0 AS age,

t.test_id,DATE_FORMAT(date,'%d-%m-%Y') as test_date,t.sample_type,t.sample_sent_from,t.sample_no,t.controlgene_no,t.conversion_fact,t.bcr_apl_no,DATE_FORMAT(p.diag_st_date,'%d-%m-%Y') as diag_stdate,p.medication_id,t.treatment_type as ttreatment_type


     from msom_patient p
     join msom_test t on t.patient_id=p.patient_id and t.treatment_type=".($_POST['ttype']?$_POST['ttype']:$report_date_rem_arr[0]['treatment_type'])."
     where p.patient_id=$id order by t.date asc",ARRAY_A);
   
   
 
  
   if($patient_arr)
    {
        
        
        
        $marr=gender_arr();
        $bcr_apl_stype_arr=bcr_apl_stype();
        $type_of_treatment_arr=treatment_type();
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
    border-left-style: solid; "*/
    
}
</style>
<title>Patient Details - Print</title>
<body><!-- onload="print();"-->
<style type="text/css">
#ftbl th{
 
    padding: 0 2px;
    table-layout:fixed;
    border-style:solid; 
    border-width:1px; 
    border-collapse:separate;
    border-spacing:1px;
}
#ftbl td{
 
    padding: 0 2px;
    table-layout:fixed;
    border-style:solid; 
    border-width:1px; 
    border-collapse:separate;
    border-spacing:1px;
}</style>
<center><h2>Patient Details</h2></center>
        <table width="100%" style="">
        
<tr><td width="15%">Patient Name, Surname</td><td width="15%">: <strong><?php echo $patient_arr[0]['pname'].' '.$patient_arr[0]['sur_name']; ?></strong></td><td width="47%"></td><td width="16%">Sample Delivery date</td><td width="15%">: <strong><?php echo date('d-m-Y'); ?></strong></td></tr>
<tr><td>Age / Gender</td><td>: <strong><?php echo $patient_arr[0]['age'].'/'.$marr[$patient_arr[0]['gender']]; ?></strong></td><td></td><td>Report Date</td><td>: <strong><?php echo $report_date[0]['rdate']; ?></strong></td></tr>
<tr><td>Sent From and Dr.Name</td><td>: <strong><?php echo $patient_arr[0]['sample_sent_from'].' / '.$patient_arr[0]['physician_name']; ?></strong></td><td></td><td>Hospital Id</td><td >: <strong><?php echo $patient_arr[0]['protocol_no']; ?></strong></td></tr>
<tr><td>Date of diagnosis</td><td>: <strong><?php echo $patient_arr[0]['diag_stdate']; ?></strong></td><td></td><td></td><td></td></tr>
<tr><td>Medication name</td><td>: <strong><?php echo $medication_arr[$patient_arr[0]['medication_id']]; ?></strong></td><td></td><td></td><td></td></tr>


        </table><br />
        <table id="ftbl"class="ntbl" align="center" style='border-collapse:collapse;' width="50%">
        <tr>
        <th class="ntbl" width="20%">Date of Test</th>
        <th class="ntbl">BCR-ABL1 Result %
(International Scale)</th></tr>
         	 	 	 	 	 	 	
        <?php

       
        foreach($patient_arr as $k=>$v)
        {
            $td_class='class='.($k%2?'ntd1':'ntd2');
        echo "<tr>
        <td $td_class align=center>".($v['test_date'])."&nbsp;</td>
        <td $td_class align=center>".($v['bcr_apl_no'])."&nbsp;</td></tr>";
        
            
        }
        ?>
        </table>
        </body><br />
        <?php

    
    /*
        foreach($patient_arr as $pk=>$pv)
        {
            $data_arr[0][]=$pv['bcr_apl_no'];
            $data_arr[1][]=$pv['test_date'];
        }
            
            
         $_SESSION['mso_eln']['Bcr-AplArr']=$data_arr;*/
           
           
         
           $image_file ="./graph/$get_max_id.png";
        echo "<table id=ftbl width=100%><tr><th>Start Date</th><td>".$_GET['sdate']."</td><th>End Date</th><td>".$_GET['edate']."</td><th>Treatment Type</th><td>".$type_of_treatment_arr[$_GET['ttype']]."</td></tr></table>
        <center><img src=\"$image_file\"/><br>
        ".treatment_graph($report_date_rem_arr[0]['treatment_type'])."<br> Reference: Baccarani M, Deininger MW,Rosti G, et al.European LeukemiaNet recommendations for the management of chronic myeloid leukemia:2013. Blood 2013;122(6):872-84.doi:10.1182/blood-2013-05-501569 </center>\n &nbsp;<b>Evaluation of the report :</b>".$report_date_rem_arr[0]['remarks'];
 

    }
    }
    
?>

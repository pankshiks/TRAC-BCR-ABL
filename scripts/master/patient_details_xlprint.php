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
        
    require_once($_SERVER['DOCUMENT_ROOT'].'/ELN/includes/excel1.7.7/Classes/PHPExcel.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/ELN/includes/excel1.7.7/Classes/PHPExcel/IOFactory.php');
        
       
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->createSheet(1);
            $objPHPExcel->getSheet(1)->setTitle("sheet_1");
            $objPHPExcel->setActiveSheetIndex("1");    
 
    /*$objPHPExcel->getProperties()->setCreator("Medtrix");
    $objPHPExcel->getProperties()->setLastModifiedBy("Medtrix");
    $objPHPExcel->getProperties()->setTitle("Office 2007 report");
    $objPHPExcel->getProperties()->setSubject("Office 2007 report");
    $objPHPExcel->getProperties()->setDescription("report");
    $objPHPExcel->getProperties()->setKeywords("Office 2007");
    $objPHPExcel->getProperties()->setCategory("report");*/
   // $objPHPExcel->setActiveSheetIndex(0);    

$objPHPExcel->getActiveSheet()->getStyle()->getFont()->setSize(12);
 ///////////////////////////////////Head//////////////////////////////
 
 $objPHPExcel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
 $objPHPExcel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
 $objPHPExcel->getActiveSheet()->setCellValue('D1','Patient Details');
 $objPHPExcel->getActiveSheet()->mergeCells("D1:I2"); 
 $objPHPExcel->getActiveSheet()->getStyle("D1:I2")->getFont()->setSize(14.5);
 $objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
 
  $row=4;
  $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,'Name');
  $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,' : ');
  $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$patient_arr[0]['pname']);
  $objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getFont()->setBold(true);
  
  $objPHPExcel->getActiveSheet()->setCellValue('H'.$row,"Physician's name");
  $objPHPExcel->getActiveSheet()->setCellValue('K'.$row,':');
  $objPHPExcel->getActiveSheet()->setCellValue('L'.$row,$patient_arr[0]['physician_name']);
  $objPHPExcel->getActiveSheet()->getStyle('L'.$row)->getFont()->setBold(true);
  $row++;
  
  $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,'Surname');
  $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,' : ');
  $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$patient_arr[0]['sur_name']);
  $objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getFont()->setBold(true);
  
  $objPHPExcel->getActiveSheet()->setCellValue('H'.$row,"Physician's e-mail address");
  $objPHPExcel->getActiveSheet()->setCellValue('K'.$row,':');
  $objPHPExcel->getActiveSheet()->setCellValue('L'.$row,$patient_arr[0]['phy_mail']);
  $objPHPExcel->getActiveSheet()->getStyle('L'.$row)->getFont()->setBold(true);
  $row++;
    
  $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,'Gender');
  $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,' : ');
  $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$marr[$patient_arr[0]['gender']]);
  $objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getFont()->setBold(true);
  
  $objPHPExcel->getActiveSheet()->setCellValue('H'.$row,"The diagnosis and the phase at the time of diagnosis");
  $objPHPExcel->getActiveSheet()->getStyle('H'.$row)->getAlignment()->setWrapText(true); 
  $objPHPExcel->getActiveSheet()->mergeCells("H$row:J$row");
  $objPHPExcel->getActiveSheet()->setCellValue('K'.$row,':');
  $objPHPExcel->getActiveSheet()->setCellValue('L'.$row,$diagnosis_arr[$patient_arr[0]['diagnosis']]);
  $objPHPExcel->getActiveSheet()->getStyle('L'.$row)->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(28);
  $row++;
    
  $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,'Date of birth');
  $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,' : ');
  $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$patient_arr[0]['dob']);
  $objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getFont()->setBold(true);
  
  $objPHPExcel->getActiveSheet()->setCellValue('H'.$row,"BCR-ABL transcript subtype");
  $objPHPExcel->getActiveSheet()->setCellValue('K'.$row,':');
  $objPHPExcel->getActiveSheet()->setCellValue('L'.$row,$bcr_apl_stype_arr[$patient_arr[0]['bcr_apl']].($patient_arr[0]['bcr_apl_others']?' - '.$patient_arr[0]['bcr_apl_others']:''));
  $objPHPExcel->getActiveSheet()->getStyle('L'.$row)->getFont()->setBold(true);
  $row++;
  
  

 $objPHPExcel->getActiveSheet()->getStyle("A$row:L$row")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
 
  $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,'Hospital ID');
  $objPHPExcel->getActiveSheet()->mergeCells("A$row:B$row");
  $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,' : ');
  $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$patient_arr[0]['protocol_no']);
  $objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getFont()->setBold(true);
  
 $objPHPExcel->getActiveSheet()->setCellValue('H'.$row,"Date of diagnosis");
  $objPHPExcel->getActiveSheet()->setCellValue('K'.$row,':');
  $objPHPExcel->getActiveSheet()->setCellValue('L'.$row,$patient_arr[0]['diag_st_date']);
  $objPHPExcel->getActiveSheet()->getStyle('L'.$row)->getFont()->setBold(true);

  $row++;
  
     
  $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,"Patient's e-mail address");
  $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,' : ');
  $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$patient_arr[0]['pmail']);
  $objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getFont()->setBold(true);
  
  $objPHPExcel->getActiveSheet()->setCellValue('H'.$row,"Medication name");
  $objPHPExcel->getActiveSheet()->setCellValue('K'.$row,':');
  $objPHPExcel->getActiveSheet()->setCellValue('L'.$row,$medication_arr[$patient_arr[0]['medication_id']]);
  $objPHPExcel->getActiveSheet()->getStyle('L'.$row)->getFont()->setBold(true);
  $row++;
  
     
  $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,'Report authorized by');
  $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,' : ');
  $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$patient_arr[0]['authorized_by1']);
  $objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getFont()->setBold(true);
   $objPHPExcel->getActiveSheet()->setCellValue('H'.$row,"Treatment start date");
  $objPHPExcel->getActiveSheet()->setCellValue('K'.$row,':');
  $objPHPExcel->getActiveSheet()->setCellValue('L'.$row,$patient_arr[0]['tsdate']);
  $objPHPExcel->getActiveSheet()->getStyle('L'.$row)->getFont()->setBold(true);
  
   $row++;
  
      
  $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,'Report authorized by');
  $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,' : ');
  $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$patient_arr[0]['authorized_by2']);
  $objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getFont()->setBold(true);
   $objPHPExcel->getActiveSheet()->setCellValue('H'.$row,"Type of treatment");
  $objPHPExcel->getActiveSheet()->setCellValue('K'.$row,':');
  $objPHPExcel->getActiveSheet()->setCellValue('L'.$row,$type_of_treatment_arr[$patient_arr[0]['treatment_type']]);
  $objPHPExcel->getActiveSheet()->getStyle('L'.$row)->getFont()->setBold(true);
  
  $row++;
      
  $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,'Report authorized by');
  $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,' : ');
  $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$patient_arr[0]['authorized_by3']);
  $objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getFont()->setBold(true);
  
  $row++;
  
  $objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(31);
  $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(6);
  $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(17);
  $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(3);
  $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
  $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(3);
  $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(19);
  
  
  
  $objPHPExcel->getActiveSheet()->getStyle("A$row:J$row")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
 $objPHPExcel->getActiveSheet()->getStyle("A$row:J$row")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
 $objPHPExcel->getActiveSheet()->getStyle("A$row:J$row")->getAlignment()->setWrapText(true); 
  $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':J'.$row)->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,'#');
  $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,'Date of Test');
  $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,'Sample Type');
  $objPHPExcel->getActiveSheet()->mergeCells("C$row:D$row");
  $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,"Sample sent from (Hospital)");
  $objPHPExcel->getActiveSheet()->mergeCells("E$row:G$row");
  $objPHPExcel->getActiveSheet()->setCellValue('H'.$row,'Sample #');
  $objPHPExcel->getActiveSheet()->mergeCells("H$row:I$row");
  $objPHPExcel->getActiveSheet()->setCellValue('J'.$row,"BCR-ABL1 Result % (International Scale)");
  $objPHPExcel->getActiveSheet()->mergeCells("J$row:L$row");
  $row++;
    ///////////////////////////////////////


    $cnt=count($patient_arr);
    
    
    $prow_limit=45;//items row limit for every page also change the for loop
    $new_cnt=number_format($cnt/$prow_limit,1,'.','');
    
    list($first,$second)=explode('.',$new_cnt);
    $first_c=$first=='0'?'1':$first;
    $no_of_page=(($first=='0') || ($first=='1' && $second=='0') || ($first >1  && $second=='0') )?$first_c:$first+1;   //new one
         //$tcnt=0;
         $ir=0;
        for($m=1;$m<=$no_of_page;$m++)
        {
          
           if($m>1)//Add new page head
           {

            $objPHPExcel->createSheet($m);
            $objPHPExcel->getSheet($m)->setTitle("sheet_$m");
            $objPHPExcel->setActiveSheetIndex("$m");    
 
 ///////////////////////////////////Head//////////////////////////////
 
 $objPHPExcel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
 $objPHPExcel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
 $objPHPExcel->getActiveSheet()->setCellValue('D1','Patient Details');
 $objPHPExcel->getActiveSheet()->mergeCells("D1:I2"); 
 $objPHPExcel->getActiveSheet()->getStyle("D1:I2")->getFont()->setSize(14.5);
 $objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
 
  $row=4;
  $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,'Name');
  $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,' : ');
  $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$patient_arr[0]['pname']);
  $objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getFont()->setBold(true);
  
  $objPHPExcel->getActiveSheet()->setCellValue('H'.$row,"Patient's e-mail address");
  $objPHPExcel->getActiveSheet()->setCellValue('K'.$row,':');
  $objPHPExcel->getActiveSheet()->setCellValue('L'.$row,$patient_arr[0]['pmail']);
  $objPHPExcel->getActiveSheet()->getStyle('L'.$row)->getFont()->setBold(true);
  $row++;
  
  $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,'Surname');
  $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,' : ');
  $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$patient_arr[0]['sur_name']);
  $objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getFont()->setBold(true);
  
  $objPHPExcel->getActiveSheet()->setCellValue('H'.$row,"Report authorized by");
  $objPHPExcel->getActiveSheet()->setCellValue('K'.$row,':');
  $objPHPExcel->getActiveSheet()->setCellValue('L'.$row,$patient_arr[0]['authorized_by1']);
  $objPHPExcel->getActiveSheet()->getStyle('L'.$row)->getFont()->setBold(true);
  $row++;
    
  $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,'Gender');
  $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,' : ');
  $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$marr[$patient_arr[0]['gender']]);
  $objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getFont()->setBold(true);
  
  $objPHPExcel->getActiveSheet()->setCellValue('H'.$row,"Physician's name");
  $objPHPExcel->getActiveSheet()->setCellValue('K'.$row,':');
  $objPHPExcel->getActiveSheet()->setCellValue('L'.$row,$patient_arr[0]['physician_name']);
  $objPHPExcel->getActiveSheet()->getStyle('L'.$row)->getFont()->setBold(true);
  $row++;
    
  $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,'Date of birth');
  $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,' : ');
  $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$patient_arr[0]['dob']);
  $objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getFont()->setBold(true);
  
  $objPHPExcel->getActiveSheet()->setCellValue('H'.$row,"Physician's e-mail address");
  $objPHPExcel->getActiveSheet()->setCellValue('K'.$row,':');
  $objPHPExcel->getActiveSheet()->setCellValue('L'.$row,$patient_arr[0]['phy_mail']);
  $objPHPExcel->getActiveSheet()->getStyle('L'.$row)->getFont()->setBold(true);
  $row++;
  
  
   $objPHPExcel->getActiveSheet()->getStyle("A$row:L$row")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
  $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,'Hospital ID');
  $objPHPExcel->getActiveSheet()->mergeCells("A$row:B$row");
  $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,' : ');
  $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$patient_arr[0]['protocol_no']);
  $objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getFont()->setBold(true);
  
  $objPHPExcel->getActiveSheet()->setCellValue('H'.$row,"The diagnosis and the phase at the time of diagnosis");
  $objPHPExcel->getActiveSheet()->getStyle('H'.$row)->getAlignment()->setWrapText(true); 
  $objPHPExcel->getActiveSheet()->mergeCells("H$row:J$row");
  $objPHPExcel->getActiveSheet()->setCellValue('K'.$row,':');
  $objPHPExcel->getActiveSheet()->setCellValue('L'.$row,$patient_arr[0]['diagnosis']);
  $objPHPExcel->getActiveSheet()->getStyle('L'.$row)->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(28);
  $row++;
  
     
  $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,'Treatment start date');
  $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,' : ');
  $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$patient_arr[0]['tsdate']);
  $objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getFont()->setBold(true);
  
  $objPHPExcel->getActiveSheet()->setCellValue('H'.$row,"Bcr-Abl transcript subtype");
  $objPHPExcel->getActiveSheet()->setCellValue('K'.$row,':');
  $objPHPExcel->getActiveSheet()->setCellValue('L'.$row,$bcr_apl_stype_arr[$patient_arr[0]['bcr_apl']].($patient_arr[0]['bcr_apl_others']?' - '.$patient_arr[0]['bcr_apl_others']:''));
  $objPHPExcel->getActiveSheet()->getStyle('L'.$row)->getFont()->setBold(true);
  $row++;
  
     
  $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,'Type of treatment');
  $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,' : ');
  $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$type_of_treatment_arr[$patient_arr[0]['treatment_type']]);
  $objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getFont()->setBold(true);
  $row++;
  $objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(31);
  $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(6);
  $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(14);
  $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(3);
  $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
  $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(3);
  $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
  
  
  
  $objPHPExcel->getActiveSheet()->getStyle("A$row:J$row")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
 $objPHPExcel->getActiveSheet()->getStyle("A$row:J$row")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
 $objPHPExcel->getActiveSheet()->getStyle("A$row:J$row")->getAlignment()->setWrapText(true); 
  $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':J'.$row)->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,'#');
  $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,'Date of Test');
  $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,'Sample Type');
  $objPHPExcel->getActiveSheet()->mergeCells("C$row:D$row");
  $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,"Sample sent from (Hospital)");
  $objPHPExcel->getActiveSheet()->mergeCells("E$row:G$row");
  $objPHPExcel->getActiveSheet()->setCellValue('H'.$row,'Sample #');
  $objPHPExcel->getActiveSheet()->mergeCells("H$row:I$row");
  $objPHPExcel->getActiveSheet()->setCellValue('J'.$row,"BCR-ABL1 Result % (International Scale)");
  $objPHPExcel->getActiveSheet()->mergeCells("J$row:L$row");
  $row++;
    ///////////////////////////////////////

$row++;

           }


    
    $sr=$row;

        for($i=0;$i<$prow_limit;$i++)
          {
            if($patient_arr[$ir]['test_id'])
            {
                
                $objPHPExcel->getActiveSheet()->getStyle("A$row:B$row")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,($ir+1));
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$patient_arr[$ir]['test_date']);
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$patient_arr[$ir]['sample_type']);
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,$patient_arr[$ir]['sample_sent_from']);
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$row,$patient_arr[$ir]['sample_no']);
                $objPHPExcel->getActiveSheet()->setCellValue('J'.$row,$patient_arr[$ir]['bcr_apl_no']);
                $objPHPExcel->getActiveSheet()->mergeCells("C$row:D$row");
                $objPHPExcel->getActiveSheet()->mergeCells("E$row:G$row");
                $objPHPExcel->getActiveSheet()->mergeCells("H$row:I$row");
                $objPHPExcel->getActiveSheet()->mergeCells("J$row:L$row");
                
                $row++;
            }
            
            
            $ir++;
            
          }

 $objPHPExcel->getActiveSheet()->getStyle("A".($sr-1).":L".($row-1))->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN))));
 
 $objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.00);
$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.00);
$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.00);
$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.00);
$objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
$objPHPExcel->getActiveSheet()->getPageSetup()->setVerticalCentered(true);
    
    $objPageSetup = new PHPExcel_Worksheet_PageSetup();
    $objPageSetup->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
    $objPageSetup->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
    //$objPageSetup->setPrintArea("A$start_row_no:J$row_no");
    $objPageSetup->setFitToWidth(1);
    $objPageSetup->setFitToHeight(0);
    $objPHPExcel->getActiveSheet()->setPageSetup($objPageSetup);

        }




    $objPHPExcel->removeSheetByIndex(0);
    $objPHPExcel->setActiveSheetIndex("0");   
    $file_name="patient_detail_".date('Y_m_d');
    header('Content-Type: application/vnd.ms-excel');
    header("Content-Disposition: attachment;filename=$file_name.xls");
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');

?>

<?php
    }
    else
      $show_errors="<div class=error>There are no records to view...</div>";

}
?>
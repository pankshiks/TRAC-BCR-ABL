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

 
 $condition.=$_GET['name'] && $_GET['name']!='undefined'?" and (p.pname like '%".$_GET['name']."%' OR p.sur_name like '%".$_GET['name']."%')":'';
 $condition.=$_GET['dod'] && $_GET['dod']!='undefined'?" and p.diag_st_date='".GetFormattedDate($_GET['dod'])."'":'';
 $condition.=$_GET['tdate'] && $_GET['tdate']!='undefined'?" and p.start_date='".GetFormattedDate($_GET['tdate'])."'":'';
 $condition.=$_GET['medic_id'] && $_GET['medic_id']!='undefined'?" and p.medication_id='".$_GET['medic_id']."'":'';
 $condition.=$_GET['phy_name'] && $_GET['phy_name']!='undefined'?" and p.physician_name='".$_GET['phy_name']."'":'';
 

    
      $patient_arr=$db->get_results("select
    p.patient_id,p.pcode,p.pname,p.sur_name,DATE_FORMAT(p.start_date,'%d-%m-%Y') as tsdate,DATE_FORMAT(p.diag_st_date,'%d-%m-%Y') as dof_diagnosis,p.medication_id,DATEDIFF('".date('Y-m-d')."',p.start_date) as treatment_time,p.physician_name, 
     concat(FORMAT((DATEDIFF('".date('Y-m-d')."',p.start_date)/30),1),' month(s)')  AS treatment_month

     from msom_patient p
     where p.patient_id IS NOT NULL $condition and p.status='act'  order by patient_id asc",ARRAY_A);



   if($patient_arr)
   {

  $wrcondition.=$_GET['hospital']?" where sample_sent_from='".$_GET['hospital']."'":'';
  $last_bcr_abl_arr=$db->get_results("select patient_id,bcr_apl_no,sample_sent_from as hospital from msom_test $wrcondition order by test_id asc",ARRAY_A);
  $last_graph_arr=$db->get_results("select patient_id,max(graph_id) as graph_id from msom_graph  group by patient_id ",ARRAY_A);


  if($last_graph_arr)
  {
    foreach($last_graph_arr as $lgk=>$lgv)
        $last_grapharr[$lgv['patient_id']]=$lgv['graph_id'];
  }
  
  if($last_bcr_abl_arr)
  {
    foreach($last_bcr_abl_arr as $lbk=>$lbv)
       {
        
         $mark="";
          if($lbv['bcr_apl_no']<=0.0032)
            $mark='MR4.5';
          elseif($lbv['bcr_apl_no']<=0.01)
            $mark='MR4';
          elseif($lbv['bcr_apl_no']<=0.1)
            $mark='MMR';            
          elseif($lbv['bcr_apl_no']<1)
            $mark='CCYR';
          else
            $mark="";
            
          
        if($_GET['mstone']=='undefined' || $mark==$_GET['mstone'] || !$_GET['mstone'])
        {  
      
            $last_bcrabl_arr[$lbv['patient_id']]['bcr_apl_no']=$lbv['bcr_apl_no'];
            $last_bcrabl_arr[$lbv['patient_id']]['hospital']=$lbv['hospital'];
            $last_bcrabl_arr[$lbv['patient_id']]['milestone']=$mark;
        }
       }
    
  }
  }
  
   
    
   if($patient_arr)
    {
        
        
    require_once($_SERVER['DOCUMENT_ROOT'].'/ELN/includes/excel1.7.7/Classes/PHPExcel.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/ELN/includes/excel1.7.7/Classes/PHPExcel/IOFactory.php');
        
       
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->createSheet(1);
            $objPHPExcel->getSheet(1)->setTitle("sheet_1");
            $objPHPExcel->setActiveSheetIndex("1");    
            $medication_arr=medication_arr();

$objPHPExcel->getActiveSheet()->getStyle()->getFont()->setSize(12);

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(4);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(11);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(11);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(16);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(22);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(28);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(75);



 ///////////////////////////////////Head//////////////////////////////
 
 $objPHPExcel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
 $objPHPExcel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
 $objPHPExcel->getActiveSheet()->setCellValue('D1','Overall Patient Report');
 $objPHPExcel->getActiveSheet()->mergeCells("D1:I2"); 
 $objPHPExcel->getActiveSheet()->getStyle("D1:I2")->getFont()->setSize(14.5);
 
  $row=4;
  $objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(45);
  $objPHPExcel->getActiveSheet()->getStyle("A$row:P$row")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
 $objPHPExcel->getActiveSheet()->getStyle("A$row:P$row")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
 $objPHPExcel->getActiveSheet()->getStyle("A$row:P$row")->getAlignment()->setWrapText(true); 
  $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':P'.$row)->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,'#');
  $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,'Name');
  $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,'Date of diagnosis');
  $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,'Treatment start date');
  $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,'Last BCR-ABL result');
  $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,'Milestone');
  $objPHPExcel->getActiveSheet()->setCellValue('G'.$row,'Time on treatment');
  $objPHPExcel->getActiveSheet()->setCellValue('H'.$row,"Medication name");
  $objPHPExcel->getActiveSheet()->setCellValue('I'.$row,"Physician's name");
  $objPHPExcel->getActiveSheet()->setCellValue('J'.$row,'Sample sent from (Hospital)');
  $objPHPExcel->getActiveSheet()->setCellValue('K'.$row,'Graph');

  
  $row++;
    ///////////////////////////////////////


    $cnt=count($patient_arr);
    
 
          
         

    
    $sr=$row;
    $sl=1;
        for($i=0;$i<$cnt;$i++)
          {
             if($patient_arr[$i]['patient_id'] && $last_grapharr[$patient_arr[$i]['patient_id']] && ($_GET['mstone']=='undefined' || !$_GET['mstone'] || $last_bcrabl_arr[$patient_arr[$i]['patient_id']]['milestone']) && ($_GET['hospital']=='undefined' || !$_GET['hospital'] || $last_bcrabl_arr[$patient_arr[$i]['patient_id']]['hospital']))
             {
                 $objPHPExcel->getActiveSheet()->getStyle("A$row:J$row")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
 $objPHPExcel->getActiveSheet()->getStyle("A$row:J$row")->getAlignment()->setWrapText(true); 

                $objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(145);
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$sl);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$patient_arr[$i]['pname'].' '.$patient_arr[$i]['sur_name']);
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$patient_arr[$i]['dof_diagnosis']);
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$patient_arr[$i]['tsdate']);
                
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,$last_bcrabl_arr[$patient_arr[$i]['patient_id']]['bcr_apl_no']);
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,$last_bcrabl_arr[$patient_arr[$i]['patient_id']]['milestone']);
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$row,($patient_arr[$i]['treatment_time']<'30'?($patient_arr[$i]['treatment_time'].' day(s)'):$patient_arr[$i]['treatment_month']));
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$row,$medication_arr[$patient_arr[$i]['medication_id']]);
                
                $objPHPExcel->getActiveSheet()->setCellValue('I'.$row,$patient_arr[$i]['physician_name']);
                $objPHPExcel->getActiveSheet()->setCellValue('J'.$row,$last_bcrabl_arr[$patient_arr[$i]['patient_id']]['hospital']);
                
                $image_file ="graph/".$last_grapharr[$patient_arr[$i]['patient_id']].".png";
                $objPHPExcel->getActiveSheet()->setCellValue('K'.$row,$patient_arr[$i]['authorized_by3']);
                
                if (file_exists($image_file))
                {
                    $objDrawing = new PHPExcel_Worksheet_Drawing();
                    $objDrawing->setName('graph');
                    $objDrawing->setDescription('graph');
                    $objDrawing->setPath($image_file);
                    $objDrawing->setOffsetX(3);                     //setOffsetX works properly
                    $objDrawing->setOffsetY(3);   
                    $objDrawing->setCoordinates('K'.$row);             //set image to cell E38
                    $objDrawing->setHeight(180);                     //signature height  
                    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());  //save      
                }
                
                $row++;
                $sl++;
            }
            
          }

 $objPHPExcel->getActiveSheet()->getStyle("A".($sr-1).":K".($row-1))->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN))));
 
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

       



    $objPHPExcel->removeSheetByIndex(0);
    $objPHPExcel->setActiveSheetIndex("0");   
    $file_name="patient_overall_".date('Y_m_d');
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


?>
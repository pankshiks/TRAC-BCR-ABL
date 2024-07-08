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

 
    $condition.=$_GET['pcode'] && $_GET['pcode']!='undefined'?" and p.pcode like '%".$_GET['pcode']."%'":'';
    $condition.=$_GET['name'] && $_GET['name']!='undefined'?" and p.pname like '%".$_GET['name']."%'":'';
    $condition.=$_GET['surname'] && $_GET['surname']!='undefined'?" and p.sur_name like '%".$_GET['surname']."%'":'';
    $condition.=$_GET['gender'] && $_GET['gender']!='undefined'?" and p.gender like '%".$_GET['gender']."%'":'';    
    $condition.=$_GET['dob'] && $_GET['dob']!='undefined'?" and p.dob='".GetFormattedDate($_GET['dob'])."'":'';
    $condition.=$_GET['prot_no'] && $_GET['prot_no']!='undefined'?" and p.protocol_no like '%".$_GET['prot_no']."%'":'';
    
    $condition.=$_GET['pemail'] && $_GET['pemail']!='undefined'?" and p.pmail like '%".$_GET['pemail']."%'":'';
    $condition.=$_GET['authorized1'] && $_GET['authorized1']!='undefined'?" and p.authorized_by1 like '%".$_GET['authorized1']."%'":'';
    $condition.=$_GET['phy_name'] && $_GET['phy_name']!='undefined'?" and p.physician_name like '%".$_GET['phy_name']."%'":'';
    $condition.=$_GET['phy_mail'] && $_GET['phy_mail']!='undefined'?" and p.phy_mail like '%".$_GET['phy_mail']."%'":'';
    $condition.=$_GET['diag'] && $_GET['diag']!='undefined'?" and p.diagnosis like '%".$_GET['diag']."%'":'';
    $condition.=$_GET['bcr_apl_stype'] && $_GET['bcr_apl_stype']!='undefined'?" and p.bcr_apl like '%".$_GET['bcr_apl_stype']."%'":'';
    $condition.=$_GET['tsdate'] && $_GET['tsdate']!='undefined'?" and p.start_date='".GetFormattedDate($_GET['tsdate'])."'":'';
    $condition.=$_GET['type_of_treatment'] && $_GET['type_of_treatment']!='undefined'?" and p.treatment_type like '%".$_GET['type_of_treatment']."%'":'';

        $patient_arr=$db->get_results("select
    p.patient_id,p.pcode,p.pname,p.sur_name,p.gender,DATE_FORMAT(p.dob,'%d-%m-%Y') as dob,p.protocol_no,p.pmail,p.authorized_by1,p.authorized_by2,p.authorized_by3,p.physician_name,p.phy_mail,p.diagnosis,p.bcr_apl,DATE_FORMAT(p.start_date,'%d-%m-%Y') as tsdate,p.treatment_type
    
     from msom_patient p
     where p.status='act' $condition ",ARRAY_A);
   
    
   if($patient_arr)
    {
        $marr=gender_arr();
        $bcr_apl_stype_arr=bcr_apl_stype();
        $type_of_treatment_arr=treatment_type();
        $diagnosis_arr=diagnosis_arr();
        
    require_once($_SERVER['DOCUMENT_ROOT'].'/ELN/includes/excel1.7.7/Classes/PHPExcel.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/ELN/includes/excel1.7.7/Classes/PHPExcel/IOFactory.php');
        
       
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->createSheet(1);
            $objPHPExcel->getSheet(1)->setTitle("sheet_1");
            $objPHPExcel->setActiveSheetIndex("1");    
 

$objPHPExcel->getActiveSheet()->getStyle()->getFont()->setSize(12);

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(4);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(9);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(11);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(16);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(22);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(15);

 ///////////////////////////////////Head//////////////////////////////
 
 $objPHPExcel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
 $objPHPExcel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
 $objPHPExcel->getActiveSheet()->setCellValue('A1','List Of Patients');
 //$objPHPExcel->getActiveSheet()->mergeCells("A1:I2"); 
 $objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setSize(14.5);
 
$row=4;
$objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(45);
$objPHPExcel->getActiveSheet()->getStyle("A$row:P$row")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle("A$row:P$row")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle("A$row:P$row")->getAlignment()->setWrapText(true); 
$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':P'.$row)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->setCellValue('A'.$row,'#');

  
  $lc='A';
if($_GET['c1'] && $_GET['c1']!='undefined')
{
    $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,'Name');
    $val_arr['B']='1';
    $lc='B';
}
if($_GET['c2'] && $_GET['c2']!='undefined')
{
    $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,'Surname');
    $val_arr['C']='1';
    $lc='C';
}
if($_GET['c3'] && $_GET['c3']!='undefined')
{
    $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,'Gender');
    $val_arr['D']='1';
    $lc='D';
}
if($_GET['c4'] && $_GET['c4']!='undefined')
{
    $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,'DOB');
    $val_arr['E']='1';
    $lc='E';
}
if($_GET['c5'] && $_GET['c5']!='undefined')
{
    $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,'Hospital ID');
    $val_arr['F']='1';
    $lc='F';
}
if($_GET['c6'] && $_GET['c6']!='undefined')
{
    $objPHPExcel->getActiveSheet()->setCellValue('G'.$row,"Patient's e-mail Address");
    $val_arr['G']='1';
    $lc='G';
}
if($_GET['c7'] && $_GET['c7']!='undefined')
{
    $objPHPExcel->getActiveSheet()->setCellValue('H'.$row,'Report authorized by');
    $objPHPExcel->getActiveSheet()->setCellValue('I'.$row,'Report authorized by');
    $objPHPExcel->getActiveSheet()->setCellValue('J'.$row,'Report authorized by');
    $val_arr['H']='1';
    $val_arr['I']='1';
    $val_arr['J']='1';
    $lc='J';
}
if($_GET['c8'] && $_GET['c8']!='undefined')
{
    $objPHPExcel->getActiveSheet()->setCellValue('K'.$row,"Physician's name");
    $val_arr['K']='1';
    $lc='K';
}
if($_GET['c9'] && $_GET['c9']!='undefined')
{
    $objPHPExcel->getActiveSheet()->setCellValue('L'.$row,"Physician's e-mail address");
    $val_arr['L']='1';
    $lc='L';
}
if($_GET['c10'] && $_GET['c10']!='undefined')
{
    $objPHPExcel->getActiveSheet()->setCellValue('M'.$row,"The diagnosis and the phase at the time of diagnosis");
    $val_arr['M']='1';
    $lc='M';
}
if($_GET['c11'] && $_GET['c11']!='undefined')
{
    $objPHPExcel->getActiveSheet()->setCellValue('N'.$row,"BCR-ABL transcript subtype");
    $val_arr['N']='1';
    $lc='N';
}
if($_GET['c12'] && $_GET['c12']!='undefined')
{
    $objPHPExcel->getActiveSheet()->setCellValue('O'.$row,'Treatment start date');
    $val_arr['O']='1';
    $lc='O';
}
if($_GET['c13'] && $_GET['c13']!='undefined')
{
    $objPHPExcel->getActiveSheet()->setCellValue('P'.$row,'Type of treatment');
    $val_arr['P']='1';
    $lc='P';
}

  $row++;
    ///////////////////////////////////////


    $cnt=count($patient_arr);
    
 
          
         

    
    $sr=$row;

        for($i=0;$i<$cnt;$i++)
          {
            
  $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,($i+1));
  if($_GET['c1'] && $_GET['c1']!='undefined')
  $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$patient_arr[$i]['pname']);
  if($_GET['c2'] && $_GET['c2']!='undefined')
  $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$patient_arr[$i]['sur_name']);
  if($_GET['c3'] && $_GET['c3']!='undefined')
  {
  $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$marr[$patient_arr[$i]['gender']]);
  $objPHPExcel->getActiveSheet()->getStyle('D'.$row.":E$row")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  }
  if($_GET['c4'] && $_GET['c4']!='undefined')
  $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,$patient_arr[$i]['dob']);
  if($_GET['c5'] && $_GET['c5']!='undefined')
  $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,$patient_arr[$i]['protocol_no']);
  if($_GET['c6'] && $_GET['c6']!='undefined')
  $objPHPExcel->getActiveSheet()->setCellValue('G'.$row,$patient_arr[$i]['pmail']);
  if($_GET['c7'] && $_GET['c7']!='undefined')
  {
  $objPHPExcel->getActiveSheet()->setCellValue('H'.$row,$patient_arr[$i]['authorized_by1']);
  $objPHPExcel->getActiveSheet()->setCellValue('I'.$row,$patient_arr[$i]['authorized_by2']);
  $objPHPExcel->getActiveSheet()->setCellValue('J'.$row,$patient_arr[$i]['authorized_by3']);
  }
  if($_GET['c8'] && $_GET['c8']!='undefined')
  $objPHPExcel->getActiveSheet()->setCellValue('K'.$row,$patient_arr[$i]['physician_name']);
  if($_GET['c9'] && $_GET['c9']!='undefined')
  $objPHPExcel->getActiveSheet()->setCellValue('L'.$row,$patient_arr[$i]['phy_mail']);
  if($_GET['c10'] && $_GET['c10']!='undefined')
  $objPHPExcel->getActiveSheet()->setCellValue('M'.$row,$diagnosis_arr[$patient_arr[$i]['diagnosis']]);
  if($_GET['c11'] && $_GET['c11']!='undefined')
  $objPHPExcel->getActiveSheet()->setCellValue('N'.$row,$bcr_apl_stype_arr[$patient_arr[$i]['bcr_apl']].($patient_arr[$i]['bcr_apl_others']?' - '.$patient_arr[$i]['bcr_apl_others']:''));
  if($_GET['c12'] && $_GET['c12']!='undefined')
  $objPHPExcel->getActiveSheet()->setCellValue('O'.$row,$patient_arr[$i]['tsdate']);
  if($_GET['c13'] && $_GET['c13']!='undefined')
  $objPHPExcel->getActiveSheet()->setCellValue('P'.$row,$type_of_treatment_arr[$patient_arr[$i]['treatment_type']]);
  if($_GET['c14'] && $_GET['c14']!='undefined')
  $objPHPExcel->getActiveSheet()->getStyle('N'.$row.":P$row")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
   
   $row++;
            
            
          }

 $objPHPExcel->getActiveSheet()->getStyle("A".($sr-1).":$lc".($row-1))->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN))));



if(!$val_arr['P'])
    $objPHPExcel->getActiveSheet()->removeColumn('P', 1);
if(!$val_arr['O'])
$objPHPExcel->getActiveSheet()->removeColumn('O', 1);
if(!$val_arr['N'])
$objPHPExcel->getActiveSheet()->removeColumn('N', 1);
if(!$val_arr['M'])
$objPHPExcel->getActiveSheet()->removeColumn('M', 1);
if(!$val_arr['L'])
$objPHPExcel->getActiveSheet()->removeColumn('L', 1);
if(!$val_arr['K'])
$objPHPExcel->getActiveSheet()->removeColumn('K', 1);
if(!$val_arr['J'])
$objPHPExcel->getActiveSheet()->removeColumn('J', 1);
if(!$val_arr['I'])
$objPHPExcel->getActiveSheet()->removeColumn('I', 1);
if(!$val_arr['H'])
$objPHPExcel->getActiveSheet()->removeColumn('H', 1);
if(!$val_arr['G'])
$objPHPExcel->getActiveSheet()->removeColumn('G', 1);
if(!$val_arr['F'])
$objPHPExcel->getActiveSheet()->removeColumn('F', 1);
if(!$val_arr['E'])
$objPHPExcel->getActiveSheet()->removeColumn('E', 1);
if(!$val_arr['D'])
$objPHPExcel->getActiveSheet()->removeColumn('D', 1);
if(!$val_arr['C'])
$objPHPExcel->getActiveSheet()->removeColumn('C', 1);
if(!$val_arr['B'])
$objPHPExcel->getActiveSheet()->removeColumn('B', 1);



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
    $file_name="patient_list_".date('Y_m_d');
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
<?php
ini_set('display_errors',false);
define ('PDF_MARGIN_TOP', 45);
session_start();
 if(!$_SESSION['mso_eln']["guser_id"])
    {
        $msg=("Login+time+out+");
       	$msg=urlencode(base64_encode($msg));
        header("location:../../index.php?msg=$msg");
    }
include($_SERVER['DOCUMENT_ROOT'].'/ELN/includes/ezsql/ezsql_conn.inc');
include($_SERVER['DOCUMENT_ROOT'].'/ELN/includes/cosmic/functions.inc');


    
 // echo '<br><br>';

$id=$_REQUEST['id'];
 

 
if($id)
{
require_once('../../includes/tcpdf/config/lang/eng.php');
require_once('../../includes/tcpdf/tcpdf.php');
        $marr=gender_arr();
        $bcr_apl_stype_arr=bcr_apl_stype();
        $type_of_treatment_arr=treatment_type();
        $medication_arr=medication_arr();
        
// extend TCPF with custom functions
class MYPDF extends TCPDF {

	// Load table data from file
	/*public function LoadData($file) {
		// Read file lines
		$lines = file($file);
		$data = array();
		foreach($lines as $line) {
			$data[] = explode(';', chop($line));
		}
		return $data;
	}*/

 public function Header()
 {

    global $db,$guser_name,$guser_id,$patient_narr,$marr,$bcr_apl_stype_arr,$type_of_treatment_arr,$medication_arr;
     $this->SetFillColor(255, 255, 255);
//$this->SetFillColor(224, 235, 255);
$this->SetTextColor(0);
$this->SetFont('times', 'B','15');
//$this->Cell('230', 20, '', 0, 1, 'C', 1);
//$this->Ln(0.2);
//$this->SetY(5);
$this->Cell('230', 7, 'Patient Individual View', 0, 1, 'C', 1);
$this->SetFillColor(255, 255, 255);
$this->SetTextColor(0);
$this->Cell('230', 7, ' ', 0, 1, 'C', 1);
//$this->SetFont('times', 'B','11');
$this->SetFont('times', '','11');
$this->Cell('30', 6, 'Start Date ', 0, 0, 'L', 0);
$this->SetFont('times', 'B','11');
$this->Cell('40', 6, ': '.($patient_narr[0]['sdate']), 0, 0, 'L', 0);

$this->SetFont('times', '','11');
$this->Cell('30', 6, 'End Date ', 0, 0, 'L', 0);
$this->SetFont('times', 'B','11');
$this->Cell('40', 6, ': '.($patient_narr[0]['edate']), 0, 0, 'L', 0);

$this->SetFont('times', '','11');
$this->Cell('40', 6, 'Treatment Type ', 0, 0, 'L', 0);
$this->SetFont('times', 'B','11');
$this->Cell('40', 6, ': '.($type_of_treatment_arr[($patient_narr[0]['ptype_of_treatment']?$patient_narr[0]['ptype_of_treatment']:'1')]), 0, 0, 'L', 0);

    }


 public function Footer() {
    }
    
    
    
    
	// Colored table
	public function ColoredTable($header,$ind_id) {
		// Colors, line width and bold font
        
global $db,$guser_name,$guser_id;
   
$this->SetY(43);

		$this->SetFillColor(139,137,137);
		$this->SetTextColor(255);
		$this->SetDrawColor(0, 0, 0);        
		$this->SetLineWidth(0.3);
		$this->SetFont('times', 'B','11');
       
		// Header
		//$w = array(15, 115, 25,20,25,30);
    

            

           $image_file ="./graph/ind_$ind_id.png";
           $this->Image($image_file, '', '', 230, '', '', '', '', false, 300);
        

	}
}





/*function findminmax_yaxix($data)
{
    
    switch ($data) {
    case $data<0.001:
        $ret='-4';
        break;
    case $data>=0.001 && $data<0.01:
        $ret='-3';
        break;
    case $data>=0.01 && $data<0.1:
        $ret='-2';
        break;
    case $data>=0.1 && $data<1:
        $ret='-1';
        break;
     case $data>=1 && $data<10:
        $ret='0';
        break;
      case $data>=10 && $data<100:
        $ret='1';
        break;
         case $data>=100 && $data<1000:
        $ret='2';
        break;
         case $data>=1000:
        $ret='3';
        break;
   echo "<br>".$ret;     
      return $ret;
}


      return $ret;
}*/
   // $cperson_designation_arr=cperson_designation();
   
        
    
     //print_R($_REQUEST);
  if($_REQUEST)
   {
    if($_REQUEST['sdate'] && $_REQUEST['edate'])
        $tcond.=" and t.date between '".GetFormattedDate($_REQUEST['sdate'])."' and '".GetFormattedDate($_REQUEST['edate'])."'";
    else
    {
        $tcond.=$_REQUEST['sdate']?" and t.date>='".GetFormattedDate($_REQUEST['sdate'])."'":'';
        $tcond.=$_REQUEST['edate']?" and t.date<='".GetFormattedDate($_REQUEST['edate'])."'":'';
    }
   }
   $tcond.=" and t.treatment_type='".($_REQUEST['type_of_treatment']?$_REQUEST['type_of_treatment']:$_REQUEST['tot'])."'";
   
     $patient_array=$db->get_results("select p.treatment_type,DATE_FORMAT(t.date,'%d/%m/%Y') as dis_date,
     p.start_date,DATE_FORMAT(p.start_date,'%d-%m-%Y') as tsdate,
     p.sstart_date,DATE_FORMAT(p.sstart_date,'%d-%m-%Y') as stsdate
     
     from msom_patient p  left join msom_test t on t.patient_id=p.patient_id where p.patient_id=$id  ",ARRAY_A);
       foreach($patient_array as $k1=>$v1)
        {
            $tlast_date=$v1['dis_date'];
        }
     $patient_narr=$db->get_results("select
    p.patient_id,t.bcr_apl_no,t.date as gdate,DATE_FORMAT(t.date,'%d/%m/%Y') as dis_date


     from msom_patient p
     left join msom_test t on t.patient_id=p.patient_id
     where p.patient_id=$id and p.status='act' and t.date>='".(($_REQUEST['type_of_treatment']=='1' || (!$_REQUEST['type_of_treatment'] && $_REQUEST['tot']=='1'))?$patient_array[0]['start_date']:$patient_array[0]['sstart_date'])."' $tcond
     order by t.date asc",ARRAY_A);
      
      //$db->debug();
      
      
  if($patient_narr)
    {   
        
        $patient_narr[0]['sdate']=$_REQUEST['sdate'];
        $patient_narr[0]['edate']=$_REQUEST['edate'];
        $patient_narr[0]['ptype_of_treatment']=$_REQUEST['type_of_treatment'];
        
        
        
        foreach($patient_narr as $k=>$v)
        {
            $data_arr[0][]=$v['bcr_apl_no'];//>1000?1000:$pv['bcr_apl_no']);
            $data_arr[1][]=$v['gdate'];
            
        }
       
    $gid=base64_decode($_GET['id']);
      // if(count($data_arr[0])>1)
      // {
         $_SESSION['mso_eln']['Bcr-AplArr']=$data_arr;
         $_SESSION['mso_eln']['Bcr-AplArr'][2]=$patient_array[0]['treatment_type'];
         $_SESSION['mso_eln']['Bcr-AplArr'][3]=$type_of_treatment_arr[$_REQUEST['type_of_treatment']?$_REQUEST['type_of_treatment']:$patient_array[0]['treatment_type']];
         $_SESSION['mso_eln']['Bcr-AplArr'][4]=$_REQUEST['type_of_treatment']=='1' || (!$_REQUEST['type_of_treatment'] && $patient_array[0]['treatment_type']=='1')?$patient_array[0]['tsdate']:$patient_array[0]['stsdate'];;//$patient_arr[0]['test_date'];//
         
         
         
         $_SESSION['mso_eln']['Bcr-AplArr'][5]=$patient_array[0]['dis_date'];
         $_SESSION['mso_eln']['Bcr-AplArr'][6]=$tlast_date;
         
         $_SESSION['mso_eln']['Bcr-AplArr'][7]=$_REQUEST['sdate']?$_REQUEST['sdate']:$_REQUEST['type_of_treatment'];
         if($_REQUEST['sdate'] || $_REQUEST['type_of_treatment'])
         {
         $min=findminmax_yaxix(min($data_arr[0]));;
         $max=findminmax_yaxix(max($data_arr[0]))+1;
         //$min=($min=='0'?'-1':$min);
         $_SESSION['mso_eln']['Bcr-AplArr'][8]=$min;//($min=='0'?'-1':$min);
         $_SESSION['mso_eln']['Bcr-AplArr'][9]=($max==$min)?$max+1:$max;
         }
         $ind_id=$id;
         include("bcr_apl_graph_det.php");
          
      // }
      }
             

global $pdf;
   // create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Medtrix');
$pdf->SetTitle('PDF Document');
$pdf->SetSubject('CS PDF');
$pdf->SetKeywords('CS, PDF');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.'PDF Document', PDF_HEADER_STRING);


// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// ---------------------------------------------------------

// set font
$pdf->SetFont('times', '', 8);

// add a page
//$pdf->AddPage();
$resolution= array(250,260);
$pdf->AddPage('L', $resolution);

//Column titles
//$header = array('');

//Data loading
//$data = $tdata;

// print colored table
$pdf->ColoredTable($header, $ind_id);

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('bcrabl'.$patient_arr[0]['pcode'].'.pdf', 'D'); 




//============================================================+
// END OF FILE                                                
//============================================================+

}
        else
          	$show_errors= "<div align=left class=error>There are no records to view</div>";



?>
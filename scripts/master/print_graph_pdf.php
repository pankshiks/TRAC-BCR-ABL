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
    
    //ini_set('display_errors',true);
    
include($_SERVER['DOCUMENT_ROOT'].'/ELN/includes/ezsql/ezsql_conn.inc');
include($_SERVER['DOCUMENT_ROOT'].'/ELN/includes/cosmic/functions.inc');

//ini_set('display_errors',true);
    
 // echo '<br><br>';

$id=$_SESSION['mso_eln']['pviewid'];
 
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

    global $db,$guser_name,$guser_id,$patient_arr,$marr,$bcr_apl_stype_arr,$type_of_treatment_arr,$medication_arr;
   
        $get_max_id=$db->get_var("select max(graph_id) from msom_graph where patient_id=".$_SESSION['mso_eln']['pviewid']);;
        $report_date=$db->get_var("select DATE_FORMAT(report_date,'%d-%m-%Y'),treatment_type from msom_graph where graph_id=".$get_max_id);
        
        $this->SetFillColor(255, 255, 255);
//$this->SetFillColor(224, 235, 255);
$this->SetTextColor(0);
$this->SetFont('times', 'B','15');
//$this->Cell('230', 20, '', 0, 1, 'C', 1);
//$this->Ln(0.2);
//$this->SetY(5);
$this->Cell('230', 7, 'Patient Details', 0, 1, 'C', 1);


//$this->SetY(35);
$this->SetFillColor(255, 255, 255);
$this->SetTextColor(0);

//$this->SetFont('times', 'B','11');
$this->SetFont('times', '','11');
$this->Cell('40', 6, 'Patient Name, Surname ', 0, 0, 'L', 0);
$this->SetFont('times', 'B','11');
$this->Cell('130', 6, ': '.($patient_arr[0]['pname'].' '.$patient_arr[0]['sur_name']), 0, 0, 'L', 0);


$this->SetFont('times', '','11');
$this->Cell('40', 6, " Sample Delivery date ", 0, 0, 'L', 0);
$this->SetFont('times', 'B','11');
$this->Cell('50', 6, ': '.date('d-m-Y'), 0, 1, 'L', 0);




$this->SetFont('times', '','11');
$this->Cell('40', 6, 'Age / Gender ', 0, 0, 'L', 0);
$this->SetFont('times', 'B','11');
$this->Cell('130', 6,  ': '.($patient_arr[0]['age'].' / '.$marr[$patient_arr[0]['gender']]), 0, 0, 'L', 0);
$this->SetFont('times', '','11');
$this->Cell('40', 6, " Report date ", 0, 0, 'L', 0);
$this->SetFont('times', 'B','11');
$this->Cell('50', 6,  ': '.$report_date, 0, 1, 'L', 0);


$this->SetFont('times', '','11');
$this->Cell('40', 6, 'Sent From and Dr.Name ', 0, 0, 'L', 0);
$this->SetFont('times', 'B','11');
$this->Cell('130', 6,  ': '.($patient_arr[0]['sample_sent_from'].' / '.$patient_arr[0]['physician_name']), 0, 0, 'L', 0);
$this->SetFont('times', '','11');
$this->Cell('40', 6, " Hospital Id ", 0, 0, 'L', 0);
$this->SetFont('times', 'B','11');
$this->Cell('50', 6,  ': '.$patient_arr[0]['protocol_no'], 0, 1, 'L', 0);


$this->SetFont('times', '','11');
$this->Cell('40', 6, 'Date of diagnosis ', 0, 0, 'L', 0);
$this->SetFont('times', 'B','11');
$this->Cell('130', 6,  ': '.$patient_arr[0]['diag_stdate'], 0, 0, 'L', 0);
$this->SetFont('times', '','11');
$this->Cell('40', 6, "  ", 0, 0, 'L', 0);
$this->Cell('50', 6,  ' ', 0, 1, 'L', 0);



$this->SetFont('times', '','11');
$this->Cell('40', 6, 'Medication name ', 0, 0, 'L', 0);
$this->SetFont('times', 'B','11');
$this->Cell('130', 6,  ': '.$medication_arr[$patient_arr[0]['medication_id']], 0, 0, 'L', 0);
$this->SetFont('times', '','11');
$this->Cell('40', 6, "  ", 0, 0, 'L', 0);
$this->Cell('50', 6,  ' ', 0, 1, 'L', 0);





    }


 public function Footer() {
    global $db,$guser_name,$guser_id;
     $this->SetY(-35);
$this->SetFillColor(139,137,137);
		$this->SetTextColor(255);
		$this->SetDrawColor(0, 0, 0);        
		$this->SetLineWidth(0.3);
//$this->SetFont('times', 'B', 11);
$this->Ln(0.5);

        
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        
       // $this->SetY(-25);
        
        // Set font
        //$this->Image('../../images/footer_img1a.jpg', '', '', 230, '', '', '', '', false, 300);
        $this->SetY(-4);
       $this->SetFont('times', '', 6);
       $date = Date('d-m-Y H:i:s');
       $this->Cell('220', 0, 'Date : '.$date, 0, 0, 'L', 1);
        //$this->Cell('140', 0, '', 0, 0, 'L', 1);
        
       
        $this->SetFont('times', '', 8);
        // Page number
        $this->Cell('10', 0, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        //$this->Cell('120', 0, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), '0', '0', 230, '', '', '', '', false, '');
        
    }
    
    
    
    
	// Colored table
	public function ColoredTable($header,$patient_arr) {
		// Colors, line width and bold font
        
global $db,$guser_name,$guser_id,$type_of_treatment_arr;
   
$this->SetY(43);

	//	$this->SetFillColor(139,137,137);
    $this->SetFillColor(255,255,255);
		$this->SetTextColor(0);
		$this->SetDrawColor(0, 0, 0);        
		$this->SetLineWidth(0.3);
		$this->SetFont('times', 'B','11');
       
		// Header
		//$w = array(15, 115, 25,20,25,30);
        $w = array(42,190);
        $header=array('Date of Test','BCR-ABL1 Result % (International Scale)');
        $border = array('LTRB' => array('width' => 0.4, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(247, 159, 129)));

        $this->SetFont('times', 'B','9');
		$num_headers = count($header);
		for($i = 0; $i < $num_headers; ++$i) {
			$this->Cell($w[$i], 8, $header[$i],$border, 0, 'C', 1);
		}

		$this->Ln();
		// Color and font restoration
		$this->SetFillColor(238,233,233);
		$this->SetTextColor(0);
		$this->SetFont('times', '','9');
		// Data
		$fill = 0;
        $i=0;
       // $ne=$this->AddPage();
       
      
    
		 $cnt=count($patient_arr);
         
         
    $prow_limit=23;//items row limit for every page also change the for loop
    $new_cnt=number_format($cnt/$prow_limit,1,'.','');
    
list($first,$second)=explode('.',$new_cnt);
$first_c=$first=='0'?'1':$first;
//$no_of_page=(($first=='0') || ($first=='1' && $second=='0') || ($first >1  && $second=='0') )?$first_c:$first+1;   //new one
         //$tcnt=0;
         $ir=0;
         $no_of_page+=1;//add 1 page for graph and remarks
          //$db->debug();
            $get_max_id=$db->get_var("select max(graph_id) from msom_graph where patient_id=".$_SESSION['mso_eln']['pviewid']);
            $report_remark_arr=$db->get_results("select remarks,treatment_type from msom_graph where graph_id=".$get_max_id,ARRAY_A);
            $report_remark=$report_remark_arr['0']['remarks'];
            

           $image_file ="./graph/$get_max_id.png";
           
        //for($m=1;$m<=$no_of_page;$m++)
        //{
          /*
           if($m>1)//Add new page
           {
            $tcnt=0;
            $this->Cell(array_sum($w), 0, '', 'T','1');
            $this->Ln();
            $this->AddPage();
            $this->SetY(43);

        $this->SetFillColor(139,137,137);
		$this->SetTextColor(255);
		$this->SetDrawColor(0, 0, 0);        
		$this->SetLineWidth(0.3);
		$this->SetFont('times', 'B');
        
        
        
        if($patient_arr[$ir]["test_id"])
        {
		$num_headers = count($header);
		for($i = 0; $i < $num_headers; ++$i) {
			$this->Cell($w[$i], 6, $header[$i], 1, 0, 'C', 1);
		}
		$this->Ln();
        $this->SetFillColor(238,233,233);
		$this->SetTextColor(0);
		$this->SetFont('times', '','11');
        }
           }*/
   
   $j=0;
          for($i=8;$i<=($cnt+8);$i++)//$prow_limit
          {
            if($patient_arr[$ir]["test_id"])
            {

            $this->SetFont('times', '','10');
            if($i%2)
                $this->SetFillColor(255, 255, 255);
            else
                $this->SetFillColor(255, 204, 204);
            $len=1;//$patient_arr[$ir]["product_code"]?(strlen($patient_arr[$ir]['product_name'])/60):'1';
            
         

            $this->MultiCell($w[0], 7*$len, ($patient_arr[$ir]["test_date"]), $border, 'C', 1, 0, '', '', true,0,false,true,7*$len,M);
            
            $this->MultiCell($w[1], 7*$len, ($patient_arr[$ir]['bcr_apl_no']), $border, 'C', 1, 0, '', '', true,0,false,true,7*$len,M);
            
           
			$this->Ln();
			$fill=!$fill;
            
            
            //$tcnt++;
           // if(!$patient_arr[$ir+1]["test_id"])
               // $this->Image($image_file, '', '', 230, '', '', '', '', false, 300);
               $ir++;   
               $j++;
               
               
               
               
               
               
               if($j>$prow_limit)
               {
                
                
                
            $j=0;
            $this->Cell(array_sum($w), 0, '', 'T','1');
            $this->Ln();
            $this->AddPage();
            $this->SetY(43);

        $this->SetFillColor(139,137,137);
		$this->SetTextColor(255);
		$this->SetDrawColor(0, 0, 0);        
		$this->SetLineWidth(0.3);
		$this->SetFont('times', 'B');
        
        
        
        if($patient_arr[$ir]["test_id"])
        {
    		$num_headers = count($header);
    		for($i = 0; $i < $num_headers; ++$i) {
    			$this->Cell($w[$i], 6, $header[$i], 1, 0, 'C', 1);
		  }
          
		$this->Ln();
        $this->SetFillColor(238,233,233);
		$this->SetTextColor(0);
		$this->SetFont('times', '','11');
        }
               }
               
              
            }
            
            
           }
              
      $this->SetFillColor(255, 255, 255);
	//	}
      

        //$this->Image('../../images/header1a.jpg', '0', '0', 230, 'C', '', '', '', false, 300);
        //$this->Image($image_file, 0, 0, 230, '', 'png', '', 'T', false, 300, 'C', false, false, 0, false, false, false);
        
    $ir++;
             //echo "$prow_limit - $ir -$j = ".(($ir*8)+45);
         // exit;
         
        
          if(($j+9)>=$prow_limit)
               {
                
                
                
            $j=0;
            $this->Cell(array_sum($w), 0, '', 'T','1');
            $this->Ln();
            $this->AddPage();
            $this->SetY(43);

        $this->SetFillColor(139,137,137);
		$this->SetTextColor(255);
		$this->SetDrawColor(0, 0, 0);        
		$this->SetLineWidth(0.3);
		$this->SetFont('times', 'B');
        
        
         $this->Image($image_file, '', '', 230, '', '', '', '', false, 300);
         $this->SetY(130);
        $this->SetFont('times', '','11');
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        
                                           
        $this->Cell('230', 0, 'Reference: Baccarani M, Deininger MW,Rosti G, et al.European LeukemiaNet recommendations for the management of chronic myeloid leukemia:2013.  ', 0, 1, 'L', 1);
       $this->Cell('230', 0, 'Blood 2013;122(6):872-84.doi:10.1182/blood-2013-05-501569 ', 0, 1, 'L', 1);
       $this->SetFont('times', 'B','11');
       
       $this->Cell('45', 0, 'Evaluation of the report : ', 0, 0, 'L', 1);
       if(trim($report_remark))
       {
           $this->SetFont('times', '','11');
           $this->MultiCell('180', 7, $report_remark, 0, 1, 'L', 1);
       }
       
       
               }
               else
               {
       
  $yax=$j>0?(($j*7)+53):45;//140;//
     $this->SetY("$yax");
 $this->SetTextColor(0);
$this->Cell('230', 7, ' ', 0, 1, 'C', 1);
//$this->SetFont('times', 'B','11');
$this->SetFont('times', '','11');
$this->Cell('30', 6, 'Start Date ', 0, 0, 'L', 0);
$this->SetFont('times', 'B','11');
$this->Cell('40', 6, ': '.($_GET['sdate']), 0, 0, 'L', 0);

$this->SetFont('times', '','11');
$this->Cell('30', 6, 'End Date ', 0, 0, 'L', 0);
$this->SetFont('times', 'B','11');
$this->Cell('40', 6, ': '.($_GET['edate']), 0, 0, 'L', 0);

$this->SetFont('times', '','11');
$this->Cell('40', 6, 'Treatment Type ', 0, 0, 'L', 0);
$this->SetFont('times', 'B','11');
$this->Cell('40', 6, ': '.($type_of_treatment_arr[$_GET['ttype']]), 0, 0, 'L', 0);

        
       $yax=$yax+20;//=220;//
        
        $this->SetY("$yax");
        $this->Image($image_file, '', '', 235, '', '', '', '', false, 300);
        
        $yax=$yax+80;//=220;//
        $this->SetY("$yax");
        $this->SetFont('times', '','11');
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        
        
        
        
  
        
        $this->Ln();
            $this->AddPage();
            $this->SetY(43);
        
        
                //$report_remark[0]['treatment_type']
       
        // Table with rowspans and THEAD
        $tbbl=treatment_graph($report_remark_arr[0]['treatment_type']);        

$tbl = <<<EOD
$tbbl
EOD;




//$this->writeHTML($tbl, true, false, false, false, '');
  $html = $tbl;


// output the HTML content
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
//$this->writeHTMLCell('300', 0, '', '', $tbbl, 'LRTB', 1, 0, true, 'L', true);

$this->setPageMark();
$this->SetFont('dejavusans', '', 10);
$this->writeHTML($html, true, false, true, false, '');                      

$this->lastPage();
        
        
        
        
        
        
        
        
        
        
        
        $this->Cell('230', 0, 'Reference: Baccarani M, Deininger MW,Rosti G, et al.European LeukemiaNet recommendations for the management of chronic myeloid leukemia:2013.  ', 0, 1, 'L', 1);
        
        
        
       $this->Cell('230', 0, 'Blood 2013;122(6):872-84.doi:10.1182/blood-2013-05-501569 ', 0, 1, 'L', 1);
       $this->SetFont('times', 'B','11');
       
       $this->Cell('45', 0, 'Evaluation of the report : ', 0, 0, 'L', 1);
       if(trim($report_remark))
       {
           $this->SetFont('times', '','11');
           $this->MultiCell('180', 7, $report_remark, 0, 1, 'L', 1);
       }
            }
    
        //
        // Set font
    // echo $ir;
    // exit;
          //  $this->SetY();
        
        //$this->Image($image_file, '', '', 40, 40, '', '', 'T', false, 300, '', false, false, 1, false, false, false);
         
      
        

	}
}





   // $cperson_designation_arr=cperson_designation();
        //$db->debug=1;
       // $db->debug_all=true;
        $get_max_idt=$db->get_var("select max(graph_id) from msom_graph where patient_id=".$_SESSION['mso_eln']['pviewid']);;
       $report_date_rem_arr=$db->get_results("select DATE_FORMAT(report_date,'%d-%m-%Y') as rdate,remarks,treatment_type  from msom_graph where graph_id=".$get_max_idt,ARRAY_A);
    
      $patient_arr=$db->get_results("select
    p.patient_id,p.pcode,p.pname,p.sur_name,p.gender,DATE_FORMAT(p.dob,'%d-%m-%Y') as dob,p.protocol_no,p.pmail,p.authorized_by1,p.authorized_by2,p.authorized_by3,p.physician_name,p.phy_mail,p.diagnosis,p.bcr_apl,DATE_FORMAT(p.start_date,'%d-%m-%Y') as tsdate,p.treatment_type,DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.dob)), '%Y')+0 AS age,
    
    t.test_id,DATE_FORMAT(date,'%d-%m-%Y') as test_date,t.sample_type,t.sample_sent_from,t.sample_no,t.bcr_apl_no,t.controlgene_no,t.conversion_fact ,DATE_FORMAT(p.diag_st_date,'%d-%m-%Y') as diag_stdate,p.medication_id


     from msom_patient p
     left join msom_test t on t.patient_id=p.patient_id and t.treatment_type=".$report_date_rem_arr[0]['treatment_type']."
     where p.patient_id=$id order by t.date asc",ARRAY_A);
     foreach($patient_arr as $pk=>$pv)
            $data_arr[]=$pv['bcr_apl_no'];
            
            
         $_SESSION['mso_eln']['Bcr-AplArr']=$data_arr;

//echo '<pre>';
//print_R($patient_arr);
//exit;

global $pdf;
   // create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

//$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, false, 'ISO-8859-1', false);

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
//$pdf->SetFont('times', '', 8);
$pdf->SetFont('dejavusans', '', 10);
//$pdf->SetFont('helvetica', '', 11, '', true);
// add a page
//$pdf->AddPage();

$resolution= array(250,260);
$pdf->AddPage('L', $resolution);

//Column titles
//$header = array('');

//Data loading
//$data = $tdata;

// print colored table
$pdf->ColoredTable($header, $patient_arr);

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
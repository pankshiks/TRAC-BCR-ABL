<?php
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
        $diagnosis_arr=diagnosis_arr();
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

    global $db,$guser_name,$guser_id,$patient_arr,$marr,$bcr_apl_stype_arr,$type_of_treatment_arr,$diagnosis_arr,$medication_arr;
         
 $this->SetFillColor(255, 255, 255);
//$this->SetFillColor(224, 235, 255);
$this->SetTextColor(0);
$this->SetFont('times', 'B','13');
//$this->Cell('230', 20, '', 0, 1, 'C', 1);
//$this->Ln(0.2);
//$this->SetY(5);
$this->Cell('230', 7, 'Patient Details', 0, 1, 'C', 1);


$this->SetY(20);
$this->SetFillColor(255, 255, 255);
$this->SetTextColor(0);

$this->SetFont('times', '','11');
$this->Cell('36', 6, 'Patient Name', 0, 0, 'L', 0);
$this->SetFont('times', 'B','11');
$this->Cell('85', 6,' : '. $patient_arr[0]['pname'], 0, 0, 'L', 0);
$this->SetFont('times', '','11');
$this->Cell('50', 6, "Physician's name", 0, 0, 'L', 0);
$this->SetFont('times', 'B','11');
$this->Cell('60', 6, " : ".$patient_arr[0]['physician_name'], 0, 1, 'L', 1);


$this->SetFont('times', '','11');
$this->Cell('36', 6, 'Surname', 0, 0, 'L', 0);
$this->SetFont('times', 'B','11');
$this->Cell('85', 6, ' : '.$patient_arr[0]['sur_name'], 0, 0, 'L', 0);
$this->SetFont('times', '','11');
$this->Cell('50', 6, "Physician's e-mail address", 0, 0, 'L', 0);
$this->SetFont('times', 'B','11');
$this->Cell('60', 6, ' : '.$patient_arr[0]['phy_mail'], 0, 1, 'L', 1);



$this->SetFont('times', '','11');
$this->Cell('36', 6, 'Gender', 0, 0, 'L', 0);
$this->SetFont('times', 'B','11');
$this->Cell('85', 6, ' : '.$marr[$patient_arr[0]['gender']], 0, 0, 'L', 0);
$this->SetFont('times', '','11');
//$this->Cell('50', 6, ' The diagnosis and the phase at the time of diagnosis  ', 0, 0, 'L', 0);
$this->MultiCell('50', 8, 'The diagnosis and the phase at   the time of diagnosis', 0, 'L', 0, 0, '', '', true);
$this->SetFont('times', 'B','11');
$this->Cell('60', 6, ' : '.$diagnosis_arr[$patient_arr[0]['diagnosis']], 0, 1, 'L', 1);
    

$this->SetFont('times', '','11');
$this->Cell('36', 6, 'Date of birth', 0, 0, 'L', 0);
$this->SetFont('times', 'B','11');
$this->Cell('85', 6, ' : '.$patient_arr[0]['dob'], 0, 0, 'L', 0);
$this->SetFont('times', '','11');
$this->Cell('50', 6, "", 0, 0, 'L', 0);
$this->SetFont('times', 'B','11');
$this->Cell('60', 6, "  ", 0, 1, 'L', 1);

$this->SetFont('times', '','11');
$this->Cell('36', 6, 'Hospital ID', 0, 0, 'L', 0);
$this->SetFont('times', 'B','11');
$this->Cell('85', 6, ' : '.$patient_arr[0]['protocol_no'], 0, 0, 'L', 0);
$this->SetFont('times', '','11');
$this->Cell('50', 6, "BCR-ABL transcript subtype", 0, 0, 'L', 0);
$this->SetFont('times', 'B','11');
$this->Cell('60', 6, " : ".$bcr_apl_stype_arr[$patient_arr[0]['bcr_apl']].($patient_arr[0]['bcr_apl_others']?' - '.$patient_arr[0]['bcr_apl_others']:''), 0, 1, 'L', 1);

//$this->Cell('230', 6, ' ', 0, 0, 'L', 0);
$this->SetFont('times', '','11');
$this->Cell('36', 6, "Patient's e-mail address", 0, 0, 'L', 0);
$this->SetFont('times', 'B','11');
$this->Cell('85', 6, ' : '.$patient_arr[0]['pmail'], 0, 0, 'L', 0);
$this->SetFont('times', '','11');
$this->Cell('50', 6, "Date of diagnosis", 0, 0, 'L', 0);
$this->SetFont('times', 'B','11');
$this->Cell('60', 6, " : ".$patient_arr[0]['diag_st_date'], 0, 1, 'L', 1);


$this->SetFont('times', '','11');
$this->Cell('36', 6, 'Report authorized by', 0, 0, 'L', 0);
$this->SetFont('times', 'B','11');
$this->Cell('85', 6, ' : '.$patient_arr[0]['authorized_by1'], 0, 0, 'L', 0);
$this->SetFont('times', '','11');
$this->Cell('50', 6,'Medication name', 0, 0, 'L', 0);
$this->SetFont('times', 'B','11');
$this->Cell('60', 6, " : ".$medication_arr[$patient_arr[0]['medication_id']], 0, 1, 'L', 1);


$this->SetFont('times', '','11');
$this->Cell('36', 6, 'Report authorized by', 0, 0, 'L', 0);
$this->SetFont('times', 'B','11');
$this->Cell('85', 6, ' : '.$patient_arr[0]['authorized_by2'], 0, 0, 'L', 0);
$this->SetFont('times', '','11');
$this->Cell('50', 6, 'Treatment start date', 0, 0, 'L', 0);
$this->SetFont('times', 'B','11');
$this->Cell('60', 6, ' : '.$patient_arr[0]['tsdate'], 0, 1, 'L', 1);

$this->SetFont('times', '','11');
$this->Cell('36', 6, 'Report authorized by', 0, 0, 'L', 0);
$this->SetFont('times', 'B','11');
$this->Cell('85', 6, ' : '.$patient_arr[0]['authorized_by3'], 0, 0, 'L', 0);
$this->SetFont('times', '','11');
$this->Cell('50', 6, 'Type of treatment', 0, 0, 'L', 0);
$this->SetFont('times', 'B','11');
$this->Cell('60', 6, ' : '.$type_of_treatment_arr[$patient_arr[0]['treatment_type']], 0, 1, 'L', 1);





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
        $this->SetY(-8);
       $this->SetFont('times', '', 6);
       $date = Date('d-m-Y H:i:s');
       $this->Cell('160', 0, 'Date : '.$date, 0, 0, 'L', 1);
        //$this->Cell('140', 0, '', 0, 0, 'L', 1);
        
        //$this->Cell('59', 0, 'Developed by http://www.minervasoft.net  ', 0, 0, 'R', 1);
        
        $this->SetFont('times', '', 8);
        // Page number
        $this->Cell('100', 0, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        //$this->Cell('120', 0, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), '0', '0', 230, '', '', '', '', false, '');
        
    }
    
    
    
    
	// Colored table
	public function ColoredTable($header,$patient_arr) {
		// Colors, line width and bold font
        
global $db,$guser_name,$guser_id;
   
//$this->SetY(85);

		$this->SetFillColor(139,137,137);
		$this->SetTextColor(255);
		$this->SetDrawColor(0, 0, 0);        
		$this->SetLineWidth(0.3);
		$this->SetFont('times', 'B','11');
       $this->SetY(75);
		// Header
		//$w = array(15, 115, 25,20,25,30);
        $w = array(6,25,40,50,29,78);
        $header=array('#','Date of test','Sample Type',"Sample sent from (Hospital)",'Sample #',"BCR-ABL1 Result % (International Scale)");
		$num_headers = count($header);
		for($i = 0; $i < $num_headers; ++$i) {
			$this->Cell($w[$i], 8, $header[$i], 1, 0, 'C', 1);
		}
		$this->Ln();
		// Color and font restoration
		$this->SetFillColor(238,233,233);
		$this->SetTextColor(0);
		$this->SetFont('times', '','11');
		// Data
		$fill = 0;
        $i=0;
       // $ne=$this->AddPage();
       
        
    
		 $cnt=count($patient_arr);
         
         
    $prow_limit=11;//items row limit for every page also change the for loop
    $new_cnt=number_format($cnt/$prow_limit,1,'.','');
    
list($first,$second)=explode('.',$new_cnt);
$first_c=$first=='0'?'1':$first;
$no_of_page=(($first=='0') || ($first=='1' && $second=='0') || ($first >1  && $second=='0') )?$first_c:$first+1;   //new one
         //$tcnt=0;
         $ir=0;
        for($m=1;$m<=$no_of_page;$m++)
        {
          
           if($m>1)//Add new page
           {
            $tcnt=0;
            $this->Cell(array_sum($w), 0, '', 'T','1');
            $this->Ln();
            $this->AddPage();
            $this->SetY(79);

        $this->SetFillColor(139,137,137);
		$this->SetTextColor(255);
		$this->SetDrawColor(0, 0, 0);        
		$this->SetLineWidth(0.3);
		$this->SetFont('times', 'B');
        
        
        
        
		$num_headers = count($header);
		for($i = 0; $i < $num_headers; ++$i) {
			$this->Cell($w[$i], 6, $header[$i], 1, 0, 'C', 1);
		}
		$this->Ln();
        $this->SetFillColor(238,233,233);
		$this->SetTextColor(0);
		$this->SetFont('times', '','11');
        
           }
           // set color for background
           //echo"<pre>";
           //print_R($patient_arr);
           
          for($i=8;$i<=18;$i++)
          {
            if($patient_arr[$ir]["test_id"])
            {
            $this->SetFont('times', '','10');
            if($i%2)
                $this->SetFillColor(238,233,233);
            else
                $this->SetFillColor(255, 255, 255);
            $len=1.5;//$patient_arr[$ir]["product_code"]?(strlen($patient_arr[$ir]['product_name'])/60):'1';
            
            $this->MultiCell($w[0], 7*$len, ($patient_arr[$ir]["test_id"]?$ir+1:""), 1, 'C', 1, 0, '', '', true);
            $this->MultiCell($w[1], 7*$len, ($patient_arr[$ir]["test_date"]), 1, 'C', 1, 0, '', '', true);
            
            $this->MultiCell($w[2], 7*$len, ($patient_arr[$ir]['sample_type']), 1, 'L', 1, 0, '', '', true);
            
            $this->MultiCell($w[3], 7*$len, ($patient_arr[$ir]['sample_sent_from']), 1, 'L', 1, 0, '', '', true);
            $this->MultiCell($w[4], 7*$len, ($patient_arr[$ir]["sample_no"]), 1, 'C', 1, 0, '', '', true);
            $this->MultiCell($w[5], 7*$len, ($patient_arr[$ir]["bcr_apl_no"]), 1, 'C', 1, 0, '', '', true);
                                                                                    
			
           
			$this->Ln();
			$fill=!$fill;
            
            $ir++;
            //$tcnt++;
            }
           }
		}
            
        
        

	}
}





   // $cperson_designation_arr=cperson_designation();

        // $db->debug=1;
    
    
      $patient_arr=$db->get_results("select
    p.patient_id,p.pcode,p.pname,p.sur_name,p.gender,DATE_FORMAT(p.dob,'%d-%m-%Y') as dob,p.protocol_no,p.pmail,p.authorized_by1,p.authorized_by2,p.authorized_by3,p.physician_name,p.phy_mail,p.diagnosis,p.bcr_apl,DATE_FORMAT(p.start_date,'%d-%m-%Y') as tsdate,p.treatment_type,
    
    t.test_id,DATE_FORMAT(date,'%d-%m-%Y') as test_date,t.sample_type,t.sample_sent_from,t.sample_no,t.bcr_apl_no,t.controlgene_no,t.conversion_fact,DATE_FORMAT(p.diag_st_date,'%d-%m-%Y') as diag_st_date,p.medication_id,p.bcr_apl_others


     from msom_patient p
     left join msom_test t on t.patient_id=p.patient_id
     where p.patient_id=$id",ARRAY_A);
    
             

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

$resolution= array(250,350);

$pdf->AddPage('P', $resolution);


//Column titles
//$header = array('');

//Data loading
//$data = $tdata;

// print colored table
$pdf->ColoredTable($header, $patient_arr);

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('report_'.$patient_arr[0]['pname'].'.pdf', 'D'); 




//============================================================+
// END OF FILE                                                
//============================================================+

}
        else
          	$show_errors= "<div align=left class=error>There are no records to view</div>";



?>
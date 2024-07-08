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


require_once('../../includes/tcpdf/config/lang/eng.php');
require_once('../../includes/tcpdf/tcpdf.php');
       
// extend TCPF with custom functions
class MYPDF extends TCPDF {



 public function Header()
 {

    global $db,$guser_name,$guser_id,$patient_arr,$marr,$bcr_apl_stype_arr,$type_of_treatment_arr,$diagnosis_arr;
    
    $this->SetFillColor(255, 255, 255);
    $this->SetTextColor(0);
    $this->SetFont('times', 'B','11');
    $this->Cell('330', 7, 'Patient Report', 0, 1, 'C', 1);
 }


 public function Footer() {
    global $db,$guser_name,$guser_id;
    $this->SetY(-35);
    $this->SetFillColor(139,137,137);
    $this->SetTextColor(255);
    $this->SetDrawColor(0, 0, 0);        
    $this->SetLineWidth(0.3);
    
    $this->Ln(0.5);

        
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        
       $this->SetY(-8);
       $this->SetFont('times', '', 6);
       $date = Date('d-m-Y H:i:s');
       $this->Cell('200', 0, 'Date : '.$date, 0, 0, 'L', 1);
       $this->SetFont('times', '', 8);
        $this->Cell('200', 0, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        
    }
    
    
    
    
	// Colored table
	public function ColoredTable($w,$header,$patient_arr) {
		// Colors, line width and bold font
        
global $db,$guser_name,$guser_id;
        $marr=gender_arr();
        $bcr_apl_stype_arr=bcr_apl_stype();
        $type_of_treatment_arr=treatment_type();
        $diagnosis_arr=diagnosis_arr();
        

  $this->SetY(20);
		$this->SetFillColor(139,137,137);
		$this->SetTextColor(255);
		$this->SetDrawColor(0, 0, 0);        
		$this->SetLineWidth(0.3);
		$this->SetFont('times', 'B','8');
       
		// Header
		//$w = array(15, 115, 25,20,25,30);
        
		$num_headers = count($header);
		for($i = 0; $i < $num_headers; ++$i) {
		   $len=2.1;//$patient_arr[$ir]["product_code"]?(strlen($patient_arr[$ir]['product_name'])/60):'1';
            
            $this->MultiCell($w[$i], 7*$len, ($header[$i]), 1, 'C', 1, 0, '', '', true);
			//$this->Cell($w[$i], 10, $header[$i], 1, 0, 'C', 1);
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
           
       $this->SetY(20);
		$this->SetFillColor(139,137,137);
		$this->SetTextColor(255);
		$this->SetDrawColor(0, 0, 0);        
		$this->SetLineWidth(0.3);
		$this->SetFont('times', 'B','8');
       
		// Header
		//$w = array(15, 115, 25,20,25,30);
       // $w = array(5,25,15,14,20,19,20,22,22,22,25,23,21,25,20,20);
       // $header=array('#','Name','Surname','Gender','DOB','Hospital ID',"Patient's e-mail address",'Report authorized by','Report authorized by','Report authorized by',"Physician's name","Physician's e-mail address",'The diagnosis and the phase at the time of diagnosis','BCR-ABL transcript subtype','Treatment start date','Type of treatment');
		$num_headers = count($header);
		for($i = 0; $i < $num_headers; ++$i) {
		   $len=2.1;//$patient_arr[$ir]["product_code"]?(strlen($patient_arr[$ir]['product_name'])/60):'1';
            
            $this->MultiCell($w[$i], 7*$len, ($header[$i]), 1, 'C', 1, 0, '', '', true);
			//$this->Cell($w[$i], 10, $header[$i], 1, 0, 'C', 1);
		}
		$this->Ln();
		// Color and font restoration
		$this->SetFillColor(238,233,233);
		$this->SetTextColor(0);
		$this->SetFont('times', '','11');
		// Data
		$fill = 0;  
           }
           // set color for background
           //echo"<pre>";
           //print_R($patient_arr);
           
          for($i=8;$i<=18;$i++)
          {
            if($patient_arr[$ir]['patient_id'])
            {
                $ai=1;
            //$this->SetFont('times', '','9');
            if($i%2)
                $this->SetFillColor(238,233,233);
            else
                $this->SetFillColor(255, 255, 255);
            $len=2.1;//$patient_arr[$ir]["product_code"]?(strlen($patient_arr[$ir]['product_name'])/60):'1';
            
            //$this->MultiCell($w[0], 7*$len, ($patient_arr[$ir]["pcode"]), 1, 'C', 1, 0, '', '', true);
            $this->SetFont('times', '','10');
            $this->MultiCell($w[0], 7*$len, ($ir+1), 1, 'L', 1, 0, '', '', true);
            if($_GET['c1'] && $_GET['c1']!='undefined')
            {
            $this->MultiCell($w[$ai], 7*$len, ($patient_arr[$ir]["pname"]), 1, 'L', 1, 0, '', '', true);
            $ai++;
            }
            if($_GET['c2'] && $_GET['c2']!='undefined')
            {
            $this->MultiCell($w[$ai], 7*$len, ($patient_arr[$ir]['sur_name']), 1, 'L', 1, 0, '', '', true);
            $ai++;
            }
            if($_GET['c3'] && $_GET['c3']!='undefined')  
            {     
            $this->MultiCell($w[$ai], 7*$len, ($marr[$patient_arr[$ir]['gender']]), 1, 'L', 1, 0, '', '', true);
            $ai++;
            }
            if($_GET['c4'] && $_GET['c4']!='undefined')
            {
            $this->MultiCell($w[$ai], 7*$len, ($patient_arr[$ir]["dob"]), 1, 'L', 1, 0, '', '', true);
            $ai++;
            }
            if($_GET['c5'] && $_GET['c5']!='undefined')
            {
            $this->MultiCell($w[$ai], 7*$len, ($patient_arr[$ir]["protocol_no"]), 1, 'L', 1, 0, '', '', true);
            $ai++;
            }
           if($_GET['c6'] && $_GET['c6']!='undefined')
           {
            $this->MultiCell($w[$ai], 7*$len, ($patient_arr[$ir]["pmail"]), 1, 'L', 1, 0, '', '', true);
            $ai++;
            }
            if($_GET['c7'] && $_GET['c7']!='undefined')
            {
            $this->MultiCell($w[$ai], 7*$len, ($patient_arr[$ir]["authorized_by1"]), 1, 'L', 1, 0, '', '', true);
            $ai++;
            $this->MultiCell($w[$ai], 7*$len, ($patient_arr[$ir]["authorized_by2"]), 1, 'L', 1, 0, '', '', true);
            $ai++;
            $this->MultiCell($w[$ai], 7*$len, ($patient_arr[$ir]["authorized_by3"]), 1, 'L', 1, 0, '', '', true);
            $ai++;
            }
            if($_GET['c8'] && $_GET['c8']!='undefined')
            {
            $this->MultiCell($w[$ai], 7*$len, ($patient_arr[$ir]["physician_name"]), 1, 'L', 1, 0, '', '', true);
            $ai++;
            }
            if($_GET['c9'] && $_GET['c9']!='undefined')
            {
            $this->MultiCell($w[$ai], 7*$len, ($patient_arr[$ir]["phy_mail"]), 1, 'L', 1, 0, '', '', true);
            $ai++;
            }
            if($_GET['c10'] && $_GET['c10']!='undefined')
            {
            $this->MultiCell($w[$ai], 7*$len, ($diagnosis_arr[$patient_arr[$ir]["diagnosis"]]), 1, 'L', 1, 0, '', '', true);
            $ai++;
            }
            if($_GET['c12'] && $_GET['c12']!='undefined')
            {
            $this->MultiCell($w[$ai], 7*$len, ($bcr_apl_stype_arr[$patient_arr[$ir]["bcr_apl"]].($patient_arr[$ir]["bcr_apl_others"]?' - '.$patient_arr[$ir]["bcr_apl_others"]:'')), 1, 'L', 1, 0, '', '', true);
            $ai++;
            }
            if($_GET['c13'] && $_GET['c13']!='undefined')
            {
            $this->MultiCell($w[$ai], 7*$len, ($patient_arr[$ir]["tsdate"]), 1, 'L', 1, 0, '', '', true);
            $ai++;
            }
            if($_GET['c11'] && $_GET['c11']!='undefined')
            {
            $this->MultiCell($w[$ai], 7*$len, ($type_of_treatment_arr[$patient_arr[$ir]["treatment_type"]]), 1, 'L', 1, 0, '', '', true);
            $ai++;
            }
            
                          
			$this->Ln();
			$fill=!$fill;
            
            $ir++;
            //$tcnt++;
            }
           }
		}

	}
}


    
    
   
    
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
    p.patient_id,p.pcode,p.pname,p.sur_name,p.gender,DATE_FORMAT(p.dob,'%d-%m-%Y') as dob,p.protocol_no,p.pmail,p.authorized_by1,p.authorized_by2,p.authorized_by3,p.physician_name,p.phy_mail,p.diagnosis,p.bcr_apl,DATE_FORMAT(p.start_date,'%d-%m-%Y') as tsdate,p.treatment_type,p.bcr_apl_others
    
     from msom_patient p
     where p.status='act' $condition",ARRAY_A);
    
             

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

$pdf->AddPage('L', $resolution);

//Column titles
$w = array(5);
$ai=1;
$header=array('#');
if($_GET['c1'] && $_GET['c1']!='undefined')
{
$header[$ai]="Name";
$w[$ai]='25';
$ai++;
}
if($_GET['c2'] && $_GET['c2']!='undefined')
{
$header[$ai]="Surname";
$w[$ai]='15';
$ai++;
}
if($_GET['c3'] && $_GET['c3']!='undefined')
{
$header[$ai]="Gender";
$w[$ai]='14';
$ai++;
}
if($_GET['c4'] && $_GET['c4']!='undefined')
{
$header[$ai]="DOB";
$w[$ai]='20';
$ai++;
}
if($_GET['c5'] && $_GET['c5']!='undefined')
{
$header[$ai]="Hospital ID";
$w[$ai]='19';
$ai++;
}
if($_GET['c6'] && $_GET['c6']!='undefined')
{
$header[$ai]="Patient's e-mail address";
$w[$ai]='20';
$ai++;
}
if($_GET['c7'] && $_GET['c7']!='undefined')
{
$header[$ai]="Report authorized by";
$w[$ai]='22';
$ai++;
$header[$ai]="Report authorized by";
$w[$ai]='22';
$ai++;
$header[$ai]="Report authorized by";
$w[$ai]='22';
$ai++;
}
if($_GET['c8'] && $_GET['c8']!='undefined')
{
$header[$ai]="Physician's name";
$w[$ai]='25';
$ai++;
}
if($_GET['c9'] && $_GET['c9']!='undefined')
{
$header[$ai]="Physician's e-mail address";
$w[$ai]='23';
$ai++;
}
if($_GET['c10'] && $_GET['c10']!='undefined')
{
$header[$ai]="The diagnosis and the phase at the time of diagnosis";
$w[$ai]='21';
$ai++;
}
if($_GET['c12'] && $_GET['c12']!='undefined')
{
$header[$ai]="Treatment start date";
$w[$ai]='25';
$ai++;
}
if($_GET['c13'] && $_GET['c13']!='undefined')
{
$header[$ai]="Type of treatment";
$w[$ai]='20';
$ai++;
}
if($_GET['c11'] && $_GET['c11']!='undefined')
{
$header[$ai]="BCR-ABL transcript subtype";
$w[$ai]='20';
$ai++;
}


 

//Data loading
//$data = $tdata;

// print colored table
$pdf->ColoredTable($w,$header, $patient_arr);

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('Patient_Report_'.date('d_m_Y').'.pdf', 'D'); 




//============================================================+
// END OF FILE                                                
//============================================================+




?>
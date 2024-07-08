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
    $this->Cell('330', 7, 'Overall Patient Report', 0, 1, 'C', 1);
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
	public function ColoredTable($header,$patient_arr,$last_grapharr,$last_bcrabl_arr) {
		// Colors, line width and bold font
        
global $db,$guser_name,$guser_id;
    
        $medication_arr=medication_arr();

  $this->SetY(20);
		$this->SetFillColor(139,137,137);
		$this->SetTextColor(255);
		$this->SetDrawColor(0, 0, 0);        
		$this->SetLineWidth(0.3);
		$this->SetFont('times', 'B','8');
       
		// Header
		//$w = array(15, 115, 25,20,25,30);
       $w = array(8,30,20,20,15,15,15,25,25,30,135);
        $header=array('#','Name','Date of diagnosis','Treatment start date','Last BCR-ABL result','Milestone','Time on treatment','Medication name',"Physician's name",'Sample sent from(Hospital)','Graph');
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
         
         
    $prow_limit=4;//items row limit for every page also change the for loop
    $new_cnt=number_format($cnt/$prow_limit,1,'.','');
    
list($first,$second)=explode('.',$new_cnt);
$first_c=$first=='0'?'1':$first;
$sl=1;
$no_of_page=(($first=='0') || ($first=='1' && $second=='0') || ($first >1  && $second=='0') )?$first_c:$first+1;   //new one
         //$tcnt=0;
      
     
         $ir=0;
        for($m=1;$m<=$no_of_page;$m++)
        {
          
           if($m>1 && $patient_arr[$ir]['patient_id'] && $last_grapharr[$patient_arr[$ir]['patient_id']])//Add new page
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
         $w = array(8,30,20,20,15,15,15,25,25,30,135);
        $header=array('#','Name','Date of diagnosis','Treatment start date','Last BCR-ABL result','Milestone','Time on treatment','Medication name',"Physician's name",'Sample sent from(Hospital)','Graph');
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
           $len=6;
         
            $img_x=220;
            $img_y=35;
            
            $rlimt=11;
            
          for($i=8;$i<=$rlimt;$i++)
          {
            if($patient_arr[$ir]['patient_id'] && $last_grapharr[$patient_arr[$ir]['patient_id']] && ($_GET['mstone']=='undefined' || !$_GET['mstone'] || $last_bcrabl_arr[$patient_arr[$ir]['patient_id']]['milestone']) && ($_GET['hospital']=='undefined' || !$_GET['hospital'] || $last_bcrabl_arr[$patient_arr[$ir]['patient_id']]['hospital']))
            {
            
            //$this->SetFont('times', '','9');
            if($sl%2)
                $this->SetFillColor(255, 255, 255);
            else
                $this->SetFillColor(238,233,233);

            //$len=2.1;//$patient_arr[$ir]["product_code"]?(strlen($patient_arr[$ir]['product_name'])/60):'1';
            
            //$this->MultiCell($w[0], 7*$len, ($patient_arr[$ir]["pcode"]), 1, 'C', 1, 0, '', '', true);
            $this->SetFont('times', '','10');
            $this->MultiCell($w[0], 7*$len, $sl, 1, 'L', 1, 0, '', '', true);
            $this->MultiCell($w[1], 7*$len, ($patient_arr[$ir]["pname"].' '.$patient_arr[$ir]["sur_name"]), 1, 'L', 1, 0, '', '', true);
            $this->MultiCell($w[2], 7*$len, ($patient_arr[$ir]['dof_diagnosis']), 1, 'L', 1, 0, '', '', true);
                   
            $this->MultiCell($w[3], 7*$len, ($patient_arr[$ir]['tsdate']), 1, 'L', 1, 0, '', '', true);
            $this->MultiCell($w[4], 7*$len, ($last_bcrabl_arr[$patient_arr[$ir]['patient_id']]['bcr_apl_no']), 1, 'L', 1, 0, '', '', true);
            $this->MultiCell($w[5], 7*$len, ($last_bcrabl_arr[$patient_arr[$ir]['patient_id']]['milestone']), 1, 'L', 1, 0, '', '', true);
            $this->MultiCell($w[6], 7*$len, ($patient_arr[$ir]["treatment_time"]<'30'?($patient_arr[$ir]["treatment_time"].' day(s)'):$patient_arr[$ir]["treatment_month"]), 1, 'L', 1, 0, '', '', true);
           
            $this->MultiCell($w[7], 7*$len, ($medication_arr[$patient_arr[$ir]['medication_id']]), 1, 'L', 1, 0, '', '', true);
            $this->MultiCell($w[8], 7*$len, ($patient_arr[$ir]["physician_name"]), 1, 'L', 1, 0, '', '', true);
            $this->MultiCell($w[9], 7*$len, ($last_bcrabl_arr[$patient_arr[$ir]['patient_id']]['hospital']), 1, 'L', 1, 0, '', '', true);
            $image_file ="graph/".$last_grapharr[$patient_arr[$ir]['patient_id']].".png";
             //$this->MultiCell($w[9], 7*$len, ($last_bcrabl_arr[$patient_arr[$ir]['patient_id']]['hospital']), 1, 'L', 1, 0, '', '', true);
           if(file_exists($image_file))
           {
          
          $this->MultiCell(135, 7*$len, '', 1, 'L', 1, 0, '', '', true);
          $this->Image("graph/".$last_grapharr[$patient_arr[$ir]['patient_id']].".png", $img_x,$img_y, 125,40, '', '', '', false, 300);
          //$this->writeHTMLCell(135, 7*$len, '', '', '<img src="'.$image_file.'" />5465',$border=1, $ln=0, $fill=0, $reseth=false, $align='', $autopadding=false);//
               
                }
                
               // writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
           // $this->Image("graph/".$last_grapharr[$patient_arr[$ir]['patient_id']].".png", $img_x,$img_y, 125,45, '', '', '', false, 300);
           
           //$this->writeHTMLCell($w[9], 7*$len, $img_x, $img_y, 'Lorem ipsum...<img src='.$image_file.'> Curabitur at porta dui...');
               // $this->writeHTMLCell($w[9], 7*$len, $img_x, $img_y, '<img src='.$image_file.'>', $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=false);
           //$this->writeHTMLcell($w[9], 7*$len, $img_x, $img_y, $html='<img src='.$image_file.'>', $border=1, $ln=0, $fill=false, $reseth=true, $align='', $autopadding=true);
           
           //$this->_pdfObject->MultiCell(0, 0, '<img src="'.$fileName.'">', 0, 'L', 0, 0, '', '', true, null, true);
             //$this->Image("graph/".$last_grapharr[$patient_arr[$ir]['patient_id']].".png", $img_x,$img_y, 125,45, '', '', '', false, 300);
			$this->Ln();
			$fill=!$fill;
            
            
            //$tcnt++;
            $sl++;
           // $img_x+=10;
            $img_y+=42;
            }
            elseif($patient_arr[$ir]['patient_id'])
                $rlimt+=1;
            $ir++;
           }
		}

	}
}


 $condition.=$_GET['name'] && $_GET['name']!='undefined'?" and (p.pname like '%".$_GET['name']."%' OR p.sur_name like '%".$_GET['name']."%')":'';
 $condition.=$_GET['dod'] && $_GET['dod']!='undefined'?" and p.diag_st_date='".GetFormattedDate($_GET['dod'])."'":'';
 $condition.=$_GET['tdate'] && $_GET['tdate']!='undefined'?" and p.start_date='".GetFormattedDate($_GET['tdate'])."'":'';
 $condition.=$_GET['medic_id'] && $_GET['medic_id']!='undefined'?" and p.medication_id='".$_GET['medic_id']."'":'';
 $condition.=$_GET['phy_name'] && $_GET['phy_name']!='undefined'?" and p.physician_name='".$_GET['phy_name']."'":'';
 

    
      $patient_arr=$db->get_results("select
    p.patient_id,p.pcode,p.pname,p.sur_name,DATE_FORMAT(p.start_date,'%d-%m-%Y') as tsdate,DATE_FORMAT(p.diag_st_date,'%d-%m-%Y') as dof_diagnosis,p.medication_id,p.physician_name,
    
    DATEDIFF('".date('Y-m-d')."',p.start_date) as treatment_time,
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
//$header = array('');

//Data loading
//$data = $tdata;

// print colored table
$pdf->ColoredTable($header, $patient_arr,$last_grapharr,$last_bcrabl_arr);

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('Overall_Patient_Report_'.date('d_m_Y').'.pdf', 'D');




//============================================================+
// END OF FILE                                                 
//============================================================+
?>
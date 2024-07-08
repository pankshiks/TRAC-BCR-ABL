<?php
ini_set('display_errors',false);
include($_SERVER['DOCUMENT_ROOT'].'/ELN/includes/graph/jpgraph.php');
include($_SERVER['DOCUMENT_ROOT'].'/ELN/includes/graph/jpgraph_line.php');
include($_SERVER['DOCUMENT_ROOT'].'/ELN/includes/graph/jpgraph_log.php');
include($_SERVER['DOCUMENT_ROOT'].'/ELN/includes/graph/jpgraph_scatter.php');
include($_SERVER['DOCUMENT_ROOT'].'/ELN/includes/graph/jpgraph_regstat.php');
//include($_SERVER['DOCUMENT_ROOT'].'/ELN/includes/jpgraph/jpgraph.php');
//include($_SERVER['DOCUMENT_ROOT'].'/ELN/includes/jpgraph/jpgraph_line.php');
//include($_SERVER['DOCUMENT_ROOT'].'/ELN/includes/jpgraph/jpgraph_plotline.php');
//include($_SERVER['DOCUMENT_ROOT'].'/ELN/includes/jpgraph/jpgraph_error.php');
 

   

session_start();
$datay1 =$_SESSION['mso_eln']['Bcr-AplArr'][0];


$months =array('',"3M",
'6M',
'9M',
'1stY',
"3M",
'6M',
'9M',
'2ndY',
"3M",
'6M',
'9M',
'3rdY',);//$_SESSION['mso_eln']['Bcr-AplArr'][1];


//////////////////////////////////////////////////////////////
if($_SESSION['mso_eln']['Bcr-AplArr'][1] && $_SESSION['mso_eln']['Bcr-AplArr'][4])//////find quarter plots positions
{
    $date_arr=$_SESSION['mso_eln']['Bcr-AplArr'][1];
    $j=0;
    list($ggd,$ggm,$ggy)=explode('-',$_SESSION['mso_eln']['Bcr-AplArr'][4]);
    $first_dateof_test=$ggy.'-'.$ggm.'-'.$ggd;//$_SESSION['mso_eln']['Bcr-AplArr'][1][0]
    $daylen = 60*60*24;
    
    foreach($date_arr as $dk=>$dvalue)
    {
        if($first_dateof_test)
        {
            $cval=(strtotime($dvalue)-strtotime($first_dateof_test))/$daylen;
            
            
            //$cval=$dk>0?((strtotime($dvalue)-strtotime($first_dateof_test))/$daylen):1;
            if($cval>=0)
            {
                $qrtday=ceil($cval/90);////find exact quarter
                $days_arr[$j]=$qrtday;
                $days_bcl_arr[$j]=$datay1[$dk];
                
                $quarter_arr[$qrtday]+=1;
                $j++;
            }
        }
        
    }
   
    
    if($quarter_arr)
    {
        foreach($quarter_arr as $qi=>$qv)
        {
            if(!$spoint)
                $spoint=$qi;
                $epoint=$qi;
            $quarter_point_arr[$qi]=number_format(0.8/$qv,2);
        }
    }
  

    
    if($days_arr && $quarter_point_arr)
    {
        
        foreach($days_arr as $dqk=>$dqv)
            {
                $item[$dqv]+=$quarter_point_arr[$dqv];
                $tval=($dqv-1)+$item[$dqv];
                $xdata[$dqk]=$tval<0?0:$tval;//////form Quarter posision for corresponding values
                $data[$dqk]=$days_bcl_arr[$dqk];//bcr apl values
            }
    }
}
///////////////////////////////////////////////////////////////

  
  






if($_SESSION['mso_eln']['Bcr-AplArr'][2]=='1')
{
            /* first line*/
//$optimal_max_1 = array(100,10,1,0.100,0.100,0.100,0.100,0.100,0.100,0.100,0.100,0.100);//old
//$warning_max_1 = array(0,100,100,10,1,1,1,1,1,1,1,1);
//$failure_max_1 = array(1000,1000,1000,1000,1000,1000,1000,1000,1000,1000,1000,1000);
$optimal_max_1 = array(100,10,1,0.3,0.100,0.100,0.100,0.100,0.100,0.100,0.100,0.100,0.100);
$warning_max_1 = array(0,100,9.5,3.2,1,1,1,1,1,1,1,1,1);
$failure_max_1 = array(1000,1000,1000,1000,1000,1000,1000,1000,1000,1000,1000,1000,1000);

$ex_pml=0.100;
$ex_wml=1;
$ex_fml=1000;
}
else
{
    /*Second line */
    //$optimal_max_1 = array(100,10,10,1,0.100,0.100,0.100,0.100,0.100,0.100,0.100,0.100);
    //$warning_max_1 = array(0,100,100,10,10,0.100,0.100,0.100,0.100,0.100,0.100,0.100);
    //$failure_max_1 = array(1000,1000,1000,1000,1000,1000,1000,1000,1000,1000,1000,1000);

    $optimal_max_1 = array(100,10,10,3.5,0,0.100,0.100,0.100,0.100,0.100,0.100,0.100,0.100,0.100);
    $warning_max_1 = array(0,90,0,6,10,0.9,0.9,0.9,0.9,0.9,0.9,0.9,0.9,0.9);
    $failure_max_1 = array(1000,1000,1000,1000,1000,1000,1000,1000,1000,1000,1000,1000,1000,1000);
    
    $ex_pml=0.100;
    $ex_wml=0.9;
    $ex_fml=1000;
}




$mcnt=count($months);
$micnt=count($optimal_max_1);
$maximum_qrtr=max(array_keys($quarter_arr));

    

if($micnt<$maximum_qrtr)
{
    
     for($mpl=$micnt;$mpl<=$maximum_qrtr;$mpl++)
     {
        
        $optimal_max_1[$mpl]=$ex_pml;
        $warning_max_1[$mpl]=$ex_wml;
        $failure_max_1[$mpl]=$ex_fml;
     }
}

$nmicnt=count($optimal_max_1);
    
    $xcnt=count($xdata);
    if($nmicnt<$xcnt)
    {
     for($mpl=$nmicnt;$mpl<=$xcnt;$mpl++)
     {
        
        $optimal_max_1[$mpl]=$ex_pml;
        $warning_max_1[$mpl]=$ex_wml;
        $failure_max_1[$mpl]=$ex_fml;
     }
    }
$nmicnt=count($optimal_max_1);
if($mcnt<$nmicnt)
    {


        $tmarr=array('3M','6M','9M',"thY");
        $ly=0;
        $nmicnt+=1;
        $gyr=3;
        for($ti=$mcnt;$ti<$nmicnt;$ti++)
        {
            if(!$months[$ti])
            {
            if($ly=='3')
            {
                $gyr++;
                $gdyr=$gyr;
            }
            $months[$ti]=$gdyr.$tmarr[$ly];
            $ly++;
            if($ly=='4')
                $ly=0;
                $gdyr="";
            //$months[$ti]='Q'.$ti;
            }
        }
            
    }
   
   
  

/////////Reform month for filter//////
if($_SESSION['mso_eln']['Bcr-AplArr'][7])
{
    if($months[$spoint])
    {
        $tmonth=$months;
        unset($months);
        $mi=0;
        foreach($tmonth as $mk=>$mv)
        {
            if($spoint==$mk)
                $ok='1';
            if($ok)
            {
            $months[$mi]=$mv;
            $mi++;
            if($mk==($epoint+1))
                break;
            }
        }
    }
}
//////////////////////////////////////


 /* echo '<pre>';
print_r($optimal_max_1);
echo '<=---=>';
print_r($months);
echo '<=---=>';
print_r($data);
echo '<=---=>';
print_r($xdata);
echo '<=---=>';
//$data,$xdata
print_r($quarter_point_arr);
exit;
*//*
if($_SESSION['mso_eln']['Bcr-AplArr'][7])
{
   
$topt=$optimal_max_1;
$twarn=$warning_max_1;
$tfail=$failure_max_1;
$tmonth=$months;
unset($optimal_max_1,$warning_max_1,$failure_max_1,$months);
///////////Unset needless plot//////

$i='0';//'1'
foreach($data as $opk=>$opv)//$quarter_point_arr
{
  //  if(!$tstart)
    //    $tstart=$opk;
        
    $optimal_max_1[$i]=$topt[$opk];
    $warning_max_1[$i]=$twarn[$opk];
    $failure_max_1[$i]=$tfail[$opk];
    $months[$i]=$tmonth[$opk];
    $i++;
}
/*
$tstart=$tstart-1;
if($topt[$tstart])
{
    $optimal_max_1[0]=$topt[$tstart];
    $warning_max_1[0]=$twarn[$tstart];
    $failure_max_1[0]=$tfail[$tstart];
    $months[0]=$tmonth[$tstart];
   // $xdata[0]='0';
    //$data[0]='0';
}*//*

   

/////////////Reverse  x axis value//////
if($xdata)
{
 
$mainval=explode('.',$xdata[0]);
foreach($xdata as $xi=>$xv)
{
    $xdata[$xi]=$xdata[$xi]-$mainval[0];
}
}

   
unset($topt,$twarn,$tfail,$tmonth);
/////////////////////////////////////
}*/


//$ydata = $datay1;
$graph = new Graph(1300,450,'auto');
 if(($_SESSION['mso_eln']['Bcr-AplArr'][8]=='0' || $_SESSION['mso_eln']['Bcr-AplArr'][8]) && ($_SESSION['mso_eln']['Bcr-AplArr'][9]=='0' || $_SESSION['mso_eln']['Bcr-AplArr'][9]))
    $graph->SetScale("textlog",$_SESSION['mso_eln']['Bcr-AplArr'][8],$_SESSION['mso_eln']['Bcr-AplArr'][9],($spoint-1),$epoint);
   else
    $graph->SetScale("textlog","-4",3);//,0,4
   

//$graph = new Graph(400,220,'auto');
//$graph->SetScale("textlog",'-3',3);
//$graph->SetScale("textlin",0,1000);
//$graph->SetMargin(100,100,100,100);
$graph->SetMargin(90,0,80,75);
//$graph->Set90AndMargin(50,20,50,30);
/////////////////
if($_SESSION['mso_eln']['Bcr-AplArr'][2]=='1')
{
    $l1plot=new LinePlot($optimal_max_1);
    //$l1plot->SetColor('red');
    $l1plot->SetFillColor('#7375EF');
    $l1plot->SetColor("#7375EF");
    $l1plot->SetLegend('OPTIMAL');
    
    $l2plot = new LinePlot($warning_max_1);
    $l2plot->SetFillColor('#FFF710');
    $l2plot->SetColor("#FFF710");
    $l2plot->SetLegend('WARNING');
    
    $l3plot = new LinePlot($failure_max_1);
    $l3plot->SetFillColor('#E77173');
    $l3plot->SetColor("#E77173");
    $l3plot->SetLegend('FAILURE');
}
else
{
    $l3plot = new LinePlot($failure_max_1);
    $l3plot->SetFillColor('#E77173');
    $l3plot->SetColor("#E77173");
    $l3plot->SetLegend('FAILURE');
    
    $l1plot=new LinePlot($optimal_max_1);
    $l1plot->SetFillColor('#7375EF');
    $l1plot->SetColor("#7375EF");
    $l1plot->SetLegend('OPTIMAL');
    
    $l2plot = new LinePlot($warning_max_1);
    $l2plot->SetFillColor('#FFF710');
    $l2plot->SetColor("#FFF710");
    $l2plot->SetLegend('WARNING');
  
} 
// Add the plots to the graph

$ap = new AccLinePlot(array($l1plot,$l2plot,$l3plot));
$graph->Add($ap);


    $white_arr=array(10000,10000);
    $lplot = new LinePlot($white_arr);
    $lplot->SetFillColor('white');
    $lplot->SetColor("white");


$ap1 = new AccLinePlot(array($lplot));
$graph->Add($ap1);
 ////////////////
    $graph->SetGridDepth(DEPTH_FRONT);
        $graph->xgrid->SetColor('#585858'); 
        $graph->ygrid->SetColor('#585858'); //BDBDBD


$graph->SetMarginColor('white');
    $graph->SetFrame(false);
    $graph->SetBox(false);
    $graph->SetClipping(true);
$graph->xgrid->Show(true);
$graph->ygrid->Show(true);
$graph->yaxis->HideZeroLabel();
$graph->yaxis->HideLine(true);
$graph->yaxis->HideTicks(true,true);
//print_r($months);
//exit;
//$graph->xaxis->SetTickLabels($months);
//$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,8);
//$graph->xaxis->SetLabelAngle(45);
  //$graph->xaxis->SetLabelMargin(15);
 //$graph->xaxis->SetLabelSide(SIDE_LEFT);
// $graph->xaxis->SetLabelAlign('150'); 
 
  
 //$graph->yaxis->SetTitleMargin(70);
 //$graph->xaxis->SetTitleMargin(90); 



$graph->title->Set("BCR-ABL1 expression levels over time",'left');
//$graph->title->SetColor("white");
$graph->title->SetFont(FF_FONT1,FS_BOLD);
$graph->subtitle->Set("This graph has been adapted from the ELN 2013 recommendations for the definition of response to\nTyrosine Kinase Inhibitors (TKIs) as ".$_SESSION['mso_eln']['Bcr-AplArr'][3].' treatment'."\n".$_SESSION['mso_eln']['Bcr-AplArr'][5].' - '.$_SESSION['mso_eln']['Bcr-AplArr'][6]);

//$graph->subtitle->SetColor("white");











// graph title, x axis, y axis title here
//$graph->title->Set("BCR-ABL1 expression levels over time\nThis graph has been adapted from the ELN 2013 recommendations for the definition of response to\nTyrosine Kinase Inhibitors (TKIs) as first-line treatment");
//$graph->title->SetFont(FF_FONT1,FS_BOLD);
//$graph->yaxis->title->Set("BCR-ABL Transcript number");//\n

$graph->yaxis->title->Set("Treatment start date : ".$_SESSION['mso_eln']['Bcr-AplArr'][4]);//BCR-ABL Transcript number\n
$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);

//$graph->xaxis->title->Set("DATE");
//$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);

//// mark y axis here



  

//$spline = new Spline($data,$xdata);
//list($newx,$newy) = $spline->Get(50);
$lp1 = new LinePlot($data,$xdata);
//$lp1->xaxis->SetTickLabels($data);
//$lp1 = new LinePlot($newx,$newy);

$lp1->mark->SetType(MARK_FILLEDCIRCLE);
//$lp1->SetFillColor("#D8EBFC");

//$lp1->xaxis->SetTickLabels(array('1','6'));


//$lp1->img->SetAntiAliasing(true); 
$lp1->mark->SetWidth(3);
$lp1->mark->SetFillColor("blue");
$lp1->SetColor("black");
$lp1->SetLegend("Patient");
$lp1->value->Show(); 
// Set full blue

$graph->Add($lp1);
// Hide line and tick marks


  //$lp1->value->SetFont(FF_ARIAL,FS_NORMAL,7);
//$lp1->value->SetAngle(-35);      
//$lp1->value->SetFormat('%01.3f');  
// Horizontal dotted Line Draw Here
//$upper_lt='1';
//$lplot1 = new LinePlot(array($upper_lt));
//$graph->Add($lplot1);
/*$pline1 = new PlotLine(HORIZONTAL,$upper_lt,'black',1); // upper limit
$pline1->SetWeight('1.1');
$pline1->SetLineStyle('dotted');
//$pline1->SetLegend('Date of Test');
$graph->Add($pline1);
*/
/// set legend properties
$graph->legend->SetFrameWeight(1);
$graph->legend->SetColor('#4E4E4E','#00A78A');
$graph->legend->SetMarkAbsSize(8);
$graph->legend->SetPos(0.5,0.88,'center','top');
$graph->legend->SetLayout(LEGEND_HOR);  
//$graph->footer->center->Set('Reference: Baccarani M, Deininger MW,Rosti G, et al.European LeukemiaNet recommendations for the management of chronic myeloid leukemia:2013. Blood 2013;122(6):872-84.doi:10.1182/blood-2013-05-501569');

$txt = new Text('[M-Month,Y-Year]');
$txt->SetPos(5, 420);
//$txt->SetColor('red');
$txt->SetFont(FF_FONT1,FS_BOLD);
$graph->AddText($txt); 
$graph->xaxis->SetTickLabels($months);
// Output graph
//
$graph->xaxis->scale->ticks->Set(1);

/*$tickPositions=array('1','2');
$minTickPositions=array('1');
$graph->xaxis->SetTickPositions($tickPositions,$minTickPositions);

*/
//$graph->xaxis->SetLabelFormat('');
//$graph->xaxis->SetTextTickInterval(1,0);
//$graph->xaxis->scale->SetGrace(0,1);
//$graph->xaxis->SetTickLabels($months);
//print_r($xdata);
//print_r($data);
//exit;
if($ind_id)
  $graph->Stroke("./graph/ind_$ind_id.png");  
else
    $graph->Stroke();
?>
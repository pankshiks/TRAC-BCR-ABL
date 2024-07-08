<?php

/* =============================================================================
 File Name    : functions.inc
 Created on   : 06.12.2014
 Created By   : 
 Modified  on : 
 Modified By  : 
 Purpose      : 
 Notes        :
==============================================================================*/
include($_SERVER['DOCUMENT_ROOT'].'/ELN/includes/ezsql/ezsql_conn.inc');
date_default_timezone_set('Asia/Calcutta');

function findminmax_yaxix($data)
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
  // echo "<br>".$ret;     
      return $ret;
}


      return $ret;
}

function gender_arr()
{
    return array('m'=>'Male','f'=>'Female');//,'o'=>'Others'
}


function getoutarray($id)
{
    $oparr[1]=array('HTML'=>'HTML');
    $oparr[2]=array('HTML'=>'HTML','CSV'=>'CSV');
    $oparr[3]=array('HTML'=>'HTML','CSV'=>'CSV','TEXT'=>'TEXT');
    $oparr[4]=array('HTML'=>'HTML','CSV'=>'CSV','TEXT'=>'TEXT','GRAPH'=>'GRAPH');
    $oparr[5]=array('HTML'=>'HTML','CSV'=>'CSV','TEXT'=>'TEXT','GRAPH'=>'GRAPH','PDF'=>'PDF');
    $oparr[6]=array('HTML'=>'HTML','CSV'=>'CSV','TEXT'=>'TEXT','PDF'=>'PDF');
    $oparr[7]=array('HTML'=>'HTML','EXCEL'=>'EXCEL');
    $oparr[8]=array('HTML'=>'HTML','EXCEL'=>'EXCEL','GRAPH'=>'GRAPH');
    return $oparr[$id];
}



function writemlog($page,$values,$in_time,$out_time)
{
    global $db,$guser_id;
    $f_path="../../log/$guser_id/".$page."_addpat_".date('M_W_Y').".txt";
    file_put_contents($f_path,"\n".str_pad(CONST_UNAME,10).' '.' '.'User Name:'.$page.' '.'Entering Time'.$in_time.' '.'Logout Time'.$out_time.' '.'Staying Time:'.$values,FILE_APPEND);
    return 'ok';
}







        function getFormattedDate($given_date,$format="dd-mm-yyyy",$separator="-")
        {
        // convert the string to date array format
        switch ($format)
                {
                case "dd/mm/yyyy":
                        list ($day, $month, $year) = explode ($separator, $given_date);
                        break;
                case "mm/dd/yyyy":
                        list ($month, $day, $year) = explode ($separator, $given_date);
                        break;
                 case "dd-mm-yyyy"://Added 11/02/2014
                        list ($day, $month, $year) = explode ($separator, $given_date);
                        break;
                }
        $date_array=array ($year, $month, $day);
        //convert the date array to the string
        $date_string=implode ('-', $date_array);
        return $date_string;
        }







    
function bcr_apl_stype()
{
    return array(1=>'P210',2=>'Other');
}
function treatment_type()
{
    return array(1=>'First line',2=>'Second line intolerance',3=>'Second line failure');
}
function diagnosis_arr()
{
    return array(1=>'CML Chronic Phase',2=>'CML Accelerated Phase',3=>'CML Blastic Phase'); //,4=>'Other'
}
function medication_arr()
{
    return array(1=>'Imatinib 400mg QD',2=>'Nilotinib 300mg BID',3=>'Nilotinib 400mg BID',4=>'Dasatinib 100mg QD',5=>'Dasatinib 140mg QD',6=>'Ponatinib 45mg QD',7=>'Bosutinib 500mg QD',8=>'Others'); 
}

function treatment_graph($type)
{
    $arr['1']='
<table id="igraph" style="border-collapse: collapse;border:2px solid #F79F81;"><tr><th style="height:27px;border:2px solid #F79F81;"></th>
<th style="border:2px solid #F79F81;">Optimal</th><th style="border:2px solid #F79F81;">Warning</th><th style="border:2px solid #F79F81;">Failure</th></tr>
<tr><td style="background-color: #F6CECE; border:2px solid #F79F81; height:24px;">Baseline</td><td style="background-color: #F6CECE; border:2px solid #F79F81; height:24px;">NA</td><td style="background-color: #F6CECE; border:2px solid #F79F81; height:24px;">High risk
Or
CCA/Ph+, major route
</td><td style="background-color: #F6CECE; border:2px solid #F79F81; height:24px;">NA</td></tr>

<tr><td  style="border:2px solid #F79F81; height:24px;">3 mo</td><td style="border:2px solid #F79F81; height:24px;">BCR-ABL1 &le;10%
and/or
Ph+ &le;35%
</td><td  style="border:2px solid #F79F81; height:24px;">BCR-ABL1 &ge;10%
and/or
Ph+ 36-95%
</td><td  style="border:2px solid #F79F81; height:24px;">Non-CHR
and/or
Ph+ &ge;95%
</td></tr>

<tr><td style="background-color: #F6CECE; border:2px solid #F79F81; height:24px;">6 mo</td><td style="background-color: #F6CECE; border:2px solid #F79F81; height:24px;">BCR-ABL1 &le;1%
and/or
Ph+ 0
</td><td style="background-color: #F6CECE; border:2px solid #F79F81; height:24px;">BCR-ABL1 1-10%
and/or
Ph+ 1-35%
</td><td style="background-color: #F6CECE; border:2px solid #F79F81; height:24px;">BCR-ABL1 &ge;10%
and/or
Ph+ &ge;35%
</td></tr>
<tr><td style="border:2px solid #F79F81; height:24px;">12 mo</td><td style="border:2px solid #F79F81; height:24px;">BCR-ABL1 &le;0.1%</td><td style="border:2px solid #F79F81; height:24px;">BCR-ABL1 &ge;0.1-1%</td><td style="border:2px solid #F79F81; height:24px;">BCR-ABL1 &ge;1%
and/or
Ph+ &ge;0
</td></tr>
<tr><td rowspan="5"  style="background-color: #F6CECE; border:2px solid #F79F81; height:24px;">Then, and at any time</td><td rowspan="5" style="background-color: #F6CECE; border:2px solid #F79F81; height:24px;">BCR-ABL1 &le;0.1%</td><td rowspan="5" style="background-color: #F6CECE; border:2px solid #F79F81; height:24px;">CCA/Ph-
(-7, or 7q-)
</td><td style="background-color: #F6CECE; border:2px solid #F79F81; height:24px;">Loss of CHR</td></tr>
<tr><td style="background-color: #F6CECE; border:2px solid #F79F81; height:24px;">Loss of CcyR</td></tr>
<tr><td style="background-color: #F6CECE; border:2px solid #F79F81; height:24px;">Confirmed loss of MMR<sup>*</sup></td></tr>
<tr><td style="background-color: #F6CECE; border:2px solid #F79F81; height:24px;">Mutations</td></tr>
<tr><td style="background-color: #F6CECE; border:2px solid #F79F81; height:24px;">CCA/Ph+</td></tr>
</table>';


$arr['2']='

<table id="igraph" style="border-collapse: collapse;border:2px solid #F79F81;"><tr><th  style="border:2px solid #F79F81;"></th>
<th  style="height:27px;border:2px solid #F79F81;">Optimal</th><th style="border:2px solid #F79F81;">Warning</th><th  style="border:2px solid #F79F81;">Failure</th></tr>
<tr><td   style="background-color: #F6CECE; border:2px solid #F79F81; height:24px;">Baseline</td><td   style="background-color: #F6CECE; border:2px solid #F79F81; height:24px;">NA</td><td  style="background-color: #F6CECE; border:2px solid #F79F81; height:24px;">No CHR or loss of CHR on imatinib or
lack of CyR to first-line TKI
or
high risk
</td><td  style="background-color: #F6CECE; border:2px solid #F79F81; height:24px;">NA</td></tr>

<tr><td style="border:2px solid #F79F81; height:24px;">3 mo</td><td style="border:2px solid #F79F81; height:24px;">BCR-ABL1 &le;10%
and/or
Ph+ &ge; 65%

</td><td style="border:2px solid #F79F81; height:24px;">BCR-ABL1 &ge;10%
and/or
Ph+ 65-95%
</td><td style="border:2px solid #F79F81; height:24px;">No CHR
or
Ph+ &ge;95%
or
new mutations
</td></tr>

<tr><td  style="background-color: #F6CECE; border:2px solid #F79F81; height:24px;">6 mo</td><td style="background-color: #F6CECE; border:2px solid #F79F81; height:24px;">BCR-ABL1 =10%
and/or
Ph+ &le; 35%
</td><td style="background-color: #F6CECE; border:2px solid #F79F81; height:24px;">Ph+ 35-65%
</td><td style="background-color: #F6CECE; border:2px solid #F79F81; height:24px;">BCR-ABL1 &ge;10%
and/or
Ph+ &ge;65%
and/or
new mutations

</td></tr>
<tr><td style="border:2px solid #F79F81; height:24px;">12 mo</td><td style="border:2px solid #F79F81; height:24px;">BCR-ABL1 &le;1%
and/or
Ph+ 0
</td><td style="border:2px solid #F79F81; height:24px;">BCR-ABL1 1-10%
and/or
Ph+ 1-35%
</td><td style="border:2px solid #F79F81; height:24px;">BCR-ABL1 &ge;10%
and/or
Ph+ &ge;35%
and/or
new mutations

</td></tr>
<tr><td style="background-color: #F6CECE; border:2px solid #F79F81; height:24px;">Then, and at any time</td><td  style="background-color: #F6CECE; border:2px solid #F79F81; height:24px;">BCR-ABL1 &le;0.1%</td><td style="background-color: #F6CECE; border:2px solid #F79F81; height:24px;">CCA/Ph- (-7 or 7q-)
or
BCR-ABL1 &ge;0.1%
</td><td  style="background-color: #F6CECE; border:2px solid #F79F81; height:24px;">Loss of CHR
or
loss of CCyR or PCyR
New mutations
Confirmed loss of MMR*
CCA/Ph+
</td></tr>

</table>';

return $arr[$type];
}
?>
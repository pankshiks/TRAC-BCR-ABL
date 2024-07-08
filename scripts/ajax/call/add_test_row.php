<?php
include($_SERVER['DOCUMENT_ROOT'].'/ELN/includes/layout/default_page_layout.inc');
$next_row=$_POST['id'];

    $slno=$_POST['lid']?$_POST['lid']:$next_row;
    $slno+=1;
    
    $arr[0]['succ']="
    <tr class=".($next_row%2?'row2':'row1')." id=\"tbody_tr_$next_row\">
    <td align=\"center\"><label id=\"sl_no_$next_row\">$slno</lable></td>  
    <td align=\"center\"><input class=txt_box type=text name=\"dot[$next_row]\" id=\"dot_$next_row\" {$date_validation_string} onFocus=\"displayCalendar(document.add_patient_form.dot_$next_row,'dd-mm-yyyy',this)\"  size=8 readonly=\"\" autocomplete=\"off\" /></td>
    <td align=\"center\"><input class=txt_box type=text name=\"stest[$next_row]\" id=\"stest[$next_row]\" size=\"18\" maxlength=\"30\" autocomplete=\"off\" /></td>
    <td align=\"center\"><input class=txt_box type=text name=\"ssent_from[$next_row]\" id=\"ssent_from[$next_row]\" size=\"18\" maxlength=\"30\" autocomplete=\"off\" /></td>
    <td align=\"center\"><input class=txt_box type=text name=\"sno[$next_row]\" id=\"sno[$next_row\" size=\"15\" maxlength=\"20\" autocomplete=\"off\" /></td>
    <td align=\"center\"><input class=txt_box type=text name=\"apltrans_no[$next_row]\" id=\"apltrans_no[$next_row]\" size=\"15\" maxlength=\"20\" autocomplete=\"off\" /></td>
    <td align=\"center\"><span class=\"remove_class\"><span class=\"add\"><input type=\"button\" value=\"Add Test\" name=\"add\" id=\"add_nrow\" class=\"button\" onclick=\"add_row();return false\"/></span></span></td></tr>";
     
//    <td><input class=txt_box type=text name=\"genetrans_no[$next_row]\" id=\"genetrans_no[$next_row]\" size=\"15\" maxlength=\"20\" autocomplete=\"off\" /></td>
//<td><input class=txt_box type=text name=\"con_factor[$next_row]\" id=\"con_factor[$next_row]\" size=\"4\" maxlength=\"2\" autocomplete=\"off\" /></td>
     $arr[0]['clid']=$slno;
     
   echo '{"json_return_array":'.json_encode($arr).'}';    
?>
<?php /* Smarty version Smarty-3.0.6, created on 2024-07-05 17:11:48
         compiled from "../templates\patient_report.tpl" */ ?>
<?php /*%%SmartyHeaderCode:816687dbfc1e7228-28281750%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1f5a2bf85a421e4c15813eb4e162242bd948caee' => 
    array (
      0 => '../templates\\patient_report.tpl',
      1 => 1720179440,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '816687dbfc1e7228-28281750',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_html_options')) include 'C:\wamp\www\ELN\includes\Smarty306\libs\plugins\function.html_options.php';
if (!is_callable('smarty_function_cycle')) include 'C:\wamp\www\ELN\includes\Smarty306\libs\plugins\function.cycle.php';
?><?php $_template = new Smarty_Internal_Template("header.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<script language='JavaScript' src='../../js/jquery.bpopup.min.js'></script>

<script type="text/javascript">

 $(function(){
$(document).click(function(e){   
if(e.target.id!='rec_mail' && e.target.id!='mail' && e.target.id!='sendmail'){
  $('#semail').html('<input type="button" name="mail" id="mail" value="E-mail" class="button" onclick="show_mail();"/>'); //hide the button
}
  });
});

function gotosetting()
{
window.location='project_settings.php';
}
$(document).ready(function() {
		 $("#mail").click(function(e){
                // Prevents the default action to be triggered. 
                e.preventDefault();

                // Triggering bPopup when click event is fired
      $('#mail_to_pop_up').bPopup({
            contentContainer:'.content'
            
        });
            
        
                                
    });
	});
function goto_test(id)
{

$.ajax({
	   		url: "../ajax/call/patient_view.php",
	   		type: "POST",
	   		data: {"pid":id},
	   		success: function(data) {
                    window.location ="add_patient_test.php";
	   		}
	   		}); 
		
	
}

function reset_form()
{
    window.location='patient_report.php';
/*
    $('#pat_report input[type=text]').attr('value','');
    $('#pat_report input[type=radio]').attr('checked','');
    $('select', $('#pat_report ')).val('');
*/
}
function showhide()
{
     $( "#showhide" ).toggle( "slow", function() {});
}

function gotoprint()
{
         
        $.post('patient_report_print.php', { "name":$("#name").val(),"surname": $("#surname").val(), "gender" : $("#gender").val() , "dob" : $("#dob").val() , "prot_no" : $("#prot_no").val() , "pemail" : $("#pemail").val() , "authorized1" : $("#authorized1").val() , "phy_name" : $("#phy_name").val() , "phy_mail" : $("#phy_mail").val() , "diag" : $("#diag").val() , "bcr_apl_stype" : $("#bcr_apl_stype").val() , "tsdate" : $("#tsdate").val() , "type_of_treatment" : $("#type_of_treatment").val(),"c1":$("#c1:checked").val() , "c2" : $("#c2:checked").val() , "c3" : $("#c3:checked").val() , "c4" : $("#c4:checked").val() , "c5" : $("#c5:checked").val(), "c6" : $("#c6:checked").val() , "c7" : $("#c7:checked").val() , "c8": $("#c8:checked").val() , "c9": $("#c9:checked").val() , "c10" : $("#c10:checked").val() , "c11" : $("#c11:checked").val() , "c12" : $("#c12:checked").val() , "c13" : $("#c13:checked").val() }, function (result) {
            WinId =window.open("", "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=500, left=500, width=400, height=400,menubar=1");
            WinId.document.open();
            WinId.document.write(result);
            WinId.document.close();
        });
    
 // window.open("patient_report_print.php", "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=500, left=500, width=400, height=400,menubar=1");

}

function show_mail()
{
    
    document.getElementById('semail').innerHTML="<input type=text name=rec_mail id=rec_mail size=20 placeholder='Enter mail id' class='txt_box'/><input type=button name='sendmail' id='sendmail' value='Send Mail' class=button onclick=send_mail();>"; 
}
function send_mail()
{
         document.getElementById("sendmail").value="Sending.Please wait.";
        document.getElementById("sendmail").disabled = true;

  $.ajax({
	   	
            url: "../../scripts/ajax/call/send_report_mail.php",
	   		type: "POST",
	   		data: {"mailid":document.getElementById('rec_mail').value,"name":$("#name").val(),"surname": $("#surname").val(), "gender" : $("#gender").val() , "dob" : $("#dob").val() , "prot_no" : $("#prot_no").val() , "pemail" : $("#pemail").val() , "authorized1" : $("#authorized1").val() , "phy_name" : $("#phy_name").val() , "phy_mail" : $("#phy_mail").val() , "diag" : $("#diag").val() , "bcr_apl_stype" : $("#bcr_apl_stype").val() , "tsdate" : $("#tsdate").val() , "type_of_treatment" : $("#type_of_treatment").val(),"c1":$("#c1:checked").val() , "c2" : $("#c2:checked").val() , "c3" : $("#c3:checked").val() , "c4" : $("#c4:checked").val() , "c5" : $("#c5:checked").val(), "c6" : $("#c6:checked").val() , "c7" : $("#c7:checked").val() , "c8": $("#c8:checked").val() , "c9": $("#c9:checked").val() , "c10" : $("#c10:checked").val() , "c11" : $("#c11:checked").val() , "c12" : $("#c12:checked").val() , "c13" : $("#c13:checked").val()},
            dataType: 'json', 
   			success: function(data) {
	  	    $.each(data.json_return_array, function(key, val)
            {
                if(val.succ)
    			{
    			     alert(val.succ);
                      window.location.reload();
    			}
                 else if(val.ref)
                 {
                        alert(val.ref);
                        window.location.reload();
                        
                 }
                 else
                 {
                    alert(val.err);
                 }
                 
                 document.getElementById("sendmail").value="Send Mail";
                 document.getElementById("sendmail").disabled = false;


                 
   	        });
	   		}
	   		});
}
function gotopdfprint()
{
   var url = "patient_reort_pdf.php?name=" + $("#name").val() + "&surname=" + $("#surname").val() + "&gender=" + $("#gender").val() + "&dob=" + $("#dob").val() + "&prot_no=" + $("#prot_no").val() + "&pemail=" + $("#pemail").val() + "&authorized1=" + $("#authorized1").val() + "&phy_name=" + $("#phy_name").val() + "&phy_mail=" + $("#phy_mail").val() + "&diag=" + $("#diag").val() + "&bcr_apl_stype=" + $("#bcr_apl_stype").val() + "&tsdate=" + $("#tsdate").val() + "&type_of_treatment=" + $("#type_of_treatment").val() + "&c1=" + $("#c1:checked").val() + "&c2=" + $("#c2:checked").val() + "&c3=" + $("#c3:checked").val() + "&c4=" + $("#c4:checked").val() + "&c5=" + $("#c5:checked").val() + "&c6=" + $("#c6:checked").val() + "&c7=" + $("#c7:checked").val() + "&c8=" + $("#c8:checked").val() + "&c9=" + $("#c9:checked").val() + "&c10=" + $("#c10:checked").val() + "&c11=" + $("#c11:checked").val() + "&c12=" + $("#c12:checked").val() + "&c13=" + $("#c13:checked").val() ;
      
  window.open(url, "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=500, left=500, width=400, height=400,menubar=1");

}
function gotoxlprint()
{
   
            
       var url = "patient_report_xlprint.php?name=" + $("#name").val() + "&surname=" + $("#surname").val() + "&gender=" + $("#gender").val() + "&dob=" + $("#dob").val() + "&prot_no=" + $("#prot_no").val() + "&pemail=" + $("#pemail").val() + "&authorized1=" + $("#authorized1").val() + "&phy_name=" + $("#phy_name").val() + "&phy_mail=" + $("#phy_mail").val() + "&diag=" + $("#diag").val() + "&bcr_apl_stype=" + $("#bcr_apl_stype").val() + "&tsdate=" + $("#tsdate").val() + "&type_of_treatment=" + $("#type_of_treatment").val()+
       
        "&c1=" + $("#c1:checked").val() + "&c2=" + $("#c2:checked").val() + "&c3=" + $("#c3:checked").val() + "&c4=" + $("#c4:checked").val() + "&c5=" + $("#c5:checked").val() + "&c6=" + $("#c6:checked").val() + "&c7=" + $("#c7:checked").val() + "&c8=" + $("#c8:checked").val() + "&c9=" + $("#c9:checked").val() + "&c10=" + $("#c10:checked").val() + "&c11=" + $("#c11:checked").val() + "&c12=" + $("#c12:checked").val() + "&c13=" + $("#c13:checked").val() ;
     
            window.open(url, "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=500, left=500, width=400, height=400,menubar=1");

}

function remove_patient(id)
{
    if(id)
    {
            $.ajax({
    	   		url: "../ajax/call/del_patient.php",
    	   		type: "POST",
                data: {"id":id},
                dataType: 'json',
                success: function(rdata) {
    	  	    $.each(rdata.json_return_array, function(key, val){
                if(val.succ)
    			{
    			     alert(val.succ);
                     window.location='patient_report.php';
    			}
                else
                    { alert(val.err);}

                	});
    	   		}
    	   		});
    }
    
}
</script>
<style type="text/css">
th{
    text-align:center;
  
}

#mail_to_pop_up { 
    display:none;
    background-color: white;
    font-weight:bold;
    height:90px;
     border-radius:10px;
    padding: 6px;
    
    }

</style>


<form id="pat_report" name="pat_report" method="post" action="patient_report.php">
<div id="mail_to_pop_up"><button class="alertbutton" style="top:55px;left:25px" onclick="gotosetting();">Configure e-mail address</button> <button class="alertbutton b-close" style="top:55px;left:286px"><span>e-mail configured</span></button><br />&nbsp; Please Configure your e-mail ID in settings section to use this feature &nbsp;</div>
<table width="100%"><tr><td valign="top" width="100%">


<table><tr><td><input type="button" name="sh" id="sh" value="Show/Hide Column" class="button" onclick="showhide(); return false;"/></td>
<td><span id="showhide"><?php echo $_smarty_tpl->getVariable('column_arr')->value[0];?>
<?php echo $_smarty_tpl->getVariable('column_arr')->value[1];?>
<?php echo $_smarty_tpl->getVariable('column_arr')->value[2];?>
<?php echo $_smarty_tpl->getVariable('column_arr')->value[3];?>
<?php echo $_smarty_tpl->getVariable('column_arr')->value[4];?>
<?php echo $_smarty_tpl->getVariable('column_arr')->value[5];?>
<?php echo $_smarty_tpl->getVariable('column_arr')->value[6];?>
<?php echo $_smarty_tpl->getVariable('column_arr')->value[7];?>

<?php echo $_smarty_tpl->getVariable('column_arr')->value[8];?>
<br /><?php echo $_smarty_tpl->getVariable('column_arr')->value[9];?>
<?php echo $_smarty_tpl->getVariable('column_arr')->value[10];?>
<?php echo $_smarty_tpl->getVariable('column_arr')->value[11];?>
<?php echo $_smarty_tpl->getVariable('column_arr')->value[12];?>
<?php echo $_smarty_tpl->getVariable('column_arr')->value[13];?>
</span></td></tr></table>

<input type="submit" name="search" id="search" value="Filter" class="button"/>
<input type="reset" name="reset" id="reset" value="Reset" class="button" onclick="reset_form(); return false;"/><br />



</td></tr>
<tr><td width="120%">
<?php echo $_smarty_tpl->getVariable('show_errors')->value;?>

<?php if ($_smarty_tpl->getVariable('report_arr')->value){?>
<table width="100%"  id="gradient-style" summary="Meeting Results" style="table-layout: fixed;">
<tr class="row1">
<td width="2%" class="td_padd"></td>
<?php if (($_POST['c1'])=='1'||!$_POST){?><td width="7%" class="td_padd"><input type="text" class="txt_box" name="name" id="name" value="<?php echo $_POST['name'];?>
" size="8"/></td><?php }?>
<?php if (($_POST['c2'])=='1'||!$_POST){?><td width="6%" class="td_padd"><input type="text" class="txt_box" name="surname" id="surname" value="<?php echo $_POST['surname'];?>
" size="6"/></td><?php }?>
<?php if (($_POST['c3'])=='1'||!$_POST){?><td width="3%" class="td_padd"><select name="gender" id="gender" class="narrow"><option value="">--Select--</option>
<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->getVariable('marr')->value,'selected'=>($_POST['gender'])),$_smarty_tpl);?>
</select></td><?php }?>
<?php if (($_POST['c4'])=='1'||!$_POST){?><td width="6%" class="td_padd"><input type="text" class="txt_box" name="dob" id="dob" value="<?php echo $_POST['dob'];?>
"  onFocus="displayCalendar(document.pat_report.dob,'dd-mm-yyyy',this)"  size="6"/></td><?php }?>
<?php if (($_POST['c5'])=='1'||!$_POST){?><td width="6%" class="td_padd"><input type="text" class="txt_box" name="prot_no" id="prot_no" value="<?php echo $_POST['prot_no'];?>
" size="7"/></td><?php }?>
<?php if (($_POST['c6'])=='1'){?><td width="7%" class="td_padd"><input type="text" class="txt_box" name="pemail" id="pemail" value="<?php echo $_POST['pemail'];?>
" size="8"/></td><?php }?>
<?php if (($_POST['c7'])=='1'){?><td width="6%" class="td_padd"><input type="text" class="txt_box" name="authorized1" id="authorized1" value="<?php echo $_POST['authorized1'];?>
" size="6"/></td><?php }?>
<?php if (($_POST['c7'])=='1'){?><td width="6%" class="td_padd"><input type="text" class="txt_box" name="authorized2" id="authorized2" value="<?php echo $_POST['authorized2'];?>
" size="6"/></td><?php }?>
<?php if (($_POST['c7'])=='1'){?><td width="6%" class="td_padd"><input type="text" class="txt_box" name="authorized3" id="authorized3" value="<?php echo $_POST['authorized3'];?>
" size="6"/></td><?php }?>

<?php if (($_POST['c8'])=='1'){?><td width="6%" class="td_padd"><input type="text" class="txt_box" name="phy_name" id="phy_name" value="<?php echo $_POST['phy_name'];?>
" size="6"/></td><?php }?>
<?php if (($_POST['c9'])=='1'){?><td width="7%" class="td_padd"><input type="text" class="txt_box" name="phy_mail" id="phy_mail" value="<?php echo $_POST['phy_mail'];?>
" size="6"/></td><?php }?>
<?php if (($_POST['c10'])=='1'){?><td width="8%" class="td_padd" align="center"><select name="diag" id="diag" class="narrow"><option value="">--Select--</option><?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->getVariable('diagnosis_arr')->value,'selected'=>($_POST['diag'])),$_smarty_tpl);?>
</select></td><?php }?>
<?php if (($_POST['c11'])=='1'){?><td width="6%" class="td_padd" align="center"><select name="bcr_apl_stype" id="bcr_apl_stype" class="narrow"><option value="">--Select--</option><?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->getVariable('bcr_apl_stype_arr')->value,'selected'=>($_POST['bcr_apl_stype'])),$_smarty_tpl);?>
</select></td><?php }?>
<?php if (($_POST['c12'])=='1'){?><td width="6%" class="td_padd"><input type="text" class="txt_box" name="tsdate" id="tsdate" value="<?php echo $_POST['tsdate'];?>
"  onFocus="displayCalendar(document.pat_report.tsdate,'dd-mm-yyyy',this)"  size="6"/></td><?php }?>
<?php if (($_POST['c13'])=='1'){?><td width="8%" class="td_padd"><select name="type_of_treatment" id="type_of_treatment" class="medium">
   <option value="">--Select--</option><?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->getVariable('type_of_treatment_arr')->value,'selected'=>($_POST['type_of_treatment'])),$_smarty_tpl);?>
</select></td><?php }?>
<?php if (($_POST['c14'])=='1'||!$_POST){?><td width="4%" class="td_padd"></td><?php }?>

</tr><tr style="word-wrap: break-word;">

<th width="2%" class="head_padd">#</th>
<?php if (($_POST['c1'])=='1'||!$_POST){?><th width="7%" class="head_padd">Name</th><?php }?>
<?php if (($_POST['c2'])=='1'||!$_POST){?><th width="6%" class="head_padd">Surname</th><?php }?>
<?php if (($_POST['c3'])=='1'||!$_POST){?><th width="3%" class="head_padd">Gender</th><?php }?>
<?php if (($_POST['c4'])=='1'||!$_POST){?><th width="6%" class="head_padd">DOB</th><?php }?>
<?php if (($_POST['c5'])=='1'||!$_POST){?><th width="6%" class="head_padd">Hospital ID</th><?php }?>
<?php if (($_POST['c6'])=='1'){?><th width="7%" class="head_padd">Patient's e-mail Address</th><?php }?>
<?php if (($_POST['c7'])=='1'){?><th width="6%" class="head_padd">Report authorized by</th><?php }?>
<?php if (($_POST['c7'])=='1'){?><th width="6%" class="head_padd">Report authorized by</th><?php }?>
<?php if (($_POST['c7'])=='1'){?><th width="6%" class="head_padd">Report authorized by</th><?php }?>

<?php if (($_POST['c8'])=='1'){?><th width="6%" class="head_padd">Physician's name</th><?php }?>
<?php if (($_POST['c9'])=='1'){?><th width="7%" class="head_padd">Physician's e-mail address</th><?php }?>
<?php if (($_POST['c10'])=='1'){?><th width="8%" class="head_padd">The diagnosis and the phase at the time of diagnosis</th><?php }?>
<?php if (($_POST['c11'])=='1'){?><th width="6%" class="head_padd">BCR-ABL transcript subtype</th><?php }?>
<?php if (($_POST['c12'])=='1'){?><th width="6%" class="head_padd">Treatment start date</th><?php }?>
<?php if (($_POST['c13'])=='1'){?><th width="8%" class="head_padd">Type of treatment</th><?php }?>
<?php if (($_POST['c14'])=='1'||!$_POST){?><th width="4%" class="head_padd">Delete</th><?php }?>
</tr>

<?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('report_arr')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['value']->key;
?>

<tr class="<?php echo smarty_function_cycle(array('values'=>"row1,row2"),$_smarty_tpl);?>
" style="word-wrap: break-word;">

<td class="td_padd"><?php echo $_smarty_tpl->tpl_vars['key']->value+1;?>
</td>
<?php if (($_POST['c1'])=='1'||!$_POST){?><td class="td_padd"><a href="javascript:void(0);" title="Goto Add Patient Test" onclick="goto_test(<?php echo $_smarty_tpl->tpl_vars['value']->value['patient_id'];?>
)"><?php echo $_smarty_tpl->tpl_vars['value']->value['pname'];?>
</a></td><?php }?>
<?php if (($_POST['c2'])=='1'||!$_POST){?><td class="td_padd"><?php echo $_smarty_tpl->tpl_vars['value']->value['sur_name'];?>
</td><?php }?>
<?php if (($_POST['c3'])=='1'||!$_POST){?><td class="td_padd"><?php echo $_smarty_tpl->getVariable('marr')->value[$_smarty_tpl->tpl_vars['value']->value['gender']];?>
</td><?php }?>
<?php if (($_POST['c4'])=='1'||!$_POST){?><td class="td_padd"><?php echo $_smarty_tpl->tpl_vars['value']->value['dob'];?>
</td><?php }?>
<?php if (($_POST['c5'])=='1'||!$_POST){?><td class="td_padd"><?php echo $_smarty_tpl->tpl_vars['value']->value['protocol_no'];?>
</td><?php }?>
<?php if (($_POST['c6'])=='1'){?><td class="td_padd"><?php echo $_smarty_tpl->tpl_vars['value']->value['pmail'];?>
</td><?php }?>
<?php if (($_POST['c7'])=='1'){?><td class="td_padd"><?php echo $_smarty_tpl->tpl_vars['value']->value['authorized_by1'];?>
</td><?php }?>
<?php if (($_POST['c7'])=='1'){?><td class="td_padd"><?php echo $_smarty_tpl->tpl_vars['value']->value['authorized_by2'];?>
</td><?php }?>
<?php if (($_POST['c7'])=='1'){?><td class="td_padd"><?php echo $_smarty_tpl->tpl_vars['value']->value['authorized_by3'];?>
</td><?php }?>
<?php if (($_POST['c8'])=='1'){?><td class="td_padd"><?php echo $_smarty_tpl->tpl_vars['value']->value['physician_name'];?>
</td><?php }?>
<?php if (($_POST['c9'])=='1'){?><td class="td_padd"><?php echo $_smarty_tpl->tpl_vars['value']->value['phy_mail'];?>
</td><?php }?>
<?php if (($_POST['c10'])=='1'){?><td class="td_padd"><?php echo $_smarty_tpl->getVariable('diagnosis_arr')->value[$_smarty_tpl->tpl_vars['value']->value['diagnosis']];?>
</td><?php }?>
<?php if (($_POST['c11'])=='1'){?><td class="td_padd"><?php echo $_smarty_tpl->getVariable('bcr_apl_stype_arr')->value[$_smarty_tpl->tpl_vars['value']->value['bcr_apl']];?>
<?php if ($_smarty_tpl->tpl_vars['value']->value['bcr_apl']){?><br /><?php echo $_smarty_tpl->tpl_vars['value']->value['bcr_apl_others'];?>
<?php }?></td><?php }?>
<?php if (($_POST['c12'])=='1'){?><td class="td_padd"><?php echo $_smarty_tpl->tpl_vars['value']->value['tsdate'];?>
</td><?php }?>
<?php if (($_POST['c13'])=='1'){?><td class="td_padd"><?php echo $_smarty_tpl->getVariable('type_of_treatment_arr')->value[$_smarty_tpl->tpl_vars['value']->value['treatment_type']];?>
</td><?php }?>
<?php if (($_POST['c14'])=='1'||!$_POST){?><td class="td_padd" align="center"><a href="javascript:void(0);" onclick="if(confirm('Do you want to delete this patient details?'))remove_patient(<?php echo $_smarty_tpl->tpl_vars['value']->value['patient_id'];?>
); return false;" title="Delete this row"><img  src="../../images/minus.png" width="25" height="25"/></a></td><?php }?>


</tr>

<?php }} ?>
</table>


<br />
<center><table width="40%"><tr>
<td width="10%"><span id="semail"><input type="button" name="mail" id="mail" value="E-mail" class="button" onclick="show_mail();"/></span></td>
<td width="10%"><input type="button" name="print" id="print" value="Print" class="button" onclick="gotoprint(); return false;"/></td>
<td width="10%"><input type="button" name="pdf" id="pdf" value="Export as PDF" class="button" onclick="gotopdfprint(); return false;"/></td>
<td width="10%"><input type="button" name="xl" id="xl" value="Export to excel" class="button" onclick="gotoxlprint(); return false;"/></td>

</tr></table></center>
<?php }?>

</td></tr></table>




<?php if ($_POST&&$_POST['output']=='GRAPH'){?>
<?php echo $_smarty_tpl->getVariable('graph_str')->value;?>

<?php }?>
</form>

<?php $_template = new Smarty_Internal_Template("footer.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

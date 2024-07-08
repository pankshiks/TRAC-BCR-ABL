<?php /* Smarty version Smarty-3.0.6, created on 2024-07-01 17:54:10
         compiled from "../templates\poverall_details_report.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1391666829fea34e613-09733711%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1043df0edf72105bf3180d9e43399aa099d1c414' => 
    array (
      0 => '../templates\\poverall_details_report.tpl',
      1 => 1442222983,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1391666829fea34e613-09733711',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_html_options')) include 'C:\wamp\www\ELN\includes\Smarty306\libs\plugins\function.html_options.php';
if (!is_callable('smarty_function_cycle')) include 'C:\wamp\www\ELN\includes\Smarty306\libs\plugins\function.cycle.php';
?><?php $_template = new Smarty_Internal_Template("header_ind.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

<script type="text/javascript">

function reset_form()
{
    window.location='poverall_details_report.php';
}



function gotopdfprint()
{
   var url = "patient_overall_pdf.php?name="+ $("#name").val() + "&phy_name=" + $("#phy_name").val() + "&mstone=" + $("#mstone").val() + "&hospital=" + $("#hospital").val()+ "&medic_id=" + $("#medic_id").val()+ "&dod=" + $("#dod").val()+ "&tdate=" + $("#tdate").val();
      
  window.open(url, "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=500, left=500, width=400, height=400,menubar=1");

}
function gotoxlprint()
{
  
            
       var url = "patient_overall_xlprint.php?name="+ $("#name").val() + "&phy_name=" + $("#phy_name").val() + "&mstone=" + $("#mstone").val() + "&hospital=" + $("#hospital").val() + "&medic_id=" + $("#medic_id").val()+ "&dod=" + $("#dod").val()+ "&tdate=" + $("#tdate").val();
        
        window.open(url, "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=500, left=500, width=400, height=400,menubar=1");


    }



</script>


<form id="pat_report" name="pat_report" method="post" action="">


  <div id="maindiv">
  <input type="submit" name="search" id="search" value="Filter" class="button"/>
<input type="reset" name="reset" id="reset" value="Reset" class="button" onclick="reset_form(); return false;"/><br />


 <?php if ($_smarty_tpl->getVariable('patient_arr')->value){?>
    <table width="100%"  id="gradient-style">
   
    <tr class="row1">
    <td width="2%" height="30px;"></td>
    <td width="7%"><input type="text" class="txt_box" name="name" id="name" value="<?php echo $_POST['name'];?>
" size="12" maxlength="20"/></td>
    <td width="4%"><input type="text" class="txt_box" name="dod" id="dod" value="<?php echo $_POST['dod'];?>
"  onFocus="displayCalendar(document.pat_report.dod,'dd-mm-yyyy',this)"  size="6"/></td>        
    <td width="4%"><input type="text" class="txt_box" name="tdate" id="tdate" value="<?php echo $_POST['tdate'];?>
"  onFocus="displayCalendar(document.pat_report.tdate,'dd-mm-yyyy',this)"  size="6"/></td>    
    <td width="7%"></td> 
    <td width="7%"><input type="text" class="txt_box" name="mstone" id="mstone" value="<?php echo $_POST['mstone'];?>
" size="5" maxlength="10"/></td> 
    
       <td width="5%"></td>    
    <td width="16%">
    
        <select name="medic_id" id="medic_id" class="medium">
        <option value="">--Select--</option>
        <?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->getVariable('medication_arr')->value,'selected'=>($_POST['medic_id'])),$_smarty_tpl);?>
</select>
      
    </td>    
    <td width="5%"><input type="text" class="txt_box" name="phy_name" id="phy_name" value="<?php echo $_POST['phy_name'];?>
" size="10" maxlength="50"/></td>
    <td width="5%"><input type="text" class="txt_box" name="hospital" id="hospital" value="<?php echo $_POST['hospital'];?>
" size="10" maxlength="50"/></td>
      
    <td width="30%"></td>
   </tr>
   
   
   <tr>
        <th width="2%" height="30px;">#</th>
        <th width="7%">Name</th>
        <th width="4%">Date of diagnosis</th>        
        <th width="4%">Treatment start date</th>
        <th width="7%">Last BCR-ABL result</th>
        <th width="7%">Milestone</th>
        <th width="5%">Time on treatment</th>
        <th width="16%">Medication name</th>
        <th width="5%">Physician's name</th>
        <th width="5%">Sample sent from<br />(Hospital)</th>
        <th width="30%">Graph</th>
   </tr>
   <?php $_smarty_tpl->tpl_vars["j"] = new Smarty_variable(1, null, null);?>
    <?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->value = 0;
  if ($_smarty_tpl->getVariable('i')->value<$_smarty_tpl->getVariable('pcnt')->value){ for ($_foo=true;$_smarty_tpl->getVariable('i')->value<$_smarty_tpl->getVariable('pcnt')->value; $_smarty_tpl->tpl_vars['i']->value++){
?>
  <?php if ($_smarty_tpl->getVariable('last_grapharr')->value[$_smarty_tpl->getVariable('patient_arr')->value[$_smarty_tpl->tpl_vars['i']->value]['patient_id']]&&(!$_POST['hospital']||($_smarty_tpl->getVariable('last_bcrabl_arr')->value[$_smarty_tpl->getVariable('patient_arr')->value[$_smarty_tpl->tpl_vars['i']->value]['patient_id']]['hospital']))&&(!$_POST['mstone']||($_smarty_tpl->getVariable('last_bcrabl_arr')->value[$_smarty_tpl->getVariable('patient_arr')->value[$_smarty_tpl->tpl_vars['i']->value]['patient_id']]['milestone']))){?>
    
    <tr class="<?php echo smarty_function_cycle(array('values'=>"row1,row2"),$_smarty_tpl);?>
">
    <td width=""><?php echo $_smarty_tpl->getVariable('j')->value++;?>
</td>
    <td width=""><a href="javascript:void(0);" onclick="goback(<?php echo $_smarty_tpl->getVariable('patient_arr')->value[$_smarty_tpl->tpl_vars['i']->value]['patient_id'];?>
,'ind_graph_det.php');" title="To view individual graph click here..."><?php echo $_smarty_tpl->getVariable('patient_arr')->value[$_smarty_tpl->tpl_vars['i']->value]['pname'];?>
 <?php echo $_smarty_tpl->getVariable('patient_arr')->value[$_smarty_tpl->tpl_vars['i']->value]['sur_name'];?>
</a></td>
    <td width=""><?php echo $_smarty_tpl->getVariable('patient_arr')->value[$_smarty_tpl->tpl_vars['i']->value]['dof_diagnosis'];?>
</td>
    <td width=""><?php echo $_smarty_tpl->getVariable('patient_arr')->value[$_smarty_tpl->tpl_vars['i']->value]['tsdate'];?>
</td>
    <td width=""><?php echo $_smarty_tpl->getVariable('last_bcrabl_arr')->value[$_smarty_tpl->getVariable('patient_arr')->value[$_smarty_tpl->tpl_vars['i']->value]['patient_id']]['bcr_apl_no'];?>
</td>
    <td width=""><?php echo $_smarty_tpl->getVariable('last_bcrabl_arr')->value[$_smarty_tpl->getVariable('patient_arr')->value[$_smarty_tpl->tpl_vars['i']->value]['patient_id']]['milestone'];?>
</td>
    <td width=""><?php echo $_smarty_tpl->getVariable('patient_arr')->value[$_smarty_tpl->tpl_vars['i']->value]['treatment_time']<'30' ? (($_smarty_tpl->getVariable('patient_arr')->value[$_smarty_tpl->tpl_vars['i']->value]['treatment_time']).(' day(s)')) : ($_smarty_tpl->getVariable('patient_arr')->value[$_smarty_tpl->tpl_vars['i']->value]['treatment_month']);?>
</td>
    <td width=""><?php echo $_smarty_tpl->getVariable('medication_arr')->value[$_smarty_tpl->getVariable('patient_arr')->value[$_smarty_tpl->tpl_vars['i']->value]['medication_id']];?>
</td>
    <td width=""><?php echo $_smarty_tpl->getVariable('patient_arr')->value[$_smarty_tpl->tpl_vars['i']->value]['physician_name'];?>
</td>
    <td width=""><?php echo $_smarty_tpl->getVariable('last_bcrabl_arr')->value[$_smarty_tpl->getVariable('patient_arr')->value[$_smarty_tpl->tpl_vars['i']->value]['patient_id']]['hospital'];?>
</td>
    <td width="" align="center"><img style="cursor:pointer" title="Click here to go to the  Patient Data Report" onclick="goback(<?php echo $_smarty_tpl->getVariable('patient_arr')->value[$_smarty_tpl->tpl_vars['i']->value]['patient_id'];?>
,'patient_details_report.php');"  src="./graph/<?php echo $_smarty_tpl->getVariable('last_grapharr')->value[$_smarty_tpl->getVariable('patient_arr')->value[$_smarty_tpl->tpl_vars['i']->value]['patient_id']];?>
.png" width="500" height="200"/></td>
  
     </tr>
    
   <?php }?>
    <?php }} ?>
    
    
    
    </table>
    
    <?php }?>
   
    
    <?php if ($_smarty_tpl->getVariable('patient_arr')->value){?>
    <br />
<center><table width="20%"><tr>
<td width="10%"></td>

<td width="10%"><input type="button" name="pdf" id="pdf" value="Export as PDF" class="button" onclick="gotopdfprint(); return false;"/></td>
<td width="10%"><input type="button" name="xl" id="xl" value="Export to excel" class="button" onclick="gotoxlprint(); return false;"/></td>
<td width="10%"></td>

</tr></table></center>
<?php }?>
 
<?php echo $_smarty_tpl->getVariable('show_errors')->value;?>

    </div>

</form>

<?php $_template = new Smarty_Internal_Template("footer.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
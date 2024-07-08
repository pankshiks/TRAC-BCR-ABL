<?php /* Smarty version Smarty-3.0.6, created on 2024-07-01 18:15:31
         compiled from "../templates\project_settings.tpl" */ ?>
<?php /*%%SmartyHeaderCode:245346682a4ebe7b470-97183300%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a0ffe7a24a2028bbdb9a99954b73bd8391030cc4' => 
    array (
      0 => '../templates\\project_settings.tpl',
      1 => 1442041137,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '245346682a4ebe7b470-97183300',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template("header.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

<script type="text/javascript">
function submit_form() {
var serializedData = $("#add_patient_form").serialize();
$.ajax({
	   	
            url: "../../scripts/ajax/call/settings.php",
	   		type: "POST",
	   		data: serializedData,
            dataType: 'json', 
   			success: function(data) {
	  	    $.each(data.json_return_array, function(key, val)
            {
                if(val.succ)
    			{
    			     alert(val.succ);
                     window.location='index.php';
    			}
                 else
                 {
                        alert(val.err);
                 }
   	        });
	   		}
	   		});
}
</script>

 
<form id="add_patient_form" name="add_patient_form" method="post">
   <!-- <div style="width:100%;float:left;"></div>!--><?php echo $_smarty_tpl->getVariable('show_errors')->value;?>

   
  <table id="gradient-style" summary="Meeting Results">
 
    <tr class="row1">
    <td width="25%">Default password<sup>*</sup></td>
    <td width="25%">
    <input  type="password" class="txt_box" name="def_password"  id="def_password"  value="" autocomplete="off" maxlength="30"   size="50"  placeholder="Enter your current password for changes to take place"/>
    </td>
   
    <td width="25%">Mail sender</td>
    <td width="25%"><input  type="text" class="txt_box" name="msender"  id="msender"  value="<?php echo $_smarty_tpl->getVariable('report_arr')->value[0]['mail_sender'];?>
" autocomplete="off"   size="50" maxlength="50" placeholder="Ex:Name.Surname@Mail-Server.Com"/></td>
    </tr>	
   
    <tr class="row2">
       <td>Username</td>
       <td><input  type="text" class="txt_box" name="luname"  id="luname"  value="<?php echo $_smarty_tpl->getVariable('report_arr')->value[0]['user_name'];?>
" autocomplete="off"   size="50" maxlength="15" placeholder="User Name"/></td>
       <td>Mail Subject </td>
       <td><input class="txt_box" name="msubject"  id="msubject" value="<?php echo $_smarty_tpl->getVariable('report_arr')->value[0]['mail_subject'];?>
" autocomplete="off"  type="text" placeholder="Molecular Follow-Up-Eln 2014" size="50" maxlength="200"/></td>
    </tr>
       <tr class="row2">
       <td>New Password</td>
       <td colspan="3"><input  type="password" class="txt_box" name="new_password"  id="new_password"  value="" autocomplete="off"   size="50" maxlength="20" placeholder="Leave blank if you don't want to change."/></td>
      
    </tr>
      
    <tr class="row1">
    <td>Re-type new password</td>
    <td colspan="3">
    <input class="txt_box" name="re_new_password"  id="re_new_password" value="" autocomplete="off"  type="password"  size="50" maxlength="20"/>    </td></tr> 
 
    
    
    <tr class="row1">
    <td>Institution</td>
    <td colspan="3">
    <input class="txt_box" name="instit"  id="instit" value="<?php echo $_smarty_tpl->getVariable('report_arr')->value[0]['institution'];?>
" autocomplete="off"  type="text"  size="50" maxlength="25" />    </td></tr> 
    
       <tr class="row1">
    <td>Procedure</td>
    <td colspan="3">
    <textarea name="pro_dure" id="pro_dure" style="width: 923px; height: 41px;"><?php echo $_smarty_tpl->getVariable('report_arr')->value[0]['sprocedure'];?>
</textarea>    </td></tr> 
    
      <tr class="row1">
    <td>Mail Server</td>
    <td colspan="3">
    <input class="txt_box" name="mserver"  id="mserver" value="<?php echo $_smarty_tpl->getVariable('report_arr')->value[0]['mail_server'];?>
" autocomplete="off"  type="text"  placeholder="Ex: smtp.mail-server.com" size="50" maxlength="100"/>
   </td></tr> 
    
      <tr class="row1">
    <td>Mail port</td>
    <td colspan="3">
    <input class="txt_box" name="mport"  id="mport" value="<?php echo $_smarty_tpl->getVariable('report_arr')->value[0]['mail_port'];?>
" autocomplete="off"  type="text"  size="50" maxlength="50" placeholder="Ex: 25"/></td></tr> 
      <tr class="row1">
      
      <tr class="row1">
    <td>Mail username</td>
    <td colspan="3">
    <input class="txt_box" name="musername"  id="musername" value="<?php echo $_smarty_tpl->getVariable('report_arr')->value[0]['mail_uname'];?>
" autocomplete="off"  type="text"  size="50" maxlength="50" placeholder="Ex:Name.Surname@Mail-Server.Com"/> </td></tr> 
    

      <tr class="row1">
    <td>Mail password</td>
    <td>
    <input class="txt_box" name="mail_password"  id="mail_password" value="<?php echo $_smarty_tpl->getVariable('report_arr')->value[0]['mail_pword'];?>
" autocomplete="off"  type="password"  size="50" maxlength="30"/>    </td>
    <td colspan="2" align="right"><input type="submit" name="save" id="save" value="Save" class="button" onclick="if(confirm('Are you sure?'))submit_form(); return false;"/></td>
    </tr> 
    
     
      

    </table>
 <?php echo $_smarty_tpl->getVariable('menu_str')->value;?>

</form>
<?php $_template = new Smarty_Internal_Template("footer.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<?php /* Smarty version Smarty-3.0.6, created on 2024-07-01 17:27:35
         compiled from "../templates\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18959668299af9e9df8-29555489%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '640171bba002182ed4c71d3b4902eb617d462bcd' => 
    array (
      0 => '../templates\\index.tpl',
      1 => 1439802240,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18959668299af9e9df8-29555489',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template("header_ind.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

<script type="text/javascript">
function goto_page(id)
{
   

  $.ajax({
	   		url: "../ajax/call/goto_page.php",
	   		type: "POST",
	   		data: {"id":id},
	   		success: function(data) {

                    window.location = data;
              
	   		}
	   		}); 
		
	
}
</script>


<div class="error"><?php echo $_GET['msg'];?>
</div><br />
<br /><br />
     
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        
        <tr>
          <td height="36" valign="top">
          
          
          
          
          <table width="97%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td>
              
              
              
              <table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="189"><div align="center" class="add1"><a href="javascript:void(0);" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image3','','../../images/add1up.png',1)" onclick="goto_page('add_patient.php');return false;" title="To Add New Patient click here..."><img src="../../images/add1.png" name="Image3" width="189" height="210" border="0" id="Image3" /></a></div></td>
                  <td width="85">&nbsp;</td>
                  <td width="189"><div align="center" class="add1"><a  href="../master/patient_report.php" title="Go to View Listed Patient" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image5','','../../images/view1up.png',1)"><img src="../../images/view1.png" name="Image5" width="189" height="210" border="0" id="Image5" /></a></div></td>
                  <td width="85">&nbsp;</td>
                  <td width="189"><div align="center" class="add1"><a href="../master/project_settings.php" title="Settings" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image6','','../../images/change1up.png',1)"><img src="../../images/change1.png" name="Image6" width="189" height="210" border="0" id="Image6" /></a></div></td>
                  
                  
                  
                    <td width="85">&nbsp;</td>
                  <td width="189"><div align="center" class="add1"><a href="../master/db_backup.php" title="Settings" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image7','','../../images/backup1up.png',1)"><img src="../../images/backup1.png" name="Image7" width="189" height="210" border="0" id="Image7" /></a></div></td>
                  
                  
                </tr>
              </table>
              
              
              </td>
            </tr>
          </table>
          
          
          </td>
        </tr>
        <tr>
          <td height="36">&nbsp;</td>
        </tr>
      </table>
      
<?php $_template = new Smarty_Internal_Template("footer.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
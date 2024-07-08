<?php /* Smarty version Smarty-3.0.6, created on 2024-07-01 18:18:53
         compiled from "../templates\db_backup.tpl" */ ?>
<?php /*%%SmartyHeaderCode:239096682a5b5f0aab0-11551791%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'dffd030fc21abcb7a417986d0320b866d42f35eb' => 
    array (
      0 => '../templates\\db_backup.tpl',
      1 => 1439802243,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '239096682a5b5f0aab0-11551791',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template("header.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>


 
<form id="db_backup_form" name="db_backup_form" method="post" enctype="multipart/form-data">
  <?php echo $_smarty_tpl->getVariable('show_errors')->value;?>

   <center>
  <table>
    <tr class="row1">
    <td><input type="submit" class="button" placeholder="Select the file to upload" name="backup" id="backup" value="Backup" onclick="return (confirm('Are you sure?'));"/></td><td></td>
    <td><input type="file" name="afile" id="afile"/> : <input type="submit" class="button" name="restore" id="restore" value="Restore from backup" onclick="return (confirm('Are you sure?'));"/></td>
    </tr>
  </table></center>
 
</form>
<?php $_template = new Smarty_Internal_Template("footer.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
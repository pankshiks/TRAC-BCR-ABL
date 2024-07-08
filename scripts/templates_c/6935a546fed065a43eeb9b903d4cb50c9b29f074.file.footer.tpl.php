<?php /* Smarty version Smarty-3.0.6, created on 2024-07-01 17:27:35
         compiled from "../templates\footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:31909668299afaa3f61-41054871%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6935a546fed065a43eeb9b903d4cb50c9b29f074' => 
    array (
      0 => '../templates\\footer.tpl',
      1 => 1439802242,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '31909668299afaa3f61-41054871',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_block_php')) include 'C:\wamp\www\ELN\includes\Smarty306\libs\plugins\block.php.php';
?></td>
              </tr>
              <tr>
                <td><div align="right"><?php echo $_smarty_tpl->getVariable('back_button')->value;?>
</div></td>
              </tr>
              
          </table></td>
        </tr>
        <tr>
          <td height="36">&nbsp;</td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td height="20">&nbsp;</td>
    </tr>
  </table>
</div>
<div id="header1">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="40" bgcolor="#941A21"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="72%">
          <a href="index.php" class="<?php if ($_smarty_tpl->getVariable('default_select')->value){?><?php echo $_smarty_tpl->getVariable('default_select')->value;?>
<?php }else{ ?><?php $_smarty_tpl->smarty->_tag_stack[] = array('php', array()); $_block_repeat=true; smarty_block_php(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
 echo 'hometoplink26';<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_php(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<?php }?>" >Home</a> 
          <a href="javascript:void(0);" onclick="goto_page('add_patient.php');return false;" class="<?php if ($_smarty_tpl->getVariable('default_select1')->value){?><?php echo $_smarty_tpl->getVariable('default_select1')->value;?>
<?php }else{ ?><?php $_smarty_tpl->smarty->_tag_stack[] = array('php', array()); $_block_repeat=true; smarty_block_php(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
 echo 'hometoplink26';<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_php(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<?php }?>">Add Patient</a>
          <a href="poverall_details_report.php" class="<?php if ($_smarty_tpl->getVariable('default_select3')->value){?><?php echo $_smarty_tpl->getVariable('default_select3')->value;?>
<?php }else{ ?><?php $_smarty_tpl->smarty->_tag_stack[] = array('php', array()); $_block_repeat=true; smarty_block_php(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
 echo 'hometoplink26';<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_php(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<?php }?>">Overall Report</a>
          </td>
          <td width="28%"><div align="right"><a href="../moderator/user_script/logout.php" class="hometoplink26">Logout</a></div></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td height="100" class="header-logo-bg"><table width="97%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td height="100"><img src="../../images/logo2.png" alt="" width="472" height="97" /></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td height="20" background="../../images/top_bg.png" bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
  </table>
</div>
<div id="footer2">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="25"><table width="97%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="66%" height="25"><!--<div align="left"><a href="#" class="hometoplink28">Home</a> <span class="title_10nee23">&nbsp;&nbsp;|&nbsp;&nbsp; </span><a href="#" class="hometoplink28">Change Password</a></div>--></td>
          <td width="34%"><div align="left" class="title_10nee">
            <!--<div align="right" class="title_10nee">Developed By Minerva Soft 2014</div>-->
          </div></td>
        </tr>
      </table></td>
    </tr>
  </table>
</div>
</body>
<img src="../../images/page_bg1.jpg" class="fp_bgImage" />
</html>


<script type="text/javascript">

function CompareDates(smallDate,largeDate,separator) 
{
        
   
    
    var smallDateArr = Array(); var largeDateArr = Array();

smallDateArr     = smallDate.split(separator);
largeDateArr     = largeDate.split(separator);

var smallDt      = smallDateArr[0];
var smallMt      = smallDateArr[1];
var smallYr      = smallDateArr[2];

var largeDt      = largeDateArr[0];
var largeMt      = largeDateArr[1];
var largeYr      = largeDateArr[2];

  
if(smallYr<largeYr)
    return 0;
else if(smallYr==largeYr && smallMt<largeMt)
    return 0;
else if(smallYr<=largeYr && smallMt==largeMt && smallDt<largeDt)
    return 0;
else 
    return 1;
}

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

function goback(id,page)
{
   

  $.ajax({
	   		url: "../ajax/call/goback.php",
	   		type: "POST",
	   		data: {"id":id},
	   		success: function(data) {

                    window.location = page;
              
	   		}
	   		}); 
		
	
}
</script>
<script TYPE="text/javascript">
<!--
//Disable right click script
//visit http://www.rainbow.arch.scriptmania.com/scripts/
var message="Sorry, right-click has been disabled";
///////////////////////////////////
function clickIE() {if (document.all) {(message);return false;}}
function clickNS(e) {if
(document.layers||(document.getElementById&&!document.all)) {
if (e.which==2||e.which==3) {(message);return false;}}}
if (document.layers)
{document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS;}
else{document.onmouseup=clickNS;document.oncontextmenu=clickIE;}
document.oncontextmenu=new Function("return false")
// -->
</script> 
<style type="text/css">
input:focus::-webkit-input-placeholder { color:transparent; }
input:focus:-moz-placeholder { color:transparent; } /* FF 4-18 */
input:focus::-moz-placeholder { color:transparent; } /* FF 19+ */
input:focus:-ms-input-placeholder { color:transparent; } /* IE 10+ */</style>


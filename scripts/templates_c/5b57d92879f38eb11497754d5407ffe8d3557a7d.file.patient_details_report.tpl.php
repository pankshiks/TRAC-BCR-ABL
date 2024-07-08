<?php /* Smarty version Smarty-3.0.6, created on 2024-07-02 16:34:49
         compiled from "../templates\patient_details_report.tpl" */ ?>
<?php /*%%SmartyHeaderCode:218346683ded1e8a498-66811789%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5b57d92879f38eb11497754d5407ffe8d3557a7d' => 
    array (
      0 => '../templates\\patient_details_report.tpl',
      1 => 1442045043,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '218346683ded1e8a498-66811789',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_html_options')) include 'C:\wamp\www\ELN\includes\Smarty306\libs\plugins\function.html_options.php';
if (!is_callable('smarty_block_php')) include 'C:\wamp\www\ELN\includes\Smarty306\libs\plugins\block.php.php';
?><?php $_template = new Smarty_Internal_Template("header_ind.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
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
function gotoppage(id)
{
window.location=id;
}
function reset_form()
{
    window.location='patient_details_report.php';
}
function gotosetting()
{
window.location='project_settings.php';
}

function mail_popup()
{
         $('#mail_to_pop_up').bPopup({
            contentContainer:'.content'
        });
}
    
function gotoprint()
{
    window.open("print_graph.php?sdate="+document.getElementById("sdate").value+'&edate='+document.getElementById("edate").value+'&ttype='+document.getElementById("sel_type_of_treatment").value, "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=500, left=500, width=400, height=400,menubar=1");
}
function gotopdfprint()
{
    window.open("print_graph_pdf.php?sdate="+document.getElementById("sdate").value+'&edate='+document.getElementById("edate").value+'&ttype='+document.getElementById("sel_type_of_treatment").value, "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=500, left=500, width=400, height=400,menubar=1");
}
function show_mail()
{
    document.getElementById('semail').innerHTML="<input type='text' name='rec_mail' id='rec_mail' size='20' placeholder='Enter mail id' class='txt_box'/><input type=button name=sendmail id=sendmail value='Send Mail' class=button onclick=send_mail();>";
}

function send_mail()
{
    
   document.getElementById("sendmail").value="Sending.Please wait.";
   document.getElementById("sendmail").disabled = true; 
    
   
   
      $.ajax({
	   	
            url: "../../scripts/ajax/call/send_attachmail.php",
	   		type: "POST",
	   		data: {"mailid":document.getElementById('rec_mail').value,"sdate":document.getElementById("sdate").value,"edate":document.getElementById("edate").value,"ttype":document.getElementById("sel_type_of_treatment").value},
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

function submit_form(pid) {
$.ajax({
	   	
            url: "../../scripts/ajax/call/save_graph_data.php",
	   		type: "POST",
	   		data: {"id":pid,"evalution":document.getElementById('evalution').value,"stid":document.getElementById('stid').value,"rdate":document.getElementById('rep_date').value,"sel_type_of_treatment":document.getElementById('sel_type_of_treatment').value,"sdate":document.getElementById('sdate').value,"edate":document.getElementById('edate').value},
            dataType: 'json', 
   			success: function(data) {
	  	    $.each(data.json_return_array, function(key, val)
            {
                if(val.succ)
                {
                    alert(val.succ);
                    alert('Redirecting to report page');                     
                    window.location='pind_details_report.php';
                   
                }
                else if(val.err)
                    {
                        alert(val.err);
                    }
   	        });
	   		}
	   		});
}


function changetoftreatment() {
$.ajax({
	   	
            url: "../../scripts/ajax/call/change_tof_treatment.php",
	   		type: "POST",
	   		data: {"id":document.getElementById('type_of_treatment').value},
            dataType: 'json', 
   			success: function(data) {
	  	    $.each(data.json_return_array, function(key, val)
            {
                if(val.succ)
                {
                    window.location=val.succ;
                }
               
   	        });
	   		}
	   		});
}
</script>
<style type="text/css">

#mail_to_pop_up { 
    display:none;
    background-color: white;
    font-weight:bold;
    height:90px;
    
    }
#show_pop_up {
    display:none;
    background-color: white;
    font-weight:bold;
    height:90px;
    border-radius:10px;
    padding: 6px;
    }


</style>

<form id="pat_report" name="pat_report" method="post" action="">
<div id="mail_to_pop_up"><button class="alertbutton" id="smail" style="top:55px;left:25px" onclick="gotosetting();">Configure e-mail address</button> <button class="alertbutton b-close" style="top:55px;left:286px" id="trigmailx"><span>e-mail configured</span></button><br />&nbsp; Please Configure your e-mail ID in settings section to use this feature &nbsp;</div>

<div id="show_pop_up" style="width:380px;align:center;" align="center"><button class="alertbutton" id="trigok" style="top:55px;left:20px">Ok</button> <button class="alertbutton b-close" style="top:55px;left:200px"><span>Cancel</span></button><br />&nbsp; Please ensure you have saved the graph &nbsp;</div>
<?php echo $_smarty_tpl->getVariable('show_errors')->value;?>

<?php if ($_smarty_tpl->getVariable('patient_arr')->value){?>
<?php echo $_smarty_tpl->getVariable('body_str')->value;?>


  <input type="submit" name="search" id="search" value="Filter" class="button"/>
  <input type="reset" name="reset" id="reset" value="Reset" class="button" onclick="reset_form(); return false;"/><br />


    <table width="100%"  id="gradient-style">
   
    <tr class="row1">
    
    <td width="7%">Start Date</td>
    <td width="4%"><input type="text" class="txt_box" name="sdate" id="sdate" value="<?php echo $_POST['sdate'];?>
"  onFocus="displayCalendar(document.pat_report.sdate,'dd-mm-yyyy',this)"  size="6" style="width:70px" autocomplete="off"/></td>        
    <td width="7%">End Date</td>
    <td width="4%"><input type="text" class="txt_box" name="edate" id="edate" value="<?php echo $_POST['edate'];?>
"  onFocus="displayCalendar(document.pat_report.edate,'dd-mm-yyyy',this)"  size="6" style="width:70px" autocomplete="off"/></td>     
        <td width="7%">Treatment Type</td>
     
    <td width="16%">
      <select name="sel_type_of_treatment" id="sel_type_of_treatment" class="xmedium">
      <?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->getVariable('type_of_treatment_arr')->value,'selected'=>($_POST['sel_type_of_treatment'] ? ($_POST['sel_type_of_treatment']) : ($_smarty_tpl->getVariable('patient_arr')->value[0]['treatment_type']))),$_smarty_tpl);?>
</select>
    </td>    
       
    
   </tr>
    
    </table>
    
<input type="hidden" id="type_of_treatment" name="type_of_treatment" value="<?php echo $_smarty_tpl->getVariable('patient_arr')->value[0]['treatment_type'];?>
"/>
<?php echo $_smarty_tpl->getVariable('show_errors1')->value;?>

<center><?php echo $_smarty_tpl->getVariable('graph')->value;?>
<br /><?php echo $_smarty_tpl->getVariable('html_table')->value;?>
<br />
 <?php if ($_smarty_tpl->getVariable('patient_arr')->value[0]['test_id']){?>
<table><tr><td>Evaluation of the report :</td><td> <textarea name="evalution" id="evalution" style="width: 394px; height: 51px;"></textarea></td></tr></table>
<br />
Reference: Baccarani M, Deininger MW,Rosti G, et al.European LeukemiaNet recommendations for the management of chronic myeloid leukemia:2013. Blood 2013;122(6):872-84.doi:10.1182/blood-2013-05-501569
<br />
<br />
       
<input type="submit" name="save" id="save" onclick="if(confirm('Are you sure?'))submit_form(<?php echo $_smarty_tpl->getVariable('patient_arr')->value[0]['patient_id'];?>
); return false;" value="Save" class="button" />
<br />

<input type="hidden" name="stid" id="stid" value="<?php echo $_smarty_tpl->getVariable('sgid')->value;?>
"/>
<input type="hidden" name="ptid" id="ptid" value="<?php echo $_smarty_tpl->getVariable('patient_arr')->value[0]['patient_id'];?>
" /><br />
<?php if ($_smarty_tpl->getVariable('is_saved')->value){?>
<table width="40%"><tr>
<td width="10%"><span id="semail"><input type="button" name="mail" id="mail" value="E-mail" class="button" onclick="check_graph(<?php echo $_smarty_tpl->getVariable('patient_arr')->value[0]['patient_id'];?>
,'','mail');" /></span>
<input type="button" value="Please wait" id="waitbtn" class="button" style="display:none;"/></td>
<td width="10%"><input type="button" name="print" id="print" value="Print" class="button" onclick="check_graph(<?php echo $_smarty_tpl->getVariable('patient_arr')->value[0]['patient_id'];?>
,'','print');"/></td>
<td width="10%"><input type="button" name="pdf" id="pdf" value="Export as PDF" class="button" onclick="check_graph(<?php echo $_smarty_tpl->getVariable('patient_arr')->value[0]['patient_id'];?>
,'','pdf');"/></td>
<td width="10%"><input class="button" type="button" value="Report" onclick="check_graph(<?php echo $_smarty_tpl->getVariable('patient_arr')->value[0]['patient_id'];?>
,'pind_details_report.php','rep');return false;" /></td>

</tr></table>
<?php }?><?php }?>
</center>
<?php }?>
</form>
    
    </td>
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
          <a href="javascript:void(0);" onclick="check_graph(<?php echo $_smarty_tpl->getVariable('patient_arr')->value[0]['patient_id'];?>
,'index.php','');return false;" class="<?php if ($_smarty_tpl->getVariable('default_select')->value){?><?php echo $_smarty_tpl->getVariable('default_select')->value;?>
<?php }else{ ?><?php $_smarty_tpl->smarty->_tag_stack[] = array('php', array()); $_block_repeat=true; smarty_block_php(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
 echo 'hometoplink26';<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_php(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<?php }?>" >Home</a> 
          <a href="javascript:void(0);" onclick="check_graph(<?php echo $_smarty_tpl->getVariable('patient_arr')->value[0]['patient_id'];?>
,'add_patient.php','');return false;" class="<?php if ($_smarty_tpl->getVariable('default_select1')->value){?><?php echo $_smarty_tpl->getVariable('default_select1')->value;?>
<?php }else{ ?><?php $_smarty_tpl->smarty->_tag_stack[] = array('php', array()); $_block_repeat=true; smarty_block_php(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
 echo 'hometoplink26';<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_php(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<?php }?>">Add Patient</a>
          <a href="javascript:void(0);" onclick="check_graph(<?php echo $_smarty_tpl->getVariable('patient_arr')->value[0]['patient_id'];?>
,'poverall_details_report.php','');return false;" class="<?php if ($_smarty_tpl->getVariable('default_select3')->value){?><?php echo $_smarty_tpl->getVariable('default_select3')->value;?>
<?php }else{ ?><?php $_smarty_tpl->smarty->_tag_stack[] = array('php', array()); $_block_repeat=true; smarty_block_php(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
 echo 'hometoplink26';<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_php(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<?php }?>">Overall Report</a>
          </td>
          <td width="28%"><div align="right"><a href="javascript:void(0);" onclick="check_graph(<?php echo $_smarty_tpl->getVariable('patient_arr')->value[0]['patient_id'];?>
,'../moderator/user_script/logout.php','');return false;" class="hometoplink26">Logout</a></div></td>
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

function check_graph(id,page,btn)
{     
     $('#trigok').unbind('click');

$.ajax({
	   	
            url: "../../scripts/ajax/call/is_save_graph.php",
	   		type: "POST",
	   		data: {"id":id,"tid":document.getElementById("type_of_treatment").value},
            dataType: 'json', 
   			success: function(data) {
	  	    $.each(data.json_return_array, function(key, val)
            {
           
            
                if(val.salert || $.trim(document.getElementById("evalution").value))
                {
                    

                            // Triggering bPopup when click event is fired
                            $('#show_pop_up').bPopup({
                            contentContainer:'.content'                    
                            });
                     if(btn == 'pdf')
                        {
                                 $('#trigok').click(gotopdfprint);
                            
                        }
                        else if(btn == 'print')
                        {
                           
                            $('#trigok').click(gotoprint);
                           
                        }
                       else if(btn == 'mail')
                       {
                  
                        $('#trigok').click(mail_popup);
                        $('#trigmailx').click(show_mail);
                
                           
                       }
                       else
                       {
                        
                        $( "#trigok" ).bind( "click", function() {window.location=page;});
                            
                       }
                     
                    
                }
                else if(val.succ)
                {
                    if(btn == 'pdf')
                    {
                        gotopdfprint();
                    }
                    else if(btn == 'print')
                    {
                        gotoprint();
                    }
                    else if(btn == 'mail')
                    {
                    
                        mail_popup();
                        $('#trigmailx').click(show_mail);
                    
                    }
                    else if(btn == 'rep')
                    {
                        gotoppage(page);
                    }
                    else
                    {
                        goto_page(page);
                    }
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




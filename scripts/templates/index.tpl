{include file="header_ind.tpl"}
{literal}
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
{/literal}

<div class="error">{$smarty.get.msg}</div><br />
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
      
{include file="footer.tpl"}
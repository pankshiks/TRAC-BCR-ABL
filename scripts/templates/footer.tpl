</td>
              </tr>
              <tr>
                <td><div align="right">{$back_button}</div></td>
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
          <a href="index.php" class="{if $default_select}{$default_select}{else}{php} echo 'hometoplink26';{/php}{/if}" >Home</a> 
          <a href="javascript:void(0);" onclick="goto_page('add_patient.php');return false;" class="{if $default_select1}{$default_select1}{else}{php} echo 'hometoplink26';{/php}{/if}">Add Patient</a> 
          {*<a href="patient_report.php" class="{if $default_select2}{$default_select2}{else}{php} echo 'hometoplink26';{/php}{/if}">Report</a>*}
          <a href="poverall_details_report.php" class="{if $default_select3}{$default_select3}{else}{php} echo 'hometoplink26';{/php}{/if}">Overall Report</a>
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

{literal}
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
{/literal}

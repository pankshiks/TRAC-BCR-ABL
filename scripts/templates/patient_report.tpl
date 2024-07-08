{include file="header.tpl"}
<script language='JavaScript' src='../../js/jquery.bpopup.min.js'></script>
{literal}
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
{/literal}

<form id="pat_report" name="pat_report" method="post" action="patient_report.php">
<div id="mail_to_pop_up"><button class="alertbutton" style="top:55px;left:25px" onclick="gotosetting();">Configure e-mail address</button> <button class="alertbutton b-close" style="top:55px;left:286px"><span>e-mail configured</span></button><br />&nbsp; Please Configure your e-mail ID in settings section to use this feature &nbsp;</div>
<table width="100%"><tr><td valign="top" width="100%">


<table><tr><td><input type="button" name="sh" id="sh" value="Show/Hide Column" class="button" onclick="showhide(); return false;"/></td>
<td><span id="showhide">{$column_arr[0]}{$column_arr[1]}{$column_arr[2]}{$column_arr[3]}{$column_arr[4]}{$column_arr[5]}{$column_arr[6]}{$column_arr[7]}
{$column_arr[8]}<br />{$column_arr[9]}{$column_arr[10]}{$column_arr[11]}{$column_arr[12]}{$column_arr[13]}</span></td></tr></table>

<input type="submit" name="search" id="search" value="Filter" class="button"/>
<input type="reset" name="reset" id="reset" value="Reset" class="button" onclick="reset_form(); return false;"/><br />



</td></tr>
<tr><td width="120%">
{$show_errors}
{if $report_arr}
<table width="100%"  id="gradient-style" summary="Meeting Results" style="table-layout: fixed;">
<tr class="row1">
<td width="2%" class="td_padd"></td>
{*<th width="3%" class="head_padd">Patient Code</th>*}
{if ($smarty.post.c1)=='1' || !$smarty.post}<td width="7%" class="td_padd"><input type="text" class="txt_box" name="name" id="name" value="{$smarty.post.name}" size="8"/></td>{/if}
{if ($smarty.post.c2)=='1' || !$smarty.post}<td width="6%" class="td_padd"><input type="text" class="txt_box" name="surname" id="surname" value="{$smarty.post.surname}" size="6"/></td>{/if}
{if ($smarty.post.c3)=='1' || !$smarty.post}<td width="3%" class="td_padd"><select name="gender" id="gender" class="narrow"><option value="">--Select--</option>
{html_options  options=$marr selected=($smarty.post.gender)}</select></td>{/if}
{if ($smarty.post.c4)=='1' || !$smarty.post}<td width="6%" class="td_padd"><input type="text" class="txt_box" name="dob" id="dob" value="{$smarty.post.dob}"  onFocus="displayCalendar(document.pat_report.dob,'dd-mm-yyyy',this)"  size="6"/></td>{/if}
{if ($smarty.post.c5)=='1' || !$smarty.post}<td width="6%" class="td_padd"><input type="text" class="txt_box" name="prot_no" id="prot_no" value="{$smarty.post.prot_no}" size="7"/></td>{/if}
{if ($smarty.post.c6)=='1'}<td width="7%" class="td_padd"><input type="text" class="txt_box" name="pemail" id="pemail" value="{$smarty.post.pemail}" size="8"/></td>{/if}
{if ($smarty.post.c7)=='1'}<td width="6%" class="td_padd"><input type="text" class="txt_box" name="authorized1" id="authorized1" value="{$smarty.post.authorized1}" size="6"/></td>{/if}
{if ($smarty.post.c7)=='1'}<td width="6%" class="td_padd"><input type="text" class="txt_box" name="authorized2" id="authorized2" value="{$smarty.post.authorized2}" size="6"/></td>{/if}
{if ($smarty.post.c7)=='1'}<td width="6%" class="td_padd"><input type="text" class="txt_box" name="authorized3" id="authorized3" value="{$smarty.post.authorized3}" size="6"/></td>{/if}

{if ($smarty.post.c8)=='1'}<td width="6%" class="td_padd"><input type="text" class="txt_box" name="phy_name" id="phy_name" value="{$smarty.post.phy_name}" size="6"/></td>{/if}
{if ($smarty.post.c9)=='1'}<td width="7%" class="td_padd"><input type="text" class="txt_box" name="phy_mail" id="phy_mail" value="{$smarty.post.phy_mail}" size="6"/></td>{/if}
{if ($smarty.post.c10)=='1'}<td width="8%" class="td_padd" align="center"><select name="diag" id="diag" class="narrow"><option value="">--Select--</option>{html_options options=$diagnosis_arr selected=($smarty.post.diag)}</select></td>{/if}
{if ($smarty.post.c11)=='1'}<td width="6%" class="td_padd" align="center"><select name="bcr_apl_stype" id="bcr_apl_stype" class="narrow"><option value="">--Select--</option>{html_options options=$bcr_apl_stype_arr selected=($smarty.post.bcr_apl_stype)}</select></td>{/if}
{if ($smarty.post.c12)=='1'}<td width="6%" class="td_padd"><input type="text" class="txt_box" name="tsdate" id="tsdate" value="{$smarty.post.tsdate}"  onFocus="displayCalendar(document.pat_report.tsdate,'dd-mm-yyyy',this)"  size="6"/></td>{/if}
{if ($smarty.post.c13)=='1'}<td width="8%" class="td_padd"><select name="type_of_treatment" id="type_of_treatment" class="medium">
   <option value="">--Select--</option>{html_options options=$type_of_treatment_arr selected=($smarty.post.type_of_treatment)}</select></td>{/if}
{if ($smarty.post.c14)=='1' || !$smarty.post}<td width="4%" class="td_padd"></td>{/if}

</tr><tr style="word-wrap: break-word;">

<th width="2%" class="head_padd">#</th>
{*<th width="3%" class="head_padd">Patient Code</th>*}
{if ($smarty.post.c1)=='1' || !$smarty.post}<th width="7%" class="head_padd">Name</th>{/if}
{if ($smarty.post.c2)=='1' || !$smarty.post}<th width="6%" class="head_padd">Surname</th>{/if}
{if ($smarty.post.c3)=='1' || !$smarty.post}<th width="3%" class="head_padd">Gender</th>{/if}
{if ($smarty.post.c4)=='1' || !$smarty.post}<th width="6%" class="head_padd">DOB</th>{/if}
{if ($smarty.post.c5)=='1' || !$smarty.post}<th width="6%" class="head_padd">Hospital ID</th>{/if}
{if ($smarty.post.c6)=='1'}<th width="7%" class="head_padd">Patient's e-mail Address</th>{/if}
{if ($smarty.post.c7)=='1'}<th width="6%" class="head_padd">Report authorized by</th>{/if}
{if ($smarty.post.c7)=='1'}<th width="6%" class="head_padd">Report authorized by</th>{/if}
{if ($smarty.post.c7)=='1'}<th width="6%" class="head_padd">Report authorized by</th>{/if}

{if ($smarty.post.c8)=='1'}<th width="6%" class="head_padd">Physician's name</th>{/if}
{if ($smarty.post.c9)=='1'}<th width="7%" class="head_padd">Physician's e-mail address</th>{/if}
{if ($smarty.post.c10)=='1'}<th width="8%" class="head_padd">The diagnosis and the phase at the time of diagnosis</th>{/if}
{if ($smarty.post.c11)=='1'}<th width="6%" class="head_padd">BCR-ABL transcript subtype</th>{/if}
{if ($smarty.post.c12)=='1'}<th width="6%" class="head_padd">Treatment start date</th>{/if}
{if ($smarty.post.c13)=='1'}<th width="8%" class="head_padd">Type of treatment</th>{/if}
{if ($smarty.post.c14)=='1' || !$smarty.post}<th width="4%" class="head_padd">Delete</th>{/if}
</tr>

{foreach $report_arr as $key=>$value}

<tr class="{cycle values="row1,row2"}" style="word-wrap: break-word;">

<td class="td_padd">{$key+1}</td>
{*<td class="td_padd">{$value['pcode']}</a></td>*}
{if ($smarty.post.c1)=='1' || !$smarty.post}<td class="td_padd"><a href="javascript:void(0);" title="Goto Add Patient Test" onclick="goto_test({$value['patient_id']})">{$value['pname']}</a></td>{/if}
{if ($smarty.post.c2)=='1' || !$smarty.post}<td class="td_padd">{$value['sur_name']}</td>{/if}
{if ($smarty.post.c3)=='1' || !$smarty.post}<td class="td_padd">{$marr[$value['gender']]}</td>{/if}
{if ($smarty.post.c4)=='1' || !$smarty.post}<td class="td_padd">{$value['dob']}</td>{/if}
{if ($smarty.post.c5)=='1' || !$smarty.post}<td class="td_padd">{$value['protocol_no']}</td>{/if}
{if ($smarty.post.c6)=='1'}<td class="td_padd">{$value['pmail']}</td>{/if}
{if ($smarty.post.c7)=='1'}<td class="td_padd">{$value['authorized_by1']}</td>{/if}
{if ($smarty.post.c7)=='1'}<td class="td_padd">{$value['authorized_by2']}</td>{/if}
{if ($smarty.post.c7)=='1'}<td class="td_padd">{$value['authorized_by3']}</td>{/if}
{if ($smarty.post.c8)=='1'}<td class="td_padd">{$value['physician_name']}</td>{/if}
{if ($smarty.post.c9)=='1'}<td class="td_padd">{$value['phy_mail']}</td>{/if}
{if ($smarty.post.c10)=='1'}<td class="td_padd">{$diagnosis_arr[$value['diagnosis']]}</td>{/if}
{if ($smarty.post.c11)=='1'}<td class="td_padd">{$bcr_apl_stype_arr[$value['bcr_apl']]}{if $value['bcr_apl']}<br />{$value['bcr_apl_others']}{/if}</td>{/if}
{if ($smarty.post.c12)=='1'}<td class="td_padd">{$value['tsdate']}</td>{/if}
{if ($smarty.post.c13)=='1'}<td class="td_padd">{$type_of_treatment_arr[$value['treatment_type']]}</td>{/if}
{if ($smarty.post.c14)=='1' || !$smarty.post}<td class="td_padd" align="center"><a href="javascript:void(0);" onclick="if(confirm('Do you want to delete this patient details?'))remove_patient({$value['patient_id']}); return false;" title="Delete this row"><img  src="../../images/minus.png" width="25" height="25"/></a></td>{/if}


</tr>

{/foreach}
</table>


<br />
<center><table width="40%"><tr>
<td width="10%"><span id="semail"><input type="button" name="mail" id="mail" value="E-mail" class="button" onclick="show_mail();"/></span></td>
<td width="10%"><input type="button" name="print" id="print" value="Print" class="button" onclick="gotoprint(); return false;"/></td>
<td width="10%"><input type="button" name="pdf" id="pdf" value="Export as PDF" class="button" onclick="gotopdfprint(); return false;"/></td>
<td width="10%"><input type="button" name="xl" id="xl" value="Export to excel" class="button" onclick="gotoxlprint(); return false;"/></td>

</tr></table></center>
{/if}

</td></tr></table>
{*if $smarty.get.id && $report_arr}

<table width="100%" style="layout:fixed;background:#D9DEE1">
<tr>
<td width="12%" valign="top" style="border-right:1px solid #FFFFFF">
<table id="gradient-style">
{<tr class="maintr"><td width="20%"><a href="javascript:void(0);" id="a" onclick="change_itarget('a','../master/add_patient.php?id={$smarty.get.id}')">Patient Information</a></td> </tr>}
<tr class="maintr"><td><a href="javascript:void(0);" id="b"  onclick="change_itarget('b','../master/demography.php?id={$smarty.get.id}&ref=rep')">Demography</a></td></tr>
<tr class="maintr"><td><a href="javascript:void(0);" id="c"  onclick="change_itarget('c','../master/mhistory.php?id={$smarty.get.id}')">Medical History</a></td></tr>
<tr class="maintr"><td><a href="javascript:void(0);" id="d"  onclick="change_itarget('d','../master/pexam.php?id={$smarty.get.id}')">Physical Examination</a></td></tr>
<tr class="maintr"><td><a href="javascript:void(0);" id="e" onclick="change_itarget('e','../master/lab_result.php?id={$smarty.get.id}')">Lab Results</a></td></tr>
<tr class="maintr"><td><a href="javascript:void(0);" id="f"  onclick="change_itarget('f','../master/bone_marrow.php?id={$smarty.get.id}')">Bone Marrow</a></td></tr>
<tr class="maintr"><td><a href="javascript:void(0);" id="g"  onclick="change_itarget('g','../master/cytogenetics.php?id={$smarty.get.id}')">Cytogenetics</a></td></tr>
<tr class="maintr"><td><a href="javascript:void(0);" id="h"  onclick="change_itarget('h','../master/prognostic.php?id={$smarty.get.id}')">IPSS and Revised</a></td></tr>
<tr class="maintr"><td><a href="javascript:void(0);" id="i"  onclick="change_itarget('i','../master/treatment.php?id={$smarty.get.id}')">Treatment</a></td></tr>
<tr class="maintr"><td><a href="javascript:void(0);" id="j"  onclick="change_itarget('j','../master/follow_up.php?id={$smarty.get.id}')">Follow Up</a></td></tr>
<tr class="maintr"><td><a href="javascript:void(0);" id="k"  onclick="change_itarget('k','../master/death.php?id={$smarty.get.id}')">Death Information</a></td></tr>
</table></td>

<td width="80%" valign="top">
<div  style="width:100%;height:100%;overflow:auto">
<div id ="content"></div></div>

</td></tr>
</table>

{/if*}




{if $smarty.post && $smarty.post.output=='GRAPH'}
{$graph_str}
{*<table><tr><td><img src="./age.jpeg" width="600" height="400"/></td>
<td style="padding:0 150px"><strong>Note:</strong>All other reports will be present like this way.</td></tr>
<tr><td><img src="./country.jpeg" width="600" height="400"/></td></tr>
</table>*}
{/if}
</form>

{include file="footer.tpl"}

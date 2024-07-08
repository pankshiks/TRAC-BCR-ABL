<?php /* Smarty version Smarty-3.0.6, created on 2024-07-05 16:00:04
         compiled from "../templates\add_patient_test.tpl" */ ?>
<?php /*%%SmartyHeaderCode:287746687cb2c88fbf0-88362298%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd16420e7b9fe0050a12e0d93fa140ed71fb625cd' => 
    array (
      0 => '../templates\\add_patient_test.tpl',
      1 => 1442044916,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '287746687cb2c88fbf0-88362298',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_html_options')) include 'C:\wamp\www\ELN\includes\Smarty306\libs\plugins\function.html_options.php';
if (!is_callable('smarty_function_cycle')) include 'C:\wamp\www\ELN\includes\Smarty306\libs\plugins\function.cycle.php';
?>    <?php $_template = new Smarty_Internal_Template("header.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
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
function show_other(value)
{
    if(value=='8')
    {
        document.getElementById("med_name_others").style.display="block";
    }
    else
    {
        document.getElementById("med_name_others").style.display="none";
    }
}

function show_sdt(ttype)
{
    if(ttype=='2')
    {
        dis_sldt(2);
    }
    else if(ttype=='3')
    {
        dis_sldt(3);
    }
    else
        dis_sldt(1);
}
function dis_sldt(type)
{
    if(type=='2')
    {
        document.getElementById('sh_std').style.display="block";
        document.getElementById('sh_stdt').style.display="block";
        document.getElementById('dis_sdt').style.display="none";
        
    }
    else if(type=='3')
    {
        document.getElementById('sh_std').style.display="block";
        document.getElementById('sh_stdt').style.display="block";
        document.getElementById('dis_sdt').style.display="none";
        
    }
    else
    {
        document.getElementById('sh_std').style.display="none";
        document.getElementById('sh_stdt').style.display="none";
        document.getElementById('dis_sdt').style.display="block";
    }
}

function disp(cid,mid)
{
    document.getElementById(cid).style.display="block";
    document.getElementById(mid).style.display="none";
    
}
function update(type,fid,pid,med_desc)
{
   
$.ajax({
	   	
            url: "../../scripts/ajax/call/update_from_test.php",
	   		type: "POST",
	   		data: {tp:type,uid:fid,pid:pid,stsd:document.getElementById('stdate').value,med_desc:med_desc},
            dataType: 'json', 
   			success: function(data) {
	  	    $.each(data.json_return_array, function(key, val)
            {
                if(val.succ)
    			{
    			     alert(val.succ);
                      window.location='add_patient_test.php';
    			}
                 else
                 {
                        alert(val.err);
                 }
   	        });
	   		}
	   		});

}
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
    
function edit_patient(pid) {
$.ajax({

            url: "../../scripts/ajax/call/edit_patient.php",
	   		type: "POST",
	   		data: {"id":pid},
            dataType: 'json',
   			success: function(data) {
	  	    $.each(data.json_return_array, function(key, val)
            {
                if(val.succ)
                {
                    window.location='add_patient.php';
                }
   	        });
	   		}
	   		});
}


function save_test() {
var serializedData = $("#add_patient_form").serialize();
$.ajax({

            url: "../../scripts/ajax/call/add_patient_test.php",
	   		type: "POST",
	   		data: serializedData,
            dataType: 'json', 
   			success: function(data) {
	  	    $.each(data.json_return_array, function(key, val)
            {
                if(val.succ)
    			{
    			     alert(val.succ);
                      window.location.reload();//='add_patient_test.php';
    			}
                 else
                 {
                        alert(val.err);
                 }
   	        });
	   		}
	   		});
}



function add_row(row)
{
        

     
    var idp=Math.round(row)+1;
    $( "span.remove_class" ).replaceWith( "<a href=javascript:void(0); onclick=if(confirm(\'Do&nbsp;you&nbsp;want&nbsp;to&nbsp;delete&nbsp;this&nbsp;row?\'))remove_row("+row+",'') title='Delete this row'><img  src=\"../../images/minus.png\" width=25 height=25/></a>");
     $( "span.add" ).html( "<input type=button value='Adding...'  name=add id='add_nrow' class='button'/>");
    		
    $('#mid').val(idp);
    
 
    
    
         
    $.ajax({
    	   		url: "../ajax/call/add_test_row.php",
    	   		type: "POST",
                data: {'id':idp,"lid":document.getElementById('lid').value},
                dataType: 'json',
                success: function(rdata) {
    	  	    $.each(rdata.json_return_array, function(key, val){
                if(val.succ)
    			{
    			     $(val.succ).insertAfter("#tbody_tr_"+row);
                     
                     
                     if(val.clid != undefined)
                     {
                       
                        document.getElementById('lid').value = val.clid;
                     }
             $( "span.add" ).html( "<a href='javascript:void(0);'  name=add id='add_nrow'  onclick='add_row("+idp+");return false'><img  src=\"../../images/plus.png\" width=25 height=25/></a>");
    			}
                
                 

                	});
    	   		}
    	   		});

    

}

function remove_row(id,tid)
{
    if(tid)
    {
            $.ajax({
    	   		url: "../ajax/call/test_row_remove.php",
    	   		type: "POST",
                data: 'id='+tid,
                dataType: 'json',
                success: function(rdata) {
    	  	    $.each(rdata.json_return_array, function(key, val){
                if(val.succ)
    			{
    			     alert(val.succ);
                     window.location='add_patient_test.php';
    			}

                	});
    	   		}
    	   		});
    }
    else
    {
        $( "tr" ).remove( "#tbody_tr_"+id );
        maxid=document.getElementById('mid').value;
        
        
        
        
        //arrange sl no///////////////////
        if(maxid>0)
        {
            var tr=0;
            var tri=1;
             for(var r = 0;r <= maxid;r++)
            {
                if($('#sl_no_'+(Math.round(tr))).length)
                {
                    $('#sl_no_'+(Math.round(tr))).html(tri);
                    document.getElementById('lid').value = tri;                 
                    tri+=1;
                }
                tr+=1;
            }  
        }
        ////////////////////////////////
    }
}

function edit_test(tid)
{
     $.ajax({
    	   		url: "../ajax/call/edit_test_detail.php",
    	   		type: "POST",
                data: 'id='+tid,
                dataType: 'json',
                success: function(rdata) {
    	  	    $.each(rdata.json_return_array, function(key, val){
                if(val)
    			{
    			     $("#maindiv" ).hide();
                     $("#edit_div" ).show();                     
    			     $('#edot').val(val.tdate);
                     $('#estest').val(val.stype);
                     $('#essent_from').val(val.ssfrom);
                     $('#esno').val(val.sno);
                     $('#eapltrans_no').val(val.bapl_no);
                     $('#egenetrans_no').val(val.gen_no);
                     $('#econ_factor').val(val.cfact);
                     $('#etst_id').val(val.tstid);
    			}

                	});
    	   		}
    	   		});
    
}

function update_test()
{
   
var serializedData = $("#add_patient_form").serialize();
$.ajax({
	   	
            url: "../../scripts/ajax/call/update_test.php",
	   		type: "POST",
	   		data: serializedData,
            dataType: 'json', 
   			success: function(data) {
	  	    $.each(data.json_return_array, function(key, val)
            {
                if(val.succ)
    			{
    			     alert(val.succ);
                      window.location.reload();
    			}
                 else
                 {
                        alert(val.err);
                 }
   	        });
	   		}
	   		});

}

function gotoprint()
{
  
  window.open("patient_details_print.php", "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=500, left=500, width=400, height=400,menubar=1");

}
function gotoxlprint()
{
    window.open("patient_details_xlprint.php", "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=500, left=500, width=400, height=400,menubar=1");
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
	   	
            url: "../../scripts/ajax/call/send_mail.php",
	   		type: "POST",
	   		data: {"mailid":document.getElementById('rec_mail').value},
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
function gotopdf()
{
  
  window.open("patient_details_pdf.php", "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=500, left=500, width=400, height=400,menubar=1");

}
function gotograph()
{
  
  window.open("patient_details_report.php", "_blank");

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

<form id="add_patient_form" name="add_patient_form" method="post">
<input type="hidden" value="" id="mid" name="mid"/>
<input type="hidden" value="<?php echo $_smarty_tpl->getVariable('pcnt')->value;?>
" id="lid" name="lid"/>

<div id="mail_to_pop_up"><button class="alertbutton" style="top:55px;left:25px" onclick="gotosetting();">Configure e-mail address</button> <button class="alertbutton b-close" style="top:55px;left:286px"><span>e-mail configured</span></button><br />&nbsp; Please Configure your e-mail ID in settings section to use this feature &nbsp;</div>
   <!-- <div style="width:100%;float:left;"><?php echo $_smarty_tpl->getVariable('show_errors')->value;?>
</div>!-->
   <?php if ($_smarty_tpl->getVariable('patient_arr')->value){?>
   <input type="hidden" name="txt_patid" id="txt_patid" value="<?php echo $_smarty_tpl->getVariable('patient_arr')->value[0]['patient_id'];?>
"/>
  <table id="gradient-style" summary="Meeting Results" width="100%">
 
      
    <tr class="row2">
            <td width="15%">Name</td><td width="15%"><strong><?php echo $_smarty_tpl->getVariable('patient_arr')->value[0]['pname'];?>
</strong></td>
            <td width="20%">Physician's name</td><td width="20%"><?php echo $_smarty_tpl->getVariable('patient_arr')->value[0]['physician_name'];?>
</td>
            
      </tr>
      
      <tr class="row1">
            <td>Surname</td><td><?php echo $_smarty_tpl->getVariable('patient_arr')->value[0]['sur_name'];?>
</td>
            <td>Physician's e-mail address</td><td><?php echo $_smarty_tpl->getVariable('patient_arr')->value[0]['phy_mail'];?>
</td>
            
      </tr>
      
      <tr class="row2">
            <td>Gender</td><td><?php echo $_smarty_tpl->getVariable('marr')->value[$_smarty_tpl->getVariable('patient_arr')->value[0]['gender']];?>
</td>
            <td>The diagnosis and the phase at the time of diagnosis</td><td width="20%"><?php echo $_smarty_tpl->getVariable('diagnosis_arr')->value[$_smarty_tpl->getVariable('patient_arr')->value[0]['diagnosis']];?>
</td>
            
      </tr>
  <tr class="row1">
            <td>Date of birth</td><td><?php echo $_smarty_tpl->getVariable('patient_arr')->value[0]['dob'];?>
</td>
            <td>BCR-ABL transcript subtype</td><td><?php echo $_smarty_tpl->getVariable('bcr_apl_stype_arr')->value[$_smarty_tpl->getVariable('patient_arr')->value[0]['bcr_apl']];?>
<br /><?php echo $_smarty_tpl->getVariable('patient_arr')->value[0]['bcr_apl_others'];?>
</td>
           
      </tr>
  <tr class="row2">
            <td>Hospital ID</td><td><?php echo $_smarty_tpl->getVariable('patient_arr')->value[0]['protocol_no'];?>
</td>
            <td>Date of diagnosis</td><td ><?php echo $_smarty_tpl->getVariable('patient_arr')->value[0]['diag_stdate'];?>
</td>
  </tr>
      
<tr class="row1">
<td>Patient's e-mail address</td><td><?php echo $_smarty_tpl->getVariable('patient_arr')->value[0]['pmail'];?>
</td>
<td>Medication name</td><td><label id="dis_medic" title="To edit click here..." style="cursor:pointer;color:orange;" onclick="disp('dis_medic_cnt',this.id);"><?php echo $_smarty_tpl->getVariable('medication_arr')->value[$_smarty_tpl->getVariable('patient_arr')->value[0]['medication_id']];?>
&nbsp;<br /> <?php echo $_smarty_tpl->getVariable('patient_arr')->value[0]['med_others'];?>
</label>
<label id="dis_medic_cnt" title="To edit click here..." style="display:none">           
<select name="medic_id" id="medic_id" class="xmedium" onchange="show_other(this.value)">
<option value="">--Select--</option>
<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->getVariable('medication_arr')->value,'selected'=>($_smarty_tpl->getVariable('patient_arr')->value[0]['medication_id'])),$_smarty_tpl);?>
3
</select><br /><br />
 <input type="text" name="med_name_others" autocomplete="off" id="med_name_others" size="25" placeholder="Enter the others description" maxlength="25" class="txt_box" <?php if ($_smarty_tpl->getVariable('patient_arr')->value[0]['medication_id']!='8'){?> style="display:none" <?php }?> value="<?php echo $_smarty_tpl->getVariable('patient_arr')->value[0]['med_others'];?>
"/>
<a href="javascript:void(0);" style="color:orange;" onclick="if(confirm('Are you sure?'))update(1,document.getElementById('medic_id').value,<?php echo $_smarty_tpl->getVariable('patient_arr')->value[0]['patient_id'];?>
,document.getElementById('med_name_others').value);">Update</a></label>
</td></tr>

   <tr class="row2">
            <td>Report authorized by</td><td><?php echo $_smarty_tpl->getVariable('patient_arr')->value[0]['authorized_by1'];?>
</td>
            <td width="15%">Treatment start date</td><td width="20%"><strong><?php echo $_smarty_tpl->getVariable('patient_arr')->value[0]['tsdate'];?>
</strong></td>
      </tr>
      
<tr class="row1">
<td>Report authorized by</td><td><?php echo $_smarty_tpl->getVariable('patient_arr')->value[0]['authorized_by2'];?>
</td>
<td>Type of treatment</td><td>
<label id="dis_tot" title="To edit click here..." style="cursor:pointer;color:orange;" onclick="disp('dis_tot_cnt',this.id);show_sdt(<?php echo $_smarty_tpl->getVariable('patient_arr')->value[0]['treatment_type'];?>
);">
<?php echo $_smarty_tpl->getVariable('type_of_treatment_arr')->value[$_smarty_tpl->getVariable('patient_arr')->value[0]['treatment_type']];?>

</label>
<label id="dis_tot_cnt" title="To edit click here..." style="display:none">    
<select name="type_of_treatment" id="type_of_treatment" onchange="dis_sldt(this.value);" class="xmedium">
<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->getVariable('type_of_treatment_arr')->value,'selected'=>($_smarty_tpl->getVariable('patient_arr')->value[0]['treatment_type'])),$_smarty_tpl);?>

</select><a style="color:orange;" href="javascript:void(0);" onclick="if(confirm('Are you sure?'))update(2,document.getElementById('type_of_treatment').value,<?php echo $_smarty_tpl->getVariable('patient_arr')->value[0]['patient_id'];?>
,'');">Update</a></label>
</label>
</td></tr>


<tr class="row2">
<td>Report authorized by</td><td><?php echo $_smarty_tpl->getVariable('patient_arr')->value[0]['authorized_by3'];?>
</td>
<td><label id="sh_std" <?php if (($_smarty_tpl->getVariable('patient_arr')->value[0]['treatment_type']!='2'&&$_smarty_tpl->getVariable('patient_arr')->value[0]['treatment_type']!='3')){?> style="display:none;"<?php }?>>Second Line Treatment start date</label></td>

<td><label id="sh_stdt" <?php if (($_smarty_tpl->getVariable('patient_arr')->value[0]['treatment_type']!='2'&&$_smarty_tpl->getVariable('patient_arr')->value[0]['treatment_type']!='3')||$_smarty_tpl->getVariable('patient_arr')->value[0]['stsdate']){?> style="display:none;"<?php }?>>
<input class="txt_box" type="text" name="stdate" id="stdate"   onFocus="displayCalendar(document.add_patient_form.stdate,'dd-mm-yyyy',this)"  size="7" readonly="" value="<?php echo $_smarty_tpl->getVariable('patient_arr')->value[0]['stsdate']!='00-00-0000' ? $_smarty_tpl->getVariable('patient_arr')->value[0]['stsdate'] : '';?>
" autocomplete="off" />
</label>
<label id="dis_sdt"><?php echo $_smarty_tpl->getVariable('patient_arr')->value[0]['stsdate']!='00-00-0000' ? $_smarty_tpl->getVariable('patient_arr')->value[0]['stsdate'] : '';?>
</label>

</td>

</tr>

<tr class="row1">
<td></td><td></td>
<td colspan="2" align="right"><input type="submit" name="save" id="save" value="Edit" class="button" onclick="if(confirm('Are you sure about editing the details?'))edit_patient(<?php echo $_smarty_tpl->getVariable('patient_arr')->value[0]['patient_id'];?>
); return false;"/></td>
</tr>

    </table>
    <br />
    
    <div id="maindiv">
    
    <table width="100%"><tr>
    <td width="100%"> 
    <table width="100%"  id="gradient-style">
    <tr>
    <th width="2%" height="30px;">#</th>
    <th width="10%">Date of test</th>
    <th width="14%">Sample Type</th>
    <th width="14%">Sample sent from<br />(Hospital)</th>
    <th width="10%">Sample #</th>
    <th width="14%">BCR-ABL1 Result %<br />(International Scale)</th>
    <th width="2%"></th></tr>
    <?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->value = 0;
  if ($_smarty_tpl->getVariable('i')->value<$_smarty_tpl->getVariable('pcnt')->value){ for ($_foo=true;$_smarty_tpl->getVariable('i')->value<$_smarty_tpl->getVariable('pcnt')->value; $_smarty_tpl->tpl_vars['i']->value++){
?>
    
   <?php if ($_smarty_tpl->getVariable('patient_arr')->value[$_smarty_tpl->tpl_vars['i']->value]['test_id']){?>
    
    <tr class="<?php echo smarty_function_cycle(array('values'=>"row1,row2"),$_smarty_tpl);?>
" id="tbody_tr_<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
">
    <td width="" align="center"><label id="sl_no_<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['i']->value+1;?>
</lable></td>
    <td width="" align="center"><a href="javascript:void(0);" onclick="if(confirm('Are you sure about editing the details?'))edit_test(<?php echo $_smarty_tpl->getVariable('patient_arr')->value[$_smarty_tpl->tpl_vars['i']->value]['test_id'];?>
); return false;" title="To edit this detail click here..."><?php echo $_smarty_tpl->getVariable('patient_arr')->value[$_smarty_tpl->tpl_vars['i']->value]['test_date']!='00/00/0000' ? $_smarty_tpl->getVariable('patient_arr')->value[$_smarty_tpl->tpl_vars['i']->value]['test_date'] : '';?>
</a></td>
    <td width="" align="center"><a href="javascript:void(0);" onclick="if(confirm('Are you sure about editing the details?'))edit_test(<?php echo $_smarty_tpl->getVariable('patient_arr')->value[$_smarty_tpl->tpl_vars['i']->value]['test_id'];?>
); return false;" title="To edit this detail click here..."><?php echo $_smarty_tpl->getVariable('patient_arr')->value[$_smarty_tpl->tpl_vars['i']->value]['sample_type'];?>
</a></td>
    <td width="" align="center"><a href="javascript:void(0);" onclick="if(confirm('Are you sure about editing the details?'))edit_test(<?php echo $_smarty_tpl->getVariable('patient_arr')->value[$_smarty_tpl->tpl_vars['i']->value]['test_id'];?>
); return false;" title="To edit this detail click here..."><?php echo $_smarty_tpl->getVariable('patient_arr')->value[$_smarty_tpl->tpl_vars['i']->value]['sample_sent_from'];?>
</a></td>
    <td width="" align="center"><a href="javascript:void(0);" onclick="if(confirm('Are you sure about editing the details?'))edit_test(<?php echo $_smarty_tpl->getVariable('patient_arr')->value[$_smarty_tpl->tpl_vars['i']->value]['test_id'];?>
); return false;" title="To edit this detail click here..."><?php echo $_smarty_tpl->getVariable('patient_arr')->value[$_smarty_tpl->tpl_vars['i']->value]['sample_no'];?>
</a></td>
    <td width="" align="center"><a href="javascript:void(0);" onclick="if(confirm('Are you sure about editing the details?'))edit_test(<?php echo $_smarty_tpl->getVariable('patient_arr')->value[$_smarty_tpl->tpl_vars['i']->value]['test_id'];?>
); return false;" title="To edit this detail click here..."><?php echo $_smarty_tpl->getVariable('patient_arr')->value[$_smarty_tpl->tpl_vars['i']->value]['bcr_apl_no'];?>
</a></td>
    <td width="" align="center">
    <?php if ($_smarty_tpl->tpl_vars['i']->value!=($_smarty_tpl->getVariable('pcnt')->value-1)){?><a href="javascript:void(0);" onclick="if(confirm('Do you want to delete this row?'))remove_row(<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
,<?php echo $_smarty_tpl->getVariable('patient_arr')->value[$_smarty_tpl->tpl_vars['i']->value]['test_id'];?>
); return false;" title="Delete this row"><img  src="../../images/minus.png" width="25" height="25"/></a><?php }else{ ?><span class="remove_class"></span><?php }?></td>
    </tr>
    
    <?php }else{ ?>
    
<tr  class="<?php echo smarty_function_cycle(array('values'=>"row1,row2"),$_smarty_tpl);?>
" id="tbody_tr_<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
"> <input class="txt_box" type="hidden" name="ptestid[<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
]" id="ptestid[<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
]" size="5" value="<?php echo $_smarty_tpl->getVariable('patient_arr')->value[$_smarty_tpl->tpl_vars['i']->value]['test_id'];?>
"/>
<td width="" align="center"><label id="sl_no_<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['i']->value+1;?>
</lable></td>
    <td width="" align="center"><input class="txt_box" type="text" name="dot[<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
]" id="dot_<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" onchange="var c=CompareDates('<?php echo date('d-m-Y');?>
',this.value,'-');if(c==0){alert('Selected Date cannot be on future date');this.value=''}; var c=CompareDates(this.value,'<?php echo $_smarty_tpl->getVariable('patient_arr')->value[0]['dob'];?>
','-');if(c==0){alert('Selected Date cannot be before date of birth');this.value=''};"  onFocus="displayCalendar(document.add_patient_form.dot_<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
,'dd-mm-yyyy',this)"  size="8" readonly="" autocomplete="off" value="<?php echo $_smarty_tpl->getVariable('patient_arr')->value[$_smarty_tpl->tpl_vars['i']->value]['test_date']!='00/00/0000' ? $_smarty_tpl->getVariable('patient_arr')->value[$_smarty_tpl->tpl_vars['i']->value]['test_date'] : '';?>
" /></td>
    <td width="" align="center"><input class="txt_box" type="text" name="stest[<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
]" id="stest[<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
]" size="18" maxlength="30" value="<?php echo $_smarty_tpl->getVariable('patient_arr')->value[$_smarty_tpl->tpl_vars['i']->value]['sample_type'];?>
" autocomplete="off" /></td>
    <td width="" align="center"><input class="txt_box" type="text" name="ssent_from[<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
]" id="ssent_from[<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
]" size="18" maxlength="30" value="<?php echo $_smarty_tpl->getVariable('patient_arr')->value[$_smarty_tpl->tpl_vars['i']->value]['sample_sent_from'];?>
" autocomplete="off" /></td>
    <td width="" align="center"><input class="txt_box" type="text" name="sno[<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
]" id="sno[<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
]" size="15" maxlength="20" value="<?php echo $_smarty_tpl->getVariable('patient_arr')->value[$_smarty_tpl->tpl_vars['i']->value]['sample_no'];?>
" autocomplete="off" /></td>
    <td width="" align="center"><input class="txt_box" type="text" name="apltrans_no[<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
]" id="apltrans_no[<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
]" size="15" maxlength="20" value="<?php echo $_smarty_tpl->getVariable('patient_arr')->value[$_smarty_tpl->tpl_vars['i']->value]['bcr_apl_no'];?>
" autocomplete="off" onblur="validate_custom(this.value,'lbl_apl_<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
','Number','Enter the numeric value',this.id,'add_patient_form','','false')"/><label class="error" id="lbl_apl_<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
"></label></td>
    <td width="" align="center"><span class="remove_class"><span class="add"><a href='javascript:void(0);'   name="add" id="add_nrow" class="button" onclick="add_row(<?php echo $_smarty_tpl->getVariable('pcnt')->value-1;?>
);return false"><img  src="../../images/plus.png" width="25" height="25"/></a></span></span></td></tr>
    <?php }?>
    <?php }} ?>
    </table></td>
    </tr>
    <tr><td colspan="2" align="right"><input type="button" value="Save" name="save" id="save" class="button" onclick="if(confirm('Please verify the type of treatemt, treatment start date and medication name ?'))save_test(); return false;"/></td></tr></table>
   
    <div align="center">
    
<table width="50%"><tr>
<td width="10%"><span id="semail"><input type="button" name="mail" id="mail" value="E-mail" class="button" onclick="show_mail();"/></span></td>
<td width="10%"><input type="button" name="mail" id="mail" value="Print" class="button" onclick="gotoprint(); return false;"/></td>
<td width="10%"><input type="button" name="pdf" id="pdf" value="Export as PDF" class="button" onclick="gotopdf(); return false;"/></td>
<td width="10%"><input type="button" name="graph" id="graph" value="Generate report" class="button" onclick="gotograph(); return false;"/></td>
<td width="10%"><input type="button" name="XL" id="XL" value="Export to excel" class="button" onclick="gotoxlprint(); return false;"/></td>
</tr></table>

</div>
    </div>
 
 <center>
 <div style="display:none;" id="edit_div">
 <input type="hidden" name="etst_id" id="etst_id"/>
 
 <table width="100%"><tr><td width="50%"><table id="gradient-style">
 <tr class="row1"><td>Date of test</td><td><input class="txt_box" type="text" name="edot" id="edot" <?php echo $_smarty_tpl->getVariable('date_valid_1')->value;?>
 onFocus="displayCalendar(document.add_patient_form.edot,'dd-mm-yyyy',this)"  size="8" readonly="" autocomplete="off" value="" /></td></tr>
 <tr class="row2"><td>Sample type</td><td><input class="txt_box" type="text" name="estest" id="estest" size="30" maxlength="50"  autocomplete="off" value="" /></td></tr>
 <tr class="row1"><td>Sample sent from (Hospital)</td><td><input class="txt_box" type="text" name="essent_from" id="essent_from" size="18" maxlength="50" value="" autocomplete="off" /></td></tr>
 <tr class="row2"><td>Sample #</td><td><input class="txt_box" type="text" name="esno" id="esno" size="15" maxlength="20" value="" autocomplete="off" /><br /><label class="error" id="lbl_sno"></label></td></tr>
 <tr class="row1"><td>BCR-ABL1 Result % (International Scale)</td><td><input class="txt_box" type="text" name="eapltrans_no" id="eapltrans_no" size="15" maxlength="20" value="" autocomplete="off"  onblur="validate_custom(this.value,'lbl_apl','Number','Enter the numeric value',this.id,'add_patient_form','','false')"/><br /><label class="error" id="lbl_apl"></label></td></tr>
 <br /><label class="error" id="lbl_fact"></label></td></tr>
 
 </table> </td>
 
 <td valign="bottom" align="right">
 <input type="button" value="Save" name="save" id="save" class="button" onclick="if(confirm('Are you sure?'))update_test(); return false;"/>
 <input type="button" value="Cancel" name="save" id="save" class="button" onclick="window.location.reload();"/>
 
 </td></tr></table>
    </div>
    

</center>
    <?php }?>
 
</form>
<?php $_template = new Smarty_Internal_Template("footer.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
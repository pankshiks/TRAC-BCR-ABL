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
{/literal}
 {*function gotoprint(pid)
{
   
var serializedData = $("#add_patient_form").serialize();
$.ajax({
	   	
            url: "../../scripts/ajax/call/goprint.php",
	   		type: "POST",
	   		data: 'pid='+pid,
            dataType: 'json', 
   			success: function(data) {
	  	    $.each(data.json_return_array, function(key, val)
            {
                if(val.succ)
    			{
    			     
                      window.location='patient_details_print.php';
    			}
                else
                {
                    alert(val.err);
                }
                
   	        });
	   		}
	   		});

}*}
<form id="add_patient_form" name="add_patient_form" method="post">
<input type="hidden" value="" id="mid" name="mid"/>
<input type="hidden" value="{$pcnt}" id="lid" name="lid"/>

<div id="mail_to_pop_up"><button class="alertbutton" style="top:55px;left:25px" onclick="gotosetting();">Configure e-mail address</button> <button class="alertbutton b-close" style="top:55px;left:286px"><span>e-mail configured</span></button><br />&nbsp; Please Configure your e-mail ID in settings section to use this feature &nbsp;</div>
   <!-- <div style="width:100%;float:left;">{$show_errors}</div>!-->
   {if $patient_arr}
   <input type="hidden" name="txt_patid" id="txt_patid" value="{$patient_arr[0]['patient_id']}"/>
  <table id="gradient-style" summary="Meeting Results" width="100%">
 
  {* 
   <tr class="row1">
            <td width="15%">Patient Code</td><td width="20%" colspan="5"><strong>{$patient_arr[0]['pcode']}</strong></td>
           
      </tr>*}
      
    <tr class="row2">
            <td width="15%">Name</td><td width="15%"><strong>{$patient_arr[0]['pname']}</strong></td>
            <td width="20%">Physician's name</td><td width="20%">{$patient_arr[0]['physician_name']}</td>
            
      </tr>
      
      <tr class="row1">
            <td>Surname</td><td>{$patient_arr[0]['sur_name']}</td>
            <td>Physician's e-mail address</td><td>{$patient_arr[0]['phy_mail']}</td>
            
      </tr>
      
      <tr class="row2">
            <td>Gender</td><td>{$marr[$patient_arr[0]['gender']]}</td>
            <td>The diagnosis and the phase at the time of diagnosis</td><td width="20%">{$diagnosis_arr[$patient_arr[0]['diagnosis']]}</td>
            
      </tr>
  <tr class="row1">
            <td>Date of birth</td><td>{$patient_arr[0]['dob']}</td>
            <td>BCR-ABL transcript subtype</td><td>{$bcr_apl_stype_arr[$patient_arr[0]['bcr_apl']]}<br />{$patient_arr[0]['bcr_apl_others']}</td>
           
      </tr>
  <tr class="row2">
            <td>Hospital ID</td><td>{$patient_arr[0]['protocol_no']}</td>
            <td>Date of diagnosis</td><td >{$patient_arr[0]['diag_stdate']}</td>
  </tr>
      
<tr class="row1">
<td>Patient's e-mail address</td><td>{$patient_arr[0]['pmail']}</td>
<td>Medication name</td><td><label id="dis_medic" title="To edit click here..." style="cursor:pointer;color:orange;" onclick="disp('dis_medic_cnt',this.id);">{$medication_arr[$patient_arr[0]['medication_id']]}&nbsp;<br /> {$patient_arr[0]['med_others']}</label>
<label id="dis_medic_cnt" title="To edit click here..." style="display:none">           
<select name="medic_id" id="medic_id" class="xmedium" onchange="show_other(this.value)">
<option value="">--Select--</option>
{html_options options=$medication_arr selected=($patient_arr[0]['medication_id'])}3
</select><br /><br />
 <input type="text" name="med_name_others" autocomplete="off" id="med_name_others" size="25" placeholder="Enter the others description" maxlength="25" class="txt_box" {if $patient_arr[0]['medication_id']!='8'} style="display:none" {/if} value="{$patient_arr[0]['med_others']}"/>
<a href="javascript:void(0);" style="color:orange;" onclick="if(confirm('Are you sure?'))update(1,document.getElementById('medic_id').value,{$patient_arr[0]['patient_id']},document.getElementById('med_name_others').value);">Update</a></label>
</td></tr>

   <tr class="row2">
            <td>Report authorized by</td><td>{$patient_arr[0]['authorized_by1']}</td>
            <td width="15%">Treatment start date</td><td width="20%"><strong>{$patient_arr[0]['tsdate']}</strong></td>
      </tr>
      
<tr class="row1">
<td>Report authorized by</td><td>{$patient_arr[0]['authorized_by2']}</td>
<td>Type of treatment</td><td>
<label id="dis_tot" title="To edit click here..." style="cursor:pointer;color:orange;" onclick="disp('dis_tot_cnt',this.id);show_sdt({$patient_arr[0]['treatment_type']});">
{$type_of_treatment_arr[$patient_arr[0]['treatment_type']]}
</label>
<label id="dis_tot_cnt" title="To edit click here..." style="display:none">    
<select name="type_of_treatment" id="type_of_treatment" onchange="dis_sldt(this.value);" class="xmedium">
{html_options options=$type_of_treatment_arr selected=($patient_arr[0]['treatment_type'])}
</select><a style="color:orange;" href="javascript:void(0);" onclick="if(confirm('Are you sure?'))update(2,document.getElementById('type_of_treatment').value,{$patient_arr[0]['patient_id']},'');">Update</a></label>
</label>
</td></tr>


<tr class="row2">
<td>Report authorized by</td><td>{$patient_arr[0]['authorized_by3']}</td>
<td><label id="sh_std" {if ($patient_arr[0]['treatment_type']!='2' && $patient_arr[0]['treatment_type']!='3')} style="display:none;"{/if}>Second Line Treatment start date</label></td>

<td><label id="sh_stdt" {if ($patient_arr[0]['treatment_type']!='2' && $patient_arr[0]['treatment_type']!='3') || $patient_arr[0]['stsdate']} style="display:none;"{/if}>
<input class="txt_box" type="text" name="stdate" id="stdate"   onFocus="displayCalendar(document.add_patient_form.stdate,'dd-mm-yyyy',this)"  size="7" readonly="" value="{($patient_arr[0]['stsdate']!='00-00-0000')?$patient_arr[0]['stsdate']:''}" autocomplete="off" />
</label>
<label id="dis_sdt">{($patient_arr[0]['stsdate']!='00-00-0000')?$patient_arr[0]['stsdate']:''}</label>

</td>

</tr>

<tr class="row1">
<td></td><td></td>
<td colspan="2" align="right"><input type="submit" name="save" id="save" value="Edit" class="button" onclick="if(confirm('Are you sure about editing the details?'))edit_patient({$patient_arr[0]['patient_id']}); return false;"/></td>
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
   {* <th width="14%">Control gene transcript number</th>
    <th width="8%">Conversion factor</th>*}
    <th width="2%"></th></tr>
    {for $i=0;$i<$pcnt;$i++}
    
   {if $patient_arr[$i]['test_id']}
    
    <tr class="{cycle values="row1,row2"}" id="tbody_tr_{$i}">
    <td width="" align="center"><label id="sl_no_{$i}">{$i+1}</lable></td>
    <td width="" align="center"><a href="javascript:void(0);" onclick="if(confirm('Are you sure about editing the details?'))edit_test({$patient_arr[$i]['test_id']}); return false;" title="To edit this detail click here...">{($patient_arr[$i]['test_date']!='00/00/0000')?$patient_arr[$i]['test_date']:''}</a></td>
    <td width="" align="center"><a href="javascript:void(0);" onclick="if(confirm('Are you sure about editing the details?'))edit_test({$patient_arr[$i]['test_id']}); return false;" title="To edit this detail click here...">{$patient_arr[$i]['sample_type']}</a></td>
    <td width="" align="center"><a href="javascript:void(0);" onclick="if(confirm('Are you sure about editing the details?'))edit_test({$patient_arr[$i]['test_id']}); return false;" title="To edit this detail click here...">{$patient_arr[$i]['sample_sent_from']}</a></td>
    <td width="" align="center"><a href="javascript:void(0);" onclick="if(confirm('Are you sure about editing the details?'))edit_test({$patient_arr[$i]['test_id']}); return false;" title="To edit this detail click here...">{$patient_arr[$i]['sample_no']}</a></td>
    <td width="" align="center"><a href="javascript:void(0);" onclick="if(confirm('Are you sure about editing the details?'))edit_test({$patient_arr[$i]['test_id']}); return false;" title="To edit this detail click here...">{$patient_arr[$i]['bcr_apl_no']}</a></td>
    {*<td width=""><a href="javascript:void(0);" onclick="if(confirm('Are you sure about editing the details?'))edit_test({$patient_arr[$i]['test_id']}); return false;" title="To edit this detail click here...">{$patient_arr[$i]['controlgene_no']}</a></td>
    <td width=""><a href="javascript:void(0);" onclick="if(confirm('Are you sure about editing the details?'))edit_test({$patient_arr[$i]['test_id']}); return false;" title="To edit this detail click here...">{$patient_arr[$i]['conversion_fact']}</a></td>*}
    <td width="" align="center">
    {if $i!=($pcnt-1)}<a href="javascript:void(0);" onclick="if(confirm('Do you want to delete this row?'))remove_row({$i},{$patient_arr[$i]['test_id']}); return false;" title="Delete this row"><img  src="../../images/minus.png" width="25" height="25"/></a>{else}<span class="remove_class"></span>{/if}</td>
    </tr>
    
    {else}
    
<tr  class="{cycle values="row1,row2"}" id="tbody_tr_{$i}"> <input class="txt_box" type="hidden" name="ptestid[{$i}]" id="ptestid[{$i}]" size="5" value="{$patient_arr[$i]['test_id']}"/>
<td width="" align="center"><label id="sl_no_{$i}">{$i+1}</lable></td>
    <td width="" align="center"><input class="txt_box" type="text" name="dot[{$i}]" id="dot_{$i}" onchange="var c=CompareDates('{date('d-m-Y')}',this.value,'-');if(c==0){ldelim}alert('Selected Date cannot be on future date');this.value=''{rdelim}; var c=CompareDates(this.value,'{$patient_arr[0]['dob']}','-');if(c==0){ldelim}alert('Selected Date cannot be before date of birth');this.value=''{rdelim};"  onFocus="displayCalendar(document.add_patient_form.dot_{$i},'dd-mm-yyyy',this)"  size="8" readonly="" autocomplete="off" value="{($patient_arr[$i]['test_date']!='00/00/0000')?$patient_arr[$i]['test_date']:''}" /></td>
    <td width="" align="center"><input class="txt_box" type="text" name="stest[{$i}]" id="stest[{$i}]" size="18" maxlength="30" value="{$patient_arr[$i]['sample_type']}" autocomplete="off" /></td>
    <td width="" align="center"><input class="txt_box" type="text" name="ssent_from[{$i}]" id="ssent_from[{$i}]" size="18" maxlength="30" value="{$patient_arr[$i]['sample_sent_from']}" autocomplete="off" /></td>
    <td width="" align="center"><input class="txt_box" type="text" name="sno[{$i}]" id="sno[{$i}]" size="15" maxlength="20" value="{$patient_arr[$i]['sample_no']}" autocomplete="off" />{*onblur="validate_custom(this.value,'lbl_sno_{$i}','Number','Enter the numeric value',this.id,'add_patient_form','','false')"<label id="lbl_sno_{$i}" class="error"></label>*}</td>
    <td width="" align="center"><input class="txt_box" type="text" name="apltrans_no[{$i}]" id="apltrans_no[{$i}]" size="15" maxlength="20" value="{$patient_arr[$i]['bcr_apl_no']}" autocomplete="off" onblur="validate_custom(this.value,'lbl_apl_{$i}','Number','Enter the numeric value',this.id,'add_patient_form','','false')"/><label class="error" id="lbl_apl_{$i}"></label></td>
    {*<td width=""><input class="txt_box" type="text" name="genetrans_no[{$i}]" id="genetrans_no[{$i}]" size="15" maxlength="20" value="{$patient_arr[$i]['controlgene_no']}" autocomplete="off" onblur="validate_custom(this.value,'lbl_gno_{$i}','Number','Enter the numeric value',this.id,'add_patient_form','','false')"/><label class="error" id="lbl_gno_{$i}"></label></td> 
    <td width=""><input class="txt_box" type="text" name="con_factor[{$i}]" id="con_factor[{$i}]" size="4" maxlength="2" value="{$patient_arr[$i]['conversion_fact']}" autocomplete="off" onblur="validate_custom(this.value,'lbl_fact_{$i}','Number','Enter the numeric value',this.id,'add_patient_form','','false')"/><label class="error" id="lbl_fact_{$i}"></label></td>*}
    <td width="" align="center"><span class="remove_class"><span class="add"><a href='javascript:void(0);'   name="add" id="add_nrow" class="button" onclick="add_row({$pcnt-1});return false"><img  src="../../images/plus.png" width="25" height="25"/></a></span></span></td></tr>
    {/if}
    {/for}
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
 <tr class="row1"><td>Date of test</td><td><input class="txt_box" type="text" name="edot" id="edot" {$date_valid_1} onFocus="displayCalendar(document.add_patient_form.edot,'dd-mm-yyyy',this)"  size="8" readonly="" autocomplete="off" value="" /></td></tr>
 <tr class="row2"><td>Sample type</td><td><input class="txt_box" type="text" name="estest" id="estest" size="30" maxlength="50"  autocomplete="off" value="" /></td></tr>
 <tr class="row1"><td>Sample sent from (Hospital)</td><td><input class="txt_box" type="text" name="essent_from" id="essent_from" size="18" maxlength="50" value="" autocomplete="off" /></td></tr>
 <tr class="row2"><td>Sample #</td><td><input class="txt_box" type="text" name="esno" id="esno" size="15" maxlength="20" value="" autocomplete="off" /><br /><label class="error" id="lbl_sno"></label></td></tr>
 <tr class="row1"><td>BCR-ABL1 Result % (International Scale)</td><td><input class="txt_box" type="text" name="eapltrans_no" id="eapltrans_no" size="15" maxlength="20" value="" autocomplete="off"  onblur="validate_custom(this.value,'lbl_apl','Number','Enter the numeric value',this.id,'add_patient_form','','false')"/><br /><label class="error" id="lbl_apl"></label></td></tr>
 {* onblur="validate_custom(this.value,'lbl_sno','Number','Enter the numeric value',this.id,'add_patient_form','','false')"
 
 <tr class="row2"><td>Control gene transcript number</td><td><input class="txt_box" type="text" name="egenetrans_no" id="egenetrans_no" size="15" maxlength="20" value="" autocomplete="off"  onblur="validate_custom(this.value,'lbl_gene','Number','Enter the numeric value',this.id,'add_patient_form','','false')"/><br /><label class="error" id="lbl_gene"></label></td></tr>
 <tr class="row1"><td>Conversion factor</td><td><input class="txt_box" type="text" name="econ_factor" id="econ_factor" size="4" maxlength="2" value="" autocomplete="off"   onblur="validate_custom(this.value,'lbl_fact','Number','Enter the numeric value',this.id,'add_patient_form','','false')"/>
*}
 <br /><label class="error" id="lbl_fact"></label></td></tr>
 
 </table> </td>
 
 <td valign="bottom" align="right">
 <input type="button" value="Save" name="save" id="save" class="button" onclick="if(confirm('Are you sure?'))update_test(); return false;"/>
 <input type="button" value="Cancel" name="save" id="save" class="button" onclick="window.location.reload();"/>
 
 </td></tr></table>
    </div>
    

</center>
    {/if}
 
</form>
{include file="footer.tpl"}
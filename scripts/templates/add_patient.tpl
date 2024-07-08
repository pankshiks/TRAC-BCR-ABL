{include file="header.tpl"}
{literal}
<script type="text/javascript">

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

function show_other(value,type)
{
    if(type=='1')
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
    else if(type=='2')
    {
        if(value=='2')
        {
            document.getElementById("bapl_others").style.display="block";
        }
        else
        {
            document.getElementById("bapl_others").style.display="none";
        }
    }
}

function validate_custom1(value,eid,patt,e,vid,fn,mx,opt)
{     
    
  
  	var value=$.trim(value);  
       
    var pat=patt.split(',');
    var err=e.split('~');
    var i;
    

   
    if(err.length==pat.length)
    {
        for(i=0;i<err.length;i++)
        {
            if((value=="")&&(opt=='true'))
            {
                var ereq = document.getElementById(eid);
                ereq.style.display = "none";                
                errset=0;                
            }            
            else if(!checkPattern(value,vid,fn,pat[i],mx) && value)
            {
                $('#'+eid).html(err[i]);  
            	$('[id='+eid+']').css('display', '');
                                                          
                
                
                
                
                
				disable_form(fn,vid,true);
                alertTimerId =window.setTimeout(function ()
                {
                    document.forms[fn].elements[vid].focus();
                }, 0);     
                                          
                errset=1;
                break;
            }
            else
            {
                var ereq = document.getElementById(eid);
                ereq.style.display = "none";                
                errset=0;
            }
        }
        if(errset==1)
        return false;
        else
        {
            disable_form(fn,vid,false); 
            return true;         
        }                
    }   
}
function submit_form() {
var serializedData = $("#add_patient_form").serialize();
$.ajax({
	   	
            url: "../../scripts/ajax/call/add_patient.php",
	   		type: "POST",
	   		data: serializedData,
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

function cancel_form() {

$.ajax({
	   	
            url: "../../scripts/ajax/call/check_cancel.php",
	   		type: "POST",
	   		data: {'id':'1'},
            dataType: 'json', 
   			success: function(data) {
	  	    $.each(data.json_return_array, function(key, val)
            {
                if(val.succ)
    			{
                     window.location='add_patient_test.php';
    			}
                 else
                 {
                       window.location='add_patient.php';
                 }
   	        });
	   		}
	   		});
}
function remove_disabled(type,ttype)
{
   
    
    if(type == '1')
    {
       
        if($("#pat_dob").val().length > 0)
           $('#diag_stdate').removeAttr("disabled");
        else
             $('#diag_stdate').attr("disabled", true );
        
         
    }
    if(ttype == '2')
    {
        if($("#diag_stdate").val().length > 0)
            $('#tdate').removeAttr("disabled");
         else
            $('#tdate').attr("disabled", true );
             
    }
   
}

function validateEmail(email) 
{
    if(email)
    {
    var re = /\S+@\S+\.\S+/;
    var res = (re.test(email));    
    alert(res);
    if(res == false)
    {
    }
    
    }
    
    
}

</script>
<style type="text/css">
#add_pat td{
    	line-height:45px;
}</style>
{/literal}
 
<form id="add_patient_form" name="add_patient_form" method="post">
   <!-- <div style="width:100%;float:left;"></div>!-->{$show_errors}
   <input type="hidden" name="txt_patid" id="txt_patid" value="{$patient_arr[0]['patient_id']}"/>
  
  <table id="gradient-style" id="add_pat"  summary="Meeting Results" width="100%">
  {*<table id="add_pat"  width="95%" border="0" align="center" cellpadding="4" cellspacing="0">if $patient_arr[0]['pcode']}
    <tr class="row1">
    <td>Patient Code<sup>*</sup></td>
    <td>
    <input  type="text" class="txt_box" name="pat_code"  id="pat_code"  value="{($patient_arr[0]['pcode'])?$patient_arr[0]['pcode']:''}" autocomplete="off"   size="5"     readonly="" required="" /> <label class="error" id="lbl_code"></label>
    </td>
   <!-- <td colspan="2" style="font-size:11px"> <div align="right">[<a href="./upload_patient_excel.php"  title="Upload Excel">Upload Excel</a>]</div></td>!-->
    <td colspan="2"></td>
    </tr>	
    {/if*}
    <tr class="row2">
      <td width="25%" height="35px">Name<sup>*</sup></td>
      <td width="25%">
        <input tabindex="1" class="txt_box" name="pat_name"  id="pat_name" value="{($smarty.post.pat_name)?$smarty.post.pat_name:$patient_arr[0]['pname']}" autocomplete="off"  type="text"  maxlength="30" size="25" onblur="validate_custom1(this.value,'lbl_fname','StrictString','Please correct the name',this.id,'add_patient_form','','false'); remove_disabled('1','2')"  required/> <br /><label class="error" id="lbl_fname"></label>
      </td>
       <td width="25%">Physician's name<sup>*</sup></td>
      <td width="25%">
        <input tabindex="10"  class="txt_box" name="phys_name"  id="phys_name" value="{($smarty.post.phys_name)?$smarty.post.phys_name:$patient_arr[0]['physician_name']}" autocomplete="off"  type="text"  maxlength="50" size="25" onblur="validate_custom1(this.value,'lbl_pyname','StrictString','Please correct the Physician\'s name',this.id,'add_patient_form','','false');  remove_disabled('1','2')" required/> <br /><label class="error" id="lbl_pyname"></label>
      </td>
      </tr>
    <tr class="row1">
   
    <td>Surname<sup>*</sup></td>
    <td>
    <input tabindex="2"  class="txt_box" name="psurname"  id="psurname" value="{($smarty.post.psurname)?$smarty.post.psurname:$patient_arr[0]['sur_name']}" autocomplete="off"  type="text"  maxlength="30" size="25" onblur="validate_custom1(this.value,'lbl_sname','StrictString','Please correct the surname',this.id,'add_patient_form','','false');  remove_disabled('1','2')" required/>  <br /><label class="error" id="lbl_sname"></label>
    </td>
     <td>Physician's e-mail address<sup>*</sup></td>
      <td>
        <input tabindex="11"  class="txt_box" name="phys_email"  id="phys_email" value="{($smarty.post.phys_email)?$smarty.post.phys_email:$patient_arr[0]['phy_mail']}" autocomplete="off"  type="text"  maxlength="75" size="25" onblur="validate_custom1(this.value,'lbl_pyemail','Email','Please correct the Physician\'s e-mail address..',this.id,'add_patient_form','','false');  remove_disabled('1','2')" required/>  <br /><label class="error" id="lbl_pyemail"></label>
      </td>
   
    </tr> 
 
    <tr class="row2">
      <td>Gender<sup>*</sup></td>
      <td>{html_radios  tabindex="3"  name='gender' options=$marr selected=($patient_arr[0]['gender']) separator='&nbsp;'} </td>
      <td>The diagnosis and the phase at the time of diagnosis&nbsp;<sup>*</sup></td>
      <td>
      <select tabindex="12"  name="diagnosis" id="diagnosis" class="xmedium"  onblur="validate_custom1(this.value,'lbl_diagnosis','Empty','Please select the diagnosis',this.id,'add_patient_form','','false');  remove_disabled('1','2')"  required>
      <option value="">--Select--</option>
      {html_options options=$diagnosis_arr selected=($patient_arr[0]['diagnosis'])}</select>
      <br /><label class="error" id="lbl_diagnosis">
      
      
      
      </td>
    </tr>
    
    <tr class="row1">
      <td>Date of birth <sup>*</sup></td>
      <td><input tabindex="4"  class="txt_box" type="text" name="pat_dob" id="pat_dob" onFocus="displayCalendar(document.add_patient_form.pat_dob,'dd-mm-yyyy',this)"  size="7" readonly="" value="{($patient_arr[0]['dob']!='00-00-0000')?$patient_arr[0]['dob']:''}" autocomplete="off"   onchange="var c=CompareDates('{date('d-m-Y')}',this.value,'-');if(c==0){ldelim}alert('Date of birth cannot on a future date');this.value=''{rdelim}; var c=CompareDates(document.add_patient_form.diag_stdate.value,this.value,'-');if(c==0){ldelim}alert('Date of birth cannot be after Date of diagnosis');this.value=''{rdelim}; remove_disabled('1','')" required />
      
       
    
      
     <br /><label class="error" id="lbl_dob"></label> </td>
     <td>BCR-ABL transcript subtype <sup>*</sup></td>
      <td><select tabindex="13"  name="bcr_apl_stype" id="bcr_apl_stype" class="xmedium" onchange="show_other(this.value,'2');">
      <option value="">--Select--</option>
      {html_options options=$bcr_apl_stype_arr selected=($patient_arr[0]['bcr_apl'])}</select> {if $patient_arr[0]['bcr_apl']=='2'}<br />{/if}
      <textarea name="bapl_others" id="bapl_others" size="25" placeholder="Enter the others description" class="txt_box" {if $patient_arr[0]['bcr_apl']!='2'} style="display:none" {/if}>{$patient_arr[0]['bcr_apl_others']}</textarea></td>
  
    </tr>
    <tr class="row2">
     <td>Hospital ID <sup>*</sup></td>
      <td><input tabindex="5"  type="text" class="txt_box" name="prot_no" id="prot_no" maxlength="12" value="{($smarty.post.prot_no)?$smarty.post.prot_no:$patient_arr[0]['protocol_no']}" required/> <br />{*onblur="validate_custom1(this.value,'lbl_pno','Number','Please provide a Hospital ID',this.id,'add_patient_form','','false')" <label class="error" id="lbl_pno"></label>*}</td>
      <td>Date of diagnosis <sup>*</sup></td>
       <td><input tabindex="14"  class="txt_box" type="text" name="diag_stdate" id="diag_stdate"  onFocus="displayCalendar(document.add_patient_form.diag_stdate,'dd-mm-yyyy',this)"  size="7" readonly="" value="{($patient_arr[0]['diag_st_date']!='00-00-0000')?$patient_arr[0]['diag_st_date']:''}" autocomplete="off" {$disabled} onchange="var c=CompareDates(this.value,document.add_patient_form.pat_dob.value,'-');if(c==0){ldelim}alert('Date of diagnosis cannot be before date of birth');this.value=''{rdelim}; var c=CompareDates('{date('d-m-Y')}',this.value,'-');if(c==0){ldelim}alert('Date of diagnosis cannot on a future date');this.value=''{rdelim}; remove_disabled('','2')" />{*validate_custom1(this.value,'lbl_tdate','Email','Please enter the Treatment start date',this.id,'add_patient_form','','false')*}
        </td>
      
      
    </tr>

    <tr class="row1">
      <td>Patient's e-mail address</td>
      <td><input tabindex="6"  class="txt_box" type="text" name="p_email" id="p_email"  size="25" maxlength="75" value="{$patient_arr[0]['pmail']}" autocomplete="off" onblur="validate_custom1(this.value,'lbl_pmail','Email','Please correct the Patient\'s e-mail address..',this.id,'add_patient_form','','false');  remove_disabled('1','2')"  /> <br /><label class="error" id="lbl_pmail"></label>
      {*onblur="validate_custom(this.value,'lbl_pmail','Email','Please check the Patient\'s email address',this.id,'add_patient_form','','false'); remove_disabled('1','2')"*}
  </td>{*onblur="validate_custom1(this.value,'lbl_pyemail','Email','Please check the Physician\'s e-mail address..',this.id,'add_patient_form','','false');  remove_disabled('1','2')"*}
   <td>Medication name <sup>*</sup></td>
   <td><select tabindex="15"  name="medic_id" id="medic_id" class="xmedium" onchange="show_other(this.value,'1')">
   <option value="">--Select--</option>
      {html_options options=$medication_arr selected=($patient_arr[0]['medication_id'])}</select>
      
     <input type="text" name="med_name_others" autocomplete="off" id="med_name_others" size="25" placeholder="Enter the others description" maxlength="25" class="txt_box" {if $patient_arr[0]['medication_id']!='8'} style="display:none" {/if} value="{$patient_arr[0]['med_others']}"/>
      </td>
  
  </tr>
     
    <tr class="row2">
      <td>Report authorized by <sup>*</sup></td>
      <td><input tabindex="7"  class="txt_box" type="text" name="auth_1" id="auth_1"  size="25" maxlength="50" value="{$patient_arr[0]['authorized_by1']}" autocomplete="off" onblur="validate_custom1(this.value,'lbl_auth1','StrictString','Please correct the authorized by Name',this.id,'add_patient_form','','false'); remove_disabled('1','2')"  required/> <br /><label class="error" id="lbl_auth1"></label>
  </td>
   <td>Treatment start date <sup>*</sup></td>
   <td><input tabindex="16"  class="txt_box" type="text" name="tdate" id="tdate"   onFocus="displayCalendar(document.add_patient_form.tdate,'dd-mm-yyyy',this)"  size="7" readonly="" value="{($patient_arr[0]['tsdate']!='00-00-0000')?$patient_arr[0]['tsdate']:''}" autocomplete="off" required   {$disabled} onchange="var c=CompareDates(this.value,document.add_patient_form.diag_stdate.value,'-');if(c==0){ldelim}alert('Date of treatment cannot be before date of diagnosis');this.value=''{rdelim}; var c=CompareDates('{date('d-m-Y')}',this.value,'-');if(c==0){ldelim}alert('Treatment start date cannot on a future date');this.value=''{rdelim};" />{*validate_custom1(this.value,'lbl_tdate','Email','Please enter the Treatment start date',this.id,'add_patient_form','','false')*}</td>   
  
  </tr>
     
   <tr class="row1">
      <td>Report authorized by</td>
      <td><input tabindex="8"  class="txt_box" type="text" name="auth_2" id="auth_2"  size="25" maxlength="50" value="{$patient_arr[0]['authorized_by2']}" autocomplete="off" />
  </td>
 <td>Type of treatment <sup>*</sup></td>
   <td><select tabindex="17"  name="type_of_treatment" id="type_of_treatment" class="xmedium" onchange="dis_sldt(this.value);" >
   <option value="">--Select--</option>
      {html_options options=$type_of_treatment_arr selected=($patient_arr[0]['treatment_type'])}</select></td>
  
  </tr>
    <tr class="row2">
      <td>Report authorized by</td>
      <td><input tabindex="9"  class="txt_box" type="text" name="auth_3" id="auth_3"  size="25" maxlength="50" value="{$patient_arr[0]['authorized_by3']}" autocomplete="off" />
  </td>
   <td><label id="sh_std" {if $patient_arr[0]['treatment_type']=='1'} style="display:none;"{/if}>Second Line Treatment start date <sup>*</sup></label></td>   
  <td><label id="sh_stdt" {if ($patient_arr[0]['treatment_type']=='1')} style="display:none;"{/if}>
<input tabindex="18"  class="txt_box" type="text" name="stdate" id="stdate"   onFocus="displayCalendar(document.add_patient_form.stdate,'dd-mm-yyyy',this)"  size="7" readonly="" value="{($patient_arr[0]['stsdate']!='00-00-0000')?$patient_arr[0]['stsdate']:''}" autocomplete="off" onchange="var c=CompareDates(this.value,document.add_patient_form.tdate.value,'-');if(c==0){ldelim}alert('Second Line Treatment start date cannot be before Treatment start date');this.value=''{rdelim}; var c=CompareDates('{date('d-m-Y')}',this.value,'-');if(c==0){ldelim}alert('Second Line Treatment start date cannot on a future date');this.value=''{rdelim};"/>
</label>
</td>
  </tr>
     
      <tr><td align="center" colspan="4"><input tabindex="19" type="submit" name="save" id="save" value="Save" class="button" onclick="if(confirm('Are you sure?'))submit_form(); return false;"/>&nbsp;
      {if ($patient_arr[0]['patient_id'])}
      <input type="reset" name="reset" tabindex="20"  id="reset" value="Cancel" class="button" onclick="cancel_form();"/>
      {else}<input type="reset" name="reset" tabindex="20"  id="reset" value="Reset" class="button" />{/if}</td></tr>

    </table>
 {$menu_str}
</form>
{include file="footer.tpl"}
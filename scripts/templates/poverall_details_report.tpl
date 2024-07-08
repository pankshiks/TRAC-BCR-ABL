{include file="header_ind.tpl"}
{literal}
<script type="text/javascript">

function reset_form()
{
    window.location='poverall_details_report.php';
}



function gotopdfprint()
{
   var url = "patient_overall_pdf.php?name="+ $("#name").val() + "&phy_name=" + $("#phy_name").val() + "&mstone=" + $("#mstone").val() + "&hospital=" + $("#hospital").val()+ "&medic_id=" + $("#medic_id").val()+ "&dod=" + $("#dod").val()+ "&tdate=" + $("#tdate").val();
      
  window.open(url, "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=500, left=500, width=400, height=400,menubar=1");

}
function gotoxlprint()
{
  
            
       var url = "patient_overall_xlprint.php?name="+ $("#name").val() + "&phy_name=" + $("#phy_name").val() + "&mstone=" + $("#mstone").val() + "&hospital=" + $("#hospital").val() + "&medic_id=" + $("#medic_id").val()+ "&dod=" + $("#dod").val()+ "&tdate=" + $("#tdate").val();
        
        window.open(url, "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=500, left=500, width=400, height=400,menubar=1");


    }



</script>
{/literal}

<form id="pat_report" name="pat_report" method="post" action="">


  <div id="maindiv">
  <input type="submit" name="search" id="search" value="Filter" class="button"/>
<input type="reset" name="reset" id="reset" value="Reset" class="button" onclick="reset_form(); return false;"/><br />


 {if $patient_arr}
    <table width="100%"  id="gradient-style">
   
    <tr class="row1">
    <td width="2%" height="30px;"></td>
    <td width="7%"><input type="text" class="txt_box" name="name" id="name" value="{$smarty.post.name}" size="12" maxlength="20"/></td>
    <td width="4%"><input type="text" class="txt_box" name="dod" id="dod" value="{$smarty.post.dod}"  onFocus="displayCalendar(document.pat_report.dod,'dd-mm-yyyy',this)"  size="6"/></td>        
    <td width="4%"><input type="text" class="txt_box" name="tdate" id="tdate" value="{$smarty.post.tdate}"  onFocus="displayCalendar(document.pat_report.tdate,'dd-mm-yyyy',this)"  size="6"/></td>    
    <td width="7%"></td> 
    <td width="7%"><input type="text" class="txt_box" name="mstone" id="mstone" value="{$smarty.post.mstone}" size="5" maxlength="10"/></td> 
    
       <td width="5%"></td>    
    <td width="16%">
    
        <select name="medic_id" id="medic_id" class="medium">
        <option value="">--Select--</option>
        {html_options options=$medication_arr selected=($smarty.post.medic_id)}</select>
      
    </td>    
    <td width="5%"><input type="text" class="txt_box" name="phy_name" id="phy_name" value="{$smarty.post.phy_name}" size="10" maxlength="50"/></td>
    <td width="5%"><input type="text" class="txt_box" name="hospital" id="hospital" value="{$smarty.post.hospital}" size="10" maxlength="50"/></td>
      
    <td width="30%"></td>
   </tr>
   
   
   <tr>
        <th width="2%" height="30px;">#</th>
        <th width="7%">Name</th>
        <th width="4%">Date of diagnosis</th>        
        <th width="4%">Treatment start date</th>
        <th width="7%">Last BCR-ABL result</th>
        <th width="7%">Milestone</th>
        <th width="5%">Time on treatment</th>
        <th width="16%">Medication name</th>
        <th width="5%">Physician's name</th>
        <th width="5%">Sample sent from<br />(Hospital)</th>
        <th width="30%">Graph</th>
   </tr>
   {assign var="j" value=1}
    {for $i=0;$i<$pcnt;$i++}
  {if $last_grapharr[$patient_arr[$i]['patient_id']] && (!$smarty.post.hospital || ($last_bcrabl_arr[$patient_arr[$i]['patient_id']]['hospital'])) && (!$smarty.post.mstone || ($last_bcrabl_arr[$patient_arr[$i]['patient_id']]['milestone']))}
    
    <tr class="{cycle values="row1,row2"}">
    <td width="">{$j++}</td>
    <td width=""><a href="javascript:void(0);" onclick="goback({$patient_arr[$i]['patient_id']},'ind_graph_det.php');" title="To view individual graph click here...">{$patient_arr[$i]['pname']} {$patient_arr[$i]['sur_name']}</a></td>
    <td width="">{$patient_arr[$i]['dof_diagnosis']}</td>
    <td width="">{$patient_arr[$i]['tsdate']}</td>
    <td width="">{$last_bcrabl_arr[$patient_arr[$i]['patient_id']]['bcr_apl_no']}</td>
    <td width="">{$last_bcrabl_arr[$patient_arr[$i]['patient_id']]['milestone']}</td>
    <td width="">{($patient_arr[$i]['treatment_time']<'30')?($patient_arr[$i]['treatment_time']|cat:' day(s)'):($patient_arr[$i]['treatment_month'])}</td>
    <td width="">{$medication_arr[$patient_arr[$i]['medication_id']]}</td>
    <td width="">{$patient_arr[$i]['physician_name']}</td>
    <td width="">{$last_bcrabl_arr[$patient_arr[$i]['patient_id']]['hospital']}</td>
    <td width="" align="center"><img style="cursor:pointer" title="Click here to go to the  Patient Data Report" onclick="goback({$patient_arr[$i]['patient_id']},'patient_details_report.php');"  src="./graph/{$last_grapharr[$patient_arr[$i]['patient_id']]}.png" width="500" height="200"/></td>
  
     </tr>
    
   {/if}
    {/for}
    
    
    
    </table>
    
    {/if}
   
    
    {if $patient_arr}
    <br />
<center><table width="20%"><tr>
<td width="10%"></td>

<td width="10%"><input type="button" name="pdf" id="pdf" value="Export as PDF" class="button" onclick="gotopdfprint(); return false;"/></td>
<td width="10%"><input type="button" name="xl" id="xl" value="Export to excel" class="button" onclick="gotoxlprint(); return false;"/></td>
<td width="10%"></td>

</tr></table></center>
{/if}
 
{$show_errors}
    </div>

</form>

{include file="footer.tpl"}
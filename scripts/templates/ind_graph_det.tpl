{include file="header_ind.tpl"}
{literal}
<script type="text/javascript">

function reset_form()
{
    window.location='ind_graph_det.php';
}
function gotopdfprint(id,tot)
{
 
     var url = "print_indgraph_pdf.php?sdate="+ $("#sdate").val() + "&edate=" + $("#edate").val() + "&type_of_treatment=" + $("#type_of_treatment").val() + "&tot=" + tot+ "&id=" + id;
      
  window.open(url, "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=500, left=500, width=400, height=400,menubar=1");

}



</script>
{/literal}

<form id="pat_report" name="pat_report" method="post" action="">


  <div id="maindiv">
  <input type="submit" name="search" id="search" value="Filter" class="button"/>
<input type="reset" name="reset" id="reset" value="Reset" class="button" onclick="reset_form(); return false;"/><br />


    <table width="100%"  id="gradient-style">
   
    <tr class="row1">
    
    <td width="7%">Start Date</td>
    <td width="4%"><input type="text" class="txt_box" name="sdate" id="sdate" value="{$smarty.post.sdate}"  onFocus="displayCalendar(document.pat_report.sdate,'dd-mm-yyyy',this)"  size="6" style="width:70px"/></td>        
    <td width="7%">End Date</td>
    <td width="4%"><input type="text" class="txt_box" name="edate" id="edate" value="{$smarty.post.edate}"  onFocus="displayCalendar(document.pat_report.edate,'dd-mm-yyyy',this)"  size="6" style="width:70px"/></td>     
        <td width="7%">Treatment Type</td>
     
    <td width="16%">
      <select name="type_of_treatment" id="type_of_treatment" class="xmedium">
      {html_options options=$type_of_treatment_arr selected=(($smarty.post.type_of_treatment)?($smarty.post.type_of_treatment):($patient_arr[0]['treatment_type']))}</select>
    </td>    
       
    
   </tr>
    
    </table>
 
   
    
{$show_errors}
{if $graph}
{$graph}
<center><input id="pdf" class="button" type="button" onclick="gotopdfprint({$patient_arr[0]['patient_id']},{$patient_arr[0]['treatment_type']});" value="Export as PDF" name="pdf"></center>
{/if}
    </div>

</form>

{include file="footer.tpl"}
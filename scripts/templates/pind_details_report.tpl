{include file="header_ind.tpl"}
{literal}
<script type="text/javascript">
function gotoprint()
{
  
  window.open("print_graph.php", "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=500, left=500, width=400, height=400,menubar=1");

}
function gotopdfprint()
{
  
  window.open("print_graph_pdf.php", "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=500, left=500, width=400, height=400,menubar=1");

}
function show_mail()
{
    document.getElementById('semail').innerHTML="<input type=text name=rec_mail id=rec_mail size=20 placeholder='Enter mail id' class='txt_box'/><input type=button name=sendmail id=sendmail value='Send Mail' class=button onclick=send_mail();>";
}

function send_mail()
{

  $.ajax({
	   	
            url: "../../scripts/ajax/call/send_attachmail.php",
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
   	        });
	   		}
	   		});
}

function submit_form(pid) {
$.ajax({
	   	
            url: "../../scripts/ajax/call/save_graph_data.php",
	   		type: "POST",
	   		data: {"id":pid,"evalution":document.getElementById('evalution').value},
            dataType: 'json', 
   			success: function(data) {
	  	    $.each(data.json_return_array, function(key, val)
            {
                if(val.succ)
                {
                    alert(val.succ);
                    window.location='patient_details_report.php';
                }
                else if(val.err)
                    {
                        alert(val.err);
                    }
   	        });
	   		}
	   		});
}
</script>
{/literal}
<form id="pat_report" name="pat_report" method="post" action="">


{if $patient_arr}
  <div id="maindiv">
    
    <table width="100%"  id="gradient-style">
    <tr>
        <th width="2%" height="30px;">#</th>
        <th width="8%">Name</th>
        <th width="5%">Date</th>        
        <th width="12%">Evaluation of the report</th>
        <th width="40%">Graph</th>
   </tr>
    {for $i=0;$i<$pcnt;$i++}
  
    
    <tr class="{cycle values="row1,row2"}">
    <td width="">{$i+1}</td>
    <td width="">{$patient_arr[$i]['pname']} {$patient_arr[$i]['sur_name']}</td>
    <td width="">{$patient_arr[$i]['edate']}</td>
    <td width="">{$patient_arr[$i]['remarks']}</td>
    <td width="" align="center"><img  src="./graph/{$patient_arr[$i]['graph_id']}.png" width="500" height="200"/></td>
  
     </tr>
    
   
    {/for}
    </table>

    </div>
{/if}
</form>

{include file="footer.tpl"}
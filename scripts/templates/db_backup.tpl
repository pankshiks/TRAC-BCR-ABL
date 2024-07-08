{include file="header.tpl"}


 
<form id="db_backup_form" name="db_backup_form" method="post" enctype="multipart/form-data">
  {$show_errors}
   <center>
  <table>
    <tr class="row1">
    <td><input type="submit" class="button" placeholder="Select the file to upload" name="backup" id="backup" value="Backup" onclick="return (confirm('Are you sure?'));"/></td><td></td>
    <td><input type="file" name="afile" id="afile"/> : <input type="submit" class="button" name="restore" id="restore" value="Restore from backup" onclick="return (confirm('Are you sure?'));"/></td>
    </tr>
  </table></center>
 
</form>
{include file="footer.tpl"}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ELN Installation Procedure</title>

<?php 
ini_set('display_errors',FALSE);

if(!$_GET[id])
{ ?> 
<meta http-equiv="refresh" content="3;URL=index.php?id=2"> 
<?php 
}
?>

<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
#apDiv2 {
	position:absolute;
	left:0px;
	top:0px;
	width:100%;
	height:100%;
	z-index:2;
}
</style>
<link href="css/style.css" rel="stylesheet" type="text/css" />

</head>

<body>

<div id="apDiv2">
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  </table>
  <td height="182" valign="top"><div data-animate="bounceInDown" data-animate-inview="20" class="">

      <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="100%" height="150" valign="middle"><div align="center"><img src="images/logo1.png" width="383" height="71" /></div></td>
        </tr>
        <tr>
          <td height="50" valign="top"><table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td width="800" height="350" valign="middle" class="logine-bg2"><table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td>
                    
                    
                    
                     <div align="center" class="title">
		<h1><p style="font: 18pt/25pt Garamond, Georgia, serif;color:#A9A9F5;"><strong>Installation Procedure -ELN</strong></p></h1>
		<h2>&nbsp;</h2>
	</div>
                    
                    
                    
                    
                    
                    
                    
                    <div>
                    
                 
                    
             <?php
/*********************************Install Procedure*********************
    
Created by :
Created Date :09/07/2015
Modified Date :
    
************************************************************************/



   $file_name=$_SERVER['DOCUMENT_ROOT'].'/ELN';
  
  
if($_GET[id])
{
    
    if(trim($_SERVER['DOCUMENT_ROOT']) && file_exists($file_name))
    {
    
    ?>
    <form name="install_form_sec" id="install_form_sec" method="POST" action="">

    <center><input type="submit" name="save" id="save" value="&nbsp;To complete the Installation Click here....&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" class="button_example" onclick="return confirm('Are you sure?');"/></center>
    </form>
    <?php
    }
    else
        $msg="<font color=#B40404>Please Check Server...</font>";
        
}                       
                      
   
   
   
   
                        ///////////Run SQL/////////////
if($_POST['save'])
{

    $con=mysqli_connect("localhost","root","","");

    if(mysqli_connect_errno())// Check connection
        $msg= "Failed to connect to MySQL: ";
    
    

    if(file_exists($file_name.'/install/sql_table.php'))
    {
        
       include($file_name.'/install/sql_table.php');
      
       unset($roll_back);
       foreach($sql_arr as $key=>$value)
       {
        
            if($value)
            {
               
                if (mysqli_query($con,$value) && !$roll_back)
                {
                    $msg="<font color=green><strong>Installation procedure has been completed.Please Go back to the login page</strong>...</font><br><input type=\"button\" onClick=\"window.location='../index.php'\" name=\"back\" value=\"Go To Login\" class=\"button_example\"/>";
                    $save='1';                  
                }
                else
                {
                   
                    $msg="<font color=\"#FF0040\" style=\"font-size:18px;\">Installation Already Completed..</font>";
                    $roll_back='1';
                    
                }
            }

       }
      
        
        foreach($table_arr as $k=>$v)//Check Table is Insert
        {
            if(mysqli_query($con,"select * from  $v"))
                $ok='1';
            else
                $msg.= '<br><font color=#B40404>Table Couldn\'t be Inserted : '.$v.'</font>';
        }
    }
}
    
    
if($msg)
{
?>  

<center>

    <table width="104%" cellpadding="0" cellspacing="0">
    <tr><td colspan="2"><h2 align="center"></h2></td></tr> 
    <tr><td width="100%"><center><?php  echo $msg; ?></center></td></tr> 
    <tr><td style="font-size: 11px;text-align:center">
    <br />
    <?php if(!$save){ ?><input type="button" onClick="window.location='index.php'" name="Back" value="Back" class="button_example"/><?php } unset($save);?>
    <br />
     </tr> 
    <tr>
    <td></td></tr>
    </table>

</center>
<?php } ?>                 
                
                
                
                <?php if(!$_POST)
{
?>

<?php if(!$_GET[id])
{
    ?>    
    <table width="104%" cellpadding="0" cellspacing="0">
    <tr><td colspan="2"><h2 align="center"><p style="font: 14pt/20pt Garamond, Georgia, serif;color:#A9A9F5;;"><strong>Installation Commencement..Please wait.....</strong></p></h2></td></tr> 
  <!-- <tr><td width="100%"><center><br /><br /><input type="submit" name="Submit" value="Start" /></center></td> </tr> !-->
    <tr><td style="font-size: 11px;text-align:center"><p><br /></p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p></tr> 
    <tr><td></td></tr>
    </table>
    <?php } ?>
    
    

<?php } ?>      
                      </div>
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      </td>
                  </tr>
                </table></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        
        <tr>
          <td height="20" valign="top">&nbsp;</td>
        </tr>
      </table>
    </div></td>
  <tr>
    <td></tr></td>
  </tr>
</div>
<img src="images/bg_img3.jpg" class="fp_bgImage" />
</body>
</html>

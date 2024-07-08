<?php
ini_set('display_errors',true);
date_default_timezone_set('Asia/Calcutta');

if($_POST)
{

        
    if($_POST['login_name'] && $_POST['access_code'])
    {
//ini_set('display_errors',true);
session_start();

include(__DIR__ .'/includes/ezsql/ezsql_conn.inc');


$pword=SHA1($_POST['access_code']);//
    $seq_sql_array_1=$db->get_results("SELECT  sid as user_id,user_name
                                            
                                    FROM msom_settings usr 
                                    
                                    where usr.`user_name`='".trim($_POST["login_name"])."' and  
                                    usr.`access_code`='$pword' and sid='1'",ARRAY_A);
                                  
    
       
//print_R($_SESSION['MDS']);
//print_R($_SESSION['MDS']);
    if($seq_sql_array_1[0]["user_id"] && $seq_sql_array_1[0]["user_name"]) //&& $seq_sql_array_1[0]["ucategory"]
    {
        
        $tarr=array('1'=>'ADMINISTRATOR','2'=>'Doctor');
        session_start();
        unset($_SESSION['mso_eln']);
        session_start();
        $_SESSION['mso_eln']["guser_id"]=$seq_sql_array_1[0]["user_id"];
        $_SESSION['mso_eln']["guser_name"]=$seq_sql_array_1[0]["user_name"];
        //$_SESSION['mso_eln']["gcategory"]=$tarr[trim($seq_sql_array_1[0]["ucategory"])];
        //$_SESSION['mso_eln']["gcategory_id"]=trim($seq_sql_array_1[0]["ucategory"]);
        
    
        $log_values=str_pad($seq_sql_array_1[0]["user_id"],6).'>> UserName:'.str_pad($seq_sql_array_1[0]["login_name"],30).' Login'."\n";//.'Category:'.str_pad($seq_sql_array_1[0]["category"],15)

        
         writeulog('user_logs/user_logs',$log_values);

        unset($login_update,$diff_chk,$log_chk,$log_values,$seq_sql_array_1,$mas_setting_arr);
        header("Location:scripts/master/index.php");
        exit;
      
        
    }
    else
        $error_string="<font color=\"#FFCC00\" style=\"font-size:13px;\"> The username or password you entered is incorrect</font>";
    }
    else
        $error_string="<font color=\"#FFCC00\" style=\"font-size:13px;\"> Please Enter the username and password</font>";
}


function writeulog($page,$values)
{
    global $db,$gcompany_name;
    $f_path="./log/".$page."_log_".date('M_W_Y').".txt";
    file_put_contents($f_path,"\n".str_pad(CONST_UNAME,10).' '.str_pad(date("d/m/Y : H:i:s"),20).' '.$values,FILE_APPEND);
    return 'ok';
}
if(isset($_GET['msg']))
   $error_string=$error_string?$error_string:"<font color=\"#FFCC00\" style=\"font-size:13px;\">".urldecode(base64_decode($_GET['msg']))."</font>";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login Form</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
    background: black;
}
#apDiv1 {
	position:absolute;
	left:0px;
	top:0px;
	width:100%;
	height:100%;
	z-index:1;
}
-->
</style>

    <link href="style/minerv_stylesheet.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/jquery.js"></script>
    <script language='JavaScript' src='js/jquery.bpopup.min.js'></script>

<style type="text/css">
<!--
#apDiv2 {
	position: absolute;
	left:0px;
	bottom: 0px;
	width:100%;
	height:50px;
	z-index:2;
	background-color: #f1582f;
	visibility: hidden;
}


#show_pop_up 
    {
        display:none;
        background-color: white;
        height:90px;
        font-family:Open sans,Arial,Helvetica,sans-serif;
         border-radius:10px;
        padding: 6px;
    }
.b-close {
border-radius: 7px;
}
.b-close:hover
{
background-color: #1e1e1e;
}

.alertbutton:hover {
 border-top-color: #ffbc3a;
   background: #f87201;
   color: #ccc;
    cursor:pointer;
}
.alertbutton:active {
   border-top-color: #ffbc3a;
   background: #ffbc3a;
   }
   
.alertbutton{
 background: -moz-linear-gradient(center top , #f87201, #ffbc3a) repeat scroll 0 0 rgba(0, 0, 0, 0);
	background-image:url(images/sub_bg.jpg); background-repeat:repeat-x;
	border: 0px solid #ccc;
	border-radius:6px;
    cursor: pointer;
    color: #fff;
    font-family: Calibri;
    font-size: 14px;
	font-style: italic;
	height: 33px;
    font-weight:none;
    text-decoration: none;
    text-shadow: 0 1px 0 rgba(0, 0, 0, 0.4);
    vertical-align: middle;
    width: 129px;



position: absolute;

}

-->
</style>
<script type="text/javascript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function mail_popup()
{
    reset();
         $('#show_pop_up').bPopup({
            contentContainer:'.content'
        });
}


function reset()
{
    document.getElementById("email").value='';
}
function sendmail()
{
    
   document.getElementById("smail").innerHTML="Sending";
   document.getElementById("smail").disabled = true; 
    
   
   
      $.ajax({
	   	
            url: "./reset_password.php",
	   		type: "POST",
	   		data: {"mailid":document.getElementById('email').value},
            dataType: 'json', 
   			success: function(data) {
	  	    $.each(data.json_return_array, function(key, val)
            {
                if(val.succ)
    			{
    			     alert(val.succ);
                      window.location.reload();
    			}
                 else if(val.err)
                 {
                    alert(val.err);
                 }
                 else if(val.ref)
                 {
                    alert(val.ref);
                 }
                 
                 
                document.getElementById("smail").innerHTML="Submit";
                document.getElementById("smail").disabled = false;
                 
                 
   	        });
	   		}
	   		});         
                   
                   

}
//-->
</script>
</head>

<body style="background-image: url(images/page_bg2.jpg); background-repeat:no-repeat; background-position: 50% 0%">
<div id="apDiv1">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="40">&nbsp;</td>
    </tr>
    <tr>
      <td height="150"><table width="97%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td><div align="center"><img src="images/logo1.png" width="800" height="150" /></div></td>
        </tr>
        <tr>
          <td height="194"><table width="340" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="340" height="240" background="images/login_bg.png">
              
              
              <form id="login_form" name="login_form" method="post" action="">
                <table width="289" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td height="36" valign="top" class="title_50505"><div align="left" class="title_131">
                        <div align="center">Login</div>
                    </div></td>
                  </tr>
                  <tr>
                    <td height="139" valign="top"><table width="289" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td height="38" class="title_10076"><div align="center">
                              <input name="login_name" maxlength="15" type="text" class="username1" id="login_name" placeholder="Username" autocomplete=off>
                          </div></td>
                        </tr>
                        <tr>
                          <td height="39" class="title_10076"><div align="center">
                              <input name="access_code" maxlength="20" type="password" class="password1" id="access_code" placeholder="Password" />
                          </div></td>
                        </tr>
                        <tr>
                          <td height="34" valign="middle"><table width="248" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr>
                                <td width="130" height="23" colspan="2" align="center"><?php echo isset($error_string) ? $error_string : '' ;?><!--<div align="left">
                                    <input type="checkbox" name="checkbox" value="checkbox" />
                                    <span class="title_10nee23">Remember Me</span></div></td>
                                <td width="118" class="title_10076"><div align="right"><a href="#" class="hometoplink28">Forgot password?</a></div></td>-->
                              </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td height="28"><div align="center">
                              <input name="button2" type="submit" class="button" id="button2" value="Submit" /> | <input name="fpassword" type="button" class="button" id="fpassword" value="Forgot Password" onclick="mail_popup();" />
                          </div></td>
                        </tr>
                    </table></td>
                  </tr>
                </table>
                            </form>
                            
                            
                            <div id="show_pop_up"><button class="alertbutton" id="smail" style="top:60px;left:130px" onclick="sendmail();">Submit</button> <button class="alertbutton b-close" style="top:60px;left:300px" onclick="reset();"><span>Cancel</span></button><br />&nbsp;&nbsp;&nbsp;&nbsp; Please enter your registered email id <input type="text" name="email" id="email" size="25" maxlength="" class="txt_box" autocomplete="off" />&nbsp;&nbsp;&nbsp;&nbsp;</div>
                            
              </td>
            </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td height="20" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td height="20">&nbsp;</td>
    </tr>
  </table>
</div>
<div id="apDiv3">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="90">&nbsp;</td>
    </tr>
  </table>
</div>
<div id="apDiv2">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="50"><table width="97%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="66%" height="25"><div align="left"><a href="#" class="hometoplink28">Home</a> <span class="title_10nee23">&nbsp;&nbsp;|&nbsp;&nbsp; </span><a href="#" class="hometoplink28">Change Password</a></div></td>
          <td width="34%"><div align="left" class="title_10nee">
            <div align="right" class="title_10nee"></div>
          </div></td>
        </tr>
      </table></td>
    </tr>
  </table>
</div>

</body>
</html>

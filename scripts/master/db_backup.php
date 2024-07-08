<?PHP
ini_set('display_errors',false);
include($_SERVER['DOCUMENT_ROOT'].'/ELN/includes/layout/default_page_layout.inc');

//$db->debug=1;


function EXPORT_TABLES($host,$user,$pass,$name,  $tables=false, $backup_name=false )//cusomized function
{
    $link = mysqli_connect($host,$user,$pass,$name); if (mysqli_connect_errno()){ echo "ConnecttError: " . mysqli_connect_error();} mysqli_select_db($link,$name);  mysqli_query($link,"SET NAMES 'utf8'");
    $queryTables = mysqli_query($link,'SHOW TABLES'); while($row = mysqli_fetch_row($queryTables)) { $target_tables[] = $row[0]; }  if($tables !== false) { $target_tables = array_intersect( $target_tables, explode(',',$tables)); }

    $content='';    //start cycle
    foreach($target_tables as $table){
        $result = mysqli_query($link,'SELECT * FROM '.$table); $fields_amount = mysqli_num_fields($result);$rows_num=mysqli_num_rows($result); $row2= mysqli_fetch_row(mysqli_query($link, 'SHOW CREATE TABLE '.$table)); 
        $content    .= "\n\n".$row2[1].";\n\n";
        for ($i = 0; $i < $fields_amount; $i++) {
            $st_counter= 0;
            while($row = mysqli_fetch_row($result)) {
                    //when started (and every after 100 command cycle)
                    if ($st_counter%100 == 0 || $st_counter == 0 )  {$content .= "\n!@#$%!@#$%INSERT INTO ".$table." VALUES";}
                $content .= "\n(";
                for($j=0; $j<$fields_amount; $j++)  {
                    $row[$j] = str_replace("\n","\\n", addslashes($row[$j]) );
                    if (isset($row[$j])) { $content .= '"'.$row[$j].'"' ; } else { $content .= '""'; }
                    if ($j<($fields_amount-1)) { $content.= ','; }
                }
                $content .=")";
                    //every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
                    if ( (($st_counter+1)%100==0 && $st_counter!=0) || $st_counter+1==$rows_num) {$content .= ";";} else {$content .= ",";} $st_counter=$st_counter+1;
            }
        }$content .="\n\n\n";
    }

    
   
   $backup_name = "ELN_DB_Backup_".date("d_m_Y_H_i_s").".sql";
    header('Content-Type: application/octet-stream');   header("Content-Transfer-Encoding: Binary"); header("Content-disposition: attachment; filename=\"".$backup_name."\""); echo $content; exit;
}

    if($_POST)
    {
   
        if($_POST['backup'])//Take db backup
        {
            
 EXPORT_TABLES("localhost","root","","medtrix_eln");//local
 
$show_errors="<div class=success>Database back up created Successfully...</div>";




        }
        elseif($_POST['restore'])//restore backup...
        {
           //  $db->debug_all = true;
            
            if($_FILES['afile']['name'])
            {
           
             $db->query('begin;');
             $path_arr=pathinfo($_FILES['afile']['name']);
             $nin_arr=array(''=>'err');
                          
            if(in_array($path_arr['extension'],array('sql','SQL')))
            {
                $ger_sql=file_get_contents($_FILES['afile']['tmp_name']); 
                     
                         
        if($ger_sql)
            {

                $delete_old=$db->query("DROP TABLE  IF EXISTS   `msom_patient`, `msom_settings`, `msom_test`, `msom_graph`;");

                $exp_create=explode("CREATE TABLE ",$ger_sql);
                
                
                if($exp_create && !$error)
                {
                   
                    foreach($exp_create as $kk=>$vv)
                    {
                
                        if(trim($vv) && !$error)
                        {
                            list($createdb_sql,$insert_sql)=explode("!@#$%!@#$%",$vv);

                            if($createdb_sql && !$error)
                            {
                               $chk1= $db->query("CREATE TABLE ".$createdb_sql);
                               if(trim($insert_sql))
                                $chk2= $db->query($insert_sql);
                               

                                if($nin_arr[$chk1.$chk2]=='err')
                               {
                                   $error='1';
                                   $db->query('rollback;');
                                   $show_errors="<div class=error>Error on insert.Please contact admin...</div>";
                                   break;
                               }
                            }
                            
                        }
                        
                    }
                }
            }
                         
                         
                
                               
                               
             if(!$error)
               {
                    $db->query('commit;');
                    $show_errors="<div class=success>Database restored successfully...</div>";
               }   
               else
               {
                 $db->query('rollback;');
                 $show_errors="<div class=error>Error on insert.Please contact admin...</div>";
               }
                
            }
            else
                 $show_errors="<div class=\"error\">Please select a valid sql file </div>";
          
           }
           else
                $show_errors="<div class=\"error\">Please select the  file </div>";
        }
       
    }




$smarty->assign('show_errors',$show_errors);
$smarty->assign('select_box',$opt);
$smarty->assign('page_title','Database Backup');
$smarty->display('db_backup.tpl');
?>
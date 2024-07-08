<?php
class AddPatient
{
    function patient_insert()
    {
        global $db, $guser_id;

        //$db->debug_all=true;
        //$db->show_errors();
        // $db->escape();
        $db->query("begin");

        if (
            trim($_POST["pat_name"]) &&
            trim($_POST["psurname"]) &&
            trim($_POST["phys_name"]) &&
            trim($_POST["phys_email"]) &&
            trim($_POST["gender"]) &&
            trim($_POST["pat_dob"]) &&
            trim($_POST["bcr_apl_stype"]) &&
            trim($_POST["auth_1"]) &&
            trim($_POST["diagnosis"]) &&
            trim($_POST["type_of_treatment"]) &&
            trim($_POST["tdate"]) &&
            trim($_POST["diag_stdate"]) &&
            $_POST["medic_id"] &&
            $_POST["prot_no"]
        ) {
            if ($_POST["medic_id"] != "8" || trim($_POST["med_name_others"])) {
                if ($_POST["medic_id"] != "8") {
                    $_POST["med_name_others"] = "";
                }

                if (
                    $db->get_var(
                        "SELECT CASE WHEN '" .
                            GetFormattedDate($_POST["diag_stdate"]) .
                            "'<='" .
                            GetFormattedDate($_POST["tdate"]) .
                            "' THEN '1' ELSE '0' END"
                    ) == "1"
                ) {
                    $max_pat_id =
                        $db->get_var(
                            "select max(patient_id) from msom_patient"
                        ) + 1;

                    $chk_pat_id = $_POST["txt_patid"]
                        ? $db->get_var(
                            "select patient_id from msom_patient where patient_id=" .
                                $_POST["txt_patid"]
                        )
                        : "";

                    if (
                        $_POST["type_of_treatment"] != "1" &&
                        !$_POST["stdate"]
                    ) {
                        $roll_back = $db->query("rollback");
                        $arr[0]["err"] =
                            "Please select the second line treatment start date...";
                    }

                    if (
                        in_array($_POST["type_of_treatment"], ["2", "3"]) &&
                        $chk_pat_id
                    ) {
                        $last_firstline_test_date = $db->get_var(
                            "SELECT date FROM msom_test WHERE patient_id=$chk_pat_id and treatment_type='1' order by test_id desc"
                        );
                        if ($last_firstline_test_date) {
                            if (
                                $db->get_var(
                                    "SELECT CASE WHEN '$last_firstline_test_date'>='" .
                                        GetFormattedDate($_POST["stdate"]) .
                                        "' THEN '1' ELSE '0' END"
                                ) == "1"
                            ) {
                                $roll_back = $db->query("rollback");
                                $arr[0]["err"] =
                                    "The second line treatment test date must be bigger than the first line test date";
                            }
                        }
                    }

                    if (!$roll_back) {
                        if (
                            $_POST["stdate"] &&
                            $_POST["type_of_treatment"] != "1"
                        ) {
                            $colsup =
                                ",sstart_date='" .
                                GetFormattedDate($_POST["stdate"]) .
                                "'";
                            $colin = ",sstart_date";
                            $colans =
                                ",'" . GetFormattedDate($_POST["stdate"]) . "'";
                        }

                        if ($_POST["bcr_apl_stype"] != "2") {
                            $_POST["bapl_others"] = "";
                        }

                        if (!$chk_pat_id) {
                            $pcodestr =
                                $db->get_var(
                                    "select substr(pcode,3,10) from msom_patient order by patient_id desc"
                                ) + 1;
                            $pcode =
                                "P-" . str_pad($pcodestr, 3, "0", STR_PAD_LEFT);

                            $exist_name = $db->get_var(
                                "SELECT count(*) FROM msom_patient WHERE pcode='$pcode'"
                            );
                            if (!$exist_name) {
                                $insert =
                                    "INSERT INTO `msom_patient` (`patient_id` ,`pcode` ,`pname` ,`sur_name` ,`gender` ,`dob` ,`protocol_no` ,`pmail` ,`authorized_by1` ,`authorized_by2` ,`authorized_by3` ,`physician_name` ,`phy_mail` ,`diagnosis` ,`bcr_apl` ,`start_date` ,`treatment_type` ,`e_user`,diag_st_date,medication_id,med_others,status,graph_id$colin,bcr_apl_others)
VALUES ($max_pat_id,'$pcode','" .
                                    $_POST["pat_name"] .
                                    "','" .
                                    $_POST["psurname"] .
                                    "','" .
                                    $_POST["gender"] .
                                    "','" .
                                    GetFormattedDate($_POST["pat_dob"]) .
                                    "','" .
                                    $_POST["prot_no"] .
                                    "','" .
                                    $_POST["p_email"] .
                                    "','" .
                                    $_POST["auth_1"] .
                                    "','" .
                                    $_POST["auth_2"] .
                                    "','" .
                                    $_POST["auth_3"] .
                                    "','" .
                                    $_POST["phys_name"] .
                                    "','" .
                                    $_POST["phys_email"] .
                                    "','" .
                                    $_POST["diagnosis"] .
                                    "','" .
                                    $_POST["bcr_apl_stype"] .
                                    "','" .
                                    GetFormattedDate($_POST["tdate"]) .
                                    "','" .
                                    $_POST["type_of_treatment"] .
                                    "','$guser_id','" .
                                    GetFormattedDate($_POST["diag_stdate"]) .
                                    "'," .
                                    $_POST["medic_id"] .
                                    ",'" .
                                    $_POST["med_name_others"] .
                                    "','act','0'$colans,'" .
                                    $_POST["bapl_others"] .
                                    "')";

                                $_SESSION["mso_eln"]["pviewid"] = $max_pat_id;

                                if (!$db->query($insert)) {
                                    $roll_back = $db->query("rollback");
                                    $msg =
                                        "Something went wrong. Please contact admin.";
                                } else {
                                    $msg =
                                        "Patient have been added successfully ";
                                } //(Patient code :$pcode)
                            } else {
                                $roll_back = $db->query("rollback");
                                $arr[0]["err"] = "Sorry ! Try again";
                            }
                        } elseif ($chk_pat_id) {
                            $get_status = $db->get_var(
                                "select status from msom_patient where patient_id=" .
                                    $chk_pat_id
                            );
                            if ($get_status == "act") {
                                $update =
                                    "UPDATE  `msom_patient` set  `pname`='" .
                                    $_POST["pat_name"] .
                                    "',`sur_name`='" .
                                    $_POST["psurname"] .
                                    "' ,`gender`='" .
                                    $_POST["gender"] .
                                    "' ,`dob`='" .
                                    GetFormattedDate($_POST["pat_dob"]) .
                                    "' ,`protocol_no`='" .
                                    $_POST["prot_no"] .
                                    "' ,`pmail`='" .
                                    $_POST["p_email"] .
                                    "' ,`authorized_by1`='" .
                                    $_POST["auth_1"] .
                                    "' ,`authorized_by2`='" .
                                    $_POST["auth_2"] .
                                    "' ,`authorized_by3` ='" .
                                    $_POST["auth_3"] .
                                    "',`physician_name`='" .
                                    $_POST["phys_name"] .
                                    "' ,`phy_mail`='" .
                                    $_POST["phys_email"] .
                                    "' ,`diagnosis`='" .
                                    $_POST["diagnosis"] .
                                    "' ,`bcr_apl`='" .
                                    $_POST["bcr_apl_stype"] .
                                    "' ,`start_date`='" .
                                    GetFormattedDate($_POST["tdate"]) .
                                    "' ,`treatment_type`='" .
                                    $_POST["type_of_treatment"] .
                                    "',`e_user`=$guser_id,diag_st_date='" .
                                    GetFormattedDate($_POST["diag_stdate"]) .
                                    "',medication_id=" .
                                    $_POST["medic_id"] .
                                    ",med_others='" .
                                    $_POST["med_name_others"] .
                                    "',graph_id='0'$colsup,bcr_apl_others='" .
                                    $_POST["bapl_others"] .
                                    "' where patient_id=$chk_pat_id";

                                $_SESSION["mso_eln"]["pviewid"] = $chk_pat_id;
                                $ok = $db->query($update);
                                $succ_arr = ["0" => "1", "1" => "1", "" => "2"];
                                if ($succ_arr[trim($ok)] == "1") {
                                    $msg =
                                        "Patient details have been updated successfully";
                                } else {
                                    $roll_back = $db->query("rollback");
                                    $msg =
                                        "Something went wrong. Please contact admin";
                                }
                            } else {
                                unset($_SESSION["mso_eln"]["pviewid"]);
                                $roll_back = $db->query("rollback");
                                $msg = "This patient details already deleted";
                            }
                        } else {
                            $roll_back = $db->query("rollback");
                            $arr[0]["err"] = "Please try again later";
                        }
                        /*if($exist_name)
         $roll_back=$db->execute("rollback");
               $arr[0]['err']="Sorry ! This Patient Code already Exist";*/

                        if (!$roll_back) {
                            $db->query("commit;");
                            $arr[0]["succ"] = $msg;
                            $arr[0]["ret"] = $_REQUEST["txt_patid"];
                        }
                    }
                } else {
                    $arr[0]["err"] =
                        "Please check the Date of diagnosis and Treatment start date";
                }
            } else {
                $arr[0]["err"] = "Please enter the others description";
            }
        } else {
            $arr[0]["err"] = "You have to fill all the required fields";
        }
        //echo $pdate;

        echo '{"json_return_array":' . json_encode($arr) . "}";
    }

    function insert_patienttest()
    {
        global $db, $guser_id;

        // $db->debug_all=true;
        //print_R($_POST['stest']);

        $db->query("begin");

        if ($_POST["txt_patid"]) {
            if ($_POST["dot"]) {
                $get_pdet_arr = $db->get_results(
                    "select status,treatment_type from msom_patient where patient_id=" .
                        $_POST["txt_patid"],
                    ARRAY_A
                );

                $get_status = $get_pdet_arr[0]["status"];
                $treatment_type_id = $get_pdet_arr[0]["treatment_type"];

                if ($get_status == "act") {
                    $item = $row = 0;
                    foreach ($_POST["dot"] as $key => $value) {
                        $row++;

                        //  echo "<br>".$value.' = '.GetFormattedDate($value).' && '.$_POST['stest'][$key].' || '.$_POST['ssent_from'][$key].' || '.$_POST['sno'][$key].' || '.$_POST['apltrans_no'][$key].' || '.$_POST['genetrans_no'][$key].' || '.$_POST['con_factor'][$key];

                        if ($value && !$roll_back) {
                            // && ($_POST['stest'][$key] || $_POST['ssent_from'][$key] || $_POST['sno'][$key] || $_POST['apltrans_no'][$key] || $_POST['genetrans_no'][$key] || $_POST['con_factor'][$key])
                            //$treatment_start_date=$db->get_var("SELECT start_date FROM msom_patient WHERE patient_id=".$_POST['txt_patid']);
                            // $last_test_date=$db->get_var("SELECT date FROM msom_test WHERE patient_id=".$_POST['txt_patid']." order by test_id desc");

                            //  if($db->get_var("SELECT CASE WHEN '$last_test_date'<='".GetFormattedDate($value)."' THEN '1' ELSE '0' END")=='1' || !$last_test_date)
                            //  {
                            //echo'------------------------------'. $treatment_type_id;

                            if ($treatment_type_id == "2") {
                                $last_firstline_test_date = $db->get_var(
                                    "SELECT date FROM msom_test WHERE patient_id=" .
                                        $_POST["txt_patid"] .
                                        " and treatment_type='1' order by test_id desc"
                                );
                                if ($last_firstline_test_date) {
                                    if (
                                        $db->get_var(
                                            "SELECT CASE WHEN '$last_firstline_test_date'>='" .
                                                GetFormattedDate($value) .
                                                "' THEN '1' ELSE '0' END"
                                        ) == "1"
                                    ) {
                                        $roll_back = $db->query("rollback");
                                        $arr[0]["err"] =
                                            "The second line treatment test date must be bigger than the first line test date (Ref : Date of Test  " .
                                            $value .
                                            ")";
                                        break;
                                    }
                                }
                            }

                            // $db->debug_all=true;

                            if (!$roll_back) {
                                if (trim($_POST["apltrans_no"][$key])) {
                                    $max_test_id =
                                        $db->get_var(
                                            "select max(test_id) from msom_test"
                                        ) + 1;
                                    $insert =
                                        "INSERT INTO `msom_test` (test_id,`patient_id` ,`date` ,`sample_type` ,`sample_sent_from` ,`sample_no` ,`bcr_apl_no`,`e_user`,`treatment_type`)VALUES ($max_test_id," .
                                        $_POST["txt_patid"] .
                                        ",'" .
                                        GetFormattedDate($value) .
                                        "','" .
                                        $_POST["stest"][$key] .
                                        "','" .
                                        $_POST["ssent_from"][$key] .
                                        "','" .
                                        $_POST["sno"][$key] .
                                        "','" .
                                        $_POST["apltrans_no"][$key] .
                                        "',$guser_id,'$treatment_type_id');";

                                    $last_dt = GetFormattedDate($value);
                                    // ,`controlgene_no` ,`conversion_fact`     ,'".$_POST['genetrans_no'][$key]."','".$_POST['con_factor'][$key]."'
                                    $result = $db->query($insert);

                                    if (in_array("$result", [""])) {
                                        $roll_back = $db->query("rollback");
                                        $arr[0]["err"] =
                                            "Please check the datas in row " .
                                            $row .
                                            " (OR) Please try again later";
                                        break;
                                    }

                                    $item++;
                                } else {
                                    $roll_back = $db->query("rollback");
                                    $arr[0]["err"] =
                                        "Please enter the BCR-ABL transcript number (Ref : Date of Test  " .
                                        $value .
                                        ")";
                                    break;
                                }
                            }
                            /*}
                else
                {
                     $roll_back=$db->query("rollback");
                    $arr[0]['err']='The date entered is not after the last entered test result (Ref : Date of Test  '.$value.')';
                    break;
                }*/
                        }
                    }

                    if ($item > 0 && !$arr[0]["err"]) {
                        if (!$roll_back) {
                            $db->query(
                                "update msom_patient set graph_id='0' where patient_id=" .
                                    $_POST["txt_patid"]
                            );
                            $_SESSION["mso_eln"]["pviewid"] =
                                $_POST["txt_patid"];
                            $db->query("commit");
                            $arr[0]["succ"] =
                                "Patient Test details have been updated successfully";
                        }
                    } else {
                        $arr[0]["err"] = $arr[0]["err"]
                            ? $arr[0]["err"]
                            : "Please enter atleast one row";
                    }
                } else {
                    unset($_SESSION["mso_eln"]["pviewid"]);
                    $arr[0]["err"] = $arr[0]["err"]
                        ? $arr[0]["err"]
                        : "This patient details already deleted";
                }
            }
        } else {
            $arr[0]["err"] = "Please try again later";
        }

        echo '{"json_return_array":' . json_encode($arr) . "}";
    }

    function remove_test()
    {
        global $db, $guser_id;
        if ($_POST["id"]) {
            $patient_id = $db->get_var(
                "select patient_id from msom_test where test_id=" . $_POST["id"]
            );
            $get_status = $db->get_var(
                "select status from msom_patient where patient_id=" .
                    $patient_id
            );

            if ($get_status == "act") {
                $db->query(
                    "update msom_patient set graph_id='0' where patient_id=" .
                        $patient_id
                );
                $db->query(
                    "DELETE from msom_test where test_id=" . $_POST["id"]
                );
                $arr[0]["succ"] =
                    "Particular test have been deleted permanently";
            } else {
                $arr[0]["err"] = "This patient details already deleted";
            }
        } else {
            $arr[0]["err"] = "Something went wrong.Please try again later";
        }

        echo '{"json_return_array":' . json_encode($arr) . "}";
    }

    function get_edit_test_detail()
    {
        global $db, $guser_id;

        $chk_item_table = $db->get_results(
            "select test_id as tstid,patient_id as pid,DATE_FORMAT(date,'%d-%m-%Y') as tdate,sample_type as stype,sample_sent_from as ssfrom,sample_no as sno,bcr_apl_no as bapl_no,controlgene_no as gen_no,conversion_fact as cfact  from msom_test where test_id=" .
                $_POST["id"],
            ARRAY_A
        );
        $_SESSION["mso_eln"]["edit_test_id"] = $_POST["id"];

        echo '{"json_return_array":' . json_encode($chk_item_table) . "}";
    }

    function update_test()
    {
        global $db, $guser_id;

        //  print_R($_POST);

        if ($_SESSION["mso_eln"]["edit_test_id"] == $_POST["etst_id"]) {
            $patient_id = $db->get_var(
                "select patient_id from msom_test where test_id=" .
                    $_POST["etst_id"]
            );
            $get_status = $db->get_var(
                "select status from msom_patient where patient_id=" .
                    $patient_id
            );

            if ($get_status == "act") {
                if ($_POST["eapltrans_no"]) {
                    // $treatment_start_date=$db->get_var("SELECT p.start_date FROM msom_patient p join  msom_test t on t.patient_id=p.patient_id WHERE t.test_id=".$_POST['etst_id']);
                    // $prev_test_date=$db->get_var("SELECT coalesce(t.date,p.dob) as date FROM msom_test t join msom_patient p on p.patient_id=t.patient_id WHERE t.patient_id=".$patient_id." and t.test_id<".$_POST['etst_id']." order by t.test_id desc");
                    //$next_test_date=$db->get_var("SELECT date FROM msom_test WHERE patient_id=".$patient_id." and test_id>".$_POST['etst_id']." order by test_id asc");

                    //echo '-----------------> '. $prev_test_date.' : '.$next_test_date;

                    //  if($db->get_var("SELECT CASE WHEN '".GetFormattedDate($_POST['edot'])."' between '$prev_test_date' and '".($next_test_date?$next_test_date:date('Y-m-d'))."' THEN '1' ELSE '0' END")=='1')
                    // {

                    //$db->debug_all=true;

                    $db->query("begin");

                    $update =
                        "UPDATE msom_test set `date`='" .
                        GetFormattedDate($_POST["edot"]) .
                        "',`sample_type`='" .
                        $_POST["estest"] .
                        "' ,`sample_sent_from`='" .
                        $_POST["essent_from"] .
                        "' ,`sample_no`='" .
                        $_POST["esno"] .
                        "' ,`bcr_apl_no`='" .
                        $_POST["eapltrans_no"] .
                        "',`e_user`=$guser_id where test_id=" .
                        $_POST["etst_id"];
                    //,`controlgene_no`='".$_POST['egenetrans_no']."' ,`conversion_fact`='".$_POST['econ_factor']."'

                    $result = $db->query($update);

                    if (in_array("$result", [""])) {
                        $roll_back = $db->query("rollback");
                        $arr[0]["err"] =
                            "Please check the datas (OR) Please try again later";
                    } else {
                        $db->query(
                            "update msom_patient set graph_id='0' where patient_id=" .
                                $patient_id
                        );
                        $db->query("commit");
                        $arr[0]["succ"] = "Updated successfully";
                    }
                    // }
                    // else
                    // {
                    //$arr[0]['err']='Please check the entered date of test';
                    //$arr[0]['err']='The date entered is not after the last entered test result'.$last_test_date;
                    //}
                } else {
                    $arr[0]["err"] =
                        "Please enter the BCR-ABL transcript number";
                }
            } else {
                $arr[0]["err"] = "This patient details already deleted";
            }
        } else {
            $arr[0]["err"] = "Something went wrong please try again later";
        }

        echo '{"json_return_array":' . json_encode($arr) . "}";
    }

    function SaveGraphData()
    {
        global $db, $guser_id;

        if ($_POST["id"]) {
            if ($_POST["rdate"]) {
                $type_of_treatment_arr = treatment_type();

                $jcond = $_POST["sel_type_of_treatment"]
                    ? " and t.treatment_type=" . $_POST["sel_type_of_treatment"]
                    : " and t.treatment_type=p.treatment_type";
                $patient_narr = $db->get_results(
                    "select
    p.patient_id,p.pcode,p.pname,p.sur_name,p.gender,DATE_FORMAT(p.dob,'%d-%m-%Y') as dob,p.protocol_no,p.pmail,p.authorized_by1,p.authorized_by2,p.authorized_by3,p.physician_name,p.phy_mail,p.diagnosis,p.bcr_apl,p.treatment_type,

t.test_id,DATE_FORMAT(date,'%d-%m-%Y') as test_date,DATE_FORMAT(p.diag_st_date,'%d-%m-%Y') as diag_st_date,t.sample_type,t.sample_sent_from,t.sample_no,t.bcr_apl_no,t.date as gdate,DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),p.dob)), '%Y')+0 AS age,p.medication_id
,DATE_FORMAT(p.start_date,'%d-%m-%Y') as tsdate,p.start_date
,DATE_FORMAT(p.sstart_date,'%d-%m-%Y') as stsdate,p.sstart_date,DATE_FORMAT(t.date,'%d/%m/%Y') as dis_date


     from msom_patient p
     left join msom_test t on t.patient_id=p.patient_id $jcond
     where p.patient_id=" .
                        $_POST["id"] .
                        " and p.status='act' order by t.date asc",
                    ARRAY_A
                );

                if ($patient_narr) {
                    if ($_POST["sdate"] && $_POST["edate"]) {
                        $tcond .=
                            " and t.date between '" .
                            GetFormattedDate($_POST["sdate"]) .
                            "' and '" .
                            GetFormattedDate($_POST["edate"]) .
                            "'";
                    } else {
                        $tcond .= $_POST["sdate"]
                            ? " and t.date>='" .
                                GetFormattedDate($_POST["sdate"]) .
                                "'"
                            : "";
                        $tcond .= $_POST["edate"]
                            ? " and t.date<='" .
                                GetFormattedDate($_POST["edate"]) .
                                "'"
                            : "";
                    }

                    $tcond .=
                        " and t.treatment_type='" .
                        ($_POST["sel_type_of_treatment"]
                            ? $_POST["sel_type_of_treatment"]
                            : $patient_narr[0]["treatment_type"]) .
                        "'";

                    // $db->debug_all=true;

                    $patient_nnarr = $db->get_results(
                        "select
    p.patient_id,t.bcr_apl_no,t.date as gdate,DATE_FORMAT(t.date,'%d/%m/%Y') as dis_date


     from msom_patient p
     left join msom_test t on t.patient_id=p.patient_id
     where p.patient_id=" .
                            $_POST["id"] .
                            " and p.status='act' and t.date>='" .
                            ($_POST["sel_type_of_treatment"] == "1" ||
                            (!$_POST &&
                                $patient_narr[0]["treatment_type"] == "1")
                                ? $patient_narr[0]["start_date"]
                                : $patient_narr[0]["sstart_date"]) .
                            "' $tcond
     order by t.date asc",
                        ARRAY_A
                    );
                    //print_R($patient_nnarr);
                    if ($patient_nnarr) {
                        foreach ($patient_nnarr as $pkk => $pkv) {
                            $data_narr[0][] = $pkv["bcr_apl_no"];
                            $data_narr[1][] = $pkv["gdate"];
                            $tlast_date = $pkv["dis_date"];
                        }

                        $_SESSION["mso_eln"]["Bcr-AplArr"] = $data_narr;
                        $_SESSION["mso_eln"]["Bcr-AplArr"][2] = $_POST[
                            "sel_type_of_treatment"
                        ]
                            ? $_POST["sel_type_of_treatment"]
                            : $patient_narr[0]["treatment_type"];
                        $_SESSION["mso_eln"]["Bcr-AplArr"][3] =
                            $type_of_treatment_arr[
                                $_POST["sel_type_of_treatment"]
                                    ? $_POST["sel_type_of_treatment"]
                                    : $patient_narr[0]["treatment_type"]
                            ];
                        $_SESSION["mso_eln"]["Bcr-AplArr"][4] =
                            $_POST["sel_type_of_treatment"] == "1"
                                ? $patient_narr[0]["tsdate"]
                                : $patient_narr[0]["stsdate"]; //$patient_narr[0]['test_date'];

                        $_SESSION["mso_eln"]["Bcr-AplArr"][5] =
                            $patient_nnarr[0]["dis_date"];
                        $_SESSION["mso_eln"]["Bcr-AplArr"][6] = $tlast_date;
                        $_SESSION["mso_eln"]["Bcr-AplArr"][7] = $_POST["sdate"]
                            ? $_POST["sdate"]
                            : $_POST["sel_type_of_treatment"];

                        if ($_POST["sdate"] && $_POST["edate"]) {
                            // || $_POST['type_of_treatment'])
                            //echo 'min:'.min($data_narr[0]).' : max:'.max($data_narr[0]);
                            $min = findminmax_yaxix(min($data_narr[0]));
                            $max = findminmax_yaxix(max($data_narr[0])) + 1;
                            //$min=($min=='0'?'-1':$min);
                            $_SESSION["mso_eln"]["Bcr-AplArr"][8] = $min; //($min=='0'?'-1':$min);
                            $_SESSION["mso_eln"]["Bcr-AplArr"][9] =
                                $max == $min ? $max + 1 : $max;
                        }
                        // echo '<prE>';
                        // print_R($_SESSION['mso_eln']['Bcr-AplArr']);
                        //  exit;

                        $get_max_id =
                            $db->get_var(
                                "select max(graph_id) from msom_graph"
                            ) + 1;
                        $path = "../../master/";
                        include "../../master/bcr_apl_graph.php";
                    }
                    $insert = $db->query(
                        "insert into msom_graph(graph_id,patient_id,remarks,e_user,report_date,treatment_type)values($get_max_id," .
                            $_POST["id"] .
                            ",'" .
                            trim($_POST["evalution"]) .
                            "',$guser_id,'" .
                            GetFormattedDate($_POST["rdate"]) .
                            "'," .
                            ($_POST["sel_type_of_treatment"]
                                ? $_POST["sel_type_of_treatment"]
                                : $_POST["stid"]) .
                            ");"
                    );

                    if (in_array($insert, ["0", "1"])) {
                        $db->query(
                            "update msom_patient set graph_id='1' where patient_id=" .
                                $_POST["id"]
                        );
                        $arr[0]["succ"] = "Updated";
                    }

                    session_start();
                    $_SESSION["mso_eln"]["pviewid"] = $_POST["id"];
                } else {
                    $arr[0]["err"] = "There are no records to view";
                }
            } else {
                $arr[0]["err"] = "Please select the report date";
            }
        }

        echo '{"json_return_array":' . json_encode($arr) . "}";
    }

    function remove_patient()
    {
        global $db, $guser_id;

        $get_status = $db->get_var(
            "select status from msom_patient where patient_id=" . $_POST["id"]
        );
        if ($get_status == "act") {
            $update = $db->query(
                "update msom_patient set status='del',e_user=$guser_id where patient_id=" .
                    $_POST["id"]
            );

            if (in_array($update, ["0", "1"])) {
                $arr[0]["succ"] = "Patient details have been deleted";
            }
        } else {
            $arr[0]["err"] = "This patient details already deleted";
        }

        echo '{"json_return_array":' . json_encode($arr) . "}";
    }

    function update_fromtest()
    {
        global $db, $guser_id;

        //  print_R($_POST);

        if (
            in_array($_POST["tp"], ["1", "2"]) &&
            $_POST["uid"] &&
            $_POST["pid"]
        ) {
            if ($_POST["tp"] == "1") {
                //update medication name
                if ($_POST["uid"] != "8" || $_POST["med_desc"]) {
                    if ($_POST["uid"] != "8") {
                        $_POST["med_desc"] = "";
                    }

                    $update = $db->query(
                        "update msom_patient set medication_id=" .
                            $_POST["uid"] .
                            ",med_others='" .
                            $_POST["med_desc"] .
                            "' where patient_id=" .
                            $_POST["pid"]
                    );
                } else {
                    $arr[0]["err"] = "Please enter the others description";
                }
            } elseif ($_POST["tp"] == "2") {
                //Type of treatment
                if ($_POST["uid"] == "1" || $_POST["stsd"]) {
                    if ($_POST["uid"] == "2") {
                        $last_firstline_test_date = $db->get_var(
                            "SELECT date FROM msom_test WHERE patient_id=" .
                                $_POST["pid"] .
                                " and treatment_type='1' order by test_id desc"
                        );
                        if ($last_firstline_test_date) {
                            if (
                                $db->get_var(
                                    "SELECT CASE WHEN '$last_firstline_test_date'>='" .
                                        GetFormattedDate($_POST["stsd"]) .
                                        "' THEN '1' ELSE '0' END"
                                ) == "1"
                            ) {
                                //  $roll_back=$db->query("rollback");
                                $arr[0]["err"] =
                                    "The second line treatment test date must be bigger than the first line test date";
                            }
                        }
                    }
                    if (!$arr[0]["err"]) {
                        $cols = $_POST["stsd"]
                            ? ",sstart_date='" .
                                GetFormattedDate($_POST["stsd"]) .
                                "'"
                            : "";
                        $update = $db->query(
                            "update msom_patient set treatment_type=" .
                                $_POST["uid"] .
                                "$cols where patient_id=" .
                                $_POST["pid"]
                        );
                    }
                } else {
                    $arr[0]["err"] =
                        "Please select the Second Line Treatment start date...";
                }
            }
            if (in_array($update, ["0", "1"])) {
                $arr[0]["succ"] = "Patient details have been updated";
            }
        } else {
            $arr[0]["err"] = "Something  went wrong. Please try again later";
        }

        echo '{"json_return_array":' . json_encode($arr) . "}";
    }
}
?>

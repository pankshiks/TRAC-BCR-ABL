<?php
$sql_arr[]="CREATE DATABASE medtrix_eln;";

$sql_arr[]="CREATE TABLE IF NOT EXISTS medtrix_eln.`msom_graph` (
  `graph_id` int(6) NOT NULL,
  `patient_id` int(6) NOT NULL,
  `report_date` date NOT NULL,
  `treatment_type` smallint(6) NOT NULL,
  `remarks` text,
  `e_user` int(6) NOT NULL,
  `e_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`graph_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

$sql_arr[]="CREATE TABLE IF NOT EXISTS medtrix_eln.`msom_patient` (
  `patient_id` int(6) NOT NULL,
  `pcode` varchar(15) NOT NULL,
  `pname` varchar(30) NOT NULL,
  `sur_name` varchar(30) NOT NULL,
  `gender` char(1) NOT NULL,
  `dob` date NOT NULL,
  `protocol_no` varchar(25) DEFAULT NULL,
  `pmail` varchar(75) DEFAULT NULL,
  `authorized_by1` varchar(50) NOT NULL,
  `authorized_by2` varchar(50) DEFAULT NULL,
  `authorized_by3` varchar(50) DEFAULT NULL,
  `physician_name` varchar(50) NOT NULL,
  `phy_mail` varchar(75) NOT NULL,
  `diagnosis` varchar(35) NOT NULL,
  `bcr_apl` smallint(6) NOT NULL,
  `bcr_apl_others` text,
  `diag_st_date` date DEFAULT NULL,
  `start_date` date NOT NULL,
  `treatment_type` smallint(6) NOT NULL,
  `medication_id` smallint(6) DEFAULT NULL,
  `med_others` varchar(25) DEFAULT NULL,
  `graph_id` int(6) NOT NULL,
  `status` enum('act','del') NOT NULL DEFAULT 'act',
  `e_user` smallint(5) NOT NULL,
  `e_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `sstart_date` date DEFAULT NULL,
  PRIMARY KEY (`patient_id`),
  UNIQUE KEY `pcode` (`pcode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";


$sql_arr[]="CREATE TABLE IF NOT EXISTS medtrix_eln.`msom_settings` (
    `sid` smallint(6) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `access_code` varchar(200) NOT NULL,
  `institution` varchar(25) DEFAULT NULL,
  `sprocedure` text,
  `mail_server` varchar(100) DEFAULT NULL,
  `mail_port` varchar(50) DEFAULT NULL,
  `mail_uname` varchar(50) DEFAULT NULL,
  `mail_pword` varchar(30) DEFAULT NULL,
  `mail_sender` varchar(50) DEFAULT NULL,
  `mail_subject` varchar(200) DEFAULT NULL,
  `e_user` smallint(5) NOT NULL,
  `e_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";


$sql_arr[]="CREATE TABLE IF NOT EXISTS medtrix_eln.`msom_test` (
   `test_id` int(8) NOT NULL,
  `patient_id` int(6) NOT NULL,
  `date` date NOT NULL,
  `sample_type` varchar(30) NOT NULL,
  `sample_sent_from` varchar(30) NOT NULL,
  `sample_no` varchar(20) NOT NULL,
  `bcr_apl_no` varchar(20) DEFAULT NULL,
  `controlgene_no` varchar(20) DEFAULT NULL,
  `conversion_fact` varchar(2) DEFAULT NULL,
  `e_user` smallint(5) NOT NULL,
  `e_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `treatment_type` smallint(6) NOT NULL,
  PRIMARY KEY (`test_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";





$sql_arr[]="INSERT INTO medtrix_eln.msom_settings(sid,user_name,access_code,institution,sprocedure,mail_server,mail_port,mail_uname,mail_pword,mail_sender,mail_subject,e_user,e_time)VALUES
(1,'admin','f865b53623b121fd34ee5426c792e5c33af8c227','','','','587','elntool@gmail.com','elnelneln','elntool@gmail.com','Molecular Follow-Up-Eln 2015','1','2015-05-06 09:01:14');";





$table_arr[]="medtrix_eln.msom_graph";
$table_arr[]="medtrix_eln.msom_patient";
$table_arr[]="medtrix_eln.msom_settings";
$table_arr[]="medtrix_eln.msom_test";
?>
<?php

include ("jsonwrapper.php");
include '../Includes/TDB_DatabaseHelpers.php';
include '../Includes/TDB_Helper.php';
include '../Includes/TDB_BusinessRules.php';
 
$mail = execSelect("SELECT MAILADDRESS FROM  ". $DB_TablePrefix ."ANFORDERER WHERE ID = 35");

print_r($mail[0]);

echo "<br />";

rule_finishedReq(17792, 16, '', '', "ANFORDERUNG", $mail[0]['MAILADDRESS']);

?>

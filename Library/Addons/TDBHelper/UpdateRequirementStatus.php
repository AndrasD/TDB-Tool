<?php

include ("../../AJAX/jsonwrapper.php");
include '../../Includes/TDB_DatabaseHelpers.php';
include '../../Includes/TDB_Helper.php';
include '../../Includes/TDB_BusinessRules.php';
 
error_reporting(E_STRICT, E_WARNING, E_ERROR, E_PARSE);
ini_set('display_errors', 'On');

// Fehler falls keine ID oder Status angegeben
if (trim(filter_input(INPUT_POST, 'id')) == "" || trim(filter_input(INPUT_POST, 'status')) == "") {
    print_r("ID oder Status nicht angegeben!");
    die();
}

$id = filter_input(INPUT_POST, 'id');

if (!is_numeric($id)) {
    print_r("ID '" . $id . "' kein gültiger Datentyp!");
    die();
}

$status = getIDandValidate("STATUS", filter_input(INPUT_POST, 'status'), "Status nicht gültig!");

//SELECT anforderer FROM TDB_DEV_ANFORDERUNG WHERE ID = 17707
$anforderer = execSelect("SELECT anforderer FROM ". $DB_TablePrefix ."ANFORDERUNG WHERE ID = ".$id);
$mail = execSelect("SELECT MAILADDRESS FROM  ". $DB_TablePrefix ."ANFORDERER WHERE ID = ".$anforderer[0]['ANFORDERER']);
$br_result = rule_finishedReq($id, $status, "", "", "ANFORDERUNG", $mail[0]['MAILADDRESS']);
$fertigstellung = $br_result[0];
$fertig = $br_result[1];

if ($fertigstellung != "NULL") {
    $fertigstellung_clause = "FERTIGSTELLUNG = TO_DATE(:fertigstellung, :dateformat),";
    $usefertigsstellung = true;
} else {
    $fertigstellung_clause = "FERTIGSTELLUNG = NULL,";
    $usefertigsstellung = false;
}

$conn = oci_connect($DB_User, $DB_Password, $DB_Host);
if (!$conn) {
    $m = oci_error();
    trigger_error(htmlentities($m['message']), E_USER_ERROR);
}

$edit = "
UPDATE " . $DB_TablePrefix . "ANFORDERUNG SET 
    STATUS = :status,
    " . $fertigstellung_clause . " 
    FERTIG = :fertig
WHERE ID = :id ";

$stid = oci_parse($conn, $edit);

oci_bind_by_name($stid, ":id", $id);
if($usefertigsstellung)
{
    oci_bind_by_name($stid, ":fertigstellung", $fertigstellung);
    oci_bind_by_name($stid, ":dateformat", $dateformat_oracle);
}
oci_bind_by_name($stid, ":fertig", $fertig);
oci_bind_by_name($stid, ":status", $status);

$success = oci_execute($stid, OCI_COMMIT_ON_SUCCESS);

if ($success) {
    $response = array(
        "success" => true,
        "message" => "Anforderung '" . $id . "' wurde bearbeitet!",
        "id" => $id
    );
} else {
    $e = oci_error($conn);
    $response = array(
        "success" => false,
        "message" => $e['message'],
        "id" => NULL
    );
}

oci_close($conn);
// codieren der Daten
print_r(json_encode($response));
?>

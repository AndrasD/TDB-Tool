<?php

error_reporting(E_STRICT, E_WARNING, E_ERROR, E_PARSE);
ini_set('display_errors', 'On');



include ("../../AJAX/jsonwrapper.php");
include '../../Includes/TDB_DatabaseHelpers.php';
include '../../Includes/TDB_Helper.php';




// Fehler falls keine ID angegeben
if (trim(filter_input(INPUT_POST, 'id')) == "") {
    print_r("ID nicht angegeben!");
    die();
}

$id = filter_input(INPUT_POST, 'id');

if (!is_numeric($id)) {
    print_r("ID '" . $id . "' kein gültiger Datentyp!");
    die();
}
//id=24703;

// Delete Jobs
$jobids = parseToSmallColNames(execSelect(" SELECT JOBID, JOBID_SECOND FROM " . $DB_TablePrefix . "ANFORDERUNG WHERE ID = " . $id));
$jobids = $jobids[0];

if($jobids["jobid"] == NULL && $jobids["jobid_second"] == NULL)
{
    $response = array(
        "success" => true,
        "message" => "Keine Jobs bei Anforderung '" . $id . "' eingetragen!",
        "id" => $id
    );
    print_r(json_encode($response));
    die();
}



$conn = oci_connect($DB_User, $DB_Password, $DB_Host);
if (!$conn) {
    $m = oci_error();
    trigger_error(htmlentities($m['message']), E_USER_ERROR);
}

if ($jobids["jobid"] != "") {
    $delete = "DELETE FROM QTP_VARIANZEN_JOBS WHERE Id = :id AND RECHNER='3 TDB-Autojob'";
    $stid = oci_parse($conn, $delete);
    oci_bind_by_name($stid, ":id", $jobids["jobid"]);
    $success = oci_execute($stid, OCI_COMMIT_ON_SUCCESS);
    if (!$success) {
        $e = oci_error($conn);
        $response = array(
            "success" => false,
            "message" => "Fehler beim Löschen (Jobid): " . $e['message'],
            "id" => NULL);
		oci_close($conn);
		// codieren der Daten
		print_r(json_encode($response));
		die();
    } 
}

if ($jobids["jobid_second"] != NULL) {
    $delete = "DELETE FROM QTP_VARIANZEN_JOBS WHERE Id = :id AND RECHNER='3 TDB-Autojob'";
    $stid = oci_parse($conn, $delete);
    oci_bind_by_name($stid, ":id", $jobids["jobid_second"]);
    $success = oci_execute($stid, OCI_COMMIT_ON_SUCCESS);
    if (!$success) {
        $e = oci_error($conn);
        $response = array(
            "success" => false,
            "message" => "Fehler beim Löschen (Jobid_second): " . $e['message'],
            "id" => NULL);
			oci_close($conn);
		// codieren der Daten
		print_r(json_encode($response));
		die();
    }   
}

// Update Anforderung
$edit = "UPDATE " . $DB_TablePrefix . "ANFORDERUNG SET 
    JOBID = NULL, JOBID_SECOND = NULL
WHERE ID = :id ";

$stid = oci_parse($conn, $edit);
oci_bind_by_name($stid, ":id", $id);

$success = oci_execute($stid, OCI_COMMIT_ON_SUCCESS);

if ($success) {
    $response = array(
        "success" => true,
        "message" => "Jobs der Anforderung '" . $id . "' gelöscht!",
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
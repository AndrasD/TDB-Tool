
<?php

include ("jsonwrapper.php");
include '../Includes/TDB_DatabaseHelpers.php';
include '../Includes/TDB_Helper.php';

//error_reporting(E_ALL);
//ini_set('display_errors', 'On');
//$_POST[id] = 8;

// Fehler falls keine ID angegeben
if (!isset($_POST[id])) {
    print_r("Keine ID angegeben!");
    die();
}

$jobid = $_POST[id];

// Fehler falls ID kein Integer-Wert
if (!is_numeric($jobid)) {
    print_r("ID '" . $jobid . "' kein gültiger Datentyp!");
    die();
}

$statement = "SELECT * FROM " . $DB_TablePrefix . "ANFORDERUNG WHERE ID = " . $jobid;

if (count(execSelect($statement)) != 1) {
    $response = array(
        "success" => false,
        "message" => "Anforderung '" . $jobid . "' wurde nicht gefunden!",
        "id" => $jobid
    );
    print_r(json_encode($response));
    die();
}

$conn = oci_connect($DB_User, $DB_Password, $DB_Host);
if (!$conn) {
    $m = oci_error();
    trigger_error(htmlentities($m['message']), E_USER_ERROR);
}
//print_r(get_defined_vars());

$delete = "DELETE FROM " . $DB_TablePrefix . "ANFORDERUNG WHERE Id = :id";

//echo $delete;
$stid = oci_parse($conn, $delete);
oci_bind_by_name($stid, ":id", $jobid);
$success = oci_execute($stid, OCI_COMMIT_ON_SUCCESS);

//$success = true;

if ($success && count(execSelect($statement)) == 0) {
    $response = array(
        "success" => true,
        "message" => "Anforderung '" . $jobid . "' erfolgreich gelöscht!",
        "id" => $jobid
    );
} else {
    $e = oci_error($conn);
    $response = array(
        "success" => false,
        "message" => "Fehler beim Löschen: ".$e['message'],
        "id" => NULL);
}
oci_close($conn);
// codieren der Daten
print_r(json_encode($response));
?>

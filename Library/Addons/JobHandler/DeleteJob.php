
<?php

// necessary includes
include ("../../AJAX/jsonwrapper.php");
include '../../Includes/TDB_DatabaseHelpers.php';
include '../../Includes/TDB_Helper.php';
include 'JobSettings.php';

//error_reporting(E_ALL);
//ini_set('display_errors', 'On');
//$_POST[id] = 151001775;
//$_POST[tdbid] = 17759;
// Fehler falls keine ID angegeben
if (!isset($_POST[id]) || !isset($_POST[tdbid]) || !isset($_POST[isSlaveRun])) {
    print_r("TDB- oder Job-ID fehlt!");
    die();
}

$jobid = $_POST[id];
$tdbid = $_POST[tdbid];

// Fehler falls ID kein Integer-Wert
if (!is_numeric($jobid)) {
    print_r("ID '" . $jobid . "' kein gültiger Datentyp!");
    die();
}
if (!is_numeric($tdbid)) {
    print_r("TDB-ID '" . $tdbid . "' kein gültiger Datentyp!");
    die();
}

$isSlaveRun = false;
if ($_POST[isSlaveRun] == "true") {
    $isSlaveRun = true;
}

$statement = "SELECT * FROM " . $tabelle . " WHERE ID = " . $jobid;

if (count(execSelect($statement)) != 1) {
    $response = array(
        "success" => false,
        "message" => "Job '" . $jobid . "' wurde nicht gefunden!",
        "id" => $jobid
    );
    print_r(json_encode($response));
    die();
}


$statement_tdbid = "SELECT * FROM " . $DB_TablePrefix . "ANFORDERUNG WHERE ID = " . $tdbid;

if (count(execSelect($statement_tdbid)) != 1) {
    $response = array(
        "success" => false,
        "message" => "TDB-ID '" . $tdbid . "' wurde nicht gefunden!",
        "id" => $tdbid
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

$delete = "DELETE FROM " . $tabelle . " WHERE ID = :id";

//echo $delete;
$stid = oci_parse($conn, $delete);
oci_bind_by_name($stid, ":id", $jobid);
$success = oci_execute($stid, OCI_COMMIT_ON_SUCCESS);

//$success = true;

if ($success && count(execSelect($statement)) == 0) {

    $update_tdbid = "UPDATE " . $DB_TablePrefix . "ANFORDERUNG SET JOBID = null WHERE ID = :id";
    if ($isSlaveRun) {
        $update_tdbid = "UPDATE " . $DB_TablePrefix . "ANFORDERUNG SET JOBID_SECOND = null WHERE ID = :id";
    }

    //echo $delete;
    $stid_tdbid = oci_parse($conn, $update_tdbid);
    oci_bind_by_name($stid_tdbid, ":id", $tdbid);
    $success_tdbid = oci_execute($stid_tdbid, OCI_COMMIT_ON_SUCCESS);

    if ($success_tdbid) {

        $response = array(
            "success" => true,
            "message" => " <img src='./Library/Images/checked.gif'/> Job '" . $jobid . "' erfolgreich geloescht!",
            "id" => $jobid
        );
    } else {
        $response = array(
            "success" => false,
            "message" => " Job '" . $jobid . "' erfolgreich geloescht! Anforderung konnte aber nicht aktualisiert werden",
            "id" => $jobid
        );
    }
} else {
    $e = oci_error($conn);
    $response = array(
        "success" => false,
        "message" => "Fehler beim Loeschen. " . $e['message'],
        "id" => NULL);
}
oci_close($conn);
// codieren der Daten
print_r(json_encode($response));
?>


<?php

// necessary includes
include ("../../AJAX/jsonwrapper.php");
include '../../Includes/TDB_DatabaseHelpers.php';
include '../../Includes/TDB_Helper.php';
include 'JobSettings.php';


if (!isset($_POST['id']) || !isset($_POST['ist']) || !isset($_POST['soll']) || !isset($_POST['group']) || !isset($_POST['zusatz'])) {
    print_r("Gesendete Daten sind unvollstaendig!");
    die();
}

$jobid = checkNumeric($_POST['id'], "Id kein numerischer Wert");
$ist = checkNumeric($_POST['ist'], "Ist-Wert kein numerischer Wert");
$soll = checkNumeric($_POST['soll'], "Soll-Wert kein numerischer Wert");
$group = checkNumeric($_POST['group'], "Gruppe kein numerischer Wert");
$zusatz = $_POST['zusatz'];


$statement = "SELECT ID, ANZ_AUSF AS SOLL, COUNT_AUSF AS IST, RECHNERGRUPPE AS GRUPPE, ZUSATZ FROM " . $tabelle . " WHERE ID = " . $jobid;

if (count(execSelect($statement)) != 1) {
    $response = array(
        "success" => false,
        "message" => "Job '" . $jobid . "' wurde nicht gefunden!",
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

$update = "UPDATE " . $tabelle . " SET 
    ANZ_AUSF = :soll,
    COUNT_AUSF = :ist,
    RECHNERGRUPPE = :gruppe,
    ZUSATZ = :zusatz
    WHERE ID = :id";

//echo $delete;
$stid = oci_parse($conn, $update);
oci_bind_by_name($stid, ":id", $jobid);
oci_bind_by_name($stid, ":soll", $soll);
oci_bind_by_name($stid, ":ist", $ist);
oci_bind_by_name($stid, ":gruppe", $group);
oci_bind_by_name($stid, ":zusatz", $zusatz);

$success = oci_execute($stid, OCI_COMMIT_ON_SUCCESS);

if ($success) {
    $result = parseToSmallColNames(execSelect($statement));
    
    if($result[0]["id"] == $jobid && $result[0]["ist"] == $ist && $result[0]["soll"] == $soll && $result[0]["gruppe"] == $group && $result[0]["zusatz"] == $zusatz)
    {
        $response = array(
            "success" => true,
            "message" => " <img src='./Library/Images/checked.gif'/> Job '" . $jobid . "' erfolgreich gespeichert!",
            "id" => $result[0]["id"],
            "ist" => $result[0]["ist"],
            "soll" => $result[0]["soll"],
            "gruppe" => $result[0]["gruppe"],
            "zusatz" => $result[0]["zusatz"]
        );
    }
    else
    {
        $response = array(
        "success" => false,
        "message" => "Fehler beim Bearbeiten. Werte in DB und Reuqest stimmen nicht ueberein.",
        "id" => NULL);
    }
} else {
    $e = oci_error($conn);
    $response = array(
        "success" => false,
        "message" => "Fehler beim Bearbeiten. " . $e['message'],
        "id" => NULL);
}
oci_close($conn);
// codieren der Daten
print_r(json_encode($response));
?>

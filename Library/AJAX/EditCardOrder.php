<?php
include ("jsonwrapper.php");
include '../Includes/TDB_DatabaseHelpers.php';
include '../Includes/TDB_Helper.php';
include '../Includes/TDB_BusinessRules.php';

//error_reporting(E_STRICT, E_WARNING, E_ERROR, E_PARSE);
//ini_set('display_errors', 'On');

// Fehler falls keine ID angegeben
if (!isset($_POST['id'])) {
    print_r("Keine ID angegeben!");
    die();
}

$id = $_POST['id'];

// Fehler falls ID kein Integer-Wert
if (!is_numeric($id)) {
    print_r("ID '" . $id . "' kein gültiger Datentyp!");
    die();
}

if (!isset($_POST['release']
                , $_POST['anforderer']
                , $_POST['anzahl']
                , $_POST['kartentyp']
                , $_POST['standardvertragsgruppe']
                , $_POST['status']
                , $_POST['teilprojekt']
                , $_POST['twinbill']
                , $_POST['eingestellt']
                , $_POST['wunschtermin']
)) {
    $response = array(
        "success" => false,
        "message" => "Kartenbestellung konnte nicht erstellt werden, da nicht alle Daten übermittelt wurden!",
        "id" => -1
    );
    print_r(json_encode($response));
    die();
}

$release = getIDandValidate("RELEASE", $_POST['release'], "Release nicht gültig!");
$anforderer = getIDandValidate("ANFORDERER", $_POST['anforderer'], "Anforderer nicht gültig!");
$provider = getIDandValidate("PROVIDER", $_POST['provider'], "Provider nicht gültig!");
$ansprechpartner = getIDandValidate("ANSPRECHPARTNER", $_POST['ansprechpartner'], "Ansprechpartner nicht gültig!");
$eingestellt = checkDatum($_POST['eingestellt'], "Einstelltermin nicht im korrekten Format");
$wunschtermin = checkDatum($_POST['wunschtermin'], "Wunschtermin nicht im korrekten Format");
$bemerkung = $_POST['bemerkung'];
$bemerkungintern = $_POST['bemerkungintern'];
$status = getIDandValidate("STATUS", $_POST['status'], "Status nicht gültig!");
$teilprojekt = getIDandValidate("TEILPROJEKT", $_POST['teilprojekt'], "Teilprojekt nicht gültig!");
$anzahl = checkNumeric($_POST['anzahl'], "Anzahl nicht im korrekten Format");
if ($_POST['twinbill'] == "true") {
    $tb = 1;
} else {
    $tb = 0;
}
$hlr = getIDandValidateForHLR($release, $_POST[hlr], "HLR nicht gültig!");
$kartentyp = getIDandValidate("KARTENTYPEN", $_POST['kartentyp'], "Kartentyp nicht gültig!");
$stdvgr = getIDandValidate("STANDARDVERTRAGSGRUPPE", $_POST['standardvertragsgruppe'], "STDVGR nicht gültig!");


$mail = execSelect("SELECT MAILADDRESS FROM  ". $DB_TablePrefix ."ANFORDERER WHERE ID = ".$anforderer);
$br_result = rule_finishedReq($id, $status, $_POST['fertigstellung'], $_POST['fertig'], "KARTENBESTELLUNG", $mail[0]['MAILADDRESS']);

$fertigstellung = $br_result[0];
$fertig = $br_result[1];


$conn = oci_connect($DB_User, $DB_Password, $DB_Host);
if (!$conn) {
    $m = oci_error();
    trigger_error(htmlentities($m['message']), E_USER_ERROR);
}


if ($fertigstellung != "NULL") {
    $fertigstellung_clause = "FERTIGSTELLUNG = TO_DATE(:fertigstellung, :dateformat),";
    $usefertigsstellung = true;
} else {
    $fertigstellung_clause = "FERTIGSTELLUNG = NULL,";
    $usefertigsstellung = false;
}

$edit = "UPDATE " . $DB_TablePrefix . "KARTENBESTELLUNG SET 
    RELEASE = :release, 
    ANFORDERER = :anforderer,
    ANSPRECHPARTNER = :ansprechpartner,
    ANZAHL = :anzahl, 
    EINGESTELLT = TO_DATE(:eingestellt, :dateformat), 
    WUNSCHTERMIN = TO_DATE(:wunschtermin, :dateformat), 
    " . $fertigstellung_clause . "
    FERTIG = :fertig, 
    TWINBILL = :twinbill, 
    STDVGR = :stdvgr, 
    KARTENTYP = :kartentyp, 
    STATUS = :status, 
    TEILPROJEKT = :teilprojekt, 
    HLR = :hlr, 
    BEMERKUNG = :bemerkung, 
    BEMERKUNGINTERN = :bemerkungintern,
    PROVIDER = :provider
    WHERE ID = :id";

//print_r(get_defined_vars());

$stid = oci_parse($conn, $edit);

oci_bind_by_name($stid, ":id", $id);
oci_bind_by_name($stid, ":release", $release);
oci_bind_by_name($stid, ":anforderer", $anforderer);
oci_bind_by_name($stid, ":ansprechpartner", $ansprechpartner);
oci_bind_by_name($stid, ":anzahl", $anzahl);
oci_bind_by_name($stid, ":eingestellt", $eingestellt);
oci_bind_by_name($stid, ":wunschtermin", $wunschtermin);
if($usefertigsstellung)
{
    oci_bind_by_name($stid, ":fertigstellung", $fertigstellung);
}
oci_bind_by_name($stid, ":bemerkung", $bemerkung);
oci_bind_by_name($stid, ":fertig", $fertig);
oci_bind_by_name($stid, ":bemerkungintern", $bemerkungintern);
oci_bind_by_name($stid, ":twinbill", $tb);
oci_bind_by_name($stid, ":stdvgr", $stdvgr);
oci_bind_by_name($stid, ":kartentyp", $kartentyp);
oci_bind_by_name($stid, ":status", $status);
oci_bind_by_name($stid, ":teilprojekt", $teilprojekt);
oci_bind_by_name($stid, ":hlr", $hlr);
oci_bind_by_name($stid, ":provider", $provider);
oci_bind_by_name($stid, ":dateformat", $dateformat_oracle);

$success = oci_execute($stid, OCI_COMMIT_ON_SUCCESS);

if ($success) {
    $response = array(
        "success" => true,
        "message" => "Kartenbestellung '" . $id . "' wurde bearbeitet! <button id='zuanforderung' onclick='LoadCardOrder(" . $id . ")'>Zur Bestellung</button>",
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

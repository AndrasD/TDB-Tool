<?php

// Including Helper-Files
include ("jsonwrapper.php");
include '../Includes/TDB_DatabaseHelpers.php';
include '../Includes/TDB_Helper.php';

// Checking if neccessary information is given in POST
// if something is missing, the script execution will be aborted
if (!isset($_POST[release]
                , $_POST[anforderer]
                , $_POST[anzahl]
                , $_POST[kartentyp]
                , $_POST[standardvertragsgruppe]
                , $_POST[status]
                , $_POST[teilprojekt]
                , $_POST[twinbill]
)) {
    $response = array(
        "success" => false,
        "message" => "Kartenbestellung konnte nicht erstellt werden, da nicht alle Daten übermittelt wurden!",
        "id" => -1
    );
    print_r(json_encode($response));
    die();
}

// processing information from POST
$id = getNewId();
$release = getIDandValidate("RELEASE", $_POST[release], "Release nicht gültig!");
$anforderer_text = $_POST[anforderer];
$anforderer = getIDandValidate("ANFORDERER", $anforderer_text, "Anforderer nicht gültig!");
$provider = getIDandValidate("PROVIDER", $_POST[provider], "Provider nicht gültig!");
$ansprechpartner = getIDandValidate("ANSPRECHPARTNER", $defaultAnsprechpartner, "Ansprechpartner nicht gültig!");
$eingestellt = date($dateformat);
$wunschtermin = checkDatum($_POST[wunschtermin], "Wunschtermin nicht im korrekten Format");
$fertigstellung = NULL;
$bemerkung = $_POST[bemerkung];
$bemerkungintern = NULL;
$status = getIDandValidate("STATUS", $defaultNewStatus, "Status nicht gültig!");
$teilprojekt = getIDandValidate("TEILPROJEKT", $_POST[teilprojekt], "Teilprojekt nicht gültig!");
$anzahl = checkNumeric($_POST[anzahl], "Anzahl nicht im korrekten Format");
if ($_POST[twinbill] == "true") {
    $tb = 1;
} else {
    $tb = 0;
}
$hlr = getIDandValidateForHLR($release, $_POST[hlr], "HLR nicht gültig!");
$kartentyp = getIDandValidate("KARTENTYPEN", $_POST[kartentyp], "Kartentyp nicht gültig!");
$stdvgr = getIDandValidate("STANDARDVERTRAGSGRUPPE", $_POST[standardvertragsgruppe], "STDVGR nicht gültig!");
$fertig = NULL;

// opening connection to DB
$conn = oci_connect($DB_User, $DB_Password, $DB_Host);
if (!$conn) {
    $m = oci_error();
    trigger_error(htmlentities($m['message']), E_USER_ERROR);
}

// prepared insert statement
$insert = "INSERT INTO " . $DB_TablePrefix . "KARTENBESTELLUNG VALUES 
    (
    :id, 
    :release, 
    :anforderer, 
    :ansprechpartner, 
    :anzahl, 
    :eingestellt, 
    :wunschtermin, 
    :fertigstellung, 
    :fertig, 
    :twinbill, 
    :stdvgr, 
    :kartentyp, 
    :status, 
    :teilprojekt, 
    :hlr,
    :bemerkung, 
    :bemerkungintern,
    :provider
    )
";

// parsing statement
$stid = oci_parse($conn, $insert);

// binding proecessed information
oci_bind_by_name($stid, ":id", $id);
oci_bind_by_name($stid, ":release", $release);
oci_bind_by_name($stid, ":anforderer", $anforderer);
oci_bind_by_name($stid, ":ansprechpartner", $ansprechpartner);
oci_bind_by_name($stid, ":anzahl", $anzahl);
oci_bind_by_name($stid, ":eingestellt", $eingestellt);
oci_bind_by_name($stid, ":wunschtermin", $wunschtermin);
oci_bind_by_name($stid, ":fertigstellung", $fertigstellung);
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

// executing statement
$success = oci_execute($stid, OCI_COMMIT_ON_SUCCESS);

// preparing response
// on success send success message, in case of failure, send error
if ($success) {
    $response = array(
        "success" => true,
        "message" => "Kartenbestellung '" . $id . "' wurde erstellt! <br /> <button id='zubestellung' onclick='LoadCardOrder(" . $id . ")'>Zur Bestellung</button>",
        "id" => $id
    );

    if ($mail_sendmail == true) {

        //$betreff = '[TDB-Tool] Neue Kartenbestellung ID: ' . $id.' Besteller: '.$anforderer_text;
        $betreff = '[TDB-Tool - '.$release.'] Neue Kartenbestellung ID: '.$id.' Besteller: '.$anforderer_text;
        $nachricht = 'Es wurde eine neue Kartenbestellung eingetragen.';
        mail($mail_empfaenger, $betreff, $nachricht, $mail_header);
    }
} else {
    $e = oci_error($conn);
    $response = array(
        "success" => false,
        "message" => $e['message'],
        "id" => NULL
    );
}

// closing connection
oci_close($conn);

// coding and sending response
print_r(json_encode($response));
?>
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
                , $_POST['wunschtermin']
                , $_POST['bemerkung']
                , $_POST['tarif']
                , $_POST['status']
                , $_POST['teilprojekt']
                , $_POST['hlr']
                , $_POST['iai']
                , $_POST['kartentyp']
                , $_POST['kopplung']
                , $_POST['laufzeit']
                , $_POST['rea']
                , $_POST['bankverbindung']
                , $_POST['ra']
                , $_POST['rmd']
)) {
    $response = array(
        "success" => false,
        "message" => "Anforderung konnte nicht erstellt werden, da nicht alle Daten übermittelt wurden!",
        "id" => -1
    );
    print_r(json_encode($response));
    die();
}

$status = getIDandValidate("STATUS", $_POST['status'], "Status nicht gültig!");
$release = getIDandValidate("RELEASE", $_POST['release'], "Release nicht gültig!");
$anforderer = getIDandValidate("ANFORDERER", $_POST['anforderer'], "Anforderer nicht gültig!");
$ansprechpartner = getIDandValidate("ANSPRECHPARTNER", $_POST['ansprechpartner'], "Ansprechpartner nicht gültig!");
$anzahl = checkNumeric($_POST['anzahl'], "Anzahl kein numerischer Wert");
$eingestellt = checkDatum($_POST['eingestellt'], "Einstelltermin nicht im korrekten Format");
$wunschtermin = checkDatum($_POST['wunschtermin'], "Wunschtermin nicht im korrekten Format");

$bemerkung = $_POST['bemerkung'];
$bemerkungintern = $_POST['bemerkungintern'];
$tarif = getIDandValidate("TARIF", $_POST['tarif'], "Tarif nicht gültig!");
$tarif_second = getIDandValidate("TARIF", $_POST['tarif_second'], "gekoppelter Tarif nicht gültig!");

$teilprojekt = getIDandValidate("TEILPROJEKT", $_POST['teilprojekt'], "Teilprojekt nicht gültig!");
$zusatz = $_POST['zusatz'];
$mapid = $_POST['mapid'];
$mapid_second = $_POST['mapid_second'];
$karten = checkNumeric($_POST['karten'], "Anzahl Karten nicht im korrekten Format");

if ($_POST['bp'] == "true") {
    $bp = 1;
} else {
    $bp = 0;
}

$hlr = getIDandValidateForHLR($release, $_POST[hlr], "HLR nicht gültig!");
$iai = getIDandValidate("IAI", $_POST['iai'], "IAI nicht gültig!");
$kartentyp = getIDandValidate("KARTENTYPEN", $_POST['kartentyp'], "Kartentyp nicht gültig!");

if ($_POST['rollendruck'] == "true") {
    $rollendruck = 1;
} else {
    $rollendruck = 0;
}

$kopplung = getIDandValidate("KOPPLUNGSARTEN", $_POST['kopplung'], "Kopplung nicht gültig!");
$laufzeit = getIDandValidate("LAUFZEITEN", $_POST['laufzeit'], "Laufzeit nicht gültig!");
$rea = getIDandValidate("RECHNUNGSEMPFAENGER", $_POST['rea'], "REA nicht gültig!");
$bankverbindung = getIDandValidate("BANKVERBINDUNGEN", $_POST['bankverbindung'], "Bankverbindung nicht gültig!");

if ($_POST['regulierer'] == "true") {
    $regulierer = 1;
} else {
    $regulierer = 0;
}

if ($_POST['homezone'] == "true") {
    $homezone = 1;
} else {
    $homezone = 0;
}

$ra = getIDandValidate("RECHNUNGSARTEN", $_POST['ra'], "Rechnungart nicht gültig!");
$rv = trim($_POST['rv']);
$rmd = getIDandValidate("RECHNUNGSMEDIA", $_POST['rmd'], "Rechnungsmedium nicht gültig!");

$mail = execSelect("SELECT MAILADDRESS FROM  ". $DB_TablePrefix ."ANFORDERER WHERE ID = ".$anforderer);
$br_result = rule_finishedReq($id, $status, $_POST['fertigstellung'], $_POST['fertig'], "ANFORDERUNG", $mail[0]['MAILADDRESS']);
$fertigstellung = $br_result[0];
$fertig = $br_result[1];

if ($_POST['organisation'] == "true") {
    $organisation = 1;
} else {
    $organisation = 0;
}
 $ort  = $_POST['ort'];
 $plz = checkNumeric($_POST['plz'], "PLZ kein numerischer Wert", true);
 $strasse = $_POST['strasse'];
 $hausnummer = checkNumeric($_POST['hausnummer'], "Hausnummer kein numerischer Wert", true);
 $vorname = $_POST['vorname'];
 $nachname = $_POST['nachname'];
 $age = checkNumeric($_POST['age'], "Alter kein numerischer Wert", true);
 $vo  = $_POST['vo'];


 
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


$edit = "
UPDATE " . $DB_TablePrefix . "ANFORDERUNG SET 
    RELEASE = :release, 
    ANFORDERER = :anforderer, 
    ANSPRECHPARTNER = :ansprechpartner, 
    ANZAHL = :anzahl, 
    EINGESTELLT = TO_DATE(:eingestellt, :dateformat), 
    WUNSCHTERMIN = TO_DATE(:wunschtermin, :dateformat), 
    " . $fertigstellung_clause . "
    FERTIG = :fertig, 
    TARIF = :tarif, 
    STATUS = :status, 
    TEILPROJEKT = :teilprojekt, 
    ZUSATZ = :zusatz, 
    MAPID = :mapid,
    HLR = :hlr, 
    IAI = :iai, 
    ANZAHLKARTEN = :anzahlkarten, 
    BP = :bp, 
    KARTENTYP = :kartentyp, 
    ROLLENDRUCK = :rollendruck, 
    KOPPLUNG = :kopplung, 
    HOMEZONE = :homezone, 
    LAUFZEIT = :laufzeit, 
    RAHMENVERTRAG = :rahmenvertrag, 
    ABWEICHENDERREG = :abweichenderreg, 
    BANKVERBINDUNG = :bankverbindung, 
    RECHNUNGSEMPFAENGER = :rechnungsempfaenger, 
    RECHNUNGSART = :rechnungsart, 
    RECHNUNGSMEDIUM = :rechnungsmedium, 
    BEMERKUNG = :bemerkung, 
    BEMERKUNGINTERN = :bemerkungintern,
    organisation = :organisation,
    ort = :ort,
    plz = :plz,
    strasse = :strasse,
    hausnummer = :hausnummer,
    vorname = :vorname,
    nachname = :nachname,
    age = :age,
    vo = :vo,
    mapid_second = :mapid_second,
    tarif_second = :tarif_second
WHERE ID = :id ";

$stid = oci_parse($conn, $edit);

oci_bind_by_name($stid, ":mapid_second", $mapid_second);
oci_bind_by_name($stid, ":tarif_second", $tarif_second);
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
oci_bind_by_name($stid, ":tarif", $tarif);
oci_bind_by_name($stid, ":status", $status);
oci_bind_by_name($stid, ":teilprojekt", $teilprojekt);
oci_bind_by_name($stid, ":zusatz", $zusatz);
oci_bind_by_name($stid, ":mapid", $mapid);
oci_bind_by_name($stid, ":hlr", $hlr);
oci_bind_by_name($stid, ":iai", $iai);
oci_bind_by_name($stid, ":anzahlkarten", $karten);
oci_bind_by_name($stid, ":bp", $bp);
oci_bind_by_name($stid, ":kartentyp", $kartentyp);
oci_bind_by_name($stid, ":rollendruck", $rollendruck);
oci_bind_by_name($stid, ":kopplung", $kopplung);
oci_bind_by_name($stid, ":homezone", $homezone);
oci_bind_by_name($stid, ":laufzeit", $laufzeit);
oci_bind_by_name($stid, ":rahmenvertrag", $rv);
oci_bind_by_name($stid, ":abweichenderreg", $regulierer);
oci_bind_by_name($stid, ":bankverbindung", $bankverbindung);
oci_bind_by_name($stid, ":rechnungsempfaenger", $rea);
oci_bind_by_name($stid, ":rechnungsart", $ra);
oci_bind_by_name($stid, ":rechnungsmedium", $rmd);
oci_bind_by_name($stid, ":dateformat", $dateformat_oracle);
oci_bind_by_name($stid, ":organisation", $organisation);
oci_bind_by_name($stid, ":ort", $ort);
oci_bind_by_name($stid, ":plz", $plz);
oci_bind_by_name($stid, ":strasse", $strasse);
oci_bind_by_name($stid, ":hausnummer", $hausnummer);
oci_bind_by_name($stid, ":vorname", $vorname);
oci_bind_by_name($stid, ":nachname", $nachname);
oci_bind_by_name($stid, ":age", $age);
oci_bind_by_name($stid, ":vo", $vo);

$success = oci_execute($stid, OCI_COMMIT_ON_SUCCESS);

if ($success) {
    $response = array(
        "success" => true,
        "message" => "Anforderung '" . $id . "' wurde bearbeitet! <br /> <button id='zuanforderung' onclick='LoadRequirement(" . $id . ")'>Zur Anforderung</button>",
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

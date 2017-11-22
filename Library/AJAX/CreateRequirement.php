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
                , $_POST[wunschtermin]
                , $_POST[bemerkung]
                , $_POST[tarif]
                , $_POST[status]
                , $_POST[teilprojekt]
                , $_POST[hlr]
                , $_POST[iai]
                , $_POST[kartentyp]
                , $_POST[kopplung]
                , $_POST[laufzeit]
                , $_POST[rea]
                , $_POST[bankverbindung]
                , $_POST[ra]
                , $_POST[rmd]
)) {
    $response = array(
        "success" => false,
        "message" => "Anforderung konnte nicht erstellt werden, da nicht alle Daten übermittelt wurden!",
        "id" => -1
    );
    print_r(json_encode($response));
    die();
}

// processing information from POST
$anforderer_text = $_POST[anforderer];
$id = getNewId();
$release = getIDandValidate("RELEASE", $_POST[release], "Release nicht gültig!");
$anforderer = getIDandValidate("ANFORDERER", $anforderer_text, "Anforderer nicht gültig!");
$ansprechpartner = getIDandValidate("ANSPRECHPARTNER", $defaultAnsprechpartner, "Ansprechpartner nicht gültig!");
$anzahl = checkNumeric($_POST[anzahl], "Anzahl kein numerischer Wert");
$eingestellt = date($dateformat);
$wunschtermin = checkDatum($_POST[wunschtermin], "Wunschtermin nicht im korrekten Format");
$fertigstellung = NULL;
$bemerkung = $_POST[bemerkung];
$bemerkungintern = NULL;
$tarif = getIDandValidate("TARIF", $_POST[tarif], "Tarif nicht gültig!");

$tarif_second = getIDandValidate("TARIF", $_POST[tarif_second], "Tarif nicht gültig!");

$status = getIDandValidate("STATUS", $defaultNewStatus, "Status nicht gültig!");
$teilprojekt = getIDandValidate("TEILPROJEKT", $_POST[teilprojekt], "Teilprojekt nicht gültig!");
$zusatz = $id."tdb";
$karten = checkNumeric($_POST[karten], "Anzahl Karten nicht im korrekten Format");
if ($_POST[bp] == "true") {
    $bp = 1;
} else {
    $bp = 0;
}
$hlr = getIDandValidateForHLR($release, $_POST[hlr], "HLR nicht gültig!");
$iai = getIDandValidate("IAI", $_POST[iai], "IAI nicht gültig!");
$kartentyp = getIDandValidate("KARTENTYPEN", $_POST[kartentyp], "Kartentyp nicht gültig!");
if ($_POST[rollendruck] == "true") {
    $rollendruck = 1;
} else {
    $rollendruck = 0;
}
$kopplung = getIDandValidate("KOPPLUNGSARTEN", $_POST[kopplung], "Kopplung nicht gültig!");
$laufzeit = getIDandValidate("LAUFZEITEN", $_POST[laufzeit], "Laufzeit nicht gültig!");
$rea = getIDandValidate("RECHNUNGSEMPFAENGER", $_POST[rea], "REA nicht gültig!");
$bankverbindung = getIDandValidate("BANKVERBINDUNGEN", $_POST[bankverbindung], "Bankverbindung nicht gültig!");
if ($_POST[regulierer] == "true") {
    $regulierer = 1;
} else {
    $regulierer = 0;
}
if ($_POST[homezone] == "true") {
    $homezone = 1;
} else {
    $homezone = 0;
}
$ra = getIDandValidate("RECHNUNGSARTEN", $_POST[ra], "Rechnungart nicht gültig!");
$rv = trim($_POST[rv]);
$rmd = getIDandValidate("RECHNUNGSMEDIA", $_POST[rmd], "Rechnungsmedium nicht gültig!");
$fertig = NULL;
$mapid = NULL; 
$jobid = NULL;

$mapid_second = NULL; 
$jobid_second = NULL;

if ($_POST[organisation] == "true") {
    $organisation = 1;
} else {
    $organisation = 0;
}
 $ort  = $_POST[ort];
 $plz = checkNumeric($_POST[plz], "PLZ kein numerischer Wert", true);
 $strasse = $_POST[strasse];
 $hausnummer = checkNumeric($_POST[hausnummer], "Hausnummer kein numerischer Wert", true);
 $vorname = $_POST[vorname];
 $nachname = $_POST[nachname];
 $age = checkNumeric($_POST[age], "Alter kein numerischer Wert", true);
 $vo  = $_POST[vo];

// opening connection to DB
$conn = oci_connect($DB_User, $DB_Password, $DB_Host);
if (!$conn) {
    $m = oci_error();
    trigger_error(htmlentities($m['message']), E_USER_ERROR);
}

// preparing insert statement
$insert = "INSERT INTO " . $DB_TablePrefix . "ANFORDERUNG
VALUES
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
 :tarif, 
 :status,
 :teilprojekt, 
 :zusatz, 
 :hlr,
 :iai,
 :anzahlkarten,
 :bp,
 :kartentyp,
 :rollendruck,
 :kopplung, 
 :homezone,
 :laufzeit,
 :rahmenvertrag,
 :abweichenderreg,
 :bankverbindung,
 :rechnungsempfaenger,
 :rechnungsart,
 :rechnungsmedium,
 :bemerkung,
 :bemerkungintern,
 :mapid,
 :jobid,
 :organisation,
 :ort,
 :plz,
 :strasse,
 :hausnummer,
 :vorname,
 :nachname,
 :age,
 :vo,
 :jobid_second,
 :tarif_second,
 :mapid_second
)";

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
oci_bind_by_name($stid, ":jobid", $jobid);

oci_bind_by_name($stid, ":organisation", $organisation);
oci_bind_by_name($stid, ":ort", $ort);
oci_bind_by_name($stid, ":plz", $plz);
oci_bind_by_name($stid, ":strasse", $strasse);
oci_bind_by_name($stid, ":hausnummer", $hausnummer);
oci_bind_by_name($stid, ":vorname", $vorname);
oci_bind_by_name($stid, ":nachname", $nachname);
oci_bind_by_name($stid, ":age", $age);
oci_bind_by_name($stid, ":vo", $vo);

oci_bind_by_name($stid, ":jobid_second", $jobid_second);
oci_bind_by_name($stid, ":tarif_second", $tarif_second);
oci_bind_by_name($stid, ":mapid_second", $mapid_second);

// executing statement
$success = oci_execute($stid, OCI_COMMIT_ON_SUCCESS);

// preparing response
// on success send success message, in case of failure, send error
if($success)
{
    $response = array(
        "success" => true,
        "message" => "Anforderung '".$id."' wurde erstellt! <br /> <button id='zuanforderung' onclick='LoadRequirement(".$id.")'>Zur Anforderung</button>",
        "id" => $id
    );
    
    
    if($mail_sendmail == true)
    {
        
        $betreff = '[TDB-Tool - '.$release.'] Neue Vertragsbestellung ID: '.$id.' Besteller: '.$anforderer_text;
        $nachricht = 'Es wurde eine neue Vertragsbestellung eingetragen.';
        mail($mail_empfaenger, $betreff, $nachricht, $mail_header);
    }
}
else
{
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

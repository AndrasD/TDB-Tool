<?php

include ("jsonwrapper.php");
include '../Includes/TDB_DatabaseHelpers.php';
include '../Includes/TDB_Helper.php';

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
$array = parseToSmallColNames(
        execSelect(
                " SELECT 
    anf.ID As id,
    tp.VALUE As Teilprojekt,
    rel.VALUE As Release,
    anfo.VALUE As Anforderer,
    anf.ANZAHL As Anzahl,
    anf.ANZAHLKARTEN As karten,
    COALESCE(anf.RAHMENVERTRAG, '') As RV,
    tarif.VALUE As Tarif,
    tarif_second.VALUE As Tarif_Second,
    kt.VALUE As Kartentyp,
    lz.VALUE As Laufzeit,
    to_char(anf.EINGESTELLT,'DD.MM.YYYY') As Eingestellt,
    to_char(anf.WUNSCHTERMIN,'DD.MM.YYYY') As Wunschtermin,
    COALESCE(to_char(anf.FERTIGSTELLUNG,'DD.MM.YYYY'), '') As Fertigstellung,
    COALESCE(anf.BEMERKUNG, '') As Bemerkung,
    COALESCE(anf.BEMERKUNGINTERN, '') As BemerkungIntern,
    COALESCE(ansp.VALUE, '') As Ansprechpartner,
    COALESCE(anf.FERTIG, '') As Fertig,
    COALESCE(anf.ZUSATZ, '') As Zusatz,
    COALESCE(anf.MAPID, '') As MapID,
     COALESCE(anf.MAPID_SECOND, '') As MapID_Second,
    anf.JOBID As JobID,
    anf.JOBID_SECOND As JobID_Second,
    DECODE(
                anf.organisation, 
                    0,'false',
                    1,'true'
            ) As organisation  ,
    COALESCE(anf.ort, '') As ort,
    anf.plz As plz,
    anf.age As age,
    COALESCE(anf.strasse, '') As strasse,
    anf.hausnummer As hausnummer,
    COALESCE(anf.vorname, '') As vorname,
    COALESCE(anf.nachname, '') As nachname,
    COALESCE(anf.vo, '') As vo,
    DECODE(
                anf.BP, 
                    0,'false',
                    1,'true'
            ) As BP  ,
    hlr.VALUE As HLR,
    iai.VALUE As IAI,
    kopp.VALUE As kopplung,
    rea.VALUE As rea,
    bv.VALUE As bankverbindung,
    ra.VALUE As ra,
    rmd.VALUE As rmd,
    DECODE(
                anf.rollendruck, 
                    0,'false',
                    1,'true'
            ) As rollendruck  ,
    DECODE(
                anf.homezone, 
                    0,'false',
                    1,'true'
            ) As homezone  ,
    DECODE(
                anf.ABWEICHENDERREG, 
                    0,'false',
                    1,'true'
            ) As regulierer  ,
    stat.VALUE As Status
  FROM " . $DB_TablePrefix . "ANFORDERUNG anf
    INNER JOIN " . $DB_TablePrefix . "TEILPROJEKT tp ON anf.teilprojekt = tp.ID
    INNER JOIN " . $DB_TablePrefix . "ANFORDERER anfo on anf.ANFORDERER = anfo.ID
    INNER JOIN " . $DB_TablePrefix . "RELEASE rel ON anf.RELEASE = rel.ID
    INNER JOIN " . $DB_TablePrefix . "TARIF tarif ON anf.TARIF = tarif.ID
    INNER JOIN " . $DB_TablePrefix . "TARIF tarif_second ON anf.TARIF_SECOND = tarif_second.ID    
    INNER JOIN " . $DB_TablePrefix . "KARTENTYPEN kt ON anf.KARTENTYP = kt.ID
    INNER JOIN " . $DB_TablePrefix . "LAUFZEITEN lz ON anf.LAUFZEIT = lz.ID
    LEFT OUTER JOIN " . $DB_TablePrefix . "ANSPRECHPARTNER ansp ON anf.ANSPRECHPARTNER = ansp.ID
    INNER JOIN " . $DB_TablePrefix . "STATUS stat ON  anf.STATUS = stat.ID 
    INNER JOIN " . $DB_TablePrefix . "HLR hlr ON  anf.HLR = hlr.ID 
    INNER JOIN " . $DB_TablePrefix . "IAI iai ON  anf.IAI = iai.ID 
    INNER JOIN " . $DB_TablePrefix . "KOPPLUNGSARTEN kopp ON  anf.Kopplung = kopp.ID 
    INNER JOIN " . $DB_TablePrefix . "Rechnungsempfaenger rea ON  anf.RECHNUNGSEMPFAENGER = rea.ID 
    INNER JOIN " . $DB_TablePrefix . "BANKVERBINDUNGEN bv ON  anf.BANKVERBINDUNG = bv.ID 
    INNER JOIN " . $DB_TablePrefix . "RECHNUNGSARTEN ra ON  anf.RECHNUNGSART = ra.ID
    INNER JOIN " . $DB_TablePrefix . "RECHNUNGSMEDIA rmd ON  anf.RECHNUNGSMEDIUM = rmd.ID
  WHERE anf.ID = ".$jobid
        )
);

// codieren der Daten
print_r(json_encode($array[0]));
?>

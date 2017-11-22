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
                "SELECT
                    ktb.ID As id,
                    tp.VALUE As Teilprojekt,
                    rel.VALUE As Release,
                    anfo.VALUE As Anforderer,
                    hlr.VALUE As HLR,
                    prov.VALUE As provider,
                    DECODE(
                                ktb.TWINBILL, 
                                    0,'false',
                                    1,'true'
                            ) As TwinBill,
                    ktb.ANZAHL As Anzahl,
                    '' As RV,
                    stvgr.VALUE As standardvertragsgruppe,
                    kt.VALUE As Kartentyp,
                    '' As Laufzeit,
                    to_char(ktb.EINGESTELLT,'DD.MM.YYYY') As Eingestellt,
                    to_char(ktb.WUNSCHTERMIN,'DD.MM.YYYY') As Wunschtermin,
                    COALESCE(to_char(ktb.FERTIGSTELLUNG,'DD.MM.YYYY'), '') As Fertigstellung,
                    COALESCE(ktb.BEMERKUNG, '') As Bemerkung,
                    COALESCE(ktb.BEMERKUNGINTERN, '') As BemerkungIntern,
                    COALESCE(ansp.VALUE, '') As ansprechpartner,
                    COALESCE(ktb.FERTIG, '') As Fertig,
                    stat.VALUE As Status
                  FROM " . $DB_TablePrefix . "KARTENBESTELLUNG ktb
                    INNER JOIN " . $DB_TablePrefix . "TEILPROJEKT tp ON ktb.teilprojekt = tp.ID
                    INNER JOIN " . $DB_TablePrefix . "ANFORDERER anfo on ktb.ANFORDERER = anfo.ID
                    INNER JOIN " . $DB_TablePrefix . "RELEASE rel ON ktb.RELEASE = rel.ID
                    INNER JOIN " . $DB_TablePrefix . "STANDARDVERTRAGSGRUPPE stvgr ON ktb.STDVGR = stvgr.ID
                    LEFT OUTER JOIN " . $DB_TablePrefix . "ANSPRECHPARTNER ansp ON ktb.ANSPRECHPARTNER = ansp.ID
                    INNER JOIN " . $DB_TablePrefix . "STATUS stat ON  ktb.STATUS = stat.ID
                    INNER JOIN " . $DB_TablePrefix . "PROVIDER prov ON  ktb.PROVIDER = prov.ID    
                    INNER JOIN " . $DB_TablePrefix . "KARTENTYPEN kt ON ktb.KARTENTYP = kt.ID
                    INNER JOIN " . $DB_TablePrefix . "HLR hlr ON ktb.HLR = hlr.ID
                  WHERE ktb.ID = ".$jobid
        )
);
// codieren der Daten
print_r(json_encode($array[0]));
?>

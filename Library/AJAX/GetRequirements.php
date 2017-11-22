<?php

// necessary includes
include ("jsonwrapper.php");
include '../Includes/TDB_DatabaseHelpers.php';

// Fehler falls kein Release angegeben
if (!isset($_POST[release])) {
    print_r("Kein Release angegeben!");
    die();
}

$Release = getIDandValidate("RELEASE", $_POST[release], "Release nicht gültig!");
// Receive all Releases
$array = parseToSmallColNames(
        execSelect(
                "                     
(SELECT 
    anf.ID As Nr,
    tp.TEXT As Teilprojekt,
    rel.TEXT As Release,
    anfo.TEXT As Anforderer,
    'Ja' As Aktiviert,
    anf.ANZAHL As Anzahl,
    COALESCE(anf.RAHMENVERTRAG, '&nbsp;') As RV,
    tarif.TEXT As Tarif,
    kt.TEXT As Kartentyp,
    lz.TEXT As Laufzeit,
    anf.EINGESTELLT As Eingestellt,
    anf.WUNSCHTERMIN As Wunschtermin,
    COALESCE(to_char(anf.FERTIGSTELLUNG,'DD.MON.YYYY'), '&nbsp;') As Fertigstellung,
    COALESCE(anf.BEMERKUNG, '&nbsp;') As Bemerkung,
    COALESCE(ansp.TEXT, '&nbsp;') As Ansprechpartner,
    COALESCE(anf.FERTIG, '&nbsp;') As Fertig,
    stat.TEXT As Status
  FROM " . $DB_TablePrefix . "ANFORDERUNG anf
    INNER JOIN " . $DB_TablePrefix . "TEILPROJEKT tp ON anf.teilprojekt = tp.ID
    INNER JOIN " . $DB_TablePrefix . "ANFORDERER anfo on anf.ANFORDERER = anfo.ID
    INNER JOIN " . $DB_TablePrefix . "RELEASE rel ON anf.RELEASE = rel.ID
    INNER JOIN " . $DB_TablePrefix . "TARIF tarif ON anf.TARIF = tarif.ID
    INNER JOIN " . $DB_TablePrefix . "KARTENTYPEN kt ON anf.KARTENTYP = kt.ID
    INNER JOIN " . $DB_TablePrefix . "LAUFZEITEN lz ON anf.LAUFZEIT = lz.ID
    LEFT OUTER JOIN " . $DB_TablePrefix . "ANSPRECHPARTNER ansp ON anf.ANSPRECHPARTNER = ansp.ID
    INNER JOIN " . $DB_TablePrefix . "STATUS stat ON  anf.STATUS = stat.ID 
  WHERE rel.ID = ".$Release."
)
UNION
(
SELECT 
    ktb.ID As Nr,
    tp.TEXT As Teilprojekt,
    rel.TEXT As Release,
    anfo.TEXT As Anforderer,
    'Nein' As Aktiviert,
    ktb.ANZAHL As Anzahl,
    '&nbsp;' As RV,
    stvgr.TEXT As Tarif,
    kt.TEXT As Kartentyp,
    '&nbsp;' As Laufzeit,
    ktb.EINGESTELLT As Eingestellt,
    ktb.WUNSCHTERMIN As Wunschtermin,
    COALESCE(to_char(ktb.FERTIGSTELLUNG,'DD.MON.YYYY'), '&nbsp;') As Fertigstellung,
    COALESCE(ktb.BEMERKUNG, '&nbsp;') As Bemerkung,
    COALESCE(ansp.TEXT, '&nbsp;') As Ansprechpartner,
    COALESCE(ktb.FERTIG, '&nbsp;') As Fertig,
    stat.TEXT As Status
  FROM " . $DB_TablePrefix . "KARTENBESTELLUNG ktb
    INNER JOIN " . $DB_TablePrefix . "TEILPROJEKT tp ON ktb.teilprojekt = tp.ID
    INNER JOIN " . $DB_TablePrefix . "ANFORDERER anfo on ktb.ANFORDERER = anfo.ID
    INNER JOIN " . $DB_TablePrefix . "RELEASE rel ON ktb.RELEASE = rel.ID
    INNER JOIN " . $DB_TablePrefix . "STANDARDVERTRAGSGRUPPE stvgr ON ktb.STDVGR = stvgr.ID
    LEFT OUTER JOIN " . $DB_TablePrefix . "ANSPRECHPARTNER ansp ON ktb.ANSPRECHPARTNER = ansp.ID
    INNER JOIN " . $DB_TablePrefix . "STATUS stat ON  ktb.STATUS = stat.ID
    INNER JOIN " . $DB_TablePrefix . "KARTENTYPEN kt ON ktb.KARTENTYP = kt.ID
  WHERE rel.ID = ".$Release."
)
"
        )
);


// Encode in JSON format and outup
print_r(
        json_encode(
                $array
        )
);
?>
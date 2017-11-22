<?php

//error_reporting(E_STRICT, E_WARNING, E_ERROR, E_PARSE);
//ini_set('display_errors', 'On');

// necessary includes
include ("../../AJAX/jsonwrapper.php");
include '../../Includes/TDB_DatabaseHelpers.php';


// Fehler falls kein Release angegeben
// Fehler falls keine ID angegeben
if (trim(filter_input(INPUT_POST, 'release')) == "" || trim(filter_input(INPUT_POST, 'status')) == "") {
    print_r("Release oder Status nicht angegeben!");
    die();
}

$release = getIDandValidate("RELEASE", filter_input(INPUT_POST, 'release'), "Release nicht gültig!");
$status = getIDandValidate("STATUS", filter_input(INPUT_POST, 'status'), "Status nicht gültig!");
//$status = getIDandValidate("STATUS", filter_input(INPUT_POST, 'status'), "Status nicht gültig!");



// Receive all Releases
$array = parseToSmallColNames(
        execSelect(
                " 
SELECT 
    anf.ID, 
    anf.ZUSATZ, 
    anf.ANZAHL, 
    anf.ANZAHLKARTEN,
    anf.JOBID,
    anf.RAHMENVERTRAG,
    iai.value as IAI,
    kt.value AS Kartentyp,
    rel.VALUE as Release,
    stat.value AS Status,
    tar.VALUE AS Tarif,
    tar.VALUE as STDVGR,
    proj.VALUE as Teilprojekt,
    rel.PFAD || proj.PFAD as pfad
    
    ,anfor.VALUE AS Anforderer
    ,anf.BEMERKUNG AS Bemerkung
    ,kop.VALUE As Kopplungsart
    ,proj.CAMPAIGNINSERT AS Kampagne
FROM 
    ". $DB_TablePrefix ."ANFORDERUNG anf
    INNER JOIN ". $DB_TablePrefix ."IAI iai ON iai.id = anf.iai
    INNER JOIN ". $DB_TablePrefix ."KARTENTYPEN kt ON kt.id = anf.KARTENTYP
    INNER JOIN ". $DB_TablePrefix ."RELEASE rel ON rel.id = anf.RELEASE
    INNER JOIN ". $DB_TablePrefix ."STATUS stat ON stat.id = anf.STATUS
    INNER JOIN ". $DB_TablePrefix ."TARIF tar ON tar.id = anf.TARIF
    INNER JOIN ". $DB_TablePrefix ."STANDARDVERTRAGSGRUPPE std ON std.id = tar.STDVGR
    INNER JOIN ". $DB_TablePrefix ."TEILPROJEKT proj ON proj.id = anf.TEILPROJEKT

    INNER JOIN ". $DB_TablePrefix ."Anforderer anfor ON anfor.id = anf.ANFORDERER
    INNER JOIN ". $DB_TablePrefix ."KOPPLUNGSARTEN kop ON kop.id = anf.KOPPLUNG

WHERE
    rel.ID = '".$release."'
    AND stat.ID = '".$status."'
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
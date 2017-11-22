<?php

// necessary includes
include ("../../AJAX/jsonwrapper.php");
include '../../Includes/TDB_DatabaseHelpers.php';
include '../../Includes/TDB_Helper.php';
include 'JobSettings.php';

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
            ID, 
            rechnergruppe AS GRUPPE, 
            ANZ_AUSF AS SOLL, 
            COUNT_AUSF AS IST,
            AUFTRAGSART,
            ZUSATZ
            FROM " . $tabelle . " 
            WHERE ID = " . $jobid
        )
);
// codieren der Daten
print_r(json_encode($array[0]));

?>

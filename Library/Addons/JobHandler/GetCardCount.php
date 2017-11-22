<?php
error_reporting(E_STRICT, E_WARNING, E_ERROR, E_PARSE);
ini_set('display_errors', 'On');
// necessary includes
include ("../../AJAX/jsonwrapper.php");
include '../../Includes/TDB_DatabaseHelpers.php';
include '../../Includes/TDB_Helper.php';

$release = getIDandValidate("RELEASE", filter_input(INPUT_POST, 'release'), "Release nicht gültig!");

$hlr = checkNumeric(filter_input(INPUT_POST, 'hlr'), "HLR nicht im korrekten Format");
$iai = checkNumeric(filter_input(INPUT_POST, 'iai'), "IAI nicht im korrekten Format");
$cardtype = checkNumeric(filter_input(INPUT_POST, 'cardtype'), "Kartentyp nicht im korrekten Format");

$stdvgr = getIDandValidate("STANDARDVERTRAGSGRUPPE", filter_input(INPUT_POST, 'stdvgr'), "STDVGR nicht gültig!");

// Bei POSTPAID wird wegen anderem Datenbestand in DART die ID verändert
if($stdvgr == 1)
{
    $stdvgr = 0;
}

getIDandValidateQTP("PROVIDER", filter_input(INPUT_POST, 'provider'), "Provider " . filter_input(INPUT_POST, 'provider') . " nicht gültig!");
$provider = filter_input(INPUT_POST, 'provider');

if(filter_input(INPUT_POST, 'twinbill') == "true")
{
    $isTwinBill = "IS NOT NULL";
}
else
{
    $isTwinBill = "IS NULL";
}
    

$dartinfo = parseToSmallColNames(execSelect("SELECT HASDART, DARTHOST, DARTUSER, DARTPW FROM " . $DB_TablePrefix . "RELEASE WHERE ID = " . $release));

if ($dartinfo[0]['hasdart'] != "1") {
    print_r(json_encode("chosen release does not contain DART-Database information"));
    die();
}

// Receive contracts from chosen DART DB
$array = parseToSmallColNames(
        execDARTSelect("SELECT
count(*) as cardcount 
FROM KARTENNUMMERN ktn
INNER JOIN MAP_STDVERTRAGSGRUPPE std ON ktn.ID_STDVGRP = std.ID_STDVGRP
INNER JOIN MAP_SERVICEPROVIDER sp ON ktn.ID_SP = sp.ID_SP
WHERE ktn.id_gp = 100
and ktn.id_status = 102
and ktn.HLR = " . $hlr . "
AND SUBSTR ( ktn.ICCID,7,5 ) =  " . $iai . "
AND std.STDVERTRAGSGRUPPE = " . $stdvgr . "
AND sp.SERVICEPROVIDER LIKE '" . $provider . "'
AND ktn.ID_SIM_TY =  " . $cardtype . "
AND ktn.ICCID_TWINBILL ". $isTwinBill
                , $dartinfo[0]['dartuser']
                , $dartinfo[0]['dartpw']
                , $dartinfo[0]['darthost']
        )
);


// Encode in JSON format and outup
print_r(
        json_encode(
                $array[0]
        )
);

<?php
// necessary includes
include ("jsonwrapper.php");
include '../Includes/TDB_DatabaseHelpers.php';

// Receive all Releases
$array = parseToSmallColNames(
            execSelect("SELECT t.ID,
            t.TEXT || ' [' || t.ID || ',' || s.VALUE || ']' AS TEXT,
            t.VALUE,
            s.VALUE As STDVGR,
            DECODE(
                t.STANDARD, 
                    0,'false',
                    1,'true'
            ) As standard,
            t.MAPID As MAPID,
            t.MAP_MULTISIM As MAP_MULTISIM,
            t.MAP_TB As MAP_TB,
            t.MAP_TBPROMASTER As MAP_TBPROMASTER,
            t.MAP_TBPROSLAVE As MAP_TBPROSLAVE
            FROM 
            " . $DB_TablePrefix . "Tarif t
            INNER JOIN " . $DB_TablePrefix . "STANDARDVERTRAGSGRUPPE s ON t.STDVGR = s.ID
            ORDER BY TEXT ASC")
        );


// Encode in JSON format and outup
print_r(
        json_encode(
                $array
        )
);
?>

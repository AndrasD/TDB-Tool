<?php
// necessary includes
include ("jsonwrapper.php");
include '../Includes/TDB_DatabaseHelpers.php';

// Receive all HLR
$array = parseToSmallColNames(
            execSelect("SELECT hlr.ID,
            hlr.TEXT || ' [' || type.NAME || ']' AS TEXT,
            hlr.VALUE,
            DECODE(
                hlr.STANDARD, 
                    0,'false',
                    1,'true'
            ) As standard,
            rel.VALUE As RELEASE
            FROM 
           " . $DB_TablePrefix . "HLR hlr
           INNER JOIN " . $DB_TablePrefix . "RELEASE rel on rel.ID = hlr.RELEASE
           INNER JOIN " . $DB_TablePrefix . "HLRTYPE type on type.ID = hlr.TYPE
           ORDER BY VALUE ASC")
        );


// Encode in JSON format and outup
print_r(
        json_encode(
                $array
        )
);
?>

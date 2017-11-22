<?php
// necessary includes
include ("jsonwrapper.php");
include '../Includes/TDB_DatabaseHelpers.php';

// Receive all Releases
$array = parseToSmallColNames(
            execSelect("SELECT ID,
            TEXT ,
            VALUE,
            TO_CHAR(BEGIN, 'DD.MM.YYYY') AS BEGIN,
            TO_CHAR(END, 'DD.MM.YYYY') AS END,
            DECODE(
                STANDARD, 
                    0,'false',
                    1,'true'
            ) As standard  
            FROM 
            " . $DB_TablePrefix . "RELEASE ORDER BY ID DESC")
        );


// Encode in JSON format and outup
print_r(
        json_encode(
                $array
        )
);
?>

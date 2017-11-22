<?php
// necessary includes
include ("jsonwrapper.php");
include '../Includes/TDB_DatabaseHelpers.php';

// Receive all Releases
$array = parseToSmallColNames(
            execSelect("SELECT ID,
            TEXT ,
            VALUE,
            QTPVALUE,
            DECODE(
                STANDARD, 
                    0,'false',
                    1,'true'
            ) As standard  
            FROM 
            " . $DB_TablePrefix . "KOPPLUNGSARTEN ORDER BY ID DESC")
        );


// Encode in JSON format and outup
print_r(
        json_encode(
                $array
        )
);
?>

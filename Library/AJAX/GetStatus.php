<?php
// necessary includes
include ("jsonwrapper.php");
include '../Includes/TDB_DatabaseHelpers.php';

// Receive all Releases
$array = parseToSmallColNames(
            execSelect("SELECT ID,
           TEXT ,
            VALUE,
            DECODE(
                STANDARD, 
                    0,'false',
                    1,'true'
            ) As standard,
            DECODE(
                EDITABLE, 
                    0,'false',
                    1,'true'
            ) As editable
            FROM 
           " . $DB_TablePrefix . "STATUS
           ORDER BY ID DESC")
        );


// Encode in JSON format and outup
print_r(
        json_encode(
                $array
        )
);
?>

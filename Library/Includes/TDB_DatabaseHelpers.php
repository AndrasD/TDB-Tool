<?php

@include ("../AJAX/jsonwrapper.php");

$DB_Host = "etqa1.devlab.de.tmo";
$DB_User = "TB_IV98_40_T_SCHEMA";
$DB_Password = "tb_1090_t_schema";
$DB_TablePrefix = "TDB_PRD_";

function execSelect($statement) {
    global $DB_User, $DB_Password, $DB_Host;
    $conn = oci_connect($DB_User, $DB_Password, $DB_Host);
    $stid = oci_parse($conn, $statement);
    oci_execute($stid);
    $array = array();
    while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
        $array[] = $row;
    }
    oci_close($conn);
    return $array;
}

function parseToSmallColNames($array) {
    $return = array();
    foreach ($array as $item) {
        $helper = array();
        foreach ($item as $key => $value) {
            $helper[strtolower($key)] = $value;
        }
        $return[] = $helper;
    }
    return $return;
}

function getIDforValue($table, $value, $useQTPValue) {
    global $DB_TablePrefix;
    if (!$useQTPValue) {
        $result = execSelect("SELECT ID FROM " . $DB_TablePrefix . $table . " WHERE VALUE LIKE '" . $value . "'");
    } else {

        $result = execSelect("SELECT ID FROM " . $DB_TablePrefix . $table . " WHERE QTPVALUE LIKE '" . $value . "'");
    }
    if (count($result) == 1) {
        return $result[0]["ID"];
    } else {
        return NULL;
    }
}

function getNewId() {
    global $DB_TablePrefix;

    $array = execSelect("SELECT " . $DB_TablePrefix . "SEQ_REQUEST.nextval As ID FROM DUAL");

    //$array = execSelect("SELECT coalesce(MAX(ID)+1, 0) AS ID FROM " . $DB_TablePrefix . "IDS");
    return $array[0]["ID"];
}

function getIDandValidate($table, $value, $message) {
    $result = getIDforValue($table, $value, false);
    if ($result == NULL) {
        $response = array(
            "success" => false,
            "message" => $message,
            "id" => -1
        );
        print_r(json_encode($response));
        die();
    }
    return $result;
}

function getIDandValidateQTP($table, $value, $message) {
    $result = getIDforValue($table, $value, true);
    if ($result == NULL) {
        $response = array(
            "success" => false,
            "message" => $message,
            "id" => -1
        );
        print_r(json_encode($response));
        die();
    }
    return $result;
}

function selectColValue($table, $col, $id) {
    global $DB_TablePrefix;
    $array = execSelect("SELECT " . $col . " FROM " . $DB_TablePrefix . $table . " WHERE ID = " . $id);
    //echo "SELECT ".$col." FROM " . $DB_TablePrefix .$table." WHERE ID = ".$id;
    if (count($array) == 1) {
        return $array[0][$col];
    } else {
        return NULL;
    }
}

function getBoolColValue($table, $col, $id) {
    $value = selectColValue($table, $col, $id);
    if ($value == "1") {
        return true;
    }
    return false;
}

function getIDandValidateForHLR($release, $value, $message) {
    global $DB_TablePrefix;

    $result = execSelect("SELECT ID FROM " . $DB_TablePrefix . "HLR WHERE VALUE LIKE '" . $value . "' AND RELEASE = " . $release);

    if (count($result) != 1) {
        $response = array(
            "success" => false,
            "message" => $message,
            "id" => -1
        );
        print_r(json_encode($response));
        die();
    } else {
        $resultvalue = $result[0]["ID"];
    }
    return $resultvalue;
}

function execDARTSelect($statement, $DB_User, $DB_Password, $DB_Host) {
    $conn = oci_connect($DB_User, $DB_Password, $DB_Host);
    $stid = oci_parse($conn, $statement);
    oci_execute($stid);
    $array = array();
    while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
        $array[] = $row;
    }
    oci_close($conn);
    return $array;
}

?>

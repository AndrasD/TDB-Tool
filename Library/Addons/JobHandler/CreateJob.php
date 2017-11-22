<?php

//error_reporting(E_STRICT, E_WARNING, E_ERROR, E_PARSE);
//ini_set('display_errors', 'On');
// necessary includes
include ("../../AJAX/jsonwrapper.php");
include '../../Includes/TDB_DatabaseHelpers.php';
include '../../Includes/TDB_Helper.php';
include 'JobSettings.php';

// Checking if neccessary information is given in POST
// if something is missing, the script execution will be aborted
if (!isset(
                $_POST[segment]
                , $_POST[tdbstring]
                , $_POST[mapid]
                , $_POST[group]
                , $_POST[tdbid]
                , $_POST[release]
                , $_POST[isSlaveRun]
)) {
    $response = array(
        "message" => "Nicht alle erforderlichen Daten angegeben!"
    );
    print_r(json_encode($response));
    die();
}

//$_POST[segment] = "pk";
//$_POST[tdbstring] = "ZUSATZ=\"17759tdb\";HLR=172";
//$_POST[mapid] = "78563";
//$_POST[group] = "z2";
//$_POST[tdbid] = "17759";
//$_POST[release] = "15.1 A-Line";

$tdbid = checkNumeric($_POST[tdbid], "TDB-ID kein numerischer Wert");
$segment = $_POST[segment];
$tdbstring = $_POST[tdbstring];
$mapid = $_POST[mapid];
$group = $_POST[group];
$release = getIDandValidate("RELEASE", $_POST[release], "Release nicht gültig!");
$beschreibung = $beschreibung . $tdbid;
$anzausf = 1;
$count_ausf = 0;
$name = $name . $tdbid;

$isSlaveRun = false;
if($_POST[isSlaveRun] == "true")
{
    $isSlaveRun = true;
}

$jobid = array("0", "0", "0", "0", "0", "0", "0", "0", "0");

$release_array = str_split($release);
for ($i = 0; $i < count($release_array); $i++) {
    $jobid[$i] = $release_array[$i];
}

$tdbid_array = str_split($tdbid);
$tmpcount = count($tdbid_array);

for ($i = (count($jobid)); $i >= $tmpcount; $i--) {
    $jobid[$i - 1] = $tdbid_array[$i - $tmpcount];
}

$availableJobID = intval(implode($jobid));
$maxtries = 5;
$tries = 0;
while (true) {
    $result = execSelect("SELECT COUNT(ID) As COUNT FROM " . $tabelle . " WHERE ID = " . $availableJobID);
    if ($result[0]["COUNT"] == "0") {
        break;
    } else {
        $tries++;
        $availableJobID += 10000;
        if ($tries >= $maxtries) {
            $response = array(
                "message" => "JobID konnte nicht ermittelt werden!"
            );
            print_r(json_encode($response));
            die();
        }
    }
}
// opening connection to DB
$conn = oci_connect($DB_User, $DB_Password, $DB_Host);
if (!$conn) {
    $m = oci_error();
    trigger_error(htmlentities($m['message']), E_USER_ERROR);
}

$statement = "INSERT INTO " . $tabelle . " 
        (
            RECHNER, 
            VON, 
            QTP_TEST, 
            VAR, 
            MAP, 
            LFD, 
            AUFTRAGSART, 
            SEMAPHORE, 
            COMMAND, 
            BIS, 
            INTERVAL, 
            SEMAPHORE_ID, 
            BESCHREIBUNG, 
            AUSFUEHREN, 
            ANZ_AUSF, 
            TIMEOUT, 
            ALLOW_DAYS, 
            ID, 
            COUNT_AUSF, 
            ALLE_AUSF, 
            ZUSATZ, 
            DAILY, 
            RECHNERGRUPPE, 
            EOP_PRUEFUNG
        ) 
        VALUES 
        (
            :rechner, 
            :von, 
            :qtp_test, 
            :var, 
            :map, 
            :lfd, 
            :auftragsart, 
            :semaphore, 
            :command, 
            :bis, 
            :interval, 
            :semaphore_id, 
            :beschreibung, 
            :ausfuehren, 
            :anzausf, 
            :timeout, 
            :allow_days, 
            :id, 
            :count_ausf, 
            :alle_ausf, 
            :zusatz, 
            :daily, 
            :rechnergruppe, 
            :eop_pruefung
          )";

//parsing statement
$stid = oci_parse($conn, $statement);



// binding proecessed information
oci_bind_by_name($stid, ":rechner", $rechner);
oci_bind_by_name($stid, ":von", $von);
oci_bind_by_name($stid, ":bis", $bis);
oci_bind_by_name($stid, ":qtp_test", $name);
oci_bind_by_name($stid, ":map", $mapid);
oci_bind_by_name($stid, ":semaphore", $semaphore);
oci_bind_by_name($stid, ":interval", $interval);
oci_bind_by_name($stid, ":semaphore_id", $semaphore_id);
oci_bind_by_name($stid, ":beschreibung", $beschreibung);
oci_bind_by_name($stid, ":ausfuehren", $ausfuehren);
oci_bind_by_name($stid, ":anzausf", $anzausf);
oci_bind_by_name($stid, ":timeout", $timeout);
oci_bind_by_name($stid, ":allow_days", $allowdays);
oci_bind_by_name($stid, ":id", $availableJobID);
oci_bind_by_name($stid, ":count_ausf", $count_ausf);
oci_bind_by_name($stid, ":alle_ausf", $alle_ausf);
oci_bind_by_name($stid, ":zusatz", $tdbstring);
oci_bind_by_name($stid, ":daily", $daily);
oci_bind_by_name($stid, ":rechnergruppe", $group);
oci_bind_by_name($stid, ":eop_pruefung", $eop_pruefung);

switch ($segment) {
    case("xtra"):
        oci_bind_by_name($stid, ":var", $Xtra_varianz);
        oci_bind_by_name($stid, ":lfd", $Xtra_lfd);
        oci_bind_by_name($stid, ":command", $Xtra_command);
        oci_bind_by_name($stid, ":auftragsart", $Xtra_auftragsart);
        break;

    case("gk"):
        oci_bind_by_name($stid, ":var", $GK_varianz);
        oci_bind_by_name($stid, ":lfd", $GK_lfd);
        oci_bind_by_name($stid, ":command", $GK_command);
        oci_bind_by_name($stid, ":auftragsart", $GK_auftragsart);
        break;

    default:
        oci_bind_by_name($stid, ":var", $PK_varianz);
        oci_bind_by_name($stid, ":lfd", $PK_lfd);
        oci_bind_by_name($stid, ":command", $PK_command);
        oci_bind_by_name($stid, ":auftragsart", $PK_auftragsart);
        break;
}

$success = oci_execute($stid, OCI_COMMIT_ON_SUCCESS);
//$success = true;

if ($success) {

    $jobinfo = execSelect(
            "SELECT 
            ID, 
            rechnergruppe AS GRUPPE, 
            ANZ_AUSF AS SOLL, 
            COUNT_AUSF AS IST, 
            ZUSATZ
            FROM " . $tabelle . " 
            WHERE ID = " . $availableJobID
    );

    $result_req = execSelect("SELECT COUNT(ID) As COUNT FROM " . $DB_TablePrefix . "ANFORDERUNG WHERE ID = " . $tdbid);

    if ($result_req[0]["COUNT"] == "1") {
        
        $jobupdate = "UPDATE " . $DB_TablePrefix . "ANFORDERUNG SET JOBID = " . $jobinfo[0]["ID"] . " WHERE ID = " . $tdbid;
        if($isSlaveRun)
        {
            $jobupdate = "UPDATE " . $DB_TablePrefix . "ANFORDERUNG SET JOBID_SECOND = " . $jobinfo[0]["ID"] . " WHERE ID = " . $tdbid;
        }
        
        $stid_jobupdate = oci_parse($conn, $jobupdate);
        $success_jobupdate = oci_execute($stid_jobupdate, OCI_COMMIT_ON_SUCCESS);
        if ($success_jobupdate) {
            $message = " <img src='./Library/Images/checked.gif'/> Job erfolgreich erstellt";
        } else {
            $message = "Die zugehoerige Anforderung zum Job " . $availableJobID . " TDB-ID - " . $tdbid . " konnte nicht bearbeitet werden!";
        }
    } else {
        $message = "Die zugehoerige Anforderung zum Job " . $availableJobID . " TDB-ID - " . $tdbid . " konnte nicht ermittelt werden!";
    }

    $response = array(
        "id" => $jobinfo[0]["ID"],
        "group" => $jobinfo[0]["GRUPPE"],
        "ist" => $jobinfo[0]["IST"],
        "soll" => $jobinfo[0]["SOLL"],
        "zusatz" => $jobinfo[0]["ZUSATZ"],
        "message" => $message
    );
} else {
    $e = oci_error($conn);
    $response = array(
        "message" => $e['message']
    );
}

// closing connection
oci_close($conn);

// coding and sending response
print_r(json_encode($response));
?>
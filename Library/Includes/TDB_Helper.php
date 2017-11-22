<?php

@include("../AJAX/jsonwrapper.php");

$dateformat_oracle = "DD.MM.YYYY";
$dateformat = "d.m.Y";
$dateformat_js = "dd.mm.yy";

$defaultNewStatus = "neu";
$defaultAnsprechpartner = "tdb";

$mail_sendmail_requester = true;
$mail_sendmail = true;
$mail_header = 'From: web1528@devlab.de.tmo';// . "\r\n" .
            //'Reply-To: VL-Carmen-TA-Testdatenbereitstellung@cds.t-internal.com' . "\r\n" .
            //'X-Mailer: PHP/' . phpversion();
//$mail_empfaenger = 'VL-Carmen-TA-Testdatenbereitstellung@cds.t-internal.com';
$mail_empfaenger = 'johannes.nitschmann@t-systems.com, manfred.best@telekom.de, andras.dallos@external.telekom.de';
function check($value, $type, $message, $allownulls = false) {
    $compare = false;
    if($allownulls && ($value == null || trim($value) == ""))
    {
        return $value;
    }
    if ($type == "numeric") {
        if (is_numeric($value) && !(trim($value) == "") ) {
            $compare = true;
        }
    }
    if ($type == "bool") {
        if (is_bool($value) &&  !(trim($value) == "")) {
            $compare = true;
        }
    }
    if ($type == "date") {
        if (validateDate($value) &&  !(trim($value) == "")) {
            $compare = true;
        }
    }
    if (!$compare) {
        $response = array(
            "success" => false,
            "message" => $message,
            "id" => -1
        );
        print_r(json_encode($response));
        die();
    }
    return $value;
}

function checkNumeric($value, $message, $allownulls = false) {
    return check($value, "numeric", $message, $allownulls);
}

function checkBool($value, $message, $allownulls = false) {
    return check($value, "bool", $message, $allownulls);
}

function checkDatum($value, $message, $allownulls = false) {
    return check($value, "date", $message, $allownulls);
}

function validateDate($date) {
    global $dateformat;
//     $d = DateTime::createFromFormat($dateformat, $date);
//    return $d && $d->format($dateformat) == $date;
    if (date($dateformat, strtotime($date)) == $date) {
        return true;
    } else {
        //echo "Hallo Welt! ".date($dateformat, strtotime($date))." / ".$date;
        return false;
    }
}

?>

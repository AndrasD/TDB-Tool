<?php

//include 'TDB_Helper.php';
// BUSINESS RULE:
// If old status is not a finishing one but the new one is, the fertig and 
// fertigstellung is automatically set to completed values not matter what the
// posted values are.
// If not, posted values will be taken.
function rule_finishedReq($id, $status, $pfertigstellung, $pfertig, $tabelle, $mail_requester) {
    global $dateformat;
    global $mail_sendmail_requester;
    global $mail_header;
    
    if (getBoolColValue("STATUS", "FINISHER", $status) && !getBoolColValue("STATUS", "FINISHER", selectColValue($tabelle, "STATUS", $id))) {
        $fertig = "100%";
        $fertigstellung = date($dateformat);   
        
        if ( $mail_sendmail_requester == true && trim($mail_requester) != "") {

            //$betreff = '[TDB-Tool] Neue Kartenbestellung ID: ' . $id.' Besteller: '.$anforderer_text;
            $betreff = '[TDB] your request ' . $id . ' is ready now.';
            $nachricht = 'You are receiving this notification because your order with the TDB_ID ' . $id . ' is ready.';
            
            mail($mail_requester, $betreff, $nachricht, $mail_header);
        }
    } else {
        if (trim($pfertigstellung) == "") {
            $fertigstellung = "NULL";
        } else {
            if (validateDate($pfertigstellung)) {
                $fertigstellung = $pfertigstellung;
            } else {
                $response = array(
                    "success" => false,
                    "message" => "Fertigstellungstermin hat falsches Format!",
                    "id" => -1
                );
                print_r(json_encode($response));
                die();
            }
        }
        if (trim($pfertig) == "") {
            $fertig = "";
        } else {
            $fertig = $pfertig;
        }
    }
    return array($fertigstellung, $fertig);
}

?>

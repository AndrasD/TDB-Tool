<?php

if ($_REQUEST['Kopiervorgang-starten'] == "Kopiervorgang-starten") {
    array_walk($_REQUEST, "kopiereAnforderung");
}

// Preparation of Values for Select Lists

$Teilprojekte = array(array("VALUE" => $_alle_Teilprojekte, "TEXT" => $_alle_Teilprojekte));
$Teilprojekte = array_merge(
        $Teilprojekte, 
        CreateArrayFromSQL
        (
            $_kttDB_tdb, 
            "SELECT ID As Value, Teilprojekt As Text FROM tdb_Teilprojekt order by teilprojekt"
        )
);

$Aktiviert = array(array("VALUE" => $_alle_Liste, "TEXT" => $_alle_Liste));
$Aktiviert = array_merge(
        $Aktiviert, 
        CreateArrayFromSQL(
            $_kttDB_tdb, 
            "SELECT Beschreibung As Text, id as Value FROM tdb_Aktiviert order by id"
        )
);

$Priority = array(array("VALUE" => $_alle_Liste, "TEXT" => $_alle_Liste));
$Priority = array_merge(
        $Priority, 
        CreateArrayFromSQL(
            $_kttDB_tdb, 
            "SELECT beschreibung As Text, id as Value FROM TDB_PRIO order by id"
        )
);

$Status = array(array("VALUE" => $_alle_Liste, "TEXT" => $_alle_Liste));
$Status = array_merge(
        $Status, 
        CreateArrayFromSQL(
            $_kttDB_tdb, 
            "SELECT beschreibung as Text, Status as Value FROM TDB_STATUS order by STATUS"
        )
);

$Tarif = array(array("VALUE" => $_alle_Liste, "TEXT" => $_alle_Liste));
$Tarif = array_merge(
        $Tarif, 
        CreateArrayFromSQL(
            $_kttDB_dart, 
            "SELECT DISTINCT cds_description as Text, cntrct_template_id As Value FROM pv_def_tarif ORDER BY cds_description"
        )
);

$Anforderer = array(array("VALUE" => "*** Alle Anforderer ***", "TEXT" => "*** Alle Anforderer ***"));
$Anforderer = array_merge(
        $Anforderer, 
        CreateArrayFromSQL(
            $_kttDB_tdb, 
            "SELECT distinct anforderer as value, anforderer as text FROM tdb_anforderung where anforderer is not null order by anforderer"
        )
);

?>
<form name='auswahl' id="auswahl" method='post' >        
    <table width='98%' border='1' cellspacing='0'  style='margin-left: 10px'>
        <caption><p class='UeberschriftKleiner' align='left'>Auswahlparameter  (Ablageort: P:\IV98\RELEASES\[Release]\Abnahme\T-Daten\[Teilprojekt])</p></caption>
        <tbody>
            <tr class='Tabellenueberschr' bgColor='#c0c0c0'>
                <th  align='center'>Teilprojekt</th>
                <th  align='center'>Aktiviert</th>
                <th  align='center'>Prio</th>	
                <th  align='center'>Lieferdatum</th>
                <th  align='center'>Status</th>
                <th  align='center'>Tarif</th> 				  
                <th  align='center'>Anforderer (Name, Vorn.)</th> 				  
                <th  align='center'>Suchen</th>				  
            </tr>
            <tr>
                <td>
                    <?php
                    echo CreateSelectList(
                            "TBTP", $Teilprojekte, $_REQUEST['TBTP'], array(
                        "accesskey='t'",
                        $kopieren
                            )
                    );
                    ?>
                </td>
                <td>
                    <?php
                    echo CreateSelectList(
                            "TBAKT", $Aktiviert, $_REQUEST['TBAKT'], array(
                        "accesskey='r'",
                        $kopieren
                            )
                    );
                    ?>
                </td>
                <td>
                    <?php
                    echo CreateSelectList(
                            "TBPRIO", $Priority, $_REQUEST['TBPRIO'], array(
                        "accesskey='r'",
                        $kopieren
                            )
                    );
                    ?>
                </td>
                <td>
                    <input 
                        type='text' 
                        name='TBTERMIN' 
                        size=10 
                        maxlength=10 
                        value ="<?php
                    if ($_Termin == "") {
                        echo $_alle_Liste_10chr;
                    } else {
                        echo $_Termin;
                    }
                    ?>" 
                        />
                </td>
                <td>
                    <?php
                    echo CreateSelectList(
                            "TBSTATUS", $Status, $_REQUEST['TBSTATUS'], array(
                        "accesskey='r'",
                        $kopieren
                            )
                    );
                    ?>
                </td>
                <td>
                    <?php
                    echo CreateSelectList(
                            "TBTARIF", $Tarif, $_REQUEST['TBTARIF'], array(
                        "accesskey='r'",
                        $kopieren
                            )
                    );
                    ?>
                </td>
                <td>
                    <?php
                    echo CreateSelectList(
                            "TBANF", $Anforderer, $_REQUEST['TBANF'], array(
                        "accesskey='r'",
                        $kopieren
                            )
                    );
                    ?>
                </td>
                <td>
                    <?php
                    // If Copy Mode is enabled, the underlying code is beeing processed
                    if ($_REQUEST['Kopieren'] == "Kopieren") {
                        
                         $kopieren = " disabled ";
                         ?>
                         
                        <input type='hidden' name ='TBAKT'    value='<?php echo $_REQUEST['TBAKT']; ?>' />
                        <input type='hidden' name ='TBTP'     value='<?php echo $_REQUEST['TBTP']; ?>' />
                        <input type='hidden' name ='TBREL'    value='<?php echo $_REQUEST['TBREL']; ?>' />
                        <input type='hidden' name ='TBANF'    value='<?php echo $_REQUEST['TBANF']; ?>' />
                        <input type='hidden' name ='TBPRIO'   value='<?php echo $_REQUEST['TBPRIO']; ?>' />
                        <input type='hidden' name ='TBSTATUS' value='<?php echo $_REQUEST['TBSTATUS']; ?>' />
                        <input type='hidden' name ='TBTERMIN' value='<?php echo $_REQUEST['TBTERMIN']; ?>' />
                        <input type='hidden' name ='TBTARIF'  value='<?php echo $_REQUEST['TBTARIF']; ?>' />
                        
                        <?php
                        
                        // ToDo: Check if really only one release should be available
                        $_statement = "SELECT * FROM tdb_release where release = (SELECT max(release) FROM tdb_Release)";
                        $stmt = OCIParse($_kttDB_tdb, $_statement);
                        OCIExecute($stmt);
                        OCIFetchInto($stmt, $row, OCI_ASSOC)
                        ?>
                        <table>
                                <tr>
                                    <td class='Text'>
                                        <input type='submit' 
                                               name='Kopiervorgang-starten' 
                                               value='Kopiervorgang-starten' 
                                               accesskey='k' 
                                               title='Markierte Anforderungen kopieren'
                                               />
                                    </td>
                                    <td class='Text'>Neues Release</td>
                                    <td><select name='NREL' accesskey='r'>
                                            <option 
                                                value='<?php echo $row['RELEASE']; ?>' 
                                                selected
                                                >
                                                    <?php
                                                    echo $row[BESCHREIBUNG];
                                                    ?>
                                            </option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type='submit' 
                                               name='Abbruch' 
                                               value='Abbruch' 
                                               accesskey='a' 
                                               title='Zurück'
                                        />
                                    </td>
                                    <td class='Text'>
                                        Wunschtermin
                                    </td>
                                    <td>
                                        <input  
                                            type='text' 
                                            name='NGTERMIN' 
                                            size='10' 
                                            maxlength='10' 
                                            value='<?php echo $_Plantermin; ?>'
                                        />
                                    </td>
                                </tr>
                         </table>
                    <?php
                       } 
                       // Underlying fields are shown when copy mode is off
                       else
                       {
                        ?>
                        <input type='submit' 
                               name='Submit' 
                               value='Suche' 
                               accesskey='a' 
                               title='Anforderungen gem. den Filterkriterien ausgeben'
                        />
                        <input type='submit' 
                               name='Kopieren' 
                               value='Kopieren' 
                               accesskey='a' 
                               title='Anforderungen kopieren' 
                        <?php echo $kopieren ?>
                        />
                        <?php
                       }
                    ?>
                </td>
            </tr>
        </tbody>
    </table>
</form>
<hr />
<? 
if($_SESSION['Counter'] > 1 && !$EndOfTDBActivationPhase)
{
?>
    <button id="newRequirement">Neue Anforderung</button>
    <button id="newCardOrder">Neue Kartenbestellung</button>
<?
}
?>
<hr />                              


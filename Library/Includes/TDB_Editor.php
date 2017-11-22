<div id="dialog" title="TDB Anforderungseditor 1.0" style="display: none;">
    <form id="generator" action="">

        <fieldset id="release_container">
            <legend>Release</legend>
            <span id="release"></span>
        </fieldset>

        <fieldset id="sonstiges_container">
            <legend>Basis-Angaben</legend>
            <table>
                <tr id="id_row">
                    <td><label for="id">Anforderungs-ID</label></td>
                    <td><input type="text" id="id" readonly /></td>
                </tr>
                <tr id="teilprojekt_row">
                    <td><label for="teilprojekt" title="Hier wird das Teilprojekt ausgewählt. Dieses bestimmt auch den Ort, an dem die entsprechenden Daten abgelegt werden.">* Teilprojekt</label></td>
                    <td>
                        <select id="teilprojekt">
                        </select>  
                    </td>
                </tr> 
                <tr>
                    <td><label for="anforderer" title="Der Anforderer. Wichtig für eventuelle Rückfragen zur Anforderung">* Anforderer</label></td>
                    <td><select id="anforderer">
                        </select></td>
                </tr>
                <tr id="ansprechpartner_row">
                    <td> <label for="ansprechpartner" title="Der Ansprechpartner welcher für die Anforderung zuständig ist.">* Ansprechpartner</label></td>
                    <td><select id="ansprechpartner">
                        </select></td>
                </tr>
                <tr id="anzahl_row">
                    <td><label for="anzahl" title="Die Anzahl der benötigten VP2 mit zugehörigem Vertrag. Zu beachten ist hier, dass wenn mehrere Verträge pro VP2 benötigt werden, hier die Anzahl der VP2 angegeben werden muss.">* Anzahl</label></td>
                    <td>
                        <input type="text" id="anzahl" name="anzahl" />
                    </td>
                </tr>
                <tr id="tarif_row">
                    <td><label for="tarif" title="Hier wird der entsprechende Tarif angegeben.">* Tarif</label></td>
                    <td>
                        <select id="tarif">
                        </select>
                    </td>
                </tr> 
                <tr id="tarif_second_row">
                    <td><label for="tarif_second" title="Hier wird der Tarif für die CoCa bzw TB Verträge angegeben">* CoCa / TwinBill-Tarif</label></td>
                    <td>
                        <select id="tarif_second">
                        </select>
                    </td>
                </tr> 
                <tr id="status_row">
                    <td><label for="status" title="Der Status in dem sich die Anforderung befindet.">Status</label></td>
                    <td>
                        <select id="status">
                        </select>
                    </td>
                </tr> 
                <tr id="eingestellt_row">
                    <td><label for="eingestellt" title="Erstellungsdatum der Anforderung.">Eingestellt</label></td>
                    <td><input type="text" id="eingestellt" />
                    </td>
                </tr>
                <tr id="wunschtermin_row">
                    <td><label for="wunschtermin"  title="Der Termin an dem die Daten benötigt werden. Die Auslieferung kann sich u.U. je nach Auslastung und Wunschtermin verschieben. Bei kritischen Anforderungen bitten wir um Rücksprache.">* Wunschtermin</label></td>
                    <td><input type="text" id="wunschtermin" name="wunschtermin" />
                    </td>
                </tr>
                <tr id="fertigstellung_row">
                    <td><label for="fertigstellung" title="Datum der Fertigstellung und Auslieferung der Anforderung">Fertigstellung</label></td>
                    <td><input type="text" id="fertigstellung" />
                    </td>
                </tr>
                <tr id="bemerkung_row">
                    <td><label for="bemerkung" title="Hier können Bemerkungen bezüglich der Anforderungen eingetragen werden.">Bemerkung</label></td>
                    <td><textarea id="bemerkung" name="bemerkung" cols="75" rows="3"></textarea></td>
                </tr>
                <tr id="fertig_row">
                    <td><label for="fertig" title="Die Fertigstellung der Anforderung.">Fertig</label></td>
                    <td><input type="text" id="fertig"  />
                    </td>
                </tr>
                <tr id="bemerkungintern_row">
                    <td><label for="bemerkungintern">BemerkungIntern</label></td>
                    <td><textarea id="bemerkungintern" name="bemerkingintern" cols="75" rows="3"></textarea></td>
                </tr>


            </table>
        </fieldset>
        <fieldset id="technical_container">
            <legend>
                Technische Optionen
                <img src="Library/Images/plus.gif" id="technical_container_toggler" onclick="editor_toggle('#technical_container_table','#technical_container_toggler')" />
            </legend>
            <table id="technical_container_table" style="display:none">
                <tr id="zusatz_row">
                    <td><label for="zusatz">Job-Zusatz:</label></td>
                    <td><input type="text" id="zusatz" value=""></td>
                </tr>
                <tr id="mapid_row">
                    <td><label for="mapid">MapID:</label></td>
                    <td><input type="text" id="mapid" value=""><span id="mapid_tariff"> <br /> Standard MapID: <input style="width:150px;" type="text" id="mapid_tariff_value" value="" readonly></span></td>
                </tr>
                <tr id="mapid_second_row">
                    <td><label for="mapid_second">MapID CoCa/TB Slave</label></td>
                    <td><input type="text" id="mapid_second" value=""><span id="mapid_tariff_second"> <br /> Standard MapID: <input style="width:150px;" type="text" id="mapid_tariff_second_value" value="" readonly></span></td>
                </tr>
                <tr id="bp_row">
                    <td><label for="bp">Basisprodukte verwenden:</label></td>
                    <td><input type="checkbox" id="bp"></td>
                </tr>
                <tr id="iai_row">
                    <td><label for="iai" title="Hier wird die IAI der Telekarten angegeben. Postpaid Verträge können nur mit 0 beginnende und Prepaid nur mit 4 beginnen.">IAI:</label></td>
                    <td>
                        <select id="iai">
                        </select>
                    </td>
                </tr>
                <tr id="hlr_row">
                    <td><label for="hlr" title="Hier wird das HLR ausgewählt. Zu beachten ist hier, dass nur dann ein wirknetzgebundenes HLR ausgewählt werden darf wenn es unbedingt benötigt wird.">HLR</label></td>
                    <td>
                        <select id="hlr">
                        </select>
                    </td>
                </tr>
                <tr id="karten_row">
                    <td><label for="karten" title="Hier kann angegeben werden wie viele Verträge pro VP2 erstellt werden sollen.">Anzahl Verträge / Karten pro VP2:</label></td>
                    <td><input type="text" id="karten" name="karten" value="1"></td>
                </tr>
                <tr id="kartentyp_row">
                    <td><label for="kartentyp" title="Hier wird der Kartentyp der Telekarten ausgewählt">Kartentyp:</label></td>
                    <td>
                        <select id="kartentyp">
                        </select>
                    </td>
                </tr>
                <tr id="rollendruck_row">
                    <td><label for="rollendruck" title="Ist diese Option aktiviert, ist der komplette Name der VP2 kleiner als 35 Zeichen.">Rollendruck:</label></td>
                    <td><input type="checkbox" id="rollendruck"></td>
                </tr>
                <tr id="kopplung_row">
                    <td><label for="kopplung" title="Hier können Kopplungen wie Twinbill oder CombiCard ausgewählt werden.">gekoppelte Verträge:</label></td>
                    <td>
                        <select id="kopplung">
                        </select>
                    </td>
                </tr>
                <tr id="vo_row">
                    <td><label for="vo" title="Wenn eine spezielle VO benötigt wird, bitte hier eintragen.">VO:</label></td>
                    <td><input type="text" id="vo" value=""></td>
                </tr>
            </table>
        </fieldset>
        <fieldset id="vertrag_container">
            <legend>
                Erweiterte Vertragsoptionen
                <img src="Library/Images/plus.gif" id="vertrag_container_toggler" onclick="editor_toggle('#vertrag_container_table','#vertrag_container_toggler')" />
            </legend>
            <table id="vertrag_container_table" style="display:none">
                <tr id="homezone_row">
                    <td><label for="homezone" title="Ist diese Option aktiviert, bekommen die Verträge eine Honezone-Option">Homezone:</label></td>
                    <td><input type="checkbox" id="homezone"></td>
                </tr>
                <tr id="laufzeit_row">
                    <td><label for="laufzeit" title="Hier kann die Bindefrist der Verträge angepast werden.">Laufzeit:</label></td>
                    <td>
                        <select id="laufzeit">
                        </select>
                    </td>
                </tr>
                <tr id="rv_row">
                    <td><label for="rv" title="Sollte bei GK Verträgen ein speuieller Rahmenvertrag benötigt werden kann er hier angegeben werden. Zu beachten ist allerdings, dass nur existierende Verträge verwenden werden dürfen.">Rahmenvertrag:</label></td>
                    <td><input type="text" id="rv" name="rv" value=""></td>
                </tr>

            </table>
        </fieldset>
        <fieldset id="bankverbindung_container">
            <legend>
                Spezielle Bankverbindungseinstellungen
                <img src="Library/Images/plus.gif" id="bankverbindung_container_toggler" onclick="editor_toggle('#bankverbindung_container_table','#bankverbindung_container_toggler')" />
            </legend>
            <table id="bankverbindung_container_table" style="display:none">  
                <tr id="regulierer_row">
                    <td><label for="regulierer" title="Ist diese Option aktiviert wird ein vom VP2 abweichender Regulierer erstellt">abweichender Regulierer:</label></td>
                    <td><input type="checkbox" id="regulierer"></td>
                </tr>
                <tr id="bankverbindung_row">
                    <td><label for="bankverbindung" title="Hier können verschiedene Arten der Bankverbindung ausgewählt werden.">Bankverbindung:</label></td>
                    <td>
                        <select id="bankverbindung">

                        </select>
                    </td>
                </tr>
            </table>
        </fieldset>
        <fieldset id="rechnung_container">
            <legend>
                Erweiterte Rechnungsoptionen
                <img src="Library/Images/plus.gif" id="rechnung_container_toggler" onclick="editor_toggle('#rechnung_container_table','#rechnung_container_toggler')" />
            </legend>
            <table id="rechnung_container_table" style="display:none">    
                <tr id="rea_row">
                    <td><label for="rea" title="Hier können andere Arten von Rechnungsempfänger ausgewählt werden.">Rechnungsempfänger:</label></td>
                    <td>
                        <select id="rea">

                        </select>
                    </td>
                </tr>
                <tr id="ra_row">
                    <td><label for="ra" title="Hier können alternative Rechnungsarten ausgewählt werden.">Rechnungsart:</label></td>
                    <td>
                        <select id="ra">

                        </select>
                    </td>
                </tr>
                <tr id="rmd_row">
                    <td><label for="rmd" title="Hier können alternative Rechnungsmedia ausgewählt werden.">Rechnungsmedium:</label></td>
                    <td>
                        <select id="rmd">

                        </select>
                    </td>
                </tr>
            </table>
        </fieldset>

        <!-- *********************************************************** -->

        <fieldset id="stammdaten_container">
            <legend>
                Erweitere Optionen Stammdaten
                <img src="Library/Images/plus.gif" id="stammdaten_container_toggler" onclick="editor_toggle('#stammdaten_container_table','#stammdaten_container_toggler')" />
            </legend>
            <table id="stammdaten_container_table" style="display:none">    
                <tr id="organisation_row">
                    <td><label for="organisation" title="Bei der Auswahl dieser Option wird anstatt einer natürlichen eine juristische Person (Firma) erstellt.">VP2 ist Organisation:</label></td>
                    <td>
                        <input type="checkbox" id="organisation">
                    </td>
                </tr>
                <tr id="name_row">
                    <td><label for="nachname" title="Hier können Vor- und Nachname angegeben werden. ACHTUNG: Jeder angelegte Kunde wird mit den Angaben erstellt.">Vorname / Nachname:</label></td>
                    <td>
                        <input type="text" style="width: 150px;" id="vorname" name="vorname" value=""> / <input type="text" style="width: 150px;" id="nachname" name="nachname" value="">
                    </td>
                </tr>
                <tr id="alter_row">
                    <td><label for="age" title="Das alter des VP2 in Lebensjahren">Alter:</label></td>
                    <td>
                        <input type="text" style="width: 80px;" id="age" name="age" value="">
                    </td>
                </tr>
                <tr id="adresse_row">
                    <td><label for="ort" title="">PLZ / ORT <br /> Straße / Hausnummer:</label></td>
                    <td>
                        <input type="text" id="plz"  style="width: 80px;" name="plz" value=""> / <input type="text" id="ort" style="width: 150px;" name="ort" value=""> <br />
                        <input type="text" id="strasse" style="width: 150px;" name="strasse" value=""> / <input type="text" id="hausnummer"  style="width: 50px;" name="hausnummer" value="">
                    </td>
                </tr>
            </table>
        </fieldset>

        <!-- *********************************************************** -->

        <fieldset id="result_container">
            <legend>Ergebnis</legend>
            <span id="text_master">Master Run: </span><textarea id="result" cols="100" rows="3" readonly="readonly"></textarea><br />
            <span id="text_slave">Slave Run: </span><textarea id="result_slave" cols="100" rows="3" readonly="readonly"></textarea>
        </fieldset>
        <fieldset id="job_container">
            <legend>Jobsteuerung</legend>
            <table>
                <tr id="checkrun">
                    <td><a class="button reload" onclick="checkRunnable();return false" href="#">Check</a> </td>
                    <td><span id="checkrun_result"></span></td>
                </tr>
                <tr id="job_overview">
                    <td>
                        JobID: <span id="job_id"></span>
                    </td>
                    <td>
                        Ist: <input type="text" id="job_ist" value="0" style="width: 47px;">
                        / 
                        Soll: <input type="text" id="job_soll" value="0" style="width: 47px;">

                        <select id="job_group_choose" style="width: 150px;"></select>
                    </td>
                    <td>
                        <a class="button reload" onclick="refreshJob($('#job_id').text(), true, false);return false" href="#">Refresh</a> 
                        <a class="button" onclick='UpdateJob($("#job_id").text(), $("#job_ist").val(),$("#job_soll").val(), $("#job_group_choose").val(),$("#job_jobzusatz").val(), false);return false' href="#">Speichern</a> 
                        <a class="button delete" onclick="DeleteJob($('#job_id').text(), $('#id').val(), false);return false" href="#">Löschen</a>
                    </td>
                </tr>
                <tr id="job_control">
                    <th colspan="3" style="text-align: left">

                        <span id="job_segment_label">Segment:</span>

                        <select id="job_segment" style="width: 150px;">
                            <option value="pk">PK</option>
                            <option value="gk">GK</option>
                            <option value="xtra">Xtra</option>
                        </select>

                        <select id="job_antest_choose" style="width: 150px;"></select>

                        <a class="button add" id="job_antest" href="#" onclick="createJob(false);return false">Starte Antest</a> 

                        <select id="job_start_choose" style="width: 150px;"></select>

                        <a class="button add" id="job_start" href="#" onclick="startJob(false);return false">Starte Komplett</a>

                        <br />
                        <span id="job_text_jobzusatz">Job-Zusatz: </span><textarea id="job_jobzusatz" cols="100" rows="3"></textarea>
                        
                        
                        <img src='./Library/Images/loader.gif' id="job_loading"/>
                        <br />
                        <span id="job_message"></span>
                    </th>
                </tr>
                
            </table>
        </fieldset>
        <fieldset id="job_slave_container">
            <legend>SlaveRun-Jobsteuerung</legend>
            <table>
                <tr id="job_slave_overview">
                    <td>
                        JobID: <span id="job_slave_id"></span>
                    </td>
                    <td>
                        Ist: <input type="text" id="job_slave_ist" value="0" style="width: 47px;">
                        / 
                        Soll: <input type="text" id="job_slave_soll" value="0" style="width: 47px;">

                        <select id="job_slave_group_choose" style="width: 150px;"></select>
                    </td>
                    <td>
                        <a class="button reload" onclick="refreshJob($('#job_slave_id').text(), true, true);return false" href="#">Refresh</a> 
                        <a class="button" onclick='UpdateJob($("#job_slave_id").text(), $("#job_slave_ist").val(),$("#job_slave_soll").val(), $("#job_slave_group_choose").val(),$("#job_slave_jobzusatz").val(), true);return false' href="#">Speichern</a> 
                        <a class="button delete" onclick="DeleteJob($('#job_slave_id').text(), $('#id').val(), true);return false" href="#">Löschen</a>
                    </td>
                </tr>
                <tr id="job_control_slave">
                    <th colspan="3" style="text-align: left">

                        <span id="job_slave_segment_label">Slave-Run Segment:</span>

                        <select id="job_slave_segment" style="width: 150px;">
                            <option value="pk">PK</option>
                            <option value="gk">GK</option>
                            <option value="xtra">Xtra</option>
                        </select>

                        <select id="job_slave_antest_choose" style="width: 150px;"></select>

                        <a class="button add" id="job_slave_antest" href="#" onclick="createJob(true);return false">Starte SlaveRun-Antest</a> 

                        <select id="job_slave_start_choose" style="width: 150px;"></select>

                        <a class="button add" id="job_slave_start" href="#" onclick="startJob(true);return false">Starte SlaveRun-Komplett</a>

                        <br />
                        <span id="job_slave_text_jobzusatz">Job-Zusatz: </span><textarea id="job_slave_jobzusatz" cols="100" rows="3"></textarea>
                        
                        
                        <img src='./Library/Images/loader.gif' id="job_slave_loading"/>
                        <br />
                        <span id="job_slave_message"></span>
                    </th>
                </tr>
            </table>
        </fieldset>
    </form>
    * Pflichtfeld
</div>

<div id="loading" title="Status">
    <p id="AJAXMessage">Request wird gesendet</p>
</div>

<div id="question" title="Status">
    <p id="QuestionMessage">Test</p>
</div>
<div id="order_dialog" title="TDB Kartenbestellungseditor 1.0" style="display:none;">
    <form id="order_generator">

        <fieldset id="order_release_container">
            <legend>Release</legend>
            <span id="order_release"></span>
        </fieldset>

        <fieldset id="order_sonstiges_container">
            <legend>Bestellung</legend>
            <table>
                <tr id="order_id_row">
                    <td><label for="id">Anforderungs-ID</label></td>
                    <td><input type="text" id="order_id" readonly /></td>
                </tr>
                <tr id="order_teilprojekt_row">
                    <td><label for="teilprojekt" title="Hier wird das Teilprojekt ausgewählt. Dieses bestimmt auch den Ort, an dem die entsprechenden Daten abgelegt werden.">* Teilprojekt</label></td>
                    <td>
                        <select id="order_teilprojekt">
                        </select>  
                    </td>
                </tr> 
                <tr>
                    <td><label for="anforderer" title="Der Anforderer. Wichtig für eventuelle Rückfragen zur Anforderung">* Anforderer</label></td>
                    <td><select id="order_anforderer">
                        </select></td>
                </tr>
                <tr id="order_ansprechpartner_row">
                    <td> <label for="ansprechpartner" title="Der Ansprechpartner welcher für die Anforderung zuständig ist.">Ansprechpartner</label></td>
                    <td><select id="order_ansprechpartner">
                        </select></td>
                </tr>
                <tr id="order_status_row">
                    <td><label for="status"  title="Der Status in dem sich die Anforderung befindet.">Status</label></td>
                    <td>
                        <select id="order_status">
                        </select>
                    </td>
                </tr> 

                <tr id="order_anzahl_row">
                    <td><label for="anzahl" title="Die Anzahl der benötigten VP2 mit zugehörigem Vertrag. Zu beachten ist hier, dass wenn mehrere Verträge pro VP2 benötigt werden, hier die Anzahl der VP2 angegeben werden muss.">* Anzahl</label></td>
                    <td><input type="text" id="order_anzahl" name="order_anzahl" />
                    </td>
                </tr>
                <tr id="order_eingestellt_row">
                    <td><label for="eingestellt" title="Erstellungsdatum der Anforderung.">Eingestellt</label></td>
                    <td><input type="text" id="order_eingestellt" />
                    </td>
                </tr>
                <tr id="order_wunschtermin_row">
                    <td><label for="wunschtermin" title="Der Termin an dem die Daten benötigt werden. Die Auslieferung kann sich u.U. je nach Auslastung und Wunschtermin verschieben. Bei kritischen Anforderungen bitten wir um Rücksprache.">* Wunschtermin</label></td>
                    <td><input type="text" id="order_wunschtermin" name="order_wunschtermin" />
                    </td>
                </tr>
                <tr id="order_fertigstellung_row">
                    <td><label for="fertigstellung" title="Datum der Fertigstellung und Auslieferung der Anforderung">Fertigstellung</label></td>
                    <td><input type="text" id="order_fertigstellung" />
                    </td>
                </tr>
                <tr id="order_bemerkung_row">
                    <td><label for="bemerkung" title="Hier können Bemerkungen bezüglich der Anforderungen eingetragen werden.">Bemerkung</label></td>
                    <td><textarea id="order_bemerkung" name="order_bemerkung" cols="75" rows="3"></textarea></td>
                </tr>
                <tr id="order_fertig_row">
                    <td><label for="fertig" title="Die Fertigstellung der Anforderung.">Fertig</label></td>
                    <td><input type="text" id="order_fertig"  />
                    </td>
                </tr>
                <tr id="order_bemerkungintern_row">
                    <td><label for="bemerkungintern">BemerkungIntern</label></td>
                    <td><textarea id="order_bemerkungintern" name="order_bemerkungintern" cols="75" rows="10"></textarea></td>
                </tr>
                <tr id="order_provider_row">
                    <td><label for="provider" title="Hier wird der Provider ausgewählt.">* Provider</label></td>
                    <td>
                        <select id="order_provider">
                        </select>
                    </td>
                </tr> 
                <tr id="order_standardvertragsgruppe_row">
                    <td><label for="tarif" title="Hier wird die Standardvertragsgruppe ausgewählt.">* StandardVertragsGruppe</label></td>
                    <td>
                        <select id="order_standardvertragsgruppe">
                        </select>
                    </td>
                </tr> 
                <tr id="order_twinbill_row">
                    <td><label for="order_twinbill" title="Ist diese Option aktiviert werden die Karten als Twinbill-Karten ausgeliefert. Dieses ist nur bei POSTPAID Karten möglich.">TwinBill Karten:</label></td>
                    <td><input type="checkbox" id="order_twinbill"></td>
                </tr>
                <tr id="order_kartentyp_row">
                    <td><label for="order_kartentyp" title="Hier wird der Kartentyp der Telekarten ausgewählt">* Kartentyp:</label></td>
                    <td>
                        <select id="order_kartentyp">
                        </select>
                    </td>
                </tr>
                <tr id="order_hlr_row">
                    <td><label for="hlr" title="Hier wird das HLR ausgewählt. Zu beachten ist hier, dass nur dann ein wirknetzgebundenes HLR ausgewählt werden darf wenn es unbedingt benötigt wird.">* HLR:</label></td>
                    <td>
                        <select id="order_hlr">
                        </select>
                    </td>
                </tr>
            </table>
        </fieldset>
    </form>
    * Pflichtfeld
</div>

<div id="order_loading" title="Status">
    <p id="order_AJAXMessage">Request wird gesendet</p>
</div>

<div id="order_question" title="Status">
    <p id="order_QuestionMessage">Test</p>
</div>
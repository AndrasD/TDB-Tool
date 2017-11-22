// lädt ein Requirement mit der entsprechenden ID in den Editor
function LoadRequirement(id)
{

    $("#generator").validate().resetForm();

    // Load Details / öffnen und schließen von ladebildschirm und editor
    $("#AJAXMessage").html("Laden ... <img src='./Library/Images/loader.gif' />");
    $("#loading").dialog("open");
    $("#dialog").dialog("close");

    // AJAX
    var req = $.parseJSON(AJAX_GetDetails(id));

    if (req == null)
    {
        $("#AJAXMessage").html("Fehler, AJAX-Call nicht erfolgreich.");
    }

    // Set Fields to Values
    $('#id').val(req["id"]);
    //    $('#release').val(req["release"]);
    $('#anforderer').val(req["anforderer"]);
    $('#ansprechpartner').val(req["ansprechpartner"]);
    $('#anzahl').val(req["anzahl"]);
    $('#eingestellt').val(req["eingestellt"]);

    $('#wunschtermin').val(req["wunschtermin"]);

    $('#fertigstellung').val(req["fertigstellung"]);
    $('#bemerkung').val(req["bemerkung"]);
    $('#bemerkungintern').val(req["bemerkungintern"]);
    $('#tarif').val(req["tarif"]);
    $('#tarif_second').val(req["tarif_second"]);
    $('#status').val(req["status"]);
    $('#teilprojekt').val(req["teilprojekt"]);
    $('#zusatz').val(req["zusatz"]);
    $('#karten').val(req["karten"]);
    $('#mapid').val(req["mapid"]);
    $('#mapid_second').val(req["mapid_second"]);
    if (req["bp"] == "true")
    {
        $('#bp').prop('checked', true);
    }
    else
    {
        $('#bp').prop('checked', false);
    }
    $('#hlr').val(req["hlr"]);
    $('#iai').val(req["iai"]);
    $('#kartentyp').val(req["kartentyp"]);
    if (req["rollendruck"] == "true")
    {
        $('#rollendruck').prop('checked', true);
    }
    else
    {
        $('#rollendruck').prop('checked', false);
    }
    $('#kopplung').val(req["kopplung"]);
    if (req["homezone"] == "true")
    {
        $('#homezone').prop('checked', true);
    }
    else
    {
        $('#homezone').prop('checked', false);
    }
    $('#laufzeit').val(req["laufzeit"]);
    $('#rea').val(req["rea"]);
    $('#bankverbindung').val(req["bankverbindung"]);
    if (req["regulierer"] == "true")
    {
        $('#regulierer').prop('checked', true);
    }
    else
    {
        $('#regulierer').prop('checked', false);
    }
    $('#ra').val(req["ra"]);
    $('#rv').val(req["rv"]);
    $('#rmd').val(req["rmd"]);
    $('#fertig').val(req["fertig"]);

    if (req["organisation"] == "true")
    {
        $('#organisation').prop('checked', true);
    }
    else
    {
        $('#organisation').prop('checked', false);
    }
    $('#ort').val(req["ort"]);
    $('#plz').val(req["plz"]);
    $('#strasse').val(req["strasse"]);
    $('#hausnummer').val(req["hausnummer"]);
    $('#vorname').val(req["vorname"]);
    $('#nachname').val(req["nachname"]);
    $('#age').val(req["age"]);
    $('#vo').val(req["vo"]);

    // TDB-String aktualisieren
    ApplyTDBString();

    setFormInputStatus("editrequirement", req["status"], req["id"])

    $("#dialog").dialog("open");
    $("#loading").dialog("close");
    if (TDB)
    {
        $("#job_container").show();
        loadJobControl(req["jobid"], false);
        loadJobControl(req["jobid_second"], true);
        updateDefaultMapID(req["tarif"], req["mapid"]);
        updateSecondMapID($('#tarif_second').val(), $('#mapid_second').val());
        setSecondTariffVisibility();
    }
}

// (GUI) Workflow zum Löschen einer Anforderung
function DeleteRequirement(id)
{
    // öffnen und schließen von ladebildschirm und editor
    $("#dialog").dialog("close");
    $("#QuestionMessage").text("Anforderung '" + id + "' wirklich löschen?");
    //$( "#question" ).dialog("open"); 
    $("#question").dialog({
        buttons: {
            "Ja": function() {
                //<img src='./Library/Images/loader.gif' />
                $("#question").dialog({
                    buttons: {}
                });
                $("#QuestionMessage").html("Bitte warten... <img src='./Library/Images/loader.gif' />");
                // AJAX call
                var response = $.parseJSON(AJAX_DeleteRequirement(id));

                // Auswerten der Antwort
                if (response.success)
                {
                    var rownum = oTable.fnGetPosition($("#row_" + response.id)[0]);
                    oTable.fnDeleteRow(rownum);
                    $("#QuestionMessage").html(response.message);
                    $("#question").dialog({
                        buttons: {
                            "Okay": function() {
                                $("#question").dialog("close");
                            }
                        }
                    });
                }
                else
                {
                    $("#QuestionMessage").html(response.message);
                }
            },
            "Nein": function() {
                $("#question").dialog("close");
                LoadRequirement(id);
            }
        }
    });
    $("#question").dialog("open");

}

// (GUI) öffnet den Editor-Dialog bei dem die Default-Werte geladen sind.
function OpenCleanEditor()
{
    document.getElementById("generator").reset();
    $("#generator").validate().resetForm();
    ApplyTDBString();
    // Blendet nicht benötigte Felder aus
    setFormInputStatus("cleaneditor", null, null);

    //    $("select").each(function() { 
    //        setTDBColor(this);
    //    });

    $("#dialog").dialog("open");

    $("#job_container").hide();
}

// (GUI) Workflow zum Erstellen einer Anforderung
function CreateRequirement()
{
    // öffnen und schließen von ladebildschirm und editor
    $("#dialog").dialog("close");
    $("#AJAXMessage").html("Bitte warten ... <img src='./Library/Images/loader.gif' />");
    $("#loading").dialog("open");

    // AJAX call
    //alert(AJAX_CreateRequirement());
    var response = $.parseJSON(AJAX_CreateRequirement());

    // Auswerten der Antwort
    if (response.success)
    {
        var ai = oTable.fnAddData(GetRequirementDetailsForDataTable(response.id));
        var n = oTable.fnSettings().aoData[ ai[0] ].nTr;
        n.setAttribute('id', 'row_' + response.id);
        $("#AJAXMessage").html(response.message);
        setTimeout(function() {
            $("#loading").dialog("close");
        }, 5000);

    }
    else
    {
        $("#AJAXMessage").html(response.message);
    }
}



// liest Felder im Editor aus und gibt diese als JSON-Array zurück
function fetchDataFromEditor()
{
    return {
        "id": $('#id').val(),
        // "release" : $('#release').val(),
        "release": $('#release_main').val(),
        "anforderer": $('#anforderer').val(),
        "ansprechpartner": $('#ansprechpartner').val(),
        "anzahl": $('#anzahl').val(),
        "eingestellt": $('#eingestellt').val(),
        "wunschtermin": $('#wunschtermin').val(),
        "fertigstellung": $('#fertigstellung').val(),
        "bemerkung": $('#bemerkung').val(),
        "bemerkungintern": $('#bemerkungintern').val(),
        "tarif": $('#tarif').val(),
        "tarif_second": $('#tarif_second').val(),
        "status": $('#status').val(),
        "teilprojekt": $('#teilprojekt').val(),
        "zusatz": $('#zusatz').val(),
        "mapid": $('#mapid').val(),
        "mapid_second": $('#mapid_second').val(),
        "karten": $('#karten').val(),
        "bp": $('#bp').prop('checked'),
        "homezone": $('#homezone').prop('checked'),
        "hlr": $('#hlr').val(),
        "iai": $('#iai').val(),
        "kartentyp": $('#kartentyp').val(),
        "rollendruck": $('#rollendruck').prop('checked'),
        "kopplung": $('#kopplung').val(),
        "laufzeit": $('#laufzeit').val(),
        "rea": $('#rea').val(),
        "bankverbindung": $('#bankverbindung').val(),
        "regulierer": $('#regulierer').prop('checked'),
        "ra": $('#ra').val(),
        "rv": $('#rv').val(),
        "rmd": $('#rmd').val(),
        "fertig": $('#fertig').val(),
        "organisation": $('#organisation').prop('checked'),
        "ort": $('#ort').val(),
        "plz": $('#plz').val(),
        "strasse": $('#strasse').val(),
        "hausnummer": $('#hausnummer').val(),
        "vorname": $('#vorname').val(),
        "nachname": $('#nachname').val(),
        "age": $('#age').val(),
        "vo": $('#vo').val()
    }
}

// (GUI) Workflow zum Bearbeiten einer Anforderung
function EditRequirement(id)
{
    // öffnen und schließen von ladebildschirm und editor
    $("#dialog").dialog("close");
    $("#AJAXMessage").html("Bitte warten ... <img src='./Library/Images/loader.gif' />");
    $("#loading").dialog("open");

    // AJAX call
    var response = $.parseJSON(AJAX_EditRequirement(id));

    // Auswerten der Antwort
    if (response.success)
    {
        // Update der Zeile in der DataTable
        var rownum = oTable.fnGetPosition($("#row_" + id)[0]);
        //oTable.fnDeleteRow( rownum );
        oTable.fnUpdate(GetRequirementDetailsForDataTable(id), rownum);
        $("#AJAXMessage").html(response.message);
        setTimeout(function() {
            $("#loading").dialog("close");
        }, 5000);
    }
    else
    {
        $("#AJAXMessage").text(response.message);
    }
}

function GetRequirementDetailsForDataTable(id)
{
    var req = $.parseJSON(AJAX_GetAnforderungenById(id));
    //var req = req_array[0];

    if (req["aktiviert"] == "Ja")
    {
        tmplink = '<button id="edit_' + id + '" onclick="LoadRequirement(\'' + id + '\')">Laden</button>'
    }
    else
    {
        tmplink = '<button id="edit_' + id + '" onclick="LoadCardOrder(\'' + id + '\')">Laden</button>'
    }
    return [
        req["nr"],
        req["teilprojekt"],
        req["release"],
        req["anforderer"],
        req["aktiviert"],
        req["anzahl"],
        req["rv"],
        req["tarif"],
        req["kartentyp"],
        req["laufzeit"],
        req["eingestellt"],
        req["wunschtermin"],
        req["fertigstellung"],
        req["bemerkung"],
        req["ansprechpartner"],
        req["fertig"],
        req["status"],
        tmplink
    ];
}

function setColFilter(column)
{
    $(column)[0].initVal = $(column).value;
    $(column).val(choosen_TP_Text);
    oTable.fnFilter(choosen_TP_Text, oTable.oApi._fnVisibleToColumnIndex(oTable.fnSettings(), $("thead input").index($(column))));
    $(column)[0].className = "";
}

function checkHLR_for_Xtra(hlr, tarif)
{
    if (tarif.toLowerCase().indexOf("xtra") != -1)
    {
        //hlr = $("#hlr").val().slice(2,3);
        if (hlr.length < 4 && hlr.slice(2, 3) == "2")
        {
            alert("Für einen Xtra Tarif bitte ein wirknetzgebundenes HLR wählen.");
        }
    }
}

function setSecondTariffVisibility()
{
    switch ($("#kopplung").val())
    {
        case("tbpro"):
            $("#tarif_second_row").show();
            if (TDB)
            {
                $('#mapid_second_row').show();
                $('#job_slave_container').show();
            }
            break;

        case("combicard"):
            $("#tarif_second_row").show();
            if (TDB)
            {
                $('#mapid_second_row').show();
                $('#job_slave_container').show();
            }
            break;

        case("twincard"):
            $("#tarif_second_row").hide();
            $('#mapid_second_row').hide();
            $('#job_slave_container').hide();
            break;

        case("multisim"):
            $("#tarif_second_row").hide();
            $('#mapid_second_row').hide();
             $('#job_slave_container').hide();
            break;

        default:
            $("#tarif_second_row").hide();
            $('#mapid_second_row').hide();
            $('#job_slave_container').hide();
    }
}

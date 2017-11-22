var reqID;
var reqTime;

//------------------------------------------------------------------------------
//Version 1.2 - Johannes Nitschmann
var Releases = $.parseJSON(AJAX_GetReleases());
var HLR = $.parseJSON(AJAX_GetHLR());
var Anforderer = $.parseJSON(AJAX_GetAnforderer());
var Ansprechpartner = $.parseJSON(AJAX_GetAnsprechpartner());
var Teilprojekt = $.parseJSON(AJAX_GetTeilprojekt());
var Status = $.parseJSON(AJAX_GetStatus());
var Tarif = $.parseJSON(AJAX_GetTariff());
var StandardVertragsGruppe = $.parseJSON(AJAX_GetSTDVGR());
var Kartentypen = $.parseJSON(AJAX_GetKartentyp());
var Laufzeiten = $.parseJSON(AJAX_GetLaufzeit());
var Kopplungsarten = $.parseJSON(AJAX_GetKopplungsarten());
var Bankverbindungen = $.parseJSON(AJAX_GetBankverbindungen());
var Rechnungsempfaenger = $.parseJSON(AJAX_GetRechnungsempfaenger());
var Rechnungsarten = $.parseJSON(AJAX_GetRechnungsarten());
var IAI = $.parseJSON(AJAX_GetIAI());
var Rechnungsmedia = $.parseJSON(AJAX_GetRechnungsmedia());
var Provider = $.parseJSON(AJAX_GetProvider());
var choosen_Anforderer;
var choosen_TP;
var choosen_TP_Text;
var Anforderungen; // Wird in TDB_js geladen, da abhängig vom Release

function addOption(value, text, isSelected, selectlist, addColor)
{
    if (isSelected == "true")
    {
        $("<option selected/>").val(value).text(text).prop('selected', true).appendTo(selectlist);
    }
    else
    {
        if (TDB && addColor)
        {
            $("<option/>").val(value).text("[*] " + text).prop('selected', false).appendTo(selectlist);
        }
        else
        {
            $("<option/>").val(value).text(text).prop('selected', false).appendTo(selectlist);
        }
    }
}

function fillSelect(werte, selectlist, addColor)
{
    for (var counter = 0; werte.length > counter; counter++)
    {
        addOption(werte[counter]["value"], werte[counter]["text"], werte[counter]["standard"], selectlist, addColor);
    }
}

function generate2DArrayFrom1D(array)
{
    var newArray = new Array();
    for (var counter = 0; array.length > counter; counter++)
    {
        newArray[counter] = new Object();
        newArray[counter]["value"] = array[counter];
        newArray[counter]["text"] = array[counter];
    }
    return newArray;
}

function fillRelease_global(input)
{
    var now = new Date();
    var begin, end;
    for (var counter = 0; Releases.length > counter; counter++)
    {
        begin = new parseDate(Releases[counter].begin);
        end = new parseDate(Releases[counter].end);
        if ((begin <= now && end >= now) || TDB)
        {
            if (Releases[counter].standard == "true")
            {
                $("<option selected/>").val(Releases[counter].value).text(Releases[counter].text).attr('selected', true).appendTo(input);
            }
            else
            {
                $("<option/>").val(Releases[counter].value).text(Releases[counter].text).attr('selected', false).appendTo(input);
            }
        }
        else
        {
            // Release wird nicht mehr angezeigt.
            //$("<option/>").val(Releases[counter].value).text(Releases[counter].text).attr('selected',false).appendTo(input);
        }

    }

}

//function fillRelease()
//{
//    fillRelease_global("#release");
//}

function fillRelease_main()
{
    fillRelease_global("#release_main");
}

//function order_fillRelease()
//{
//    fillRelease_global("#order_release");
//}

function fillHLR()
{
    fillHLR_global("#hlr", "#release_main");
}

function order_fillHLR()
{
    fillHLR_global("#order_hlr", "#release_main");
}

function fillHLR_global(hlrinput, releaseinput)
{
    $(hlrinput).empty();
    var actualRelease = $(releaseinput).val();
    for (var counter = 0; HLR.length > counter; counter++)
    {
        if (HLR[counter].release == actualRelease) {
            addOption(HLR[counter].value,
                    HLR[counter].text,
                    HLR[counter].standard,
                    hlrinput
                    , true);
        }
    }
}

function fillKartentyp()
{
    fillSelect(Kartentypen, "#kartentyp", true);
    fillSelect(Kartentypen, "#order_kartentyp", true);
}

function fillIAI()
{
    fillSelect(IAI, "#iai", true);
}

function fillProvider()
{
    fillSelect(Provider, "#order_provider", true);
}

function fillLaufzeit()
{
    fillSelect(Laufzeiten, "#laufzeit", true);
}

function fillBankverbindung()
{
    fillSelect(Bankverbindungen, "#bankverbindung", true);
}

function fillRechnungsempfaenger()
{
    fillSelect(Rechnungsempfaenger, "#rea", true);
}

function fillRechnungsart()
{
    fillSelect(Rechnungsarten, "#ra", true);
}

function fillKopplung()
{
    fillSelect(Kopplungsarten, "#kopplung", true);
}

function fillRechnungsmedium()
{
    fillSelect(Rechnungsmedia, "#rmd", true);
}

function fillTeilprojekt()
{
    fillSelect(Teilprojekt, "#teilprojekt", false);
    fillSelect(Teilprojekt, "#order_teilprojekt", false);
    fillSelect(Teilprojekt, "#choose_teilprojekt", false);
}

function fillStatus()
{
    fillSelect(Status, "#status", false);
    fillSelect(Status, "#order_status", false);
}

function fillAnsprechpartner()
{
    fillSelect(Ansprechpartner, "#ansprechpartner", false);
    fillSelect(Ansprechpartner, "#order_ansprechpartner", false);
}

function fillAnforderer()
{
    fillSelect(Anforderer, "#anforderer", false);
    fillSelect(Anforderer, "#order_anforderer", false);
    fillSelect(Anforderer, "#choose_anforderer", false);
}

function fillTarif()
{
    fillSelect(Tarif, "#tarif", false);
    fillSelect(Tarif, "#tarif_second", false);
}

function order_fillStandardVertragsGruppe()
{
    fillSelect(StandardVertragsGruppe, "#order_standardvertragsgruppe", false);
}

function getLookupValue(array, lookup, value)
{
    for (var counter = 0; array.length > counter; counter++)
    {
        if (array[counter]["value"] == value)
        {
            return array[counter][lookup];
        }
    }
    return "";
}

function parseDate(input) {
    var parts = input.split('.');
    // new Date(year, month [, day [, hours[, minutes[, seconds[, ms]]]]])
    return new Date(parts[2], parts[1] - 1, parts[0]); // Note: months are 0-based
}

function fillTable()
{
    oTable.fnClearTable();
    var ai, n, tmp, tmplink;
    for (var counter = 0; Anforderungen.length > counter; counter++)
    {
        if (Anforderungen[counter]["aktiviert"] == "Ja")
        {
            tmplink = '<button id="edit_' + Anforderungen[counter]["nr"] + '" onclick="LoadRequirement(\'' + Anforderungen[counter]["nr"] + '\')">Laden</button>'
        }
        else
        {
            tmplink = '<button id="edit_' + Anforderungen[counter]["nr"] + '" onclick="LoadCardOrder(\'' + Anforderungen[counter]["nr"] + '\')">Laden</button>'
        }
        tmp = [
            Anforderungen[counter]["nr"],
            Anforderungen[counter]["teilprojekt"],
            Anforderungen[counter]["release"],
            Anforderungen[counter]["anforderer"],
            Anforderungen[counter]["aktiviert"],
            Anforderungen[counter]["anzahl"],
            Anforderungen[counter]["rv"],
            Anforderungen[counter]["tarif"],
            Anforderungen[counter]["kartentyp"],
            Anforderungen[counter]["laufzeit"],
            Anforderungen[counter]["eingestellt"],
            Anforderungen[counter]["wunschtermin"],
            Anforderungen[counter]["fertigstellung"],
            Anforderungen[counter]["bemerkung"],
            Anforderungen[counter]["ansprechpartner"],
            Anforderungen[counter]["fertig"],
            Anforderungen[counter]["status"],
            tmplink
        ];
        ai = oTable.fnAddData(tmp, false);
        n = oTable.fnSettings().aoData[ ai[0] ].nTr;
        n.setAttribute('id', 'row_' + Anforderungen[counter]["nr"]);
    }
    oTable.fnDraw();
}

function reloadTable(release)
{
    // Besseres Handling
    oTable.fnClearTable();
    $("#AJAXMessage").html("Bitte warten ... <img src='./Library/Images/loader.gif' />");
    $("#loading").dialog("open");
    Anforderungen = $.parseJSON(AJAX_GetAnforderungen(release));
    fillTable();
    $("#loading").dialog("close");
}

function getMapIDfromTariff(tariffval)
{
    // ToDo: Methode getLookupValue einbauen! Redundanz.
    for (var counter = 0; Tarif.length > counter; counter++)
    {
        if (Tarif[counter].value == tariffval) {
            return Tarif[counter];
        }
    }
    return null;
}

function updateDefaultMapID(tariff, mapid) {
//    var predefined_mapid = getMapIDfromTariff(tariff);
//    if (predefined_mapid != null && (mapid == "" || mapid == null))
//    {
//        $('#mapid_tariff').show();
//        $('#mapid_tariff_value').val(predefined_mapid);
//    }
//    else
//    {
//        $('#mapid_tariff').hide();
//    }
    updateMapID(tariff, mapid, '#mapid_tariff', '#mapid_tariff_value', $('#kopplung').val(), false);
}

function updateSecondMapID(tariff, mapid) {

    updateMapID(tariff, mapid, '#mapid_tariff_second', '#mapid_tariff_second_value', $('#kopplung').val(), true);
}

function updateMapID(tariff, mapid, targetdefault, targetvalue, kopplung, second) {
    var predefined_mapid = getPredefinedMapID(tariff, kopplung, second);

    if (predefined_mapid != null && (mapid == "" || mapid == null))
    {
        $(targetdefault).show();
        $(targetvalue).val(predefined_mapid);
    }
    else
    {
        $(targetdefault).hide();
    }
}

function getPredefinedMapID(tariff, kopplung, second)
{
    var predefined_mapid_array = getMapIDfromTariff(tariff);
    var predefined_mapid;
    switch (kopplung)
    {
        case("twinbill"):
            predefined_mapid = predefined_mapid_array.map_tb;
            break;

        case("tbpro"):
            if (!second)
            {
                predefined_mapid = predefined_mapid_array.map_tbpromaster;
            }
            else
            {
                predefined_mapid = predefined_mapid_array.map_tbproslave;
            }
            break;

        case("combicard"):
            predefined_mapid = predefined_mapid_array.mapid;
            break;

        case("twincard"):
            predefined_mapid = null;
            break;

        case("multisim"):
            predefined_mapid = predefined_mapid_array.map_multisim;
            break;

        default:
            predefined_mapid = predefined_mapid_array.mapid;
    }
    return predefined_mapid;
}
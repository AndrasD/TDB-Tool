
var Rechnergruppen = [
    {
        "text": "TDB-VM",
        "value": 110,
        "antest": false
    },
    {
        "text": "TDB-Stop",
        "value": 111,
        "antest": false
    }
    ,
    {
        "text": "TDB-784",
        "value": 112,
        "antest": false
    }
];

var add_min = 1;
var add_max = 50;
var add_percentage = 0.05;

function initiatejobControl() {
    for (var i = 0; i < Rechnergruppen.length; i++)
    {
        if (Rechnergruppen[i]["antest"])
        {
            $("<option/>").val(Rechnergruppen[i]["value"]).text("[*]" + Rechnergruppen[i]["text"]).appendTo($("#job_antest_choose"));
        }
        else
        {
            $("<option/>").val(Rechnergruppen[i]["value"]).text(Rechnergruppen[i]["text"]).appendTo($("#job_start_choose"));
            $("<option/>").val(Rechnergruppen[i]["value"]).text(Rechnergruppen[i]["text"]).appendTo($("#job_antest_choose"));
        }
        $("<option/>").val(Rechnergruppen[i]["value"]).text(Rechnergruppen[i]["text"]).appendTo($("#job_group_choose"));
    }
    for (var i = 0; i < Rechnergruppen.length; i++)
    {
        if (Rechnergruppen[i]["antest"])
        {
            $("<option/>").val(Rechnergruppen[i]["value"]).text("[*]" + Rechnergruppen[i]["text"]).appendTo($("#job_slave_antest_choose"));
        }
        else
        {
            $("<option/>").val(Rechnergruppen[i]["value"]).text(Rechnergruppen[i]["text"]).appendTo($("#job_slave_start_choose"));
            $("<option/>").val(Rechnergruppen[i]["value"]).text(Rechnergruppen[i]["text"]).appendTo($("#job_slave_antest_choose"));
        }
        $("<option/>").val(Rechnergruppen[i]["value"]).text(Rechnergruppen[i]["text"]).appendTo($("#job_slave_group_choose"));
    }
}

function loadJobControl(jobid, isSlaveRun) {

    if (!isSlaveRun)
    {
        dynamicLoadJobControl(jobid,
                "#job_start_choose",
                "#job_start",
                "#job_overview",
                "#job_loading",
                "#job_antest",
                "#job_antest_choose",
                "#job_segment",
                "#job_message",
                "#job_segment_label",
                "#job_jobzusatz",
                "#job_text_jobzusatz",
                "#tarif", isSlaveRun);
    }
    else
    {
        dynamicLoadJobControl(jobid,
                "#job_slave_start_choose",
                "#job_slave_start",
                "#job_slave_overview",
                "#job_slave_loading",
                "#job_slave_antest",
                "#job_slave_antest_choose",
                "#job_slave_segment",
                "#job_slave_message",
                "#job_slave_segment_label",
                "#job_slave_jobzusatz",
                "#job_slave_text_jobzusatz",
                "#tarif_second", isSlaveRun);
    }
}

function dynamicLoadJobControl(jobid,
        job_start_choose,
        job_start,
        job_overview,
        job_loading,
        job_antest,
        job_antest_choose,
        job_segment,
        job_message,
        job_segment_label,
        job_jobzusatz,
        job_text_jobzusatz,
        tariffield, isSlaveRun) {
    // Check ob bereits job vorhanden
    //
    if (jobid == null || jobid == "")
    {
        $(job_start_choose).hide();
        $(job_start).hide();
        $(job_overview).hide();
        $(job_loading).hide();
        $(job_antest).show();
        $(job_antest_choose).show();
        $(job_segment).attr("disabled", false);
        $(job_message).html("");
        $(job_segment).show();
        $(job_segment_label).show();
        $(job_jobzusatz).hide();
        $(job_text_jobzusatz).hide();

        $(job_segment).val("pk");

        var tarif = $(tariffield).val().toLowerCase();

        if (tarif.indexOf("busi") != -1)
        {
            $(job_segment).val("gk");
        }
        if (tarif.indexOf("xtra") != -1 || tarif.indexOf("magentamobil start") != -1)
        {
            $(job_segment).val("xtra");
        }
    }
    else
    {
        $(job_antest).hide();
        $(job_antest_choose).hide();
        $(job_segment).attr("disabled", true);

        refreshJob(jobid, false, isSlaveRun);
    }
}

function refreshJob(jobid, openOverviewOnError, isSlaveRun)
{
    if (!isSlaveRun)
    {
        DynamicRefreshJob(jobid,
                openOverviewOnError,
                "#job_overview",
                "#job_loading",
                "#job_start_choose",
                "#job_start",
                "#job_segment",
                "#job_segment_label",
                "#job_jobzusatz",
                "#job_text_jobzusatz",
                "#job_message",
                "#job_id",
                "#job_ist",
                "#job_soll",
                "#job_group_choose");
    }
    else
    {
        DynamicRefreshJob(jobid,
                openOverviewOnError,
                "#job_slave_overview",
                "#job_slave_loading",
                "#job_slave_start_choose",
                "#job_slave_start",
                "#job_slave_segment",
                "#job_slave_segment_label",
                "#job_slave_jobzusatz",
                "#job_slave_text_jobzusatz",
                "#job_slave_message",
                "#job_slave_id",
                "#job_slave_ist",
                "#job_slave_soll",
                "#job_slave_group_choose");
    }

}

function DynamicRefreshJob(jobid,
        openOverviewOnError,
        job_overview,
        job_loading,
        job_start_choose,
        job_start,
        job_segment,
        job_segment_label,
        job_jobzusatz,
        job_text_jobzusatz,
        job_message,
        job_id,
        job_ist,
        job_soll,
        job_group_choose)
{
    $(job_overview).hide();
    $(job_loading).show();
    $(job_start_choose).hide();
    $(job_start).hide();
    $(job_segment).hide();
    $(job_segment_label).hide();
    $(job_jobzusatz).hide();
    $(job_text_jobzusatz).hide();
    $(job_message).html("");

    var result = $.parseJSON(
            AJAX_GetJobStatus(
                    jobid
                    ));
    if (result != null)
    {
        $(job_id).text(result["id"]);
        $(job_ist).val(result["ist"]);
        $(job_soll).val(result["soll"]);
        $(job_jobzusatz).val(result["zusatz"]);

        switch (result["auftragsart"])
        {
            case("Normal"):
                $(job_segment).val("pk");
                break;
            case("Großkunde"):
                $(job_segment).val("gk");
                break;
            case("Xtra"):
                $(job_segment).val("xtra");
                break;
            default:
                $(job_segment).val("pk");
                break;
        }
        $(job_segment_label).show();
        $(job_segment).show();

        $(job_group_choose).val(result["gruppe"]);
        if (result["soll"] == 1)
        {
            $(job_start_choose).show();
            $(job_start).show();
        }
        $(job_loading).hide();
        $(job_overview).show();
        $(job_jobzusatz).show();
        $(job_text_jobzusatz).show();
    }
    else
    {
        $(job_loading).hide();
        if (openOverviewOnError)
        {
            $(job_overview).show();
        }
        alert("Fehler " + jobid + " konnte nicht aktualisiert werden!");
    }
}

function createJob(isSlaveRun) {
    if (!isSlaveRun)
    {
        DynamicCreateJob(
                isSlaveRun,
                "#result",
                "#id",
                "#release_main",
                "#tarif",
                "#kopplung",
                "#job_message",
                "#job_antest",
                "#job_antest_choose",
                "#job_segment",
                "#job_loading",
                "#job_jobzusatz",
                "#job_text_jobzusatz",
                "#job_id",
                "#job_ist",
                "#job_soll",
                "#job_group_choose",
                "#job_start_choose",
                "#job_start",
                "#job_overview",
                "#mapid");
    }
    else
    {
        DynamicCreateJob(
                isSlaveRun,
                "#result_slave",
                "#id",
                "#release_main",
                "#tarif_second",
                "#kopplung",
                "#job_slave_message",
                "#job_slave_antest",
                "#job_slave_antest_choose",
                "#job_slave_segment",
                "#job_slave_loading",
                "#job_slave_jobzusatz",
                "#job_slave_text_jobzusatz",
                "#job_slave_id",
                "#job_slave_ist",
                "#job_slave_soll",
                "#job_slave_group_choose",
                "#job_slave_start_choose",
                "#job_slave_start",
                "#job_slave_overview",
                "#mapid_second");
    }
}

function DynamicCreateJob(
        isSlaveRun,
        jobzusatz,
        reqid,
        release_main,
        tarif,
        kopplung,
        job_message,
        job_antest,
        job_antest_choose,
        job_segment,
        job_loading,
        job_jobzusatz,
        job_text_jobzusatz,
        job_id,
        job_ist,
        job_soll,
        job_group_choose,
        job_start_choose,
        job_start,
        job_overview,
        mapidfield) {
    $(job_message).html("");
    $(job_antest).hide();
    $(job_antest_choose).hide();
    $(job_segment).attr("disabled", true);
    $(job_loading).show();

    $(job_jobzusatz).hide();
    $(job_text_jobzusatz).hide();

    var mapid;

    if (trim($(mapidfield).val()) != "")
    {
        mapid = trim($(mapidfield).val());
    }
    else
    {

        mapid = getPredefinedMapID($(tarif).val(), $(kopplung).val(), isSlaveRun)
    }

    if (mapid == "" || mapid == null)
    {
        alert("Bitte Mapid angeben!");
    }
    else
    {
        var result = $.parseJSON(
                AJAX_CreateJob(
                        $(job_segment).val(),
                        $(jobzusatz).val(),
                        mapid,
                        $(job_antest_choose).val(),
                        $(reqid).val(),
                        $(release_main).val(),
                        isSlaveRun
                        ));

        $(job_id).text(result["id"]);
        $(job_ist).val(result["ist"]);
        $(job_soll).val(result["soll"]);
        $(job_group_choose).val(result["group"]);
        $(job_message).html(result["message"]);
        $(job_jobzusatz).val(result["zusatz"]);
        $(job_loading).hide();
        $(job_start_choose).show();
        $(job_start).show();
        $(job_overview).show();
        $(job_jobzusatz).show();
        $(job_text_jobzusatz).show();
    }
}

function startJob(isSlaveRun) {
    var anzahl = parseFloat($("#anzahl").val());
    var tmpadd = parseInt(anzahl * add_percentage);
    if (tmpadd < add_min)
    {
        anzahl += add_min;
    }
    else
    {
        if (tmpadd > add_max)
        {
            anzahl += add_max;
        }
        else
        {
            anzahl += tmpadd;
        }
    }
    if (!isSlaveRun)
    {
        UpdateJob(
                $("#job_id").text(),
                $("#job_ist").val(),
                anzahl,
                $("#job_start_choose").val(),
                $('#job_jobzusatz').val(), isSlaveRun
                );
    }
    else {
        UpdateJob(
                $("#job_slave_id").text(),
                $("#job_slave_ist").val(),
                anzahl,
                $("#job_slave_start_choose").val(),
                $('#job_slave_jobzusatz').val(), isSlaveRun
                );
    }

}

function DeleteJob(jobid, tdbid, isSlaveRun)
{
    if (!isSlaveRun)
    {
        DynamicDeleteJob(
                jobid,
                tdbid,
                isSlaveRun,
                "#job_message",
                "#job_overview",
                "#job_loading",
                "#job_start_choose",
                "#job_start",
                "#job_segment",
                "#job_segment_label",
                "#job_jobzusatz",
                "#job_text_jobzusatz");
    }
    else
    {
        DynamicDeleteJob(
                jobid,
                tdbid,
                isSlaveRun,
                "#job_slave_message",
                "#job_slave_overview",
                "#job_slave_loading",
                "#job_slave_start_choose",
                "#job_slave_start",
                "#job_slave_segment",
                "#job_slave_segment_label",
                "#job_slave_jobzusatz",
                "#job_slave_text_jobzusatz");
    }
}

function DynamicDeleteJob(
        jobid,
        tdbid,
        isSlaveRun,
        job_message,
        job_overview,
        job_loading,
        job_start_choose,
        job_start,
        job_segment,
        job_segment_label,
        job_jobzusatz,
        job_text_jobzusatz)
{
    $(job_message).html("");
    $(job_overview).hide();
    $(job_loading).show();
    $(job_start_choose).hide();
    $(job_start).hide();
    $(job_segment).hide();
    $(job_segment_label).hide();
    $(job_jobzusatz).hide();
    $(job_text_jobzusatz).hide();

    // AJAX Call
    var result = $.parseJSON(
            AJAX_DeleteJob(
                    jobid,
                    tdbid,
                    isSlaveRun
                    ));
    if (result["success"] == true)
    {
        loadJobControl(null, isSlaveRun);
    }
    else
    {
        refreshJob(jobid, true, isSlaveRun);
    }
    $(job_message).html(result["message"]);
}

function UpdateJob(jobid, ist, soll, group, zusatz, isSlaveRun)
{
    if (!isSlaveRun)
    {
        DynamicUpdateJob(
                jobid,
                ist,
                soll,
                group,
                zusatz,
                isSlaveRun,
                "#job_message",
                "#job_overview",
                "#job_loading",
                "#job_start_choose",
                "#job_start",
                "#job_segment",
                "#job_segment_label",
                "#job_jobzusatz",
                "#job_text_jobzusatz",
                "#job_id",
                "#job_ist",
                "#job_soll",
                "#job_group_choose"
                );
    }
    else
    {
        DynamicUpdateJob(
                jobid,
                ist,
                soll,
                group,
                zusatz,
                isSlaveRun,
                "#job_slave_message",
                "#job_slave_overview",
                "#job_slave_loading",
                "#job_slave_start_choose",
                "#job_slave_start",
                "#job_slave_segment",
                "#job_slave_segment_label",
                "#job_slave_jobzusatz",
                "#job_slave_text_jobzusatz",
                "#job_slave_id",
                "#job_slave_ist",
                "#job_slave_soll",
                "#job_slave_group_choose"
                );
    }
}

function DynamicUpdateJob(
        jobid,
        ist,
        soll,
        group,
        zusatz,
        isSlaveRun,
        job_message,
        job_overview,
        job_loading,
        job_start_choose,
        job_start,
        job_segment,
        job_segment_label,
        job_jobzusatz,
        job_text_jobzusatz,
        job_id,
        job_ist,
        job_soll,
        job_group_choose
        )
{
    $(job_message).html("");
    $(job_overview).hide();
    $(job_loading).show();
    $(job_start_choose).hide();
    $(job_start).hide();
    $(job_segment).hide();
    $(job_segment_label).hide();
    $(job_jobzusatz).hide();
    $(job_text_jobzusatz).hide();

    // AJAX Call
    var result = $.parseJSON(
            AJAX_UpdateJob(
                    jobid,
                    ist,
                    soll,
                    group,
                    zusatz
                    ));
    if (result["success"] == true)
    {
        $(job_id).text(result["id"]);
        $(job_ist).val(result["ist"]);
        $(job_soll).val(result["soll"]);
        $(job_group_choose).val(result["gruppe"]);
        $(job_jobzusatz).val(result["zusatz"]);

        $(job_loading).hide();
        $(job_overview).show();
        $(job_segment).show();
        $(job_segment_label).show();
        $(job_jobzusatz).show();
        $(job_text_jobzusatz).show();

        if (result["soll"] == "1")
        {
            $(job_start_choose).show();
            $(job_start).show();
        }
    }
    else
    {
        refreshJob($(job_id).text(), true, isSlaveRun);
    }
    $(job_message).html(result["message"]);
}

// (Ajax call)A ausgeben
function AJAX_GetJobStatus(jobid)
{
    return $.ajax({
        url: "Library/Addons/JobHandler/GetJobStatus.php",
        type: "POST",
        async: false,
        cache: false,
        data: {
            "id": jobid
        },
        datatype: "json"
    }).responseText;

}


// (Ajax call)A ausgeben
function AJAX_DeleteJob(jobid, tdbid, isSlaveRun)
{
    return $.ajax({
        url: "Library/Addons/JobHandler/DeleteJob.php",
        type: "POST",
        async: false,
        cache: false,
        data: {
            "id": jobid,
            "tdbid": tdbid,
            "isSlaveRun": isSlaveRun
        },
        datatype: "json"
    }).responseText;

}


// (Ajax call)A ausgeben
function AJAX_UpdateJob(jobid, ist, soll, group, zusatz)
{
    return $.ajax({
        url: "Library/Addons/JobHandler/UpdateJob.php",
        type: "POST",
        async: false,
        cache: false,
        data: {
            "id": jobid,
            "ist": ist,
            "soll": soll,
            "group": group,
            "zusatz": zusatz
        },
        datatype: "json"
    }).responseText;

}


// (Ajax call)A ausgeben
function AJAX_CreateJob(segment, tdbstring, mapid, group, tdbid, release, isSlaveRun)
{
    var test = $.ajax({
        url: "Library/Addons/JobHandler/CreateJob.php",
        type: "POST",
        async: false,
        cache: false,
        data: {
            "segment": segment,
            "tdbstring": tdbstring,
            "mapid": mapid,
            "group": group,
            "tdbid": tdbid,
            "release": release,
            "isSlaveRun": isSlaveRun
        },
        datatype: "json"
    }).responseText;
    return test;
}

function getRequiredCardCount()
{
    var amount = $('#anzahl').val() * $('#karten').val();
    switch($('#kopplung').val())
    {
        case "twincard":
            amount *= 2;
            break;
        case "combicard":
            amount *= 2;
            break;
        case "multisim":
            amount *= 3;
            break;
    }
    return amount;
}

function checkRunnable()
{
    var cardcount = checkAmountOfCards($('#release_main').val(),
                    $('#hlr').val(),
                    $('#kartentyp').val(),
                    $('#kopplung').val(),
                    $('#iai').val(),
                    $('#tarif').val())["cardcount"];
    $("#checkrun_result").text("Anzahl Karten: " + cardcount + " / " + getRequiredCardCount());
                    
}

// STDVGR hinzufügen!
function checkAmountOfCards(release, hlr, kartentyp, kopplung, iai, tarif)
{
    var stdvgr = getLookupValue(Tarif, "stdvgr", tarif);
    if (iai == "standard")
    {
        if (stdvgr == "POSTPAID") {
            iai = "00001";
        }
        else
        {
            iai = "40002";
        }
    }
    var twinbill = "false";
    if (kopplung == "twinbill" || kopplung == "tbpro")
    {
        twinbill = "true";
    }
    var result = $.parseJSON(AJAX_GetCardCount(release, hlr, iai, twinbill, kartentyp, stdvgr));
    return result;
}

// (Ajax call) gives number of available cards for given parameters
function AJAX_GetCardCount(release, hlr, iai, twinbill, cardtype, stdvgr)
{
    var test = $.ajax({
        url: "Library/Addons/JobHandler/GetCardCount.php",
        type: "POST",
        async: false,
        cache: false,
        data: {
            "release": release,
            "hlr": hlr,
            "iai": iai,
            "twinbill": twinbill,
            "cardtype": cardtype,
            "provider": "DETEM",
            "stdvgr": stdvgr
        },
        datatype: "json"
    }).responseText;
    return test;
}
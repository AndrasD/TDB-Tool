$(document).ready(function(){
    fillRelease_main();
    Anforderungen  = $.parseJSON(AJAX_GetAnforderungen($('#release_main').val()));
    fillHLR();
    fillKartentyp();
    fillBankverbindung();
    fillRechnungsart();
    fillRechnungsempfaenger();
    fillLaufzeit();
    fillKopplung();
    fillRechnungsmedium();
    fillIAI();
    fillTeilprojekt();
    fillStatus();
    fillAnsprechpartner();
    fillAnforderer();
    fillTarif();
    order_fillHLR();
    order_fillStandardVertragsGruppe();
    fillProvider();
    
    fillTable();
    
    $('#release').text($('#release_main option:selected').text());
    $('#order_release').text($('#release_main option:selected').text());

    $('#release_main').change(function() {
        $('#release').text($('#release_main option:selected').text());
        $('#order_release').text($('#release_main option:selected').text());
        fillHLR();
        order_fillHLR();
        reloadTable($('#release_main').val());
        $( "#dialog" ).dialog( "close" );
    });
    
    
    $('input, select').change(function() {
        ApplyTDBString();
    });
    $('input, select').keyup(function() {
        ApplyTDBString();
    });
    $('#tarif').change(function() {
        updateDefaultMapID($('#tarif').val(), null);
        
        // Wenn bei Auswahl eines GK Tarifes kein RV angegeben wird,
        // wird aus dem aktuellem Release automatisch ein RV-Wert generiert
        // und eingetragen.
        if($("#tarif").val().toLowerCase().indexOf("busi") != -1)
        {
            if($("#rv").val() == "")
            {
                $("#rv").val("T" + getLookupValue(Releases,'id', $("#release_main").val()) + "1"); 
            }
        }
        checkHLR_for_Xtra($("#hlr").val(),$("#tarif").val());
    
    });
    $('#hlr').change(function() {
        checkHLR_for_Xtra($("#hlr").val(),$("#tarif").val());
    });
    
    $('#mapid').keyup(function() {
        updateDefaultMapID($('#tarif').val(), $('#mapid').val());
    });
    
    $('#mapid_second').keyup(function() {
        updateSecondMapID($('#tarif_second').val(), $('#mapid_second').val());
    });
    
    $('#kopplung').change(function() {
        updateDefaultMapID($('#tarif').val(), null);
        updateSecondMapID($('#tarif_second').val(), $('#mapid_second').val());
        setSecondTariffVisibility();
    });
    
    $('#tarif_second').change(function() {
        //updateDefaultMapID($('#tarif').val(), null);
        updateSecondMapID($('#tarif_second').val(), $('#mapid_second').val());
        //setSecondTariffVisibility();
    });
    
    $('#text_master').hide();
    $('#text_slave').hide();
    $('#result_slave').hide();
    $('#mapid_tariff').hide();
    
    setDialogs()
       
    initiateTPandAnforderer()
        
    initialiseDatepicker()
    
    $( document ).tooltip();
   
    setValidatorSettings()
      
    
    $("#order_dialog").show();
    $("#dialog").show();
    
    if(TDB)
    {
        $("#cookie_button").css( "visibility", "visible" );
        editor_open('#technical_container_table','#technical_container_toggler');
        editor_open('#vertrag_container_table','#vertrag_container_toggler');
        editor_open('#bankverbindung_container_table','#bankverbindung_container_toggler');
        editor_open('#rechnung_container_table','#rechnung_container_toggler');
        initiatejobControl();
    }
    else
    {
        $("#job_container").hide();
    }   
});
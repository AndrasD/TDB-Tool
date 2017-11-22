function saveTPandAnforderer()
{
    choosen_Anforderer = $("#choose_anforderer").val();
    choosen_TP = $("#choose_teilprojekt").val();
    choosen_TP_Text = $("#choose_teilprojekt option:selected").text();
    
    $.cookie('tdb_anforderer', choosen_Anforderer, { expires: 7 });
    $.cookie('tdb_teilprojekt', choosen_TP, { expires: 7 });
    $.cookie('tdb_teilprojekt_text', choosen_TP_Text, { expires: 7 });
    if(!TDB)
    {
        setColFilter("#filter_tp");
    }
    
    $("#choosetp").dialog( "close" );
}

function resetTPandAnforderer()
{
    $.removeCookie('tdb_anforderer');
    $.removeCookie('tdb_teilprojekt');
    $.removeCookie('tdb_teilprojekt_text');
}

function initiateTPandAnforderer()
{
    choosen_Anforderer = $.cookie('tdb_anforderer');
    choosen_TP = $.cookie('tdb_teilprojekt');
    choosen_TP_Text = $.cookie('tdb_teilprojekt_text');
    var tpAutoOpen;
    
    if((typeof choosen_Anforderer != 'undefined') && (typeof choosen_TP != 'undefined') && (typeof choosen_TP_Text != 'undefined'))
    {
        setColFilter("#filter_tp");
        tpAutoOpen = false; 
    }
    else
    {
        tpAutoOpen = true;
    }
    
    if(TDB)
    {
        tpAutoOpen = false; 
    }
    
    $( "#choosetp" ).dialog(
    {
        dialogClass: "no-close",
        autoOpen: tpAutoOpen,          
        height: 380,            
        width: 480

    });
}
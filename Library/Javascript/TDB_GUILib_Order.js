// (GUI) öffnet den Editor-Dialog bei dem die Default-Werte geladen sind.
function order_OpenCleanEditor()
{
    document.getElementById("order_generator").reset();    
    // Blendet nicht benötigte Felder aus
    order_setFormInputStatus("cleaneditor",null,null);
    
//    $("select").each(function() { 
//        setTDBColor(this);
//    });
    
    $( "#order_dialog" ).dialog( "open" );
}


function LoadCardOrder(id)
{       
    
        
        
    // Load Details / öffnen und schließen von ladebildschirm und editor
    $("#order_AJAXMessage").html("Laden ... <img src='./Library/Images/loader.gif' />");
    $( "#order_loading" ).dialog("open"); 
    $( "#order_dialog" ).dialog( "close" );
        
    // AJAX
    var req = $.parseJSON(AJAX_GetDetails_CardOrder(id));
    
    // Set Fields to Values
    $('#order_id').val(req["id"]);
    //    $('#order_release').val(req["release"]);
    $('#order_anforderer').val(req["anforderer"]);
    $('#order_ansprechpartner').val(req["ansprechpartner"]);
    $('#order_anzahl').val(req["anzahl"]);
    $('#order_eingestellt').val(req["eingestellt"]);

    $('#order_wunschtermin').val(req["wunschtermin"]);

    $('#order_fertigstellung').val(req["fertigstellung"]);
    $('#order_bemerkung').val(req["bemerkung"]);
    $('#order_bemerkungintern').val(req["bemerkungintern"]);
    $('#order_standardvertragsgruppe').val(req["standardvertragsgruppe"]);
    $('#order_status').val(req["status"]);
    $('#order_provider').val(req["provider"]);
    $('#order_teilprojekt').val(req["teilprojekt"]);
    
    if(req["twinbill"] == "true")
    {
        $('#order_twinbill').prop('checked', true);
    }
    else
    {
        $('#order_twinbill').prop('checked', false);
    }
    $('#order_hlr').val(req["hlr"]);
    $('#order_kartentyp').val(req["kartentyp"]);
    $('#order_fertig').val(req["fertig"]);
        
    // TDB-String aktualisieren
    ApplyTDBString();
    
    order_setFormInputStatus("editcardorder",req["status"],req["id"])
 
    $( "#order_dialog" ).dialog( "open" );
    $( "#order_loading" ).dialog("close"); 
    
//    $("select").each(function() { 
//        setTDBColor(this);
//    });
    
}


// (GUI) Workflow zum Löschen einer Anforderung
function DeleteCardOrder(id)
{         
    // öffnen und schließen von ladebildschirm und editor
    $( "#order_dialog" ).dialog( "close" );
    $("#order_QuestionMessage").text("Kartenbestellung '" + id + "' wirklich löschen?");
    //$( "#order_question" ).dialog("open"); 
    $( "#order_question" ).dialog({
        buttons: {
            "Ja": function() {
                //<img src='./Library/Images/loader.gif' />
                $( "#order_question" ).dialog({
                    buttons: {}
                });
                $("#order_QuestionMessage").html("Bitte warten... <img src='./Library/Images/loader.gif' />"); 
                // AJAX call
                var response = $.parseJSON(AJAX_DeleteCardOrder(id));
    
                // Auswerten der Antwort
                if(response.success)
                {
                    var rownum = oTable.fnGetPosition( $("#row_" + response.id)[0] );
                    oTable.fnDeleteRow(rownum);
                    $("#order_QuestionMessage").html(response.message); 
                    $( "#order_question" ).dialog({
                        buttons: {
                            "Okay": function() {
                                $( "#order_question" ).dialog("close");
                            }
                        }
                    });      
                }
                else
                {
                    $("#order_QuestionMessage").html(response.message); 
                }             
            },
            "Nein": function() {
                $( "#order_question" ).dialog("close");
                LoadCardOrder(id);               
            }
        }
    });
    $( "#order_question" ).dialog( "open" );
     
}


// liest Felder im Editor aus und gibt diese als JSON-Array zurück
function order_fetchDataFromEditor()
{
    return {
        "id" : $('#order_id').val(),
        //        "release" : $('#order_release').val(),
        "release" : $('#release_main').val(),
        "anforderer" : $('#order_anforderer').val(),
        "ansprechpartner" : $('#order_ansprechpartner').val(),
        "anzahl" :  $('#order_anzahl').val(),
        "kartentyp" :  $('#order_kartentyp').val(),
        "eingestellt" :  $('#order_eingestellt').val(),
        "wunschtermin" :  $('#order_wunschtermin').val(),
        "fertigstellung"  : $('#order_fertigstellung').val(),
        "bemerkung" :  $('#order_bemerkung').val(),
        "bemerkungintern" :  $('#order_bemerkungintern').val(),
        "standardvertragsgruppe" :  $('#order_standardvertragsgruppe').val(),
        "status" :  $('#order_status').val(),
        "teilprojekt" :  $('#order_teilprojekt').val(),
        "hlr" :  $('#order_hlr').val(),
        "provider" :  $('#order_provider').val(),
        "fertig"   : $('#order_fertig').val(),
        "twinbill"   : $('#order_twinbill').prop('checked')
    }
}


// (GUI) Workflow zum Erstellen einer Anforderung
function CreateCardOrder()
{         
    // öffnen und schließen von ladebildschirm und editor
    $("#order_dialog" ).dialog( "close" );
    $("#order_AJAXMessage").html("Kartenbestellung wird erstellt ... <img src='./Library/Images/loader.gif' />");
    $("#order_loading" ).dialog("open"); 
     
    // AJAX call
    var response = $.parseJSON(AJAX_CreateCardOrder());
    
    // Auswerten der Antwort
    if(response.success)
    {
        var ai = oTable.fnAddData( GetRequirementDetailsForDataTable(response.id) );
        var n = oTable.fnSettings().aoData[ ai[0] ].nTr;  
        n.setAttribute('id', 'row_' + response.id);
        $("#order_AJAXMessage").html(response.message); 
        setTimeout(function(){
            $("#order_loading").dialog( "close" );
        }, 5000);
    }
    else
    {
        $("#order_AJAXMessage").html(response.message); 
    }
}


// (GUI) Workflow zum Bearbeiten einer Anforderung
function EditCardOrder(id)
{         
    // öffnen und schließen von ladebildschirm und editor
    $( "#order_dialog" ).dialog( "close" );
    $("#order_AJAXMessage").html("Bitte warten ... <img src='./Library/Images/loader.gif' />");
    $( "#order_loading" ).dialog("open"); 
     
    // AJAX call
    var response = $.parseJSON(AJAX_EditCardOrder(id));
    
    // Auswerten der Antwort
    if(response.success)
    {
        // Update der Zeile in der DataTable
        var rownum = oTable.fnGetPosition( $("#row_" + id)[0] );
        //oTable.fnDeleteRow( rownum );
        oTable.fnUpdate( GetRequirementDetailsForDataTable(id), rownum );
        $("#order_AJAXMessage").html(response.message);
        setTimeout(function(){
            $("#loading").dialog( "close" );
        }, 5000);
    }
    else
    {
        $("#order_AJAXMessage").html(response.message); 
    }
}

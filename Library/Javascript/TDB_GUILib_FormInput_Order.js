function order_setFormInputStatus(area, requirementStatus, requirementId)
{
    switch (area)
    {
        case "cleaneditor":
            editormode = "create";
            $("#order_id_row").hide();
            $("#order_ansprechpartner_row").hide();
            $('#order_release_row').show();
            $('#order_anforderer_row').show();
            $("#order_anzahl_row").show();
            $("#order_eingestellt_row").hide();
            $("#order_wunschtermin_row").show();
            $("#order_fertigstellung_row").hide();
            $("#order_bemerkung_row").show();
            $("#order_fertig_row").hide();
            $("#order_bemerkungintern_row").hide();
            $('#order_tarif_row').show();
            $('#order_status_row').hide();
            $('#order_teilprojekt_row').show();
            $('#order_twinbill_row').show();
            $('#order_provider_row').show();
            
            $('#order_hlr_row').show();
            
            // Falls vorher nicht schon aktiviert werden die DatePicker nun aktiviert         
            $( "#order_eingestellt" ).datepicker("enable");
            $( "#order_wunschtermin" ).datepicker("enable");
            
            $("#order_wunschtermin").val(createDateString(7));
            
            $( "#order_fertigstellung" ).datepicker("enable");
            $( "#order_dialog" ).dialog({
                buttons: {
                    "erstellen": function() {
                        if($("#order_generator").valid()){
                            CreateCardOrder();     
                        }
                        else
                        {
                            alert("Es sind noch nicht alle Felder korrekt ausgefüllt!");
                        }      
                    },
                    "abbrechen": function() {
                        $( "#order_dialog" ).dialog( "close" );        
                    }
                }
            });
                  
//            $('#order_release').attr("disabled", false);
            $('#order_anforderer').attr("disabled", false);
            $('#order_bemerkung').attr("disabled", false);
            $("#order_anzahl").attr("disabled", false);
            $("#order_wunschtermin").attr("disabled", false);
            $('#order_tarif').attr("disabled", false);
            $('#order_provider').attr("disabled", false);
            $('#order_teilprojekt').attr("disabled", false);
            $('#order_hlr').attr("disabled", false);
            
            $("#order_teilprojekt").val(choosen_TP);
            $("#order_anforderer").val(choosen_Anforderer);
            
            break;
            
        case "editcardorder":
            editormode = "edit";
            $("#order_id_row").show();
            $("#order_ansprechpartner_row").show();
            $('#order_release_row').show();
            $('#order_anforderer_row').show();
            $("#order_anzahl_row").show();
            $("#order_eingestellt_row").show();
            $("#order_wunschtermin_row").show();
            $("#order_fertigstellung_row").show();
            $("#order_bemerkung_row").show();
            $("#order_fertig_row").show();
            $("#order_provider_row").show();
            $('#order_standardvertragsgruppe_row').show();
            $('#order_status_row').show();
            $('#order_teilprojekt_row').show();
            $('#order_hlr_row').show();
            $('#order_twinbill_row').show();
           
            $('#order_kartentyp_row').show();
           
            if(TDB)
            {
                $("#order_bemerkungintern_row").show();
            }
            else
            {
                $("#order_bemerkungintern_row").hide();
            }
            $( "#order_eingestellt" ).datepicker("enable");
            $( "#order_wunschtermin" ).datepicker("enable");
            $( "#order_fertigstellung" ).datepicker("enable");
            
            if(TDB || getLookupValue(Status,"editable", requirementStatus) == "true")
            {
                $( "#order_dialog" ).dialog({
                    buttons: {
                        "speichern": function() {
                            EditCardOrder(requirementId);               
                        },
                        "löschen": function() {
                            DeleteCardOrder(requirementId);               
                        },
                        "abbrechen": function() {
                            $( "#order_dialog" ).dialog( "close" );        
                        }
                    }
                });
                $("#order_anforderer").attr("disabled", false);
                $("#order_id").attr("disabled", false);
                $("#order_anzahl").attr("disabled", false);
                $("#order_wunschtermin").attr("disabled", false);
                $("#order_wunschtermin" ).datepicker("enable");
                $("#order_bemerkung").attr("disabled", false);
                $('#order_standardvertragsgruppe').attr("disabled", false);
                $('#order_teilprojekt').attr("disabled", false);
                $('#order_hlr').attr("disabled", false);
                $('#order_twinbill_row').attr("disabled", false);
                $('#order_kartentyp').attr("disabled", false);
                $("#order_provider").attr("disabled", false);
            }
            else
            {
                $( "#order_dialog" ).dialog({
                    buttons: {
                        "abbrechen": function() {
                            $( "#order_dialog" ).dialog( "close" );        
                        }
                    }
                });
                
                $("#order_anforderer").attr("disabled", true);
                $("#order_id").attr("disabled", true);
                $("#order_anzahl").attr("disabled", true);
                $("#order_wunschtermin").attr("disabled", true);
                $("#order_wunschtermin" ).datepicker("disable");
                $("#order_bemerkung").attr("disabled", true);
                $('#order_standardvertragsgruppe').attr("disabled", true);
                $('#order_teilprojekt').attr("disabled", true);
                $('#order_hlr').attr("disabled", true);
                $('#order_kartentyp').attr("disabled", true);
                $('#order_twinbill_row').attr("disabled", true);
                $("#order_provider").attr("disabled", true);
            //$('#order_result_container').attr("disabled", true);
            }
            
            if(!TDB)
            {
                $("#order_ansprechpartner").attr("disabled", true);
//                $('#order_release').attr("disabled", true);
                $("#order_eingestellt").attr("disabled", true);
                $("#order_eingestellt" ).datepicker("disable");
                $('#order_status').attr("disabled", true);
                $("#order_fertig").attr("disabled", true);
                $("#order_fertigstellung").attr("disabled", true);
                $( "#order_fertigstellung" ).datepicker("disable");
                $("#order_bemerkungintern").attr("disabled", true);
                $('#order_twinbill_row').attr("disabled", true);
            }
            else
            {
                $("#order_ansprechpartner").attr("disabled", false);
//                $('#order_release').attr("disabled", false);
                $("#order_eingestellt").attr("disabled", false);
                $( "#order_eingestellt" ).datepicker("enable");     
                $('#order_status').attr("disabled", false);
                $("#order_fertig").attr("disabled", false);
                $("#order_fertigstellung").attr("disabled", false);
                $( "#order_fertigstellung" ).datepicker("enable");
                $("#order_bemerkungintern").attr("disabled", false);
                $('#order_twinbill_row').attr("disabled", false);
            }
            //alert( $("#order_eingestellt").val());
            break;
    } 
}
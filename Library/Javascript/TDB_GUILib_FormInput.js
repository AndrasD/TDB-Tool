function setFormInputStatus(area, requirementStatus, requirementId)
{
    switch (area)
    {
        case "cleaneditor":
            editormode = "create";
            $("#id_row").hide();
            $("#ansprechpartner_row").hide();
            $('#release_row').show();
            $('#anforderer_row').show();
            $("#anzahl_row").show();
            $("#eingestellt_row").hide();
            $("#wunschtermin_row").show();
            $("#fertigstellung_row").hide();
            $("#bemerkung_row").show();
            $("#fertig_row").hide();
            $("#bemerkungintern_row").hide();
            $('#tarif_row').show();
            
            //$('#tarif_second_row').show();
            
            $('#status_row').hide();
            $('#teilprojekt_row').show();
            $('#zusatz_row').hide();
            $('#mapid_row').hide();
            
            $('#mapid_second_row').hide();
            
            $('#bp_row').hide();
            $('#hlr_row').show();
            $('#iai_row').show();
            $('#karten_row').show();
            $('#kartentyp_row').show();
            $('#rollendruck_row').show();
            $('#kopplung_row').show();
            $('#homezone_row').show();
            $('#laufzeit_row').show();
            $('#rv_row').show();
            $('#regulierer_row').show();
            $('#bankverbindung_row').show();
            $('#rea_row').show();
            $('#ra_row').show();
            $('#rmd_row').show();
            $('#result_container').hide();
            
            $('#mapid_tariff').hide();
            //$('#mapid_tariff_second').hide();
            
            $('#organisation_row').show();
            $('#ort_row').show();
            $('#plz_row').show();
            $('#strasse_row').show();
            $('#hausnummer_row').show();
            $('#vorname_row').show();
            $('#nachname_row').show();
            $('#age_row').show();
            $('#vo_row').show();
            
            // Falls vorher nicht schon aktiviert werden die DatePicker nun aktiviert         
            $( "#eingestellt" ).datepicker("enable");
            $( "#wunschtermin" ).datepicker("enable");
            
            
            
            $("#wunschtermin").val(createDateString(7));
            
            $( "#fertigstellung" ).datepicker("enable");
            $( "#dialog" ).dialog({
                buttons: {
                    "erstellen": function() {
                        if($("#generator").valid()){
                            CreateRequirement();       
                        }
                        else
                        {
                            alert("Es sind noch nicht alle Felder korrekt ausgefüllt!");
                        }      
                    },
                    "abbrechen": function() {
                        $( "#dialog" ).dialog( "close" );        
                    }
                }
            });
            
            //            $('#release').attr("disabled", false);
            $('#anforderer').attr("disabled", false);
            $('#bemerkung').attr("disabled", false);
            $("#anzahl").attr("disabled", false);
            $("#wunschtermin").attr("disabled", false);
            $('#tarif').attr("disabled", false);
            $('#teilprojekt').attr("disabled", false);
            $('#hlr').attr("disabled", false);
            $('#iai').attr("disabled", false);
            $('#karten').attr("disabled", false);
            $('#kartentyp').attr("disabled", false);
            $('#rollendruck').attr("disabled", false);
            $('#kopplung').attr("disabled", false);
            $('#homezone').attr("disabled", false);
            $('#laufzeit').attr("disabled", false);
            $('#rv').attr("disabled", false);
            $('#regulierer').attr("disabled", false);
            $('#bankverbindung').attr("disabled", false);
            $('#rea').attr("disabled", false);
            $('#ra').attr("disabled", false);
            $('#rmd').attr("disabled", false);
            
            $('#organisation').attr("disabled", false);
            $('#ort').attr("disabled", false);
            $('#plz').attr("disabled", false);
            $('#strasse').attr("disabled", false);
            $('#hausnummer').attr("disabled", false);
            $('#vorname').attr("disabled", false);
            $('#nachname').attr("disabled", false);
            $('#age').attr("disabled", false);
            $('#vo').attr("disabled", false);
                             
            
            $("#teilprojekt").val(choosen_TP);
            $("#anforderer").val(choosen_Anforderer);
            
            setSecondTariffVisibility();
            
            break;
     
        case "editrequirement":
            editormode = "edit";
            $("#id_row").show();
            $("#ansprechpartner_row").show();
            $('#release_row').show();
            $('#anforderer_row').show();
            $("#anzahl_row").show();
            $("#eingestellt_row").show();
            $("#wunschtermin_row").show();
            $("#fertigstellung_row").show();
            $("#bemerkung_row").show();
            $("#fertig_row").show();
            $('#tarif_row').show();
            
            //$('#tarif_second_row').hide();
            
            $('#status_row').show();
            $('#teilprojekt_row').show();
            $('#hlr_row').show();
            $('#iai_row').show();
            $('#karten_row').show();
            $('#kartentyp_row').show();
            $('#rollendruck_row').show();
            $('#kopplung_row').show();
            $('#homezone_row').show();
            $('#laufzeit_row').show();
            $('#rv_row').show();
            $('#regulierer_row').show();
            $('#bankverbindung_row').show();
            $('#rea_row').show();
            $('#ra_row').show();
            $('#rmd_row').show();
            
            $('#organisation_row').show();
            $('#ort_row').show();
            $('#plz_row').show();
            $('#strasse_row').show();
            $('#hausnummer_row').show();
            $('#vorname_row').show();
            $('#nachname_row').show();
            $('#age_row').show();
            $('#vo_row').show();
            
            if(TDB)
            {
                $("#bemerkungintern_row").show();
                $('#zusatz_row').show();
                $('#bp_row').show();
                $('#result_container').show();
                $('#mapid_row').show();
            }
            else
            {
                $("#bemerkungintern_row").hide();
                $('#zusatz_row').hide();
                $('#bp_row').hide();
                $('#result_container').hide();
                $('#mapid_row').hide();
            }
            $('#mapid_tariff').hide();
            $('#mapid_tariff_second').hide();
            
            $( "#eingestellt" ).datepicker("enable");
            $( "#wunschtermin" ).datepicker("enable");
            $( "#fertigstellung" ).datepicker("enable");
            
            if(TDB || getLookupValue(Status,"editable", requirementStatus) == "true")
            {
                $( "#dialog" ).dialog({
                    buttons: {
                        "speichern": function() {
                            
                            if($("#generator").valid()){
                                EditRequirement(requirementId);  
                            }
                            else
                            {
                                alert("Es sind noch nicht alle Felder korrekt ausgefüllt!");
                            }  
                                          
                        },
                        "löschen": function() {
                            DeleteRequirement(requirementId);               
                        },
                        "abbrechen": function() {
                            $( "#dialog" ).dialog( "close" );        
                        }
                    }
                });
                $("#anforderer").attr("disabled", false);
                $("#id").attr("disabled", false);
                $("#anzahl").attr("disabled", false);
                $("#wunschtermin").attr("disabled", false);
                $( "#wunschtermin" ).datepicker("enable");
                $("#bemerkung").attr("disabled", false);
                $('#tarif').attr("disabled", false);
                $('#teilprojekt').attr("disabled", false);
                $('#hlr').attr("disabled", false);
                $('#iai').attr("disabled", false);
                $('#karten').attr("disabled", false);
                $('#kartentyp').attr("disabled", false);
                $('#rollendruck').attr("disabled", false);
                $('#kopplung').attr("disabled", false);
                $('#homezone').attr("disabled", false);
                $('#laufzeit').attr("disabled", false);
                $('#rv').attr("disabled", false);
                $('#regulierer').attr("disabled", false);
                $('#bankverbindung').attr("disabled", false);
                $('#rea').attr("disabled", false);
                $('#ra').attr("disabled", false);
                $('#rmd').attr("disabled", false);
                $('#organisation').attr("disabled", false);
                $('#ort').attr("disabled", false);
                $('#plz').attr("disabled", false);
                $('#strasse').attr("disabled", false);
                $('#hausnummer').attr("disabled", false);
                $('#vorname').attr("disabled", false);
                $('#nachname').attr("disabled", false);
                $('#age').attr("disabled", false);
                $('#vo').attr("disabled", false);
            }
            else
            {
                $( "#dialog" ).dialog({
                    buttons: {
                        "abbrechen": function() {
                            $( "#dialog" ).dialog( "close" );        
                        }
                    }
                });
        
                $("#anforderer").attr("disabled", true);
                $("#id").attr("disabled", true);
                $("#anzahl").attr("disabled", true);
                $("#wunschtermin").attr("disabled", true);
                $( "#wunschtermin" ).datepicker("disable");
                $("#bemerkung").attr("disabled", true);
                $('#tarif').attr("disabled", true);
                $('#teilprojekt').attr("disabled", true);
                $('#hlr').attr("disabled", true);
                $('#iai').attr("disabled", true);
                $('#karten').attr("disabled", true);
                $('#kartentyp').attr("disabled", true);
                $('#rollendruck').attr("disabled", true);
                $('#kopplung').attr("disabled", true);
                $('#homezone').attr("disabled", true);
                $('#laufzeit').attr("disabled", true);
                $('#rv').attr("disabled", true);
                $('#regulierer').attr("disabled", true);
                $('#bankverbindung').attr("disabled", true);
                $('#rea').attr("disabled", true);
                $('#ra').attr("disabled", true);
                $('#rmd').attr("disabled", true);
                $('#organisation').attr("disabled", true);
                $('#ort').attr("disabled", true);
                $('#plz').attr("disabled", true);
                $('#strasse').attr("disabled", true);
                $('#hausnummer').attr("disabled", true);
                $('#vorname').attr("disabled", true);
                $('#nachname').attr("disabled", true);
                $('#age').attr("disabled", true);
                $('#vo').attr("disabled", true);
            //$('#result_container').attr("disabled", true);
            }
            if(!TDB)
            {
                $("#ansprechpartner").attr("disabled", true);
                //                $('#release').attr("disabled", true);
                $("#eingestellt").attr("disabled", true);
                $( "#eingestellt" ).datepicker("disable");
                $('#bp').attr("disabled", true);
                $('#status').attr("disabled", true);
                $("#fertig").attr("disabled", true);
                $("#fertigstellung").attr("disabled", true);
                $( "#fertigstellung" ).datepicker("disable");
                $('#zusatz').attr("disabled", true);
                $("#bemerkungintern").attr("disabled", true);
                $('#mapid').attr("disabled", true);
            }
            else
            {
                $("#ansprechpartner").attr("disabled", false);
                //                $('#release').attr("disabled", false);
                $("#eingestellt").attr("disabled", false);
                $( "#eingestellt" ).datepicker("enable");
                $('#bp').attr("disabled", false);
                $('#status').attr("disabled", false);
                $("#fertig").attr("disabled", false);
                $("#fertigstellung").attr("disabled", false);
                $( "#fertigstellung" ).datepicker("enable");
                $('#zusatz').attr("disabled", false);
                $("#bemerkungintern").attr("disabled", false);
                $('#mapid').attr("disabled", false);
            }
            //alert( $("#eingestellt").val());
            setSecondTariffVisibility();
            
            break;
      
    } 
}
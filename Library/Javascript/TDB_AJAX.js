// (Ajax call)A ausgeben
function AJAX_GetAnforderungenById(id)
{
    return $.ajax({
        url: "Library/AJAX/GetRequirementsById.php",
        type: "POST",
        async: false,
        cache: false,
        data: {
            "id": id
        },
        datatype: "json"
    }).responseText;
    
}

// (Ajax call)A ausgeben
function AJAX_GetAnforderungen(release)
{
    return $.ajax({
        url: "Library/AJAX/GetRequirements.php",
        type: "POST",
        async: false,
        cache: false,
        data: {
            "release": release
        },
        datatype: "json"
    }).responseText;
    
}

// (Ajax call)A ausgeben
function AJAX_GetProvider()
{
    return $.ajax({
        url: "Library/AJAX/GetProvider.php",
        type: "POST",
        async: false,
        datatype: "json"
    }).responseText;
    
}

// (Ajax call)A ausgeben
function AJAX_GetIAI()
{
    return $.ajax({
        url: "Library/AJAX/GetIAI.php",
        type: "POST",
        async: false,
        datatype: "json"
    }).responseText;
    
}

// (Ajax call)A ausgeben
function AJAX_GetRechnungsmedia()
{
    return $.ajax({
        url: "Library/AJAX/GetRechnungsmedia.php",
        type: "POST",
        async: false,
        datatype: "json"
    }).responseText;
    
}

// (Ajax call)A ausgeben
function AJAX_GetRechnungsarten()
{
    return $.ajax({
        url: "Library/AJAX/GetRechnungsarten.php",
        type: "POST",
        async: false,
        datatype: "json"
    }).responseText;
    
}

// (Ajax call)A ausgeben
function AJAX_GetRechnungsempfaenger()
{
    return $.ajax({
        url: "Library/AJAX/GetRechnungsempfaenger.php",
        type: "POST",
        async: false,
        datatype: "json"
    }).responseText;
    
}

// (Ajax call)A ausgeben
function AJAX_GetBankverbindungen()
{
    return $.ajax({
        url: "Library/AJAX/GetBankverbindung.php",
        type: "POST",
        async: false,
        datatype: "json"
    }).responseText;
    
}

// (Ajax call)A ausgeben
function AJAX_GetKopplungsarten()
{
    return $.ajax({
        url: "Library/AJAX/GetKopplungsarten.php",
        type: "POST",
        async: false,
        datatype: "json"
    }).responseText;
    
}

// (Ajax call)A ausgeben
function AJAX_GetLaufzeit()
{
    return $.ajax({
        url: "Library/AJAX/GetLaufzeit.php",
        type: "POST",
        async: false,
        datatype: "json"
    }).responseText;
    
}

// (Ajax call)A ausgeben
function AJAX_GetKartentyp()
{
    return $.ajax({
        url: "Library/AJAX/GetKartentyp.php",
        type: "POST",
        async: false,
        datatype: "json"
    }).responseText;
    
}

// (Ajax call)A ausgeben
function AJAX_GetSTDVGR()
{
    return $.ajax({
        url: "Library/AJAX/GetSTDVGR.php",
        type: "POST",
        async: false,
        datatype: "json"
    }).responseText;
    
}

// (Ajax call)A ausgeben
function AJAX_GetTariff()
{
    return $.ajax({
        url: "Library/AJAX/GetTariff.php",
        type: "POST",
        async: false,
        datatype: "json"
    }).responseText;
    
}

// (Ajax call)A ausgeben
function AJAX_GetStatus()
{
    return $.ajax({
        url: "Library/AJAX/GetStatus.php",
        type: "POST",
        async: false,
        datatype: "json"
    }).responseText;
    
}

// (Ajax call)A ausgeben
function AJAX_GetTeilprojekt()
{
    return $.ajax({
        url: "Library/AJAX/GetTeilprojekt.php",
        type: "POST",
        async: false,
        datatype: "json"
    }).responseText;
    
}

// (Ajax call)A ausgeben
function AJAX_GetAnsprechpartner()
{
    return $.ajax({
        url: "Library/AJAX/GetAnsprechpartner.php",
        type: "POST",
        async: false,
        datatype: "json"
    }).responseText;
    
}


// (Ajax call)A ausgeben
function AJAX_GetAnforderer()
{
    return $.ajax({
        url: "Library/AJAX/GetAnforderer.php",
        type: "POST",
        async: false,
        datatype: "json"
    }).responseText;
    
}

// (Ajax call)HLR ausgeben
function AJAX_GetHLR()
{
    return $.ajax({
        url: "Library/AJAX/GetHLR.php",
        type: "POST",
        async: false,
        datatype: "json"
    }).responseText;
    
}

// (Ajax call) Releases ausgeben
function AJAX_GetReleases()
{
    return $.ajax({
        url: "Library/AJAX/GetReleases.php",
        type: "POST",
        async: false,
        datatype: "json"
    }).responseText;
    
}

// (Ajax call) Anforderung zu löschen
function AJAX_DeleteRequirement(id)
{
    return $.ajax({
        url: "Library/AJAX/DeleteRequirement.php",
        type: "POST",
        async: false,
        data: {
            "id": id
        },
        datatype: "json"
    }).responseText;
    
}

// (Ajax call) Anforderung zu löschen
function AJAX_DeleteCardOrder(id)
{
    return $.ajax({
        url: "Library/AJAX/DeleteCardOrder.php",
        type: "POST",
        async: false,
        data: {
            "id": id
        },
        datatype: "json"
    }).responseText;
    
}

// (Ajax call) Erstellt eine neue Anforderungen anhand der Daten im Editor
function AJAX_CreateRequirement()
{
    var details = fetchDataFromEditor();
    
    return $.ajax({
        url: "Library/AJAX/CreateRequirement.php",
        type: "POST",
        async: false,
        data: details,
        datatype: "json"
    }).responseText;
    
}

// (Ajax call) Erstellt eine neue Anforderungen anhand der Daten im Editor
function AJAX_CreateCardOrder()
{
    var details = order_fetchDataFromEditor();
    
    return $.ajax({
        url: "Library/AJAX/CreateCardOrder.php",
        type: "POST",
        async: false,
        data: details,
        datatype: "json"
    }).responseText;
    
}

// (AJAX-Call) Übergibt die Daten einer Anforderung als Array 
function AJAX_GetDetails(id)
{
    return $.ajax({
        url: "Library/AJAX/GetRequirementDetails.php",
        type: "POST",
        async: false,
        data: {
            "id": id
        },
        datatype: "json"
    }).responseText;
   
}

// (AJAX-Call) Übergibt die Daten einer Anforderung als Array 
function AJAX_GetDetails_CardOrder(id)
{
    return $.ajax({
        url: "Library/AJAX/GetCardOrderDetails.php",
        type: "POST",
        async: false,
        data: {
            "id": id
        },
        datatype: "json"
    }).responseText;
   
}



// (Ajax call) Anforderung zu bearbeiten, verwendet Daten aus TDB Editor
function AJAX_EditRequirement(id)
{
    var details = fetchDataFromEditor();
    if(id == details.id)
    {
        return $.ajax({
            url: "Library/AJAX/EditRequirement.php",
            type: "POST",
            async: false,
            data: details,
            datatype: "json"
        }).responseText;
    }
    else
    {
        return null;
    }
}


// (Ajax call) Anforderung zu bearbeiten, verwendet Daten aus TDB Editor
function AJAX_EditCardOrder(id)
{
    var details = order_fetchDataFromEditor();
    if(id == details.id)
    {
        return $.ajax({
            url: "Library/AJAX/EditCardOrder.php",
            type: "POST",
            async: false,
            data: details,
            datatype: "json"
        }).responseText;
    }
    else
    {
        return null;
    }
}


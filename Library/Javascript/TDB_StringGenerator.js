

function getStandardQTPValue(array)
{
    for(var counter = 0; array.length > counter; counter++)
    {
        if(array[counter]["standard"] == "true")
        {
            return array[counter]["value"];
        }
    }
    return "";
}

function getQTPValue(array, value)
{
    for(var counter = 0; array.length > counter; counter++)
    {
        if(array[counter]["value"] == value)
        {
            return array[counter]["qtpvalue"];
        }
    }
    return "";
}

function generateTDBString()
{
    var returnarray = ["",""];
    var tdbstring = "";
    tdbstring += "ZUSATZ=\""+$("#zusatz").val() + "\"";
    tdbstring += ";HLR="+$("#hlr").val();
    if($("#bp").is(':checked'))
    {
        tdbstring += ";BP=yes";
    }
    if($("#karten").val() != "1"){
        tdbstring += ";KARTEN="+$("#karten").val();
    }
    if($("#kartentyp").val() != getStandardQTPValue(Kartentypen)){
        tdbstring += ";"+getQTPValue(Kartentypen,$("#kartentyp").val());
    }
    if($("#rollendruck").is(':checked'))
    {
        tdbstring += ";RD=30";
    }
    if($("#homezone").is(':checked'))
    {
        tdbstring += ";HZ=yes";
    }
    if($("#laufzeit").val() != getStandardQTPValue(Laufzeiten)){
        tdbstring += ";" + getQTPValue(Laufzeiten,$("#laufzeit").val());
    }
    if($("#rv").val() != ""){
        tdbstring += ";RV=\""+$("#rv").val()+"\"";
    }
    if($("#regulierer").is(':checked'))
    {
        tdbstring += ";REG=yes";
    }
    if($("#bankverbindung").val() != getStandardQTPValue(Bankverbindungen)){
        tdbstring += ";" + getQTPValue(Bankverbindungen,$("#bankverbindung").val());
    }
    if($("#iai").val() != getStandardQTPValue(IAI)){
        tdbstring += ";" + getQTPValue(IAI,$("#iai").val());
    }
    if($("#ra").val() != getStandardQTPValue(Rechnungsarten)){
        tdbstring += ";" + getQTPValue(Rechnungsarten,$("#ra").val());
    }
    
    if($("#rea").val() != getStandardQTPValue(Rechnungsempfaenger)){
        tdbstring += ";" + getQTPValue(Rechnungsempfaenger,$("#rea").val());
    }
    
    if($("#rmd").val() != getStandardQTPValue(Rechnungsmedia)){
        tdbstring += ";" + getQTPValue(Rechnungsmedia,$("#rmd").val());
    }
    
    
    if($("#organisation").is(':checked'))
    {
        tdbstring += ";ORG=yes";
    }
    if($("#nachname").val() != ""){
        tdbstring += ";NAM=\""+$("#nachname").val()+"\"";
    }
    if($("#plz").val() != ""){
        tdbstring += ";PLZ=\""+$("#plz").val()+"\"";
    }
    if($("#strasse").val() != ""){
        tdbstring += ";ST=\""+$("#strasse").val()+"\"";
    }
    if($("#hausnummer").val() != ""){
        tdbstring += ";STN=\""+$("#hausnummer").val()+"\"";
    }
    if($("#ort").val() != ""){
        tdbstring += ";LOC=\""+$("#ort").val()+"\"";
    }
    if($("#age").val() != ""){
        tdbstring += ";age=\""+$("#age").val()+"\"";
    }
    if($("#vorname").val() != ""){
        tdbstring += ";VNA=\""+$("#vorname").val()+"\"";
    }
    if($("#vo").val() != ""){
        tdbstring += ";VO=\""+$("#vo").val()+"\"";
    }
    
    switch($("#kopplung").val())
    {
        case("tbpro"):
            returnarray[0] = tdbstring + ";BP=yes";
            returnarray[1] = tdbstring + ";BP=yes";
            break;
    
        case("combicard"):
            returnarray[0] = tdbstring + ";CM=yes";
            returnarray[1] = tdbstring + ";CS=yes";
        break;
            
        case("twincard"):
            returnarray[0] = tdbstring + ";BP=yes";
        break;
            
        case("multisim"):
            returnarray[0] = tdbstring + ";BP=yes";
        break;
        
        case("twinbill"):
            returnarray[0] = tdbstring + ";BP=yes";
        break;

        default:
            returnarray[0] = tdbstring;
    }
    
    return returnarray;
}

function ApplyTDBString()
{
    var tdbarray = generateTDBString();
    $("#result").text(tdbarray[0]);
    if(tdbarray[1] != "")
    {
        $('#text_master').show();
        $('#text_slave').show();
        $('#result_slave').show();
        $('#result_slave').text(tdbarray[1]);
    }
    else
    {    
        $('#text_master').hide();
        $('#text_slave').hide();
        $('#result_slave').hide();
    }
}


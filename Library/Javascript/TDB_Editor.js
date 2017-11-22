/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function editor_toggle(id_fieldset, id_button)
{
    if($(id_button).attr("src") == "Library/Images/plus.gif")
    {
        $(id_button).attr("src","Library/Images/minus.gif");
        $(id_fieldset).show();
    }
    else
    {
        $(id_button).attr("src","Library/Images/plus.gif");
        $(id_fieldset).hide(); 
    }
}

function editor_open(id_fieldset, id_button)
{
        $(id_button).attr("src","Library/Images/minus.gif");
        $(id_fieldset).show();
}

function addDays(theDate, days) {
    return new Date(theDate.getTime() + days*24*60*60*1000);
}

function createDateString(adddays)
{
    var tmpdate = addDays(new Date(), adddays);
    
    var dd = tmpdate.getDate();
    var mm = tmpdate.getMonth() + 1;
    var y = tmpdate.getFullYear();

    if(dd < 10)
    {
        dd = '0' + dd;
    }
        
    if(mm < 10)
    {
        mm = '0' + mm;
    }

    return dd + '.'+ mm + '.'+ y;
}


function setValidatorSettings()
{
    jQuery.validator.setDefaults({
        success: "valid"
    });
    
    $.validator.addMethod(
        "tdbcomment",
        function(value, element) {     
            if(value.length > 500)
            {
                return false;
            }
            return true;
        
        },
        "Der Kommentar ist zu lang, bitte kürzen."
        );
    
   
    $.validator.addMethod(
        "tdbdate",
        function(value, element) {     
            var matches = /^(\d{2})[-\.](\d{2})[-\.](\d{4})$/.exec(value);
            if (matches == null) return false;
            var d = matches[1];
            var m = matches[2]-1;
            var y = matches[3];
            var composedDate = new Date(y, m, d);
            return composedDate.getDate() == d &&
            composedDate.getMonth() == m &&
            composedDate.getFullYear() == y;
        
        },
        "Datumsformat (dd.mm.yyyy) nicht korrekt."
        );
    
    $.validator.addMethod(
        "tdbnumber",
        function(value, element) {     
            var matches = /^\d+$/.exec(value);
            if (matches == null) 
            {
                return false;
            }
            if(value == 0)
            {
                return false;
            }
            return true;
        },
        "Bitte eine valide Nummer eingeben."
        );
    
    $.validator.addMethod(
        "wunschtermindate",
        function(value, element) {     
            var matches = /^(\d{2})[-\.](\d{2})[-\.](\d{4})$/.exec(value);
            if (matches == null) return false;
            var d = matches[1];
            var m = matches[2]-1;
            var y = matches[3];
            var composedDate = new Date(y, m, d);
            var today = new Date();
            if((today > composedDate) && editormode == "create")
            {
                return false;
            }
            return composedDate.getDate() == d &&
            composedDate.getMonth() == m &&
            composedDate.getFullYear() == y;
        
        },
        "Wunschtermin muss in der Zukunft liegen."
        );
   
    $( "#generator" ).validate({
        rules: {
            anzahl: {
                required: true,
                tdbnumber: true
            },
            karten: {
                required: true,
                tdbnumber: true
            },
            wunschtermin: {
                required: true,
                tdbdate: true,
                wunschtermindate: true
                
            },
            bemerkung: {
                tdbcomment: true
            },
            bemerkungintern: {
                tdbcomment: true
            }
        }
    });
    
    $( "#order_generator" ).validate({
        rules: {
            order_anzahl: {
                required: true,
                number: true
            },
            order_wunschtermin: {
                required: true,
                tdbdate: true,
                wunschtermindate: true 
            },
            order_bemerkung: {
                tdbcomment: true
            },
            order_bemerkungintern: {
                tdbcomment: true
            }
        }
    });
    
    $( "#wunschtermin" ).change(
        function() {
            $( "#wunschtermin" ).valid()
        }
        );
        
    $( "#order_wunschtermin" ).change(
        function() {
            $( "#order_wunschtermin" ).valid()
        }
        ); 
}


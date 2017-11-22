function initialiseDatepicker(){
    $( "#eingestellt" ).datepicker();
    $( "#eingestellt" ).datepicker( "option", "dateFormat", dateformat );
    $( "#wunschtermin" ).datepicker();
    $( "#wunschtermin" ).datepicker( "option", "dateFormat", dateformat );
    $( "#fertigstellung" ).datepicker();
    $( "#fertigstellung" ).datepicker( "option", "dateFormat", dateformat );
    
    
    $( "#order_eingestellt" ).datepicker();
    $( "#order_eingestellt" ).datepicker( "option", "dateFormat", dateformat );
    
    $( "#order_wunschtermin" ).datepicker();
    $( "#order_wunschtermin" ).datepicker( "option", "dateFormat", dateformat );
    
    $( "#order_fertigstellung" ).datepicker();
    $( "#order_fertigstellung" ).datepicker( "option", "dateFormat", dateformat );
    
}


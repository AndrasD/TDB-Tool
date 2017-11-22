function setDialogs()
{
    $( "#dialog" ).dialog(
    {   
        autoOpen: false,          
        height: 900,            
        width: 950     
    }
    ); 
    
    // Erstelle jQuery Dialog für die Statusbox
    $( "#loading" ).dialog(
    {   
        autoOpen: false,          
        height: 200,            
        width: 400

    }); 
    
    $( "#question" ).dialog(
    {   
        autoOpen: false,          
        height: 200,            
        width: 400

    });
    
    $( "#order_dialog" ).dialog(
    {   
        autoOpen: false,          
        height: 800,            
        width: 1200     
    }
    ); 
    
    // Erstelle jQuery Dialog für die Statusbox
    $( "#order_loading" ).dialog(
    {   
        autoOpen: false,          
        height: 200,            
        width: 400

    }); 
    
    $( "#order_question" ).dialog(
    {   
        autoOpen: false,          
        height: 200,            
        width: 400

    });
}
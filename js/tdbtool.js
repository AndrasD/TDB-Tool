$(document).ready(function() {
    $('#example').DataTable( {

        fixedHeader: {
            header: false,
            footer: false
        },
        paging: true,
        scrollY: 1000,
        dom: "<'row'<'col-sm-6'l><'col-sm-6'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        "searching": true,
        buttons: [
            'colvis'
        ]
        
    } );
} 
);

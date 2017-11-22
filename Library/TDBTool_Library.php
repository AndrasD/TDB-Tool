<?php

include("Includes/TDB_Helper.php");

// returns all script and css files needed for jQuery DataTable usage
// Johannes Nitschmann (03.08.2012)
function getDataTableScripts() {
    return "       
        <link rel='stylesheet' href='css/CSSReset.css'>
        <link rel='stylesheet' href='css/t-table.css'>
	<link rel='stylesheet' href='jquery/DataTables/media/css/ColVis.css'>	
	<link rel='stylesheet' href='jquery/DataTables/media/css/ColReorder.css'>			
			
	<!--<script type='text/javascript' src='jquery/DataTables/media/js/jquery.js'></script>--> 
	<script class='jsbin' src='jquery/DataTables/media/js/jquery.dataTables.js'></script>
	<script type='text/javascript' src='jquery/DataTables/media/js/ColVis.js'></script>
	<script type='text/javascript' src='jquery/DataTables/media/js/ColReorder.js'></script>
        <script type='text/javascript' src='jquery/DataTables/EuroDateSort.js'></script>
	";
}

// Creates JS Script for a DataTable
// TableName - Id of the Html table to append script on
// sDom - The DataTables sDom paramater
// UseColumnFilter - if true: Columnfilter functionality will be added 
//                              (a second row with inputs in thead neccesary)
// Parameters - Addidional parameters for the DataTable stored into an array
// Johannes Nitschmann (07.08.2012)
function CreateDataTableJS($TableName, $sDom, $UseColumnFilter, $Parameters) {
    $output = ' 
                <script type=  "text/javascript">
                var oTable;
                    $(document).ready(function() {
                        
              ';

    if ($UseColumnFilter == true) {
        $output .= '
                    $("thead input").keyup( function () {
                        oTable.fnFilter( this.value, oTable.oApi._fnVisibleToColumnIndex( 
                        oTable.fnSettings(), $("thead input").index(this) ) );
                    } );

                    $("thead input").each( function (i) {
                        this.initVal = this.value;
                    } );

                    $("thead input").focus( function () {
                        if ( this.className == "search_init" )
                        {
                            this.className = "";
                            this.value = "";
                        }
                    } );

                    $("thead input").blur( function (i) {
                        if ( this.value == "" )
                        {
                            this.className = "search_init";
                            this.value = this.initVal;
                        }
                    } );';
    }


    $output .= '
                    oTable = $("' . $TableName . '").dataTable( {
                        "sDom": "' . $sDom . '"';

    // adding parameters to DataTable    
    foreach ($Parameters as $Param) {
        $output .= "," . $Param;
    }
    unset($Param);
    $output .= '
                        } );
                    } );
                </script>
        ';
    return $output;
}

function CreateSelectList($Name, $Values, $SelectedValue, $HtmlAttributes) {
    $output = '<select name="' . $Name . '" id="' . $Name . '"';

    // Adding additional HTML attributes to select tag
    if (!is_null($HtmlAttributes)) {
        foreach ($HtmlAttributes as $Param) {
            $output .= " " . $Param;
        }
        unset($Param);
    }
    $output .= '>';

    // Adding selectable options
    foreach ($Values as $Param) {
        $output .= '<option value="' . $Param["VALUE"] . '"';
        if ($Param["VALUE"] == $SelectedValue) {
            $output .= " selected";
        }
        $output .= '>' . $Param["TEXT"] . '</option>';
    }
    unset($Param);

    $output .= "</select>";

    return $output;
}

function CreateArrayFromSQL($DBConnection, $SqlStatement) {
    $array = array();
    $row = "";
    $stmt = OCIParse($DBConnection, $SqlStatement);
    OCIExecute($stmt);
    while (OCIFetchInto($stmt, $row, OCI_ASSOC)) {
        array_push($array, $row);
    }
    return $array;
}

//
//function CreateSelectListArray($DBConnection, $SqlStatement, $AdditionalValues)
//{
//    $array = array();
//    foreach ($AdditionalValues as $value) {
//        array_push($array, $value);
//    }
//    unset($value);
//    foreach (Create2DArrayFromSQL($DBConnection, $SqlStatement) as $value) {
//        array_push($array, $value[0]);
//    }
//    unset($value);
//    return $array;
//}
?>

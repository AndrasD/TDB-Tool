<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
// start a new session
session_start();

// Including necessary files
//include 'Includes/config.php';
// Including neccessary php-files
// jQuery DataTables
include ('Library/TDBTool_Library.php');
// DataBase Connections
//include ("userpw.incl.php");
//// TDB Functions
//include_once ("TDB_Help_Funktionen.incl.php");
//// TDB Functions
//include_once ("TDB_Help_Funktionen.incl.php");
?>
<html>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <meta http-equiv="X-UA-Compatible" content="IE=100" >
    <head>
        <title>Testdatenbereitstellung</title>
        <link rel="stylesheet" href="jquery/ui/themes/base/jquery-ui.css" />
        <link rel="stylesheet" href="css/validator.css" />
        <link rel="stylesheet" href="css/buttons.css" />
        <link rel="stylesheet" href="css/jqueryui_addons.css" />

        <!-- Bootstrap -->
        <link rel="stylesheet" href="css/bootstrap.min.css" >

        <!-- Font Awesome -->
        <link href="rel="stylesheet" font-awesome/css/font-awesome.min.css" >
        

        <script src="jquery/jquery.js"></script>
        <script src="jquery/ui/jquery-ui.js"></script>   
        <script src="jquery/validation/jquery.validate.js"></script> 
        <script src="jquery/validation/additional-methods.js"></script> 
        <script src="jquery/cookie/jquery.cookie.js"></script>  
        
        <script type="text/javascript">
        var TDB=<?PHP
            $TDB = isset($_GET['TDB']) ? $_GET['TDB'] : "false";
            if ($TDB == "TDB") {
                echo 'true';
                $sDom = "Cfrti";
            } else {
                echo 'false';
                $sDom = "Crti";
            }
            ?>;
        var dateformat = '<?PHP echo $dateformat_js; ?>';
        var editormode = "create";
        </script>

        <?php
        // "CRlfrtip"
        echo getDataTableScripts();
        echo CreateDataTableJS(
            "#example", $sDom, true, array(
            '"oLanguage": {
                            "sSearch": "Suche in allen Spalten:"
                        }',
            '"bSortCellsTop": true',
            //'"sScrollY": "70%"',
            '"sScrollY":  $(window).height() - 200',
            '"bPaginate": false',
            '"deferRender": true',
            '"aoColumnDefs": [
                            { "bVisible": false, "aTargets": [ 12,15 ] }
                        ]'
            , '"bStateSave": false' // false because of known issue with filtering, replacing and sorting
            , '"aoColumns": [
                                null,
                                null,
                                null,
                                null,
                                null,
                                null,
                                null,
                                null,
                                null,
                                null,
                                { "sType": "date-euro"},
                                { "sType": "date-euro"},
                                { "sType": "date-euro"},
                                null,
                                null,
                                null,
                                null,
                                null
                        ]'
            )
        );
        ?>
        
        <script src="Library/Javascript/TDB_DocReady_Datepicker.js"></script>
        <script src="Library/Javascript/TDB_DocReady_Cookie.js"></script>
        <script src="Library/Javascript/TDB_DocReady_Dialog.js"></script>
        <script src="Library/Javascript/TDB_DocReady_Validators.js"></script>
        <script src="Library/Javascript/TDB_js.js"></script>
        <script src="Library/Javascript/TDB_AJAX.js"></script>
        <script src="Library/Javascript/TDB_GUILib.js"></script>
        <script src="Library/Javascript/TDB_GUILib_FormInput.js"></script>
        <script src="Library/Javascript/TDB_GUILib_Order.js"></script>
        <script src="Library/Javascript/TDB_GUILib_FormInput_Order.js"></script>
        <script src="Library/Javascript/TDB_StringGenerator.js"></script>
        <script src="Library/Javascript/TDB_masterdata.js"></script>
        <script src="Library/Javascript/TDB_Editor.js"></script>
		<script src="Library/Javascript/TDB_JobControl.js"></script>
<!--        <script type="text/javascript">
            function toggleTDBMode()
            {
                if(TDB)
                {
                    TDB= false;
                }
                else
                { 
                    TDB = true;
                }
                alert(TDB);
            }
        </script>-->
    </head>

    <body style="height: 100%; margin:0px;">
        <img src='./Library/Images/loader.gif' style="display:none"/>
        <div id="sitecontainer" style="height: 100%;">
            <div id="header" name="header" style="height: 80px;">

                <table border='0' width='98%'>
                    <tr>
                        <td width='70%'><font size='5' color='#FF0080'>Anforderungen an die CARMEN Testdatenbereitstellung</font></td>
                        <td width='20%'>Version: 1.4.1 (15.11.2017)</td>
                        <td width='10%'><!--<a href='#'>Hilfe</a>--></td>
                    </tr>
                </table> 


                <b>Release: </b>
                <select id="release_main">
                </select>
                <a href="#" onclick="OpenCleanEditor()" class="button add" title="Hier kann man eine neue Bestellung von Verträgen erstellen.">Neue Vertragsbestellung</a>
                <a href="#" onclick="order_OpenCleanEditor()" class="button add" title="Hier kann eine neue Bestellung von SIM- bzw. Telekarten erstellt werden.">Neue Kartenbestellung</a>
                <a href="#" onclick="reloadTable($('#release_main').val())" class="button reload" title="Tabelle mit aktuellsten Daten aus der Datenbank erneuern.">Tabelle aktualisieren</a>
                <a href="#" id="cookie_button" style="visibility: hidden;" onclick="resetTPandAnforderer()" class="button delete" title="Cookies löschen">TDB: Cookies löschen</a>
            </div> 
            <table border='1' cellspacing='0' id='example' class='ttable'>
                <thead>
                    <tr>
                        <th>Nr</th>
                        <th>TP</th>
                        <th>Release</th>
                        <th>Anforderer</th>
                        <th>Aktiviert</th>
                        <th>Anzahl</th>
                        <th>RV-Nr</th>
                        <th>Tarif / Std.Vertr.Grp</th>
                        <th>Card-Type</th>
                        <th>Laufzeit</th>
                        <th>Eingestellt</th>
                        <th>Wunschtermin</th>
                        <th>Fertig am</th>
                        <th>Bemerkung</th>
                        <th>TDB-Anspr.</th>
                        <th>Fertig%</th>
                        <th>Status</th>
                        <th>Edit</th>
                    </tr>  
                    <tr>
                        <th><input type='text' name='search_engine' value='Suche...' class='search_init' /></th>
                        <th><input type='text' name='search_engine' value='Suche...' id="filter_tp" class='search_init' /></th>
                        <th><input type='text' name='search_engine' value='Suche...' class='search_init' /></th>
                        <th><input type='text' name='search_engine' value='Suche...' class='search_init' /></th>
                        <th><input type='text' name='search_engine' value='Suche...' class='search_init' /></th>
                        <th><input type='text' name='search_engine' value='Suche...' class='search_init' /></th>
                        <th><input type='text' name='search_engine' value='Suche...' class='search_init' /></th>
                        <th><input type='text' name='search_engine' value='Suche...' class='search_init' /></th>
                        <th><input type='text' name='search_engine' value='Suche...' class='search_init' /></th>
                        <th><input type='text' name='search_engine' value='Suche...' class='search_init' /></th>
                        <th><input type='text' name='search_engine' value='Suche...' class='search_init' /></th>
                        <th><input type='text' name='search_engine' value='Suche...' class='search_init' /></th>
                        <th><input type='text' name='search_engine' value='Suche...' class='search_init' /></th>
                        <th><input type='text' name='search_engine' value='Suche...' class='search_init' /></th>
                        <th><input type='text' name='search_engine' value='Suche...' class='search_init' /></th>
                        <th><input type='text' name='search_engine' value='Suche...' class='search_init' /></th>
                        <th><input type='text' name='search_engine' value='Suche...' class='search_init' /></th>
                        <th><input type='text' name='search_engine' value='Suche...' class='search_init' /></th>
                    </tr>
                </thead> 
                <tbody>
                </tbody>
            </table>  
            <?php
            include("Library/Includes/TDB_Editor.php");
            include("Library/Includes/TDB_OrderEditor.php");
            include("Library/Includes/TDB_ChooseTPandAnforderer.php");
            ?>
        </div>

        <!-- Bootstrap -->
        <script src="js/bootstrap.min.js"></script>
        
    </body>
</html>
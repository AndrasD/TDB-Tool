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
        <script src="jquery/jquery-3.2.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>

        <!-- Font Awesome -->
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css" >

        <!-- DataTables -->
        <link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css">
        <script type="text/javascript" charset="utf8" src="DataTables/datatables.min.js"></script>
        <link rel="stylesheet" type="text/css" href="DataTables/DataTables/css/dataTables.bootstrap.min.css">
        <script type="text/javascript" charset="utf8" src="DataTables/DataTables/js/dataTables.bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="DataTables/Scroller/css/scroller.bootstrap.min.css">
        <script type="text/javascript" charset="utf8" src="DataTables/Scroller/js/dataTables.scroller.min.js"></script>
        <link rel="stylesheet" type="text/css" href="DataTables/FixedHeader/css/fixedHeader.bootstrap.min.css">
        <script type="text/javascript" charset="utf8" src="DataTables/FixedHeader/js/dataTables.fixedHeader.min.js"></script>
        <link rel="stylesheet" type="text/css" href="DataTables/Buttons/css/buttons.bootstrap.min.css">
        <script type="text/javascript" charset="utf8" src="DataTables/Buttons/js/buttons.bootstrap.min.js"></script>
        <script type="text/javascript" charset="utf8" src="DataTables/Buttons/js/buttons.colVis.min.js"></script>
        
        <link rel="stylesheet" href="css/tdbtool.css" />

        <script src="jquery/ui/jquery-ui.js"></script>   
        <script src="jquery/validation/jquery.validate.js"></script> 
        <script src="jquery/validation/additional-methods.js"></script> 
        <script src="jquery/cookie/jquery.cookie.js"></script>  

        <script type="text/javascript" charset="utf8" src="js/tdbtool.js"></script>
        
        <script type="text/javascript">
            var TDB=<?php
            $TDB = isset($_GET['TDB']) ? $_GET['TDB'] : "false";

            if ($TDB == "TDB") {
                
                echo 'true';
                
                $sDom = "Cfrti";
                
            }
            else {
                
                echo 'false';
                
                $sDom = "Crti";
                
            }

            ?>;
            var dateformat = '<?php echo $dateformat_js;?>';
            var editormode = "create";
        </script>
        
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

    <body>
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" data-toggle="tooltip" title="Anforderungen an die CARMEN Testdatenbereitstellung. Version: 1.4.1 (15.11.2017)">TDB-Tool</a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                    <li><a href="#" data-toggle="tooltip" title="Hier kann man eine neue Bestellung von Verträgen erstellen."><i class="fa fa-file-text-o"></i>&nbsp; Vertragbestellen</a></li>
                    <li><a href="#" data-toggle="tooltip" title="Hier kann eine neue Bestellung von SIM- bzw. Telekarten erstellt werden."><i class="fa fa-mobile"></i>&nbsp; Kartenbestellen</a></li>
                    <li><a href="#" data-toggle="tooltip" title="Tabelle mit aktuellsten Daten aus der Datenbank erneuern."><i class="fa fa-refresh"></i>&nbsp; Aktualisieren</a></li>
                    <li><a href="#" data-toggle="tooltip" title="Cookies löschen"><i class="fa fa-eraser"></i>&nbsp; Cookies löschen</a></li>
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                    <li><a>Release:</a><li>
                    <li><select class="form-control" id="sel1">
                        <option>17.3</option>
                        <option>18.1</option>
                        <option>18.2</option>
                        </select>
                    </li>
                    <li><a href="#" data-toggle="tooltip" title="Einstellungen"><i class="fa fa-cogs"></i>&nbsp; Einstellungen</a></li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->

            </div>
            <!-- /.container-fluid -->
        </nav>

        <main ui-view class="container-fluid" style="margin-top:60px;">
            <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr bgcolor="#c5c5c5">
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
                </thead>
                <tbody>
                    <tr>
                        <td>22100</td>
                        <td>FS ECARE-PK</td>
                        <td>18.2 A-Line</td>
                        <td>Kothe, Antje</td>
                        <td>Nein</td>
                        <td>1000</td>
                        <td></td>
                        <td>POSTPAID</td>
                        <td>Micro-SIM 1,8V (2FF/3FF)[3]</td>
                        <td></td>
                        <td>06.11.17</td>
                        <td>10.12.17</td>
                        <td>Fertig am</td>
                        <td></td>
                        <td>TDB</td>
                        <td>Fertig%</td>
                        <td>neu</td>
                        <td><button class="btn btn-primary"><span class="fa fa-pencil"></span>&nbsp; Laden</button></td>
                    </tr>
                    <tr>
                        <td>22100</td>
                        <td>FS ECARE-PK</td>
                        <td>18.2 A-Line</td>
                        <td>Kothe, Antje</td>
                        <td>Nein</td>
                        <td>1000</td>
                        <td></td>
                        <td>POSTPAID</td>
                        <td>Micro-SIM 1,8V (2FF/3FF)[3]</td>
                        <td></td>
                        <td>06.11.17</td>
                        <td>10.12.17</td>
                        <td>Fertig am</td>
                        <td></td>
                        <td>TDB</td>
                        <td>Fertig%</td>
                        <td>neu</td>
                        <td><button class="btn btn-primary"><span class="fa fa-pencil"></span>&nbsp; Laden</button></td>
                    </tr>
                    <tr>
                        <td>22100</td>
                        <td>FS ECARE-PK</td>
                        <td>18.2 A-Line</td>
                        <td>Kothe, Antje</td>
                        <td>Nein</td>
                        <td>1000</td>
                        <td></td>
                        <td>POSTPAID</td>
                        <td>Micro-SIM 1,8V (2FF/3FF)[3]</td>
                        <td></td>
                        <td>06.11.17</td>
                        <td>10.12.17</td>
                        <td>Fertig am</td>
                        <td></td>
                        <td>TDB</td>
                        <td>Fertig%</td>
                        <td>neu</td>
                        <td><button class="btn btn-primary"><span class="fa fa-pencil"></span>&nbsp; Laden</button></td>
                    </tr>
                    <tr>
                        <td>22100</td>
                        <td>FS ECARE-PK</td>
                        <td>18.2 A-Line</td>
                        <td>Kothe, Antje</td>
                        <td>Nein</td>
                        <td>1000</td>
                        <td></td>
                        <td>POSTPAID</td>
                        <td>Micro-SIM 1,8V (2FF/3FF)[3]</td>
                        <td></td>
                        <td>06.11.17</td>
                        <td>10.12.17</td>
                        <td>Fertig am</td>
                        <td></td>
                        <td>TDB</td>
                        <td>Fertig%</td>
                        <td>neu</td>
                        <td><button class="btn btn-primary"><span class="fa fa-pencil"></span>&nbsp; Laden</button></td>
                    </tr>
                    <tr>
                        <td>22100</td>
                        <td>FS ECARE-PK</td>
                        <td>18.2 A-Line</td>
                        <td>Kothe, Antje</td>
                        <td>Nein</td>
                        <td>1000</td>
                        <td></td>
                        <td>POSTPAID</td>
                        <td>Micro-SIM 1,8V (2FF/3FF)[3]</td>
                        <td></td>
                        <td>06.11.17</td>
                        <td>10.12.17</td>
                        <td>Fertig am</td>
                        <td></td>
                        <td>TDB</td>
                        <td>Fertig%</td>
                        <td>neu</td>
                        <td><button class="btn btn-primary"><span class="fa fa-pencil"></span>&nbsp; Laden</button></td>
                    </tr>
                    <tr>
                        <td>22100</td>
                        <td>FS ECARE-PK</td>
                        <td>18.2 A-Line</td>
                        <td>Kothe, Antje</td>
                        <td>Nein</td>
                        <td>1000</td>
                        <td></td>
                        <td>POSTPAID</td>
                        <td>Micro-SIM 1,8V (2FF/3FF)[3]</td>
                        <td></td>
                        <td>06.11.17</td>
                        <td>10.12.17</td>
                        <td>Fertig am</td>
                        <td></td>
                        <td>TDB</td>
                        <td>Fertig%</td>
                        <td>neu</td>
                        <td><button class="btn btn-primary"><span class="fa fa-pencil"></span>&nbsp; Laden</button></td>
                    </tr>
                    <tr>
                        <td>22100</td>
                        <td>FS ECARE-PK</td>
                        <td>18.2 A-Line</td>
                        <td>Kothe, Antje</td>
                        <td>Nein</td>
                        <td>1000</td>
                        <td></td>
                        <td>POSTPAID</td>
                        <td>Micro-SIM 1,8V (2FF/3FF)[3]</td>
                        <td></td>
                        <td>06.11.17</td>
                        <td>10.12.17</td>
                        <td>Fertig am</td>
                        <td></td>
                        <td>TDB</td>
                        <td>Fertig%</td>
                        <td>neu</td>
                        <td><button class="btn btn-primary"><span class="fa fa-pencil"></span>&nbsp; Laden</button></td>
                    </tr>
                    <tr>
                        <td>22100</td>
                        <td>FS ECARE-PK</td>
                        <td>18.2 A-Line</td>
                        <td>Kothe, Antje</td>
                        <td>Nein</td>
                        <td>1000</td>
                        <td></td>
                        <td>POSTPAID</td>
                        <td>Micro-SIM 1,8V (2FF/3FF)[3]</td>
                        <td></td>
                        <td>06.11.17</td>
                        <td>10.12.17</td>
                        <td>Fertig am</td>
                        <td></td>
                        <td>TDB</td>
                        <td>Fertig%</td>
                        <td>neu</td>
                        <td><button class="btn btn-primary"><span class="fa fa-pencil"></span>&nbsp; Laden</button></td>
                    </tr>
                    <tr>
                        <td>22100</td>
                        <td>FS ECARE-PK</td>
                        <td>18.2 A-Line</td>
                        <td>Kothe, Antje</td>
                        <td>Nein</td>
                        <td>1000</td>
                        <td></td>
                        <td>POSTPAID</td>
                        <td>Micro-SIM 1,8V (2FF/3FF)[3]</td>
                        <td></td>
                        <td>06.11.17</td>
                        <td>10.12.17</td>
                        <td>Fertig am</td>
                        <td></td>
                        <td>TDB</td>
                        <td>Fertig%</td>
                        <td>neu</td>
                        <td><button class="btn btn-primary"><span class="fa fa-pencil"></span>&nbsp; Laden</button></td>
                    </tr>
                    <tr>
                        <td>22100</td>
                        <td>FS ECARE-PK</td>
                        <td>18.2 A-Line</td>
                        <td>Kothe, Antje</td>
                        <td>Nein</td>
                        <td>1000</td>
                        <td></td>
                        <td>POSTPAID</td>
                        <td>Micro-SIM 1,8V (2FF/3FF)[3]</td>
                        <td></td>
                        <td>06.11.17</td>
                        <td>10.12.17</td>
                        <td>Fertig am</td>
                        <td></td>
                        <td>TDB</td>
                        <td>Fertig%</td>
                        <td>neu</td>
                        <td><button class="btn btn-primary"><span class="fa fa-pencil"></span>&nbsp; Laden</button></td>
                    </tr>
                    <tr>
                        <td>22100</td>
                        <td>FS ECARE-PK</td>
                        <td>18.2 A-Line</td>
                        <td>Kothe, Antje</td>
                        <td>Nein</td>
                        <td>1000</td>
                        <td></td>
                        <td>POSTPAID</td>
                        <td>Micro-SIM 1,8V (2FF/3FF)[3]</td>
                        <td></td>
                        <td>06.11.17</td>
                        <td>10.12.17</td>
                        <td>Fertig am</td>
                        <td></td>
                        <td>TDB</td>
                        <td>Fertig%</td>
                        <td>neu</td>
                        <td><button class="btn btn-primary"><span class="fa fa-pencil"></span>&nbsp; Laden</button></td>
                    </tr>
                    <tr>
                        <td>22100</td>
                        <td>FS ECARE-PK</td>
                        <td>18.2 A-Line</td>
                        <td>Kothe, Antje</td>
                        <td>Nein</td>
                        <td>1000</td>
                        <td></td>
                        <td>POSTPAID</td>
                        <td>Micro-SIM 1,8V (2FF/3FF)[3]</td>
                        <td></td>
                        <td>06.11.17</td>
                        <td>10.12.17</td>
                        <td>Fertig am</td>
                        <td></td>
                        <td>TDB</td>
                        <td>Fertig%</td>
                        <td>neu</td>
                        <td><button class="btn btn-primary"><span class="fa fa-pencil"></span>&nbsp; Laden</button></td>
                    </tr>
                    <tr>
                        <td>22100</td>
                        <td>FS ECARE-PK</td>
                        <td>18.2 A-Line</td>
                        <td>Kothe, Antje</td>
                        <td>Nein</td>
                        <td>1000</td>
                        <td></td>
                        <td>POSTPAID</td>
                        <td>Micro-SIM 1,8V (2FF/3FF)[3]</td>
                        <td></td>
                        <td>06.11.17</td>
                        <td>10.12.17</td>
                        <td>Fertig am</td>
                        <td></td>
                        <td>TDB</td>
                        <td>Fertig%</td>
                        <td>neu</td>
                        <td><button class="btn btn-primary"><span class="fa fa-pencil"></span>&nbsp; Laden</button></td>
                    </tr>
                    <tr>
                        <td>22100</td>
                        <td>FS ECARE-PK</td>
                        <td>18.2 A-Line</td>
                        <td>Kothe, Antje</td>
                        <td>Nein</td>
                        <td>1000</td>
                        <td></td>
                        <td>POSTPAID</td>
                        <td>Micro-SIM 1,8V (2FF/3FF)[3]</td>
                        <td></td>
                        <td>06.11.17</td>
                        <td>10.12.17</td>
                        <td>Fertig am</td>
                        <td></td>
                        <td>TDB</td>
                        <td>Fertig%</td>
                        <td>neu</td>
                        <td><button class="btn btn-primary"><span class="fa fa-pencil"></span>&nbsp; Laden</button></td>
                    </tr>
                    <tr>
                        <td>22100</td>
                        <td>FS ECARE-PK</td>
                        <td>18.2 A-Line</td>
                        <td>Kothe, Antje</td>
                        <td>Nein</td>
                        <td>1000</td>
                        <td></td>
                        <td>POSTPAID</td>
                        <td>Micro-SIM 1,8V (2FF/3FF)[3]</td>
                        <td></td>
                        <td>06.11.17</td>
                        <td>10.12.17</td>
                        <td>Fertig am</td>
                        <td></td>
                        <td>TDB</td>
                        <td>Fertig%</td>
                        <td>neu</td>
                        <td><button class="btn btn-primary"><span class="fa fa-pencil"></span>&nbsp; Laden</button></td>
                    </tr>
                    <tr>
                        <td>22100</td>
                        <td>FS ECARE-PK</td>
                        <td>18.2 A-Line</td>
                        <td>Kothe, Antje</td>
                        <td>Nein</td>
                        <td>1000</td>
                        <td></td>
                        <td>POSTPAID</td>
                        <td>Micro-SIM 1,8V (2FF/3FF)[3]</td>
                        <td></td>
                        <td>06.11.17</td>
                        <td>10.12.17</td>
                        <td>Fertig am</td>
                        <td></td>
                        <td>TDB</td>
                        <td>Fertig%</td>
                        <td>neu</td>
                        <td><button class="btn btn-primary"><span class="fa fa-pencil"></span>&nbsp; Laden</button></td>
                    </tr>
                    <tr>
                        <td>22100</td>
                        <td>FS ECARE-PK</td>
                        <td>18.2 A-Line</td>
                        <td>Kothe, Anita</td>
                        <td>Nein</td>
                        <td>1000</td>
                        <td></td>
                        <td>POSTPAID</td>
                        <td>Micro-SIM 1,8V (2FF/3FF)[3]</td>
                        <td></td>
                        <td>06.11.17</td>
                        <td>10.12.17</td>
                        <td>Fertig am</td>
                        <td></td>
                        <td>TDB</td>
                        <td>Fertig%</td>
                        <td>neu</td>
                        <td><button class="btn btn-primary"><span class="fa fa-pencil"></span>&nbsp; Laden</button></td>
                    </tr>
                </tbody>
            </table>
        </main>

    </body>

<!--
    <div class="navbar navbar-inverse navbar-fixed-bottom">
    <div class="container-fluid">
        <p class="navbar-text pull-left">Version: 1.4.1 (15.11.2017)</p>
        <a class="navbar-text" href="mailto:info@sixis.com"><i id="social-em" class="fa fa-envelope-square fa-2x social"></i></a>
    </div>
    </div>
 -->
 </html>
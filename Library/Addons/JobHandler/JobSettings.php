<?php
$rechner = "3 TDB-Autojob"; // Ablageort
$von = "00:01";
$bis = "23:59";

$tabelle = "QTP_VARIANZEN_JOBS";
$name = "TDB - "; // Platzhalter - Name dynamisch?
$beschreibung = "TDB-Job - ";

$semaphore = -1;
$interval = 0;
$semaphore_id = null;
$ltz_ausf = null; // was kommt hier rein?
$ausfuehren = -1;
$allowdays = "1234567";
$alle_ausf = -1;
$daily = 0;
$eop_pruefung = 0;

$timeout = 950;

$PK_varianz = "353";
$PK_lfd = 16;
$PK_command = 'C:\WINDOWS\system32\wscript.exe C:\TEMP\$_Starter\Scripts\PEB_TDB_Prod.vbs  "NG Vorgangserfassung PK"';
$PK_auftragsart = "Normal";

$Xtra_varianz = "351";
$Xtra_lfd = 6;
$Xtra_command = 'C:\WINDOWS\system32\wscript.exe C:\TEMP\$_Starter\Scripts\PEB_TDB_Prod.vbs  "NG Vorgangserfassung XTRA"';
$Xtra_auftragsart = "Xtra";

$GK_varianz = "355";
$GK_lfd = 14;
$GK_command = 'C:\WINDOWS\system32\wscript.exe C:\TEMP\$_Starter\Scripts\PEB_TDB_Prod.vbs "NG Vorgangserfassung GK"';
$GK_auftragsart = "Großkunden";
?>

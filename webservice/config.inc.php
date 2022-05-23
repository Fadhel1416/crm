<?php

define ("DEBUG", 1);
define ("MAIL_DEBUG", "");
define ("SERVER_IP", "185.148.76.21");
define ("SERVER_IP2", "185.148.76.20");

// SqlServeur : 

$sqlserver = new PDO('sqlsrv:Server=localhost;Database=bati', 'batiusr', 'HUFAz1xiUwXL3C4');
$sqlserver->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT );

global $sqlserver;

if (function_exists('date_default_timezone_set')) { date_default_timezone_set("Europe/Paris"); }


?>
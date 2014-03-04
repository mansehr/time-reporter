<?php
/*************************************************************
 * Created on 17 dec 2008
 * Updated on  6 apr 2011
 * 
 * Config file - define all global data
 * 
 * Created by Andreas Sehr, Mattias H�gglund, David He
 **************************************************************/

/************ GLOBAL VARIABELS *********/
$title = 'SamarITen - Kontaktsystem';
$contact_email = "sehr.andreas@gmail.com";

$workVat = 0.25;
$prodVat = 0.25;

$debug = false;
if($debug) {
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
}
/************ DATABASE *********/
$db_conf = array(
'host' => "localhost",
'user' => "ms_report",
'password' => "ms_report",
'dbname' => "ms_report");

/************ DATE VARIABLES *********/
date_default_timezone_set("Europe/Stockholm");

?>

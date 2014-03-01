<?php
/*************************************************************
 * Created on 17 dec 2008
 * Updated on  6 apr 2011
 * 
 * Config file - define all global data,
 *
 * Example file - fill int the variables and rename this file to config.php
 * 
 * Created by Andreas Sehr, Mattias Hägglund, David He
 **************************************************************/

/************ GLOBAL VARIABELS *********/
$title = 'Report Title';
$contact_email = "contact email";
$debug = false;
//error_reporting(E_ALL);
//ini_set("display_errors", 1);

/************ DATABASE *********/
$db_conf = array(
'host' => "localhost",
'user' => "ms_report_user",
'password' => "",
'dbname' => "ms_report");

/************ DATE VARIABLES *********/
date_default_timezone_set("Europe/Stockholm");

?>

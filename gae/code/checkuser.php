<?php
/*************************************************************
 * Created on 17 dec 2008
 * Updated on 17 dec 2008
 *
 * Config fil som initierar grundstommen i phphanteringen av klassladdning och
 * felhantering.
 *
 * Skapad av Andreas Sehr, Mattias Hägglund, David He
 **************************************************************/

require_once ('config.php');
require_once ('functions.php');
require_once ('Auth.php');	// From pearpackage
global $auth, $db_conf;

// Connect to the database:
$options = array('dsn' => 'mysqli://'.$db_conf['user'].':'.$db_conf['password'].
                            '@'.$db_conf['host'].'/'.$db_conf['dbname'],
        'table'       => 'user',
        'usernamecol' => 'login',
        'passwordcol' => 'password',
        "db_fields" => array('adress',
                            'zipcode',
                            'city',
                            'name',
                            'phone',
                            'mobile',
                            'mail',
                            'pnr',
                            'administrator'),
        'cryptType' => 'md5');

// Create the Auth object:
$auth = new Auth('MDB2', $options, 'loginFunction');

// Start the authorization:
$auth->start();


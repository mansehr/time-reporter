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

global $user;

$loginUserHandler = new LoginUserHandler();
$user = $loginUserHandler->getCurrentUser();


<?php

/* * ***********************************************************
 * Created on  6 apr 2011
 * Updated on  6 apr 2011
 *
 * Useful global functions
 *
 * Created by Andreas Sehr
 * ************************************************************ */

/* * ** GLOBAL FUNCTIONS *** */

/* * ******** DEBUG OUTPUT ********** */
function DEBUG($output) {
    global $debug;
    if ($debug) {
        echo "<pre>";
        if (is_array($output)) {
            print_r($output);
        } else {
            echo var_dump($output);
        }
        echo "</pre>";
    }
}

/* * ******** LOGIN FORM ********** */

function loginFunction($username = null, $status = null, &$auth = null) {
    echo '<form method="post" action="./"  onSubmit="return true;" style="margin:auto; width: 250px;">';

    if (isset($_REQUEST['login'])) {
        echo '<p class="info_text_fail">Wrong username or password!</p>';
    }

    echo "<label>User:<input type=\"text\" name=\"username\"></label><br/>";
    echo "<label>Password:<input type=\"password\" name=\"password\"></label><br/>";
    echo '<input type="submit" name="login" value="Login">';
    echo "</form><br/>";
}

/* * ********ERROR MANAGEMENT ********** */
set_error_handler('error_handler');

function error_handler($e_number, $e_message, $e_file, $e_line, $e_vars) {
    global $debug, $contact_email;

    $message = "An error occured in file <b>'$e_file'</b> on row <b>$e_line</b>: \n<br />\n<br />$e_message\n<br />";
    $message .= "The event occured: " . date("j/n-y H:i:s") . "\n<br />";
    $message .= "<pre>" . print_r($e_vars, 1) . "</pre> \n</br>";

    if (($e_number != E_NOTICE) && ($e_number < 2048)) { // Show the message if debug trace is on
        DEBUG($message);
    } else if (($e_number != E_NOTICE) && ($e_number < 2048)) {
        //error_log($message, 1, $contact_email);
        echo '<p class="error">An error occured in the script file. Please try again later</p>';
    }
}

/* * ** AUTOLOAD CLASSES FROM SUBDIRECTORY *** */

function __autoload($class_name) {
    require_once './classes/' . strtolower($class_name) . '.php';
}

function prices($price, $quantity = 1) {
    $prices = array();
    $prices['exkl_moms'] = ceil($price * $quantity);
    $prices['moms'] = ceil($prices['exkl_moms'] * 0.25);
    $prices['sum'] = $prices['exkl_moms'] + $prices['moms'];
    return $prices;
}

function save_object($obj) {
    if ($obj->save()) {
        echo '<p class="info_text_ok">The data was saved</p>';
        return true;
    } else {
        if ($obj->fail_str == "") {
            echo "No changes in the database";
            return true;
        } else {
            echo '<p class="info_text_fail">A problem occured when the data was stored: <br/>'
                . $obj->fail_str.'</p>';
            return false;
        }
    }
}

function table_code($title, $name, $obj, $extra = "") {
    $value = isset($_REQUEST[$name]) ? $_REQUEST[$name]: $obj->$name ;

    $formular = '<tr>'
            . '<td nowrap="nowrap">' . $title . ':</td><td><input type="text" id="'
            . $name . '" name="' . $name . '" value="' . $value . '" ' . $extra
            . ' ><div id="' . $name . '_error" class="error_txt"></div></td>'
            . '</tr>';
    echo $formular;
}

/**
 * This function adds the values in two arrays where the array keys match
 *
 * @param <type> $dest array with values where source is added to
 * @param <type> $source array with values, unchanged
 */
function array_add(&$dest, $source) {
    foreach ($source as $key => $value) {
        if (!isset($dest[$key])) {
            $dest[$key] = $value;
        } else {
            $dest[$key] += $value;
        }
    }
}
?>

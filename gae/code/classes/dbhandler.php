<?php

/*
 * Created on 17 dec 2008
 * Updated on 27 Mar 2011
 * 
 * Database handler - handles the connection for the objects with the database.
 * Loads and stores the fields in the class automatically.
 * 
 * Created by Andreas Sehr, Mattias Hägglund, David He
 */


class DbHandler
{
    private static $db = NULL;
    private $result;

    public function __construct() {
        if (self::$db == NULL) {
            global $db_conf;
            self::$db = new mysqli($db_conf['host'], $db_conf['user'],
                                   $db_conf['password'], $db_conf['dbname'])
                    or die("Couldn't connect to database: " . mysqli_error());
        }
    }

    public function __destruct() {
        if (isset($result)) {
            $this->result->close();
        }
    }

    public function query($q) {
        $this->result = self::$db->query($q);
        if (!$this->result) {
            DEBUG("Failed to execute query: \n<br />$q\n<br />Mysql error" .
                        $this->get_mysqli_error());
        }
        return $this->result;
    }

    public function affectedRows() {
        return self::$db->affected_rows;
    }

    public function insertId() {
        return self::$db->insert_id;
    }

    public function fetch_row($q, $type = NULL) {
        $this->query($q);
        switch ($type) {
            case MYSQL_ASSOC:;
            case MYSQL_NUM:;
            case MYSQL_BOTH:;
                break;
            default: $type = MYSQL_ASSOC;
        }
        if ($this->result)
            return $this->result->fetch_array(MYSQL_ASSOC);
        else
            return NULL;
    }

    public function fetch_array($q) {
        $this->query($q);
        $rows = array();
        if ($this->result != NULL) {
            while ($row = $this->result->fetch_array(MYSQL_ASSOC)) {
                $rows[] = $row;
            }
        }
        return $rows;
    }

    public function fetch_array_value($q, $value) {
        $this->query($q);
        $rows = array();
        if ($this->result != NULL) {
            while ($row = $this->result->fetch_array(MYSQL_ASSOC)) {
                $rows[] = $row[$value];
            }
        }
        return $rows;
    }

    public function get_mysqli_error() {
        return mysqli_error(self::$db);
    }

    // This functions should be used when creating sql queries with user entered
    // values.
    // Adds quotes if necessary.
    public static function escapeCharacters($value, $quote = true) {
        // Stripslashes
        if (get_magic_quotes_gpc ()) {
            $value = stripslashes($value);
        }
        // Quote if not integer
        if ($quote && !is_numeric($value) && $value != 'CURRENT_TIMESTAMP') {
            $value = "'" . self::$db->real_escape_string($value) . "'";
        }
        return $value;
    }

}
?>

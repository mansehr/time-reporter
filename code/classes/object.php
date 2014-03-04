<?php

/*
 * Created on 17 dec 2008
 * Updated on 27 mar 2011
 * 
 * The Object class stores the base for an object.
 * Cowork with the DBHandler object to store and fetch information in the
 * database.
 * 
 * Created by Andreas Sehr, Mattias Hägglund, David He
 * 
 */

class Object extends DbHandler {

    protected $fail_str;
    protected $fields;
    protected $defaultTable;
    protected $idField;
    protected $data;

    /* 	Constructor
      Can handle two possible inputs:
      id - loads with the id from the database
      array() - stores the relevant information in the class
     */

    public function __construct($input) {
        parent::__construct();
        $this->data = array();
        $this->fail_str = "";

        // Default id field is id
        if (!isset($this->idField)) { 
            $this->idField = "id";
        }

        foreach ($this->fields as $table) {
            $this->data[$table] = "";
        }

        if (isset($input)) {
            if (is_array($input)) {
                $this->data[$this->idField] = isset($input[$this->idField]) ? $input[$this->idField] : "";
                $this->loadByArray($input);
            } else {
                $this->data[$this->idField] = $input;
                $this->loadById($input);
            }
        }
    }

    public function __get($table) {
        if ($table == "id") {
            return $this->data[$this->idField];
        }
        if ($table == "fail_str") {
            return $this->fail_str;
        }
        if ($table == "data") {
            return $this->data;
        }
        if (isset($this->data[$table])) {
            return $this->data[$table];
        }
        return NULL;
    }

    public function __set($table, $value) {
        if ($table == "id") {
            $this->data[$this->idField] = $value;
        } else if (in_array($table, $this->fields)) {
            $this->data[$table] = $value;
        }
    }
    
    /**
     * Load from the database
     */
    protected function loadByFieldValue($field, $value) {
        $q = "SELECT * FROM " . $this->defaultTable . " WHERE " . $field
                . " = " . self::escapeCharacters($value, true) .
                " LIMIT 1";
        return $this->fetch_array($q);
    }

    /**
     * Load from the database
     */
    private function loadById() {
        $q = "SELECT * FROM " . $this->defaultTable . " WHERE " . $this->idField
                . " = " . $this->escapeCharacters($this->data[$this->idField]) .
                " LIMIT 1";
        $row = $this->fetch_row($q);
        $this->loadByArray($row);
    }

    /**
     * Load from initialized array
     * @param type $data
     */
    protected function loadByArray($data) {
        if ($data != NULL) {
            foreach ($data as $key => $value) {
                if (in_array($key, $this->fields)) {
                    $this->data[$key] = $value;
                }
            }
        }
    }

    protected function exists() {
        $q = "SELECT * FROM " . $this->defaultTable . " WHERE " . $this->idField
                . " = " . $this->escapeCharacters($this->data[$this->idField]) .
                " LIMIT 1";
        return ($this->fetch_row($q) != NULL);
    }

    public function save() {
        if ($this->exists()) { // Finns i databasen
            $sql = "UPDATE ";
            $where = " WHERE " . $this->idField . " = " .
                    $this->escapeCharacters($this->data[$this->idField]);
        } else {
            $sql = "INSERT INTO ";
            $where = "";
        }

        $sql .= $this->defaultTable;

        $fields = "";
        foreach ($this->fields as $column) {
            if ($this->data[$column] != "") {
                if ($fields != "") {
                    $fields .= ",";
                } else {
                    $fields .= " SET ";
                }
                $fields .= " $column = " .
                        $this->escapeCharacters($this->data[$column]);
            }
        }

        $sql .= $fields . $where;

        if ($this->query($sql)) {
            if (!isset($this->id)) {
                $this->id = $this->insertId();
            }
        } else {
            $this->fail_str = $this->get_mysqli_error();
        }

        if ($this->affectedRows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * The variable "form" is an array with array to create rows with different
     * attributes, the key is the name of a field in the object.
     * editable (bool) - is the form editable
     */

    protected function createTable($form, $editable) {
        $ret = "<table><tbody>";
        foreach ($form as $key => $style) {
            $name = $style[0];
            $value = $this->data[$key];
            $ret .= "<tr><td>$name</td><td><b>$value</b></td></tr>";
        }
        $ret .= "</tbody></table>";
        return $ret;
    }

    public function getEditForm() {
        echo "No getEditForm implemented";
    }
}
?>

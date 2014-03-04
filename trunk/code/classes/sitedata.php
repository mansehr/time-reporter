<?php

/*
 * Created on 17 dec 2008
 * Updated on 17 dec 2008
 * Updated on 15 maj 2010 Andreas - Added administrator
 * 
 * User class - Stores user information
 * 
 * 
 * Created by Andreas Sehr, Mattias Hägglund, David He
 */

class Sitedata extends Object {

    public function __construct($in) {
        $this->defaultTable = "sitedata";
        $this->idField = "id";
        $this->fields = array('maintext',
            'workvat',
            'productvat',
            'version');

        parent::__construct($in);
    }
}
?>
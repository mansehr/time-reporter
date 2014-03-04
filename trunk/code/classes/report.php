<?php

/*
 * Created on 17 dec 2008
 * Updated on 17 dec 2008
 * 
 * Report class - Stores the user report information,
 * starttime, duration, so forth. Connects the user with the company it has
 * worked for.
 * 
 * 
 * Created by Andreas Sehr, Mattias Hägglund, David He
 */

class Report extends Object {

    public function __construct($in) {
        $this->defaultTable = "report";
        $this->idField = "id";

        $this->fields = array('date',
            'starttime',
            'duration',
            'title',
            'text',
            'invoicenr',
            'id',
            'regnumber', // Company reference number
            'update',
            'pnr');

        parent::__construct($in);
        $this->setDefault();
        $this->data['typeStr'] = "Report";
    }

    private function setDefault() {
        if ($this->date == "") {
            $this->date = date("Y-m-d", time());
        }
        if ($this->starttime == "") {
            $this->starttime = date("H:i:s", time());
        }
        if ($this->endtime == "") {
            $this->endtime = date("H:i:s", time() + 600);
        }
    }

    public function __get($name) {
        if ($name == 'endtime') {
            return date("H:i:s", strtotime($this->starttime) + $this->duration);
        }
        if ($name == 'hours') {
            return round($this->duration / 3600, 2);
        }
        return parent::__get($name);
    }

    public function save() {
        if ($this->invoicenr == 0) {
            $this->invoicenr = NULL;
        }
        return parent::save();
    }
}
?>
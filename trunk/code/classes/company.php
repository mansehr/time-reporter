<?php

/*
 * Created on 17 dec 2008
 * Updated on 27 Mar 2011
 *
 * Company class - stores company information
 * Gets and set the variables through the Object class
 * Fields used are:
 *  Regnumber
 *  Adress
 *  City
 *  Zipcode
 *  Company name
 *  Company type
 *  Price
 * 
 * Created by Andreas Sehr, Mattias Hägglund, David He
 * 
 */

class Company extends Object {
    /* 	Constructor
      Can handle two inputs:
      id - load data from the database with company id
      array() - store the array information in the object
     */

    public function __construct($in) {
        $this->defaultTable = "company";
        $this->idField = "regnumber";

        $this->fields = array('name',
            'adress',
            'city',
            'zipcode',
            'companytype', //företagstyp
            'regnumber', //Organisationsnummer
            'lastchange',
            'price');

        parent::__construct($in);

        $this->data['typeStr'] = "Company";
        if (empty($this->data['lastchange']))
            $this->data['lastchange'] = "CURRENT_TIMESTAMP";
    }

    public function __get($name) {
        if ($name == "show_link") {
            return "<a href='?page=info_comp&id=" . $this->regnumber . "'>" . $this->name . "</a>";
        }
        if ($name == "new_report_link") {
            return '<a href="?page=add_rep&regnumber=' . $this->regnumber . '">Add report</a>';
        }
        if ($name == "new_contact_link") {
            return '<a href="?page=add_contact&regnumber=' . $this->regnumber . '">Add contakt</a>';
        }
        if ($name == "edit_comp_link") {
            return '<a href="?page=add_comp&link=edit_comp_link&regnumber=' . $this->regnumber . '">Edit</a>';
        }
        if ($name == "edit_contact_link") {
            return '<a href="?page=add_contact&link=edit_contact_link&name=' . $this->name . '&regnumber=' . $this->regnumber . '">Edit</a>';
        }
        if ($name == "debit_hours") {
            if (!isset($this->data[$name])) {
                $a = $this->fetch_row("SELECT ROUND(SUM(duration)/3600, 2) as duration FROM report WHERE invoicenr IS NULL && regnumber = '" . $this->regnumber . "'");
                $this->data[$name] = $a['duration'];
            }
            return $this->data[$name];
        }
        if ($name == "debit_hours_by_person") {
            if (!isset($this->data[$name])) {
                $a = $this->fetch_row("SELECT ROUND(SUM(duration)/3600, 2) as duration, pnr FROM report WHERE invoicenr IS NULL && regnumber = '" . $this->regnumber . "' GROUP BY pnr");
                $this->data[$name] = $a;
            }
            return $this->data[$name];
        }
        if ($name == "debit_products") {
            if (!isset($this->data["debit_products"])) {
                $this->data["debit_products"] = $this->fetch_array_value("SELECT id FROM product WHERE invoicenr IS NULL && regnumber = '" . $this->regnumber . "'", "id");
            }
            return $this->data["debit_products"];
        }
        return parent::__get($name);
    }

    public function getInfoTable() {

        $form['name'] = array('Name', 'text');
        $form['adress'] = array('Adress', 'text');
        $form['city'] = array('City', 'text');
        $form['zipcode'] = array('Zip code.', 'text');
        $form['companytype'] = array('Companytype', 'text');
        $form['regnumber'] = array('Regnumber', '');
        $form['lastchange'] = array('Last updated', NULL);
        $form['price'] = array('Price ex. Tax', 'text');

        return $this->createTable($form, false);
    }

    public function getReportTable() {
        $ids = $this->fetch_array("SELECT id FROM report WHERE regnumber = " . $this->escapeCharacters($this->__get('id')) . " ORDER BY date DESC, startTime DESC");
        if (empty($ids)) {
            $ret = "<div>No reports reported for this company</div>";
        } else {
            $ret = '<table>
                    <thead>
                    <th width="120px">Date</th>
                    <th width="120px">Start</th>
                    <th width="40px">Time</th>
                    <th width="120px">User</th>
                    <th width="120px">Work done</th>
                    <th width="60px">Show</th>
                    </thead>
                    <tbody>';
            foreach ($ids as $rep) {
                $report = new Report($rep['id']);
                $person = new User($report->pnr);
                $ret .= '<tr>';
                $ret .= '<td>' . $report->date . '</td>';
                $ret .= '<td>' . $report->starttime . '</td>';
                $ret .= '<td>' . $report->hours . '</td>';
                $ret .= '<td>' . $person->name . '</td>';
                $ret .= '<td>' . $report->title . '</td>';
                $ret .= '<td><a href="javascript:show_report(' . $rep['id'] . ');" id="report' . $rep['id'] . '_link">Show</a></td>';
                $ret .= '</tr>';
                $ret .= '<tr ><td colspan="5"><div id="report' . $rep['id'] . '_text" class="report_cell"></div></td></tr>';
            }
            $ret .= "</tbody></table>";
        }
        return $ret;
    }

    function getContactPerson() {
        $persons = array();
    }

    function getEditForm() {
        table_code("Company", "name", $this);
        table_code("Adress", "adress", $this);
        table_code("Zip code", "zipcode", $this);
        table_code("City", "city", $this);
        table_code("Company type", "companytype", $this);
        table_code("Registration nr", "regnumber", $this);

        echo '<tr><td><a target="_blank" href="http://allabolag.se/?what='. // Store this in db
                urlencode((isset($_REQUEST['name'])?$_REQUEST['name']:$this->name)).
              '">Look up company</a></td></tr>';
    }
}
?>

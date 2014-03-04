<?php

/*
 * Created on 17 dec 2008
 * Updated on 23 Mar 2011
 * 
 * CompanyContact - stores information for a company contact.
 * 
 * Created by Andreas Sehr, Mattias Hägglund, David He
 */

class ContactPerson extends Object {

    public function __construct($in) {
        $this->defaultTable = "contactperson";
        $this->idField = "name";

        $this->fields = array('name',
            'regnumber',
            'phone',
            'mobile',
            'mail');

        parent::__construct($in);
        
        $this->data['typeStr'] = "ContactPerson";
    }

    public function getContactPersonTable() {
        $ids = $this->fetch_array("SELECT name FROM contactperson WHERE regnumber = "
                        . $this->escapeCharacters($this->__get('id')));
        if (empty($ids)) {
            $ret = "<div>No contact for this company</div>";
        } else {
            $ret = '<table>
                    <thead>
                    <th width="120px">Name</th>
                    <th width="120px">Phone</th>
                    <th width="120px">Cell</th>
                    <th width="120px">E-mail</th>
                    </thead>
                    <tbody>';
            foreach ($ids as $rep) {
                $report = new ContactPerson($rep['name']);
                $ret .= '<tr>';
                $ret .= '<td>' . htmlentities($report->name) . '</td>';
                $ret .= '<td>' . $report->phone . '</td>';
                $ret .= '<td>' . $report->mobile . '</td>';
                $ret .= '<td>' . $report->mail . '</td>';
                $ret .= '<td>' . '<a href="?page=add_contact&link=edit_contact_link&name=' .
                        $report->name . '&regnumber=' . $report->regnumber . '">Edit</a>' . '</td>';
                $ret .= '</tr>';
            }
            $ret .= "</tbody></table>";
        }
        return $ret;
    }

    function getEditForm() {
        echo '<input type="hidden" name="regnumber" value="'.$this->regnumber.'" />';
        table_code("Name", "name", $this);
	table_code("Phone", "phone", $this);
	table_code("Cell", "mobile", $this);
	table_code("E-mail", "mail", $this);
    }
}
?>
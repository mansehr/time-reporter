<?php
/*************************************************************
 * Created on  5 may 2011
 * Updated on  5 may 2011
 *
 * Page for administrating companies with tabs
 *
 * Created by Andreas Sehr
**************************************************************/

class page_company extends page_template {
    
    public function __construct() {
        $this->m_menu = array(
            "info" => "Company info",
            "contacts" => "Contacts",
            "reports" => "Reports"/*,
            "products" => "Sold products"*/);
        $this->m_default_page = "info";
        $this->m_class_name = "page_company";
    }

    static function info() {
        $company = new Company($_COOKIE['id']);
        return '<div class="block" align="left">
                <h1><b>'.$company->name.'</b> information</h1>'.
                '<div style="float: right">'.$company->edit_comp_link.'</div>'.
                $company->getInfoTable().'</div>';
    }

    static function contacts() {
        $company = new Company($_COOKIE['id']);
	$contactperson = new ContactPerson($_REQUEST['id']);
        return '<div class="block" align="left">
                <h1>Contactperson(s)</h1>
                <div style="float: right">'.$company->new_contact_link.'</div>'.
                $contactperson->getContactPersonTable().'</div>';
    }

    static function reports() {
        $company = new Company($_COOKIE['id']);
        return '<div class="block" align="left">
                <h1>Reports</h1>
                <div style="float: right">'.$company->new_report_link.'</div>'.
                $company->getReportTable().'</div>';
    }

    static function products() {
        $company = new Company($_COOKIE['id']);
        return '<div class="block" align="left">
                <h1>Sold products</h1>
                <div style="float: right">'.$company->new_product_link.'</div>'.
                'TODO</div>';
    }
}
?>

<?php

/*
 * Created on 17 dec 2008
 * Updated on 13 may 2011
 *
 * Invoice class - groups the reports and calculates the total time, price and
 * tax. The invoice will be marked as recieved manually to ceep trac of which
 * invoices have been paid or not.
 * 
 * Created by Andreas Sehr, Mattias Hägglund, David He
 */

class Invoice extends Object {

    public function __construct($in) {
        $this->defaultTable = "invoice";
        $this->idField = "invoicenr";

        $this->fields = array('invoicenr',
            'regnumber',
            'price',
            'sent',
            'paid');
        parent::__construct($in);
        
        $this->data['typeStr'] = "Invoice";
    }

    /*
     * workHours
     * workSum
     * workVat
     * workTot
     * 
     * prodSum
     * prodVat
     * ProdTot
     * 
     * sum
     * vat
     * tot
     */

    public function __get($name) {
        if (!isset($this->data[$name])) {
            if ($name == 'reports') {
                $this->data[$name] = $this->fetch_array("SELECT * FROM report WHERE invoicenr = " . $this->invoicenr);
            } else if ($name == 'products') {
                $this->data[$name] = $this->fetch_array("SELECT * FROM product WHERE invoicenr = " . $this->invoicenr);
            } else if ($name == 'hours') {
                $this->data['hours'] = 0;
                foreach ($this->reports as $report) {
                    $this->data['hours'] += $report['duration'];
                }
                $this->data['hours'] = round($this->data['hours'] / 3600, 2);
            } else if($name == 'company') {
                $this->data['company'] = new Company($this->regnumber);
            } else if($name == 'workSum') {
                $this->data[$name] = round($this->hours * $this->price);
            } else if($name == 'workVat') {
                global $workVat;
                $this->data[$name] = round($this->workSum * $workVat);
            } else if($name == 'workTot') {
                $this->data[$name] = round($this->workSum + $this->workVat);
            } else if($name == 'prodSum') {
                $this->data['prodSum'] = 0;
                foreach ($this->products as $prod) {
                    $this->data['prodSum'] += $prod['aprice'] * $prod['quantity'];
                }
                $this->data['prodSum'] = round($this->data['prodSum']);
            } else if($name == 'prodVat') {
                global $prodVat;
                $this->data[$name] = round($this->prodSum * $prodVat);
            } else if($name == 'prodTot') {
                $this->data[$name] = $this->prodSum + $this->prodVat;
            } else if($name == 'sum') {
                $this->data[$name] = $this->workSum + $this->prodSum;
            } else if($name == 'vat') {
                $this->data[$name] = $this->workVat + $this->prodVat;
            } else if($name == 'tot') {
                $this->data[$name] = $this->sum + $this->vat;
            }
        }
        return parent::__get($name);
    }

    /*
      GetReportStatus - fetches relevant information
      'hours' - hours which will be invoiced
      'price' - the price exclusive tax
     */

    public static function getReportStatus() {
        $ret['total_time'] = 0;
        $ret['total_price'] = 0;
        $sql = "SELECT id FROM report WHERE invoicenr IS NULL";
        $db = new DbHandler();
        $result_array = $db->fetch_array_value($sql, 'id');
        foreach ($result_array as $id) {
            $report = new Report($id);
            $company = new Company($report->regnumber);
            $time = $report->duration / 3600;
            $ret['total_time'] += $time;
            $ret['total_price'] += $time * $company->price;
        }
        $ret['total_time'] = round($ret['total_time'], 2);
        $ret['total_price_moms'] = ceil($ret['total_price'] * 1.25);
        $ret['total_price'] = ceil($ret['total_price']);
        return $ret;
    }

    public static function getTenLast() {
        // Creates a DBHandler object since this function i static.
        $db = new DbHandler();
        return $db->fetch_array_value("SELECT invoicenr FROM invoice WHERE 1 ORDER BY invoicenr DESC LIMIT 10", "invoicenr");
    }

    public static function getAll() {
        // Creates a DBHandler object since this function i static.
        $db = new DbHandler();
        return $db->fetch_array_value("SELECT invoicenr FROM invoice WHERE 1 ORDER BY invoicenr DESC", "invoicenr");
    }

    public static function prepInvoices($regnumbers) {
        $db = new DbHandler();
        if ($regnumbers) {
            foreach ($regnumbers as $regnumber) {
                $company = new Company($regnumber);
                $time = 0;
                $invoice = new Invoice("");
                $invoice->sent = date('Y-m-d', time());
                $invoice->price = $company->price;
                $invoice->regnumber = $regnumber;
                $invoice->save();
                $invoiceNr = $invoice->id;
                if (!$db->query("UPDATE report SET invoicenr = " . $invoiceNr . " WHERE invoicenr IS NULL AND regnumber = '" . $regnumber . "'")) {
                    echo "DB error: " . $db->get_mysqli_error();
                }
                if (!$db->query("UPDATE product SET invoicenr = " . $invoiceNr . " WHERE invoicenr IS NULL AND regnumber = '" . $regnumber . "'")) {
                    echo "DB error: " . $db->get_mysqli_error();
                }
            }
        } else {
            echo "No company have been marked for invoicing.";
        }
    }

}
?>
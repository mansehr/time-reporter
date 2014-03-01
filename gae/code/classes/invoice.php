<?php

/*
 * Created on 17 dec 2008
 * Updated on 27 mar 2011
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
            'price',
            'sent',
            'paid');
        parent::__construct($in);
    }

    public function __get($table) {
        if (!isset($this->data['reports'])) {
            $this->data['reports'] = $this->fetch_array("SELECT * FROM report WHERE invoicenr = " . $this->data['invoicenr']);
        }
        if (!isset($this->data[$table])) {
            switch ($table) {
                case 'hours':
                    $this->updateHours();
                    break;
                case 'company':
                    $this->data['company'] = new Company($this->data['reports'][0]['regnumber']);
                    break;
            }
        }
        if (isset($this->data[$table]))
            return $this->data[$table];
        else
            return parent::__get($table);
    }

    private function updateHours() {
        $this->data['hours'] = 0;
        foreach ($this->data['reports'] as $report) {
            $this->data['hours'] += $report['duration'];
        }
        $this->data['hours'] = round($this->data['hours'] / 3600, 2);
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

    public static function prepInvoices($regnumbers) {
        $db = new DbHandler();
        if ($regnumbers) {
            foreach ($regnumbers as $regnumber) {
                $company = new Company($regnumber);
                $time = 0;
                $invoice = new Invoice("");
                $invoice->sent = date('Y-m-d', time());
                $invoice->price = $company->price;
                $invoice->save();
                $invoiceNr = $invoice->id;
                $reportIds = $db->fetch_array_value("SELECT id FROM report WHERE invoicenr IS NULL AND regnumber = '" . $regnumber . "'", "id");
                foreach ($reportIds as $reportId) {
                    if (!$db->query("UPDATE report SET invoicenr = " . $invoiceNr . " WHERE id = " . $reportId)) {
                        echo "DB error: " . $db->get_mysqli_error();
                    }
                }
            }
        } else {
            echo "No reports have been marked for invoicing.";
        }
    }

}
?>
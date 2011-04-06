<?php
/*************************************************************
 * Created on 18 dec 2008
 * Updated on  4 apr 2011
 * 
 * Page for administrating invoices
 * 
 * Created by Andreas Sehr
**************************************************************/

if(isset($_REQUEST['prepinvoice'])) {
    Invoice::prepInvoices($_REQUEST['regnumbers']);
} else if(isset($_REQUEST['update_invoice'])) {
    update_invoice($_POST);
}


function show_content() {
    //$invoice_report = Invoice::getReportStatus();
?>
<div class="block" align="left">
    <h1>Send invoices</h1>
    <h3>Details</h3>
    <form action="./?page=invoice" method="POST">
    <p align="right">
        <input type="submit" name="prepinvoice" value="Retrieve invoice data" />
    </p>
    <table border="0" cellpadding="3">
        <thead bgcolor="#CCCCCC">
        <th align="left">Retrieve</th>
        <th align="left">Type</th>
        <th align="right">Amount</th>
        <th align="right">Price</th>
        <th align="right">Excl.VAT</th>
        <th align="right">VAT</th>
        <th align="right">Sum</th>
        </thead>
        <tbody>
                <?php
                $db = new DbHandler();
                // Retrieve the companys that have uninvoiced products or reports
                $rows1 = $db->fetch_array("SELECT DISTINCT regnumber FROM report WHERE invoicenr IS NULL");
                $rows2 = $db->fetch_array("SELECT DISTINCT regnumber FROM product WHERE invoicenr IS NULL");

                $rows = array_merge($rows1, $rows2);
                unset($rows1);
                unset($rows2);

                // Companies in the array?
                if(count($rows) > 0) {
                    // Remove doublets
                    $comps = array();
                    foreach($rows as $row) {
                        $comps[$row['regnumber']] = $row['regnumber'];
                    }

                    $total_sum = array();
                    // Step through the array one by one
                    foreach($comps as $comp_id) {
                        $comp = new Company($comp_id);

                        $price_sum = array();

                        // Retrieve worked time
                        if($comp->debit_hours > 0) {
                            $prices = prices($comp->price, $comp->debit_hours);
                            array_add($price_sum, $prices);
                            echo '<tr align="right"><td></td>'.
                                    '<td align="left">Worked time</td>'.
                                    '<td align="left">'.$comp->debit_hours."h</td>".
                                    '<td>'.$comp->price.':-</td>'.
                                    '<td>'.$prices['exkl_moms'].':-</td>'.
                                    '<td>'.$prices['moms'].':-</td>'.
                                    '<td><b>'.$prices['sum'].':-</b></td>'.
                                    "</tr>";
                        }
                        // Retrieve sold products
                        if(count($comp->debit_products) > 0) {
                            foreach($comp->debit_products as $product_id) {
                                $product = new Product($product_id);
                                $prices = prices($product->aprice, $product->quantity);
                                array_add($price_sum, $prices);

                                echo '<tr align="right"><td></td>'.
                                        '<td align="left">'.$product->producttype."</td>".
                                        '<td>'.$product->quantity.'pcs</td>'.
                                        '<td>'.$product->aprice.':-</td>'.
                                        '<td>'.$prices['exkl_moms'].':-</td>'.
                                        '<td>'.$prices['moms'].':-</td>'.
                                        '<td><b>'.$prices['sum'].':-</b></td>'.
                                        "</tr>";
                            }
                        }
                        echo '<tr align="right" bgcolor="#DDDDFF">'.
                                '<td align="center"><input type="checkbox" name="regnumbers[]" value="'.$comp->id.'"></td>'.
                                '<td align="left" colspan="3">'.$comp->show_link."</td>".
                                "<td>".$price_sum['exkl_moms'].":-</td>".
                                "<td>".$price_sum['moms'].":-</td>".
                                "<td><b>".$price_sum['sum'].":-</b></td>".
                                "</tr>";
                        array_add($total_sum, $price_sum);
                    }
                } else {
                    echo '<tr><td colspan="4">Nothing to invoice</td></tr>';
                }
                ?>
        </tbody>
    </table>
    </form>
    <br />
    Total pending invoicing:
    <table border="0">
        <tr>
            <td>Price ex.VAT: </td>
            <td><b><?php echo $total_sum['exkl_moms']; ?>:-</b></td>
        </tr>
        <tr>
            <td>VAT:</td>
            <td> <b><?php echo $total_sum['moms']; ?>:-</b></td>
        </tr>
        <tr>
            <td>Price inc.VAT: </td>
            <td><b><?php echo $total_sum['sum']; ?>:-</b></td>
        </tr>
    </table>
</div>

<div class="block" align="left" >
    <h1>Invoicelist</h1>
        <?php
        $ids = Invoice::getTenLast();
        if(!$ids) {
            echo "<p><i>no invoices sent</i></p>";
        } else {
            echo '<form action="./?page=invoice" method="POST">
			<table border="0" width="100%">
			<thead align="center">
			<th style="border-bottom: 1px solid black;">Invoicenr.</th>
			<th style="border-bottom: 1px solid black;">Company</th>
			<th style="border-bottom: 1px solid black;">Time</th>
			<th style="border-bottom: 1px solid black;">Price</th>
			<th style="border-bottom: 1px solid black;">Excl. VAT</th>
			<th style="border-bottom: 1px solid black;">VAT</th>
			<th style="border-bottom: 1px solid black;">Sum</th>
			<th style="border-bottom: 1px solid black;">Sent</th>
			<th style="border-bottom: 1px solid black;">Paid</th>
			</thead>';
            foreach($ids as $id) {
                $invoice = new Invoice($id);

                $prices = prices($invoice->price, $invoice->hours);

                echo '<tr align="right">
                        <td align="center">'.$id.'</td>
                        <td align="left">'.$invoice->company->show_link.'</td>
                        <td>'.$invoice->hours.'h</td>
                        <td>'.$invoice->price.':-</td>
                        <td>'.$prices['exkl_moms'].':-</td>
                        <td>'.$prices['moms'].':-</td>
                        <td>'.$prices['sum'].':-</td>
                    <td align="center">';
                if($invoice->sent) {
                    echo substr($invoice->sent, 0,10);
                } else {
                    echo '<input type="checkbox" name="sent[]" value="'.$id.'" />';
                }

                echo ' </td>
                    <td align="center">';

                if($invoice->paid) {
                    echo substr($invoice->paid, 0,10);
                } else {
                    echo '<input type="checkbox" name="paid[]" value="'.$id.'" />';
                }
                echo '</td>
                </tr>';
            }
            echo '</table><div style="text-align: right;">'
                .'<input name="update_invoice" type="submit" value="Updatera" />'
                .'</div></form>';
        }
        ?>

</div>

    <?php
}

function update_invoice($input) {
    if(is_array($input['sent']))
        foreach($input['sent'] as $id) {
            $invoice = new Invoice($id);
            $invoice->sent = date('Y-m-d',time());
            if(!$invoice->save())
                echo $invoice->fail_str;
        }

    if(is_array($input['paid']))
        foreach($input['paid'] as $id) {
            $invoice = new Invoice($id);
            $invoice->paid = date('Y-m-d',time());
            if(!$invoice->save())
                echo $invoice->fail_str;
        }
}

?>
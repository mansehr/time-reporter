<?php

/*
 * Created on 17 dec 2008
 * Updated on 17 dec 2008
 * 
 * Product class, used for sold products and tenders
 * 
 * Created by Andreas Sehr, Mattias Hägglund, David He
 */

class Product extends Object {

    public function __construct($in) {
        $this->defaultTable = "product";
        $this->idField = "id";

        $this->fields = array('id',
            'producttype',
            'aprice',
            'date',
            'regnumber',
            'invoicenr',
            'quantity');

        parent::__construct($in);

        $this->data['typeStr'] = "Product";
    }

}
?>
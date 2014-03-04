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

class User extends Object {

    public function __construct($in) {
        $this->defaultTable = "user";
        $this->idField = "pnr";

        $this->fields = array('login',
            'userid',
            'password',
            'name',
            'adress',
            'zipcode',
            'city',
            'phone',
            'mobile',
            'mail',
            'administrator');

        parent::__construct($in);

        $this->data['typeStr'] = "User";
    }

    public function edit_user_link() {
        global $user;
        if ($user->id == $this->userid) {
            return '<a href="?page=add_user&link=edit_user_link&pnr=' . $this->pnr . '">Edit</a>';
        }

        return;
    }

    public function isAdmin() {
        return $this->administrator == 1;
    }

    public function getInfoTable() {
        $form['name'] = array('Name', 'text');
        $form['pnr'] = array('Personnr', 'text');
        $form['adress'] = array('Adress', 'text');
        $form['city'] = array('City', 'text');
        $form['zipcode'] = array('Zipcode', 'text');
        $form['city'] = array('City', 'text');
        $form['phone'] = array('Phone', 'text');
        $form['mobile'] = array('Cell', 'text');
        $form['mail'] = array('E-mail', 'text');

        return $this->createTable($form, false);
    }

}
?>
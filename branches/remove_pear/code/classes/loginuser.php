<?php


class LoginUser extends Object {
    public function __construct($in) {
        $this->defaultTable = "user_login";
        $this->idField = "userid";
        $this->fields = array('username',
            'password',
            'authstr');

        parent::__construct($in);
    }

    public function isAdmin() {
        return $this->administrator == 1;
    }

    public function setAdmin($value) {
        $this->admin = $value;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($value) {
        $this->name = $value;
    }

    public function logout() {
        $_SESSION['auth'] = null;
    }
        
}
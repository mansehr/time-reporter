<?php


class LoginUserHandler extends LoginUser {
    
    private $logedInUser;
    
    public function __construct() {
        parent::__construct(NULL);
    }

    public function logout() {
        if(isset($this->logedInUser)) {
            $this->logedInUser->logout();
        }
    }
    
    public function getCurrentUser() {
        session_start();
        $auth = $_SESSION['auth'];
        if(isset($auth) && $auth != null) {
            $user = $this->loadUser($auth);
        }
        if(!isset($user) || $user == null) {
            $user = $this->handleLogin();
        }
        if(!isset($user) || $user == null) {
            loginFunction("","", $this);
        }
        return $user;
    }
    
    private function handleLogin() {
        if(isset($_POST['login']) && is_string($_POST['login'])) {
            $authstr = $this->validateLogin($_POST['username'], $_POST['password']);
            $_SESSION['auth'] = $authstr;
            return $this->loadUser($authstr);
        }
        return null;
    }
    
    private function loadUser($authstr) {
        if($authstr != null) {
            $users = $this->loadByFieldValue("authstr", $authstr);
            $user = isset($users[0]) ? $users[0] : null;
            if($user != null) {
                return new LoginUser($user);
            }
        }
        return null;
    }
    
    private function validateLogin($username, $password) {
        $users = $this->loadByFieldValue("username", $username);
        $user = isset($users[0]) ? $users[0] : null; 
        if(isset($user['password']) && $user['password'] == md5($password)) {
            $authStr = generateRandomString();
            $user = new LoginUser($user);
            $user->authstr = $authStr;
            $user->save();
            return $authStr;
        }
        return null;
    }
        
}
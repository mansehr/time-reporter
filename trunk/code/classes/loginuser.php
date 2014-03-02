<?php


class LoginUser {
	private $name; // string, name of the loged in user
	private $admin; // bool, if admin of timereport
	
	
	public function __construct() {
		$this->setName("Name");
		$this->setAdmin(false);
	}
	
	public function isAdmin() {
		return $this->admin;
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
		// TODO: Perform a session cleanup and logout
	}
}
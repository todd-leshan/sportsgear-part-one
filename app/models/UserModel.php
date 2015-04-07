<?php

class UserModel extends Database
{
	private $_conn;

	public function __construct()
	{
		$this->_conn = $this->connect();
	}

	public function signIn($username, $password)
	{
		$password = sha1(md5($password));

		$prepare = "SELECT staffID 
					FROM staffs 
					WHERE username = ? 
					AND password = ?";
		$param = array($username, $password);

		$userID = $this->executeSQL($this->_conn, $prepare, $param, 2);

		return $userID;
	}

	
}
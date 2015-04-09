<?php

class StaffVO
{
	private $_id;
	private $_username;
	private $_password;

	public function __construct($username, $id = 0)
	{
		$this->_username = $username;
		//$this->password = $password;
		$this->_id = $id;
	}

	public function getId()
	{
		return $this->_id;
	}
	
	public function getUsername()
	{
		return $this->_username;
	}

	public function getPassword()
	{
		return $this->_password;
	}
}
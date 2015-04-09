<?php

require_once __DIR__."/../VO/StaffVO.php";

class StaffDAO extends CRUD
{
	public function __construct()
	{
		parent::__construct();
	}

	//select staff by username and password to check existense
	public function signInCheck($username, $password)
	{
		$password= sha1(md5($password));

		$sql = "SELECT *
				FROM staffs
				WHERE username=:username
				AND password=:password";

		$data = array(
			':username'=>$username,
			':password'=>$password
			);

		$staffs = $this->select('staffs', $data);

		if(sizeof($staffs) == 1)
		{
			$staff = new StaffVO($staffs[0]['username'], $staffs[0]['id']);
		}
		else
		{
			$staff = new StaffVO('', 0);
		}

		return $staff;
	}
}
<?php

require_once __DIR__."/../VO/StaffVO.php";

class StaffDAO extends Database
{
	public function __construct()
	{
		parent::__construct();
	}

	//select staff by username and password to check existense
}
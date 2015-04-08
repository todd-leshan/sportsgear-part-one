<?php

require_once __DIR__."/../VO/BrandVO.php";
//require_once "/../core/Database.php";

class BrandDAO extends Database
{
	//private $_conn;

	public function __construct()
	{
		//$this->_conn = $this->connect();
		parent::__construct();
	}

	public function getBrands()
	{
		$rows = $this->select("brands");

		$brands = array();

		foreach ($rows as $row) 
		{
			$brands[$row['id']] = new BrandVO($row['id'], $row['name']);
		}

		return $brands;
	}



}
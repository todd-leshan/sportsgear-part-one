<?php

class BrandDAO extends Database
{
	private $_conn;

	public function __construct()
	{
		$this->_conn = $this->connect();
	}

	public function getBrands()
	{
		$sql = "SELECT *
				FROM brands";

		$rows = $this->excuteSQL($sql);

		$brands = array();

		foreach ($rows as $row) {
			$brands[$row['id']] = new BrandVO($row['id'], $row['name']);
		}

		return $brands;
	}



}
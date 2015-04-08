<?php

require_once __DIR__."/../VO/ProductVO.php";

class ProductDAO extends Database
{
	private $_photoDAO;
	private $_brandDAO;

	public function __construct($conn)
	{
		parent::__construct();
	}

	public function getProducts()
	{
		$rows = $this->select("products");

		$products = array();

		//how to get right things for ids
		//1.directly read from database?
		//2.create new object for each class
		//3.pass other objects as params

		foreach($rows as $row)
		{
			$products[$row['id']] = new ProductVO($row['name'], $row['price'], $row['description'], $row['brand']);
		}
	}

}
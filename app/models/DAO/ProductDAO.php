<?php

require_once __DIR__."/../VO/ProductVO.php";
require_once __DIR__."/../VO/BrandVO.php";
require_once __DIR__."/../VO/PhotoVO.php";
require_once __DIR__."/../VO/GearTypeVO.php";
require_once __DIR__."/../VO/SportTypeVO.php"; 

class ProductDAO extends CRUD
{
	//private $_photoDAO;
	//private $_brandDAO;

	public function __construct()
	{
		parent::__construct();
	}

	public function getProducts()
	{
		$photos     = $this->getPhotos();
		$brands     = $this->getBrands();
		$gearTypes  = $this->getGearTypes();
		$sportTypes = $this->getSportTypes();

		$rows = $this->select("products");

		$products = array();

		foreach($rows as $row)
		{
			$products[$row['id']] = new ProductVO($row['name'], $row['price'], $row['description'], $brands[$row['brandID']], $photos[$row['photoID']], $gearTypes[$row['gearTypeID']], $sportTypes[$row['sportTypeID']], $row['id']);
		}
		

		return $products;
	}

	/*
	*input: array contains all info about one new product
	*keys are field names
	*/
	public function addProduct($product)
	{
		$oldProductID = $this->isExist($product['name']);

		if($oldProductID)
		{
			return false;
		}

		$newProductID = $this->insert('products', $product);

		return $newProductID;
	}

	/*
	*check existense by checking product name
	*/
	public function isExist($productName)
	{
		$sql = "SELECT *
				FROM products
				WHERE name=:name";

		$param = array(':name'=>$productName);

		$rows = $this->executeSQL($sql, $param);

		if(sizeof($rows) != 0)
		{
			$productID = $rows[0]['id'];
		}

		return $productID = 0;
	}

	/*
	*
	*/
	public function getProductsByBrand($brandName)
	{

	}

	public function getProductsByGearType($gearType)
	{

	}

	public function getProductsBySportType($sportType)
	{

	}

	public function searchProductsByKeyword($keyword)
	{

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

	public function getPhotos()
	{
		$rows = $this->select("photos");

		$photos = array();

		foreach ($rows as $row) 
		{
			$photos[$row['id']] = new PhotoVO($row['name'], $row['alt'], $row['description'], $row['id']);
		}

		return $photos;
	}

	public function getGearTypes()
	{
		$rows = $this->select("gearTypes");

		$gearTypes = array();

		foreach ($rows as $row) {
			$gearTypes[$row['id']] = new GearTypeVO($row['id'], $row['name']);
		}

		return $gearTypes;
	}

	public function getSportTypes()
	{
		$rows = $this->select("sportTypes");

		$sportTypes = array();

		foreach ($rows as $row) {
			$sportTypes[$row['id']] = new SportTypeVO($row['id'], $row['name']);
		}

		return $sportTypes;
	}

}
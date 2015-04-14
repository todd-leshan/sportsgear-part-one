<?php

require_once __DIR__."/../VO/ProductVO.php";

require_once __DIR__."/../VO/PhotoVO.php";
require_once __DIR__."/../VO/GearTypeVO.php";
require_once __DIR__."/../VO/SportTypeVO.php"; 

require_once __DIR__."/../DAO/BrandDAO.php";

class ProductDAO extends CRUD
{
	//private $_photoDAO;
	private $_brandDAO;

	public function __construct()
	{
		parent::__construct();
		$this->_brandDAO = new BrandDAO();
	}

	public function getProducts()
	{
		$photos     = $this->getPhotos();
		$brands     = $this->_brandDAO->getBrands();
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

		if($oldProductID > 0)
		{
			return 0;
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

		$productID = 0;
		if(sizeof($rows) != 0)
		{
			$productID = $rows[0]['id'];
		}

		return $productID;
	}

	public function getProductbyId($productID)
	{
		$sql = "SELECT *
				FROM ";
	}
	/*
	*
	*/
	public function getProductsByBrand($brandName)
	{

	}

	public function getProductsByGearType($sportTypeID, $gearTypeID)
	{

	}

	public function getProductsBySportType($sportTypeID)
	{
		$photos     = $this->getPhotos();
		$brands     = $this->_brandDAO->getBrands();
		$gearTypes  = $this->getGearTypes();
		$sportTypes = $this->getSportTypes();

		$sql = "SELECT *
				FROM products
				WHERE sportTypeID=:sport";

		$param = array(':sport'=>$sportTypeID);

		$rows = $this->executeSQL($sql, $param);

		$products = array();

		foreach($rows as $row)
		{
			$products[$row['id']] = new ProductVO($row['name'], $row['price'], $row['description'], $brands[$row['brandID']], $photos[$row['photoID']], $gearTypes[$row['gearTypeID']], $sportTypes[$row['sportTypeID']], $row['id']);
		}
		

		return $products;
	}

	public function searchProductsByKeyword($keyword)
	{

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
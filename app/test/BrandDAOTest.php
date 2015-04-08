<?php

require_once __DIR__."/../models/DAO/BrandDAO.php";

class BrandDAOTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->brandDAO = new BrandDAO;
	}

	public function test()
	{
		$brands = $this->brandDAO->getBrands();

		$this->assertEquals(5, sizeof($brands), '5 brands');
	}
}
<?php

class ProductVO
{
	private $_id;
	private $_name;
	private $_price;
	private $_description;
	private $_brand;
	private $_photo;
	private $_gearType;
	private $_sportType;

	public function __construct($name, $price, $description, $brand, $photo, $gearType, $sportType, $id = 0)
	{
		//validation

		$this->_name = $name;
		$this->_price = $price;
		$this->_description = $description;
		$this->_brand = $brand;
		$this->_photo = $photo;
		$this->_gearType = $gearType;
		$this->_sportType = $sportType;
		$this->_id = $id;
	}

	public function getId()
	{
		return $this->_id;
	}

	public function getName()
	{
		return $this->_name;
	}

	public function getPrice()
	{
		return $this->_price;
	}

	public function getDescription()
	{
		return $this->_description;
	}

	public function getBrand()
	{
		return $this->_brand;
	}

	public function getPhoto()
	{
		return $this->_photo;
	}

	public function getGearType()
	{
		return $this->_gearType;
	}

	public function getSportType()
	{
		return $this->_sportType;
	}
}
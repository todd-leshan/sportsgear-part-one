<?php

class PhotoVO
{
	private $_id;
	private $_name;
	private $_alt;
	private $_description;

	public function __construct($name, $alt, $description, $id = 0)
	{
		$this->_name = $name;
		$this->_alt  = $alt;
		$this->_description = $description;
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

	public function getAlt()
	{
		return $this->_alt;
	}

	public function getDescription()
	{
		return $this->_description;
	}
}
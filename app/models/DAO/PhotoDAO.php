<?php

require_once __DIR__."/../VO/PhotoVO.php";

class PhotoDAO extends Database
{
	public function __construct()
	{
		parent::__construct();
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

	/*
	*check whether a photo with the same name exists in the dababase
	*return true if not; return false if exists
	*/
	//this may be used again, rewrite this in the parent class
	public function isExist($photoName)
	{
		$sql = "SELECT *
				FROM photos
				WHERE name=:name";

		$param = array(':name'=>$photoName);

		$row = $this->executeSQL($sql, $param);

		if(sizeof($row) != 0)
		{
			return false;
		}

		return true;
	}

	/*
	*insert new photo's info into database
	*if succeed, return id
	*input:
	*/
	public function addPhoto($name, $alt, $description)
	{
		$photo = array(
			'name'       =>$name,
			'alt'        =>$alt,
			'description'=>$description
			);

		$id = $this->insert('photos', $photo);

		return $id;
	}
}
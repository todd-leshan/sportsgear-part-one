<?php

require_once __DIR__."/../VO/PhotoVO.php";

class PhotoDAO extends CRUD
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

		$rows = $this->executeSQL($sql, $param);

		if(sizeof($rows) != 0)
		{
			$photoID = $rows[0]['id'];
		}

		return $photoID = 0;
	}

	/*
	*insert new photo's info into CRUD
	*if succeed, return id
	*input:
	*/
	public function addPhoto($photo)
	{
		$photoID = $this->isExist($photo['name']);

		if($photoID)
		{
			return $photoID;
		}

		$data = array(
			'name'       =>$photo['name'],
			'alt'        =>$photo['alt'],
			'description'=>$photo['description']
			);

		$id = $this->insert('photos', $data);

		return $id;
	}
}
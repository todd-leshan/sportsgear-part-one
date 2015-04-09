<?php

require_once __DIR__."/../VO/SportTypeVO.php";

class SportTypeDAO extends CRUD
{
	public function __construct()
	{
		parent::__construct();
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
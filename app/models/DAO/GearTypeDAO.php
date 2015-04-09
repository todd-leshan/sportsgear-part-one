<?php

require_once __DIR__."/../VO/GearTypeVO.php";

class GearTypeDAO extends CRUD
{
	public function __construct()
	{
		parent::__construct();
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
}
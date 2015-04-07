<?php

class ListModel extends Database
{
	public function __construct()
	{
		
	}

	public function addNewList($slName, $userID)
	{
		
		$conn = $this->conn();
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$sql = "INSERT INTO shoppinglist(listName, userID) 
				VALUES('".$slName."', ".$userID.")";

		//use exec() because no results are returned
		try
		{
			$conn->exec($sql);

			$newslID = $conn->lastInsertID();

			return $newslID;
		}
		catch(PDOException $e)
		{
			echo "Database error: ".$e->getMessage();
		}

		//$conn = null;
	}

	public function addNewItem($itemName, $quantity = 0, $listID)
	{
		$conn = $this->conn();

		$sql = "INSERT INTO listItems(itemName, quantity, listID) 
				VALUES('".$itemName."', ".$quantity.",".$listID.")";

		try
		{
			if($conn->query($sql))
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		catch(PDOException $e)
		{
			echo "Database error: ".$e->getMessage();
		}

		//$conn = null;
	}

	public function searchListsForUser($userID)
	{
		$conn = $this->conn();

		$sql = "SELECT *
				FROM shoppinglist
				WHERE userID=".$userID;

		try
		{
			$results = $conn->query($sql);
			return $results;
		}
		catch(PDOException $e)
		{
			echo "Database error: ".$e->getMessage();
		}
	}

	public function __destruct()
	{
		$conn = null;
	}
}
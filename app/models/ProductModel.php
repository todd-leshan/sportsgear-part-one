<?php

class ProductModel extends Database
{
	private $_conn;

	public function __construct()
	{
		$this->_conn = $this->connect();
	}

	/*
	*$table table name
	*return all fields from one table
	*/
	public function getAll($table)
	{
		$prepare = "SELECT * FROM $table";

		$results = $this->executeSQL($this->_conn, $prepare); 

		return $results;
	}

	/*
	*input: $table->table name; $id is the name of the id; $fields is an array contains the fields name which we want to keep
	*output: array: key is the id of that table while value is one line of that table
	*/

	public function getAll2($table, $id, $fields)
	{
		$rows = $this->getAll($table);
		$results = array();
		foreach ($rows as $row) {
			$line = array();
			foreach ($fields as $field) {
				//array_push($line, "$field=>$row[$field]");
				$line[$field] = $row[$field];
			}
			
			$results[$row[$id]] = $line;
			
		}

		return $results;
	}

	/*
	*insert new product into database
	*@param array $product which contains all info
	*/

	public function addNewProduct($product)
	{
		//check product name to ensure that no two products have the same name
		$prepare = "SELECT productID FROM products WHERE name=:name";
		
		$data = array(':name'=>$product['name']);
		
		$results  = $this->executeSQL($this->_conn, $prepare, $data); 

		foreach($results as $result)
		{
			if($result['productID'] > 0)
			{
				 return false;
			}
		}
		
		$newID = $this->insert($this->_conn, 'products', $product);

		return $newID;
	}

	/*
	*insert the photo info into database, return the photoID
	*if failed, return false
	*/
	public function uploadImage($photo)
	{
		//check whether a photo exists in the database or not
		$prepare = "SELECT photoID FROM photos WHERE name=:name";
		
		$data = array(':name'=>$photo['name']);
		
		$results  = $this->executeSQL($this->_conn, $prepare, $data); 

		foreach($results as $result)
		{
			if($result['photoID'] > 0)
			{
				 return $photoID = $result['photoID'];
			}
		}


		$photoID = $this->insert($this->_conn, 'photos', $photo);

		return $photoID;
	}
}
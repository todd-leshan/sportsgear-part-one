<?php

require_once __DIR__."/DB.php";

class CRUD
{
	private $_conn;

	//connect to DB
	public function __construct()
	{
		$this->_conn = DB::getConnection();
	}

	public function __destruct()
	{
		DB::disconnect();
	}


	/*
	*return an array
	*/
	public function executeSQL($prepareSQL, $param = [])
	{
		try 
		{
			$sql = $this->_conn->prepare($prepareSQL);
			$sql->execute($param);

			$rows = $sql->fetchAll();
			return $rows;
		} 
		catch (PDOException $e) 
		{
			echo $e->getMessage();
		}	
	}

	public function select($table)
	{
		$sql = "SELECT *
				FROM $table";

		$rows = $this->executeSQL($sql);

		return $rows;
	}

	/*
	*insert into CRUD and return the last insert ID
	*@param: $conn, $prepareSQL, $param
	*/
	public function insert($table, $data)
	{
		$columns = array();
		$values  = array();
		$q       = array();
		foreach ($data as $key => $value) {
			array_push($columns, $key);
			array_push($values, $value);
			array_push($q,'?');
		}

		$column = implode(',', $columns);
		$qs     = implode(',', $q);

		$prepare = "INSERT INTO $table($column) VALUES($qs)";

		$query = $this->_conn->prepare($prepare);

		$query->execute($values);

		$newID = $this->_conn->lastInsertId();

		return $newID;		
	}



	/*
	*check sth's existence
	*/
	
	/*
	public function isExist($conn, $table, $data)
	{
		$columns = array();
		$values  = array();
		foreach ($data as $key => $value) {
			array_push($columns, $key);
			array_push($values, $value);
			array_push($q,'?');
		}

		$column = implode('	AND ', $columns);
		$qs     = implode(',', $q);

		$prepare = "SELECT * FROM {$table} WHERE {}";
	}
	*/

	/*
More functions need to be defined here
sql query maker, query execute, different types
	*/

	/*
	*generate a select query
	*@fields
	*@tables array stores tables' name which need for this operation
	*@conditions, how to get the right one for PDO prepare
	*/

	public function selectMaker($fields, $tables)
	{
		$field = $this->addComa($fields);

		$table = $this->addComa($tables);

		return "SELECT $field FROM $table";
	}

	/*
	*SELECT&DELETE query generator
	*/
	private function querySD($type, $fields, $tables, $conditions = [])
	{
		if($type == "SELECT")
		{

		}
		elseif ($type == "INSERT INTO") 
		{
			# code...
		}
		elseif ($type == "UPDATE")
		{

		}
		elseif ($type == "DELETE")
		{

		}
	}

	/*
	*function which is used to assemble fields and tables for query
	*$sth is an array which may contain fields we need or table names
	*return a string like: sth1, sth2, sth3...
	*/

	private function addComa($sth)
	{
		if(sizeof($sth)==1)
		{
			return $sth[0];
		}
		else
		{
			return implode(",", $sth);
		}
	}

	/*
	*column and value pair generator
	*return a string like: col1=val1, col2=val2...
	*/

	private function column_value($columns, $values)
	{
		if(sizeof($columns) != sizeof($values))
		{
			die("Check Your Input and Try again!");
		}
		elseif(sizeof($columns) == 1)
		{
			$pair = $columns[0]."=".$values[0];
			return $pair;
		}
		else
		{
			foreach($columns as $col)
			{
				$val   = array_shift($values);
				$pairs[] = $col."=".$val;
			}

			$pair = implode(",", $pairs);
			return $pair;
		}
	}

	/*
	*function which is used to assemble condition for query
	*$condition is an array which can be empty
	*return a string like: array[0] array[1] array[2]...
	*/
	private function condition($conditions = [])
	{
		if(sizeof($conditions) == 0)
		{
			$condition = "";
			return $condition;
		}
		else
		{
			$condition = "WHERE ".implode(" ", $conditions);
			return $condition;
		}
	}
}
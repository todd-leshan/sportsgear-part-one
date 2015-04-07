<?php

class TestModel extends Database
{
	private $_conn;

	public function __construct()
	{
		$this->_conn = $this->connect();
	}

	public function test()
	{
		$sql = "SELECT * FROM brands";

		$rows = $this->_conn->query($sql);
		
		return $rows;
	}

	public function test1()
	{
		$username = 'todd';
		$password = sha1(md5(12));

		$sql = $this->_conn->prepare("SELECT * FROM staffs WHERE username = ? AND password = ?");

		$sql->execute(array($username, $password));

		//$user = $sql->fetchAll();
		//result:Array ( [0] => Array ( [staffID] => 1 [0] => 1 ) )
		//$user = $sql->fetch();
		$user = $sql->fetchColumn();
		//1
		echo "id- ";
		print_r($user);
		echo " -id";
	}

	public function test2()
	{
		$prepare1 = "SELECT * FROM brands";

		$brands  = $this->executeSQL($prepare1);

		$prepare2 = "SELECT * FROM category1";

		$cates  = $this->executeSQL($prepare2, 2);

		echo "<hr>";
		echo "brands:<br>";
		foreach($brands as $brand)
		{
			echo $brand['brandID']." - ".$brand['brandName'];
			echo "<br>";
		}
		echo "<hr>";
		echo "category<br>";
		foreach($cates as $cate)
		{
			echo $cate['cate']
		}
		echo "<hr>";
	}

	/*$return
	*1 fetchALL() by default
	*2 fetchColumn()
	*3 fecth()
	*/
	public function executeSQL($prepareSQL, $return = 1, $param = [])
	{
		$sql = $this->_conn->prepare($prepareSQL);
		$sql->execute($param);

		switch ($return)
		{
			case 1:
				$results = $sql->fetchAll();
				break;

			case 2:
				$results = $sql->fetchColumn();
				break;

			case 3:
				$results = $sql->fetch();
				break;
		}
		return $results;
	}

	public function __destruct()
	{
		$this->_conn = null;
	}
}
<?php

class Test extends Controller
{
	public function index()
	{
		//$test = $this->model("TestModel");
		/*
		$results = $test->test();
		foreach($results as $result)
		{
			echo $result['brandName'];
			echo "<br>";
		}
		*/
		//$login = 
		$test = $this->model("ProductModel");

		
		$brands = $test->getAll('brands');
		foreach ($brands as $brand) 
		{
			echo $brand['brandID']."~".$brand['brandName']."<br><hr>";
		}
		//print_r($login);
	}
}
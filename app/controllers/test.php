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
		$test = $this->model("BrandDAO");

		
		$brands = $test->getBrands();
		foreach ($brands as $brand) 
		{
			echo "id is ".$brand->getId()." name=".$brand->getName()."<br><hr>";
		}
		//print_r($login);
	}

	public function photo()
	{
		$photo = $this->model("PhotoDAO");

		$isExist = $photo->isExist("xhead-championship-4-ball-can.jpg");

		if($isExist)
		{
			echo "good";
		}
		else
		{
			echo "bad";
		}
	}

	public function sql()
	{
		$data = array(
			);
	}
}
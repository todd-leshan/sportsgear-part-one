<?php

class App
{
	//define default controller and default method
	protected $controller = 'home';
	protected $method     = 'index';

	protected $params     = [];//an empty array


	
	public function __construct()
	{
		$url = $this->parseUrl();

		//check whether a controller exists
		//not exist, call the default controller
		if(file_exists(__DIR__ . '/../controllers/'. $url[0]. '.php'))
		{
			$this->controller = $url[0];
			unset($url[0]);
		}

		require_once __DIR__ . '/../controllers/'. $this->controller .'.php';

		//create a new object
		$this->controller = new $this->controller;

		//check whether a method exists
		if(isset($url[1]))
		{
			if(method_exists($this->controller, $url[1]))
			{
				$this->method     = $url[1];
				unset($url[1]);
			}
		}

		//set param
		$this->params = $url?array_values($url) : [];
		
		call_user_func_array([$this->controller, $this->method], $this->params);


	}

	//basiclly exploding & trimming url
	//give parts of url to the controller
	public function parseUrl()
	{
		//using a HT access file to rewrite url and pass it through as a GET variable
		if(isset($_GET['url']))
		{
			//trim white space from right
			return $url = explode('/',filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
		}
	}
}
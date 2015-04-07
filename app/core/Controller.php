<?php
//announce access methods like view and model  to load models and render views
class Controller
{
	public function __construct()
	{
		session_start();
		define("BASE","http://localhost/sportsgear/");
	}	

	protected $message = null;
	//define kinds of error message here, then maybe we can use them again
	protected $error1 = "";
	protected $error2 = "";
	protected $error3 = "";
	protected $error4 = "";
	protected $error5 = "";


	public function model($model)
	{
		require_once __DIR__ . '/../models/'.$model.'.php';
		return new $model();
	}


	public function view($view, $data = [])
	{
		foreach ($data as $key => $value) 
		{
			${$key} = $value;
		}
		
		require_once __DIR__ . '/../views/'.$view.'.php';
	}

	/*
	*load error page, if sth goes wrong
	*/
	public function error($message)
	{
		$data = array(
				'title'   => "SportGear-Error",
				'mainView'=> 'error',
				'message' => $message
			);

		$this->view('page', $data);
	}
}
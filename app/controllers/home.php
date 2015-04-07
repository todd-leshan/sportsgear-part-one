<?php

class Home extends Controller
{
	public function index()
	{
		$data = array(
			'title'   => "SportGear-Professional Tennis&amp;Badminton equipments store",
			'mainView'=> 'index'
			);

		$this->view('page', $data);
	}
}
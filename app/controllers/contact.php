<?php

class Contact extends Controller
{
	public function index()
	{
		$data = array(
			'title'   => "SportGear-Contact us",
			'mainView'=> 'contact'
			);

		$this->view('page', $data);
	}

	public function sendMail()
	{
		$data = array(
			'title'   => "SportGear-send mail",
			'mainView'=> 'sendMail'
			);

		$this->view('page', $data);
	}
}
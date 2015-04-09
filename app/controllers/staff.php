<?php

class Staff extends Controller
{
	//load staff sign in view
	public function index()
	{
		//if session is still alive, redirect to staff page
		if(isset($_SESSION['staff']))
		{
			
			$staff = $_SESSION['staff'];

			$staffID  = $staff['staffID'];
			$username = $staff['username'];

			$this->profile($staffID, $username);
 		}
 		else
 		{
 			$data = array(
				'title'   => "SportGear-Staff Sign In",
				'mainView'=> 'signIn',
				'user'    => 'staff',
				'info'    => null
				);

			$this->view('page', $data);
		}
	}

	/*
	*staff sign in process
	*if fail, return to the sign in view with error message
	*if succeed, redirect to the profile page
	*/
	public function signIn()
	{
		if(isset($_POST['username']) && isset($_POST['password']))
		{
			$staff = $this->model('StaffDAO');
			$username = $_POST['username'];
			$password = $_POST['password'];
			//log in check, return staff object
			$staff  = $staff->signInCheck($username, $password);
			if($staff->getId() != 0)
			{
				//to staff  profile
				//set session here
				$id       = $staff->getId();
				$username = $staff->getUsername();

				//echo "id is ".$id."<br>";
				//echo "name is ".$username."<br>";
				//die();

				$_SESSION['staff'] = array(
										'staffID' => $id,
										'username'=> $username
										);
				$this->profile($id, $username);
			}
			else
			{
				//return to sign in view
				$this->signInFail('staff');
			}
		}
		else
		{
			$this->signInFail('staff');
		}
	}

	/*
	*if sign in failed, call this function to redirect page
	*@param = user type
	*/
	public function signInFail($user)
	{
		$data = array(
			'title'   => "SportGear-Sign In",
			'mainView'=> 'signIn',
			'user'    => 'staff',
			'info'    => 'Please enter valid username and password to sign in!'
			);

		$this->view('page', $data);
	}

	/*
	*sign out, destroy all session
	*/
	public function signOut()
	{
		session_destroy();
		$this->index();
	}

	/*
	*currently, there is only one link on this page
	*when clicking,redirect to product management page
	*
	*/
	public function profile($staffID = 0, $username = null)
	{
		if($staffID == 0 || $username == null)
		{
			$this->index();
		}
		$data = array(
			'title'   => "SportGear-user info",
			'mainView'=> 'staff',
			'user'    => 'staff',
			'username'=> $username
			);

		$this->view('page', $data);
	}

}
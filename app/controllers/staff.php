<?php

class Staff extends Controller
{
	private $_staffDAO;

	private $_productDAO;
	private $_brandDAO;
	private $_gearTypeDAO;
	private $_sportTypeDAO;

	public function __construct()
	{
		$this->_staffDAO    = $this->model('StaffDAO');

		$this->_productDAO  = $this->model('ProductDAO');
		$this->_brandDAO    = $this->model('BrandDAO');
		$this->_gearTypeDAO = $this->model('gearTypeDAO');
		$this->_sportTypeDAO= $this->model('sportTypeDAO');
	}

	public function isStaff()
	{
		/*
		if(!isset($_SESSION['staff']))
		{
 			$data = array(
				'title'   => "SportGear-Staff Sign In",
				'mainView'=> 'signIn',
				'user'    => 'staff',
				'info'    => null
				);
			$this->view('page', $data);

		}
		*/
	}

	//load staff sign in view
	public function index()
	{
		//if not log in, load log in page
		//$this->isStaff();

		//if loged in
		if(!isset($_SESSION['staff']))
		{
 			$data = array(
				'title'   => "SportGear-Staff Sign In",
				'mainView'=> 'signIn',
				'user'    => 'staff',
				'info'    => null
				);
			$this->view('page', $data);

		}
		else
		{
			$staff = $_SESSION['staff'];

			$staffID  = $staff['staffID'];
			$username = $staff['username'];

			$this->profile($staffID, $username);	
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
			//$staff = $this->model('StaffDAO');
			$username = $_POST['username'];
			$password = $_POST['password'];
			//log in check, return staff object
			$staff  = $this->_staffDAO->signInCheck($username, $password);
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

	/**********************************************************/
	//product management
	/*
	*add new products
	*/
	public function addProducts()
	{
		//$this->isStaff();
		//check all data passed here
		//if data detected, load model
		$brands    = $this->_brandDAO->getBrands();
		$gearTypes = $this->_gearTypeDAO->getGearTypes();
		$sportTypes= $this->_sportTypeDAO->getSportTypes();

		//photo upload
		if( 
			isset($_POST['newproduct_name']) &&
			isset($_POST['newproduct_price']) &&
			isset($_POST['newproduct_description']) &&
			isset($_POST['newproduct_brand']) &&
			isset($_POST['newproduct_cate1']) &&
			isset($_POST['newproduct_cate2']) &&
			isset($_FILES['newproduct_photo']) &&
			isset($_POST['photo_alt']) &&
			isset($_POST['photo_description'])
			)
		{
			//$isProductExist = $this->_productDAO->isExist($_POST['newproduct_name']);
			/*
			if($isProductExist > 0)
			{
				$this->message = 'Add new products failed!<br>You can not have the same product name!';	
				$this->error($this->message);
			}
			*/
			$gearTypeID = $_POST['newproduct_cate1'];
			$gearType   = $gearTypes[$gearTypeID]->getName();
			$file       = $_FILES['newproduct_photo'];
			//upload image first to get imageID
			$photo = array(
					'name'        => $_FILES['newproduct_photo']['name'],
					'alt'         => $_POST['photo_alt'],
					'description' => $_POST['photo_description']
				);
			
			$photoID = $this->uploadImage($file, $photo, $gearType);			

			//then insert new product
			$product = array(
					'name'        => $_POST['newproduct_name'],
					'price'       => $_POST['newproduct_price'],
					'description' => $_POST['newproduct_description'],
					'brandID'     => $_POST['newproduct_brand'],
					'gearTypeID'  => $gearTypeID,
					'sportTypeID' => $_POST['newproduct_cate2'],
					'photoID'     => $photoID
					);
			$newProductID = $this->_productDAO->addProduct($product);
			//die("error: ".$newProductID);
			if($newProductID == 0)
			{
				$this->message = 'Add new products failed!<br>You can not have the same product name!';
			}
			else
			{
				$this->message = "You've added a new product!";
			}
			//**************************************

		// $_FILES['newproduct_photo'] is an array ;
		}

		//if not, go back to the view; or when error found, go back the view with error
		//if(1!=1){}
		//always load the add form
		if($brands && $gearTypes && $sportTypes)
		{
			$data = array(
				'title'   => "SportGear-Add new products",
				'mainView'=> 'addNewProduct',
				'brands'  => $brands,
				'gearTypes'=>$gearTypes,
				'sportTypes'=>$sportTypes,
				'message'  =>$this->message
			);

			$this->view('page', $data);
		}
		else
		{
			$this->message = 'Sorry, We are trying to fix this. Please try again!!!';
			$this->error($this->message);
		}
	}

	/*
	*input: array contains all info of a photo
	*categoryID
	*output:photoID
	*/
	public function uploadImage($file, $photo, $gearType)
	{
			$target_dir = "../public/images/product/$gearType/";
			$target_file= $target_dir.basename($file['name']);

			$uploadOK = 1;
			//better $fileType = $file['type']; => 'image/jpeg'
			$fileType = pathinfo($target_file, PATHINFO_EXTENSION);
			//add sth to make sure an image is uploaded
			$isImage = getimagesize($file['tmp_name']);
			if($isImage === false)
			{
				$this->message .= "Sorry, please upload a real image!<br>";
				$uploadOK = 0;
			}

			if(file_exists($target_file))
			{
				$this->message .= "Sorry, Image exists!<br>";
				$uploadOK = 0;
			}

			if($file['size'] > 2000000)//2mb
			{
				$this->message .= "Sorry, Your file is too big!<br>";
				$uploadOK = 0;
			}

			$allowedType = array('jpg','gif','jpeg','png');
			if(!in_array($fileType, $allowedType))
			{
				$this->message .= "Sorry, only ".implode(', ', $allowedType)." files are allowed!<br>";
				$uploadOK = 0;
			}
			  
			if($uploadOK == 0)
			{
				$this->error($this->message);
			}

			$this->message = '';

			//move file to the target directory
			if(!move_uploaded_file($file['tmp_name'], $target_file))
			{
				$this->message = "Photo upload failed!";
				$this->error($this->message);
				//do we need to do sth to stop 
			}
			else
			{
				$photoDAO = $this->model('PhotoDAO');
				$photoID  = $photoDAO->addPhoto($photo);
				if($photoID == false)
				{
					$this->message = "Can not insert photo infomation into Database!!!";
					$this->error($this->message);
				}
				return $photoID;
			}
	}

	public function manageProducts($params = [])
	{
		//$this->isStaff();

		//use $params directly to get id
		$products = $this->_productDAO->getProducts();
		
		if(sizeof($products) > 0) 
		{
			$data = array(
				'title'    => "SportGear-manage products",
				'mainView' => 'manageProducts',
				'products' => $products,
				'message'  => $this->message
			);

			$this->view('page', $data);
		}
		else
		{
			$this->message = 'Sorry, We don\'t have any products now.';
			$this->error($this->message);
		}
	}

}
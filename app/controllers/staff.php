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
				'mainView'=> 'signin',
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
			$user = $this->model('UserModel');
			$username = $_POST['username'];
			$password = $_POST['password'];
			//log in check, if succeed, return the user ID
			$staffID  = $user->signIn($username, $password);
			if($staffID)
			{
				//to staff  profile
				//set session here

				$_SESSION['staff'] = array(
										'staffID' => $staffID,
										'username'=> $username
										);
				$this->profile($staffID, $username);
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

	/*
	*add new products
	*/
	public function addNewProducts()
	{
		//check all data passed here
		//if data detected, load model
		$model = $this->model('ProductModel');

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
			$category1ID = $_POST['newproduct_cate1'];
			$file        = $_FILES['newproduct_photo'];
			//upload image first to get imageID
			$photo = array(
					'name'        => $_FILES['newproduct_photo']['name'],
					'alt'         => $_POST['photo_alt'],
					'description' => $_POST['photo_description']
				);
			
			$photoID = $this->uploadImage($model, $file, $photo, $category1ID);			

			//then insert new product
			$product = array(
					'name'        => $_POST['newproduct_name'],
					'price'       => $_POST['newproduct_price'],
					'description' => $_POST['newproduct_description'],
					'brandID'     => $_POST['newproduct_brand'],
					'category1ID' => $category1ID,
					'category2ID' => $_POST['newproduct_cate2'],
					'photoID'     => $photoID
					);
			$newProductID = $model->addNewProduct($product);
			//die("error: ".$newProductID);
			if($newProductID == false)
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
		

		$brands = $model->getAll('brands');
		$cate1  = $model->getAll('category1');
		$cate2  = $model->getAll('category2');

		if($brands && $cate1 && $cate2)
		{
			$data = array(
				'title'   => "SportGear-Add new products",
				'mainView'=> 'addNewProduct',
				'brands'  => $brands,
				'category1'=>$cate1,
				'category2'=>$cate2,
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
	public function uploadImage($model, $file, $photo, $category1ID)
	{
		switch ($category1ID)
			{
				case 1:
					$category1 = "racquet";
					break;
				case 2:
					$category1 = "ball";
					break;
				case 3:
					$category1 = "footwear";
					break;
				case 4:
					$category1 = "clothing";
					break;
				case 5:
					$category1 = "accessory";
					break;
			}
			$target_dir = "../public/images/product/$category1/";
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

			if(file_exists($target_dir, $file['name']))
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
			}
			else
			{
				$photoID = $model->uploadImage($photo);
				if($photoID == false)
				{
					$this->message = "Can not insert photo infomation into database!!!";
					$this->error($this->message);
				}
				return $photoID;
			}
	}

	public function allProducts($params = [])
	{
		//use $params directly to get id

		$productModel = $this->model("ProductModel");

		$products = $productModel->getAll('products');
		$photos   = $productModel->getAll2('photos','photoID', array('name', 'alt'));
		$brands   = $productModel->getAll2('brands', 'brandID', array('brandName'));
		$category1= $productModel->getAll2('category1', 'cate1ID', array('cate1'));
		$category2= $productModel->getAll2('category2', 'cate2ID', array('cate2'));

		if(sizeof($products) > 0) 
		{
			$data = array(
				'title'    => "SportGear-All products",
				'mainView' => 'products',
				'products' => $products,
				'photos'   => $photos,
				'brands'   => $brands,
				'category1'=> $category1,
				'category2'=> $category2,
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
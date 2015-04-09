<?php

class Product extends Controller
{
	private $_product;

	//load all products
	public function index()
	{
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

	//load products by category1

	//load products by category2

	//load products by searching

	//how to load products by combining limits

	/*
	*add new products
	*/
	public function addProducts()
	{
		//check all data passed here
		//if data detected, load model
		$productDAO  = $this->model('ProductDAO');
		$brandDAO    = $this->model('BrandDAO');
		$gearTypeDAO = $this->model('gearTypeDAO');
		$sportTypeDAO= $this->model('sportTypeDAO');

		$brands    = $brandDAO->getBrands();
		$gearTypes = $gearTypeDAO->getGearTypes();
		$sportTypes= $sportTypeDAO->getSportTypes();

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
			$newProductID = $productDAO->addProduct($product);
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
		//use $params directly to get id
		$productDAO = $this->model("ProductDAO");

		$products = $productDAO->getProducts();
		
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
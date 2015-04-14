
<div id="wrapper" class="clearFix">

<table>
	<tr>
		<th class="productName">Name</th>
		<th class="productPrice">Price</th>
		<th class="productDesc">Description</th>
		<th class="productPhoto">Photo</th>
		<th class="productbrand">Brand</th>
		<th class="productCate1">Category</th>
		<th class="productCate2">Sport</th>
		<th></th>
	</tr>
<?php 
foreach ($products as $product) :
	$productID    = $product->getId();
	$name         = $product->getName();
	$price        = $product->getPrice();
	$description  = $product->getDescription();
	
	$photo        = $product->getPhoto();
	$photoName    = $photo->getName();
	$photoAlt     = $photo->getAlt();
	
	$brand        = $product->getBrand();
	$brandName    = $brand->getName();
	
	$gearType     = $product->getGearType();
	$gearTypeName = $gearType->getName();
	
	$sportType    = $product->getSportType();
	$sportTypeName= $sportType->getName();
?>	
	<tr>
		<td><?php echo $name; ?></td>
		<td><?php echo $price; ?></td>
		<td><?php echo $description; ?></td>
		<td><img src="/sportsgear/public/images/product/<?php echo $gearTypeName.'/'.$photoName; ?>" alt="<?php echo $photoAlt;?>"></td>
		<td><?php echo $brandName; ?></td>
		<td><?php echo $gearTypeName; ?></td>
		<td><?php echo $sportTypeName; ?></td>
		<td><a href="<?php echo ROOT.'staff/editProduct/'.$productID; ?>">Edit</a></td>
	</tr>
<?php
endforeach;
?>
</table>

<p class="goBack"><a href="<?php echo ROOT.'staff'; ?>">Back to Menu</a></p>
<p class="logout"><a href="<?php echo ROOT.'staff/signOut'; ?>">Sign Out</a></p>

</div>
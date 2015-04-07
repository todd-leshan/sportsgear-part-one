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
?>	
	<tr>
		<td><?php echo $product['name'] ?></td>
		<td><?php echo '$'.$product['price'] ?></td>
		<td><?php echo $product['description'] ?></td>
		<td><img src="/sportsgear/public/images/product/<?php echo $category1[$product['category1ID']]['cate1'].'/'.$photos[$product['photoID']]['name']; ?>" alt="<?php echo $photos[$product['photoID']]['alt'];?>"></td>
		<td><?php echo $brands[$product['brandID']]['brandName']; ?></td>
		<td><?php echo $category1[$product['category1ID']]['cate1']; ?></td>
		<td><?php echo $category2[$product['category2ID']]['cate2']; ?></td>
		<td><a href="<?php echo ROOT.'product/editProduct/'.$product['productID']; ?>">Edit</a></td>
	</tr>
<?php
endforeach;
?>
</table>

<p class="goBack"><a href="<?php echo ROOT.'staff'; ?>">Back to Menu</a></p>
<p class="logout"><a href="<?php echo ROOT.'staff/signOut'; ?>">Sign Out</a></p>

</div>
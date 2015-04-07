<div id="wrapper" class="clearFix">

<table>
	<tr>
		<th>Name</th>
		<th>Price</th>
		<th>Description</th>
		<th>Photo</th>
		<th>Brand</th>
		<th>Category</th>
		<th>Sport</th>
	</tr>
<?php 
foreach ($products as $product) :
?>	
	<tr>
		<th><?php echo $product['name'] ?></th>
		<th><?php echo '$'.$product['price'] ?></th>
		<th><?php echo $product['description'] ?></th>
		<th><img src="/sportsgear/public/images/product/<?php echo $category1[$product['category1ID']]['cate1'].'/'.$photos[$product['photoID']]['name']; ?>" alt="<?php echo $photos[$product['photoID']]['alt'];?>"></th>
		<th><?php echo $brands[$product['brandID']]['brandName']; ?></th>
		<th><?php echo $category1[$product['category1ID']]['cate1']; ?></th>
		<th><?php echo $category2[$product['category2ID']]['cate2']; ?></th>
	</tr>
<?php
endforeach;
?>
</table>

<p class="goBack"><a href="<?php echo ROOT.'staff'; ?>">Back to Menu</a></p>
<p class="logout"><a href="<?php echo ROOT.'staff/signOut'; ?>">Sign Out</a></p>

</div>
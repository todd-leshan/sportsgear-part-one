<div id="wrapper" class="clearFix">


<section id="filter" class="float-left">
add sth later
</section>

<section id="products-container" class="float-left clearFix">
<?php 
if(sizeof($products) > 0){
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
		<article class="float-left">
		<!--need a place to store id-->
			<div>
				<img src="/sportsgear/public/images/product/<?php echo $gearTypeName.'/'.$photoName; ?>" alt="<?php echo $photoAlt;?>" width="240" height="320">
			</div>
			<h4><?php echo $name; ?></h4>
			<p>$<?php echo $price; ?></p>
			<p><?php echo $description; ?></p>
			<p><a href="<?php echo ROOT.'product/product/'.$productID; ?>">More Info</a></p>
		</article>
	<?php
	endforeach;
}
else
{
	echo "No products found! Try again!";
}
?>

</section>

</div>
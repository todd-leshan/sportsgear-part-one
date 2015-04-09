<?php 
if(!isset($_SESSION['staff']))
{
	header("Location:".ROOT."staff");
}
?>
<div id="wrapper" class="clearFix">

<form id="addNewProduct" class="mainform" method="post" action="<?php echo ROOT.'product/addProducts'; ?>" enctype="multipart/form-data">
	<fieldset>
		<legend>Add a new product:</legend>
		<p>
			<?php echo $message; ?>
		</p>
		<p>You must fill all fields with *.</p>
		<p>
			<label for="newproduct_name">*Product Name:</label>
			<input type="text" name="newproduct_name" id="newproduct_name" required pattern="[a-zA-Z0-9_ -]*" maxlength="20" />
			<span class="error">This field is required!</span>
		</p>
		<p>
			<label for="newproduct_price">*Product Price:</label>
			<input type="number" name="newproduct_price" id="newproduct_price" required min="0" step="0.01" >
		</p>
		<p>
			<label for="newproduct_description">*Description:</label>
			<textarea name="newproduct_description" id="newproduct_description" required></textarea>
			<span class="error">This field is required!</span>
		</p>
<!--brands selector-->
		<p class="clearFix">
			<label for="brands-select">*Brands:</label>
			<select class="form-control" id="brands-select" name="newproduct_brand">
			<option>Please select</option>
<?php
		foreach($brands as $brand):
			$brandID = $brand->getId();
			$brandName = $brand->getName();
?>
			<option value="<?php echo $brandID;?>"><?php echo $brandName;?></option>				
<?php
		endforeach;
?>
			</select>
			<span class="error">This field is required!</span>
		</p>

		
<!--category1-->
		<p class="clearFix">
			<label for="category1-select">*Category:</label>
			<select class="form-control" id="category1-select" name="newproduct_cate1">
			<option>Please select</option>
<?php
		foreach($gearTypes as $gearType):
			$gearTypeID   = $gearType->getId();
			$gearTypeName = $gearType->getName();
?>
			<option value="<?php echo $gearTypeID;?>"><?php echo $gearTypeName;?></option>
				
<?php
		endforeach;
?>
			</select>
			<span class="error">This field is required!</span>
		</p>
	
<!--tennis or badminton-->		
		<p class="radio">
			<label class="mainform-label">*Sports:</label>
<?php
		foreach($sportTypes as $sportType):
			$sportTypeID     = $sportType->getId();
			$sportTypeName   = $sportType->getName();
?>
			<label for="sport-<?php echo $sportTypeName;?>">
				<input type="radio" name="newproduct_cate2" id="sport-<?php echo $sportTypeName;?>" value="<?php echo $sportTypeID;?>">
			<?php echo $sportTypeName;?>
			</label>
					
				
<?php
		endforeach;
?>
			<span class="error">This field is required!</span>
		</p>
<!-- photo -->
		<p>
			<label for="newproduct_photo">*Photo:</label>
			<input type="file" name="newproduct_photo" id="newproduct_photo" required />
			<span class="error">This field is required!</span>
		</p>

		<p>
			<label for="photo_alt">*Photo Alt:</label>
			<input type="text" name="photo_alt" id="photo_alt" required maxlength="20" />
			<span class="error">This field is required!</span>
		</p>

		<p>
			<label for="photo_description">*Photo Description:</label>
			<textarea name="photo_description" id="photo_description" required></textarea>
			<span class="error">This field is required!</span>
		</p>

		<p class="buttons">
			<button type="submit" id="addNewButton">Add</button>
			<button type="reset" id="resetButton">Reset</button>
		</p>

	</fieldset>
</form>

<p class="goBack"><a href="<?php echo ROOT.'staff'; ?>">Back to Menu</a></p>
<p class="logout"><a href="<?php echo ROOT.'staff/signOut'; ?>">Sign Out</a></p>

</div>
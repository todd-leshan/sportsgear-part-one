<div id="wrapper" class="clearFix">
<form id="signin" method="post" action="<?php echo ROOT.$user.'/signIn'; ?>" class="mainform">
	<fieldset>
<?php
	if($user == 'staff')
	{
?>
	<legend>Sign In as a staff:</legend>
<?php
	}
	else
	{
?>
	<legend><a href="">If You want to sign up with us, click here:</a></legend>
<?php
	}
?>

<?php
	if($info)
	{
?>
	<p class="info"><?php echo $info; ?></p>
<?php		
	}
?>
		
		<p>You must fill all fields with *.</p>
		<p>
			<label for="signin-username">*Username:</label>
			<input type="text" name="username" id="signin-username" required maxlength="12" pattern="[a-zA-Z0-9_-]*" />
			<span class="error">This field is required!</span>
		</p>
		<p>
			<label for="signin-password">*Password:</label>
			<input type="password" name="password" id="signin-password" required maxlength="12" pattern="[a-zA-Z0-9_-]*" />
			<span class="error">This field is required!</span>
		</p>

		<p class="buttons">
			<button type="submit" id="signinButton">Submit</button>
			<button type="reset" id="resetButton">Reset</button>
		</p>
	</fieldset>
</form>

</div>



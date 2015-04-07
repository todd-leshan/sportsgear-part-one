<div id="wrapper" class="clearFix">
<form id="contact" method="post" action="<?php echo ROOT.'contact/sendMail'?>" class="mainform" novalidate>
	<fieldset>
		<legend>Please leave your detail here:</legend>
		<p>You must fill all fields with *.</p>
		<p>
			<label for="contact_firstname">*First Name:</label>
			<input type="text" name="firstname" id="contact_firstname" required pattern="[a-zA-Z0-9_-]*" />
			<span class="error">This field is required!</span>
		</p>
		<p>
			<label for="contact_lastname">*Last Name:</label>
			<input type="text" name="lastname" id="contact_lastname" required />
			<span class="error">This field is required!</span>
		</p>
		<p>
			<label for="contact_phone">Contact Number:</label>
			<input type="text" name="phone" id="contact_phone" />
			<span class="error">Please enter a valid australia phone number!</span>
		</p>
		<p>
			<label for="contact_email">*Email:</label>
			<input type="email" name="email" id="contact_email" required />
			<span class="error">Please enter a valid email address!</span>
		</p>
		<p>
			<label for="contact_message">*Message:</label>
			<textarea name="message" id="contact_message" required></textarea>
			<span class="error">This field is required!</span>
		</p>
		<p class="buttons">
			<button type="submit" id="submitButton">Submit</button>
			<button type="reset" id="resetButton">Reset</button>
		</p>
	</fieldset>
</form>

<input id="map-input" class="controls" type="text" placeholder="Search your nearest court">
<div id="map-canvas"></div>

</div>


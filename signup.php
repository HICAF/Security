<?php require 'header.php'; ?>

		<form method="POST" id="signup-form">
			<div class="form-group">
			  <label for="firstname">First name:</label>
			  <input type="text" name="firstname" class="form-control" id="">
			</div>
			<div class="form-group">
			  <label for="lastname">Last name:</label>
			  <input type="text" name="lastname" class="form-control" id="">
			</div>
			<div class="form-group">
			  <label for="username">Username:</label>
			  <input type="text" name="username" class="form-control" id="">
			</div>
			<div class="form-group">
			  <label for="email">Email:</label>
			  <input type="email" name="email" class="form-control" id="">
			</div>
			<div class="form-group">
			  <label for="password">Password:</label>
			  <input type="password" name="password" class="form-control" id="">
			</div>
			<div class="form-group">
				<input type="checkbox" name="rememberMe" value="true"> Remember me
			</div>
			<div class="g-recaptcha" data-sitekey="6LdTeyATAAAAAHUaIPdYoCKM3IZIn76wJqxe1Cqs"></div>
			<br>
			<input type="submit" class="btn btn-primary btn-lg" id="btn-signup" value="Sign Up"><br />
		</form>
			<a href="login.php">Already signed up?</a>
		

		
<?php require 'footer.php'; ?>



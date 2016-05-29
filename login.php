<?php require 'header.php'; ?>
<?php require 'src/SMSApi.php'; ?>

		<form method="POST" id="login-form">
			<div class="form-group">
			  <label for="username">Username:</label>
			  <input type="text" name="username" class="form-control" id="">
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
			<input type="submit" class="btn btn-primary btn-lg" id="btn-login" value="Login"><br />
			<a id="btn-retrieve-password">Forgot password?</a> | 
			<a href="signup.php">Sign up!</a>
		</form>

		
<?php require 'footer.php'; ?>
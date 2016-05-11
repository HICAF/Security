<?php require 'header.php'; ?>

		<form>
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
			<input class="btn btn-primary" type="submit">
			<a href="login.php">Already signed up?</a>
		</form>
		
		
<?php require 'footer.php'; ?>



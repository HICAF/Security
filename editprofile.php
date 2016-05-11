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
			  <label for="email">Email:</label>
			  <input type="email" name="email" class="form-control" id="">
			</div>
			<div class="form-group">
			  <label for="password">Old password:</label>
			  <input type="password" name="password" class="form-control" id="">
			</div>
			<div class="form-group">
			  <label for="new-password">New password:</label>
			  <input type="password" name="new-password" class="form-control" id="">
			</div>
			<div class="form-group">
			  <label for="new-password-repeat">Repeat password:</label>
			  <input type="password" name="new-password-repeat" class="form-control" id="">
			</div>
			
			<!--TODO: Make nice. -->
			<div class="form-group">
			
				<label class="control-label">Profile picture:</label>	
				<span class="btn btn-default btn-file">
					Browse <input type="file">
				</span>
			</div>
			<br>
			
			<input class="btn btn-primary" type="submit">
			<a href="profile.php">Nevermind.</a>
		</form>
		
<?php require 'chat.php'; ?>
	
<?php require 'footer.php'; ?>
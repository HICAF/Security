<?php require 'header.php'; 

	if ($_SESSION['user'] != "") {
		$dbUsers = $oDb->query("SELECT * FROM users WHERE user_id = '".$_SESSION['user']."'");
		$aUser = $dbUsers->fetchAll(PDO::FETCH_ASSOC);

		$sUsername = $aUser[0]['username'];
		$sEmail = $aUser[0]['email'];

		$sFirstName = $aUser[0]['first_name'];
		$sLastName = $aUser[0]['last_name'];

	} else {
		echo "
			<script>
				alert('YOU ARE NOT LOGGED IN');
				window.location.href='index.php';
			</script>";

		header("location: index.php");
	}
 ?>

		<form method="POST" id="update-form">
			<div class="form-group">
				<label for="username">Username: </label>
				<input type="text" name="username" class="form-control" placeholder="<?php echo $sUsername; ?>"/>
			</div>
			<div class="form-group">
				<label for="firstname">First Name: </label>
				<input type="text" name="firstname" class="form-control" placeholder="<?php echo $sFirstName; ?>" />
			</div>
			<div class="form-group">
				<label for="lastname">Last Name: </label>
				<input type="text" name="lastname" class="form-control" placeholder="<?php echo $sLastName; ?>"/>
			</div>
			<div class="form-group">
				<label for="email">Email: </label>
				<input type="text" name="email" class="form-control" placeholder="<?php echo $sEmail; ?>" />
			</div>
			
			<div class="form-group">
				<label for="email">Change your password: </label>
				<input type="password" class="form-control" name="password" placeholder="New password" value="" /><br />
				<input type="password" class="form-control" name="passwordcheck" placeholder="Retype password" value="" />
			</div>
			<br>
			<div class="g-recaptcha" data-sitekey="6LdTeyATAAAAAHUaIPdYoCKM3IZIn76wJqxe1Cqs"></div>
			<br>
			<input type="submit" id="btn-UpdateProfile" class="btn btn-default" value="Update my profile">
		</form>
		<div id="responseUpdateProfile"></div>
		<br>
		<button type="button" class="btn btn-primary logout">Log out</button>
		<button id="btnDeleteUser" type="button" class="btn btn-danger">Delete account</button>
		<div id="deleteConfirmation">
		</div>
		

<?php require 'footer.php'; ?>
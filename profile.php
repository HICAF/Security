<?php require 'header.php'; ?>

	
 <?php
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

		<div class="profile-picture"></div>
		
		<label>Username: </label><input type="text" name="username" placeholder="<?php echo $sUsername; ?>" value=""/> <br />
		<label>First Name: </label><input type="text" name="firstname" placeholder="<?php echo $sFirstName; ?>" value="" /><br />
		<label>Last Name: </label><input type="text" name="lastname" placeholder="<?php echo $sLastName; ?>" value=""/><br />
		<label>Email: </label><input type="text" name="email" placeholder="<?php echo $sEmail; ?>" value="" />

<br /><br />
		
		<label>Change your password</label><br />
		<input type="password" name="password" placeholder="New password" value="" /><br />
		<input type="password" name="passwordcheck" placeholder="Retype password" value="" /><br />

<br /><br />
		
		<button id="btn-UpdateProfile" type="button" class="btn btn-primary">update my profile</button>
		<div id="responseUpdateProfile"></div>
		<br>
		<button type="button" class="btn btn-primary logout">log out</button>
		<br><br />
		<button id="btnDeleteUser" type="button" class="btn btn-danger">delete user</button>
		<div id="deleteConfirmation">
		</div>
		

<?php require 'footer.php'; ?>
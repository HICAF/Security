<?php 
	require "dbconnect.php";
	require "functions.php";
 ?>

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
 <script type="text/javascript">
 	console.log("<?php echo $_SESSION['user']; ?>")
 </script>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="favicon.png">
	<title>KEA FridayBar social - USER</title>

	<!-- CDN LOCAL -->
	<!-- <link rel="stylesheet" type="text/css" href="../cdn/bootstrap.min.css"> -->
	<!-- <link rel="stylesheet" type="text/css" href="../cdn/jquery-ui.min.css"> -->
	<!-- <link rel="stylesheet" type="text/css" href="../cdn/Font-Awesome-master/css/font-awesome.min.css"> -->
	<!-- <link rel="stylesheet" type="text/css" href="../cdn/sweetalert.css"> -->

	<!-- JQuery -->
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

	<!-- Fontawesome -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>

	<h2>Your Profile</h2>
		<label>Username: </label><input type="text" id="usernameProfile" placeholder="<?php echo $sUsername; ?>" value=""/> <br />
		<label>First Name: </label><input type="text" id="firstNameProfile" placeholder="<?php echo $sFirstName; ?>" value="" /><br />
		<label>Last Name: </label><input type="text" id="lastNameProfile" placeholder="<?php echo $sLastName; ?>" value=""/><br />
		<label>Email: </label><input type="text" id="emailProfile" placeholder="<?php echo $sEmail; ?>" value="" />

<br /><br />
		
		<label>Change your password</label><br />
		<input type="password" id="passwordProfile" placeholder="New password" value="" /><br />
		<input type="password" id="passwordCheckProfile" placeholder="Retype password" value="" /><br />

<br /><br />
		
		<button id="btn-UpdateProfile" type="button" class="btn btn-primary">update my profile</button>
		<div id="responseUpdateProfile"></div>
		<br>
		<button type="button" class="btn btn-primary logout">log out</button>
		<br><br />
		<button id="btnDeleteUser" type="button" class="btn btn-danger">delete user</button>
		<div id="deleteConfirmation">
		</div>
	


	<!-- JQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script> 
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script> 

	<!-- Latest compiled and minified JavaScript bootstrap -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script> 

	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script> 

	<script src="script.js"></script>
</body>
</html>
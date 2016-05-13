<?php 
	require "dbconnect.php";
	require "functions.php";

	$id = $_GET['id'];
 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="favicon.png">
	<title>KEA FridayBar social - RESET PASSWORD</title>

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
<h1>Reset your password</h1><br />
<label>Change your password</label><br />
		<input type="password" id="passwordReset" placeholder="New password" value="" /><br />
		<input type="password" id="passwordCheckReset" placeholder="Retype password" value="" /><br />
		<button data-id="<?php echo $id; ?>" class="btn btn-success" id="btn-password-reset">Go! &nbsp;<i class="fa fa-arrow-right"></i></button>




	<!-- JQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script> 
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script> 

	<!-- Latest compiled and minified JavaScript bootstrap -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script> 

	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script> 

	<script src="script.js"></script>
</body>
</html>
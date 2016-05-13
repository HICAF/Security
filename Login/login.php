<?php 
	require "dbconnect.php";
	require "functions.php";
 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="favicon.png">
	<title>KEA FridayBar social - LOGIN</title>

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
<h1>Login!</h1><br />
	<input name="text" type="text" required placeholder="Username" id="usernameLogin">
	<input name="password" type="password" required placeholder="password" id="passwordLogin"><br><br>
	<div class="login-btns">
	<button id="btn-login" class="btn btn-success btn-block">proceed &nbsp;<i class="fa fa-arrow-right"></i></button>
	<button class="btn btn-default btn-sm btn-block" id="btn-retrieve-password">Forgot your password? &nbsp;<i class="fa fa-arrow-right"></i></button> </button>




	<!-- JQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script> 
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script> 

	<!-- Latest compiled and minified JavaScript bootstrap -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script> 

	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script> 

	<script src="script.js"></script>
</body>
</html>
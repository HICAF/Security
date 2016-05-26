<?php 
	require 'src/dbconnect.php';
	// grab recaptcha library

 	$user = $_SESSION["user"];
 	$admin = $_SESSION["admin"];


$host = basename($_SERVER['REQUEST_URI']);
$host = strtolower($host);
if ($user != "") {
	if(strrpos($host, 'login.php') !== false ) { header('location: profile.php'); }
	else if(strrpos($host, 'signup.php') !== false ) { header('location: profile.php'); }
} else {
	if(strrpos($host, 'profile.php') !== false ) { header('location: index.php'); }
	else if(strrpos($host, 'gifaccept.php') !== false ) { header('location: index.php'); }
	else if(strrpos($host, 'gifupload.php') !== false ) { header('location: index.php'); }
}
 
?>

<!DOCTYPE html>

<html>

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="shortcut icon" href="favicon.ico" />	
		
		<!-- Normanlize -->
		<link rel="stylesheet" href="css/normalize.css"> 
		
		<!-- Bootstrap -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		
		<!-- FontAwesome -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
		
		<!-- JQuery -->
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">

		<!-- SweetAlert -->
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">

		<!-- Custom CSS -->
		<link rel="stylesheet" href="css/style.css"> 
		<link rel="stylesheet" href="css/fileupload.css"> 

		<!-- Google reCAPTCHA -->
		<script src='https://www.google.com/recaptcha/api.js'></script>
		<title>Gif Wall</title>
	</head>

	<body>

		<nav class="navbar navbar-default">
		  <div class="container-fluid">
		    <!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		      <a class="navbar-brand" href="index.php"><i class="fa fa-beer" aria-hidden="true"></i> Gif wall</a>
		    </div>

		    <!-- Collect the nav links, forms, and other content for toggling -->
		    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		      <ul class="nav navbar-nav navbar-right">
		      	<?php if ($user != "") { ?>
							<li><a href="gifupload.php">Upload Gif</a></li>
							<?php if ($admin == "1") { ?>
								<li><a href="gifaccept.php">Approve Gifs</a></li>
							<?php } ?>
		        	<li><a href="profile.php">Profile <i class="fa fa-user" aria-hidden="true"></i></a></li>
						<?php } ?>
		      </ul>
		    </div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>
		
		<div class="wrapper">

		
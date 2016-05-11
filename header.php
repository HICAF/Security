<!-- In here the common header -->
<!-- TODO Require in all pages -->
<!-- TODO Consistency: Gif or GIF? -->

<!DOCTYPE html>

<html>

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="shortcut icon" href="favicon.ico" />	
		<link rel="stylesheet" href="css/normalize.css"> 
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="css/style.css"> 
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
						<!-- TODO only show when logged in. -->
						<li><a href="gifupload.php">Upload Gif</a></li>
						<!-- TODO only show to admins -->
						<li><a href="gifaccept.php">Approve Gifs</a></li>
		        <li>
							<a href="profile.php">Profile <i class="fa fa-user" aria-hidden="true"></i></a>
						</li>
		      </ul>
		    </div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>
		
		<div class="wrapper">

		
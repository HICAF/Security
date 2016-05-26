<?php	require 'header.php'; 

	if ($_SESSION['user'] != "") {
		$dbUsers = $oDb->query("SELECT * FROM users WHERE user_id = '".$_SESSION['user']."'");
		$aUser = $dbUsers->fetchAll(PDO::FETCH_ASSOC);

		$sUsername = $aUser[0]['username'];
		$sEmail = $aUser[0]['email'];

		$sFirstName = $aUser[0]['first_name'];
		$sLastName = $aUser[0]['last_name'];

		$sName = $sFirstName." ".$sLastName;

	} else {
		
		$sName = "Guest";

	}
 ?>

		
		<div class="register-wrap">
			<a href="login.php" class="btn btn-primary">Login</a>
			<a href="signup.php" class="btn btn-primary">Sign up</a>
		</div>
		
		<h2>Hi there, <?php echo $sName; ?></h2>
		<p>This page is dedicated to KEA Fredagsbar's Gif wall - hold on, it's just a school project though. If you have ever been to one of the awesome Friday Bars at L16, you must have seen the Gifwall. </p>
		<p>You can now contribute to this very wall with your own amazing gifs. Just log in and upload your art piece and we'll add it to the queue. You can also have a little chat with your fellow party enthusiasts. Meet new people, find each other, comment on that super dope gif that just passed on the wall, ...</p>
		<p>Enjoy!</p>
		
		<img alt="Logo" src="img/logo.jpg" class="logo">
		




<?php require 'footer.php'; ?>
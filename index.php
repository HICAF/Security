<?php	require 'header.php'; ?>

<?php
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
		
		<h2>Welcome <?php echo $sName; ?></h2>
		<p>Cat ipsum dolor sit amet, find something else more interesting for meow for food, then when human fills food dish, take a few bites of food and continue meowing. Chase imaginary bugs find empty spot in cupboard and sleep all day favor packaging over toy. </p>
		<p>Run outside as soon as door open put toy mouse in food bowl run out of litter box at full speed loves cheeseburgers nap all day, but lick the plastic bag.</p>
		<p>Lie on your belly and purr when you are asleep find something else more interesting, but cat snacks present belly, scratch hand when stroked lie on your belly and purr when you are asleep. Chase mice put toy mouse in food bowl run out of litter box at full speed rub face on everything.</p>
		
		<img alt="Logo" src="img/logo.jpg" class="logo">
		




<?php require 'footer.php'; ?>
<?php
require "dbconnect.php";
require "functions.php";

$function = $_GET['function'];




///////////////////////
///	SIGNUP FUNCTION ///
///////////////////////

if ($function == 'signup') {
	$sUsername = $_GET['username'];
	$sPassword = $_GET['password'];
	$sEmail = $_GET['email'];
	$sFirstName = $_GET['firstName'];
	$sLastName = $_GET['lastName'];



	// Encrypting password using MD5 hashing (NON-decryptable)
		$ePassword = md5($sPassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword);
	

	// Default message to display
	$msg = json_decode('{"title":"Ooops...!","message":"You need to fill out all the required fields<br />","type":"warning","fields":[] }');


	// Check if the email is in use
	$emailCheck = $oDb->prepare("SELECT * FROM users WHERE email = '".$sEmail."' ");
	$emailCheck->execute();
	$aEmailCheck = $emailCheck->fetchAll(PDO::FETCH_ASSOC);

	// Check if the username is in use
	$usernameCheck = $oDb->prepare("SELECT * FROM users WHERE username = '".$eUsername."' ");
	$usernameCheck->execute();
	$aUsernameCheck = $usernameCheck->fetchAll(PDO::FETCH_ASSOC);



	if ($sUsername == "" || $sEmail == "" ||  $sPassword == "" || $sFirstName == "" || $sLastName == "") {

		// No username has been entered
		if ($sUsername == "") {
			$msg->message .= "<br />No username is entered";
			$msg->fields[] .= "username";
		}
		
		// No email has been entered
		if ($sEmail == "") {
			$msg->message .= "<br />No email is entered";
			$msg->fields[] .= "emailSignup";
		}

		// No password has been entered
		if ($sPassword == "") {
			$msg->message .= "<br />No password is entered";
			$msg->fields[] .= "passwordSignup";
		}

		// No First name has been entered
		if ($sFirstName == "") {
			$msg->message .= "<br />No firstname is entered";
		}

		// no Last name has been entered
		if ($sLastName == "") {
			$msg->message .= "<br />No lastname is entered";
		}


		// echo json_encode($msg);
	} else if (count($aUsernameCheck) == 1 || count($aEmailCheck) == 1) {
		$msg->message = "";
		$msg->title = 'You again?';

		if (count($aUsernameCheck) == 1) {
			$msg->message .="The usernmae is already in use<br />";
			$msg->fields[] .="username";
		}


		if (count($aEmailCheck) == 1) {
			$msg->message .= "The email address is already in use<br />";
			$msg->fields[] .= "emailSignup";
		}

	} else {
		$query = $oDb->prepare(
		"INSERT INTO users (user_id, username, password, email, first_name, last_name, active)
		VALUES (NULL, '".$eUsername."', '".$ePassword."', '".$sEmail."','".$sFirstName."','".$sLastName."',true)
        ");
		
			$query->execute();

		$msg->message = "Your user has successfully been created";
		$msg->title = "Congratulations!";
		$msg->type = "success";

		$msg->firstName = $sFirstName;
		$msg->lastName = $sLastName;
		$msg->email = $sEmail;
		$msg->password = $sPassword;
	
		$getId = $oDb->query("SELECT * FROM users WHERE username = '".$sUsername."'");
		$aGetId = $getId->fetchAll(PDO::FETCH_ASSOC);

		$_SESSION['user'] = $aGetId[0]['user_id'];

		$msg->session = $_SESSION['user'];
	}		

	

	echo json_encode($msg);
		
};







//////////////////////
///	LOGIN FUNCTION ///
//////////////////////

if ($function == 'login') { 
	$sUsername = $_GET['username'];
	$sPassword = $_GET['password'];



	// Encrypt password at same level as login
		$ePassword = md5($sPassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword);


	$msg = json_decode('{"title":"Wrong!","message":"The email or password you have entered is incorrect. Please try again","type":"error"}');

	$user = $oDb->query("SELECT * FROM users WHERE username = '".$eUsername."' AND password = '".$ePassword."' ");
		$aUser = $user->fetchAll(PDO::FETCH_ASSOC);
	
	if (count($aUser) == 1) {
		$_SESSION["user"] = $aUser[0]["user_id"];

		$msg->message = 'You have successfully logged in again';
		$msg->title = 'Welcome back!';
		$msg->type = 'success';

		$sName = $aUser[0]["firstName"];
		$sLastName = $aUser[0]["lastName"];

		$msg->firstName = $sName;
		$msg->lastName = $sLastName;
		$msg->email = $sEmail;
		$msg->password = $sPassword;
	}
	echo json_encode($msg);
};










///////////////////////
///	LOGOUT FUNCTION ///
///////////////////////

if ($function == "logout") {
	session_unset();
	header('location: index.php');
};

 











//////////////////////
///	UPDATE PROFILE ///
//////////////////////

 if ($function == 'updateProfile' ) {
	$sUsername = $_GET['username'];
	$sEmail = $_GET['email'];
	$sFirstName = $_GET['firstName'];
	$sLastName = $_GET['lastName'];
	$sPassword = $_GET['password'];
	$sPasswordCheck = $_GET['passwordCheck'];
	$userId = $_SESSION['user'];




	// Check if the email is in use
	$emailCheck = $oDb->prepare("SELECT * FROM users WHERE email = '".$sEmail."' ");
	$emailCheck->execute();
	$aEmailCheck = $emailCheck->fetchAll(PDO::FETCH_ASSOC);


	// Check if the username is in use
	$usernameCheck = $oDb->prepare("SELECT * FROM users WHERE username = '".$sUsername."' ");
	$usernameCheck->execute();
	$aUsernameCheck = $usernameCheck->fetchAll(PDO::FETCH_ASSOC);
	

	$msg = json_last_error('{"message":"","title":"Please try again!","type":"warning"}');
 	





	if (count($aUsernameCheck) == 1 && $aUsernameCheck[0]['user_id'] != $userId) {
		$msg->message .="The usernmae is already in use<br />";
		$msg->fields[] .="usernameProfile";
		$msg->title = 'A fault occured!';
		$msg->type = "error";
	}


	if (count($aEmailCheck) == 1 && $aEmailCheck[0]['user_id'] != $userId) {
		$msg->message .= "The email address is already in use<br />";
		$msg->fields[] .= "emailProfile";
		$msg->title = 'A fault occured!';
		$msg->type = "error";
	}
	 
	if ($sPassword != $sPasswordCheck) {
		$msg->title = 'A fault occured!';
		$msg->type = "error";
		$msg->message .="Your passwords does not match.";
		$msg->fields[] .="passwordProfile";
		$msg->fields[] .="passwordCheckProfile";

	}

	if ($msg->type != "error") {

		// Upload user data WITHOUT password change
		if ($sPassword == "") {
			$query = "UPDATE users SET username='".$sUsername."', email='".$sEmail."', first_name='".$sFirstName."', last_name='".$sLastName."' WHERE user_id=".$_SESSION['user']." ";

		// Upload user data WITH password change
		} else {

			// Encrypting password using MD5 hashing (NON-decryptable)
			$ePassword = md5($sPassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword);


			$query = "UPDATE users SET username='".$sUsername."', email='".$sEmail."', password='".$sPassword."', firstName='".$sFirstName."', lastName='".$sLastName."' WHERE user_id=".$_SESSION['user']." ";
		}

    	$stmt = $oDb->prepare($query);
    	$stmt->execute();
	

		$msg->message = "Your profile has successfully been updated.";
		$msg->title = "Congratulations!";
		$msg->type = "success";	
	}


	echo json_encode($msg);
	
};







 ?>
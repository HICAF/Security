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
	

	// Default message to display
	$msg = json_decode('{"title":"Ooops...!","message":"You need to fill out all the required fields<br />","type":"warning"}');


	// Check if the email is in use
	$emailCheck = $oDb->prepare("SELECT * FROM users WHERE email = '".$sEmail."' ");
	$emailCheck->execute();
	$aEmailCheck = $emailCheck->fetchAll(PDO::FETCH_ASSOC);

	// Check if the username is in use
	$usernameCheck = $oDb->prepare("SELECT * FROM users WHERE username = '".$sUsername."' ");
	$usernameCheck->execute();
	$aUsernameCheck = $usernameCheck->fetchAll(PDO::FETCH_ASSOC);



	if ($sUsername == "" || $sEmail == "" ||  $sPassword == "" || $sFirstName == "" || $sLastName == "") {

		// No username has been entered
		if ($sUsername == "") {
			$msg->message .= "<br />No username is entered";
		}
		
		// No email has been entered
		if ($sEmail == "") {
			$msg->message .= "<br />No email is entered";
		}

		// No password has been entered
		if ($sPassword == "") {
			$msg->message .= "<br />No password is entered";
		}

		// No First name has been entered
		if ($sFirstName == "") {
			$msg->message .= "<br />No firstname is entered";
		}

		// no Last name has been entered
		if ($sLastName == "") {
			$msg->message .= "<br />No lastname is entered";
		}


		echo json_encode($msg);
	} else if (count($aUserCheck) == 1) {
		$msg->message = 'The email is already in use';
		$msg->title = 'You again?';
		$msg->type = 'error';
	} else {
		$query = $oDb->prepare(
		"INSERT INTO users (user_id, username, password, email, first_name, last_name, active)
		VALUES (NULL, '".$sUsername."', '".$sPassword."', '".$sEmail."','".$sFirstName."','".$sLastName."',true)
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

	$msg = json_decode('{"title":"Wrong!","message":"The email or password you have entered is incorrect. Please try again","type":"error"}');

	$user = $oDb->query("SELECT * FROM users WHERE username = '".$sUsername."' AND password = '".$sPassword."' ");
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

 ?>
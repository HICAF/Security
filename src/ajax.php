<?php
require "dbconnect.php";
require "functions.php";
require "SMSApi.php";

$function = $_POST['function'];





////////////////////////////////////
//********************************//
//*********	USER ACTIONS *********//
//********************************//
////////////////////////////////////


///////////////////////
///	SIGNUP FUNCTION ///
///////////////////////

if ($function == 'signup') {
	$sUsername = $_POST['username'];
	$sPassword = $_POST['password'];
	$sEmail = $_POST['email'];
	$sFirstName = $_POST['firstname'];
	$sLastName = $_POST['lastname'];
	if (isset($_POST['rememberMe']) ) {
		$bRememberMe = $_POST['rememberMe'];
	}

	if(isset($_POST['g-recaptcha-response']) ){
		$captcha=$_POST['g-recaptcha-response'];
	}

	$expMail = explode("@",$sEmail);



	// Encrypting password using MD5 hashing (NON-decryptable)
		$eP = md5($sPassword);
		$d = new DateTime();
		$ePs1 = substr($eP, 0, 4);
		$ePs2 = substr($eP, -6, 6);
		$ePs3 = substr($eP, 6, 5);
		$sD = $d->format('sYdHim');
		$sD1 = substr($eP, 0,7);
		$sD2 = substr($eP, -7,7);



		$ePassword = $sD2."Y-".$ePs1."O-".$sD1."L-".$ePs2."O-".$ePs3."!";
	

	// Default message to display
	$msg = json_decode('{"title":"Ooops...!","message":"You need to fill out all the required fields<br />","type":"warning","fields":[] }');


	// Check if the email is in use
	$emailCheck = $oDb->prepare("SELECT * FROM users WHERE email = '".$sEmail."' ");
	$emailCheck->execute();
	$aEmailCheck = $emailCheck->fetchAll(PDO::FETCH_ASSOC);

	// Check if the username is in use
	$usernameCheck = $oDb->prepare("SELECT * FROM users WHERE username = '".$sUsername."' ");
	$usernameCheck->execute();
	$aUsernameCheck = $usernameCheck->fetchAll(PDO::FETCH_ASSOC);


	// Check if all fields has been entered
	if ($sUsername == "" || $sEmail == "" ||  $sPassword == "" || $sFirstName == "" || $sLastName == "" || !$captcha ) {

		// No username has been entered
		if ($sUsername == "") {
			$msg->message .= "<br />No username is entered.";
			$msg->fields[] .= "username";
		}
		
		// No email has been entered
		if ($sEmail == "") {
			$msg->message .= "<br />No email is entered.";
			$msg->fields[] .= "email";
		}

		// No password has been entered
		if ($sPassword == "") {
			$msg->message .= "<br />No password is entered.";
			$msg->fields[] .= "password";
		}

		// No First name has been entered
		if ($sFirstName == "") {
			$msg->message .= "<br />No firstname is entered.";
			$msg->fields[] .= "firstname";
		}

		// no Last name has been entered
		if ($sLastName == "") {
			$msg->message .= "<br />No lastname is entered.";
			$msg->fields[] .= "lastname";
		}

		// reCAPTCHA not cehcked
		if(!$captcha){
          $msg->message .= '<br /><strong>Confirm that your not a robot!</strong>';
        }


		// echo json_encode($msg);
	} else if (count($aUsernameCheck) == 1 && $aUsernameCheck[0]["active"]=="1" || count($aEmailCheck) == 1 && $aEmailCheck[0]["active"]=="1") {
		$msg->message = "";
		$msg->title = 'You again?';

		if (count($aUsernameCheck) == 1) {
			$msg->message .="This username is already in use.<br />";
			$msg->fields[] .="username";
		}


		if (count($aEmailCheck) == 1) {
			$msg->message .= "The email address is already in use.<br />";
			$msg->fields[] .= "email";
		}

	// Validation of input strings.
	} else if (!preg_match("/^[a-zA-Z æøåÆØÅ\-]*$/",$sFirstName) || !preg_match("/^[a-zA-Z æøåÆØÅ\-]*$/",$sLastName) || !filter_var($sEmail, FILTER_VALIDATE_EMAIL) || $expMail[1]=="mailinator.com" || !preg_match('/^[a-zA-Z0-9 æøåÆØÅ.,:;\-\_\/]+$/', $sUsername) || !preg_match('/^[a-zA-Z0-9 æøåÆØÅ.,:;\-\_\/]+$/', $sPassword) ) {
		
		$msg->message = "There seems to be an issue with your inputs.<br />";


		// Check if firstname is legit
		if (!preg_match("/^[a-zA-Z æøåÆØÅ]*$/",$sFirstName)) {
			$msg->message .= "<br />Your first name seems to be invalid!";
			$msg->fields[] .= "firstname";
		}
		// Check if lastName is legit
		if (!preg_match("/^[a-zA-Z æøåÆØÅ]*$/",$sLastName)) {
			$msg->message .= "<br />Your last name seems to be invalid!";
			$msg->fields[] .= "lastname";
		}

		// Username can only contain letters, numbers, space, dot, comma, dash, underscore, slash
		if (!preg_match('/^[a-zA-Z0-9 æøåÆØÅ.,:;\-\_\/]+$/', $sUsername)) {
			$msg->message .= "<br />Your username seems to be invalid!<br />(username can only contain letters, numbers, space, dot, comma, dash, underscore, slash)";
			$msg->fields[] .= "username";
		}
		// Password can only contain letters, numbers, space, dot, comma, dash, underscore, slash, backslash
		if (!preg_match('/^[a-zA-Z0-9 æøåÆØÅ.,:;\-\_\/]+$/', $sPassword)) {
			$msg->message .= "<br />Your passowrd seems to be invalid!<br />(password can only contain letters, numbers, space, dot, comma, dash, underscore, slash)";
			$msg->fields[] .= "password";
		}

		if (!filter_var($sEmail, FILTER_VALIDATE_EMAIL) || $expMail[1]=="mailinator.com") {
			$msg->message .= "<br />Your email seems to be invalid!";
			$msg->fields[] .= "email";
		}
	} else {
		$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LdTeyATAAAAALuCaOJ9Xuiv9IGEJcwcoE2R-Jl8&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);


        if($response.success==false)
        {
          $msg->message = "<h4>We have reason to believe that you're not an honest user of the site.</h4>";
          $msg->title = 'Hey there, friendo!';
        } else {
			if (count($aEmailCheck) == 1 && $aEmailCheck[0]["active"]=="0") {
				
				$query = "UPDATE users SET username='".$sUsername."', email='".$sEmail."', password='".$ePassword."', first_name='".$sFirstName."', last_name='".$sLastName."', active=true WHERE user_id=".$aEmailCheck[0]['user_id']." ";

				$sql = $oDb->prepare($query);
				$sql->execute();

			} else {
				$query = $oDb->prepare(
				"INSERT INTO users (user_id, username, password, email, first_name, last_name, admin, active)
				VALUES (NULL, '".$sUsername."', '".$ePassword."', '".$sEmail."','".$sFirstName."','".$sLastName."', false, true)
		        ");
				
					$query->execute();

			}


			
			$msg->message = "Your user has been created successfully.";
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




			// Set unique cookie value if Remeber me is :checked
			if ($bRememberMe == "true") {
				$msg->rememberMe = $bRememberMe;

				$sUsername = $aGetId[0]["username"];
				$sFirstName = $aGetId[0]["first_name"];
				$sLastName = $aGetId[0]["last_name"];
				$sPassword = $aGetId[0]["password"];
				$iUserId = $aGetId[0]["user_id"];

				$eUsername = md5($sUsername);
				$eFirstName = md5($sFirstName);
				$eLastName = md5($sLastName);
				$ePassword = md5($sPassword);

				// MD5 Hashing all users value X [user_id]
				for ($y=0; $y < $iUserId ; $y++) { 
					$eUsername = md5($eUsername);
					$eFirstName = md5($eFirstName);
					$eLastName = md5($eLastName);
					$ePassword = md5($ePassword);
				}

				// Choose parts of hashed values to combine
				$cUsername = substr($eUsername, 0, 4);
				$cFirstName = substr($eFirstName, -3);
				$cLastName = substr($eLastName, 0, 3);
				$cPassword = substr($ePassword, -8, 6);

				// Combine parts of hashed values to unique Cookie value
				$cValue = $cFirstName."-".$cUsername."-".$cLastName."-".$cPassword;

				$msg->cookieName = "kfbsusloinapi2016"; // Cookie Name
				$msg->cookieValue = $cValue; // Cookie Unique Value
				$msg->cookieExdays = 365; // expiration = 365 days
			}
		}
	}		

	

	echo json_encode($msg);
		
};







//////////////////////
///	LOGIN FUNCTION ///
//////////////////////

if ($function == 'login') { 
	$sUsername = $_POST['username'];
	$sPassword = $_POST['password'];
	if (isset($_POST['rememberMe']) ) {
		$bRememberMe = $_POST['rememberMe'];
	}
	if(isset($_POST['g-recaptcha-response']) ){
		$captcha=$_POST['g-recaptcha-response'];
	}



	// Tracking only password parts from encrypted psw.
	// Exceed unique timestamp from the string
		$eP = md5($sPassword);
		$ePs1 = substr($eP, 0, 4);
		$ePs2 = substr($eP, -6, 6);
		$ePs3 = substr($eP, 6, 5);

		$sPs = $ePs1.$ePs2.$ePs3;




	$msg = json_decode('{"title":"Wrong!","message":"The email or password you have entered is incorrect. Please try again!","type":"error","rememberMe":"false","fields":[] }');
	
	
	// Check if all required fields has been 
	if ($sUsername == "" ||  $sPassword == "" || !$captcha) {

		$msg = json_decode('{"title":"Ooops...!","message":"You need to fill out all the required fields.<br />","type":"warning","fields":[] }');

		// No username has been entered
		if ($sUsername == "") {
			$msg->message .= "<br />No username is entered.";
			$msg->fields[] .= "username";
		}
		

		// No password has been entered
		if ($sPassword == "") {
			$msg->message .= "<br />No password is entered.";
			$msg->fields[] .= "password";
		}

		// reCAPTCHA not cehcked
		if(!$captcha){
	          $msg->message .= '<br /><strong>Confirm that your not a robot!</strong>';
	        }

	} else {
		$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LdTeyATAAAAALuCaOJ9Xuiv9IGEJcwcoE2R-Jl8&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);


        if($response.success==false)
        {
          $msg->message = "<h4>We have reason to believe that you're not an honest user of this site.</h4>";
          $msg->title = 'Hey there, friendo!';
        } else {
          
			$user = $oDb->query("SELECT * FROM users WHERE username = '".$sUsername."' ");
			$aUser = $user->fetchAll(PDO::FETCH_ASSOC);

			for ($i=0; $i < count($aUser); $i++) { 
				$uPassword = $aUser[$i]['password'];

				// combine the same parts of hashed password, as saved in DB
				$cPs1 = substr($uPassword, 9, 4);
				$cPs2 = substr($uPassword, 24, 6);
				$cPs3 = substr($uPassword, 32, 5);
				$cPs = $cPs1.$cPs2.$cPs3;



				if ($cPs == $sPs && $aUser[$i]["active"] == "1") {
					$_SESSION["user"] = $aUser[$i]["user_id"];
					$_SESSION["admin"] = $aUser[$i]["admin"];

					$msg->message = 'You have successfully logged in again';
					$msg->title = 'Welcome back!';
					$msg->type = 'success';

					$sName = $aUser[$i]["firstName"];
					$sLastName = $aUser[$i]["lastName"];

					$msg->firstName = $sName;
					$msg->lastName = $sLastName;
					$msg->email = $sEmail;
					$msg->password = $sPassword;
					$msg->admin = $aUser[$i]["admin"];


					// Set unique cookie value if Remeber me is :checked
					if ($bRememberMe == "true") {
						$msg->rememberMe = $bRememberMe;

						$sUsername = $aUser[$i]["username"];
						$sFirstName = $aUser[$i]["first_name"];
						$sLastName = $aUser[$i]["last_name"];
						$sPassword = $aUser[$i]["password"];
						$iUserId = $aUser[$i]["user_id"];

						$eUsername = md5($sUsername);
						$eFirstName = md5($sFirstName);
						$eLastName = md5($sLastName);
						$ePassword = md5($sPassword);

						// MD5 Hashing all users value X [user_id]
						for ($y=0; $y < $iUserId ; $y++) { 
							$eUsername = md5($eUsername);
							$eFirstName = md5($eFirstName);
							$eLastName = md5($eLastName);
							$ePassword = md5($ePassword);
						}

						// Choose parts of hashed values to combine
						$cUsername = substr($eUsername, 0, 4);
						$cFirstName = substr($eFirstName, -3);
						$cLastName = substr($eLastName, 0, 3);
						$cPassword = substr($ePassword, -8, 6);

						// Combine parts of hashed values to unique Cookie value
						$cValue = $cFirstName."-".$cUsername."-".$cLastName."-".$cPassword;

						$msg->cookieName = "kfbsusloinapi2016"; // Cookie Name
						$msg->cookieValue = $cValue; // Cookie Unique Value
						$msg->cookieExdays = 365; // expiration = 365 days
					
					} // End IF-statement ($bRememberMe == "true")

				} //  End IF-statement ($cPs == $sPs)

			} // End for loop

		} // End ELSE

	}
	echo json_encode($msg);
}; // End login function


////////////////////
///	COOKIE LOGIN ///
////////////////////
if ($function == "cookieLogin") {
	$cValue = $_POST['userApi'];

	$user = $oDb->query("SELECT * FROM users ");
	$aUsers = $user->fetchAll(PDO::FETCH_ASSOC);

	for ($i=0; $i < count($aUsers) ; $i++) { 
		$sUsername = $aUsers[$i]["username"];
		$sFirstName = $aUsers[$i]["first_name"];
		$sLastName = $aUsers[$i]["last_name"];
		$sPassword = $aUsers[$i]["password"];
		$iUserId = $aUsers[$i]["user_id"];



		$eUsername = md5($sUsername);
		$eFirstName = md5($sFirstName);
		$eLastName = md5($sLastName);
		$ePassword = md5($sPassword);

		for ($y=0; $y < $iUserId ; $y++) { 
			$eUsername = md5($eUsername);
			$eFirstName = md5($eFirstName);
			$eLastName = md5($eLastName);
			$ePassword = md5($ePassword);
		}

		$cUsername = substr($eUsername, 0, 4);
		$cFirstName = substr($eFirstName, -3);
		$cLastName = substr($eLastName, 0, 3);
		$cPassword = substr($ePassword, -8, 6);

		$checkValue = $cFirstName."-".$cUsername."-".$cLastName."-".$cPassword;

		if ($checkValue == $cValue) {
			$_SESSION["user"] = $iUserId;
			$_SESSION["admin"] = $aUsers[$i]["admin"];
			echo "true";
			break;
		} else {
			echo $checkValue." | ";
		}


	} 
}












///////////////////////
///	LOGOUT FUNCTION ///
///////////////////////

if ($_GET["logout"] == "true") {
	session_unset();
	header('location: /index.php');
};

 











//////////////////////
///	UPDATE PROFILE ///
//////////////////////

 if ($function == 'updateProfile' ) {
	$sEmail = $_POST['email'];
	$sUsername = $_POST['username'];
	$sFirstName = $_POST['firstname'];
	$sLastName = $_POST['lastname'];
	$sPassword = $_POST['password'];
	$sPasswordCheck = $_POST['passwordcheck'];

	$userId = $_SESSION['user'];
	
	$activeUser = $oDb->prepare("SELECT * FROM users WHERE user_id = '".$userId."' ");
	$activeUser->execute();
	$aActiveUser = $activeUser->fetchAll(PDO::FETCH_ASSOC);
	
	if ($sUsername == "") {
		$sUsername = $aActiveUser[0]['username'];
	}

	if ($sFirstName == "") {
		$sFirstName = $aActiveUser[0]['first_name'];
	}

	if ($sLastName == "") {
		$sLastName = $aActiveUser[0]['last_name'];
	}

	if ($sEmail == "") {
		$sEmail = $aActiveUser[0]['email'];
	}

	

	if(isset($_POST['g-recaptcha-response']) ){
		$captcha=$_POST['g-recaptcha-response'];
	}



	// Check if the email is in use
	$emailCheck = $oDb->prepare("SELECT * FROM users WHERE email = '".$sEmail."' ");
	$emailCheck->execute();
	$aEmailCheck = $emailCheck->fetchAll(PDO::FETCH_ASSOC);


	// Check if the username is in use
	$usernameCheck = $oDb->prepare("SELECT * FROM users WHERE username = '".$sUsername."' ");
	$usernameCheck->execute();
	$aUsernameCheck = $usernameCheck->fetchAll(PDO::FETCH_ASSOC);
	

	$msg = json_last_error('{"message":"","title":"Please try again!","type":"warning","fields":[]}');
 	


	if (count($aUsernameCheck) == 1 && $aUsernameCheck[0]['user_id'] != $userId) {
		$msg->message .="The usernmae is already in use.<br />";
		$msg->fields[] .="usernameProfile";
		$msg->title = 'A fault occured!';
		$msg->type = "error";
	}


	if (count($aEmailCheck) == 1 && $aEmailCheck[0]['user_id'] != $userId) {
		$msg->message .= "The email address is already in use.<br />";
		$msg->fields[] .= "emailProfile";
		$msg->title = 'A fault occured!';
		$msg->type = "error";
	}
	 
	if ($sPassword != $sPasswordCheck) {
		$msg->title = 'A fault occured!';
		$msg->type = "error";
		$msg->message .="Your passwords do not match.";
		$msg->fields[] .="passwordProfile";
		$msg->fields[] .="passwordCheckProfile";

	}

	if (!preg_match("/^[a-zA-Z æøåÆØÅ\-]*$/",$sFirstName) || !preg_match("/^[a-zA-Z æøåÆØÅ\-]*$/",$sLastName) || !filter_var($sEmail, FILTER_VALIDATE_EMAIL) || $expMail[1]=="mailinator.com" || !preg_match('/^[a-zA-Z0-9 æøåÆØÅ.,:;\-\_\/]+$/', $sUsername) || !preg_match('/^[a-zA-Z0-9 æøåÆØÅ.,:;\-\_\/]+$/', $sPassword) && $sPassword != "" ) {
		
		$msg->message = "There seems to be an issue with your inputs.<br />";
		$msg->title = 'A fault occured!';
		$msg->type = "error";

		// Check if firstname is legit
		if (!preg_match("/^[a-zA-Z æøåÆØÅ]*$/",$sFirstName)) {
			$msg->message .= "<br />Your first name seems to be invalid!";
			$msg->fields[] .= "firstname";
		}
		// Check if lastName is legit
		if (!preg_match("/^[a-zA-Z æøåÆØÅ]*$/",$sLastName)) {
			$msg->message .= "<br />Your last name seems to be invalid!";
			$msg->fields[] .= "lastname";
		}

		// Username can only contain letters, numbers, space, dot, comma, dash, underscore, slash
		if (!preg_match('/^[a-zA-Z0-9 æøåÆØÅ.,:;\-\_\/]+$/', $sUsername)) {
			$msg->message .= "<br />Your username seems to be invalid!<br />(username can only contain letters, numbers, space, dot, comma, dash, underscore, slash)";
			$msg->fields[] .= "username";
		}
		// Password can only contain letters, numbers, space, dot, comma, dash, underscore, slash, backslash
		if (!preg_match('/^[a-zA-Z0-9 æøåÆØÅ.,:;\-\_\/]+$/', $sPassword)) {
			$msg->message .= "<br />Your passowrd seems to be invalid!<br />(password can only contain letters, numbers, space, dot, comma, dash, underscore, slash)";
			$msg->fields[] .= "password";
		}

		if (!filter_var($sEmail, FILTER_VALIDATE_EMAIL) || $expMail[1]=="mailinator.com") {
			$msg->message .= "<br />Your email seems to be invalid!";
			$msg->fields[] .= "email";
		}
	}

	// reCAPTCHA not cehcked
	if(!$captcha){
		$msg->message .= '<br /><strong>Confirm that your not a robot!</strong>';
		$msg->title = 'A fault occured!';
		$msg->type = "error";
    }

	if ($msg->type != "error") {
		$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LdTeyATAAAAALuCaOJ9Xuiv9IGEJcwcoE2R-Jl8&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);


        if($response.success==false)
        {
          $msg->message = "<h4>We have reason to believe that you're not an honest user of the site.</h4>";
          $msg->title = 'Hey there, friendo!';
        } else {
			// Upload user data WITHOUT password change
			if ($sPassword == "") {
				$query = "UPDATE users SET username='".$sUsername."', email='".$sEmail."', first_name='".$sFirstName."', last_name='".$sLastName."' WHERE user_id=".$_SESSION['user']." ";

				$msg->message = "Your profile has been updated successfully.";
				$msg->title = "Congratulations!";
				$msg->type = "success";	

			// Upload user data WITH password change
			} else {

				// Encrypting password using MD5 hashing (NON-decryptable)
				$eP = md5($sPassword);
				$d = new DateTime();
				$ePs1 = substr($eP, 0, 4);
				$ePs2 = substr($eP, -6, 6);
				$ePs3 = substr($eP, 6, 5);
				$sD = $d->format('sYdHim');
				$sD1 = substr($eP, 0,7);
				$sD2 = substr($eP, -7,7);



				$ePassword = $sD2."Y-".$ePs1."O-".$sD1."L-".$ePs2."O-".$ePs3."!";


				$query = "UPDATE users SET username='".$sUsername."', email='".$sEmail."', password='".$ePassword."', first_name='".$sFirstName."', last_name='".$sLastName."' WHERE user_id=".$_SESSION['user']." ";

				$msg->message = "Both, your profile and password has successfully been updated.";
				$msg->title = "Congratulations!";
				$msg->type = "success";	
			}

	    	$stmt = $oDb->prepare($query);
	    	$stmt->execute();
	    }
	
		
	}


	echo json_encode($msg);
	
};






/////////////////////////
///	RETRIEVE PASSWORD ///
/////////////////////////

if ($_GET['retrieveMail'] == "true") {
	// require 'src/SMSApi.php';
	$sEmail = $_GET['email'];


	// Standard return message
	$msg = json_last_error('{"message":"It seems like an error occured. Try typing your email again or reload the page.","title":"Hmmm!?","type":"warning"}');


	// Check if email exists in DB
	$emailCheck = $oDb->prepare("SELECT * FROM users WHERE email = '".$sEmail."' ");
	$emailCheck->execute();
	$aEmailCheck = $emailCheck->fetchAll(PDO::FETCH_ASSOC);


	if (count($aEmailCheck) == 0) {
		$msg->message = "The email you entered does not exist.";
		$msg->title = "Ooops...";
		$msg->type = "error";

	} else {
		// require "SMSApi.php";

		// Fetch the user_id of the user with the typed email
		// Needed to for referrance to the reset password site
		$user_id = $aEmailCheck[0]['user_id'];
		$username = $aEmailCheck[0]['username'];
		$firstName = $aEmailCheck[0]['first_name'];
		$lastName = $aEmailCheck[0]['last_name'];

		$eUser_id = md5($user_id);

		$link = 'http://localhost:8888/password-reset.php?id='.$eUser_id;


		// Send a mail to the typed mail
		// With a link to the custom url pointing to the right user

				$toMail = $sEmail;
				$toName = $firstName.' '.$lastName;

				$fromMail = "doNotReply@keafbs.dk";
				$fromName = "KEA FridayBar Social";

				// subject
				$subject = $toName.' - reset password for KEA FridayBar Social';

				// message
				$message = '
	Hi '.$firstName.'! 

	Reset your password for: '.$username.'. 
	Follow this link to reset your password: 
	'.$link;

				// To send HTML mail, the Content-type header must be set
				// $headers  = 'MIME-Version: 1.0' . "\r\n";
				// $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

				// // Additional headers
				// $headers .= 'To: '.$toName.' <'.$toMail.'>' . "\r\n";
				// $headers .= 'From: '.$fromName.' <'.$fromMail.'>' . "\r\n";
				// $headers .= 'Cc:' . "\r\n";
				// $headers .= 'Bcc:' . "\r\n";

				// Mail it
				// mail($toMail, $subject, $message, $headers);
				$sms=new SMSApi('Group07','024BC40D02D31AF6');
				
				$reply=$sms->SendEmailv2($toMail, $subject, $message);

				// $reply;


		$msg->message = "An email has been sent to: ";
		$msg->title = "Done!";
		$msg->type = "success";	
	}

	echo json_encode($msg);

};





//////////////////////
///	RESET PASSWORD ///
//////////////////////

if ($function == 'resetPassword') { 
	$sIdSite = $_POST['id'];
	$sPassword = $_POST['password'];


	// Encrypt password at same level as login
		$eP = md5($sPassword);
		$d = new DateTime();
		$ePs1 = substr($eP, 0, 4);
		$ePs2 = substr($eP, -6, 6);
		$ePs3 = substr($eP, 6, 5);
		$sD = $d->format('sYdHim');
		$sD1 = substr($eP, 0,7);
		$sD2 = substr($eP, -7,7);



		$ePassword = $sD2."Y-".$ePs1."O-".$sD1."L-".$ePs2."O-".$ePs3."!";


	$msg = json_decode('{"title":"Wrong!","message":"Something went wrong. Please try again","type":"error"}');

	$user = $oDb->prepare("SELECT * FROM users ");
	$user->execute();
	$aUsers = $user->fetchAll(PDO::FETCH_ASSOC);
		
	for ($i=0; $i < count($aUsers); $i++) { 
		$user_id = $aUsers[$i]['user_id'];
		$sIdCheck = md5($user_id);


		if ($sIdCheck == $sIdSite) {
			$query = "UPDATE users SET password='".$ePassword."' WHERE user_id=".$user_id." ";
			$stmt = $oDb->prepare($query);
    		$stmt->execute();

			$msg->message = "Your password has been updated";
			$msg->title = "Success!";
			$msg->type = "success";
		}

	}

	echo json_encode($msg);
};







///////////////////
///	DELETE USER ///
///////////////////


if ($function == "deleteUser") {

	$query = "UPDATE users SET active=false WHERE user_id=".$_SESSION['user']." ";


	$sql = $oDb->prepare($query);
	$sql->execute();

	session_unset();
	echo "
			<script>
				alert('Your user has been deleted');
				window.location.href='/index.php';
			</script>";
};


















///////////////////////////////////
//*******************************//
//*********	HANDLE GIFS *********//
//*******************************//
///////////////////////////////////



///////////////////
///	UPLOAD FILE ///
///////////////////

if ($_GET['uploadFile'] == "true") {
	// if(isset($_POST['g-recaptcha-response']) ){
	// 	$captcha=$_POST['g-recaptcha-response'];
	// }

	//get the url
	$url = $_POST['linkToUpload'];
	$target_dir = "gifs/";


	// reCAPTCHA not cehcked
	// if(!$captcha){
	// 	echo "
	// 		<script>
	// 			alert('Confirm that your not a robot!');
	// 			window.location.href='/gifupload.php';
	// 		</script>";

 //    } else {

    // 	$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LdTeyATAAAAALuCaOJ9Xuiv9IGEJcwcoE2R-Jl8&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
    	
    // 	if($response.success==false) {
	   //  	echo "
				// <script>
				// 	alert('You are spammer ! Get the FUCKK out!');
				// 	window.location.href='/gifupload.php';
				// </script>";

	   //  } else 
	if ($url != "") {

			//add time to the current filename
			$name = basename($url);
			list($txt, $ext) = explode(".", $name);
			$name = $txt.time();
			$name = $name.".".$ext;
			 
			//check if the files are only image / document
			if($ext == "jpg" || $ext == "png" || $ext == "gif" || $ext == "jpeg" ){
				// Check if file already exists
				if (file_exists($target_dir.$name)) {
				    echo "
					<script>
						alert('Sorry, file already exists!');
						window.location.href='/gifupload.php';
					</script>";
				} else {
					//here is the actual code to get the file from the url and save it to the uploads folder
					//get the file from the url using file_get_contents and put it into the folder using file_put_contents
					file_put_contents($target_dir.$name, file_get_contents($url));


					
					//check success
					$date = new DateTime();
					$user = $_SESSION['user'];

					$query = $oDb->prepare(
						"INSERT INTO gifs (gif_id, name, uploaded, pending, accepted, user_id)
						VALUES (NULL, '".$name."', '".$date->format("Y-m-d H:i:s")."', '1','0','".$user."')
				        ");
				
					$query->execute();

				    echo "
					<script>
						alert('Your file has been uploaded!');
						window.location.href='/gifupload.php';
					</script>";
				}

			} else {
			    echo "
				<script>
					alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed!');
					window.location.href='/gifupload.php';
				</script>";
			}
		

		} else {

			$file_name = $_FILES['fileToUpload']['name'];

			$target_file = $target_dir.$file_name;
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);



			// Check if image file is a actual image or fake image
		    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		    if($check !== false) {
		        $uploadOk = 1;
		    } else {
			    echo "
				<script>
					alert('File is not an image!');
					window.location.href='/gifupload.php';
				</script>";
		        $uploadOk = 0;
		    }

			// Check if file already exists
			if (file_exists($target_file)) {
			    echo "
				<script>
					alert('Sorry, file already exists!');
					window.location.href='/gifupload.php';
				</script>";
			    $uploadOk = 0;
			}

			// // Check file size
			// if ($_FILES["fileToUpload"]["size"] > 5000000) {
			//     echo "Sorry, your file is too large.";
			//     $uploadOk = 0;
			// }

			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
			    echo "
				<script>
					alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed!');
					window.location.href='/gifupload.php';
				</script>";

			    $uploadOk = 0;
			}

			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
				echo "
				<script>
					alert('Sorry, your file was not uploaded!');
					window.location.href='/gifupload.php';
				</script>";
			
			// if everything is ok, try to upload file
			} else {
				move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_file);

				$date = new DateTime();
				$name = $file_name;
				$user = $_SESSION['user'];

				$query = $oDb->prepare(
					"INSERT INTO gifs (gif_id, name, uploaded, pending, accepted, user_id)
					VALUES (NULL, '".$name."', '".$date->format("Y-m-d H:i:s")."', '1','0','".$user."')
			        ");
			
				$query->execute();

				echo "
				<script>
					alert('Your file has been uploaded!');
					window.location.href='/gifupload.php';
				</script>";

			}
		}
	// }
};






//////////////////
///	ACCEPT GIF ///
//////////////////

if ($function == "gif-accepted") {

	$gif_id = $_POST['gif_id'];

	$query = "UPDATE gifs SET pending='0', accepted='1' WHERE gif_id=".$gif_id." ";
	
	$sql = $oDb->prepare($query);
	$sql->execute();

	$msg = json_decode('{"title":"Great!","message":"gif has been accepted","type":"success"}');
	echo json_encode($msg);
};



//////////////////
///	REJECT GIF ///
//////////////////

if ($function == "gif-rejected") {

	$gif_id = $_POST['gif_id'];

	$query = "UPDATE gifs SET pending='0', accepted='0' WHERE gif_id=".$gif_id." ";

	$sql = $oDb->prepare($query);
	$sql->execute();

	$msg = json_decode('{"title":"Nah..!","message":"That one sucked anyway","type":"error"}');
	echo json_encode($msg);

};









 ?>
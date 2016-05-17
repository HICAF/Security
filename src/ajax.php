<?php
require "dbconnect.php";
require "functions.php";

$function = $_GET['function'];





////////////////////////////////////
//********************************//
//*********	USER ACTIONS *********//
//********************************//
////////////////////////////////////


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
	$usernameCheck = $oDb->prepare("SELECT * FROM users WHERE username = '".$sUsername."' ");
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
			$msg->fields[] .= "email";
		}

		// No password has been entered
		if ($sPassword == "") {
			$msg->message .= "<br />No password is entered";
			$msg->fields[] .= "password";
		}

		// No First name has been entered
		if ($sFirstName == "") {
			$msg->message .= "<br />No firstname is entered";
			$msg->fields[] .= "firstname";
		}

		// no Last name has been entered
		if ($sLastName == "") {
			$msg->message .= "<br />No lastname is entered";
			$msg->fields[] .= "lastname";
		}


		// echo json_encode($msg);
	} else if (count($aUsernameCheck) == 1 && $aUsernameCheck[0]["active"]=="1" || count($aEmailCheck) == 1 && $aEmailCheck[0]["active"]=="1") {
		$msg->message = "";
		$msg->title = 'You again?';

		if (count($aUsernameCheck) == 1) {
			$msg->message .="The usernmae is already in use<br />";
			$msg->fields[] .="username";
		}


		if (count($aEmailCheck) == 1) {
			$msg->message .= "The email address is already in use<br />";
			$msg->fields[] .= "email";
		}

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
	

	
	if ($sUsername == "" ||  $sPassword == "" ) {

		$msg = json_decode('{"title":"Ooops...!","message":"You need to fill out all the required fields<br />","type":"warning","fields":[] }');

		// No username has been entered
		if ($sUsername == "") {
			$msg->message .= "<br />No username is entered";
			$msg->fields[] .= "username";
		}
		

		// No password has been entered
		if ($sPassword == "") {
			$msg->message .= "<br />No password is entered";
			$msg->fields[] .= "password";
		}

	} else {
		$user = $oDb->query("SELECT * FROM users WHERE username = '".$sUsername."' AND password = '".$ePassword."' ");
		$aUser = $user->fetchAll(PDO::FETCH_ASSOC);

		
		if (count($aUser) == 1 && $aUser[0]["active"] == "1") {
			$_SESSION["user"] = $aUser[0]["user_id"];
			$_SESSION["admin"] = $aUser[0]["admin"];

			$msg->message = 'You have successfully logged in again';
			$msg->title = 'Welcome back!';
			$msg->type = 'success';

			$sName = $aUser[0]["firstName"];
			$sLastName = $aUser[0]["lastName"];

			$msg->firstName = $sName;
			$msg->lastName = $sLastName;
			$msg->email = $sEmail;
			$msg->password = $sPassword;
			$msg->admin = $aUser[0]["admin"];
		}
	}
	echo json_encode($msg);
};










///////////////////////
///	LOGOUT FUNCTION ///
///////////////////////

if ($function == "logout") {
	session_unset();
	header('location: /index.php');
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

			$msg->message = "Your profile has successfully been updated.";
			$msg->title = "Congratulations!";
			$msg->type = "success";	

		// Upload user data WITH password change
		} else {

			// Encrypting password using MD5 hashing (NON-decryptable)
			$ePassword = md5($sPassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword);


			$query = "UPDATE users SET username='".$sUsername."', email='".$sEmail."', password='".$ePassword."', first_name='".$sFirstName."', last_name='".$sLastName."' WHERE user_id=".$_SESSION['user']." ";

			$msg->message = "Your profile AND password has successfully been updated.";
			$msg->title = "Congratulations!";
			$msg->type = "success";	
		}

    	$stmt = $oDb->prepare($query);
    	$stmt->execute();
	

		
	}


	echo json_encode($msg);
	
};






/////////////////////////
///	RETRIEVE PASSWORD ///
/////////////////////////

if ($function == "retrievePassword") {
	$sEmail = $_GET['email'];


	// Standard return message
	$msg = json_last_error('{"message":"It seems like an error occured. Try type your email again or reload the page.","title":"Hmmm!?","type":"warning"}');


	// Check if email exists in DB
	$emailCheck = $oDb->prepare("SELECT * FROM users WHERE email = '".$sEmail."' ");
	$emailCheck->execute();
	$aEmailCheck = $emailCheck->fetchAll(PDO::FETCH_ASSOC);


	if (count($aEmailCheck) == 0) {
		$msg->message = "The email you entered does not exist.";
		$msg->title = "Ooops...";
		$msg->type = "error";

	} else {

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
				$subject = $username.' - reset password for KEA FridayBar Social';

				// message
				$message = '
				<html>
				<head>
				  <title>Reset password | KEA FridayBar Social</title>
				</head>
				<body>
				  <div><h1>Hi '.$firstName.'</h1><br /><h5>Reset your password for: '.$username.'</h5></div>
				  <div><p><a href="'.$link.'">Follow this link to reset your password</a></p></div>
				</body>
				</html>
				';

				// To send HTML mail, the Content-type header must be set
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

				// Additional headers
				$headers .= 'To: '.$toName.' <'.$toMail.'>' . "\r\n";
				$headers .= 'From: '.$fromName.' <'.$fromMail.'>' . "\r\n";
				$headers .= 'Cc:' . "\r\n";
				$headers .= 'Bcc:' . "\r\n";

				// Mail it
				mail($toMail, $subject, $message, $headers);


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
	$sIdSite = $_GET['id'];
	$sPassword = $_GET['password'];


	// Encrypt password at same level as login
		$ePassword = md5($sPassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword); $ePassword = md5($ePassword);


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

if ($function == "upload-file") {

	//get the url
	$url = $_POST['linkToUpload'];
	$target_dir = "gifs/";


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
};






//////////////////
///	ACCEPT GIF ///
//////////////////

if ($function == "gif-accepted") {

	$gif_id = $_GET['gif_id'];

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

	$gif_id = $_GET['gif_id'];

	$query = "UPDATE gifs SET pending='0', accepted='0' WHERE gif_id=".$gif_id." ";

	$sql = $oDb->prepare($query);
	$sql->execute();

	$msg = json_decode('{"title":"Nah..!","message":"That one sucked anyway","type":"error"}');
	echo json_encode($msg);

};









 ?>
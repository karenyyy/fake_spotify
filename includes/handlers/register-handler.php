<?php 

function cleanPassword($inputText) {
	$inputText = strip_tags($inputText);
	return $inputText;
}

function cleanUsername($inputText) {
	$inputText = strip_tags($inputText);
	$inputText = str_replace(" ", "", $inputText);
	return $inputText;
}

function cleanString($inputText) {
	$inputText = strip_tags($inputText);
	$inputText = str_replace(" ", "", $inputText);
	$inputText = ucfirst(strtolower($inputText)); // turn the first character to Upper Case
	return $inputText;
}


if(isset($_POST['registerButton'])) {

	//Register when button was pressed
	$username = cleanUsername($_POST['username']);
	$firstName = cleanString($_POST['firstName']);
	$lastName = cleanString($_POST['lastName']);
	$email = cleanString($_POST['email']);
	$password = cleanPassword($_POST['password']);
	$password2 = cleanPassword($_POST['password2']);


	$wasSuccessful = $account->register($username, $firstName, $lastName, $email, $password, $password2);

	if($wasSuccessful === true) {
		$_SESSION['userLoggedIn'] = $username;
		header("Location: index.php");
	}


    $target_file = 'assets/images/profile-pics/'.$username;
    if (!is_dir($target_file)){
        mkdir($target_file, 0777, true);
    }

    $target_file=$target_file."/".basename($_FILES['profilePicToUpload']['name']);
	$oldpath = $_FILES['profilePicToUpload']['tmp_name'];

    move_uploaded_file($oldpath, $target_file);


}


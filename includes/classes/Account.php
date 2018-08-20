<?php

	class Account {

		private $con;
		private $errorArray;

		public function __construct($con) {
			$this->con = $con;
			$this->errorArray = array();
		}

		public function login($current_user, $password) {

			$password = md5($password);

			$query = $this->con->query(
				"SELECT * FROM users WHERE username='$current_user' AND password='$password'");

			// check whether it has already been registered in database
			if(!$query || mysqli_num_rows($query) == 1) {
				return true;
			}
			else {
				array_push($this->errorArray, Constants::$loginFailed);
				return false;
			}

		}

		public function register($current_user, $firstname, $lastname, $email, $password, $confirm_password) {
			$this->checkUsername($current_user);
			$this->checkFirstName($firstname);
			$this->checkLastName($lastname);
			$this->checkEmails($email);
			$this->checkPasswords($password, $confirm_password);

			if(empty($this->errorArray) == true) {
				//Insert into db
				return $this->insertUserDetails($current_user, $firstname, $lastname, $email, $password);
			}
			else {
				return false;
			}

		}

		public function getError($error) {
			if(!in_array($error, $this->errorArray)) {
				$error = "";
			}
			return "<span class='errorMessage'>$error</span>";
		}

		private function insertUserDetails($current_user, $firstname, $lastname, $email, $password) {
			$encrypted_password = md5($password);
			$profilePic = "assets/images/profile-pics/".$current_user;
            array_multisort($times = array_map('filemtime', $files = glob("$profilePic/*")), SORT_DESC, $files);
            $profilePic = explode("spotify/", $files[0])[1];
			$date = date("Y-m-d");

			$result = $this->con->query( "INSERT INTO users VALUES ('', '$current_user', '$firstname', '$lastname', '$email', '$encrypted_password', '$date', '$profilePic')");

			return $result;
		}

		private function checkUsername($current_user) {

			if(strlen($current_user) > 25 || strlen($current_user) < 5) {
				array_push($this->errorArray, Constants::$usernameCharacters);
				return;
			}

			$checkUsernameQuery = $this->con->query( "SELECT username FROM users WHERE username='$current_user'");

			if(!$checkUsernameQuery || mysqli_num_rows($checkUsernameQuery) != 0) {
				array_push($this->errorArray, Constants::$usernameTaken);
				return;
			}

		}

		private function checkFirstName($firstname) {
			if(strlen($firstname) > 25 || strlen($firstname) < 2) {
				array_push($this->errorArray, Constants::$firstNameCharacters);
				return;
			}
		}

		private function checkLastName($lastname) {
			if(strlen($lastname) > 25 || strlen($lastname) < 2) {
				array_push($this->errorArray, Constants::$lastNameCharacters);
				return;
			}
		}

		private function checkEmails($email) {


			if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				array_push($this->errorArray, Constants::$emailInvalid);
				return;
			}

			$checkEmailQuery = $this->con->query( "SELECT email FROM users WHERE email='$email'");
			if(!$checkEmailQuery || mysqli_num_rows($checkEmailQuery) != 0) {
				array_push($this->errorArray, Constants::$emailTaken);
				return;
			}

		}

		private function checkPasswords($password, $confirm_password) {
			
			if($password != $confirm_password) {
				array_push($this->errorArray, Constants::$passwordsDoNoMatch);
				return;
			}

			if(preg_match('/[^A-Za-z0-9]/', $password)) {
				array_push($this->errorArray, Constants::$passwordNotAlphanumeric);
				return;
			}

			if(strlen($password) > 30 || strlen($password) < 5) {
				array_push($this->errorArray, Constants::$passwordCharacters);
				return;
			}

		}


	}
?>

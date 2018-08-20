<?php
	class User {

		private $con;
		private $username;

		public function __construct($con, $username) {
			$this->con = $con;
			$this->username = $username;
		}

		public function getUsername() {
			return $this->username;
		}

		public function getEmail() {
			$query = $this->con->query( "SELECT email FROM users WHERE username='$this->username'");
			$row = mysqli_fetch_array($query);
			return $row['email'];
		}

		public function getFirstAndLastName() {
			$query = $this->con->query( "SELECT concat(firstName, ' ', lastName) as 'name'  FROM users WHERE username='$this->username'");
			$row = mysqli_fetch_array($query);
			return $row['name'];
		}

	}
?>
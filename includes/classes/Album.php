<?php

	class Album {

		private $con;
		private $id;
		private $title;
		private $artistId;
		private $artworkPath;

		public function __construct($con, $id) {
			$this->con = $con;
			$this->id = $id;
			$this->userid = $this->getUserID();
			$query = $this->con->query( "SELECT * FROM albums WHERE id='$this->id' AND userid = '$this->userid'");
			$album = mysqli_fetch_array($query);

			$this->title = $album['title'];
			$this->artistId = $album['artist'];
			$this->artworkPath = $album['artworkPath'];


		}

		public function getTitle() {
			return $this->title;
		}

		public function getArtist() {
			return new Artist($this->con, $this->artistId);
		}


		public function getArtworkPath() {
			return $this->artworkPath;
		}

		public function getUserID() {
            $user_loggedin = $_SESSION['userLoggedIn'];
            $sql = "SELECT id FROM users WHERE username = '$user_loggedin'";
            $user_id = $this->con->query( $sql);
            $user_id = mysqli_fetch_array($user_id);
            $user_id = $user_id['id'];
            return $user_id;

        }

		public function getNumberOfSongs() {
		    $sql = "SELECT id FROM Songs WHERE album='$this->id'";
			$query = $this->con->query( $sql);
			return mysqli_num_rows($query);
		}

		public function getSongIds() {
            $sql = "SELECT id FROM Songs WHERE album='$this->id'";
			$query = $this->con->query( $sql);

			$array = array();

			while($row = mysqli_fetch_array($query)) {
				array_push($array, $row['id']);
			}

			return $array;

		}






	}
?>
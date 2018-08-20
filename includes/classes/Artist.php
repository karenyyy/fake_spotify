<?php
	class Artist {

		private $con;
		private $id;

		public function __construct($con, $id) {
			$this->con = $con;
			$this->id = $id;
		}

		public function getId() {
			return $this->id;
		}

		public function getName() {
			$artistQuery = $this->con->query( "SELECT name FROM artists WHERE id='$this->id'");
			$artist = mysqli_fetch_array($artistQuery);
			return $artist['name'];
		}
		
		public function getSongIds() {

			$query = $this->con->query( "SELECT id FROM Songs WHERE artist='$this->id'");

			$array = array();

			while($row = mysqli_fetch_array($query)) {
				array_push($array, $row['id']);
			}

			return $array;

		}
	}
?>
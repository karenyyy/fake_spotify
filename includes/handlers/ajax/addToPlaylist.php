<?php
include("../../config.php");

if(isset($_POST['playlistId']) && isset($_POST['songId'])) {
	$playlistId = $_POST['playlistId'];
	$songId = $_POST['songId'];

	$orderIdQuery = $con->query( "SELECT MAX(playlistOrder) + 1 as playlistOrder FROM playlistSongs WHERE playlistId='$playlistId'");
	$row = mysqli_fetch_array($orderIdQuery);
	$order = $row['playlistOrder'];

	$query = $con->query( "INSERT INTO playlistSongs(songId, playlistId, playlistOrder) VALUES('$songId', '$playlistId', '$order')");

}
else {
	echo "PlaylistId or songId was not passed into addToPlaylist.php";
}



?>
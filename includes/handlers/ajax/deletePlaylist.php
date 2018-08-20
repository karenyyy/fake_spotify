<?php
include("../../config.php");

if(isset($_POST['playlistId'])) {
	$playlistId = $_POST['playlistId'];

	$playlistQuery = $con->query( "DELETE FROM playlists WHERE id='$playlistId'");
	$songsQuery = $con->query( "DELETE FROM playlistSongs WHERE playlistId='$playlistId'");
}
else {
	echo "PlaylistId was not passed into deletePlaylist.php";
}


?>
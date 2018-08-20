<?php

include("includes/header.php");
include("includes/footer.php");



$current_user = $_SESSION['userLoggedIn'];
$playlistPic = "assets/images/playlist-pics/" . $current_user;

$playlist_name = $_POST['updateButton'];
$playlist_name = trim(explode('for',$playlist_name)[1]);

print_r($playlist_name);

$sql = "SELECT id FROM playlists WHERE name = '$playlist_name' AND owner = '$current_user'";
$playlistId = $con->query($sql);
$playlistId = mysqli_fetch_array($playlistId);
$playlistId = $playlistId['id'];

$target_file = $playlistPic . "/" . basename($_FILES['playlistPicToUpdate']['name']);

$oldpath = $_FILES['playlistPicToUpdate']['tmp_name'];
print_r($target_file, $oldpath);
move_uploaded_file($oldpath, $target_file);

header("Location: playlist.php?id=$playlistId");



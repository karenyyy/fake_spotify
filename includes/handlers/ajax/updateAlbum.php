<?php
include("../../config.php");


if(isset($_POST['title']) !="" || isset($_POST['artist']) != "") {

    $username = $_SESSION['userLoggedIn'];;
    $title = $_POST['title'];
    $artist = $_POST['artist'];

    $old_album_id = $_POST['albumId'];
    $old_artist_id = $_POST['artistId'];


    $album_path="assets/uploads/".$username."/album_covers/".$artist;

    $insert_album_path="assets/uploads/".$username."/album_covers/".$artist."/";


    if (!is_dir($album_path)){
        mkdir($album_path, 0777, true);

    }

    $album_target_dir = $album_path."/";

    $album_target_file = $album_target_dir . basename($_FILES["coverPicToUpdate"]["name"]);

    $oldpath = $_FILES['coverPicToUpdate']['tmp_name'];

    move_uploaded_file($oldpath, $album_target_file);


    array_multisort($times = array_map('filemtime', $files = glob("$album_path/*")), SORT_DESC, $files);
    $insert_path = explode("spotify/", $files[0])[1];

    echo $insert_path;


    $sql = "SELECT id FROM users WHERE username = '$username'";
    $user_id = $con->query($sql);
    $user_id = mysqli_fetch_array($user_id);
    $user_id = $user_id['id'];

    $sql = "SELECT id FROM artists WHERE name = '$artist'";
    $already_exist = mysqli_num_rows($con->query($sql));

    if ($already_exist === 0){
        $sql = "INSERT INTO artists(name) VALUES ('$artist')";
        $con->query($sql);
    }

    $sql = "SELECT id FROM artists WHERE name = '$artist'";
    $artist_id = $con->query($sql);
    $artist_id = mysqli_fetch_array($artist_id);
    $artist_id = $artist_id['id'];

    echo $username, $title, $artist;

    $albumCheck = $con->query("SELECT id FROM albums WHERE userid=$user_id AND title = '$title'");
    if(mysqli_num_rows($albumCheck) > 1) {
        echo "Already have an album with the same title. \~_~/";
        exit();
    }

    if ($title!="") {
        $con->query("UPDATE albums SET title = '$title' WHERE userid=$user_id AND id = $old_album_id");
        echo "Title updated successfully";
    }

    if ($artist!="") {
        $con->query("UPDATE albums SET artist = $artist_id WHERE userid=$user_id AND id = $old_album_id");
        $con->query("UPDATE Songs SET artist = $artist_id WHERE album = $old_album_id");
        echo "Artist updated successfully";
    }

    echo "UPDATE albums SET artworkPath = '$insert_path' WHERE userid=$user_id AND title='$title'";
    echo is_dir($album_target_file);


    if (is_dir($album_target_file)) {
        $con->query("UPDATE albums SET artworkPath = '$insert_path' WHERE userid=$user_id AND id = $old_album_id");
        echo "Cover updated successfully";
    }


}
else {
    echo "You must provide something to update. \~_~/";
}

$sql = "SELECT id FROM albums WHERE title = '$title' AND userid = '$user_id'";
$album_id = $con->query($sql);
$album_id = mysqli_fetch_array($album_id);
$album_id = $album_id['id'];

header("Location: http://localhost:8090/fake_spotify/album.php?id=$album_id");

?>
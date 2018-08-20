<?php
include("../../config.php");


if(isset($_POST['title']) !="") {

    $username = $_SESSION['userLoggedIn'];;
    $title = $_POST['title'];
    $old_song_title = $_POST['path'];


    $sql = "SELECT id FROM users WHERE username = '$username'";
    $user_id = $con->query($sql);
    $user_id = mysqli_fetch_array($user_id);
    $user_id = $user_id['id'];

    $sql = "SELECT id FROM Songs WHERE title = '$old_song_title' AND album IN (SELECT id FROM albums WHERE userid = $user_id)";
    $song_id_ = $con->query($sql);
    $song_id = mysqli_fetch_array($song_id_);
    $song_id = $song_id['id'];

    echo $song_id;

    if(mysqli_num_rows($song_id_) > 1) {
        echo "Already have a song with the same title. \~_~/";
        exit();
    }

    if ($title!="") {
        $updateQuery = $con->query("UPDATE Songs SET title = '$title' WHERE title = '$old_song_title' AND album IN (SELECT id FROM albums WHERE userid = $user_id");
        echo "Title updated successfully";
    }



}
else {
    echo "You must provide something to update. \~_~/";
}

//header("Location: http://localhost:8090/fake_spotify/browse.php?");
//header("Refresh:0");

?>
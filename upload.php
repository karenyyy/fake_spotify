<?php
include ("includes/header.php");
?>

<html>
<head>

    <link rel="stylesheet" type="text/css" href="assets/css/register.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</head>


<body>
<div id="background">

    <?php

    $user_loggedin = $_SESSION['userLoggedIn'];
    
    $artist= $_POST['artist'];
    $album_name=$_POST['album'];
    $song_title=$_POST['title'];

    $parent_path="assets/";

    $song_path="assets/uploads/".$user_loggedin."/songs/".$artist;
    $album_path="assets/uploads/".$user_loggedin."/album_covers/".$artist;

    $insert_song_path="assets/uploads/".$user_loggedin."/songs/".$artist."/";
    $insert_album_path="assets/uploads/".$user_loggedin."/album_covers/".$artist."/";

    if (!is_dir($song_path)){
        mkdir($song_path, 0777, true);

    }

    if (!is_dir($album_path)){
        mkdir($album_path, 0777, true);

    }

    $song_target_dir = $song_path."/";
    $album_target_dir = $album_path."/";


    $song_target_file = $song_target_dir . basename($_FILES["songToUpload"]["name"]);
    $album_target_file = $album_target_dir . basename($_FILES["albumToUpload"]["name"]);
    $uploadOk = 1;
    $songFileType = strtolower(pathinfo($song_target_file,PATHINFO_EXTENSION));
    $imageFileType = strtolower(pathinfo($album_target_file,PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image


    if(isset($_POST["submit"])) {
        $check = filesize($_FILES["songToUpload"]["tmp_name"]);
        if($check !== false) {
            echo "<h2 style='color: white;'>Song successfully uploaded.</h2>";
            $uploadOk = 1;
        } else {
            echo "<h2 style='color: white;'>Song file is invalid.";
            $uploadOk = 0;
        }

        echo "<br><br>";

    }



    $oldpath = $_FILES['songToUpload']['tmp_name'];

    move_uploaded_file($oldpath, $song_target_file);

    if (move_uploaded_file($oldpath, $song_target_file)) {
        echo "song uploaded";
    }



    $oldpath = $_FILES['albumToUpload']['tmp_name'];

    move_uploaded_file($oldpath, $album_target_file);

    if (move_uploaded_file($oldpath, $album_target_file)) {
        echo "album cover uploaded";
    }

    echo "<br><br><br><br><br><br><br><button id='btn' style='color: black; margin: 3px 25px; font-weight: bold' onclick=\"window.location.href='browse.php'\">Back to my music collections</button></form>";


    print_r($artist);
    echo "<br>";

    $sql = "SELECT id FROM artists WHERE name = '$artist'";
    $already_uploaded = $con->query($sql);
    $already_uploaded = mysqli_num_rows($already_uploaded);

    print_r($already_uploaded);
    echo "<br>";

    if ($already_uploaded ===0) {
        $sql = "INSERT INTO artists(name) VALUES ('$artist')";
        $con->query($sql);
    }


    $sql = "SELECT id FROM artists WHERE name = '$artist'";
    $artist_id = $con->query($sql);
    $artist_id = mysqli_fetch_array($artist_id);
    $artist_id = $artist_id['id'];

    print_r($artist_id);
    echo "<br>";

    

    $sql = "SELECT id FROM users WHERE username = '$user_loggedin'";

    $user_id = $con->query($sql);
    $user_id = mysqli_fetch_array($user_id);

    $user_id = $user_id['id'];


    $sql = "SELECT id FROM albums WHERE title = '$album_name' AND artist = $artist_id AND userid = $user_id";
    $already_uploaded = $con->query($sql);
    $already_uploaded = mysqli_num_rows($already_uploaded);

    print_r($already_uploaded);
    echo "<br>";



    if (is_dir($album_path)) {
        if ($already_uploaded === 0) {
            array_multisort($times = array_map('filemtime', $files = glob("$album_path/*")), SORT_DESC, $files);
            $insert_path = explode("spotify/", $files[0])[1];
            $sql = "INSERT INTO albums(title, artist, artworkPath, userid) VALUES ('$album_name', $artist_id, '$insert_path', $user_id)";
            $con->query($sql);
        }

    }



    $sql = "SELECT id FROM albums WHERE title = '$album_name' AND artist = $artist_id AND userid = $user_id";
    $album_id = $con->query($sql);
    $album_id = mysqli_fetch_array($album_id);
    $album_id = $album_id['id'];

    print_r($album_id);
    echo "<br>";


    if (is_dir($song_path)){
        if (count(glob("$song_path/*")) !== 0) {
            array_multisort($times = array_map('filemtime', $files = glob("$song_path/*")), SORT_DESC, $files);
            $insert_path = explode("spotify/", $files[0])[1];
            $command = escapeshellcmd("python3 assets/py/duration.py '$insert_path'");
            $duration = trim(shell_exec($command));
            print_r($duration);
            $sql = "INSERT INTO Songs(title, artist, album, duration, path) VALUES
                      ('$song_title', $artist_id, $album_id, '$duration', '$insert_path')";
            $con->query($sql);

            $album_artist = $artist;

            $song_title = strtolower($song_title);
            $query = $artist.' '.$song_title;
            $query = implode("+", explode(" ", $query));

            $curl = curl_init();
            $scrape_site = "https://www.youtube.com";
            $url = "https://www.youtube.com/results?search_query=".$query;
            //print_r($url);

            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $result = curl_exec($curl);

            preg_match("!href=\"\/watch\?[a-z]=[A-Za-z0-9]+\"!", $result, $match);

            //print_r(explode("href=", $match[0][0])[1]);
            if (sizeof($match)===0){
                $mv_link="";
            } else {
                $mv_link = "'".$scrape_site.trim(explode("href=", $match[0])[1],"\"")."'";
            }


            $sql = "SELECT id FROM Songs WHERE album IN (SELECT id FROM albums WHERE userid = $user_id) AND title = '$song_title'";
            $song_id = $con->query($sql);
            $song_id = mysqli_fetch_array($song_id);
            $song_id = $song_id['id'];

            $sql = "INSERT INTO youtubeMv(songid, url) VALUES
                      ($song_id, $mv_link)";
            $con->query($sql);
        }
    }
    header("Location: browse.php?");

    ?>



</div>



</body>


</html>
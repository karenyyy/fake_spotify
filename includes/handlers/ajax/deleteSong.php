<?php
include("../../config.php");

if(isset($_POST['songId'])) {
    $songId = $_POST['songId'];

    $con->query( "DELETE FROM Songs WHERE id=$songId");
    $con->query( "DELETE FROM youtubeMv WHERE songid=$songId");
    $con->query( "DELETE FROM playlistSongs WHERE songId=$songId");
}
else {
    echo "songId was not passed into deleteSong.php";
}


?>
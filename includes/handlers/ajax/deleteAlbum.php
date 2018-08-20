<?php
include("../../config.php");


if(isset($_POST['albumId'])) {

    $albumId = $_POST['albumId'];

    $con->query( "DELETE FROM Songs WHERE album = $albumId");
    $con->query( "DELETE FROM albums WHERE id = $albumId");
}
else {
    echo "AlbumId was not passed into deleteAlbum.php";
}


?>
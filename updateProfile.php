
<?php
echo "<div id='background'>";

include("includes/header.php");
include("includes/footer.php");


$current_user = $_SESSION['userLoggedIn'];
$profilePic = "assets/images/profile-pics/".$current_user;

if (!is_dir($profilePic)){
    mkdir($profilePic, 0777, true);
}


$target_file=$profilePic."/".basename($_FILES['profilePicToUpdate']['name']);

$oldpath = $_FILES['profilePicToUpdate']['tmp_name'];

move_uploaded_file($oldpath, $target_file);


array_multisort($times = array_map('filemtime', $files = glob("$profilePic/*")), SORT_DESC, $files);

$profilePic = explode("spotify/", $files[0])[1];

$sql = "UPDATE users SET profilePic = '$profilePic' WHERE username = '$current_user'";
$result = $con->query($sql);

if ($result) {
    header("Location: http://localhost:8090/fake_spotify/settings.php?");
}



?>


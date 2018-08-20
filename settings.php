<?php  
include("includes/includedFiles.php");

$user_loggedin = $_SESSION['userLoggedIn'];

$sql = "SELECT profilePic FROM users WHERE username = '$user_loggedin'";

$profile = $con->query($sql);
$profile = mysqli_fetch_array($profile);

$profile = $profile['profilePic'];

?>
<div id="background">

<div class="entityInfo">

	<div class="centerSection">
		<div class="userInfo">
			<h1><?php echo $userLoggedIn->getFirstAndLastName(); ?></h1>
		</div>
	</div>

	<div class="buttonItems">
        <img style="border-radius:50%; display: block; margin-left:650px; width: 300px; height: 300px" src="<?php echo $profile?>"><br>
        <button style="margin-top: 350px" class="button" onclick="openPage('updateDetails.php')">USER DETAILS</button>
        <button class="button" onclick="logout()">LOGOUT</button>
	</div>

</div>

</div>


<style>
    #background {
        background-color: #000;
        background-image: url(assets/images/bg3.jpg);
        background-position: center;
        background-size: cover;
        display: table;
        height: 100%;
        width: 100%;
    }
</style>
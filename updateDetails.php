<?php
include("includes/includedFiles.php");

?>
<div class="userDetails">

	<div class="container borderBottom">
		<h2>EMAIL</h2>
		<input type="text" class="email" name="email" placeholder="Email address..." value="<?php echo $userLoggedIn->getEmail(); ?>">
		<span class="message"></span>
		<button class="button" onclick="updateEmail('email')">SAVE</button>
	</div>

	<div class="container borderBottom">
		<h2>PASSWORD</h2>
		<input type="password" class="oldPassword" name="oldPassword" placeholder="Current password">
		<input type="password" class="newPassword1" name="newPassword1" placeholder="New password">
		<input type="password" class="newPassword2" name="newPassword2" placeholder="Confirm password">
		<span class="message"></span>
		<button class="button" onclick="updatePassword('oldPassword', 'newPassword1', 'newPassword2')">SAVE</button>
	</div>
    <form action="updateProfile.php" method="post" enctype="multipart/form-data">
    <div class="container">
        <h2>UPDATE PROFILE PICTURE</h2><br>

            <input style="color: white; display: block; margin-left: auto; margin-right: auto;" type="file" name="profilePicToUpdate" id="profilePicToUpdate">
            <button class="button" type="submit">Update</button>

    </div>
    </form>
</div>




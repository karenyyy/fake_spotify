
<?php
	include("includes/config.php"); // connect to mysql database

	include("includes/classes/Account.php");
	include("includes/classes/Constants.php");

	$account = new Account($con);

	include("includes/handlers/register-handler.php");
	include("includes/handlers/login-handler.php");

	function getInputValue($name) {
		if(isset($_POST[$name])) {
			echo $_POST[$name];
		}
	}
?>

<html>
<head>
	<title>Fake Spotify</title>

	<link rel="stylesheet" type="text/css" href="assets/css/register.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="assets/js/register.js"></script>
    <script src="assets/js/script.js"></script>

</head>
<body>
	<?php

    // isset == !empty
	if(isset($_POST['registerButton'])) {
		echo '<script>
				$(document).ready(function() {
					$("#loginForm").hide();
					$("#registerForm").show();
				});
			</script>';
	}
	else {
		echo '<script>
				$(document).ready(function() {
					$("#loginForm").show();
					$("#registerForm").hide();
				});
			</script>';
	}


	?>



    <div id="background">


        <div id="navBarContainer">
            <nav class="navBar">

		            <span role="link" tabindex="0" onclick="openPage('index.php')" class="logo">
			<svg class="logo" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="28" height="28" viewBox="0 0 70 70" version="1.1">
              <g class="logo__mainGroup">
                <g class="logo__grayGroup">
                  <path class="logo__square" fill="none" stroke-width="1" d="M0,0 0,70 70,70 70,0z"/>
                  <path class="logo__line logo__line-1" fill="none" stroke-width="1" d="M10,0 10,70"/>
                  <path class="logo__line logo__line-2" fill="none" stroke-width="1" d="M20,0 20,70"/>
                  <path class="logo__line logo__line-3" fill="none" stroke-width="1" d="M30,0 30,70"/>
                  <path class="logo__line logo__line-4" fill="none" stroke-width="1" d="M40,0 40,70"/>
                  <path class="logo__line logo__line-5" fill="none" stroke-width="1" d="M50,0 50,70"/>
                  <path class="logo__line logo__line-6" fill="none" stroke-width="1" d="M60,0 60,70"/>
                  <path class="logo__line logo__line-1" fill="none" stroke-width="1" d="M0,10 70,10"/>
                  <path class="logo__line logo__line-2" fill="none" stroke-width="1" d="M0,20 70,20"/>
                  <path class="logo__line logo__line-3" fill="none" stroke-width="1" d="M0,30 70,30"/>
                  <path class="logo__line logo__line-4" fill="none" stroke-width="1" d="M0,40 70,40"/>
                  <path class="logo__line logo__line-5" fill="none" stroke-width="1" d="M0,50 70,50"/>
                  <path class="logo__line logo__line-6" fill="none" stroke-width="1" d="M0,60 70,60"/>
                </g>
                <g class="logo__colorGroup">
                  <path class="logo__stroke" fill="none" stroke-width="1" d="M0,70 0,40 50,40 50,60 60,60 60,30 40,30 40,10 10,10 10,20 30,20 30,30 0,30 0,0 50,0 50,20 70,20 70,70 40,70 40,50 10,50 10,60 30,60 30,70 0,70" />
                  <path class="logo__fill" fill="none" stroke-width="10" d="M30,25 5,25 5,5 45,5 45,25 65,25 65,65 45,65 45,45 5,45 5,65 30,65" />
                </g>
              </g>
            </svg>

		</span>


                <div class="group">


                    <div class="navItem" style="margin-top: 100px">
                        <span role="link" tabindex="0" class="navItemLink">
                           <a href="mainpage.php" style="text-decoration: none; font-size: large">Back to Main Page</a>

                        </span>
                    </div>

                </div>

            </nav>
        </div>


        <div id="loginContainer"">

            <div id="inputContainer">
				<form id="loginForm" action="register.php" method="POST">
					<h2>Login to your account</h2>
					<p>
						<?php echo $account->getError(Constants::$loginFailed); ?>
						<label for="loginUsername">Username</label>
						<input style="color: white" id="loginUsername" name="loginUsername" type="text" placeholder="e.g. karenyyy" value="<?php getInputValue('loginUsername') ?>" required autocomplete="off">
					</p>
					<p>
						<label for="loginPassword">Password</label>
						<input style="color: white" id="loginPassword" name="loginPassword" type="password" placeholder="password" required>
					</p>

					<button type="submit" name="loginButton">LOG IN</button>

					<div class="hasAccountText">
						<span style="color: white" id="hideLogin">Don't have an account yet? Signup here.</span>
					</div>

				</form>



				<form id="registerForm" action="register.php" method="POST" enctype="multipart/form-data">
					<h2>Create your free account</h2>
					<p>
						<?php echo $account->getError(Constants::$usernameCharacters); ?>
						<?php echo $account->getError(Constants::$usernameTaken); ?>
						<label for="username">Username</label>
						<input style="color: white" id="username" name="username" type="text" placeholder="e.g. karenyyy" value="<?php getInputValue('username') ?>" required>
					</p>

					<p>
						<?php echo $account->getError(Constants::$firstNameCharacters); ?>
						<label for="firstName">First name</label>
						<input style="color: white" id="firstName" name="firstName" type="text" placeholder="e.g. Karen" value="<?php getInputValue('firstName') ?>" required>
					</p>

					<p>
						<?php echo $account->getError(Constants::$lastNameCharacters); ?>
						<label for="lastName">Last name</label>
						<input style="color: white" id="lastName" name="lastName" type="text" placeholder="e.g. Ye" value="<?php getInputValue('lastName') ?>" required>
					</p>

					<p>
						<?php echo $account->getError(Constants::$emailsDoNotMatch); ?>
						<?php echo $account->getError(Constants::$emailInvalid); ?>
						<?php echo $account->getError(Constants::$emailTaken); ?>
						<label for="email">Email</label>
						<input style="color: white" id="email" name="email" type="email" placeholder="e.g. karenye.psu@gmail.com" value="<?php getInputValue('email') ?>" required>
					</p>


					<p>
						<?php echo $account->getError(Constants::$passwordsDoNoMatch); ?>
						<?php echo $account->getError(Constants::$passwordNotAlphanumeric); ?>
						<?php echo $account->getError(Constants::$passwordCharacters); ?>
						<label for="password">Password</label>
						<input style="color: white" id="password" name="password" type="password" placeholder="password" required>
					</p>

					<p>
						<label for="password2">Confirm password</label>
						<input style="color: white" id="password2" name="password2" type="password" placeholder="password" required>
					</p>

                    <p>
                        <label for="profilePicToUpload">Upload Profile Picture</label><br>
                        <input style="color: white" type="file" name="profilePicToUpload" id="profilePicToUpload">
                    </p>
					<button type="submit" name="registerButton">SIGN UP</button>

					<div class="hasAccountText" style="color: white">
						<span id="hideRegister">Already have an account? Log in here.</span>
					</div>

				</form>


			</div>

			<div id="container" style="float: right">
<!--                <svg class="heart-loader" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="-100 -100 90 90" version="1.1">-->
<!--                    <g class="heart-loader__group">-->
<!--                        <path class="heart-loader__square" stroke-width="1" fill="none" d="M0,30 0,90 60,90 60,30z"/>-->
<!--                        <path class="heart-loader__circle m--left" stroke-width="1" fill="none" d="M60,60 a30,30 0 0,1 -60,0 a30,30 0 0,1 60,0"/>-->
<!--                        <path class="heart-loader__circle m--right" stroke-width="1" fill="none" d="M60,60 a30,30 0 0,1 -60,0 a30,30 0 0,1 60,0"/>-->
<!--                        <path class="heart-loader__heartPath" stroke-width="2" d="M60,30 a30,30 0 0,1 0,60 L0,90 0,30 a30,30 0 0,1 60,0" />-->
<!--                    </g>-->
<!--                </svg>-->
<!--                -->
                <div id="holder">
                    <div id="viewport">
                        <div class="subviewport expl">
                            <div id="explosion">
                                <div id="explosion-circle"></div>
                            </div>
                        </div>
                        <div class="subviewport red">
                            <div class="circles">
                                <div class="circle-top"> </div><div class="circle-top"> </div><div class="circle-top"></div><div class="circle-top"> </div>
                            </div>
                        </div>


                        <div class="hexagon dude" style="">
                            <div class="face"> </div>

                        </div>

                        <div class="subviewport orange">
                            <div class="circles">
                                <div class="circle-top"> </div><div class="circle-top"> </div><div class="circle-top"></div><div class="circle-top"> </div>
                            </div>
                        </div>


                        <div class="box dude" style="
                     "> <div class="face" style="
                        "></div></div>

                        <div class="subviewport green" style="
                     ">
                            <div class="circles">
                                <div class="circle-top"> </div><div class="circle-top"> </div><div class="circle-top"></div><div class="circle-top"> </div><div class="circle-top"> </div>
                            </div>
                        </div>

                        <div class="rectangle dude">
                            <div class="face"> </div>
                        </div>

                        <div class="subviewport blue" style="
                     ">
                            <div class="circles">
                                <div class="circle-top"> </div><div class="circle-top"> </div><div class="circle-top"> </div><div class="circle-top"> </div><div class="circle-top"> </div><div class="circle-top"></div><div class="circle-top"></div><div class="circle-top"> </div>
                            </div>
                        </div>

                        <div class="circle dude">
                            <div class="face"> </div>
                        </div>

                    </div>
                </div>

		</div>
	</div>

</body>

</html>
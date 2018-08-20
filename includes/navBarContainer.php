
<link rel="stylesheet" type="text/css" href="assets/css/style.css">
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

			<div class="navItem">
				<span role='link' tabindex='0' onclick='openPage("search.php")' class="navItemLink">
					Search
					<img src="assets/images/icons/search.png" class="icon" alt="Search">
				</span>
			</div>

		</div>

		<div class="group">

            <div class="navItem">
                <span role="link" tabindex="0" onclick="openPage('addsong.php')" class="navItemLink">Upload a song</span>
            </div>

            <div class="navItem">
                <span role="link" tabindex="0" onclick="openPage('browse.php')" class="navItemLink">My Music Collections</span>
            </div>

			<div class="navItem">
				<span role="link" tabindex="0" onclick="openPage('yourMusic.php')" class="navItemLink">My Playlists</span>
			</div><br><br>


			<div class="navItem">
				<span role="link" tabindex="0" onclick="openPage('settings.php')" class="navItemLink"><?php echo $userLoggedIn->getFirstAndLastName(); ?></span>
			</div>


		</div>

	</nav>
</div>

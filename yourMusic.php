<?php
include("includes/includedFiles.php");
?>
<link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
<div id="background">




<div class="playlistsContainer">

	<div class="gridViewContainer">
		<h2>PLAYLISTS</h2>

		<div class="buttonItems">
			<button class="button green" onclick="createPlaylist()">NEW PLAYLIST</button>
		</div>

        <?php

        function resize_image($file, $w, $h, $specific=false, $crop=false) {
            list($width, $height) = getimagesize($file);
            $r = $width / $height;
            if ($crop) {
                if ($width > $height) {
                    $width = ceil($width-($width*abs($r-$w/$h)));
                } else {
                    $height = ceil($height-($height*abs($r-$w/$h)));
                }
                $newwidth = $w;
                $newheight = $h;
            } else {
                if ($w/$h > $r) {
                    if ($specific){
                        $newwidth = $w;
                        $newheight = $h;
                    }else{
                        $newwidth = $h*$r;
                        $newheight = $h;
                    }

                } else {
                    if ($specific) {
                        $newheight = $h;
                        $newwidth = $w;
                    }else{
                        $newheight = $w / $r;
                        $newwidth = $w;
                    }
                }
            }
            if (exif_imagetype($file) === IMAGETYPE_JPEG) {
                $src = imagecreatefromjpeg($file);
            }else{
                $src = imagecreatefrompng($file);
            }
            $dst = imagecreatetruecolor($newwidth, $newheight);
            imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

            return $dst;
        }

        ?>

		<?php

			$username = $userLoggedIn->getUsername();

            $playlistPic = "assets/images/playlist-pics/" . $username;


            array_multisort($times = array_map('filemtime', $files = glob("$playlistPic/*")), SORT_DESC, $files);

            $playlistPic = explode("spotify/", $files[0])[1];

            $img = resize_image($playlistPic, 500, 500, true);

            if (exif_imagetype($playlistPic) === IMAGETYPE_JPEG) {
                imagejpeg($img, $playlistPic);
            }else{
                imagepng($img, $playlistPic);
            }


            $playlistsQuery = $con->query("SELECT * FROM playlists WHERE owner='$username'");

			if(mysqli_num_rows($playlistsQuery) == 0) {
				echo "<span style='font-weight: bold; margin: 100px 580px; font-size: x-large' class='noResults'>You don't have any playlists yet.</span>";
			}

			while($row = mysqli_fetch_array($playlistsQuery)) {

				$playlist = new Playlist($con, $row);

				echo "<div class='gridViewItem'>
                            <span  role='link' tabindex='0' onclick='openPage(\"playlist.php?id=" . $playlist->getId() . "\")'>
                                <img style=\"border-radius:50%;\" src='$playlistPic'>
                     
                                <div class='gridViewInfo'>
						    <div class=\"svg-wrapper\">
                               <svg height=\"90\" width=\"120\" xmlns=\"http://www.w3.org/2000/svg\">
                                    <rect class=\"shape\" height=\"70\" width=\"150\" />
                                </svg>
                              <div class=\"text\">". $playlist->getName() ."</div>
                             </div>
						</div>
                            </span>
					</div>";



			}
		?>






	</div>

</div>

</div>


<style>
    #background {
        background-color: #000;
        background-image: url(./assets/images/bg5.jpg);
        background-position: center;
        background-size: cover;
        display: table;
        height: 100%;
        width: 100%;
    }

    .svg-wrapper {
        height: 90px;
        margin: 0 auto;
        position: relative;
        top: 20%;
        transform: translateY(-50%);
        width: 120px;
    }

    .shape {
        fill: transparent;
        stroke-dasharray: 140 540;
        stroke-dashoffset: -474;
        stroke-width: 7px;
        stroke: #19f6e8;
    }

    .text {
        color: #fff;
        font-weight: bolder;
        font-size: 14px;
        letter-spacing: 1px;
        line-height: 32px;
        position: relative;
        top: -48px;
    }

    @keyframes draw {
        0% {
            stroke-dasharray: 140 540;
            stroke-dashoffset: -474;
            stroke-width: 12px;
        }
        100% {
            stroke-dasharray: 560;
            stroke-dashoffset: 0;
            stroke-width: 2px;
        }
    }

    .svg-wrapper:hover .shape {
        -webkit-animation: 0.5s draw linear forwards;
        animation: 0.5s draw linear forwards;
    }



</style>
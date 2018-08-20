<?php include("includes/includedFiles.php");


if(isset($_GET['id'])) {
	$albumId = $_GET['id'];
}
else {
	header("Location: index.php");
}


$album = new Album($con, $albumId);
$artist = $album->getArtist();

$artistId = $artist->getId();

?>

<link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">

<div id="background">
<div class="entityInfo">

	<div class="leftSection">
        <div class="ball" style="background-image: url('<?php echo $album->getArtworkPath();?>')"></div>
        <div class="ball-shadow"></div>
	</div>

	<div class="rightSection">
		<h2><?php echo $album->getTitle(); ?></h2>
		<p role="link" tabindex="0" onclick="openPage('artist.php?id=<?php echo $artistId; ?>')">By <?php echo $artist->getName(); ?></p>
		<p><?php echo $album->getNumberOfSongs(); ?> songs</p><br>

        <section class='rating-widget' style="float: right">
            <link rel="stylesheet" href="assets_/css/plugins.css" />
            <!-- Rating Stars Box -->
            <div class='rating-stars text-center' style="margin-bottom: -50px">
                <ul id='stars'>
                    <li class='star' title='Poor' data-value='1'>
                        <i class='fa fa-star fa-fw'></i>
                    </li>
                    <li class='star' title='Fair' data-value='2'>
                        <i class='fa fa-star fa-fw'></i>
                    </li>
                    <li class='star' title='Good' data-value='3'>
                        <i class='fa fa-star fa-fw'></i>
                    </li>
                    <li class='star' title='Excellent' data-value='4'>
                        <i class='fa fa-star fa-fw'></i>
                    </li>
                    <li class='star' title='WOW!!!' data-value='5'>
                        <i class='fa fa-star fa-fw'></i>
                    </li>
                </ul>
            </div>

            <div class='success-box' style="width: 95%; float: right">
                <div class='clearfix'></div>
                <img alt='tick image' width='32' src='https://i.imgur.com/3C3apOp.png'/>
                <div class='text-message' style="color: black"></div>
                <div class='clearfix'></div>
            </div>



        </section>

        <script>
            $(document).ready(function(){

                /* 1. Visualizing things on Hover - See next part for action on click */
                $('#stars li').on('mouseover', function(){
                    var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on

                    // Now highlight all the stars that's not after the current hovered star
                    $(this).parent().children('li.star').each(function(e){
                        if (e < onStar) {
                            $(this).addClass('hover');
                        }
                        else {
                            $(this).removeClass('hover');
                        }
                    });

                }).on('mouseout', function(){
                    $(this).parent().children('li.star').each(function(e){
                        $(this).removeClass('hover');
                    });
                });


                /* 2. Action to perform on click */
                $('#stars li').on('click', function(){
                    var onStar = parseInt($(this).data('value'), 10); // The star currently selected
                    var stars = $(this).parent().children('li.star');

                    for (i = 0; i < stars.length; i++) {
                        $(stars[i]).removeClass('selected');
                    }

                    for (i = 0; i < onStar; i++) {
                        $(stars[i]).addClass('selected');
                    }

                    // JUST RESPONSE (Not needed)
                    var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
                    var msg = "";
                    if (ratingValue > 1) {
                        msg = "Thanks! You rated this " + ratingValue + " stars.";
                    }
                    else {
                        msg = "We will improve ourselves. You rated this " + ratingValue + " stars.";
                    }
                    responseMessage(msg);

                });


            });


            function responseMessage(msg) {
                $('.success-box').fadeIn(200);
                $('.success-box div.text-message').html("<span style='color: black'>" + msg + "</span>");
            }
        </script>

        <div class="headerButtons">
            <button class="button green" onclick="playFirstSong()">PLAY</button>
            <button class="button" onclick="openPage('addsong.php')">ADD A SONG</button>
            <button class="button" name="updateAlbumButton" onclick="showUpdateAlbum('album_form')" >UPDATE ALBUM INFO</button>
            <button class="button" onclick="deleteAlbum('<?php echo $albumId; ?>')">DELETE ALBUM</button>

            <form action="API/similarArtists.php" method="POST">
                <span style="font-weight: bold; font-size: x-large; font-style: oblique"> Get Similar Artists: </span>
                <input type='submit' class='button' style='color: white; margin: 3px 25px; font-weight: bold' name='recommend' value='<?php echo $artist->getName(); ?>'>
            </form>

        </div>

	</div>


</div>

    <?php

    // isset == !empty
    if(isset($_POST['updateAlbumButton'])) {
        echo '<script>
				$(document).ready(function() {
					$("#album_form").show();
				});
			</script>';
    }
    else {
        echo '<script>
				$(document).ready(function() {
					$("#album_form").hide();
				});
			</script>';
    }

    if(isset($_POST['updateSongButton'])) {
        echo '<script>
				$(document).ready(function() {
					$("#song_form").show();
				});
			</script>';
    }
    else {
        echo '<script>
				$(document).ready(function() {
					$("#song_form").hide();
				});
			</script>';
    }

    ?>


    <div id="album_form">
        <form action="includes/handlers/ajax/updateAlbum.php" method="post" enctype="multipart/form-data">
            <fieldset id="field">
                <p>
                <label for="title">New Title: </label>
                <input style="color: black" type="text" name="title" class="title" value="<?php echo $album->getTitle();?>">
                </p>
                <p>
                <label for="artist">New Artist:</label>
                <input style="color: black" type="text" name="artist" id="artist" class="artist" value="<?php echo $artist->getName(); ?>">
                </p>
                <p>
                <label for="artworkPath">Cover: </label>
                    <input type="file" name="coverPicToUpdate" class="coverPicToUpdate">
                </p><br>
                <button name="cancelUpdateButton" style="float: right" class="button" onclick="hideUpdateAlbum('album_form')" >Cancel</button>
                <button style="float: right" class="button" name="updatedButton" type="submit" onclick="updateAlbum('title', 'artist', <?php echo $albumId ?>, <?php echo $artistId ?>)">Update</button>
                </form>
            </fieldset>
    </div>


<!---->
<!--    --><?php
//    if(isset($_POST['cancelUpdateButton'])) {
//        echo '<script>
//				$(document).ready(function() {
//					$("#album_form").hide();
//				});
//			</script>';
//    }
//
//    if(isset($_POST['updatedButton'])) {
//        $album_path="assets/uploads/".$userLoggedIn."/album_covers/".$artist->getName();
//        array_multisort($times = array_map('filemtime', $files = glob("$album_path/*")), SORT_DESC, $files);
//        $insert_path = explode("spotify/", $files[0])[1];
//        echo $insert_path;
//
//        $sql = "SELECT id FROM users WHERE username = '$userLoggedIn'";
//        $user_id = $con->query($sql);
//        $user_id = mysqli_fetch_array($user_id);
//        $user_id = $user_id['id'];
//
//        $con->query("UPDATE albums SET artworkPath = '$insert_path' WHERE userid=$user_id AND id = $albumId");
//
//    }
//
//    ?>


    <div id="song_form">
        <form action="" method="post" enctype="multipart/form-data">
            <fieldset id="songfield">
                <p>
                    <label for="title">New Title: </label>
                    <input style="color: black" type="text" name="title" class="title">
                </p>
                <p>
                    <label for="path">Cover: </label>
                    <input type="file" name="songToUpdate" class="songToUpdate">
                </p>
                <button name="cancelUpdateButton" style="float: right" class="button" onclick="hideUpdateSong('song_form')">Cancel</button>
                <button style="float: right" class="button" type="submit" onclick="updateSong('title',  <?php echo $albumId ?>, <?php echo $artistId ?>)">Update</button>
        </form>
        </fieldset>
    </div>




    <div class="tracklistContainer">
	<ul class="tracklist">
		
		<?php

        $songIdArray = $album->getSongIds();

		$i = 1;
		foreach($songIdArray as $songId) {

			$albumSong = new Song($con, $songId);
			$album_artist = $albumSong->getArtist();


			$sql="SELECT title FROM Songs WHERE id = '$songId'";
            $song_title = $con->query($sql);
            $song_title = mysqli_fetch_array($song_title);
            $song_title = strtolower($song_title['title']);
            $artist_name = strtolower($album_artist->getName());
            $query = $artist_name.' '.$song_title;
            $query = implode("+", explode(" ", $query));


            $sql = "SELECT url FROM youtubeMv WHERE songid = $songId";
            $song_url = $con->query($sql);
            $song_url = mysqli_fetch_array($song_url);
            $song_url = $song_url['url'];




            echo "<li class='tracklistRow'>
					<div class='trackCount'>
						<img class='play' src='assets/images/icons/play-white.png' onclick='setTrack(\"" . $albumSong->getId() . "\", tempPlaylist, true)'>
						<span class='trackNumber'>$i</span>
					</div>
                    
					<div class='trackInfo'>
						<span class='trackName'>" . $albumSong->getTitle() . "</span>
						<span class='artistName'>" . $artist->getName() . "</span>
						
					</div>
					
					<button style='float: right' class='button' onclick='deleteSong(\"" . $songId . "\")'>Delete Song</button>
					
					<button style='float: right' class='button' onclick=\"showUpdateSong('song_form')\">Update Song Info</button>
			
					
                    <a target=\"_blank\" style='margin: 300px 80px' href=$song_url>$song_url</a>
                  
					<div class='trackOptions'>
						
						<input type='hidden' class='songId' value='" . $albumSong->getId() . "'>
						<img class='optionsButton' src='assets/images/icons/more.png' onclick='showOptionsMenu(this)'>
					</div>

					<div class='trackDuration'>
					
						<span class='duration'>" . $albumSong->getDuration() . "</span>
					</div>


				</li>";

			$i = $i + 1;
		}
		?>



        <script>
			var tempSongIds = '<?php echo json_encode($songIdArray); ?>';
			tempPlaylist = JSON.parse(tempSongIds);
		</script>

	</ul>
</div>


<nav class="optionsMenu">
	<input type="hidden" class="songId">
	<?php echo Playlist::getPlaylistsDropdown($con, $userLoggedIn->getUsername()); ?>
</nav>


</div>




<style>

    #background {
        background-color: #000;
        background-image: url(assets/images/bg1.jpg);
        background-position: center;
        background-size: cover;
        display: table;
        height: 100%;
        width: 100%;
    }

    #field {
        border-radius: 15px 50px 30px;
        background: green;
        padding: 20px;
        width: 350px;
        height: 230px;
    }

    #songfield {
        border-radius: 15px 50px 30px;
        background: green;
        padding: 20px;
        width: 350px;
        height: 150px;
    }



</style>


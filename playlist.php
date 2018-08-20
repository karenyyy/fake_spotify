<?php include("includes/includedFiles.php"); 

if(isset($_GET['id'])) {
	$playlistId = $_GET['id'];
}
else {
	header("Location: index.php");
}

$playlist = new Playlist($con, $playlistId);
$owner = new User($con, $playlist->getOwner());


$profilePic = "assets/images/profile-pics/".$owner->getUsername();
array_multisort($times = array_map('filemtime', $files = glob("$profilePic/*")), SORT_DESC, $files);
$profilePic = explode("spotify/", $files[0])[1];
$playlistPic = "assets/images/playlist-pics/" . $owner->getUsername();

if (!is_dir($playlistPic)) {
    mkdir($playlistPic, 0777, true);
}

$iterator = new \FilesystemIterator($playlistPic);
$isDirEmpty = !$iterator->valid();
if ($isDirEmpty) {
    copy($profilePic, $playlistPic . "/" . 'placeholder.jpg');
}


array_multisort($times = array_map('filemtime', $files = glob("$playlistPic/*")), SORT_DESC, $files);

$playlistPic = explode("spotify/", $files[0])[1];

?>

<div id="background">

<div class="entityInfo">

	<div class="leftSection">
        <div class="ball" style="background-image: url(<?php echo $playlistPic?>)"></div>
        <div class="ball-shadow"></div>
	</div>



	<div class="rightSection">
		<h2><?php echo $playlist->getName(); ?></h2>
		<p>By <?php echo $playlist->getOwner(); ?></p>
		<p><?php echo $playlist->getNumberOfSongs(); ?> songs</p>
        <button class="button green" onclick="playFirstSong()">PLAY</button>
		<button class="button" onclick="deletePlaylist('<?php echo $playlistId; ?>')">DELETE PLAYLIST</button>
        <br>

        <form action="updatePlaylistPic.php" method="post" enctype="multipart/form-data">
        <input style="color: white;" type="file" name="playlistPicToUpdate" id="playlistPicToUpdate">
        <input class="button" name="updateButton" type="submit" value="Update cover for <?php echo  $playlist->getName();?>">
        </form>

	</div>

</div>


<div class="tracklistContainer">
	<ul class="tracklist">
		
		<?php
		$songIdArray = $playlist->getSongIds();

		$i = 1;
		foreach($songIdArray as $songId) {

			$playlistSong = new Song($con, $songId);
			$songArtist = $playlistSong->getArtist();

            $sql = "SELECT url FROM youtubeMv WHERE songid = $songId";
            $song_url = $con->query($sql);
            $song_url = mysqli_fetch_array($song_url);
            $song_url = $song_url['url'];



            echo "<li class='tracklistRow'>
					<div class='trackCount'>
						<img class='play' src='assets/images/icons/play-white.png' onclick='setTrack(" . $playlistSong->getId() . ", tempPlaylist, true)'>
						<span class='trackNumber'>$i</span>
					</div>


					<div class='trackInfo'>
						<span class='trackName'>" . $playlistSong->getTitle() . "</span>
						<span class='artistName'>" . $songArtist->getName() . "</span>
					</div>

                    <button style='float: right' class='button' onclick='deleteSong(\"" . $songId . "\")'>Delete Song</button>
                    
                    <a target=\"_blank\" style='margin: 130px' href=$song_url>$song_url</a>
                    
					<div class='trackOptions'>
						<input type='hidden' class='songId' value='" . $playlistSong->getId() . "'>
						<img class='optionsButton' src='assets/images/icons/more.png' onclick='showOptionsMenu(this)'>
					</div>

					<div class='trackDuration'>
						<span class='duration'>" . $playlistSong->getDuration() . "</span>
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
	<div class="item" onclick="removeFromPlaylist(this, '<?php echo $playlistId; ?>')">Remove from Playlist</div>
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
</style>







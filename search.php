<?php
include("includes/includedFiles.php");

if(isset($_GET['term'])) {
	$term = urldecode($_GET['term']);
}
else {
	$term = "";
}
?>

<div class="searchContainer">

	<h4>Search for an artist, album or song</h4><br>
	<input type="text" style="font-size: large; font-weight: bold" class="searchInput" value="<?php echo $term; ?>" placeholder="Start typing..." onfocus="this.value = this.value">

</div>

<script>

$(".searchInput").focus();

$(function() {
	
	$(".searchInput").keyup(function() {
		clearTimeout(timer);

		timer = setTimeout(function() {
			var val = $(".searchInput").val();
			openPage("search.php?term=" + val);
		}, 2000);

	})


})

</script>

<?php if($term == "") exit(); ?>

<div id="background">

<div class="tracklistContainer borderBottom">
	<h2>SONGS</h2>
	<ul class="tracklist">
		
		<?php

        $user_loggedin = $_SESSION['userLoggedIn'];

        $sql = "SELECT id FROM users WHERE username = '$user_loggedin'";

        $user_id = $con->query($sql);
        $user_id = mysqli_fetch_array($user_id);

        $user_id = $user_id['id'];

        $songsQuery = $con->query("SELECT id FROM Songs WHERE album IN (SELECT id FROM albums WHERE userid = $user_id) AND title LIKE '%$term%' LIMIT 10");

		if(mysqli_num_rows($songsQuery) == 0) {
			echo "<span class='noResults' style=\"font-size: larger; font-weight: bold\">No songs found matching '" . $term . "'</span>";
		}



		$songIdArray = array();

		$i = 1;
		while($row = mysqli_fetch_array($songsQuery)) {

			if($i > 15) {
				break;
			}

			array_push($songIdArray, $row['id']);

			$albumSong = new Song($con, $row['id']);
			$albumArtist = $albumSong->getArtist();

			echo "<li class='tracklistRow'>
					<div class='trackCount'>
						<img class='play' src='assets/images/icons/play-white.png' onclick='setTrack(\"" . $albumSong->getId() . "\", tempPlaylist, true)'>
						<span class='trackNumber'>$i</span>
					</div>


					<div class='trackInfo'>
						<span class='trackName'>" . $albumSong->getTitle() . "</span>
						<span class='artistName'>" . $albumArtist->getName() . "</span>
					</div>

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


<div class="artistsContainer borderBottom">

	<h2>ARTISTS</h2>

	<?php
	$artistsQuery = $con->query("SELECT id FROM artists WHERE name LIKE '%$term%' LIMIT 10");
	
	if(mysqli_num_rows($artistsQuery) == 0) {
		echo "<span class='noResults' style=\"font-size: larger; font-weight: bold\">No artists found matching '" . $term . "'</span>";
	}

	while($row = mysqli_fetch_array($artistsQuery)) {

		$artistFound = new Artist($con, $row['id']);

		echo "<div class='searchResultRow'>
				<div class='artistName'>

					<span style=\"font-size: larger; font-weight: bold\" role='link' tabindex='0' onclick='openPage(\"artist.php?id=" . $artistFound->getId() ."\")'>
					"
					. $artistFound->getName() .
					"
					</span>

				</div>

			</div>";

	}


	?>

</div>

<div class="gridViewContainer">
	<h2>ALBUMS</h2>
	<?php
		$albumQuery = $con->query("SELECT * FROM albums WHERE title LIKE '%$term%' LIMIT 10");

		if(mysqli_num_rows($albumQuery) == 0) {
			echo "<span class='noResults' style=\"font-size: larger; font-weight: bold\">No albums found matching '" . $term . "'</span>";
		}

		while($row = mysqli_fetch_array($albumQuery)) {

			echo "<div class='gridViewItem'>
					<span role='link' tabindex='0' onclick='openPage(\"album.php?id=" . $row['id'] . "\")'>
						<img src='" . $row['artworkPath'] . "'>

						<div class='gridViewInfo'>"
							. $row['title'] .
						"</div>
					</span>

				</div>";



		}
	?>

</div>

<nav class="optionsMenu">
	<input type="hidden" class="songId">
	<?php echo Playlist::getPlaylistsDropdown($con, $userLoggedIn->getUsername()); ?>
</nav>


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

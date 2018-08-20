<?php
include("includes/includedFiles.php");
?>



<div id="background">


    <h1 class="pageHeadingBig">My Music Collections</h1>
    <div class="gridViewContainer">


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
    $user_loggedin = $_SESSION['userLoggedIn'];
    $sql = "SELECT id FROM users WHERE username = '$user_loggedin'";
    $user_id = $con->query($sql);
    $user_id = mysqli_fetch_array($user_id);
    $user_id = $user_id['id'];

    $albumQuery = $con->query("SELECT * FROM albums WHERE userid = $user_id ORDER BY RAND()");
    $name_array = array();
    $visited = array();
		while($row = mysqli_fetch_array($albumQuery)) {
		    $artist_id = $row['artist'];
            $artist_name = $con->query("SELECT name FROM artists WHERE id = $artist_id");
            $artist_name = mysqli_fetch_array($artist_name);
            $artist_name = $artist_name['name'];

            $pic = $row['artworkPath'];
            $img = resize_image($pic, 500, 500, true);
            if (exif_imagetype($pic) === IMAGETYPE_JPEG) {
                imagejpeg($img, $pic);
            }else{
                imagepng($img, $pic);
            }

            if (!in_array($artist_name, $visited)) {
                array_push($visited, $artist_name);
            }
            echo "<div class='gridViewItem'>
					<span role='link' tabindex='0' onclick='openPage(\"album.php?id=" . $row['id'] . "\")'>
						<img style=\"border-radius:50%;\" src='" . $row['artworkPath'] . "'>
                        <div class=\"text\" style='visibility: hidden'>" . $row['title'] . "</div>
						<div class='gridViewInfo'>
						    <div class=\"svg-wrapper\">
                               <svg height=\"90\" width=\"120\" xmlns=\"http://www.w3.org/2000/svg\">
                                    <rect class=\"shape\" height=\"70\" width=\"150\" />
                                </svg>
                              <div class=\"text\">". $row['title'] ."</div>
                             </div>
						</div>
					</span>

				</div>";
		}

    foreach ($visited as $item) {
        array_push($name_array, $item);
	}

    $fp = fopen('assets/json_files/names.json', 'w');
    fwrite($fp, json_encode($name_array, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
    fclose($fp);


    ?>

        <script>
            $(document).ready(function() {
                $.getJSON("assets/json_files/names.json", function (json) {
                    var html = '';
                    var visited = [];
                    $.each(json, function (i, item) {
                        var path = "";
                        if (visited.indexOf(item)<=-1) {
                            visited.push(item);
                            var index = visited.length;
                            item = visited[index-1];
                        }
                        path += "http://ws.audioscrobbler.com/2.0/?method=artist.getsimilar&limit=7&artist=";
                        path += item;
                        path += "&api_key=e4352f4de078644ba4e562e03f3b23d3&format=json&callback=?";
                        $.getJSON(path, function (json) {
                            var html = "<br><br>";
                            html += "<h1 style=\"text-align: center\">Because you like " + "<span style='color: green'>"+item+"</span>" + ", you might also like ...</h1><br><div id=\"mainContent\">";
                            html += "<div class=\"gridViewContainer\">";
                            var image_path;
                            $.each(json.similarartists.artist, function (i, item) {
                                html += "<div class=\"gridViewItem\">";
                                // html += "<form id=\"similarForm\" action=\"similarArtists.php\" method=\"POST\">";
                                html += "<input type='submit' id='btn' style='color: black; margin: 3px 25px; font-weight: bold' name='recommend' value='" + item.name + "'>";
                                html += "<span role=\"link\" tabindex=\"0\" onclick=window.open(\"" + item.url + "\")>";
                                image_path = '"' + JSON.stringify(item.image[4]).replace("#", "").split(",")[0].split("\":\"")[1];
                                html += "<img style='border-radius: 50%' src=" + image_path + ">";
                                html += "<div class='gridViewInfo' style='font-weight: bold'>" + item.name + "<br>" + "<span style='color: deepskyblue'>"+"Matched probability: " + "<br>" + item.match +"</span>"+ "</div></span></div>";
                            });
                            $('#result').append(html);
                        });
                    });
                });
            });
        </script>


        <div>
            <form id="similarForm" action="API/similarArtists.php" method="POST">
                <div id="result"></div>
            </form>
        </div>

</div>
</div>

<style>
    #background {
        display: table;
        height: 100%;
        width: 100%;
        background: linear-gradient(70deg, black, #0D3542, black, #0D3542, black, #0D3542, black);
    }

    #btn {
        width: 150px;
        font: bold 13px "Helvetica Neue", Helvetica, Arial, clean, sans-serif !important;
        text-shadow: 0 -1px 1px rgba(0,0,0,0.25), -2px 0 1px rgba(0,0,0,0.25);
        border-radius: 5px;
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        -moz-box-shadow: 0 1px 2px rgba(0,0,0,0.5);
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,0.5);
        display: inline-block;
        color: white;
        padding: 5px 10px 5px;
        white-space: nowrap;
        text-decoration: none;
        cursor: pointer;
        background: green url(API/button3.png) repeat-x scroll 0 0;
        border-style: none;
        text-align: center;
        overflow: visible;
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
        font-size: 15px;
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
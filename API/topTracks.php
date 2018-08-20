<html>
<head>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../assets/js/script.js"></script>
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">

</head>
<body>


<div id="navBarContainer">
    <nav class="navBar">

		<span role="link" tabindex="0" onclick="openPage('../index.php')" class="logo">
			<img src="../assets/images/icons/pp.png">
		</span>


        <div class="group">

            <div class="navItem">
                <span role="link" tabindex="0" onclick="openPage('us_top.php')" class="navItemLink">US Top List</span>
            </div>

            <div class="navItem">
                <span role="link" tabindex="0" onclick="openPage('canada_top.php')" class="navItemLink">Canada Top List</span>
            </div>

            <div class="navItem">
                <span role="link" tabindex="0" onclick="openPage('france_top.php')" class="navItemLink">France Top List</span>
            </div>

            <div class="navItem">
                <span role="link" tabindex="0" onclick="openPage('spain_top.php')" class="navItemLink">Spain Top List</span>
            </div>

            <div class="navItem">
                <span role="link" tabindex="0" onclick="openPage('china_top.php')" class="navItemLink">China Top List</span>
            </div>

            <div class="navItem">
                <span role="link" tabindex="0" onclick="openPage('india_top.php')" class="navItemLink">India Top List</span>
            </div>
        </div>

    </nav>
</div>



<script>
    $(document).ready(function() {
        $.getJSON("http://ws.audioscrobbler.com/2.0/?method=chart.gettoptracks&limit=100&api_key=e4352f4de078644ba4e562e03f3b23d3&format=json&callback=?", function(json) {
            var html = "<h1 style='text-align: center'>Top 100 Tracks of 2018 (US)</h1><br><div id=\"mainContent\" style='margin-left: 250px'>";
            html += "<div class=\"gridViewContainer\">";
            var image_path;
            $.each(json.tracks.track, function(i, item) {
                html += "<div class=\"gridViewItem\">";
                html += "<form id=\"similarForm\" action=\"similarArtists.php\" method=\"POST\">";
                html +="<button id='btn' style='color: black; margin: 3px 25px; font-weight: bold' onclick=\"window.location.href='similarTracks.php'\">recommendation</button></form>";
                html += "<span role=\"link\" tabindex=\"0\" onclick=window.open(\"" +item.url +"\")>";
                image_path='"'+ JSON.stringify(item.image[3]).replace("#", "").split(",")[0].split("\":\"")[1];
                html += "<img src=" + image_path +">";
                html += "<div class='gridViewInfo' style='font-weight: bold'>" + "Song Title: " +item.name + "<br>" + "Artist : " +item.artist.name +"<br>"+ "Play count : " +item.playcount + "</div></span></div>";

            });

            html += "</div>";
            $('#result').append(html);
        });
    });
</script>
<div id="result"></div>


</body>

<style>
    #btn {
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
        background: #A9014B url(button3.png) repeat-x scroll 0 0;
        border-style: none;
        text-align: center;
        overflow: visible;
    }

    #result {
        background-color: #000;
        background-image: url(../assets/images/bg6.png);
        background-position: center;
        background-size: cover;
        display: table;
        height: 100%;
        width: 100%;
    }

</style>
</html>
<html>
<head>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../assets/js/script.js"></script>
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">


</head>
<body>

<?php
include("../includes/config.php");
$country = $_POST['country'];
?>

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
                <span role="link" tabindex="0" onclick="openPage('India.php')" class="navItemLink">India Top List</span>
            </div>
        </div>

    </nav>
</div>


<script>
    $(document).ready(function() {
        $.getJSON("http://ws.audioscrobbler.com/2.0/?method=geo.gettopartists&country=<?php echo $country?>&limit=100&api_key=e4352f4de078644ba4e562e03f3b23d3&format=json&callback=?", function(json) {
            var html = "<h1 style='text-align: center'>Top 100 Artists of 2018 (<?php echo ucfirst($country)?>)</h1><br><div id=\"mainContent\" style='margin-left: 250px'>";
            html += "<div class=\"gridViewContainer\">";
            var image_path;
            $.each(json.topartists.artist, function(i, item) {
                html += "<div class=\"gridViewItem\">";
                // html += "<form id=\"similarForm\" action=\"similarArtists.php\" method=\"POST\">";
                html +="<input type='submit' id='btn' style='color: black; margin: 3px 25px; font-weight: bold' name='recommend' value='" + item.name + "'>";
                html += "<span role=\"link\" tabindex=\"0\" onclick=window.open(\"" +item.url +"\")>";
                image_path='"'+ JSON.stringify(item.image[4]).replace("#", "").split(",")[0].split("\":\"")[1];
                html += "<img src=" + image_path +">";
                html += "<div class='gridViewInfo' style='font-weight: bold'>" + item.name + "<br>" + "Play count : " +item.listeners + "</div></span></div>";

            });

            html += "</div>";
            $('#result').append(html);
        });
    });
</script>
<div>
    <form id="similarForm" action="similarArtists.php" method="POST">
        <div id="result"></div>
    </form>
</div>

</body>

<style>
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
        background: green url(button3.png) repeat-x scroll 0 0;
        border-style: none;
        text-align: center;
        overflow: visible;
    }


</style>
</html>
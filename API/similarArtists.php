<html>
<head>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
    <script src="../assets/js/script.js"></script>
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
</head>
<body>

<div id="background">
<div id="navBarContainer">
    <nav class="navBar">

		<span role="link" tabindex="0" onclick="openPage('../index.php')" class="logo">
			<span role="link" tabindex="0" onclick="openPage('index.php')" class="logo">
			<svg class="logo" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="28" height="28" viewBox="10 0 70 70" version="1.1">
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

		</span>


        <div class="group">


            <div class="navItem" style="margin-top: 100px">
                        <span role="link" tabindex="0" class="navItemLink">
                           <a href="../mainpage.php" style="text-decoration: none; font-size: large">Back to Main Page</a>

                        </span>
            </div>

        </div>

    </nav>
</div>

<?php
$artist = $_POST['recommend'];
?>

<script>

    $(document).ready(function() {
        var path="";
        path += "http://ws.audioscrobbler.com/2.0/?method=artist.getsimilar&limit=100&artist=";
        path += "<?php echo $artist?>";
        path += "&api_key=e4352f4de078644ba4e562e03f3b23d3&format=json&callback=?";
        $.getJSON(path, function(json) {
            var html = "<h1 style='text-align: center'>Similar Artists of '"+"<?php echo $artist?>"+"'</h1><br><div id=\"mainContent\" style='margin-left: 250px'>";
            html += "<div class=\"gridViewContainer\">";
            var image_path;
            $.each(json.similarartists.artist, function(i, item) {
                html += "<div class=\"gridViewItem\">";
                // html += "<form id=\"similarForm\" action=\"similarArtists.php\" method=\"POST\">";
                html +="<input type='submit' id='btn' style='color: black; margin: 3px 25px; font-weight: bold' name='recommend' value='"+item.name+"'>";
                html += "<span role=\"link\" tabindex=\"0\" onclick=window.open(\"" +item.url +"\")>";
                image_path='"'+ JSON.stringify(item.image[4]).replace("#", "").split(",")[0].split("\":\"")[1];
                html += "<img style='border-radius: 50%' src=" + image_path +">";
                html += "<div class='gridViewInfo' style='font-weight: bold'>" + item.name + "<br>" + "<span style='color: green'>"+"Matched probability: "+ "<br>" +item.match +"</span>"+ "</div></span></div>";

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

    #background {
        display: table;
        height: 100%;
        width: 100%;
        background: linear-gradient(50deg, black, darkslategray, black);
    }

</style>

</html>
<html>
<head>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
</head>
<body>

<?php
$tracks = $_POST['recommend'];
?>

<script>

    $(document).ready(function() {
        var path="";
        path += "http://ws.audioscrobbler.com/2.0/?method=track.getsimilar&limit=98&artist=";
        path += "taylorswift";
        path += "&track=";
        path += "Love Story";
        path += "&api_key=e4352f4de078644ba4e562e03f3b23d3&format=json&callback=?";
        $.getJSON(path, function(json) {
            var html = "<h1 style='text-align: center'>Similar Tracks of 'Love Story' by 'Taylor Swift'</h1><br><div id=\"mainContent\" style='margin-left: 150px'>";
            html += "<div class=\"gridViewContainer\">";
            var image_path;
            $.each(json.similartracks.track, function(i, item) {
                html += "<div class=\"gridViewItem\">";
                html +="<button style='color: black; margin: 3px 25px; font-weight: bold' onclick=\"window.location.href='similarTracks.php'\">recommendation</button></form>";
                html += "<span role=\"link\" tabindex=\"0\" onclick=window.open(\"" +item.url +"\")>";
                image_path='"'+ JSON.stringify(item.image[4]).replace("#", "").split(",")[0].split("\":\"")[1];
                html += "<img src=" + image_path +">";
                html += "<div class='gridViewInfo' style='font-weight: bold'>" + item.name + "<br>" + "Matched probability: "+ "<br>" +item.match + "</div></span></div>";

            });

            html += "</div>";
            $('#result').append(html);
        });
    });
</script>


<div id="result"></div>


</body>

<style>
    button {
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

    .button:hover,
    .button:focus {
        background-position: 0 -50px;
        color: white;
    }

    .button:active {
        background-position: 0 -100px;
        -moz-box-shadow: inset 0 1px 2px rgba(0,0,0,0.7);
        -webkit-box-shadow: none;
    }
</style>

</html>
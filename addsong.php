<?php
include("includes/classes/Account.php");
include("includes/classes/Constants.php");

include("includes/handlers/register-handler.php");


function getInputValue($name) {
    if(isset($_POST[$name])) {
        echo $_POST[$name];
    }
}
?>

<html>
<head>
    <title>Welcome to Karenyyy's PHP music site!</title>

    <link rel="stylesheet" type="text/css" href="assets/css/register.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


</head>
<body>

<div id="background">
    <div>
        <h1 style="color: #fff; text-align: center">Add a new song</h1>
    </div>

     <div id="inputContainer" style="width: 400px; padding: 10px 600px;">


         <form id="addSongForm" action="upload.php" method="post" enctype="multipart/form-data">


                <p>
                    <label for="title">Song Title</label>
                    <input style="color: white" id="title" name="title" type="text" placeholder="e.g. Sorry Not Sorry" value="<?php getInputValue('title') ?>" required>
                </p>

                <p>
                    <label for="songToUpload">Upload Song</label>
                    <input style="color: white" type="file" name="songToUpload" id="songToUpload">
                </p>



                <p>
                    
                    <label for="artist">Artist</label>
                    <input style="color: white" id="artist" name="artist" type="text" placeholder="e.g. Demi Lovato" value="<?php getInputValue('artist') ?>" required>
                </p>


                <p>
                    <label for="album">Album Name</label>
                    <input style="color: white" id="album" name="album" type="text" placeholder="e.g. Tell Me You Love Me" value="<?php getInputValue('album') ?>" required>
                </p>


                <p>
                    <label for="albumToUpload">Upload Album Cover</label>
                    <input style="color: white" type="file" name="albumToUpload" id="albumToUpload">
                </p><br><br><br>


                <input type="submit" class="button" value="Upload Song" name="submit" style="color: #fff;float: right">

            </form>


     </div>

</div>


</body>


</html>
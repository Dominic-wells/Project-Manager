<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Googlefonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@500&display=swap" rel="stylesheet">
    <title>The Project King</title>
    <!--Bootstrap CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <!--Custom CSS-->
    <link rel="stylesheet" href="assets/css/style.css" type="text/css" />
    <!--Sortable,js-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.10.2/Sortable.min.js"></script>
    <!--Meta data-->
    <meta name="description" content="The Project King - A tool to help users manage their lives">
    <meta name="keywords" content="The Project King">
    <meta name="author" content="Joe Wells">
</head>
  <body>


         <!-- The Video -->
         <video autoplay muted loop id="myVideo">
        <source src="assets/video/background3.mp4" type="video/mp4">
    </video>

    <!--The Music-->
    <audio id="background-music">
        <source src="assets/sounds/nexus-img-main-version-22138-02-54.mp3" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>

    <header class="viewport-header">
      
        <div class="button-bar">
            <button id="myBtn" onclick="myFunction()">Pause</button>
            <button id="music-toggle">Toggle Music</button>
            <button  type="button" onclick="location.href='login.php'">Login</button>
        </div>
        <h1>
            Plan With
            <span>The-Project-King</span>     
        </h1>
    </header>
  </body>
  
   <!--Bootstrap JS-->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>

    <!--Custom JS-->
    <script src="assets/js/music.js"></script>
    <script src="assets/js/video.js"></script>
</html>



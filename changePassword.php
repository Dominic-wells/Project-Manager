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
    <title>The Project King - Change Password</title>
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
            <button type="button" onclick="location.href='actions/logout.php'">Logout</button>
            <button  type="button" onclick="location.href='login.php'">Login</button>
            <button id="myBtn" onclick="myFunction()">Pause</button>
            <button id="music-toggle">Toggle Music</button>
        </div>
        <h1>Update password</h1>
    </header>


    <?php
session_start();
require_once 'config.php';
// The database connection file, this is to avoid storing the connection details in plain view

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newPassword = htmlspecialchars($_POST['newPassword']);
    $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $userId = $_SESSION['userId'];
    // Updates the password in the database
    try {
        $stmt = $pdo->prepare("UPDATE users SET password = ?, firstLogin = 0 WHERE userId = ?");
        if ($stmt->execute([$hashedNewPassword, $userId])) {
            header("Location: profilePage.php");
            exit;
        } else {
            echo "Failed to update password.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!-- HTML Form for password change -->
<div class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-dark text-white" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">
                        <h3 class="card-title fw-bold mb-2 text-uppercase">Change Password</h3>
                        <form action="changePassword.php" method="POST">
                            <div class="form-outline form-white mb-4">
                                <label for="newPassword" class="form-label">New Password:</label>
                                <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                            </div>
                            <button type="submit" class="btn btn-outline-light btn-lg px-5">Update Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



       <!--Bootstrap JS-->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>

    <!--Custom JS-->
    <script src="assets/js/music.js"></script>
    <script src="assets/js/video.js"></script>
</html>


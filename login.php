<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@500&display=swap" rel="stylesheet">
    <title>The Project King - Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css" type="text/css" />
    <!-- Meta data -->
    <meta name="description" content="The Project King - A tool to help users manage their lives">
    <meta name="keywords" content="The Project King">
    <meta name="author" content="Joe Wells">
</head>
<body>
    <!-- The Video -->
    <video autoplay muted loop id="myVideo">
        <source src="assets/video/background3.mp4" type="video/mp4">
    </video>

    <!-- The Music -->
    <audio id="background-music">
        <source src="assets/sounds/nexus-img-main-version-22138-02-54.mp3" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>

    <header class="viewport-header">
        <div class="button-bar">
            <button type="button" onclick="location.href='index.php'">Home</button>
            <button type="button" onclick="location.href='actions/logout.php'">Logout</button>
            <button id="myBtn" onclick="myFunction()">Pause</button>
            <button id="music-toggle">Toggle Music</button>
        </div>
        <h1>Login</h1>
    </header>

    <!-- The login form -->
    <div class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <h3 class="card-title fw-bold mb-2 text-uppercase">Login</h3>
                            <form action="login.php" method="POST">
                                <div class="form-outline form-white mb-4">
                                    <label for="inputLogin" class="form-label">Username or Email</label>
                                    <input type="text" class="form-control" id="inputLogin" name="login" required>
                                </div>
                                <div class="form-outline form-white mb-4">
                                    <label for="inputPassword" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="inputPassword" name="password" required>
                                </div>
                                <button type="submit" class="btn btn-outline-light btn-lg px-5">Login</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
session_start();
require_once 'config.php'; 
// The database connection file, this is to avoid storing the connection details in plain view

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = htmlspecialchars($_POST['login']);
    $password = htmlspecialchars($_POST['password']);

    try {
        $stmt = $pdo->prepare("SELECT userId, username, password, role, firstLogin FROM users WHERE username = :username OR email = :email");
        $stmt->bindParam(":username", $login, PDO::PARAM_STR);
        $stmt->bindParam(":email", $login, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $row['password'])) {
                $_SESSION['userId'] = $row['userId'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['role'] = $row['role'];
                // Redirects user to change password page if first login(hasn't changed password yet) else to profile page or adminTasks.php if admin
                if ($row['firstLogin'] == 1) {
                    header("Location: changePassword.php"); 
                    exit;
                } else {
                    if ($row['role'] == 'admin') {
                        header("Location: adminTasks.php");
                        exit;
                    } else {
                        header("Location: profilePage.php"); 
                        exit;
                    }
                }
            } else {
                echo '<div class="alert alert-danger">Invalid password.</div>';
            }
        } else {
            echo '<div class="alert alert-danger">No account found with that username or email.</div>';
        }
    } catch (PDOException $e) {
        echo '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
    }
}
?>


  <!--Bootstrap JS-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
       integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
       crossorigin="anonymous"></script>

   <!--Custom JS-->
   <script src="assets/js/music.js"></script>
   <script src="assets/js/video.js"></script>
</body>
</html>

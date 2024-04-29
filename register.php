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
    <title>The Project King - Register</title>
    <!--Bootstrap CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <!--Custom CSS-->
    <link rel="stylesheet" href="assets/css/style.css" type="text/css" />
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
            <button type="button" onclick="location.href='logout.php'">Logout</button>
            <button type="button" onclick="location.href='index.php'">Home</button>
            <button type="button" onclick="location.href='createTask.php'">Create Task</button>
            <button type="button" onclick="location.href='actions/logout.php'">Logout</button>
            <button id="myBtn" onclick="myFunction()">Pause</button>
            <button id="music-toggle">Toggle Music</button>
        </div>
        <h1>Register A User</h1>
    </header>



    
    <?php
session_start();
require_once 'config/config.php';
// The database connection file, this is to avoid storing the connection details in plain view
// Redirect if not logged in or not an admin
if (!isset($_SESSION['userId']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}


$username = $email = $password = $role = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Basic validation for empty fields
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $role = trim($_POST['role']);
    
    // Check if password is empty, set default password if so
    if (empty($_POST['password'])) {
        // Default password
        $password = 'usw1'; 
    } else {
        // Use provided password
        $password = trim($_POST['password']); 
    }

    if (empty($username) || empty($email) || empty($role)) {
        $error = 'Please fill in all fields.';
    } else {
        // Hashing the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare the SQL statement to prevent SQL injection
        $stmt = $pdo->prepare("INSERT INTO Users (username, email, password, role, firstLogin) VALUES (?, ?, ?, ?, 1)");

        try {
            $stmt->execute([$username, $email, $hashedPassword, $role]);
            // Redirect on successful registration
            header("Location: ProfilePage.php"); 
            exit;
        } catch (PDOException $e) {
            $error = "Error while registering the user: " . $e->getMessage();
        }
    }
}
?>

<!-- This is the form to register new users, admin only -->
<section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-dark text-white" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">
                        <div class="mb-md-5 mt-md-4 pb-5">
                            <h2 class="fw-bold mb-2 text-uppercase">Register User</h2>
                            <p class="text-white-50 mb-5">Please enter the details to register a new user.</p>
                            <form action="register.php" method="post">
                                <div class="form-outline form-white mb-4">
                                    <input type="text" class="form-control" name="username" placeholder="Username" required>
                                </div>
                                <div class="form-outline form-white mb-4">
                                    <input type="email" class="form-control" name="email" placeholder="Email" required>
                                </div>
                                <div class="form-outline form-white mb-4">
                                    <input type="password" class="form-control" name="password" placeholder="usw1 or enter Password">
                                </div>
                                <div class="form-outline form-white mb-4">
                                    <select class="form-select" name="role" aria-label="Role select">
                                        <option selected>Select Role</option>
                                        <option value="user">User</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>
                                <button class="btn btn-outline-light btn-lg px-5" type="submit">Register</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</section>


</body>
  
  <!--Bootstrap JS-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
       integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
       crossorigin="anonymous"></script>

   <!--Custom JS-->
   <script src="assets/js/music.js"></script>
   <script src="assets/js/video.js"></script>
</html>
  

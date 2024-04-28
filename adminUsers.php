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
    <title>The Project King - User Admin</title>
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

    <!-- Background Video -->
    <video autoplay muted loop id="myVideo">
    <source src="assets/video/background3.mp4" type="video/mp4">
    </video>

    <!-- Background Music -->
    <audio id="background-music">
        <source src="assets/sounds/nexus-img-main-version-22138-02-54.mp3" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>

    <header class="viewport-header">
        <div class="button-bar">
            <button type="button" onclick="location.href='index.php'">Home</button>
            <button type="button" onclick="location.href='profilePage.php'">Profile</button>
            <button type="button" onclick="location.href='createTasks.php'">Create Task</button>
            <button type="button" onclick="location.href='adminTask.php'">Admin Tasks</button>
            <button type="button" onclick="location.href='actions/logout.php'">Logout</button>
            <button id="myBtn" onclick="myFunction()">Pause</button>
            <button id="music-toggle">Toggle Music</button>
        </div>
        <h1>Edit Your Task</h1>
    </header>

<?php
    include 'config.php';
    session_start();
    // The database connection file, this is to avoid storing the connection details in plain view

    if (!isset($_SESSION['userId']) || $_SESSION['role'] !== 'admin') {
        header('Location: login.php');
        exit;
    }

// Fetch users from the database
try {
    $stmt = $pdo->query("SELECT userId, username, role, email FROM users");
    $users = $stmt->fetchAll();
} catch (Exception $e) {
    // Log the error message for debugging purposes
    error_log($e->getMessage());
    // Display a more detailed error message
    exit('An error occurred while fetching users: ' . $e->getMessage());
}

  // Handle task deletion
  if (isset($_POST['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM users WHERE userId = ?");
    $stmt->execute([$_POST['userId']]);
    header("Refresh:0");
}
?>

<section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12">
                <div class="card bg-dark text-white" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">
                        <h2 class="fw-bold mb-2 text-uppercase">Current Users</h2>
                        <p class="text-white-50 mb-5">Manage all users below.</p>
                        <table class="table table-dark table-hover">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th>Email</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?= htmlspecialchars($user['userId']) ?></td>
                                    <td><?= htmlspecialchars($user['username']) ?></td>
                                    <td><?= htmlspecialchars($user['role']) ?></td>
                                    <td><?= htmlspecialchars($user['email']) ?></td>
                                    <td>
                                    <form method="post" action="">
                                        <input type="hidden" name="userId" value="<?= $user['userId'] ?>">
                                        <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                                    </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
      crossorigin="anonymous"></script>

    <!-- Custom JS -->
    <script src="assets/js/music.js"></script>
    <script src="assets/js/video.js"></script>

</body>
</html>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- GoogleFonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@500&display=swap" rel="stylesheet">
    <title>The Project King - Task Admin</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css" type="text/css" />
    <!-- Meta data -->
    <meta name="description" content="The Project King - A tool to help users manage their lives">
    <meta name="keywords" content="The Project King">
    <meta name="author" content="Joe Wells">
<body>



    <?php
    include 'config/config.php';
    session_start();
    // The database connection file, this is to avoid storing the connection details in plain view

    if (!isset($_SESSION['userId']) || $_SESSION['role'] !== 'admin') {
        header('Location: login.php');
        exit;
    }

    // Fetch all tasks
    $stmt = $pdo->query("SELECT Tasks.*, Users.username AS creator FROM Tasks JOIN Users ON Tasks.creatorId = Users.userId");
    $tasks = $stmt->fetchAll();

    // Handle task deletion
    if (isset($_POST['delete'])) {
        $stmt = $pdo->prepare("DELETE FROM Tasks WHERE taskId = ?");
        $stmt->execute([$_POST['taskId']]);
        header("Refresh:0");
    }
    ?>

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
            <button type="button" onclick="location.href='profilePage.php'">Profile</button>
            <button type="button" onclick="location.href='register.php'">Register Users</button>
            <button type="button" onclick="location.href='createTask.php'">Create Task</button>
            <button type="button" onclick="location.href='adminUsers.php'">Manage Users</button>
            <button type="button" onclick="location.href='actions/logout.php'">Logout</button>
            <button id="myBtn" onclick="myFunction()">Pause</button>
            <button id="music-toggle">Toggle Music</button>
        </div>
        <h1>Admin Task Management</h1>
    </header>

    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <h2 class="fw-bold mb-2 text-uppercase">Tasks Overview</h2>
                            <p class="text-white-50 mb-5">Manage all tasks below.</p>
                            <table class="table table-dark table-hover">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Creator</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($tasks as $task): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($task['title']) ?></td>
                                        <td class="description-cell"><?= htmlspecialchars($task['description']) ?></td>
                                        <td><?= htmlspecialchars($task['creator']) ?></td>
                                        <td>
                                            <a href="editTask.php?taskId=<?= $task['taskId'] ?>" class="btn btn-primary">Edit</a>
                                            <form method="post" action="" style="display: inline-block;">
                                                <input type="hidden" name="taskId" value="<?= $task['taskId'] ?>">
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

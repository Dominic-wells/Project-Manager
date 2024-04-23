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
    <title>The Project King - Your Profile </title>
    <!--Bootstrap CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <!--Custom CSS-->
    <link rel="stylesheet" href="assets/css/style.css" type="text/css" />
</head>
<body>


    <?php
    // The database connection file, this is to avoid storing the connection details in plain view
    include 'config.php';
    session_start();

    // This checks if the user is logged in, if not they are redirected to the login page
    if (!isset($_SESSION['userId'])) {
        header('Location: login.php');
        exit;
    }

    // This gets the user's tasks from the database
    $userId = $_SESSION['userId'];
    $stmt = $pdo->prepare("SELECT * FROM Tasks WHERE creatorId = ? AND deleted = FALSE");
    $stmt->execute([$userId]);
    $tasks = $stmt->fetchAll();
    ?>


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
            <button id="myBtn" onclick="myFunction()">Pause</button>
            <button id="music-toggle">Toggle Music</button>
        </div>
        <h1>Manage Your Tasks</h1>
    </header>


    <!-- Task cards section, this will display the tasks as cards for the user -->
    <div class="container">
        <div class="row" id="tasks">
            <?php foreach ($tasks as $task): ?>
            <div class="col-md-4">
                <div class="card mt-3">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($task['title']) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($task['description']) ?></p>
                        <a href="edit_task.php?taskId=<?= $task['taskId'] ?>" class="btn btn-primary">Edit</a>
                        <a href="delete_task.php?taskId=<?= $task['taskId'] ?>" class="btn btn-danger">Delete</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <div class="col-md-4">
                <div class="card mt-3">
                    <div class="card-body">
                        <h5 class="card-title">Add New Task</h5>
                        <a href="createtask.php" class="btn btn-success">Create Task</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Bootstrap JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
</body>
</html>
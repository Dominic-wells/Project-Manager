<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@500&display=swap" rel="stylesheet">
    <title>The Project King - Create Task</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css" type="text/css" />
    <!--Meta data-->
    <meta name="description" content="The Project King - A tool to help users manage their lives">
    <meta name="keywords" content="The Project King">
    <meta name="author" content="Joe Wells">
</head>
<body>
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
            <button type="button" onclick="location.href='actions/logout.php'">Logout</button>
            <button id="myBtn" onclick="myFunction()">Pause</button>
            <button id="music-toggle">Toggle Music</button>
        </div>
        <h1>Manage Your Tasks</h1>
    </header>

    <?php
    include 'config.php';
    // The database connection file, this is to avoid storing the connection details in plain view
    session_start();

    // Redirect non-admin users who should not set assignees
    if (!isset($_SESSION['userId']) || $_SESSION['role'] === 'guest') {
        header('Location: login.php');
        exit;
    }

    // Fetch users if admin for assignee dropdown, otherwise default to self
    $users = ($_SESSION['role'] === 'admin') ? 
             $pdo->query("SELECT userId, username FROM Users WHERE role IN ('user', 'admin')")->fetchAll() : 
             [];
    // Handle the POST request from the task creation form
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = trim($_POST['title']);
        $description = trim($_POST['description']);
        $completionDate = trim($_POST['completionDate']);
        $status = 'backlog'; 
        $creatorId = $_SESSION['userId']; // ID from the session
        $assigneeId = ($_SESSION['role'] === 'admin' && isset($_POST['assigneeId'])) ? 
                      $_POST['assigneeId'] : 
                      $_SESSION['userId']; 
        $priority = $_POST['priority'];
        // Insert the task into the database
        $stmt = $pdo->prepare("INSERT INTO Tasks (title, description, completionDate, status, creatorId, assigneeId, taskPriority) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$title, $description, $completionDate, $status, $creatorId, $assigneeId, $priority])) {
            header("Location: ProfilePage.php");
            exit;
        } else {
            echo '<div class="alert alert-danger">Error creating task. Please try again.</div>';
        }
    }
    ?>

    <!-- From for creating tasks -->
    <div class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <h2 class="fw-bold mb-2 text-uppercase">Create Task</h2>
                            <p class="text-white-50 mb-4">Please fill in the details to create a new task.</p>
                            <form method="POST" action="createTask.php">
                                <div class="form-outline form-white mb-4">
                                    <input type="text" class="form-control" name="title" id="title" placeholder="Title" required>
                                </div>
                                <div class="form-outline form-white mb-4">
                                    <textarea class="form-control" name="description" id="description" placeholder="Description" required></textarea>
                                </div>
                                <div class="form-outline form-white mb-4">
                                    <label for="completionDate" class="form-label">Completion Date</label>
                                    <input type="date" class="form-control" name="completionDate" id="completionDate" required>
                                </div>
                                <?php if ($_SESSION['role'] === 'admin'): ?>
                                    <div class="form-outline form-white mb-4">
                                        <label for="assigneeId" class="form-label">Assignee</label>
                                        <select class="form-control" name="assigneeId" id="assigneeId" required>
                                            <?php foreach ($users as $user): ?>
                                                <option value="<?= $user['userId'] ?>"><?= htmlspecialchars($user['username']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                <?php endif; ?>
                                <div class="form-outline form-white mb-4">
                                    <label for="priority" class="form-label">Priority</label>
                                    <select class="form-control" name="priority" id="priority" required>
                                        <option value="low">Low</option>
                                        <option value="medium">Medium</option>
                                        <option value="high">High</option>
                                    </select>
                                </div>
                                <button class="btn btn-outline-light btn-lg px-5" type="submit">Create Task</button>
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

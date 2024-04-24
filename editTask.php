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
    <title>The Project King - Edit Task</title>
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
        <!-- Placeholder for Background Video -->
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
            <button type="button" onclick="location.href='createTask.php'">Create Task</button>
            <button type="button" onclick="location.href='actions/logout.php'">Logout</button>
            <button id="myBtn" onclick="myFunction()">Pause</button>
            <button id="music-toggle">Toggle Music</button>
        </div>
        <h1>Edit Your Task</h1>
    </header>

    <?php
    include 'config.php';
    // The database connection file, this is to avoid storing the connection details in plain view
    session_start();
    // Redirects non-admin/users to the login page
    if (!isset($_SESSION['userId']) || $_SESSION['role'] === 'guest') {
        header('Location: login.php');
        exit;
    }

    $taskId = $_GET['taskId'] ?? null;
    if (!$taskId) {
        echo '<div class="alert alert-danger">Task ID is missing.</div>';
        exit;
    }

    // Fetch task details if we are not posting
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        $stmt = $pdo->prepare("SELECT * FROM Tasks WHERE taskId = ?");
        $stmt->execute([$taskId]);
        $task = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$task) {
            echo '<div class="alert alert-danger">Task not found or access denied.</div>';
            exit;
        }
    } else {
        $title = trim($_POST['title']);
        $description = trim($_POST['description']);
        $completionDate = trim($_POST['completionDate']);
        $status = trim($_POST['status']);
        $priority = trim($_POST['priority']);

        // Assignee only set by admins
        $assigneeId = ($_SESSION['role'] === 'admin') ? trim($_POST['assigneeId']) : $task['assigneeId'];
        // Update the task in the database
        $stmt = $pdo->prepare("UPDATE Tasks SET title = ?, description = ?, completionDate = ?, status = ?, assigneeId = ?, taskPriority = ? WHERE taskId = ? AND (creatorId = ? OR ? = 'admin')");
        if ($stmt->execute([$title, $description, $completionDate, $status, $assigneeId, $priority, $taskId, $_SESSION['userId'], $_SESSION['role']])) {
            echo '<div class="alert alert-success">Task updated successfully.</div>';
        } else {
            echo '<div class="alert alert-danger">Error updating task: ' . $e->getMessage() . '</div>';
        }
    }

    // Fetch users for the dropdown only if admin
    if ($_SESSION['role'] === 'admin') {
        $stmt = $pdo->query("SELECT userId, username FROM Users WHERE role IN ('user', 'admin')");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    ?>
    <!-- Html form to edit task-->
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-dark text-white" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">
                        <h2 class="fw-bold mb-2 text-uppercase">Edit Task</h2>
                        <form method="POST" action="">
                            <div class="form-outline form-white mb-4">
                                <input type="text" id="title" name="title" class="form-control" placeholder="Title" value="<?= htmlspecialchars($task['title'] ?? '') ?>" required>
                            </div>
                            <div class="form-outline form-white mb-4">
                                <textarea id="description" name="description" class="form-control" placeholder="Description" required><?= htmlspecialchars($task['description'] ?? '') ?></textarea>
                            </div>
                            <div class="form-outline form-white mb-4">
                                <input type="date" id="completionDate" name="completionDate" class="form-control" value="<?= htmlspecialchars($task['completionDate'] ?? '') ?>" required>
                            </div>
                            <div class="form-outline form-white mb-4">
                                <select id="status" name="status" class="form-control" required>
                                    <option value="backlog" <?= ($task['status'] ?? '') === 'backlog' ? 'selected' : '' ?>>Backlog</option>
                                    <option value="doing" <?= ($task['status'] ?? '') === 'doing' ? 'selected' : '' ?>>Doing</option>
                                    <option value="done" <?= ($task['status'] ?? '') === 'done' ? 'selected' : '' ?>>Done</option>
                                </select>
                            </div>
                            <?php if ($_SESSION['role'] === 'admin'): ?>
                                <div class="form-outline form-white mb-4">
                                    <select id="assigneeId" name="assigneeId" class="form-control" required>
                                        <?php foreach ($users as $user): ?>
                                            <option value="<?= $user['userId'] ?>" <?= ($user['userId'] === ($task['assigneeId'] ?? '')) ? 'selected' : '' ?>><?= htmlspecialchars($user['username']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            <?php endif; ?>
                            <div class="form-outline form-white mb-4">
                                <select id="priority" name="priority" class="form-control" required>
                                    <option value="low" <?= ($task['taskPriority'] ?? '') === 'low' ? 'selected' : '' ?>>Low</option>
                                    <option value="medium" <?= ($task['taskPriority'] ?? '') === 'medium' ? 'selected' : '' ?>>Medium</option>
                                    <option value="high" <?= ($task['taskPriority'] ?? '') === 'high' ? 'selected' : '' ?>>High</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-outline-light btn-lg px-5">Update Task</button>
                        </form>
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
</body>
</html>

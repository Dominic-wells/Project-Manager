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
            <button type="button" onclick="location.href='actions/logout.php'">Logout</button>
        </div>
        <h1>
            Plan With
            <span>The-Project-King</span>     
        </h1>
    </header>



<!-- Task Cards Section -->
<div class="container">
    <div class="row">
        <div class="col-md-4" id="backlogTasks">
            <h3>Backlog</h3>
            <!-- Backlog tasks will be set here -->
        </div>
        <div class="col-md-4" id="doingTasks">
            <h3>Doing</h3>
            <!-- Doing tasks will be set here -->
        </div>
        <div class="col-md-4" id="doneTasks">
            <h3>Done</h3>
            <!-- Done tasks will be set here -->
        </div>
    </div>
</div>


    <!-- Sortable.js  -->
    <script>
    new Sortable(document.getElementById('backlogTasks'), {
        ghostClass: 'ghost'
    });
    new Sortable(document.getElementById('doingTasks'), {
        ghostClass: 'ghost'
    });
    new Sortable(document.getElementById('doneTasks'), {
        ghostClass: 'ghost'
    });
</script>

  </body>
  <?php
include 'config.php';  
    // The database connection file, this is to avoid storing the connection details in plain view
    if ($pdo) {
        $tasks = ['backlog' => '', 'doing' => '', 'done' => ''];
        $stmt = $pdo->query("SELECT taskId, title, description, status, assigneeId, taskPriority, completionDate, creatorId FROM tasks WHERE deleted = FALSE ORDER BY FIELD(status, 'Backlog', 'Doing', 'Done')");
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Fetch username of the assigned user
            $stmtUser = $pdo->prepare("SELECT username FROM Users WHERE userId = ?");
            $stmtUser->execute([$row['assigneeId']]);
            $assignedUser = $stmtUser->fetchColumn();
        
            // Fetch username of the creator
            $stmtCreator = $pdo->prepare("SELECT username FROM Users WHERE userId = ?");
            $stmtCreator->execute([$row['creatorId']]);
            $creatorUsername = $stmtCreator->fetchColumn();
        
            // This will add task and user data to the card 
            $cardHtml = '<div class="card border-light text-white bg-dark mt-3">';
            $cardHtml .= '<div class="card-header">';
            $cardHtml .= 'Assigned User: ' . htmlspecialchars($assignedUser);
            $cardHtml .= '<br>Priority: ' . htmlspecialchars($row['taskPriority']);
            $cardHtml .= ' | Status: ' . htmlspecialchars($row['status']);
            $cardHtml .= '</div>';
            $cardHtml .= '<div class="card-body">';
            $cardHtml .= '<h5 class="card-title">' . htmlspecialchars($row['title']) . '</h5>';
            $cardHtml .= '<p class="card-text">' . htmlspecialchars($row['description']) . '</p>';
            $cardHtml .= '</div>';
            $cardHtml .= '<div class="card-footer text-white">';
            $cardHtml .= 'Completion Date: ' . htmlspecialchars($row['completionDate']);
            $cardHtml .= ' | Created By: ' . htmlspecialchars($creatorUsername);
            $cardHtml .= '</div>';
            $cardHtml .= '</div>';
        
            // Append to the correct status array element
            $tasks[strtolower($row['status'])] .= $cardHtml;
        }
    
        // This will output the tasks into the correct divs
        echo "<script>
                document.getElementById('backlogTasks').innerHTML = `" . $tasks['backlog'] . "`;
                document.getElementById('doingTasks').innerHTML = `" . $tasks['doing'] . "`;
                document.getElementById('doneTasks').innerHTML = `" . $tasks['done'] . "`;
              </script>";
    } else {
        // Failed to connect to the database error alert message
        echo "<p>Failed to connect to the database.</p>";  
    }
?>
  
   <!--Bootstrap JS-->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>

    <!--Custom JS-->
    <script src="assets/js/music.js"></script>
    <script src="assets/js/video.js"></script>
</html>


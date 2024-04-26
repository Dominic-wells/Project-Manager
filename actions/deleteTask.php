<?php
session_start();
//This gets the database connection file
require '../config.php'; 
//This checks if the user is authenticated
if (!isset($_SESSION['userId'])) {
    echo json_encode(['message' => 'Not authenticated']);
    exit;
}
//This checks if the request method is POST and if the taskId is set
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['taskId'])) {
    $taskId = $_POST['taskId'];
    $userId = $_SESSION['userId'];
//This updates the task status and sets the status to 'deleted'
    $stmt = $pdo->prepare("UPDATE Tasks SET deleted = TRUE WHERE taskId = ? AND creatorId = ?");
    if ($stmt->execute([$taskId, $userId])) {
        echo json_encode(['message' => 'Task deleted successfully']);
    } else {
        echo json_encode(['message' => 'Failed to delete task']);
    }
} else {
    echo json_encode(['message' => 'Invalid request']);
}
?>



<?php
session_start();
// This gets the database connection file
require '../config/config.php';
// This checks if the user is authenticated
if (!isset($_SESSION['userId'])) {
    echo json_encode(['message' => 'Not authenticated']);
    exit;
}
// This checks if the request method is POST and if the taskId and status are set
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['taskId'], $_POST['status'])) {
    $taskId = $_POST['taskId'];
    $status = $_POST['status'];
    $userId = $_SESSION['userId'];
// This checks if the status is valid
    $validStatuses = ['Backlog', 'Doing', 'Done'];
    if (!in_array($status, $validStatuses)) {
        echo json_encode(['message' => 'Invalid status']);
        exit;
    }
// This updates the task status
    $stmt = $pdo->prepare("UPDATE Tasks SET status = ? WHERE taskId = ? AND creatorId = ?");
    if ($stmt->execute([$status, $taskId, $userId])) {
        echo json_encode(['message' => 'Task status updated successfully']);
    } else {
        echo json_encode(['message' => 'Failed to update task']);
    }
} else {
    echo json_encode(['message' => 'Invalid request']);
}
?>

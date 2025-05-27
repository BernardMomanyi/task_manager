<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['task_id'])) {
    $task_id = $_POST['task_id'];
    $user_id = $_SESSION['user_id'];

    // Update the task status to 'completed'
    $stmt = $conn->prepare("UPDATE tasks SET status='completed' WHERE task_id=? AND user_id=?");
    $stmt->bind_param("ii", $task_id, $user_id);
    $stmt->execute();

    // Redirect to the projects page or display a success message
    header("Location: projects.php");
    exit();
}
?>

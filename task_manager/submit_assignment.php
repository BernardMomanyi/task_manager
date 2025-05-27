<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $task_id = $_POST['task_id'];

    // Update the task status to 'submitted'
    $stmt = $conn->prepare("UPDATE tasks SET status='submitted' WHERE task_id=? AND user_id=?");
    $stmt->bind_param("ii", $task_id, $_SESSION['user_id']);
    $stmt->execute();

    // Redirect or display a success message
    echo "Assignment submitted successfully!";
}
?>

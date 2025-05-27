<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized");
}

$user_id = $_SESSION['user_id'];
$project_name = $_POST['project_name'];
$type = $_POST['type'];
$due_date = $_POST['due_date'];

$sql = "INSERT INTO projects (user_id, project_name, type, due_date) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isss", $user_id, $project_name, $type, $due_date);
$stmt->execute();

header("Location: projects.php");
?>

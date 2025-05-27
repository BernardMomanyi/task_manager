<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized");
}

$user_id = $_SESSION['user_id'];
$subject = $_POST['subject'];
$exam_date = $_POST['exam_date'];

$sql = "INSERT INTO exams (user_id, subject, exam_date) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iss", $user_id, $subject, $exam_date);
$stmt->execute();

header("Location: exams.php");
?>

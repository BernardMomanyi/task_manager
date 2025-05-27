<?php
session_start();
include 'functions.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access. Please log in.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $deadline = $_POST['deadline'];

    // Basic validation
    if (empty($title) || empty($description) || empty($deadline)) {
        echo "All fields are required!";
        exit();
    }

    if (addTask($user_id, $title, $description, $deadline)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error adding task.";
    }
}
?>

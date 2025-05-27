<?php
session_start();
include 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['add_task'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $deadline = $_POST['deadline'];

    $sql = "INSERT INTO tasks (user_id, title, description, deadline, status) VALUES (?, ?, ?, ?, 'Pending')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $user_id, $title, $description, $deadline);
    $stmt->execute();
}

// Fetch only tasks belonging to the logged-in user
$tasks = $conn->query("SELECT * FROM tasks WHERE user_id='$user_id' ORDER BY deadline ASC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tasks</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Manage Your Tasks</h2>

        <form method="POST" class="mb-3">
            <input type="text" name="title" placeholder="Task Title" required class="form-control mb-2">
            <textarea name="description" placeholder="Description" required class="form-control mb-2"></textarea>
            <input type="date" name="deadline" required class="form-control mb-2">
            <button type="submit" name="add_task" class="btn btn-primary">Add Task</button>
        </form>

        <h3>Your Tasks</h3>
        <ul class="list-group">
            <?php while ($task = $tasks->fetch_assoc()): ?>
                <li class="list-group-item">
                    <strong><?php echo htmlspecialchars($task['title']); ?></strong> - 
                    <?php echo htmlspecialchars($task['deadline']); ?> - 
                    <span class="badge bg-<?php echo ($task['status'] === 'Completed') ? 'success' : 'warning'; ?>">
                        <?php echo htmlspecialchars($task['status']); ?>
                    </span>
                </li>
            <?php endwhile; ?>
        </ul>
        <a href="logout.php" class="btn btn-danger mt-3">Logout</a>
    </div>
</body>
</html>

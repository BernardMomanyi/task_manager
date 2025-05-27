<?php
session_start();
include 'config.php';

// Only admins can access this page
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch all users
$users = $conn->query("SELECT * FROM users");

// Fetch all tasks
$tasks = $conn->query("SELECT tasks.*, users.username FROM tasks JOIN users ON tasks.user_id = users.id ORDER BY tasks.deadline ASC");

// Grant/Revoke Admin Privileges
if (isset($_POST['update_role'])) {
    $user_id = $_POST['user_id'];
    $new_role = $_POST['new_role'];
    $conn->query("UPDATE users SET role = '$new_role' WHERE id = $user_id");
    header("Location: admin_dashboard.php");
    exit();
}

// Close Submission Deadline
if (isset($_POST['close_submission'])) {
    $task_id = $_POST['task_id'];
    $conn->query("UPDATE tasks SET status = 'Closed' WHERE id = $task_id");
    header("Location: admin_dashboard.php");
    exit();
}

// Approve Assignments
if (isset($_POST['approve_task'])) {
    $task_id = $_POST['task_id'];
    $conn->query("UPDATE tasks SET status = 'Approved' WHERE id = $task_id");
    header("Location: admin_dashboard.php");
    exit();
}

// Reset User Password
if (isset($_POST['reset_password'])) {
    $user_id = $_POST['user_id'];
    $new_password = password_hash("default123", PASSWORD_DEFAULT);
    $conn->query("UPDATE users SET password = '$new_password' WHERE id = $user_id");
    header("Location: admin_dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Admin Dashboard</h2>


        <!-- Users List -->
        <h3 class="mt-4">Users</h3>
        <ul>
            <?php while ($user = $users->fetch_assoc()): ?>
                <li>
                    <?php echo htmlspecialchars($user['username']); ?> - Role: <?php echo htmlspecialchars($user['role']); ?>
                    
                    <!-- Grant/Revoke Admin -->
                    <form method="POST" class="d-inline">
                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                        <select name="new_role" class="form-select d-inline w-auto">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                        <button type="submit" name="update_role" class="btn btn-sm btn-primary">Update Role</button>
                    </form>

                    <!-- Reset Password -->
                    <form method="POST" class="d-inline">
                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                        <button type="submit" name="reset_password" class="btn btn-sm btn-warning">Reset Password</button>
                    </form>
                </li>
            <?php endwhile; ?>
        </ul>

        <!-- Tasks List -->
        <h3 class="mt-4">All Tasks</h3>
        <ul>
            <?php while ($task = $tasks->fetch_assoc()): ?>
                <li>
                    <?php echo htmlspecialchars($task['title']); ?> - Assigned to: <?php echo htmlspecialchars($task['username']); ?> - Deadline: <?php echo htmlspecialchars($task['deadline']); ?>
                    <span class="badge bg-<?php echo $task['status'] == 'Approved' ? 'success' : ($task['status'] == 'Closed' ? 'danger' : 'secondary'); ?>">
                        <?php echo htmlspecialchars($task['status']); ?>
                    </span>

                    <!-- Close Submission -->
                    <?php if ($task['status'] !== 'Closed'): ?>
                    <form method="POST" class="d-inline">
                        <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                        <button type="submit" name="close_submission" class="btn btn-sm btn-danger">Close Submission</button>
                    </form>
                    <?php endif; ?>

                    <!-- Approve Assignment -->
                    <?php if ($task['status'] !== 'Approved'): ?>
                    <form method="POST" class="d-inline">
                        <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                        <button type="submit" name="approve_task" class="btn btn-sm btn-success">Approve</button>
                    </form>
                    <?php endif; ?>
                </li>
            <?php endwhile; ?>
        </ul>

        <!-- Logout Button -->
        <a href="logout.php" class="btn btn-danger mt-3">Logout</a>
    </div>

    <!-- Notification Area -->
    <div class="notification-box">
        <p><strong>Upcoming Events:</strong></p>
        <p>Project deadline: March 25, 2025</p>
    </div>
</body>
</html>

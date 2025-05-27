<?php
session_start();
include 'config.php';

// Redirect to login page if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="styles.css"> <!-- Include external stylesheet -->
</head>
<body>

<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar p-3">
        <h3 class="text-primary">Task Manager</h3>
        <ul class="nav flex-column">
            <li class="nav-item"><a href="user_dashboard.php" class="nav-link active">All Tasks</a></li>
            <li class="nav-item"><a href="assignments.php" class="nav-link">Assignments</a></li>
            <li class="nav-item"><a href="projects.php" class="nav-link">Projects</a></li>
            <li class="nav-item"><a href="exams.php" class="nav-link">Exams</a></li>
            <li class="nav-item"><a href="logout.php" class="nav-link text-danger">Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="container mt-4">
        <h2 class="mb-4">Welcome, User!</h2>
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addTaskModal">Add Task</button>

        <!-- Task Cards -->
        <div class="row">
            <!-- Example Task Card -->
            <div class="col-md-4">
                <div class="card task-card">
                    <div class="card-body">
                        <h5 class="card-title">UI Assignment</h5>
                        <p class="card-text">Task Management System</p>
                        <span class="badge bg-danger">High</span>
                        <span class="badge bg-secondary">Pending</span>
                    </div>
                </div>
            </div>

            <!-- More Tasks Here -->
        </div>
    </div>
</div>

<!-- Modal for Adding Tasks -->
<div class="modal fade" id="addTaskModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" id="title" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select id="category" class="form-select">
                            <option>Assignments</option>
                            <option>Projects</option>
                            <option>Exams</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="due_date" class="form-label">Due Date</label>
                        <input type="date" id="due_date" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Save Task</button>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>

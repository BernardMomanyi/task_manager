<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$projects = $conn->query("SELECT * FROM tasks WHERE user_id='$user_id' AND category='Project' ORDER BY deadline ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Projects</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
	


    <style>
        .card {
            margin-bottom: 20px;
        }
        .btn {
            margin-top: 10px;
        }
        .deadline-text {
            font-weight: bold;
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Your Projects</h2>
        <a href="index.php" class="btn btn-secondary">Back</a>
        <div class="row mt-3">
            <?php while ($project = $projects->fetch_assoc()): ?>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($project['title']) ?></h5>
                            <p class="card-text deadline-text">Deadline: <?= date('F j, Y, g:i a', strtotime($project['deadline'])) ?></p>
                            <p class="card-text">Status: <?= htmlspecialchars($project['status']) ?></p>
                            <p class="card-text">Category: <?= htmlspecialchars($project['category']) ?></p>
                            
                            <!-- Display Team or Personal Project -->
                            <p class="card-text"><strong>Type:</strong> 
                                <?= htmlspecialchars($project['type']) == 'team' ? 'Team Project' : 'Personal Project' ?>
                            </p>

                            <!-- Submission Section -->
                            <?php if ($project['status'] != 'completed'): ?>
                                <form action="submit_project.php" method="POST">
                                    <input type="hidden" name="task_id" value="<?= $project['task_id'] ?>">
                                    <button type="submit" class="btn btn-primary">Submit Project</button>
                                </form>
                            <?php else: ?>
                                <p class="text-success">Project Submitted</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>

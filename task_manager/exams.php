<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$exams = $conn->query("SELECT * FROM tasks WHERE user_id='$user_id' AND category='Exam' ORDER BY deadline ASC");

// Check if the query executed successfully for exams
if (!$exams) {
    die("Error fetching exams: " . $conn->error);
}

$units = $conn->query("SELECT * FROM units WHERE user_id='$user_id'"); // Query for units the user is enrolled in

// Check if the query executed successfully for units
if (!$units) {
    die("Error fetching units: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exams</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Your Exams</h2>
        <a href="index.php" class="btn btn-secondary">Back</a>
        
        <!-- Unit List Section -->
        <div class="mt-4">
            <h4>Current Units</h4>
            <ul class="list-group">
                <?php while ($unit = $units->fetch_assoc()): ?>
                    <li class="list-group-item"><?= htmlspecialchars($unit['unit_name']) ?></li>
                <?php endwhile; ?>
            </ul>
        </div>

        <!-- Exam Timetable Section -->
        <div class="mt-4">
            <h4>Exam Timetable</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Deadline</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($exam = $exams->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($exam['title']) ?></td>
                            <td><?= htmlspecialchars($exam['deadline']) ?></td>
                            <td><?= htmlspecialchars($exam['status']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Print Exam Cards Section -->
        <div class="mt-4">
            <h4>Print Exam Cards</h4>
            <button onclick="window.print()" class="btn btn-primary">Print Exam Cards</button>
        </div>
    </div>
</body>
</html>


<?php
session_start();
include 'config.php';

$user_id = $_SESSION['user_id'];

// Fetch pending assignments (status = 'pending')
$tasks = $conn->query("SELECT * FROM tasks WHERE user_id='$user_id' AND status='pending' ORDER BY deadline ASC");

// Fetch revision questions
$revision_questions = $conn->query("SELECT * FROM revision_questions WHERE user_id='$user_id' ORDER BY due_date ASC");
?>

<h2>Pending Assignments</h2>
<?php while ($task = $tasks->fetch_assoc()): ?>
    <p>
        <?php echo $task['title']; ?> - 
        <?php echo $task['deadline']; ?>
        <!-- Submit button for the assignment -->
        <form action="submit_assignment.php" method="POST">
            <input type="hidden" name="task_id" value="<?php echo $task['task_id']; ?>">
            <button type="submit">Submit Assignment</button>
        </form>
    </p>
<?php endwhile; ?>

<h2>Revision Questions</h2>
<?php while ($question = $revision_questions->fetch_assoc()): ?>
    <p>
        <?php echo $question['question']; ?> - 
        <?php echo $question['due_date']; ?>
    </p>
<?php endwhile; ?>

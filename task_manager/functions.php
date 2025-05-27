### functions.php
```php
<?php
include 'config.php';

function addTask($user_id, $title, $description, $deadline) {
    global $conn;
    $sql = "INSERT INTO tasks (user_id, title, description, deadline, status) VALUES (?, ?, ?, ?, 'Pending')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $user_id, $title, $description, $deadline);
    return $stmt->execute();
}

function getTasks($user_id) {
    global $conn;
    $sql = "SELECT * FROM tasks WHERE user_id = ? ORDER BY deadline ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    return $stmt->get_result();
}

function completeTask($task_id) {
    global $conn;
    $sql = "UPDATE tasks SET status = 'Completed' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $task_id);
    return $stmt->execute();
}
?>
```
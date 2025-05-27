### complete_task.php
```php
<?php
include 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_id = $_POST['task_id'];
    if (completeTask($task_id)) {
        header("Location: index.php");
    } else {
        echo "Error updating task.";
    }
}
?>
```
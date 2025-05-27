<?php
session_start();
include 'config.php';

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert user into database
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $hashed_password);

        if ($stmt->execute()) {
            header("Location: login.php"); // Redirect to login after successful registration
            exit();
        } else {
            $error = "Username already exists!";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Register</h2>
        <?php if (isset($error)): ?>
            <p class="text-danger"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required class="form-control mb-2">
            <input type="password" name="password" placeholder="Password" required class="form-control mb-2">
            <input type="password" name="confirm_password" placeholder="Confirm Password" required class="form-control mb-2">
            <button type="submit" name="register" class="btn btn-primary">Register</button>
        </form>
    </div>
</body>
</html>


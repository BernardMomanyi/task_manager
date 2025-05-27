<?php
include 'config.php';

// Define admin details
$admin_username = 'admin';
$admin_password = 'admin123'; // Change to your preferred password
$hashed_password = password_hash($admin_password, PASSWORD_DEFAULT);
$role = 'admin';

// Insert admin into the users table
$sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $admin_username, $hashed_password, $role);

if ($stmt->execute()) {
    echo "Admin user added successfully!";
} else {
    echo "Error: " . $stmt->error;
}

// Close the connection
$stmt->close();
$conn->close();
?>

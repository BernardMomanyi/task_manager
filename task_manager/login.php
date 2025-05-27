<?php
session_start();
include 'config.php';

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Prevent SQL Injection
    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $user['role'];

            if ($user['role'] === 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: user_dashboard.php");
            }
            exit();
        } else {
            $_SESSION['error'] = "Invalid password!";
        }
    } else {
        $_SESSION['error'] = "User not found!";
    }
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    
    <!-- Bootstrap & CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">

    
    <!-- jQuery & Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container d-flex flex-column justify-content-center align-items-center vh-100">
        
        <div class="login-box animate__animated animate__fadeInUp">
            <h3 class="text-center mb-3">Login</h3>
            
            <!-- Display Error Message -->
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger text-center small">
                    <?php 
                        echo $_SESSION['error']; 
                        unset($_SESSION['error']); 
                    ?>
                </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form method="POST">
                <input type="text" name="username" placeholder="Username" required class="form-control form-control-sm mb-2" 
                    value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                <input type="password" name="password" placeholder="Password" required class="form-control form-control-sm mb-2">
                <button type="submit" name="login" class="btn btn-primary btn-sm w-100">Login</button>
            </form>

            <p class="mt-2 text-center small">Don't have an account? <a href="register.php">Register here</a></p>
        </div>

        <!-- Info Sections (Smaller) -->
        <div class="info-section animate__animated animate__fadeIn delay-1s">
            <div class="info-box about-us">
                <h6>About Us</h6>
                <p class="small">Helping students manage tasks efficiently.</p>
            </div>
            <div class="info-box contact-us">
                <h6>Contact</h6>
                <p class="small">Email: support@taskmanager.com</p>
            </div>
        </div>

        <!-- Daily Quote -->
        <div class="quote-box animate__animated animate__bounceIn delay-2s">
            <div class="robot-thought">
                <p class="small">“Productivity is never an accident.”</p>
            </div>
        </div>
    </div>

</body>
</html>

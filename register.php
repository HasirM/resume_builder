<?php
include 'db.php';

$error = ""; // Variable to store error messages

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Validate input fields
    if (empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "All fields are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        // Check if email already exists
        $check_email_sql = "SELECT * FROM users WHERE email='$email'";
        $check_email_result = $conn->query($check_email_sql);

        if ($check_email_result->num_rows > 0) {
            $error = "Email already registered!";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Insert user into the database
            $sql = "INSERT INTO users (first_name, last_name, email, password) 
                    VALUES ('$first_name', '$last_name', '$email', '$hashed_password')";

            if ($conn->query($sql) === TRUE) {
                header("Location: login.php");
                exit();
            } else {
                $error = "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="css/style1.css">
    <title>Register</title>
</head>
<body class="login-register-body">
    <div class="login-register-container">
        <h2>Register</h2>
        <?php if (!empty($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" action="register.php">
            <input type="text" name="first_name" placeholder="First Name" value="<?php echo isset($_POST['first_name']) ? htmlspecialchars($_POST['first_name']) : ''; ?>" required>
            <input type="text" name="last_name" placeholder="Last Name" value="<?php echo isset($_POST['last_name']) ? htmlspecialchars($_POST['last_name']) : ''; ?>" required>
            <input type="email" name="email" placeholder="Email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>
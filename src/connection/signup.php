<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Retrieve and sanitize input values
    $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);
    $username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING));
    $password = trim($_POST['password']);  // Do not sanitize password because it will be hashed

    // Check if inputs are empty
    if (empty($role) || empty($username) || empty($password)) {
        echo "<script>alert('Please fill in all fields.');</script>";
        exit;
    }

    // Adjust query based on role
    if ($role == 'admin') {
        // For admin, use email instead of username
        $check_sql = "SELECT * FROM admin WHERE username = ?";
        $insert_sql = "INSERT INTO admin (username, password) VALUES (?, ?)";
    } else {
        // For other roles, use username
        $check_sql = "SELECT * FROM $role WHERE username = ?";
        $insert_sql = "INSERT INTO $role (username, password) VALUES (?, ?)";
    }

    // Prepare the statements
    $check_stmt = mysqli_prepare($conn, $check_sql);
    $insert_stmt = mysqli_prepare($conn, $insert_sql);

    // Bind the parameters for checking user existence
    mysqli_stmt_bind_param($check_stmt, "s", $username);
    mysqli_stmt_execute($check_stmt);
    $check_result = mysqli_stmt_get_result($check_stmt);

    if (!$check_result) {
        // Output the specific SQL error
        die("Error executing query: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($check_result) > 0) {
        // User already exists, notify the user
        echo "<script>alert('User already exists. Please choose another.');</script>";
    } else {
        // Hash the password before storing
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Bind parameters and insert the new user data with hashed password
        mysqli_stmt_bind_param($insert_stmt, "ss", $username, $hashed_password);
        mysqli_stmt_execute($insert_stmt);

        if (mysqli_stmt_affected_rows($insert_stmt) > 0) {
            echo "<script>alert('New User created successfully!');</script>";
            echo "<script>window.location.href = '../index.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>
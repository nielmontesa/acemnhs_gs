<?php
session_start();
include 'connection.php';

// Handle login form submission
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = mysqli_real_escape_string($conn, trim($_POST['password']));
    $role = $_POST['role'];

    if (empty($username) || empty($password)) {
        echo '<script>alert("Please fill out all fields.");</script>';
    } else {
        // Prepare SQL query based on role
        if ($role == 'admin') {
            $checkQuery = "SELECT * FROM admin WHERE username=?";
        } elseif ($role == 'teacher') {
            $checkQuery = "SELECT * FROM teachers WHERE username=?";
        }

        // Use prepared statements to prevent SQL injection
        $stmt = mysqli_prepare($conn, $checkQuery);
        if (!$stmt) {
            die('Prepare failed: ' . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (!$result) {
            die('Query Error: ' . mysqli_error($conn));
        }

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            // Check if the password is hashed in the database
            if (password_verify($password, $row['password'])) {
                $_SESSION['role'] = $role;
                $_SESSION['username'] = $row['username'];
                $_SESSION['logged_in'] = true;

                // Alert and redirect based on role
                echo '<script>alert("Logged in successfully as ' . ucfirst($role) . '!");</script>';
                if ($role == 'admin') {
                    echo '<script>window.location.href = "../pages/admin/departments.php";</script>';
                } elseif ($role == 'teacher') {
                    echo '<script>window.location.href = "../pages/teacher/sections.php";</script>';
                }
                exit();
            } else {
                echo '<script>alert("Login failed. Incorrect username or password for ' . ucfirst($role) . '.");</script>';
                echo '<script>window.location.href = "../index.php";</script>';
            }
        } else {
            echo '<script>alert("No such user found.");</script>';
            echo '<script>window.location.href = "../index.php";</script>';
        }
    }
}
?>
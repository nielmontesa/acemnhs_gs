<?php
session_start();
include '../connection/connection.php';

// Check if user is already logged in
if (isset($_SESSION['status']) && $_SESSION['status'] == 'valid') {
    if ($_SESSION['role'] == 'admin') {
        echo '<script>window.location.href = "../pages/admin/departments.php";</script>';
        exit();
    } elseif ($_SESSION['role'] == 'teacher') {
        echo '<script>window.location.href = "../pages/teacher/sections.php";</script>';
        exit();
    } elseif ($_SESSION['role'] == 'parent') {
        echo '<script>window.location.href = "../pages/parent/student_details.php";</script>';
        exit();
    }
}

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
        } elseif ($role == 'parent') {
            $checkQuery = "SELECT * FROM parents WHERE username=?";
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
                $_SESSION['status'] = 'valid';
                $_SESSION['role'] = $role;
                $_SESSION['username'] = $row['username'];

                // Alert and redirect based on role
                echo '<script>alert("Logged in successfully as ' . ucfirst($role) . '!");</script>';
                if ($role == 'admin') {
                    echo '<script>window.location.href = "../pages/admin/departments.php";</script>';
                } elseif ($role == 'teacher') {
                    echo '<script>window.location.href = "../pages/teacher/sections.php";</script>';
                } elseif ($role == 'parent') {
                    echo '<script>window.location.href = "../pages/parent/student_details.php";</script>';
                }
                exit();
            } else {
                echo '<script>alert("Login failed. Incorrect username or password for ' . ucfirst($role) . '.");</script>';
            }
        } else {
            echo '<script>alert("No such user found.");</script>';
        }
    }
}
?>

<?php
include 'connection.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $first_name = $_POST['teacherfname'];
    $last_name = $_POST['teacherlname'];
    $email = $_POST['teachermail'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $department_id = $_POST['department_id']; // Get department ID from the form

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // SQL query to insert teacher data, including department_id
    $sql = "INSERT INTO teachers (first_name, last_name, email, username, password, department_id)
            VALUES (?, ?, ?, ?, ?, ?)";

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $first_name, $last_name, $email, $username, $hashed_password, $department_id);

    // Execute the statement
    if ($stmt->execute()) {
        echo "New teacher added successfully!";
        header("Location: ../pages/admin/teachers.php");
        exit(); // Ensure no further code is executed after redirect
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
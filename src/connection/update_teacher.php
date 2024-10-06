<?php
include 'connection.php'; // Include your DB connection

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $teacher_id = $_POST['teacher_id'];
    $first_name = $_POST['teacherfname'];
    $last_name = $_POST['teacherlname'];
    $email = $_POST['teachermail'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare the SQL query
    if (!empty($password)) {
        // If a new password is provided, update the password as well
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE teachers SET first_name = ?, last_name = ?, email = ?, username = ?, password = ? WHERE teacher_id = ?";
        $stmt = $conn->prepare($sql);
    } else {
        // If no new password, only update the other fields
        $sql = "UPDATE teachers SET first_name = ?, last_name = ?, email = ?, username = ? WHERE teacher_id = ?";
        $stmt = $conn->prepare($sql);
    }

    // Check if the statement was prepared successfully
    if ($stmt === false) {
        die('Error in prepare statement: ' . $conn->error);
    }

    // Bind parameters based on whether the password was provided
    if (!empty($password)) {
        $stmt->bind_param("sssssi", $first_name, $last_name, $email, $username, $hashed_password, $teacher_id);
    } else {
        $stmt->bind_param("ssssi", $first_name, $last_name, $email, $username, $teacher_id);
    }

    // Check if parameter binding was successful
    if ($stmt->errno !== 0) {
        die('Error binding parameters: ' . $stmt->error);
    }

    // Execute the statement
    if ($stmt->execute()) {
        echo "Teacher updated successfully!";
        header("Location: ../pages/admin/all_teachers.php"); // Redirect to all teachers page
        exit;
    } else {
        echo "Error updating teacher: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
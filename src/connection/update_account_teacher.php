<?php
session_start();

// Include your database connection file
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $oldpassword = $_POST['oldpassword'];
    $newpassword = $_POST['newpassword'];

    // Check if any of the fields are empty
    if (empty($username) || empty($oldpassword) || empty($newpassword)) {
        echo "All fields are required!";
        exit();
    }

    // Get the current admin details using session username
    $current_username = $_SESSION['username'];
    
    // Query to get the current user based on session username
    $query = "SELECT * FROM teachers WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $current_username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $teachers = $result->fetch_assoc();
        $hashed_password = $teachers['password'];

        // Verify if the old password matches the hashed password in the database
        if (password_verify($oldpassword, $hashed_password)) {
            // Hash the new password before updating
            $new_hashed_password = password_hash($newpassword, PASSWORD_BCRYPT);

            // Update the admin details
            $update_query = "UPDATE teachers SET username = ?, password = ? WHERE teacher_id = ?";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bind_param('ssi', $username, $new_hashed_password, $teachers['teacher_id']);

            if ($update_stmt->execute()) {
                $_SESSION['username'] = $username; // Update session username if changed
                echo '<script>alert("Update Successful.");</script>';
                echo '<script>window.location.href = "../pages/teacher/settings.php";</script>';
            } else {
                echo "Failed to update account details.";
            }
        } else {
            echo "Old password is incorrect!";
        }
    } else {
        echo "Admin not found.";
    }
} else {
    echo "Invalid request method!";
}
?>

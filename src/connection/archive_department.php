<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    include '../connection/connection.php';

    // Retrieve section/department id from the form
    $department_id = $conn->real_escape_string($_POST['department_id']);

    // Update the department to be archived
    $sql = "UPDATE department SET is_archived = 1 WHERE department_id = '$department_id'";

    if ($conn->query($sql) === TRUE) {
        // Archive all students in the department
        $update_students_sql = "UPDATE students SET is_archived = 1 WHERE department_id = '$department_id'";

        if ($conn->query($update_students_sql) === TRUE) {
            echo "Department and associated students archived successfully!";
        } else {
            echo "Error archiving students: " . $conn->error;
        }

        // Redirect after successful archiving
        header("Location: ../pages/admin/departments.php");
        exit(); // Make sure to exit after header redirect
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close connection
    $conn->close();
}

?>
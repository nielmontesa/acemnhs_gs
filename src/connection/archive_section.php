<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    include '../connection/connection.php';

    // Retrieve section/department id from the form
    $section_id = $conn->real_escape_string($_POST['section_id']);

    // Update the section/department to be archived
    $sql = "UPDATE section SET is_archived = 1 WHERE section_id = '$section_id'";

    if ($conn->query($sql) === TRUE) {
        // Archive all students in the section
        $update_students_sql = "UPDATE students SET is_archived = 1 WHERE section_id = '$section_id'";

        if ($conn->query($update_students_sql) === TRUE) {
            echo "Section and associated students archived successfully!";
        } else {
            echo "Error archiving students: " . $conn->error;
        }

        // Redirect after successful archiving
        header("Location: ../pages/admin/sections.php");
        exit(); // Make sure to exit after header redirect
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close connection
    $conn->close();
}
?>
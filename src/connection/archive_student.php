<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    include '../connection/connection.php';

    // Retrieve student_id and section_id from the form
    $student_id = $conn->real_escape_string($_POST['student_id']);
    $section_id = $conn->real_escape_string($_POST['section_id']); // Get the current section ID

    // Update the student to be archived
    $sql = "UPDATE students SET is_archived = 1 WHERE student_id = '$student_id'";

    if ($conn->query($sql) === TRUE) {
        // Redirect back to the same page with the section ID after archiving
        header("Location: ../pages/admin/students.php?section_id=$section_id");
        exit(); // Make sure to exit after header redirect
    } else {
        echo "Error archiving student: " . $conn->error;
    }

    // Close connection
    $conn->close();
}
?>
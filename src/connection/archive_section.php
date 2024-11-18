<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    include 'connection.php';

    // Retrieve section id from the form
    $section_id = $conn->real_escape_string($_POST['section_id']);

    // Update the section to be archived
    $sql = "UPDATE section SET is_archived = 1 WHERE section_id = '$section_id'";

    if ($conn->query($sql) === TRUE) {
        // Archive all students in the section
        $update_students_sql = "UPDATE students SET is_archived = 1 WHERE section_id = '$section_id'";

        if ($conn->query($update_students_sql) === TRUE) {
            // Redirect back to the same page with section_id in the URL
            header("Location: " . $_SERVER['HTTP_REFERER'] . "?section_id=" . $section_id);
            exit(); // Make sure to exit after the header redirect
        } else {
            echo "Error archiving students: " . $conn->error;
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close connection
    $conn->close();
}
?>
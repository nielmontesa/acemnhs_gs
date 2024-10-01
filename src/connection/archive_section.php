<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    include '../connection/connection.php';

    // Retrieve section/department id from the form
    $section_id = $conn->real_escape_string($_POST['section_id']);

    // Update the section/department to be archived
    $sql = "UPDATE section SET is_archived = 1 WHERE section_id = '$section_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Section archived successfully!";
        header("Location: ../pages/admin/sections.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close connection
    $conn->close();
}
?>
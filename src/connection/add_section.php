<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    include '../connection/connection.php';

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get form inputs
    $sectionname = $conn->real_escape_string($_POST['sectionname']);
    $gradelevel = $conn->real_escape_string($_POST['gradelevel']);

    // SQL query to insert the new section
    $sql = "INSERT INTO section (section_name, grade_level) VALUES ('$sectionname', '$gradelevel')";

    if ($conn->query($sql) === TRUE) {
        echo "New section added successfully!";
        // Redirect back to the section listing page or another page
        header("Location: ../pages/admin/sections.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
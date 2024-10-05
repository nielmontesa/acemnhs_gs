<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    include 'connection.php';

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get form inputs
    $section_id = $conn->real_escape_string($_POST['section_id']);
    $sectionname = $conn->real_escape_string($_POST['sectionname']);
    $gradelevel = $conn->real_escape_string($_POST['gradelevel']);
    $advisername = $conn->real_escape_string($_POST['advisername']);
    $startyear = $conn->real_escape_string($_POST['startyear']);
    $endyear = $conn->real_escape_string($_POST['endyear']);

    // Combine startyear and endyear into school_year format (e.g., 2023-2024)
    $schoolyear = $startyear . '-' . $endyear;

    // SQL query to update the section
    $sql = "UPDATE section SET section_name='$sectionname', grade_level='$gradelevel', school_year='$schoolyear', adviser_id='$advisername' WHERE section_id='$section_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Section updated successfully!";
        // Redirect back to the section listing page or another page
        header("Location: ../pages/admin/students.php?section_id=" . $section_id);
        exit(); // Make sure to exit after redirecting
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
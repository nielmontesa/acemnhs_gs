<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    include '../connection/connection.php';

    // Retrieve student details from the form
    $student_lrn = $conn->real_escape_string($_POST['student_lrn']);
    $student_firstname = $conn->real_escape_string($_POST['student_firstname']);
    $student_lastname = $conn->real_escape_string($_POST['student_lastname']);
    $email = $conn->real_escape_string($_POST['email']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $akap_status = $conn->real_escape_string($_POST['akap_status']);
    $teacher_remarks = $conn->real_escape_string($_POST['teacher_remarks']); // New field for teacher remarks

    // Retrieve student ID and section ID
    $student_id = $conn->real_escape_string($_POST['student_id']); // Student ID from the form

    // First, fetch the section_id associated with this student
    $section_sql = "SELECT section_ID FROM students WHERE student_id = '$student_id'";
    $section_result = $conn->query($section_sql);

    if ($section_result && $section_result->num_rows > 0) {
        $section_row = $section_result->fetch_assoc();
        $section_id = $section_row['section_ID']; // Get the section ID for redirection
    } else {
        echo "Student section not found.";
        exit();
    }

    // Update student details in the database
    $sql = "UPDATE students SET 
                LRN = '$student_lrn', 
                first_name = '$student_firstname', 
                last_name = '$student_lastname', 
                email = '$email', 
                gender = '$gender', 
                akap_status = '$akap_status', 
                teacher_remarks = '$teacher_remarks'  -- Update for teacher remarks
            WHERE student_id = '$student_id'";

    if ($conn->query($sql) === TRUE) {
        // Redirect to the student page of the relevant section
        header("Location: ../pages/admin/students.php?section_id=" . $section_id); // Add the section_id to the URL for context
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>
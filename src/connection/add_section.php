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
        // Get the last inserted section_id
        $section_id = $conn->insert_id;

        // List of subjects to be inserted into the gradesheet table
        $subjects = [
            'Filipino',
            'English',
            'Mathematics',
            'Science',
            'Home Economics',
            'Araling Panlipunan',
            'Edukasyon sa Pagpapakatao',
            'TLE',
            'Music',
            'Arts',
            'PE',
            'Health'
        ];

        // Insert subjects into gradesheet table
        $insertGradesheetQuery = "INSERT INTO gradesheet (section_id, subject) VALUES (?, ?)";
        $stmt = $conn->prepare($insertGradesheetQuery);

        // Loop through subjects and insert each one with the section_id
        foreach ($subjects as $subject) {
            $stmt->bind_param("is", $section_id, $subject);
            $stmt->execute();
        }

        $stmt->close();

        echo "New section and corresponding gradesheets added successfully!";
        // Redirect back to the section listing page or another page
        header("Location: ../pages/admin/sections.php");
        exit(); // Make sure to exit after redirecting
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
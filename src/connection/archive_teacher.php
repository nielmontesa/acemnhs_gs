<?php
include 'connection.php';

// Archive operation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['archive_teacher_id'])) {
    $teacher_id = $_POST['archive_teacher_id'];

    // Archive the teacher in the database (adjust SQL to your needs)
    $archive_sql = "UPDATE teachers SET is_archived = 1 WHERE teacher_id = ?";
    $stmt = $conn->prepare($archive_sql);
    $stmt->bind_param('i', $teacher_id);

    if ($stmt->execute()) {
        echo "Teacher archived successfully.";
        header("Location: ../pages/admin/all_teachers.php"); // Redirect after successful archive
        exit();
    } else {
        echo "Error archiving teacher: " . $conn->error;
    }

    $stmt->close();
}
?>
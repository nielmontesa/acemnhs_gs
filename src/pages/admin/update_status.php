<?php
include '../../connection/connection.php'; // Include your DB connection

// Get the section ID and new locked status from the AJAX request
$section_id = $_POST['section_id'] ?? null;
$is_locked = $_POST['is_locked'] ?? null;

// Check if both section_id and is_locked are available
if ($section_id !== null && $is_locked !== null) {
    // Update the is_locked status in the database
    $update_sql = "UPDATE section SET is_locked = ? WHERE section_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param('ii', $is_locked, $section_id);

    if ($update_stmt->execute()) {
        echo "Status updated successfully.";
    } else {
        echo "Error updating status.";
    }

    $update_stmt->close();
} else {
    echo "Invalid input.";
}

$conn->close();
?>
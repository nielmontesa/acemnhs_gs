<?php
include "connection.php"; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['gradesheet_id'])) {
    $gradesheet_id = (int) $_POST['gradesheet_id']; // Convert to integer
    $is_finalized = (int) $_POST['is_finalized']; // Convert to integer (0 or 1)

    // Prepare the SQL statement to update is_finalized
    $sql = "UPDATE gradesheet SET is_finalized = ? WHERE gradesheet_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ii", $is_finalized, $gradesheet_id);
        if ($stmt->execute()) {
            echo "Update successful"; // Optional: success message
        } else {
            echo "Error updating gradesheet: " . $conn->error; // Handle errors
        }
        $stmt->close(); // Close the statement
    } else {
        echo "Error preparing statement: " . $conn->error; // Handle errors in statement preparation
    }
}

$conn->close(); // Close the connection
?>
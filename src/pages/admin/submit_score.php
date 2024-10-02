<?php
include '../../connection/connection.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['score'])) {
    $student_id = $_POST['student_id']; // Make sure this is passed in the drawer
    $activity_id = $_POST['activity_id']; // Make sure this is passed in the drawer
    $score = $_POST['score'];

    // Insert the score into the database
    $add_score_query = "INSERT INTO student_activity_score (student_id, activity_id, score) VALUES (?, ?, ?)";
    $add_stmt = $conn->prepare($add_score_query);
    $add_stmt->bind_param("iid", $student_id, $activity_id, $score);

    if ($add_stmt->execute()) {
        // Get the redirect URL from the hidden input
        $redirect_url = $_POST['redirect_url'] ?? 'default_page.php'; // Fallback to a default page
        header("Location: $redirect_url");
        exit(); // Make sure to exit after the header redirect
    } else {
        echo "<script>alert('Error adding score: " . $conn->error . "');</script>";
    }
}

?>
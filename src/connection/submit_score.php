<?php
include 'connection.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['score'])) {
    $student_id = $_POST['student_id'];
    $activity_id = $_POST['activity_id'];
    $score = $_POST['score'];

    // Check if the score for this student and activity already exists
    $add_or_update_score_query = "
        INSERT INTO student_activity_score (student_id, activity_id, score) 
        VALUES (?, ?, ?)
        ON DUPLICATE KEY UPDATE score = VALUES(score)";

    $add_stmt = $conn->prepare($add_or_update_score_query);
    $add_stmt->bind_param("iid", $student_id, $activity_id, $score);

    if ($add_stmt->execute()) {
        // Redirect to the page where the user came from
        $redirect_url = $_POST['redirect_url'] ?? 'default_page.php'; // Fallback to a default page
        header("Location: $redirect_url");
        exit(); // Ensure that the script stops executing after the redirect
    } else {
        echo "<script>alert('Error saving score: " . $conn->error . "');</script>";
    }
}
?>
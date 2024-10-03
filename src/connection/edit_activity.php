<?php
include "connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['activity_id'])) {
    $activity_id = $_POST['activity_id'];

    // Check which action to perform
    if ($_POST['action'] === 'save') {
        // Save changes to activity
        $activity_name = $_POST['activity_name'];
        $total_score = $_POST['total_score'];
        $activity_type = $_POST['activity_type'];

        // Update the activity in the database, including activity_type
        $update_sql = "UPDATE activity SET activity_name = ?, total_score = ?, activity_type = ? WHERE activity_id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("sdsi", $activity_name, $total_score, $activity_type, $activity_id);

        if ($stmt->execute()) {
            // Redirect after saving
            $redirect_url = isset($_POST['redirect_url']) ? $_POST['redirect_url'] : 'default_redirect_page.php';
            header("Location: " . $redirect_url);
            exit();
        } else {
            echo "Error updating activity: " . $conn->error;
        }
    } elseif ($_POST['action'] === 'archive') {
        // Delete scores related to the activity
        $delete_scores_sql = "DELETE FROM student_activity_score WHERE activity_id = ?";
        $stmt_scores = $conn->prepare($delete_scores_sql);
        $stmt_scores->bind_param("i", $activity_id);

        if (!$stmt_scores->execute()) {
            echo "Error deleting scores: " . $conn->error;
            exit();
        }

        // Delete the activity from the database
        $delete_activity_sql = "DELETE FROM activity WHERE activity_id = ?";
        $stmt_activity = $conn->prepare($delete_activity_sql);
        $stmt_activity->bind_param("i", $activity_id);

        if ($stmt_activity->execute()) {
            // Redirect after deleting
            $redirect_url = isset($_POST['redirect_url']) ? $_POST['redirect_url'] : 'default_redirect_page.php';
            header("Location: " . $redirect_url);
            exit();
        } else {
            echo "Error deleting activity: " . $conn->error;
        }
    }
}
?>
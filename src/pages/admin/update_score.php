<?php
session_start();
// update_score.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database connection
    include('../../connection/connection.php'); // Modify this path as necessary

    // Assuming you have user information in the session
    $user_id = $_SESSION['username'] ?? 'Unknown User'; // Replace with actual user ID or username

    // Retrieve the values sent via AJAX
    $student_id = intval($_POST['student_id']);
    $activity_id = intval($_POST['activity_id']);
    $score = floatval($_POST['score']);

    // Check if there's already a score for this student and activity
    $check_query = "SELECT * FROM student_activity_score WHERE student_id = ? AND activity_id = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("ii", $student_id, $activity_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // If a record exists, update it
        $update_query = "UPDATE student_activity_score SET score = ? WHERE student_id = ? AND activity_id = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("dii", $score, $student_id, $activity_id);
        if ($update_stmt->execute()) {
            // Log the score update
            $score_id = $result->fetch_assoc()['score_id']; // Get the existing score ID
            $log_query = "INSERT INTO score_change_logs (score_id, edited_by) VALUES (?, ?)";
            $log_stmt = $conn->prepare($log_query);
            $log_stmt->bind_param("is", $score_id, $user_id); // Assuming edited_by is a string
            $log_stmt->execute(); // Log the change
            echo json_encode(['success' => true, 'message' => 'Score updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update score']);
        }
    } else {
        // If no record exists, insert a new one
        $insert_query = "INSERT INTO student_activity_score (student_id, activity_id, score) VALUES (?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_query);
        $insert_stmt->bind_param("iid", $student_id, $activity_id, $score);
        if ($insert_stmt->execute()) {
            // Log the score addition
            $score_id = $conn->insert_id; // Get the new score ID
            $log_query = "INSERT INTO score_change_logs (score_id, edited_by) VALUES (?, ?)";
            $log_stmt = $conn->prepare($log_query);
            $log_stmt->bind_param("is", $score_id, $user_id); // Assuming edited_by is a string
            $log_stmt->execute(); // Log the change

            echo json_encode(['success' => true, 'message' => 'Score added successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add score']);
        }
    }

    $stmt->close();
    $conn->close();
}
?>
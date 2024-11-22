<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include('../../connection/connection.php');

    $user_id = $_SESSION['username'] ?? 'Unknown User';

    $student_id = intval($_POST['student_id']);
    $activity_id = intval($_POST['activity_id']);
    $score = floatval($_POST['score']);

    // More efficient check for existing score
    $check_query = "SELECT score_id FROM student_activity_score WHERE student_id = ? AND activity_id = ?";
    $stmt = $conn->prepare($check_query);

    if (!$stmt) {
        echo json_encode(['success' => false, 'message' => "Error preparing statement: " . $conn->error]);
        exit;
    }

    $stmt->bind_param("ii", $student_id, $activity_id);

    if (!$stmt->execute()) {
        echo json_encode(['success' => false, 'message' => "Error executing statement: " . $stmt->error]);
        exit;
    }

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $update_query = "UPDATE student_activity_score SET score = ? WHERE student_id = ? AND activity_id = ?";
        $update_stmt = $conn->prepare($update_query);

        if (!$update_stmt) {
            echo json_encode(['success' => false, 'message' => "Error preparing statement: " . $conn->error]);
            exit;
        }

        $update_stmt->bind_param("dii", $score, $student_id, $activity_id);

        if ($update_stmt->execute()) {
            // Re-execute the query to get the updated score_id (if needed)
            $stmt->execute();
            $result = $stmt->get_result();
            $score_id = $result->fetch_assoc()['score_id'];

            $log_query = "INSERT INTO score_change_logs (score_id, edited_by) VALUES (?, ?)";
            $log_stmt = $conn->prepare($log_query);

            if (!$log_stmt) {
                echo json_encode(['success' => false, 'message' => "Error preparing statement: " . $conn->error]);
                exit;
            }

            $log_stmt->bind_param("is", $score_id, $user_id);

            if (!$log_stmt->execute()) {
                echo json_encode(['success' => false, 'message' => "Error executing statement: " . $log_stmt->error]);
                exit;
            }

            echo json_encode(['success' => true, 'message' => 'Score updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => "Failed to update score: " . $update_stmt->error]);
        }
    } else {
        $insert_query = "INSERT INTO student_activity_score (student_id, activity_id, score) VALUES (?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_query);

        if (!$insert_stmt) {
            echo json_encode(['success' => false, 'message' => "Error preparing statement: " . $conn->error]);
            exit;
        }

        $insert_stmt->bind_param("iid", $student_id, $activity_id, $score);

        if ($insert_stmt->execute()) {
            $score_id = $conn->insert_id;
            $log_query = "INSERT INTO score_change_logs (score_id, edited_by) VALUES (?, ?)";
            $log_stmt = $conn->prepare($log_query);

            if (!$log_stmt) {
                echo json_encode(['success' => false, 'message' => "Error preparing statement: " . $conn->error]);
                exit;
            }

            $log_stmt->bind_param("is", $score_id, $user_id);

            if (!$log_stmt->execute()) {
                echo json_encode(['success' => false, 'message' => "Error executing statement: " . $log_stmt->error]);
                exit;
            }

            echo json_encode(['success' => true, 'message' => 'Score added successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => "Failed to add score: " . $insert_stmt->error]);
        }
    }

    // Get the quarter of the activity
    $quarter_query = "SELECT quarter FROM activity WHERE activity_id = ?";
    $quarter_stmt = $conn->prepare($quarter_query);

    if (!$quarter_stmt) {
        echo json_encode(['success' => false, 'message' => "Error preparing statement: " . $conn->error]);
        exit;
    }

    $quarter_stmt->bind_param("i", $activity_id);

    if (!$quarter_stmt->execute()) {
        echo json_encode(['success' => false, 'message' => "Error executing statement: " . $quarter_stmt->error]);
        exit;
    }

    $quarter_result = $quarter_stmt->get_result();
    $quarter = $quarter_result->fetch_assoc()['quarter'];


    $gradesheet_query = "SELECT gradesheet_id FROM activity WHERE activity_id = ?";
    $gradesheet_stmt = $conn->prepare($gradesheet_query);

    if (!$gradesheet_stmt) {
        echo json_encode(['success' => false, 'message' => "Error preparing statement: " . $conn->error]);
        exit;
    }

    $gradesheet_stmt->bind_param("i", $activity_id);

    if (!$gradesheet_stmt->execute()) {
        echo json_encode(['success' => false, 'message' => "Error executing statement: " . $gradesheet_stmt->error]);
        exit;
    }

    $gradesheet_result = $gradesheet_stmt->get_result();
    $gradesheet_id = $gradesheet_result->fetch_assoc()['gradesheet_id'];


    // Fetch the last 5 scores for this gradesheet, student, and quarter
    $score_check_query = "
        SELECT sas.score, a.total_score
        FROM student_activity_score sas
        JOIN activity a ON sas.activity_id = a.activity_id
        WHERE sas.student_id = ? 
          AND a.gradesheet_id = ? 
          AND a.quarter = ?  -- Filter by quarter
        ORDER BY sas.score_id DESC
        LIMIT 5";
    $score_stmt = $conn->prepare($score_check_query);

    if (!$score_stmt) {
        echo json_encode(['success' => false, 'message' => "Error preparing statement: " . $conn->error]);
        exit;
    }

    $score_stmt->bind_param("iii", $student_id, $gradesheet_id, $quarter);

    if (!$score_stmt->execute()) {
        echo json_encode(['success' => false, 'message' => "Error executing statement: " . $score_stmt->error]);
        exit;
    }

    $score_result = $score_stmt->get_result();


    $low_score_count = 0;

    if ($score_result->num_rows > 0) {
        while ($row = $score_result->fetch_assoc()) {
            if ($row['score'] < ($row['total_score'] * 0.75)) {
                $low_score_count++;
            }
        }

        if ($low_score_count == 5) {
            $update_status_query = "UPDATE students SET akap_status = 'Active' WHERE student_id = ?";
            $status_stmt = $conn->prepare($update_status_query);

            if (!$status_stmt) {
                echo json_encode(['success' => false, 'message' => "Error preparing statement: " . $conn->error]);
                exit;
            }

            $status_stmt->bind_param("i", $student_id);

            if (!$status_stmt->execute()) {
                echo json_encode(['success' => false, 'message' => "Error executing statement: " . $status_stmt->error]);
                exit;
            }
        }
    }

    $stmt->close();
    $conn->close();
}
?>
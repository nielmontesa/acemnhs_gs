<?php

session_start();


include '../../connection/connection.php';
require '../../../vendor/autoload.php'; // Update the path if needed
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Get student ID from the URL
$student_id = $_GET['student_id'];

// Define weights for subjects
$weights = [
    'Filipino' => [0.3, 0.5, 0.2], // [Written Work, Performance Task, Quarterly Assessment]
    'English' => [0.3, 0.5, 0.2],
    'Mathematics' => [0.3, 0.4, 0.3],
    'Science' => [0.3, 0.4, 0.3],
    'Home Economics' => [0.3, 0.6, 0.1],
    'Araling Panlipunan' => [0.3, 0.5, 0.2],
    'Edukasyon sa Pagpapakatao' => [0.3, 0.5, 0.2],
    'TLE' => [0.3, 0.6, 0.1],
    'Music' => [0.3, 0.6, 0.1],
    'Arts' => [0.3, 0.6, 0.1],
    'PE' => [0.3, 0.6, 0.1],
    'Health' => [0.3, 0.6, 0.1]
];

// Fetch scores for the student from student_activity_score and join with activity table
$query = "
    SELECT 
        a.activity_id, 
        a.total_score, 
        sas.score AS student_score, 
        a.quarter, 
        gs.gradesheet_id, 
        gs.subject,
        a.activity_type
    FROM student_activity_score sas
    JOIN activity a ON sas.activity_id = a.activity_id
    JOIN gradesheet gs ON a.gradesheet_id = gs.gradesheet_id
    WHERE sas.student_id = ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();

$final_grades_display = []; // Array to store the final grades for display

if ($result->num_rows > 0) {
    // Prepare an array to hold scores by subject, quarter, and activity type
    $quarter_scores = [];

    while ($row = $result->fetch_assoc()) {
        $quarter = $row['quarter'];
        $subject = $row['subject'];
        $total_score = $row['total_score'];
        $student_score = $row['student_score'] ?? 0;
        $gradesheet_id = $row['gradesheet_id'];
        $activity_type = $row['activity_type'];

        // Group scores by subject, quarter, and activity type
        $quarter_scores[$subject][$quarter][$activity_type][] = [
            'total_score' => $total_score,
            'student_score' => $student_score,
            'gradesheet_id' => $gradesheet_id
        ];
    }

    // Calculate and insert/update final grades for each quarter of each subject
    foreach ($quarter_scores as $subject => $quarters) {
        foreach ($quarters as $quarter => $activity_types) {
            $weighted_scores = [];

            foreach ($activity_types as $activity_type => $scores) {
                $total_max_scores = 0;
                $total_student_scores = 0;

                foreach ($scores as $score) {
                    $total_max_scores += $score['total_score'];
                    $total_student_scores += $score['student_score'];
                }

                if ($total_max_scores > 0) {
                    // Calculate student percentage score
                    $student_percentage_score = ($total_student_scores / $total_max_scores) * 100;

                    // Get weight for the current activity type based on the subject
                    $weight = $weights[$subject][array_search($activity_type, ['Written Work', 'Performance Task', 'Quarterly Assessment'])];

                    // Calculate the weighted percentage
                    $student_weighted_percentage = $student_percentage_score * $weight;

                    // Add to weighted scores
                    $weighted_scores[] = $student_weighted_percentage;
                }
            }

            // Calculate final grade by summing the weighted scores
            // Calculate final grade by summing the weighted scores
            $final_grade = array_sum($weighted_scores);
            // Ensure that the final grade is not null before attempting to transmute
            if (!is_null($final_grade)) {
                $transmuted_grade = transmute_grade($final_grade);
            } else {
                $transmuted_grade = null; // Handle the case if final_grade is null
            }

            // Check if the final grade already exists
            $check_query = "
        SELECT final_grade_id FROM final_grades 
        WHERE student_id = ? AND gradesheet_id = ? AND quarter = ?
    ";

            $check_stmt = $conn->prepare($check_query);
            $check_stmt->bind_param("iii", $student_id, $scores[0]['gradesheet_id'], $quarter);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();

            if ($check_result->num_rows > 0) {
                // Update existing final grade
                $update_query = "
            UPDATE final_grades 
            SET final_grade = ?, transmuted_grade = ? 
            WHERE student_id = ? AND gradesheet_id = ? AND quarter = ?
        ";

                $update_stmt = $conn->prepare($update_query);
                $update_stmt->bind_param("dsiii", $final_grade, $transmuted_grade, $student_id, $scores[0]['gradesheet_id'], $quarter);

                if (!$update_stmt->execute()) {
                    die("Update Failed: " . $update_stmt->error);
                }
            } else {
                // Insert into final grades table
                $insert_query = "
            INSERT INTO final_grades (student_id, gradesheet_id, quarter, final_grade, transmuted_grade) 
            VALUES (?, ?, ?, ?, ?)
        ";

                $insert_stmt = $conn->prepare($insert_query);
                $insert_stmt->bind_param("iiidd", $student_id, $scores[0]['gradesheet_id'], $quarter, $final_grade, $transmuted_grade);

                if (!$insert_stmt->execute()) {
                    die("Insert Failed: " . $insert_stmt->error);
                }
            }

            // Store for display
            $final_grades_display[] = [
                'subject' => $subject,
                'quarter' => $quarter,
                'final_grade' => round($final_grade, 2), // Round final grade to 2 decimal places
                'transmuted_grade' => $transmuted_grade // Also store transmuted grade
            ];
        }
    }
} else {
    echo "No activity scores found for Student ID: $student_id";
}
function transmute_grade($final_grade)
{
    if ($final_grade >= 100)
        return 100;
    if ($final_grade >= 98.40)
        return 99;
    if ($final_grade >= 96.80)
        return 98;
    if ($final_grade >= 95.21)
        return 97;
    if ($final_grade >= 93.60)
        return 96;
    if ($final_grade >= 92.00)
        return 95;
    if ($final_grade >= 90.40)
        return 94;
    if ($final_grade >= 88.80)
        return 93;
    if ($final_grade >= 87.20)
        return 92;
    if ($final_grade >= 85.60)
        return 91;
    if ($final_grade >= 84.00)
        return 90;
    if ($final_grade >= 82.40)
        return 89;
    if ($final_grade >= 80.80)
        return 88;
    if ($final_grade >= 78.20)
        return 87;
    if ($final_grade >= 77.60)
        return 86;
    if ($final_grade >= 76.00)
        return 85;
    if ($final_grade >= 74.40)
        return 84;
    if ($final_grade >= 72.80)
        return 83;
    if ($final_grade >= 71.20)
        return 82;
    if ($final_grade >= 69.61)
        return 81;  // Adjusted the range here to make sure 69.80 gets covered
    if ($final_grade >= 68.00)
        return 80;
    if ($final_grade >= 66.40)
        return 79;
    if ($final_grade >= 64.81)
        return 78;
    if ($final_grade >= 63.21)
        return 77;
    if ($final_grade >= 61.60)
        return 76;
    if ($final_grade >= 60.01)
        return 75;
    if ($final_grade >= 56.00)
        return 74;
    if ($final_grade >= 52.01)
        return 73;
    if ($final_grade >= 48.00)
        return 72;
    if ($final_grade >= 44.00)
        return 71;
    if ($final_grade >= 40.01)
        return 70;
    if ($final_grade >= 36.00)
        return 69;
    if ($final_grade >= 32.00)
        return 68;
    if ($final_grade >= 28.00)
        return 67;
    if ($final_grade >= 24.00)
        return 66;
    if ($final_grade >= 20.00)
        return 65;
    if ($final_grade >= 16.00)
        return 64;
    if ($final_grade >= 12.00)
        return 63;
    if ($final_grade >= 8.00)
        return 62;
    if ($final_grade >= 4.00)
        return 61;
    return 60;  // If grade is below 4.00, return 60
}

use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST['export'])) {
    // Load the existing Excel template (sf9.xlsx)
    $templateFilePath = '../../templates/sf9.xlsx'; // Update this path
    $spreadsheet = IOFactory::load($templateFilePath);

    // Select the 'BACK' sheet where the grades will be placed
    $sheet = $spreadsheet->getSheetByName('BACK');

    // Mapping for each subject to its row in the Excel sheet
    $subjectRowMapping = [
        'Filipino' => 7,
        'English' => 8,
        'Mathematics' => 9,
        'Science' => 10,
        // Continue mapping subjects to row numbers
    ];

    foreach ($final_grades_display as $grade) {
        // Get the corresponding row number for the subject
        $row = $subjectRowMapping[$grade['subject']];

        // Set the transmuted grade in the correct column based on the quarter
        if ($grade['quarter'] == 1) {
            $sheet->setCellValue('N' . $row, $grade['transmuted_grade']); // Quarter 1
        } elseif ($grade['quarter'] == 2) {
            $sheet->setCellValue('O' . $row, $grade['transmuted_grade']); // Quarter 2
        } elseif ($grade['quarter'] == 3) {
            $sheet->setCellValue('P' . $row, $grade['transmuted_grade']); // Quarter 3
        } elseif ($grade['quarter'] == 4) {
            $sheet->setCellValue('Q' . $row, $grade['transmuted_grade']); // Quarter 4
        }
    }

    // After setting all grades, calculate the average and status for each subject
    foreach ($subjectRowMapping as $subject => $row) {
        // Retrieve grades for the 4 quarters
        $quarter1 = $sheet->getCell('N' . $row)->getValue();
        $quarter2 = $sheet->getCell('O' . $row)->getValue();
        $quarter3 = $sheet->getCell('P' . $row)->getValue();
        $quarter4 = $sheet->getCell('Q' . $row)->getValue();

        // Check if grades are set and calculate average only if all quarters have grades
        if (is_numeric($quarter1) && is_numeric($quarter2) && is_numeric($quarter3) && is_numeric($quarter4)) {
            $average = ($quarter1 + $quarter2 + $quarter3 + $quarter4) / 4;
            $sheet->setCellValue('R' . $row, round($average, 2));

            // Determine if the student passed (average >= 75)
            $status = ($average >= 75) ? 'PASSED' : 'FAILED';
            $sheet->setCellValue('S' . $row, $status);
        } else {
            // Clear average and status cells if any grade is missing
            $sheet->setCellValue('R' . $row, ''); // Clear average cell
            $sheet->setCellValue('S' . $row, ''); // Clear status cell
        }
    }

    // Save the modified file as .xlsx
    $writer = new Xlsx($spreadsheet);
    $filename = 'sf9_final_' . date('Y-m-d_H-i-s') . '.xlsx';

    // Set headers for download
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    // Save to output buffer
    $writer->save('php://output');
    exit; // Ensure no further output after download
}
// Close statement
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Card</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">



        <h1>Report Card</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Quarter</th>
                    <th>Final Grade</th>
                    <th>Transmuted Grade</th>
                </tr>
            </thead>
            <form method="post">
                <button type="submit" name="export" class="btn btn-primary">Export to Excel</button>
            </form>

            <tbody>
                <?php foreach ($final_grades_display as $grade): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($grade['subject']); ?></td>
                        <td><?php echo htmlspecialchars($grade['quarter']); ?></td>
                        <td><?php echo htmlspecialchars($grade['final_grade']); ?></td>
                        <td><?php echo htmlspecialchars($grade['transmuted_grade']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>
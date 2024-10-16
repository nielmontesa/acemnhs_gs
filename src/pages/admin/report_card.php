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
        'Science' => 11,
        'Araling Panlipunan' => 12,
        'Edukasyon sa Pagpapakatao' => 13,
        'TLE' => 15,
        'Music' => 18,
        'Arts' => 19,
        'PE' => 20,
        'Health' => 21,
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
            $average = transmute_grade(($quarter1 + $quarter2 + $quarter3 + $quarter4) / 4);
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

    // Get student information from the database
    // Get student information from the database
    $sql = "SELECT s.first_name, s.last_name, s.LRN, sec.grade_level, sec.section_name, sec.school_year, s.gender
        FROM students s
        JOIN section sec ON s.section_ID = sec.section_id
        WHERE s.student_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $student_id); // Assuming student_id is an integer
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $student_data = $result->fetch_assoc();

        // Select the 'FRONT' sheet where the student information will be placed
        $frontSheet = $spreadsheet->getSheetByName('FRONT');

        // Set the student data in the specified cells
        $frontSheet->setCellValue('P22', 'Name: ' . $student_data['first_name'] . ' ' . $student_data['last_name']);
        $frontSheet->setCellValue('P24', 'Learner\'s Reference Number: ' . $student_data['LRN']);
        $frontSheet->setCellValue('P26', 'Sex: ' . $student_data['gender']);
        $frontSheet->setCellValue('P28', 'Grade: ' . $student_data['grade_level'] . ' Section: ' . $student_data['section_name']);
        $frontSheet->setCellValue('P30', 'School Year: ' . $student_data['school_year']);

        // Underline the added text
        $frontSheet->getStyle('P22')->getFont()->setUnderline(true);
        $frontSheet->getStyle('P24')->getFont()->setUnderline(true);
        $frontSheet->getStyle('P26')->getFont()->setUnderline(true);
        $frontSheet->getStyle('P28')->getFont()->setUnderline(true);
        $frontSheet->getStyle('P30')->getFont()->setUnderline(true);
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
<html data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light only">
    <title>Antonio C. Esguerra MNHS</title>
    <link rel="stylesheet" href='../../styles/tailwind.css'>
    <link rel="stylesheet" href='../../styles/style.css'>
    <link rel="icon" href="../../assets/acemnhs_logo.png">
</head>


<body>
    <div class="flex flex-row sm:gap-5">
        <div class="sm:w-full sm:max-w-[18rem]">
            <input type="checkbox" id="sidebar-mobile-fixed" class="sidebar-state" />
            <label for="sidebar-mobile-fixed" class="sidebar-overlay"></label>
            <aside
                class="sidebar sidebar-fixed-left sidebar-mobile h-full justify-start max-sm:fixed max-sm:-translate-x-full">
                <section class="sidebar-title items-center p-4 gap-2">
                    <img src="../../assets/acemnhs_logo.png" class="w-14" alt="">
                    <div class="flex flex-col">
                        <span class="text-lg">ACEMN High School</span>
                        <span class="text-xs font-normal text-content2">Grading System</span>
                    </div>
                </section>
                <section class="sidebar-content">
                    <nav class="menu rounded-md">
                        <section class="menu-section px-4">head
                            <span class="menu-title">Welcome, <?php echo $_SESSION['username']; ?></span>
                            <ul class="menu-items">
                                <a href="departments.php">
                                    <li class="menu-item ">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-75" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span>Faculty</span>
                                    </li>
                                </a>
                                <a href="sections.php">
                                    <li class="menu-item  menu-active">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-75" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        <span>Students</span>
                                    </li>
                                </a>
                                <a href="reports.php">
                                    <li class="menu-item">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-75" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                        </svg>
                                        <span>Reports</span>
                                    </li>
                                </a>
                            </ul>
                        </section>

                    </nav>
                </section>
                <section class="sidebar-footer justify-end bg-gray-2 pt-2">
                    <div class="divider my-0"></div>
                    <div class="dropdown z-50 flex h-fit w-full cursor-pointer hover:bg-gray-4">
                        <label class="whites mx-2 flex h-fit w-full cursor-pointer p-0 hover:bg-gray-4" tabindex="0">
                            <div class="flex flex-row gap-4 p-4">
                                <div class="avatar-square avatar avatar-md">
                                    <img src="https://i.pravatar.cc/150?img=30" alt="avatar" />
                                </div>

                                <div class="flex flex-col">
                                    <span><?php echo $_SESSION['username']; ?></span>
                                    <span class="text-xs">Administrator</span>
                                </div>
                            </div>
                        </label>
                        <div class="dropdown-menu-right-top dropdown-menu ml-2">
                            <a href="settings.php" tabindex="-1" class="dropdown-item text-sm">Account settings</a>
                            <a href="../../connection/logout.php" tabindex="-1" class="dropdown-item text-sm">Logout</a>
                        </div>
                    </div>
                </section>
            </aside>
        </div>
        <main class="main-content flex-1 p-8 overflow-x-auto">
            <div class="w-fit">
                <label for="sidebar-mobile-fixed" class="btn-primary btn sm:hidden">Open Sidebar</label>
            </div>

            <?php
            // Start the session if needed
            
            // Database connection (ensure you have this included at the top)
            include '../../connection/connection.php';

            // Get student ID from the URL
            $student_id = $_GET['student_id'];

            // Prepare the SQL statement to get the student's name, section name, and grade level
            $sql = "SELECT s.first_name, s.last_name, sec.section_name, sec.grade_level 
        FROM students s
        JOIN section sec ON s.section_ID = sec.section_id
        WHERE s.student_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $student_id); // Assuming student_id is an integer
            $stmt->execute();
            $result = $stmt->get_result();

            // Check if the student exists
            if ($result->num_rows > 0) {
                // Fetch the student's data
                $student_data = $result->fetch_assoc();
                $full_name = $student_data['first_name'] . ' ' . $student_data['last_name'];
                $section_name = $student_data['section_name'];
                $grade_level = $student_data['grade_level'];

                // Display the student's name in an <h1> element
                echo "<h1 class='text-xl font-bold pb-2'>$full_name</h1>";

                // Display the section name and grade level in a paragraph
                echo "<p class='pb-4'>Section: $section_name | Grade Level: $grade_level</p>";
            } else {
                echo "<h1>Student not found</h1>";
            }

            // Close the statement and connection
            $stmt->close();
            $conn->close();
            ?>


            <form method="post" class="flex gap-2">
                <button type="submit" name="export" class="btn btn-primary">Export to Excel</button>
                <h1> </h1>
                <a href="PDF%20Generator/pdfstructure.php?student_id=<?php echo $student_id; ?>" target="_blank" class="btn btn-primary">Preview in PDF</a>
            </form>

            <table class="table table-striped pt-8">
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Quarter 1</th>
                        <th>Quarter 2</th>
                        <th>Quarter 3</th>
                        <th>Quarter 4</th>
                        <th>Final Grade</th>
                        <th>Transmuted Grade</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $subject_grades = [];
                    foreach ($final_grades_display as $grade) {
                        $subject = $grade['subject'];

                        // Group grades by subject
                        if (!isset($subject_grades[$subject])) {
                            $subject_grades[$subject] = [
                                'quarter_1' => '',
                                'quarter_2' => '',
                                'quarter_3' => '',
                                'quarter_4' => '',
                                'transmuted_grades' => []
                            ];
                        }

                        // Assign the correct quarter's transmuted grade
                        $subject_grades[$subject]['quarter_' . $grade['quarter']] = $grade['transmuted_grade'];

                        // Store transmuted grades for final calculations
                        $subject_grades[$subject]['transmuted_grades'][] = $grade['transmuted_grade'];
                    }

                    // Function to calculate the transmuted grade
                    function calculate_transmuted_grade($final_grade)
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
                            return 81;
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
                        return 60;
                    }

                    // Display the grouped grades in the table
                    foreach ($subject_grades as $subject => $grades) {
                        // Calculate the final grade (average of the quarters)
                        $total_grades = array_sum($grades['transmuted_grades']);
                        $num_grades = count($grades['transmuted_grades']);
                        $final_grade = $num_grades > 0 ? $total_grades / $num_grades : 0;

                        // Calculate the transmuted final grade
                        $transmuted_final_grade = calculate_transmuted_grade($final_grade);
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($subject); ?></td>
                            <td><?php echo htmlspecialchars($grades['quarter_1']); ?></td>
                            <td><?php echo htmlspecialchars($grades['quarter_2']); ?></td>
                            <td><?php echo htmlspecialchars($grades['quarter_3']); ?></td>
                            <td><?php echo htmlspecialchars($grades['quarter_4']); ?></td>
                            <td><?php echo htmlspecialchars(round($final_grade, 2)); ?></td>
                            <td><?php echo htmlspecialchars($transmuted_final_grade); ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>

        </main>
</body>

</html>
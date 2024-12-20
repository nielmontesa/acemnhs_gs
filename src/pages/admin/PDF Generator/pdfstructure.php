<?php
session_start();
require('fpdf/fpdf.php');
require_once('FPDI-master/src/autoload.php');
require('../../../connection/connection.php');



$student_id = $_GET['student_id'];


// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Fetching for progress report
$sql_attendance = "SELECT s.*, sec.*, FLOOR(DATEDIFF(CURDATE(), bday) / 365) as age
                    FROM students s
                    INNER JOIN section sec ON s.section_id = sec.section_id
                    WHERE s.student_id = '$student_id' and s.is_archived = 0;";
$data_attendance = mysqli_query($conn, $sql_attendance);

function transmute_grade($final_grade)
{
    $grade_map = [
        [100, 100],
        [98.40, 99],
        [96.80, 98],
        [95.21, 97],
        [93.60, 96],
        [92.00, 95],
        [90.40, 94],
        [88.80, 93],
        [87.20, 92],
        [85.60, 91],
        [84.00, 90],
        [82.40, 89],
        [80.80, 88],
        [78.20, 87],
        [77.60, 86],
        [76.00, 85],
        [74.40, 84],
        [72.80, 83],
        [71.20, 82],
        [69.61, 81],
        [68.00, 80],
        [66.40, 79],
        [64.81, 78],
        [63.21, 77],
        [61.60, 76],
        [60.01, 75],
        [56.00, 74],
        [52.01, 73],
        [48.00, 72],
        [4.00, 61],
        [0, 60]  // If it's below 4.00, return 60
    ];
    // Iterate transmuted grade
    foreach ($grade_map as $grade) {
        if ($final_grade >= $grade[0]) {
            return $grade[1];
        }
    }
}

function status($status)
{
    if ($status >= 75)
        return 'PASSED';
    else
        return 'FAILED';
}

// Check for errors in the attendance query

if (!$data_attendance) {
    die("SQL Error for attendance: " . mysqli_error($conn));
}

// Fetching for grades
$sql_grades = "SELECT s.*, ROUND(fg.transmuted_grade) as final_grade, gs.*, fg.quarter
              FROM students s
              INNER JOIN final_grades fg ON s.student_id = fg.student_id
              INNER JOIN gradesheet gs ON fg.gradesheet_id = gs.gradesheet_id
              WHERE s.is_archived = 0 AND s.student_id = '$student_id'";
$data_grades = mysqli_query($conn, $sql_grades);

// Check for errors in the grades query
if (!$data_grades) {
    die("SQL Error for grades: " . mysqli_error($conn));
}

// Step 2: Create a new FPDI object
$pdf = new \setasign\Fpdi\Fpdi();

$pdf->SetFont("Arial", "", 12);

// Attendance PDF
$pdf->setSourceFile("attendance.pdf");
$template = $pdf->importPage(1);
$pdf->AddPage("L");
$pdf->useTemplate($template);


while ($row = mysqli_fetch_assoc($data_attendance)) {

    $pdf->SetXY(140, 111);
    $pdf->MultiCell(120, 2, $row['first_name'] . ' ' . $row['last_name']);

    $pdf->SetXY(175, 119);
    $pdf->MultiCell(120, 2, $row['LRN']);

    $pdf->SetXY(155, 127);
    $pdf->MultiCell(120, 2, $row['age']);

    $pdf->SetXY(200, 127);
    $pdf->MultiCell(120, 2, $row['gender']);

    $pdf->SetXY(155, 136);
    $pdf->MultiCell(120, 2, $row['grade_level']);

    $pdf->SetXY(190, 136);
    $pdf->MultiCell(120, 2, $row['section_name']);

    $pdf->SetXY(150, 145);
    $pdf->MultiCell(120, 2, $row['school_year']);



}

// Grade PDF
$pdf->setSourceFile("Grades_and_morals.pdf");
$template2 = $pdf->importPage(1);
$pdf->AddPage('L');
$pdf->useTemplate($template2);
$pdf->SetXY(50, 50);

$filipino_grades = [];
$english_grades = [];
$math_grades = [];
$sci_grades = [];
$ap_grades = [];
$esp_grades = [];
$tle_grades = [];
$mq1_grades = [];
$mq2_grades = [];
$mq3_grades = [];
$mq4_grades = [];
$general_ave = [];

while ($row = mysqli_fetch_assoc($data_grades)) {
    $pdf->SetFont("Arial", "", 10);
    $pdf->SetXY(50, 50);


    if ($row['subject'] == 'Filipino') {
        // Store the final grade for each quarter in the array
        $quarterIndex = $row['quarter'] - 1; // Assuming quarter is 1-based (1, 2, 3, 4)
        $filipino_grades[$quarterIndex] = $row['final_grade'];
    }


    //Filipino
    if ($row['subject'] == 'Filipino' && $row['quarter'] == 1) {
        $pdf->SetXY(50, 50);
        $pdf->MultiCell(60, 15, $row['final_grade']);
    }
    if ($row['subject'] == 'Filipino' && $row['quarter'] == 2) {
        $pdf->SetXY(60, 50);
        $pdf->MultiCell(60, 15, $row['final_grade']);
    }
    if ($row['subject'] == 'Filipino' && $row['quarter'] == 3) {
        $pdf->SetXY(70, 50);
        $pdf->MultiCell(60, 15, $row['final_grade']);
    }
    if ($row['subject'] == 'Filipino' && $row['quarter'] == 4) {
        $pdf->SetXY(80, 50);
        $pdf->MultiCell(60, 15, $row['final_grade']);
    }



    if ($row['subject'] == 'English') {
        // Store the final grade for each quarter in the array
        $quarterIndex = $row['quarter'] - 1; // Assuming quarter is 1-based (1, 2, 3, 4)
        $english_grades[$quarterIndex] = $row['final_grade'];
    }

    // English
    if ($row['subject'] == 'English' && $row['quarter'] == 1) {
        $pdf->SetXY(50, 55);
        $pdf->MultiCell(60, 16, $row['final_grade']);
    }
    if ($row['subject'] == 'English' && $row['quarter'] == 2) {
        $pdf->SetXY(60, 55);
        $pdf->MultiCell(60, 16, $row['final_grade']);
    }
    if ($row['subject'] == 'English' && $row['quarter'] == 3) {
        $pdf->SetXY(70, 55);
        $pdf->MultiCell(60, 16, $row['final_grade']);
    }
    if ($row['subject'] == 'English' && $row['quarter'] == 4) {
        $pdf->SetXY(80, 55);
        $pdf->MultiCell(60, 16, $row['final_grade']);
    }

    if ($row['subject'] == 'Mathematics') {
        // Store the final grade for each quarter in the array
        $quarterIndex = $row['quarter'] - 1; // Assuming quarter is 1-based (1, 2, 3, 4)
        $math_grades[$quarterIndex] = $row['final_grade'];
    }

    // Mathematics
    if ($row['subject'] == 'Mathematics' && $row['quarter'] == 1) {
        $pdf->SetXY(50, 61);
        $pdf->MultiCell(60, 16, $row['final_grade']);
    }
    if ($row['subject'] == 'Mathematics' && $row['quarter'] == 2) {
        $pdf->SetXY(60, 61);
        $pdf->MultiCell(60, 16, $row['final_grade']);
    }
    if ($row['subject'] == 'Mathematics' && $row['quarter'] == 3) {
        $pdf->SetXY(70, 61);
        $pdf->MultiCell(60, 16, $row['final_grade']);
    }
    if ($row['subject'] == 'Mathematics' && $row['quarter'] == 4) {
        $pdf->SetXY(80, 61);
        $pdf->MultiCell(60, 16, $row['final_grade']);
    }

    if ($row['subject'] == 'Science') {
        // Store the final grade for each quarter in the array
        $quarterIndex = $row['quarter'] - 1; // Assuming quarter is 1-based (1, 2, 3, 4)
        $sci_grades[$quarterIndex] = $row['final_grade'];
    }

    // Science
    if ($row['subject'] == 'Science' && $row['quarter'] == 1) {
        $pdf->SetXY(50, 67);
        $pdf->MultiCell(60, 16, $row['final_grade']);
    }
    if ($row['subject'] == 'Science' && $row['quarter'] == 2) {
        $pdf->SetXY(60, 67);
        $pdf->MultiCell(60, 16, $row['final_grade']);
    }
    if ($row['subject'] == 'Science' && $row['quarter'] == 3) {
        $pdf->SetXY(70, 67);
        $pdf->MultiCell(60, 16, $row['final_grade']);
    }
    if ($row['subject'] == 'Science' && $row['quarter'] == 4) {
        $pdf->SetXY(80, 67);
        $pdf->MultiCell(60, 16, $row['final_grade']);
    }

    if ($row['subject'] == 'Araling Panlipunan') {
        // Store the final grade for each quarter in the array
        $quarterIndex = $row['quarter'] - 1; // Assuming quarter is 1-based (1, 2, 3, 4)
        $ap_grades[$quarterIndex] = $row['final_grade'];
    }

    // Araling Panlipunan
    if ($row['subject'] == 'Araling Panlipunan' && $row['quarter'] == 1) {
        $pdf->SetXY(50, 73);
        $pdf->MultiCell(60, 16, $row['final_grade']);
    }
    if ($row['subject'] == 'Araling Panlipunan' && $row['quarter'] == 2) {
        $pdf->SetXY(60, 73);
        $pdf->MultiCell(60, 16, $row['final_grade']);
    }
    if ($row['subject'] == 'Araling Panlipunan' && $row['quarter'] == 3) {
        $pdf->SetXY(70, 73);
        $pdf->MultiCell(60, 16, $row['final_grade']);
    }
    if ($row['subject'] == 'Araling Panlipunan' && $row['quarter'] == 4) {
        $pdf->SetXY(80, 73);
        $pdf->MultiCell(60, 16, $row['final_grade']);
    }

    if ($row['subject'] == 'Edukasyon sa Pagpapakatao') {
        // Store the final grade for each quarter in the array
        $quarterIndex = $row['quarter'] - 1; // Assuming quarter is 1-based (1, 2, 3, 4)
        $esp_grades[$quarterIndex] = $row['final_grade'];
    }

    // Edukasyon sa Pagpapakatao
    if ($row['subject'] == 'Edukasyon sa Pagpapakatao' && $row['quarter'] == 1) {
        $pdf->SetXY(50, 83);
        $pdf->MultiCell(60, 16, $row['final_grade']);
    }
    if ($row['subject'] == 'Edukasyon sa Pagpapakatao' && $row['quarter'] == 2) {
        $pdf->SetXY(60, 83);
        $pdf->MultiCell(60, 16, $row['final_grade']);
    }
    if ($row['subject'] == 'Edukasyon sa Pagpapakatao' && $row['quarter'] == 3) {
        $pdf->SetXY(70, 83);
        $pdf->MultiCell(60, 16, $row['final_grade']);
    }
    if ($row['subject'] == 'Edukasyon sa Pagpapakatao' && $row['quarter'] == 4) {
        $pdf->SetXY(80, 83);
        $pdf->MultiCell(60, 16, $row['final_grade']);
    }

    if ($row['subject'] == 'TLE') {
        // Store the final grade for each quarter in the array
        $quarterIndex = $row['quarter'] - 1; // Assuming quarter is 1-based (1, 2, 3, 4)
        $tle_grades[$quarterIndex] = $row['final_grade'];
    }

    // Edukasyong Pantahanan at Pangkabuhayan/TLE
    if ($row['subject'] == 'TLE' && $row['quarter'] == 1) {
        $pdf->SetXY(50, 95);
        $pdf->MultiCell(60, 16, $row['final_grade']);
    }
    if ($row['subject'] == 'TLE' && $row['quarter'] == 2) {
        $pdf->SetXY(60, 95);
        $pdf->MultiCell(60, 16, $row['final_grade']);
    }
    if ($row['subject'] == 'TLE' && $row['quarter'] == 3) {
        $pdf->SetXY(70, 95);
        $pdf->MultiCell(60, 16, $row['final_grade']);
    }
    if ($row['subject'] == 'TLE' && $row['quarter'] == 4) {
        $pdf->SetXY(80, 95);
        $pdf->MultiCell(60, 16, $row['final_grade']);
    }

    // // Mapeh
    // if ($row['subject'] == 'TLE' && $row['quarter'] == 1) {
    //     $pdf->SetXY(50, 104); 
    //     $pdf->MultiCell(60, 16, $row['final_grade'] );     
    // }
    // if ($row['subject'] == 'TLE' && $row['quarter'] == 2) {
    //     $pdf->SetXY(60, 104); 
    //     $pdf->MultiCell(60, 16, $row['final_grade'] );     
    // }
    // if ($row['subject'] == 'TLE' && $row['quarter'] == 3) {
    //     $pdf->SetXY(70,104); 
    //     $pdf->MultiCell(60, 16, $row['final_grade'] );     
    // }
    // if ($row['subject'] == 'TLE' && $row['quarter'] == 4) {
    //     $pdf->SetXY(80, 104); 
    //     $pdf->MultiCell(60, 16, $row['final_grade'] );     
    // }

    // Mapeh/Music
    if ($row['subject'] == 'Music' && $row['quarter'] == 1) {
        $pdf->SetXY(50, 110);
        $pdf->MultiCell(60, 16, $row['final_grade']);
        $mq1_grades[0] = $row['final_grade'];
    }
    if ($row['subject'] == 'Music' && $row['quarter'] == 2) {
        $pdf->SetXY(60, 110);
        $pdf->MultiCell(60, 16, $row['final_grade']);
        $mq2_grades[0] = $row['final_grade'];
    }
    if ($row['subject'] == 'Music' && $row['quarter'] == 3) {
        $pdf->SetXY(70, 110);
        $pdf->MultiCell(60, 16, $row['final_grade']);
        $mq3_grades[0] = $row['final_grade'];
    }
    if ($row['subject'] == 'Music' && $row['quarter'] == 4) {
        $pdf->SetXY(80, 110);
        $pdf->MultiCell(60, 16, $row['final_grade']);
        $mq4_grades[0] = $row['final_grade'];
    }

    // Mapeh/Arts
    if ($row['subject'] == 'Arts' && $row['quarter'] == 1) {
        $pdf->SetXY(50, 118);
        $pdf->MultiCell(60, 16, $row['final_grade']);
        $mq1_grades[1] = $row['final_grade'];

    }
    if ($row['subject'] == 'Arts' && $row['quarter'] == 2) {
        $pdf->SetXY(60, 118);
        $pdf->MultiCell(60, 16, $row['final_grade']);
        $mq2_grades[1] = $row['final_grade'];
    }
    if ($row['subject'] == 'Arts' && $row['quarter'] == 3) {
        $pdf->SetXY(70, 118);
        $pdf->MultiCell(60, 16, $row['final_grade']);
        $mq3_grades[1] = $row['final_grade'];
    }
    if ($row['subject'] == 'Arts' && $row['quarter'] == 4) {
        $pdf->SetXY(80, 118);
        $pdf->MultiCell(60, 16, $row['final_grade']);
        $mq4_grades[1] = $row['final_grade'];
    }

    // Mapeh/Physical Education
    if ($row['subject'] == 'PE' && $row['quarter'] == 1) {
        $pdf->SetXY(50, 125);
        $pdf->MultiCell(60, 16, $row['final_grade']);
        $mq1_grades[2] = $row['final_grade'];
    }
    if ($row['subject'] == 'PE' && $row['quarter'] == 2) {
        $pdf->SetXY(60, 125);
        $pdf->MultiCell(60, 16, $row['final_grade']);
        $mq2_grades[2] = $row['final_grade'];
    }
    if ($row['subject'] == 'PE' && $row['quarter'] == 3) {
        $pdf->SetXY(70, 125);
        $pdf->MultiCell(60, 16, $row['final_grade']);
        $mq3_grades[2] = $row['final_grade'];
    }
    if ($row['subject'] == 'PE' && $row['quarter'] == 4) {
        $pdf->SetXY(80, 125);
        $pdf->MultiCell(60, 16, $row['final_grade']);
        $mq4_grades[2] = $row['final_grade'];
    }

    // Mapeh/Health
    if ($row['subject'] == 'Health' && $row['quarter'] == 1) {
        $pdf->SetXY(50, 133);
        $pdf->MultiCell(60, 16, $row['final_grade']);
        $mq1_grades[3] = $row['final_grade'];
    }
    if ($row['subject'] == 'Health' && $row['quarter'] == 2) {
        $pdf->SetXY(60, 133);
        $pdf->MultiCell(60, 16, $row['final_grade']);
        $mq2_grades[3] = $row['final_grade'];
    }
    if ($row['subject'] == 'Health' && $row['quarter'] == 3) {
        $pdf->SetXY(70, 133);
        $pdf->MultiCell(60, 16, $row['final_grade']);
        $mq3_grades[3] = $row['final_grade'];
    }
    if ($row['subject'] == 'Health' && $row['quarter'] == 4) {
        $pdf->SetXY(80, 133);
        $pdf->MultiCell(60, 16, $row['final_grade']);
        $mq4_grades[3] = $row['final_grade'];
    }


}
//filipino
$filipino_total = array_sum($filipino_grades);
$filipino_ave = $filipino_total / count($filipino_grades);
$pdf->SetXY(90, 50);
$pdf->MultiCell(60, 15, transmute_grade($filipino_ave));
$pdf->SetXY(102, 50);
$pdf->MultiCell(60, 15, status(transmute_grade($filipino_ave)));

//english
$english_total = array_sum($english_grades);
$english_ave = $english_total / count($english_grades);
$pdf->SetXY(90, 55);
$pdf->MultiCell(60, 15, transmute_grade($english_ave));
$pdf->SetXY(102, 55);
$pdf->MultiCell(60, 15, status(transmute_grade($english_ave)));

//mathematics
$math_total = array_sum($math_grades);
$math_ave = $math_total / count($math_grades);
$pdf->SetXY(90, 61);
$pdf->MultiCell(60, 15, transmute_grade($math_ave));
$pdf->SetXY(102, 61);
$pdf->MultiCell(60, 15, status(transmute_grade($math_ave)));

//science
$sci_total = array_sum($sci_grades);
$sci_ave = $sci_total / count($sci_grades);
$pdf->SetXY(90, 67);
$pdf->MultiCell(60, 15, transmute_grade($sci_ave));
$pdf->SetXY(102, 67);
$pdf->MultiCell(60, 15, status(transmute_grade($sci_ave)));

//araling panlipunan
$ap_total = array_sum($ap_grades);
$ap_ave = $ap_total / count($ap_grades);
$pdf->SetXY(90, 73);
$pdf->MultiCell(60, 15, transmute_grade($ap_ave));
$pdf->SetXY(102, 73);
$pdf->MultiCell(60, 15, status(transmute_grade($ap_ave)));

//Edukasyon sa Pagpapakatao
$esp_total = array_sum($esp_grades);
$esp_ave = $esp_total / count($esp_grades);
$pdf->SetXY(90, 83);
$pdf->MultiCell(60, 15, transmute_grade($esp_ave));
$pdf->SetXY(102, 83);
$pdf->MultiCell(60, 15, status(transmute_grade($esp_ave)));

//tle
$tle_total = array_sum($tle_grades);
$tle_ave = $tle_total / count($tle_grades);
$pdf->SetXY(90, 95);
$pdf->MultiCell(60, 15, transmute_grade($tle_ave));
$pdf->SetXY(102, 95);
$pdf->MultiCell(60, 15, status(transmute_grade($tle_ave)));

//mapeh/quarter 1
$mq1_total = array_sum($mq1_grades);
$mq1_ave = $mq1_total / count($mq1_grades);
$pdf->SetXY(50, 103);
$pdf->MultiCell(60, 15, $mq1_ave);

//mapeh/quarter 2
$mq2_total = array_sum($mq2_grades);
$mq2_ave = $mq2_total / count($mq2_grades);
$pdf->SetXY(60, 103);
$pdf->MultiCell(60, 15, ($mq2_ave));

//mapeh/quarter 3
$mq3_total = array_sum($mq3_grades);
$mq3_ave = $mq3_total / count($mq3_grades);
$pdf->SetXY(69, 103);
$pdf->MultiCell(60, 15, $mq3_ave);

//mapeh/quarter 4
$mq4_total = array_sum($mq4_grades);
$mq4_ave = $mq4_total / count($mq4_grades);
$pdf->SetXY(79, 103);
$pdf->MultiCell(60, 15, $mq4_ave);

//mapeh/final?
$mapeh_final = $mq1_ave + $mq2_ave + $mq3_ave + $mq4_ave;
$pdf->SetXY(90, 103);
$pdf->MultiCell(60, 15, ceil($mapeh_final / 4));
$pdf->SetXY(102, 103);
$pdf->MultiCell(60, 15, status($mapeh_final / 4));

//General Average
$general_ave = (transmute_grade($filipino_ave) + transmute_grade($english_ave) + transmute_grade($math_ave) + transmute_grade($sci_ave) + transmute_grade($ap_ave) + transmute_grade($esp_ave) + transmute_grade($tle_ave)) / 7;
$pdf->SetXY(90, 140);
$pdf->MultiCell(60, 15, ceil($general_ave));



// Output the PDF inline in the browser
ob_end_clean(); // Clean the output buffer
$pdf->Output("I", "preview.pdf");

// Close the database connection
$conn->close();

?>
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

$sql_attendance = "SELECT * FROM students WHERE is_archived = 0 AND student_id = '$student_id' ORDER BY student_id asc";

$sql_attendance = "SELECT s.*, sec.*
                    FROM students s
                    INNER JOIN section sec ON s.section_id = sec.section_id
                    WHERE s.student_id = '$student_id' and s.is_archived = 0;";
$data_attendance = mysqli_query($conn, $sql_attendance);

// Check for errors in the attendance query
if (!$data_attendance) {
    die("SQL Error for attendance: " . mysqli_error($conn));
}

// Fetching for grades
$sql_grades = "SELECT s.*, ROUND(fg.final_grade) as final_grade
              FROM students s
              INNER JOIN final_grades fg ON s.student_id = fg.student_id
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

    $pdf->SetXY(140, 127);
    $pdf->MultiCell(120, 2, $row['email']);

    $pdf->SetXY(200, 127);
    $pdf->MultiCell(120, 2, $row['gender']);

    $pdf->SetXY(150, 136);
    $pdf->MultiCell(120, 2, $row['grade_level']);

    $pdf->SetXY(190, 136);
    $pdf->MultiCell(120, 2, $row['section_name']);

    
   
}

// Grade PDF
$pdf->setSourceFile("Grades_and_morals.pdf");
$template2 = $pdf->importPage(1);
$pdf->AddPage('L');
$pdf->useTemplate($template2);
$pdf->SetXY(50, 50);


while ($row = mysqli_fetch_assoc($data_grades)) {
    $pdf->SetFont("Arial", "", 10);
    $pdf->SetXY(50, $y);
    $pdf->MultiCell(180, 116, $row['final_grade'] );
    $y += 6; // increment Y position for each grade

}

// Output the PDF inline in the browser
ob_end_clean(); // Clean the output buffer
$pdf->Output("I", "preview.pdf");

// Close the database connection
$conn->close();

?>

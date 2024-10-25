<?php
ob_start(); // Start output buffering to prevent premature output

session_start();
include '../../connection/connection.php';
require '../../../vendor/autoload.php'; // PhpSpreadsheet autoload

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

$spreadsheet = new Spreadsheet();
$schoolYearsQuery = "SELECT DISTINCT school_year FROM section ORDER BY school_year DESC";
$schoolYearsResult = $conn->query($schoolYearsQuery);

while ($row = $schoolYearsResult->fetch_assoc()) {
    $schoolYear = $row['school_year'];

    // Add a new sheet for each school year
    $sheet = $spreadsheet->createSheet();
    $sheet->setTitle($schoolYear);

    // Fetch students for the current school year
    $studentsQuery = "SELECT students.*, section.section_name, section.grade_level
                      FROM students 
                      JOIN section ON students.section_ID = section.section_id 
                      WHERE section.school_year = '$schoolYear'";
    $studentsResult = $conn->query($studentsQuery);

    // Set headers for the sheet
    $sheet->setCellValue('A1', 'LRN')
        ->setCellValue('B1', 'First Name')
        ->setCellValue('C1', 'Last Name')
        ->setCellValue('D1', 'Parent E-mail')
        ->setCellValue('E1', 'Gender')
        ->setCellValue('F1', 'AKAP Status')
        ->setCellValue('G1', 'Section Name')
        ->setCellValue('H1', 'Grade Level');

    // Populate the sheet with student data and apply colors for AKAP status
    $rowIndex = 2;
    while ($student = $studentsResult->fetch_assoc()) {
        $akapStatus = $student['akap_status'];
        $sheet->setCellValue('A' . $rowIndex, $student['LRN'])
            ->setCellValue('B' . $rowIndex, $student['first_name'])
            ->setCellValue('C' . $rowIndex, $student['last_name'])
            ->setCellValue('D' . $rowIndex, $student['email'])
            ->setCellValue('E' . $rowIndex, $student['gender'])
            ->setCellValue('F' . $rowIndex, $akapStatus)
            ->setCellValue('G' . $rowIndex, $student['section_name'])
            ->setCellValue('H' . $rowIndex, $student['grade_level']);

        // Apply color based on AKAP status
        $akapCell = $sheet->getStyle('F' . $rowIndex);
        if ($akapStatus === 'Active') {
            $akapCell->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB(Color::COLOR_RED);
        } elseif ($akapStatus === 'Solved') {
            $akapCell->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB(Color::COLOR_GREEN);
        }
        $rowIndex++;
    }
}

// Set the first sheet as active
$spreadsheet->setActiveSheetIndex(0);

// Remove the first empty sheet if there are more than one
if ($spreadsheet->getSheetCount() > 1) {
    $spreadsheet->removeSheetByIndex(0);
}

// Clear any output buffer before sending the file to prevent corruption
ob_end_clean();

// Create the Excel file
$writer = new Xlsx($spreadsheet);
$filename = "All_Students.xlsx";

// Send the file to the browser for download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"$filename\"");
header('Cache-Control: max-age=0');

$writer->save('php://output');
exit();
?>
<?php
include '../../connection/connection.php';

// Get the selected school year from the AJAX request
$school_year = isset($_GET['school_year']) ? $_GET['school_year'] : '';

// Query to get AKAP status data for the selected school year
$query_akap_status = "SELECT akap_status, COUNT(*) as count 
                      FROM students
                      JOIN section ON students.section_ID = section.section_id
                      WHERE section.school_year = '$school_year'
                      GROUP BY akap_status";
$result_akap_status = $conn->query($query_akap_status);
$akap_status_data = [];
while ($row = $result_akap_status->fetch_assoc()) {
    $akap_status_data[] = $row;
}

// Query to get gender data for the selected school year
$query_gender = "SELECT gender, COUNT(*) as count 
                 FROM students
                 JOIN section ON students.section_ID = section.section_id
                 WHERE section.school_year = '$school_year'
                 GROUP BY gender";
$result_gender = $conn->query($query_gender);
$gender_data = [];
while ($row = $result_gender->fetch_assoc()) {
    $gender_data[] = $row;
}

// Query to get AKAP cases ("Active" and "Solved") for each school year
$query_akap_cases = "SELECT section.school_year, COUNT(*) as count 
                     FROM students
                     JOIN section ON students.section_ID = section.section_id
                     WHERE akap_status IN ('Active', 'Solved')
                     GROUP BY section.school_year
                     ORDER BY section.school_year ASC";
$result_akap_cases = $conn->query($query_akap_cases);
$akap_cases_data = [];
while ($row = $result_akap_cases->fetch_assoc()) {
    $akap_cases_data[] = $row;
}

// Prepare the data to return as JSON
$response = [
    'akapStatusLabels' => array_column($akap_status_data, 'akap_status'),
    'akapStatusCounts' => array_column($akap_status_data, 'count'),
    'genderLabels' => array_column($gender_data, 'gender'),
    'genderCounts' => array_column($gender_data, 'count'),
    'akapCasesLabels' => array_column($akap_cases_data, 'school_year'),
    'akapCasesCounts' => array_column($akap_cases_data, 'count')
];

// Return the JSON response
echo json_encode($response);

$conn->close();
?>
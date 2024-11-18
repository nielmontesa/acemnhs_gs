<?php
// Autoload Composer dependencies
set_time_limit(1000);
require_once 'vendor/autoload.php';  // Composer's autoload file

// Database connection
$mysqli = new mysqli("localhost", "root", "", "esguerradb");  // Adjust as needed

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Faker instance
$faker = Faker\Factory::create();

// Subjects for each gradesheet
$subjects = [
    'Filipino',
    'English',
    'Mathematics',
    'Science',
    'Araling Panlipunan',
    'Edukasyon sa Pagpapakatao',
    'TLE',
    'Music',
    'Arts',
    'PE',
    'Health'
];

// Function to get existing departments
function getDepartments($mysqli)
{
    $departments = [];
    $result = $mysqli->query("SELECT department_id FROM department");  // Assuming the department_id is stored in the 'attendance' table

    while ($row = $result->fetch_assoc()) {
        $departments[] = $row['department_id'];
    }

    return $departments;
}

// Function to insert teachers with department linking
function insertTeachers($mysqli, $departments)
{
    global $faker;
    $teacher_ids = [];

    for ($i = 1; $i <= 40; $i++) {  // Assuming we need 40 teachers for 40 sections
        $first_name = $mysqli->real_escape_string($faker->firstName);
        $last_name = $mysqli->real_escape_string($faker->lastName);
        $username = str_pad(rand(0, 99999999), 8, '0', STR_PAD_LEFT);  // Generate 8-digit random number
        $email = $mysqli->real_escape_string($faker->email);
        $password = password_hash('password123', PASSWORD_DEFAULT);  // Default password
        $department_id = $departments[array_rand($departments)];  // Randomly assign a department

        $mysqli->query("INSERT INTO teachers (username, password, first_name, last_name, email, department_id) 
                        VALUES ('$username', '$password', '$first_name', '$last_name', '$email', '$department_id')");
        $teacher_ids[] = $mysqli->insert_id;  // Store the teacher IDs for assigning as advisers
    }

    return $teacher_ids;
}


// Function to insert sections and students
function insertSections($grade_level, $teachers, $mysqli)
{
    global $faker;
    global $subjects;

    for ($i = 1; $i <= 5; $i++) {  // 5 sections per grade level
        $section_name = "Section " . $i;
        $school_year = "2020-2021";
        $adviser_id = $teachers[array_rand($teachers)];  // Randomly assign a teacher as adviser
        $is_archived = 1;  // Set the archived status to 1

        // Insert section with adviser and is_archived field
        $mysqli->query("INSERT INTO section (grade_level, section_name, school_year, adviser_id, is_archived) 
                        VALUES ('$grade_level', '$section_name', '$school_year', '$adviser_id', '$is_archived')");
        $section_id = $mysqli->insert_id;  // Get the section ID

        // Insert students for this section
        insertStudents($section_id, $mysqli);

        // Insert gradesheet and activities for all 4 quarters
        insertGradesheet($section_id, $mysqli);
    }
}


// Function to insert students
// Add random akap_status to each student
$akap_statuses = ['Inactive', 'Active', 'Solved'];  // Possible values for akap_status

// Function to insert students (with akap_status)
function insertStudents($section_id, $mysqli)
{
    global $faker;
    global $akap_statuses;

    for ($j = 1; $j <= 10; $j++) {  // 50 students per section
        $first_name = $mysqli->real_escape_string($faker->firstName);
        $last_name = $mysqli->real_escape_string($faker->lastName);
        $email = $mysqli->real_escape_string($faker->email);
        $gender = $mysqli->real_escape_string($faker->randomElement(['Male', 'Female']));
        $LRN = $faker->numerify('###########');  // Generate a 12-digit LRN
        $akap_status = $akap_statuses[array_rand($akap_statuses)];  // Randomly select akap_status

        // Insert student with akap_status
        $mysqli->query("INSERT INTO students (first_name, last_name, section_ID, email, gender, LRN, akap_status) 
                        VALUES ('$first_name', '$last_name', '$section_id', '$email', '$gender', '$LRN', '$akap_status')");
    }
}


// Function to insert gradesheets and activities (for all quarters)
function insertGradesheet($section_id, $mysqli)
{
    global $subjects;  // Use the predefined subjects

    foreach ($subjects as $subject) {
        $subject = $mysqli->real_escape_string($subject);
        $mysqli->query("INSERT INTO gradesheet (section_id, subject) VALUES ('$section_id', '$subject')");
        $gradesheet_id = $mysqli->insert_id;  // Get the gradesheet ID

        // Insert activities for this gradesheet across 4 quarters
        for ($quarter = 1; $quarter <= 4; $quarter++) {
            insertActivities($gradesheet_id, $quarter, $mysqli);
        }
    }
}

// Function to insert activities into the gradesheet (for each quarter)
function insertActivities($gradesheet_id, $quarter, $mysqli)
{
    global $faker;
    $activities = [
        ['name' => 'Assignment', 'type' => 'Written Work', 'score' => 50],
        ['name' => 'Exercise', 'type' => 'Performance Task', 'score' => 50],
        ['name' => 'Exam', 'type' => 'Quarterly Assessment', 'score' => 100]
    ];

    foreach ($activities as $activity) {
        $activity_name = $mysqli->real_escape_string($activity['name'] . ' ' . $faker->numerify('#'));
        $total_score = $activity['score'];
        $activity_type = $mysqli->real_escape_string($activity['type']);

        // Insert the activity, linked to the quarter
        $mysqli->query("INSERT INTO activity (gradesheet_id, activity_name, total_score, activity_type, quarter) 
                        VALUES ('$gradesheet_id', '$activity_name', '$total_score', '$activity_type', '$quarter')");
        $activity_id = $mysqli->insert_id;  // Get the activity ID

        // Insert scores for each student in the section
        insertStudentScores($gradesheet_id, $activity_id, $total_score, $mysqli);
    }
}

// Function to insert scores for each student (ensure score <= total score)
function insertStudentScores($gradesheet_id, $activity_id, $total_score, $mysqli)
{
    $result = $mysqli->query("SELECT student_id FROM students WHERE section_ID = (SELECT section_id FROM gradesheet WHERE gradesheet_id = '$gradesheet_id')");

    global $faker;
    while ($row = $result->fetch_assoc()) {
        $student_id = $row['student_id'];
        $score = $faker->numberBetween(0, $total_score);  // Random score between 0 and the activity's total score

        $mysqli->query("INSERT INTO student_activity_score (student_id, activity_id, score) 
                        VALUES ('$student_id', '$activity_id', '$score')");
    }
}

// Get existing departments
$departments = getDepartments($mysqli);

// Insert teachers (advisers) and link to departments
$teachers = insertTeachers($mysqli, $departments);  // Get the list of teachers to assign as advisers

// Insert sections, students, gradesheets, activities, and scores for grades 7 to 10
for ($grade_level = 7; $grade_level <= 10; $grade_level++) {
    insertSections($grade_level, $teachers, $mysqli);
}

echo "Dummy data inserted successfully!";
?>
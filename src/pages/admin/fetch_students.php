<?php
session_start();
include '../../connection/connection.php';

// Fetch all students initially (or based on the selected school year via AJAX)
$selectedSchoolYear = isset($_GET['school_year']) ? $_GET['school_year'] : null;

if ($selectedSchoolYear) {
    // Fetch students for the selected school year, regardless of whether the section is archived
    $studentsQuery = "SELECT students.*, section.section_name, section.grade_level, section.is_archived 
                      FROM students 
                      JOIN section ON students.section_ID = section.section_id 
                      WHERE section.school_year = '$selectedSchoolYear' 
                      ORDER BY 
                        CASE WHEN students.gender = 'Male' THEN 1 ELSE 2 END, 
                        students.last_name ASC";
} else {
    // Fetch all students (both archived and non-archived)
    $studentsQuery = "SELECT students.*, section.section_name, section.grade_level, section.is_archived 
                      FROM students 
                      JOIN section ON students.section_ID = section.section_id 
                      ORDER BY 
                        CASE WHEN students.gender = 'Male' THEN 1 ELSE 2 END, 
                        students.last_name ASC";
}

$studentsResult = $conn->query($studentsQuery);
?>

<?php if ($studentsResult->num_rows > 0): ?>
    <?php
    $male_counter = 1;
    $female_counter = 1;
    $current_gender = 'Male';

    while ($student = $studentsResult->fetch_assoc()):
        $drawer_id = "drawer-all-" . $student['student_id'];

        // Reset counter when switching from male to female or vice versa
        if ($student['gender'] !== $current_gender) {
            $current_gender = $student['gender'];
            if ($current_gender == 'Male') {
                $male_counter = 1;
            } else {
                $female_counter = 1;
            }
        }
        ?>
        <tr>
            <th>
                <?php
                if ($student['gender'] == 'Male') {
                    echo $male_counter++;
                } else {
                    echo $female_counter++;
                }
                ?>
            </th>
            <th><?php echo $student['LRN']; ?></th>
            <th><?php echo $student['first_name']; ?></th>
            <td><?php echo $student['last_name']; ?></td>
            <td><?php echo $student['email']; ?></td>
            <td><?php echo $student['gender']; ?></td>
            <td><?php echo $student['akap_status']; ?></td>
            <td><?php echo $student['section_name']; ?></td>
            <td><?php echo $student['grade_level']; ?></td>
            <td><?php echo $student['is_archived'] ? 'Archived' : 'Active'; ?></td>
            <td>
                <a href="report_card.php?student_id=<?php echo $student['student_id']; ?>" class="btn btn-outline-primary">View
                    Report Card</a>
            </td>
        </tr>
    <?php endwhile; ?>
<?php else: ?>
    <tr>
        <td colspan="11" class="text-center">No students found.</td>
    </tr>
<?php endif; ?>
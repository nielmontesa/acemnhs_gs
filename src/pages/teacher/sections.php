<?php
session_start();
include '../../connection/connection.php';

// Function to get the next school year (e.g., 2024-2025 -> 2025-2026)
function getNextSchoolYear($currentSchoolYear)
{
    // Split the current year into start and end year (e.g., 2024 and 2025)
    list($startYear, $endYear) = explode('-', $currentSchoolYear);

    // Increment both years
    $nextStartYear = (int) $startYear + 1;
    $nextEndYear = (int) $endYear + 1;

    // Return the new school year in the format YYYY-YYYY
    return "$nextStartYear-$nextEndYear";
}

// Function to detect the current active school year from non-archived sections
function getCurrentSchoolYear($conn)
{
    // Query to get the latest school year from non-archived sections
    $query = "SELECT school_year FROM section WHERE is_archived = 0 ORDER BY school_year DESC LIMIT 1";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['school_year'];
    } else {
        die("No active sections found to determine the current school year.");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['finish_year'])) {
    // Start the Finish School Year Process
    $conn->begin_transaction();

    try {
        // Dynamically detect the current school year from active sections
        $currentSchoolYear = getCurrentSchoolYear($conn);

        // 1. Archive Grade 10 sections and their students
        $archiveGrade10Sections = "UPDATE section SET is_archived = 1 WHERE grade_level = 10 AND school_year = ?";
        $stmtArchiveGrade10Sections = $conn->prepare($archiveGrade10Sections);
        $stmtArchiveGrade10Sections->bind_param("s", $currentSchoolYear);
        $stmtArchiveGrade10Sections->execute();

        $archiveGrade10Students = "UPDATE students SET is_archived = 1 WHERE section_ID IN 
                                   (SELECT section_id FROM section WHERE grade_level = 10 AND school_year = ?)";
        $stmtArchiveGrade10Students = $conn->prepare($archiveGrade10Students);
        $stmtArchiveGrade10Students->bind_param("s", $currentSchoolYear);
        $stmtArchiveGrade10Students->execute();

        // 2. Promote sections (Grade 7 -> 8, Grade 8 -> 9, Grade 9 -> 10) for sections in the current school year only
        $sectionsToPromote = "SELECT section_id, section_name, grade_level, school_year, adviser_id 
                              FROM section WHERE grade_level IN (7, 8, 9) AND school_year = ?";
        $stmtSectionsToPromote = $conn->prepare($sectionsToPromote);
        $stmtSectionsToPromote->bind_param("s", $currentSchoolYear);
        $stmtSectionsToPromote->execute();
        $sectionsResult = $stmtSectionsToPromote->get_result();

        // Prepare statement for inserting promoted sections and copying students
        $insertSectionQuery = "INSERT INTO section (section_name, grade_level, school_year, adviser_id) 
                               VALUES (?, ?, ?, ?)";
        $stmtInsertSection = $conn->prepare($insertSectionQuery);

        $insertStudentQuery = "INSERT INTO students (LRN, first_name, last_name, email, gender, akap_status, section_ID)
                               SELECT LRN, first_name, last_name, email, gender, akap_status, ? 
                               FROM students WHERE section_ID = ? AND is_archived = 0";
        $stmtInsertStudent = $conn->prepare($insertStudentQuery);

        while ($section = $sectionsResult->fetch_assoc()) {
            $oldSectionId = $section['section_id'];
            $newGradeLevel = $section['grade_level'] + 1;

            // Get the next school year for the promoted section
            $newSchoolYear = getNextSchoolYear($section['school_year']);

            // Insert the promoted section (create a new section with next grade level and next school year)
            $stmtInsertSection->bind_param("sisi", $section['section_name'], $newGradeLevel, $newSchoolYear, $section['adviser_id']);
            $stmtInsertSection->execute();

            // Get the ID of the newly inserted section (promoted)
            $newSectionId = $conn->insert_id;

            // Copy students from the old section to the new promoted section
            $stmtInsertStudent->bind_param("ii", $newSectionId, $oldSectionId);
            $stmtInsertStudent->execute();

            // Archive the old section and its students
            $archiveOldSection = "UPDATE section SET is_archived = 1 WHERE section_id = $oldSectionId";
            $conn->query($archiveOldSection);

            $archiveOldStudents = "UPDATE students SET is_archived = 1 WHERE section_ID = $oldSectionId";
            $conn->query($archiveOldStudents);
        }

        // 3. Add new gradesheets for the promoted sections
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

        $newSectionsQuery = "SELECT section_id FROM section WHERE grade_level IN (8, 9, 10) AND school_year = ?";
        $stmtNewSections = $conn->prepare($newSectionsQuery);
        $stmtNewSections->bind_param("s", $newSchoolYear);
        $stmtNewSections->execute();
        $newSectionsResult = $stmtNewSections->get_result();

        $insertGradesheetQuery = "INSERT INTO gradesheet (section_id, subject) VALUES (?, ?)";
        $stmtInsertGradesheet = $conn->prepare($insertGradesheetQuery);

        while ($newSection = $newSectionsResult->fetch_assoc()) {
            $section_id = $newSection['section_id'];

            // Insert gradesheets for each subject for this new section
            foreach ($subjects as $subject) {
                $stmtInsertGradesheet->bind_param("is", $section_id, $subject);
                $stmtInsertGradesheet->execute();
            }
        }

        // Commit transaction
        $conn->commit();
    } catch (Exception $e) {
        // Rollback in case of any failure
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
}
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
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const radioButtons = document.querySelectorAll('input[name="options"]');
            const sections = document.querySelectorAll('#grade-sections > div');

            radioButtons.forEach(radio => {
                radio.addEventListener('change', () => {
                    const selectedGrade = radio.value;
                    sections.forEach(section => {
                        if (section.getAttribute('data-grade') === selectedGrade) {
                            section.style.display = 'block';
                        } else {
                            section.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>
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
                        <section class="menu-section px-4">
                            <span class="menu-title">Welcome, <?php echo $_SESSION['username']; ?></span>
                            <ul class="menu-items">
                                <a href="sections.php">
                                    <li class="menu-item menu-active">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-75" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        <span>Students</span>
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

            <h1 class="text-xl font-bold">Sections</h1>
            <p class="pt-2">This is currently all of the sections in the school.</p>

            <div class="flex justify-between items-center mt-4" style="justify-content: space-between;">
                <div class="flex gap-2">
                    <form action="../../connection/add_section.php" method="POST" class="hidden">
                        <input type="checkbox" id="drawer-right" class="drawer-toggle" />
                        <label for="drawer-right" class="btn btn-primary">Add Section</label>
                        <label class="overlay" for="drawer-right"></label>
                        <div class="drawer drawer-right">
                            <div class="drawer-content pt-10 flex flex-col h-full">
                                <label for="drawer-right"
                                    class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</label>
                                <div>
                                    <h2 class="text-xl font-medium">Add Section</h2>
                                    <label for="sectionname">
                                        <span class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Section
                                            Name</span>
                                        <input class="input-block input" placeholder="Enter section name"
                                            name="sectionname" type="text" required />
                                    </label>
                                    <label for="gradelevel">
                                        <span class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Grade
                                            Level</span>
                                        <select class="input-block input" name="gradelevel" required>
                                            <option value="" disabled selected>Select grade level</option>
                                            <option value="7">Grade 7</option>
                                            <option value="8">Grade 8</option>
                                            <option value="9">Grade 9</option>
                                            <option value="10">Grade 10</option>
                                        </select>
                                    </label>
                                    <label for="schoolyear">
                                        <span class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">School
                                            Year</span>
                                        <div class="flex gap-2 items-center justify-center">
                                            <input class="input" maxlength="4" placeholder="Start Year"
                                                name="startyear" />
                                            <span> to </span>
                                            <input class="input" maxlength="4" placeholder="End Year" name="endyear" />
                                        </div>
                                    </label>
                                    <label for="advisername">
                                        <span class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Adviser
                                            Name</span>
                                        <select class="input-block input" name="advisername" required>
                                            <option value="" disabled selected>Select adviser</option>
                                            <?php
                                            // Query the 'teachers' table
                                            $sql = "SELECT teacher_id, first_name, last_name FROM teachers";
                                            $result = $conn->query($sql);

                                            // Loop through results and generate options
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo '<option value="' . $row["teacher_id"] . '">' . $row["first_name"] . ' ' . $row["last_name"] . '</option>';
                                                }
                                            } else {
                                                echo '<option value="" disabled>No advisers found</option>';
                                            }
                                            ?>
                                        </select>
                                    </label>
                                </div>
                                <div class="h-full flex flex-row justify-end items-end gap-2">
                                    <button type="reset" class="btn btn-ghost">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Create</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="flex gap-4 items-center">
                    <span class="text-sm">Filter Grade Level:</span>
                    <form>
                        <div class="btn-group">
                            <input type="radio" name="options" value="Grade 7" data-content="Grade 7"
                                class="btn bg-[rgba(0,0,0,0.02)]" checked />
                            <input type="radio" name="options" value="Grade 8" data-content="Grade 8"
                                class="btn bg-[rgba(0,0,0,0.02)]" />
                            <input type="radio" name="options" value="Grade 9" data-content="Grade 9"
                                class="btn bg-[rgba(0,0,0,0.02)]" />
                            <input type="radio" name="options" value="Grade 10" data-content="Grade 10"
                                class="btn bg-[rgba(0,0,0,0.02)]" />
                        </div>
                    </form>
                </div>
            </div>
            <div id="grade-sections">
                <div class="flex w-full overflow-x-auto pt-8" data-grade="Grade 7">
                    <table class="table-compact table-zebra table w-full">
                        <thead>
                            <tr>
                                <th>Grade Level</th>
                                <th>Section Name</th>
                                <th>School Year</th>
                                <th>Adviser Name</th>
                                <th>Student Count</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Assuming you have a valid database connection in $connection
                            $sql = "SELECT 
                                    section.*, 
                                    teachers.first_name, 
                                    teachers.last_name,
                                    COUNT(students.student_id) AS student_count
                                FROM 
                                    section
                                JOIN 
                                    teachers ON section.adviser_id = teachers.teacher_id
                                LEFT JOIN 
                                    students ON section.section_id = students.section_ID AND students.is_archived = 0
                                WHERE 
                                    section.grade_level = 7 AND section.is_archived = 0
                                GROUP BY 
                                    section.section_id, teachers.first_name, teachers.last_name";
                            $result = $conn->query($sql);



                            if ($result->num_rows > 0):
                                ?>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $row['grade_level']; ?></td>
                                        <th><?php echo $row['section_name']; ?></th>
                                        <td><?php echo $row['school_year']; ?></td>
                                        <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                                        <td><?php echo $row['student_count']; ?></td>
                                        <td>
                                            <a href="students.php?section_id=<?php echo $row['section_id']; ?>">
                                                <button class="btn btn-secondary">View</button>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">No sections found for Grade 7.</td>
                        </tr>
                    <?php endif; ?>
                    </table>
                </div>
                <div class="hidden w-full overflow-x-auto pt-8" data-grade="Grade 8">
                    <table class="table-compact table-zebra table w-full">
                        <thead>
                            <tr>
                                <th>Grade Level</th>
                                <th>Section Name</th>
                                <th>School Year</th>
                                <th>Adviser Name</th>
                                <th>Student Count</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Assuming you have a valid database connection in $connection
                            $sql = "SELECT 
                                    section.*, 
                                    teachers.first_name, 
                                    teachers.last_name,
                                    COUNT(students.student_id) AS student_count
                                FROM 
                                    section
                                JOIN 
                                    teachers ON section.adviser_id = teachers.teacher_id
                                LEFT JOIN 
                                    students ON section.section_id = students.section_ID AND students.is_archived = 0
                                WHERE 
                                    section.grade_level = 8 AND section.is_archived = 0
                                GROUP BY 
                                    section.section_id, teachers.first_name, teachers.last_name";
                            $result = $conn->query($sql);



                            if ($result->num_rows > 0):
                                ?>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $row['grade_level']; ?></td>
                                        <th><?php echo $row['section_name']; ?></th>
                                        <td><?php echo $row['school_year']; ?></td>
                                        <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                                        <td><?php echo $row['student_count']; ?></td>
                                        <td>
                                            <a href="students.php?section_id=<?php echo $row['section_id']; ?>">
                                                <button class="btn btn-secondary">View</button>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">No sections found for Grade 8.</td>
                        </tr>
                    <?php endif; ?>
                    </table>
                </div>
                <div class="hidden w-full overflow-x-auto pt-8" data-grade="Grade 9">
                    <table class="table-compact table-zebra table w-full">
                        <thead>
                            <tr>
                                <th>Grade Level</th>
                                <th>Section Name</th>
                                <th>School Year</th>
                                <th>Adviser Name</th>
                                <th>Student Count</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Assuming you have a valid database connection in $connection
                            $sql = "SELECT 
                                    section.*, 
                                    teachers.first_name, 
                                    teachers.last_name,
                                    COUNT(students.student_id) AS student_count
                                FROM 
                                    section
                                JOIN 
                                    teachers ON section.adviser_id = teachers.teacher_id
                                LEFT JOIN 
                                    students ON section.section_id = students.section_ID AND students.is_archived = 0
                                WHERE 
                                    section.grade_level = 9 AND section.is_archived = 0
                                GROUP BY 
                                    section.section_id, teachers.first_name, teachers.last_name";
                            $result = $conn->query($sql);



                            if ($result->num_rows > 0):
                                ?>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $row['grade_level']; ?></td>
                                        <th><?php echo $row['section_name']; ?></th>
                                        <td><?php echo $row['school_year']; ?></td>
                                        <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                                        <td><?php echo $row['student_count']; ?></td>
                                        <td>
                                            <a href="students.php?section_id=<?php echo $row['section_id']; ?>">
                                                <button class="btn btn-secondary">View</button>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">No sections found for Grade 9.</td>
                        </tr>
                    <?php endif; ?>
                    </table>
                </div>
                <div class="hidden w-full overflow-x-auto pt-8" data-grade="Grade 10">
                    <table class="table-compact table-zebra table w-full">
                        <thead>
                            <tr>
                                <th>Grade Level</th>
                                <th>Section Name</th>
                                <th>School Year</th>
                                <th>Adviser Name</th>
                                <th>Student Count</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Assuming you have a valid database connection in $connection
                            $sql = "SELECT 
                                    section.*, 
                                    teachers.first_name, 
                                    teachers.last_name,
                                    COUNT(students.student_id) AS student_count
                                FROM 
                                    section
                                JOIN 
                                    teachers ON section.adviser_id = teachers.teacher_id
                                LEFT JOIN 
                                    students ON section.section_id = students.section_ID AND students.is_archived = 0
                                WHERE 
                                    section.grade_level = 10 AND section.is_archived = 0
                                GROUP BY 
                                    section.section_id, teachers.first_name, teachers.last_name";
                            $result = $conn->query($sql);



                            if ($result->num_rows > 0):
                                ?>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $row['grade_level']; ?></td>
                                        <th><?php echo $row['section_name']; ?></th>
                                        <td><?php echo $row['school_year']; ?></td>
                                        <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                                        <td><?php echo $row['student_count']; ?></td>
                                        <td>
                                            <a href="students.php?section_id=<?php echo $row['section_id']; ?>">
                                                <button class="btn btn-secondary">View</button>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">No sections found for Grade 10.</td>
                        </tr>
                    <?php endif; ?>
                    </table>
                </div>
            </div>

        </main>
    </div>

</body>

</html>
<?php
// Include your database connection
// Include your database connection
session_start();
include '../../connection/connection.php';

// Get the section ID from the URL
$section_id = $_GET['section_id'] ?? null;

// Check if section ID is available
if ($section_id === null) {
    die('Error: Section ID is missing.');
}

// Query to check if all gradesheets are finalized
$sql = "SELECT COUNT(*) AS total, SUM(is_finalized) AS finalized_count FROM gradesheet WHERE section_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $section_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$total_gradesheets = $row['total'];
$finalized_count = $row['finalized_count'];

$stmt->close();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $student_lrn = $_POST['studentlrn'];
    $student_firstname = $_POST['studentfirstname'];
    $student_lastname = $_POST['studentlastname'];
    $parent_email = $_POST['email'];
    $gender = $_POST['gender'];
    $akap_status = $_POST['akap_status']; // Get the Akap Status from the form
    $birthday = $_POST['bday']; // Get the birthday from the form
    unset($_SESSION['section_id']);
    unset($_SESSION['gradesheet_id']);

    // SQL query to insert student data, including the birthday, section ID, and Akap Status
    $sql = "INSERT INTO students (LRN, first_name, last_name, email, gender, akap_status, bday, section_id)
            VALUES ('$student_lrn', '$student_firstname', '$student_lastname', '$parent_email', '$gender', '$akap_status', '$birthday', '$section_id')";

    if ($conn->query($sql) === TRUE) {
        echo "New student added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


// Check if section_id is set in the URL
if (isset($_GET['section_id'])) {
    $section_id = $conn->real_escape_string($_GET['section_id']);

    // SQL query to fetch existing section data
    $sql = "SELECT section_name, grade_level, school_year, adviser_id FROM section WHERE section_id='$section_id'";
    $result = $conn->query($sql);

    // Check if section data exists
    if ($result->num_rows > 0) {
        $section = $result->fetch_assoc();
    } else {
        // Handle the case where no section data is found
        die("No section found with the given ID.");
    }
} else {
    // Handle the case where section_id is not set
    die("No section ID specified.");
}

// Fetch the adviser_id from the sections table
$section_sql = "SELECT adviser_id FROM section WHERE section_ID = '$section_id'";
$section_result = $conn->query($section_sql);

if ($section_result && $section_result->num_rows > 0) {
    $section_row = $section_result->fetch_assoc();
    $adviser_id = $section_row['adviser_id']; // Get the adviser ID
} else {
    echo "Section not found.";
    exit();
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
                                <a href="departments.php">
                                    <li class="menu-item">
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
                                    <li class="menu-item menu-active">
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
                                    <img src="../../assets/avatar.svg" alt="avatar" />
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


            <h1 class="text-xl font-bold">
                <?php

                if (isset($_GET['section_id'])) {
                    $section_id = $_GET['section_id'];
                    $section_details_query = "SELECT section_name, grade_level, section_id FROM section WHERE section_id = $section_id";
                    $result = $conn->query($section_details_query);

                    if ($result->num_rows > 0) {
                        // Fetch the result as an associative array and display section_name
                        while ($row = $result->fetch_assoc()) {
                            echo "Grade ";
                            echo $row['grade_level'];
                            echo " - ";
                            echo $row['section_name']; // Output each section name
                        }
                    } else {
                        echo "No sections found.";
                    }
                }
                ?>
            </h1>
            <p class='pt-2'>This is currently all of the students in

                <?php
                if (isset($_GET['section_id'])) {
                    $section_id = $_GET['section_id'];
                    $section_details_query = "SELECT section_name, grade_level, section_id FROM section WHERE section_id = $section_id";
                    $result = $conn->query($section_details_query);

                    if ($result->num_rows > 0) {
                        // Fetch the result as an associative array and display section_name
                        while ($row = $result->fetch_assoc()) {
                            echo "Grade ";
                            echo $row['grade_level'];
                            echo " - ";
                            echo $row['section_name']; // Output each section name
                        }
                    } else {
                        echo "No sections found.";
                    }
                }
                ?>.
            </p>

            <div class="flex justify-between items-center mt-4" style="justify-content: space-between;">
                <div class=" flex gap-2 items-center">
                    <form method="POST">
                        <input type="checkbox" id="drawer-right" class="drawer-toggle" />
                        <label for="drawer-right" class="btn btn-primary">Add Student</label>
                        <label class="overlay" for="drawer-right"></label>
                        <div class="drawer drawer-right">
                            <div class="drawer-content pt-10 flex flex-col h-full">
                                <label for="drawer-right"
                                    class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</label>
                                <div>
                                    <h2 class="text-xl font-medium">Add Student</h2>
                                    <label for="studentlrn">
                                        <span class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">LRN</span>
                                        <input class="input-block input" placeholder="Please enter the LRN."
                                            name="studentlrn" type="text" maxlength="12" required />
                                    </label>
                                    <label for="studentfirstname">
                                        <span class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Student First
                                            Name</span>
                                        <input class="input-block input" placeholder="Please enter first name."
                                            name="studentfirstname" type="text" required />
                                    </label>
                                    <label for="studentlastname">
                                        <span class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Student Last
                                            Name</span>
                                        <input class="input-block input" placeholder="Please enter last name."
                                            name="studentlastname" type="text" required />
                                    </label>
                                    <label for="email">
                                        <span class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Parent
                                            E-mail</span>
                                        <input class="input-block input" placeholder="Please enter parent e-mail."
                                            name="email" type="email" required />
                                    </label>
                                    <label for="bday">
                                        <span
                                            class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Birthday</span>
                                        <input class="input-block input" placeholder="Please enter parent e-mail."
                                            name="bday" type="date" required />
                                    </label>
                                    <label for="gender">
                                        <span class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Gender</span>
                                        <select class="select" name="gender" required>
                                            <option value="">Select Gender...</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </label>
                                    <label for="akap_status">
                                        <span class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Akap
                                            Status</span>
                                        <select class="select" name="akap_status" required>
                                            <option value="Inactive">Inactive</option>
                                            <option value="Active">Active</option>
                                            <option value="Solved">Solved</option>
                                        </select>
                                    </label>
                                </div>
                                <div class="h-full flex flex-row justify-end items-end gap-2">
                                    <button type="button" class="btn btn-ghost"
                                        onclick="document.getElementById('drawer-right').checked = false;">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Create</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <form action="../../connection/edit_section.php" method="POST">
                        <input type="hidden" name="section_id" value="<?php echo $section_id; ?>" />
                        <!-- Hidden field for section ID -->
                        <input type="checkbox" id="drawer-edit-section" class="drawer-toggle" />
                        <label for="drawer-edit-section" class="btn btn-primary">Edit Section</label>
                        <label class="overlay" for="drawer-edit-section"></label>
                        <div class="drawer drawer-right">
                            <div class="drawer-content pt-10 flex flex-col h-full">
                                <label for="drawer-edit-section"
                                    class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</label>
                                <div>
                                    <h2 class="text-xl font-medium">Edit Section</h2>
                                    <label for="sectionname">
                                        <span class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Section
                                            Name</span>
                                        <input class="input-block input" placeholder="Enter section name"
                                            name="sectionname" type="text"
                                            value="<?php echo htmlspecialchars($section['section_name']); ?>"
                                            required />
                                    </label>
                                    <label for="gradelevel">
                                        <span class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Grade
                                            Level</span>
                                        <select class="input-block input" name="gradelevel" required>
                                            <option value="" disabled>Select grade level</option>
                                            <option value="7" <?php echo ($section['grade_level'] == 7) ? 'selected' : ''; ?>>Grade 7</option>
                                            <option value="8" <?php echo ($section['grade_level'] == 8) ? 'selected' : ''; ?>>Grade 8</option>
                                            <option value="9" <?php echo ($section['grade_level'] == 9) ? 'selected' : ''; ?>>Grade 9</option>
                                            <option value="10" <?php echo ($section['grade_level'] == 10) ? 'selected' : ''; ?>>Grade 10
                                            </option>
                                        </select>
                                    </label>
                                    <label for="schoolyear">
                                        <span class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">School
                                            Year</span>
                                        <div class="flex gap-2 items-center justify-center">
                                            <input class="input" maxlength="4" placeholder="Start Year" name="startyear"
                                                value="<?php echo htmlspecialchars(substr($section['school_year'], 0, 4)); ?>" />
                                            <span> to </span>
                                            <input class="input" maxlength="4" placeholder="End Year" name="endyear"
                                                value="<?php echo htmlspecialchars(substr($section['school_year'], 5, 4)); ?>" />
                                        </div>
                                    </label>
                                    <label for="advisername">
                                        <span class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Adviser
                                            Name</span>
                                        <select class="input-block input" name="advisername" required>
                                            <option value="" disabled>Select adviser</option>
                                            <?php
                                            // Query the 'teachers' table
                                            $teachersql = "SELECT teacher_id, first_name, last_name FROM teachers WHERE is_archived = 0";
                                            $result = $conn->query($teachersql);

                                            // Loop through results and generate options
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    $selected = ($row['teacher_id'] == $section['adviser_id']) ? 'selected' : '';
                                                    echo '<option value="' . $row["teacher_id"] . '" ' . $selected . '>' . $row["first_name"] . ' ' . $row["last_name"] . '</option>';
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
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <a href="gradesheet.php?section_id=<?php echo $section_id; ?>"
                        class="btn btn-outline-primary">Gradesheets</a>

                    <?php
                    // Assuming you have already established a database connection
                    include '../../connection/connection.php';

                    // Get the section ID from the URL
                    $section_id = $_GET['section_id'] ?? null;

                    // Check if section ID is available
                    if ($section_id === null) {
                        die('Error: Section ID is missing.');
                    }

                    // Fetch the section information along with the 'is_locked' status
                    $sql = "SELECT section_name, grade_level, is_locked FROM section WHERE section_id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('i', $section_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    // Check if the section exists
                    if ($result->num_rows > 0) {
                        $section = $result->fetch_assoc();
                        $section_name = $section['section_name'];
                        $grade_level = $section['grade_level'];
                        $is_locked = $section['is_locked'];

                        // Checkbox for is_locked with specified format
                        echo '<div>';
                        echo '<label class="flex cursor-pointer gap-2">';
                        echo '<input type="checkbox" class="checkbox" name="is_locked" value="1" id="lockCheckbox" ' . ($is_locked ? 'checked' : '') . ' />';
                        echo '<span>Lock Gradesheets</span>';
                        echo '</label>';
                        echo '</div>';
                    } else {
                        echo "<h1>Section not found</h1>";
                    }

                    // Close the statement and connection
                    $stmt->close();
                    $conn->close();
                    ?>
                </div>
                <div class="flex gap-4 items-center content-center">
                    <div class="flex gap-4 items-center">
                        <span class="text-sm">Filter Gender:</span>
                        <form id="gender-filter-form">
                            <div class="btn-group">
                                <input type="radio" value="all" name="gender-filter" data-content="All"
                                    class="btn bg-[rgba(0,0,0,0.02)]" checked />
                                <input type="radio" value="male" name="gender-filter" data-content="Male"
                                    class="btn bg-[rgba(0,0,0,0.02)]" />
                                <input type="radio" value="female" name="gender-filter" data-content="Female"
                                    class="btn bg-[rgba(0,0,0,0.02)]" />
                            </div>
                        </form>

                    </div>
                    <div class="flex gap-4 items-center">
                        <span class="text-sm">Filter AKAP:</span>
                        <form id="akap-filter-form">
                            <select name="options" id="akap-dropdown" class="select">
                                <option value="all" data-content="All" selected>All</option>
                                <option value="inactive" data-content="Inactive">Inactive</option>
                                <option value="active" data-content="Active">Active</option>
                                <option value="solved" data-content="Solved">Solved</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>

            <div class="flex w-full overflow-x-auto pt-8">
                <table class="table-compact table-zebra table" id="student-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>LRN</th>
                            <th>Last Name</th>
                            <th>First Name</th>
                            <th>Parent E-mail</th>
                            <th>Gender</th>
                            <th>Birthday</th>
                            <th>AKAP Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody data-type="all" data-akap="all">
                        <?php
                        include '../../connection/connection.php';

                        // Check if section_id is passed in the URL
                        if (isset($_GET['section_id'])) {
                            $section_id = $_GET['section_id'];

                            // Query the database for students in this section, ordered by gender (Male first) and then by last name
                            $sql = "SELECT * FROM students WHERE section_ID = $section_id AND is_archived = 0
                ORDER BY 
                CASE WHEN gender = 'Male' THEN 1 ELSE 2 END, 
                last_name ASC";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0):
                                $male_counter = 1;  // Initialize the counter for males
                                $female_counter = 1;  // Initialize the counter for females
                                $current_gender = 'Male';  // Track the current gender
                        
                                while ($student = $result->fetch_assoc()):
                                    $drawer_id = "drawer-all-" . $student['student_id'];

                                    // Reset counter when switching from male to female or vice versa
                                    if ($student['gender'] !== $current_gender) {
                                        $current_gender = $student['gender'];
                                        if ($current_gender == 'Male') {
                                            $male_counter = 1;  // Reset male counter
                                        } else {
                                            $female_counter = 1;  // Reset female counter
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <th>
                                            <!-- Display male or female counter -->
                                            <?php
                                            if ($student['gender'] == 'Male') {
                                                echo $male_counter++;  // Increment and display male counter
                                            } else {
                                                echo $female_counter++;  // Increment and display female counter
                                            }
                                            ?>
                                        </th>
                                        <th><?php echo $student['LRN']; ?></th>
                                        <th><?php echo $student['last_name']; ?></th>
                                        <td><?php echo $student['first_name']; ?></td>
                                        <td><?php echo $student['email']; ?></td>
                                        <td><?php echo $student['gender']; ?></td>
                                        <td><?php echo $student['bday']; ?></td>
                                        <td><?php echo $student['akap_status']; ?></td>
                                        <td>
                                            <!-- Dynamic Drawer Toggle -->
                                            <input type="checkbox" id="<?php echo $drawer_id; ?>" class="drawer-toggle" />
                                            <label for="<?php echo $drawer_id; ?>" class="btn btn-secondary">View</label>
                                            <label class="overlay" for="<?php echo $drawer_id; ?>"></label>

                                            <!-- Drawer Content -->
                                            <div class="drawer drawer-right">
                                                <form method="POST" action="../../connection/update_student.php"
                                                    class="drawer-content pt-10 flex flex-col h-full">
                                                    <label for="<?php echo $drawer_id; ?>"
                                                        class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</label>
                                                    <div>
                                                        <h2 class="text-xl font-medium">Edit Student</h2>
                                                        <div class="flex flex-col gap-2">
                                                            <label for="student_lrn">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">LRN</span>
                                                                <br>
                                                                <input class="input-block input" placeholder="Please enter the LRN."
                                                                    name="student_lrn" type="text"
                                                                    value="<?php echo htmlspecialchars($student['LRN']); ?>"
                                                                    required />
                                                            </label>
                                                            <label for="student_firstname">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Student
                                                                    First
                                                                    Name</span>
                                                                <br>
                                                                <input class="input-block input"
                                                                    placeholder="Please enter first name." name="student_firstname"
                                                                    type="text"
                                                                    value="<?php echo htmlspecialchars($student['first_name']); ?>"
                                                                    required />
                                                            </label>
                                                            <label for="student_lastname">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Student
                                                                    Last
                                                                    Name</span>
                                                                <br>
                                                                <input class="input-block input"
                                                                    placeholder="Please enter last name." name="student_lastname"
                                                                    type="text"
                                                                    value="<?php echo htmlspecialchars($student['last_name']); ?>"
                                                                    required />
                                                            </label>
                                                            <label for="email">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">E-mail</span>
                                                                <br>
                                                                <input class="input-block input" placeholder="Please enter e-mail."
                                                                    name="email" type="email"
                                                                    value="<?php echo htmlspecialchars($student['email']); ?>"
                                                                    required />
                                                            </label>
                                                            <!-- Birthday Field -->
                                                            <label for="bday">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Birthday</span>
                                                                <br>
                                                                <input class="input-block input"
                                                                    placeholder="Please enter birthday." name="bday" type="date"
                                                                    value="<?php echo htmlspecialchars($student['bday']); ?>"
                                                                    required />
                                                            </label>
                                                            <label for="gender">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Gender</span>
                                                                <br>
                                                                <select class="select" name="gender" required>
                                                                    <option value="">Select Gender...</option>
                                                                    <option value="Male" <?php echo ($student['gender'] == 'Male') ? 'selected' : ''; ?>>
                                                                        Male</option>
                                                                    <option value="Female" <?php echo ($student['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                                                                </select>
                                                            </label>
                                                            <label for="akap_status">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">AKAP</span>
                                                                <br>
                                                                <select class="select" name="akap_status" required>
                                                                    <option value="">Select Status...</option>
                                                                    <option value="Active" <?php echo ($student['akap_status'] == 'Active') ? 'selected' : ''; ?>>
                                                                        Active</option>
                                                                    <option value="Inactive" <?php echo ($student['akap_status'] == 'Inactive') ? 'selected' : ''; ?>>
                                                                        Inactive</option>
                                                                    <option value="Solved" <?php echo ($student['akap_status'] == 'Solved') ? 'selected' : ''; ?>>
                                                                        Solved</option>
                                                                </select>
                                                            </label>

                                                            <?php
                                                            $student_id = $student['student_id']; // Assume this is dynamically set based on the current student
                                                            ?>

                                                            <label for="teacher_remarks">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Teacher
                                                                    Remarks</span>
                                                                <br>
                                                                <textarea textarea class="textarea"
                                                                    placeholder="Please enter remarks from the teacher."
                                                                    name="teacher_remarks"
                                                                    rows="4"><?php echo htmlspecialchars($student['teacher_remarks']); ?></textarea>
                                                            </label>
                                                            <a href="../email/email_form.php?email=<?php echo urlencode($student['email']); ?>&name=<?php echo urlencode($student['first_name'] . ' ' . $student['last_name']); ?>&adviser_id=<?php echo urlencode($adviser_id); ?>&section_id=<?php echo urlencode($section_id); ?>"
                                                                class="btn btn-outline-error"
                                                                title="This will redirect to the email form with the student's email, name, and adviser ID, while the current page only has the section ID.">Contact
                                                                Parent</a>
                                                            <a href="report_card.php?student_id=<?php echo $student_id; ?>"
                                                                class="btn btn-outline-primary">View Report Card</a>

                                                            <span class="flex items-center gap-2">
                                                                <?php if ($total_gradesheets > 0 && $finalized_count == $total_gradesheets): ?>
                                                                    <span class="dot dot-success"></span>
                                                                    <span>All gradesheets finalized!</span>
                                                                <?php else: ?>
                                                                    <span class="dot dot-error"></span>
                                                                    <span>Some gradesheets are not yet finalized.</span>
                                                                <?php endif; ?>
                                                            </span>


                                                            <div class="h-full flex flex-row justify-end items-end gap-2">
                                                                <button type="button" class="btn btn-ghost"
                                                                    onclick="document.getElementById('<?php echo $drawer_id; ?>').checked = false;">Cancel</button>
                                                                <button type="submit" class="btn btn-primary">Update</button>
                                                                <input type="hidden" name="student_id"
                                                                    value="<?php echo htmlspecialchars($student['student_id']); ?>" />
                                                                <!-- Hidden field for student ID -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                            <!-- Archive Button and Modal -->
                                            <label class="btn btn-error"
                                                for="modal-2-<?php echo $student['student_id']; ?>">Archive</label>
                                            <input class="modal-state" id="modal-2-<?php echo $student['student_id']; ?>"
                                                type="checkbox" />
                                            <div class="modal">
                                                <label class="modal-overlay"
                                                    for="modal-2-<?php echo $student['student_id']; ?>"></label>
                                                <form method="POST" action="../../connection/archive_student.php"
                                                    class="modal-content flex flex-col gap-5">
                                                    <label for="modal-2-<?php echo $student['student_id']; ?>"
                                                        class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</label>
                                                    <h2 class="text-xl">Archive Student?</h2>
                                                    <span>Are you sure you want to archive this student?</span>

                                                    <!-- Hidden input to send student ID -->
                                                    <input type="hidden" name="student_id"
                                                        value="<?php echo $student['student_id']; ?>" />

                                                    <!-- Hidden input to send the current section ID -->
                                                    <input type="hidden" name="section_id"
                                                        value="<?php echo $_GET['section_id']; ?>" />
                                                    <div class="flex gap-3">
                                                        <button class="btn btn-error btn-block" type="submit">Archive</button>
                                                        <label for="modal-2-<?php echo $student['student_id']; ?>"
                                                            class="btn btn-block">Cancel</label>
                                                    </div>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center">No students found in this view.</td>
                                </tr>
                            <?php endif;
                        } else {
                            echo "<tr><td colspan='7'>No students found in this view.</td></tr>";
                        }
                        ?>
                    </tbody>
                    <tbody data-type="all" data-akap="inactive">
                        <?php
                        include '../../connection/connection.php';

                        // Check if section_id is passed in the URL
                        if (isset($_GET['section_id'])) {
                            $section_id = $_GET['section_id'];

                            // Query the database for students in this section, ordered by gender (Male first) and then by last name
                            $sql = "SELECT * FROM students WHERE section_ID = $section_id AND is_archived = 0 AND akap_status = 'Inactive'
                ORDER BY 
                CASE WHEN gender = 'Male' THEN 1 ELSE 2 END, 
                last_name ASC";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0):
                                $male_counter = 1;  // Initialize the counter for males
                                $female_counter = 1;  // Initialize the counter for females
                                $current_gender = 'Male';  // Track the current gender
                        
                                while ($student = $result->fetch_assoc()):
                                    $drawer_id = "drawer-right-1" . $student['student_id'];

                                    // Reset counter when switching from male to female or vice versa
                                    if ($student['gender'] !== $current_gender) {
                                        $current_gender = $student['gender'];
                                        if ($current_gender == 'Male') {
                                            $male_counter = 1;  // Reset male counter
                                        } else {
                                            $female_counter = 1;  // Reset female counter
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <th>
                                            <!-- Display male or female counter -->
                                            <?php
                                            if ($student['gender'] == 'Male') {
                                                echo $male_counter++;  // Increment and display male counter
                                            } else {
                                                echo $female_counter++;  // Increment and display female counter
                                            }
                                            ?>
                                        </th>
                                        <th><?php echo $student['LRN']; ?></th>
                                        <th><?php echo $student['last_name']; ?></th>
                                        <td><?php echo $student['first_name']; ?></td>
                                        <td><?php echo $student['email']; ?></td>
                                        <td><?php echo $student['gender']; ?></td>
                                        <td><?php echo $student['bday']; ?></td>
                                        <td><?php echo $student['akap_status']; ?></td>
                                        <td>
                                            <!-- Dynamic Drawer Toggle -->
                                            <input type="checkbox" id="<?php echo $drawer_id; ?>" class="drawer-toggle" />
                                            <label for="<?php echo $drawer_id; ?>" class="btn btn-secondary">View</label>
                                            <label class="overlay" for="<?php echo $drawer_id; ?>"></label>

                                            <!-- Drawer Content -->
                                            <div class="drawer drawer-right">
                                                <form method="POST" action="../../connection/update_student.php"
                                                    class="drawer-content pt-10 flex flex-col h-full">
                                                    <label for="<?php echo $drawer_id; ?>"
                                                        class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</label>
                                                    <div>
                                                        <h2 class="text-xl font-medium">Edit Student</h2>
                                                        <div class="flex flex-col gap-2">
                                                            <label for="student_lrn">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">LRN</span>
                                                                <br>
                                                                <input class="input-block input" placeholder="Please enter the LRN."
                                                                    name="student_lrn" type="text"
                                                                    value="<?php echo htmlspecialchars($student['LRN']); ?>"
                                                                    required />
                                                            </label>
                                                            <label for="student_firstname">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Student
                                                                    First
                                                                    Name</span>
                                                                <br>
                                                                <input class="input-block input"
                                                                    placeholder="Please enter first name." name="student_firstname"
                                                                    type="text"
                                                                    value="<?php echo htmlspecialchars($student['first_name']); ?>"
                                                                    required />
                                                            </label>
                                                            <label for="student_lastname">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Student
                                                                    Last
                                                                    Name</span>
                                                                <br>
                                                                <input class="input-block input"
                                                                    placeholder="Please enter last name." name="student_lastname"
                                                                    type="text"
                                                                    value="<?php echo htmlspecialchars($student['last_name']); ?>"
                                                                    required />
                                                            </label>
                                                            <label for="email">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">E-mail</span>
                                                                <br>
                                                                <input class="input-block input" placeholder="Please enter e-mail."
                                                                    name="email" type="email"
                                                                    value="<?php echo htmlspecialchars($student['email']); ?>"
                                                                    required />
                                                            </label>
                                                            <!-- Birthday Field -->
                                                            <label for="bday">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Birthday</span>
                                                                <br>
                                                                <input class="input-block input"
                                                                    placeholder="Please enter birthday." name="bday" type="date"
                                                                    value="<?php echo htmlspecialchars($student['bday']); ?>"
                                                                    required />
                                                            </label>
                                                            <label for="gender">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Gender</span>
                                                                <br>
                                                                <select class="select" name="gender" required>
                                                                    <option value="">Select Gender...</option>
                                                                    <option value="Male" <?php echo ($student['gender'] == 'Male') ? 'selected' : ''; ?>>
                                                                        Male</option>
                                                                    <option value="Female" <?php echo ($student['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                                                                </select>
                                                            </label>
                                                            <label for="akap_status">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">AKAP</span>
                                                                <br>
                                                                <select class="select" name="akap_status" required>
                                                                    <option value="">Select Status...</option>
                                                                    <option value="Active" <?php echo ($student['akap_status'] == 'Active') ? 'selected' : ''; ?>>
                                                                        Active</option>
                                                                    <option value="Inactive" <?php echo ($student['akap_status'] == 'Inactive') ? 'selected' : ''; ?>>
                                                                        Inactive</option>
                                                                    <option value="Solved" <?php echo ($student['akap_status'] == 'Solved') ? 'selected' : ''; ?>>
                                                                        Solved</option>
                                                                </select>
                                                            </label>

                                                            <?php
                                                            $student_id = $student['student_id']; // Assume this is dynamically set based on the current student
                                                            ?>

                                                            <label for="teacher_remarks">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Teacher
                                                                    Remarks</span>
                                                                <br>
                                                                <textarea textarea class="textarea"
                                                                    placeholder="Please enter remarks from the teacher."
                                                                    name="teacher_remarks"
                                                                    rows="4"><?php echo htmlspecialchars($student['teacher_remarks']); ?></textarea>
                                                            </label>
                                                            <a href="../email/email_form.php?email=<?php echo urlencode($student['email']); ?>&name=<?php echo urlencode($student['first_name'] . ' ' . $student['last_name']); ?>&adviser_id=<?php echo urlencode($adviser_id); ?>&section_id=<?php echo urlencode($section_id); ?>"
                                                                class="btn btn-outline-error"
                                                                title="This will redirect to the email form with the student's email, name, and adviser ID, while the current page only has the section ID.">Contact
                                                                Parent</a>

                                                            <a href="report_card.php?student_id=<?php echo $student_id; ?>"
                                                                class="btn btn-outline-primary">View Report Card</a>

                                                            <span class="flex items-center gap-2">
                                                                <?php if ($total_gradesheets > 0 && $finalized_count == $total_gradesheets): ?>
                                                                    <span class="dot dot-success"></span>
                                                                    <span>All gradesheets finalized!</span>
                                                                <?php else: ?>
                                                                    <span class="dot dot-error"></span>
                                                                    <span>Some gradesheets are not yet finalized.</span>
                                                                <?php endif; ?>
                                                            </span>
                                                            <div class="h-full flex flex-row justify-end items-end gap-2">
                                                                <button type="button" class="btn btn-ghost"
                                                                    onclick="document.getElementById('<?php echo $drawer_id; ?>').checked = false;">Cancel</button>
                                                                <button type="submit" class="btn btn-primary">Update</button>
                                                                <input type="hidden" name="student_id"
                                                                    value="<?php echo htmlspecialchars($student['student_id']); ?>" />
                                                                <!-- Hidden field for student ID -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                            <!-- Archive Button and Modal -->
                                            <label class="btn btn-error"
                                                for="modal-1-<?php echo $student['student_id']; ?>">Archive</label>
                                            <input class="modal-state" id="modal-1-<?php echo $student['student_id']; ?>"
                                                type="checkbox" />
                                            <div class="modal">
                                                <label class="modal-overlay"
                                                    for="modal-1-<?php echo $student['student_id']; ?>"></label>
                                                <form method="POST" action="../../connection/archive_student.php"
                                                    class="modal-content flex flex-col gap-5">
                                                    <label for="modal-1-<?php echo $student['student_id']; ?>"
                                                        class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</label>
                                                    <h2 class="text-xl">Archive Student?</h2>
                                                    <span>Are you sure you want to archive this student?</span>

                                                    <!-- Hidden input to send student ID -->
                                                    <input type="hidden" name="student_id"
                                                        value="<?php echo $student['student_id']; ?>" />

                                                    <!-- Hidden input to send the current section ID -->
                                                    <input type="hidden" name="section_id"
                                                        value="<?php echo $_GET['section_id']; ?>" />
                                                    <div class="flex gap-3">
                                                        <button class="btn btn-error btn-block" type="submit">Archive</button>
                                                        <label for="modal-1-<?php echo $student['student_id']; ?>"
                                                            class="btn btn-block">Cancel</label>
                                                    </div>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php endif;
                        } else {
                            echo "<p>No section selected.</p>";
                        }
                        ?>
                    </tbody>
                    <tbody data-type="all" data-akap="active">
                        <?php
                        include '../../connection/connection.php';

                        // Check if section_id is passed in the URL
                        if (isset($_GET['section_id'])) {
                            $section_id = $_GET['section_id'];

                            // Query the database for students in this section, ordered by gender (Male first) and then by last name
                            $sql = "SELECT * FROM students WHERE section_ID = $section_id AND is_archived = 0 AND akap_status = 'Active'
                ORDER BY 
                CASE WHEN gender = 'Male' THEN 1 ELSE 2 END, 
                last_name ASC";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0):
                                $male_counter = 1;  // Initialize the counter for males
                                $female_counter = 1;  // Initialize the counter for females
                                $current_gender = 'Male';  // Track the current gender
                        
                                while ($student = $result->fetch_assoc()):
                                    $drawer_id = "drawer-right-2-" . $student['student_id'];

                                    // Reset counter when switching from male to female or vice versa
                                    if ($student['gender'] !== $current_gender) {
                                        $current_gender = $student['gender'];
                                        if ($current_gender == 'Male') {
                                            $male_counter = 1;  // Reset male counter
                                        } else {
                                            $female_counter = 1;  // Reset female counter
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <th>
                                            <!-- Display male or female counter -->
                                            <?php
                                            if ($student['gender'] == 'Male') {
                                                echo $male_counter++;  // Increment and display male counter
                                            } else {
                                                echo $female_counter++;  // Increment and display female counter
                                            }
                                            ?>
                                        </th>
                                        <th><?php echo $student['LRN']; ?></th>
                                        <th><?php echo $student['last_name']; ?></th>
                                        <td><?php echo $student['first_name']; ?></td>
                                        <td><?php echo $student['email']; ?></td>
                                        <td><?php echo $student['gender']; ?></td>
                                        <td><?php echo $student['bday']; ?></td>
                                        <td><?php echo $student['akap_status']; ?></td>
                                        <td>
                                            <!-- Dynamic Drawer Toggle -->
                                            <input type="checkbox" id="<?php echo $drawer_id; ?>" class="drawer-toggle" />
                                            <label for="<?php echo $drawer_id; ?>" class="btn btn-secondary">View</label>
                                            <label class="overlay" for="<?php echo $drawer_id; ?>"></label>

                                            <!-- Drawer Content -->
                                            <div class="drawer drawer-right">
                                                <form method="POST" action="../../connection/update_student.php"
                                                    class="drawer-content pt-10 flex flex-col h-full">
                                                    <label for="<?php echo $drawer_id; ?>"
                                                        class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</label>
                                                    <div>
                                                        <h2 class="text-xl font-medium">Edit Student</h2>
                                                        <div class="flex flex-col gap-2">
                                                            <label for="student_lrn">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">LRN</span>
                                                                <br>
                                                                <input class="input-block input" placeholder="Please enter the LRN."
                                                                    name="student_lrn" type="text"
                                                                    value="<?php echo htmlspecialchars($student['LRN']); ?>"
                                                                    required />
                                                            </label>
                                                            <label for="student_firstname">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Student
                                                                    First
                                                                    Name</span>
                                                                <br>
                                                                <input class="input-block input"
                                                                    placeholder="Please enter first name." name="student_firstname"
                                                                    type="text"
                                                                    value="<?php echo htmlspecialchars($student['first_name']); ?>"
                                                                    required />
                                                            </label>
                                                            <label for="student_lastname">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Student
                                                                    Last
                                                                    Name</span>
                                                                <br>
                                                                <input class="input-block input"
                                                                    placeholder="Please enter last name." name="student_lastname"
                                                                    type="text"
                                                                    value="<?php echo htmlspecialchars($student['last_name']); ?>"
                                                                    required />
                                                            </label>
                                                            <label for="email">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">E-mail</span>
                                                                <br>
                                                                <input class="input-block input" placeholder="Please enter e-mail."
                                                                    name="email" type="email"
                                                                    value="<?php echo htmlspecialchars($student['email']); ?>"
                                                                    required />
                                                            </label>
                                                            <!-- Birthday Field -->
                                                            <label for="bday">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Birthday</span>
                                                                <br>
                                                                <input class="input-block input"
                                                                    placeholder="Please enter birthday." name="bday" type="date"
                                                                    value="<?php echo htmlspecialchars($student['bday']); ?>"
                                                                    required />
                                                            </label>



                                                            <label for="gender">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Gender</span>
                                                                <br>
                                                                <select class="select" name="gender" required>
                                                                    <option value="">Select Gender...</option>
                                                                    <option value="Male" <?php echo ($student['gender'] == 'Male') ? 'selected' : ''; ?>>
                                                                        Male</option>
                                                                    <option value="Female" <?php echo ($student['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                                                                </select>
                                                            </label>
                                                            <label for="akap_status">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">AKAP</span>
                                                                <br>
                                                                <select class="select" name="akap_status" required>
                                                                    <option value="">Select Status...</option>
                                                                    <option value="Active" <?php echo ($student['akap_status'] == 'Active') ? 'selected' : ''; ?>>
                                                                        Active</option>
                                                                    <option value="Inactive" <?php echo ($student['akap_status'] == 'Inactive') ? 'selected' : ''; ?>>
                                                                        Inactive</option>
                                                                    <option value="Solved" <?php echo ($student['akap_status'] == 'Solved') ? 'selected' : ''; ?>>
                                                                        Solved</option>
                                                                </select>
                                                            </label>

                                                            <?php
                                                            $student_id = $student['student_id']; // Assume this is dynamically set based on the current student
                                                            ?>

                                                            <label for="teacher_remarks">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Teacher
                                                                    Remarks</span>
                                                                <br>
                                                                <textarea textarea class="textarea"
                                                                    placeholder="Please enter remarks from the teacher."
                                                                    name="teacher_remarks"
                                                                    rows="4"><?php echo htmlspecialchars($student['teacher_remarks']); ?></textarea>
                                                            </label>
                                                            <a href="../email/email_form.php?email=<?php echo urlencode($student['email']); ?>&name=<?php echo urlencode($student['first_name'] . ' ' . $student['last_name']); ?>&adviser_id=<?php echo urlencode($adviser_id); ?>&section_id=<?php echo urlencode($section_id); ?>"
                                                                class="btn btn-outline-error"
                                                                title="This will redirect to the email form with the student's email, name, and adviser ID, while the current page only has the section ID.">Contact
                                                                Parent</a>

                                                            <a href="report_card.php?student_id=<?php echo $student_id; ?>"
                                                                class="btn btn-outline-primary">View Report Card</a>

                                                            <span class="flex items-center gap-2">
                                                                <?php if ($total_gradesheets > 0 && $finalized_count == $total_gradesheets): ?>
                                                                    <span class="dot dot-success"></span>
                                                                    <span>All gradesheets finalized!</span>
                                                                <?php else: ?>
                                                                    <span class="dot dot-error"></span>
                                                                    <span>Some gradesheets are not yet finalized.</span>
                                                                <?php endif; ?>
                                                            </span>
                                                            <div class="h-full flex flex-row justify-end items-end gap-2">
                                                                <button type="button" class="btn btn-ghost"
                                                                    onclick="document.getElementById('<?php echo $drawer_id; ?>').checked = false;">Cancel</button>
                                                                <button type="submit" class="btn btn-primary">Update</button>
                                                                <input type="hidden" name="student_id"
                                                                    value="<?php echo htmlspecialchars($student['student_id']); ?>" />
                                                                <!-- Hidden field for student ID -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                            <!-- Archive Button and Modal -->
                                            <label class="btn btn-error"
                                                for="modal-60-<?php echo $student['student_id']; ?>">Archive</label>
                                            <input class="modal-state" id="modal-60-<?php echo $student['student_id']; ?>"
                                                type="checkbox" />
                                            <div class="modal">
                                                <label class="modal-overlay"
                                                    for="modal-1-<?php echo $student['student_id']; ?>"></label>
                                                <form method="POST" action="../../connection/archive_student.php"
                                                    class="modal-content flex flex-col gap-5">
                                                    <label for="modal-60-<?php echo $student['student_id']; ?>"
                                                        class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</label>
                                                    <h2 class="text-xl">Archive Student?</h2>
                                                    <span>Are you sure you want to archive this student?</span>

                                                    <!-- Hidden input to send student ID -->
                                                    <input type="hidden" name="student_id"
                                                        value="<?php echo $student['student_id']; ?>" />

                                                    <!-- Hidden input to send the current section ID -->
                                                    <input type="hidden" name="section_id"
                                                        value="<?php echo $_GET['section_id']; ?>" />
                                                    <div class="flex gap-3">
                                                        <button class="btn btn-error btn-block" type="submit">Archive</button>
                                                        <label for="modal-60-<?php echo $student['student_id']; ?>"
                                                            class="btn btn-block">Cancel</label>
                                                    </div>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php endif;
                        } else {
                            echo "<p>No section selected.</p>";
                        }
                        ?>
                    </tbody>
                    <tbody data-type="all" data-akap="solved">
                        <?php
                        include '../../connection/connection.php';

                        // Check if section_id is passed in the URL
                        if (isset($_GET['section_id'])) {
                            $section_id = $_GET['section_id'];

                            // Query the database for students in this section, ordered by gender (Male first) and then by last name
                            $sql = "SELECT * FROM students WHERE section_ID = $section_id AND is_archived = 0 AND akap_status = 'Solved'
                ORDER BY 
                CASE WHEN gender = 'Male' THEN 1 ELSE 2 END, 
                last_name ASC";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0):
                                $male_counter = 1;  // Initialize the counter for males
                                $female_counter = 1;  // Initialize the counter for females
                                $current_gender = 'Male';  // Track the current gender
                        
                                while ($student = $result->fetch_assoc()):
                                    $drawer_id = "drawer-right-3-" . $student['student_id'];

                                    // Reset counter when switching from male to female or vice versa
                                    if ($student['gender'] !== $current_gender) {
                                        $current_gender = $student['gender'];
                                        if ($current_gender == 'Male') {
                                            $male_counter = 1;  // Reset male counter
                                        } else {
                                            $female_counter = 1;  // Reset female counter
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td>
                                            <!-- Display male or female counter -->
                                            <?php
                                            if ($student['gender'] == 'Male') {
                                                echo $male_counter++;  // Increment and display male counter
                                            } else {
                                                echo $female_counter++;  // Increment and display female counter
                                            }
                                            ?>
                                        </td>
                                        <th><?php echo $student['LRN']; ?></th>
                                        <th><?php echo $student['last_name']; ?></th>
                                        <td><?php echo $student['first_name']; ?></td>
                                        <td><?php echo $student['email']; ?></td>
                                        <td><?php echo $student['gender']; ?></td>
                                        <td><?php echo $student['bday']; ?></td>
                                        <td><?php echo $student['akap_status']; ?></td>
                                        <td>
                                            <!-- Dynamic Drawer Toggle -->
                                            <input type="checkbox" id="<?php echo $drawer_id; ?>" class="drawer-toggle" />
                                            <label for="<?php echo $drawer_id; ?>" class="btn btn-secondary">View</label>
                                            <label class="overlay" for="<?php echo $drawer_id; ?>"></label>

                                            <!-- Drawer Content -->
                                            <div class="drawer drawer-right">
                                                <form method="POST" action="../../connection/update_student.php"
                                                    class="drawer-content pt-10 flex flex-col h-full">
                                                    <label for="<?php echo $drawer_id; ?>"
                                                        class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</label>
                                                    <div>
                                                        <h2 class="text-xl font-medium">Edit Student</h2>
                                                        <div class="flex flex-col gap-2">
                                                            <label for="student_lrn">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">LRN</span>
                                                                <br>
                                                                <input class="input-block input" placeholder="Please enter the LRN."
                                                                    name="student_lrn" type="text"
                                                                    value="<?php echo htmlspecialchars($student['LRN']); ?>"
                                                                    required />
                                                            </label>
                                                            <label for="student_firstname">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Student
                                                                    First
                                                                    Name</span>
                                                                <br>
                                                                <input class="input-block input"
                                                                    placeholder="Please enter first name." name="student_firstname"
                                                                    type="text"
                                                                    value="<?php echo htmlspecialchars($student['first_name']); ?>"
                                                                    required />
                                                            </label>
                                                            <label for="student_lastname">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Student
                                                                    Last
                                                                    Name</span>
                                                                <br>
                                                                <input class="input-block input"
                                                                    placeholder="Please enter last name." name="student_lastname"
                                                                    type="text"
                                                                    value="<?php echo htmlspecialchars($student['last_name']); ?>"
                                                                    required />
                                                            </label>
                                                            <label for="email">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">E-mail</span>
                                                                <br>
                                                                <input class="input-block input" placeholder="Please enter e-mail."
                                                                    name="email" type="email"
                                                                    value="<?php echo htmlspecialchars($student['email']); ?>"
                                                                    required />
                                                            </label>
                                                            <!-- Birthday Field -->
                                                            <label for="bday">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Birthday</span>
                                                                <br>
                                                                <input class="input-block input"
                                                                    placeholder="Please enter birthday." name="bday" type="date"
                                                                    value="<?php echo htmlspecialchars($student['bday']); ?>"
                                                                    required />
                                                            </label>
                                                            <label for="gender">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Gender</span>
                                                                <br>
                                                                <select class="select" name="gender" required>
                                                                    <option value="">Select Gender...</option>
                                                                    <option value="Male" <?php echo ($student['gender'] == 'Male') ? 'selected' : ''; ?>>
                                                                        Male</option>
                                                                    <option value="Female" <?php echo ($student['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                                                                </select>
                                                            </label>
                                                            <label for="akap_status">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">AKAP</span>
                                                                <br>
                                                                <select class="select" name="akap_status" required>
                                                                    <option value="">Select Status...</option>
                                                                    <option value="Active" <?php echo ($student['akap_status'] == 'Active') ? 'selected' : ''; ?>>
                                                                        Active</option>
                                                                    <option value="Inactive" <?php echo ($student['akap_status'] == 'Inactive') ? 'selected' : ''; ?>>
                                                                        Inactive</option>
                                                                    <option value="Solved" <?php echo ($student['akap_status'] == 'Solved') ? 'selected' : ''; ?>>
                                                                        Solved</option>
                                                                </select>
                                                            </label>
                                                            <?php
                                                            $student_id = $student['student_id']; // Assume this is dynamically set based on the current student
                                                            ?>

                                                            <label for="teacher_remarks">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Teacher
                                                                    Remarks</span>
                                                                <br>
                                                                <textarea textarea class="textarea"
                                                                    placeholder="Please enter remarks from the teacher."
                                                                    name="teacher_remarks"
                                                                    rows="4"><?php echo htmlspecialchars($student['teacher_remarks']); ?></textarea>
                                                            </label>
                                                            <a href="../email/email_form.php?email=<?php echo urlencode($student['email']); ?>&name=<?php echo urlencode($student['first_name'] . ' ' . $student['last_name']); ?>&adviser_id=<?php echo urlencode($adviser_id); ?>&section_id=<?php echo urlencode($section_id); ?>"
                                                                class="btn btn-outline-error"
                                                                title="This will redirect to the email form with the student's email, name, and adviser ID, while the current page only has the section ID.">Contact
                                                                Parent</a>

                                                            <a href="report_card.php?student_id=<?php echo $student_id; ?>"
                                                                class="btn btn-outline-primary">View Report Card</a>

                                                            <span class="flex items-center gap-2">
                                                                <?php if ($total_gradesheets > 0 && $finalized_count == $total_gradesheets): ?>
                                                                    <span class="dot dot-success"></span>
                                                                    <span>All gradesheets finalized!</span>
                                                                <?php else: ?>
                                                                    <span class="dot dot-error"></span>
                                                                    <span>Some gradesheets are not yet finalized.</span>
                                                                <?php endif; ?>
                                                            </span>

                                                            <div class="h-full flex flex-row justify-end items-end gap-2">
                                                                <button type="button" class="btn btn-ghost"
                                                                    onclick="document.getElementById('<?php echo $drawer_id; ?>').checked = false;">Cancel</button>
                                                                <button type="submit" class="btn btn-primary">Update</button>
                                                                <input type="hidden" name="student_id"
                                                                    value="<?php echo htmlspecialchars($student['student_id']); ?>" />
                                                                <!-- Hidden field for student ID -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                            <!-- Archive Button and Modal -->
                                            <label class="btn btn-error"
                                                for="modal-61-<?php echo $student['student_id']; ?>">Archive</label>
                                            <input class="modal-state" id="modal-61-<?php echo $student['student_id']; ?>"
                                                type="checkbox" />
                                            <div class="modal">
                                                <label class="modal-overlay"
                                                    for="modal-61-<?php echo $student['student_id']; ?>"></label>
                                                <form method="POST" action="../../connection/archive_student.php"
                                                    class="modal-content flex flex-col gap-5">
                                                    <label for="modal-61-<?php echo $student['student_id']; ?>"
                                                        class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</label>
                                                    <h2 class="text-xl">Archive Student?</h2>
                                                    <span>Are you sure you want to archive this student?</span>

                                                    <!-- Hidden input to send student ID -->
                                                    <input type="hidden" name="student_id"
                                                        value="<?php echo $student['student_id']; ?>" />

                                                    <!-- Hidden input to send the current section ID -->
                                                    <input type="hidden" name="section_id"
                                                        value="<?php echo $_GET['section_id']; ?>" />
                                                    <div class="flex gap-3">
                                                        <button class="btn btn-error btn-block" type="submit">Archive</button>
                                                        <label for="modal-61-<?php echo $student['student_id']; ?>"
                                                            class="btn btn-block">Cancel</label>
                                                    </div>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php endif;
                        } else {
                            echo "<p>No section selected.</p>";
                        }
                        ?>
                    </tbody>
                    <tbody data-type="male" data-akap="all">
                        <?php
                        include '../../connection/connection.php';

                        // Check if section_id is passed in the URL
                        if (isset($_GET['section_id'])) {
                            $section_id = $_GET['section_id'];

                            // Query the database for students in this section, ordered by gender (Male first) and then by last name
                            $sql = "SELECT * FROM students WHERE section_ID = $section_id AND is_archived = 0 AND gender = 'Male'
                ORDER BY 
                CASE WHEN gender = 'Male' THEN 1 ELSE 2 END, 
                last_name ASC";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0):
                                $male_counter = 1;  // Initialize the counter for males
                                $female_counter = 1;  // Initialize the counter for females
                                $current_gender = 'Male';  // Track the current gender
                        
                                while ($student = $result->fetch_assoc()):
                                    $drawer_id = "drawer-right-65-" . $student['student_id'];

                                    // Reset counter when switching from male to female or vice versa
                                    if ($student['gender'] !== $current_gender) {
                                        $current_gender = $student['gender'];
                                        if ($current_gender == 'Male') {
                                            $male_counter = 1;  // Reset male counter
                                        } else {
                                            $female_counter = 1;  // Reset female counter
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <th>
                                            <!-- Display male or female counter -->
                                            <?php
                                            if ($student['gender'] == 'Male') {
                                                echo $male_counter++;  // Increment and display male counter
                                            } else {
                                                echo $female_counter++;  // Increment and display female counter
                                            }
                                            ?>
                                        </th>
                                        <th><?php echo $student['LRN']; ?></th>
                                        <th><?php echo $student['last_name']; ?></th>
                                        <td><?php echo $student['first_name']; ?></td>
                                        <td><?php echo $student['email']; ?></td>
                                        <td><?php echo $student['gender']; ?></td>
                                        <td><?php echo $student['bday']; ?></td>
                                        <td><?php echo $student['akap_status']; ?></td>
                                        <td>
                                            <!-- Dynamic Drawer Toggle -->
                                            <input type="checkbox" id="<?php echo $drawer_id; ?>" class="drawer-toggle" />
                                            <label for="<?php echo $drawer_id; ?>" class="btn btn-secondary">View</label>
                                            <label class="overlay" for="<?php echo $drawer_id; ?>"></label>

                                            <!-- Drawer Content -->
                                            <div class="drawer drawer-right">
                                                <form method="POST" action="../../connection/update_student.php"
                                                    class="drawer-content pt-10 flex flex-col h-full">
                                                    <label for="<?php echo $drawer_id; ?>"
                                                        class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</label>
                                                    <div>
                                                        <h2 class="text-xl font-medium">Edit Student</h2>
                                                        <div class="flex flex-col gap-2">
                                                            <label for="student_lrn">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">LRN</span>
                                                                <br>
                                                                <input class="input-block input" placeholder="Please enter the LRN."
                                                                    name="student_lrn" type="text"
                                                                    value="<?php echo htmlspecialchars($student['LRN']); ?>"
                                                                    required />
                                                            </label>
                                                            <label for="student_firstname">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Student
                                                                    First
                                                                    Name</span>
                                                                <br>
                                                                <input class="input-block input"
                                                                    placeholder="Please enter first name." name="student_firstname"
                                                                    type="text"
                                                                    value="<?php echo htmlspecialchars($student['first_name']); ?>"
                                                                    required />
                                                            </label>
                                                            <label for="student_lastname">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Student
                                                                    Last
                                                                    Name</span>
                                                                <br>
                                                                <input class="input-block input"
                                                                    placeholder="Please enter last name." name="student_lastname"
                                                                    type="text"
                                                                    value="<?php echo htmlspecialchars($student['last_name']); ?>"
                                                                    required />
                                                            </label>
                                                            <label for="email">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">E-mail</span>
                                                                <br>
                                                                <input class="input-block input" placeholder="Please enter e-mail."
                                                                    name="email" type="email"
                                                                    value="<?php echo htmlspecialchars($student['email']); ?>"
                                                                    required />
                                                            </label>
                                                            <!-- Birthday Field -->
                                                            <label for="bday">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Birthday</span>
                                                                <br>
                                                                <input class="input-block input"
                                                                    placeholder="Please enter birthday." name="bday" type="date"
                                                                    value="<?php echo htmlspecialchars($student['bday']); ?>"
                                                                    required />
                                                            </label>



                                                            <label for="gender">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Gender</span>
                                                                <br>
                                                                <select class="select" name="gender" required>
                                                                    <option value="">Select Gender...</option>
                                                                    <option value="Male" <?php echo ($student['gender'] == 'Male') ? 'selected' : ''; ?>>
                                                                        Male</option>
                                                                    <option value="Female" <?php echo ($student['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                                                                </select>
                                                            </label>
                                                            <label for="akap_status">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">AKAP</span>
                                                                <br>
                                                                <select class="select" name="akap_status" required>
                                                                    <option value="">Select Status...</option>
                                                                    <option value="Active" <?php echo ($student['akap_status'] == 'Active') ? 'selected' : ''; ?>>
                                                                        Active</option>
                                                                    <option value="Inactive" <?php echo ($student['akap_status'] == 'Inactive') ? 'selected' : ''; ?>>
                                                                        Inactive</option>
                                                                    <option value="Solved" <?php echo ($student['akap_status'] == 'Solved') ? 'selected' : ''; ?>>
                                                                        Solved</option>
                                                                </select>
                                                            </label>

                                                            <?php
                                                            $student_id = $student['student_id']; // Assume this is dynamically set based on the current student
                                                            ?>

                                                            <label for="teacher_remarks">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Teacher
                                                                    Remarks</span>
                                                                <br>
                                                                <textarea textarea class="textarea"
                                                                    placeholder="Please enter remarks from the teacher."
                                                                    name="teacher_remarks"
                                                                    rows="4"><?php echo htmlspecialchars($student['teacher_remarks']); ?></textarea>
                                                            </label>
                                                            <a href="../email/email_form.php?email=<?php echo urlencode($student['email']); ?>&name=<?php echo urlencode($student['first_name'] . ' ' . $student['last_name']); ?>&adviser_id=<?php echo urlencode($adviser_id); ?>&section_id=<?php echo urlencode($section_id); ?>"
                                                                class="btn btn-outline-error"
                                                                title="This will redirect to the email form with the student's email, name, and adviser ID, while the current page only has the section ID.">Contact
                                                                Parent</a>

                                                            <a href="report_card.php?student_id=<?php echo $student_id; ?>"
                                                                class="btn btn-outline-primary">View Report Card</a>

                                                            <span class="flex items-center gap-2">
                                                                <?php if ($total_gradesheets > 0 && $finalized_count == $total_gradesheets): ?>
                                                                    <span class="dot dot-success"></span>
                                                                    <span>All gradesheets finalized!</span>
                                                                <?php else: ?>
                                                                    <span class="dot dot-error"></span>
                                                                    <span>Some gradesheets are not yet finalized.</span>
                                                                <?php endif; ?>
                                                            </span>
                                                            <div class="h-full flex flex-row justify-end items-end gap-2">
                                                                <button type="button" class="btn btn-ghost"
                                                                    onclick="document.getElementById('<?php echo $drawer_id; ?>').checked = false;">Cancel</button>
                                                                <button type="submit" class="btn btn-primary">Update</button>
                                                                <input type="hidden" name="student_id"
                                                                    value="<?php echo htmlspecialchars($student['student_id']); ?>" />
                                                                <!-- Hidden field for student ID -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                            <!-- Archive Button and Modal -->
                                            <label class="btn btn-error"
                                                for="modal-20-<?php echo $student['student_id']; ?>">Archive</label>
                                            <input class="modal-state" id="modal-20-<?php echo $student['student_id']; ?>"
                                                type="checkbox" />
                                            <div class="modal">
                                                <label class="modal-overlay"
                                                    for="modal-20-<?php echo $student['student_id']; ?>"></label>
                                                <form method="POST" action="../../connection/archive_student.php"
                                                    class="modal-content flex flex-col gap-5">
                                                    <label for="modal-20-<?php echo $student['student_id']; ?>"
                                                        class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</label>
                                                    <h2 class="text-xl">Archive Student?</h2>
                                                    <span>Are you sure you want to archive this student?</span>

                                                    <!-- Hidden input to send student ID -->
                                                    <input type="hidden" name="student_id"
                                                        value="<?php echo $student['student_id']; ?>" />

                                                    <!-- Hidden input to send the current section ID -->
                                                    <input type="hidden" name="section_id"
                                                        value="<?php echo $_GET['section_id']; ?>" />
                                                    <div class="flex gap-3">
                                                        <button class="btn btn-error btn-block" type="submit">Archive</button>
                                                        <label for="modal-20-<?php echo $student['student_id']; ?>"
                                                            class="btn btn-block">Cancel</label>
                                                    </div>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php endif;
                        } else {
                            echo "<p>No section selected.</p>";
                        }
                        ?>
                    </tbody>
                    <tbody data-type="male" data-akap="inactive">
                        <?php
                        include '../../connection/connection.php';

                        // Check if section_id is passed in the URL
                        if (isset($_GET['section_id'])) {
                            $section_id = $_GET['section_id'];

                            // Query the database for students in this section, ordered by gender (Male first) and then by last name
                            $sql = "SELECT * FROM students WHERE section_ID = $section_id AND is_archived = 0 AND akap_status = 'Inactive' AND gender = 'Male'
                ORDER BY 
                CASE WHEN gender = 'Male' THEN 1 ELSE 2 END, 
                last_name ASC";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0):
                                $male_counter = 1;  // Initialize the counter for males
                                $female_counter = 1;  // Initialize the counter for females
                                $current_gender = 'Male';  // Track the current gender
                        
                                while ($student = $result->fetch_assoc()):
                                    $drawer_id = "drawer-right-4-" . $student['student_id'];

                                    // Reset counter when switching from male to female or vice versa
                                    if ($student['gender'] !== $current_gender) {
                                        $current_gender = $student['gender'];
                                        if ($current_gender == 'Male') {
                                            $male_counter = 1;  // Reset male counter
                                        } else {
                                            $female_counter = 1;  // Reset female counter
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <th>
                                            <!-- Display male or female counter -->
                                            <?php
                                            if ($student['gender'] == 'Male') {
                                                echo $male_counter++;  // Increment and display male counter
                                            } else {
                                                echo $female_counter++;  // Increment and display female counter
                                            }
                                            ?>
                                        </th>
                                        <th><?php echo $student['LRN']; ?></th>
                                        <th><?php echo $student['last_name']; ?></th>
                                        <td><?php echo $student['first_name']; ?></td>
                                        <td><?php echo $student['email']; ?></td>
                                        <td><?php echo $student['gender']; ?></td>
                                        <td><?php echo $student['bday']; ?></td>
                                        <td><?php echo $student['akap_status']; ?></td>
                                        <td>
                                            <!-- Dynamic Drawer Toggle -->
                                            <input type="checkbox" id="<?php echo $drawer_id; ?>" class="drawer-toggle" />
                                            <label for="<?php echo $drawer_id; ?>" class="btn btn-secondary">View</label>
                                            <label class="overlay" for="<?php echo $drawer_id; ?>"></label>

                                            <!-- Drawer Content -->
                                            <div class="drawer drawer-right">
                                                <form method="POST" action="../../connection/update_student.php"
                                                    class="drawer-content pt-10 flex flex-col h-full">
                                                    <label for="<?php echo $drawer_id; ?>"
                                                        class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</label>
                                                    <div>
                                                        <h2 class="text-xl font-medium">Edit Student</h2>
                                                        <div class="flex flex-col gap-2">
                                                            <label for="student_lrn">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">LRN</span>
                                                                <br>
                                                                <input class="input-block input" placeholder="Please enter the LRN."
                                                                    name="student_lrn" type="text"
                                                                    value="<?php echo htmlspecialchars($student['LRN']); ?>"
                                                                    required />
                                                            </label>
                                                            <label for="student_firstname">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Student
                                                                    First
                                                                    Name</span>
                                                                <br>
                                                                <input class="input-block input"
                                                                    placeholder="Please enter first name." name="student_firstname"
                                                                    type="text"
                                                                    value="<?php echo htmlspecialchars($student['first_name']); ?>"
                                                                    required />
                                                            </label>
                                                            <label for="student_lastname">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Student
                                                                    Last
                                                                    Name</span>
                                                                <br>
                                                                <input class="input-block input"
                                                                    placeholder="Please enter last name." name="student_lastname"
                                                                    type="text"
                                                                    value="<?php echo htmlspecialchars($student['last_name']); ?>"
                                                                    required />
                                                            </label>
                                                            <label for="email">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">E-mail</span>
                                                                <br>
                                                                <input class="input-block input" placeholder="Please enter e-mail."
                                                                    name="email" type="email"
                                                                    value="<?php echo htmlspecialchars($student['email']); ?>"
                                                                    required />
                                                            </label>
                                                            <!-- Birthday Field -->
                                                            <label for="bday">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Birthday</span>
                                                                <br>
                                                                <input class="input-block input"
                                                                    placeholder="Please enter birthday." name="bday" type="date"
                                                                    value="<?php echo htmlspecialchars($student['bday']); ?>"
                                                                    required />
                                                            </label>



                                                            <label for="gender">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Gender</span>
                                                                <br>
                                                                <select class="select" name="gender" required>
                                                                    <option value="">Select Gender...</option>
                                                                    <option value="Male" <?php echo ($student['gender'] == 'Male') ? 'selected' : ''; ?>>
                                                                        Male</option>
                                                                    <option value="Female" <?php echo ($student['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                                                                </select>
                                                            </label>
                                                            <label for="akap_status">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">AKAP</span>
                                                                <br>
                                                                <select class="select" name="akap_status" required>
                                                                    <option value="">Select Status...</option>
                                                                    <option value="Active" <?php echo ($student['akap_status'] == 'Active') ? 'selected' : ''; ?>>
                                                                        Active</option>
                                                                    <option value="Inactive" <?php echo ($student['akap_status'] == 'Inactive') ? 'selected' : ''; ?>>
                                                                        Inactive</option>
                                                                    <option value="Solved" <?php echo ($student['akap_status'] == 'Solved') ? 'selected' : ''; ?>>
                                                                        Solved</option>
                                                                </select>
                                                            </label>

                                                            <?php
                                                            $student_id = $student['student_id']; // Assume this is dynamically set based on the current student
                                                            ?>

                                                            <label for="teacher_remarks">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Teacher
                                                                    Remarks</span>
                                                                <br>
                                                                <textarea textarea class="textarea"
                                                                    placeholder="Please enter remarks from the teacher."
                                                                    name="teacher_remarks"
                                                                    rows="4"><?php echo htmlspecialchars($student['teacher_remarks']); ?></textarea>
                                                            </label>
                                                            <a href="../email/email_form.php?email=<?php echo urlencode($student['email']); ?>&name=<?php echo urlencode($student['first_name'] . ' ' . $student['last_name']); ?>&adviser_id=<?php echo urlencode($adviser_id); ?>&section_id=<?php echo urlencode($section_id); ?>"
                                                                class="btn btn-outline-error"
                                                                title="This will redirect to the email form with the student's email, name, and adviser ID, while the current page only has the section ID.">Contact
                                                                Parent</a>

                                                            <a href="report_card.php?student_id=<?php echo $student_id; ?>"
                                                                class="btn btn-outline-primary">View Report Card</a>

                                                            <span class="flex items-center gap-2">
                                                                <?php if ($total_gradesheets > 0 && $finalized_count == $total_gradesheets): ?>
                                                                    <span class="dot dot-success"></span>
                                                                    <span>All gradesheets finalized!</span>
                                                                <?php else: ?>
                                                                    <span class="dot dot-error"></span>
                                                                    <span>Some gradesheets are not yet finalized.</span>
                                                                <?php endif; ?>
                                                            </span>
                                                            <div class="h-full flex flex-row justify-end items-end gap-2">
                                                                <button type="button" class="btn btn-ghost"
                                                                    onclick="document.getElementById('<?php echo $drawer_id; ?>').checked = false;">Cancel</button>
                                                                <button type="submit" class="btn btn-primary">Update</button>
                                                                <input type="hidden" name="student_id"
                                                                    value="<?php echo htmlspecialchars($student['student_id']); ?>" />
                                                                <!-- Hidden field for student ID -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                            <!-- Archive Button and Modal -->
                                            <label class="btn btn-error"
                                                for="modal-11-<?php echo $student['student_id']; ?>">Archive</label>
                                            <input class="modal-state" id="modal-11-<?php echo $student['student_id']; ?>"
                                                type="checkbox" />
                                            <div class="modal">
                                                <label class="modal-overlay"
                                                    for="modal-11-<?php echo $student['student_id']; ?>"></label>
                                                <form method="POST" action="../../connection/archive_student.php"
                                                    class="modal-content flex flex-col gap-5">
                                                    <label for="modal-11-<?php echo $student['student_id']; ?>"
                                                        class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</label>
                                                    <h2 class="text-xl">Archive Student?</h2>
                                                    <span>Are you sure you want to archive this student?</span>

                                                    <!-- Hidden input to send student ID -->
                                                    <input type="hidden" name="student_id"
                                                        value="<?php echo $student['student_id']; ?>" />

                                                    <!-- Hidden input to send the current section ID -->
                                                    <input type="hidden" name="section_id"
                                                        value="<?php echo $_GET['section_id']; ?>" />
                                                    <div class="flex gap-3">
                                                        <button class="btn btn-error btn-block" type="submit">Archive</button>
                                                        <label for="modal-11-<?php echo $student['student_id']; ?>"
                                                            class="btn btn-block">Cancel</label>
                                                    </div>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php endif;
                        } else {
                            echo "<p>No section selected.</p>";
                        }
                        ?>
                    </tbody>
                    <tbody data-type="male" data-akap="active">
                        <?php
                        include '../../connection/connection.php';

                        // Check if section_id is passed in the URL
                        if (isset($_GET['section_id'])) {
                            $section_id = $_GET['section_id'];

                            // Query the database for students in this section, ordered by gender (Male first) and then by last name
                            $sql = "SELECT * FROM students WHERE section_ID = $section_id AND is_archived = 0 AND akap_status = 'Active' AND gender = 'Male'
                ORDER BY 
                CASE WHEN gender = 'Male' THEN 1 ELSE 2 END, 
                last_name ASC";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0):
                                $male_counter = 1;  // Initialize the counter for males
                                $female_counter = 1;  // Initialize the counter for females
                                $current_gender = 'Male';  // Track the current gender
                        
                                while ($student = $result->fetch_assoc()):
                                    $drawer_id = "drawer-right-5-" . $student['student_id'];

                                    // Reset counter when switching from male to female or vice versa
                                    if ($student['gender'] !== $current_gender) {
                                        $current_gender = $student['gender'];
                                        if ($current_gender == 'Male') {
                                            $male_counter = 1;  // Reset male counter
                                        } else {
                                            $female_counter = 1;  // Reset female counter
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <th>
                                            <!-- Display male or female counter -->
                                            <?php
                                            if ($student['gender'] == 'Male') {
                                                echo $male_counter++;  // Increment and display male counter
                                            } else {
                                                echo $female_counter++;  // Increment and display female counter
                                            }
                                            ?>
                                        </th>
                                        <th><?php echo $student['LRN']; ?></th>
                                        <th><?php echo $student['last_name']; ?></th>
                                        <td><?php echo $student['first_name']; ?></td>
                                        <td><?php echo $student['email']; ?></td>
                                        <td><?php echo $student['gender']; ?></td>
                                        <td><?php echo $student['bday']; ?></td>
                                        <td><?php echo $student['akap_status']; ?></td>
                                        <td>
                                            <!-- Dynamic Drawer Toggle -->
                                            <input type="checkbox" id="<?php echo $drawer_id; ?>" class="drawer-toggle" />
                                            <label for="<?php echo $drawer_id; ?>" class="btn btn-secondary">View</label>
                                            <label class="overlay" for="<?php echo $drawer_id; ?>"></label>

                                            <!-- Drawer Content -->
                                            <div class="drawer drawer-right">
                                                <form method="POST" action="../../connection/update_student.php"
                                                    class="drawer-content pt-10 flex flex-col h-full">
                                                    <label for="<?php echo $drawer_id; ?>"
                                                        class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</label>
                                                    <div>
                                                        <h2 class="text-xl font-medium">Edit Student</h2>
                                                        <div class="flex flex-col gap-2">
                                                            <label for="student_lrn">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">LRN</span>
                                                                <br>
                                                                <input class="input-block input" placeholder="Please enter the LRN."
                                                                    name="student_lrn" type="text"
                                                                    value="<?php echo htmlspecialchars($student['LRN']); ?>"
                                                                    required />
                                                            </label>
                                                            <label for="student_firstname">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Student
                                                                    First
                                                                    Name</span>
                                                                <br>
                                                                <input class="input-block input"
                                                                    placeholder="Please enter first name." name="student_firstname"
                                                                    type="text"
                                                                    value="<?php echo htmlspecialchars($student['first_name']); ?>"
                                                                    required />
                                                            </label>
                                                            <label for="student_lastname">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Student
                                                                    Last
                                                                    Name</span>
                                                                <br>
                                                                <input class="input-block input"
                                                                    placeholder="Please enter last name." name="student_lastname"
                                                                    type="text"
                                                                    value="<?php echo htmlspecialchars($student['last_name']); ?>"
                                                                    required />
                                                            </label>
                                                            <label for="email">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">E-mail</span>
                                                                <br>
                                                                <input class="input-block input" placeholder="Please enter e-mail."
                                                                    name="email" type="email"
                                                                    value="<?php echo htmlspecialchars($student['email']); ?>"
                                                                    required />
                                                            </label>
                                                            <!-- Birthday Field -->
                                                            <label for="bday">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Birthday</span>
                                                                <br>
                                                                <input class="input-block input"
                                                                    placeholder="Please enter birthday." name="bday" type="date"
                                                                    value="<?php echo htmlspecialchars($student['bday']); ?>"
                                                                    required />
                                                            </label>



                                                            <label for="gender">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Gender</span>
                                                                <br>
                                                                <select class="select" name="gender" required>
                                                                    <option value="">Select Gender...</option>
                                                                    <option value="Male" <?php echo ($student['gender'] == 'Male') ? 'selected' : ''; ?>>
                                                                        Male</option>
                                                                    <option value="Female" <?php echo ($student['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                                                                </select>
                                                            </label>
                                                            <label for="akap_status">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">AKAP</span>
                                                                <br>
                                                                <select class="select" name="akap_status" required>
                                                                    <option value="">Select Status...</option>
                                                                    <option value="Active" <?php echo ($student['akap_status'] == 'Active') ? 'selected' : ''; ?>>
                                                                        Active</option>
                                                                    <option value="Inactive" <?php echo ($student['akap_status'] == 'Inactive') ? 'selected' : ''; ?>>
                                                                        Inactive</option>
                                                                    <option value="Solved" <?php echo ($student['akap_status'] == 'Solved') ? 'selected' : ''; ?>>
                                                                        Solved</option>
                                                                </select>
                                                            </label>

                                                            <?php
                                                            $student_id = $student['student_id']; // Assume this is dynamically set based on the current student
                                                            ?>

                                                            <label for="teacher_remarks">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Teacher
                                                                    Remarks</span>
                                                                <br>
                                                                <textarea textarea class="textarea"
                                                                    placeholder="Please enter remarks from the teacher."
                                                                    name="teacher_remarks"
                                                                    rows="4"><?php echo htmlspecialchars($student['teacher_remarks']); ?></textarea>
                                                            </label>
                                                            <a href="../email/email_form.php?email=<?php echo urlencode($student['email']); ?>&name=<?php echo urlencode($student['first_name'] . ' ' . $student['last_name']); ?>&adviser_id=<?php echo urlencode($adviser_id); ?>&section_id=<?php echo urlencode($section_id); ?>"
                                                                class="btn btn-outline-error"
                                                                title="This will redirect to the email form with the student's email, name, and adviser ID, while the current page only has the section ID.">Contact
                                                                Parent</a>

                                                            <a href="report_card.php?student_id=<?php echo $student_id; ?>"
                                                                class="btn btn-outline-primary">View Report Card</a>

                                                            <span class="flex items-center gap-2">
                                                                <?php if ($total_gradesheets > 0 && $finalized_count == $total_gradesheets): ?>
                                                                    <span class="dot dot-success"></span>
                                                                    <span>All gradesheets finalized!</span>
                                                                <?php else: ?>
                                                                    <span class="dot dot-error"></span>
                                                                    <span>Some gradesheets are not yet finalized.</span>
                                                                <?php endif; ?>
                                                            </span>
                                                            <div class="h-full flex flex-row justify-end items-end gap-2">
                                                                <button type="button" class="btn btn-ghost"
                                                                    onclick="document.getElementById('<?php echo $drawer_id; ?>').checked = false;">Cancel</button>
                                                                <button type="submit" class="btn btn-primary">Update</button>
                                                                <input type="hidden" name="student_id"
                                                                    value="<?php echo htmlspecialchars($student['student_id']); ?>" />
                                                                <!-- Hidden field for student ID -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                            <!-- Archive Button and Modal -->
                                            <label class="btn btn-error"
                                                for="modal-62-<?php echo $student['student_id']; ?>">Archive</label>
                                            <input class="modal-state" id="modal-62-<?php echo $student['student_id']; ?>"
                                                type="checkbox" />
                                            <div class="modal">
                                                <label class="modal-overlay"
                                                    for="modal-62-<?php echo $student['student_id']; ?>"></label>
                                                <form method="POST" action="../../connection/archive_student.php"
                                                    class="modal-content flex flex-col gap-5">
                                                    <label for="modal-62-<?php echo $student['student_id']; ?>"
                                                        class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</label>
                                                    <h2 class="text-xl">Archive Student?</h2>
                                                    <span>Are you sure you want to archive this student?</span>

                                                    <!-- Hidden input to send student ID -->
                                                    <input type="hidden" name="student_id"
                                                        value="<?php echo $student['student_id']; ?>" />

                                                    <!-- Hidden input to send the current section ID -->
                                                    <input type="hidden" name="section_id"
                                                        value="<?php echo $_GET['section_id']; ?>" />
                                                    <div class="flex gap-3">
                                                        <button class="btn btn-error btn-block" type="submit">Archive</button>
                                                        <label for="modal-62-<?php echo $student['student_id']; ?>"
                                                            class="btn btn-block">Cancel</label>
                                                    </div>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php endif;
                        } else {
                            echo "<p>No section selected.</p>";
                        }
                        ?>
                    </tbody>
                    <tbody data-type="male" data-akap="solved">
                        <?php
                        include '../../connection/connection.php';

                        // Check if section_id is passed in the URL
                        if (isset($_GET['section_id'])) {
                            $section_id = $_GET['section_id'];

                            // Query the database for students in this section, ordered by gender (Male first) and then by last name
                            $sql = "SELECT * FROM students WHERE section_ID = $section_id AND is_archived = 0 AND akap_status = 'Solved' AND gender = 'Male'
                ORDER BY 
                CASE WHEN gender = 'Male' THEN 1 ELSE 2 END, 
                last_name ASC";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0):
                                $male_counter = 1;  // Initialize the counter for males
                                $female_counter = 1;  // Initialize the counter for females
                                $current_gender = 'Male';  // Track the current gender
                        
                                while ($student = $result->fetch_assoc()):
                                    $drawer_id = "drawer-right-6-" . $student['student_id'];

                                    // Reset counter when switching from male to female or vice versa
                                    if ($student['gender'] !== $current_gender) {
                                        $current_gender = $student['gender'];
                                        if ($current_gender == 'Male') {
                                            $male_counter = 1;  // Reset male counter
                                        } else {
                                            $female_counter = 1;  // Reset female counter
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <th>
                                            <!-- Display male or female counter -->
                                            <?php
                                            if ($student['gender'] == 'Male') {
                                                echo $male_counter++;  // Increment and display male counter
                                            } else {
                                                echo $female_counter++;  // Increment and display female counter
                                            }
                                            ?>
                                        </th>
                                        <th><?php echo $student['LRN']; ?></th>
                                        <th><?php echo $student['last_name']; ?></th>
                                        <td><?php echo $student['first_name']; ?></td>
                                        <td><?php echo $student['email']; ?></td>
                                        <td><?php echo $student['gender']; ?></td>
                                        <td><?php echo $student['bday']; ?></td>
                                        <td><?php echo $student['akap_status']; ?></td>
                                        <td>
                                            <!-- Dynamic Drawer Toggle -->
                                            <input type="checkbox" id="<?php echo $drawer_id; ?>" class="drawer-toggle" />
                                            <label for="<?php echo $drawer_id; ?>" class="btn btn-secondary">View</label>
                                            <label class="overlay" for="<?php echo $drawer_id; ?>"></label>

                                            <!-- Drawer Content -->
                                            <div class="drawer drawer-right">
                                                <form method="POST" action="../../connection/update_student.php"
                                                    class="drawer-content pt-10 flex flex-col h-full">
                                                    <label for="<?php echo $drawer_id; ?>"
                                                        class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</label>
                                                    <div>
                                                        <h2 class="text-xl font-medium">Edit Student</h2>
                                                        <div class="flex flex-col gap-2">
                                                            <label for="student_lrn">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">LRN</span>
                                                                <br>
                                                                <input class="input-block input" placeholder="Please enter the LRN."
                                                                    name="student_lrn" type="text"
                                                                    value="<?php echo htmlspecialchars($student['LRN']); ?>"
                                                                    required />
                                                            </label>
                                                            <label for="student_firstname">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Student
                                                                    First
                                                                    Name</span>
                                                                <br>
                                                                <input class="input-block input"
                                                                    placeholder="Please enter first name." name="student_firstname"
                                                                    type="text"
                                                                    value="<?php echo htmlspecialchars($student['first_name']); ?>"
                                                                    required />
                                                            </label>
                                                            <label for="student_lastname">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Student
                                                                    Last
                                                                    Name</span>
                                                                <br>
                                                                <input class="input-block input"
                                                                    placeholder="Please enter last name." name="student_lastname"
                                                                    type="text"
                                                                    value="<?php echo htmlspecialchars($student['last_name']); ?>"
                                                                    required />
                                                            </label>
                                                            <label for="email">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">E-mail</span>
                                                                <br>
                                                                <input class="input-block input" placeholder="Please enter e-mail."
                                                                    name="email" type="email"
                                                                    value="<?php echo htmlspecialchars($student['email']); ?>"
                                                                    required />
                                                            </label>
                                                            <!-- Birthday Field -->
                                                            <label for="bday">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Birthday</span>
                                                                <br>
                                                                <input class="input-block input"
                                                                    placeholder="Please enter birthday." name="bday" type="date"
                                                                    value="<?php echo htmlspecialchars($student['bday']); ?>"
                                                                    required />
                                                            </label>



                                                            <label for="gender">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Gender</span>
                                                                <br>
                                                                <select class="select" name="gender" required>
                                                                    <option value="">Select Gender...</option>
                                                                    <option value="Male" <?php echo ($student['gender'] == 'Male') ? 'selected' : ''; ?>>
                                                                        Male</option>
                                                                    <option value="Female" <?php echo ($student['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                                                                </select>
                                                            </label>
                                                            <label for="akap_status">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">AKAP</span>
                                                                <br>
                                                                <select class="select" name="akap_status" required>
                                                                    <option value="">Select Status...</option>
                                                                    <option value="Active" <?php echo ($student['akap_status'] == 'Active') ? 'selected' : ''; ?>>
                                                                        Active</option>
                                                                    <option value="Inactive" <?php echo ($student['akap_status'] == 'Inactive') ? 'selected' : ''; ?>>
                                                                        Inactive</option>
                                                                    <option value="Solved" <?php echo ($student['akap_status'] == 'Solved') ? 'selected' : ''; ?>>
                                                                        Solved</option>
                                                                </select>
                                                            </label>

                                                            <?php
                                                            $student_id = $student['student_id']; // Assume this is dynamically set based on the current student
                                                            ?>

                                                            <label for="teacher_remarks">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Teacher
                                                                    Remarks</span>
                                                                <br>
                                                                <textarea textarea class="textarea"
                                                                    placeholder="Please enter remarks from the teacher."
                                                                    name="teacher_remarks"
                                                                    rows="4"><?php echo htmlspecialchars($student['teacher_remarks']); ?></textarea>
                                                            </label>
                                                            <a href="../email/email_form.php?email=<?php echo urlencode($student['email']); ?>&name=<?php echo urlencode($student['first_name'] . ' ' . $student['last_name']); ?>&adviser_id=<?php echo urlencode($adviser_id); ?>&section_id=<?php echo urlencode($section_id); ?>"
                                                                class="btn btn-outline-error"
                                                                title="This will redirect to the email form with the student's email, name, and adviser ID, while the current page only has the section ID.">Contact
                                                                Parent</a>

                                                            <a href="report_card.php?student_id=<?php echo $student_id; ?>"
                                                                class="btn btn-outline-primary">View Report Card</a>

                                                            <span class="flex items-center gap-2">
                                                                <?php if ($total_gradesheets > 0 && $finalized_count == $total_gradesheets): ?>
                                                                    <span class="dot dot-success"></span>
                                                                    <span>All gradesheets finalized!</span>
                                                                <?php else: ?>
                                                                    <span class="dot dot-error"></span>
                                                                    <span>Some gradesheets are not yet finalized.</span>
                                                                <?php endif; ?>
                                                            </span>
                                                            <div class="h-full flex flex-row justify-end items-end gap-2">
                                                                <button type="button" class="btn btn-ghost"
                                                                    onclick="document.getElementById('<?php echo $drawer_id; ?>').checked = false;">Cancel</button>
                                                                <button type="submit" class="btn btn-primary">Update</button>
                                                                <input type="hidden" name="student_id"
                                                                    value="<?php echo htmlspecialchars($student['student_id']); ?>" />
                                                                <!-- Hidden field for student ID -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                            <!-- Archive Button and Modal -->
                                            <label class="btn btn-error"
                                                for="modal-63-<?php echo $student['student_id']; ?>">Archive</label>
                                            <input class="modal-state" id="modal-63-<?php echo $student['student_id']; ?>"
                                                type="checkbox" />
                                            <div class="modal">
                                                <label class="modal-overlay"
                                                    for="modal-63-<?php echo $student['student_id']; ?>"></label>
                                                <form method="POST" action="../../connection/archive_student.php"
                                                    class="modal-content flex flex-col gap-5">
                                                    <label for="modal-63-<?php echo $student['student_id']; ?>"
                                                        class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</label>
                                                    <h2 class="text-xl">Archive Student?</h2>
                                                    <span>Are you sure you want to archive this student?</span>

                                                    <!-- Hidden input to send student ID -->
                                                    <input type="hidden" name="student_id"
                                                        value="<?php echo $student['student_id']; ?>" />

                                                    <!-- Hidden input to send the current section ID -->
                                                    <input type="hidden" name="section_id"
                                                        value="<?php echo $_GET['section_id']; ?>" />
                                                    <div class="flex gap-3">
                                                        <button class="btn btn-error btn-block" type="submit">Archive</button>
                                                        <label for="modal-63-<?php echo $student['student_id']; ?>"
                                                            class="btn btn-block">Cancel</label>
                                                    </div>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php endif;
                        } else {
                            echo "<p>No section selected.</p>";
                        }
                        ?>
                    </tbody>
                    <tbody data-type="female" data-akap="all">
                        <?php
                        include '../../connection/connection.php';

                        // Check if section_id is passed in the URL
                        if (isset($_GET['section_id'])) {
                            $section_id = $_GET['section_id'];

                            // Query the database for students in this section, ordered by gender (Male first) and then by last name
                            $sql = "SELECT * FROM students WHERE section_ID = $section_id AND is_archived = 0  AND gender = 'Female'
                ORDER BY 
                CASE WHEN gender = 'Male' THEN 1 ELSE 2 END, 
                last_name ASC";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0):
                                $male_counter = 1;  // Initialize the counter for males
                                $female_counter = 1;  // Initialize the counter for females
                                $current_gender = 'Male';  // Track the current gender
                        
                                while ($student = $result->fetch_assoc()):
                                    $drawer_id = "drawer-right-65-" . $student['student_id'];

                                    // Reset counter when switching from male to female or vice versa
                                    if ($student['gender'] !== $current_gender) {
                                        $current_gender = $student['gender'];
                                        if ($current_gender == 'Male') {
                                            $male_counter = 1;  // Reset male counter
                                        } else {
                                            $female_counter = 1;  // Reset female counter
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td>
                                            <!-- Display male or female counter -->
                                            <?php
                                            if ($student['gender'] == 'Male') {
                                                echo $male_counter++;  // Increment and display male counter
                                            } else {
                                                echo $female_counter++;  // Increment and display female counter
                                            }
                                            ?>
                                        </td>
                                        <th><?php echo $student['LRN']; ?></th>
                                        <th><?php echo $student['last_name']; ?></th>
                                        <td><?php echo $student['first_name']; ?></td>
                                        <td><?php echo $student['email']; ?></td>
                                        <td><?php echo $student['gender']; ?></td>
                                        <td><?php echo $student['bday']; ?></td>
                                        <td><?php echo $student['akap_status']; ?></td>
                                        <td>
                                            <!-- Dynamic Drawer Toggle -->
                                            <input type="checkbox" id="<?php echo $drawer_id; ?>" class="drawer-toggle" />
                                            <label for="<?php echo $drawer_id; ?>" class="btn btn-secondary">View</label>
                                            <label class="overlay" for="<?php echo $drawer_id; ?>"></label>

                                            <!-- Drawer Content -->
                                            <div class="drawer drawer-right">
                                                <form method="POST" action="../../connection/update_student.php"
                                                    class="drawer-content pt-10 flex flex-col h-full">
                                                    <label for="<?php echo $drawer_id; ?>"
                                                        class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</label>
                                                    <div>
                                                        <h2 class="text-xl font-medium">Edit Student</h2>
                                                        <div class="flex flex-col gap-2">
                                                            <label for="student_lrn">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">LRN</span>
                                                                <br>
                                                                <input class="input-block input" placeholder="Please enter the LRN."
                                                                    name="student_lrn" type="text"
                                                                    value="<?php echo htmlspecialchars($student['LRN']); ?>"
                                                                    required />
                                                            </label>
                                                            <label for="student_firstname">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Student
                                                                    First
                                                                    Name</span>
                                                                <br>
                                                                <input class="input-block input"
                                                                    placeholder="Please enter first name." name="student_firstname"
                                                                    type="text"
                                                                    value="<?php echo htmlspecialchars($student['first_name']); ?>"
                                                                    required />
                                                            </label>
                                                            <label for="student_lastname">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Student
                                                                    Last
                                                                    Name</span>
                                                                <br>
                                                                <input class="input-block input"
                                                                    placeholder="Please enter last name." name="student_lastname"
                                                                    type="text"
                                                                    value="<?php echo htmlspecialchars($student['last_name']); ?>"
                                                                    required />
                                                            </label>
                                                            <label for="email">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">E-mail</span>
                                                                <br>
                                                                <input class="input-block input" placeholder="Please enter e-mail."
                                                                    name="email" type="email"
                                                                    value="<?php echo htmlspecialchars($student['email']); ?>"
                                                                    required />
                                                            </label>
                                                            <!-- Birthday Field -->
                                                            <label for="bday">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Birthday</span>
                                                                <br>
                                                                <input class="input-block input"
                                                                    placeholder="Please enter birthday." name="bday" type="date"
                                                                    value="<?php echo htmlspecialchars($student['bday']); ?>"
                                                                    required />
                                                            </label>
                                                            <label for="gender">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Gender</span>
                                                                <br>
                                                                <select class="select" name="gender" required>
                                                                    <option value="">Select Gender...</option>
                                                                    <option value="Male" <?php echo ($student['gender'] == 'Male') ? 'selected' : ''; ?>>
                                                                        Male</option>
                                                                    <option value="Female" <?php echo ($student['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                                                                </select>
                                                            </label>
                                                            <label for="akap_status">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">AKAP</span>
                                                                <br>
                                                                <select class="select" name="akap_status" required>
                                                                    <option value="">Select Status...</option>
                                                                    <option value="Active" <?php echo ($student['akap_status'] == 'Active') ? 'selected' : ''; ?>>
                                                                        Active</option>
                                                                    <option value="Inactive" <?php echo ($student['akap_status'] == 'Inactive') ? 'selected' : ''; ?>>
                                                                        Inactive</option>
                                                                    <option value="Solved" <?php echo ($student['akap_status'] == 'Solved') ? 'selected' : ''; ?>>
                                                                        Solved</option>
                                                                </select>
                                                            </label>

                                                            <?php
                                                            $student_id = $student['student_id']; // Assume this is dynamically set based on the current student
                                                            ?>

                                                            <label for="teacher_remarks">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Teacher
                                                                    Remarks</span>
                                                                <br>
                                                                <textarea textarea class="textarea"
                                                                    placeholder="Please enter remarks from the teacher."
                                                                    name="teacher_remarks"
                                                                    rows="4"><?php echo htmlspecialchars($student['teacher_remarks']); ?></textarea>
                                                            </label>
                                                            <a href="../email/email_form.php?email=<?php echo urlencode($student['email']); ?>&name=<?php echo urlencode($student['first_name'] . ' ' . $student['last_name']); ?>&adviser_id=<?php echo urlencode($adviser_id); ?>&section_id=<?php echo urlencode($section_id); ?>"
                                                                class="btn btn-outline-error"
                                                                title="This will redirect to the email form with the student's email, name, and adviser ID, while the current page only has the section ID.">Contact
                                                                Parent</a>

                                                            <a href="report_card.php?student_id=<?php echo $student_id; ?>"
                                                                class="btn btn-outline-primary">View Report Card</a>

                                                            <span class="flex items-center gap-2">
                                                                <?php if ($total_gradesheets > 0 && $finalized_count == $total_gradesheets): ?>
                                                                    <span class="dot dot-success"></span>
                                                                    <span>All gradesheets finalized!</span>
                                                                <?php else: ?>
                                                                    <span class="dot dot-error"></span>
                                                                    <span>Some gradesheets are not yet finalized.</span>
                                                                <?php endif; ?>
                                                            </span>
                                                            <div class="h-full flex flex-row justify-end items-end gap-2">
                                                                <button type="button" class="btn btn-ghost"
                                                                    onclick="document.getElementById('<?php echo $drawer_id; ?>').checked = false;">Cancel</button>
                                                                <button type="submit" class="btn btn-primary">Update</button>
                                                                <input type="hidden" name="student_id"
                                                                    value="<?php echo htmlspecialchars($student['student_id']); ?>" />
                                                                <!-- Hidden field for student ID -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                            <!-- Archive Button and Modal -->
                                            <label class="btn btn-error"
                                                for="modal-65-<?php echo $student['student_id']; ?>">Archive</label>
                                            <input class="modal-state" id="modal-65-<?php echo $student['student_id']; ?>"
                                                type="checkbox" />
                                            <div class="modal">
                                                <label class="modal-overlay"
                                                    for="modal-65-<?php echo $student['student_id']; ?>"></label>
                                                <form method="POST" action="../../connection/archive_student.php"
                                                    class="modal-content flex flex-col gap-5">
                                                    <label for="modal-65-<?php echo $student['student_id']; ?>"
                                                        class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</label>
                                                    <h2 class="text-xl">Archive Student?</h2>
                                                    <span>Are you sure you want to archive this student?</span>

                                                    <!-- Hidden input to send student ID -->
                                                    <input type="hidden" name="student_id"
                                                        value="<?php echo $student['student_id']; ?>" />

                                                    <!-- Hidden input to send the current section ID -->
                                                    <input type="hidden" name="section_id"
                                                        value="<?php echo $_GET['section_id']; ?>" />
                                                    <div class="flex gap-3">
                                                        <button class="btn btn-error btn-block" type="submit">Archive</button>
                                                        <label for="modal-65-<?php echo $student['student_id']; ?>"
                                                            class="btn btn-block">Cancel</label>
                                                    </div>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php endif;
                        } else {
                            echo "<p>No section selected.</p>";
                        }
                        ?>
                    </tbody>
                    <tbody data-type="female" data-akap="inactive">
                        <?php
                        include '../../connection/connection.php';

                        // Check if section_id is passed in the URL
                        if (isset($_GET['section_id'])) {
                            $section_id = $_GET['section_id'];

                            // Query the database for students in this section, ordered by gender (Male first) and then by last name
                            $sql = "SELECT * FROM students WHERE section_ID = $section_id AND is_archived = 0 AND akap_status = 'Inactive' AND gender = 'Female'
                ORDER BY 
                CASE WHEN gender = 'Male' THEN 1 ELSE 2 END, 
                last_name ASC";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0):
                                $male_counter = 1;  // Initialize the counter for males
                                $female_counter = 1;  // Initialize the counter for females
                                $current_gender = 'Male';  // Track the current gender
                        
                                while ($student = $result->fetch_assoc()):
                                    $drawer_id = "drawer-right-7-" . $student['student_id'];

                                    // Reset counter when switching from male to female or vice versa
                                    if ($student['gender'] !== $current_gender) {
                                        $current_gender = $student['gender'];
                                        if ($current_gender == 'Male') {
                                            $male_counter = 1;  // Reset male counter
                                        } else {
                                            $female_counter = 1;  // Reset female counter
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td>
                                            <!-- Display male or female counter -->
                                            <?php
                                            if ($student['gender'] == 'Male') {
                                                echo $male_counter++;  // Increment and display male counter
                                            } else {
                                                echo $female_counter++;  // Increment and display female counter
                                            }
                                            ?>
                                        </td>
                                        <th><?php echo $student['LRN']; ?></th>
                                        <th><?php echo $student['last_name']; ?></th>
                                        <td><?php echo $student['first_name']; ?></td>
                                        <td><?php echo $student['email']; ?></td>
                                        <td><?php echo $student['gender']; ?></td>
                                        <td><?php echo $student['bday']; ?></td>
                                        <td><?php echo $student['akap_status']; ?></td>
                                        <td>
                                            <!-- Dynamic Drawer Toggle -->
                                            <input type="checkbox" id="<?php echo $drawer_id; ?>" class="drawer-toggle" />
                                            <label for="<?php echo $drawer_id; ?>" class="btn btn-secondary">View</label>
                                            <label class="overlay" for="<?php echo $drawer_id; ?>"></label>

                                            <!-- Drawer Content -->
                                            <div class="drawer drawer-right">
                                                <form method="POST" action="../../connection/update_student.php"
                                                    class="drawer-content pt-10 flex flex-col h-full">
                                                    <label for="<?php echo $drawer_id; ?>"
                                                        class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</label>
                                                    <div>
                                                        <h2 class="text-xl font-medium">Edit Student</h2>
                                                        <div class="flex flex-col gap-2">
                                                            <label for="student_lrn">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">LRN</span>
                                                                <br>
                                                                <input class="input-block input" placeholder="Please enter the LRN."
                                                                    name="student_lrn" type="text"
                                                                    value="<?php echo htmlspecialchars($student['LRN']); ?>"
                                                                    required />
                                                            </label>
                                                            <label for="student_firstname">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Student
                                                                    First
                                                                    Name</span>
                                                                <br>
                                                                <input class="input-block input"
                                                                    placeholder="Please enter first name." name="student_firstname"
                                                                    type="text"
                                                                    value="<?php echo htmlspecialchars($student['first_name']); ?>"
                                                                    required />
                                                            </label>
                                                            <label for="student_lastname">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Student
                                                                    Last
                                                                    Name</span>
                                                                <br>
                                                                <input class="input-block input"
                                                                    placeholder="Please enter last name." name="student_lastname"
                                                                    type="text"
                                                                    value="<?php echo htmlspecialchars($student['last_name']); ?>"
                                                                    required />
                                                            </label>
                                                            <label for="email">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">E-mail</span>
                                                                <br>
                                                                <input class="input-block input" placeholder="Please enter e-mail."
                                                                    name="email" type="email"
                                                                    value="<?php echo htmlspecialchars($student['email']); ?>"
                                                                    required />
                                                            </label>
                                                            <!-- Birthday Field -->
                                                            <label for="bday">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Birthday</span>
                                                                <br>
                                                                <input class="input-block input"
                                                                    placeholder="Please enter birthday." name="bday" type="date"
                                                                    value="<?php echo htmlspecialchars($student['bday']); ?>"
                                                                    required />
                                                            </label>



                                                            <label for="gender">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Gender</span>
                                                                <br>
                                                                <select class="select" name="gender" required>
                                                                    <option value="">Select Gender...</option>
                                                                    <option value="Male" <?php echo ($student['gender'] == 'Male') ? 'selected' : ''; ?>>
                                                                        Male</option>
                                                                    <option value="Female" <?php echo ($student['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                                                                </select>
                                                            </label>
                                                            <label for="akap_status">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">AKAP</span>
                                                                <br>
                                                                <select class="select" name="akap_status" required>
                                                                    <option value="">Select Status...</option>
                                                                    <option value="Active" <?php echo ($student['akap_status'] == 'Active') ? 'selected' : ''; ?>>
                                                                        Active</option>
                                                                    <option value="Inactive" <?php echo ($student['akap_status'] == 'Inactive') ? 'selected' : ''; ?>>
                                                                        Inactive</option>
                                                                    <option value="Solved" <?php echo ($student['akap_status'] == 'Solved') ? 'selected' : ''; ?>>
                                                                        Solved</option>
                                                                </select>
                                                            </label>

                                                            <?php
                                                            $student_id = $student['student_id']; // Assume this is dynamically set based on the current student
                                                            ?>

                                                            <label for="teacher_remarks">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Teacher
                                                                    Remarks</span>
                                                                <br>
                                                                <textarea textarea class="textarea"
                                                                    placeholder="Please enter remarks from the teacher."
                                                                    name="teacher_remarks"
                                                                    rows="4"><?php echo htmlspecialchars($student['teacher_remarks']); ?></textarea>
                                                            </label>
                                                            <a href="../email/email_form.php?email=<?php echo urlencode($student['email']); ?>&name=<?php echo urlencode($student['first_name'] . ' ' . $student['last_name']); ?>&adviser_id=<?php echo urlencode($adviser_id); ?>&section_id=<?php echo urlencode($section_id); ?>"
                                                                class="btn btn-outline-error"
                                                                title="This will redirect to the email form with the student's email, name, and adviser ID, while the current page only has the section ID.">Contact
                                                                Parent</a>

                                                            <a href="report_card.php?student_id=<?php echo $student_id; ?>"
                                                                class="btn btn-outline-primary">View Report Card</a>

                                                            <span class="flex items-center gap-2">
                                                                <?php if ($total_gradesheets > 0 && $finalized_count == $total_gradesheets): ?>
                                                                    <span class="dot dot-success"></span>
                                                                    <span>All gradesheets finalized!</span>
                                                                <?php else: ?>
                                                                    <span class="dot dot-error"></span>
                                                                    <span>Some gradesheets are not yet finalized.</span>
                                                                <?php endif; ?>
                                                            </span>
                                                            <div class="h-full flex flex-row justify-end items-end gap-2">
                                                                <button type="button" class="btn btn-ghost"
                                                                    onclick="document.getElementById('<?php echo $drawer_id; ?>').checked = false;">Cancel</button>
                                                                <button type="submit" class="btn btn-primary">Update</button>
                                                                <input type="hidden" name="student_id"
                                                                    value="<?php echo htmlspecialchars($student['student_id']); ?>" />
                                                                <!-- Hidden field for student ID -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                            <!-- Archive Button and Modal -->
                                            <label class="btn btn-error"
                                                for="modal-71-<?php echo $student['student_id']; ?>">Archive</label>
                                            <input class="modal-state" id="modal-71-<?php echo $student['student_id']; ?>"
                                                type="checkbox" />
                                            <div class="modal">
                                                <label class="modal-overlay"
                                                    for="modal-71-<?php echo $student['student_id']; ?>"></label>
                                                <form method="POST" action="../../connection/archive_student.php"
                                                    class="modal-content flex flex-col gap-5">
                                                    <label for="modal-71-<?php echo $student['student_id']; ?>"
                                                        class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</label>
                                                    <h2 class="text-xl">Archive Student?</h2>
                                                    <span>Are you sure you want to archive this student?</span>

                                                    <!-- Hidden input to send student ID -->
                                                    <input type="hidden" name="student_id"
                                                        value="<?php echo $student['student_id']; ?>" />

                                                    <!-- Hidden input to send the current section ID -->
                                                    <input type="hidden" name="section_id"
                                                        value="<?php echo $_GET['section_id']; ?>" />
                                                    <div class="flex gap-3">
                                                        <button class="btn btn-error btn-block" type="submit">Archive</button>
                                                        <label for="modal-71-<?php echo $student['student_id']; ?>"
                                                            class="btn btn-block">Cancel</label>
                                                    </div>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php endif;
                        } else {
                            echo "<p>No section selected.</p>";
                        }
                        ?>
                    </tbody>
                    <tbody data-type="female" data-akap="active">
                        <?php
                        include '../../connection/connection.php';

                        // Check if section_id is passed in the URL
                        if (isset($_GET['section_id'])) {
                            $section_id = $_GET['section_id'];

                            // Query the database for students in this section, ordered by gender (Male first) and then by last name
                            $sql = "SELECT * FROM students WHERE section_ID = $section_id AND is_archived = 0 AND akap_status = 'Active' AND gender = 'Female'
                ORDER BY 
                CASE WHEN gender = 'Male' THEN 1 ELSE 2 END, 
                last_name ASC";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0):
                                $male_counter = 1;  // Initialize the counter for males
                                $female_counter = 1;  // Initialize the counter for females
                                $current_gender = 'Male';  // Track the current gender
                        
                                while ($student = $result->fetch_assoc()):
                                    $drawer_id = "drawer-right-8-" . $student['student_id'];

                                    // Reset counter when switching from male to female or vice versa
                                    if ($student['gender'] !== $current_gender) {
                                        $current_gender = $student['gender'];
                                        if ($current_gender == 'Male') {
                                            $male_counter = 1;  // Reset male counter
                                        } else {
                                            $female_counter = 1;  // Reset female counter
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <th>
                                            <!-- Display male or female counter -->
                                            <?php
                                            if ($student['gender'] == 'Male') {
                                                echo $male_counter++;  // Increment and display male counter
                                            } else {
                                                echo $female_counter++;  // Increment and display female counter
                                            }
                                            ?>
                                        </th>
                                        <th><?php echo $student['LRN']; ?></th>
                                        <th><?php echo $student['last_name']; ?></th>
                                        <td><?php echo $student['first_name']; ?></td>
                                        <td><?php echo $student['email']; ?></td>
                                        <td><?php echo $student['gender']; ?></td>
                                        <td><?php echo $student['bday']; ?></td>
                                        <td><?php echo $student['akap_status']; ?></td>
                                        <td>
                                            <!-- Dynamic Drawer Toggle -->
                                            <input type="checkbox" id="<?php echo $drawer_id; ?>" class="drawer-toggle" />
                                            <label for="<?php echo $drawer_id; ?>" class="btn btn-secondary">View</label>
                                            <label class="overlay" for="<?php echo $drawer_id; ?>"></label>

                                            <!-- Drawer Content -->
                                            <div class="drawer drawer-right">
                                                <form method="POST" action="../../connection/update_student.php"
                                                    class="drawer-content pt-10 flex flex-col h-full">
                                                    <label for="<?php echo $drawer_id; ?>"
                                                        class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</label>
                                                    <div>
                                                        <h2 class="text-xl font-medium">Edit Student</h2>
                                                        <div class="flex flex-col gap-2">
                                                            <label for="student_lrn">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">LRN</span>
                                                                <br>
                                                                <input class="input-block input" placeholder="Please enter the LRN."
                                                                    name="student_lrn" type="text"
                                                                    value="<?php echo htmlspecialchars($student['LRN']); ?>"
                                                                    required />
                                                            </label>
                                                            <label for="student_firstname">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Student
                                                                    First
                                                                    Name</span>
                                                                <br>
                                                                <input class="input-block input"
                                                                    placeholder="Please enter first name." name="student_firstname"
                                                                    type="text"
                                                                    value="<?php echo htmlspecialchars($student['first_name']); ?>"
                                                                    required />
                                                            </label>
                                                            <label for="student_lastname">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Student
                                                                    Last
                                                                    Name</span>
                                                                <br>
                                                                <input class="input-block input"
                                                                    placeholder="Please enter last name." name="student_lastname"
                                                                    type="text"
                                                                    value="<?php echo htmlspecialchars($student['last_name']); ?>"
                                                                    required />
                                                            </label>
                                                            <label for="email">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">E-mail</span>
                                                                <br>
                                                                <input class="input-block input" placeholder="Please enter e-mail."
                                                                    name="email" type="email"
                                                                    value="<?php echo htmlspecialchars($student['email']); ?>"
                                                                    required />
                                                            </label>
                                                            <!-- Birthday Field -->
                                                            <label for="bday">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Birthday</span>
                                                                <br>
                                                                <input class="input-block input"
                                                                    placeholder="Please enter birthday." name="bday" type="date"
                                                                    value="<?php echo htmlspecialchars($student['bday']); ?>"
                                                                    required />
                                                            </label>



                                                            <label for="gender">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Gender</span>
                                                                <br>
                                                                <select class="select" name="gender" required>
                                                                    <option value="">Select Gender...</option>
                                                                    <option value="Male" <?php echo ($student['gender'] == 'Male') ? 'selected' : ''; ?>>
                                                                        Male</option>
                                                                    <option value="Female" <?php echo ($student['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                                                                </select>
                                                            </label>
                                                            <label for="akap_status">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">AKAP</span>
                                                                <br>
                                                                <select class="select" name="akap_status" required>
                                                                    <option value="">Select Status...</option>
                                                                    <option value="Active" <?php echo ($student['akap_status'] == 'Active') ? 'selected' : ''; ?>>
                                                                        Active</option>
                                                                    <option value="Inactive" <?php echo ($student['akap_status'] == 'Inactive') ? 'selected' : ''; ?>>
                                                                        Inactive</option>
                                                                    <option value="Solved" <?php echo ($student['akap_status'] == 'Solved') ? 'selected' : ''; ?>>
                                                                        Solved</option>
                                                                </select>
                                                            </label>

                                                            <?php
                                                            $student_id = $student['student_id']; // Assume this is dynamically set based on the current student
                                                            ?>

                                                            <label for="teacher_remarks">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Teacher
                                                                    Remarks</span>
                                                                <br>
                                                                <textarea textarea class="textarea"
                                                                    placeholder="Please enter remarks from the teacher."
                                                                    name="teacher_remarks"
                                                                    rows="4"><?php echo htmlspecialchars($student['teacher_remarks']); ?></textarea>
                                                            </label>
                                                            <a href="../email/email_form.php?email=<?php echo urlencode($student['email']); ?>&name=<?php echo urlencode($student['first_name'] . ' ' . $student['last_name']); ?>&adviser_id=<?php echo urlencode($adviser_id); ?>&section_id=<?php echo urlencode($section_id); ?>"
                                                                class="btn btn-outline-error"
                                                                title="This will redirect to the email form with the student's email, name, and adviser ID, while the current page only has the section ID.">Contact
                                                                Parent</a>

                                                            <a href="report_card.php?student_id=<?php echo $student_id; ?>"
                                                                class="btn btn-outline-primary">View Report Card</a>

                                                            <span class="flex items-center gap-2">
                                                                <?php if ($total_gradesheets > 0 && $finalized_count == $total_gradesheets): ?>
                                                                    <span class="dot dot-success"></span>
                                                                    <span>All gradesheets finalized!</span>
                                                                <?php else: ?>
                                                                    <span class="dot dot-error"></span>
                                                                    <span>Some gradesheets are not yet finalized.</span>
                                                                <?php endif; ?>
                                                            </span>
                                                            <div class="h-full flex flex-row justify-end items-end gap-2">
                                                                <button type="button" class="btn btn-ghost"
                                                                    onclick="document.getElementById('<?php echo $drawer_id; ?>').checked = false;">Cancel</button>
                                                                <button type="submit" class="btn btn-primary">Update</button>
                                                                <input type="hidden" name="student_id"
                                                                    value="<?php echo htmlspecialchars($student['student_id']); ?>" />
                                                                <!-- Hidden field for student ID -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                            <!-- Archive Button and Modal -->
                                            <label class="btn btn-error"
                                                for="modal-81-<?php echo $student['student_id']; ?>">Archive</label>
                                            <input class="modal-state" id="modal-81-<?php echo $student['student_id']; ?>"
                                                type="checkbox" />
                                            <div class="modal">
                                                <label class="modal-overlay"
                                                    for="modal-81-<?php echo $student['student_id']; ?>"></label>
                                                <form method="POST" action="../../connection/archive_student.php"
                                                    class="modal-content flex flex-col gap-5">
                                                    <label for="modal-81-<?php echo $student['student_id']; ?>"
                                                        class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</label>
                                                    <h2 class="text-xl">Archive Student?</h2>
                                                    <span>Are you sure you want to archive this student?</span>

                                                    <!-- Hidden input to send student ID -->
                                                    <input type="hidden" name="student_id"
                                                        value="<?php echo $student['student_id']; ?>" />

                                                    <!-- Hidden input to send the current section ID -->
                                                    <input type="hidden" name="section_id"
                                                        value="<?php echo $_GET['section_id']; ?>" />
                                                    <div class="flex gap-3">
                                                        <button class="btn btn-error btn-block" type="submit">Archive</button>
                                                        <label for="modal-81-<?php echo $student['student_id']; ?>"
                                                            class="btn btn-block">Cancel</label>
                                                    </div>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php endif;
                        } else {
                            echo "<p>No section selected.</p>";
                        }
                        ?>
                    </tbody>
                    <tbody data-type="female" data-akap="solved">
                        <?php
                        include '../../connection/connection.php';

                        // Check if section_id is passed in the URL
                        if (isset($_GET['section_id'])) {
                            $section_id = $_GET['section_id'];

                            // Query the database for students in this section, ordered by gender (Male first) and then by last name
                            $sql = "SELECT * FROM students WHERE section_ID = $section_id AND is_archived = 0 AND akap_status = 'Solved' AND gender = 'Female'
                ORDER BY 
                CASE WHEN gender = 'Male' THEN 1 ELSE 2 END, 
                last_name ASC";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0):
                                $male_counter = 1;  // Initialize the counter for males
                                $female_counter = 1;  // Initialize the counter for females
                                $current_gender = 'Male';  // Track the current gender
                        
                                while ($student = $result->fetch_assoc()):
                                    $drawer_id = "drawer-right-9-" . $student['student_id'];

                                    // Reset counter when switching from male to female or vice versa
                                    if ($student['gender'] !== $current_gender) {
                                        $current_gender = $student['gender'];
                                        if ($current_gender == 'Male') {
                                            $male_counter = 1;  // Reset male counter
                                        } else {
                                            $female_counter = 1;  // Reset female counter
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <th>
                                            <!-- Display male or female counter -->
                                            <?php
                                            if ($student['gender'] == 'Male') {
                                                echo $male_counter++;  // Increment and display male counter
                                            } else {
                                                echo $female_counter++;  // Increment and display female counter
                                            }
                                            ?>
                                        </th>
                                        <th><?php echo $student['LRN']; ?></th>
                                        <th><?php echo $student['last_name']; ?></th>
                                        <td><?php echo $student['first_name']; ?></td>
                                        <td><?php echo $student['email']; ?></td>
                                        <td><?php echo $student['gender']; ?></td>
                                        <td><?php echo $student['bday']; ?></td>
                                        <td><?php echo $student['akap_status']; ?></td>
                                        <td>
                                            <!-- Dynamic Drawer Toggle -->
                                            <input type="checkbox" id="<?php echo $drawer_id; ?>" class="drawer-toggle" />
                                            <label for="<?php echo $drawer_id; ?>" class="btn btn-secondary">View</label>
                                            <label class="overlay" for="<?php echo $drawer_id; ?>"></label>

                                            <!-- Drawer Content -->
                                            <div class="drawer drawer-right">
                                                <form method="POST" action="../../connection/update_student.php"
                                                    class="drawer-content pt-10 flex flex-col h-full">
                                                    <label for="<?php echo $drawer_id; ?>"
                                                        class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</label>
                                                    <div>
                                                        <h2 class="text-xl font-medium">Edit Student</h2>
                                                        <div class="flex flex-col gap-2">
                                                            <label for="student_lrn">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">LRN</span>
                                                                <br>
                                                                <input class="input-block input" placeholder="Please enter the LRN."
                                                                    name="student_lrn" type="text"
                                                                    value="<?php echo htmlspecialchars($student['LRN']); ?>"
                                                                    required />
                                                            </label>
                                                            <label for="student_firstname">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Student
                                                                    First
                                                                    Name</span>
                                                                <br>
                                                                <input class="input-block input"
                                                                    placeholder="Please enter first name." name="student_firstname"
                                                                    type="text"
                                                                    value="<?php echo htmlspecialchars($student['first_name']); ?>"
                                                                    required />
                                                            </label>
                                                            <label for="student_lastname">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Student
                                                                    Last
                                                                    Name</span>
                                                                <br>
                                                                <input class="input-block input"
                                                                    placeholder="Please enter last name." name="student_lastname"
                                                                    type="text"
                                                                    value="<?php echo htmlspecialchars($student['last_name']); ?>"
                                                                    required />
                                                            </label>

                                                            <label for="email">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">E-mail</span>
                                                                <br>
                                                                <input class="input-block input" placeholder="Please enter e-mail."
                                                                    name="email" type="email"
                                                                    value="<?php echo htmlspecialchars($student['email']); ?>"
                                                                    required />
                                                            </label>
                                                            <!-- Birthday Field -->
                                                            <label for="bday">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Birthday</span>
                                                                <br>
                                                                <input class="input-block input"
                                                                    placeholder="Please enter birthday." name="bday" type="date"
                                                                    value="<?php echo htmlspecialchars($student['bday']); ?>"
                                                                    required />
                                                            </label>



                                                            <label for="gender">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Gender</span>
                                                                <br>
                                                                <select class="select" name="gender" required>
                                                                    <option value="">Select Gender...</option>
                                                                    <option value="Male" <?php echo ($student['gender'] == 'Male') ? 'selected' : ''; ?>>
                                                                        Male</option>
                                                                    <option value="Female" <?php echo ($student['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                                                                </select>
                                                            </label>
                                                            <label for="akap_status">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">AKAP</span>
                                                                <br>
                                                                <select class="select" name="akap_status" required>
                                                                    <option value="">Select Status...</option>
                                                                    <option value="Active" <?php echo ($student['akap_status'] == 'Active') ? 'selected' : ''; ?>>
                                                                        Active</option>
                                                                    <option value="Inactive" <?php echo ($student['akap_status'] == 'Inactive') ? 'selected' : ''; ?>>
                                                                        Inactive</option>
                                                                    <option value="Solved" <?php echo ($student['akap_status'] == 'Solved') ? 'selected' : ''; ?>>
                                                                        Solved</option>
                                                                </select>
                                                            </label>

                                                            <?php
                                                            $student_id = $student['student_id']; // Assume this is dynamically set based on the current student
                                                            ?>

                                                            <label for="teacher_remarks">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Teacher
                                                                    Remarks</span>
                                                                <br>
                                                                <textarea textarea class="textarea"
                                                                    placeholder="Please enter remarks from the teacher."
                                                                    name="teacher_remarks"
                                                                    rows="4"><?php echo htmlspecialchars($student['teacher_remarks']); ?></textarea>
                                                            </label>
                                                            <a href="../email/email_form.php?email=<?php echo urlencode($student['email']); ?>&name=<?php echo urlencode($student['first_name'] . ' ' . $student['last_name']); ?>&adviser_id=<?php echo urlencode($adviser_id); ?>&section_id=<?php echo urlencode($section_id); ?>"
                                                                class="btn btn-outline-error"
                                                                title="This will redirect to the email form with the student's email, name, and adviser ID, while the current page only has the section ID.">Contact
                                                                Parent</a>

                                                            <a href="report_card.php?student_id=<?php echo $student_id; ?>"
                                                                class="btn btn-outline-primary">View Report Card</a>

                                                            <span class="flex items-center gap-2">
                                                                <?php if ($total_gradesheets > 0 && $finalized_count == $total_gradesheets): ?>
                                                                    <span class="dot dot-success"></span>
                                                                    <span>All gradesheets finalized!</span>
                                                                <?php else: ?>
                                                                    <span class="dot dot-error"></span>
                                                                    <span>Some gradesheets are not yet finalized.</span>
                                                                <?php endif; ?>
                                                            </span>
                                                            <div class="h-full flex flex-row justify-end items-end gap-2">
                                                                <button type="button" class="btn btn-ghost"
                                                                    onclick="document.getElementById('<?php echo $drawer_id; ?>').checked = false;">Cancel</button>
                                                                <button type="submit" class="btn btn-primary">Update</button>
                                                                <input type="hidden" name="student_id"
                                                                    value="<?php echo htmlspecialchars($student['student_id']); ?>" />
                                                                <!-- Hidden field for student ID -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                            <!-- Archive Button and Modal -->
                                            <label class="btn btn-error"
                                                for="modal-91-<?php echo $student['student_id']; ?>">Archive</label>
                                            <input class="modal-state" id="modal-91-<?php echo $student['student_id']; ?>"
                                                type="checkbox" />
                                            <div class="modal">
                                                <label class="modal-overlay"
                                                    for="modal-91-<?php echo $student['student_id']; ?>"></label>
                                                <form method="POST" action="../../connection/archive_student.php"
                                                    class="modal-content flex flex-col gap-5">
                                                    <label for="modal-91-<?php echo $student['student_id']; ?>"
                                                        class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</label>
                                                    <h2 class="text-xl">Archive Student?</h2>
                                                    <span>Are you sure you want to archive this student?</span>

                                                    <!-- Hidden input to send student ID -->
                                                    <input type="hidden" name="student_id"
                                                        value="<?php echo $student['student_id']; ?>" />

                                                    <!-- Hidden input to send the current section ID -->
                                                    <input type="hidden" name="section_id"
                                                        value="<?php echo $_GET['section_id']; ?>" />
                                                    <div class="flex gap-3">
                                                        <button class="btn btn-error btn-block" type="submit">Archive</button>
                                                        <label for="modal-91-<?php echo $student['student_id']; ?>"
                                                            class="btn btn-block">Cancel</label>
                                                    </div>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php endif;
                        } else {
                            echo "<p>No section selected.</p>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

    </div>

    </main>
    </div>
</body>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const genderRadioButtons = document.querySelectorAll('input[name="gender-filter"]');
        const akapDropdown = document.getElementById('akap-dropdown');
        const sections = document.querySelectorAll('#student-table > tbody');
        const emptyStateMessage = document.createElement('tbody');
        emptyStateMessage.innerHTML = "<tr><td colspan='8'>No students found in this view</td></tr>";
        emptyStateMessage.style.color = 'red';
        const tableContainer = document.getElementById('student-table');
        tableContainer.appendChild(emptyStateMessage);

        // Function to filter sections based on selected filters
        function filterSections() {
            const selectedGender = document.querySelector('input[name="gender-filter"]:checked').value;
            const selectedAKAP = akapDropdown.value;
            let anyVisible = false;

            // Hide all sections initially
            sections.forEach(section => {
                section.style.display = 'none';
            });

            // Show relevant tbody based on the selected filters
            sections.forEach(section => {
                const sectionType = section.getAttribute('data-type');
                const sectionAKAP = section.getAttribute('data-akap');

                // Case 1: If both filters are "all", show the section with data-type="all" and data-akap="all"
                if (selectedGender === 'all' && selectedAKAP === 'all') {
                    if (sectionType === 'all' && sectionAKAP === 'all') {
                        section.style.display = '';  // Show the "all-all" section
                        anyVisible = true;
                    }
                }
                // Case 2: If gender is "male/female" and AKAP is "all", show only the section with data-akap="all" for that gender
                else if ((selectedGender === 'male' || selectedGender === 'female') && selectedAKAP === 'all') {
                    if (sectionType === selectedGender && sectionAKAP === 'all') {
                        section.style.display = '';  // Show the gender's "all" section
                        anyVisible = true;
                    }
                }
                // Case 3: If specific AKAP is selected, match both the gender and AKAP
                else if (selectedAKAP !== 'all') {
                    if (sectionType === selectedGender && sectionAKAP === selectedAKAP) {
                        section.style.display = '';  // Show the matching section
                        anyVisible = true;
                    }
                }
            });

            // Handle empty state if no sections are visible
            if (!anyVisible) {
                emptyStateMessage.style.display = '';
            } else {
                emptyStateMessage.style.display = 'none';
            }
        }

        // Event listeners for filter changes
        genderRadioButtons.forEach(radio => {
            radio.addEventListener('change', filterSections);
        });

        akapDropdown.addEventListener('change', filterSections);

        // Initial filter call
        filterSections();
    });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#lockCheckbox').change(function () {
            // Get the checked state of the checkbox
            var isChecked = $(this).is(':checked') ? 1 : 0;

            // Send an AJAX request to update the is_locked status
            $.ajax({
                url: 'update_status.php', // Create this file to handle the update
                type: 'POST',
                data: {
                    section_id: <?php echo $section_id; ?>,
                    is_locked: isChecked
                },
                success: function (response) {
                    console.log(response); // You can handle the response here if needed
                },
                error: function (xhr, status, error) {
                    console.error(error); // Handle any errors here
                }
            });
        });
    });
</script>






</html>
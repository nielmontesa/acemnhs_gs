<?php
// Include your database connection
include '../../connection/connection.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $student_lrn = $_POST['studentlrn'];
    $student_firstname = $_POST['studentfirstname'];
    $student_lastname = $_POST['studentlastname'];
    $parent_email = $_POST['email'];
    $gender = $_POST['gender'];
    $akap_status = $_POST['akap_status']; // Get the Akap Status from the form

    // Use the section ID from the session
    $section_id = $_GET['section_id'] ?? null;

    // Check if section ID is available
    if ($section_id === null) {
        die('Error: Section ID is missing.');
    }

    // SQL query to insert student data, including the section ID and Akap Status
    $sql = "INSERT INTO students (LRN, first_name, last_name, email, gender, akap_status, section_id)
            VALUES ('$student_lrn', '$student_firstname', '$student_lastname', '$parent_email', '$gender', '$akap_status', '$section_id')";

    if ($conn->query($sql) === TRUE) {
        echo "New student added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
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
            const radioButtons = document.querySelectorAll('#gender-filter');
            const sections = document.querySelectorAll('#student-tables > div');

            radioButtons.forEach(radio => {
                radio.addEventListener('change', () => {
                    const selectedGender = radio.value;
                    sections.forEach(section => {
                        if (section.getAttribute('data-type') === selectedGender) {
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
                            <span class="menu-title">Welcome, Username</span>
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
                                    <img src="https://i.pravatar.cc/150?img=30" alt="avatar" />
                                </div>

                                <div class="flex flex-col">
                                    <span>Username</span>
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
        <main class="main-content flex-1 p-8">
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
                                <label for="gender">
                                    <span class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Gender</span>
                                    <select class="select" name="gender" id="gender-filter" required>
                                        <option value="">Select Gender...</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </label>
                                <label for="akap_status">
                                    <span class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Akap
                                        Status</span>
                                    <select class="select" name="akap_status" required>
                                        <option value="">Select Akap Status...</option>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
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
                    <a href="#" class="btn btn-outline-primary">Gradesheets</a>
                </form>

                <div class="flex gap-4">
                    <div class="flex gap-4 items-center">
                        <span class="text-sm">Filter Students:</span>
                        <form>
                            <div class="btn-group">
                                <input type="radio" name="options" data-content="All" class="btn bg-[rgba(0,0,0,0.02)]"
                                    checked />
                                <input type="radio" name="options" data-content="Male"
                                    class="btn bg-[rgba(0,0,0,0.02)]" />
                                <input type="radio" name="options" data-content="Female"
                                    class="btn bg-[rgba(0,0,0,0.02)]" />
                            </div>
                        </form>
                    </div>
                    <div class="flex gap-4 items-center">
                        <span class="text-sm">Filter AKAP:</span>
                        <form>
                            <div class="btn-group">
                                <input type="radio" name="options" data-content="Active"
                                    class="btn bg-[rgba(0,0,0,0.02)]" checked />
                                <input type="radio" name="options" data-content="Inactive"
                                    class="btn bg-[rgba(0,0,0,0.02)]" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="flex w-full overflow-x-auto pt-8" data-type="all">
                <table class="table-hover table">
                    <thead>
                        <tr>
                            <th>LRN</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Parent E-mail</th>
                            <th>Gender</th>
                            <th>AKAP Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include '../../connection/connection.php';

                        // Check if section_id is passed in the URL
                        if (isset($_GET['section_id'])) {
                            $section_id = $_GET['section_id'];

                            // Query the database for students in this section
                            $sql = "SELECT * FROM students WHERE section_ID = $section_id AND is_archived = 0";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0):
                                ?>
                            <tbody>
                                <?php while ($student = $result->fetch_assoc()): ?>
                                    <tr>
                                        <th><?php echo $student['LRN']; ?></th>
                                        <th><?php echo $student['first_name']; ?></th>
                                        <td><?php echo $student['last_name']; ?></td>
                                        <td><?php echo $student['email']; ?></td>
                                        <td><?php echo $student['gender']; ?></td>
                                        <td><?php echo $student['akap_status']; ?></td>
                                        <td>
                                            <input type="checkbox" id="drawer-right-2" class="drawer-toggle" />
                                            <label for="drawer-right-2" class="btn btn-secondary">Edit</label>
                                            <label class="overlay" for="drawer-right-2"></label>
                                            <div class="drawer drawer-right">
                                                <form method="POST" action="../../connection/update_student.php"
                                                    class="drawer-content pt-10 flex flex-col h-full">
                                                    <label for="drawer-right-2"
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
                                                                    First Name</span>
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
                                                                    Last Name</span>
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
                                                            <label for="gender">
                                                                <span
                                                                    class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Gender</span>
                                                                <br>
                                                                <select class="select" name="gender" required>
                                                                    <option value="">Select Gender...</option>
                                                                    <option value="Male" <?php echo ($student['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                                                                    <option value="Female" <?php echo ($student['gender'] == 'Female') ? 'selected' : ''; ?>>Female
                                                                    </option>
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

                                                            <div class="h-full flex flex-row justify-end items-end gap-2">
                                                                <button type="button" class="btn btn-ghost"
                                                                    onclick="document.getElementById('drawer-right-2').checked = false;">Cancel</button>
                                                                <button type="submit" class="btn btn-primary">Update</button>
                                                                <input type="hidden" name="student_id"
                                                                    value="<?php echo htmlspecialchars($student['student_id']); ?>" />
                                                                <!-- Hidden field for student ID -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

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
                            </tbody>
                        <?php else: ?>
                            <tr>
                                <td colspan="8">No students found in this section.</td>
                            </tr>
                        <?php endif; ?>
                        <?php
                        } else {
                            echo "<p>No section selected.</p>";
                        }
                        ?>

                    <!-- <tr>
                            <th>13777577575</th>
                            <th>Roberto</th>
                            <td>Dimagiba</td>
                            <td>robertodimagiba@acemnhs.com</td>
                            <td>Male</td>
                            <td>Active</td>
                            <td>
                                <input type="checkbox" id="drawer-right-2" class="drawer-toggle" />
                                <label for="drawer-right-2" class="btn btn-secondary">Edit</label>
                                <label class="overlay" for="drawer-right-2"></label>
                                <div class="drawer drawer-right">
                                    <form class="drawer-content pt-10 flex flex-col h-full">
                                        <label for="drawer-right-2"
                                            class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</label>
                                        <div>
                                            <h2 class="text-xl font-medium">Edit Student</h2>
                                            <div class="flex flex-col gap-2">
                                                <label for="studentlrn">
                                                    <span
                                                        class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">LRN</span>
                                                    <br>
                                                    <input class="input-block input" placeholder="Please enter the LRN."
                                                        name="studentfirstname" type="text" />
                                                </label>
                                                <label for="studentfirstname">
                                                    <span
                                                        class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Student
                                                        First
                                                        Name</span> <br>
                                                    <input class="input-block input"
                                                        placeholder="Please enter first name." name="studentfirstname"
                                                        type="text" />
                                                </label>
                                                <label for="teacherlastname">
                                                    <span
                                                        class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Student
                                                        Last
                                                        Name</span> <br>
                                                    <input class="input-block input"
                                                        placeholder="Please enter last name." name="studentlastname"
                                                        type="text" />
                                                </label>
                                                <label for="e-mail">
                                                    <span
                                                        class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">E-mail</span>
                                                    <br>
                                                    <input class="input-block input" placeholder="Please enter e-mail."
                                                        name="e-mail" type="email" />
                                                </label>
                                                <label for="Gender">
                                                    <span
                                                        class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Gender</span>
                                                    <br>
                                                    <select class="select" for="select">
                                                        <option>Select Gender...</option>
                                                        <option>Male</option>
                                                        <option>Female</option>
                                                    </select>
                                                </label>
                                                <label for="akap">
                                                    <span
                                                        class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">AKAP</span>
                                                    <br>
                                                    <select class="select" for="select">
                                                        <option>Select Status...</option>
                                                        <option>Active</option>
                                                        <option>Inactive</option>
                                                        <option>Solved</option>
                                                    </select>
                                                </label>
                                                <button class="btn btn-error">Contact Parent</button>
                                                <button class="btn btn-outline-primary">Export Report Card</button>
                                            </div>
                                        </div>
                                        <div class="h-full flex flex-row justify-end items-end gap-2">
                                            <button class="btn btn-ghost">Cancel</button>
                                            <button class="btn btn-primary">Update</button>
                                        </div>
                                    </form>
                                </div>

                                <label class="btn btn-error" for="modal-1">Archive</label>
                                <input class="modal-state" id="modal-1" type="checkbox" />
                                <div class="modal">
                                    <label class="modal-overlay" for="modal-1"></label>
                                    <div class="modal-content flex flex-col gap-5">
                                        <label for="modal-1"
                                            class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</label>
                                        <h2 class="text-xl">Archive department?</h2>
                                        <span>Are you sure you want to Archive this department?</span>
                                        <div class="flex gap-3">
                                            <button class="btn btn-error btn-block">Archive</button>

                                            <label for="modal-1" class="btn btn-block">Cancel</label>
                                        </div>
                                    </div>
                            </td>
                        </tr> -->
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>


</html>
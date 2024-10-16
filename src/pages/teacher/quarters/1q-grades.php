<?php
session_start();
?>

<!DOCTYPE html>
<html data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light only">
    <title>Antonio C. Esguerra MNHS</title>
    <link rel="stylesheet" href='../../../styles/tailwind.css'>
    <link rel="stylesheet" href='../../../styles/style.css'>
    <link rel="icon" href="../../../assets/acemnhs_logo.png">
</head>

<style>
    /* Ensure the table header is sticky */
    #student-table thead {
        position: sticky;
        top: 0;
        z-index: 10;
        background-color: #f3f3f3;
    }

    /* Style the first four columns to be sticky */
    #student-table th:first-child,
    #student-table th:nth-child(2),
    #student-table th:nth-child(3),
    #student-table th:nth-child(4),
    #student-table td:first-child,
    #student-table td:nth-child(2),
    #student-table td:nth-child(3),
    #student-table td:nth-child(4) {
        overflow: hidden;
        text-overflow: ellipsis;

        position: sticky;
        left: 0;
        /* Stick to the left */
        background-color: white;
        /* Match the header background */
        z-index: 5;
        /* Lower than the header but above other table content */
    }

    #student-table th:nth-child(2),
    #student-table th:nth-child(3),
    #student-table th:nth-child(4),
    #student-table td:nth-child(2),
    #student-table td:nth-child(3),
    #student-table td:nth-child(4) {
        min-width: 124px;
        max-width: 124px;
    }

    /* Add a slight shadow effect to distinguish sticky columns */
    #student-table th:first-child,
    #student-table th:nth-child(2),
    #student-table th:nth-child(3),
    #student-table th:nth-child(4) {
        box-shadow: 1px 0 5px rgba(0, 0, 0, 0.1);
    }

    /* Ensure the sticky columns do not overlap */
    #student-table td:first-child,
    #student-table td:nth-child(2),
    #student-table td:nth-child(3),
    #student-table td:nth-child(4) {
        box-shadow: 1px 0 5px rgba(0, 0, 0, 0.05);
    }

    /* Set a fixed width for the first four columns to avoid collapsing */
    #student-table th:first-child,
    #student-table td:first-child {
        width: 100px;
        /* Adjust as needed */
    }

    #student-table th:nth-child(2),
    #student-table td:nth-child(2) {
        width: 150px;
        /* Adjust as needed */
    }

    #student-table th:nth-child(3),
    #student-table td:nth-child(3) {
        width: 150px;
        /* Adjust as needed */
    }

    #student-table th:nth-child(4),
    #student-table td:nth-child(4) {
        width: 150px;
        /* Adjust as needed */
    }
</style>

<body>
    <div class="flex flex-row sm:gap-5">
        <div class="sm:w-full sm:max-w-[18rem]">
            <input type="checkbox" id="sidebar-mobile-fixed" class="sidebar-state" />
            <label for="sidebar-mobile-fixed" class="sidebar-overlay"></label>
            <aside
                class="sidebar sidebar-fixed-left sidebar-mobile h-full justify-start max-sm:fixed max-sm:-translate-x-full">
                <section class="sidebar-title items-center p-4 gap-2">
                    <img src="../../../assets/acemnhs_logo.png" class="w-14" alt="">
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
                                <a href="../sections.php">
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
                            <a href="../settings.php" tabindex="-1" class="dropdown-item text-sm">Account settings</a>
                            <a href="../../../connection/logout.php" tabindex="-1"
                                class="dropdown-item text-sm">Logout</a>
                        </div>
                    </div>
                </section>
            </aside>
        </div>
        <main class="main-content flex-1 p-8 w-fit overflow-x-auto">
            <label for="sidebar-mobile-fixed" class="btn-primary btn sm:hidden">Open Sidebar</label>

            <?php
            // Include your database connection
            include '../../../connection/connection.php';

            // Check if gradesheet_id is provided
            if (isset($_GET['gradesheet_id'])) {
                $gradesheet_id = $_GET['gradesheet_id'];

                // Fetch the gradesheet details
                $gradesheet_query = "SELECT * FROM gradesheet WHERE gradesheet_id = ?";
                $stmt = $conn->prepare($gradesheet_query);
                $stmt->bind_param("i", $gradesheet_id);
                $stmt->execute();
                $gradesheet_result = $stmt->get_result();

                if ($gradesheet_result->num_rows > 0) {
                    $gradesheet = $gradesheet_result->fetch_assoc();
                    echo "<h1 class='text-xl font-bold'>Gradesheet for " . htmlspecialchars($gradesheet['subject']) . "</h1>";
                    // Add the drawer form for adding activities
                    ?>

                    <p>This is a gradesheet for

                        <?php
                        include '../../../connection/connection.php';
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
                    <?php
                    if (isset($_GET['section_id'])) {
                        $section_id = $_GET['section_id'];
                        $section_details_query = "SELECT section_name, grade_level, section_id FROM section WHERE section_id = $section_id";
                        $result = $conn->query($section_details_query);
                    }
                    ?>
                    </p>
                    <div class="flex items-center justify-between  pt-2">
                        <div class="flex items-center content-center gap-2">
                            <form method="POST" action="">
                                <input type="hidden" name="gradesheet_id" value="<?php echo $gradesheet_id; ?>">
                                <input type="checkbox" id="drawer-right" class="drawer-toggle" />
                                <label for="drawer-right" class="btn btn-primary">Add Activity</label>
                                <label class="overlay" for="drawer-right"></label>
                                <div class="drawer drawer-right">
                                    <div class="drawer-content pt-10 flex flex-col h-full">
                                        <label for="drawer-right"
                                            class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</label>
                                        <div>
                                            <h2 class="text-xl font-medium">Add Activity</h2>
                                            <label for="activity_name">
                                                <span class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Activity
                                                    Name</span>
                                                <input class="input-block input" placeholder="Please enter the activity name."
                                                    name="activity_name" type="text" required />
                                            </label>
                                            <label for="total_score">
                                                <span class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Total
                                                    Score</span>
                                                <input class="input-block input" placeholder="Please enter total score."
                                                    name="total_score" type="number" required />
                                            </label>
                                            <label for="activity_type">
                                                <span class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium for="
                                                    activity_type">Activity Type</span>
                                                <select class="select" name="activity_type">
                                                    <option value="Written Work">Written Work</option>
                                                    <option value="Performance Task">Performance Task</option>
                                                    <option value="Quarterly Assessment">Quarterly Assessment</option>
                                                </select>
                                            </label>
                                        </div>
                                        <div class="h-full flex flex-row justify-end items-end gap-2">
                                            <button type="button" class="btn btn-ghost"
                                                onclick="document.getElementById('drawer-right').checked = false;">Cancel</button>
                                            <button type="submit" class="btn btn-primary">Add Activity</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <a href="#" class="btn btn-outline-primary">Check Totals</a>
                            <div>
                                <?php
                                include "../../../connection/connection.php"; // Include your database connection
                        
                                // Initialize the is_finalized variable
                                $is_finalized = 0; // Default value
                        
                                // Assuming you have the gradesheet_id from the context (e.g., a GET parameter)
                                if (isset($_GET['gradesheet_id'])) {
                                    $gradesheet_id = (int) $_GET['gradesheet_id']; // Convert to integer for safety
                        
                                    // Prepare a statement to fetch the is_finalized value
                                    $sql = "SELECT is_finalized FROM gradesheet WHERE gradesheet_id = ?";
                                    $stmt = $conn->prepare($sql);

                                    if ($stmt) {
                                        $stmt->bind_param("i", $gradesheet_id);
                                        $stmt->execute();
                                        $result = $stmt->get_result();

                                        // Fetch the result
                                        if ($result->num_rows > 0) {
                                            $row = $result->fetch_assoc();
                                            $is_finalized = (int) $row['is_finalized']; // Ensure it's treated as an integer
                                        }
                                        $stmt->close(); // Close the statement
                                    } else {
                                        echo "Error preparing statement: " . $conn->error; // Handle errors in statement preparation
                                    }
                                }

                                // Close the connection
                        

                                ?>
                                <div>
                                    <label class="flex cursor-pointer gap-2 items-center justify-center">
                                        <input type="checkbox" class="checkbox" id="finalized-checkbox" <?php echo $is_finalized ? 'checked' : ''; ?> />
                                        <span>Gradesheet Finalized?</span>
                                    </label>
                                </div>
                            </div>

                        </div>
                        <div class="flex items-center content-center gap-2">
                            <span>Filter Quarter:</span>
                            <div class="btn-group btn-group-scrollable">
                                <input type="radio" name="quarterFilter" data-content="1" class="btn" checked />
                                <input type="radio" name="quarterFilter" data-content="2" class="btn" />
                                <input type="radio" name="quarterFilter" data-content="3" class="btn" />
                                <input type="radio" name="quarterFilter" data-content="4" class="btn" />
                            </div>
                        </div>
                    </div>
                    <?php
                    // Handle the POST request to add an activity
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        // Check if the gradesheet_id is still available in the POST data
                        if (isset($_POST['gradesheet_id'])) {
                            $activity_name = $_POST['activity_name'];
                            $total_score = $_POST['total_score'];
                            $activity_type = $_POST['activity_type'];
                            $gradesheet_id = $_POST['gradesheet_id']; // Get the gradesheet_id from POST data
            
                            // Insert the new activity into the activities table
                            $add_activity_query = "INSERT INTO activity (activity_name, total_score, activity_type, gradesheet_id, quarter) VALUES (?, ?, ?, ?, ?)";
                            $add_stmt = $conn->prepare($add_activity_query);
                            $quarter = 1; // The value you want to insert for the quarter column
                            $add_stmt->bind_param("sisii", $activity_name, $total_score, $activity_type, $gradesheet_id, $quarter);


                            if ($add_stmt->execute()) {

                            } else {
                                echo "<script>alert('Error adding activity: " . $conn->error . "');</script>";
                            }
                        }
                    }
                } else {
                    echo "Gradesheet not found.";
                }
            } else {
                echo "Gradesheet ID not provided.";
            }
            ?>


            <div class="overflow-x-auto max-w-3xl lg:max-w-none" style="padding-top: 1rem">
                <table class="table-compact table-hover table w-full" id="student-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>LRN</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <?php
                            include "../../../connection/connection.php";
                            if (isset($_GET['section_id']) && isset($_GET['gradesheet_id'])) {

                                $section_id = $_GET['section_id'];
                                $gradesheet_id = $_GET['gradesheet_id'];

                                // Updated SQL query with ORDER BY to sort activity types
                                $activity_sql = "SELECT * FROM activity WHERE gradesheet_id = $gradesheet_id AND quarter = 1 ORDER BY 
                             CASE activity_type 
                                 WHEN 'Written Work' THEN 1 
                                 WHEN 'Performance Task' THEN 2 
                                 WHEN 'Quarterly Assessment' THEN 3 
                             END";
                                $activity_result = $conn->query($activity_sql);

                                if ($activity_result->num_rows > 0) {
                                    while ($activity = $activity_result->fetch_assoc()) {
                                        // Determine the activity type abbreviation
                                        $activity_type_abbr = '';
                                        switch ($activity['activity_type']) {
                                            case 'Written Work':
                                                $activity_type_abbr = '(WW)';
                                                break;
                                            case 'Performance Task':
                                                $activity_type_abbr = '(PT)';
                                                break;
                                            case 'Quarterly Assessment':
                                                $activity_type_abbr = '(QA)';
                                                break;
                                        }

                                        echo "<th class='activity-header cursor-pointer underline' data-activity-id='" . $activity['activity_id'] . "' data-activity-type='" . $activity['activity_type'] . "' data-activity-name='" . htmlspecialchars($activity['activity_name']) . "' data-total-score='" . $activity['total_score'] . "' onclick='openActivityDrawer(this)'>" . htmlspecialchars($activity['activity_name']) . " $activity_type_abbr</th>";
                                    }
                                }
                            }
                            ?>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        // Query the database for students in this section
                        if (isset($section_id)) {
                            $sql = "SELECT * FROM students WHERE section_ID = $section_id AND is_archived = 0  
                ORDER BY 
                CASE WHEN gender = 'Male' THEN 1 ELSE 2 END, 
                last_name ASC";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                $male_counter = 1;  // Initialize the counter for males
                                $female_counter = 1;  // Initialize the counter for females
                                $current_gender = 'Male';  // Track the current gender
                        
                                while ($student = $result->fetch_assoc()) {
                                    // Reset counter when switching from male to female or vice versa
                                    if ($student['gender'] !== $current_gender) {
                                        $current_gender = $student['gender'];
                                        if ($current_gender == 'Male') {
                                            $male_counter = 1;  // Reset male counter
                                        } else {
                                            $female_counter = 1;  // Reset female counter
                                        }
                                    }

                                    echo "<tr>";

                                    // Display male or female counter
                                    echo "<th>";
                                    if ($student['gender'] == 'Male') {
                                        echo $male_counter++;  // Increment and display male counter
                                    } else {
                                        echo $female_counter++;  // Increment and display female counter
                                    }
                                    echo "</th>";

                                    echo "<th>" . htmlspecialchars($student['LRN']) . "</th>";
                                    echo "<th>" . htmlspecialchars($student['first_name']) . "</th>";
                                    echo "<th>" . htmlspecialchars($student['last_name']) . "</th>";

                                    // Fetch the total score for each activity for this student
                                    if (isset($gradesheet_id)) {
                                        $activity_result->data_seek(0);
                                        while ($activity = $activity_result->fetch_assoc()) {
                                            $activity_id = $activity['activity_id'];
                                            $total_score = $activity['total_score'];

                                            // Fetch the student's score for the current activity
                                            $sql_score = "SELECT score FROM student_activity_score WHERE student_id = ? AND activity_id = ?";
                                            $stmt = $conn->prepare($sql_score);
                                            $stmt->bind_param("ii", $student['student_id'], $activity_id);
                                            $stmt->execute();
                                            $score_result = $stmt->get_result();
                                            $student_score_row = $score_result->fetch_assoc();

                                            $student_score = $student_score_row ? $student_score_row['score'] : 0;

                                            // Display the score in a contenteditable <td>
                                            echo "<td class='editable' contenteditable='true' data-student-id='" . $student['student_id'] . "' data-activity-id='$activity_id' data-max-score='$total_score'><span class='student-score opacity-50'>" . htmlspecialchars($student_score) . "</span> / <span class='total-score'> " . htmlspecialchars($total_score) . "</span></td>";
                                        }
                                    }

                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='7'>No students found in this section.</td></tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No section selected.</td></tr>";
                        }
                        ?>
                    </tbody>

                    <!-- Drawer Modal -->
                    <input type="checkbox" id="drawer-right-1" class="drawer-toggle" />
                    <label class="overlay" for="drawer-right-1"></label>
                    <div class="drawer drawer-right">
                        <div class="drawer-content pt-10 h-full">
                            <label for="drawer-right-1"
                                class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</label>
                            <div class="flex flex-col content-between h-full">
                                <div>
                                    <h2 class="text-xl font-medium">Enter Student Score</h2>
                                    <p id="max_score_display"></p>
                                    <div>
                                        <form method="POST" action="../../../connection/submit_score.php" class="flex">
                                            <input id="student-score" class="input py-1.5 my-3"
                                                placeholder="Type score here..." name="score" type="number" required />
                                            <input type="hidden" id="activity-id" name="activity_id" />
                                            <input type="hidden" id="student-id" name="student_id" />
                                            <input type="hidden" name="redirect_url"
                                                value="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" />
                                            <input type="hidden" id="max-score" />

                                    </div>
                                </div>
                                <!-- Change the action to your PHP file -->
                                <div class="h-full flex flex-row justify-end items-end gap-2">
                                    <button type="button" class="btn btn-ghost" onclick="closeDrawer()">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </table>
            </div>

        </main>
    </div>

    <!-- Drawer Modal for Editing Activity -->
    <input type="checkbox" id="activity-drawer" class="drawer-toggle" />
    <label class="overlay" for="activity-drawer"></label>
    <div class="drawer drawer-right">
        <div class="drawer-content pt-10 h-full">
            <label for="activity-drawer" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</label>
            <div class="flex flex-col content-between h-full">
                <div>
                    <h2 class="text-xl font-medium">Edit Activity</h2>
                    <form method="POST" action="../../../connection/edit_activity.php">
                        <div>
                            <label for="activity-name" class="block">Activity Name</label>
                            <input type="text" id="activity-name" name="activity_name" class="input w-full" required
                                value="<?php echo htmlspecialchars($activity_name); ?>">
                        </div>
                        <div>
                            <label for="total-score" class="block">Total Score</label>
                            <input type="number" id="total-score" name="total_score" class="input w-full" required
                                value="<?php echo htmlspecialchars($total_score); ?>">
                        </div>

                        <!-- Dropdown for Activity Type -->
                        <div>
                            <label for="activity_type">
                                <span class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium for="
                                    activity_type">Activity Type</span>
                                <select class="select" name="activity_type" id="activity_type">
                                    <option value="Written Work">Written Work</option>
                                    <option value="Performance Task">Performance Task</option>
                                    <option value="Quarterly Assessment">Quarterly Assessment</option>
                                </select>
                            </label>
                        </div>


                        <input type="hidden" name="redirect_url"
                            value="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" />
                        <input type="hidden" id="activity-id-edit" name="activity_id">

                        <!-- Buttons for saving changes and archiving -->
                        <div class="flex flex-row-reverse justify-start items-end gap-2 mt-4">
                            <input type="hidden" id="archive-activity-id" name="activity_id"
                                value="<?php echo htmlspecialchars($activity_id); ?>" />
                            <button type="submit" name="action" value="save" class="btn btn-primary">Save</button>
                            <button type="submit" name="action" value="archive" class="btn btn-error">Delete</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Function to open the activity drawer
    function openActivityDrawer(headerElement) {
        const activityId = headerElement.getAttribute('data-activity-id');
        const activityName = headerElement.getAttribute('data-activity-name');
        const totalScore = headerElement.getAttribute('data-total-score');
        const activityType = headerElement.getAttribute('data-activity-type');

        // Update to the new ID
        document.getElementById('activity-id-edit').value = activityId;
        document.getElementById('activity-name').value = activityName;
        document.getElementById('total-score').value = totalScore;
        document.getElementById('activity_type').value = activityType;


        // Set value for archiving
        document.getElementById('archive-activity-id').value = activityId;

        // Show the activity drawer
        document.getElementById('activity-drawer').checked = true;
    }

    // Function to open the score drawer
    function openScoreDrawer(cell) {
        // Get data attributes from the clicked cell
        const studentId = cell.getAttribute('data-student-id');
        const activityId = cell.getAttribute('data-activity-id');
        const maxScore = cell.getAttribute('data-max-score');

        // Get the current score from the cell's innerText (split by '/')
        const score = cell.textContent.split(' / ')[0].trim();

        // Set the hidden input fields in the drawer
        document.getElementById('student-id').value = studentId;
        document.getElementById('activity-id').value = activityId;
        document.getElementById('max-score').value = maxScore;
        document.getElementById('max_score_display').textContent = "Max Score: " + maxScore;

        // Set the score input with the current score
        document.getElementById('student-score').value = score;

        // Open the score drawer
        document.getElementById('drawer-right-1').checked = true;
    }

    // Close all drawers
    function closeDrawer() {
        document.getElementById('drawer-right-1').checked = false; // Score drawer
        document.getElementById('activity-drawer').checked = false; // Activity drawer
    }

    // Set up click listeners for activity headers
    document.querySelectorAll('.activity-header').forEach(header => {
        header.addEventListener('click', function (event) {
            event.stopPropagation(); // Prevent propagation
            openActivityDrawer(this);
        });
    });

    // Set up click listeners for score cells
    document.querySelectorAll('.score-cell').forEach(cell => {
        cell.addEventListener('click', function (event) {
            event.stopPropagation(); // Prevent propagation
            openScoreDrawer(this);
        });
    });

    document.querySelectorAll('.editable').forEach(cell => {
        let originalContent = '';

        // Handle cell click
        cell.addEventListener('focus', function () {
            // Save the original content in case the user cancels the edit
            originalContent = this.textContent;
            // Clear the score so the user can start fresh
            this.textContent = '';
        });

        // Handle cell losing focus (blur event)
        cell.addEventListener('blur', function () {
            const studentId = this.getAttribute('data-student-id');
            const activityId = this.getAttribute('data-activity-id');
            const maxScore = parseFloat(this.getAttribute('data-max-score'));

            let newScore = this.textContent.trim();

            // If the user leaves the field empty, reset to the original value
            if (newScore === '') {
                this.textContent = originalContent;
                return;
            }

            let numericScore = parseFloat(newScore);

            // Validate if the input is a valid number and within the max score range
            if (isNaN(numericScore) || numericScore < 0 || numericScore > maxScore) {
                alert(`Please enter a valid score between 0 and ${maxScore}`);
                this.textContent = originalContent;
                return;
            }

            // Prepare data to send
            const formData = new FormData();
            formData.append('student_id', studentId);
            formData.append('activity_id', activityId);
            formData.append('score', numericScore);

            // Send the data to the PHP script via AJAX
            fetch('../update_score.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update the content with the new score and max score

                        if (numericScore === 0) {
                            this.innerHTML = `<span class="opacity-50">${numericScore}</span> / ${maxScore}`;
                        } else {
                            this.innerHTML = `<span class="opacity-100">${numericScore}</span> / ${maxScore}`;
                        }
                    } else {
                        // Reset the content if there was an error
                        this.textContent = originalContent;
                    }
                })
                .catch(error => console.error('Error:', error));
        });

        // Handle pressing Enter to submit the score
        cell.addEventListener('keydown', function (event) {
            if (event.key === 'Enter') {
                event.preventDefault(); // Prevent the default newline behavior
                this.blur(); // Trigger the blur event to save the score
            }
        });
    });

    document.addEventListener('DOMContentLoaded', () => {
        const studentScores = document.querySelectorAll('.student-score');
        // Loop through each student score element
        studentScores.forEach(studentScore => {
            // Check if the text content of the current student score is not '0'
            if (studentScore.textContent.trim() !== '0') {
                // Remove 'opacity-50' class and add 'opacity-100' class
                studentScore.classList.remove('opacity-50');
                studentScore.classList.add('opacity-100');
            }
        });
    });

    $(document).ready(function () {
        $('#finalized-checkbox').change(function () {
            var isChecked = $(this).is(':checked') ? 1 : 0; // Set value based on checkbox state
            var gradesheet_id = <?php echo isset($_GET['gradesheet_id']) ? json_encode($_GET['gradesheet_id']) : '0'; ?>; // Get the gradesheet ID

            $.ajax({
                url: '../../../connection/update_gradesheet.php', // Your PHP file to handle the update
                type: 'POST',
                data: {
                    gradesheet_id: gradesheet_id,
                    is_finalized: isChecked
                },
                success: function (response) {
                    console.log(response); // Optional: Log the response
                },
                error: function (xhr, status, error) {
                    console.error(error); // Optional: Log any errors
                }
            });
        });
    });

    // PHP variables passed to JavaScript
    const gradesheetId = "<?php echo $gradesheet_id; ?>";
    const sectionId = "<?php echo $section_id; ?>";

    // Get all the radio buttons
    const buttons = document.querySelectorAll('input[name="quarterFilter"]');

    // Add a change event listener to each radio button
    buttons.forEach(button => {
        button.addEventListener('change', function () {
            // Get the value from data-content
            const quarter = this.getAttribute('data-content');
            // Redirect to the respective quarter page with PHP variables as query parameters
            window.location.href = `${quarter}q-grades.php?gradesheet_id=${gradesheetId}&section_id=${sectionId}`;
        });
    });
</script>




</html>
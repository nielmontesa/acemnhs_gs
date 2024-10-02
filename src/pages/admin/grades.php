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
                            <span class="menu-title">Welcome, Username</span>
                            <ul class="menu-items">
                                <a href="departments.php">
                                    <li class="menu-item ">
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
        <main class="main-content flex-1 p-8 w-fit overflow-x-auto">
            <label for="sidebar-mobile-fixed" class="btn-primary btn sm:hidden">Open Sidebar</label>

            <?php
            // Include your database connection
            include '../../connection/connection.php';

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
                    echo "<h1>Gradesheet for " . htmlspecialchars($gradesheet['subject']) . "</h1>";

                    // Add the drawer form for adding activities
                    ?>
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
                            $add_activity_query = "INSERT INTO activity (activity_name, total_score, activity_type, gradesheet_id) VALUES (?, ?, ?, ?)";
                            $add_stmt = $conn->prepare($add_activity_query);
                            $add_stmt->bind_param("sisi", $activity_name, $total_score, $activity_type, $gradesheet_id);

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


            <div class="overflow-x-auto pt-8 max-w-3xl lg:max-w-none">
                <table class="table-compact table w-full" id="student-table">
                    <thead>
                        <tr>
                            <th>LRN</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <?php
                            include "../../connection/connection.php";
                            if (isset($_GET['section_id']) && isset($_GET['gradesheet_id'])) {

                                $section_id = $_GET['section_id'];
                                $gradesheet_id = $_GET['gradesheet_id'];

                                $activity_sql = "SELECT * FROM activity WHERE gradesheet_id = $gradesheet_id";
                                $activity_result = $conn->query($activity_sql);

                                if ($activity_result->num_rows > 0) {
                                    while ($activity = $activity_result->fetch_assoc()) {
                                        echo "<th class='activity-header' data-activity-id='" . $activity['activity_id'] . "' data-activity-name='" . htmlspecialchars($activity['activity_name']) . "' data-total-score='" . $activity['total_score'] . "' onclick='openActivityDrawer(this)'>" . htmlspecialchars($activity['activity_name']) . "</th>";
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
                            $sql = "SELECT * FROM students WHERE section_ID = $section_id AND is_archived = 0";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($student = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<th>" . htmlspecialchars($student['LRN']) . "</th>";
                                    echo "<th>" . htmlspecialchars($student['first_name']) . "</th>";
                                    echo "<td>" . htmlspecialchars($student['last_name']) . "</td>";

                                    // Fetch the total score for each activity for this student
                                    if (isset($gradesheet_id)) {
                                        // Reset the pointer of the activity result to loop through it again
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

                                            // Determine the score to display
                                            $student_score = $student_score_row ? $student_score_row['score'] : 0;

                                            // Display the score in the desired format
                                            echo "<td class='score-cell' data-student-id='" . $student['student_id'] . "' data-activity-id='$activity_id' data-max-score='$total_score' onclick='openDrawer(this)'>" . htmlspecialchars($student_score) . " / " . htmlspecialchars($total_score) . "</td>";
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
                                        <form method="POST" action="../../connection/submit_score.php" class="flex">
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
                    <form method="POST" action="../../connection/edit_activity.php">
                        <div>
                            <label for="activity-name" class="block">Activity Name</label>
                            <input type="text" id="activity-name" name="activity_name" class="input w-full" required>
                        </div>
                        <div>
                            <label for="total-score" class="block">Total Score</label>
                            <input type="number" id="total-score" name="total_score" class="input w-full" required>
                        </div>
                        <input type="hidden" name="redirect_url"
                            value="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" />
                        <input type="hidden" id="activity-id-edit" name="activity_id">

                        <!-- Buttons for saving changes and archiving -->
                        <div class="flex flex-row justify-end items-end gap-2 mt-4">
                            <input type="hidden" id="archive-activity-id" name="activity_id"
                                value="<?php echo htmlspecialchars($activity_id); ?>" />
                            <button type="submit" name="action" value="archive" class="btn btn-error">Delete</button>
                            <button type="submit" name="action" value="save" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    // Function to open the activity drawer
    function openActivityDrawer(headerElement) {
        const activityId = headerElement.getAttribute('data-activity-id');
        const activityName = headerElement.getAttribute('data-activity-name');
        const totalScore = headerElement.getAttribute('data-total-score');

        // Update to the new ID
        document.getElementById('activity-id-edit').value = activityId;
        document.getElementById('activity-name').value = activityName;
        document.getElementById('total-score').value = totalScore;

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
</script>




</html>
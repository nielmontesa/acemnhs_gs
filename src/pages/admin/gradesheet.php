<?php
session_start();
include '../../connection/connection.php';

// Check if we are accessing a new gradesheet; if yes, clear the old session data
if (isset($_GET['section_id'])) {
    // Unset previous session values
    unset($_SESSION['section_id']);
    unset($_SESSION['gradesheet_id']);

    // Set the new session values
    $_SESSION['section_id'] = $_GET['section_id'];
}

// Do similar for gradesheet_id if necessary
if (isset($_GET['gradesheet_id'])) {
    unset($_SESSION['gradesheet_id']);
    $_SESSION['gradesheet_id'] = $_GET['gradesheet_id'];
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
                            echo "Gradesheets of Grade ";
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
            <p class='pt-2'>This is currently all of the gradesheets in

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
            <?php
            if (isset($_GET['section_id'])) {
                $section_id = $_GET['section_id'];
                $section_details_query = "SELECT section_name, grade_level, section_id FROM section WHERE section_id = $section_id";
                $result = $conn->query($section_details_query);
            }
            ?>
            </p>
            <br>
            <table class="table-compact table-zebra table w-full">
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // SQL query to get gradesheet details for the specific section_id
                    if (isset($section_id)) {
                        $sql = "SELECT g.gradesheet_id, g.subject, s.section_name, s.grade_level
                    FROM gradesheet g
                    INNER JOIN section s ON g.section_id = s.section_id
                    WHERE s.section_id = $section_id AND s.is_archived = 0";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0):
                            ?>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <th><?php echo $row['subject']; ?></th>
                                    <td>
                                        <a
                                            href="quarters/1q-grades.php?gradesheet_id=<?php echo $row['gradesheet_id']; ?>&section_id=<?php echo $section_id; ?>">
                                            <button class="btn btn-secondary">View</button>
                                        </a>

                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">No gradesheets found for this section.</td>
                        </tr>
                    <?php endif;
                    } ?>
                </tbody>
            </table>

        </main>
    </div>
</body>


</html>
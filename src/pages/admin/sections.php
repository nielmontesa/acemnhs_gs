<?php
session_start();
include '../../connection/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $section_name = $_POST['sectionname'];
    $grade_level = $_POST['gradelevel'];

    // Prepared statement to insert section into the database
    $stmt = $conn->prepare("INSERT INTO section (section_name, grade_level) VALUES (?, ?)");
    $stmt->bind_param("si", $section_name, $grade_level);

    if ($stmt->execute()) {
        echo "New section added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
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
                <form action="../../connection/add_section.php" method="POST">
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
                                    <input class="input-block input" placeholder="Enter section name" name="sectionname"
                                        type="text" required />
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
                            </div>
                            <div class="h-full flex flex-row justify-end items-end gap-2">
                                <button type="reset" class="btn btn-ghost">Cancel</button>
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </div>
                    </div>
                </form>


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
                                <th>Student Count</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Assuming you have a valid database connection in $connection
                            $sql = "SELECT * FROM section WHERE grade_level = 7 AND is_archived = 0";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0):
                                ?>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $row['grade_level']; ?></td>
                                        <td><?php echo $row['section_name']; ?></td>
                                        <td>0</td>
                                        <td>
                                            <a href="students.php?section_id=<?php echo $row['section_id']; ?>">
                                                <button class="btn btn-secondary">View</button>
                                            </a>
                                            <label class="btn btn-error"
                                                for="modal-1-<?php echo $row['section_id']; ?>">Archive</label>
                                            <input class="modal-state" id="modal-1-<?php echo $row['section_id']; ?>"
                                                type="checkbox" />
                                            <div class="modal">
                                                <label class="modal-overlay"
                                                    for="modal-1-<?php echo $row['section_id']; ?>"></label>
                                                <form method="POST" action="../../connection/archive_section.php"
                                                    class="modal-content flex flex-col gap-5">
                                                    <label for="modal-1-<?php echo $row['section_id']; ?>"
                                                        class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</label>
                                                    <h2 class="text-xl">Archive Section?</h2>
                                                    <span>Are you sure you want to archive this section?</span>

                                                    <!-- Hidden input to send section ID -->
                                                    <input type="hidden" name="section_id"
                                                        value="<?php echo $row['section_id']; ?>" />

                                                    <div class="flex gap-3">
                                                        <button class="btn btn-error btn-block" type="submit">Archive</button>
                                                        <label for="modal-1-<?php echo $row['section_id']; ?>"
                                                            class="btn btn-block">Cancel</label>
                                                    </div>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">No sections found for Grade 7.</td>
                        </tr>
                    <?php endif; ?>
                    </table>
                </div>
                <div class="hidden w-full overflow-x-auto pt-8" data-grade="Grade 8">
                    <table class="table-hover table w-full">
                        <thead>
                            <tr>
                                <th>Grade Level</th>
                                <th>Section Name</th>
                                <th>Student Count</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Assuming you have a valid database connection in $connection
                            $sql = "SELECT * FROM section WHERE grade_level = 8 AND is_archived = 0";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0):
                                ?>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $row['grade_level']; ?></td>
                                        <td><?php echo $row['section_name']; ?></td>
                                        <td>0</td>
                                        <td>
                                            <a href="students.php?section_id=<?php echo $row['section_id']; ?>">
                                                <button class="btn btn-secondary">View</button>
                                            </a>
                                            <label class="btn btn-error"
                                                for="modal-1-<?php echo $row['section_id']; ?>">Archive</label>
                                            <input class="modal-state" id="modal-1-<?php echo $row['section_id']; ?>"
                                                type="checkbox" />
                                            <div class="modal">
                                                <label class="modal-overlay"
                                                    for="modal-1-<?php echo $row['section_id']; ?>"></label>
                                                <form method="POST" action="../../connection/archive_section.php"
                                                    class="modal-content flex flex-col gap-5">
                                                    <label for="modal-1-<?php echo $row['section_id']; ?>"
                                                        class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</label>
                                                    <h2 class="text-xl">Archive Section?</h2>
                                                    <span>Are you sure you want to archive this section?</span>

                                                    <!-- Hidden input to send section ID -->
                                                    <input type="hidden" name="section_id"
                                                        value="<?php echo $row['section_id']; ?>" />

                                                    <div class="flex gap-3">
                                                        <button class="btn btn-error btn-block" type="submit">Archive</button>
                                                        <label for="modal-1-<?php echo $row['section_id']; ?>"
                                                            class="btn btn-block">Cancel</label>
                                                    </div>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">No sections found for Grade 8.</td>
                        </tr>
                    <?php endif; ?>
                    </table>
                </div>
                <div class="hidden w-full overflow-x-auto pt-8" data-grade="Grade 9">
                    <table class="table-hover table w-full">
                        <thead>
                            <tr>
                                <th>Grade Level</th>
                                <th>Section Name</th>
                                <th>Student Count</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Assuming you have a valid database connection in $connection
                            $sql = "SELECT * FROM section WHERE grade_level = 9 AND is_archived = 0";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0):
                                ?>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $row['grade_level']; ?></td>
                                        <td><?php echo $row['section_name']; ?></td>
                                        <td>0</td>
                                        <td>
                                            <a href="students.php?section_id=<?php echo $row['section_id']; ?>">
                                                <button class="btn btn-secondary">View</button>
                                            </a>
                                            <label class="btn btn-error"
                                                for="modal-1-<?php echo $row['section_id']; ?>">Archive</label>
                                            <input class="modal-state" id="modal-1-<?php echo $row['section_id']; ?>"
                                                type="checkbox" />
                                            <div class="modal">
                                                <label class="modal-overlay"
                                                    for="modal-1-<?php echo $row['section_id']; ?>"></label>
                                                <form method="POST" action="../../connection/archive_section.php"
                                                    class="modal-content flex flex-col gap-5">
                                                    <label for="modal-1-<?php echo $row['section_id']; ?>"
                                                        class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</label>
                                                    <h2 class="text-xl">Archive Section?</h2>
                                                    <span>Are you sure you want to archive this section?</span>

                                                    <!-- Hidden input to send section ID -->
                                                    <input type="hidden" name="section_id"
                                                        value="<?php echo $row['section_id']; ?>" />

                                                    <div class="flex gap-3">
                                                        <button class="btn btn-error btn-block" type="submit">Archive</button>
                                                        <label for="modal-1-<?php echo $row['section_id']; ?>"
                                                            class="btn btn-block">Cancel</label>
                                                    </div>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">No sections found for Grade 9.</td>
                        </tr>
                    <?php endif; ?>
                    </table>
                </div>
                <div class="hidden w-full overflow-x-auto pt-8" data-grade="Grade 10">
                    <table class="table-hover table w-full">
                        <thead>
                            <tr>
                                <th>Grade Level</th>
                                <th>Section Name</th>
                                <th>Student Count</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Assuming you have a valid database connection in $connection
                            $sql = "SELECT * FROM section WHERE grade_level = 10 AND is_archived = 0";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0):
                                ?>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $row['grade_level']; ?></td>
                                        <td><?php echo $row['section_name']; ?></td>
                                        <td>0</td>
                                        <td>
                                            <a href="students.php?section_id=<?php echo $row['section_id']; ?>">
                                                <button class="btn btn-secondary">View</button>
                                            </a>
                                            <label class="btn btn-error"
                                                for="modal-1-<?php echo $row['section_id']; ?>">Archive</label>
                                            <input class="modal-state" id="modal-1-<?php echo $row['section_id']; ?>"
                                                type="checkbox" />
                                            <div class="modal">
                                                <label class="modal-overlay"
                                                    for="modal-1-<?php echo $row['section_id']; ?>"></label>
                                                <form method="POST" action="../../connection/archive_section.php"
                                                    class="modal-content flex flex-col gap-5">
                                                    <label for="modal-1-<?php echo $row['section_id']; ?>"
                                                        class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</label>
                                                    <h2 class="text-xl">Archive Section?</h2>
                                                    <span>Are you sure you want to archive this section?</span>

                                                    <!-- Hidden input to send section ID -->
                                                    <input type="hidden" name="section_id"
                                                        value="<?php echo $row['section_id']; ?>" />

                                                    <div class="flex gap-3">
                                                        <button class="btn btn-error btn-block" type="submit">Archive</button>
                                                        <label for="modal-1-<?php echo $row['section_id']; ?>"
                                                            class="btn btn-block">Cancel</label>
                                                    </div>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">No sections found for Grade 10.</td>
                        </tr>
                    <?php endif; ?>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>

</html>
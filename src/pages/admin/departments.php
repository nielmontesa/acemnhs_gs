<?php
session_start();
include '../../connection/connection.php';

// If the user is not logged in or not an admin, redirect to the login page
if (!isset($_SESSION['logged_in']) || ($_SESSION['logged_in']) !== true || $_SESSION['role'] !== 'admin') {
    header('Location: ../../index.php'); // Redirect to login page
    exit(); // End script after redirection
}

$sql = "
    SELECT d.department_id, d.department_name, COUNT(t.teacher_id) AS teacher_count 
    FROM department d 
    LEFT JOIN teachers t ON d.department_id = t.department_id AND t.is_archived = 0 
    WHERE d.is_archived = 0 
    GROUP BY d.department_id, d.department_name
";
$result = mysqli_query($conn, $sql);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header("Location: ../../pages/admin/departments.php");
    $departmentName = $_POST['department_name'];

    // Prepare and execute the SQL query
    $sql = "INSERT INTO department (department_name) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $departmentName);
    $stmt->execute();

    // Display an alert message
    echo "<script>alert('Department created successfully!');</script>";
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
                                    <li class="menu-item  menu-active">
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
                                    <li class="menu-item">
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

            <h1 class="text-xl font-bold">Departments</h1>
            <p class="pt-2">This is currently all of the departments in the school.</p>


            <div class="mt-8">
                <input type="checkbox" id="drawer-right" class="drawer-toggle" />
                <label for="drawer-right" class="btn btn-primary">Add Department</label>
                <label class="overlay" for="drawer-right"></label>
                <div class="drawer drawer-right">
                    <div class="drawer-content pt-10 flex flex-col h-full">
                        <label for="drawer-right"
                            class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</label>
                        <div>
                            <h2 class="text-xl font-medium">Add Department</h2>
                            <form action="departments.php" method="post">
                                <input class="input py-1.5 my-3" name="department_name" placeholder="Department Name" />
                        </div>
                        <div class="h-full flex flex-row justify-end items-end gap-2">
                            <button class="btn btn-ghost">Cancel</button>
                            <button class="btn btn-primary">Create</button>
                        </div>
                        </form>
                    </div>
                </div>
                <a href="all_teachers.php">
                    <button class="btn btn-outline-primary">View All Teachers</button></a>
            </div>
            <div class="flex w-full overflow-x-auto pt-8">
                <table class="table-compact table-zebra table w-full">
                    <thead>
                        <tr>
                            <th>Department</th>
                            <th>Teacher Count</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['department_name']); ?></td>
                                    <td><?php echo $row['teacher_count']; ?></td>
                                    <td>
                                        <a href="teachers.php?department_id=<?php echo $row['department_id']; ?>">
                                            <button class="btn btn-secondary">View</button>
                                        </a>
                                        <label class="btn btn-error"
                                            for="modal-<?php echo $row['department_id']; ?>">Archive</label>
                                        <input class="modal-state" id="modal-<?php echo $row['department_id']; ?>"
                                            type="checkbox" />
                                        <div class="modal">
                                            <label class="modal-overlay"
                                                for="modal-<?php echo $row['department_id']; ?>"></label>
                                            <div class="modal-content flex flex-col gap-5">
                                                <label for="modal-<?php echo $row['department_id']; ?>"
                                                    class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</label>
                                                <h2 class="text-xl">Archive department?</h2>
                                                <span>Are you sure you want to Archive this department?</span>
                                                <form method="POST" action="../../connection/archive_department.php">
                                                    <input type="hidden" name="department_id"
                                                        value="<?php echo $row['department_id']; ?>" />
                                                    <div class="flex gap-3">
                                                        <button type="submit" class="btn btn-error btn-block">Archive</button>
                                                        <label for="modal-<?php echo $row['department_id']; ?>"
                                                            class="btn btn-block">Cancel</label>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3">No departments found in this view.</td>
                            </tr>
                        <?php endif; ?>
                        <?php $conn->close(); ?>
                    </tbody>
                </table>


            </div>
        </main>
    </div>
</body>


</html>
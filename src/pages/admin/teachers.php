<?php
session_start();
include '../../connection/connection.php';

// Check if department_id is passed via the URL
if (isset($_GET['department_id'])) {
    $department_id = $_GET['department_id'];

    // Fetch all teachers and their respective department names from the specific department
    $sql = "SELECT teachers.*, department.department_name 
            FROM teachers 
            JOIN department ON teachers.department_id = department.department_id 
            WHERE teachers.is_archived = 0 AND teachers.department_id = ?";

    // Prepare and bind the statement to avoid SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $department_id);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    
}

if (isset($_GET['department_id'])) {
    $department_id = $_GET['department_id'];

    // Fetch the department name based on the department_id
    $sql_department = "SELECT department_name FROM department WHERE department_id = ?";
    $stmt_department = $conn->prepare($sql_department);
    $stmt_department->bind_param("i", $department_id);
    $stmt_department->execute();
    $stmt_department->bind_result($department_name);
    $stmt_department->fetch();
    $stmt_department->close();
} else {
    exit; // Exit if the department ID is not provided
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

            <h1 class="text-xl font-bold"><?php echo htmlspecialchars($department_name); ?> Department</h1>
            <p class="pt-2">This is the <?php echo htmlspecialchars($department_name); ?> department of the school.</p>


            <form method="post" action="../../connection/add_teacher_department.php" class="mt-8">
                <input type="checkbox" id="drawer-right" class="drawer-toggle" />
                <label for="drawer-right" class="btn btn-primary">Add Teacher</label>
                <label class="overlay" for="drawer-right"></label>
                <div class="drawer drawer-right">
                    <div class="drawer-content pt-10 flex flex-col h-full">
                        <label for="drawer-right"
                            class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</label>
                        <div>
                            <h2 class="text-xl font-medium">Add Teacher</h2>
                            <label for="teacherfirstname">
                                <span class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Teacher First
                                    Name</span>
                                <input class="input-block input" placeholder="Please enter your first name."
                                    name="teacherfname" type="text" />
                            </label>
                            <label for="teacherlastname">
                                <span class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Teacher Last
                                    Name</span>
                                <input class="input-block input" placeholder="Please enter your last name."
                                    name="teacherlname" type="text" />
                            </label>
                            <label for="e-mail">
                                <span class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">E-mail</span>
                                <input class="input-block input" placeholder="Please enter your e-mail."
                                    name="teachermail" type="email" />
                            </label>
                            <label for="username">
                                <span class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Teacher Number</span>
                                <input class="input-block input" placeholder="Please enter the teacher number."
                                    name="username" type="text" />
                            </label>
                            <label for="Password">
                                <span class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Password</span>
                                <input class="input-block input" placeholder="Please enter your password."
                                    name="password" type="password" />
                            </label>
                             <input type="hidden" name="department_id" value="<?php echo htmlspecialchars($department_id); ?>">
                            <?php
                            // Fetch department data from the database
                            $department_query = "SELECT department_id, department_name FROM department WHERE is_archived = 0";
                            $department_result = $conn->query($department_query);
                            ?>
                            <label for="department_id">
    <span class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Department</span>
    <select name="department_id" id="department_id" class="select">
        <option value="">Select department...</option>
        <?php if ($department_result->num_rows > 0): ?>
                                        <?php while ($department = $department_result->fetch_assoc()): ?>
                                            <option value="<?php echo $department['department_id']; ?>" <?php echo (isset($department_id) && $department['department_id'] == $department_id) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($department['department_name']); ?>
                                            </option>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <option value="">No departments available</option>
                                    <?php endif; ?>
                                </select>
                            </label>

            
            
                        </div>
                        <div class="h-full flex flex-row justify-end items-end gap-2">
                            <button class="btn btn-ghost">Cancel</button>
                            <button class="btn btn-primary">Create</button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="flex w-full overflow-x-auto pt-8">
                <div class="flex w-full overflow-x-auto">
                    <table class="table-compact table-zebra table">
                        <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Department</th>
                                <th>E-mail</th>
                                <th>Teacher Number</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0): ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <th><?php echo $row['first_name']; ?></th>
                                        <td><?php echo $row['last_name']; ?></td>
                                        <td><?php echo $row['department_name']; ?></td>
                                        <td><?php echo $row['email']; ?></td>
                                        <td><?php echo $row['username']; ?></td>
                                        <td>
                                            <?php
                                            $teacher_id = $row['teacher_id'];
                                            ?>

                                            <!-- UPDATE TEACHER -->
                                            <input type="checkbox" id="drawer-toggle-<?php echo $teacher_id; ?>"
                                                class="drawer-toggle" />
                                            <label for="drawer-toggle-<?php echo $teacher_id; ?>"
                                                class="btn btn-secondary">Edit</label>
                                            <label class="overlay" for="drawer-toggle-<?php echo $teacher_id; ?>"></label>

                                            <?php
                                                // Fetch department data from the database
                                                $department_query = "SELECT department_id, department_name FROM department WHERE is_archived = 0";
                                                $department_result = $conn->query($department_query);

                                                // Fetch current teacher's department_id
                                                $current_department_query = "SELECT department_id FROM teachers WHERE teacher_id = {$row['teacher_id']}";
                                                $current_department_result = $conn->query($current_department_query);
                                                $current_department = $current_department_result->fetch_assoc()['department_id'];
                                                ?>
                                            
                                            <form method="post" action="../../connection/update_teacher.php" class="drawer drawer-right">
                                                <input type="hidden" name="teacher_id" value="<?php echo $row['teacher_id']; ?>" />
                                                <div class="drawer-content pt-10 flex flex-col h-full">
                                                    <label for="drawer-toggle-<?php echo $teacher_id; ?>"
                                                        class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</label>
                                                    <div>
                                                        <h2 class="text-xl font-medium">Edit Teacher</h2>
                                                        <div class="flex flex-col gap-2">
                                                            <!-- Teacher First Name -->
                                                            <label for="teacherfirstname-<?php echo $teacher_id; ?>">
                                                                <span class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Teacher First Name</span> <br>
                                                                <input class="input-block block input" name="teacherfname" type="text" id="teacherfirstname-<?php echo $teacher_id; ?>" value="<?php echo $row['first_name']; ?>" />
                                                            </label>
                                            
                                                            <!-- Teacher Last Name -->
                                                            <label for="teacherlastname-<?php echo $teacher_id; ?>">
                                                                <span class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Teacher Last Name</span> <br>
                                                                <input class="input-block input" placeholder="Please enter your last name." name="teacherlname"
                                                                    type="text" id="teacherlastname-<?php echo $teacher_id; ?>"
                                                                    value="<?php echo $row['last_name']; ?>" />
                                                            </label>
                                            
                                                            <!-- Teacher E-mail -->
                                                            <label for="email-<?php echo $teacher_id; ?>">
                                                                <span class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">E-mail</span><br>
                                                                <input class="input-block input" placeholder="Please enter your e-mail." name="teachermail"
                                                                    type="email" id="email-<?php echo $teacher_id; ?>" value="<?php echo $row['email']; ?>" />
                                                            </label>
                                            
                                                            <!-- Username -->
                                                            <label for="username-<?php echo $teacher_id; ?>">
                                                                <span class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Teacher Number</span><br>
                                                                <input class="input-block input" placeholder="Please enter the teacher number." name="username"
                                                                    type="text" id="username-<?php echo $teacher_id; ?>" value="<?php echo $row['username']; ?>" />
                                                            </label>
                                            
                                                            <!-- Password -->
                                                            <label for="password-<?php echo $teacher_id; ?>">
                                                                <span class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Password</span><br>
                                                                <input class="input-block input" placeholder="Please enter your password." name="password"
                                                                    type="password" id="password-<?php echo $teacher_id; ?>" />
                                                            </label>
                                            
                                                            <!-- Department Select Input -->
                                                            <label for="department_id-<?php echo $teacher_id; ?>">
                                                                <span class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Department</span><br>
                                                                <select name="department_id" id="department_id-<?php echo $teacher_id; ?>" class="select">
                                                                    <?php if ($department_result->num_rows > 0): ?>
                                                                        <?php while ($department = $department_result->fetch_assoc()): ?>
                                                                            <option value="<?php echo $department['department_id']; ?>" <?php echo $department['department_id'] == $current_department ? 'selected' : ''; ?>>
                                                                                <?php echo htmlspecialchars($department['department_name']); ?>
                                                                            </option>
                                                                        <?php endwhile; ?>
                                                                    <?php else: ?>
                                                                        <option value="">No departments available</option>
                                                                    <?php endif; ?>
                                                                </select>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="h-full flex flex-row justify-end items-end gap-2">
                                                        <button class="btn btn-ghost">Cancel</button>
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </div>
                                                </div>
                                            </form>
                                            <label class="btn btn-error" for="modal-<?php echo $teacher_id; ?>">Archive</label>
                                            <input class="modal-state" id="modal-<?php echo $teacher_id; ?>" type="checkbox" />
                                            <div class="modal">
                                                <label class="modal-overlay" for="modal-<?php echo $teacher_id; ?>"></label>
                                                <div class="modal-content flex flex-col gap-5">
                                                    <label for="modal-<?php echo $teacher_id; ?>"
                                                        class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</label>
                                                    <h2 class="text-xl">Archive teacher?</h2>
                                                    <span>Are you sure you want to Archive this teacher?</span>
                                                    <form method="post" action="../../connection/archive_teacher.php">
                                                         <input type="hidden" name="department_id" value="<?php echo htmlspecialchars($department_id); ?>">
                                                        <input type="hidden" name="archive_teacher_id"
                                                            value="<?php echo $row['teacher_id']; ?>" />
                                                        <div class="flex gap-3">
                                                            <button type="submit"
                                                                class="btn btn-error btn-block">Archive</button>
                                                            <label for="modal-<?php echo $teacher_id; ?>"
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
                                <td colspan="6" class="text-center text-gray-500">
                                    No teachers found in this view.
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </main>
    </div>
</body>


</html>
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
                                <a href="student_details.html">
                                    <li class="menu-item">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-75" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span>Student Details</span>
                                    </li>
                                </a>
                                <li>
                                    <input type="checkbox" id="menu-1" class="menu-toggle" checked />
                                    <label class="menu-item justify-between" for="menu-1">
                                        <div class="flex gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-75"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            <span>Grades</span>
                                        </div>

                                        <span class="menu-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                    </label>
                                    <div class="menu-item-collapse">
                                        <div class="min-h-0">
                                            <label class="menu-item-disabled menu-item ml-6">Grades</label>
                                            <a href="grades/report-card.html"><label class="menu-item ml-6">Report
                                                    Cards</label></a>

                                        </div>
                                    </div>
                                </li>
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
                                    <span class="text-xs">Parent</span>
                                </div>
                            </div>
                        </label>
                        <div class="dropdown-menu-right-top dropdown-menu ml-2">
                            <a href="settings.html" tabindex="-1" class="dropdown-item text-sm">Account settings</a>
                            <a href="../../connection/logout.php" tabindex="-1" class="dropdown-item text-sm">Logout</a>
                        </div>
                    </div>
                </section>
            </aside>
        </div>

        <main class="main-content flex-1 p-8">
            <h1 class="text-xl font-bold">Student Details</h1>
            <p class="pt-2 pb-4">These are currently all of the student details.</p>
            <div class="flex w-full overflow-x-auto">
                <table class="table-compact table max-w-4xl">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Details</th>
                            <th>Action(s)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>AKAP Status</th>
                            <td>No Active Case</td>
                            <td><button class="btn btn-error">View</button></td>
                        </tr>
                        <tr>
                            <th>Full Name</th>
                            <td>Roberto Dimagiba</td>
                            <td><button class="btn" disabled>Edit</button></td>
                        </tr>
                        <tr>
                            <th>First Name</th>
                            <td>Roberto</td>
                            <td><button class="btn" disabled>Edit</button></td>
                        </tr>
                        <tr>
                            <th>Last Name</th>
                            <td>Dimagiba</td>
                            <td><button class="btn" disabled>Edit</button></td>
                        </tr>
                        <tr>
                            <th>Parent Name</th>
                            <td>Lydia Dimagiba</td>
                            <td><button class="btn" disabled>Edit</button></td>
                        </tr>
                        <tr>
                            <th>Parent E-mail</th>
                            <td>lydiadimagiba65@gmail.com</td>
                            <td><input type="checkbox" id="drawer-right" class="drawer-toggle" />
                                <label for="drawer-right" class="btn btn-primary">Edit</label>
                                <label class="overlay" for="drawer-right"></label>
                                <div class="drawer drawer-right">
                                    <div class="drawer-content pt-10 flex flex-col h-full">
                                        <label for="drawer-right"
                                            class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</label>
                                        <div>
                                            <h2 class="text-xl font-medium">Edit field</h2>
                                            <input class="input py-1.5 my-3" placeholder="Type here..." />
                                        </div>
                                        <div class="h-full flex flex-row justify-end items-end gap-2">
                                            <button class="btn btn-ghost">Cancel</button>
                                            <button class="btn btn-primary">Edit</button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Parent Contact Number</th>
                            <td>09152233859</td>
                            <td><input type="checkbox" id="drawer-right" class="drawer-toggle" />
                                <label for="drawer-right" class="btn btn-primary">Edit</label>
                                <label class="overlay" for="drawer-right"></label>
                                <div class="drawer drawer-right">
                                    <div class="drawer-content pt-10 flex flex-col h-full">
                                        <label for="drawer-right"
                                            class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</label>
                                        <div>
                                            <h2 class="text-xl font-medium">Edit field</h2>
                                            <input class="input py-1.5 my-3" placeholder="Type here..." />
                                        </div>
                                        <div class="h-full flex flex-row justify-end items-end gap-2">
                                            <button class="btn btn-ghost">Cancel</button>
                                            <button class="btn btn-primary">Edit</button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>


</html>
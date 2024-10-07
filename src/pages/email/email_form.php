<?php
session_start();
include '../../connection/connection.php';
// Get the student and adviser details from the URL
$parent_email = isset($_GET['email']) ? htmlspecialchars($_GET['email']) : '';
$student_name = isset($_GET['name']) ? htmlspecialchars($_GET['name']) : '';
$adviser_id = isset($_GET['adviser_id']) ? htmlspecialchars($_GET['adviser_id']) : '';

// SQL query to fetch the adviser's first and last name along with their email
$adviser_sql = "SELECT first_name, last_name, email FROM teachers WHERE teacher_id = '$adviser_id'";

// Execute the query
$adviser_result = $conn->query($adviser_sql);

// Check if the adviser exists and fetch the details
if ($adviser_result && $adviser_result->num_rows > 0) {
    $adviser_data = $adviser_result->fetch_assoc();
    $adviser_first_name = $adviser_data['first_name'];
    $adviser_last_name = $adviser_data['last_name'];
    $adviser_email = $adviser_data['email'];
} else {
    // Handle the case where the adviser is not found
    $adviser_first_name = "Unknown"; // Fallback first name
    $adviser_last_name = "Adviser"; // Fallback last name
    $adviser_email = "unknown@school.edu"; // Fallback email
}

// Prepare the subject and message
$subject = "Important Meeting Regarding {$student_name}'s Academic Progress";
$message = "Dear Parent/Guardian,\n\n" .
    "I hope this message finds you well. I am writing to inform you about a concern regarding your child, {$student_name}, who is currently at risk of failing my class.\n\n" .
    "I believe that with additional support and communication, we can help {$student_name} improve their understanding of the material and succeed in their studies. I would like to invite you to meet with me at your earliest convenience to discuss this matter in more detail.\n\n" .
    "Please let me know your available times, and I will do my best to accommodate. Your involvement is crucial to ensuring that {$student_name} receives the support they need.\n\n" .
    "Thank you for your attention to this important matter. I look forward to hearing from you soon.\n\n" .
    "Best regards,\n\n" .
    "{$adviser_first_name} {$adviser_last_name}\n" . // Concatenate first and last name
    "Teacher\n" .
    "Antonio C. Esguerra Memorial National High School\n" .
    "{$adviser_email}";
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
    <style>
        .alert {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            /* Ensure it's above other content */
            display: none;
            /* Initially hidden */
            opacity: 1;
            transition: opacity 1s ease-in-out;
        }

        .alert.show {
            display: flex;
        }

        .fade-out {
            opacity: 0;
        }
    </style>
</head>

<body>
    <!-- Check for session messages -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success w-fit show" id="successAlert">
            <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M24 4C12.96 4 4 12.96 4 24C4 35.04 12.96 44 24 44C35.04 44 44 35.04 44 24C44 12.96 35.04 4 24 4ZM18.58 32.58L11.4 25.4C10.62 24.62 10.62 23.36 11.4 22.58C12.18 21.8 13.44 21.8 14.22 22.58L20 28.34L33.76 14.58C34.54 13.8 35.8 13.8 36.58 14.58C37.36 15.36 37.36 16.62 36.58 17.4L21.4 32.58C20.64 33.36 19.36 33.36 18.58 32.58Z"
                    fill="#00BA34" />
            </svg>
            <div class="flex flex-col">
                <span>E-mail Sent</span>
                <span class="text-content2">Your e-mail has been sent!</span>
            </div>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    </div>
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
                                <a href="../admin/departments.php">
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
                                <a href="../admin/sections.php">
                                    <li class="menu-item">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-75" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        <span>Students</span>
                                    </li>
                                </a>
                                <a href="../admin/reports.php">
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
            <section class="bg-gray-2 rounded-xl">
                <div class="p-8 rounded-lg">
                    <h1 class="text-2xl font-bold pb-4 ml-1">Parent Contact Form</h1>
                    <form action="send_email.php" method="POST" class="space-y-4">
                        <div class="w-full">
                            <label for="email">
                                <span class="text-xs pb-8 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Parent E-mail</span>
                            </label>
                            <input class="input max-w-full" placeholder="Parent E-mail" type="email" name="email"
                                id="email" value="<?php echo $parent_email; ?>" />
                        </div>

                        <div>
                            <label for="subject">
                                <span class="text-xs pb-8 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Subject</span>
                            </label>
                            <input class="input max-w-full" placeholder="Subject" type="text" name="subject"
                                id="subject" value="<?php echo $subject; ?>" />
                        </div>

                        <div class="w-full">
                            <label for="message">
                                <span class="text-xs pb-8 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Message</span>
                            </label>

                            <textarea class="textarea max-w-full h-fit" placeholder="Message" name="message" rows="20"
                                id="message"><?php echo htmlspecialchars($message); ?></textarea>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="rounded-lg btn btn-primary btn-block">Send Email</button>
                        </div>
                    </form>
                </div>
            </section>
        </main>
    </div>
</body>
<script>
    // Show the alert for 5 seconds and then fade out
    window.onload = function () {
        const alert = document.getElementById('successAlert');
        if (alert) {
            setTimeout(() => {
                alert.classList.add('fade-out');
                setTimeout(() => {
                    alert.style.display = 'none'; // Hide after fading out
                }, 1000); // Wait for the fade-out duration before hiding
            }, 5000); // Show alert for 5 seconds
        }
    }
</script>

</html>
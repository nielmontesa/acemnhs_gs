<?php
session_start();

// If the user is already logged in, redirect them based on their role
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    if ($_SESSION['role'] === 'admin') {
        header('Location: pages/admin/departments.php');
    } elseif ($_SESSION['role'] === 'teacher') {
        header('Location: pages/teacher/sections.php');
    }
    exit(); // End script after redirection
}
?>

<!DOCTYPE html>
<html data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light only">

    <meta http-equiv="Cache-Control" content="no-store">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <title>Antonio C. Esguerra MNHS</title>
    <link rel="stylesheet" href='styles/tailwind.css'>
    <link rel="stylesheet" href='styles/style.css'>
    <lisnk rel="icon" href="assets/acemnhs_logo.png">
</head>

<body class="h-screen flex justify-center items-center">
    <div
        class="bg-gray-100 border-2 border-gray-200 rounded-xl py-16 px-12 m-6 flex flex-col gap-4 align-center justify-center">
        <div class="w-full rounded flex justify-center">
            <img src="./assets/acemnhs_logo.png" />
        </div>
        <h1 class="font-bold text-4xl text-center">Antonio C. Esguerra MNHS</h1>
        <form action="connection/login-process.php" method="POST" class="form-control">
            <div class="flex flex-col w-full gap-4">
                <div class="w-full flex place-content-center">
                    <div class="btn-group mx-auto">
                        <input type="radio" name="role" value="admin" data-content="Admin"
                            class="btn bg-[rgba(0,0,0,0.02)]" checked required />
                        <input type="radio" name="role" value="teacher" data-content="Teacher"
                            class="btn bg-[rgba(0,0,0,0.02)]" required />
                    </div>
                </div>
                <div class="flex flex-col gap-2">
                    <label for="username">
                        <span class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Username</span>
                        <input class="input-block input" placeholder="Please enter your username." name="username"
                            type="text" required />
                    </label>
                    <label for="password">
                        <span class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Password</span>
                        <input class="input-block input" placeholder="Please enter your password." name="password"
                            type="password" required />
                    </label>
                    <button class="btn btn-primary btn-block mt-2" type="submit" name="login">Log-in</button>
                </div>
            </div>
        </form>
    </div>
</body>

</html>
<?php
session_start();
include 'connection/connection.php';

// Set default session status if not set
if (empty($_SESSION['status'])) {
    $_SESSION['status'] = 'invalid';
}

// Redirect if session is valid
if ($_SESSION['status'] == 'valid') {
    $role = $_SESSION['role'];
    if ($role == 'admin') {
        echo '<script>window.location.href = "pages/admin/departments.php";</script>';
        exit();
    } elseif ($role == 'teacher') {
        echo '<script>window.location.href = "pages/teacher/sections.php";</script>';
        exit();
    } elseif ($role == 'parent') {
        echo '<script>window.location.href = "pages/parent/student_details.php";</script>';
        exit();
    }
}

// Handle login form submission
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = mysqli_real_escape_string($conn, trim($_POST['password']));
    $role = $_POST['role'];

    if (empty($username) || empty($password)) {
        echo '<script>alert("Please fill out all fields.");</script>';
    } else {
        // Prepare SQL query based on role
        if ($role == 'admin') {
            $checkQuery = "SELECT * FROM admin WHERE username=? AND password=?";
        } elseif ($role == 'teacher') {
            $checkQuery = "SELECT * FROM teachers WHERE username=? AND password=?";
        } elseif ($role == 'parent') {
            $checkQuery = "SELECT * FROM parents WHERE username=? AND password=?";
        }

        // Use prepared statements to prevent SQL injection
        $stmt = mysqli_prepare($conn, $checkQuery);
        mysqli_stmt_bind_param($stmt, "ss", $username, $password);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (!$result) {
            die('Query Error: ' . mysqli_error($conn));
        }

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['status'] = 'valid';
            $_SESSION['role'] = $role;
            $_SESSION['username'] = $row['username'];

            // Alert and redirect based on role
            echo '<script>alert("Logged in successfully as ' . ucfirst($role) . '!");</script>';
            if ($role == 'admin') {
                echo '<script>window.location.href = "pages/admin/departments.php";</script>';
            } elseif ($role == 'teacher') {
                echo '<script>window.location.href = "pages/teacher/sections.php";</script>';
            } elseif ($role == 'parent') {
                echo '<script>window.location.href = "pages/parent/student_details.php";</script>';
            }
            exit();
        } else {
            echo '<script>alert("Login failed. Incorrect username or password for ' . ucfirst($role) . '.");</script>';
        }
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
    <link rel="stylesheet" href='styles/tailwind.css'>
    <link rel="stylesheet" href='styles/style.css'>
    <link rel="icon" href="./assets/acemnhs_logo.png">
</head>

<body class="h-screen flex justify-center items-center">
    <div
        class="bg-gray-100 border-2 border-gray-200 rounded-xl py-16 px-12 m-6 flex flex-col gap-4 align-center justify-center">
        <div class="w-full rounded flex justify-center">
            <img src="./assets/acemnhs_logo.png" />
        </div>
        <h1 class="font-bold text-4xl text-center">Antonio C. Esguerra MNHS</h1>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="form-control">
            <div class="flex flex-col w-full gap-4">
                <div class="w-full flex place-content-center">
                    <div class="btn-group mx-auto">
                        <input type="radio" name="role" value="admin" data-content="Admin"
                            class="btn bg-[rgba(0,0,0,0.02)]" required />
                        <input type="radio" name="role" value="teacher" data-content="Teacher"
                            class="btn bg-[rgba(0,0,0,0.02)]" checked required />
                        <input type="radio" name="role" value="parent" data-content="Parent"
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
                    <button class="btn btn-primary btn-block mt-2" type="submit" name="login">Login</button>
                </div>
            </div>
        </form>
        <p class="text-sm text-center"> No account? <a href="./pages/user_authentication/sign-up.php"
                class="link text-sm text-[rgba(0,0,0,0.8)] underline">Sign Up</a></p>
    </div>
</body>

</html>
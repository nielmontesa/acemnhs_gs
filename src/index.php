<?php
session_start();
include 'C:\xampp\htdocs\Capstone\acemnhs_gs\src\connection\connection.php'; 

// Check if the session is valid
if (empty($_SESSION['status'])) {
    $_SESSION['status'] = 'invalid';
}

if ($_SESSION['status'] == 'valid') {
    $role = $_SESSION['role']; // Ensure role is set in the session
    if ($role == 'admin') {
        echo '<script>window.location.href = "/Capstone/acemnhs_gs/src/pages/admin/departments.php";</script>';
        exit();
    } elseif ($role == 'teacher') {
        echo '<script>window.location.href = "/Capstone/acemnhs_gs/src/pages/teacher/index.php";</script>';
        exit();
    } elseif ($role == 'parent') {
        echo '<script>window.location.href = "/Capstone/acemnhs_gs/src/pages/parent/student_details.php";</script>';
        exit();
    }
}

if (isset($_POST['login'])) {
    // Retrieve and trim user inputs
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = $_POST['role']; // Get the selected role

    if (empty($username) || empty($password)) {
        echo '<script>alert("Please fill out all fields.");</script>';
    } else {
        // Check for user in the correct table based on the selected role
        $checkQuery = "";
        if ($role == 'admin') {
            $checkQuery = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
        } elseif ($role == 'teacher') {
            $checkQuery = "SELECT * FROM teachers WHERE username='$username' AND password='$password'";
        } elseif ($role == 'parent') {
            $checkQuery = "SELECT * FROM parents WHERE username='$username' AND password='$password'";
        }

        $result = mysqli_query($conn, $checkQuery);

        // Check if the user exists in the selected role's table
        if (mysqli_num_rows($result) > 0) {
            // Successful login
            $_SESSION['status'] = 'valid';
            $_SESSION['role'] = $role; // Store the role in the session
            echo '<script>alert("Logged in successfully as ' . ucfirst($role) . '!");</script>';
            
            // Redirect based on role using window.location
            if ($role == 'admin') {
                echo '<script>window.location.href = "/Capstone/acemnhs_gs/src/pages/admin/departments.html";</script>';
            } elseif ($role == 'teacher') {
                echo '<script>window.location.href = "/Capstone/acemnhs_gs/src/pages/teacher/index.html";</script>';
            } elseif ($role == 'parent') {
                echo '<script>window.location.href = "/Capstone/acemnhs_gs/src/pages/parent/student_details.html";</script>';
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
    <div class="bg-gray-100 border-2 border-gray-200 rounded-xl py-16 px-12 m-6 flex flex-col gap-4 align-center justify-center">
        <div class="w-full rounded flex justify-center">
            <img src="./assets/acemnhs_logo.png" />
        </div>
        <h1 class="font-bold text-4xl text-center">Antonio C. Esguerra MNHS</h1>
        <!-- Form -->
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="form-control">
            <div class="flex flex-col w-full gap-4">
                <div class="w-full flex place-content-center">
                    <div class="btn-group mx-auto">
                        <label>
                            <input type="radio" name="role" value="admin" class="btn bg-[rgba(0,0,0,0.02)]" required />
                            Admin
                        </label>
                        <label>
                            <input type="radio" name="role" value="teacher" class="btn bg-[rgba(0,0,0,0.02)]" checked required />
                            Teacher
                        </label>
                        <label>
                            <input type="radio" name="role" value="parent" class="btn bg-[rgba(0,0,0,0.02)]" required />
                            Parent
                        </label>
                    </div>
                </div>
                <div class="flex flex-col gap-2">
                    <label for="username">
                        <span class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Username</span>
                        <input class="input-block input" placeholder="Please enter your username." name="username" type="text" required />
                    </label>
                    <label for="Password">
                        <span class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Password</span>
                        <input class="input-block input" placeholder="Please enter your password." name="password" type="password" required />
                    </label>
                    <button class="btn btn-primary btn-block mt-2" type="submit" name="login">Login</button>
                </div>
            </div>
        </form>
        <p class="text-sm text-center"> No account? <a href="./pages/user_authentication/sign-up.php" class="link text-sm text-[rgba(0,0,0,0.8)] underline">Sign Up</a></p>
    </div>
</body>
</html>

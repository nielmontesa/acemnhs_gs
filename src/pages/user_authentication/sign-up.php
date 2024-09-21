<?php
include '../../connection/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Retrieve input values
    $role = $_POST['role'];
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Adjust query based on role
    if ($role == 'admin') {
        // For admin, use email instead of username
        $check_sql = "SELECT * FROM admin WHERE email = '$username'";
        $insert_sql = "INSERT INTO admin (email, password) VALUES ('$username', '$password')";
    } else {
        // For other roles, use username
        $check_sql = "SELECT * FROM $role WHERE username = '$username'";
        $insert_sql = "INSERT INTO $role (username, password) VALUES ('$username', '$password')";
    }

    // Execute the query and check for errors
    $check_result = mysqli_query($conn, $check_sql);

    if (!$check_result) {
        // Output the specific SQL error
        die("Error executing query: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($check_result) > 0) {
        // User already exists, notify the user
        echo "<script>alert('User already exists. Please choose another.');</script>";
    } else {
        // Insert the new user data
        if (mysqli_query($conn, $insert_sql)) {
            echo "<script>alert('New User created successfully!');</script>";
        } else {
            echo "Error: " . $insert_sql . "<br>" . mysqli_error($conn);
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
    <link rel="stylesheet" href='../../styles/tailwind.css'>
    <link rel="stylesheet" href='../../styles/style.css'>
</head>

<body class="h-screen flex justify-center items-center">
    <div
        class="bg-gray-100 border-2 border-gray-200 rounded-xl py-16 px-12 m-6 flex flex-col gap-4 align-center justify-center">
        <div class="w-full rounded flex justify-center">
            <img src="../../assets/acemnhs_logo.png" />
        </div>
        <h1 class="font-bold text-4xl text-center">Antonio C. Esguerra MNHS</h1>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="form-control">
            <div class="flex flex-col w-full gap-4">
                <div class="w-full flex place-content-center">
                    <div class="btn-group mx-auto">
                        <label>
                            <input type="radio" name="role" value="admin" class="btn bg-[rgba(0,0,0,0.02)]" required />
                            Admin
                        </label>
                        <label>
                            <input type="radio" name="role" value="teachers" class="btn bg-[rgba(0,0,0,0.02)]"
                                required />
                            Teacher
                        </label>
                        <label>
                            <input type="radio" name="role" value="parents" class="btn bg-[rgba(0,0,0,0.02)]"
                                required />
                            Parent
                        </label>
                    </div>
                </div>
                <div class="flex flex-col gap-2">
                    <label for="username">
                        <span class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Username</span>
                        <input class="input-block input" placeholder="Please enter your username." name="username"
                            type="text" required />
                    </label>
                    <label for="Password">
                        <span class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Password</span>
                        <input class="input-block input" placeholder="Please enter your password." name="password"
                            type="password" required />
                    </label>
                    <button class="btn btn-primary btn-block mt-2" name="submit" type="submit">Sign-up</button>
                </div>
            </div>
        </form>
        <p class="text-sm text-center"> Already have an account? <a href="../../index.php"
                class="link text-sm text-[rgba(0,0,0,0.8)] underline">Log-in</a></p>
    </div>
</body>

</html>
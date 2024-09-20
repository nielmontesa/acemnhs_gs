<?php

include __DIR__ . '/../../connection/connection.php';

if (isset($_POST['submit'])) {

    // Get and sanitize form data
    $user = mysqli_real_escape_string($conn, trim($_POST['username']));
    $pass = mysqli_real_escape_string($conn, trim($_POST['password']));
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    // Validate that all fields are filled
    if (empty($user) || empty($pass)) {
        echo '<script>alert("Please fill out all fields!");</script>';
    } else {
        // Check if username already exists in either admin or faculty table
        $checkAdmin = "SELECT * FROM admin WHERE email='$user'";
        $checkFaculty = "SELECT * FROM teachers WHERE username='$user'";
        $checkParent = "SELECT * FROM parents WHERE username = '$user'"
        $resultAdmin = mysqli_query($conn, $checkAdmin);
        $resultFaculty = mysqli_query($conn, $checkFaculty);
        $resultParent = mysqli_query($conn, $checkParent);

        if (mysqli_num_rows($resultAdmin) > 0 || mysqli_num_rows($resultFaculty) > 0) {
            // If the username exists, show an alert and don't insert the record
            echo '<script>
                    alert("Admin, Faculty or Parent Already Exists!");
                    window.location.href = "' . $_SERVER['PHP_SELF'] . '";
                  </script>';
        } else {
            // Hash the password before inserting it into the database
            $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

            // Insert data based on selected role
            if ($role === 'admin') {
                $sql = "INSERT INTO admin (email, password) VALUES ('$user', '$hashed_password')";
            } elseif ($role === 'faculty') {
                $sql = "INSERT INTO teachers (username, password) VALUES ('$user', '$hashed_password')";
            } elseif ($role === 'parent') {
                $sql = "INSERT INTO parents (username, password) VALUES ('$user', '$hashed_password')";
            }

            // Execute the query and check for success
            if (mysqli_query($conn, $sql)) {
                echo '<script>
                        alert("New record created successfully!");
                        window.location.href = "../../index.php";
                      </script>';
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }
    }

    // Close the connection
    mysqli_close($conn);
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


        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class="form-control">
            <div class="flex flex-col w-full gap-4">
                <div class="w-full flex place-content-center">
                    <div class="btn-group mx-auto">
                        <label>
                            <input type="radio" name="role" value="admin" class="btn bg-[rgba(0,0,0,0.02)]" required />
                            Admin
                        </label>
                        <label>
                            <input type="radio" name="role" value="faculty" class="btn bg-[rgba(0,0,0,0.02)]" required />
                            Faculty
                        </label>
                        <label>
                            <input type="radio" name="role" value="parent" class="btn bg-[rgba(0,0,0,0.02)]" required />
                            Faculty
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

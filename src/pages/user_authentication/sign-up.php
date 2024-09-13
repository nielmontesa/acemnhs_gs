<?php
include 'C:\xampp\htdocs\Capstone\acemnhs_gs\src\connection.php';

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Get data from form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hash the password before saving it to the database
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Use prepared statements to avoid SQL injection
    $stmt = $conn->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");

    // Bind parameters (s = string)
    $stmt->bind_param("ss", $username, $hashed_password);

    // Execute the query and check if it was successful
    if ($stmt->execute()) {
        echo "New record created successfully";
        
        // Redirect to index.php
        header("Location: C:\xampp\htdocs\Capstone\acemnhs_gs\src\index.php");
        exit(); // Ensure no further code is executed after redirection
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the prepared statement
    $stmt->close();
}

// Close connection
mysqli_close($conn);
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

        <!-- Form -->

        <form action="./pages/admin/index.html" method="post" class="form-control">
            <div class="flex flex-col w-full gap-4">
                <div class="w-full flex place-content-center">
                    <div class="btn-group mx-auto">
                        <input type="radio" name="options" data-content="Admin" class="btn bg-[rgba(0,0,0,0.02)]" />
                        <input type="radio" name="options" data-content="Faculty" class="btn bg-[rgba(0,0,0,0.02)]"
                            checked />
                    </div>
                </div>
                <div class="flex flex-col gap-2">
                    <label for="username">
                        <span class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Username</span>
                        <input class="input-block input" placeholder="Please enter your username." name="username"
                            type="text" />
                    </label>
                    <label for="Password">
                        <span class="text-xs pb-4 pl-2 text-[rgba(0,0,0,0.5)] font-medium">Password</span>
                        <input class="input-block input" placeholder="Please enter your password." name="password"
                            type="password" />
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
<!DOCTYPE html>
<html data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light only">
    <title>Antonio C. Esguerra MNHS</title>
    <link rel="stylesheet" href='../../styles/tailwind.css'>
</head>
<link rel="stylesheet" href='../../styles/style.css'>

<body class="h-screen flex justify-center items-center">
    <div
        class="bg-gray-100 border-2 border-gray-200 rounded-xl py-16 px-12 m-6 flex flex-col gap-4 align-center justify-center">
        <div class="w-full rounded flex justify-center">
            <img src="../../assets/acemnhs_logo.png" />
        </div>
        <h1 class="font-bold text-4xl text-center">Antonio C. Esguerra MNHS</h1>

        <form action="../../connection/signup.php" method="post" class="form-control">
            <div class="flex flex-col w-full gap-4">
                <div class="w-full flex place-content-center">
                    <div class="btn-group mx-auto">
                        <input type="radio" name="role" data-content="Admin" value="admin"
                            class="btn bg-[rgba(0,0,0,0.02)]" required />
                        <input type="radio" data-content="Teacher" name="role" value="teachers"
                            class="btn bg-[rgba(0,0,0,0.02)]" required checked />
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
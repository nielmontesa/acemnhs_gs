<!DOCTYPE html>
<html data-theme=emerald">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light only">
    <title>Antonio C. Esguerra MNHS</title>
    <link rel="stylesheet" href='styles/css/tailwind.css'>
</head>

<body class="h-screen flex justify-center items-center bg-gray-200">
    <div
        class="bg-gray-100 border border-gray-300 rounded-xl py-16 px-12 m-6 flex flex-col gap-4 align-center justify-center">
        <div class="w-full rounded flex justify-center">
            <img src="./assets/acemnhs_logo.png" />
        </div>
        <h1 class="font-bold text-4xl text-center">Antonio C. Esguerra MNHS</h1>

        <!-- Form -->

        <form action="" class="form-control">
            <div class="join flex justify-center w-full mb-4">
                <input class="join-item btn" type="radio" name="options" aria-label="Admin" required />
                <input class="join-item btn" type="radio" name="options" aria-label="Faculty" required />
                <input class="join-item btn" type="radio" name="options" aria-label="Parent" checked required />
            </div>
            <div class="flex flex-col gap-2 form-control">
                <label class="input input-bordered flex items-center gap-2">
                    Username
                    <input type="text" class="grow" placeholder="Enter your username." />
                </label>
                <label class="input input-bordered flex items-center gap-2">
                    Password
                    <input type="password" class="grow" placeholder="Enter your password." />

                </label>
                <button class="btn btn-primary" type="submit">Login</button>
            </div>

        </form>
    </div>
</body>


</html>
<?php
  require "services.php";
  
  session_start();
  global $conn;
  
  if (isset($_SESSION["signin"])) {
    header("Location: index.php");
    exit;
  }
   
  if (isset($_POST["login"])) {
    $checkUsername = mysqli_query($conn, "SELECT * FROM users WHERE username = '$_POST[username]'");
  
    if (mysqli_num_rows($checkUsername) === 1) {
      $user = mysqli_fetch_assoc($checkUsername);
  
      if (password_verify($_POST["password"], $user["password"])) {
        $_SESSION["signin"] = true;
        $_SESSION["role"] = $user["role"];
        header("Location: index.php");
        exit;
      }
    }
  }
?>

<!doctype html>
  <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.css" rel="stylesheet" />
      <title>Login - Point of Sales</title>
    </head>
    <body class="flex h-screen fixed w-screen bg-slate-50 text-slate-800 select-none">
      <div class="flex flex-col items-center justify-center mx-auto space-y-6">
        <div class="flex items-center text-2xl font-semibold">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 mr-2 text-indigo-500">
            <path d="M5.223 2.25c-.497 0-.974.198-1.325.55l-1.3 1.298A3.75 3.75 0 007.5 9.75c.627.47 1.406.75 2.25.75.844 0 1.624-.28 2.25-.75.626.47 1.406.75 2.25.75.844 0 1.623-.28 2.25-.75a3.75 3.75 0 004.902-5.652l-1.3-1.299a1.875 1.875 0 00-1.325-.549H5.223z" />
            <path fill-rule="evenodd" d="M3 20.25v-8.755c1.42.674 3.08.673 4.5 0A5.234 5.234 0 009.75 12c.804 0 1.568-.182 2.25-.506a5.234 5.234 0 002.25.506c.804 0 1.567-.182 2.25-.506 1.42.674 3.08.675 4.5.001v8.755h.75a.75.75 0 010 1.5H2.25a.75.75 0 010-1.5H3zm3-6a.75.75 0 01.75-.75h3a.75.75 0 01.75.75v3a.75.75 0 01-.75.75h-3a.75.75 0 01-.75-.75v-3zm8.25-.75a.75.75 0 00-.75.75v5.25c0 .414.336.75.75.75h3a.75.75 0 00.75-.75v-5.25a.75.75 0 00-.75-.75h-3z" clip-rule="evenodd" />
          </svg>
          
          Point of Sales
        </div>
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
          <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900">
            Login to your account
          </h1>
          <form class="space-y-4 md:space-y-6" action="" method="post">
            <div class="space-y-2">
              <label for="username" class="text-sm font-medium">Username <span class="text-red-500">*</span></label>
              <input type="text" id="username" name="username" class="block w-full rounded-full py-2 px-6 border-2 border-slate-200 active:outline-0 text-indigo-500" placeholder="Enter a username" required>
            </div>
            <div class="space-y-2">
              <label for="password" class="text-sm font-medium">Password <span class="text-red-500">*</span></label>
              <input type="password" id="password" name="password" class="block w-full rounded-full py-2 px-6 border-2 border-slate-200 active:outline-0 text-indigo-500" placeholder="Enter password" required>
            </div>
            <button type="submit" name="login" class="w-full bg-blue-400 hover:bg-blue-500 text-white font-medium rounded-full text-sm px-6 py-2 text-center">Sign in</button>
          </form>
        </div>
      </div>
    
      <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
      <script src="https://cdn.tailwindcss.com"></script>
    </body>
  </html>

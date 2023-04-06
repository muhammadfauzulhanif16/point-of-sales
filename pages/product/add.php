<?php
  require "../../services.php";
  
  session_start();
  
  if (!isset($_SESSION["signin"])) {
    header("Location: ../../login.php");
    exit;
  }
  
  $categories = getDatas("SELECT * FROM categories");
  
  $isMessage = false;
  $message = null;
  if (isset($_POST["create"])) {
    if (postProduct($_POST) > 0) {
      $isMessage = true;
      $message = "Product \"$_POST[name]\" was successfully added!";
    } else {
      $message = "Product \"$_POST[name]\" failed to add!";
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
      <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.css"  rel="stylesheet" />
      <title>Add Product (<?= $_SESSION["role"]; ?>) - Point of Sales</title>
      <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
          -webkit-appearance: none;
          margin: 0;
        }
  
        input[type=number] {
          -moz-appearance:textfield;
        }
      </style>
    </head>
    
    <body class="flex h-screen fixed w-screen bg-slate-50 text-slate-800 select-none">
      <aside class="w-32 border-r-2 border-slate-200 flex flex-col flex-none">
        <a href="../../index.php" class="flex justify-center items-center p-2">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10 text-indigo-500">
            <path d="M5.223 2.25c-.497 0-.974.198-1.325.55l-1.3 1.298A3.75 3.75 0 007.5 9.75c.627.47 1.406.75 2.25.75.844 0 1.624-.28 2.25-.75.626.47 1.406.75 2.25.75.844 0 1.623-.28 2.25-.75a3.75 3.75 0 004.902-5.652l-1.3-1.299a1.875 1.875 0 00-1.325-.549H5.223z" />
            <path fill-rule="evenodd" d="M3 20.25v-8.755c1.42.674 3.08.673 4.5 0A5.234 5.234 0 009.75 12c.804 0 1.568-.182 2.25-.506a5.234 5.234 0 002.25.506c.804 0 1.567-.182 2.25-.506 1.42.674 3.08.675 4.5.001v8.755h.75a.75.75 0 010 1.5H2.25a.75.75 0 010-1.5H3zm3-6a.75.75 0 01.75-.75h3a.75.75 0 01.75.75v3a.75.75 0 01-.75.75h-3a.75.75 0 01-.75-.75v-3zm8.25-.75a.75.75 0 00-.75.75v5.25c0 .414.336.75.75.75h3a.75.75 0 00.75-.75v-5.25a.75.75 0 00-.75-.75h-3z" clip-rule="evenodd" />
          </svg>
        </a>
        
        <ul class="grid grid-cols-1 p-2 h-full gap-2">
          <li class="group hover:bg-violet-100 cursor-pointer rounded-2xl items-center">
            <a href="../../index.php" class="flex flex-col justify-center items-center h-full">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-slate-400 group-hover:text-violet-500 mb-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
              </svg>
              
              <span class="text-sm font-medium text-slate-400 group-hover:text-violet-500">Dashboard</span>
            </a>
          </li>
          <li class="bg-amber-100 cursor-pointer rounded-2xl items-center">
            <a href="./index.php" class="flex flex-col justify-center items-center h-full">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-amber-500 mb-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
              </svg>
              
              <span class="text-sm font-medium text-amber-500">Products</span>
            </a>
          </li>
          <li class="group hover:bg-sky-100 cursor-pointer rounded-2xl items-center">
            <a href="../category/index.php" class="flex flex-col justify-center items-center h-full">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-slate-400 group-hover:text-sky-500 mb-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
              </svg>
              
              <span class="text-sm font-medium text-slate-400 group-hover:text-sky-500">Categories</span>
            </a>
          </li>
          <li class="group hover:bg-rose-100 cursor-pointer rounded-2xl items-center">
            <a href="../transaction/index.php" class="flex flex-col justify-center items-center h-full">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-slate-400 group-hover:text-rose-500 mb-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
              </svg>
              
              <span class="text-sm font-medium text-slate-400 group-hover:text-rose-500">Transactions</span>
            </a>
          </li>
        </ul>
      </aside>
      
      <div class="grow flex flex-col w-0">
        <header class="bg-white px-12 py-4 border-b-2 border-slate-200 flex justify-end flex-none rounded-b-2xl">
          <a href="../../signout.php" class="font-medium">Welcome, <?= $_SESSION["role"]; ?></a>
        </header>
        
        <form class="grow px-12 py-6 flex flex-col space-y-6" action="" method="post">
          <div class="flex flex-col grow space-y-4">
            <div class="flex justify-between items-center flex-none">
              <span class="text-2xl font-medium">Add Product</span>
              
              <button type="submit" name="create" class="bg-blue-400 hover:bg-blue-500 flex py-2 px-4 text-white font-medium rounded-full space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                </svg>
      
                <span>Create</span>
              </button>
            </div>
            
            <div class="grid grid-cols-2 gap-6">
              <div class="space-y-4">
                <label for="name" class="text-sm font-medium">Name <span class="text-red-500">*</span></label>
                <input type="text" id="name" name="name" class="block w-full rounded-full py-2 px-6 border-2 border-slate-200 active:outline-0 text-amber-500" placeholder="Enter a product name" required>
              </div>
              <div class="space-y-4">
                <label for="quantity" class="text-sm font-medium">Quantity <span class="text-red-500">*</span></label>
                <input type="number" id="quantity" name="quantity" class="block w-full rounded-full py-2 px-6 border-2 border-slate-200 active:outline-0 text-amber-500" placeholder="Enter the product quantity" required min="1">
              </div>
              <div class="space-y-4">
                <label for="unitType" class="text-sm font-medium">Unit Type</label>
                <input type="text" id="unitType" name="unitType" class="block w-full rounded-full py-2 px-6 border-2 border-slate-200 active:outline-0 text-amber-500" placeholder="Enter the product unit type">
              </div>
              <div class="space-y-4">
                <label for="category" class="text-sm font-medium">Category <span class="text-red-500">*</span></label>
                <select name="category" id="category" class="block w-full rounded-full py-2 px-6 border-2 border-slate-200 active:outline-0" required>
                  -
                  <?php foreach ($categories as $category): ?>
                    <option value="<?= $category["name"]; ?>"><?= $category["name"]; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="space-y-4" id="priceContainer">
                <label for="price" class="text-sm font-medium">Price <span class="text-red-500">*</span></label>
                <div class="flex items-center w-full rounded-full px-6 border-2 border-slate-200 bg-white">
                  <span class="text-sm font-medium text-slate-500">Rp</span>
                  <input type="number" id="price" name="price" class="w-full pr-0 focus:ring-0 border-0 text-amber-500" placeholder="Enter the product price" min="1">
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      
      <?php if ($isMessage): ?>
        <div id="toast-default" class="fixed right-0 m-4 space-x-4 flex items-center w-full w-max p-4 text-slate-500 bg-slate-50 rounded-2xl shadow-2xl border-2 border-slate-200" role="alert">
          <div class="inline-flex items-center justify-center flex-shrink-0 w-10 h-10 text-amber-500 bg-amber-100 rounded-2xl">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
            </svg>
  
            <span class="sr-only">Product</span>
          </div>
          
          <div class="ml-4 text-sm whitespace-nowrap"><?= $message; ?></div>
          
          <button type="button" class="bg-slate-100 hover:bg-slate-200 text-slate-400  rounded-2xl p-2 h-10 w-10" data-dismiss-target="#toast-default" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
          </button>
        </div>
      <?php endif; ?>

      <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
      <script src="https://cdn.tailwindcss.com"></script>
      <script>
        $(document).ready(function() {
          $('#unitType').on('change', function() {
            if ($(this).val() !== '') {
              $('#priceContainer').hide().attr('required', false);
            } else {
              $('#priceContainer').show().attr('required', true);
            }
          });
        });
      </script>
    </body>
  </html>

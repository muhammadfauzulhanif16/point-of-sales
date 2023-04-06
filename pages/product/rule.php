<?php
  require "../../services.php";
  
  session_start();
  
  if (!isset($_SESSION["signin"])) {
    header("Location: ../../login.php");
    exit;
  }
  
  $product = getDatas("SELECT * FROM products WHERE id = '$_GET[id]'")[0];
  $rules = getDatas(
    "SELECT * FROM rules WHERE productId = '$product[id]' ORDER BY title"
  );
  
  if (isset($_POST["create"])) {
    if (postRule($_POST, $product) > 0) {
      echo "
        <script>
          alert('aturan berhasil diubah!');
          document.location.href = 'rule.php?id=$_GET[id]';
        </script>
      ";
    } else {
      echo "
        <script>
          alert('aturan gagal diubah!');
          document.location.href = 'rule.php?id=$_GET[id]';
        </script>
      ";
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
    <title>Rules of buying "<?= $product["name"]; ?>" - Point of Sales (<?= $_SESSION["role"]; ?>)</title>
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
      
      <div class="h-full px-12 py-6 space-y-4 flex flex-col">
        <div class="justify-between items-center flex-none">
          <span class="text-2xl font-medium">Rules of buying "<?= $product["name"]; ?>"</span>
        </div>
        
        <div class="grid <?= ($_SESSION["role"] === "admin") ? "grid-cols-2" : "grid-cols-1"; ?> gap-6 w-full h-0 grow">
          <?php if ($_SESSION["role"] === "admin"): ?>
            <form class="grow flex flex-col space-y-6" action="" method="post">
            <div class="flex flex-col grow space-y-4">
              <div class="space-y-4">
                <label for="title" class="text-sm font-medium">Title <span class="text-red-500">*</span></label>
                <div class="flex space-x-4 items-center w-full rounded-full px-6 border-2 border-slate-200 bg-white">
                  <input type="text" id="title" name="title" class="w-full px-0 focus:ring-0 border-0 text-amber-500" placeholder="Enter a product rule title" required>
                  <span class="text-sm font-medium text-slate-500 whitespace-nowrap"><?= (count(explode(",", $product["unitType"])) > 1) ? trim(explode(",", $product["unitType"])[1]) : ""; ?></span>
                </div>
              </div>
              <div class="space-y-4">
                <label for="quantity" class="text-sm font-medium">Quantity <span class="text-red-500">*</span></label>
                <div class="flex space-x-4 items-center w-full rounded-full px-6 border-2 border-slate-200 bg-white">
                  <input type="number" id="quantity" name="quantity" class="w-full px-0 focus:ring-0 border-0 text-amber-500" placeholder="Enter the product quantity" min="1" required>
                  <span class="text-sm font-medium text-slate-500 whitespace-nowrap"><?= (count(explode(",", $product["unitType"])) > 1) ? explode(",", $product["unitType"])[0] : ""; ?></span>
                </div>
              </div>
              <div class="space-y-4">
                <label for="price" class="text-sm font-medium">Price <span class="text-red-500">*</span></label>
                <div class="flex space-x-4 items-center w-full rounded-full px-6 border-2 border-slate-200 bg-white">
                  <span class="text-sm font-medium text-slate-500">Rp </span>
                  <input type="number" id="price" name="price" class="w-full px-0 focus:ring-0 border-0 text-amber-500" placeholder="Enter the product price" min="1" required>
                </div>
              </div>
              <button type="submit" name="create" class="justify-center bg-blue-400 hover:bg-blue-500 flex py-2 px-4 text-white font-medium rounded-full space-x-2 items-center w-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                </svg>
      
                <span>Create</span>
              </button>
            </div>
          </form>
          <?php endif; ?>
          
          <div class="flex flex-col grow space-y-4">
            <?php if (count($rules) === 0) : ?>
              <div class="px-4 pb-4 h-full flex flex-col justify-center items-center space-y-4 border-2 border-slate-200 border-dashed rounded-2xl">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-slate-400">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184" />
                </svg>
  
                <span class="text-slate-400 font-medium">No rules <?= !isset($_GET["search"]) ? "yet" : "found" ?></span>
              </div>
            <?php else: ?>
              <div class="grow overflow-auto h-0 border-2 rounded-2xl border-slate-200">
                <table class="w-full text-sm text-left text-slate-500">
                  <thead class="text-xs uppercase bg-slate-100 sticky top-0">
                  <tr>
                    <th scope="col" class="px-6 py-4 whitespace-nowrap">Title</th>
                    <th scope="col" class="px-6 py-4 whitespace-nowrap">Quantity</th>
                    <th scope="col" class="px-6 py-4 whitespace-nowrap">Price</th>
                    <th scope="col" class="px-6 py-4 whitespace-nowrap">Created At</th>
                    <th scope="col" class="px-6 py-4 whitespace-nowrap">Updated At</th>
<!--                    <th scope="col" class="px-6 py-4"><span class="sr-only">Action</span></th>-->
                  </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($rules as $rule) : ?>
                    <tr class="bg-white border-b hover:bg-slate-200">
                      <th scope="row" class="px-6 py-4 font-medium text-slate-800 whitespace-nowrap"><?= $rule["title"]; ?> <?= (count(explode(",", $product["unitType"])) > 1) ? explode(",", $product["unitType"])[1] : ""; ?></th>
                      <td class="px-6 py-4 whitespace-nowrap"><?= $rule["quantity"]; ?> <?= (count(explode(",", $product["unitType"])) > 1) ? explode(",", $product["unitType"])[0] : ""; ?></td>
                      <td class="px-6 py-4 whitespace-nowrap">Rp<?= number_format($rule["price"], 0, 0, "."); ?></td>
                      <td class="px-6 py-4 whitespace-nowrap"><?= $rule["createdAt"]; ?></td>
                      <td class="px-6 py-4 whitespace-nowrap"><?= $rule["updatedAt"]; ?></td>
<!--                      <td class="px-6 py-4 whitespace-nowrap flex space-x-4">-->
<!--                        <a href="./edit.php?id=--><?php //= $rule["id"] ?><!--" class="font-medium text-blue-500 ">-->
<!--                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">-->
<!--                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />-->
<!--                          </svg>-->
<!--                        </a>-->
<!--                        <a href="./delete.php?id=--><?php //= $rule["id"] ?><!--" class="font-medium text-red-500">-->
<!--                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">-->
<!--                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />-->
<!--                          </svg>-->
<!--                        </a>-->
<!--                      </td>-->
                    </tr>
                  <?php endforeach ?>
                  </tbody>
                </table>
              </div>
            <?php endif; ?>
          </div>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
  </body>
  </html>

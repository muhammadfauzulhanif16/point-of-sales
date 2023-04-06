<?php
  require '../../services.php';
  
  session_start();
  
  if (!isset($_SESSION["signin"])) {
    header("Location: ../../login.php");
    exit;
  }

  $transactions = getDatas("SELECT * FROM transactions ORDER BY createdAt DESC");
  
  if (isset($_GET["search"])) {
    $transactions = getSearchData($_GET["search"], "transactions");
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
      <title>View Transactions (<?= $_SESSION["role"]; ?>) - Point of Sales</title>
    </head>
  
    <body class="flex h-screen fixed w-screen bg-slate-50 text-slate-800 select-none">
      <aside class="w-32 border-r-2 border-slate-200 flex flex-col flex-none">
        <a href="../../index.php" class="flex justify-center items-center p-2">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10 text-indigo-500">
            <path
              d="M5.223 2.25c-.497 0-.974.198-1.325.55l-1.3 1.298A3.75 3.75 0 007.5 9.75c.627.47 1.406.75 2.25.75.844 0 1.624-.28 2.25-.75.626.47 1.406.75 2.25.75.844 0 1.623-.28 2.25-.75a3.75 3.75 0 004.902-5.652l-1.3-1.299a1.875 1.875 0 00-1.325-.549H5.223z" />
            <path fill-rule="evenodd"
              d="M3 20.25v-8.755c1.42.674 3.08.673 4.5 0A5.234 5.234 0 009.75 12c.804 0 1.568-.182 2.25-.506a5.234 5.234 0 002.25.506c.804 0 1.567-.182 2.25-.506 1.42.674 3.08.675 4.5.001v8.755h.75a.75.75 0 010 1.5H2.25a.75.75 0 010-1.5H3zm3-6a.75.75 0 01.75-.75h3a.75.75 0 01.75.75v3a.75.75 0 01-.75.75h-3a.75.75 0 01-.75-.75v-3zm8.25-.75a.75.75 0 00-.75.75v5.25c0 .414.336.75.75.75h3a.75.75 0 00.75-.75v-5.25a.75.75 0 00-.75-.75h-3z"
              clip-rule="evenodd" />
          </svg>
        </a>
    
        <ul class="grid grid-cols-1 p-2 h-full gap-2">
          <li class="group hover:bg-violet-100 cursor-pointer rounded-2xl items-center">
            <a href="../../index.php" class="flex flex-col justify-center items-center h-full">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-slate-400 group-hover:text-violet-500 mb-2">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
              </svg>
    
              <span class="text-sm font-medium text-slate-400 group-hover:text-violet-500">Dashboard</span>
            </a>
          </li>
          <li class="group hover:bg-amber-100 cursor-pointer rounded-2xl items-center">
            <a href="../product/index.php" class="flex flex-col justify-center items-center h-full">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-slate-400 group-hover:text-amber-500 mb-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
              </svg>
    
              <span class="text-sm font-medium text-slate-400 group-hover:text-amber-500">Products</span>
            </a>
          </li>
          <li class="group hover:bg-sky-100 cursor-pointer rounded-2xl items-center">
            <a href="../category/index.php" class="flex flex-col justify-center items-center h-full">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-slate-400 group-hover:text-sky-500 mb-2">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
              </svg>
    
              <span class="text-sm font-medium text-slate-400 group-hover:text-sky-500">Categories</span>
            </a>
          </li>
          <li class="bg-rose-100 cursor-pointer rounded-2xl items-center">
            <a class="flex flex-col justify-center items-center h-full">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-rose-500 mb-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
              </svg>
    
              <span class="text-sm font-medium text-rose-500">Transactions</span>
            </a>
          </li>
        </ul>
      </aside>
    
      <div class="grow flex flex-col w-0">
        <header class="bg-white px-12 py-4 border-b-2 border-slate-200 grid grid-cols-2 flex-none rounded-b-2xl">
          <form action="" class="flex items-center p-0 m-0" method="get">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-slate-500 mr-2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
            <label for="search" class="w-full">
              <input type="text" id="search" name="search" value="<?= $_GET["search"] ?? "" ?>" placeholder="Search for transactions by id...." class="w-full border-0 focus:ring-0 text-indigo-500 placeholder-slate-500 p-0">
            </label>
          </form>
    
          <a href="../../signout.php" class="justify-end  inline-flex font-medium">Welcome, <?= $_SESSION["role"]; ?></a>
        </header>
    
        <div class="grow px-12 py-6 flex flex-col space-y-6">
          <div class="flex flex-col grow space-y-4">
            <div class="flex justify-between items-center flex-none">
              <span class="text-2xl font-medium">View Transactions</span>
            </div>
  
            <div class="grow rounded-2xl border-2 border-slate-200 <?= (count($transactions) === 0) ? "h-full flex flex-col justify-center items-center space-y-4 border-dashed" : "overflow-auto h-0"; ?>">
              <?php if (count($transactions) === 0): ?>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-slate-400">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                </svg>
                
                <span class="text-slate-400 font-medium">No transactions <?= !isset($_GET["search"]) ? "yet" : "found" ?></span>
              <?php else: ?>
                <table class="w-full text-sm text-left text-slate-500">
                  <thead class="text-xs uppercase bg-slate-100 sticky top-0">
                    <tr>
                      <th scope="col" class="px-6 py-4 whitespace-nowrap">Id</th>
                      <th scope="col" class="px-6 py-4 whitespace-nowrap">Customer Name</th>
                      <th scope="col" class="px-6 py-4 whitespace-nowrap">Product Name</th>
                      <th scope="col" class="px-6 py-4 whitespace-nowrap">Category</th>
                      <th scope="col" class="px-6 py-4 whitespace-nowrap">Quantity</th>
                      <th scope="col" class="px-6 py-4 whitespace-nowrap">Unit Price</th>
                      <th scope="col" class="px-6 py-4 whitespace-nowrap">Total Price</th>
                      <th scope="col" class="px-6 py-4 whitespace-nowrap">Created At</th>
                  </tr>
                  </thead>
                  
                  <tbody>
                  <?php foreach ($transactions as $transaction): ?>
                    <tr class="bg-white border-b hover:bg-slate-200">
                      <th scope="row" class="px-6 py-4 font-medium text-slate-800 whitespace-nowrap">#<?= $transaction["id"] ?></th>
                      <td class="px-6 py-4 whitespace-nowrap"><?= $transaction["customerName"] ?></td>
                      <td class="px-6 py-4 whitespace-nowrap"><?= $transaction["productName"] ?></td>
                      <td class="px-6 py-4 whitespace-nowrap"><?= $transaction["category"] ?></td>
                      <td class="px-6 py-4 whitespace-nowrap"><?= $transaction["quantity"] ?></td>
                      <td class="px-6 py-4 whitespace-nowrap">Rp<?= number_format($transaction["unitPrice"], 0, 0, "."); ?></td>
                      <td class="px-6 py-4 whitespace-nowrap">Rp<?= number_format($transaction["totalPrice"], 0, 0, "."); ?></td>
                      <td class="px-6 py-4 whitespace-nowrap"><?= $transaction["createdAt"] ?></td>
                    </tr>
                  <?php endforeach ?>
                  </tbody>
                </table>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    
      <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
      <script src="https://cdn.tailwindcss.com"></script>
    </body>
  </html>

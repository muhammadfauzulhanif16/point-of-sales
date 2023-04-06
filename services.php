<?php
  $conn = mysqli_connect("localhost", "root", "", "point_of_sales");
  
  date_default_timezone_set("Asia/Jakarta");

  function register($data): int|string {
    global $conn;

    $id = uniqid();
    $username = htmlspecialchars($data["username"]);
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $role = "cashier";
    $createdAt = date("Y-m-d G:i:s");

    $checkUsername = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");
    if (mysqli_fetch_assoc($checkUsername)) {
      echo
        "<script>
          alert('Username already exists!');
        </script>"
      ;

      return false;
    }

    $password = password_hash($password, PASSWORD_DEFAULT);

    mysqli_query($conn, "INSERT INTO users VALUES ('$id', '$username', '$password', '$role', '$createdAt', '$createdAt')");
    return mysqli_affected_rows($conn);
  }
  function postProduct($data): int|string {
    global $conn;

    $id = uniqid();
    $name = htmlspecialchars($data["name"]);
    $quantity = htmlspecialchars($data["quantity"]);
    $unitType = $data["unitType"] ? htmlspecialchars($data["unitType"]) : "Pcs";
    $price = $data["price"] ? htmlspecialchars($data["price"]) : 0;
    $category = htmlspecialchars($data["category"]);
    $createdAt = date("Y-m-d G:i:s");
    
    mysqli_query($conn, "INSERT INTO products VALUES ('$id', '$name', '$quantity', '$unitType', '$category', '$price', '$createdAt', '$createdAt')");
    
    postActivity("Added product \"$name\"", "Admin");
    
    return mysqli_affected_rows($conn);
  }
  
  function postRule($data, $product): int|string {
    global $conn;
    
    $id = uniqid();
    $title = htmlspecialchars($data["title"]);
    $quantity = htmlspecialchars($data["quantity"]);
    $price = htmlspecialchars($data["price"]);
    $createdAt = date("Y-m-d G:i:s");
    
    mysqli_query($conn, "INSERT INTO rules VALUES ('$id', '$title', '$quantity', '$price', '$product[id]', '$createdAt', '$createdAt')");
    
//    postActivity("Added rule \"$name\"", "Admin");
    
    return mysqli_affected_rows($conn);
  }
  
  function postCategory($data): int|string {
    global $conn;
    
    $id = uniqid();
    $name = htmlspecialchars($data["name"]);
    $createdAt = date("Y-m-d G:i:s");
    
    mysqli_query($conn, "INSERT INTO categories VALUES ('$id', '$name', '$createdAt', '$createdAt')");
    
    postActivity("Added category \"$name\"", "Admin");
    
    return mysqli_affected_rows($conn);
  }
  
  function postTransaction($data, $product): int|string {
    global $conn;
    
    $rule = getDatas("SELECT * FROM rules WHERE id = '$data[quantity]'")[0];
    
    $id = "POS-" . date("ynj-Gis");
    $customerName = $data["customerName"] ? htmlspecialchars($data["customerName"]) : "-";
    $productName = htmlspecialchars($product["name"]);
    $category = htmlspecialchars($product["category"]);
    $quantity = count(explode(",", $product["unitType"])) > 1 ?
      htmlspecialchars(($rule["title"]) . " " . explode(",", $product["unitType"])[1] . " = " . $rule["quantity"] . " " . explode(",", $product["unitType"])[0]) :
      htmlspecialchars($data["quantity"] . " " . $product["unitType"]);
    $unitPrice = count(explode(",", $product["unitType"])) > 1 ? $rule["price"] : $product["price"];
    $totalPrice = count(explode(",", $product["unitType"])) > 1 ? $rule["price"] : $data["quantity"] * $product["price"];
    $createdAt = date("Y-m-d G:i:s");
    
    $productQuantity = count(explode(",", $product["unitType"])) > 1 ? $product["quantity"] - $rule["quantity"] : $product["quantity"] - $data["quantity"];
    $updatedAt = date("Y-m-d G:i:s");

    mysqli_query($conn, "UPDATE products SET quantity = '$productQuantity', updatedAt = '$updatedAt' WHERE id = '$product[id]'");

    mysqli_query($conn, "INSERT INTO transactions VALUES ('$id', '$customerName', '$productName', '$category', '$quantity', '$unitPrice', '$totalPrice', '$createdAt')");

    return mysqli_affected_rows($conn);
  }

  
  function postActivity($subject, $role): void {
    global $conn;
    
    $historyId = uniqid();
    $createdAt = date("Y-m-d G:i:s");
    
    mysqli_query($conn, "INSERT INTO histories VALUES ('$historyId', '$subject', '$role', '$createdAt')");
  }
  
  function getDatas($query): array {
    global $conn;

    $result = mysqli_query($conn, $query);
    $datas = [];

    while ($data = mysqli_fetch_assoc($result)) {
      $datas[] = $data;
    }

    return $datas;
  }
  
  function getSearchData($keyword, $table): array {
    $column = $table === "transactions" ? "id" : "name";
    
    return getDatas("SELECT * FROM $table WHERE $column LIKE '%$keyword%'");
  }
  
  function putProduct($data, $product): int|string {
    global $conn;
    
    $updatedAt = date("Y-m-d G:i:s");
    
    mysqli_query($conn, "UPDATE products SET name = '$data[name]', quantity = '$data[quantity]', unitType = '$data[unitType]', category = '$data[category]', updatedAt = '$updatedAt' WHERE id = '$product[id]'");
    
    $subject = "";
    if ($product["name"] !== $data["name"]) {
      $subject = "Updated product name \"$product[name]\" to \"$data[name]\"";
    } else if ($product["quantity"] !== $data["quantity"]) {
      $subject = "Updated product quantity \"$product[quantity]\" to \"$data[quantity]\"";
    } else if ( $product["unitType"] !== $data["unitType"]) {
      $subject = "Updated product unit type \"$product[unitType]\" to \"$data[unitType]\"";
    } else if ( $product["category"] !== $data["category"]) {
      $subject = "Updated product category \"$product[category]\" to \"$data[category]\"";
    } else if ( $product["purchasePrice"] !== $data["purchasePrice"]) {
      $subject = "Updated product purchase price \"$product[purchasePrice]\" to \"$data[purchasePrice]\"";
    } else if ( $product["salesPrice"] !== $data["salesPrice"]) {
      $subject = "Updated product sales price \"$product[salesPrice]\" to \"$data[salesPrice]\"";
    }
    
    postActivity($subject, "Admin");
    
    return mysqli_affected_rows($conn);
  }
  
  function putCategory($data, $category): int|string {
    global $conn;
    
    $updatedAt = date("Y-m-d G:i:s");
    
    mysqli_query($conn, "UPDATE categories SET name = '$data[name]', updatedAt = '$updatedAt' WHERE id = '$category[id]'");
    
    postActivity("Updated category \"$category[name]\" to \"$data[name]\"", "Admin");
    
    return mysqli_affected_rows($conn);
  }
  
  function deleteProduct($id): int|string {
    global $conn;
    
    $product = getDatas("SELECT * FROM products WHERE id = '$id'")[0];
    
    mysqli_query($conn, "DELETE FROM products WHERE id = '$id'");
    
    postActivity("Deleted product \"$product[name]\"", "Admin");
    
    return mysqli_affected_rows($conn);
  }
  
  function deleteCategory($id): int|string {
    global $conn;
    
    $category = getDatas("SELECT * FROM categories WHERE id = '$id'")[0];
    
    mysqli_query($conn, "DELETE FROM categories WHERE id = '$id'");
    
    postActivity("Deleted category \"$category[name]\"", "Admin");
    
    return mysqli_affected_rows($conn);
  }

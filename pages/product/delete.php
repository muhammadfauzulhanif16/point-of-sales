<?php
  require "../../services.php";
  
  session_start();
  
  if (!isset($_SESSION["signin"])) {
    header("Location: ../../login.php");
    exit;
  }
  
  if (deleteProduct($_GET["id"]) > 0) {
    echo "
      <script>
        alert('produk berhasil dihapus!');
        document.location.href = 'index.php';
      </script>
    ";
  } else {
    echo "
      <script>
        alert('produk gagal dihapus!');
        document.location.href = 'index.php';
      </script>
    ";
  }

<?php
  require "../../services.php";
  
  session_start();
  
  if (!isset($_SESSION["signin"])) {
    header("Location: ../../login.php");
    exit;
  }
  
  if (deleteCategory($_GET["id"]) > 0) {
    echo "
      <script>
        alert('kategori berhasil dihapus!');
        document.location.href = 'index.php';
      </script>
    ";
  } else {
    echo "
      <script>
        alert('kategori gagal dihapus!');
        document.location.href = 'index.php';
      </script>
    ";
  }

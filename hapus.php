<?php 
session_start();

if(!isset($_SESSION["login"])) { // jika tidak ada session login kembalikan ke page login
  header("Location: login.php");
  exit;
}

require 'functions.php';

$id = $_GET['id'];

if(hapus($id) > 0) {
  echo "
  <script>
        alert('Data berhasi dihapus')
        document.location.href = 'index.php'
  </script>";
} else {
echo "
<script>
alert('Data gagal dihapus')
document.location.href = 'index.php'
</script>";
}

?>
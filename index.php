<?php
session_start();

if (!isset($_SESSION["login"])) { // jika tidak ada session login kembalikan ke page login
  header("Location: login.php");
  exit;
}

require 'functions.php';

// konfigurasi pagination
$jumlahDataPerhalaman = 5;
$jumlahData = count(query("SELECT * FROM mahasiswa")); // menghitung jumlah data
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerhalaman);
$halamaAktif = isset($_GET["page"]) ? $_GET["page"] : 1; // untuk mengatasi halaman awal
$awalData = ($jumlahDataPerhalaman * $halamaAktif) - $jumlahDataPerhalaman;

$mahasiswa = query("SELECT *  FROM mahasiswa LIMIT $awalData, $jumlahDataPerhalaman"); // dari index (awaldata) sebanyak (jumlahDataPerhalaman)

//tombol cari ditekan maka $mahasiswa ditimpa
if (isset($_POST["cari"])) { //'cari' adalah nama button
  $mahasiswa = cari($_POST["keyword"]);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="indexstyles.css">
  <title>Halaman Admin</title>
</head>

<body>
  <div class="logout-container">
    <a href="logout.php" class="logout">Logout</a>
  </div>

  <h1>Daftar Data Mahasiswa</h1>


  <form class="form-search" action="" method="post">
    <input id="input-search" class="input-search" type="text" name="keyword" autofocus placeholder="masukan keyword..."
      autocomplete="off">
    <button id="button-search" class="button-search" name="cari" type="submit">Cari</button>
    <img src="img/loader.gif" class="loader" >
  </form>

  <a class="tambah-badge" href="tambah.php">Tambah Data Mahasiswa</a>
  <div id="table-container">
  <table>
  <tr>
    <th>No</th>
    <th>Aksi</th>
    <th>Gambar</th>
    <th>NRP</th>
    <th>Nama</th>
    <th>Email</th>
    <th>Jurusan</th>
  </tr>
  <?php $i = 1 ?>
  <?php foreach ($mahasiswa as $row): ?>

        <tr>
          <td>
            <?= $i++ ?>.
          </td>
          <td class="update">
            <a href="ubah.php?id=<?= $row["id"]; ?>">Ubah</a>
            <div class="hapus"><a href="hapus.php?id=<?= $row["id"]; ?>" onclick="return confirm('Are you sure?');">Hapus</a>
            </div>
          </td>
          <td><img src="img/<?= $row["gambar"] ?>" alt=""></td>
          <td>
            <?= $row["nrp"]; ?>
          </td>
          <td>
            <?= $row["nama"]; ?>
          </td>
          <td>
            <?= $row["email"]; ?>
          </td>
          <td>
            <?= $row["jurusan"]; ?>
          </td>
        </tr>
  <?php endforeach; ?>
</table>
  </div>
  <!-- NAVIGASI -->


  <div class="pagination-container">
    <?php if ($halamaAktif > 1): ?>
          <a href="index.php?page=<?= $halamaAktif - 1; ?>">&laquo;</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $jumlahHalaman; $i++): ?>
          <?php if ($i == $halamaAktif): ?>
                <a href="index.php?page=<?= $i; ?>" style="background-color: #3498db;">
                  <?= $i; ?>
                </a>
          <?php else: ?>
                <a href="index.php?page=<?= $i; ?>">
                  <?= $i; ?>
                </a>
          <?php endif; ?>
    <?php endfor; ?>

    <?php if ($halamaAktif < $jumlahHalaman): ?>
          <a href="index.php?page=<?= $halamaAktif - 1; ?>">&raquo;</a>
    <?php endif; ?>
  </div>
<!-- panggil jquery sebelum script kita -->
      <script src="js/jquery-3.7.1.min.js"></script>
  <script src="js/script.js"></script>
</body>

</html>
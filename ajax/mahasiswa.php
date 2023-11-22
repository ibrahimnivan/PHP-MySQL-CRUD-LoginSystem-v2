<?php
sleep(1); // agar loading aga lama
require '../functions.php';
$keyword = $_GET["keyword"];
$query = "SELECT * FROM mahasiswa WHERE 
nama LIKE '%$keyword%' OR 
nrp LIKE '%$keyword%' OR 
email LIKE '%$keyword%' OR 
jurusan LIKE '%$keyword%'";
$mahasiswa = query($query);

?>
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
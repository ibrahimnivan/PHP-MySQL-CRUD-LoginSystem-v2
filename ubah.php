<?php
session_start();

if(!isset($_SESSION["login"])) { // jika tidak ada session login kembalikan ke page login
  header("Location: login.php");
  exit;
}

require 'functions.php';

// ambil data di url
$id = $_GET["id"];

// query data mahasiswa berdasarkan id
$mhs = query(" SELECT * FROM mahasiswa WHERE id = $id")[0];  //[0] karena ada array rows di function query
 

// cek apakah tombol submit sudah ditekan
if (isset($_POST["submit"])) {



  // cek apakah data berhasil diubah
  if (ubah($_POST) > 0) {
    echo "
          <script>
                alert('Data berhasil diubah')
                document.location.href = 'index.php'
          </script>";
  } else {
    echo "
    <script>
    alert('Data gagal diubah')
    document.location.href = 'index.php'
    </script>";
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>ubah data mahasiswa</title>
  <style>
  body {
    font-family: 'Arial', sans-serif;
    margin: 20px;
  }

  h1 {
    color: #333;
    text-align: center;
    margin-bottom: 50px;
  }

  form {
    max-width: 400px;
    margin: 0 auto;
  }

  label {
    display: block;
    margin-bottom: 8px;
    color: #555;
  }

  input {
    width: 100%;
    padding: 8px;
    margin-bottom: 16px;
    box-sizing: border-box;
  }

  button {
    background-color: #4CAF50;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }

  button:hover {
    background-color: #45a049;
  }
  </style>
</head>

<body>
  <h1>Ubah data mahasiswa</h1>
  <form action="" method="post" enctype="multipart/form-data" >
    <!-- mhs id untuk queri ubah di functions -->
    <input type="hidden" name="id" value="<?= $mhs["id"] ?>"> 
    <!-- untuk gambar lama -->
    <input type="hidden" name="gambarLama" value="<?= $mhs["gambar"] ?>"> 

    <label for="nrp">NRP :</label>
    <input type="text" name="nrp" id="nrp" value="<?= $mhs["nrp"] ?>" required>

    <label for="nama">Nama :</label>
    <input type="text" name="nama" id="nama" value="<?= $mhs["nama"] ?>" required>

    <label for="email">Email :</label>
    <input type="email" name="email" id="email"value="<?= $mhs["email"] ?>"  required>

    <label for="jurusan">Jurusan :</label>
    <input type="text" name="jurusan" id="jurusan" value="<?= $mhs["jurusan"] ?>" required>

    <label for="gambar">Gambar :</label>
    <img src="img/<?= $mhs["gambar"]; ?> " alt="">
    <input type="file" name="gambar" id="gambar">

    <button type="submit" name="submit">Ubah</button>
</form>
</body>

</html>
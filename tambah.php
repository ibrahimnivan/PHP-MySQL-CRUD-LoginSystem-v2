<?php
session_start();

if(!isset($_SESSION["login"])) { // jika tidak ada session login kembalikan ke page login
  header("Location: login.php");
  exit;
}

require 'functions.php';

// cek apakah tombol submit sudah ditekan
if (isset($_POST["submit"])) {



  // cek apakah data berhasil ditambahkan
  if (tambah($_POST) > 0) {
    echo "
          <script>
                alert('Data berhasil ditambahkan')
                document.location.href = 'index.php'
          </script>";
  }
  //  else {
  //   echo "
  //   <script>
  //   alert('Data gagal ditambahkan')
  //   document.location.href = 'index.php'
  //   </script>";
  // }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>tambah data mahasiswa</title>
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
  <h1>Tambah data mahasiswa</h1>
  <!-- untuk string akan dikelola methood post untuk file dikelola enctype -->
  <form action="" method="post" enctype="multipart/form-data" >
    <label for="nrp">NRP :</label>
    <input type="text" name="nrp" id="nrp" required>

    <label for="nama">Nama :</label>
    <input type="text" name="nama" id="nama" required>

    <label for="email">Email :</label>
    <input type="email" name="email" id="email" required>

    <label for="jurusan">Jurusan :</label>
    <input type="text" name="jurusan" id="jurusan" required>

    <label for="gambar">Gambar :</label>
    <input type="file" name="gambar" id="gambar" required>

    <button type="submit" name="submit">Tambah</button>
</form >
</body>

</html>
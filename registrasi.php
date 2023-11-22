<?php 
require 'functions.php';

if( isset($_POST["register"])) {
  if(registrasi($_POST) > 0) {
    echo "<script> 
    alert('sign up berhasil');
    </script>";
  } else {
    echo mysqli_affected_rows($conn);
  }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      font-family: 'Arial', sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
      height: 100vh;
    }

    h1 {
      text-align: center;
      color: #333;
      margin: 50px;
    }

    form {
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      width: 300px;
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
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    button {
      background-color: #4caf50;
      color: #fff;
      padding: 10px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      width: 100%;
    }

    button:hover {
      background-color: #45a049;
    }
  </style>
  <title>Document</title>
</head>
<body>
  <h1> Halalman Registrasi</h1>

  <form action="" method="post">
    <label for="username">Username :</label>
    <input type="text" name="username" id="username" >

    <label for="password">Password :</label>
    <input type="password" name="password" id="password" >

    <label for="password2">Konfirmasi Password :</label>
    <input type="password" name="password2" id="pasword2">

    <button type="submit" name="register" >Register</button>
  </form>
</body>
</html>
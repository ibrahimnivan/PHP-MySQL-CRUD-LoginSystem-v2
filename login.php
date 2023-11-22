<?php
session_start();
require 'functions.php';

// cek coolkie simple
// if( isset($_COOKIE["login"])) { // cek cookie login
//   if($_COOKIE["login"] === 'true') { // cek isi
//     $_SESSION["login"] = true;
//   }
// }

// cek cookie jika pake hash
if(isset($_COOKIE["id"]) && isset($_COOKIE["key"])) {
  $id = $_COOKIE["id"];
  $key = $_COOKIE["key"];

  // ambil username (key) berdasarkan id
  $result = mysqli_query($conn, "SELECT username FROM users WHERE id = $id");
  $row = mysqli_fetch_assoc($result);

  // cek apakah cookie === username
  if( $key === hash('sha156', $row["usermame"])) {
    $_SESSION["login"] = true;
  }
}



//kl udah login ngga bisa ke login lagi
if (isset($_SESSION["login"])) {
  header("Location: index.php");
  exit;
}


if (isset($_POST["login"])) {
  $username = $_POST["username"];
  $password = $_POST["password"];

  $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");

  //cek username
  if (mysqli_num_rows($result) === 1) {

    // cek password
    $row = mysqli_fetch_assoc($result);
    if (password_verify($password, $row["password"])) { // kebalikan dari hash
      // set session
      $_SESSION["login"] = true; //kl ada session login = berhasil login

      // kl remember me diceklis 
      if( isset($_POST["remember-me"])) { //input checkbox
        // buat cookie
        setcookie("id", $row["id"], time() + 120);
        setcookie("key", hash('sha256', $row["username"], time() + 120));
      }

      header("Location: index.php"); //redirect
      exit;
    }
  }

  $error = true;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    * {
      padding: 0;
      margin: 0;
      box-sizing: border-box;
    }

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

    .remember-container {
      display: flex;
      flex-direction: row;
      align-items: center;
      justify-content: flex-start;
      overflow: hidden;
      width: 100%;
      margin-bottom: 10px;
    }

    .remember-container > input {
      width: 14px;
      margin-right: 0;
      padding: 2px;
      margin-bottom: 0px;
      margin-right: 6px;
      /* Set margin-right to 0 */
    }

    .remember-container>label {
      display: inline;
      margin-bottom: 0px;
    }





    /* .remember-container > input {
      
    } */


    .warning {
      color: red;
      text-align: center;
    }
  </style>
  <title>Halaman Login</title>
</head>

<body>
  <h1>Halaman Login</h1>

  <?php if (isset($error)): ?>
    <p class="warning">username / password salah</p>
  <?php endif; ?>

  <form action="" method="post">
    <label for="username">Username :</label>
    <input type="text" name="username" id="username">

    <label for="password">Password :</label>
    <input type="password" name="password" id="password">

    <div class="remember-container">
      <input type="checkbox" name="remember-me" id="remember-me">
      <label for="remember-me">Remember me?</label>
    </div>

    <button type="submit" name="login">Login</button>
  </form>

</body>

</html>
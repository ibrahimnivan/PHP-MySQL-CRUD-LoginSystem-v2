<!-- memisahkan logic dengan tampilan -->

<?php
$conn = mysqli_connect("localhost", "root", "", "phpdasar");



function query($query)
{
    global $conn;

    $result = mysqli_query($conn, $query);

    if (!$result) {
        // If the query fails, you can output an error message or log the error
        die("Query failed: " . mysqli_error($conn));
    }

    $rows = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}


function tambah($data)
{
  global $conn;
  // ambil data dari tiap element dalam form
  $nrp = htmlspecialchars($data["nrp"]);
  $nama = htmlspecialchars($data["nama"]);
  $email = htmlspecialchars($data["email"]);
  $jurusan = htmlspecialchars($data["jurusan"]);

  $gambar = upload();
  if(!$gambar) {
    return false;
  }

  // query insert data
  $query = "INSERT INTO mahasiswa VALUES ('', '$nrp', '$nama', '$email', '$jurusan', '$gambar')";

  mysqli_query($conn, $query);

  return mysqli_affected_rows($conn);

}

function upload() {
  $namaFile = $_FILES["gambar"]["name"]; // properti dari $_FILES
  $ukuranFile = $_FILES["gambar"]["size"];
  $error = $_FILES["gambar"]["error"];
  $tmpName = $_FILES["gambar"]["tmp_name"]; // tempat temporari file

  //jika tidak ada gambar yg diupload
  if($error === 4) {
    echo "<script> alert('pilih gambar terlebih dahulu')</script>";
  return false;
  }

  // yang boleh diupload hanya gambar
  $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
  $ekstensiGambar = explode('.', $namaFile); //mengubah str menjadi array
  $ekstensiGambar = strtolower(end($ekstensiGambar)); // mengambil index terakhir (ekstensi)
  if( !in_array($ekstensiGambar, $ekstensiGambarValid) ) {
    echo "<script> alert('hanya boleh upload jpg, jpeg dan png')</script>";
    return false;
  }

  // batasan ukuran
  if($ukuranFile > 1000000) { //1 mb
    echo "<script> alert('ukuran gambar terlalu besar')</script>";
    return false;
  }

  //lolos pengecekan gambar bisa diupload
  $namaFileBaru = uniqid(); // handling nama file yg sama
  $namaFileBaru .= '.';
  $namaFileBaru .= $ekstensiGambar;
  move_uploaded_file($tmpName, 'img/' . $namaFileBaru);

  return $namaFileBaru; //untuk database
}


//untuk menghapus data
function hapus($id)
{
  global $conn;
  mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id");

  return mysqli_affected_rows($conn);
}


function ubah($data)
{
  $id = $data["id"];
  global $conn;
  // ambil data dari tiap element dalam form
  $nrp = htmlspecialchars($data["nrp"]);
  $nama = htmlspecialchars($data["nama"]);
  $email = htmlspecialchars($data["email"]);
  $jurusan = htmlspecialchars($data["jurusan"]);
  $gambarLama = htmlspecialchars($data["gambarLama"]); //ngambil dari hidden

  //jika user menambahkan gambar baru
  if($_FILES["gambar"]["error"] === 4) {
    $gambar = $gambarLama;
  } else {
    $gambar = upload();
  }
  
  // query insert data
  $query = "UPDATE mahasiswa SET 
  nrp = '$nrp', 
  nama = '$nama',  
  email = '$email', 
  jurusan = '$jurusan', 
  gambar = '$gambar'
  WHERE id = $id
  ";

  mysqli_query($conn, $query);

  return mysqli_affected_rows($conn);

}

function cari($keyword) {
  $query = "SELECT * FROM mahasiswa WHERE 
  nama LIKE '%$keyword%' OR 
  nrp LIKE '%$keyword%' OR 
  email LIKE '%$keyword%' OR 
  jurusan LIKE '%$keyword%' ";

  return query($query);
}


function registrasi($data) {
  global $conn;

  $username = strtolower(stripslashes($data["username"])); //membersihkan karakter backslash agar ngga masuk ke database // agar yg dimasukan huruf kecil
  $password = mysqli_real_escape_string($conn, $data["password"]); // memungkinkan password ada kutipnya
  $password2 = mysqli_real_escape_string($conn, $data["password2"]); // memungkinkan password ada kutipnya

  // cek username sudah ada atau belum
  $result = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");

  if(mysqli_num_rows($result) > 0) {
    echo "<script> alert('username sudah ada') </script>";

    return false;
  }

  //cek konfirmasi password
  if($password !== $password2) {
    echo "<script> alert('Password tidak sesuai') </script>";

    return false;
  } 

  //enkripsi password
  $password = password_hash($password, PASSWORD_DEFAULT);  // algoritma akan terus berubah ketika ada pengamanan baru

  // tambahkan userbaru ke database
  mysqli_query($conn, "INSERT INTO users VALUES('', '$username', '$password')");

  return mysqli_affected_rows($conn);
}


?>
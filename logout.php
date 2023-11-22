<?php 
// menghapus session
session_start();
$_SESSION = [];
session_unset();
session_destroy();

//menghapus cookie
setcookie("id", "", time() - 3600); //waktu dimundurkan
setcookie("key", "", time() - 3600);

header("Location: login.php");
exit;

?>
<?php
include "../koneksi/koneksi.php";

if (isset($_GET['id_user'])) {
  $id = $_GET['id_user'];
  mysqli_query($koneksi, "DELETE FROM users WHERE id_user='$id'");
}

header("Location: pengguna.php");
exit;
?>

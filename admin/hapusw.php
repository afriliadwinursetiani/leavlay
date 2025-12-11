<?php
include "../koneksi/koneksi.php";
$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM wisata WHERE id_wisata='$id'");
header("Location: wisata.php");
exit;
?>

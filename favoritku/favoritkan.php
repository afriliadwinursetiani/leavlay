<?php
session_start();
include "../koneksi/koneksi.php";

// Pastikan pengguna sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location: ../login/login.php");
    exit;
}

$id_pengguna = $_SESSION['id_user'];
$id_wisata = $_GET['id'];

// Cek apakah wisata sudah difavoritkan
$cek = mysqli_query($koneksi, "SELECT * FROM wisata_favorit WHERE id_user='$id_pengguna' AND id_wisata='$id_wisata'");
if (mysqli_num_rows($cek) == 0) {
    mysqli_query($koneksi, "INSERT INTO wisata_favorit (id_user, id_wisata) VALUES ('$id_pengguna', '$id_wisata')");
}

// Arahkan kembali ke halaman sebelumnya
header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
?>

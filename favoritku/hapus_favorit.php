<?php
session_start();
include "../koneksi/koneksi.php";

// Pastikan user sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location: ../login/login.php");
    exit;
}

// Ambil id favorit yang mau dihapus
if (isset($_GET['id'])) {
    $id_favorit = mysqli_real_escape_string($koneksi, $_GET['id']);
    $id_user = $_SESSION['id_user'];

    // Pastikan data ini milik user yang login
    $cek = mysqli_query($koneksi, "SELECT * FROM wisata_favorit WHERE id_favorit = '$id_favorit' AND id_user = '$id_user'");
    if (mysqli_num_rows($cek) > 0) {
        $hapus = mysqli_query($koneksi, "DELETE FROM wisata_favorit WHERE id_favorit = '$id_favorit'");

        if ($hapus) {
            echo "<script>
                    alert('✅ Wisata berhasil dihapus dari favoritmu.');
                    window.location.href = '../favoritku/favorit.php';
                  </script>";
        } else {
            echo "<script>
                    alert('❌ Gagal menghapus data. Coba lagi ya.');
                    window.location.href = 'favoritku.php';
                  </script>";
        }
    } else {
        echo "<script>
                alert('⚠️ Data tidak ditemukan atau bukan milikmu.');
                window.location.href = 'favoritku.php';
              </script>";
    }
} else {
    header("Location: favoritku.php");
    exit;
}
?>

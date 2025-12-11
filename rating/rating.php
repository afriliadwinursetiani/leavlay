<?php
session_start();
include "../koneksi/koneksi.php";

if (!isset($_SESSION['id_user'])) {
    echo "NOLOGIN";
    exit;
}

$id_user   = $_SESSION['id_user'];
$id_wisata = $_POST['id_wisata'];
$rating    = $_POST['rating'];

// Cek apakah user sudah pernah memberi rating
$cek = mysqli_query($koneksi, 
    "SELECT * FROM rating 
     WHERE id_user='$id_user' AND id_wisata='$id_wisata'"
);

if (mysqli_num_rows($cek) > 0) {
    // Update
    mysqli_query($koneksi, 
        "UPDATE rating 
         SET nilai_rating='$rating', tanggal=NOW() 
         WHERE id_user='$id_user' AND id_wisata='$id_wisata'"
    );
} else {
    // Insert baru
    mysqli_query($koneksi, 
        "INSERT INTO rating (id_user, id_wisata, nilai_rating, tanggal)
         VALUES ('$id_user', '$id_wisata', '$rating', NOW())"
    );
}

echo "OK";
?>

<?php
session_start();
include "../koneksi/koneksi.php";
include "../navbar/navbar.php";

// Pastikan user sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location: ../login/login.php");
    exit;
}

$id_user = $_SESSION['id_user'];

// Ambil data kategori untuk dropdown
$kategori_query = mysqli_query($koneksi, "SELECT DISTINCT k.nama_kategori 
                                          FROM wisata_favorit f
                                          JOIN wisata w ON f.id_wisata = w.id_wisata
                                          JOIN kategori k ON w.id_kategori = k.id_kategori
                                          WHERE f.id_user = '$id_user'");

// Filter pencarian
$search = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : '';
$kategori_filter = isset($_GET['kategori']) ? mysqli_real_escape_string($koneksi, $_GET['kategori']) : '';

// Query utama
$query = "
    SELECT f.id_favorit, w.id_wisata, w.nama_wisata, w.lokasi, w.gambar, 
           w.deskripsi, f.tanggal_favorit, k.nama_kategori
    FROM wisata_favorit f
    JOIN wisata w ON f.id_wisata = w.id_wisata
    JOIN kategori k ON w.id_kategori = k.id_kategori
    WHERE f.id_user = '$id_user'
";

if (!empty($search)) {
    $query .= " AND w.nama_wisata LIKE '%$search%'";
}
if (!empty($kategori_filter)) {
    $query .= " AND k.nama_kategori = '$kategori_filter'";
}

$query .= " ORDER BY f.tanggal_favorit DESC";

$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Daftar Favorit</title>

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: #f2f4f7;
        margin: 0;
        padding: 0;
    }

    .container {
        width: 90%;
        max-width: 1100px;
        margin: 40px auto;
        background: #fff;
        padding: 25px;
        border-radius: 16px;
        box-shadow: 0 6px 18px rgba(0,0,0,0.09);
    }

    h2 {
        text-align: center;
        color: #111827;
        margin-bottom: 25px;
        font-weight: 600;
    }

    /* Search Box Modern */
    .search-box {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-bottom: 25px;
        flex-wrap: wrap;
    }

    .search-box input[type="text"] {
        padding: 12px 15px;
        width: 260px;
        border: 2px solid #d1d5db;
        border-radius: 8px;
        font-size: 14px;
        transition: 0.3s;
    }

    .search-box input[type="text"]:focus {
        border-color: #6366f1;
        box-shadow: 0 0 5px rgba(99,102,241,0.4);
    }

    .search-box select {
        padding: 12px;
        border: 2px solid #d1d5db;
        border-radius: 8px;
        background: white;
        font-size: 14px;
        cursor: pointer;
        transition: 0.3s;
    }

    .search-box select:focus {
        border-color: #10b981;
        box-shadow: 0 0 5px rgba(16,185,129,0.4);
    }

    .search-box button {
        padding: 12px 20px;
        background: #4f46e5;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: 0.3s;
    }

    .search-box button:hover {
        background: #4338ca;
        transform: translateY(-2px);
    }

    /* Card */
    .card {
        background: #fff;
        border-radius: 14px;
        padding: 15px;
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
        transition: 0.2s;
    }

    .card:hover {
        transform: translateY(-3px);
    }

    .card img {
        width: 165px;
        height: 115px;
        border-radius: 10px;
        object-fit: cover;
        margin-right: 15px;
    }

    .btn {
        display: inline-block;
        color: white;
        padding: 8px 16px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 13px;
        margin-top: 8px;
        transition: 0.3s;
        font-weight: 600;
    }

    .btn-detail {
        background: #2563eb;
    }

    .btn-detail:hover {
        background: #1d4ed8;
    }

    .btn-hapus {
        background: #ef4444;
    }

    .btn-hapus:hover {
        background: #dc2626;
    }
</style>

<script>
// 🔍 Auto Search & Auto Filter
function autoSubmit() {
    document.getElementById("filterForm").submit();
}
</script>

</head>
<body>

<div class="container">
    <h2>Daftar Wisata Favoritmu 📍</h2>

    <!-- 🔎 Form Filter -->
    <form method="GET" id="filterForm" class="search-box">
        <input 
            type="text" 
            name="search" 
            placeholder="Cari nama wisata..." 
            value="<?= htmlspecialchars($search); ?>"
            oninput="autoSubmit()"
        >

        <select name="kategori" onchange="autoSubmit()">
            <option value="">Semua Kategori</option>

            <?php while ($kat = mysqli_fetch_assoc($kategori_query)) : ?>
                <option 
                    value="<?= $kat['nama_kategori']; ?>" 
                    <?= ($kategori_filter == $kat['nama_kategori']) ? 'selected' : ''; ?>
                >
                    <?= ucfirst($kat['nama_kategori']); ?>
                </option>
            <?php endwhile; ?>
        </select>

        <button type="submit">Cari</button>
    </form>

    <hr>

    <!-- 🗺️ Daftar Favorit -->
    <?php if (mysqli_num_rows($result) == 0): ?>
        <p class="no-data" style="text-align:center; color:#6b7280; margin-top:20px;">
            Tidak ada wisata ditemukan 😢
        </p>
    <?php else: ?>
        <?php while ($data = mysqli_fetch_assoc($result)): ?>
            <div class="card">
                <img src="../img/<?= htmlspecialchars($data['gambar']); ?>" alt="img">

                <div>
                    <h3><?= htmlspecialchars($data['nama_wisata']); ?></h3>
                    <p><strong>Lokasi:</strong> <?= htmlspecialchars($data['lokasi']); ?></p>
                    <p><strong>Kategori:</strong> <?= htmlspecialchars($data['nama_kategori']); ?></p>
                    <small>Ditambahkan: <?= htmlspecialchars($data['tanggal_favorit']); ?></small><br>

                    <a href="../detail/detail.php?id=<?= $data['id_wisata']; ?>" class="btn btn-detail">Detail</a>
                    <a href="hapus_favorit.php?id=<?= $data['id_favorit']; ?>" class="btn btn-hapus" onclick="return confirm('Hapus dari favorit?')">Hapus</a>
                </div>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>

</div>

</body>
</html>

<?php
session_start();
include "../koneksi/koneksi.php";

// Cek login
if (!isset($_SESSION['username'])) {
  header("Location: ../login/login.php");
  exit;
}

$username = $_SESSION['username'];
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';

if ($role !== 'admin') {
  echo "<script>alert('Akses ditolak! Halaman ini hanya untuk admin.'); window.location='../login/login.php';</script>";
  exit;
}

// Hitung data
$jumlah_wisata = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM wisata"))['total'];
$jumlah_user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM users WHERE role='user'"))['total'];
$jumlah_admin = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM users WHERE role='admin'"))['total'];
$jumlah_rating = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM rating"))['total'];

// Ambil seluruh data rating
$data_rating = mysqli_query($koneksi, "
    SELECT r.*, u.nama_lengkap, w.nama_wisata
    FROM rating r
    LEFT JOIN users u ON r.id_user = u.id_user
    LEFT JOIN wisata w ON r.id_wisata = w.id_wisata
    ORDER BY r.id_rating DESC
");

// Ambil statistik rating tiap wisata
$data_statistik_rating = mysqli_query($koneksi, "
    SELECT 
        w.id_wisata,
        w.nama_wisata,
        COUNT(r.id_rating) AS total_pemberi_rating,
        COALESCE(AVG(r.nilai_rating), 0) AS rata_rata_rating
    FROM wisata w
    LEFT JOIN rating r ON w.id_wisata = r.id_wisata
    GROUP BY w.id_wisata
    ORDER BY total_pemberi_rating DESC
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Admin - Leavlay</title>
<link rel="stylesheet" href="dasces.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
/* 🌈 MODERN TABLE STYLE */
.table-modern {
    width: 100%;
    border-collapse: collapse;
    border-radius: 12px;
    overflow: hidden;
    background: #ffffff;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

.table-modern thead {
    background: linear-gradient(135deg, #42a5f5, #1e88e5);
    color: white;
}

.table-modern th {
    padding: 14px;
    text-align: left;
    font-size: 16px;
    letter-spacing: .5px;
}

.table-modern td {
    padding: 12px 14px;
    font-size: 15px;
    border-bottom: 1px solid #f0f0f0;
}

.table-modern tbody tr:nth-child(even) {
    background: #f9fbff;
}

.table-modern tbody tr:hover {
    background: #e7f1ff;
    cursor: pointer;
    transition: .2s;
}

/* ⭐ Styled Stars */
.star {
    color: gold;
    font-size: 18px;
}

.container-table {
    margin-top: 20px;
    overflow-x: auto;
    padding: 5px;
}

/* ICON STATISTIK */
.stats-icon {
    color: #ff9800;
    margin-right: 6px;
}
</style>

</head>
<body>

<?php include "sidebar.php"; ?>

<main class="content fade-in">

<header>
  <h1>Dashboard</h1>
  <p>Selamat datang, <strong><?= htmlspecialchars($username); ?></strong> 👋</p>
</header>

<!-- ===== CARD ===== -->
<section class="cards-horizontal">

    <div class="card blue">
      <div class="icon"><i class="fa fa-map fa-2x"></i></div>
      <h3 id="wisata"><?= $jumlah_wisata; ?></h3>
      <p>Total Wisata</p>
    </div>

    <div class="card pink">
      <div class="icon"><i class="fa fa-user fa-2x"></i></div>
      <h3 id="user"><?= $jumlah_user; ?></h3>
      <p>Total User</p>
    </div>

    <div class="card orange">
      <div class="icon"><i class="fa fa-shield-alt fa-2x"></i></div>
      <h3 id="admin"><?= $jumlah_admin; ?></h3>
      <p>Total Admin</p>
    </div>

    <div class="card green">
      <div class="icon">⭐</i></div>
      <h3 id="rating"><?= $jumlah_rating; ?></h3>
      <p>Total Rating</p>
    </div>

</section>

<!-- ====================== TABEL RATING DETAIL ====================== -->
<h2 style="margin-top: 40px;">📊 Data Rating Wisata</h2>

<div class="container-table">
<table class="table-modern">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama User</th>
            <th>Nama Wisata</th>
            <th>Rating</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>

        <?php 
        $no1 = 1;
        while ($row = mysqli_fetch_assoc($data_rating)) { 
        ?>
        <tr>
            <td><?= $no1++; ?></td>
            <td><?= $row['nama_lengkap'] ? htmlspecialchars($row['nama_lengkap']) : 'User Hilang'; ?></td>
            <td><?= $row['nama_wisata'] ? htmlspecialchars($row['nama_wisata']) : 'Wisata Hilang'; ?></td>
            <td>
                <?php for ($i = 1; $i <= 5; $i++) {
                    echo $i <= $row['nilai_rating'] ? '<span class="star">★</span>' : '<span class="star" style="color:#ddd;">★</span>';
                } ?>
            </td>
            <td><?= $row['tanggal']; ?></td>
        </tr>
        <?php } ?>

    </tbody>
</table>
</div>

<!-- ====================== TABEL STATISTIK ====================== -->
<h2 style="margin-top: 40px;">
    <i class="fa fa-calculator stats-icon"></i> ⭐ Statistik Rating Per Wisata
</h2>

<div class="container-table">
<table class="table-modern">
    <thead style="background:#ff9800;">
        <tr>
            <th>No</th>
            <th>Nama Wisata</th>
            <th>Total Pemberi Rating</th>
            <th>Rata-Rata</th>
            <th>Bintang</th>
        </tr>
    </thead>

    <tbody>
        <?php 
        $no2 = 1;
        while ($ws = mysqli_fetch_assoc($data_statistik_rating)) { 
        ?>
        <tr>
            <td><?= $no2++; ?></td>
            <td><?= htmlspecialchars($ws['nama_wisata']); ?></td>
            <td><?= $ws['total_pemberi_rating']; ?> orang</td>
            <td><?= number_format($ws['rata_rata_rating'], 1); ?></td>
            <td>
                <?php
                $star = round($ws['rata_rata_rating']);
                for ($i = 1; $i <= 5; $i++) {
                    echo $i <= $star ? '<span class="star">★</span>' : '<span class="star" style="color:#ddd;">★</span>';
                }
                ?>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
</div>

<footer>
  <p>© <?= date("Y"); ?> Leavlay Admin Panel — dibuat dengan cinta ❤️ Afrilia</p>
</footer>

</main>

<script>
  function animateValue(id, start, end, duration) {
    const obj = document.getElementById(id);
    let startTimestamp = null;
    const step = (timestamp) => {
      if (!startTimestamp) startTimestamp = timestamp;
      const progress = Math.min((timestamp - startTimestamp) / duration, 1);
      obj.textContent = Math.floor(progress * (end - start) + start);
      if (progress < 1) window.requestAnimationFrame(step);
    };
    window.requestAnimationFrame(step);
  }

  animateValue("wisata", 0, <?= $jumlah_wisata ?>, 1000);
  animateValue("user", 0, <?= $jumlah_user ?>, 1000);
  animateValue("admin", 0, <?= $jumlah_admin ?>, 1000);
  animateValue("rating", 0, <?= $jumlah_rating ?>, 1000);
</script>

</body>
</html>

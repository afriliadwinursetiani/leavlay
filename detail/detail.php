<?php
session_start();
include "../koneksi/koneksi.php";
include "../navbar/navbar.php";

// Pastikan ID ada
if (!isset($_GET['id'])) {
    echo "<div style='margin-top:40px;text-align:center;'>ID wisata tidak ditemukan.</div>";
    exit;
}

$id = intval($_GET['id']);

// Query wisata + kategori + rata-rata rating
$wisata = mysqli_query($koneksi, "
    SELECT 
        w.*, 
        k.nama_kategori,
        IFNULL(ROUND(AVG(r.nilai_rating),1),0) AS rata_rating
    FROM wisata w
    JOIN kategori k ON w.id_kategori = k.id_kategori
    LEFT JOIN rating r ON w.id_wisata = r.id_wisata
    WHERE w.id_wisata = $id
    GROUP BY w.id_wisata
");

if (mysqli_num_rows($wisata) == 0) {
    echo "<div style='margin-top:40px;text-align:center;'>Data wisata tidak ditemukan.</div>";
    exit;
}

$data = mysqli_fetch_assoc($wisata);

// Rating user
$id_user = $_SESSION['id_user'] ?? 0;
$myRating = 0;

if ($id_user) {
    $q = mysqli_query($koneksi, "
        SELECT nilai_rating FROM rating 
        WHERE id_user='$id_user' AND id_wisata='$id'
    ");
    $r = mysqli_fetch_assoc($q);
    if ($r) $myRating = $r['nilai_rating'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Detail Wisata - <?= $data['nama_wisata']; ?></title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

<style>
body {
  font-family: 'Poppins', sans-serif;
  background: #f2f7f7;
  margin: 0;
  padding: 0;
}

.container {
  width: 90%;
  max-width: 950px;
  margin: 50px auto;
  background: #fff;
  border-radius: 20px;
  box-shadow: 0 8px 20px rgba(0,0,0,0.1);
  overflow: hidden;
}

.image-container {
  height: 420px;
  overflow: hidden;
}

.image-container img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.content {
  padding: 25px 35px;
}

h2 {
  text-align: center;
  color: #2c3e50;
}

.info {
  text-align: center;
  color: #666;
  font-size: 15px;
  margin-bottom: 20px;
}

.desc {
  text-align: justify;
  line-height: 1.7;
  margin-bottom: 25px;
}

/* ⭐ Rating */
.rating-box {
  text-align: center;
  margin-bottom: 25px;
  font-size: 14px;
  color: #555;
}

.star-rating {
  display: inline-flex;
  gap: 5px;
  cursor: pointer;
}

.star {
  font-size: 26px;
  color: #ccc;
  transition: 0.2s;
}

.star.filled {
  color: #f1c40f;
}

.buttons {
  display: flex;
  justify-content: center;
  gap: 15px;
  margin-bottom: 25px;
}

.btn {
  padding: 10px 20px;
  border-radius: 10px;
  text-decoration: none;
  font-weight: 600;
  transition: 0.3s;
}

.btn-back {
  background: #34495e;
  color: white;
}

.btn-back:hover {
  background: #1abc9c;
}

.btn-favorit {
  background: #f1c40f;
  color: #2c3e50;
}

.btn-favorit:hover {
  background: #f39c12;
}
</style>
</head>

<body>

<div class="container">
  <div class="image-container">
    <img src="../img/<?= $data['gambar']; ?>" alt="<?= $data['nama_wisata']; ?>">
  </div>

  <div class="content">
    <h2><?= $data['nama_wisata']; ?></h2>

    <div class="info">
      📍 <b><?= $data['lokasi']; ?></b> &nbsp; | &nbsp;
      🏷️ Kategori: <b><?= $data['nama_kategori']; ?></b>
    </div>

    <!-- ⭐ RATING SYSTEM -->
    <div class="rating-box">
      <div style="margin-bottom:6px;">
        <b>Rating rata-rata:</b> ⭐ <?= $data['rata_rating']; ?>/5
      </div>

      <?php if ($id_user): ?>
      <div class="star-rating" data-wisata="<?= $data['id_wisata']; ?>">
        <?php for ($i = 1; $i <= 5; $i++): ?>
          <span class="star <?= $i <= $myRating ? 'filled' : '' ?>" data-value="<?= $i ?>">★</span>
        <?php endfor; ?>
      </div>
      <div style="font-size:12px;color:#777;margin-top:5px;">Klik untuk memberikan rating</div>
      <?php else: ?>
        <div style="font-size:12px;color:#888;">Login untuk memberikan rating ⭐</div>
      <?php endif; ?>
    </div>

    <div class="desc">
      <?= nl2br($data['deskripsi']); ?>
    </div>

    <div class="buttons">
      <a href="../jelajahi/jelajahi.php" class="btn btn-back">Kembali</a>
      <a href="../favoritku/favoritkan.php?id=<?= $data['id_wisata']; ?>" class="btn btn-favorit">Favoritkan</a>
    </div>
  </div>
</div>

<script>
// ⭐ SISTEM RATING DETAIL PAGE
document.querySelectorAll('.star-rating').forEach(container => {
  const stars = container.querySelectorAll('.star');

  stars.forEach(star => {

    // Hover
    star.addEventListener('mouseover', () => {
      const val = star.dataset.value;
      stars.forEach((s,i) => s.classList.toggle('filled', i < val));
    });

    // Klik = simpan rating
    star.addEventListener('click', async () => {
      const nilai = star.dataset.value;
      const wisata = container.dataset.wisata;

      await fetch('../rating/rating.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id_wisata=${wisata}&rating=${nilai}`
      });

      location.reload();
    });
  });

  container.addEventListener('mouseleave', () => {
    const current = [...container.querySelectorAll('.star.filled')].length;
    stars.forEach((s,i) => s.classList.toggle('filled', i < current));
  });

});
</script>

</body>
</html>

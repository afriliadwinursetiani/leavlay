<?php
session_start();
include "../koneksi/koneksi.php";
include "../navbar/navbar.php";

// Ambil semua kategori
$kategori_query = mysqli_query($koneksi, "SELECT * FROM kategori");

// Filter pencarian
$kategori_filter = isset($_GET['kategori']) ? $_GET['kategori'] : '';
$search_filter   = isset($_GET['search']) ? $_GET['search'] : '';

// Query wisata + rating
$query = "SELECT 
            w.*, 
            k.nama_kategori,
            IFNULL(ROUND(AVG(r.nilai_rating),1),0) AS rata_rating,
            COUNT(r.id_rating) AS jumlah_rating
          FROM wisata w
          JOIN kategori k ON w.id_kategori = k.id_kategori
          LEFT JOIN rating r ON w.id_wisata = r.id_wisata
          WHERE 1";

if (!empty($kategori_filter)) {
  $kategori_safe = mysqli_real_escape_string($koneksi, $kategori_filter);
  $query .= " AND LOWER(k.nama_kategori) LIKE LOWER('%$kategori_safe%')";
}

if (!empty($search_filter)) {
  $search_safe = mysqli_real_escape_string($koneksi, $search_filter);
  $query .= " AND LOWER(w.nama_wisata) LIKE LOWER('%$search_safe%')";
}

$query .= " GROUP BY w.id_wisata ORDER BY w.id_wisata DESC";
$wisata_query = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Jelajahi Sumatera Barat - Leavlay</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

<style>
body {
  font-family: 'Poppins', sans-serif;
  background: #f9fafc;
  margin: 0;
  padding: 0;
}
.search-container { text-align: center; margin: 30px auto; }
form { display: inline-flex; flex-wrap: wrap; justify-content: center; gap: 10px; }
select, input[type="text"] {
  padding: 10px 12px;
  font-size: 14px;
  border: 1px solid #ccc;
  border-radius: 8px;
  outline: none;
}
input[type="text"]:focus, select:focus { border-color: #1abc9c; }
.container { width: 90%; max-width: 1200px; margin: 40px auto; }
h2 { text-align: center; color: #2c3e50; font-size: 26px; margin-bottom: 25px; }

.grid { 
  display: grid; 
  grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); 
  gap: 25px; 
}
.card {
  background: #fff; border-radius: 15px; box-shadow: 0 4px 10px rgba(61,106,118,0.3);
  overflow: hidden; transition: 0.3s ease-in-out;
}
.card:hover {
  transform: translateY(-5px); box-shadow: 0 8px 18px rgba(0,0,0,0.15);
}
.card img { width: 100%; height: 200px; object-fit: cover; }
.card-content { padding: 15px; text-align: center; }
.card h3 { margin: 10px 0 5px; color: #34495e; }
.card p { font-size: 14px; color: #7f8c8d; margin: 3px 0; }

.rating-info { font-size: 14px; font-weight: 600; color: #333; }
.rating-count { font-size: 12px; color: #666; margin-bottom: 8px; }

.star-rating { display: inline-flex; gap: 4px; cursor: pointer; }
.star {
  font-size: 23px;
  color: #ccc;
  transition: 0.2s;
}
.star.filled { color: #f1c40f; }

.buttons { display: flex; justify-content: center; gap: 10px; padding: 15px; }
.btn-detail {
  background: #3498db; color: white; border: none; padding: 8px 14px;
  border-radius: 8px; cursor: pointer; transition: 0.3s; font-weight: 600;
}
.btn-detail:hover { background: #2980b9; }

.btn-favorit {
  background: #f1c40f; color: #2c3e50; border: none; padding: 8px 14px;
  border-radius: 8px; cursor: pointer; font-weight: 600; transition: 0.3s;
}
.btn-favorit:hover { background: #f39c12; }

.no-data { text-align: center; color: #7f8c8d; font-size: 16px; margin-top: 30px; }
</style>
</head>

<body>

<div class="search-container">
  <form method="GET" action="" id="filterForm">
    <select name="kategori" id="kategoriSelect">
      <option value="">Semua Kategori</option>
      <?php while ($row = mysqli_fetch_assoc($kategori_query)) { ?>
        <option value="<?= $row['nama_kategori']; ?>" 
          <?= ($kategori_filter == $row['nama_kategori']) ? 'selected' : ''; ?>>
          <?= ucfirst($row['nama_kategori']); ?>
        </option>
      <?php } ?>
    </select>

    <input type="text" name="search" id="searchInput"
           placeholder="Cari destinasi impianmu..." 
           value="<?= htmlspecialchars($search_filter); ?>">
  </form>
</div>

<div class="container">
  <h2>Destinasi Wisata <?= $kategori_filter ? ucfirst($kategori_filter) : "Terbaik di Sumatera Barat"; ?></h2>

  <div class="grid">
    <?php if (mysqli_num_rows($wisata_query) > 0): ?>
      <?php while ($wisata = mysqli_fetch_assoc($wisata_query)): ?>

        <?php
        // Cek rating user login
        $id_user = $_SESSION['id_user'] ?? 0;
        $myRating = 0;

        if ($id_user) {
          $cek = mysqli_query($koneksi,
            "SELECT nilai_rating FROM rating 
             WHERE id_user='$id_user' AND id_wisata='".$wisata['id_wisata']."'"
          );
          $r = mysqli_fetch_assoc($cek);
          if ($r) $myRating = $r['nilai_rating'];
        }
        ?>

        <div class="card">
          <img src="../img/<?= htmlspecialchars($wisata['gambar']); ?>" alt="<?= htmlspecialchars($wisata['nama_wisata']); ?>">
          <div class="card-content">
            <h3><?= htmlspecialchars($wisata['nama_wisata']); ?></h3>
            <p><strong>Lokasi:</strong> <?= htmlspecialchars($wisata['lokasi']); ?></p>

            <div class="rating-info">⭐ <?= $wisata['rata_rating']; ?> / 5</div>
            <div class="rating-count">(<?= $wisata['jumlah_rating']; ?> orang memberi rating)</div>

            <?php if ($id_user): ?>
              <div class="star-rating" data-wisata="<?= $wisata['id_wisata']; ?>">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                  <span class="star <?= ($i <= $myRating) ? 'filled' : '' ?>" data-value="<?= $i ?>">★</span>
                <?php endfor; ?>
              </div>
            <?php else: ?>
              <p style="font-size:12px;color:#888;">Login untuk memberikan rating ⭐</p>
            <?php endif; ?>
          </div>

          <div class="buttons">
            <button class="btn-detail" onclick="location.href='../detail/detail.php?id=<?= $wisata['id_wisata']; ?>'">Detail</button>
            <button class="btn-favorit" onclick="location.href='../favoritku/favoritkan.php?id=<?= $wisata['id_wisata']; ?>'">Favoritkan</button>
          </div>
        </div>

      <?php endwhile; ?>
    <?php else: ?>
      <p class="no-data">Tidak ada destinasi ditemukan 😢</p>
    <?php endif; ?>
  </div>
</div>

<script>
// AUTO SUBMIT KETIKA PILIH KATEGORI
document.getElementById("kategoriSelect").addEventListener("change", function () {
    document.getElementById("filterForm").submit();
});

// AUTO SUBMIT SEARCH SAAT KETIK (DELAY 500ms)
let timer;
document.getElementById("searchInput").addEventListener("keyup", function () {
    clearTimeout(timer);
    timer = setTimeout(() => {
        document.getElementById("filterForm").submit();
    }, 500);
});

// ⭐ SISTEM RATING
document.querySelectorAll('.star-rating').forEach(container => {
  const stars = container.querySelectorAll('.star');

  stars.forEach(star => {
    // Hover efek
    star.addEventListener('mouseover', () => {
      const value = star.dataset.value;
      stars.forEach((s, i) => s.classList.toggle('filled', i < value));
    });

    // Klik simpan rating
    star.addEventListener('click', async () => {
      const value = star.dataset.value;
      const wisata = container.dataset.wisata;

      stars.forEach((s, i) => s.classList.toggle('filled', i < value));

      await fetch('../rating/rating.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id_wisata=${wisata}&rating=${value}`
      });

      location.reload();
    });
  });

  // Reset ke nilai asli saat mouse keluar
  container.addEventListener('mouseleave', () => {
    const filled = [...stars].filter(s => s.classList.contains('filled')).length;
    stars.forEach((s, i) => s.classList.toggle('filled', i < filled));
  });
});
</script>

</body>
</html>

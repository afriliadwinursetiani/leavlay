<?php
include "../koneksi/koneksi.php";
session_start();

$id_wisata = $_GET['id'];

// Ambil data wisata
$data = mysqli_query($koneksi, "SELECT * FROM wisata WHERE id_wisata='$id_wisata'");
$wisata = mysqli_fetch_assoc($data);

// Hitung rata-rata rating
$result = mysqli_query($koneksi, "SELECT AVG(rating) as rata FROM wisata_rating WHERE id_wisata='$id_wisata'");
$row = mysqli_fetch_assoc($result);
$rata_rating = round($row['rata'], 1);
?>

<h2><?php echo $wisata['nama_wisata']; ?></h2>
<p><strong>Lokasi:</strong> <?php echo $wisata['lokasi']; ?></p>
<p><strong>Rating:</strong> ⭐ <?php echo $rata_rating; ?> / 5</p>

<?php if (isset($_SESSION['id_user'])): ?>
<form action="rating.php" method="POST">
    <input type="hidden" name="id_wisata" value="<?php echo $id_wisata; ?>">
    <label>Berikan Rating:</label><br>
    <?php for ($i=1; $i<=5; $i++): ?>
        <input type="radio" name="rating" value="<?php echo $i; ?>" id="star<?php echo $i; ?>">
        <label for="star<?php echo $i; ?>">⭐</label>
    <?php endfor; ?>
    <br><br>
    <button type="submit">Kirim Rating</button>
</form>
<?php else: ?>
<p>Silakan <a href="../login.php">login</a> untuk memberi rating.</p>
<?php endif; ?>

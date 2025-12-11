<?php
include "../koneksi/koneksi.php";

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama_wisata'];
    $deskripsi = $_POST['deskripsi'];
    $lokasi = $_POST['lokasi'];
    $id_kategori = $_POST['id_kategori'];

    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];
    $folder = "../img/" . $gambar;

    if ($gambar != "") move_uploaded_file($tmp, $folder);

    $sql = "INSERT INTO wisata (nama_wisata, deskripsi, lokasi, id_kategori, gambar) 
            VALUES ('$nama', '$deskripsi', '$lokasi', '$id_kategori', '$gambar')";
    mysqli_query($koneksi, $sql);

    header("Location: wisata.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Wisata</title>

  <style>
    body {
        font-family: 'Poppins', sans-serif;
        background: url('https://images.unsplash.com/photo-1501785888041-af3ef285b470') no-repeat center/cover;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }

    /* GLASS CONTAINER */
    .container {
        width: 90%;
        max-width: 700px;
        padding: 45px 40px;          /* padding dibuat lebih seimbang */
        border-radius: 22px;

        background: rgba(255, 255, 255, 0.20);
        backdrop-filter: blur(5px);
        -webkit-backdrop-filter: blur(5px);

        border: 1px solid rgba(255,255,255,0.45);
        box-shadow: 0 12px 40px rgba(0,0,0,0.28);
        animation: fadeIn .6s ease;
    }

    h2 {
        text-align: center;
        font-weight: 700;
        margin-bottom: 30px;
        color: white;
        font-size: 30px;
        text-shadow: 0 2px 4px rgba(0,0,0,0.5);
        letter-spacing: .5px;
    }

    /* FORM CONTAINER */
    .form-box {
        display: flex;
        flex-direction: column;
        gap: 22px;     /* jarak antar input lebih konsisten */
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .form-group label {
        font-weight: 600;
        color: white;
        font-size: 15px;
        text-shadow: 0 1px 3px rgba(0,0,0,0.6);
    }

    /* INPUT, TEXTAREA, SELECT */
    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 13px 15px;
        border-radius: 12px;
        background: rgba(255,255,255,0.85);
        color: #222;
        border: 1px solid rgba(255,255,255,0.55);
        font-size: 14px;
        outline: none;
        transition: all 0.25s ease;
    }

    .form-group textarea {
        resize: none;
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        background: #ffffff;
        border-color: #67b7ff;
        box-shadow: 0 0 6px #67b7ff;
    }

    /* BUTTONS */
    .btn-simpan {
        background: #62a0deb7;
        color: white;
        border: none;
        padding: 14px;
        width: 104%;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 15px;
        cursor: pointer;
        transition: 0.25s;
        margin-top: 10px;
    }

    .btn-simpan:hover {
        background: #91b6deb1;
    }

    .btn-kembali {
        display: inline-block;
        margin-top: 12px;
        padding: 14px;
        width: 100%;
        border-radius: 12px;
        background: rgba(0,0,0,0.45);
        color: white;
        text-align: center;
        text-decoration: none;
        font-size: 15px;
        transition: 0.25s;
    }

    .btn-kembali:hover {
        background: rgba(0,0,0,0.65);
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(14px); }
        to { opacity: 1; transform: translateY(0); }
    }
  </style>

</head>
<body>

<div class="container">
  <h2>Tambah Data Wisata</h2>

  <form method="post" enctype="multipart/form-data" class="form-box">
    
    <div class="form-group">
      <label>Nama Wisata</label>
      <input type="text" name="nama_wisata" placeholder="Masukkan nama wisata..." required>
    </div>

    <div class="form-group">
      <label>Deskripsi</label>
      <textarea name="deskripsi" rows="5" placeholder="Masukkan deskripsi wisata..." required></textarea>
    </div>

    <div class="form-group">
      <label>Lokasi</label>
      <input type="text" name="lokasi" placeholder="Masukkan lokasi wisata..." required>
    </div>

    <div class="form-group">
      <label>Kategori</label>
      <select name="id_kategori" required>
        <?php
        $kat = mysqli_query($koneksi, "SELECT * FROM kategori");
        while ($k = mysqli_fetch_assoc($kat)) {
          echo "<option value='{$k['id_kategori']}'>{$k['nama_kategori']}</option>";
        }
        ?>
      </select>
    </div>

    <div class="form-group">
      <label>Gambar</label>
      <input type="file" name="gambar" accept="image/*">
    </div>

    <button type="submit" name="simpan" class="btn-simpan">Simpan</button>
    <a href="wisata.php" class="btn-kembali">Kembali</a>

  </form>
</div>

</body>
</html>

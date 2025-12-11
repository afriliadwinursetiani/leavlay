<?php
include "../koneksi/koneksi.php";

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM wisata WHERE id_wisata='$id'"));

if (isset($_POST['update'])) {
    $nama = $_POST['nama_wisata'];
    $deskripsi = $_POST['deskripsi'];
    $lokasi = $_POST['lokasi'];
    $id_kategori = $_POST['id_kategori'];

    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];

    if ($gambar != "") {
        $folder = "../img/" . $gambar;
        move_uploaded_file($tmp, $folder);
        $update = "UPDATE wisata SET 
                    nama_wisata='$nama',
                    deskripsi='$deskripsi',
                    lokasi='$lokasi',
                    id_kategori='$id_kategori',
                    gambar='$gambar'
                   WHERE id_wisata='$id'";
    } else {
        $update = "UPDATE wisata SET 
                    nama_wisata='$nama',
                    deskripsi='$deskripsi',
                    lokasi='$lokasi',
                    id_kategori='$id_kategori'
                   WHERE id_wisata='$id'";
    }

    mysqli_query($koneksi, $update);
    header("Location: wisata.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Wisata - Leavlay</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: url('https://images.unsplash.com/photo-1501785888041-af3ef285b470') no-repeat center/cover;
            margin: 0;
            padding: 0;
            min-height: 100vh;

            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* CARD GLASS EFFECT */
        .container {
            width: 90%;
            max-width: 700px;
            padding: 45px 40px;

            border-radius: 22px;
            background: rgba(255, 255, 255, 0.22);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);

            border: 1px solid rgba(255,255,255,0.40);
            box-shadow: 0 12px 40px rgba(0,0,0,0.28);
            animation: fadeIn .6s ease;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            font-weight: 700;
            font-size: 30px;
            color: white;
            text-shadow: 0 2px 4px rgba(0,0,0,0.5);
            letter-spacing: .5px;
        }

        .form-box {
            display: flex;
            flex-direction: column;
            gap: 22px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group label {
            color: white;
            font-weight: 600;
            text-shadow: 0 1px 3px rgba(0,0,0,0.6);
        }

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
            transition: .25s ease;
        }

        .form-group textarea {
            resize: none;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            background: white;
            border-color: #67b7ff;
            box-shadow: 0 0 6px #67b7ff;
        }

        .preview img {
            width: 120px;
            height: 80px;
            margin-top: 8px;
            border-radius: 8px;
            object-fit: cover;
            border: 2px solid white;
        }

        .button-group {
            display: flex;
            gap: 15px;
            margin-top: 15px;
        }

        .btn-update {
            flex: 1;
            background: #62a0deb7;
            color: white;
            padding: 14px;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            transition: .25s;
        }

        .btn-update:hover {
            background: #91b6deb1;
        }

        .btn-back {
            flex: 1;
            background: rgba(0,0,0,0.45);
            color: white;
            padding: 14px;
            border-radius: 12px;
            text-align: center;
            text-decoration: none;
            transition: .25s;
        }

        .btn-back:hover {
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
    <h2><i class="fa-solid fa-pen-to-square"></i> Edit Data Wisata</h2>

    <form method="post" enctype="multipart/form-data" class="form-box">

        <div class="form-group">
            <label>Nama Wisata</label>
            <input type="text" name="nama_wisata" value="<?= htmlspecialchars($data['nama_wisata']); ?>" required>
        </div>

        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi" rows="5" required><?= htmlspecialchars($data['deskripsi']); ?></textarea>
        </div>

        <div class="form-group">
            <label>Lokasi</label>
            <input type="text" name="lokasi" value="<?= htmlspecialchars($data['lokasi']); ?>" required>
        </div>

        <div class="form-group">
            <label>Kategori</label>
            <select name="id_kategori" required>
                <?php
                $kat = mysqli_query($koneksi, "SELECT * FROM kategori");
                while ($k = mysqli_fetch_assoc($kat)) {
                    $selected = ($k['id_kategori'] == $data['id_kategori']) ? "selected" : "";
                    echo "<option value='{$k['id_kategori']}' $selected>{$k['nama_kategori']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label>Gambar</label>
            <input type="file" name="gambar" accept="image/*">
            <div class="preview">
                <img src="../img/<?= htmlspecialchars($data['gambar']); ?>" alt="Gambar Wisata">
            </div>
        </div>

        <div class="button-group">
            <button type="submit" name="update" class="btn-update">Update</button>
            <a href="wisata.php" class="btn-back">Kembali</a>
        </div>

    </form>
</div>

</body>
</html>

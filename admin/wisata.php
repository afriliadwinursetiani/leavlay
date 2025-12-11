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
    echo "<script>alert('Akses ditolak! Halaman hanya untuk admin'); window.location='../login/login.php';</script>";
    exit;
}

// Ambil search jika ada
$search = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : "";

// Query data wisata
$query = mysqli_query($koneksi, "
    SELECT w.*, k.nama_kategori
    FROM wisata w
    LEFT JOIN kategori k ON w.id_kategori = k.id_kategori
    WHERE w.nama_wisata LIKE '%$search%'
    ORDER BY w.id_wisata DESC
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Wisata - Leavlay Admin</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Poppins, sans-serif;
    }

    body {
        background: #f3f4f6;
        display: flex;
    }

    /* CONTENT */
    .content {
        padding: 25px;
        margin-left: 250px;
        width: calc(100% - 250px);
    }

    /* HEADER BAR */
    .header-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #ffffff;
        padding: 20px 25px;
        border-radius: 14px;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.05);
        margin-bottom: 25px;
    }

    .header-bar h1 {
        font-size: 25px;
        font-weight: 700;
        color: #111827;
    }

    /* SEARCH GROUP */
    .search-group {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .search-group input {
        width: 300px;
        padding: 13px 18px;
        border-radius: 50px;
        border: 2px solid #e5e7eb;
        background: #f9fafb;
        font-size: 15px;
        transition: 0.2s;
    }

    .search-group input:focus {
        border-color: #4f46e5;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.12);
        outline: none;
    }

    .btn-search-round {
        background: #4f46e5;
        color: white;
        padding: 13px 16px;
        border-radius: 50px;
        border: none;
        font-size: 16px;
        cursor: pointer;
        transition: 0.2s;
    }

    .btn-search-round:hover {
        background: #4338ca;
        transform: translateY(-2px);
    }

    .btn-add-modern {
        background: #22c55e;
        color: white;
        padding: 13px 22px;
        border-radius: 50px;
        text-decoration: none;
        font-size: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: 0.2s;
        font-weight: 500;
    }

    .btn-add-modern:hover {
        background: #16a34a;
        transform: translateY(-2px);
    }

    /* TABLE */
    .table-wrapper {
        background: #fff;
        padding: 20px;
        border-radius: 14px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 900px;
    }

    th {
        padding: 14px;
        background: linear-gradient(45deg, #4f46e5, #6366f1);
        color: white;
        text-align: left;
        font-size: 15px;
    }

    td {
        padding: 14px;
        border-bottom: 1px solid #e5e7eb;
    }

    tr:hover {
        background: #f9fafb;
        transition: 0.2s;
    }

    img {
        width: 90px;
        height: 65px;
        object-fit: cover;
        border-radius: 8px;
    }

    .action-btn {
        display: flex;
        gap: 10px;
    }

    .btn {
        padding: 8px 14px;
        border-radius: 8px;
        font-size: 13px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: 0.2s;
        font-weight: 500;
    }

    .btn-edit { background: #fbbf24; color: #000; }
    .btn-delete { background: #ef4444; color: #fff; }

    .btn:hover { transform: translateY(-2px); opacity: .9; }
</style>

</head>

<body>

<?php include "sidebar.php"; ?>

<main class="content">

    <div class="header-bar">
        <h1>Data Wisata</h1>

        <form method="GET" class="search-group">
            <input type="text" name="search" placeholder="Cari wisata..." value="<?= $search ?>">
            <button class="btn-search-round"><i class="fa fa-search"></i></button>
        </form>

        <a href="tambahw.php" class="btn-add-modern">
            <i class="fa fa-plus"></i> Tambah Wisata
        </a>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Wisata</th>
                    <th>Deskripsi</th>
                    <th>Lokasi</th>
                    <th>Kategori</th>
                    <th>Gambar</th>
                    <th>Tindakan</th>
                </tr>
            </thead>

            <tbody>
            <?php
            $no = 1;
            while ($row = mysqli_fetch_assoc($query)) {
            ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($row['nama_wisata']); ?></td>
                    <td><?= substr(htmlspecialchars($row['deskripsi']), 0, 80); ?>...</td>
                    <td><?= htmlspecialchars($row['lokasi']); ?></td>
                    <td><?= htmlspecialchars($row['nama_kategori']); ?></td>

                    <td>
                        <?php if (!empty($row['gambar'])) { ?>
                            <img src="../img/<?= $row['gambar']; ?>">
                        <?php } else { ?>
                            <span style="color: gray;">Tidak ada</span>
                        <?php } ?>
                    </td>

                    <td>
                        <div class="action-btn">
                            <a href="editw.php?id=<?= $row['id_wisata']; ?>" class="btn btn-edit">
                                <i class="fa fa-pen"></i> Edit
                            </a>
                            <a href="hapusw.php?id=<?= $row['id_wisata']; ?>" class="btn btn-delete" onclick="return confirm('Yakin ingin menghapus data ini?');">
                                <i class="fa fa-trash"></i> Hapus
                            </a>
                        </div>
                    </td>
                </tr>
            <?php } ?>
            </tbody>

        </table>
    </div>

</main>

</body>
</html>

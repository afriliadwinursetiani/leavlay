<?php
session_start();
include "../koneksi/koneksi.php";

if (!isset($_SESSION['username'])) {
  header("Location: ../login/login.php");
  exit;
}

$username = $_SESSION['username'];
$role = $_SESSION['role'] ?? '';

if ($role !== 'admin') {
  echo "<script>alert('Akses ditolak! Halaman ini hanya untuk admin.'); window.location='../login/login.php';</script>";
  exit;
}

// ----------------------------
// SISTEM PENCARIAN
// ----------------------------
$search = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : '';

$query_str = "SELECT * FROM users WHERE 1";

if (!empty($search)) {
    $query_str .= " AND (
        username LIKE '%$search%' OR
        nama_lengkap LIKE '%$search%' OR
        email LIKE '%$search%'
    )";
}

$query_str .= " ORDER BY id_user DESC";

$query = mysqli_query($koneksi, $query_str);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data Pengguna - Leavlay Admin</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
    }

    body {
      background: #f3f4f6;
      display: flex;
    }

    /* CONTENT AREA */
    .content {
      padding: 25px;
      margin-left: 250px;
      width: calc(100% - 250px);
    }

    /* TOP BAR */
    .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: #ffffff;
      padding: 15px 20px;
      border-radius: 12px;
      box-shadow: 0 3px 12px rgba(0,0,0,0.08);
      margin-bottom: 20px;
      gap: 10px;
    }

    .top-bar h1 {
      font-size: 22px;
      font-weight: 600;
      color: #111827;
    }

    /* SEARCH */
    .search-box {
      display: flex;
      gap: 10px;
      align-items: center;
    }

    .search-box input {
      padding: 9px 12px;
      border: 1px solid #d1d5db;
      border-radius: 8px;
      width: 220px;
      outline: none;
    }

    .search-box input:focus {
      border-color: #4f46e5;
    }

    .btn-search {
      background: #4f46e5;
      color: white;
      padding: 9px 15px;
      border-radius: 8px;
      cursor: pointer;
      border: none;
      font-weight: 500;
    }

    .btn-search:hover {
      opacity: 0.9;
    }

    /* BUTTON */
    .btn {
      padding: 9px 14px;
      border-radius: 8px;
      text-decoration: none;
      font-size: 14px;
      display: inline-flex;
      align-items: center;
      gap: 7px;
      transition: 0.2s;
      font-weight: 500;
      cursor: pointer;
    }

    .btn-add { background: #22c55e; color: white; }
    .btn-add:hover { opacity: 0.9; transform: translateY(-2px); }

    .btn-edit { background: #fbbf24; color: #000; }
    .btn-edit:hover { opacity: 0.9; transform: translateY(-2px); }

    .btn-delete { background: #ef4444; color: white; }
    .btn-delete:hover { opacity: 0.9; transform: translateY(-2px); }

    /* TABLE WRAPPER */
    .table-wrapper {
      background: white;
      padding: 20px;
      border-radius: 14px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.08);
      overflow-x: auto;
    }

    /* TABLE STYLE */
    table {
      width: 100%;
      border-collapse: collapse;
      min-width: 800px;
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

    /* ACTION BUTTONS */
    .actions {
      display: flex;
      gap: 10px;
    }

  </style>
</head>

<body>

  <?php include "sidebar.php"; ?>

  <main class="content">

    <div class="top-bar">

      <h1>Data Pengguna</h1>

      <!-- 🔍 FORM PENCARIAN -->
      <form method="GET" class="search-box">
        <input 
          type="text" 
          name="search" 
          placeholder="Cari pengguna..."
          value="<?= htmlspecialchars($search); ?>">
        <button class="btn-search"><i class="fa fa-search"></i></button>
      </form>

      <a href="tamda.php" class="btn btn-add">
        <i class="fa fa-plus"></i> Tambah Pengguna
      </a>
    </div>

    <div class="table-wrapper">
      <table>
        <thead>
          <tr>
            <th>No</th>
            <th>Username</th>
            <th>Role</th>
            <th>Nama Lengkap</th>
            <th>Email</th>
            <th>Tindakan</th>
          </tr>
        </thead>

        <tbody>
          <?php
          $no = 1;
          while ($row = mysqli_fetch_assoc($query)) { ?>
          <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($row['username']); ?></td>
            <td><?= htmlspecialchars($row['role']); ?></td>
            <td><?= htmlspecialchars($row['nama_lengkap']); ?></td>
            <td><?= htmlspecialchars($row['email']); ?></td>

            <td>
              <div class="actions">
                <a href="ditad.php?id_user=<?= $row['id_user']; ?>" class="btn btn-edit">
                  <i class="fa fa-pen"></i> Edit
                </a>

                <a href="hapad.php?id_user=<?= $row['id_user']; ?>" class="btn btn-delete"
                   onclick="return confirm('Yakin ingin menghapus pengguna ini?');">
                  <i class="fa fa-trash"></i> Hapus
                </a>
              </div>
            </td>

          </tr>
          <?php } ?>
        </tbody>

      </table>

      <?php if (mysqli_num_rows($query) == 0): ?>
        <p style="padding: 15px; text-align:center; color:#777;">Tidak ada data ditemukan...</p>
      <?php endif; ?>

    </div>

  </main>
</body>
</html>

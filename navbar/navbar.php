<?php
// Jalankan session hanya jika belum aktif
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../koneksi/koneksi.php';

// Cegah admin akses halaman user kecuali halaman tertentu
if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {

    // daftar halaman user yang boleh dibuka admin
    $halaman_boleh = ['index.php', 'jelajahi.php', 'detail.php'];

    $current_page = basename($_SERVER['PHP_SELF']);

    if (!in_array($current_page, $halaman_boleh)) {
        header("Location: ../admin/index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Navbar - Leavlay</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }
    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: rgba(156, 132, 117, 0.75);
      backdrop-filter: blur(12px);
      padding: 12px 35px;
      position: sticky;
      top: 0;
      z-index: 999;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.25);
      transition: background 0.3s ease, box-shadow 0.3s ease;
    }
    .navbar:hover {
      background: rgba(156, 132, 117, 0.9);
      box-shadow: 0 4px 25px rgba(0, 0, 0, 0.3);
    }
    .logo {
      color: #ffffff;
      font-size: 24px;
      font-weight: 700;
      text-decoration: none;
      letter-spacing: 1px;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .logo i {
      color: #fff7e9;
      font-size: 22px;
    }
    .navbar ul {
      list-style: none;
      display: flex;
      align-items: center;
      gap: 20px;
    }
    .navbar ul li a {
      text-decoration: none;
      color: #ffffff;
      font-weight: 500;
      padding: 8px 14px;
      border-radius: 8px;
      transition: all 0.3s ease;
    }
    .navbar ul li a:hover {
      background: #ce9c5a;
      color: #fff;
      transform: translateY(-2px);
    }
    .user-info {
      color: #fff;
      font-weight: 500;
      margin-right: 10px;
      font-size: 15px;
    }
    .navbar ul li a.btn {
      background: #6b4a3a;
      color: #fff;
      border-radius: 25px;
      padding: 8px 18px;
      font-weight: 600;
      transition: all 0.3s ease;
    }
    .navbar ul li a.btn:hover {
      background: #5a3c2e;
      transform: translateY(-2px);
    }
    @media (max-width: 768px) {
      .navbar {
        flex-wrap: wrap;
        justify-content: center;
        text-align: center;
        padding: 15px;
      }
      .navbar ul {
        flex-direction: column;
        gap: 10px;
        margin-top: 10px;
      }
      .navbar .logo {
        margin-bottom: 10px;
      }
    }
  </style>
</head>
<body>

  <nav class="navbar">
    <a href="../view/index.php" class="logo">
      <i class="fa-solid fa-umbrella-beach"></i> Leavlay
    </a>

    <ul>
      <li><a href="../view/index.php"><i class="fa-solid fa-house"></i> Beranda</a></li>
      <li><a href="../jelajahi/jelajahi.php"><i class="fa-solid fa-map-location-dot"></i> Wisata</a></li>
      <li><a href="../favoritku/favorit.php"><i class="fa-solid fa-heart"></i> Favorit</a></li>

      <?php if (isset($_SESSION['username'])): ?>
        <li class="user-info"><i class="fa-solid fa-user"></i> <?= htmlspecialchars($_SESSION['nama_lengkap']); ?></li>
        <li><a href="../login/logout.php" class="btn"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
      <?php else: ?>
        <li><a href="../login/login.php" class="btn"><i class="fa-solid fa-right-to-bracket"></i> Login</a></li>
      <?php endif; ?>
    </ul>
  </nav>

</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Leavlay</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <style>
    body, html {
      margin: 0;
      padding: 0;
      height: 100%;
      font-family: 'Roboto', sans-serif;
    }

    /* Hero Section */
    .hero {
      width: 100%;
      height: 100vh;
      background: url('../img/home.png') no-repeat center center;
      background-size: cover;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      color: white;
      padding: 0 20px;
    }

    .hero h1 {
      font-size: 36px;
      margin-bottom: 15px;
      text-shadow: 1px 1px 4px rgba(0,0,0,0.7);
    }

    .hero p {
      font-size: 18px;
      max-width: 600px;
      margin-bottom: 25px;
      text-shadow: 1px 1px 3px rgba(0,0,0,0.6);
    }

    .hero .btn {
      background-color: #232625ff;
      color: #fff;
      padding: 12px 30px;
      border: none;
      border-radius: 25px;
      font-size: 16px;
      cursor: pointer;
      transition: 0.3s;
    }

    .hero .btn:hover {
      background-color: #c4c4c4ff;
    }
  </style>
</head>
<body>

  <!-- Panggil navbar -->
  <?php include '../navbar/navbar.php';
  include '../koneksi/koneksi.php'; ?>

  <!-- Hero Section -->
  <section class="hero">
    <h1>Selamat Datang di <strong>Leavlay</strong></h1>
<p>Selamat datang di surga nya wisata Sumatera Barat! Dari pesona alam yang memukau hingga kekayaan budaya Minangkabau, semua siap menanti langkah petualanganmu.</p>
    <button class="btn" onclick="location.href='../jelajahi/jelajahi.php'">Mulai Menjelajahi</button>
  </section>

</body>
</html>

<?php
include '../koneksi/koneksi.php'; // koneksi database

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = md5($_POST['password']); // pakai MD5
    $nama = $_POST['nama_lengkap'];

    // Simpan ke tabel user
    $query = "INSERT INTO users (nama_lengkap, username, email, password) VALUES ('$nama', '$username', '$email', '$password')";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location='login.php';</script>";
    } else {
        echo "<script>alert('Registrasi gagal!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar - Leavlay</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: url('../img/kapal.png') no-repeat center center/cover;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .register-container {
      background: #c7ac9dab;
      backdrop-filter: blur(10px);
      border-radius: 25px;
      padding: 40px 50px;
      width: 85%;
      max-width: 850px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
      color: #fff;
    }

    h2 {
      text-align: center;
      margin-bottom: 25px;
      color: #fff;
      font-weight: 600;
      font-size: 26px;
    }

    form {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px 25px;
    }

    label {
      font-size: 15px;
      font-weight: 500;
      color: #ffffff;
      display: flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 6px;
    }

    input {
      width: 100%;
      padding: 12px 15px;
      border: none;
      border-radius: 25px;
      font-size: 14px;
      background: rgba(255, 255, 255, 0.9);
      color: #333;
      outline: none;
      box-shadow: inset 0 2px 3px rgba(0,0,0,0.1);
    }

    input::placeholder {
      color: #888;
    }

    .full-width {
      grid-column: span 2;
      text-align: center;
    }

    button {
      width: 40%;
      background: #6b4a3a;
      color: white;
      border: none;
      padding: 12px 0;
      border-radius: 30px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }

    button:hover {
      background: #5a3c2e;
      transform: translateY(-2px);
    }

    .login-link {
      margin-top: 15px;
      font-size: 14px;
      color: #fff;
    }

    .login-link a {
      color: #a9d9f3ff;
      text-decoration: none;
      font-weight: 600;
    }

    .login-link a:hover {
      text-decoration: underline;
    }

    /* Responsive */
    @media (max-width: 700px) {
      form {
        grid-template-columns: 1fr;
      }
      .full-width {
        grid-column: span 1;
      }
      button {
        width: 100%;
      }
    }
  </style>
</head>
<body>

  <div class="register-container">
    <h2>Daftar Akun Baru</h2>
    <form method="POST" action="">
      <div>
        <label><i class="fa fa-user"></i> Username</label>
        <input type="text" name="username" placeholder="Masukan Nama..." required>
      </div>
      <div>
        <label><i class="fa fa-id-card"></i> Nama Lengkap</label>
        <input type="text" name="nama_lengkap" placeholder="Masukan Nama Lengkap..." required>
      </div>
      <div>
        <label><i class="fa fa-lock"></i> Password</label>
        <input type="password" name="password" placeholder="Masukan Password..." required>
      </div>
      <div>
        <label><i class="fa fa-envelope"></i> Email</label>
        <input type="email" name="email" placeholder="Masukan Email..." required>
      </div>
      <div class="full-width">
        <p class="login-link">Sudah Punya Akun? <a href="login.php">Login Sekarang</a></p>
        <button type="submit" name="register">DAFTAR</button>
      </div>
    </form>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
</body>
</html>

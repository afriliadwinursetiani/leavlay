<?php
include "../koneksi/koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username']);
  $password = md5($_POST['password']);
  $nama = trim($_POST['nama_lengkap']);
  $email = trim($_POST['email']);
  $role = $_POST['role'];

  // 🔹 Cek username
  $cek = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username'");
  if (mysqli_num_rows($cek) > 0) {
    echo "<script>alert('❌ Username sudah digunakan!'); window.history.back();</script>";
    exit;
  }

  // 🔹 Simpan user baru
  $query = "INSERT INTO users (username, password, nama_lengkap, email, role) 
            VALUES ('$username', '$password', '$nama', '$email', '$role')";

  if (mysqli_query($koneksi, $query)) {
    echo "<script>alert('✅ Pengguna berhasil ditambahkan!'); window.location='pengguna.php';</script>";
    exit;
  } else {
    echo "<script>alert('Terjadi kesalahan: " . mysqli_error($koneksi) . "');</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Pengguna</title>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: Poppins, sans-serif;
      margin: 0;
      min-height: 100vh;

      background: url('https://images.unsplash.com/photo-1501785888041-af3ef285b470')
        no-repeat center/cover;

      display: flex;
      justify-content: center;
      align-items: center;
    }

    form {
      width: 90%;
      max-width: 420px;

      padding: 40px 32px;

      border-radius: 20px;
      background: rgba(255, 255, 255, 0.23);
      backdrop-filter: blur(5px);
      -webkit-backdrop-filter: blur(5px);

      border: 1px solid rgba(255, 255, 255, 0.45);
      box-shadow: 0 10px 30px rgba(0,0,0,0.25);

      animation: fadeIn .6s ease;
    }

    h2 {
      text-align: center;
      margin-bottom: 25px;
      font-weight: 700;
      font-size: 28px;
      color: white;
      text-shadow: 0 2px 4px rgba(0,0,0,0.6);
    }

    label {
      font-weight: 600;
      color: white;
      text-shadow: 0 1px 2px rgba(0,0,0,0.5);
      margin-bottom: 6px;
      display: block;
    }

    input, select {
      width: 100%;
      padding: 12px 14px;

      border-radius: 12px;
      border: 1px solid rgba(255,255,255,0.6);

      background: rgba(255,255,255,0.85);
      font-size: 14px;
      margin-bottom: 15px;

      transition: .25s ease;
    }

    input:focus,
    select:focus {
      background: white;
      border-color: #67b7ff;
      box-shadow: 0 0 6px #67b7ff;
      outline: none;
    }

    button {
      width: 100%;
      padding: 13px;

      background: #62a0deb7;
      color: white;
      border: none;
      border-radius: 12px;
      font-size: 16px;
      cursor: pointer;
      font-weight: 600;

      transition: .25s ease;
    }

    button:hover {
      background: #8db9deb7;
    }

    a {
      text-decoration: none;
      text-align: center;
      display: block;
      margin-top: 16px;
      color: white;
      padding: 10px;
      background: rgba(0,0,0,0.45);
      border-radius: 12px;
      transition: .25s ease;
    }

    a:hover {
      background: rgba(0,0,0,0.65);
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(15px); }
      to   { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>

<body>

  <form method="POST">
    <h2>Tambah Pengguna</h2>

    <label>Username</label>
    <input type="text" name="username" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <label>Nama Lengkap</label>
    <input type="text" name="nama_lengkap" required>

    <label>Email</label>
    <input type="email" name="email" required>

    <label>Role</label>
    <select name="role" required>
      <option value="user">User</option>
      <option value="admin">Admin</option>
    </select>

    <button type="submit">Tambah</button>
    <a href="pengguna.php">Kembali</a>
  </form>

</body>
</html>

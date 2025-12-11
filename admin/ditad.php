<?php
include "../koneksi/koneksi.php";

$id = $_GET['id_user'];
$result = mysqli_query($koneksi, "SELECT * FROM users WHERE id_user='$id'");
$row = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['username'];
  $nama = $_POST['nama_lengkap'];
  $email = $_POST['email'];
  $role = $_POST['role'];

  if (!empty($_POST['password'])) {
    $password = md5($_POST['password']);
    $query = "UPDATE users SET username='$username', nama_lengkap='$nama', email='$email', role='$role', password='$password' WHERE id_user='$id'";
  } else {
    $query = "UPDATE users SET username='$username', nama_lengkap='$nama', email='$email', role='$role' WHERE id_user='$id'";
  }

  if (mysqli_query($koneksi, $query)) {
    header("Location: pengguna.php");
    exit;
  } else {
    echo "Error: " . mysqli_error($koneksi);
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Pengguna</title>

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
    <h2>Edit Pengguna</h2>

    <label>Username:</label>
    <input type="text" name="username" value="<?= $row['username']; ?>" required>

    <label>Password (kosongkan jika tidak diubah):</label>
    <input type="password" name="password">

    <label>Nama Lengkap:</label>
    <input type="text" name="nama_lengkap" value="<?= $row['nama_lengkap']; ?>" required>

    <label>Email:</label>
    <input type="email" name="email" value="<?= $row['email']; ?>" required>

    <label>Role:</label>
    <select name="role">
      <option value="user" <?= $row['role']=='user'?'selected':''; ?>>User</option>
      <option value="admin" <?= $row['role']=='admin'?'selected':''; ?>>Admin</option>
    </select>

    <button type="submit">Simpan Perubahan</button>
    <a href="pengguna.php">Kembali</a>
  </form>

</body>
</html>

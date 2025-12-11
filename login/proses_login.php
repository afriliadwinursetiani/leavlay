<?php
session_start();
include "../koneksi/koneksi.php"; // koneksi ke database

// Cek apakah form dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Ambil data dari form dan lindungi dari injeksi SQL
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    // Enkripsi password dengan MD5 agar cocok dengan data di database
    $password_md5 = md5($password);

    // Ambil data user dari database berdasarkan username
    $query = "SELECT * FROM users WHERE username='$nama' AND password='$password_md5' LIMIT 1";
    $result = mysqli_query($koneksi, $query);

    // Jika username dan password cocok
    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);

        // Buat session login
        $_SESSION['id_user'] = $data['id_user'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['role'] = $data['role'];
        $_SESSION['nama_lengkap'] = $data['nama_lengkap'];

        // Redirect berdasarkan role
        if ($data['role'] == 'user') {
            header("Location: ../view/index.php");
        } else {
            header("Location: ../admin/dashboard.php");
        }
        exit();

    } else {
        // Jika login gagal
        echo "<script>
                alert('Nama atau password salah!');
                window.location.href='../login/login.php';
              </script>";
    }
}
?>

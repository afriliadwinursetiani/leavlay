<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Leavlay</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

  <!-- Font Awesome (untuk ikon user & lock) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    /* RESET */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background: url('../img/kapal.png') no-repeat center center/cover;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    /* CARD LOGIN */
    .login-box {
      background: #c7ac9dab;
      backdrop-filter: blur(10px);
      border-radius: 25px;
      padding: 40px 50px;
      width: 400px;
      color: #ffffff;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
    }

    .login-box h2 {
      text-align: center;
      margin-bottom: 30px;
      font-weight: 600;
      font-size: 26px;
      color: #ffffff;
    }

    /* FORM INPUT */
    .input-group {
      margin-bottom: 20px;
      position: relative;
    }

    .input-group i {
      position: absolute;
      top: 50%;
      left: 15px;
      transform: translateY(-50%);
      color: #5a3c2e;
      font-size: 16px;
    }

    .input-group input {
      width: 100%;
      padding: 12px 15px 12px 40px;
      border-radius: 25px;
      border: none;
      outline: none;
      background: rgba(255, 255, 255, 0.9);
      color: #333;
      font-size: 14px;
      box-shadow: inset 0 2px 3px rgba(0, 0, 0, 0.1);
    }

    .input-group input::placeholder {
      color: #888;
    }

    .input-group label {
      display: block;
      margin-bottom: 8px;
      font-weight: 500;
      color: #ffffff;
      font-size: 15px;
    }

    /* BUTTON LOGIN */
    .btn-login {
      width: 100%;
      background: #6b4a3a;
      color: white;
      padding: 12px;
      border: none;
      border-radius: 30px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
      margin-top: 10px;
    }

    .btn-login:hover {
      background: #5a3c2e;
      transform: translateY(-2px);
    }

    /* LINK REGISTER */
    .register-link {
      text-align: center;
      margin-top: 20px;
      font-size: 14px;
      color: #fff;
    }

    .register-link a {
      color: #a9d9f3ff;
      text-decoration: none;
      font-weight: 600;
    }

    .register-link a:hover {
      text-decoration: underline;
    }

    /* RESPONSIVE */
    @media (max-width: 500px) {
      .login-box {
        width: 90%;
        padding: 30px 25px;
      }
    }
  </style>
</head>
<body>

  <div class="login-box">
    <h2>Login</h2>
    <form action="proses_login.php" method="POST">

      <div class="input-group">
        <i class="fa fa-user"></i>
        <input type="text" name="nama" placeholder="Masukan Nama..." required>
      </div>

      <div class="input-group">
        <i class="fa fa-lock"></i>
        <input type="password" name="password" placeholder="Masukan Password..." required>
      </div>

      <button type="submit" class="btn-login">LOGIN</button>

      <div class="register-link">
        Belum punya akun? <a href="register.php">Daftar Sekarang</a>
      </div>
    </form>
  </div>

</body>
</html>

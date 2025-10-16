<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login User</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    * {
      box-sizing: border-box;
      font-family: 'Inter', sans-serif;
    }

    body {
      margin: 0;
      padding: 0;
      background-image: url('../../assets/images/school_bg.png');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }

    .alert-box {
      background-color: #ffe0e0;
      color: #a70000;
      padding: 12px 16px;
      border-left: 6px solid #e60000;
      border-radius: 6px;
      margin-bottom: 20px;
      font-weight: 500;
    }

    .overlay {
      background-color: rgba(255, 255, 255, 0.9);
      border-radius: 10px;
      padding: 40px;
      max-width: 420px;
      width: 90%;
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
    }

    .overlay h2 {
      margin: 0 0 30px 0;
      color: #333;
      font-weight: 700;
      font-size: 26px;
      text-align: center;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      font-size: 16px;
      color: #333;
      display: block;
      margin-bottom: 6px;
    }

    .password-wrapper {
      position: relative;
    }

    .password-wrapper input {
      padding-right: 90px;
    }

    .toggle-password {
      position: absolute;
      top: 50%;
      right: 10px;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: #2f80ed;
      font-weight: 600;
      cursor: pointer;
      font-size: 14px;
    }

    .toggle-password:focus-visible {
      outline: 2px solid #1a30b3;
      outline-offset: 2px;
    }

    .login-btn {
      display: block;
      width: 100%;
      padding: 12px;
      background-color: #2f80ed;
      color: #fff;
      font-weight: bold;
      font-size: 18px;
      border: none;
      border-radius: 8px;
      box-shadow: 2px 2px 0 #555;
      cursor: pointer;
    }

    .login-btn:hover {
      background-color: #2366c6;
    }

    .footer-links {
      margin-top: 20px;
      padding-bottom: 20px;
      font-size: 14px;
      text-align: left;
      color: #333;
    }

    .footer-links a {
      color: #007bff;
      text-decoration: none;
      font-weight: 500;
    }

    .footer-links a:hover {
      text-decoration: underline;
    }

    footer {
      position: absolute;
      bottom: 10px;
      text-align: center;
      width: 100%;
      color: white;
      font-size: 14px;
      text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
    }
  </style>
</head>
<body>
  <div class="overlay">
    <h2>Login User</h2>
      <?php if (isset($_SESSION['login_message'])): ?>
        <div class="alert-box">
            ⚠️ <?= htmlspecialchars($_SESSION['login_message']) ?>
        </div>
        <?php unset($_SESSION['login_message']); ?>
      <?php endif; ?>
    <form action="../../controllers/user/user_login_handler.php" method="POST">
      <div class="form-group">
        <label for="nama">Nama</label>
        <input type="text" name="nama" id="nama" placeholder="Masukkan Nama Lengkap" required />
      </div>

      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" placeholder="Masukkan username" required />
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <div class="password-wrapper">
          <input type="password" name="password" id="password" placeholder="Masukkan password" required />
          <button type="button" class="toggle-password" aria-label="Tampilkan password" aria-pressed="false">Show</button>
        </div>
      </div>

      <div class="form-group">
        <label for="email">E-mail</label>
        <input type="email" name="email" id="email" placeholder="Masukkan E-mail" required />
      </div>

      <div class="form-group">
        <label for="no_hp">Nomor Handphone</label>
        <input type="tel" name="no_hp" id="no_hp" placeholder="Masukkan Nomor Handphone" required />
      </div>

      <button type="submit" class="login-btn">Daftar</button>
    </form>
  </div>

  <footer>
    &copy; 2025 Dash UI. All rights reserved.
  </footer>

  <script>
    // Wait until the page is fully loaded
    window.addEventListener('DOMContentLoaded', () => {
      const alertBox = document.querySelector('.alert-box');
      if (alertBox) {
        setTimeout(() => {
          alertBox.style.transition = 'opacity 0.6s ease';
          alertBox.style.opacity = '0';
          setTimeout(() => {
            alertBox.style.display = 'none';
          }, 600); // Match the transition duration
        }, 3000); // Wait 3 seconds before fading out
      }

      const passwordInput = document.querySelector('#password');
      const toggleButton = document.querySelector('.toggle-password');

      if (passwordInput && toggleButton) {
        toggleButton.addEventListener('click', () => {
          const isHidden = passwordInput.type === 'password';
          passwordInput.type = isHidden ? 'text' : 'password';
          toggleButton.textContent = isHidden ? 'Hide' : 'Show';
          toggleButton.setAttribute('aria-pressed', isHidden ? 'true' : 'false');
          toggleButton.setAttribute('aria-label', isHidden ? 'Sembunyikan password' : 'Tampilkan password');
        });
      }
    });
  </script>
</body>
</html>

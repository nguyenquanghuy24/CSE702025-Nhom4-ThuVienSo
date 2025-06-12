<?php
session_start();
include 'connect.php';

// Xử lý khi người dùng submit form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $user = $_POST['user'];
  $pass = $_POST['pass'];
  $confirm = $_POST['confirm'];
  $email = $_POST['email'];

  if ($pass !== $confirm) {
    $_SESSION['register_error'] = "Mật khẩu xác nhận không khớp.";
    header("Location: register.php");
    exit();
  }

  // Kiểm tra tên đăng nhập trùng
  $stmt = $conn->prepare("SELECT * FROM tbl_user WHERE user = ?");
  $stmt->bind_param("s", $user);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $_SESSION['register_error'] = "Tên đăng nhập đã tồn tại.";
    header("Location: register.php");
    exit();
  }

  // Thêm người dùng mới
  $stmt = $conn->prepare("INSERT INTO tbl_user (user, pass, email) VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $user, $pass, $email);

  if ($stmt->execute()) {
    $_SESSION['user'] = $user;
    header("Location: ../index.php");
    exit();
  } else {
    $_SESSION['register_error'] = "Đăng ký thất bại. Vui lòng thử lại.";
    header("Location: register.php");
    exit();
  }

  $stmt->close();
}
?>

<!-- HTML giao diện đăng ký -->
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đăng ký tài khoản</title>
  <link rel="stylesheet" href="../test.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f0f2f5;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .register-container {
      background: white;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      width: 350px;
    }
    h2 {
      text-align: center;
      margin-bottom: 20px;
    }
    input, button {
      width: 100%;
      padding: 10px;
      margin-top: 10px;
    }
    p.error {
      color: red;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="register-container">
    <h2>Đăng ký</h2>

    <?php if (isset($_SESSION['register_error'])): ?>
      <p class="error"><?php echo $_SESSION['register_error']; unset($_SESSION['register_error']); ?></p>
    <?php endif; ?>

    <form method="POST" action="">
      <label for="user">Tên đăng nhập:</label>
      <input type="text" name="user" id="user" required>

      <label for="email">Email:</label>
      <input type="email" name="email" id="email" required>

      <label for="pass">Mật khẩu:</label>
      <input type="password" name="pass" id="pass" required>

      <label for="confirm">Xác nhận mật khẩu:</label>
      <input type="password" name="confirm" id="confirm" required>

      <button type="submit">Tạo tài khoản</button>
    </form>
    <p style="text-align: center; margin-top: 10px;">
      <a href="../index.php">← Quay lại trang chính</a>
    </p>
  </div>
</body>
</html>

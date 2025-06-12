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
  <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
  <title>Đăng ký</title>
  <link rel="stylesheet" href="resister.css">
</head>
<body>
  <!-- Thanh điều hướng -->
  <header class="navbar">
    <div class="logo">📚 LOGO</div>
    <div class="nav-links">
      <a href="#">Thư viện</a>
      <a href="#">Dịch vụ</a>
      <a href="#">Help</a>
      <a href="#">Contact</a>
    </div>
    <div class="auth">
      <a href="#">Log in / Sign in</a>
    </div>
  </header>

  <!-- Phần đăng ký -->
  <div class="register-container">
    <h2>Đăng ký</h2>
    <form>
      <input type="text" placeholder="Tên đăng nhập" required>
      <input type="email" placeholder="Email" required>
      <input type="password" placeholder="Mật khẩu" required>
      <input type="password" placeholder="Xác nhận mật khẩu" required>
      <button type="submit">Đăng ký</button>
    </form>
    <div class="signup-link">
      <p>Đã có tài khoản? <a href="#">Đăng nhập</a></p>
    </div>
  </div>

  <!-- Footer -->
  <footer class="last_bottom">
    <div class="column">
      <h1>About</h1>
      <p>Đây là thư viện số. Bạn muốn viết thêm gì thì có viết thêm vào đây.</p>
    </div>
    <div class="column">
      <h1>Thông tin</h1>
      <ul>
        <li><a href="#">Dịch vụ hỗ trợ nghiên cứu</a></li>
        <li><a href="#">Câu hỏi thường gặp</a></li>
        <li><a href="#">Tìm tài sản thất lạc</a></li>
      </ul>
    </div>
    <div class="column">
      <h1>Liên hệ</h1>
      <ul class="contact-list">
        <li><i class="ri-map-pin-fill"></i><span>Đại học Phenikaa</span></li>
        <li><i class="ri-mail-fill"></i><span> elib@phenikaa-uni.edu.vn</span></li>
        <li><i class="ri-phone-fill"></i> <span> 0246.6291 8118 | Số máy lẻ: 117</span></li>
      </ul>
    </div>
  </footer>
  <div class="bottom">
    <p>Copyright Group 4_Software Engineering</p>
    <div class="right_footer">
      <div class="icons">
        <i class="ri-facebook-fill"></i>
        <i class="ri-instagram-fill"></i>
        <i class="ri-youtube-fill"></i>
      </div>
    </div>
  </div>
</body>
</html>

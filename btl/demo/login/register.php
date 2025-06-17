<?php
session_start();
include 'connect.php';

// Xử lý khi người dùng submit form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $user = $_POST['user'];
  $pass = $_POST['pass'];
  $confirm = $_POST['confirm'];
  $email = $_POST['email'];
  $hoTen = $_POST['hoTen'];
  $maSV = $_POST['maSV'];

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
  $stmt = $conn->prepare("INSERT INTO tbl_user (user, pass, email, hoTen, maSV) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("sssss", $user, $pass, $email, $hoTen, $maSV);

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
  <link rel="stylesheet" href="dangki.css" />
</head>
<body>
  <!-- Thanh điều hướng -->
<header class="navbar">
    <div class="logo">
      <a href="../index.php">
        <img src="../assets/logo.jpg" alt="Logo Thư viện số">
      </a>
    </div>
      <div class="nav-links">
        <div class="dropdown">
          <span class="dropdown-toggle">Thư viện</span>
          <div class="dropdown-menu">
              <a href="../gt/gt.php">Giới thiệu</a>
              <a href="../nq/nq.php">Nội Quy</a>
          </div>
        </div>
        <div class="dropdown">
          <span class="dropdown-toggle">Dịch vụ</span>
          <div class="dropdown-menu">
              <a href="../borrow/borrow.php">Mượn, Trả sách</a>
          </div>
        </div>
        <div class="dropdown">
            <span class="dropdown-toggle">Help</span>
            <div class="dropdown-menu">
              <a href="../faq/faq.php">FAQ</a>
              <a href="../ticket/ticket.php">Góp ý, hỗ trợ người dùng</a>
             </div>
        </div>
        <div class="dropdown">
            <span class="dropdown-toggle">Contact</span>
        </div>
      </div>
</header>


  <!-- Phần đăng ký -->
<div class="register-container">
    <h2>Đăng ký</h2>
    <?php if (isset($_SESSION['register_error'])): ?>
      <p class="error"><?php echo $_SESSION['register_error']; unset($_SESSION['register_error']); ?></p>
    <?php endif; ?>
    <form method="POST" action="">
      <label for="hoTen">Họ và tên:</label>
      <input type="text" name="hoTen" id="hoTen" required>

      <label for="maSV">Mã sinh viên:</label>
      <input type="text" name="maSV" id="maSV" required>
      
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

  </div>

  <!-- Footer -->
<footer class="footer">
        <div class="footer-top">
            <div class="footer-column">
                <span>📍</span>
                <h3>LOCATION</h3>
                <p>Phenikaa University<br>XP7X+286, Yên Nghĩa, Hà Đông, Hà Nội</p>
            </div>
            <div class="footer-column">
                <span>⏰</span>
                <h3>SERVICE TIMES</h3>
                <p>Monday to Friday: 7:00AM - 9:00PM<br>Saturdays at 8:00AM - Sunset</p>
            </div>
            <div class="footer-column">
                <span>💬</span>
                <h3>GET IN TOUCH</h3>
                <p>Email: elib@phenikaa-uni.edu.vn<br>Phone: 0246.6291 8118</p>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="footer-column">
                <h3>About</h3>
                <p>Đây là thư viện số. Bạn muốn viết thêm gì thì có viết thêm vào đây.</p>
                <button class="read-more-btn">Read More</button>
            </div>
            <div class="footer-column">
                <h3>Dịch vụ</h3>
                <p>Hỗ trợ nghiên cứu<br>Câu hỏi thường gặp<br>Tìm đồ thất lạc</p>
            </div>
            <div class="footer-column">
                <h3>Liên hệ</h3>
                <p>Đại học Phenikaa<br>elib@phenikaa-uni.edu.vn<br>0246.6291 8118 | Số máy lẻ: 117</p>
            </div>
            <div class="footer-column">
                <h3>Social</h3>
                <div class="social-icons">
                    <a href="#"><i class="ri-facebook-box-fill"></i></a>
                    <a href="#"><i class="ri-instagram-line"></i></a>
                    <a href="#"><i class="ri-twitter-line"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <p>Copyright © 2025 All Rights Reserved | This template is made with ♥ by Group 4</p>
        </div>
</footer>
</body>
</html>

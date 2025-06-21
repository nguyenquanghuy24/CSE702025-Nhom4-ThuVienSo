<?php
session_start();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
  <title>Thư viện số - Admin</title>
  <link rel="stylesheet" href="login.css" />
</head>
<body>
<header class="navbar">
    <div class="logo">
      <a href="logadmin.php"> <img src="../user/demo/assets/logo.jpg" alt="Logo Thư viện số">
      </a>
    </div>
      <div class="nav-links">
        <div class="nav-item">
            <a href="add/add.php" class="nav-link">Thêm sách</a> </div>
        <div class="nav-item">
            <a href="manage/manage.php" class="nav-link">Quản lý</a> </div>
        <div class="nav-item">
            <a href="reply/reply.php" class="nav-link">Hòm thư</a> </div>
      </div>
    <div class="auth">
        <?php if (isset($_SESSION['user'])): ?>
            <span><?php echo htmlspecialchars($_SESSION['user']); ?></span>
            <a href="../user/demo/login/logout.php?redirect=/project/CSE702025-Nhom4-ThuVienSo/user/demo/index.php">Đăng xuất</a>
        <?php else: ?>
            <a href="#" onclick="openLoginModal()" class="auth-link">Đăng nhập</a>
        <?php endif; ?>
    </div>
</header>

<main class="admin-dashboard-main">
    <?php if (isset($_SESSION['user'])): ?>
        <section class="admin-actions">
            <h1>Chào mừng, <?php echo htmlspecialchars($_SESSION['user']); ?>!</h1>
            <p>Chọn một tác vụ quản lý dưới đây:</p>
            <div class="action-grid">
                <a href="add/add.php" class="action-card">
                    <i class="ri-book-open-line"></i>
                    <span>Thêm Sách Mới</span>
                </a>
                <a href="manage/manage.php" class="action-card">
                    <i class="ri-settings-4-line"></i>
                    <span>Quản Lý Sách</span>
                </a>
                <a href="reply/reply.php" class="action-card">
                    <i class="ri-mail-line"></i>
                    <span>Hòm Thư Phản Hồi</span>
                </a>
            </div>
        </section>
    <?php else: ?>
        <section class="auth-prompt">
            <p>Vui lòng đăng nhập để truy cập trang quản trị.</p>
        </section>
    <?php endif; ?>
</main>


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
<?php if (!isset($_SESSION['user'])): ?>
<div id="loginModal" class="modal" style="display:flex;"> <div class="modal-content">
    <span class="close-btn" style="display: none;">&times;</span> <h2>Đăng nhập</h2>
    <?php if (isset($_SESSION['login_error'])): ?>
      <p style="color: red;"><?php echo $_SESSION['login_error']; unset($_SESSION['login_error']); ?></p>
    <?php endif; ?>
    <form method="POST" action="../user/demo/login/handle_login.php">
        <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
        <label for="user">Tên đăng nhập:</label>
        <input type="text" id="user" name="user" required>
        <label for="pass">Mật khẩu:</label>
        <input type="password" id="pass" name="pass" required>
        <button type="submit">Đăng nhập</button>
        </form>
  </div>
</div>
<?php else: ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('loginModal');
        if (modal) {
            modal.style.display = 'none'; // Hide modal if already logged in
        }
    });
</script>
<?php endif; ?>
<script src="login.js"></script>
</body>
</html>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
  <title>Thêm Sách Mới - Admin</title>
  <link rel="stylesheet" href="add.css" />
</head>
<body>
<header class="navbar">
    <div class="logo">
      <a href="../index.php"> <img src="../assets/logo.jpg" alt="Logo Thư viện số">
      </a>
</div>
      <div class="nav-links">
        <div class="dropdown">
          <a href="add.php" class="dropdown-toggle">Thêm sách</a> </div>
        <div class="dropdown">
          <a href="../manage/manage.php" class="dropdown-toggle">Quản lý</a> </div>
        <div class="dropdown">
            <a href="../reply/reply.php" class="dropdown-toggle">Hòm thư</a> </div>
        <div class="dropdown">
            <a href="#" class="dropdown-toggle">Contact</a> </div>
      </div>
    <div class="auth">
        <?php if (isset($_SESSION['user'])): ?>
            <span><?php echo htmlspecialchars($_SESSION['user']); ?></span>
            <a href="../login/logout.php?redirect=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>">Đăng xuất</a> <?php else: ?>
            <a href="#" onclick="openLoginModal()" class="auth-link">Đăng nhập</a>
        <?php endif; ?>
    </div>
</header>
<main class="admin-content">
    <h1>Thêm Sách Mới</h1>
    <form action="process_add_book.php" method="POST" enctype="multipart/form-data" class="add-book-form">
        <div class="form-group">
            <label for="book_title">Tên sách:</label>
            <input type="text" id="book_title" name="book_title" required>
        </div>

        <div class="form-group">
            <label for="author">Tác giả:</label>
            <input type="text" id="author" name="author" required>
        </div>

        <div class="form-group">
            <label for="publisher">Nhà xuất bản:</label>
            <input type="text" id="publisher" name="publisher">
        </div>

        <div class="form-group">
            <label for="publication_year">Năm xuất bản:</label>
            <input type="number" id="publication_year" name="publication_year" min="1000" max="<?php echo date("Y"); ?>" required>
        </div>

        <div class="form-group">
            <label for="category">Thể loại:</label>
            <select id="category" name="category" required>
                <option value="">Chọn thể loại</option>
                <option value="Khoa học">Khoa học máy tính</option>
                <option value="Trí tuệ">Trí tuệ nhân tạo</option>
                <option value="Toán">Toán học</option>
            </select>
        </div>

        <div class="form-group">
            <label for="description">Mô tả:</label>
            <textarea id="description" name="description" rows="5"></textarea>
        </div> 

        <div class="form-group">
            <label for="book_image">Ảnh bìa sách:</label>
            <input type="file" id="book_image" name="book_image" accept="image/*">
        </div>

        <button type="submit" class="submit-btn">Thêm Sách</button>
    </form>
</main>

 <footer class="footer">
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
<div id="loginModal" class="modal" style="<?php if (isset($_SESSION['login_error'])) echo 'display:block;'; ?>">
  <div class="modal-content">
    <span class="close-btn" onclick="closeModal()">&times;</span>
    <h2>Đăng nhập</h2>
    <?php if (isset($_SESSION['login_error'])): ?>
      <p style="color: red;"><?php echo $_SESSION['login_error']; unset($_SESSION['login_error']); ?></p>
    <?php endif; ?>
    <form method="POST" action="login/login.php">
        <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
        <label for="user">Tên đăng nhập:</label>
        <input type="text" id="user" name="user" required>
        <label for="pass">Mật khẩu:</label>
        <input type="password" id="pass" name="pass" required>
        <button type="submit">Đăng nhập</button>
        <p class="signup-link">Chưa có tài khoản? <a href="login/register.php">Đăng ký</a></p>
    </form>
  </div>
</div>
<?php endif; ?>
<script src="add.js"></script>
</body>
</html>
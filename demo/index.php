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
  <title>Thư viện số</title>
  <link rel="stylesheet" href="test.css" />
</head>
<body>
<header class="navbar">
    <div class="logo">📚 LOGO</div>
    <nav class="nav-links">
      <a href="#">Thư viện</a>
      <a href="#">Dịch vụ</a>
      <a href="#">Help</a>
      <a href="#">Contact</a>
    </nav>
    <div class="auth">
    <?php if (isset($_SESSION['user'])): ?>
      <span><?php echo htmlspecialchars($_SESSION['user']); ?></span>
      <a href="login/logout.php">Đăng xuất</a>
    <?php else: ?>
      <a href="#" onclick="openLoginModal()">Log in / Sign up</a>
    <?php endif; ?>
    </div>
</header>
<section class="welcome-section">
    <h1>Welcome to <span>Thư viện số</span></h1>
    <div class="search-box">
      <input type="text" placeholder="Tìm kiếm tài liệu..." />
      <button><span>🔍</span></button>
    </div>
</section>
<section class="new-documents">
    <h2 class="title">TÀI LIỆU MỚI</h2>
    <div class="card-container">
        <div class="card">
            <div class="image" style="background-image: url('path/to/doc1.jpg');"></div>
            <div class="card-content">
                <p class="category">Khoa học</p>
                <h3 class="title">Tiêu đề tài liệu 1</h3>
                <p class="description">Mô tả ngắn về tài liệu mới, giới thiệu nội dung chính.</p>
            </div>
        </div>
        <div class="card">
            <div class="image" style="background-image: url('path/to/doc2.jpg');"></div>
            <div class="card-content">
                <p class="category">Công nghệ</p>
                <h3 class="title">Tiêu đề tài liệu 2</h3>
                <p class="description">Tóm tắt nội dung tài liệu, thu hút người đọc.</p>
            </div>
        </div>
        <div class="card">
            <div class="image" style="background-image: url('path/to/doc3.jpg');"></div>
            <div class="card-content">
                <p class="category">Văn học</p>
                <h3 class="title">Tiêu đề tài liệu 3</h3>
                <p class="description">Giới thiệu tài liệu một cách hấp dẫn.</p>
            </div>
        </div>
    </div>
    <div class="btn-wrapper">
        <button class="btn-xemthem">
            <a href="#" class="custom-link">XEM THÊM &rsaquo;</a>
        </button>
    </div>
</section>
<section class="events">
    <div class="section-header">
        <h2 class="title">SỰ KIỆN</h2>
    </div>
    <div class="card-container">
        <div class="card">
            <div class="image" style="background-image: url('path/to/event1.jpg');"></div>
            <div class="card-content">
                <p class="category">Hội thảo</p>
                <h3 class="title">Sự kiện A</h3>
                <p class="description">Sự kiện về công nghệ AI, ngày 20/06/2025.</p>
            </div>
        </div>
        <div class="card">
            <div class="image" style="background-image: url('path/to/event2.jpg');"></div>
            <div class="card-content">
                <p class="category">Triển lãm</p>
                <h3 class="title">Sự kiện B</h3>
                <p class="description">Triển lãm sách số, ngày 25/06/2025.</p>
            </div>
        </div>
    </div>
    <div class="btn-wrapper">
        <button class="btn-xemthem">
            <a href="#" class="custom-link">XEM THÊM &rsaquo;</a>
        </button>
    </div>
</section>
<section class="news-section">
    <h2 class="title">TIN TỨC</h2>
    <p class="desc">Cập nhật tin tức, thông báo</p>
    <div class="news-container">
        <div class="news-card card-with-bg" style="background-image: url('image1.jpg');">
            <div class="overlay">
              <p class="news-topic">Văn hóa đọc</p>
              <h3 class="news-title">Lễ trao giải các cuộc thi Ngày Sách và Văn hóa đọc</h3>
            </div>
        </div>
        <div class="news-card card-with-bg" style="background-image: url('image2.jpg');">
            <div class="overlay">
              <p class="news-topic">Topic2</p>
              <h3 class="news-title">Ứng dụng AI hỗ trợ học tập và nghiên cứu khoa học</h3>
            </div>
        </div>
        <div class="news-card card-with-bg" style="background-image: url('image3.jpg');">
            <div class="overlay">
              <p class="news-topic">Triển lãm</p>
              <h3 class="news-title">Đọc sách thông minh – Bảo vệ bản quyền</h3>
            </div>
        </div>
    </div>
    <div class="btn-wrapper">
        <button class="btn-xemthem">
            <a href="#" class="custom-link">XEM THÊM &rsaquo;</a>
        </button>
    </div>
</section>
<footer>
    <div class="last_bottom">
        <div class="column">
            <h1 id="about">About</h1>
            <p>Đây là thư viện số. <br>Bạn muốn viết thêm gì thì có viết thêm vào đây. </br> </p>
        </div>
        <div class="column">
            <h1 id="info">Thông tin</h1>
            <ul>
                <li>
                    <a href="Support">Dịch vụ hỗ trợ nghiên cứu</a>
                </li>
                <li>
                    <a href="Question">Câu hỏi thường gặp</a>
                </li>
                <li>
                    <a href="Search">Tìm tài sản thất lạc</a>
                </li>
            </ul>
        </div>
        <div class="column">
            <h1 id="contact">Liên hệ</h1>
            <ul class="contact-list">
                <li>
                    <i class="ri-map-pin-fill"></i>
                    <span>Đại học Phenikaa</span>
                </li>
                <li>
                    <i class="ri-mail-fill"></i> 
                    <span> elib@phenikaa-uni.edu.vn</span>
                </li>
                <li>
                    <i class="ri-phone-fill"></i> 
                    <span> 0246.6291 8118 | Số máy lẻ: 117</span>
                </li>
            </ul>
        </div>
    </div>
    <div class="bottom">        
        <div class="left-footer">
            <p>Copyright  Group 4_Software Engineering</p>
        </div>
        <div class="right_footer">
            <div class="icons">
                <i class="ri-facebook-fill"></i>
                <i class="ri-instagram-fill"></i>
                <i class="ri-youtube-fill"></i>
            </div>
        </div>
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
<script src="script.js"></script>
</body>
</html>
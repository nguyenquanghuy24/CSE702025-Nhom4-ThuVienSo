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
      <div class="nav-item">
        <a href="#">Thư viện</a>
        <div class="sub-menu">
          <a href="#">Tài liệu số</a>
          <a href="#">Sách in</a>
          <a href="#">Tạp chí khoa học</a>
          <a href="#">Luận văn & Luận án</a>
          <a href="#">Cơ sở dữ liệu</a>
        </div>
      </div>
      <div class="nav-item">
        <a href="#">Dịch vụ</a>
        <div class="sub-menu">
          <a href="#">Hỗ trợ nghiên cứu</a>
          <a href="#">Hướng dẫn sử dụng</a>
          <a href="#">Dịch vụ kỹ thuật</a>
        </div>
      </div>
      <div class="nav-item">
        <a href="#">Help</a>
        <div class="sub-menu">
          <a href="#">FAQ</a>
          <a href="#">Hỗ trợ trực tuyến</a>
          <a href="#">Tài liệu hướng dẫn</a>
        </div>
      </div>
      <div class="nav-item">
        <a href="#">Contact</a>
        <div class="sub-menu">
          <a href="#">Email</a>
          <a href="#">Hotline</a>
          <a href="#">Địa chỉ</a>
        </div>
      </div>
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
        <div class="image"></div>
        <p class="title">Tiêu đề tài liệu</p>
      </div>
      <div class="card">
        <div class="image"></div>
        <p class="title">Tiêu đề tài liệu</p>
      </div>
      <div class="card">
        <div class="image"></div>
        <p class="title">Tiêu đề tài liệu</p>
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
        <div class="image"></div>
        <p class="title">Sự kiện A</p>
      </div>
      <div class="card">
        <div class="image"></div>
        <p class="title">Sự kiện B</p>
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
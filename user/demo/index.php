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
  <link rel="stylesheet" href="home.css" />
</head>
<body>
<header class="navbar">
    <div class="logo">
      <a href="index.php">
        <img src="assets/logo.jpg" alt="Logo Thư viện số">
      </a>
    </div>
      <div class="nav-links">
        <div class="dropdown">
          <span class="dropdown-toggle">Thư viện</span>
          <div class="dropdown-menu">
              <a href="gt/gt.php">Giới thiệu</a>
              <a href="nq/nq.php">Nội Quy</a>
          </div>
        </div>
        <div class="dropdown">
          <span class="dropdown-toggle">Dịch vụ</span>
          <div class="dropdown-menu">
              <a href="borrow/borrow.php">Mượn, Trả sách</a>
          </div>
        </div>
        <div class="dropdown">
            <span class="dropdown-toggle">Help</span>
            <div class="dropdown-menu">
              <a href="faq/faq.php">FAQ</a>
              <a href="ticket/ticket.php">Góp ý, hỗ trợ người dùng</a>
             </div>
        </div>
        <div class="dropdown">
            <span class="dropdown-toggle" id="contact-scroll-btn">Contact</span>
        </div>
      </div>
    <div class="auth">
        <?php if (isset($_SESSION['user'])): ?>
            <span><?php echo htmlspecialchars($_SESSION['user']); ?></span>
            <a href="login/logout.php?redirect=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>">Đăng xuất</a>
        <?php else: ?>
            <a href="#" onclick="openLoginModal()" class="auth-link">Đăng nhập</a>
        <?php endif; ?>
    </div>
</header>


<section class="welcome-section">
    <h1>Welcome to Thư viện số</h1>
     <form action="search/search.php" method="GET" class="search-box">
         <input type="text" name="query" placeholder="Tìm kiếm sách, tài liệu...">
        <button type="submit">Search</button>
    </form>
 </section>

<section class="new-documents">
        <h2 class="title">TÀI LIỆU MỚI</h2>
        <div class="card-container">
            <div class="card">
                <img src="assets/giaitich1.jpg" alt="1" class="image">
                <div class="card-content">
                    <span class="category">Toán học</span>
                    <h3 class="title">Giải tích I</h3>
                    <p class="description">Đại cương giải tích</p>
                </div>
            </div>
            <div class="card">
                <img src="assets/giaitich2.jpg" alt="2" class="image">
                <div class="card-content">
                    <span class="category">Toán học</span>
                    <h3 class="title">Giải tích II</h3>
                    <p class="description">Giải tích nâng cao</p>
                </div>
            </div>
            <div class="card">
                <img src="assets/giaitich3.jpg" alt="3" class="image">
                <div class="card-content">
                    <span class="category">Toán học</span>
                    <h3 class="title">Giải tích III</h3>
                    <p class="description">Đi sâu vào giải tích</p>
                </div>
            </div>
        </div>
        <div class="btn-wrapper">
            <button class="btn-xemthem"><a href="#">XEM THÊM</a></button>
        </div>
 </section>

<section class="events">
        <h2 class="title">SỰ KIỆN</h2>
        <div class="card-container">
            <div class="card">
                <img src="assets/sukien1.jpg" alt="Sự kiện A" class="image"> 
                <div class="card-content">
                    <span class="category">Hot</span>
                    <h3 class="title"></h3>
                    <p class="description">Chuyển từ trường đại học phenikaa thành đại học phenikaa</p>
                </div>
            </div>
            <div class="card">
                <img src="assets/sukien2.jpg" alt="Sự kiện B" class="image">
                <div class="card-content">
                    <span class="category"></span>
                    <h3 class="title">Hot</h3>
                    <p class="description">Đại học Phenikaa tri ân báo chí nhân kỷ niệm 100 năm Ngày Báo chí Cách mạng Việt Nam</p>
                </div>
            </div>
        </div>
        <div class="btn-wrapper">
            <button class="btn-xemthem"><a href="#">XEM THÊM</a></button>
        </div>
</section>

<section class="news-section">
    <h3 class="subtitle">TIN TỨC</h3>
    <h2 class="title">Cập nhật tin tức, thông báo</h2>
    <div class="news-container">
        <div class="card-with-bg" style="background-image: url('assets/robot-tu-hanh-amr-i150-khi-cong-nghe-make-in-phenikaa-vuon-tam-quoc-te.png');">
            <div class="overlay">
                <span class="news-topic">Robot tự hành AMR</span>
                <h3 class="news-title">Robot tự hành AMR I150: Khi công nghệ “Make in Phenikaa” vươn tầm quốc tế</h3>
            </div>
        </div>
        <div class="card-with-bg" style="background-image: url('assets/khangdinhjpg.jpg');">
            <div class="overlay">
                <span class="news-topic">Khẳng định dấu ấn</span>
                <h3 class="news-title">Đại học Phenikaa duy trì đà tăng điểm, ghi dấu ấn tại nhiều mục tiêu phát triển bền vững</h3>
            </div>
        </div>
        <div class="card-with-bg" style="background-image: url('assets/khonggian.jpg');">
            <div class="overlay">
                <span class="news-topic">Tầm vóc</span>
                <h3 class="news-title">Không gian học tập hiện đại, xanh và truyền cảm hứng tại Đại học Phenikaa</h3>
            </div>
        </div>
    </div>
    <div class="btn-wrapper">
        <button class="btn-xemthem"><a href="#">XEM THÊM</a></button>
    </div>
</section>

 <footer class="footer" id="footer-section">
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
<div id="loginModal" class="modal" style="<?php if (isset($_SESSION['login_error'])) echo 'display:block;'; ?>">
  <div class="modal-content">
    <span class="close-btn" onclick="closeModal()">&times;</span>
    <h2>Đăng nhập</h2>
    <?php if (isset($_SESSION['login_error'])): ?>
      <p style="color: red;"><?php echo $_SESSION['login_error']; unset($_SESSION['login_error']); ?></p>
    <?php endif; ?>
    <form method="POST" action="login/handle_login.php">
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
<script src="script.js"></script>
</body>
</html>
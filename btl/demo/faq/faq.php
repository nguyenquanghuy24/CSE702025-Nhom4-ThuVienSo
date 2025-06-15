<?php
session_start();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - Câu hỏi thường gặp</title>
    <link rel="stylesheet" href="faq.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header class="navbar">
        <div class="logo">
            <a href="../index.php">
                <img src="../assets/logo.jpg" alt="Logo">
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
                    <a href="#">Mượn, Trả sách</a>
                </div>
            </div>
            <div class="dropdown">
                <span class="dropdown-toggle">Help</span>
                <div class="dropdown-menu">
                    <a href="faq.php">FAQ</a>
                    <a href="../ticket/ticket.php">Góp ý, hỗ trợ người dùng</a>
                </div>
            </div>
            <div class="dropdown">
                <a href="#contact-section" class="dropdown-toggle">Contact</a>
            </div>
        </div>
        <div class="auth">
            <?php if (isset($_SESSION['user'])): ?>
                <span class="auth-user"><?php echo htmlspecialchars($_SESSION['user']); ?></span>
                <a href="../login/logout.php?redirect=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>" class="auth-link">Đăng xuất</a>
            <?php else: ?>
                <a href="#" onclick="openLoginModal()" class="auth-link">Đăng nhập</a>
            <?php endif; ?>
        </div>
    </header>

    <main class="faq-section">
        <h1>Câu Hỏi Thường Gặp</h1>
        <div class="faq-container">
            <div class="faq-item">
                <button class="faq-question">
                    <span>Tôi có thể gửi túi xách, đồ dùng cá nhân ở đâu?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>Bạn có thể gửi túi xách, balo và các vật dụng cá nhân tại khu vực gửi đồ gần cổng vào Thư viện, có tủ khóa an toàn cho người dùng.</p>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">
                    <span>Khu vực học qua đêm ở đâu? Thời gian hoạt động? Đăng ký như thế nào?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p><strong>Vị trí:</strong> Tầng 6-A10</p>
                    <p><strong>Thời gian hoạt động:</strong> Từ 22:00 đến 6:00 sáng hôm sau.</p>
                    <p><strong>Cách đăng ký:</strong> Sinh viên cần đăng ký trực tiếp tại quầy thông tin hoặc qua cổng thông tin điện tử của thư viện trước 17:00 mỗi ngày.</p>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">
                    <span>Liên hệ với ai và ở đâu để làm lại Thẻ sinh viên đã bị mất?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>Bạn vui lòng đến quầy thủ tục để khai báo mất thẻ. Sau đó, điền vào mẫu đơn cấp lại và nộp phí theo quy định.</p>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">
                    <span>Nơi mượn và trả sách cho mượn về?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>Bạn đến quầy thủ tục tại tầng 4 để thực hiện thủ tục mượn/trả tài liệu. Đừng quên mang theo thẻ sinh viên.</p>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">
                    <span>Tìm lại tài sản bị thất lạc thì cần liên lạc với ai? Ở đâu?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>Nếu bị mất đồ, bạn hãy đến bàn thủ tục hoặc phòng công tác sinh viên, hoặc gửi email cho bộ phận quản lý cơ sở vật chất để được hỗ trợ kiểm tra.</p>
                </div>
            </div>
        </div>
    </main>

    <footer id="contact-section" class="footer">
        <div class="footer-bottom">
            <div class="footer-column">
                <h3>About</h3>
                <p>Đây là thư viện số.</p>
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
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
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
                <form method="POST" action="../login/login.php">
                    <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
                    <label for="user">Tên đăng nhập:</label>
                    <input type="text" id="user" name="user" required>
                    <label for="pass">Mật khẩu:</label>
                    <input type="password" id="pass" name="pass" required>
                    <button type="submit">Đăng nhập</button>
                    <p class="signup-link">Chưa có tài khoản? <a href="../login/register.php">Đăng ký</a></p>
                </form>
            </div>
        </div>
    <?php endif; ?>    
    <script src="faq.js"></script>
</body>
</html>
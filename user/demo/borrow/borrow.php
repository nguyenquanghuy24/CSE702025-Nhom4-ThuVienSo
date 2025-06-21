<?php
session_start();
include("../login/connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['book_id'])) {
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['login_error'] = "Bạn cần đăng nhập để mượn sách.";
        header("Location: ../login/login.php"); 
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $book_id = intval($_POST['book_id']);

    $stmt_count_total = $conn->prepare("SELECT COUNT(*) AS total_borrowed FROM borrow_tbl WHERE user_id = ? AND tinhTrang = 'Đang mượn'");
    $stmt_count_total->bind_param("i", $user_id);
    $stmt_count_total->execute();
    $result_count_total = $stmt_count_total->get_result();
    $borrow_count_total = $result_count_total->fetch_assoc()['total_borrowed'];
    $stmt_count_total->close();

    if ($borrow_count_total >= 5) {
        $_SESSION['borrow_error'] = "Bạn đã mượn tối đa 5 cuốn sách. Vui lòng trả sách để mượn thêm.";
        header("Location: borrow.php");
        exit();
    }

    $stmt_count_specific = $conn->prepare("SELECT COUNT(*) AS specific_book_borrowed FROM borrow_tbl WHERE user_id = ? AND book_id = ? AND tinhTrang = 'Đang mượn'");
    $stmt_count_specific->bind_param("ii", $user_id, $book_id);
    $stmt_count_specific->execute();
    $result_count_specific = $stmt_count_specific->get_result();
    $specific_book_borrowed = $result_count_specific->fetch_assoc()['specific_book_borrowed'];
    $stmt_count_specific->close();

    if ($specific_book_borrowed > 0) {
        $_SESSION['borrow_error'] = "Bạn đã mượn cuốn sách này rồi. Vui lòng trả sách để mượn lại hoặc chọn sách khác.";
        header("Location: borrow.php");
        exit();
    }

    $stmt = $conn->prepare("SELECT soLuong, trangThai FROM book_tbl WHERE id = ?");
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $book = $result->fetch_assoc();
        
        if ($book['trangThai'] == 'Đang bảo trì') {
            $_SESSION['borrow_error'] = "Sách đang bảo trì, không thể mượn.";
        } elseif ($book['soLuong'] > 0) {
            $stmt = $conn->prepare("UPDATE book_tbl SET soLuong = soLuong - 1 WHERE id = ?");
            $stmt->bind_param("i", $book_id);
            $stmt->execute();

            if ($book['soLuong'] - 1 <= 0) {
                $stmt = $conn->prepare("UPDATE book_tbl SET trangThai = 'Đã mượn hết' WHERE id = ?");
                $stmt->bind_param("i", $book_id);
                $stmt->execute();
            }

            $stmt = $conn->prepare("INSERT INTO borrow_tbl (user_id, book_id, ngayMuon, ngayHetHan, tinhTrang) 
                                  VALUES (?, ?, NOW(), DATE_ADD(NOW(), INTERVAL 30 DAY), 'Đang mượn')");
            $stmt->bind_param("ii", $user_id, $book_id);
            $stmt->execute();

            $_SESSION['borrow_success'] = "Yêu cầu mượn sách thành công! Vui lòng chờ phê duyệt.";
        } else {
            $_SESSION['borrow_error'] = "Sách đã hết.";
        }
    } else {
        $_SESSION['borrow_error'] = "Sách không tồn tại.";
    }

    header("Location: borrow.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mượn Trả Sách - Thư Viện Số</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="borrow.css">
</head>
<body>

    <?php if (isset($_SESSION['borrow_success'])): ?>
        <div class="alert success"><?php echo $_SESSION['borrow_success']; unset($_SESSION['borrow_success']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['borrow_error'])): ?>
        <div class="alert error"><?php echo $_SESSION['borrow_error']; unset($_SESSION['borrow_error']); ?></div>
        <script>
            alert("Lỗi mượn sách: <?php echo htmlspecialchars($_SESSION['borrow_error']); ?>");
        </script>
    <?php endif; ?>

    <?php if (isset($_SESSION['return_success'])): ?>
        <div class="alert success"><?php echo $_SESSION['return_success']; unset($_SESSION['return_success']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['return_error'])): ?>
        <div class="alert error"><?php echo $_SESSION['return_error']; unset($_SESSION['return_error']); ?></div>
        <script>
            alert("Lỗi trả sách: <?php echo htmlspecialchars($_SESSION['return_error']); ?>");
        </script>
    <?php endif; ?>

    <?php if (isset($_SESSION['login_error'])): ?>
        <script>
            const loginErrorExists = true; 
        </script>
        <?php unset($_SESSION['login_error']); ?>
    <?php endif; ?>

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
                    <a href="borrow.php">Mượn, Trả sách</a>
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
                <span class="dropdown-toggle" id="contact-scroll-btn">Contact</span>
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

    <main class="page-main-content">
        <div class="content-container">
            <section class="book-section search-feature">
                <form action="../search/search.php" method="GET" class="search-bar">
                    <input type="text" name="query" placeholder="Tìm kiếm sách theo tên, tác giả..." class="search-input">
                    <button type="submit" class="search-button">Search</button>
                </form>
            </section>

            <section class="book-section">
                <h2>Sách đề xuất</h2>
                <div class="recommend-grid">
                    <div class="book-card-simple" 
                         data-book-id="11" 
                         data-title="Giải Tích I" 
                         data-author="Ngô Văn Ban" 
                         data-description="Cuốn sách Giải Tích I cung cấp các kiến thức cơ bản và nền tảng nhất của giải tích, bao gồm giới hạn, đạo hàm, và tích phân." 
                         data-img-src="../assets/giaitich1.jpg"
                         data-year="2021"
                         data-category="Toán học"
                         data-language="Tiếng Việt">
                        <img src="../assets/giaitich1.jpg" alt="Bìa sách Giải Tích I">
                        <p class="book-title">Giải Tích I</p>
                    </div>
                    <div class="book-card-simple" 
                         data-book-id="12" 
                         data-title="Giải Tích II" 
                         data-author="Trần Thị Kim Oanh, Phan Xuân Thành, Lê Chí Ngọc, Nguyễn Thị Thu Hương" 
                         data-description="Tiếp nối Giải Tích I, cuốn sách này đi sâu vào các chủ đề nâng cao như giải tích hàm nhiều biến, tích phân bội, và phương trình vi phân." 
                         data-img-src="../assets/giaitich2.jpg"
                         data-year="2022"
                         data-category="Toán học"
                         data-language="Tiếng Việt">
                        <img src="../assets/giaitich2.jpg" alt="Bìa sách Giải Tích II">
                        <p class="book-title">Giải Tích II</p>
                    </div>
                    <div class="book-card-simple" 
                         data-book-id="13" 
                         data-title="Giải Tích III" 
                         data-author="Nguyễn Thiệu Huy, Bùi Xuân Diệu, Đào Tuấn Anh" 
                         data-description="Cuốn sách cuối cùng trong bộ ba, tập trung vào các khái niệm về chuỗi số, chuỗi hàm, và các phép biến đổi quan trọng như Fourier và Laplace." 
                         data-img-src="../assets/giaitich3.jpg"
                         data-year="2023"
                         data-category="Toán học"
                         data-language="Tiếng Việt">
                        <img src="../assets/giaitich3.jpg" alt="Bìa sách Giải Tích III">
                        <p class="book-title">Giải Tích III</p>
                    </div>
                </div>
            </section>
            
            <section class="book-section">
                <h2>Sách đang mượn</h2>
                <div class="borrowed-list">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <div class="borrowed-item">
                            <div class="book-cover">
                                <img src="../assets/giaitich1.jpg" alt="Bìa sách Giải Tích I">
                            </div>
                            <div class="book-info">
                                <h3>Giải Tích I</h3>
                                <p class="author">Ngô Văn Ban</p>
                                <p class="category">Thể loại: Toán học</p>
                                
                                <div class="borrow-details">
                                    <p><i class="fas fa-calendar-day"></i> Ngày mượn: 21/06/2025</p>
                                    <p><i class="fas fa-clock"></i> Hạn trả: 21/07/2025</p>
                                </div>
                                <p class="borrow-status-pending">
                                    <i class="fas fa-hourglass-half"></i> Đang chờ phê duyệt
                                </p>
                                <p class="borrow-code">Mã mượn:842C7</p>
                            </div>
                        </div>

                        <div class="borrowed-item">
                            <div class="book-cover">
                                <img src="../assets/giaitich2.jpg" alt="Bìa sách Giải Tích II">
                            </div>
                            <div class="book-info">
                                <h3>Giải Tích II</h3>
                                <p class="author">Trần Thị Kim Oanh</p>
                                <p class="category">Thể loại: Toán học</p>
                                
                                <div class="borrow-details">
                                    <p><i class="fas fa-calendar-day"></i> Ngày mượn: 15/06/2025</p>
                                    <p><i class="fas fa-clock"></i> Hạn trả: 15/07/2025</p>
                                </div>
                                <p class="borrow-status-approved">
                                    <i class="fas fa-check-circle"></i> Đang mượn
                                </p>
                                <p class="borrow-code">Mã mượn:89D58</p>
                            </div>
                        </div>

                    <?php else: ?>
                        <div class="login-required">
                            <i class="fas fa-exclamation-triangle"></i>
                            <p>Vui lòng đăng nhập để xem sách đang mượn.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        </div>
    </main>

    <footer class="footer" id="footer-section">
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
            <div id="loginModal" class="modal">
                <div class="modal-content">
                    <span class="close-btn" onclick="closeModal()">&times;</span>
                    <h2>Đăng nhập</h2>
                <?php if (isset($_SESSION['login_error'])): ?>
                    <p style="color: red;"><?php echo $_SESSION['login_error']; unset($_SESSION['login_error']); ?></p>
                <?php endif; ?>
                <form method="POST" action="../login/handle_login.php">
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

    <div id="bookDetailModal" class="modal">
        <div class="popup-content">
            <span id="close-popup-btn" class="popup-close-btn">&times;</span>
            <h2 id="modal-book-title" class="popup-title"></h2>
            <div class="popup-body">
                <div class="popup-left-column">
                    <img id="modal-book-image" src="" alt="Bìa sách">
                </div>
                <div class="popup-right-column">
                    <div class="popup-actions">
                        <button class="popup-btn btn-view"><i class="fas fa-book-open"></i> Xem online</button>
                        <form method="POST" action="borrow.php" onsubmit="return checkLoginBeforeBorrow();">
                            <input type="hidden" name="book_id" id="modal-borrow-book-id">
                            <button type="submit" class="btn-action btn-borrow-book">
                                <i class="fas fa-hand-holding-heart"></i> Mượn sách
                            </button>
                        </form>                                       
                    </div>
                    <h4 class="popup-details-header">Details</h4>
                    <dl class="popup-details-list">
                        <dt>Tác giả</dt>
                        <dd id="modal-book-author"></dd>
                        <dt>Mô tả</dt>
                        <dd id="modal-book-description"></dd>
                        <dt>Năm xuất bản</dt>
                        <dd id="modal-book-year-popup">N/A</dd> <dt>Ngôn ngữ</dt>
                        <dd id="modal-book-language-popup">N/A</dd>
                        <dt>Thể loại</dt>
                        <dd id="modal-book-category-popup">N/A</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
<script>
    const isLoggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;

    function checkLoginBeforeBorrow() {
        if (!isLoggedIn) {
            openLoginModal(); 
            return false;     
        }
        return true; 
    }
    function openLoginModal() {
        const modal = document.getElementById('loginModal');
        if (modal) {
            modal.style.display = 'block';
            const redirectInput = modal.querySelector('input[name="redirect"]');
            if (redirectInput) {
                redirectInput.value = window.location.href; 
            }
        }
    }
    function closeModal() {
        const modal = document.getElementById('loginModal');
        if (modal) {
            modal.style.display = 'none';
        }
    }

</script>
    <script src="borrow.js"></script>
</body>
</html>
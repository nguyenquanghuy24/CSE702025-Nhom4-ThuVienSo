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
    // Kiểm tra xem đã có yêu cầu cho cuốn sách này chưa (dù đang chờ hay bị từ chối)
    $stmt_check_existing = $conn->prepare("SELECT COUNT(*) AS existing FROM borrow_tbl WHERE user_id = ? AND book_id = ? AND tinhTrang IN ('Đang chờ phê duyệt', 'Từ chối')");
    $stmt_check_existing->bind_param("ii", $user_id, $book_id);
    $stmt_check_existing->execute();
    $result_check_existing = $stmt_check_existing->get_result();
    $existing = $result_check_existing->fetch_assoc()['existing'];
    $stmt_check_existing->close();

    if ($existing > 0) {
        $_SESSION['borrow_error'] = "Bạn đã gửi yêu cầu mượn sách này rồi (đang chờ phê duyệt hoặc bị từ chối).";
        header("Location: borrow.php");
        exit();
    }


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
        } elseif ($book['soLuong'] <= 0) {
            $_SESSION['borrow_error'] = "Sách đã hết.";
        } else {
            // ✅ Sinh mã mượn
            $maMuon = strtoupper(substr(md5(uniqid()), 0, 5));

            // ✅ Thêm yêu cầu mượn, chưa trừ số lượng, trạng thái chờ duyệt
            $stmt = $conn->prepare("INSERT INTO borrow_tbl (user_id, book_id, ngayMuon, ngayHetHan, tinhTrang, maMuon)
                                    VALUES (?, ?, NOW(), DATE_ADD(NOW(), INTERVAL 30 DAY), 'Đang chờ phê duyệt', ?)");
            $stmt->bind_param("iis", $user_id, $book_id, $maMuon);
            $stmt->execute();

            $_SESSION['borrow_success'] = "Yêu cầu mượn sách đã được gửi. Vui lòng chờ phê duyệt.";
        }
    } else {
        $_SESSION['borrow_error'] = "Sách không tồn tại.";
    }
    // Lấy số lượng sách thực tế từ bảng sách
    $soLuong = $book['soLuong'];

    // Tính tổng số sách đã được mượn hoặc đang chờ phê duyệt
    $stmt_check = $conn->prepare("SELECT COUNT(*) AS daMuon FROM borrow_tbl WHERE book_id = ? AND tinhTrang IN ('Đang mượn', 'Đang chờ phê duyệt')");
    $stmt_check->bind_param("i", $book_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    $daMuon = $result_check->fetch_assoc()['daMuon'];
    $stmt_check->close();

    // Nếu số lượng đã mượn >= số lượng gốc => không cho mượn nữa
    if ($daMuon >= $soLuong) {
        $_SESSION['borrow_error'] = "Sách đã hết.";
        header("Location: borrow.php");
        exit();
    } 
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
    <?php if (isset($_SESSION['borrow_error'])):
        $error = $_SESSION['borrow_error'];
        unset($_SESSION['borrow_error']);
    ?>
        <div class="alert error"><?php echo $error; ?></div>
        <script>alert("Lỗi mượn sách: <?php echo htmlspecialchars($error); ?>");</script>
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
            
            <?php if (isset($_SESSION['user_id'])): ?>
                <section class="book-section">
                    <h2>Sách của tôi</h2>
                    <?php
                    $user_id = $_SESSION['user_id'];
                    $query = "SELECT b.*, k.tieuDe, k.tacGia, k.theLoai, k.anhBia
                            FROM borrow_tbl b
                            JOIN book_tbl k ON b.book_id = k.id
                            WHERE b.user_id = ? ORDER BY b.ngayMuon DESC";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("i", $user_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    ?>

                    <?php
                    if ($result->num_rows === 0): ?>
                        <p style="padding: 10px;">Bạn chưa mượn sách nào...</p>
                    <?php else: ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                            <div class="borrowed-item">
                                <div class="book-cover">
                                    <?php
                                        $filename = htmlspecialchars($row['anhBia']);
                                        $imgPath = "../" . $filename;                                                       
                                    ?>
                                    <img src="<?php echo $imgPath; ?>" alt="Bìa sách <?php echo htmlspecialchars($row['tieuDe']); ?>">
                                </div>        
                                <div class="book-info">
                                    <h3><?php echo htmlspecialchars($row['tieuDe']); ?></h3>
                                    <p class="author"><?php echo htmlspecialchars($row['tacGia']); ?></p>
                                    <p class="category">Thể loại: <?php echo htmlspecialchars($row['theLoai']); ?></p>

                                    <div class="borrow-details">
                                        <p><i class="fas fa-calendar-day"></i> Ngày mượn: <?php echo date('d/m/Y', strtotime($row['ngayMuon'])); ?></p>
                                        <p><i class="fas fa-clock"></i> Hạn trả: <?php echo date('d/m/Y', strtotime($row['ngayHetHan'])); ?></p>
                                    </div>

                                    <?php if ($row['tinhTrang'] == 'Đang chờ phê duyệt'): ?>
                                        <p class="borrow-status-pending"><i class="fas fa-hourglass-half"></i> Đang chờ phê duyệt</p>
                                    <?php elseif ($row['tinhTrang'] == 'Đang mượn'): ?>
                                        <p class="borrow-status-approved"><i class="fas fa-check-circle"></i> Đang mượn</p>
                                    <?php elseif ($row['tinhTrang'] == 'Đã trả'): ?>
                                        <p class="borrow-status-returned"><i class="fas fa-check"></i> Đã trả</p>
                                    <?php elseif ($row['tinhTrang'] == 'Từ chối'): ?>
                                        <p class="borrow-status-rejected"><i class="fas fa-times-circle"></i> Yêu cầu bị từ chối</p>
                                    <?php endif; ?>

                                    <p class="borrow-code">Mã mượn: <?php echo $row['maMuon']; ?></p>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </section>
            <?php endif; ?>
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
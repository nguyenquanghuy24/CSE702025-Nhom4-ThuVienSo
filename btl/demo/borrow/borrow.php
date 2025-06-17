<?php
session_start();
include("../login/connect.php");

// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['user_id'])) {
    // Nếu chưa đăng nhập, chuyển hướng lại search.php và hiện modal
    $_SESSION['login_required'] = true;
    header("Location: ../search/search.php");
    exit();
}

// Nếu nhận được yêu cầu mượn
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['book_id'])) {
    $user_id = $_SESSION['user_id'];
    $book_id = intval($_POST['book_id']);

    // Kiểm tra sách có tồn tại và còn số lượng
    $stmt = $conn->prepare("SELECT soLuong FROM book_tbl WHERE id = ?");
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $book = $result->fetch_assoc();
        if ($book['soLuong'] > 0) {
            // Giảm số lượng
            $stmt = $conn->prepare("UPDATE book_tbl SET soLuong = soLuong - 1 WHERE id = ?");
            $stmt->bind_param("i", $book_id);
            $stmt->execute();

            // Ghi vào bảng borrow_tbl
            $stmt = $conn->prepare("INSERT INTO borrow_tbl (user_id, book_id, ngayMuon) VALUES (?, ?, NOW())");
            $stmt->bind_param("ii", $user_id, $book_id);
            $stmt->execute();

            $_SESSION['borrow_success'] = true;
        } else {
            $_SESSION['borrow_error'] = "Sách đã hết.";
        }
    } else {
        $_SESSION['borrow_error'] = "Sách không tồn tại.";
    }

    header("Location: ../borrow/borrow.php");
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
    <?php endif; ?>

    <?php if (isset($_SESSION['login_error'])): ?>
        <script>
            window.onload = function() {
                openLoginModal(); // Gọi modal đăng nhập nếu có
            };
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
                    <a href="#">Mượn, Trả sách</a>
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
                         data-book-id="1" 
                         data-title="Giải Tích I" 
                         data-author="Ngô Văn Ban" 
                         data-description="Cuốn sách Giải Tích I cung cấp các kiến thức cơ bản và nền tảng nhất của giải tích, bao gồm giới hạn, đạo hàm, và tích phân." 
                         data-img-src="../assets/giaitich1.jpg">
                        <img src="../assets/giaitich1.jpg" alt="Bìa sách Giải Tích I">
                        <p class="book-title">Giải Tích I</p>
                    </div>
                    <div class="book-card-simple" 
                         data-book-id="2" 
                         data-title="Giải Tích II" 
                         data-author="Trần Thị Kim Oanh, Phan Xuân Thành, Lê Chí Ngọc, Nguyễn Thị Thu Hương" 
                         data-description="Tiếp nối Giải Tích I, cuốn sách này đi sâu vào các chủ đề nâng cao như giải tích hàm nhiều biến, tích phân bội, và phương trình vi phân." 
                         data-img-src="../assets/giaitich2.jpg">
                        <img src="../assets/giaitich2.jpg" alt="Bìa sách Giải Tích II">
                        <p class="book-title">Giải Tích II</p>
                    </div>
                    <div class="book-card-simple" 
                         data-book-id="3" 
                         data-title="Giải Tích III" 
                         data-author="Nguyễn Thiệu Huy, Bùi Xuân Diệu, Đào Tuấn Anh" 
                         data-description="Cuốn sách cuối cùng trong bộ ba, tập trung vào các khái niệm về chuỗi số, chuỗi hàm, và các phép biến đổi quan trọng như Fourier và Laplace." 
                         data-img-src="../assets/giaitich3.jpg">
                        <img src="../assets/giaitich3.jpg" alt="Bìa sách Giải Tích III">
                        <p class="book-title">Giải Tích III</p>
                    </div>
                </div>
            </section>

            <section class="book-section">
                <h2>Sách đang mượn</h2>
                <div class="borrowed-list">
                <?php
                if (isset($_SESSION['user_id'])):
                    $user_id = $_SESSION['user_id']; 

                    $stmt = $conn->prepare("
                        SELECT b.tieuDe, b.anhBia, br.ngayMuon, br.ngayHetHan, br.borrow_id 
                        FROM borrow_tbl br
                        JOIN book_tbl b ON br.book_id = b.id
                        WHERE br.user_id = ? AND br.tinhTrang = 'Đang mượn'
                    ");
                    $stmt->bind_param("i", $user_id);
                    $stmt->execute();
                    $borrowedBooks = $stmt->get_result();

                    if ($borrowedBooks->num_rows > 0) {
                        while ($row = $borrowedBooks->fetch_assoc()) {
                            $anhBia = htmlspecialchars($row['anhBia']);
                            $tieuDe = htmlspecialchars($row['tieuDe']);

                            $relativePath = "../" . $anhBia;  // thêm ../ vì ảnh nằm ở cấp trên

                            $filePath = __DIR__ . "/" . $relativePath;

                            if (file_exists($filePath)) {
                                $imgPath = $relativePath;
                            } else {
                                $imgPath = "https://placehold.co/100x140/333/FFF?text=Bìa";
                            }
                            echo '<div class="borrowed-item">
                                <div class="borrowed-item-cover">
                                    <img src="' . $imgPath . '" alt="Bìa sách">
                                    <p class="book-title-small">' . $tieuDe . '</p>
                                </div>
                                <div class="borrowed-item-info">
                                    <p><strong>Thông tin sách</strong></p>
                                    <p>Ngày mượn: ' . $row['ngayMuon'] . '</p>
                                    <p>Ngày hết hạn: ' . $row['ngayHetHan'] . '</p>
                                </div>
                                <form method="POST" action="return.php">
                                    <input type="hidden" name="borrow_id" value="' . $row['borrow_id'] . '">
                                    <button type="submit" class="btn-return">Trả sách</button>
                                </form>
                            </div>';
                        }
                    } else {
                        echo "<p>Chưa mượn sách nào.</p>";
                    }
                    $stmt->close();
                else:
                    echo "<p>Vui lòng <a href='#' onclick='openLoginModal()'>đăng nhập</a> để xem sách đã mượn.</p>";
                endif;
                ?>
                </div>
            </section>
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
                        <form method="POST" action="borrow.php">
                            <input type="hidden" name="borrow_book_id" value="<?php echo $book['id']; ?>">
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
                        <dd>2021</dd> <dt>Ngôn ngữ</dt>
                        <dd>Tiếng Việt</dd> </dl>
                </div>
            </div>
        </div>
    </div>

    <script src="borrow.js"></script>
</body>
</html>
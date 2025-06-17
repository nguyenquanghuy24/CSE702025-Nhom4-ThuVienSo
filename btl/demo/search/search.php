<?php
session_start();
include("../login/connect.php");

// Lấy từ khóa tìm kiếm từ URL
$query = isset($_GET['query']) ? trim($_GET['query']) : '';

// Chuẩn bị truy vấn tìm kiếm
$books = [];
if (!empty($query)) {
    $sql = "SELECT * FROM book_tbl WHERE tieuDe LIKE ? OR tacGia LIKE ?";
    $stmt = $conn->prepare($sql);
    $searchTerm = "%" . $query . "%";
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết quả tìm kiếm - Thư viện số</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="search.css">
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

    <main class="search-main-content">
        <div class="search-container">
            <div class="search-bar-wrapper">
                <form action="search.php" method="get">
                    <input type="text" class="search-input" name="query" placeholder="Nhập tên sách, tác giả để tìm kiếm..." value="<?php echo htmlspecialchars($query); ?>">
                    <button class="search-button"><i class="fa fa-search"></i></button>
                </form>
            </div>

            <div class="search-page-body">
                <aside class="filter-sidebar">
                    <!-- ... filter giữ nguyên (chưa xử lý logic) ... -->
                </aside>

                <section class="search-results">
                    <h2>Kết quả cho: "<?php echo htmlspecialchars($query); ?>"</h2>
                    <p class="results-count">Tìm thấy <?php echo count($books); ?> kết quả</p>

                    <div class="results-list">
                        <?php foreach ($books as $book): ?>
                            <div class="book-list-item">
                                <img src="<?php echo htmlspecialchars($book['biaSach'] ?? 'https://placehold.co/100x140?text=Bìa+Sách'); ?>" alt="Bìa sách" class="book-item-image">
                                <div class="book-item-info">
                                    <h4 class="book-title"><?php echo htmlspecialchars($book['tieuDe']); ?></h4>
                                    <p class="book-author">Tác giả: <?php echo htmlspecialchars($book['tacGia']); ?></p>
                                    <p class="book-description"><?php echo htmlspecialchars($book['moTa']); ?></p>
                                    <p class="book-year">Năm: <?php echo htmlspecialchars($book['namXuatBan']); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <?php if (count($books) === 0): ?>
                            <p>Không tìm thấy sách phù hợp.</p>
                        <?php endif; ?>
                    </div>
                </section>
            </div>
        </div>
    </main>

    <footer class="footer">
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

    <div id="bookDetailModal" class="modal">
        <div class="modal-content-large">
            <span class="close-btn-large">&times;</span>
            <div class="modal-body-large">
                <div class="modal-book-cover">
                    <img id="modal-book-image" src="" alt="Bìa sách">
                </div>
                <div class="modal-book-details">
                    <h2 id="modal-book-title"></h2>
                    <div class="modal-action-buttons">
                        <button class="btn-action btn-view-online"><i class="fas fa-book-open"></i> Xem online</button>
                        <button class="btn-action btn-borrow-book"><i class="fas fa-hand-holding-heart"></i> Mượn sách</button>
                    </div>
                    <h3>Details</h3>
                    <dl class="details-list">
                        <dt>Tác giả</dt>
                        <dd id="modal-book-author"></dd>
                        <dt>Năm xuất bản</dt>
                        <dd id="modal-book-year"></dd>
                        <dt>Mô tả</dt>
                        <dd id="modal-book-description"></dd>
                        <dt>Ngôn ngữ</dt>
                        <dd>Tiếng Việt</dd>
                        <dt>Chủ đề</dt>
                        <dd>Toán học, Giáo trình</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <script src="timkiem.js"></script>
</body>
</html>
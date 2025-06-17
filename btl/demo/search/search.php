<?php
session_start();
include("../login/connect.php");

// Lấy dữ liệu từ GET
$query = isset($_GET['query']) ? trim($_GET['query']) : '';
$category_filter = isset($_GET['category']) ? $_GET['category'] : [];
$year_filter = isset($_GET['year']) ? $_GET['year'] : [];
$lang_filter = isset($_GET['lang']) ? $_GET['lang'] : [];

$books = [];

// Chỉ thực hiện truy vấn nếu có từ khóa hoặc có chọn lọc
if (!empty($query) || !empty($category_filter) || !empty($year_filter) || !empty($lang_filter)) {
    $sql = "SELECT * FROM book_tbl WHERE 1=1"; // 1=1 để dễ nối AND
    $types = "";
    $params = [];

    // Lọc theo từ khóa
    if (!empty($query)) {
        $sql .= " AND (tieuDe LIKE ? OR tacGia LIKE ?)";
        $types .= "ss";
        $params[] = "%$query%";
        $params[] = "%$query%";
    }

    // Lọc thể loại
    if (!empty($category_filter)) {
        $placeholders = implode(',', array_fill(0, count($category_filter), '?'));
        $sql .= " AND theLoai IN ($placeholders)";
        $types .= str_repeat("s", count($category_filter));
        $params = array_merge($params, $category_filter);
    }

    // Lọc năm xuất bản
    if (!empty($year_filter)) {
        $year_conditions = [];
        foreach ($year_filter as $filter) {
            if ($filter == '>2020') {
                $year_conditions[] = "namXuatBan > 2020";
            } elseif ($filter == '2015-2020') {
                $year_conditions[] = "(namXuatBan >= 2015 AND namXuatBan <= 2020)";
            } elseif ($filter == '<2015') {
                $year_conditions[] = "namXuatBan < 2015";
            }
        }
        if (!empty($year_conditions)) {
            $sql .= " AND (" . implode(" OR ", $year_conditions) . ")";
        }
    }

    // Lọc ngôn ngữ
    if (!empty($lang_filter)) {
        $placeholders = implode(',', array_fill(0, count($lang_filter), '?'));
        $sql .= " AND ngonNgu IN ($placeholders)";
        $types .= str_repeat("s", count($lang_filter));
        $params = array_merge($params, $lang_filter);
    }

    // Thực hiện truy vấn
    $stmt = $conn->prepare($sql);
    if ($types && !empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
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
    <?php if (isset($_SESSION['borrow_success'])): ?>
        <script>alert("✅ Mượn sách thành công!");</script>
        <?php unset($_SESSION['borrow_success']); ?>
    <?php elseif (isset($_SESSION['borrow_error'])): ?>
        <script>alert("❌ <?php echo $_SESSION['borrow_error']; ?>");</script>
        <?php unset($_SESSION['borrow_error']); ?>
    <?php elseif (isset($_SESSION['login_required'])): ?>
        <script>
            alert("🔒 Vui lòng đăng nhập để mượn sách!");
            openLoginModal(); // gọi modal đăng nhập nếu bạn đã có hàm này
        </script>
        <?php unset($_SESSION['login_required']); ?>
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
                    <a href="../borrow/borrow.php">Mượn, Trả sách</a>
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
        <!-- Thanh tìm kiếm -->
        <div class="search-bar-wrapper">
            <form action="search.php" method="get" class="search-form">
                <input type="text" class="search-input" name="query" placeholder="Nhập tên sách, tác giả để tìm kiếm..." value="<?php echo htmlspecialchars($query); ?>">
                <button class="search-button"><i class="fa fa-search"></i></button>
            </form>
        </div>

        <div class="search-page-body">
            <!-- BỘ LỌC -->
            <aside class="filter-sidebar">
                <h3>Lọc kết quả</h3>
                <form method="get" action="search.php">
                    <input type="hidden" name="query" value="<?php echo htmlspecialchars($query); ?>">
                    
                    <div class="filter-group">
                        <strong>Thể loại</strong><br>
                            <input type="checkbox" name="category[]" value="Công nghệ thông tin" <?php if (in_array("Công nghệ thông tin", $category_filter)) echo "checked"; ?>> Khoa học máy tính<br>
                            <input type="checkbox" name="category[]" value="Trí tuệ nhân tạo" <?php if (in_array("Trí tuệ nhân tạo", $category_filter)) echo "checked"; ?>> Trí tuệ nhân tạo<br>
                            <input type="checkbox" name="category[]" value="Toán học" <?php if (in_array("Toán học", $category_filter)) echo "checked"; ?>> Toán học
                    </div>
                    
                    <div class="filter-group">
                        <strong>Năm xuất bản</strong><br>
                        <input type="checkbox" name="year[]" value=">2020" <?php if (in_array(">2020", $year_filter)) echo "checked"; ?>> Sau 2020<br>
                        <input type="checkbox" name="year[]" value="2015-2020" <?php if (in_array("2015-2020", $year_filter)) echo "checked"; ?>> 2015 - 2020<br>
                        <input type="checkbox" name="year[]" value="<2015" <?php if (in_array("<2015", $year_filter)) echo "checked"; ?>> Trước 2015
                    </div>


                    <div class="filter-group">
                        <strong>Ngôn ngữ</strong><br>
                        <input type="checkbox" name="lang[]" value="Tiếng Việt" <?php if (in_array("Tiếng Việt", $lang_filter)) echo "checked"; ?>> Tiếng Việt<br>
                        <input type="checkbox" name="lang[]" value="Tiếng Anh" <?php if (in_array("Tiếng Anh", $lang_filter)) echo "checked"; ?>> Tiếng Anh
                    </div>
                                

                    <button type="submit" class="filter-apply-button">Áp dụng</button>
                </form>
            </aside>

            <!-- KẾT QUẢ -->
            <section class="search-results">
                <?php if (!empty($query) || !empty($category_filter) || !empty($year_filter) || !empty($lang_filter)): ?>
                    <?php if (!empty($query)): ?>
                        <h2>"<?php echo htmlspecialchars($query); ?>"</h2>
                    <?php else: ?>
                        <h2>Kết quả lọc</h2>
                    <?php endif; ?>
                        
                    <p class="results-count">Tìm thấy <?php echo count($books); ?> kết quả</p>  

                    <div class="results-list">
                        <?php if (count($books) > 0): ?>
                            <?php foreach ($books as $book): ?>
                                <div class="book-list-item">
                                <?php
                                $imagePath = !empty($book['anhBia']) ? '../' . $book['anhBia'] : 'https://placehold.co/100x140?text=Bìa+Sách';
                                ?>
                                <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="Bìa sách" class="book-item-image">
                                    <div class="book-item-info">
                                        <h4 class="book-title"><?php echo htmlspecialchars($book['tieuDe']); ?></h4>
                                        <p class="book-author">Tác giả: <?php echo htmlspecialchars($book['tacGia']); ?></p>
                                        <p class="book-description"><?php echo htmlspecialchars($book['moTa']); ?></p>
                                        <p class="book-year">Năm: <?php echo htmlspecialchars($book['namXuatBan']); ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p style="margin-top: 1rem; color: #555;">❌ Không tìm thấy sách phù hợp với từ khóa "<strong><?php echo htmlspecialchars($query); ?></strong>".</p>
                        <?php endif; ?>
                    </div>
                    <?php else: ?>
                        <h2>🔎 Hãy nhập từ khóa hoặc chọn bộ lọc để tìm kiếm sách</h2>
                    <?php endif; ?>
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
                        <form method="post" action="../borrow/borrow.php" style="display: inline;">
                            <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
                            <button type="submit" class="btn-action btn-borrow-book">
                                <i class="fas fa-hand-holding-heart"></i> Mượn sách
                            </button>
                        </form>                    
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

    <script src="search.js"></script>
</body>
</html>
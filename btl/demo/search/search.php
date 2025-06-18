<?php
session_start();
require_once '../login/connect.php'; // Đảm bảo đường dẫn đúng tới file kết nối CSDL

// Khởi tạo các biến với giá trị mặc định để tránh lỗi undefined
$query = $_GET['query'] ?? ''; // Sử dụng null coalescing operator (PHP 7+)
$category_filter = $_GET['category'] ?? [];
$year_filter = $_GET['year'] ?? [];
$lang_filter = $_GET['lang'] ?? [];
$books = []; // Khởi tạo mảng sách rỗng

// Xử lý mượn sách (POST request)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_id']) && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $book_id = intval($_POST['book_id']);

    // === KIỂM TRA GIỚI HẠN SỐ SÁCH MƯỢN TỔNG CỘNG ===
    $stmt_count_total = $conn->prepare("SELECT COUNT(*) AS total_borrowed FROM borrow_tbl WHERE user_id = ? AND tinhTrang = 'Đang mượn'");
    $stmt_count_total->bind_param("i", $user_id);
    $stmt_count_total->execute();
    $result_count_total = $stmt_count_total->get_result();
    $borrow_count_total = $result_count_total->fetch_assoc()['total_borrowed'];
    $stmt_count_total->close();

    if ($borrow_count_total >= 5) {
        $_SESSION['borrow_error'] = "Bạn đã mượn tối đa 5 cuốn sách. Vui lòng trả sách để mượn thêm.";
        header("Location: ../borrow/borrow.php");
        exit();
    }

    // === KIỂM TRA GIỚI HẠN 1 CUỐN/ĐẦU SÁCH ===
    $stmt_count_specific = $conn->prepare("SELECT COUNT(*) AS specific_book_borrowed FROM borrow_tbl WHERE user_id = ? AND book_id = ? AND tinhTrang = 'Đang mượn'");
    $stmt_count_specific->bind_param("ii", $user_id, $book_id);
    $stmt_count_specific->execute();
    $result_count_specific = $stmt_count_specific->get_result();
    $specific_book_borrowed = $result_count_specific->fetch_assoc()['specific_book_borrowed'];
    $stmt_count_specific->close();

    if ($specific_book_borrowed > 0) {
        $_SESSION['borrow_error'] = "Bạn đã mượn cuốn sách này rồi. Vui lòng trả sách để mượn lại hoặc chọn sách khác.";
        header("Location: ../borrow/borrow.php");
        exit();
    }

    $conn->begin_transaction();

    try {
        // Kiểm tra và giảm số lượng
        $stmt = $conn->prepare("UPDATE book_tbl SET soLuong = soLuong - 1 WHERE id = ? AND soLuong > 0");
        $stmt->bind_param("i", $book_id);
        $stmt->execute();

        if ($stmt->affected_rows === 0) {
            $check_book_stmt = $conn->prepare("SELECT trangThai, soLuong FROM book_tbl WHERE id = ?");
            $check_book_stmt->bind_param("i", $book_id);
            $check_book_stmt->execute();
            $check_book_result = $check_book_stmt->get_result();
            $book_status = $check_book_result->fetch_assoc();
            $check_book_stmt->close();

            if ($book_status && $book_status['trangThai'] == 'Đang bảo trì') {
                throw new Exception("Sách đang bảo trì, không thể mượn.");
            } elseif ($book_status && $book_status['soLuong'] <= 0) {
                throw new Exception("Sách đã hết.");
            } else {
                throw new Exception("Không thể mượn sách này. Vui lòng thử lại.");
            }
        }

        // Cập nhật trạng thái nếu hết sách
        $update_status_stmt = $conn->prepare("UPDATE book_tbl SET trangThai = 'Đã mượn hết' WHERE id = ? AND soLuong <= 0");
        $update_status_stmt->bind_param("i", $book_id);
        $update_status_stmt->execute();
        $update_status_stmt->close();

        // Ghi mượn vào bảng borrow
        $stmt = $conn->prepare("INSERT INTO borrow_tbl (user_id, book_id, ngayMuon, ngayHetHan, tinhTrang)
                                 VALUES (?, ?, NOW(), DATE_ADD(NOW(), INTERVAL 30 DAY), 'Đang mượn')");
        $stmt->bind_param("ii", $user_id, $book_id);
        $stmt->execute();
        $stmt->close();

        $conn->commit();
        $_SESSION['borrow_success'] = "Mượn sách thành công! Sách sẽ xuất hiện trong mục 'Sách đang mượn'.";
    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['borrow_error'] = $e->getMessage();
    }

    header("Location: ../borrow/borrow.php");
    exit();
}

// BẮT ĐẦU: Logic tìm kiếm và lọc chỉ thực thi khi có query hoặc filter
if (!empty($query) || !empty($category_filter) || !empty($year_filter) || !empty($lang_filter)) {
    // Xây dựng câu truy vấn SQL
    $sql = "SELECT * FROM book_tbl WHERE 1=1";

    $params = [];
    $types = "";

    if (!empty($query)) {
        $sql .= " AND (tieuDe LIKE ? OR tacGia LIKE ?)";
        $params[] = '%' . $query . '%';
        $params[] = '%' . $query . '%';
        $types .= "ss";
    }

    if (!empty($category_filter)) {
        $cleaned_category_filter = array_map('trim', $category_filter);
        $category_placeholders = implode(',', array_fill(0, count($cleaned_category_filter), '?'));
        $sql .= " AND theLoai IN ($category_placeholders)";
        foreach ($cleaned_category_filter as $cat) {
            $params[] = $cat;
            $types .= "s";
        }
    }

    if (!empty($year_filter)) {
        $year_conditions = [];
        foreach ($year_filter as $year_range) {
            switch ($year_range) {
                case '>2020':
                    $year_conditions[] = "namXuatBan > 2020";
                    break;
                case '2015-2020':
                    $year_conditions[] = "(namXuatBan >= 2015 AND namXuatBan <= 2020)";
                    break;
                case '<2015':
                    $year_conditions[] = "namXuatBan < 2015";
                    break;
            }
        }
        if (!empty($year_conditions)) {
            $sql .= " AND (" . implode(' OR ', $year_conditions) . ")";
        }
    }

    if (!empty($lang_filter)) {
        $cleaned_lang_filter = array_map('trim', $lang_filter);
        $lang_placeholders = implode(',', array_fill(0, count($cleaned_lang_filter), '?'));
        $sql .= " AND ngonNgu IN ($lang_placeholders)";
        foreach ($cleaned_lang_filter as $lang) {
            $params[] = $lang;
            $types .= "s";
        }
    }

    $stmt = $conn->prepare($sql);

    if (!empty($params)) {
        $bind_names = array_merge([$types], $params);
        $refs = [];
        foreach ($bind_names as $key => $value) {
            $refs[$key] = &$bind_names[$key];
        }
        call_user_func_array([$stmt, 'bind_param'], $refs);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $books = $result->fetch_all(MYSQLI_ASSOC);

    $stmt->close();
    $conn->close();
} else {
    // Nếu không có query hay filter, set $books rỗng để không hiển thị gì
    $books = [];
    // Và đóng kết nối CSDL ở đây luôn vì không cần truy vấn
    $conn->close();
}
// KẾT THÚC: Logic tìm kiếm và lọc chỉ thực thi khi có query hoặc filter

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
        <div class="search-bar-wrapper">
            <form action="search.php" method="get" class="search-form">
                <input type="text" class="search-input" name="query" placeholder="Nhập tên sách, tác giả để tìm kiếm..." value="<?php echo htmlspecialchars($query); ?>">
                <button type="submit" class="search-button"><i class="fa fa-search"></i></button>
            </form>
        </div>

        <div class="search-page-body">
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

            <section class="search-results">
                <?php if (!empty($query) || !empty($category_filter) || !empty($year_filter) || !empty($lang_filter)): /* ĐIỀU KIỆN MỚI */ ?>
                    <?php if (!empty($query)): ?>
                        <h2>Kết quả tìm kiếm cho "<?php echo htmlspecialchars($query); ?>"</h2>
                    <?php else: ?>
                        <h2>Kết quả lọc</h2>
                    <?php endif; ?>
                            
                    <p class="results-count">Tìm thấy <?php echo count($books); ?> kết quả</p>    

                    <div class="results-list">
                        <?php if (count($books) > 0): ?>
                            <?php foreach ($books as $book): ?>
                                <?php
                                $statusClass = '';
                                switch($book['trangThai']) {
                                    case 'Có sẵn': 
                                        $statusClass = 'status-available'; 
                                        break;
                                    case 'Đã mượn hết': 
                                        $statusClass = 'status-unavailable'; 
                                        break;
                                    case 'Đang bảo trì': 
                                        $statusClass = 'status-maintenance'; 
                                        break;
                                    default: 
                                        $statusClass = 'status-unknown';
                                        break;
                                }
                                
                                // === LOGIC XỬ LÝ ĐƯỜNG DẪN ẢNH ĐƯỢC CẢI THIỆN ===
                                $imagePath = "https://placehold.co/100x140?text=Không+có+ảnh"; // Mặc định
                                if (!empty($book['anhBia'])) {
                                    $dbImagePath = $book['anhBia']; 
                                    
                                    $projectRootForImages = dirname(__DIR__); 

                                    $physicalFilePath = $projectRootForImages . '/' . $dbImagePath; 

                                    if (file_exists($physicalFilePath)) {
                                        $imagePath = '../' . $dbImagePath; 
                                    } else {
                                        error_log("Search.php: Image file not found for " . $dbImagePath . " at " . $physicalFilePath);
                                    }
                                }
                                ?>
                                
                                <div class="book-list-item" 
                                     data-book-id="<?php echo htmlspecialchars($book['id']); ?>"
                                     data-title="<?php echo htmlspecialchars($book['tieuDe']); ?>"
                                     data-author="<?php echo htmlspecialchars($book['tacGia']); ?>"
                                     data-year="<?php echo htmlspecialchars($book['namXuatBan']); ?>"
                                     data-description="<?php echo htmlspecialchars($book['moTa']); ?>"
                                     data-img-src="<?php echo htmlspecialchars($imagePath); ?>"
                                     data-status="<?php echo htmlspecialchars($book['trangThai']); ?>"
                                     data-category="<?php echo htmlspecialchars($book['theLoai']); ?>"
                                     data-language="<?php echo htmlspecialchars($book['ngonNgu']); ?>">
                                    <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="Bìa sách" class="book-item-image">
                                    <div class="book-item-info">
                                        <h4 class="book-title"><?php echo htmlspecialchars($book['tieuDe']); ?></h4>
                                        <p class="book-author">Tác giả: <?php echo htmlspecialchars($book['tacGia']); ?></p>
                                        
                                        <div class="book-status <?php echo $statusClass; ?>">
                                            <i class="status-icon"></i>
                                            <span><?php echo htmlspecialchars($book['trangThai']); ?></span>
                                        </div>
                                        
                                        <p class="book-meta">
                                            <span class="book-year">Năm: <?php echo htmlspecialchars($book['namXuatBan']); ?></span><br>
                                            <span class="book-quantity">Số lượng: <?php echo htmlspecialchars($book['soLuong']); ?></span><br>
                                            <span class="book-category-display">Thể loại: <?php echo htmlspecialchars($book['theLoai']); ?></span><br>
                                            <span class="book-language-display">Ngôn ngữ: <?php echo htmlspecialchars($book['ngonNgu']); ?></span>
                                        </p>
                                        
                                        <div class="book-description">
                                            <p><?php echo htmlspecialchars($book['moTa']); ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="no-results">
                                <i class="fas fa-book-open"></i>
                                <p>Không tìm thấy sách phù hợp với từ khóa "<strong><?php echo htmlspecialchars($query); ?></strong>" hoặc bộ lọc đã chọn.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php else: /* ĐIỀU KIỆN MỚI: HIỂN THỊ HƯỚNG DẪN KHI CHƯA CÓ SEARCH/FILTER */ ?>
                    <div class="search-instruction">
                        <i class="fas fa-search"></i>
                        <h2>Hãy nhập từ khóa hoặc chọn bộ lọc để tìm kiếm sách</h2>
                    </div>
                <?php endif; ?>
            </section>
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
            <div id="loginModal" class="modal">
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
                        <form method="post" action="search.php" style="display: inline;">
                            <input type="hidden" name="book_id" id="modal-borrow-book-id">
                            <button type="submit" class="btn-action btn-borrow-book" id="modal-borrow-btn">
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
                        <dd id="modal-book-language"></dd>
                        <dt>Chủ đề</dt>
                        <dd id="modal-book-category"></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <script>
        const isLoggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;
    </script>
    <script src="search.js"></script>
</body>
</html>
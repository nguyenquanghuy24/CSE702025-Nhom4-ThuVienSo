<?php
session_start();
include("../login/connect.php");
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['book_id'])) {
    if (!isset($_SESSION['user_id'])) {
        echo "<script>openLoginModal();</script>";
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $book_id = intval($_POST['book_id']);
    $ngayMuon = date("Y-m-d");
    $ngayHetHan = date("Y-m-d", strtotime("+7 days"));
    $tinhTrang = "Đang mượn";

    $check_sql = "SELECT soLuong FROM book_tbl WHERE id = $book_id";
    $result = mysqli_query($conn, $check_sql);
    $row = mysqli_fetch_assoc($result);

    if ($row && $row['soLuong'] > 0) {
        $sql = "INSERT INTO borrow_tbl (user_id, book_id, ngayMuon, ngayHetHan, tinhTrang)
                VALUES ($user_id, $book_id, '$ngayMuon', '$ngayHetHan', '$tinhTrang')";

        if (mysqli_query($conn, $sql)) {
            $update_sql = "UPDATE book_tbl SET soLuong = soLuong - 1 WHERE id = $book_id";
            mysqli_query($conn, $update_sql);
            echo "Mượn sách thành công!";
        } else {
            echo "Lỗi khi mượn sách: " . mysqli_error($conn);
        }
    } else {
        echo "Sách đã hết hoặc không tồn tại.";
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
            <section class="book-section">
                <h2>Sách đề xuất</h2>
                <div class="recommend-grid">
                    <div class="book-card-simple">
                        <img src="https://placehold.co/200x280/0077cc/FFF?text=Bìa+Sách" alt="Bìa sách">
                        <p class="book-title">Tên sách 1</p>
                    </div>
                    <div class="book-card-simple">
                        <img src="https://placehold.co/200x280/5cb85c/FFF?text=Bìa+Sách" alt="Bìa sách">
                        <p class="book-title">Tên sách 2</p>
                    </div>
                    <div class="book-card-simple">
                        <img src="https://placehold.co/200x280/d9534f/FFF?text=Bìa+Sách" alt="Bìa sách">
                        <p class="book-title">Tên sách 3</p>
                    </div>
                    <div class="book-card-simple">
                        <img src="https://placehold.co/200x280/f0ad4e/FFF?text=Bìa+Sách" alt="Bìa sách">
                        <p class="book-title">Tên sách 4</p>
                    </div>
                </div>
            </section>

            <section class="book-section">
                <h2>Sách đang mượn</h2>
                <div class="borrowed-list">
                <?php
                if ($user_id) {
                    $sql = "SELECT b.tieuDe, br.ngayMuon, br.ngayHetHan, br.borrow_id 
                            FROM borrow_tbl br 
                            JOIN book_tbl b ON br.book_id = b.id 
                            WHERE br.user_id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $user_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="borrowed-item">
                                <div class="borrowed-item-cover">
                                    <img src="https://placehold.co/100x140/333/FFF?text=Bìa" alt="Bìa sách">
                                    <p class="book-title-small">' . htmlspecialchars($row['tieuDe']) . '</p>
                                </div>
                                <div class="borrowed-item-info">
                                    <p><strong>Thông tin sách</strong></p>
                                    <p>Ngày mượn: ' . $row['ngayMuon'] . '</p>
                                    <p>Ngày hết hạn: ' . $row['ngayHetHan'] . '</p>
                                </div>
                                <form method="POST" action="return_book.php">
                                    <input type="hidden" name="borrow_id" value="' . $row['borrow_id'] . '">
                                    <button type="submit" class="btn-return">Trả sách</button>
                                </form>
                            </div>';
                        }
                    } else {
                        echo "<p>Chưa mượn sách nào.</p>";
                    }

                    $stmt->close();
                } else {
                    echo "<p>Vui lòng <a href='#' onclick='openLoginModal()'>đăng nhập</a> để xem sách đã mượn.</p>";
                }
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

    <script src="borrow.js"></script>
</body>
</html>
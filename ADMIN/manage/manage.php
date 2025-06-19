<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$books = [
    [
        'id' => 1,
        'title' => 'Giải tích I',
        'author' => 'Nguyễn Đình Trí',
        'isbn' => '978-604-56-1234-5',
        'quantity' => 10,
        'available' => 7,
        'image' => 'assets/giaitich1.jpg',
        'description' => 'Cuốn sách này bao gồm các kiến thức cơ bản về giải tích một biến, giới hạn, đạo hàm, tích phân.',
        'borrowers' => [
            ['user_id' => 101, 'name' => 'Trần Văn A', 'borrow_date' => '2025-06-01', 'due_date' => '2025-06-15'],
            ['user_id' => 102, 'name' => 'Lê Thị B', 'borrow_date' => '2025-06-05', 'due_date' => '2025-06-19'],
            ['user_id' => 103, 'name' => 'Phạm Văn C', 'borrow_date' => '2025-06-10', 'due_date' => '2025-06-24'],
        ]
    ],
    [
        'id' => 2,
        'title' => 'Giải tích II',
        'author' => 'Nguyễn Đình Trí',
        'isbn' => '978-604-56-6789-0',
        'quantity' => 8,
        'available' => 5,
        'image' => 'assets/giaitich2.jpg',
        'description' => 'Tiếp nối Giải tích I, cuốn sách này tập trung vào giải tích nhiều biến, chuỗi và phương trình vi phân.',
        'borrowers' => [
            ['user_id' => 104, 'name' => 'Đinh Công D', 'borrow_date' => '2025-05-20', 'due_date' => '2025-06-03'],
            ['user_id' => 105, 'name' => 'Võ Thị E', 'borrow_date' => '2025-06-02', 'due_date' => '2025-06-16'],
            ['user_id' => 106, 'name' => 'Nguyễn Hữu F', 'borrow_date' => '2025-06-12', 'due_date' => '2025-06-26'],
        ]
    ],
    [
        'id' => 3,
        'title' => 'Giải tích III',
        'author' => 'Nguyễn Đình Trí',
        'isbn' => '978-604-56-0101-0',
        'quantity' => 12,
        'available' => 12,
        'image' => 'assets/giaitich3.jpg',
        'description' => 'Giải tích III bao gồm các chủ đề nâng cao về giải tích hàm, phép biến đổi Laplace và Fourier.',
        'borrowers' => []
    ],
    [
        'id' => 4,
        'title' => 'Nhập môn Trí tuệ nhân tạo',
        'author' => 'Stuart Russell, Peter Norvig',
        'isbn' => '978-0136042594',
        'quantity' => 5,
        'available' => 3,
        'image' => 'assets/ai_book.jpg',
        'description' => 'Cuốn sách kinh điển về trí tuệ nhân tạo, bao gồm các thuật toán tìm kiếm, logic, học máy, v.v.',
        'borrowers' => [
            ['user_id' => 107, 'name' => 'Trần Quang G', 'borrow_date' => '2025-06-03', 'due_date' => '2025-06-17'],
            ['user_id' => 108, 'name' => 'Lý Hữu H', 'borrow_date' => '2025-06-08', 'due_date' => '2025-06-22'],
        ]
    ],
];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
  <title>Quản lý Sách - Admin</title>
  <link rel="stylesheet" href="admin3.css" />
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
          <a href="add.php" class="dropdown-toggle">Thêm sách</a>
          </div>
        <div class="dropdown">
          <a href="manage.php" class="dropdown-toggle">Quản lý</a>
          </div>
        <div class="dropdown">
            <a href="reply.php" class="dropdown-toggle">Hòm thư</a>
            </div>
        <div class="dropdown">
            <a href="contact.php" class="dropdown-toggle">Contact</a>
        </div>
      </div>
        <div class="dropdown">
            <span class="dropdown-toggle">Contact</span>
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

<div class="admin-books-container">
    <aside class="books-sidebar-left">
        <div class="sidebar-header">
            <h3>Danh sách Sách</h3>
            <div class="search-books">
                <input type="text" id="bookSearchInput" placeholder="Tìm kiếm sách...">
                <i class="ri-search-line"></i>
            </div>
        </div>
        <ul class="book-list">
            <?php if (!empty($books)): ?>
                <?php foreach ($books as $book): ?>
                    <li class="book-item"
                        data-id="<?php echo $book['id']; ?>"
                        data-title="<?php echo htmlspecialchars($book['title']); ?>"
                        data-author="<?php echo htmlspecialchars($book['author']); ?>"
                        data-isbn="<?php echo htmlspecialchars($book['isbn']); ?>"
                        data-quantity="<?php echo $book['quantity']; ?>"
                        data-available="<?php echo $book['available']; ?>"
                        data-image="<?php echo htmlspecialchars($book['image']); ?>"
                        data-description="<?php echo htmlspecialchars($book['description']); ?>"
                        data-borrowers='<?php echo json_encode($book['borrowers']); ?>'>
                        <div class="item-content">
                            <h4 class="item-title"><?php echo htmlspecialchars($book['title']); ?></h4>
                            <p class="item-author"><?php echo htmlspecialchars($book['author']); ?></p>
                            <p class="item-status">Còn: <?php echo $book['available']; ?>/<?php echo $book['quantity']; ?></p>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>Không có sách nào trong thư viện.</li>
            <?php endif; ?>
        </ul>
    </aside>

    <section class="book-details-panel">
        <div class="no-book-selected" id="noBookSelected">
            <i class="ri-book-3-line"></i>
            <p>Chọn một cuốn sách để xem chi tiết</p>
        </div>

        <div class="book-details-content" id="bookDetailsContent" style="display:none;">
            <div class="book-info">
                <img src="" alt="Ảnh bìa sách" class="book-cover" id="detailBookImage">
                <div class="book-meta">
                    <h2 class="book-title" id="detailBookTitle"></h2>
                    <p class="book-author">Tác giả: <span id="detailBookAuthor"></span></p>
                    <p class="book-isbn">ISBN: <span id="detailBookISBN"></span></p>
                    <p class="book-quantity">Tổng số lượng: <span id="detailBookQuantity"></span></p>
                    <p class="book-available">Số lượng còn lại: <span id="detailBookAvailable"></span></p>
                    <p class="book-description" id="detailBookDescription"></p>
                    </div>
            </div>

            <div class="borrowers-section">
                <h3>Người đang mượn</h3>
                <ul class="borrower-list" id="borrowerList">
                    <li>Không có ai đang mượn sách này.</li>
                </ul>
            </div>
        </div>
    </section>
</div>

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
<div id="loginModal" class="modal">
  <div class="modal-content">
    <span class="close-btn" onclick="closeModal()">&times;</span>
    <h2>Đăng nhập</h2>
    <?php if (isset($_SESSION['login_error'])): ?>
      <p style="color: red;"><?php echo $_SESSION['login_error']; unset($_SESSION['login_error']); ?></p>
    <?php endif; ?>
    <form method="POST" action="login/login.php">
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

<script src="admin3.js"></script>
</body>
</html>
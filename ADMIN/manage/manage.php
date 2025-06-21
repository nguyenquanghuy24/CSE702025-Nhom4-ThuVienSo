<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("../../user/demo/login/connect.php");

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    $_SESSION['login_error'] = "Bạn cần đăng nhập bằng tài khoản quản trị để truy cập.";
    header("Location: ../logadmin.php");
    exit();
}

// Xử lý phê duyệt hoặc từ chối yêu cầu mượn
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['request_id'])) {
    $request_id = intval($_POST['request_id']);
    $action = $_POST['action'];

    if ($action === 'approve') {
        $stmt = $conn->prepare("UPDATE borrow_tbl SET tinhTrang = 'Đang mượn' WHERE borrow_id = ?");
    } elseif ($action === 'decline') {
        // Lấy book_id để tăng lại số lượng nếu từ chối
        $getBookId = $conn->prepare("SELECT book_id FROM borrow_tbl WHERE borrow_id = ?");
        $getBookId->bind_param("i", $request_id);
        $getBookId->execute();
        $bookRow = $getBookId->get_result()->fetch_assoc();
        $book_id = $bookRow['book_id'];
        $getBookId->close();

        $updateBook = $conn->prepare("UPDATE book_tbl SET soLuong = soLuong + 1 WHERE id = ?");
        $updateBook->bind_param("i", $book_id);
        $updateBook->execute();
        $updateBook->close();

        $stmt = $conn->prepare("UPDATE borrow_tbl SET tinhTrang = 'Từ chối' WHERE borrow_id = ?");
    }

    $stmt->bind_param("i", $request_id);
    $stmt->execute();
    $stmt->close();

    header("Location: manage.php");
    exit();
}

// Lấy danh sách sách từ book_tbl
$book_result = $conn->query("SELECT * FROM book_tbl ORDER BY id DESC");

// Lấy danh sách yêu cầu mượn sách đang chờ phê duyệt
$request_sql = "SELECT b.borrow_id, u.hoTen AS fullname, u.maSV, u.email, bk.tieuDe, b.maMuon, b.ngayMuon
    FROM borrow_tbl b
    JOIN tbl_user u ON b.user_id = u.id
    JOIN book_tbl bk ON b.book_id = bk.id
    WHERE b.tinhTrang = 'Đang chờ phê duyệt'
    ORDER BY b.ngayMuon DESC";
$request_result = $conn->query($request_sql);

$books = [];

// Lấy danh sách tất cả sách
$query = "SELECT * FROM book_tbl";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $book_id = $row['id'];

        // Truy vấn người đang mượn cuốn sách này
        $borrowers = [];
        $borrow_query = "
            SELECT u.id AS user_id, u.hoTen AS name, b.ngayMuon, b.ngayHetHan AS hanTra 
            FROM borrow_tbl b 
            JOIN tbl_user u ON b.user_id = u.id 
            WHERE b.book_id = $book_id AND b.tinhTrang = 'Đang mượn'
        ";        
        $borrow_result = mysqli_query($conn, $borrow_query);
        if ($borrow_result && mysqli_num_rows($borrow_result) > 0) {
            while ($br = mysqli_fetch_assoc($borrow_result)) {
                $borrowers[] = [
                    'user_id' => $br['user_id'],
                    'name' => $br['name'],
                    'borrow_date' => $br['ngayMuon'],
                    'due_date' => $br['hanTra']
                ];
            }
        }

        // Đường dẫn ảnh
        $imagePath = !empty($row['anhBia']) ? '../../user/demo/' . $row['anhBia'] : 'assets/default_book.jpg';

        $books[] = [
            'id' => $row['id'],
            'title' => $row['tieuDe'],
            'author' => $row['tacGia'] ?? 'Không rõ',
            'isbn' => $row['maSach'],
            'quantity' => $row['soLuong'],
            'available' => $row['soLuong'] - count($borrowers),
            'image' => $imagePath,
            'description' => $row['moTa'] ?? '',
            'borrowers' => $borrowers
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
  <title>Quản lý Sách - Admin</title>
  <link rel="stylesheet" href="manage.css" />
</head>
<body>
<header class="navbar">
    <div class="logo">
      <a href="../logadmin.php"> <img src="../../user/demo/assets/logo.jpg" alt="Logo Thư viện số">
      </a>
    </div>
    <div class="nav-links">
        <div class="dropdown">
          <a href="../add/add.php" class="dropdown-toggle">Thêm sách</a> </div>
        <div class="dropdown">
          <a href="manage.php" class="dropdown-toggle">Quản lý</a> </div>
        <div class="dropdown">
            <a href="../reply/reply.php" class="dropdown-toggle">Hòm thư</a> </div>
    </div> <div class="auth">
        <?php if (isset($_SESSION['user'])): ?>
            <span><?php echo htmlspecialchars($_SESSION['user']); ?></span>
            <a href="../../user/demo/login/logout.php?redirect=/project/CSE702025-Nhom4-ThuVienSo/user/demo/index.php">Đăng xuất</a>
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

<section class="borrow-requests-section" style="margin: 40px;">
    <h2>Yêu cầu mượn sách</h2>
    <?php if ($request_result && $request_result->num_rows > 0): ?>
    <table border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse: collapse;">
        <tr>
            <th>Mã mượn</th>
            <th>Họ tên</th>
            <th>MSSV</th>
            <th>Email</th>
            <th>Tên sách</th>
            <th>Ngày mượn</th>
            <th>Thao tác</th>
        </tr>
        <?php while ($row = $request_result->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['maMuon']); ?></td>
            <td><?php echo htmlspecialchars($row['fullname']); ?></td>
            <td><?php echo htmlspecialchars($row['maSV']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo htmlspecialchars($row['tieuDe']); ?></td>
            <td><?php echo htmlspecialchars($row['ngayMuon']); ?></td>
            <td>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="request_id" value="<?php echo $row['borrow_id']; ?>">
                    <button type="submit" name="action" value="approve">Phê duyệt</button>
                </form>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="request_id" value="<?php echo $row['borrow_id']; ?>">
                    <button type="submit" name="action" value="decline" onclick="return confirm('Bạn có chắc chắn từ chối?');">Từ chối</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <?php else: ?>
        <p>Không có yêu cầu mượn sách nào đang chờ xử lý.</p>
    <?php endif; ?>
</section>

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

<script src="manage.js"></script>
</body>
</html>
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

$feedbacks = [];
$sql = "SELECT * FROM ticket_tbl ORDER BY ticket_id DESC";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $feedbacks[] = $row;
    }
}

if (isset($_GET['success']) && $_GET['success'] == 1) {
    echo "<script>alert('Đã gửi phản hồi thành công!');</script>";
}
if (isset($_GET['error'])) {
    echo "<script>alert('Lỗi: " . htmlspecialchars($_GET['error']) . "');</script>";
}

?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
  <title> Phản hồi - Admin</title>
  <link rel="stylesheet" href="reply.css" />
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
          <a href="../manage/manage.php" class="dropdown-toggle">Quản lý</a> </div>
        <div class="dropdown">
            <a href="reply.php" class="dropdown-toggle">Hòm thư</a> </div>
      </div>
    <div class="auth">
        <?php if (isset($_SESSION['user'])): ?>
            <span><?php echo htmlspecialchars($_SESSION['user']); ?></span>
            <a href="../../user/demo/login/logout.php?redirect=/project/CSE702025-Nhom4-ThuVienSo/user/demo/index.php">Đăng xuất</a>
        <?php else: ?>
            <a href="#" onclick="openLoginModal()" class="auth-link">Đăng nhập</a>
        <?php endif; ?>
    </div>
</header>

<div class="admin-inbox-container">
    <aside class="sidebar-left">
        <div class="sidebar-header">
            <h3>Inbox</h3>
            <div class="filter-dropdown">
                <select>
                    <option>All Courses</option>
                    <option>Course 1</option>
                    <option>Course 2</option>
                </select>
            </div>
        </div>
        <div class="search-inbox">
            <input type="text" placeholder="Search Inbox...">
            <i class="ri-search-line"></i>
        </div>
            <ul class="feedback-inbox-list">
            <?php if (!empty($feedbacks)): ?>
                <?php foreach ($feedbacks as $feedback): ?>
                    <li class="inbox-item"
                        data-id="<?php echo $feedback['ticket_id']; ?>"
                        data-sender="<?php echo htmlspecialchars($feedback['hoTen']); ?>"
                        data-email="<?php echo htmlspecialchars($feedback['email']); ?>"
                        data-subject="<?php echo htmlspecialchars($feedback['subject']); ?>"
                        data-message="<?php echo htmlspecialchars($feedback['message']); ?>"
                        data-date="<?php echo htmlspecialchars($feedback['created_at'] ?? ''); ?>"> <!-- Nếu bạn có trường thời gian -->
                        <div class="item-checkbox"><input type="checkbox"></div>
                        <div class="item-content">
                            <div class="item-sender"><?php echo htmlspecialchars($feedback['hoTen']); ?></div>
                            <div class="item-subject"><?php echo htmlspecialchars($feedback['subject']); ?></div>
                            <div class="item-excerpt"><?php echo substr(htmlspecialchars($feedback['message']), 0, 50); ?>...</div>
                        </div>
                        <div class="item-meta">
                            <span class="item-date"><?php echo date('M d, Y'); ?></span>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>Không có phản hồi nào.</li>
            <?php endif; ?>
            </ul> 
    </aside>

    <section class="main-content-panel">
        <div class="conversation-view">
            <div class="no-conversation-selected" id="noConversationSelected">
                <i class="ri-mail-line"></i>
                <p>No Conversations Selected</p>
            </div>

            <div class="conversation-details" id="conversationDetails" style="display:none;">
                <div class="conversation-details-header">
                    <h2 class="conversation-subject" id="detailSubject">(No subject)</h2>
                    <div class="conversation-meta">
                        <div class="sender-info">
                            <span class="sender-avatar"></span>
                            <span class="sender-name" id="detailSenderName"></span>
                            <span class="sender-email" id="detailSenderEmail"></span>
                        </div>
                        <span class="conversation-date" id="detailDate"></span>
                    </div>
                </div>
                <div class="conversation-body">
                    <p class="conversation-message" id="detailMessage"></p>
                </div>
                <div class="conversation-actions">
                    <button class="reply-button" id="replyButton"><i class="ri-reply-line"></i> Reply</button>
                    </div>
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


<div id="composeModal" class="compose-modal">
    <div class="compose-modal-content">
        <div class="compose-modal-header">
            <span class="compose-modal-title">Compose Message</span>
            <span class="close-compose-modal close-button">&times;</span>
        </div>
        <form id="composeForm" method="POST" action="send_reply.php">
            <input type="hidden" name="ticket_id" id="composeTicketId">
            <div class="form-group">
                <label for="composeCourse">Course:</label>
                <input type="text" id="composeCourse" name="compose_course" value="Kỹ thuật phần mềm" readonly>
            </div>
            <div class="form-group">
                <label for="composeTo">To:</label>
                <input type="text" id="composeTo" name="compose_to" readonly>
            </div>
            <div class="form-group">
                <label for="composeSubject">Subject:</label>
                <input type="text" id="composeSubject" name="compose_subject" required>
            </div>
            <div class="form-group">
                <textarea id="composeMessage" name="compose_message" rows="10" placeholder="Type your message here..." required></textarea>
            </div>
            <div class="compose-modal-footer">
                <button type="button" class="cancel-compose-btn">Cancel</button>
                <button type="submit" class="send-compose-btn">Send</button>
            </div>
        </form>
        <input type="hidden" name="ticket_id" id="composeTicketId">
    </div>
</div>
<script>
document.querySelectorAll('.inbox-item').forEach(item => {
    item.addEventListener('click', function () {
        const ticketId = this.getAttribute('data-id');
        const sender = this.getAttribute('data-sender');
        const email = this.getAttribute('data-email');
        const subject = this.getAttribute('data-subject');
        const message = this.getAttribute('data-message');
        const date = this.getAttribute('data-date');

        // Gán giá trị vào modal
        document.getElementById('detailSubject').innerText = subject;
        document.getElementById('detailSenderName').innerText = sender;
        document.getElementById('detailSenderEmail').innerText = email;
        document.getElementById('detailMessage').innerText = message;
        document.getElementById('detailDate').innerText = date;

        // Gán dữ liệu vào form trả lời
        document.getElementById('composeTo').value = sender;
        document.getElementById('composeSubject').value = "Phản hồi: " + subject;
        document.getElementById('composeTicketId').value = ticketId;

        // Hiện phần chi tiết và modal
        document.getElementById('conversationDetails').style.display = 'block';
    });
});
</script>

<script src="reply.js"></script>
</body>
</html>
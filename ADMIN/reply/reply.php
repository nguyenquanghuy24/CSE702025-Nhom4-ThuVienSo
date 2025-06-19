<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
//viết csdl đây nhé tùng
$feedbacks = [
    [
        'id' => 1,
        'sender' => 'Nguyễn Quang Huy',
        'email' => 'huy.nguyen@example.com',
        'subject' => 'Về sách Giải tích I bị hỏng',
        'message' => 'Kính gửi thư viện, tôi muốn báo cáo rằng cuốn sách Giải tích I tôi vừa mượn có một số trang bị rách và không đọc được. Mong thư viện có thể hỗ trợ đổi sách hoặc có biện pháp xử lý. Cảm ơn.',
        'date' => '2025-06-15 10:30:00',
        'status' => 'Chưa trả lời'
    ],
    [
        'id' => 2,
        'sender' => 'Hoàng Lê Đức Huy',
        'email' => 'duc.huy@example.com',
        'subject' => 'Đề xuất thêm sách mới',
        'message' => 'Chào thư viện, tôi muốn đề xuất mua thêm các đầu sách về khoa học dữ liệu và trí tuệ nhân tạo. Hiện tại thư viện có vẻ chưa nhiều sách về mảng này. Trân trọng.',
        'date' => '2025-06-14 14:00:00',
        'status' => 'Đã trả lời'
    ],
    [
        'id' => 3,
        'sender' => 'Nguyễn Minh Tùng',
        'email' => 'minh.tung@example.com',
        'subject' => 'Góp ý về thời gian mở cửa',
        'message' => 'Tôi thấy thời gian mở cửa thư viện vào cuối tuần hơi ngắn, rất khó cho sinh viên bận rộn như chúng tôi. Kính mong thư viện xem xét kéo dài thêm thời gian. Cảm ơn.',
        'date' => '2025-06-12 09:15:00',
        'status' => 'Chưa trả lời'
    ],
    [
        'id' => 4,
        'sender' => 'Nguyễn Văn Thiệu',
        'email' => 'thieu.nguyen@example.com',
        'subject' => 'Hỏi về tài liệu chuyên ngành',
        'message' => 'Tôi đang làm nghiên cứu về trí tuệ nhân tạo và cần một số tài liệu chuyên sâu hơn về học sâu (deep learning). Thư viện có thể gợi ý hoặc cung cấp thêm không ạ?',
        'date' => '2025-02-25 11:00:00',
        'status' => 'Chưa trả lời'
    ],
    [
        'id' => 5,
        'sender' => 'Nguyễn Kim Khương',
        'email' => 'khuong.nguyen@example.com',
        'subject' => 'Báo cáo lỗi hệ thống',
        'message' => 'Khi tôi cố gắng đăng nhập vào hệ thống thư viện số, tôi gặp lỗi "Access Denied". Vui lòng kiểm tra lại. Cảm ơn.',
        'date' => '2024-10-18 16:45:00',
        'status' => 'Đã trả lời'
    ],
];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
  <title>Quản lý Phản hồi - Admin</title>
  <link rel="stylesheet" href="admin2.css" />
</head>
<body>
<header class="navbar">
    <div class="logo">
      <a href="../index.php"> <img src="../assets/logo.jpg" alt="Logo Thư viện số">
      </a>
      <div class="nav-links">
        <div class="dropdown">
          <a href="../add/add.php" class="dropdown-toggle">Thêm sách</a> </div>
        <div class="dropdown">
          <a href="../manage/manage.php" class="dropdown-toggle">Quản lý</a> </div>
        <div class="dropdown">
            <a href="reply.php" class="dropdown-toggle">Hòm thư</a> </div>
        <div class="dropdown">
            <a href="#" class="dropdown-toggle">Contact</a> </div>
      </div>
    <div class="auth">
        <?php if (isset($_SESSION['user'])): ?>
            <span><?php echo htmlspecialchars($_SESSION['user']); ?></span>
            <a href="../login/logout.php?redirect=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>">Đăng xuất</a> <?php else: ?>
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
                    <li class="inbox-item <?php echo ($feedback['id'] == 1) ? 'active' : ''; ?>"
                        data-id="<?php echo $feedback['id']; ?>"
                        data-sender="<?php echo htmlspecialchars($feedback['sender']); ?>"
                        data-email="<?php echo htmlspecialchars($feedback['email']); ?>"
                        data-subject="<?php echo htmlspecialchars($feedback['subject']); ?>"
                        data-message="<?php echo htmlspecialchars($feedback['message']); ?>"
                        data-date="<?php echo htmlspecialchars($feedback['date']); ?>">
                        <div class="item-checkbox"><input type="checkbox"></div>
                        <div class="item-content">
                            <div class="item-sender"><?php echo htmlspecialchars($feedback['sender']); ?></div>
                            <div class="item-subject"><?php echo htmlspecialchars($feedback['subject']); ?></div>
                            <div class="item-excerpt"><?php echo substr(htmlspecialchars($feedback['message']), 0, 50); ?>...</div>
                        </div>
                        <div class="item-meta">
                            <span class="item-date"><?php echo date('M d, Y', strtotime($feedback['date'])); ?></span>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>Không có phản hồi nào.</li>
            <?php endif; ?>
        </ul>
    </aside>

    <section class="main-content-panel">
        <div class="content-panel-header">
            <div class="header-left-controls">
                <i class="ri-checkbox-line icon-button"></i>
                <i class="ri-star-line icon-button"></i>
                <i class="ri-archive-line icon-button"></i>
                <i class="ri-delete-bin-line icon-button"></i>
            </div>
            <div class="header-right-controls">
                <i class="ri-share-line icon-button"></i>
                <i class="ri-printer-line icon-button"></i>
                <i class="ri-download-line icon-button"></i>
                <i class="ri-arrow-go-back-line icon-button"></i>
                <i class="ri-settings-4-line icon-button"></i>
            </div>
        </div>

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

<div id="composeModal" class="compose-modal">
    <div class="compose-modal-content">
        <div class="compose-modal-header">
            <span class="compose-modal-title">Compose Message</span>
            <span class="close-compose-modal close-button">&times;</span>
        </div>
        <form id="composeForm" method="POST" action="send_reply.php">
            <div class="form-group">
                <label for="composeCourse">Course:</label>
                <input type="text" id="composeCourse" name="compose_course" value="Kỹ thuật phần mềm-1-3-24(COUR01.LT2)" readonly>
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
    </div>
</div>

<script src="admin2.js"></script>
</body>
</html>
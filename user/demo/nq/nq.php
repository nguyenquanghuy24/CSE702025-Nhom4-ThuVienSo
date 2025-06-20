<?php
session_start();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nội quy Thư viện - Phenikaa</title>
    <link rel="stylesheet" href="nq.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
                    <a href="nq.php">Nội Quy</a>
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
                <a href="#contact-section" class="dropdown-toggle">Contact</a>
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

    <main class="rules-section">
        <div class="rules-container">
            <h1>NỘI QUY THƯ VIỆN TRƯỜNG ĐẠI HỌC PHENIKAA</h1>
            <p class="subtitle">(Ban hành kèm theo Quyết định số 655/QĐ-ĐHP-ĐT&QLSV ngày 25 tháng 03 năm 2021)</p>

            <article class="rule-article">
                <h3>Điều 1: Đối tượng sử dụng</h3>
                <ul>
                    <li>Cán bộ, giảng viên, sinh viên, học viên các hệ đào tạo của Trường Đại học Phenikaa (sau đây gọi tắt là Trường).</li>
                    <li>Đối tượng thuộc diện liên kết của Thư viện: bạn đọc không thuộc Trường, có nhu cầu sử dụng Thư viện phải có Giấy giới thiệu của cơ quan chủ quản, kèm theo Chứng minh thư nhân dân/Căn cước công dân, nộp phí dịch vụ theo quy định của Thư viện.</li>
                    <li>Người sử dụng được cấp quyền sử dụng Thư viện khi có đủ các điều kiện sau:
                        <ul>
                            <li>Có thẻ cán bộ, giảng viên, sinh viên, học viên của Trường hoặc thẻ sử dụng Thư viện đối với người sử dụng diện liên kết của Thư viện;</li>
                            <li>Tham gia và hoàn thành các lớp tập huấn sử dụng Thư viện và nộp kinh phí đặt cọc sử dụng Thư viện (không áp dụng đối với cán bộ, giảng viên của Trường).</li>
                        </ul>
                    </li>
                </ul>
            </article>

            <article class="rule-article">
                <h3>Điều 2: Trách nhiệm của người sử dụng Thư viện</h3>
                <ul>
                    <li>Không sử dụng thẻ của người khác và không cho người khác mượn thẻ. Khi mất thẻ, phải báo ngay cho Thư viện để làm thủ tục khóa tài khoản.</li>
                    <li>Xuất trình thẻ và gửi đồ vào nơi quy định; Tự bảo quản tư trang và các vật dụng cá nhân có giá trị khác.</li>
                    <li>Giữ gìn, bảo quản tài nguyên thông tin, trang thiết bị, cơ sở vật chất của Thư viện trong quá trình sử dụng.</li>
                    <li>Giữ trật tự, an ninh, an toàn cháy nổ và vệ sinh môi trường; không hút thuốc, không mang những vật dụng dễ cháy, nổ và đồ ăn uống (ngoài nước uống đóng chai) vào Thư viện.</li>
                    <li>Chụp ảnh, quay phim trong tòa nhà Thư viện phải được sự đồng ý của Trường.</li>
                </ul>
            </article>

            <article class="rule-article">
                <h3>Điều 3: Sử dụng tài liệu Thư viện</h3>
                <p>Thời hạn mượn tài liệu tuỳ thuộc vào từng đối tượng bạn đọc và từng loại tài liệu. Hết thời hạn, nếu muốn mượn tiếp bạn đọc phải mang tài liệu đến xin gia hạn và chỉ được mượn tài liệu mới khi đã trả tài liệu cũ.</p>
                
                <h4>1. Đối với bạn đọc là sinh viên:</h4>
                <ul>
                    <li>Người sử dụng được mượn về nhà tối đa 05 tài liệu/1 lần.</li>
                    <li>Giáo trình: số lượng tối đa 10 cuốn, mượn 150 ngày/tài liệu (1 học kỳ), không được gia hạn.</li>
                    <li>Tài liệu tham khảo chuyên ngành: số lượng tối đa 5 cuốn, mượn 90 ngày/tài liệu, được gia hạn tối đa 2 lần (3 ngày/lần).</li>
                </ul>

                <h4>2. Đối với cán bộ, giảng viên:</h4>
                 <ul>
                    <li>Giáo trình và tài liệu tham khảo chuyên ngành thuộc bộ môn giảng dạy: số lượng tối đa 10 cuốn (giáo trình) và 5 cuốn (tham khảo), được mượn không giới hạn thời gian.</li>
                    <li>Sách tham khảo thông thường: số lượng tối đa 5 cuốn, mượn 15 ngày, được gia hạn 2 lần (3 ngày/lần).</li>
                </ul>
            </article>
            
            <article class="rule-article">
                <h3>Điều 4: Đối với phòng đọc sách, luận văn/ kho mở</h3>
                <p>Bạn đọc tự chọn tài liệu trên giá sách theo bảng chỉ dẫn, không tráo đổi vị trí. Được lấy không quá 02 cuốn cho 1 lần sử dụng. Đọc xong, bạn đọc xếp tài liệu về vị trí quy định.</p>
            </article>

            <article class="rule-article">
                <h3>Điều 11: Các chính sách xử lý vi phạm nội quy</h3>
                 <p>Người sử dụng vi phạm các quy định, tùy theo mức độ vi phạm mà áp dụng những hình thức xử lý như sau:</p>
                <ul>
                    <li>Khóa thẻ tạm thời hoặc đình chỉ quyền sử dụng Thư viện.</li>
                    <li>Xử phạt hành chính.</li>
                    <li>Bồi thường thiệt hại bằng hiện vật hoặc bằng tiền theo quy định của Trường.</li>
                    <li>Trường hợp vi phạm nghiêm trọng có thể bị kỷ luật và truy cứu trách nhiệm hình sự.</li>
                </ul>
            </article>

             <article class="rule-article">
                <h3>Điều 12: Bảo quản tài liệu và đóng góp ý kiến</h3>
                <ul>
                    <li>Tuyệt đối không mang tài liệu ra khỏi phòng đọc khi chưa được phép, không làm hư hỏng, tráo đổi, cắt xén tài liệu.</li>
                    <li>Bạn đọc phải nghiêm chỉnh chấp hành những quy định trên. Mọi vi phạm sẽ bị xử lý kỷ luật.</li>
                    <li>Hoan nghênh bạn đọc thực hiện tốt nội quy và phát hiện vi phạm.</li>
                    <li>Mọi ý kiến đóng góp xin gửi vào "Hòm thư góp ý" hoặc email: <a href="mailto:elib@phenikaa-uni.edu.vn">elib@phenikaa-uni.edu.vn</a> (Thư góp ý cần ghi rõ thông tin cá nhân).</li>
                </ul>
            </article>
        </div>
    </main>

    <footer id="contact-section" class="footer">
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

    <script src="nq.js"></script>
</body>
</html>
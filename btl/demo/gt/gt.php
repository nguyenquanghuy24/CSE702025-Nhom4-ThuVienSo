<?php
session_start();
include("../login/connect.php");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giới thiệu - Thư viện Phenikaa</title>
    <link rel="stylesheet" href="gt.css">
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
                    <a href="gt.php">Giới thiệu</a>
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

    <main class="intro-section">
        <div class="intro-container">
            <h1>Giới thiệu Trung tâm Thông tin Thư viện</h1>
            
            <section class="intro-block">
                <p>Trung tâm Thông tin Thư viện Trường Đại học Phenikaa chính thức được thành lập từ ngày 18/9/2020 theo Quyết định số 18/QĐ-ĐHP-HĐT trên cơ sở tách bộ phận Quản lý Thư viện từ Phòng Đào tạo và Quản lý sinh viên.</p>
                <p>Chức năng nhiệm vụ của Trung tâm Thông tin Thư viện được quy định tại Quy định chức năng nhiệm vụ Phòng/Ban/Khoa/Viện/Trung tâm trực thuộc Trường Đại học Phenikaa.</p>
            </section>

            <section class="mission-statement">
                <p><strong>TRUNG TÂM THÔNG TIN THƯ VIỆN PHENIKAA UNI</strong> là nơi hỗ trợ học tập / nghiên cứu / đổi mới / khởi nghiệp (Learn - Study / Research / Innovate / StartUp); Phát sinh ý tưởng mới (Ideas); Giao lưu, hợp tác, kết nối, chia sẻ học thuật (Collaborate – Connect - Sharing); Là nơi truyền cảm hứng nghiên cứu, sáng tạo (Inspire, Create).</p>
            </section>

            <section class="intro-block">
                <h2>Mô hình Learning Commons</h2>
                <p>Trung tâm TTTV Phenikaa Uni được định hướng tới mô hình Learning Commons. Đây được định nghĩa như là một không gian giáo dục, tương tự như thư viện và lớp học trong đó có các không gian và hạ tầng thiết bị phục vụ việc đọc, nghiên cứu, tự học, làm việc nhóm, sáng tạo, gặp gỡ, hay đơn thuần chỉ là thư giãn… Learning commons là sự kết hợp giữa thư viện với công nghệ thông tin và các dịch vụ hỗ trợ học tập nhằm cung cấp những dịch vụ tốt nhất đáp ứng được tối đa các nhu cầu của người dùng. Áp dụng mô hình này, người dùng thư viện có thể phát huy tối đa những không gian chung cho phép tự tra cứu, học, đọc tài liệu hoặc nghiên cứu, thảo luận về các vấn đề quan tâm, hoặc đơn giản chỉ là nghỉ ngơi, thư giãn.</p>
            </section>

            <section class="intro-block">
                <h2>Nguồn tài nguyên và Công nghệ hiện đại</h2>
                <p>Trung tâm Thông tin – Thư viện không ngừng được nâng cấp, đảm bảo đáp ứng nhu cầu sử dung, khai thác thông tin và tài liệu nghiên cứu, giảng dạy và học tập. Ngoài các đầu sách được bổ sung hằng năm, hệ thống thư viện số được đẩy mạnh với nhiều phần mềm bản quyền, cổng thông tin và các cơ sở dữ liệu liên kết trong và ngoài nước.</p>
                <ul>
                    <li><strong>Phần mềm Quản trị thư viện:</strong> Duy trì và phát triển các phần mềm KOHA (Thư viện truyền thống), Dspace (Thư viện số), Vufind (Tìm kiếm tập trung), và Drupal (Cổng thông tin).</li>
                    <li><strong>Công nghệ RFID:</strong> Ứng dụng trên 100% tài liệu in và vận hành lưu thông, bao gồm cổng an ninh, máy kiểm kê và trạm lập trình RFID.</li>
                    <li><strong>Thiết bị Self-Check:</strong> Máy mượn - trả sách tự động được trang bị để nâng cao trải nghiệm thư viện thông minh.</li>
                    <li><strong>Phần mềm chống đạo văn Turnitin:</strong> Tích hợp vào hệ thống dạy học trực tuyến Canvas để đảm bảo tính liêm chính trong học thuật.</li>
                    <li><strong>Kết nối hệ thống (API):</strong> Phần mềm KOHA và Dspace đã kết nối với các phần mềm trong hệ thống ERP của nhà trường, giúp đồng bộ dữ liệu liên tục 24/24.</li>
                    <li><strong>Ứng dụng di động PULIC:</strong> Hơn 17.000 lượt cài đặt (tính đến tháng 7/2024) trên IOS và Android, giúp tăng cường khả năng tiếp cận tài liệu mọi lúc mọi nơi.</li>
                    <li><strong>Tương tác trực tuyến:</strong> Nhúng Messenger Chatbot lên toàn bộ hệ thống website của Trung tâm để hỗ trợ bạn đọc nhanh chóng và thuận tiện.</li>
                </ul>
            </section>
            
            <section class="intro-block">
                <h2>Không gian học tập và tiện ích</h2>
                <p>Không gian đọc sách và tự học được thiết kế trên 3 tầng với tổng diện tích ~4200m² hiện đại, đa dạng và nhiều tiện ích.</p>
                 <ul>
                    <li><strong>Địa điểm:</strong> Tầng 4, 5, 6 Tòa A10</li>
                    <li><strong>Tầng 4:</strong> Cửa đón tiếp, không gian đọc sách, học nhóm, sân khấu, khu vực đa phương tiện (sách từ DDC 620 - 999).</li>
                    <li><strong>Tầng 5:</strong> Phòng học nhóm, không gian đọc sách, phòng đọc khóa luận/luận văn (sách từ DDC 000 - 619).</li>
                    <li><strong>Tầng 6:</strong> Phòng học nhóm, không gian tự học, khu làm việc của Quản lý Thư viện.</li>
                </ul>
                <p>Ngoài ra, không gian đọc sách mở với diện tích gần 3.200m² được thiết kế dọc các dãy hành lang, cho phép bạn đọc học tập trong một không gian tràn ngập ánh sáng và hòa mình cùng thiên nhiên.</p>
            </section>

             <section class="intro-block">
                <h2>Giờ mở cửa và các liên kết</h2>
                <h4>Giờ mở cửa</h4>
                <ul>
                    <li><strong>Phòng đọc:</strong> Thứ 2 – Thứ 6 (Sáng: 8h-12h; Chiều: 13h-17h)</li>
                    <li><strong>Phòng tự học (Tầng 6 A10):</strong> Mở cửa từ 06h00 tới 22h30 hàng ngày</li>
                </ul>

                <h4>Các đường link truy cập</h4>
                <ul class="link-list">
                    <li><a href="http://library.phenikaa-uni.edu.vn" target="_blank">Cổng thông tin thư viện</a></li>
                    <li><a href="http://elib.phenikaa-uni.edu.vn" target="_blank">Thư viện điện tử</a></li>
                    <li><a href="http://dlib.phenikaa-uni.edu.vn" target="_blank">Thư viện số</a></li>
                    <li><a href="https://library.phenikaa-uni.edu.vn/node/383" target="_blank">Ứng dụng di động Thư viện PU-LIC</a></li>
                </ul>
                
                 <h4>Một số liên kết quan trọng khác</h4>
                <ul class="link-list">
                    <li><a href="https://library.phenikaa-uni.edu.vn/node/156" target="_blank">Nội quy thư viện</a></li>
                    <li><a href="https://library.phenikaa-uni.edu.vn/node/191" target="_blank">Hướng dẫn sử dụng Thư viện</a></li>
                    <li><a href="https://www.facebook.com/trungtamthongtinthuvienPhenikaaUni" target="_blank">Fanpage PU LIC</a></li>
                </ul>
            </section>
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


    <script src="gt.js"></script>
</body>
</html>
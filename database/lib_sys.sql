-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th6 21, 2025 lúc 09:02 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `lib_sys`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin_tbl`
--

CREATE TABLE `admin_tbl` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `admin_tbl`
--

INSERT INTO `admin_tbl` (`admin_id`, `username`, `password`, `email`, `full_name`) VALUES
(1, 'admin', '123', 'admin.tung@phenikaa-uni.edu.vn', 'Nguyễn Minh Tùng ');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `book_tbl`
--

CREATE TABLE `book_tbl` (
  `id` int(11) NOT NULL,
  `maSach` varchar(20) NOT NULL,
  `tieuDe` varchar(255) NOT NULL,
  `tacGia` varchar(100) DEFAULT NULL,
  `theLoai` varchar(100) DEFAULT NULL,
  `namXuatBan` int(11) DEFAULT NULL,
  `ngonNgu` varchar(50) DEFAULT NULL,
  `soLuong` int(11) DEFAULT 1,
  `trangThai` varchar(50) DEFAULT 'Có sẵn',
  `moTa` text DEFAULT NULL,
  `anhBia` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `book_tbl`
--

INSERT INTO `book_tbl` (`id`, `maSach`, `tieuDe`, `tacGia`, `theLoai`, `namXuatBan`, `ngonNgu`, `soLuong`, `trangThai`, `moTa`, `anhBia`) VALUES
(1, 'EN001', 'Algorithms (4th Edition)', 'Robert Sedgewick, Kevin Wayne', 'Công nghệ thông tin', 2011, 'Tiếng Anh', 1, 'Có sẵn', 'Cuốn sách trình bày toàn diện về các thuật toán cổ điển và cấu trúc dữ liệu, bao gồm phân tích hiệu năng và cách cài đặt bằng Java. Rất phù hợp với sinh viên ngành Khoa học Máy tính.', 'image/1.jpg'),
(2, 'EN002', 'Agile Software Development, Principles, Patterns, and Practices', 'Robert Martin', 'Công nghệ thông tin', 2002, 'Tiếng Anh', 4, 'Có sẵn', 'Cuốn sách trình bày chi tiết các nguyên lý phát triển phần mềm linh hoạt (Agile), các mẫu thiết kế (design patterns) và thực hành lập trình hiệu quả, phù hợp cho lập trình viên và kỹ sư phần mềm.', 'image/2.jpg'),
(3, 'VN001', 'Giáo trình lập trình Android', 'Lê Hoàng Sơn, Nguyễn Thọ Thông', 'Công nghệ thông tin', 2020, 'Tiếng Việt, Tiếng Anh', 3, 'Có sẵn', 'Mục tiêu chính của cuốn sách này là giúp bạn đọc nhanh chóng nắm bắt được các thành phần cốt yếu trong Android và có thể lập trình được các ứng dụng cơ bản một cách hiệu quả. Đây cũng sẽ là cuốn giáo trình hữu ích cho sinh viên các trường đại học kỹ thuật chuyên về công nghệ thông tin. Để có thể đọc một cách hiệu quả nội dung của cuốn sách này, bạn đọc cần nắm được các kiến thức nền tảng về lập trình hướng đối tượng trong Java. Trong mỗi chương, chúng tôi cũng trình bày các đoạn mã nguồn đầy đủ để bạn đọc tiện theo dõi và thực hành.', 'image/3.jpg'),
(4, 'EN003', 'Microsystem Design', 'Stephen D. Senturia', 'Công nghệ thông tin\r\n', 2000, 'Tiếng Anh', 3, 'Có sẵn', 'Giới thiệu các nguyên lý cơ bản và liên ngành trong thiết kế hệ thống vi cơ điện tử (MEMS) thông qua các tình huống nghiên cứu thực tế.', 'image/4.jpg'),
(5, 'EN004', 'Computing and Technology Ethics: Engaging through Science Fiction', 'Emanuelle Burton', 'Trí tuệ nhân tạo', 2023, 'Tiếng Anh', 3, 'Có sẵn', 'Giới thiệu các khung đạo đức và các vấn đề hiện đại về đạo đức công nghệ như AI, quyền riêng tư, và điện toán thông qua khoa học viễn tưởng.', 'image/5.jpg'),
(6, 'EN005', 'Deep Learning in Computer Vision: Principles and Applications', 'Mahmoud Hassaballah, Ali Ismail Awad', 'Trí tuệ nhân tạo', 2020, 'Tiếng Anh', 4, 'Có sẵn', 'Giới thiệu các nguyên lý và ứng dụng của deep learning trong thị giác máy tính như nhận diện khuôn mặt, phát hiện cháy, và phân đoạn ảnh y tế.', 'image/6.jpg'),
(7, 'VN004', 'Giáo trình SQL Server 2000', 'Nguyễn Thiên Bằng, Hoàng Đức Hải, Phương Lan', 'Công nghệ thông tin', 2005, 'Tiếng Việt, Tiếng Anh', 5, 'Có sẵn', 'Cung cấp kiến thức về cài đặt, quản trị và truy vấn SQL Server 2000 cho người học và lập trình viên.', 'image/7.jpg'),
(8, 'VN005', 'Giáo Trình Toán Học Cao Cấp – Tập 1', 'Nguyễn Đình Trí', 'Toán học', 2007, 'Tiếng Việt', 4, 'Có sẵn', 'Trình bày tập hợp, ánh xạ, số thực - phức, giới hạn, đạo hàm, định thức, ma trận và không gian vectơ.', 'image/8.jpg'),
(9, 'VN006', 'Giáo Trình Toán Học Cao Cấp – Tập 2', 'Nguyễn Đình Trí', 'Toán học', 2007, 'Tiếng Việt', 4, 'Có sẵn', 'Hàm nhiều biến, tích phân kép, đường, chuỗi và phương trình vi phân.', 'image/9.jpg'),
(10, 'VN007', 'Giáo trình hệ điều hành', 'Từ Minh Phương', 'Công nghệ thông tin', 2016, 'Tiếng Việt, Tiếng Anh', 2, 'Có sẵn', 'Tổng quan hệ điều hành, tiến trình, tập tin và quản lý hệ thống.', 'image/10.jpg'),
(11, 'VN011', 'Giáo Trình Giải Tích I', 'Ngô Văn Ban', 'Toán học', 2021, 'Tiếng Việt', 5, 'Có sẵn', 'Cuốn sách Giải Tích I cung cấp các kiến thức cơ bản và nền tảng nhất của giải tích, bao gồm giới hạn, đạo hàm, và tích phân.', 'assets/giaitich1.jpg'),
(12, 'VN012', 'Giải Tích II', 'Trần Thị Kim Oanh, Phan Xuân Thành, Lê Chí Ngọc, Nguyễn Thị Thu Hương', 'Toán học', 2022, 'Tiếng Việt', 8, 'Có sẵn', 'Tiếp nối Giải Tích I, cuốn sách này đi sâu vào các chủ đề nâng cao như giải tích hàm nhiều biến, tích phân bội, và phương trình vi phân.', 'assets/giaitich2.jpg'),
(13, 'VN013', 'Giải Tích III', 'Nguyễn Thiệu Huy, Bùi Xuân Diệu, Đào Tuấn Anh', 'Toán học', 2023, 'Tiếng Việt', 6, 'Có sẵn', 'Cuốn sách cuối cùng trong bộ ba, tập trung vào các khái niệm về chuỗi số, chuỗi hàm, và các phép biến đổi quan trọng như Fourier và Laplace.', 'assets/giaitich3.jpg'),
(18, '333', 'Toán và ứng dụng', 'Nguyễn Văn A', 'Toán', 2023, 'Tiếng Việt', 1, 'Có sẵn', 'toan', 'assets/no-image.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `borrow_tbl`
--

CREATE TABLE `borrow_tbl` (
  `borrow_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ngayMuon` datetime DEFAULT NULL,
  `ngayHetHan` datetime DEFAULT NULL,
  `tinhTrang` varchar(50) DEFAULT NULL,
  `book_id` int(11) DEFAULT NULL,
  `maMuon` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `borrow_tbl`
--

INSERT INTO `borrow_tbl` (`borrow_id`, `user_id`, `ngayMuon`, `ngayHetHan`, `tinhTrang`, `book_id`, `maMuon`) VALUES
(49, 7, '2025-06-22 00:33:23', '2025-07-22 00:33:23', 'Đang mượn', 11, '267EC'),
(50, 7, '2025-06-22 00:44:27', '2025-07-22 00:44:27', 'Đang mượn', 6, 'M175052786'),
(51, 7, '2025-06-22 00:44:32', '2025-07-22 00:44:32', 'Từ chối', 13, 'E9433');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reply_tbl`
--

CREATE TABLE `reply_tbl` (
  `reply_id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `reply_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `reply_tbl`
--

INSERT INTO `reply_tbl` (`reply_id`, `ticket_id`, `admin_id`, `subject`, `message`, `reply_date`) VALUES
(4, 4, 1, 'Re: Về sách Giải tích I bị hỏng', 'Đã nhận phản hồi!', '2025-06-21 17:56:16');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `request_tbl`
--

CREATE TABLE `request_tbl` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `maMuon` varchar(10) NOT NULL,
  `ngayYeuCau` datetime DEFAULT current_timestamp(),
  `trangThai` enum('Chờ duyệt','Đã duyệt','Từ chối','Hủy') DEFAULT 'Chờ duyệt',
  `ghiChu` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL,
  `user` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `hoTen` varchar(100) NOT NULL,
  `maSV` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `user`, `pass`, `email`, `hoTen`, `maSV`) VALUES
(7, 'tung', '123', 'tung@gmail.com', 'Nguyen Minh Tung', '001');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ticket_tbl`
--

CREATE TABLE `ticket_tbl` (
  `ticket_id` int(11) NOT NULL,
  `hoTen` varchar(100) NOT NULL,
  `maSV` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `ticket_tbl`
--

INSERT INTO `ticket_tbl` (`ticket_id`, `hoTen`, `maSV`, `email`, `subject`, `message`, `created_at`, `user_id`) VALUES
(4, 'Nguyen Quang Huy', '002', 'nghuy@gmail.com', 'Về sách Giải tích I bị hỏng', 'Kính gửi thư viện, tôi muốn báo cáo rằng cuốn sách Giải tích I tôi vừa mượn có một số trang bị rách và không đọc được. Mong thư viện có thể hỗ trợ đổi sách hoặc có biện pháp xử lý. Cảm ơn.', '2025-06-21 17:53:43', NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admin_tbl`
--
ALTER TABLE `admin_tbl`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Chỉ mục cho bảng `book_tbl`
--
ALTER TABLE `book_tbl`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `maSach` (`maSach`);

--
-- Chỉ mục cho bảng `borrow_tbl`
--
ALTER TABLE `borrow_tbl`
  ADD PRIMARY KEY (`borrow_id`),
  ADD UNIQUE KEY `maMuon` (`maMuon`),
  ADD KEY `fk_borrow_user` (`user_id`),
  ADD KEY `fk_book` (`book_id`);

--
-- Chỉ mục cho bảng `reply_tbl`
--
ALTER TABLE `reply_tbl`
  ADD PRIMARY KEY (`reply_id`),
  ADD KEY `fk_reply_admin` (`admin_id`),
  ADD KEY `fk_reply_ticket` (`ticket_id`);

--
-- Chỉ mục cho bảng `request_tbl`
--
ALTER TABLE `request_tbl`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Chỉ mục cho bảng `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `ticket_tbl`
--
ALTER TABLE `ticket_tbl`
  ADD PRIMARY KEY (`ticket_id`),
  ADD KEY `fk_ticket_user` (`user_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admin_tbl`
--
ALTER TABLE `admin_tbl`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `book_tbl`
--
ALTER TABLE `book_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `borrow_tbl`
--
ALTER TABLE `borrow_tbl`
  MODIFY `borrow_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT cho bảng `reply_tbl`
--
ALTER TABLE `reply_tbl`
  MODIFY `reply_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `request_tbl`
--
ALTER TABLE `request_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `ticket_tbl`
--
ALTER TABLE `ticket_tbl`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `borrow_tbl`
--
ALTER TABLE `borrow_tbl`
  ADD CONSTRAINT `fk_borrow_book` FOREIGN KEY (`book_id`) REFERENCES `book_tbl` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_borrow_user` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `reply_tbl`
--
ALTER TABLE `reply_tbl`
  ADD CONSTRAINT `fk_reply_admin` FOREIGN KEY (`admin_id`) REFERENCES `admin_tbl` (`admin_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_reply_ticket` FOREIGN KEY (`ticket_id`) REFERENCES `ticket_tbl` (`ticket_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reply_tbl_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admin_tbl` (`admin_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reply_tbl_ibfk_2` FOREIGN KEY (`ticket_id`) REFERENCES `ticket_tbl` (`ticket_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `request_tbl`
--
ALTER TABLE `request_tbl`
  ADD CONSTRAINT `request_tbl_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`id`),
  ADD CONSTRAINT `request_tbl_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `book_tbl` (`id`);

--
-- Các ràng buộc cho bảng `ticket_tbl`
--
ALTER TABLE `ticket_tbl`
  ADD CONSTRAINT `fk_ticket_user` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

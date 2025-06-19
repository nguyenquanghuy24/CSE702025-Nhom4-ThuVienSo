-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 19, 2025 at 09:45 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lib_sys`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_tbl`
--

CREATE TABLE `admin_tbl` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_tbl`
--

INSERT INTO `admin_tbl` (`admin_id`, `username`, `password`, `email`, `full_name`) VALUES
(2, 'admin', '123', 'admin.tung@phenikaa-uni.edu.vn', 'Nguyễn Minh Tùng ');

-- --------------------------------------------------------

--
-- Table structure for table `book_tbl`
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
-- Dumping data for table `book_tbl`
--

INSERT INTO `book_tbl` (`id`, `maSach`, `tieuDe`, `tacGia`, `theLoai`, `namXuatBan`, `ngonNgu`, `soLuong`, `trangThai`, `moTa`, `anhBia`) VALUES
(1, 'EN001', 'Algorithms (4th Edition)', 'Robert Sedgewick, Kevin Wayne', 'Công nghệ thông tin', 2011, 'Tiếng Anh', 3, 'Có sẵn', 'Cuốn sách trình bày toàn diện về các thuật toán cổ điển và cấu trúc dữ liệu, bao gồm phân tích hiệu năng và cách cài đặt bằng Java. Rất phù hợp với sinh viên ngành Khoa học Máy tính.', 'image/1.jpg'),
(2, 'EN002', 'Agile Software Development, Principles, Patterns, and Practices', 'Robert Martin', 'Công nghệ thông tin', 2002, 'Tiếng Anh', 4, 'Có sẵn', 'Cuốn sách trình bày chi tiết các nguyên lý phát triển phần mềm linh hoạt (Agile), các mẫu thiết kế (design patterns) và thực hành lập trình hiệu quả, phù hợp cho lập trình viên và kỹ sư phần mềm.', 'image/2.jpg'),
(3, 'VN001', 'Giáo trình lập trình Android', 'Lê Hoàng Sơn, Nguyễn Thọ Thông', 'Công nghệ thông tin', 2020, 'Tiếng Việt, Tiếng Anh', 3, 'Có sẵn', 'Mục tiêu chính của cuốn sách này là giúp bạn đọc nhanh chóng nắm bắt được các thành phần cốt yếu trong Android và có thể lập trình được các ứng dụng cơ bản một cách hiệu quả. Đây cũng sẽ là cuốn giáo trình hữu ích cho sinh viên các trường đại học kỹ thuật chuyên về công nghệ thông tin. Để có thể đọc một cách hiệu quả nội dung của cuốn sách này, bạn đọc cần nắm được các kiến thức nền tảng về lập trình hướng đối tượng trong Java. Trong mỗi chương, chúng tôi cũng trình bày các đoạn mã nguồn đầy đủ để bạn đọc tiện theo dõi và thực hành.', 'image/3.jpg'),
(4, 'EN003', 'Microsystem Design', 'Stephen D. Senturia', 'Công nghệ thông tin\r\n', 2000, 'Tiếng Anh', 3, 'Có sẵn', 'Giới thiệu các nguyên lý cơ bản và liên ngành trong thiết kế hệ thống vi cơ điện tử (MEMS) thông qua các tình huống nghiên cứu thực tế.', 'image/4.jpg'),
(5, 'EN004', 'Computing and Technology Ethics: Engaging through Science Fiction', 'Emanuelle Burton', 'Trí tuệ nhân tạo', 2023, 'Tiếng Anh', 4, 'Có sẵn', 'Giới thiệu các khung đạo đức và các vấn đề hiện đại về đạo đức công nghệ như AI, quyền riêng tư, và điện toán thông qua khoa học viễn tưởng.', 'image/5.jpg'),
(6, 'EN005', 'Deep Learning in Computer Vision: Principles and Applications', 'Mahmoud Hassaballah, Ali Ismail Awad', 'Trí tuệ nhân tạo', 2020, 'Tiếng Anh', 5, 'Có sẵn', 'Giới thiệu các nguyên lý và ứng dụng của deep learning trong thị giác máy tính như nhận diện khuôn mặt, phát hiện cháy, và phân đoạn ảnh y tế.', 'image/6.jpg'),
(7, 'VN004', 'Giáo trình SQL Server 2000', 'Nguyễn Thiên Bằng, Hoàng Đức Hải, Phương Lan', 'Công nghệ thông tin', 2005, 'Tiếng Việt, Tiếng Anh', 5, 'Có sẵn', 'Cung cấp kiến thức về cài đặt, quản trị và truy vấn SQL Server 2000 cho người học và lập trình viên.', 'image/7.jpg'),
(8, 'VN005', 'Giáo Trình Toán Học Cao Cấp – Tập 1', 'Nguyễn Đình Trí', 'Toán học', 2007, 'Tiếng Việt', 4, 'Có sẵn', 'Trình bày tập hợp, ánh xạ, số thực - phức, giới hạn, đạo hàm, định thức, ma trận và không gian vectơ.', 'image/8.jpg'),
(9, 'VN006', 'Giáo Trình Toán Học Cao Cấp – Tập 2', 'Nguyễn Đình Trí', 'Toán học', 2007, 'Tiếng Việt', 4, 'Có sẵn', 'Hàm nhiều biến, tích phân kép, đường, chuỗi và phương trình vi phân.', 'image/9.jpg'),
(10, 'VN007', 'Giáo trình hệ điều hành', 'Từ Minh Phương', 'Công nghệ thông tin', 2016, 'Tiếng Việt, Tiếng Anh', 2, 'Có sẵn', 'Tổng quan hệ điều hành, tiến trình, tập tin và quản lý hệ thống.', 'image/10.jpg'),
(11, 'VN011', 'Giáo Trình Giải Tích I', 'Ngô Văn Ban', 'Toán học', 2021, 'Tiếng Việt', 5, 'Có sẵn', 'Cuốn sách Giải Tích I cung cấp các kiến thức cơ bản và nền tảng nhất của giải tích, bao gồm giới hạn, đạo hàm, và tích phân.', 'assets/giaitich1.jpg'),
(12, 'VN012', 'Giải Tích II', 'Trần Thị Kim Oanh, Phan Xuân Thành, Lê Chí Ngọc, Nguyễn Thị Thu Hương', 'Toán học', 2022, 'Tiếng Việt', 5, 'Có sẵn', 'Tiếp nối Giải Tích I, cuốn sách này đi sâu vào các chủ đề nâng cao như giải tích hàm nhiều biến, tích phân bội, và phương trình vi phân.', 'assets/giaitich2.jpg'),
(13, 'VN013', 'Giải Tích III', 'Nguyễn Thiệu Huy, Bùi Xuân Diệu, Đào Tuấn Anh', 'Toán học', 2023, 'Tiếng Việt', 5, 'Có sẵn', 'Cuốn sách cuối cùng trong bộ ba, tập trung vào các khái niệm về chuỗi số, chuỗi hàm, và các phép biến đổi quan trọng như Fourier và Laplace.', 'assets/giaitich3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `borrow_tbl`
--

CREATE TABLE `borrow_tbl` (
  `borrow_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ngayMuon` date DEFAULT NULL,
  `ngayHetHan` date DEFAULT NULL,
  `tinhTrang` varchar(50) DEFAULT NULL,
  `book_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrow_tbl`
--

INSERT INTO `borrow_tbl` (`borrow_id`, `user_id`, `ngayMuon`, `ngayHetHan`, `tinhTrang`, `book_id`) VALUES
(23, 1, '2025-06-18', NULL, NULL, 10),
(24, 1, '2025-06-20', '2025-07-20', 'Đã trả', 8),
(25, 1, '2025-06-20', '2025-07-20', 'Đã trả', 11);

-- --------------------------------------------------------

--
-- Table structure for table `reply_tbl`
--

CREATE TABLE `reply_tbl` (
  `reply_id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `reply_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
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
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `user`, `pass`, `email`, `hoTen`, `maSV`) VALUES
(1, 'tung', '123', 'ngtung@gmail.com', 'Nguyen Minh Tung', '1'),
(6, 'huy', '123', 'nghuy@gmail.com', 'Nguyen Quang Huy', '2');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_tbl`
--

CREATE TABLE `ticket_tbl` (
  `ticket_id` int(11) NOT NULL,
  `hoTen` varchar(100) NOT NULL,
  `maSV` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ticket_tbl`
--

INSERT INTO `ticket_tbl` (`ticket_id`, `hoTen`, `maSV`, `email`, `subject`, `message`) VALUES
(1, 'Nguyen Quang Huy', '2', 'nghuy@gmail.com', 'Khong su dung duoc sach', 'Hom nay khi truy cap vao thi toi khong the mo duoc sach de xem ');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_tbl`
--
ALTER TABLE `admin_tbl`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `book_tbl`
--
ALTER TABLE `book_tbl`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `maSach` (`maSach`);

--
-- Indexes for table `borrow_tbl`
--
ALTER TABLE `borrow_tbl`
  ADD PRIMARY KEY (`borrow_id`),
  ADD KEY `fk_borrow_user` (`user_id`),
  ADD KEY `fk_book` (`book_id`);

--
-- Indexes for table `reply_tbl`
--
ALTER TABLE `reply_tbl`
  ADD PRIMARY KEY (`reply_id`),
  ADD KEY `fk_reply_admin` (`admin_id`),
  ADD KEY `fk_reply_ticket` (`ticket_id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket_tbl`
--
ALTER TABLE `ticket_tbl`
  ADD PRIMARY KEY (`ticket_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_tbl`
--
ALTER TABLE `admin_tbl`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `book_tbl`
--
ALTER TABLE `book_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `borrow_tbl`
--
ALTER TABLE `borrow_tbl`
  MODIFY `borrow_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `reply_tbl`
--
ALTER TABLE `reply_tbl`
  MODIFY `reply_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ticket_tbl`
--
ALTER TABLE `ticket_tbl`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `borrow_tbl`
--
ALTER TABLE `borrow_tbl`
  ADD CONSTRAINT `fk_borrow_book` FOREIGN KEY (`book_id`) REFERENCES `book_tbl` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_borrow_user` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reply_tbl`
--
ALTER TABLE `reply_tbl`
  ADD CONSTRAINT `fk_reply_admin` FOREIGN KEY (`admin_id`) REFERENCES `admin_tbl` (`admin_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_reply_ticket` FOREIGN KEY (`ticket_id`) REFERENCES `ticket_tbl` (`ticket_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reply_tbl_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admin_tbl` (`admin_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reply_tbl_ibfk_2` FOREIGN KEY (`ticket_id`) REFERENCES `ticket_tbl` (`ticket_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

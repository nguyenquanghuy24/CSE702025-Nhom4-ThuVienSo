-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2025 at 03:49 PM
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
-- Table structure for table `book_tbl`
--

CREATE TABLE `book_tbl` (
  `id` int(11) NOT NULL,
  `maSach` varchar(20) NOT NULL,
  `tieuDe` varchar(255) NOT NULL,
  `tacGia` varchar(100) DEFAULT NULL,
  `theLoai` varchar(100) DEFAULT NULL,
  `namXuatBan` int(11) DEFAULT NULL,
  `soLuong` int(11) DEFAULT 1,
  `moTa` text DEFAULT NULL,
  `anhBia` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book_tbl`
--

INSERT INTO `book_tbl` (`id`, `maSach`, `tieuDe`, `tacGia`, `theLoai`, `namXuatBan`, `soLuong`, `moTa`, `anhBia`) VALUES
(1, 'EN001', 'Algorithms (4th Edition)', 'Robert Sedgewick, Kevin Wayne', 'Thuật toán', 2011, 3, 'Cuốn sách trình bày toàn diện về các thuật toán cổ điển và cấu trúc dữ liệu, bao gồm phân tích hiệu năng và cách cài đặt bằng Java. Rất phù hợp với sinh viên ngành Khoa học Máy tính.', 'image/1.jpg'),
(2, 'EN002', 'Agile Software Development, Principles, Patterns, and Practices', 'Robert Martin', 'Phát triển phần mềm', 2002, 4, 'Cuốn sách trình bày chi tiết các nguyên lý phát triển phần mềm linh hoạt (Agile), các mẫu thiết kế (design patterns) và thực hành lập trình hiệu quả, phù hợp cho lập trình viên và kỹ sư phần mềm.', 'image/2.jpg'),
(3, 'VN001', 'Giáo trình lập trình Android', 'Lê Hoàng Sơn, Nguyễn Thọ Thông', 'Lập trình di động', 2020, 3, 'Mục tiêu chính của cuốn sách này là giúp bạn đọc nhanh chóng nắm bắt được các thành phần cốt yếu trong Android và có thể lập trình được các ứng dụng cơ bản một cách hiệu quả. Đây cũng sẽ là cuốn giáo trình hữu ích cho sinh viên các trường đại học kỹ thuật chuyên về công nghệ thông tin. Để có thể đọc một cách hiệu quả nội dung của cuốn sách này, bạn đọc cần nắm được các kiến thức nền tảng về lập trình hướng đối tượng trong Java. Trong mỗi chương, chúng tôi cũng trình bày các đoạn mã nguồn đầy đủ để bạn đọc tiện theo dõi và thực hành.', 'image/3.jpg'),
(4, 'EN003', 'Microsystem Design', 'Stephen D. Senturia', 'MEMS, Kỹ thuật vi hệ thống', 2000, 3, 'Giới thiệu các nguyên lý cơ bản và liên ngành trong thiết kế hệ thống vi cơ điện tử (MEMS) thông qua các tình huống nghiên cứu thực tế.', 'image/4.jpg'),
(5, 'EN004', 'Computing and Technology Ethics: Engaging through Science Fiction', 'Emanuelle Burton', 'Công nghệ, Đạo đức, Trí tuệ nhân tạo', 2023, 4, 'Giới thiệu các khung đạo đức và các vấn đề hiện đại về đạo đức công nghệ như AI, quyền riêng tư, và điện toán thông qua khoa học viễn tưởng.', 'image/5.jpg'),
(6, 'EN005', 'Deep Learning in Computer Vision: Principles and Applications', 'Mahmoud Hassaballah, Ali Ismail Awad', 'Trí tuệ nhân tạo, Thị giác máy tính', 2020, 5, 'Giới thiệu các nguyên lý và ứng dụng của deep learning trong thị giác máy tính như nhận diện khuôn mặt, phát hiện cháy, và phân đoạn ảnh y tế.', 'image/6.jpg'),
(7, 'VN004', 'Giáo trình SQL Server 2000', 'Nguyễn Thiên Bằng, Hoàng Đức Hải, Phương Lan', 'Cơ sở dữ liệu', 2005, 5, 'Cung cấp kiến thức về cài đặt, quản trị và truy vấn SQL Server 2000 cho người học và lập trình viên.', 'image/7.jpg'),
(8, 'VN005', 'Giáo Trình Toán Học Cao Cấp – Tập 1', 'Nguyễn Đình Trí', 'Toán học', 2007, 4, 'Trình bày tập hợp, ánh xạ, số thực - phức, giới hạn, đạo hàm, định thức, ma trận và không gian vectơ.', 'image/8.jpg'),
(9, 'VN006', 'Giáo Trình Toán Học Cao Cấp – Tập 2', 'Nguyễn Đình Trí', 'Toán học', 2007, 4, 'Hàm nhiều biến, tích phân kép, đường, chuỗi và phương trình vi phân.', 'image/9.jpg'),
(10, 'VN007', 'Giáo trình hệ điều hành', 'Từ Minh Phương', 'Hệ điều hành', 2016, 5, 'Tổng quan hệ điều hành, tiến trình, tập tin và quản lý hệ thống.', 'image/10.jpg');

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
  `hoTen` varchar(100) NOT NULL,
  `maSV` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ticket_tbl`
--

INSERT INTO `ticket_tbl` (`hoTen`, `maSV`, `email`, `subject`, `message`) VALUES
('Nguyen Quang Huy', '2', 'nghuy@gmail.com', 'Khong su dung duoc sach', 'Hom nay khi truy cap vao thi toi khong the mo duoc sach de xem ');

--
-- Indexes for dumped tables
--

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
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `book_tbl`
--
ALTER TABLE `book_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `borrow_tbl`
--
ALTER TABLE `borrow_tbl`
  MODIFY `borrow_id` int(11) NOT NULL AUTO_INC`REMENT;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `borrow_tbl`
--
ALTER TABLE `borrow_tbl`
  ADD CONSTRAINT `fk_book` FOREIGN KEY (`book_id`) REFERENCES `book_tbl` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_borrow_user` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

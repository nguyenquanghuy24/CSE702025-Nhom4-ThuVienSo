<?php
$servername = "localhost";
$username = "root";       // tài khoản mặc định của XAMPP
$password = "";           // mật khẩu thường để trống
$dbname = "user_demo";    // tên database bạn đã tạo

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
  die("Kết nối thất bại: " . $conn->connect_error);
}
?>

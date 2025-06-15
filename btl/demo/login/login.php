<?php
session_start();
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $redirect = isset($_POST['redirect']) ? $_POST['redirect'] : '../index.php'; // Mặc định về index

    // Chuẩn bị truy vấn
    $stmt = $conn->prepare("SELECT * FROM tbl_user WHERE user = ? AND pass = ?");
    $stmt->bind_param("ss", $user, $pass);
    $stmt->execute();
    $result = $stmt->get_result();

    // Nếu đăng nhập thành công
    if ($result->num_rows == 1) {
        $_SESSION['user'] = $user;

        // Chuyển hướng đến trang trước đó
        header("Location: " . $redirect);
        exit();
    } else {
        $_SESSION['login_error'] = "Sai tên đăng nhập hoặc mật khẩu.";

        // Gửi lại về trang cũ kèm thông báo lỗi
        header("Location: " . $redirect);
        exit();
    }

    $stmt->close();
}
?>


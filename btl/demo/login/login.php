<?php
session_start();
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $redirect = isset($_POST['redirect']) ? $_POST['redirect'] : '../index.php'; // Mặc định về index

    $stmt = $conn->prepare("SELECT * FROM tbl_user WHERE user = ? AND pass = ?");
    $stmt->bind_param("ss", $user, $pass);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc(); // ✅ Lấy dòng dữ liệu người dùng

        $_SESSION['user'] = $user;
        $_SESSION['user_id'] = $row['id']; // ✅ Gán id vào session

        header("Location: " . $redirect);
        exit();
    } else {
        $_SESSION['login_error'] = "Sai tên đăng nhập hoặc mật khẩu.";
        header("Location: " . $redirect);
        exit();
    }

    $stmt->close();
}
?>



<?php
session_start();
include("../login/connect2.php");

// Bật hiển thị lỗi để debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['user']);
    $password = mysqli_real_escape_string($conn, $_POST['pass']);
    $redirect = isset($_POST['redirect']) ? $_POST['redirect'] : '../logadmin.php';

    $query = "SELECT * FROM admin_tbl WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) == 1) {
        $admin = mysqli_fetch_assoc($result);
        $_SESSION['user'] = $admin['username'];
        $_SESSION['is_admin'] = true; // đánh dấu là admin
        header("Location: $redirect");
        exit();
    } else {
        $_SESSION['login_error'] = "Tên đăng nhập hoặc mật khẩu không đúng.";
        header("Location: $redirect");
        exit();
    }
}
?>

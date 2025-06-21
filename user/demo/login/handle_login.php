<?php
session_start();

include("connect.php"); // Đảm bảo đường dẫn đúng

$username = $_POST['user'] ?? '';
$password = $_POST['pass'] ?? '';
$redirect = $_POST['redirect'] ?? '../index.php'; // Mặc định về giao diện user

// Kiểm tra tài khoản admin
$admin_query = "SELECT * FROM admin_tbl WHERE username = '$username' AND password = '$password'";
$admin_result = mysqli_query($conn, $admin_query);

if ($admin_result && mysqli_num_rows($admin_result) === 1) {
    $admin = mysqli_fetch_assoc($admin_result);
    $_SESSION['user'] = $admin['username'];
    $_SESSION['is_admin'] = true;
    $_SESSION['admin_id'] = $admin['admin_id'];
    header("Location: ../../../admin/logadmin.php");
    exit();
}

// Kiểm tra tài khoản user
$user_query = "SELECT * FROM tbl_user WHERE user = '$username' AND pass = '$password'";
$user_result = mysqli_query($conn, $user_query);

if ($user_result && mysqli_num_rows($user_result) === 1) {
    $user = mysqli_fetch_assoc($user_result);
    $_SESSION['user'] = $user['user'];
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['is_admin'] = false;
    header("Location: ../index.php");
    exit();
}

// Đăng nhập thất bại
$_SESSION['login_error'] = "Sai tên đăng nhập hoặc mật khẩu.";
header("Location: $redirect");
exit(); 
<?php
// Bắt đầu hoặc tiếp tục session
session_start();

// Xoá toàn bộ biến trong session
session_unset();

// Hủy session
session_destroy();

// Xóa cookie session nếu có
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
// Chuyển hướng về trang chủ sau 1 giây
header("Refresh: 1; URL=../index.php");
exit();
?>
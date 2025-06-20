<?php
session_start();
session_unset();
session_destroy();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Ưu tiên redirect về trang được chỉ định (nếu có)
if (isset($_GET['redirect']) && !empty($_GET['redirect'])) {
    $redirect = $_GET['redirect'];
} else {
    // Nếu không có thì xét theo vai trò
    $redirect = '../user/demo/index.php'; // luôn quay về giao diện người dùng
}

header("Location: $redirect");
exit();
?>

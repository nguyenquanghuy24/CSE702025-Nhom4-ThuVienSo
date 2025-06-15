<?php
session_start();

// Xóa tất cả session
session_unset();
session_destroy();

// Xóa cookie session nếu có
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Nếu có redirect được truyền vào thì quay lại đó, không thì về index
$redirect = isset($_GET['redirect']) ? $_GET['redirect'] : '../index.php';
header("Location: $redirect");
exit();
?>

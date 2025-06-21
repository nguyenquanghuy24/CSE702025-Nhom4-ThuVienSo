<?php
session_start();
require_once '../../user/demo/login/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ticket_id = isset($_POST['ticket_id']) ? intval($_POST['ticket_id']) : null;
    $subject = trim($_POST['compose_subject'] ?? '');
    $message = trim($_POST['compose_message'] ?? '');
    $admin_id = $_SESSION['admin_id'] ?? null;

    if ($ticket_id && $admin_id && $subject && $message) {
        $stmt = $conn->prepare("INSERT INTO reply_tbl (ticket_id, admin_id, subject, message) VALUES (?, ?, ?, ?)");
        if (!$stmt) {
            die("Lỗi prepare: " . $conn->error); // Debug nếu chuẩn bị statement lỗi
        }
        $stmt->bind_param("iiss", $ticket_id, $admin_id, $subject, $message);
        if ($stmt->execute()) {
            header("Location: reply.php?success=1");
            exit();
        } else {
            die("Lỗi execute: " . $stmt->error); // Debug lỗi khi execute
        }
    } else {
        die("Chưa đăng nhập với quyền admin.");
    }
}
?>

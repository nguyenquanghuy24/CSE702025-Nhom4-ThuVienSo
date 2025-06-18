<?php
session_start();
require '../login/connect.php'; // Đảm bảo đường dẫn đúng

// Kiểm tra kết nối CSDL ngay sau khi require
if ($conn->connect_error) {
    $_SESSION['return_error'] = "Lỗi kết nối CSDL: " . $conn->connect_error;
    header("Location: ../borrow/borrow.php");
    exit();
}

if (isset($_SESSION['user_id']) && isset($_POST['borrow_id'])) {
    $user_id = $_SESSION['user_id'];
    $borrow_id = intval($_POST['borrow_id']);

    // Ghi log để kiểm tra giá trị nhận được (sẽ hiển thị trong file log của PHP server)
    error_log("Return request received: user_id=" . $user_id . ", borrow_id=" . $borrow_id);

    $conn->begin_transaction(); // Bắt đầu giao dịch

    try {
        // 1. Lấy thông tin book_id từ borrow_id và kiểm tra trạng thái 'Đang mượn'
        // KHÔNG LẤY ngayTraThucTe NỮA
        $stmt = $conn->prepare("SELECT book_id FROM borrow_tbl WHERE borrow_id = ? AND user_id = ? AND tinhTrang = 'Đang mượn'");
        if (!$stmt) {
            throw new Exception("Lỗi prepare SELECT: " . $conn->error);
        }
        $stmt->bind_param("ii", $borrow_id, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $borrow_record = $result->fetch_assoc();
        $stmt->close(); // Đóng statement sau khi dùng

        if (!$borrow_record) {
            error_log("Return Error: Borrow record not found, not 'Đang mượn', or already processed. borrow_id=" . $borrow_id . ", user_id=" . $user_id);
            throw new Exception("Không tìm thấy lượt mượn hợp lệ, sách không ở trạng thái 'Đang mượn' hoặc đã được xử lý.");
        }

        $book_id = $borrow_record['book_id'];
        error_log("Book found for return: book_id=" . $book_id);

        // 2. CẬP NHẬT TRẠNG THÁI của lượt mượn trong borrow_tbl thành 'Đã trả'
        // Đã loại bỏ ngayTraThucTe = NOW()
        $stmt = $conn->prepare("UPDATE borrow_tbl SET tinhTrang = 'Đã trả' WHERE borrow_id = ?");
        if (!$stmt) {
            throw new Exception("Lỗi prepare UPDATE borrow_tbl: " . $conn->error);
        }
        $stmt->bind_param("i", $borrow_id);
        $stmt->execute();

        if ($stmt->affected_rows === 0) {
            error_log("Return Error: UPDATE borrow_tbl affected_rows is 0. borrow_id=" . $borrow_id . ", SQL error: " . $stmt->error);
            throw new Exception("Không thể cập nhật trạng thái trả sách. Có thể không có thay đổi nào được thực hiện.");
        }
        error_log("borrow_tbl updated for borrow_id: " . $borrow_id);

        // 3. Tăng số lượng sách trong book_tbl và cập nhật trạng thái sách (nếu cần)
        $stmt = $conn->prepare("UPDATE book_tbl SET soLuong = soLuong + 1, trangThai = 'Có sẵn' WHERE id = ?");
        if (!$stmt) {
            throw new Exception("Lỗi prepare UPDATE book_tbl: " . $conn->error);
        }
        $stmt->bind_param("i", $book_id);
        $stmt->execute();

        if ($stmt->affected_rows === 0) {
            error_log("Return Error: UPDATE book_tbl affected_rows is 0. book_id=" . $book_id . ", SQL error: " . $stmt->error);
            throw new Exception("Không thể cập nhật số lượng sách trong kho.");
        }
        error_log("book_tbl updated for book_id: " . $book_id);

        $conn->commit(); // Hoàn tất giao dịch
        $_SESSION['return_success'] = "Sách đã được trả thành công!";
        error_log("Transaction committed. Success message set.");

    } catch (Exception $e) {
        $conn->rollback(); // Hoàn tác giao dịch nếu có lỗi
        $_SESSION['return_error'] = "Lỗi trả sách: " . $e->getMessage();
        error_log("Transaction rolled back. Error: " . $e->getMessage());
    }

    header("Location: ../borrow/borrow.php"); // Chuyển hướng về trang mượn/trả
    exit();

} else {
    $_SESSION['return_error'] = "Yêu cầu không hợp lệ. Vui lòng đăng nhập hoặc chọn sách hợp lệ để trả.";
    header("Location: ../borrow/borrow.php");
    exit();
}
?>
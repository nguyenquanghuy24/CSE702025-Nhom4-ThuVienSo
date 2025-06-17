<?php
session_start();
include("../login/connect.php");

if (!isset($_SESSION['user_id'])) {
    die("Bạn cần đăng nhập để trả sách.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['borrow_id'])) {
    $borrow_id = intval($_POST['borrow_id']);

    // Lấy book_id từ lượt mượn
    $sql = "SELECT book_id FROM borrow_tbl WHERE borrow_id = $borrow_id AND user_id = {$_SESSION['user_id']}";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        $book_id = $row['book_id'];

        // Xoá lượt mượn
        $delete_sql = "DELETE FROM borrow_tbl WHERE borrow_id = $borrow_id";
        if (mysqli_query($conn, $delete_sql)) {
            // Tăng số lượng sách
            $update_sql = "UPDATE book_tbl SET soLuong = soLuong + 1 WHERE id = $book_id";
            mysqli_query($conn, $update_sql);

            // Hiện thông báo và chuyển trang
            echo "<script>
                alert('Trả sách thành công!');
                setTimeout(function() {
                    window.location.href = 'borrow.php';
                }, 200); 
            </script>";
        } else {
            echo "Lỗi khi trả sách.";
        }
    } else {
        echo "Không tìm thấy lượt mượn hợp lệ.";
    }
} else {
    echo "Yêu cầu không hợp lệ.";
}
?>

<?php
session_start();
// Sửa đường dẫn kết nối CSDL từ connect2.php sang connect.php với đường dẫn tương đối đúng
include "../../user/demo/login/connect.php"; // Kết nối CSDL

// Tạm thời bật hiển thị lỗi để debug
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kiểm tra kết nối CSDL
    if ($conn->connect_error) {
        $_SESSION['upload_error'] = "Lỗi kết nối cơ sở dữ liệu: " . $conn->connect_error;
        header("Location: add.php");
        exit();
    }

    $title = mysqli_real_escape_string($conn, $_POST['book_title']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $isbn = mysqli_real_escape_string($conn, $_POST['isbn']); // Lấy giá trị ISBN mới thêm
    $year = intval($_POST['publication_year']);
    $language = mysqli_real_escape_string($conn, $_POST['language']);
    $quantity = intval($_POST['quantity']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // Tạo mã sách (Giữ nguyên logic của bạn, nhưng mã sách giờ sẽ không cần tạo nữa vì có ISBN)
    // Lưu ý: Nếu cột 'maSach' trong DB của bạn là ISBN, thì không cần logic tạo mã tự động này.
    // Nếu 'maSach' là một ID tự tạo khác ISBN, bạn cần làm rõ.
    // Hiện tại, tôi sẽ sử dụng ISBN cho 'maSach' như một giả định hợp lý.
    // Nếu 'maSach' phải là một giá trị tự tăng riêng, bạn cần thay đổi logic.
    $maSach = $isbn; // Sử dụng ISBN làm mã sách (nếu trường maSach trong DB của bạn lưu ISBN)

    // Xử lý ảnh bìa
    $anhBia = null;
    if (isset($_FILES['book_image']) && $_FILES['book_image']['error'] == 0) {
        $upload_dir = "../../user/demo/assets/"; // Đường dẫn upload ảnh tuyệt đối từ root project
        $filename = basename($_FILES['book_image']['name']);
        $target_path = $upload_dir . $filename;

        // Đảm bảo thư mục upload tồn tại
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true); // Tạo thư mục nếu chưa có
        }

        if (move_uploaded_file($_FILES['book_image']['tmp_name'], $target_path)) {
            $anhBia = "assets/" . $filename; // Đường dẫn sẽ lưu vào CSDL, tương đối từ thư mục "demo"
        } else {
            $_SESSION['upload_error'] = "Tải ảnh thất bại. Vui lòng kiểm tra quyền thư mục.";
            header("Location: add.php");
            exit();
        }
    }

    // Thêm sách vào CSDL sử dụng prepared statements
    // Cập nhật truy vấn để bao gồm trường ISBN (được ánh xạ tới maSach trong DB của bạn)
    $stmt = $conn->prepare("INSERT INTO book_tbl (maSach, tieuDe, tacGia, theLoai, namXuatBan, ngonNgu, soLuong, trangThai, moTa, anhBia) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if ($stmt === false) {
        $_SESSION['upload_error'] = "Lỗi chuẩn bị truy vấn: " . $conn->error;
        header("Location: add.php");
        exit();
    }

    // Cập nhật bind_param để bao gồm $isbn thay vì $maSach được tạo tự động
    $stmt->bind_param("ssssisisss", $isbn, $title, $author, $category, $year, $language, $quantity, $status, $description, $anhBia);


    if ($stmt->execute()) {
        $_SESSION['success'] = "Đã thêm sách thành công!";
        header("Location: add.php");
        exit();
    } else {
        // Có thể thêm kiểm tra lỗi trùng lặp ISBN nếu 'maSach' là UNIQUE KEY
        if ($conn->errno == 1062) { // Error code for duplicate entry
            $_SESSION['upload_error'] = "Lỗi: Mã ISBN đã tồn tại. Vui lòng sử dụng ISBN khác.";
        } else {
            $_SESSION['upload_error'] = "Lỗi thêm sách vào CSDL: " . $stmt->error;
        }
        header("Location: add.php");
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    // Nếu không phải phương thức POST, chuyển hướng về trang thêm sách
    header("Location: add.php");
    exit();
}
?>
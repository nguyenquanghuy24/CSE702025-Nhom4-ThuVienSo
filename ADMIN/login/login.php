<?php
session_start();
include("connect2.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['user']);
    $password = mysqli_real_escape_string($conn, $_POST['pass']);

    // Kiểm tra trong bảng admin_tbl
    $query = "SELECT * FROM admin_tbl WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) == 1) {
        $admin = mysqli_fetch_assoc($result);
        $_SESSION['user'] = $admin['username'];
        $_SESSION['is_admin'] = true;
        header("Location: ../logadmin.php");
        exit();
    } else {
        $_SESSION['login_error'] = "Sai tên đăng nhập hoặc mật khẩu.";
        header("Location: ../logadmin.php");
        exit();
    }
}
?>

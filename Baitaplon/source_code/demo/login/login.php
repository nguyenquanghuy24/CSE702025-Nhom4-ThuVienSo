<?php
session_start();
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $user = $_POST['user'];
  $pass = $_POST['pass'];

  $stmt = $conn->prepare("SELECT * FROM tbl_user WHERE user = ? AND pass = ?");
  $stmt->bind_param("ss", $user, $pass);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows == 1) {
    $_SESSION['user'] = $user;
    header("Location: ../index.php");
    exit();
  } else {
    $_SESSION['login_error'] = "Sai tên đăng nhập hoặc mật khẩu.";
    header("Location: ../index.php");
    exit();
  }

  $stmt->close();
}
?>

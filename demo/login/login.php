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
    echo "<script>alert('Sai tên đăng nhập hoặc mật khẩu'); window.location.href='login.php';</script>";
  }

  $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Đăng nhập</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
  <form method="POST" action="">
    <h2>Đăng nhập</h2>
    <label for="user">Tên đăng nhập:</label>
    <input type="text" id="user" name="user" required>
    <label for="pass">Mật khẩu:</label>
    <input type="password" id="pass" name="pass" required>
    <button type="submit">Đăng nhập</button>
    <p>Chưa có tài khoản? <a href="register.php">Đăng ký</a></p>
  </form>
</body>
</html>

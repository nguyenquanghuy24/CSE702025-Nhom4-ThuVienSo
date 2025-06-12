<?php
include 'connect.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $user = $_POST['user'];
  $pass = $_POST['pass'];

  $stmt = $conn->prepare("INSERT INTO tbl_user (username, password) VALUES (?, ?)");
  $stmt->bind_param("ss", $user, $pass);

  if ($stmt->execute()) {
    echo "<script>alert('Đăng ký thành công'); window.location.href='login.php';</script>";
  } else {
    echo "<script>alert('Tên đăng nhập đã tồn tại'); window.location.href='register.php';</script>";
  }

  $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Đăng ký</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
  <form method="POST" action="">
    <h2>Đăng ký</h2>
    <label for="user">Tên đăng nhập:</label>
    <input type="text" id="user" name="user" required>
    <label for="pass">Mật khẩu:</label>
    <input type="password" id="pass" name="pass" required>
    <button type="submit">Đăng ký</button>
    <p>Đã có tài khoản? <a href="login.php">Đăng nhập</a></p>
  </form>
</body>
</html>
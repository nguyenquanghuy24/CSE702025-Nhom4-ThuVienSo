// Chờ cho toàn bộ nội dung trang được tải xong
document.addEventListener('DOMContentLoaded', () => {
  // Lấy các phần tử cần thiết cho Modal Đăng nhập
  const loginLink = document.getElementById('login-auth-link');
  const modal = document.getElementById('loginModal');
  const closeBtn = document.querySelector('.close-btn');

  // Kiểm tra xem các phần tử có tồn tại không trước khi thêm sự kiện
  if (loginLink && modal && closeBtn) {
    // 1. Mở modal khi nhấn vào nút "Đăng nhập"
    loginLink.addEventListener('click', (event) => {
      event.preventDefault(); // Ngăn hành vi mặc định của thẻ <a>
      modal.style.display = 'block';
    });

    // 2. Đóng modal khi nhấn vào nút 'x'
    closeBtn.addEventListener('click', () => {
      modal.style.display = 'none';
    });

    // 3. Đóng modal khi nhấn ra ngoài khu vực modal
    window.addEventListener('click', (event) => {
      if (event.target === modal) {
        modal.style.display = 'none';
      }
    });
  }
});
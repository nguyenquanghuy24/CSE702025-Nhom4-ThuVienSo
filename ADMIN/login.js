document.addEventListener('DOMContentLoaded', () => {
  const loginLink = document.querySelector('.auth-link');
  const modal = document.querySelector('#loginModal');
  const closeBtn = document.querySelector('.close-btn');

  // Ngăn chặn đóng modal bằng nút X hoặc click ra ngoài nếu chưa đăng nhập
  // PHP đã thiết lập modal display:flex khi chưa đăng nhập, nên không cần modal.style.display = 'block' ở đây
  if (closeBtn) {
    closeBtn.style.display = 'none'; // Đảm bảo nút đóng bị ẩn theo yêu cầu
  }

  // Nếu người dùng đã đăng nhập (kiểm tra bằng session trong PHP), modal sẽ bị ẩn đi.
  // PHP sẽ thêm một script nhỏ để ẩn modal nếu $_SESSION['user'] đã tồn tại.
  // Nếu chưa đăng nhập, modal sẽ hiển thị với display:flex từ PHP.

  // Event listener cho nút Đăng nhập trên navbar (nếu có)
  if (loginLink) {
    loginLink.addEventListener('click', (e) => {
      e.preventDefault();
      // Nếu modal bị ẩn (do đã đăng nhập hoặc đã đóng thủ công), thì hiển thị lại.
      if (modal && (modal.style.display === 'none' || modal.style.display === '')) {
        modal.style.display = 'flex';
      }
    });
  }

  // Vô hiệu hóa việc đóng modal khi click ra ngoài
  window.addEventListener('click', (e) => {
    if (e.target === modal && !modal.classList.contains('allow-close')) {
      // Do nothing, prevent closing
    } else if (e.target === modal && modal.classList.contains('allow-close')) {
      modal.style.display = 'none';
    }
  });

  // Xử lý logic đóng modal sau khi đăng nhập thành công
  // Logic này sẽ nằm trong handle_login.php (không thay đổi code PHP của bạn ở đây)
  // handle_login.php sau khi xác thực thành công sẽ redirect về logadmin.php
  // Lúc đó, phần PHP trên logadmin.php sẽ kiểm tra $_SESSION['user'] và ẩn modal.

});

// Hàm này vẫn cần vì nó được gọi từ onclick trong HTML, nhưng chúng ta sẽ kiểm soát việc đóng chặt hơn
function openLoginModal() {
  const modal = document.getElementById('loginModal');
  if (modal) {
    modal.style.display = 'flex';
  }
}

// Hàm này không nên được gọi trực tiếp bằng nút X nữa, nó sẽ được gọi bởi hệ thống sau khi đăng nhập
function closeModal() {
  const modal = document.getElementById('loginModal');
  if (modal && modal.classList.contains('allow-close')) {
    modal.style.display = 'none';
  }
}
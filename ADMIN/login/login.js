document.addEventListener('DOMContentLoaded', () => {
  // Login Modal
  const loginLink = document.querySelector('.auth-link');
  const modal = document.querySelector('#loginModal');
  const closeBtn = document.querySelector('.close-btn');

  if (loginLink && modal && closeBtn) { // Kiểm tra sự tồn tại của các phần tử
      loginLink.addEventListener('click', (e) => {
        e.preventDefault();
        modal.style.display = 'block';
      });

      closeBtn.addEventListener('click', () => {
        modal.style.display = 'none';
      });

      window.addEventListener('click', (e) => {
        if (e.target === modal) {
          modal.style.display = 'none';
        }
      });
  }


  // Card animation on load (Nếu vẫn dùng trên index.php)
  const cards = document.querySelectorAll('.card');
  cards.forEach((card, index) => {
    card.style.opacity = '0';
    card.style.transform = 'translateY(20px)';
    setTimeout(() => {
      card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
      card.style.opacity = '1';
      card.style.transform = 'translateY(0)';
    }, index * 100);
  });
});

// Mở modal đăng nhập (Hàm global để gọi từ onclick trong HTML)
function openLoginModal() {
  const modal = document.getElementById('loginModal');
  if (modal) {
      modal.style.display = 'block';
  }
}

// Đóng modal (Hàm global để gọi từ onclick trong HTML)
function closeModal() {
  const modal = document.getElementById('loginModal');
  if (modal) {
      modal.style.display = 'none';
  }
}
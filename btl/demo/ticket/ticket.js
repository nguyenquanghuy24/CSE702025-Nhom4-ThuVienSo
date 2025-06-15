document.addEventListener('DOMContentLoaded', () => {
  // Login Modal
  const loginLink = document.querySelector('.auth-link');
  const modal = document.querySelector('#loginModal');
  const closeBtn = document.querySelector('.close-btn');

  // Check if all elements exist before adding listeners
  if (loginLink && modal && closeBtn) {
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
});

// Mở modal đăng nhập
function openLoginModal() {
  const modal = document.getElementById('loginModal');
  if (modal) {
    modal.style.display = 'block';
  }
}

// Đóng modal
function closeModal() {
  const modal = document.getElementById('loginModal');
  if (modal) {
    modal.style.display = 'none';
  }
}
document.addEventListener('DOMContentLoaded', () => {
  // Login Modal
  const loginLink = document.querySelector('.auth a');
  const modal = document.querySelector('#loginModal');
  const closeBtn = document.querySelector('.close-btn');

  if (loginLink) {
    loginLink.addEventListener('click', (e) => {
      if (loginLink.getAttribute('href') === '#') {
        e.preventDefault();
        modal.style.display = 'block';
      }
    });
  }

  if (closeBtn) {
    closeBtn.addEventListener('click', () => {
      modal.style.display = 'none';
    });
  }

  window.addEventListener('click', (e) => {
    if (e.target === modal) {
      modal.style.display = 'none';
    }
  });
});
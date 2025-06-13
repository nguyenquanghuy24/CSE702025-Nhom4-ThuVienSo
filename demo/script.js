document.addEventListener('DOMContentLoaded', () => {
  // Login Modal
  const loginLink = document.querySelector('.auth a');
  const modal = document.querySelector('#loginModal');
  const closeBtn = document.querySelector('.close-btn');

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
});
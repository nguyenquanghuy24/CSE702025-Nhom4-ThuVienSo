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

  // Card animation on load (from original script.js)
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

  // Scroll to footer when Contact is clicked (new addition)
  const contactScrollBtn = document.getElementById('contact-scroll-btn');
  if (contactScrollBtn) {
    contactScrollBtn.addEventListener('click', () => {
      const footer = document.getElementById('footer-section');
      if (footer) {
        footer.scrollIntoView({ behavior: 'smooth' });
      }
    });
  }
});

// Mở modal đăng nhập (from original script.js)
function openLoginModal() {
  const modal = document.getElementById('loginModal');
  if (modal) {
    modal.style.display = 'block';
  }
}

// Đóng modal (from original script.js)
function closeModal() {
  const modal = document.getElementById('loginModal');
  if (modal) {
    modal.style.display = 'none';
  }
}
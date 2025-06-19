document.addEventListener('DOMContentLoaded', () => {
  // Login Modal
  const loginLink = document.querySelector('.auth-link');
  const modal = document.querySelector('#loginModal');
  const closeBtn = document.querySelector('.close-btn');

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
document.addEventListener('DOMContentLoaded', () => {

  const loginLink = document.querySelector('.auth-link');
  const modal = document.querySelector('#loginModal');
  const closeBtn = document.querySelector('.close-btn');

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

  // FAQ
  const faqQuestions = document.querySelectorAll('.faq-question');

  faqQuestions.forEach(question => {
    question.addEventListener('click', () => {
      const answer = question.nextElementSibling;

      const isActive = question.classList.toggle('active');

      if(isActive){
        answer.style.maxHeight = answer.scrollHeight + 'px';
      } else {
        answer.style.maxHeight = '0px';
      }
    });
  });
});

function openLoginModal() {
  const modal = document.getElementById('loginModal');
  if (modal) {
    modal.style.display = 'block';
  }
}

function closeModal() {
  const modal = document.getElementById('loginModal');
  if (modal) {
    modal.style.display = 'none';
  }
}
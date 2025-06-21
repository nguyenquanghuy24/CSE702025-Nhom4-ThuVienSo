document.addEventListener('DOMContentLoaded', () => {
  // Login Modal
  const loginLink = document.querySelector('.auth-link');
  const modal = document.querySelector('#loginModal');
  const closeBtn = document.querySelector('.close-btn');

  if (loginLink) {
    loginLink.addEventListener('click', (e) => {
      e.preventDefault();
      if (modal) modal.style.display = 'block';
    });
  }

  if (closeBtn) {
    closeBtn.addEventListener('click', () => {
      if (modal) modal.style.display = 'none';
    });
  }

  window.addEventListener('click', (e) => {
    if (e.target === modal) {
      if (modal) modal.style.display = 'none';
    }
  });

  // Mở modal đăng nhập
  window.openLoginModal = function() {
    if (modal) modal.style.display = 'block';
  }

  // Đóng modal
  window.closeModal = function() {
    if (modal) modal.style.display = 'none';
  }

  // Các chức năng JavaScript cụ thể cho trang admin (validation form)
  const addBookForm = document.querySelector('.add-book-form');
  if (addBookForm) {
      addBookForm.addEventListener('submit', (e) => {
          const bookTitle = document.getElementById('book_title').value;
          const author = document.getElementById('author').value;
          const isbn = document.getElementById('isbn').value; // Lấy giá trị ISBN
          const quantity = document.getElementById('quantity').value;

          // Thêm kiểm tra cho trường ISBN
          if (bookTitle.trim() === '' || author.trim() === '' || isbn.trim() === '' || quantity.trim() === '') {
              alert('Vui lòng điền đầy đủ các trường bắt buộc (Tên sách, Tác giả, ISBN, Số lượng).');
              e.preventDefault(); // Ngăn chặn gửi form
          }
          // Thêm các kiểm tra khác nếu cần
      });
  }
});
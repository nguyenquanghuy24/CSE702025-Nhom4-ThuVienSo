// Chờ cho toàn bộ nội dung trang được tải xong
document.addEventListener('DOMContentLoaded', () => {
  // --- Modal Đăng nhập (code cũ giữ nguyên) ---
  const loginLink = document.getElementById('login-auth-link');
  const loginModal = document.getElementById('loginModal');
  if (loginModal) {
    const loginCloseBtn = loginModal.querySelector('.close-btn');

    if (loginLink && loginCloseBtn) {
      loginLink.addEventListener('click', (event) => {
        event.preventDefault();
        loginModal.style.display = 'block';
      });
      loginCloseBtn.addEventListener('click', () => {
        loginModal.style.display = 'none';
      });
    }
  }


  // --- NEW: Xử lý Modal Chi tiết Sách ---
  const bookDetailModal = document.getElementById('bookDetailModal');
  if (bookDetailModal) {
    const detailCloseBtn = bookDetailModal.querySelector('.close-btn-large');
    const viewDetailButtons = document.querySelectorAll('.btn-view-details');

    // Lấy các phần tử trong modal để điền dữ liệu
    const modalImage = document.getElementById('modal-book-image');
    const modalTitle = document.getElementById('modal-book-title');
    const modalAuthor = document.getElementById('modal-book-author');
    const modalYear = document.getElementById('modal-book-year');
    const modalDescription = document.getElementById('modal-book-description');

    // Thêm sự kiện cho tất cả các nút "Xem chi tiết"
    viewDetailButtons.forEach(button => {
      button.addEventListener('click', (event) => {
        // Tìm mục sách cha gần nhất
        const bookItem = event.target.closest('.book-list-item');

        // Lấy dữ liệu từ các phần tử con của mục sách
        const title = bookItem.querySelector('.book-title').textContent;
        const author = bookItem.querySelector('.book-author').textContent;
        const fullDescription = bookItem.querySelector('.book-description').textContent; // Lấy mô tả đầy đủ
        const year = bookItem.querySelector('.book-year').textContent;
        const imageSrc = bookItem.querySelector('.book-item-image').src;

        // Điền dữ liệu vào modal
        modalTitle.textContent = title;
        modalAuthor.textContent = author.replace('Tác giả: ', ''); // Bỏ tiền tố "Tác giả: "
        modalYear.textContent = year;
        modalDescription.textContent = fullDescription;
        modalImage.src = imageSrc;

        // Hiển thị modal
        bookDetailModal.style.display = 'block';
      });
    });

    // Đóng modal chi tiết khi nhấn nút 'x'
    if (detailCloseBtn) {
        detailCloseBtn.addEventListener('click', () => {
            bookDetailModal.style.display = 'none';
        });
    }
  }

  // Đóng cả 2 modal khi nhấn ra ngoài
  window.addEventListener('click', (event) => {
    const loginModal = document.getElementById('loginModal');
    const bookDetailModal = document.getElementById('bookDetailModal');
    if (event.target === loginModal) {
      loginModal.style.display = 'none';
    }
    if (event.target === bookDetailModal) {
      bookDetailModal.style.display = 'none';
    }
  });
});
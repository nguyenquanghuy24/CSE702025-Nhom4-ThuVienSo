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

document.querySelectorAll('.book-list-item').forEach(item => {
    item.addEventListener('click', function () {
        // Lấy thông tin sách từ DOM
        const title = this.querySelector('.book-title').innerText;
        const author = this.querySelector('.book-author').innerText.replace("Tác giả: ", "");
        const year = this.querySelector('.book-year').innerText.replace("Năm: ", "");
        const description = this.querySelector('.book-description').innerText;
        const image = this.querySelector('img').src;

        // Lấy book_id từ dataset (bạn cần thêm data-book-id vào thẻ cha <div>)
        const bookId = this.dataset.bookId;

        // Hiển thị modal
        document.getElementById('modal-book-title').innerText = title;
        document.getElementById('modal-book-author').innerText = author;
        document.getElementById('modal-book-year').innerText = year;
        document.getElementById('modal-book-description').innerText = description;
        document.getElementById('modal-book-image').src = image;

        // Truyền bookId vào nút
        document.getElementById('borrowButton').setAttribute('data-book-id', bookId);

        document.getElementById('bookDetailModal').style.display = 'block';
    });
});


  // --- Xử lý Modal Chi tiết Sách ---
const bookDetailModal = document.getElementById('bookDetailModal');
  if (bookDetailModal) {
    const detailCloseBtn = bookDetailModal.querySelector('.close-btn-large');
    // THAY ĐỔI: Chọn toàn bộ mục sách thay vì chỉ nút bấm
    const bookItems = document.querySelectorAll('.book-list-item');

    // Lấy các phần tử trong modal để điền dữ liệu
    const modalImage = document.getElementById('modal-book-image');
    const modalTitle = document.getElementById('modal-book-title');
    const modalAuthor = document.getElementById('modal-book-author');
    const modalYear = document.getElementById('modal-book-year');
    const modalDescription = document.getElementById('modal-book-description');

    // Thêm sự kiện cho tất cả các MỤC SÁCH
    bookItems.forEach(item => {
      item.addEventListener('click', (event) => {
        // 'item' chính là 'book-list-item' được nhấn vào
        const bookItem = event.currentTarget;

        // Lấy dữ liệu từ các phần tử con của mục sách
        const title = bookItem.querySelector('.book-title').textContent;
        const author = bookItem.querySelector('.book-author').textContent;
        const fullDescription = bookItem.querySelector('.book-description').textContent;
        const year = bookItem.querySelector('.book-year').textContent;
        const imageSrc = bookItem.querySelector('.book-item-image').src;

        // Điền dữ liệu vào modal
        modalTitle.textContent = title;
        modalAuthor.textContent = author.replace('Tác giả: ', '');
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
    if (loginModal && event.target === loginModal) {
      loginModal.style.display = 'none';
    }
    if (bookDetailModal && event.target === bookDetailModal) {
      bookDetailModal.style.display = 'none';
    }
  });
});

document.addEventListener('DOMContentLoaded', () => {
  // Mã cho Login Modal
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

document.getElementById('borrowButton').addEventListener('click', function () {
    const bookId = this.getAttribute('data-book-id');

    fetch('../borrow/borrow_book.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `book_id=${encodeURIComponent(bookId)}`
    })
    .then(response => response.text())
    .then(data => {
        if (data.includes("Vui lòng đăng nhập")) {
            // Chưa đăng nhập → hiện modal login
            document.getElementById('bookDetailModal').style.display = 'none';
            document.getElementById('loginModal').style.display = 'block';
        } else {
            alert(data); // Hiển thị thông báo thành công/thất bại
            document.getElementById('bookDetailModal').style.display = 'none';
        }
    })
    .catch(error => {
        console.error("Lỗi:", error);
        alert("Có lỗi xảy ra khi mượn sách.");
    });
});

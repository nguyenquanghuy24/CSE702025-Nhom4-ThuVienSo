document.addEventListener('DOMContentLoaded', () => {
    // === XỬ LÝ MODAL ĐĂNG NHẬP ===
    const loginModal = document.getElementById('loginModal');
    if (loginModal) {
        // Gán hàm vào window để PHP có thể gọi từ onclick
        window.openLoginModal = function() {
            loginModal.style.display = 'block';
        }
        window.closeModal = function() {
            loginModal.style.display = 'none';
        }
        
        // Tìm nút đăng nhập trên header
        const loginLink = Array.from(document.querySelectorAll('.auth-link')).find(a => a.textContent.includes('Đăng nhập'));
        const closeBtn = loginModal.querySelector('.close-btn');

        if (loginLink) {
            loginLink.addEventListener('click', (e) => {
                e.preventDefault();
                openLoginModal();
            });
        }
        if (closeBtn) {
            closeBtn.addEventListener('click', closeModal);
        }
    }

    // === XỬ LÝ POPUP CHI TIẾT SÁCH ===
    const bookDetailModal = document.getElementById('bookDetailModal');
    if (bookDetailModal) {
        const detailCloseBtn = document.getElementById('close-popup-btn');
        const recommendedBooks = document.querySelectorAll('.recommend-grid .book-card-simple');
        
        // Lấy các phần tử trong popup để điền dữ liệu
        const modalImage = document.getElementById('modal-book-image');
        const modalTitle = document.getElementById('modal-book-title');
        const modalAuthor = document.getElementById('modal-book-author');
        const modalDescription = document.getElementById('modal-book-description');
        const modalBorrowButton = document.getElementById('modal-borrow-button');

        // Gắn sự kiện click cho từng sách đề xuất
        recommendedBooks.forEach(book => {
            book.addEventListener('click', () => {
                // Lấy dữ liệu từ data-* attributes của sách được click
                const title = book.dataset.title;
                const author = book.dataset.author;
                const description = book.dataset.description;
                const imgSrc = book.dataset.imgSrc;
                const bookId = book.dataset.bookId;

                // Điền dữ liệu vào popup
                modalTitle.textContent = title;
                modalAuthor.textContent = author;
                modalDescription.textContent = description;
                modalImage.src = imgSrc;
                
                // Lưu book_id vào nút mượn sách để xử lý sau
                modalBorrowButton.dataset.bookId = bookId;

                // Hiển thị popup
                bookDetailModal.style.display = 'block';
            });
        });

        // Gắn sự kiện cho nút "Mượn sách" trong popup
        modalBorrowButton.addEventListener('click', function() {
            const bookId = this.dataset.bookId;
            if (!bookId) return;

            const formData = new FormData();
            formData.append('book_id', bookId);

            fetch('borrow.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(text => {
                if (text === 'login_required') {
                    alert('Bạn cần đăng nhập để thực hiện chức năng này.');
                    bookDetailModal.style.display = 'none';
                    openLoginModal();
                } else {
                    alert(text);
                    if (text.includes("thành công")) {
                        location.reload();
                    }
                }
            })
            .catch(error => {
                console.error('Lỗi khi gửi yêu cầu mượn sách:', error);
                alert('Đã xảy ra lỗi. Vui lòng thử lại.');
            });
        });
        
        // Đóng popup khi nhấn nút X
        if (detailCloseBtn) {
            detailCloseBtn.addEventListener('click', () => {
                bookDetailModal.style.display = 'none';
            });
        }
    }

    // Đóng các modal khi nhấn ra ngoài
    window.addEventListener('click', (event) => {
        const loginModal = document.getElementById('loginModal');
        const bookDetailModal = document.getElementById('bookDetailModal');
        if (loginModal && event.target == loginModal) {
            loginModal.style.display = 'none';
        }
        if (bookDetailModal && event.target == bookDetailModal) {
            bookDetailModal.style.display = 'none';
        }
    });
});

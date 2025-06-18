document.addEventListener('DOMContentLoaded', () => {
    // === XỬ LÝ MODAL ĐĂNG NHẬP ===
    const loginModal = document.getElementById('loginModal');
    if (loginModal) {
        // openLoginModal và closeModal đã được định nghĩa global trong <script> của borrow.php
        
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

        // Tự động mở modal nếu có loginErrorExists từ PHP
        if (typeof loginErrorExists !== 'undefined' && loginErrorExists) {
            openLoginModal();
        }
    }

    // === XỬ LÝ POPUP CHI TIẾT SÁCH (CHO SÁCH ĐỀ XUẤT TRÊN TRANG BORROW) ===
    const bookDetailModal = document.getElementById('bookDetailModal');
    if (bookDetailModal) {
        const detailCloseBtn = document.getElementById('close-popup-btn');
        const recommendedBooks = document.querySelectorAll('.recommend-grid .book-card-simple');
        
        // Lấy các phần tử trong popup để điền dữ liệu
        const modalImage = document.getElementById('modal-book-image');
        const modalTitle = document.getElementById('modal-book-title');
        const modalAuthor = document.getElementById('modal-book-author');
        const modalDescription = document.getElementById('modal-book-description');
        const modalBorrowBookIdInput = document.getElementById('modal-borrow-book-id');

        // ĐÃ THÊM: Lấy các phần tử cho Năm xuất bản, Ngôn ngữ, Thể loại
        const modalYearPopup = document.getElementById('modal-book-year-popup');
        const modalLanguagePopup = document.getElementById('modal-book-language-popup');
        const modalCategoryPopup = document.getElementById('modal-book-category-popup');


        // Gắn sự kiện click cho từng sách đề xuất
        recommendedBooks.forEach(book => {
            book.addEventListener('click', () => {
                // Lấy dữ liệu từ data- thuộc tính trên book-card-simple
                const bookId = book.dataset.bookId;
                const title = book.dataset.title;
                const author = book.dataset.author;
                const description = book.dataset.description;
                const imgSrc = book.dataset.imgSrc;
                // ĐÃ THÊM: Lấy data-year, data-category, data-language
                const year = book.dataset.year;
                const category = book.dataset.category;
                const language = book.dataset.language;


                modalTitle.textContent = title;
                modalAuthor.textContent = author;
                modalDescription.textContent = description;
                modalImage.src = imgSrc;
                
                // ĐÃ THÊM: Điền dữ liệu vào các phần tử popup
                if (modalYearPopup) modalYearPopup.textContent = year;
                if (modalLanguagePopup) modalLanguagePopup.textContent = language;
                if (modalCategoryPopup) modalCategoryPopup.textContent = category;
                
                // Cập nhật book_id cho form mượn trong modal
                if (modalBorrowBookIdInput) {
                    modalBorrowBookIdInput.value = bookId;
                }

                bookDetailModal.style.display = 'block';
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
        
        if (loginModal && loginModal.style.display === 'block' && event.target === loginModal) {
            loginModal.style.display = 'none';
        }
        else if (bookDetailModal && bookDetailModal.style.display === 'block' && event.target === bookDetailModal) {
            bookDetailModal.style.display = 'none';
        }
    });
});
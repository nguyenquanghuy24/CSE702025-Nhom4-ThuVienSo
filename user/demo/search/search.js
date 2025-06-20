// search.js

// Hàm mở modal đăng nhập
function openLoginModal() {
    const modal = document.getElementById('loginModal');
    if (modal) {
        modal.style.display = 'block';
        const redirectInput = modal.querySelector('input[name="redirect"]');
        if (redirectInput) {
            redirectInput.value = window.location.href; 
        }
    }
}

// Hàm đóng modal đăng nhập
function closeModal() {
    const modal = document.getElementById('loginModal');
    if (modal) {
        modal.style.display = 'none';
    }
}

// Hàm kiểm tra đăng nhập trước khi gửi form mượn sách
function checkLoginBeforeBorrow(event) {
    if (!isLoggedIn) { // 'isLoggedIn' được định nghĩa trong search.php
        event.preventDefault(); // Ngăn chặn form gửi đi
        openLoginModal(); // Mở modal đăng nhập
        return false;
    }
    return true; // Cho phép form gửi nếu đã đăng nhập
}

document.addEventListener('DOMContentLoaded', function() {
    // === Logic cho Modal Đăng nhập (đã có) ===
    const loginModal = document.getElementById('loginModal');
    if (loginModal) {
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

        if (typeof loginErrorExists !== 'undefined' && loginErrorExists) {
            openLoginModal();
        }
    }

    // === Logic cho Modal Chi tiết sách (đã có) ===
    const bookDetailModal = document.getElementById('bookDetailModal');
    if (bookDetailModal) {
        const detailCloseBtn = document.getElementById('close-popup-btn'); // Sử dụng ID này
        const recommendedBooks = document.querySelectorAll('.recommend-grid .book-card-simple'); // Nếu có trên trang này
        const bookItems = document.querySelectorAll('.book-list-item'); // Các item kết quả tìm kiếm
        
        const modalImage = document.getElementById('modal-book-image');
        const modalTitle = document.getElementById('modal-book-title');
        const modalAuthor = document.getElementById('modal-book-author');
        const modalDescription = document.getElementById('modal-book-description');
        const modalBorrowBookIdInput = document.getElementById('modal-borrow-book-id');

        const modalYearPopup = document.getElementById('modal-book-year'); // ID đã đổi trong search.php
        const modalLanguagePopup = document.getElementById('modal-book-language'); // ID đã đổi trong search.php
        const modalCategoryPopup = document.getElementById('modal-book-category'); // ID đã đổi trong search.php

        // Gắn sự kiện cho các item trong danh sách tìm kiếm
        bookItems.forEach(item => {
            item.addEventListener('click', function(e) {
                const title = item.dataset.title;
                const author = item.dataset.author;
                const year = item.dataset.year;
                const description = item.dataset.description;
                const imageSrc = item.dataset.imgSrc;
                const bookId = item.dataset.bookId;
                const bookStatusText = item.dataset.status;
                const bookCategoryText = item.dataset.category;
                const bookLanguageText = item.dataset.language;

                modalTitle.textContent = title;
                modalAuthor.textContent = author;
                modalDescription.textContent = description;
                modalImage.src = imageSrc;
                
                if (modalYearPopup) modalYearPopup.textContent = year;
                if (modalLanguagePopup) modalLanguagePopup.textContent = language;
                if (modalCategoryPopup) modalCategoryPopup.textContent = category;
                
                if (modalBorrowBookIdInput) {
                    modalBorrowBookIdInput.value = bookId;
                }

                // Cập nhật trạng thái nút mượn trong modal
                const modalBorrowBtnInModal = document.getElementById('modal-borrow-btn');
                const modalBorrowForm = document.querySelector('#bookDetailModal form'); // Lấy form lại
                if (modalBorrowBtnInModal) {
                    modalBorrowBtnInModal.classList.remove('disabled'); // Xóa class disabled cũ
                    // Gỡ bỏ listener cũ nếu có, để tránh gắn trùng lặp
                    if (modalBorrowForm) {
                        modalBorrowForm.removeEventListener('submit', checkLoginBeforeBorrow); 
                    }

                    if (bookStatusText === 'Có sẵn') {
                        modalBorrowBtnInModal.disabled = false;
                        modalBorrowBtnInModal.innerHTML = '<i class="fas fa-hand-holding-heart"></i> Mượn sách';
                        if (modalBorrowForm) {
                            modalBorrowForm.addEventListener('submit', checkLoginBeforeBorrow); // Gắn lại nếu có sẵn
                        }
                    } else if (bookStatusText === 'Đã mượn hết') {
                        modalBorrowBtnInModal.disabled = true;
                        modalBorrowBtnInModal.innerHTML = '<i class="fas fa-times"></i> Đã mượn hết';
                        modalBorrowBtnInModal.classList.add('disabled');
                    } else if (bookStatusText === 'Đang bảo trì') {
                        modalBorrowBtnInModal.disabled = true;
                        modalBorrowBtnInModal.innerHTML = '<i class="fas fa-hammer"></i> Đang bảo trì';
                        modalBorrowBtnInModal.classList.add('disabled');
                    } else {
                        modalBorrowBtnInModal.disabled = true;
                        modalBorrowBtnInModal.innerHTML = '<i class="fas fa-info-circle"></i> Trạng thái không xác định';
                        modalBorrowBtnInModal.classList.add('disabled');
                    }
                }

                bookDetailModal.style.display = 'block';
            });
        });
        
        // Nút đóng popup chi tiết sách
        const closePopupBtnLarge = document.querySelector('#bookDetailModal .close-btn-large'); // Lấy lại nút đóng
        if (closePopupBtnLarge) {
            closePopupBtnLarge.addEventListener('click', () => {
                bookDetailModal.style.display = 'none';
            });
        }
    }

    // Xử lý đóng modal khi click ra ngoài (đã có)
    window.addEventListener('click', (event) => {
        const loginModal = document.getElementById('loginModal');
        const bookDetailModal = document.getElementById('bookDetailModal');
        
        if (loginModal && loginModal.style.display === 'block' && event.target === loginModal) {
            closeModal();
        }
        else if (bookDetailModal && bookDetailModal.style.display === 'block' && event.target === bookDetailModal) {
            bookDetailModal.style.display = 'none';
        }
    });

    // === Logic CUỘN XUỐNG CUỐI TRANG cho nút Contact ===
    const contactScrollBtn = document.getElementById('contact-scroll-btn');
    if (contactScrollBtn) {
        contactScrollBtn.addEventListener('click', (e) => {
            e.preventDefault(); // Ngăn chặn hành vi mặc định của thẻ <a> (nếu có)
            const footer = document.getElementById('footer-section');
            if (footer) {
                footer.scrollIntoView({ behavior: 'smooth' });
            }
        });
    }
});
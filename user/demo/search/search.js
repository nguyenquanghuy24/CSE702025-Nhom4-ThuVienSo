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
    // KHÔNG CÓ FORM MƯỢN SÁCH TRỰC TIẾP TRÊN LIST KẾT QUẢ TÌM KIẾM NỮA

    // Gắn sự kiện cho nút 'Mượn sách' trong modal chi tiết sách
    const modalBorrowForm = document.querySelector('#bookDetailModal form');
    const modalBorrowBtn = document.getElementById('modal-borrow-btn');
    if (modalBorrowForm && modalBorrowBtn) {
        // Luôn gỡ bỏ listener cũ trước khi gắn lại để tránh gắn nhiều lần
        modalBorrowForm.removeEventListener('submit', checkLoginBeforeBorrow);

        if (!modalBorrowBtn.disabled) {
            modalBorrowForm.addEventListener('submit', checkLoginBeforeBorrow);
        } else {
            modalBorrowBtn.addEventListener('click', function(e) {
                e.preventDefault();
            });
        }
    }

    // Xử lý đóng modal khi click ra ngoài
    window.onclick = function(event) {
        const loginModal = document.getElementById('loginModal');
        const bookDetailModal = document.getElementById('bookDetailModal');

        if (loginModal && loginModal.style.display === 'block' && event.target === loginModal) {
            closeModal();
        } else if (bookDetailModal && bookDetailModal.style.display === 'block' && event.target === bookDetailModal) {
            bookDetailModal.style.display = 'none';
        }
    };

    // Xử lý đóng modal chi tiết sách bằng nút X
    const closePopupBtn = document.querySelector('#bookDetailModal .close-btn-large');
    if (closePopupBtn) {
        closePopupBtn.onclick = function() {
            document.getElementById('bookDetailModal').style.display = 'none';
        };
    }

    // Cập nhật thông tin modal chi tiết sách khi click vào book-list-item
    const bookItems = document.querySelectorAll('.book-list-item');
    bookItems.forEach(item => {
        item.addEventListener('click', function(e) {
            // Ngăn sự kiện click lan truyền nếu click vào nút/form mượn sách trong modal
            // (Không còn nút mượn trực tiếp trên list nữa)
            // if (e.target.closest('form.borrow-form') || e.target.closest('.btn-borrow')) {
            //     return;
            // }

            // Lấy dữ liệu từ data- thuộc tính trên div.book-list-item
            const title = item.dataset.title;
            const author = item.dataset.author;
            const year = item.dataset.year;
            const description = item.dataset.description;
            const imageSrc = item.dataset.imgSrc;
            const bookId = item.dataset.bookId;
            const bookStatusText = item.dataset.status;
            const bookCategoryText = item.dataset.category;
            const bookLanguageText = item.dataset.language;

            document.getElementById('modal-book-title').textContent = title;
            document.getElementById('modal-book-author').textContent = author;
            document.getElementById('modal-book-year').textContent = year;
            document.getElementById('modal-book-description').textContent = description;
            document.getElementById('modal-book-image').src = imageSrc;
            document.getElementById('modal-borrow-book-id').value = bookId; // Cập nhật ID sách cho form mượn trong modal
            document.getElementById('modal-book-category').textContent = bookCategoryText;
            document.getElementById('modal-book-language').textContent = bookLanguageText;

            // Cập nhật trạng thái nút mượn trong modal
            const modalBorrowBtnInModal = document.getElementById('modal-borrow-btn');
            if (modalBorrowBtnInModal) {
                modalBorrowBtnInModal.classList.remove('disabled'); // Xóa class disabled cũ
                if (modalBorrowForm) {
                    modalBorrowForm.removeEventListener('submit', checkLoginBeforeBorrow); // Gỡ bỏ listener cũ
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

            document.getElementById('bookDetailModal').style.display = 'block';
        });
    });
});
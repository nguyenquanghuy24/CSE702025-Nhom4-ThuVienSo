document.addEventListener('DOMContentLoaded', function() {
    const bookDetailModal = document.getElementById('bookDetailModal');

    if (!bookDetailModal) return;

    const modalImage = document.getElementById('modal-book-image');
    const modalTitle = document.getElementById('modal-book-title');
    const modalAuthor = document.getElementById('modal-book-author');
    const modalYear = document.getElementById('modal-book-year');
    const modalLanguage = document.getElementById('modal-book-language');
    const modalCategory = document.getElementById('modal-book-category');
    const modalDescription = document.getElementById('modal-book-description');
    const modalBorrowBookIdInput = document.getElementById('modal-borrow-book-id');
    const modalBorrowBtn = document.getElementById('modal-borrow-btn');
    const modalBorrowForm = document.querySelector('#bookDetailModal form');

    document.querySelectorAll('.book-list-item').forEach(item => {
        item.addEventListener('click', function() {
            modalTitle.textContent = item.dataset.title;
            modalAuthor.textContent = item.dataset.author;
            modalYear.textContent = item.dataset.year;
            modalLanguage.textContent = item.dataset.language;
            modalCategory.textContent = item.dataset.category;
            modalDescription.textContent = item.dataset.description;
            modalImage.src = item.dataset.imgSrc;
            modalBorrowBookIdInput.value = item.dataset.bookId;

            const status = item.dataset.status;
            modalBorrowBtn.classList.remove('disabled');
            modalBorrowBtn.disabled = false;

            if (status === 'Có sẵn') {
                modalBorrowBtn.innerHTML = '<i class="fas fa-hand-holding-heart"></i> Mượn sách';
            } else {
                modalBorrowBtn.disabled = true;
                modalBorrowBtn.classList.add('disabled');
                modalBorrowBtn.innerHTML = `<i class="fas fa-times"></i> ${status}`;
            }

            bookDetailModal.style.display = 'block';
        });
    });

    // Close modal
    const closeBtn = document.querySelector('.close-btn-large');
    if (closeBtn) {
        closeBtn.addEventListener('click', () => {
            bookDetailModal.style.display = 'none';
        });
    }

    window.addEventListener('click', (e) => {
        if (e.target === bookDetailModal) {
            bookDetailModal.style.display = 'none';
        }
    });

    // Scroll đến cuối trang khi click "Contact"
    const contactBtn = document.getElementById('contact-scroll-btn');
    if (contactBtn) {
        contactBtn.addEventListener('click', (e) => {
            e.preventDefault();
            document.getElementById('footer-section').scrollIntoView({ behavior: 'smooth' });
        });
    }
});

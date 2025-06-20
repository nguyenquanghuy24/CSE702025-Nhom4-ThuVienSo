document.addEventListener('DOMContentLoaded', () => {
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

    const bookDetailModal = document.getElementById('bookDetailModal');
    if (bookDetailModal) {
        const detailCloseBtn = document.getElementById('close-popup-btn');
        const recommendedBooks = document.querySelectorAll('.recommend-grid .book-card-simple');
        
        const modalImage = document.getElementById('modal-book-image');
        const modalTitle = document.getElementById('modal-book-title');
        const modalAuthor = document.getElementById('modal-book-author');
        const modalDescription = document.getElementById('modal-book-description');
        const modalBorrowBookIdInput = document.getElementById('modal-borrow-book-id');

        const modalYearPopup = document.getElementById('modal-book-year-popup');
        const modalLanguagePopup = document.getElementById('modal-book-language-popup');
        const modalCategoryPopup = document.getElementById('modal-book-category-popup');

        recommendedBooks.forEach(book => {
            book.addEventListener('click', () => {

                const bookId = book.dataset.bookId;
                const title = book.dataset.title;
                const author = book.dataset.author;
                const description = book.dataset.description;
                const imgSrc = book.dataset.imgSrc;
 
                const year = book.dataset.year;
                const category = book.dataset.category;
                const language = book.dataset.language;


                modalTitle.textContent = title;
                modalAuthor.textContent = author;
                modalDescription.textContent = description;
                modalImage.src = imgSrc;
                

                if (modalYearPopup) modalYearPopup.textContent = year;
                if (modalLanguagePopup) modalLanguagePopup.textContent = language;
                if (modalCategoryPopup) modalCategoryPopup.textContent = category;
                

                if (modalBorrowBookIdInput) {
                    modalBorrowBookIdInput.value = bookId;
                }

                bookDetailModal.style.display = 'block';
            });
        });
        

        if (detailCloseBtn) {
            detailCloseBtn.addEventListener('click', () => {
                bookDetailModal.style.display = 'none';
            });
        }
    }


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

    // Scroll to footer when Contact is clicked
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
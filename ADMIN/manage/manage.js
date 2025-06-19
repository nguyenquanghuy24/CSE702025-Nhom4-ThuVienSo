document.addEventListener('DOMContentLoaded', () => {
  // Login Modal functionality
  const loginModal = document.querySelector('#loginModal');
  const loginLink = document.querySelector('.auth-link');
  const closeLoginBtn = loginModal ? loginModal.querySelector('.close-btn') : null;

  if (loginLink) {
      loginLink.addEventListener('click', (e) => {
          e.preventDefault();
          if (loginModal) loginModal.style.display = 'block';
      });
  }

  if (closeLoginBtn) {
      closeLoginBtn.addEventListener('click', () => {
          if (loginModal) loginModal.style.display = 'none';
      });
  }

  // Global functions for login modal (to be called from inline onclick)
  window.openLoginModal = function() {
    if (loginModal) loginModal.style.display = 'block';
  }

  window.closeModal = function() { // This is for login modal
    if (loginModal) loginModal.style.display = 'none';
  }

  // Book List Selection and Content Display
  const bookItems = document.querySelectorAll('.book-item');
  const noBookSelected = document.getElementById('noBookSelected');
  const bookDetailsContent = document.getElementById('bookDetailsContent');

  const detailBookImage = document.getElementById('detailBookImage');
  const detailBookTitle = document.getElementById('detailBookTitle');
  const detailBookAuthor = document.getElementById('detailBookAuthor');
  const detailBookISBN = document.getElementById('detailBookISBN');
  const detailBookQuantity = document.getElementById('detailBookQuantity');
  const detailBookAvailable = document.getElementById('detailBookAvailable');
  const detailBookDescription = document.getElementById('detailBookDescription');
  const borrowerList = document.getElementById('borrowerList');


  bookItems.forEach(item => {
      item.addEventListener('click', () => {
          // Remove 'active' class from all items
          bookItems.forEach(i => i.classList.remove('active'));
          // Add 'active' class to the clicked item
          item.classList.add('active');

          // Hide "No Book Selected" and show details
          noBookSelected.style.display = 'none';
          bookDetailsContent.style.display = 'block';

          // Populate book details panel
          detailBookImage.src = item.dataset.image;
          detailBookTitle.textContent = item.dataset.title;
          detailBookAuthor.textContent = item.dataset.author;
          detailBookISBN.textContent = item.dataset.isbn;
          detailBookQuantity.textContent = item.dataset.quantity;
          detailBookAvailable.textContent = item.dataset.available;
          detailBookDescription.textContent = item.dataset.description;

          // Populate borrowers list
          const borrowers = JSON.parse(item.dataset.borrowers);
          borrowerList.innerHTML = ''; // Clear previous borrowers

          if (borrowers.length > 0) {
              borrowers.forEach(borrower => {
                  const li = document.createElement('li');
                  li.classList.add('borrower-item');
                  li.innerHTML = `
                      <div>
                          <p class="name">${borrower.name}</p>
                          <p>ID: ${borrower.user_id}</p>
                      </div>
                      <div class="dates">
                          <p>Mượn: ${borrower.borrow_date}</p>
                          <p>Hạn trả: ${borrower.due_date}</p>
                      </div>
                  `;
                  borrowerList.appendChild(li);
              });
          } else {
              const li = document.createElement('li');
              li.textContent = 'Không có ai đang mượn sách này.';
              borrowerList.appendChild(li);
          }
      });
  });

  // Automatically load the first book's details if available
  if (bookItems.length > 0) {
      bookItems[0].click(); // Simulate click on the first item
  } else {
      noBookSelected.style.display = 'flex'; // Show no book selected message
      bookDetailsContent.style.display = 'none';
  }

  // Search functionality (simple client-side filter)
  const bookSearchInput = document.getElementById('bookSearchInput');
  bookSearchInput.addEventListener('keyup', (e) => {
      const searchTerm = e.target.value.toLowerCase();
      bookItems.forEach(item => {
          const title = item.dataset.title.toLowerCase();
          const author = item.dataset.author.toLowerCase();
          if (title.includes(searchTerm) || author.includes(searchTerm)) {
              item.style.display = 'flex'; // Show item
          } else {
              item.style.display = 'none'; // Hide item
          }
      });
  });
});
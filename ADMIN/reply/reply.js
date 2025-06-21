document.addEventListener('DOMContentLoaded', () => {
  // Login Modal (retained existing functionality)
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

  window.openLoginModal = function() {
    if (loginModal) loginModal.style.display = 'block';
  }

  window.closeModal = function() {
    if (loginModal) loginModal.style.display = 'none';
  }

  const composeModal = document.getElementById('composeModal');
  const closeComposeModalBtn = composeModal ? composeModal.querySelector('.close-button') : null; // Use .close-button
  const cancelComposeBtn = composeModal ? composeModal.querySelector('.cancel-compose-btn') : null;
  const replyButton = document.getElementById('replyButton'); // The reply button in the right panel

  // Ensure compose modal is hidden initially
  if (composeModal) {
      composeModal.style.display = 'none';
  }

  if (replyButton) {
      replyButton.addEventListener('click', () => {
          // Get data from the currently displayed conversation
          const detailSenderName = document.getElementById('detailSenderName').textContent;
          const detailSenderEmail = document.getElementById('detailSenderEmail').textContent;
          const detailSubject = document.getElementById('detailSubject').textContent;
          // const detailMessage = document.getElementById('detailMessage').textContent; // Không cần lấy nội dung tin nhắn gốc nữa
          // const detailDate = document.getElementById('detailDate').dataset.fullDate; // Không cần lấy ngày tin nhắn gốc nữa

          if (composeModal) {
              document.getElementById('composeTo').value = `${detailSenderName} ${detailSenderEmail}`;
              document.getElementById('composeSubject').value = `Re: ${detailSubject}`;
              // Xóa dòng thêm nội dung phản hồi gốc
              document.getElementById('composeMessage').value = ''; // Đặt giá trị rỗng để không có nội dung gốc
              composeModal.style.display = 'flex'; // Use 'flex' for centering
          }
      });
  }

  if (closeComposeModalBtn) {
      closeComposeModalBtn.addEventListener('click', () => {
          if (composeModal) composeModal.style.display = 'none';
      });
  }

  if (cancelComposeBtn) {
      cancelComposeBtn.addEventListener('click', () => {
          if (composeModal) composeModal.style.display = 'none';
      });
  }

  window.addEventListener('click', (e) => {
      if (e.target === composeModal) {
          composeModal.style.display = 'none';
      }
  });


  // Inbox Item Selection and Content Display
  const inboxItems = document.querySelectorAll('.inbox-item');
  const noConversationSelected = document.getElementById('noConversationSelected');
  const conversationDetails = document.getElementById('conversationDetails');

  const detailSubject = document.getElementById('detailSubject');
  const detailSenderName = document.getElementById('detailSenderName');
  const detailSenderEmail = document.getElementById('detailSenderEmail');
  const detailDate = document.getElementById('detailDate');
  const detailMessage = document.getElementById('detailMessage');
  const senderAvatar = conversationDetails.querySelector('.sender-avatar');


  inboxItems.forEach(item => {
      item.addEventListener('click', () => {
          // Remove 'active' class from all items
          inboxItems.forEach(i => i.classList.remove('active'));
          // Add 'active' class to the clicked item
          item.classList.add('active');

          // Hide "No Conversations Selected" and show details
          noConversationSelected.style.display = 'none';
          conversationDetails.style.display = 'block';

          // Populate details panel with data from clicked item
          detailSubject.textContent = item.dataset.subject;
          detailSenderName.textContent = item.dataset.sender;
          detailSenderEmail.textContent = `<${item.dataset.email}>`; // Format email with angle brackets
          detailMessage.textContent = item.dataset.message;

          // Format date for display in the main panel: "lúc HH:MM DD tháng M,YYYY"
          const fullDate = new Date(item.dataset.date);
          const time = fullDate.toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit', hour12: false });
          // Lấy ngày tháng năm theo định dạng dd/mm/yyyy
          const day = fullDate.getDate();
          const month = fullDate.getMonth() + 1; // getMonth() trả về 0-11
          const year = fullDate.getFullYear();
          detailDate.textContent = `lúc ${time} ${day} tháng ${month}, ${year}`; // Format "lúc 10:30 15 tháng 6, 2025"
          detailDate.dataset.fullDate = item.dataset.date; // Store full date for reply message


          // Set sender avatar initial
          const senderInitial = item.dataset.sender.charAt(0).toUpperCase();
          senderAvatar.textContent = senderInitial;
      });
  });

  // This block ensures a message is selected or "No Conversation" is shown on load.
  // It should simulate a click on the first item if available, else show the no conversation message.
  if (inboxItems.length > 0) {
      inboxItems[0].click(); // Simulate click on the first item to display its content
  } else {
      noConversationSelected.style.display = 'flex'; // Show no conversation message
      conversationDetails.style.display = 'none';
  }
});


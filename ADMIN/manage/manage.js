document.querySelectorAll(".book-item").forEach(item => {
    item.addEventListener("click", () => {
        // Lấy thông tin sách từ attributes
        const title = item.dataset.title;
        const author = item.dataset.author;
        const isbn = item.dataset.isbn;
        const quantity = item.dataset.quantity;
        const available = item.dataset.available;
        const description = item.dataset.description;
        const image = item.dataset.image;
        const borrowers = JSON.parse(item.dataset.borrowers);

        // Cập nhật giao diện
        document.getElementById("detailBookTitle").textContent = title;
        document.getElementById("detailBookAuthor").textContent = author;
        document.getElementById("detailBookISBN").textContent = isbn;
        document.getElementById("detailBookQuantity").textContent = quantity;
        document.getElementById("detailBookAvailable").textContent = available;
        document.getElementById("detailBookDescription").textContent = description;
        document.getElementById("detailBookImage").src = image;

        // Xử lý danh sách người mượn
        const borrowerList = document.getElementById("borrowerList");
        borrowerList.innerHTML = "";
        if (borrowers.length === 0) {
            borrowerList.innerHTML = "<li>Không có ai đang mượn sách này.</li>";
        } else {
            borrowers.forEach(b => {
                const li = document.createElement("li");
                li.innerHTML = `<strong>${b.name}</strong> (ID: ${b.user_id})<br>
                    Mượn: ${b.borrow_date} - Trả: ${b.due_date}`;
                borrowerList.appendChild(li);
            });
        }

        document.getElementById("noBookSelected").style.display = "none";
        document.getElementById("bookDetailsContent").style.display = "block";
    });
});

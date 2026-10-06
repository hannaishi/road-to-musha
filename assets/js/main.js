const searchModal = document.querySelector(".js-search-modal");
const searchOpenButton = document.querySelector(".js-search-modal-open-button");
const searchCloseButton = document.querySelector(
    ".js-search-modal-close-button",
);

if (searchModal && searchOpenButton && searchCloseButton) {
    searchOpenButton.addEventListener("click", () => {
        searchModal.showModal();
    });

    searchCloseButton.addEventListener("click", () => {
        searchModal.close();
    });
}

// Contact Form 7：送信完了メッセージを5秒後に非表示
document.addEventListener("wpcf7mailsent", (event) => {
    const response = event.target.querySelector(".wpcf7-response-output");

    if (!response) return;

    setTimeout(() => {
        response.style.display = "none";
    }, 3000);
});

document.addEventListener("DOMContentLoaded", function () {
    const popup = document.getElementById("userChoicePopup");
    const closeButtons = document.querySelectorAll("[data-close-user-popup]");
    const openButtons = document.querySelectorAll("[data-open-user-popup]");

    if (!popup) {
        return;
    }

    function openUserPopup() {
        popup.classList.add("active");
        document.body.classList.add("user-popup-open");
    }

    function closeUserPopup() {
        popup.classList.remove("active");
        document.body.classList.remove("user-popup-open");
    }

    openButtons.forEach(function (button) {
        button.addEventListener("click", function (event) {
            event.preventDefault();
            openUserPopup();
        });
    });

    closeButtons.forEach(function (button) {
        button.addEventListener("click", closeUserPopup);
    });

    document.addEventListener("keydown", function (event) {
        if (event.key === "Escape" && popup.classList.contains("active")) {
            closeUserPopup();
        }
    });

    // Automatically open when success message is present
    const successMessage = document.querySelector(
        ".alert-success, [data-registration-success]"
    );

    if (successMessage) {
        openUserPopup();
    }

    window.openUserChoicePopup = openUserPopup;
    window.closeUserChoicePopup = closeUserPopup;
});
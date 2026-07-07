document.addEventListener("DOMContentLoaded", function () {
    const menuBtn = document.getElementById("mlAdminMenuToggle");
    const sidebar = document.querySelector(".ml-admin-sidebar");

    if (menuBtn && sidebar) {
        menuBtn.addEventListener("click", function () {
            sidebar.classList.toggle("show");
        });
    }
});
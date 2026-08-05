document.addEventListener("DOMContentLoaded", function () {

    /*===========================
      Mobile Sidebar Toggle
    ===========================*/
    const menuBtn = document.getElementById("mlAdminMenuToggle");
    const sidebar = document.querySelector(".ml-user-sidebar");

    if (menuBtn && sidebar) {
        menuBtn.addEventListener("click", function () {
            sidebar.classList.toggle("show");
        });
    }


    /*===========================
      Success Message Auto-Close
      (only runs if a .ml-user-success-alert exists on the page)
    ===========================*/
    const successAlert = document.getElementById("mlUserSuccessAlert");
    const successClose = document.getElementById("mlUserSuccessClose");

    if (successAlert) {

        if (successClose) {
            successClose.addEventListener("click", function () {
                successAlert.classList.add("hide");

                setTimeout(function () {
                    successAlert.remove();
                }, 300);
            });
        }

        setTimeout(function () {
            successAlert.classList.add("hide");

            setTimeout(function () {
                successAlert.remove();
            }, 300);
        }, 4000);
    }

});

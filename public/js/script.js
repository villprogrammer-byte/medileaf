// --------------------------cart functio------------------------------------------

function openCart() {

    if (cartDrawer) {
        cartDrawer.classList.add("active");
    }

    if (cartOverlay) {
        cartOverlay.classList.add("active");
    }

    const cartBtn = document.querySelector(".ml-cart-btn");
    if (cartBtn) {
        cartBtn.classList.add("cart-active");
    }
}
// ----------------------------------------------------------
function closeCart() {

    if (cartDrawer) {
        cartDrawer.classList.remove("active");
    }

    if (cartOverlay) {
        cartOverlay.classList.remove("active");
    }

    const cartBtn = document.querySelector(".ml-cart-btn");
    if (cartBtn) {
        cartBtn.classList.remove("cart-active");
    }
}


// -------------------------page reloader------------------------------------

window.addEventListener("load", function () {
    const loader = document.getElementById("mlLoader");

    if (!loader) return;

    if (sessionStorage.getItem("medileafLoaderShown")) {
        loader.style.display = "none";
        return;
    }

    setTimeout(function () {
        loader.classList.add("hide");
        sessionStorage.setItem("medileafLoaderShown", "true");
    }, 2000);
});


// -------------------------------switch Button-----------------------------------------------------

document.querySelectorAll(".ml-auth-switch").forEach(function (switchBox) {
    const tabs = switchBox.querySelectorAll(".ml-auth-tab");

    tabs.forEach(function (tab) {
        tab.addEventListener("click", function () {
            tabs.forEach(function (item) {
                item.classList.remove("active");
            });

            this.classList.add("active");

            if (this.dataset.target === "admin") {
                switchBox.classList.add("admin-active");
            } else {
                switchBox.classList.remove("admin-active");
            }
        });
    });
});

// -------------------------MENU NAV------------------------------------------------

document.addEventListener("DOMContentLoaded", function () {
    const menuBtn = document.getElementById("mlNewMenuBtn");
    const nav = document.getElementById("mlNewNav");

    if (menuBtn && nav) {
        menuBtn.addEventListener("click", function () {
            nav.classList.toggle("show");
            menuBtn.classList.toggle("active");
        });
    }
});

// ------------------------FAQ--------------------------------------------------

document.addEventListener("DOMContentLoaded", function () {
    const faqItems = document.querySelectorAll(".ml-faq-simple-item");

    faqItems.forEach(function (item) {
        const btn = item.querySelector(".ml-faq-simple-question");

        btn.addEventListener("click", function () {

            if (item.classList.contains("active")) {
                item.classList.remove("active");
                return;
            }

            faqItems.forEach(function (otherItem) {
                otherItem.classList.remove("active");
            });

            item.classList.add("active");
        });
    });
});

// -----------------------------------Page scroller------------------------------------------------

const scrollTopBtn = document.getElementById("mlScrollTop");

scrollTopBtn.style.display = "none";

window.addEventListener("scroll", () => {

    const scrollPosition = window.scrollY + window.innerHeight;
    const pageHeight = document.documentElement.scrollHeight;

    // Footer ke paas (100px pehle) button show hoga
    if (scrollPosition >= pageHeight - 100) {
        scrollTopBtn.style.display = "flex";
    } else {
        scrollTopBtn.style.display = "none";
    }

});

scrollTopBtn.addEventListener("click", () => {

    window.scrollTo({
        top: 0,
        behavior: "smooth"
    });

});


/* =============submitpopup========================== */

function closeSuccessPopup() {
    const popup = document.getElementById("successPopup");

    if (popup) {
        popup.style.display = "none";
    }
}

// =============================datepiker====================================

document.addEventListener("DOMContentLoaded", function () {

    if (typeof flatpickr !== "undefined") {

        flatpickr(".dob-picker", {
            dateFormat: "d / m / Y",
            maxDate: "today",
            allowInput: true,
            disableMobile: true
        });

    }

});

// ===================================conatct=======================================

document.addEventListener("DOMContentLoaded", function () {

    const contactSelect = document.getElementById("contactReasonSelect");

    if (!contactSelect) {
        return;
    }


    const trigger = contactSelect.querySelector(
        ".ml-contact-select-trigger"
    );


    const label = document.getElementById(
        "contactReasonLabel"
    );


    const input = document.getElementById(
        "contactReasonInput"
    );


    const options = contactSelect.querySelectorAll(
        ".ml-contact-option"
    );


    trigger.addEventListener("click", function () {

        contactSelect.classList.toggle("open");

    });


    options.forEach(function (option) {

        option.addEventListener("click", function () {

            const value = this.dataset.value;

            label.textContent = value;

            input.value = value;


            options.forEach(function (item) {

                item.classList.remove("active");

            });


            this.classList.add("active");

            contactSelect.classList.remove("open");

        });

    });


    document.addEventListener("click", function (event) {

        if (!contactSelect.contains(event.target)) {

            contactSelect.classList.remove("open");

        }

    });

});
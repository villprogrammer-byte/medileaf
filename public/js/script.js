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

            if (this.dataset.target === "vendor") {
                switchBox.classList.add("vendor-active");
            } else {
                switchBox.classList.remove("vendor-active");
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

document.getElementById("mlScrollTop").addEventListener("click", function () {

    window.scrollTo({
        top: 0,
        behavior: "smooth"
    });

});
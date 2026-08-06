document.addEventListener("DOMContentLoaded", function () {
    const loader = document.getElementById("medileafLoader");

    if (!loader) {
        return;
    }

    const isHomePage =
        window.location.pathname === "/" ||
        window.location.pathname === "/home";

    const loaderAlreadyShown =
        sessionStorage.getItem("medileaf_loader_shown") === "true";

    if (!isHomePage || loaderAlreadyShown) {
        loader.remove();
        document.body.classList.remove("ml-page-is-loading");
        return;
    }

    document.body.classList.add("ml-page-is-loading");

    sessionStorage.setItem("medileaf_loader_shown", "true");

    window.setTimeout(function () {
        loader.classList.add("is-hidden");
        document.body.classList.remove("ml-page-is-loading");

        window.setTimeout(function () {
            loader.remove();
        }, 700);
    }, 2500);
});
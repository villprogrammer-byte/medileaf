document.addEventListener("DOMContentLoaded", function () {
    const loader = document.getElementById("medileafLoader");

    if (!loader) {
        console.log("Loader element not found");
        return;
    }

    document.body.classList.add("ml-page-is-loading");

    window.setTimeout(function () {
        loader.classList.add("is-hidden");

        document.body.classList.remove("ml-page-is-loading");

        window.setTimeout(function () {
            loader.remove();
        }, 700);

    }, 2500);
});
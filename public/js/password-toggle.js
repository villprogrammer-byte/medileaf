document.addEventListener("DOMContentLoaded", function () {

    document.querySelectorAll(".password-toggle").forEach(function (toggle) {

        const input = document.getElementById(toggle.dataset.target);
        const icon = toggle.querySelector("i");

        if (!input || !icon) return;

        toggle.addEventListener("click", function () {

            const isHidden = input.type === "password";

            input.type = isHidden ? "text" : "password";

            icon.classList.toggle("bi-eye", isHidden);
            icon.classList.toggle("bi-eye-slash", !isHidden);

            toggle.setAttribute("aria-label", isHidden ? "Hide password" : "Show password");

        });

    });

});

document.addEventListener("DOMContentLoaded", function () {

    const toggle = document.querySelector(".toggle-password");
    const password = document.getElementById("password");

    if (toggle) {
        toggle.addEventListener("click", function () {
            if (password.type === "password") {
                password.type = "text";
                this.innerHTML = '<i class="bi bi-eye-slash"></i>';
            } else {
                password.type = "password";
                this.innerHTML = '<i class="bi bi-eye"></i>';
            }
        });
    }

});
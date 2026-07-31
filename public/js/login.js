document.addEventListener("DOMContentLoaded", function () {

    const loginForm = document.getElementById("loginForm");

    const passwordInput =
        document.getElementById("password");

    const passwordToggle =
        document.getElementById("passwordToggle");

    const passwordToggleIcon =
        document.getElementById("passwordToggleIcon");

    const signInButton =
        document.getElementById("signInButton");


    /*
    |--------------------------------------------------------------------------
    | Password Show / Hide
    |--------------------------------------------------------------------------
    */

    if (
        passwordInput &&
        passwordToggle &&
        passwordToggleIcon
    ) {

        passwordToggle.addEventListener("click", function () {

            const passwordIsHidden =
                passwordInput.type === "password";

            passwordInput.type =
                passwordIsHidden ? "text" : "password";

            passwordToggleIcon.classList.toggle(
                "bi-eye",
                passwordIsHidden
            );

            passwordToggleIcon.classList.toggle(
                "bi-eye-slash",
                !passwordIsHidden
            );

            passwordToggle.setAttribute(
                "aria-label",
                passwordIsHidden
                    ? "Hide password"
                    : "Show password"
            );

        });

    }


    /*
    |--------------------------------------------------------------------------
    | Form Loading State
    |--------------------------------------------------------------------------
    */

    if (loginForm && signInButton) {

        loginForm.addEventListener("submit", function () {

            signInButton.disabled = true;

            signInButton.innerHTML = `
                <span
                    class="spinner-border spinner-border-sm"
                    aria-hidden="true">
                </span>

                <span>
                    Checking & Sending OTP...
                </span>
            `;

        });

    }

});
document.addEventListener("DOMContentLoaded", function () {

    const loginForm = document.getElementById("loginForm");

    const signInButton =
        document.getElementById("signInButton");


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
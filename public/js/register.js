document.addEventListener("DOMContentLoaded", function () {

    // ============ DOB: click anywhere opens calendar + 18+ validation ============
    const dob = document.getElementById("dob");

    if (dob) {
        dob.addEventListener("click", function () {
            try { this.showPicker(); } catch (e) { /* not supported, ignore */ }
        });

        dob.addEventListener("change", function () {
            const birth = new Date(this.value);
            const today = new Date();
            let age = today.getFullYear() - birth.getFullYear();
            const month = today.getMonth() - birth.getMonth();

            if (month < 0 || (month === 0 && today.getDate() < birth.getDate())) {
                age--;
            }

            if (age < 18) {
                alert("You must be at least 18 years old to create an account.");
                this.value = "";
                this.focus();
            }
        });
    }

    // ============ Registration form -> AJAX submit -> show verify modal ============
    const form = document.getElementById("registerForm");
    const overlay = document.getElementById("verifyModalOverlay");
    const emailDisplay = document.getElementById("verifyModalEmail");
    const resendBtn = document.getElementById("verifyModalResend");
    const continueBtn = document.getElementById("verifyModalContinue");
    const closeBtn = document.getElementById("verifyModalClose");

    const csrfTokenEl = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = csrfTokenEl
        ? csrfTokenEl.getAttribute("content")
        : document.querySelector('input[name="_token"]').value;

    let registeredEmail = "";

    function clearFieldErrors() {
        document.querySelectorAll(".ajax-error").forEach(el => el.remove());
    }

    function showFieldErrors(errors) {
        clearFieldErrors();
        Object.keys(errors).forEach(function (field) {
            const input = form.querySelector(`[name="${field}"]`);
            const message = errors[field][0];

            if (input) {
                const wrap = input.closest(".form-group") || input.parentElement.parentElement;
                const errEl = document.createElement("small");
                errEl.className = "text-danger d-block mt-2 ajax-error";
                errEl.textContent = message;
                wrap.appendChild(errEl);
            } else if (field === "cf-turnstile-response") {
                const el = document.createElement("div");
                el.className = "text-danger small mb-3 ajax-error";
                el.textContent = message;
                form.querySelector(".cf-turnstile").insertAdjacentElement("afterend", el);
            }
        });

        // Scroll to first error
        const firstError = document.querySelector(".ajax-error");
        if (firstError) {
            firstError.scrollIntoView({ behavior: "smooth", block: "center" });
        }
    }

    function openModal() {
        overlay.classList.add("active");
        document.body.style.overflow = "hidden";
    }

    function closeModal() {
        overlay.classList.remove("active");
        document.body.style.overflow = "";
    }

    if (form) {
        form.addEventListener("submit", function (e) {
            e.preventDefault();

            clearFieldErrors();

            const submitBtn = form.querySelector('button[type="submit"]');
            const originalHtml = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span>Creating account...</span>';

            const formData = new FormData(form);

            fetch(form.action, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                    "Accept": "application/json",
                },
                body: formData,
            })
                .then(async (response) => {
                    const data = await response.json();

                    if (!response.ok) {
                        if (response.status === 422 && data.errors) {
                            showFieldErrors(data.errors);
                        } else {
                            alert(data.message || "Something went wrong. Please try again.");
                        }
                        return;
                    }

                    registeredEmail = data.email;
                    emailDisplay.textContent = registeredEmail;
                    openModal();
                })
                .catch(() => {
                    alert("Network error. Please check your connection and try again.");
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalHtml;
                });
        });
    }

    // ============ Resend verification email ============
    if (resendBtn) {
        resendBtn.addEventListener("click", function () {
            const originalHtml = resendBtn.innerHTML;
            resendBtn.disabled = true;
            resendBtn.innerHTML = '<i class="bi bi-arrow-repeat"></i><span>Sending...</span>';

            fetch("/email/verification-notification", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                    "Accept": "application/json",
                },
            })
                .then(async (response) => {
                    if (response.ok) {
                        resendBtn.innerHTML = '<i class="bi bi-check-lg"></i><span>Sent!</span>';
                    } else {
                        resendBtn.innerHTML = '<i class="bi bi-exclamation-triangle"></i><span>Try again</span>';
                    }
                })
                .catch(() => {
                    resendBtn.innerHTML = '<i class="bi bi-exclamation-triangle"></i><span>Try again</span>';
                })
                .finally(() => {
                    setTimeout(() => {
                        resendBtn.disabled = false;
                        resendBtn.innerHTML = originalHtml;
                    }, 4000);
                });
        });
    }

    // ============ Continue button ============
    if (continueBtn) {
        continueBtn.addEventListener("click", function () {
            window.location.href = "/";
        });
    }

    // ============ Close button ============
    if (closeBtn) {
        closeBtn.addEventListener("click", closeModal);
    }

});
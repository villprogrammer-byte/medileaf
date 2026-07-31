<!-- User Choice Popup -->
<div class="user-choice-popup" id="userChoicePopup">
    <div class="user-choice-overlay" data-close-user-popup></div>

    <div class="user-choice-modal">

        <button type="button" class="user-choice-close" data-close-user-popup aria-label="Close popup">
            <i class="bi bi-x-lg"></i>
        </button>

        <!-- Left Side -->
        <div class="user-choice-left">

            <div class="user-choice-brand">
                <img src="{{ asset('img//medileaf-logo.webp') }}" alt="MediLeaf" class="user-choice-logo">

                <p class="user-choice-tagline">
                    AUSTRALIA'S TRUSTED<br>
                    MEDICAL STORE
                </p>

                <span class="brand-line"></span>
            </div>

            <div class="user-choice-left-content">
                <h2>
                    Your <span>health</span>,<br>
                    our priority.
                </h2>

                <p>
                    Sign in or create an account to continue your journey
                    and access exclusive health solutions.
                </p>
            </div>

            <div class="user-choice-product-image">
                <img src="{{ asset('img/user-popup-products.webp') }}" alt="MediLeaf healthcare products">
            </div>

        </div>

        <!-- Right Side -->
        <div class="user-choice-right">

            <div class="user-choice-top-icon">
                <i class="bi bi-person"></i>
                <span>
                    <i class="bi bi-leaf-fill"></i>
                </span>
            </div>

            <div class="user-choice-heading">
                <h2>
                    Are you already a user<br>
                    or new here?
                </h2>

                <div class="heading-divider">
                    <span></span>
                    <i class="bi bi-leaf-fill"></i>
                    <span></span>
                </div>

                <p>
                    Choose how you'd like to continue with Medileaf.
                    Start a consultation or shop for your healthcare products.
                </p>
            </div>

            <div class="user-choice-cards">

                <!-- Existing User -->
                <div class="choice-card existing-user-card">

                    <div class="choice-card-icon">
                        <i class="bi bi-person"></i>

                        <span class="choice-icon-badge">
                            <i class="bi bi-check-lg"></i>
                        </span>
                    </div>

                    <h3>Already a User</h3>

                    <p>
                        Login to your existing<br>
                        account
                    </p>

                    <a href="{{ route('login') }}" class="choice-button choice-button-filled">
                        <span>
                            <i class="bi bi-lock"></i>
                            Login
                        </span>

                        <i class="bi bi-arrow-right"></i>
                    </a>

                </div>

                <!-- New User -->
                <div class="choice-card new-user-card">

                    <div class="choice-card-icon">
                        <i class="bi bi-person"></i>

                        <span class="choice-icon-badge">
                            <i class="bi bi-plus-lg"></i>
                        </span>
                    </div>

                    <h3>New User</h3>

                    <p>
                        Create a new account<br>
                        to get started
                    </p>

                    <a href="{{ route('register') }}" class="choice-button choice-button-outline">
                        <span>
                            <i class="bi bi-person-plus"></i>
                            Create Account
                        </span>

                        <i class="bi bi-arrow-right"></i>
                    </a>

                </div>

            </div>

            <div class="user-choice-security">
                <i class="bi bi-shield-check"></i>

                <p>
                    Your data is safe with us. We
                    <strong>never</strong> share your information.
                </p>
            </div>

        </div>

    </div>
</div>
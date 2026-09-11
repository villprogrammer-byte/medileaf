<!-- ------------------ Footer ------------------ -->

<footer class="ml-premium-footer">
    <div class="container">

        <div class="ml-footer-top">

            <div class="ml-footer-brand">
                <a href="{{ route('home') }}" class="ml-new-logo mb-3">
                    <img src="{{ asset('img/medileaf-white-logo.webp') }}" alt="MediLeaf Logo">
                </a>

                <p>
                    Doctor guided plant based healthcare, personalised consultations,
                    pharmacy support and ongoing patient care across Australia.
                </p>

                <div class="ml-footer-social">
                    <a href="https://www.facebook.com/people/Medileaf-Health/61590404445014/" target="_blank"
                        rel="noopener noreferrer">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="https://www.instagram.com/medileaf.pottspoint/" target="_blank" rel="noopener noreferrer">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="#"><i class="bi bi-linkedin"></i></a>

                </div>
            </div>

            <div class="ml-footer-links">
                <h3>Pages</h3>

                <a href="{{ route('home') }}">Home</a>
                <a href="{{ route('about') }}">About</a>
                <a href="{{ route('clinic') }}">Clinic</a>
                <a href="{{ route('pharmacy') }}">Pharmacy</a>
                <a href="{{ route('blog') }}">Blog</a>
                <a href="{{ route('terms') }}">Terms</a>
            </div>

            <div class="ml-footer-contact">

                <h3>Contact</h3>

                <div>
                    <i class="bi bi-geo-alt"></i>
                    <span>48A Darlinghurst Rd, Potts Point<br>NSW 2011</span>
                </div>

                <div>
                    <i class="bi bi-telephone"></i>
                    <a href="tel:(02) 9569 2078">
                        <span>(02) 9569 2078</span>
                    </a>
                </div>

                <div>
                    <i class="bi bi-phone"></i>
                    <a href="tel:+61460034851">
                        <span>+61 460 034 851</span>
                    </a>
                </div>

                <div>
                    <i class="bi bi-envelope"></i>
                    <a href="mailto:info@medileaf.com.au">
                        <span>info@medileaf.com.au</span>
                    </a>
                </div>

            </div>

            <div class="ml-footer-newsletter">

                <h3>Subscribe Newsletter</h3>

                <p>
                    Stay informed with expert health updates.
                </p>

                <form>
                    <input type="email" placeholder="Enter your email">

                    <button type="button">
                        <i class="bi bi-arrow-right"></i>
                    </button>
                </form>

                <span>*Only valuable resources</span>

            </div>

        </div>

        <button class="ml-scroll-top" id="mlScrollTop">
            <i class="bi bi-arrow-up"></i>
        </button>

        <!-- Disclaimer -->
        <div class="ml-footer-disclaimer">

            <div class="ml-disclaimer-icon">
                <i class="bi bi-shield-check"></i>
            </div>

            <div class="ml-disclaimer-content">
                <h3>Medical Disclaimer</h3>

                <p>
                    At MediLeaf Health, all patients are individually assessed by qualified healthcare professionals to
                    determine whether our services and treatment options are suitable for their personal health needs
                    and circumstances. Not everyone will be eligible, and individual outcomes may differ. The content on
                    this website is intended for general educational and informational purposes only and is not a
                    substitute for professional medical advice, diagnosis or treatment. Where medicinal cannabis is
                    discussed, it is a prescription-only treatment option in Australia and is subject to clinical
                    assessment and applicable Australian regulations. MediLeaf Health does not advertise or encourage
                    the inappropriate use of prescription medicines or medicinal cannabis. A consultation does not
                    guarantee a prescription or any particular treatment. If you would like to understand whether a
                    treatment may be appropriate for your circumstances, please speak with a qualified healthcare
                    professional.
                </p>
            </div>

        </div>

        <div class="ml-footer-bottom">
            <p>&copy; {{ date('Y') }} MediLeaf. All Rights Reserved.</p>
        </div>

    </div>
</footer>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom JS -->
<script src="{{ asset('js/script.js') }}"></script>
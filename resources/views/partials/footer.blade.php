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

        <div class="ml-footer-bottom">
            <p>&copy; {{ date('Y') }} MediLeaf. All Rights Reserved.</p>
        </div>

    </div>
</footer>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom JS -->
<script src="{{ asset('js/script.js') }}"></script>

@stack('scripts')
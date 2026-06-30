@extends('layouts.app')

@section('title', 'About MediLeaf')

@section('content')
    <section class="ml-glass-hero">
        <div class="ml-glass-hero-bg"></div>

        <div class="ml-glass-hero-content">

            <div class="ml-glass-hero-badge">
                DOCTOR GUIDED PLANT BASED HEALTHCARE
            </div>

            <h1>
                Healthcare
                <span>Designed</span>
                Around You
            </h1>

            <p>
                Access consultations, personalised treatment pathways,<br>
                pharmacy support and ongoing care across Australia.
            </p>

            <div class="ml-glass-hero-buttons">
                <a href="contact" class="ml-glass-btn primary">
                    Book Consultation
                    <i class="bi bi-arrow-right"></i>
                </a>

                <a href="services" class="ml-glass-btn secondary">
                    Explore Services
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>

        </div>
    </section>

    <section class="ml-commitment-section">
        <div class="container">

            <div class="ml-commitment-card">

                <div class="ml-commitment-badge">
                    <i class="bi bi-heart-pulse"></i>
                    Patient First Care
                </div>

                <h2>
                    Your Health,
                    <span>Our Commitment</span>
                </h2>

                <p>
                    At MediLeaf Health and Pharmacy, we provide personalised patient consultations,
                    doctor guided care, treatment support, and pharmacy services designed to make
                    your healthcare journey simple, supportive, and stress free.
                </p>

                <div class="ml-commitment-features">

                    <div class="ml-commitment-feature">
                        <i class="bi bi-person-check"></i>
                        <span>Doctor Guided</span>
                    </div>

                    <div class="ml-commitment-feature">
                        <i class="bi bi-shield-check"></i>
                        <span>Safe Treatment</span>
                    </div>

                    <div class="ml-commitment-feature">
                        <i class="bi bi-heart"></i>
                        <span>Personalised Care</span>
                    </div>

                    <div class="ml-commitment-feature">
                        <i class="bi bi-capsule"></i>
                        <span>Pharmacy Support</span>
                    </div>

                </div>

            </div>

        </div>
    </section>

    <section class="ml-patient-care-section">
        <div class="container">

            <div class="ml-patient-care-head">
                <h2>Comprehensive Patient Care</h2>
                <p>
                    Personalised treatment support, telehealth access, and pharmacy coordination
                    designed to make your care journey simple and convenient.
                </p>
            </div>

            <div class="ml-patient-care-layout">

                <div class="ml-patient-care-left">
                    <div class="ml-patient-care-label">
                        <i class="bi bi-camera-video"></i>
                        Online appointments available
                    </div>

                    <h3>Care That Fits Around Your Life</h3>

                    <p>
                        Our team supports patients with flexible consultations, tailored treatment
                        planning, and convenient medication access across Australia.
                    </p>

                    <a href="clinic" class="ml-patient-care-btn">
                        View Clinic
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>

                <div class="ml-patient-care-timeline">

                    <div class="ml-patient-care-item">
                        <div class="ml-patient-care-number">
                            <img src="{{ asset('img/herb.svg') }}" alt="Herb Icon">
                        </div>
                        <div class="ml-patient-care-card">
                            <div class="ml-patient-care-icon">
                                <i class="bi bi-clipboard2-pulse"></i>
                            </div>

                            <div class="ml-patient-care-content">
                                <h3>Personalised Treatment Plans</h3>
                                <p>
                                    Custom care plans designed around your health needs, preferences,
                                    and ongoing wellbeing goals.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="ml-patient-care-item">
                        <div class="ml-patient-care-number">
                            <img src="{{ asset('img/herb.svg') }}" alt="Herb Icon">
                        </div>

                        <div class="ml-patient-care-card">
                            <div class="ml-patient-care-icon">
                                <i class="bi bi-truck"></i>
                            </div>

                            <div class="ml-patient-care-content">
                                <h3>Express Medicine Delivery</h3>
                                <p>
                                    Fast and discreet delivery options to help patients access
                                    prescribed treatments conveniently.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="ml-patient-care-item">
                        <div class="ml-patient-care-number">
                            <img src="{{ asset('img/herb.svg') }}" alt="Herb Icon">
                        </div>

                        <div class="ml-patient-care-card">
                            <div class="ml-patient-care-icon">
                                <i class="bi bi-phone"></i>
                            </div>

                            <div class="ml-patient-care-content">
                                <h3>Convenient Online Consultations</h3>
                                <p>
                                    Hassle-free telehealth appointments with doctor guided support
                                    and simple patient access.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </section>


    <section class="ml-telehealth-cta">
        <div class="ml-telehealth-bg">
            <img src="{{ asset('img/medileaf-clinic.webp') }}" alt="Medileaf Clinic">
        </div>

        <div class="container">
            <div class="ml-telehealth-card">

                <div class="ml-telehealth-content">

                    <span class="ml-telehealth-tag">
                        <i class="bi bi-camera-video"></i>
                        Telehealth Appointments
                    </span>

                    <h2>
                        We Offer Telehealth Appointments With Our Doctors
                    </h2>

                    <p>
                        Speak with our friendly team, upload your prescription, or scan the QR code
                        to book your appointment quickly and securely.
                    </p>

                    <div class="ml-telehealth-note">
                        <i class="bi bi-info-circle"></i>
                        Terms and conditions apply. Please contact pharmacy for further details.
                    </div>

                    <div class="ml-telehealth-contact">
                        <div>
                            <i class="bi bi-telephone"></i>
                            <a href="tel:+61295692078">
                                <span>(02) 9569 2078</span>
                            </a>
                        </div>

                        <div>
                            <i class="bi bi-phone"></i>
                            <a href="tel:+61460034851">
                                <span>+61 460 034 851</span>
                            </a>
                        </div>
                    </div>

                </div>

                <div class="ml-telehealth-action">

                    <div class="ml-telehealth-qr-box">
                        <span>Scan to book your appointment</span>

                        <div class="ml-telehealth-qr">
                            <img src="{{ asset('img/qr-code.png') }}" alt="Medileaf Appointment QR Code">
                        </div>
                    </div>

                    <div class="ml-telehealth-buttons">

                        <a href="#" class="ml-telehealth-btn primary">
                            <i class="bi bi-upload"></i>
                            Upload Prescription
                        </a>

                        <a href="prescription" class="ml-telehealth-btn">
                            <i class="bi bi-file-medical"></i>
                            Need Prescription
                        </a>

                        <a href="https://www.halaxy.com/book/appointment/medileaf-health/location/1332127"
                            class="ml-telehealth-btn">
                            <i class="bi bi-calendar-check"></i>
                            Book Appointment
                        </a>

                    </div>

                </div>

            </div>
        </div>
    </section>

    <section class="ml-faq-simple-section">
        <div class="container">

            <div class="ml-faq-simple-head">
                <div class="ml-commitment-badge px-4">
                    <i class="bi bi-question-circle"></i>
                    FAQ
                </div>
                <h2>Frequently Asked Questions</h2>
                <p>
                    Quick answers about consultations, prescriptions, telehealth, pharmacy support, and delivery.
                </p>
            </div>

            <div class="ml-faq-simple-wrap">

                <div class="ml-faq-simple-item">
                    <button class="ml-faq-simple-question" type="button">
                        <span>How do I make an appointment?</span>
                        <i class="bi bi-plus-lg"></i>
                    </button>
                    <div class="ml-faq-simple-answer mb-4">
                        <p class="fw-bold pb-1">Ready to Connect with MediLeaf?</p>
                        <p class="fw-bold pb-1">Connecting with us is easy! You can:</p>
                        <ul class="contact-section pt-3">
                            <li><strong> Book online </strong>by clicking the button above.</li>
                            <li><strong> Call us directly </strong> at <a href="tel:0295692078">(02) 9569
                                    2078</a> or <a href="tel:+61460034851">+61 460 034 851</a>.</li>
                            <li><strong> Leave your details </strong> using the <a
                                    href="https://medileaf.com.au/#contactus">Contact Us</a> form below, and
                                we'll call you.
                            </li>
                            <li><strong> Email us at </strong><a
                                    href="mailto:admin@medileaf.com.au">admin@medileaf.com.au</a>.</li>
                            <li><strong>Visit our </strong> store during opening hours.</li>
                        </ul>
                    </div>
                </div>

                <div class="ml-faq-simple-item">
                    <button class="ml-faq-simple-question" type="button">
                        <span>Why Medileaf ?</span>
                        <i class="bi bi-plus-lg"></i>
                    </button>
                    <div class="ml-faq-simple-answer mb-4">
                        <p>Your Partner in Plant-Based Healthcare</p>
                        <p>At MediLeaf, we believe in making life-changing plant therapies easily
                            accessible as a natural alternative to traditional medicine. Our
                            innovative healthcare model simplifies the process for you, shaping a
                            future where quality, plant-based treatments are readily available.</p>
                        <p>At our dedicated dispensary, we specialize in high-quality plant-based
                            treatments, ensuring you receive the best possible care. You'll never
                            have to worry about medication availability; we maintain a reliable
                            supply of premium alternative medicines. With efficient processes and
                            convenient in-store and telehealth appointments, we make your healthcare
                            journey smooth and stress-free.</p>
                        <p>Choose MediLeaf for trusted, patient-focused care. <a href="https://medileaf.com.au/registration"
                                rel="noopener noreferrer" target="_blank"><strong>Book your
                                    appointment today!</strong></a></p>
                    </div>
                </div>

                <div class="ml-faq-simple-item">
                    <button class="ml-faq-simple-question" type="button">
                        <span>Who is MediLeaf for ?</span>
                        <i class="bi bi-plus-lg"></i>
                    </button>
                    <div class="ml-faq-simple-answer mb-4">
                        <p>MediLeaf offers an alternative path to wellness for patients seeking new
                            approaches to their health and medication. In Australia, these medicinal
                            alternatives are only available through a prescription, typically arranged via
                            the <strong>Special Access Scheme (SAS)</strong> with the <strong>Therapeutic
                                Goods Administration (TGA)</strong>. This scheme has been in place since
                            2016.</p>
                    </div>
                </div>

                <div class="ml-faq-simple-item">
                    <button class="ml-faq-simple-question" type="button">
                        <span>How much do our consults cost ?</span>
                        <i class="bi bi-plus-lg"></i>
                    </button>
                    <div class="ml-faq-simple-answer mb-4">
                        <p><strong>In-clinic (face-to-face) initial consultations</strong> are $79
                            out-of-pocket after Medicare rebates. This fee ensures you have ample time
                            for a thorough discussion with our experienced doctors, right here in our
                            store.</p>
                        <p><strong>Follow-up appointments</strong> to adjust or issue your next
                            prescription are $62 out-of-pocket after Medicare rebates.</p>
                        <p>We also offer <strong>Telehealth appointments</strong> with our doctors for
                            $49. Please note that Medicare rebates currently do not apply to Telehealth
                            consultations.</p>
                        <p><strong>We can even get your medicine on the same day</strong>. MediLeaf is
                            an integrated clinic and pharmacy with on-site dispensing. This means you
                            can often walk out with your medicinal products immediately after your
                            consultation.</p>
                    </div>
                </div>

                <div class="ml-faq-simple-item">
                    <button class="ml-faq-simple-question" type="button">
                        <span> Do I need a referral ?</span>
                        <i class="bi bi-plus-lg"></i>
                    </button>
                    <div class="ml-faq-simple-answer mb-4">
                        <p><strong>No, you don't!</strong> You can book a consultation with us directly.
                            Our doctors are not only practicing GPs but are also specially qualified in
                            plant-based therapies.</p>
                        <p><strong>Medicare rebates are also available.</strong> Our Patient Advocates
                            can provide you with exact rebate information based on your consultation
                            details.</p>
                        <p><strong>We can fill your existing prescription as long as your prescription
                                is current and valid</strong>. If it's not, we can book you in with one
                            of our doctors to renew it for you.</p>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <section class="medileaf-testimonial-section">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <div class="medileaf-testimonial-head">
                        <div class="ml-commitment-badge">
                            <i class="bi bi-chat-quote"></i>
                            Testimonials
                        </div>
                        <h2 class="medileaf-testimonial-title">What Our <span class="primary-color">Patients Say</span>
                        </h2>
                        <p class="medileaf-testimonial-subtitle">
                            Real experiences from patients who trust Medileaf for personalised care and convenient
                            support.
                        </p>
                    </div>
                </div>
            </div>

            <div id="medileafTestimonialSlider" class="carousel slide medileaf-testimonial-slider pb-0"
                data-bs-ride="carousel">
                <div class="carousel-inner">

                    <div class="carousel-item">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="medileaf-testimonial-card text-center">
                                    <div class="medileaf-testimonial-quote">
                                        <i class="bi bi-quote"></i>
                                    </div>
                                    <p class="medileaf-testimonial-text">
                                        Staff are always pleasant and professional. Communication too is excellent! Highly
                                        recommended 👍🏻👍🏻👍🏻
                                    </p>
                                    <div class="medileaf-testimonial-user">
                                        <img src="{{ asset('img/Jamie-McFarlane.png') }}" alt="Patient Review"
                                            class="medileaf-testimonial-img">
                                        <h3 class="medileaf-testimonial-name">Jamie McFarlane</h3>
                                        <span class="medileaf-testimonial-role">Verified Patient</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="carousel-item">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="medileaf-testimonial-card text-center">
                                    <div class="medileaf-testimonial-quote">
                                        <i class="bi bi-quote"></i>
                                    </div>
                                    <p class="medileaf-testimonial-text">
                                        Best clinic arround Sydney, nidi is the most kind chemist. Very good service!!
                                    </p>
                                    <div class="medileaf-testimonial-user">
                                        <img src="{{ asset('img/Dogus-Ergün.png') }}" alt="Patient Review"
                                            class="medileaf-testimonial-img">
                                        <h3 class="medileaf-testimonial-name">Dogus Ergün</h3>
                                        <span class="medileaf-testimonial-role">Verified Patient</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="carousel-item active">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="medileaf-testimonial-card text-center">
                                    <div class="medileaf-testimonial-quote">
                                        <i class="bi bi-quote"></i>
                                    </div>
                                    <p class="medileaf-testimonial-text">
                                        Great friendly service. Highly suggest.
                                    </p>
                                    <div class="medileaf-testimonial-user">
                                        <img src="{{ asset('img/John-H.jpg') }}" alt="Patient Review"
                                            class="medileaf-testimonial-img">
                                        <h3 class="medileaf-testimonial-name">John H</h3>
                                        <span class="medileaf-testimonial-role">Verified Patient</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button class="carousel-control-prev medileaf-testimonial-control medileaf-testimonial-prev" type="button"
                    data-bs-target="#medileafTestimonialSlider" data-bs-slide="prev">
                    <span class="medileaf-testimonial-arrow">
                        <i class="bi bi-arrow-left"></i>
                    </span>
                </button>

                <button class="carousel-control-next medileaf-testimonial-control medileaf-testimonial-next" type="button"
                    data-bs-target="#medileafTestimonialSlider" data-bs-slide="next">
                    <span class="medileaf-testimonial-arrow">
                        <i class="bi bi-arrow-right"></i>
                    </span>
                </button>

                <div class="carousel-indicators medileaf-testimonial-indicators">
                    <button type="button" data-bs-target="#medileafTestimonialSlider" data-bs-slide-to="0" class="active"
                        aria-current="true"></button>
                    <button type="button" data-bs-target="#medileafTestimonialSlider" data-bs-slide-to="1"></button>
                    <button type="button" data-bs-target="#medileafTestimonialSlider" data-bs-slide-to="2"></button>
                </div>
            </div>
        </div>
    </section>

    <section class="ml-gallery-premium-section">
        <div class="container">

            <div class="ml-gallery-premium-head">
                <div class="ml-commitment-badge px-4">
                    <i class="bi bi-image"></i>
                    Gallery
                </div>
                <h2>Inside Our Clinics</h2>
                <p>
                    A closer look at MediLeaf Health, pharmacy space, products, and patient care environment.
                </p>
            </div>

            <div class="ml-gallery-premium-grid">

                <a href="{{ asset('img/clinic-view-1.webp') }}" class="ml-gallery-premium-item large">
                    <img src="{{ asset('img/clinic-view-1.webp') }}" alt="MediLeaf Clinic Signage">
                    <div class="ml-gallery-overlay">
                        <span>Clinic Front</span>
                        <i class="bi bi-arrow-up-right"></i>
                    </div>
                </a>

                <a href="{{ asset('img/product-2.webp') }}" class="ml-gallery-premium-item">
                    <img src="{{ asset('img/product-2.webp') }}" alt="MediLeaf Display Table">
                    <div class="ml-gallery-overlay">
                        <span>Health Display</span>
                        <i class="bi bi-arrow-up-right"></i>
                    </div>
                </a>

                <a href="{{ asset('img/product-3.webp') }}" class="ml-gallery-premium-item tall">
                    <img src="{{ asset('img/product-3.webp') }}" alt="MediLeaf Products">
                    <div class="ml-gallery-overlay">
                        <span>Product Shelf</span>
                        <i class="bi bi-arrow-up-right"></i>
                    </div>
                </a>

                <a href="{{ asset('img/product-7.webp') }}" class="ml-gallery-premium-item">
                    <img src="{{ asset('img/product-7.webp') }}" alt="MediLeaf Health Sign">
                    <div class="ml-gallery-overlay">
                        <span>Clinic Sign</span>
                        <i class="bi bi-arrow-up-right"></i>
                    </div>
                </a>

                <a href="{{ asset('img/product-5.webp') }}" class="ml-gallery-premium-item">
                    <img src="{{ asset('img/product-5.webp') }}" alt="MediLeaf Pharmacy Products">
                    <div class="ml-gallery-overlay">
                        <span>Pharmacy Range</span>
                        <i class="bi bi-arrow-up-right"></i>
                    </div>
                </a>

                <a href="{{ asset('img/product-6.webp') }}" class="ml-gallery-premium-item wide">
                    <img src="{{ asset('img/product-6.webp') }}" alt="MediLeaf Product Display">
                    <div class="ml-gallery-overlay">
                        <span>Care Products</span>
                        <i class="bi bi-arrow-up-right"></i>
                    </div>
                </a>

                <a href="{{ asset('img/product-8.webp') }}" class="ml-gallery-premium-item">
                    <img src="{{ asset('img/product-8.webp') }}" alt="MediLeaf Health Sign">
                    <div class="ml-gallery-overlay">
                        <span>Clinic Sign</span>
                        <i class="bi bi-arrow-up-right"></i>
                    </div>
                </a>

            </div>

        </div>
    </section>
@endsection
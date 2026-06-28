@extends('layouts.app')

@section('title', 'About MediLeaf')

@section('content')
    <section class="ml-pharmacy-hero">
        <div class="container">
            <div class="row align-items-center g-5">

                <div class="col-lg-6">
                    <div class="ml-pharmacy-hero-content">
                        <div class="ml-commitment-badge px-4">
                            <i class="bi bi-heart-fill"></i>
                            Meadileaf Health
                        </div>

                        <h1>We’re Here To Support Your Care Journey</h1>

                        <p>
                            Reach out to Medileaf for consultations, treatment guidance, appointment support, and
                            general enquiries. Our team is here to help you move forward with clarity and
                            confidence.
                        </p>

                        <div class="ml-pharmacy-hero-actions">
                            <a href="#medileaf-contact-form-section" class="ml-pharmacy-hero-link">
                                Book Appointment
                                <i class="bi bi-arrow-down-circle-fill"></i>
                            </a>
                        </div>

                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="ml-pharmacy-hero-visual">

                        <div class="ml-pharmacy-hero-leaf left">
                            <svg viewBox="0 0 200 300" fill="none">
                                <path d="M100 285C98 210 104 120 120 25" stroke="currentColor" stroke-width="3" />
                                <path d="M112 95C58 80 35 48 25 22C70 25 100 52 112 95Z" fill="currentColor" />
                                <path d="M104 150C50 142 20 110 8 80C58 82 92 108 104 150Z" fill="currentColor" />
                                <path d="M100 205C52 203 22 174 10 145C55 142 90 165 100 205Z" fill="currentColor" />
                                <path d="M122 72C164 54 184 30 192 8C154 10 130 34 122 72Z" fill="currentColor" />
                                <path d="M113 130C160 120 188 90 196 62C152 66 124 92 113 130Z" fill="currentColor" />
                                <path d="M106 188C154 182 180 154 190 126C146 128 116 151 106 188Z" fill="currentColor" />
                            </svg>
                        </div>

                        <div class="ml-pharmacy-hero-image-card">
                            <img src="img/contact-us.webp" alt="Medileaf Health Consultation">

                            <div class="ml-pharmacy-hero-badge">
                                <i class="bi bi-shield-check"></i>
                                <span>Trusted Patient Support</span>
                            </div>
                        </div>

                        <div class="ml-pharmacy-hero-info-card">
                            <i class="bi bi-calendar2-check"></i>
                            <div>
                                <strong>Simple Booking</strong>
                                <span>Online or in clinic support</span>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
    <section class="medileaf-contact-info-section">
        <div class="container">

            <div class="row g-4">

                <!-- Visit -->
                <div class="col-md-6 col-xl-3">
                    <div class="medileaf-contact-info-card">

                        <div class="medileaf-contact-info-icon">
                            <i class="bi bi-geo-alt"></i>
                        </div>

                        <span class="medileaf-contact-info-label">
                            Visit Our Clinic
                        </span>

                        <h3 class="medileaf-contact-info-title">
                            Visit Us
                        </h3>

                        <p class="medileaf-contact-info-text">
                            48A Darlinghurst Rd,<br>
                            Potts Point NSW 2011
                        </p>

                    </div>
                </div>

                <!-- Call -->
                <div class="col-md-6 col-xl-3">
                    <div class="medileaf-contact-info-card">

                        <div class="medileaf-contact-info-icon">
                            <i class="bi bi-telephone"></i>
                        </div>

                        <span class="medileaf-contact-info-label">
                            Speak With Us
                        </span>

                        <h3 class="medileaf-contact-info-title">
                            Call Us
                        </h3>

                        <p class="medileaf-contact-info-text">
                            <a href="tel:+61460034851">
                                +61 460 034 851
                            </a>
                        </p>

                    </div>
                </div>

                <!-- Email -->
                <div class="col-md-6 col-xl-3">
                    <div class="medileaf-contact-info-card">

                        <div class="medileaf-contact-info-icon">
                            <i class="bi bi-envelope"></i>
                        </div>

                        <span class="medileaf-contact-info-label">
                            Email Support
                        </span>

                        <h3 class="medileaf-contact-info-title">
                            Email Us
                        </h3>

                        <p class="medileaf-contact-info-text">
                            <a href="mailto:info@medileaf.com.au">
                                info@medileaf.com.au
                            </a>
                        </p>

                    </div>
                </div>

                <!-- Hours -->
                <div class="col-md-6 col-xl-3">
                    <div class="medileaf-contact-info-card">

                        <div class="medileaf-contact-info-icon">
                            <i class="bi bi-clock"></i>
                        </div>

                        <span class="medileaf-contact-info-label">
                            Opening Hours
                        </span>

                        <h3 class="medileaf-contact-info-title">
                            We're Available
                        </h3>

                        <p class="medileaf-contact-info-text">
                            Monday to Saturday<br>
                            9:00 AM to 6:00 PM
                        </p>

                    </div>
                </div>

            </div>

        </div>
    </section>
    <section class="medileaf-contact-main-section" id="medileaf-contact-form-section">
        <div class="container">
            <div class="row g-5 align-items-start">

                <div class="col-lg-7">
                    <div class="medileaf-contact-form-wrap">

                        <div class="medileaf-contact-form-head">
                            <div class="ml-commitment-badge px-4">
                                <i class="bi bi-chat-dots"></i>
                                Get IN Touch
                            </div>

                            <h2 class="medileaf-contact-form-title">Send Us A Message</h2>
                            <p class="medileaf-contact-form-subtitle">
                                Fill in your details and our MediLeaf team will contact you with the right guidance.
                            </p>
                        </div>

                        <form class="medileaf-contact-form">
                            <div class="row g-4">

                                <div class="col-md-6">
                                    <label class="medileaf-form-label">First Name</label>
                                    <input type="text" class="form-control medileaf-form-control" placeholder="First name">
                                </div>

                                <div class="col-md-6">
                                    <label class="medileaf-form-label">Last Name</label>
                                    <input type="text" class="form-control medileaf-form-control" placeholder="Last name">
                                </div>

                                <div class="col-md-6">
                                    <label class="medileaf-form-label">Phone Number</label>
                                    <input type="text" class="form-control medileaf-form-control"
                                        placeholder="Phone number">
                                </div>

                                <div class="col-md-6">
                                    <label class="medileaf-form-label">Email Address</label>
                                    <input type="email" class="form-control medileaf-form-control"
                                        placeholder="Email address">
                                </div>

                                <div class="col-12">
                                    <label class="medileaf-form-label">Reason For Contact</label>
                                    <select class="form-select medileaf-form-control">
                                        <option selected>Select an option</option>
                                        <option>Consultation Booking</option>
                                        <option>Treatment Enquiry</option>
                                        <option>Prescription Support</option>
                                        <option>General Enquiry</option>
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label class="medileaf-form-label">Message</label>
                                    <textarea class="form-control medileaf-form-control medileaf-form-textarea"
                                        placeholder="Tell us how we can help"></textarea>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="medileaf-contact-submit-btn">
                                        Submit Your Enquiry
                                        <i class="bi bi-arrow-right"></i>
                                    </button>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="medileaf-contact-side-wrap">

                        <div class="medileaf-contact-side-card">
                            <h3 class="medileaf-contact-side-title">Why Contact MediLeaf?</h3>
                            <ul class="medileaf-contact-side-list">
                                <li>Qualified consultation support</li>
                                <li>Clear treatment guidance</li>
                                <li>Fast response from our team</li>
                                <li>Patient focused ongoing care</li>
                            </ul>
                        </div>

                        <div class="medileaf-contact-side-card">
                            <h3 class="medileaf-contact-side-title">Need Quick Help?</h3>
                            <p class="medileaf-contact-side-text">
                                If your enquiry is urgent, call our clinic directly and our team will guide you.
                            </p>
                            <a href="tel:+61460034851" class="medileaf-contact-side-btn">Call Now</a>
                        </div>

                        <div class="medileaf-contact-side-card">
                            <h3 class="medileaf-contact-side-title">Email Support</h3>
                            <p class="medileaf-contact-side-text">
                                Send your questions anytime and we will respond during clinic hours.
                            </p>
                            <a href="mailto:info@medileaf.com.au"
                                class="medileaf-contact-side-btn medileaf-contact-side-btn-outline">Email Us</a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- MAP / LOCATION -->
    <section class="medileaf-contact-location-section">
        <div class="container">

            <div class="medileaf-location-head">
                <div class="ml-commitment-badge px-4">
                    <i class="bi bi-geo-alt-fill"></i>
                    Visit MediLeaf
                </div>
                <h2>Find Our Clinic</h2>
                <p>
                    Visit our clinic for personalised guidance and professional support in a calm,
                    welcoming environment.
                </p>
            </div>

            <div class="medileaf-location-layout">

                <div class="medileaf-location-card">
                    <div class="medileaf-location-icon">
                        <i class="bi bi-geo-alt"></i>
                    </div>

                    <h3>Clinic Address</h3>
                    <p>48A Darlinghurst Rd, Potts Point NSW 2011</p>

                    <div class="medileaf-location-mini">
                        <i class="bi bi-clock"></i>
                        <span>Monday to Saturday · 9:00 AM to 6:00 PM</span>
                    </div>

                    <div class="medileaf-location-mini">
                        <i class="bi bi-telephone"></i>
                        <span>+61 460 034 851</span>
                    </div>

                    <a href="https://www.google.com/maps?q=48A%20Darlinghurst%20Rd,%20Potts%20Point%20NSW%202011"
                        target="_blank" class="medileaf-location-btn">
                        Get Directions
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>

                <div class="medileaf-contact-map-wrap">
                    <iframe
                        src="https://www.google.com/maps?q=48A%20Darlinghurst%20Rd,%20Potts%20Point%20NSW%202011&output=embed"
                        width="100%" height="430" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>

            </div>

        </div>
    </section>
@endsection
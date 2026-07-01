@extends('layouts.app')

@section('title', 'About MediLeaf')

@section('content')
    <section class="ml-pharmacy-hero">
        <div class="container">
            <div class="row g-5">

                <div class="col-lg-6">
                    <div class="ml-pharmacy-hero-content">
                        <div class="ml-commitment-badge px-4">
                            <i class="bi bi-heart-fill"></i>
                            Meadileaf Health
                        </div>
                        <h1>Doctor Guided Plant Based Healthcare</h1>

                        <p>
                            Personalised healthcare support designed to help patients access
                            doctor guided consultations, prescription pathways, and pharmacy care
                            across Australia.
                        </p>

                        <div class="ml-pharmacy-hero-actions">
                            <a href="tel:+61460034851" class="ml-pharmacy-hero-link">
                                <i class="bi bi-telephone"></i>
                                Call Pharmacy
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
                            <img src="{{ asset('img/medileaf-clinic.webp') }}" alt="Medileaf Health Consultation">

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

    <section class="ml-clinic-modern-section">
        <div class="container">

            <div class="ml-clinic-modern-head">
                <div class="ml-commitment-badge px-4">
                    <i class="bi bi-person-heart"></i>
                    Doctor Guided Care
                </div>
                <h2><strong>Personalised Care</strong> Trusted Doctors</h2>
                <p>
                    Doctor guided plant based healthcare designed to support your wellbeing
                    across Australia, with trusted access to medical cannabis consultations
                    and prescriptions.
                </p>
            </div>

            <div class="ml-clinic-modern-tabs">
                <a href="#"> Chronic Pain</a>
                <a href="#">Anxiety</a>
                <a href="#">Sleep</a>
                <a href="#">Wellbeing</a>
            </div>

            <div class="ml-clinic-modern-process">

                <div class="ml-clinic-process-head">
                    <div class="ml-commitment-badge px-4">
                        <i class="bi bi-arrow-down-circle-fill"></i>
                        Simple Steps
                    </div>
                    <h2>How It Works</h2>
                </div>

                <div class="ml-clinic-process-grid">

                    <div class="ml-clinic-step-card">
                        <div class="ml-step-number">01</div>
                        <div class="ml-step-icon">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                        <h3>Book Consultation</h3>
                        <p>Schedule your appointment online.</p>
                    </div>

                    <div class="ml-clinic-step-card">
                        <div class="ml-step-number">02</div>
                        <div class="ml-step-icon">
                            <i class="bi bi-clipboard2-pulse"></i>
                        </div>
                        <h3>Doctor Assessment</h3>
                        <p>Comprehensive evaluation of your condition.</p>
                    </div>

                    <div class="ml-clinic-step-card">
                        <div class="ml-step-number">03</div>
                        <div class="ml-step-icon">
                            <i class="bi bi-journal-medical"></i>
                        </div>
                        <h3>Treatment Plan</h3>
                        <p>Personalised therapy tailored for you.</p>
                    </div>

                    <div class="ml-clinic-step-card">
                        <div class="ml-step-number">04</div>
                        <div class="ml-step-icon">
                            <i class="bi bi-headset"></i>
                        </div>
                        <h3>Ongoing Support</h3>
                        <p>Continued care and follow-up.</p>
                    </div>

                </div>

            </div>

        </div>
    </section>


    <section class="ml-services-bento-section">
        <div class="container">

            <div class="ml-services-bento-head">
                <div class="ml-commitment-badge px-4">
                    <i class="bi bi-grid"></i>
                    Our Services
                </div>
                <h2>Doctor Guided Care, Designed Around You</h2>
                <p>
                    Access personalised plant based healthcare through qualified doctors,
                    simple consultations, tailored treatment plans, and ongoing patient support.
                </p>
            </div>

            <div class="ml-services-bento-grid">

                <div class="ml-services-bento-image">
                    <img src="img/clinic-doctor-guide.webp" alt="Medileaf Clinic Services">

                    <div class="ml-services-image-badge">
                        <i class="bi bi-shield-check"></i>
                        Doctor Guided Support
                    </div>
                </div>

                <div class="ml-services-bento-card">
                    <span>01</span>
                    <h3>Medical Consultations</h3>
                    <p>
                        Clinical assessment by qualified doctors to review your
                        condition, medical history, and treatment suitability.
                    </p>
                </div>

                <div class="ml-services-bento-card">
                    <span>02</span>
                    <h3>Chronic Pain Management</h3>
                    <p>
                        Structured care plans for managing chronic pain, including
                        neuropathic and musculoskeletal conditions.
                    </p>
                </div>

                <div class="ml-services-bento-card">
                    <span>03</span>
                    <h3>Personalised Plant Based Treatment</h3>
                    <p>
                        Doctor-prescribed treatment plans aligned with Australian medical guidelines and tailored to
                        individual patient needs.
                    </p>
                </div>

                <div class="ml-services-bento-card">
                    <span>04</span>
                    <h3>Ongoing Monitoring and Support</h3>
                    <p>
                        Regular follow-ups to assess treatment response, adjust prescriptions, and ensure patient
                        safety.
                    </p>
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
                            <span>(02) 9569 2078</span>
                        </div>

                        <div>
                            <i class="bi bi-phone"></i>
                            <span>+61 460 034 851</span>
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

                        <a href="#" class="ml-telehealth-btn">
                            <i class="bi bi-file-medical"></i>
                            Need Prescription
                        </a>

                        <a href="#" class="ml-telehealth-btn">
                            <i class="bi bi-calendar-check"></i>
                            Book Appointment
                        </a>

                    </div>

                </div>

            </div>
        </div>
    </section>

    <section class="ml-pharmacy-cta">
        <div class="container">
            <div class="ml-pharmacy-cta-card">

                <div class="ml-pharmacy-botanical left">
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

                <div class="ml-pharmacy-botanical right">
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

                <div class="row align-items-center g-4">
                    <div class="col-lg-8">
                        <div class="ml-pharmacy-cta-content">
                            <div class="ml-commitment-badge px-4">
                                <i class="bi bi-headset"></i>
                                Patient Support
                            </div>
                            <h2>Need Guidance Before You Begin?</h2>
                            <p>
                                Connect with the Medileaf team for consultation enquiries, prescription support,
                                pharmacy guidance, and product information.
                            </p>

                            <div class="ml-pharmacy-trust-row">
                                <div><i class="bi bi-shield-check"></i> Doctor Guided</div>
                                <div><i class="bi bi-truck"></i> Pharmacy Support</div>
                                <div><i class="bi bi-chat-dots"></i> Friendly Assistance</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="ml-pharmacy-cta-actions">
                            <a href="#medileaf-pharmacy-enquiry" class="ml-pharmacy-main-btn">Consultation Enquiry</a>
                            <a href="tel:+61460034851" class="ml-pharmacy-call-btn">Call Pharmacy</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
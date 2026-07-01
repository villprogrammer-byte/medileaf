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
                        <h1>About MediLeaf Healthcare</h1>
                        <p>
                            Doctor guided plant based healthcare designed to support your wellbeing
                            across Australia, with trusted access to medical cannabis consultations
                            and prescriptions.
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
                            <img src="img/about-bg.webp" alt="Medileaf Health Consultation">

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

    <section class="ml-story-editorial-section">
        <div class="container">

            <div class="ml-story-editorial-wrap">

                <div class="ml-story-editorial-content">

                    <span class="ml-story-editorial-label">Our Story</span>

                    <h2>
                        Built Around Trust, Care, and Patient Support
                    </h2>

                    <p>
                        MediLeaf Health began with a simple idea that every patient deserves
                        to feel heard, understood, and supported when exploring new treatment options.
                    </p>

                    <p>
                        By bringing together qualified doctors, pharmacy guidance, and a calm
                        patient-centred approach, MediLeaf provides a clear and medically responsible
                        pathway for people seeking reliable support.
                    </p>

                    <div class="ml-story-editorial-actions">
                        <a href="#" class="ml-story-editorial-btn">
                            Learn More
                            <i class="bi bi-arrow-right"></i>
                        </a>

                        <div class="ml-story-mini-trust">
                            <i class="bi bi-shield-check"></i>
                            Doctor guided care
                        </div>
                    </div>

                </div>

                <div class="ml-story-editorial-visual">

                    <div class="ml-story-editorial-image">
                        <img src="img/medileaf-story.webp" alt="Medileaf Story">
                    </div>

                    <div class="ml-story-stat-card stat-one">
                        <strong>Australia Wide</strong>
                        <span>Patient support</span>
                    </div>

                    <div class="ml-story-stat-card stat-two">
                        <strong>Personalised</strong>
                        <span>Care pathways</span>
                    </div>

                </div>

            </div>

        </div>
    </section>

    <section class="ml-approach-premium-section">
        <div class="container">

            <div class="ml-approach-premium-head">
                <div class="ml-commitment-badge px-4">
                    <i class="bi bi-clipboard"></i>
                    Our Approach
                </div>
                <h2>Our Medical Approach</h2>
                <p>
                    A patient-centred process designed to provide safe, doctor guided care,
                    personalised treatment pathways, and ongoing support.
                </p>
            </div>

            <div class="ml-approach-premium-grid">

                <div class="ml-approach-premium-card">
                    <div class="ml-approach-icon">
                        <i class="bi bi-person-badge"></i>
                    </div>
                    <h3>Doctor Led Consultations</h3>
                    <p>Experienced medical professionals assess your health needs with care.</p>
                </div>

                <div class="ml-approach-premium-card">
                    <div class="ml-approach-icon">
                        <i class="bi bi-clipboard2-pulse"></i>
                    </div>
                    <h3>Personalised Treatment Plans</h3>
                    <p>Care pathways tailored around your individual needs and wellbeing goals.</p>
                </div>

                <div class="ml-approach-premium-card">
                    <div class="ml-approach-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h3>Safe Treatment Pathways</h3>
                    <p>Responsible, regulated and clinically guided care every step of the way.</p>
                </div>

                <div class="ml-approach-premium-card">
                    <div class="ml-approach-icon">
                        <i class="bi bi-headset"></i>
                    </div>
                    <h3>Ongoing Patient Support</h3>
                    <p>Continued guidance, follow-ups and support throughout your care journey.</p>
                </div>

            </div>

        </div>
    </section>

    <section class="ml-conditions-lux-section">
        <div class="container">

            <div class="ml-conditions-lux-wrap">

                <div class="ml-conditions-lux-left">
                    <span>Conditions We Support</span>

                    <h2>
                        Conditions We Care For
                    </h2>

                    <p>
                        Patients seek support from MediLeaf Health for a range of conditions
                        that can affect daily wellbeing, comfort, sleep, mood, and quality of life.
                    </p>

                    <div class="ml-conditions-lux-image">
                        <img src="{{ asset('img/condition-we-care.webp') }}" alt="Conditions We Care For">
                    </div>

                    <div class="ml-conditions-lux-badge">
                        <i class="bi bi-shield-check"></i>
                        Doctor Guided Support
                    </div>
                </div>

                <div class="ml-conditions-lux-grid">

                    <div class="ml-conditions-lux-card">
                        <div class="ml-conditions-lux-icon">
                            <i class="bi bi-heart-pulse"></i>
                        </div>
                        <div>
                            <h3>Chronic Pain</h3>
                            <p>Support for ongoing discomfort and long-term pain concerns.</p>
                        </div>
                    </div>

                    <div class="ml-conditions-lux-card">
                        <div class="ml-conditions-lux-icon">
                            <i class="bi bi-cloud-sun"></i>
                        </div>
                        <div>
                            <h3>Anxiety</h3>
                            <p>Care pathways focused on stress, calm, and emotional wellbeing.</p>
                        </div>
                    </div>

                    <div class="ml-conditions-lux-card">
                        <div class="ml-conditions-lux-icon">
                            <i class="bi bi-emoji-smile"></i>
                        </div>
                        <div>
                            <h3>Depression</h3>
                            <p>Doctor guided support for mood, routine, and daily balance.</p>
                        </div>
                    </div>

                    <div class="ml-conditions-lux-card">
                        <div class="ml-conditions-lux-icon">
                            <i class="bi bi-moon-stars"></i>
                        </div>
                        <div>
                            <h3>Sleep Disorders</h3>
                            <p>Personalised options to support better rest and recovery.</p>
                        </div>
                    </div>

                    <div class="ml-conditions-lux-card">
                        <div class="ml-conditions-lux-icon">
                            <i class="bi bi-brightness-alt-high"></i>
                        </div>
                        <div>
                            <h3>PTSD</h3>
                            <p>Supportive care designed around comfort and stability.</p>
                        </div>
                    </div>

                    <div class="ml-conditions-lux-card">
                        <div class="ml-conditions-lux-icon">
                            <i class="bi bi-puzzle"></i>
                        </div>
                        <div>
                            <h3>ADHD & Autism</h3>
                            <p>Guided care for focus, regulation, and patient wellbeing.</p>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </section>

    <section class="ml-mv-premium-section">
        <div class="container">

            <div class="ml-mv-premium-head">
                <div class="ml-commitment-badge px-4">
                    <i class="bi bi-people"></i>
                    Our Purpose
                </div>
                <h2><strong>MediLeaf</strong> Mission & Vision</h2>
                <p>
                    Guided by care, clarity, and patient trust, our purpose is to make doctor guided
                    plant based healthcare more accessible, responsible, and supportive.
                </p>
            </div>

            <div class="ml-mv-premium-wrap">

                <div class="ml-mv-premium-card">
                    <div class="ml-mv-icon">
                        <i class="bi bi-eye"></i>
                    </div>

                    <span>Our Vision</span>

                    <h3>Accessible Care For Better Wellbeing</h3>

                    <p>
                        To help make plant based healthcare a trusted and accessible part of modern care
                        across Australia, where every patient feels informed, supported, and confident
                        in their treatment choices.
                    </p>
                </div>

                <div class="ml-mv-premium-card ml-mv-card-dark">
                    <div class="ml-mv-icon">
                        <i class="bi bi-heart-pulse"></i>
                    </div>

                    <span>Our Mission</span>

                    <h3>Safe, Doctor Guided Patient Support</h3>

                    <p>
                        To provide safe, doctor guided care through personalised treatment, clear
                        information, and ongoing support, placing patients at the heart of every
                        decision throughout their healthcare journey.
                    </p>
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
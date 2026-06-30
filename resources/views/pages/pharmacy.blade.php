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
                        <h1>Medileaf Pharmacy</h1>
                        <p>
                            Reliable pharmacy care, personalised support, and convenient delivery across Australia.
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
                            <img src="img/pharmacy-herbs-medicine.webp" alt="Medileaf Health Consultation">

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

    <section class="ml-pharmacy-showcase">
        <div class="container">
            <div class="row align-items-center g-5">

                <div class="col-lg-6">
                    <div class="ml-pharmacy-showcase-image">
                        <img src="img/our parmacy.webp" alt="Medileaf Pharmacy" class="img-fluid">

                        <div class="ml-pharmacy-showcase-badge">
                            <i class="bi bi-shield-check"></i>
                            <span>Trusted Pharmacy Support</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="ml-pharmacy-showcase-content">
                        <span class="ml-pharmacy-showcase-label">Plant-Based Treatment Access
                        </span>

                        <h2>Our Pharmacy</h2>

                        <p>
                            At Medileaf Pharmacy, we provide trusted support for prescribed plant-based treatments, helping
                            patients access medications, pharmacy guidance, and ongoing care with confidence. From
                            prescription fulfilment to convenient delivery, we're here to make the process simple and
                            stress-free.

                        </p>

                        <div class="ml-pharmacy-showcase-points">
                            <div>
                                <i class="bi bi-prescription2"></i>
                                <span>Prescription Support</span>
                            </div>

                            <div>
                                <i class="bi bi-truck"></i>
                                <span>Pickup or Delivery</span>
                            </div>

                            <div>
                                <i class="bi bi-chat-dots"></i>
                                <span>Friendly Pharmacy Team</span>
                            </div>
                        </div>

                        <a href="#medileaf-pharmacy-enquiry" class="ml-pharmacy-showcase-btn">
                            Organise Prescription
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="ml-product-journey">
        <div class="container">
            <div class="ml-product-journey-head">
                <div class="ml-commitment-badge px-4">
                    <i class="bi bi-box-seam"></i>
                    Discover Range
                </div>
                <h2>Explore Medileaf Pharmacy Essentials</h2>
                <p>From prescription support to wellness products, everything is organised in a simple patient friendly
                    flow.</p>
            </div>

            <div class="ml-product-journey-wrap">

                <div class="ml-product-journey-card">
                    <div class="ml-product-journey-img">
                        <img src="img/plants-based.webp" alt="Plant Based Treatment Support">
                    </div>
                    <div class="ml-product-journey-content">
                        <strong>01</strong>
                        <span>Prescription Support</span>
                        <h3>Plant-Based Treatment Access</h3>
                        <p>At Medileaf Pharmacy, we help patients access prescribed plant-based medications through a simple
                            and supportive process. From prescription fulfilment to convenient delivery, our team is
                            committed to providing professional pharmacy care every step of the way.
                        </p>
                        <a href="#">Organise Prescription</a>
                    </div>
                </div>

                <div class="ml-product-journey-card reverse">
                    <div class="ml-product-journey-img">
                        <img src="img/nicotin.webp" alt="Smoking Cessation Products">
                    </div>
                    <div class="ml-product-journey-content">
                        <strong>02</strong>
                        <span>Pharmacy Guidance</span>
                        <h3>Smoking Cessation Support</h3>
                        <p>Taking the first step towards quitting smoking isn't always easy. That's why our pharmacy team
                            offers personalised guidance, approved treatment options, and ongoing support to help eligible
                            patients work towards their health goals with confidence.

                        </p>
                        <a href="#">Consultation Enquiry</a>
                    </div>
                </div>

                <div class="ml-product-journey-card">
                    <div class="ml-product-journey-img">
                        <img src="img/cbd-vape.webp" alt="Vaporisers">
                    </div>
                    <div class="ml-product-journey-content">
                        <strong>03</strong>
                        <span>Device Support</span>
                        <h3>Vaporisers & Accessories</h3>
                        <p>Having the right device can make a difference to your treatment experience. We provide access to
                            trusted vaporisers and accessories, along with friendly support to help patients make informed
                            choices with confidence.
                        </p>
                        <a href="store.html">View Products</a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="ml-prescription-flow pt-0">
        <div class="container">

            <div class="ml-prescription-flow-head">
                <div class="ml-commitment-badge px-4">
                    <i class="bi bi-arrow-down-circle-fill"></i>
                    Simple Steps
                </div>
                <h2>Prescription Process</h2>
                <p>
                    A simple, guided process to help you enquire, organise your prescription, and choose pickup or
                    delivery.
                </p>
            </div>

            <div class="ml-prescription-flow-wrap">

                <div class="ml-prescription-flow-card">
                    <div class="ml-prescription-flow-number">01</div>

                    <div class="ml-prescription-flow-icon">
                        <i class="bi bi-clipboard2-pulse"></i>
                    </div>

                    <h3>Enquire About a Consultation</h3>
                    <p>
                        Fill out a quick enquiry form so our team can understand your needs and guide you through the
                        next step.
                    </p>

                    <a href="#medileaf-pharmacy-enquiry">Enquire Now</a>
                </div>

                <div class="ml-prescription-flow-card active">
                    <div class="ml-prescription-flow-number">02</div>

                    <div class="ml-prescription-flow-icon">
                        <i class="bi bi-prescription2"></i>
                    </div>

                    <h3>Organise Your Prescription</h3>
                    <p>
                        Share your prescription details or speak with our pharmacy team for clear support and guidance.
                    </p>

                    <a href="#medileaf-pharmacy-enquiry">Start Request</a>
                </div>

                <div class="ml-prescription-flow-card">
                    <div class="ml-prescription-flow-number">03</div>

                    <div class="ml-prescription-flow-icon">
                        <i class="bi bi-truck"></i>
                    </div>

                    <h3>Choose Pickup or Delivery</h3>
                    <p>
                        Once everything is ready, choose pharmacy pickup or arrange convenient delivery support.
                    </p>

                    <a href="tel:+61460034851">Call Pharmacy</a>
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
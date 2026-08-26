@extends('layouts.app')

@section('title', 'For Practitioners | MediLeaf Health')

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
                        <h1>GP & Practitioner Referral Pathway</h1>

                        <p>
                            At MediLeaf Health, we act as a trusted, TGA-compliant co-management partner for general
                            practices and allied health professionals across Australia.
                        </p>

                        <div class="ml-pharmacy-hero-actions">
                            <a href="" class="ml-pharmacy-hero-link">
                                <i class="bi bi-person-fill-add"></i>
                                Refer a Patient
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
                            <img src="{{ asset('img/practitioner.webp') }}" alt="Medileaf Health Consultation">

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

    <section class="ml-practitioner-features">
        <div class="container">
            <div class="ml-practitioner-features-grid">
                <article class="ml-practitioner-feature-card">
                    <div class="ml-practitioner-feature-icon"><i class="bi bi-clipboard2-pulse"></i></div>
                    <h3>Clinical Assessment</h3>
                    <p>Eligibility screening by experienced practitioners</p>
                </article>
                <article class="ml-practitioner-feature-card">
                    <div class="ml-practitioner-feature-icon"><i class="bi bi-file-earmark-check"></i></div>
                    <h3>Regulatory Support</h3>
                    <p>Appropriate clinical and regulatory pathways</p>
                </article>
                <article class="ml-practitioner-feature-card">
                    <div class="ml-practitioner-feature-icon"><i class="bi bi-arrow-repeat"></i></div>
                    <h3>Continuity of Care</h3>
                    <p>Ongoing patient management and follow up</p>
                </article>
                <article class="ml-practitioner-feature-card">
                    <div class="ml-practitioner-feature-icon"><i class="bi bi-shield-lock"></i></div>
                    <h3>Secure &amp; Discreet</h3>
                    <p>Patient focused communication and dispensing</p>
                </article>
            </div>
        </div>
    </section>

    <section class="ml-practitioner-pathway">
        <div class="ml-practitioner-pathway-leaf ml-practitioner-pathway-leaf-left" aria-hidden="true"></div>
        <div class="ml-practitioner-pathway-leaf ml-practitioner-pathway-leaf-right" aria-hidden="true"></div>

        <div class="container">
            <div class="ml-practitioner-pathway-head">
                <div class="ml-practitioner-kicker">
                    <span></span>HOW THE REFERRAL PATHWAY WORKS<span></span>
                </div>
                <h2>A clear pathway for better patient outcomes</h2>
            </div>

            <div class="ml-practitioner-pathway-grid">
                <article class="ml-practitioner-pathway-item">
                    <div class="ml-pathway-number">01</div>
                    <div class="ml-pathway-icon"><i class="bi bi-person-plus"></i></div>
                    <h3>Refer Patient</h3>
                    <p>Contact the MediLeaf administrative team to initiate the practitioner referral pathway.</p>
                </article>
                <article class="ml-practitioner-pathway-item">
                    <div class="ml-pathway-number">02</div>
                    <div class="ml-pathway-icon"><i class="bi bi-clipboard2-pulse"></i></div>
                    <h3>Clinical Assessment</h3>
                    <p>Our specialised doctors manage clinical eligibility screening for the patient.</p>
                </article>
                <article class="ml-practitioner-pathway-item">
                    <div class="ml-pathway-number">03</div>
                    <div class="ml-pathway-icon"><i class="bi bi-file-earmark-check"></i></div>
                    <h3>Treatment Pathway</h3>
                    <p>Relevant frameworks, approvals and care planning are managed by our clinical team.</p>
                </article>
                <article class="ml-practitioner-pathway-item">
                    <div class="ml-pathway-number">04</div>
                    <div class="ml-pathway-icon"><i class="bi bi-people"></i></div>
                    <h3>Ongoing Care</h3>
                    <p>Primary care physicians are kept updated on their patients' progress.</p>
                </article>
            </div>
        </div>
    </section>

    <section class="ml-practitioner-management">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <div class="ml-practitioner-copy">
                        <div class="ml-practitioner-label">CO-MANAGEMENT PARTNER</div>
                        <h2>Working together for <span>seamless patient care</span></h2>
                        <div class="ml-practitioner-title-line"></div>
                        <p>At MediLeaf Health, we act as a trusted, TGA-compliant co-management partner for general
                            practices and allied health professionals across Australia.</p>
                        <p>We understand the immense regulatory and administrative time constraints involved in navigating
                            alternative therapeutic pathways via the Special Access Scheme (SAS). Our specialized doctors
                            manage the full clinical eligibility screening, legal frameworks, approvals, and continuous care
                            plans, keeping primary care physicians consistently updated on their patients' progress.</p>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="ml-practitioner-manages-card">
                        <div class="ml-practitioner-dna-bg" aria-hidden="true"></div>
                        <div class="ml-practitioner-manages-content">
                            <h3>MediLeaf manages</h3>
                            <div class="ml-practitioner-manages-list">
                                <div><span class="ml-manage-check"><i class="bi bi-check-lg"></i></span><span>Clinical
                                        eligibility screening</span></div>
                                <div><span class="ml-manage-check"><i class="bi bi-check-lg"></i></span><span>Legal
                                        frameworks and approvals</span></div>
                                <div><span class="ml-manage-check"><i class="bi bi-check-lg"></i></span><span>Continuous
                                        care plans</span></div>
                                <div><span class="ml-manage-check"><i class="bi bi-check-lg"></i></span><span>Ongoing
                                        patient management</span></div>
                                <div><span class="ml-manage-check"><i class="bi bi-check-lg"></i></span><span>Practitioner
                                        communication</span></div>
                                <div><span class="ml-manage-check"><i class="bi bi-check-lg"></i></span><span>Patient
                                        progress updates</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ml-practitioner-pharmacy">
        <div class="container">
            <div class="row g-5 align-items-stretch">
                <div class="col-lg-6">
                    <div class="ml-practitioner-pharmacy-image">
                        <img src="{{ asset('img/referral-pharmacy-delivery.webp') }}"
                            alt="MediLeaf secure pharmacy dispensing and delivery">
                        <div class="ml-practitioner-delivery-seal">
                            <i class="bi bi-shield-lock"></i>
                            <strong>DISCREET &amp; SECURE</strong>
                            <span>DELIVERY</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="ml-practitioner-pharmacy-content">
                        <div class="ml-practitioner-label">PHARMACY SUPPORT</div>
                        <h2>Discreet Nationwide <span>Pharmacy Dispensing</span></h2>
                        <div class="ml-practitioner-title-line"></div>
                        <p>To ensure maximum continuity of care and comfort for patients managing chronic pain, structural
                            mobility limitations, or severe anxiety, MediLeaf operates an integrated pharmacy network
                            framework with on-site dispensing. Through our specialized dispatch systems,</p>

                        <div class="ml-practitioner-pharmacy-highlight">
                            <div class="ml-practitioner-highlight-icon"><i class="bi bi-check-lg"></i></div>
                            <strong>we provide fast, highly secure, and discreet direct-to-door medication delivery for all
                                referred patients across Australia.</strong>
                        </div>

                        <div class="ml-practitioner-pharmacy-grid">
                            <div class="ml-practitioner-pharmacy-point">
                                <i class="bi bi-shop"></i>
                                <strong>Integrated Pharmacy Network</strong>
                                <span>On-site dispensing support</span>
                            </div>
                            <div class="ml-practitioner-pharmacy-point">
                                <i class="bi bi-shield-check"></i>
                                <strong>Highly Secure &amp; Discreet</strong>
                                <span>Patient privacy protected</span>
                            </div>
                            <div class="ml-practitioner-pharmacy-point">
                                <i class="bi bi-truck"></i>
                                <strong>Australia Wide Delivery</strong>
                                <span>Direct-to-door nationwide</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ml-practitioner-final">
        <div class="container">
            <div class="ml-practitioner-final-card">
                <div class="row align-items-center g-4">
                    <div class="col-lg-6">
                        <div class="ml-practitioner-final-left">
                            <button type="button" class="ml-practitioner-final-icon" data-bs-toggle="modal"
                                data-bs-target="#practitionerReferralModal" aria-label="Open practitioner referral form">
                                <i class="bi bi-person-plus"></i>
                            </button>
                            <div>
                                <h2>Ready to refer a patient?</h2>
                                <p>
                                    Refer a patient securely through our online practitioner referral form.
                                    Our administrative team will review the referral and contact you if any
                                    further information is required.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="ml-practitioner-final-contact">
                            <a href="mailto:admin@medileaf.com.au">
                                <span class="ml-practitioner-contact-icon"><i class="bi bi-envelope"></i></span>
                                <span><small>Email our team</small><strong>admin@medileaf.com.au</strong></span>
                            </a>
                            <a href="tel:0295692078">
                                <span class="ml-practitioner-contact-icon"><i class="bi bi-telephone"></i></span>
                                <span><small>Call MediLeaf</small><strong>(02) 9569 2078</strong></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    {{-- Practitioner Referral Modal --}}
    <div class="modal fade ml-practitioner-referral-modal" id="practitionerReferralModal" tabindex="-1"
        aria-labelledby="practitionerReferralModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">

                {{-- Modal Header --}}
                <div class="ml-referral-modal-header">

                    <div class="ml-referral-modal-heading">

                        <div class="ml-referral-modal-icon">
                            <i class="bi bi-person-plus"></i>
                        </div>

                        <div>
                            <span>MEDILEAF HEALTH</span>

                            <h2 id="practitionerReferralModalLabel">
                                Practitioner Referral
                            </h2>

                            <p>
                                Refer a patient securely to our clinical team.
                            </p>
                        </div>

                    </div>

                    <button type="button" class="ml-referral-modal-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x-lg"></i>
                    </button>

                </div>


                {{-- Modal Body --}}
                <div class="ml-referral-modal-body">

                    <div class="ml-referral-practitioner-banner">

                        <div class="ml-referral-practitioner-banner-icon">
                            <i class="bi bi-person-badge"></i>
                        </div>

                        <div>
                            <small>REFERRING PRACTITIONER</small>

                            <strong>
                                Practitioner Referral
                            </strong>

                            <span>
                                Please provide your professional and patient details below.
                            </span>
                        </div>

                    </div>


                    <form action="#" method="POST">

                        @csrf

                        {{-- Practitioner Details --}}
                        <div class="ml-referral-section-heading">
                            <div class="ml-referral-section-number">1</div>

                            <div>
                                <h3>Practitioner Details</h3>
                                <p>Your professional contact information</p>
                            </div>

                            <span>Required</span>
                        </div>

                        <div class="row g-4">

                            <div class="col-md-6">

                                <label class="ml-referral-label">
                                    Practitioner Name <span>*</span>
                                </label>

                                <div class="ml-referral-input-wrap">
                                    <i class="bi bi-person-badge"></i>

                                    <input type="text" name="practitioner_name" placeholder="Enter practitioner name"
                                        required>
                                </div>

                            </div>


                            <div class="col-md-6">

                                <label class="ml-referral-label">
                                    Practice / Clinic Name
                                </label>

                                <div class="ml-referral-input-wrap">
                                    <i class="bi bi-building"></i>

                                    <input type="text" name="practice_name" placeholder="Enter practice or clinic name">
                                </div>

                            </div>


                            <div class="col-md-6">

                                <label class="ml-referral-label">
                                    Practitioner Email <span>*</span>
                                </label>

                                <div class="ml-referral-input-wrap">
                                    <i class="bi bi-envelope"></i>

                                    <input type="email" name="practitioner_email" placeholder="Enter professional email"
                                        required>
                                </div>

                            </div>


                            <div class="col-md-6">

                                <label class="ml-referral-label">
                                    Practitioner Phone <span>*</span>
                                </label>

                                <div class="ml-referral-input-wrap">
                                    <i class="bi bi-telephone"></i>

                                    <input type="tel" name="practitioner_phone" placeholder="Enter contact number" required>
                                </div>

                            </div>

                        </div>


                        {{-- Patient Details --}}
                        <div class="ml-referral-section-heading mt-5">

                            <div class="ml-referral-section-number">2</div>

                            <div>
                                <h3>Patient Details</h3>
                                <p>Information about the patient being referred</p>
                            </div>

                            <span>Required</span>

                        </div>


                        <div class="row g-4">

                            <div class="col-md-6">

                                <label class="ml-referral-label">
                                    First Name <span>*</span>
                                </label>

                                <div class="ml-referral-input-wrap">
                                    <i class="bi bi-person"></i>

                                    <input type="text" name="patient_first_name" placeholder="Enter patient's first name"
                                        required>
                                </div>

                            </div>


                            <div class="col-md-6">

                                <label class="ml-referral-label">
                                    Surname <span>*</span>
                                </label>

                                <div class="ml-referral-input-wrap">
                                    <i class="bi bi-person"></i>

                                    <input type="text" name="patient_last_name" placeholder="Enter patient's surname"
                                        required>
                                </div>

                            </div>


                            <div class="col-md-6">

                                <label class="ml-referral-label">
                                    Patient Email <span>*</span>
                                </label>

                                <div class="ml-referral-input-wrap">
                                    <i class="bi bi-envelope"></i>

                                    <input type="email" name="patient_email" placeholder="Enter patient's email" required>
                                </div>

                            </div>


                            <div class="col-md-6">

                                <label class="ml-referral-label">
                                    Patient Phone <span>*</span>
                                </label>

                                <div class="ml-referral-input-wrap">
                                    <i class="bi bi-telephone"></i>

                                    <input type="tel" name="patient_phone" placeholder="Enter patient's phone number"
                                        required>
                                </div>

                            </div>


                            <div class="col-md-6">

                                <label class="ml-referral-label">
                                    Date of Birth <span>*</span>
                                </label>

                                <div class="ml-referral-input-wrap">
                                    <i class="bi bi-calendar3"></i>

                                    <input type="date" name="patient_dob" required>
                                </div>

                            </div>


                            <div class="col-md-6">

                                <label class="ml-referral-label">
                                    Medicare Number
                                </label>

                                <div class="ml-referral-input-wrap">
                                    <i class="bi bi-card-text"></i>

                                    <input type="text" name="medicare_number" placeholder="Enter Medicare number">
                                </div>

                            </div>


                            <div class="col-12">

                                <label class="ml-referral-label">
                                    Additional Information
                                </label>

                                <div class="ml-referral-textarea-wrap">

                                    <i class="bi bi-pencil-square"></i>

                                    <textarea name="notes" rows="4"
                                        placeholder="Please provide any relevant referral information..."></textarea>

                                </div>

                            </div>

                        </div>


                        {{-- Consent --}}
                        <div class="ml-referral-consent">

                            <input type="checkbox" name="consent" value="1" required>

                            <span>
                                I confirm that I am authorised to provide this referral
                                information and consent to MediLeaf Health contacting me
                                regarding this referral.
                            </span>

                        </div>


                        {{-- Turnstile --}}

                        <div class="form-group mt-3">

                            <div class="turnstile-wrap">

                                <div class="cf-turnstile" data-sitekey="{{ config('services.turnstile.site_key') }}"
                                    data-theme="light" data-size="flexible">
                                </div>

                            </div>

                            @error('cf-turnstile-response')
                                <small class="field-error d-block mt-2">
                                    {{ $message }}
                                </small>
                            @enderror

                        </div>

                        <div class="ml-referral-security">

                            <div class="ml-referral-security-icon">
                                <i class="bi bi-shield-check"></i>
                            </div>

                            <div>
                                <strong>Secure Referral</strong>

                                <span>
                                    Your information is handled securely and used only
                                    for the purpose of this referral.
                                </span>
                            </div>

                        </div>


                        {{-- Footer --}}
                        <div class="ml-referral-modal-footer">

                            <button type="button" class="ml-referral-cancel-btn" data-bs-dismiss="modal">
                                Cancel
                            </button>

                            <button type="submit" class="ml-referral-submit-btn">

                                <i class="bi bi-send"></i>

                                Submit Referral

                            </button>

                        </div>

                    </form>

                </div>

            </div>
        </div>
    </div>
@endsection
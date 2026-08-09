@extends('layouts.app')

@section('title', 'About MediLeaf')

@section('content')
    <section class="prescription-page">
        <div class="container">
            <div class="row g-4 align-items-stretch">

                <!-- Left Information -->
                <div class="col-lg-4">
                    <div class="prescription-info-card">

                        <div class="ml-commitment-badge px-4">
                            <i class="bi bi-headset"></i>
                            We're Here to Help
                        </div>

                        <h2>New Patient<span>Registration</span></h2>
                        <h3>Start Your Consultation</h3>
                        <div class="green-line"></div>

                        <p class="intro-text">
                            Complete the form below to begin your consultation. Our healthcare team will review your enquiry
                            and contact you to discuss your eligibility for treatment. If appropriate, a qualified
                            practitioner may issue a prescription following your consultation.
                        </p>

                        <div class="contact-box">
                            <div class="icon"><i class="bi bi-telephone"></i></div>
                            <div>
                                <small>Phone</small>
                                <strong><a href="tel:+61295692078">02 9569 2078</a></strong>
                            </div>
                        </div>

                        <div class="contact-box">
                            <div class="icon"><i class="bi bi-phone"></i></div>
                            <div>
                                <small>Call</small>
                                <strong><a href="tel:+61460034851">+61 460 034 851</a></strong>
                            </div>
                        </div>

                        <div class="contact-box">
                            <div class="icon"><i class="bi bi-envelope"></i></div>
                            <div>
                                <small>Email</small>
                                <strong><a href="mailto:info@medileaf.com.au">info@medileaf.com.au</a></strong>
                            </div>
                        </div>

                        <div class="hours-box">
                            <h4><i class="fa-regular fa-clock"></i> Business Hours</h4>
                            <p><span>Monday – Friday</span><span>10:00 AM – 5:00 PM</span></p>
                            <p><span>Saturday</span><span>10:00 AM – 2:00 PM</span></p>
                            <p><span>Sunday</span><span>Closed</span></p>
                        </div>

                        <div class="privacy-box">
                            <i class="fa-solid fa-shield-halved"></i>
                            <p>Your information is safe with us.<br>We respect your privacy.</p>
                        </div>

                    </div>
                </div>

                <!-- Right Form -->
                <div class="col-lg-8">
                    <div class="prescription-form-card">

                        <div class="form-heading">
                            <div class="form-icon">
                                <i class="bi bi-chat-dots"></i>
                            </div>
                            <div>
                                <h2>Prescription Enquiry</h2>
                                <p>Please fill in your details below and our team will be in touch.</p>
                            </div>
                        </div>

                        <form action="{{ route('prescription.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row g-4">

                                <div class="col-md-6">
                                    <label>First Name *</label>
                                    <div class="input-wrap">
                                        <i class="fa-regular fa-user"></i>
                                        <input type="text" name="first_name" placeholder="Enter your first name" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label>Last Name *</label>
                                    <div class="input-wrap">
                                        <i class="fa-regular fa-user"></i>
                                        <input type="text" name="last_name" placeholder="Enter your last name" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label>Email *</label>
                                    <div class="input-wrap">
                                        <i class="fa-regular fa-envelope"></i>
                                        <input type="email" name="email" placeholder="Enter your email address" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label>Mobile Number *</label>
                                    <div class="input-wrap">
                                        <i class="fa-solid fa-phone"></i>
                                        <input type="text" name="mobile" placeholder="Enter your mobile number" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label>Date of Birth <span>*</span></label>

                                    <div class="input-wrap">
                                        <i class="fa-regular fa-calendar"></i>

                                        <input type="text" class="dob-picker" name="dob" placeholder="DD / MM / YYYY"
                                            autocomplete="off" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label>State / Territory *</label>
                                    <div class="input-wrap">
                                        <i class="fa-solid fa-location-dot"></i>
                                        <select name="state" required>
                                            <option value="">Select your state</option>
                                            <option value="NSW">NSW</option>
                                            <option value="VIC">VIC</option>
                                            <option value="QLD">QLD</option>
                                            <option value="WA">WA</option>
                                            <option value="SA">SA</option>
                                            <option value="TAS">TAS</option>
                                            <option value="ACT">ACT</option>
                                            <option value="NT">NT</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label>Are you an existing patient? *</label>
                                    <div class="option-box">
                                        <label><input type="radio" name="patient" value="Yes" required> Yes</label>
                                        <label><input type="radio" name="patient" value="No"> No</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label>What do you need a prescription for? <span>*</span></label>

                                    <div class="input-wrap">
                                        <i class="fa-solid fa-notes-medical"></i>

                                        <select name="prescription_for" required>
                                            <option value="">Select Prescription Type</option>
                                            <option value="Chronic Pain">Chronic Pain</option>
                                            <option value="Anxiety">Anxiety</option>
                                            <option value="Sleep">Sleep</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label>Do you currently have a prescription? *</label>
                                    <div class="option-box">
                                        <label><input type="radio" name="current_prescription" value="Yes" required>
                                            Yes</label>

                                        <label><input type="radio" name="current_prescription" value="No"> No</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label>Upload Prescription File <small class="text-muted">(optional)</small></label>
                                    <div class="upload-box" id="uploadBox">
                                        <input type="file" id="prescriptionFile" name="prescription_file"
                                            accept=".jpg,.jpeg,.png,.pdf" hidden>

                                        <i class="bi bi-cloud-upload"></i>
                                        <p><strong>Click to upload</strong> or drag and drop</p>
                                        <small>PDF, JPG, PNG (Max. 5MB)</small>

                                        <br>
                                        <button type="button" class="choose-file-btn">Choose File</button>
                                        <div id="fileName" class="file-name pt-3"></div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label>Additional Notes (optional)</label>
                                    <div class="textarea-wrap">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                        <textarea name="notes"
                                            placeholder="Any extra information you'd like to share..."></textarea>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label class="consent">
                                        <input type="checkbox" name="consent" value="1" required>
                                        <span>
                                            I consent to Medileaf Health contacting me regarding my enquiry and understand
                                            that submitting this form does not guarantee a prescription.
                                        </span>
                                    </label>
                                </div>

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

                                <div class="col-12">
                                    <button type="submit" class="submit-btn">
                                        <i class="fa-regular fa-paper-plane"></i>
                                        Submit Prescription Enquiry
                                    </button>
                                </div>

                                <div class="secure-note">
                                    <i class="fa-solid fa-lock"></i>
                                    Your information is secure and will only be used for this enquiry.
                                </div>

                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </section>

    @if(session('success'))
        <div id="successPopup" class="ml-success-popup">
            <div class="ml-success-popup-card">

                <button type="button" class="ml-popup-close" onclick="closeSuccessPopup()">&times;</button>

                <div class="ml-popup-icon">
                    <i class="bi bi-check-circle-fill"></i>
                </div>

                <h3>Prescription Enquiry Submitted Successfully</h3>

                <p>{{ session('success') }}</p>

                <button type="button" class="ml-popup-btn" onclick="closeSuccessPopup()">
                    Done
                </button>

            </div>
        </div>
    @endif
@endsection

@push('scripts')
    <script src="{{ asset('js/prescription-upload.js') }}"></script>
@endpush
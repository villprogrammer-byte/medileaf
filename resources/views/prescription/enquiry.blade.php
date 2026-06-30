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

                        <h2>I Need a <span>Prescription</span></h2>
                        <h3>Explore Your Eligibility</h3>
                        <div class="green-line"></div>

                        <p class="intro-text">
                            Complete the form below and our healthcare team will review your enquiry.
                            If you're eligible, we'll guide you through the consultation process and help
                            you obtain a prescription where clinically appropriate.
                        </p>

                        <div class="contact-box">
                            <div class="icon"><i class="bi bi-telephone"></i></i></i></div>
                            <div>
                                <small>Phone</small>
                                <strong>02 9569 2078</strong>
                            </div>
                        </div>

                        <div class="contact-box">
                            <div class="icon"><i class="bi bi-phone"></i></div>
                            <div>
                                <small>Call</small>
                                <strong>+61 460 034 851</strong>
                            </div>
                        </div>

                        <div class="contact-box">
                            <div class="icon"> <i class="bi bi-envelope"></i></i></div>
                            <div>
                                <small>Email</small>
                                <strong>info@medileaf.com.au</strong>
                            </div>
                        </div>

                        <div class="hours-box">
                            <h4><i class="fa-regular fa-clock"></i> Business Hours</h4>
                            <p><span>Monday – Friday</span><span>9:00 AM – 6:00 PM</span></p>
                            <p><span>Saturday</span><span>9:00 AM – 2:00 PM</span></p>
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
                                    <label>Date of Birth *</label>
                                    <div class="input-wrap">
                                        <i class="fa-regular fa-calendar"></i>
                                        <input type="text" name="dob" placeholder="DD / MM / YYYY" required>
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
                                    <label>What do you need a prescription for? *</label>
                                    <div class="option-box checkbox-options">
                                        <label><input type="checkbox" name="prescription_for[]" value="Chronic Pain">
                                            Chronic Pain</label>

                                        <label><input type="checkbox" name="prescription_for[]" value="Anxiety">
                                            Anxiety</label>

                                        <label><input type="checkbox" name="prescription_for[]" value="Sleep"> Sleep</label>

                                        <label><input type="checkbox" name="prescription_for[]" value="Other"> Other</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label>Do you currently have a prescription? *</label>
                                    <div class="option-box">
                                        <label><input type="radio" name="current_prescription" value="Yes" required>
                                            Yes</label>

                                        <label><input type="radio" name="current_prescription" value="No"> No</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label>Upload Previous Prescription (Optional)</label>

                                    <div class="upload-box" id="uploadBox">
                                        <input type="file" id="prescriptionFile" name="prescription"
                                            accept=".jpg,.jpeg,.png,.pdf" hidden>

                                        <i class="fa-solid fa-cloud-arrow-up"></i>
                                        <p><strong>Click to upload</strong> or drag & drop</p>
                                        <small>JPG, PNG, PDF (Max. 5MB)</small>

                                        <div id="fileName" class="mt-2"></div>
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
@endsection
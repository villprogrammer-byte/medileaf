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

                        <h2>Uploard Your<span>Prescription</span></h2>
                        <h3>Quick.Secure.Confidential</h3>
                        <div class="green-line"></div>

                        <p class="intro-text">
                            Upload your existing prescription and complete the form below. Our healthcare team will review
                            your submission securely.
                        </p>

                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fa-solid fa-lock"></i>
                            </div>
                            <div>
                                <h4>Secure & Confidential</h4>
                                <p>Your information and documents are encrypted and kept private.</p>
                            </div>
                        </div>

                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fa-regular fa-clock"></i>
                            </div>
                            <div>
                                <h4>Fast Review</h4>
                                <p>Our team reviews your prescription promptly to avoid delays.</p>
                            </div>
                        </div>

                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fa-solid fa-shield-heart"></i>
                            </div>
                            <div>
                                <h4>Australian Standards</h4>
                                <p>We follow strict healthcare and privacy regulations in Australia.</p>
                            </div>
                        </div>

                        <div class="contact-box">
                            <div class="icon"><i class="bi bi-telephone"></i></i></i></div>
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
                            <div class="icon"> <i class="bi bi-envelope"></i></i></div>
                            <div>
                                <small>Email</small>
                                <strong><a href="mailto:info@medileaf.com.au">info@medileaf.com.au</a></strong>
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

                    <div class="prescription-tabs">

                        <a href="" class="tab-btn">
                            <i class="bi bi-clipboard2-pulse"></i>
                            <span>Need a Prescription?</span>
                        </a>

                        <a href="" class="tab-btn active">
                            <i class="bi bi-cloud-upload"></i>
                            <span>Upload Existing Prescription</span>
                        </a>

                    </div>

                    <div class="prescription-form-card">

                        <div class="form-heading">
                            <div class="form-icon">
                                <i class="bi bi-cloud-upload"></i>
                            </div>
                            <div>
                                <h2>Uploard Prescription</h2>
                                <p>Please fill in your details below and our team will be in touch.</p>
                            </div>
                        </div>

                        <form action="{{ route('upload.prescription.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row g-4">

                                <div class="col-md-6">
                                    <label>First Name *</label>
                                    <div class="input-wrap">
                                        <i class="fa-regular fa-user"></i>
                                        <input type="text" name="first_name" value="{{ old('first_name') }}"
                                            placeholder="Enter your first name" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label>Last Name *</label>
                                    <div class="input-wrap">
                                        <i class="fa-regular fa-user"></i>
                                        <input type="text" name="last_name" value="{{ old('last_name') }}"
                                            placeholder="Enter your last name" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label>Date of Birth *</label>
                                    <div class="input-wrap">
                                        <i class="fa-regular fa-calendar"></i>
                                        <input type="text" name="dob" value="{{ old('dob') }}" placeholder="DD / MM / YYYY"
                                            required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label>State / Territory *</label>
                                    <div class="input-wrap">
                                        <i class="fa-solid fa-location-dot"></i>
                                        <select name="state" required>
                                            <option value="">Select your state</option>
                                            @foreach(['NSW', 'VIC', 'QLD', 'WA', 'SA', 'TAS', 'ACT', 'NT'] as $state)
                                                                                <option value="{{ $state }}" {{ old('state') == $state ? 'selected' : '' }}>{{
                                                $state }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label>Email *</label>
                                    <div class="input-wrap">
                                        <i class="fa-regular fa-envelope"></i>
                                        <input type="email" name="email" value="{{ old('email') }}"
                                            placeholder="Enter your email address" required>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label>Mobile Number *</label>
                                    <div class="input-wrap">
                                        <i class="fa-solid fa-phone"></i>
                                        <input type="text" name="mobile" value="{{ old('mobile') }}"
                                            placeholder="Enter your mobile number" required>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label>Upload Prescription File *</label>
                                    <div class="upload-box" id="uploadBox">
                                        <input type="file" id="prescriptionFile" name="prescription_file"
                                            accept=".jpg,.jpeg,.png,.pdf" hidden required>

                                        <i class="bi bi-cloud-upload"></i>
                                        <p><strong>Click to upload</strong> or drag and drop</p>
                                        <small>PDF, JPG, PNG (Max. 10MB)</small>

                                        <br>
                                        <button type="button" class="choose-file-btn">Choose File</button>
                                        <div id="fileName" class="file-name"></div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label>Additional Notes (optional)</label>
                                    <div class="textarea-wrap">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                        <textarea name="notes"
                                            placeholder="Any additional information you'd like to share...">{{ old('notes') }}</textarea>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label class="consent">
                                        <input type="checkbox" name="consent" value="1" required>
                                        <span>
                                            I consent to MediLeaf Health contacting me regarding my enquiry and
                                            understand that my prescription will be reviewed by our clinical team.
                                        </span>
                                    </label>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="submit-btn">
                                        <i class="fa-regular fa-paper-plane"></i>
                                        Submit Prescription Enquiry
                                    </button>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
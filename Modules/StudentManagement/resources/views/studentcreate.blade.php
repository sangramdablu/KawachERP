@extends('layouts.master')
@section('content')

<style>
    /* Variables for theme */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
    :root {
        --stu-primary: #00c8bf;
        --primary-accent: #e83e8c;
        --stu-secondary: #f8f9fa;
        --stu-card-bg: #ffffff;
        --stu-card-shadow: rgba(0, 0, 0, 0.1);
        --stu-border-color: #dee2e6;
    }

    /* Main Section Container */
    .stu-form-section {
        background-color: #ffffff;
        min-height: 100vh;
        font-family: 'Arial', sans-serif;
        padding: 15px;
    }

    /* Card Wrapper */
    .stu-form-card {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        background-color: var(--stu-card-bg);
        border-radius: 12px;
        box-shadow: 0 5px 20px var(--stu-card-shadow);
        overflow: hidden;
    }

    /* Header Styling */
    .stu-form-header {
        padding: 25px;
        background-color: var(--stu-primary);
        color: white;
        text-align: center;
    }

    .stu-form-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .stu-form-subtitle {
        font-size: 1rem;
        opacity: 0.9;
    }

    /* Form Body Padding */
    .stu-form-body {
        padding: 30px;
    }

    /* Box style for each form section */
    .stu-form-group-box {
        background-color: #ffffff;
        border-radius: 10px;
        padding: 25px;
        margin-bottom: 30px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        border: 1px solid #f0f0f0;
    }

    .stu-form-group-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #343a40;
        margin-top: 0;
        margin-bottom: 20px;
        padding-bottom: 5px;
        border-bottom: 2px solid var(--stu-border-color);
    }

    /* Customizing Form Controls */
    .stu-form-control {
        border-radius: 6px;
        padding: 10px 15px;
        transition: border-color 0.2s, box-shadow 0.2s;
        width: 100%;
    }

    .stu-form-control:focus {
        border-color: var(--stu-primary);
        box-shadow: 0 0 0 0.25rem rgba(32, 201, 151, 0.25);
    }

    .stu-form-label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 5px;
    }

    .stu-form-required::after {
        content: ' *';
        color: #dc3545;
    }

    /* Submit Button */
    .stu-form-button {
        width: 100%;
        padding: 12px 0;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 8px;
        margin-top: 20px;
        transition: background-color 0.2s;
    }

    .stu-form-button:hover {
        background-color: #00c8bf;
    }

    /* ------------------------ */
    /* Responsive Design Tweaks */
    /* ------------------------ */

    @media (max-width: 992px) {
        .stu-form-title {
            font-size: 1.6rem;
        }
        .stu-form-body {
            padding: 20px;
        }
    }

    @media (max-width: 768px) {
        .stu-form-card {
            border-radius: 8px;
            box-shadow: none;
        }

        .stu-form-section {
            padding: 10px;
        }

        .stu-form-group-box {
            padding: 20px;
            margin-bottom: 20px;
        }

        .stu-form-title {
            font-size: 1.5rem;
        }

        .stu-form-group-title {
            font-size: 1.2rem;
        }
    }

    @media (max-width: 576px) {
        .stu-form-section {
            padding: 8px;
        }

        .stu-form-body {
            padding: 15px;
        }

        .stu-form-header {
            padding: 15px;
        }

        .stu-form-title {
            font-size: 1.3rem;
        }

        .stu-form-subtitle {
            font-size: 0.9rem;
        }

        .stu-form-group-box {
            padding: 15px;
        }
    }

    @media (max-width: 768px) {
        .content-wrapper,
        .content-wrapper .row,
        .content-wrapper .card,
        .content-wrapper .card-body,
        .content-wrapper .grid-margin,
        .content-wrapper .icons-list {
            margin: 0 !important;
            padding: 0 !important;
        }

        /* Ensure the form takes full width */
        .stu-form-section {
            width: 100% !important;
            max-width: 100% !important;
            padding: 10px !important;
        }

        /* Remove Bootstrap’s default card border/shadow */
        .content-wrapper .card {
            border: none !important;
            box-shadow: none !important;
        }

        /* Optional: better mobile background */
        .content-wrapper {
            background-color: #f9f9f9 !important;
        }
    }
</style>

        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-12 grid-margin">
              <div class="card">

            <section class="stu-form-section">
                
                <div class="stu-form-card">
                    <header class="stu-form-header">
                        <div>
                            <h1 class="stu-form-title">Student Enrollment Application</h1>
                            <p class="stu-form-subtitle">Please provide all necessary details for a Student admission.</p>
                            <p class="stu-form-subtitle">or</p>
                        </div>
                        <div>
                            <a href="{{ route('tenant.student.bulkaddstudent') }}">
                                <button type="button" class="btn btn-primary btn-rounded btn-fw" style="background-color: #844fc1">Add Bulk Students</button>
                                {{-- <button type="button" class="btn btn-primary mb-3">Add Bulk Students</button> --}}
                            </a>
                        </div>
                    </header>

                    <form class="stu-form-body needs-validation" method="POST">
                        @csrf
                        <!-- ---------------------------------------------------- -->
                        <!-- SECTION 1: PERSONAL & IDENTIFICATION WRAPPER -->
                        <!-- ---------------------------------------------------- -->
                        <div class="stu-form-group-box">
                            <h3 class="stu-form-group-title">1. Personal & Identification Details</h3>
                            <div class="row g-4">
                                <!-- First Name -->
                                <div class="col-md-6 col-lg-3">
                                    <label for="firstName" class="form-label stu-form-label stu-form-required">First Name</label>
                                    <input type="text" id="firstName" name="first_name" class="form-control stu-form-control" required>
                                </div>

                                <!-- Last Name -->
                                <div class="col-md-6 col-lg-3">
                                    <label for="lastName" class="form-label stu-form-label stu-form-required">Last Name</label>
                                    <input type="text" id="lastName" name="last_name" class="form-control stu-form-control" required>
                                </div>

                                <!-- Full Name (Display Only) -->
                                <div class="col-md-6 col-lg-3">
                                    <label for="fullName" class="form-label stu-form-label">Full Name</label>
                                    <input type="text" id="fullName" name="full_name" class="form-control stu-form-control" disabled placeholder="Generated automatically">
                                </div>

                                <!-- Date of Birth -->
                                <div class="col-md-6 col-lg-3">
                                    <label for="dob" class="form-label stu-form-label stu-form-required">Date of Birth (DOB)</label>
                                    <input type="date" id="dob" name="dob" class="form-control stu-form-control" required>
                                </div>

                                <!-- Gender -->
                                <div class="col-md-4 col-lg-3">
                                    <label for="gender" class="form-label stu-form-label">Gender</label>
                                    <select id="gender" name="gender" class="form-select stu-form-control">
                                        <option value="">Select Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>

                                <!-- Nationality -->
                                <div class="col-md-4 col-lg-3">
                                    <label for="nationality" class="form-label stu-form-label">Nationality</label>
                                    <input type="text" id="nationality" name="nationality" class="form-control stu-form-control" placeholder="e.g., Indian">
                                </div>
                                
                                <!-- Religion -->
                                <div class="col-md-4 col-lg-3">
                                    <label for="religion" class="form-label stu-form-label">Religion</label>
                                    <input type="text" id="religion" name="religion" class="form-control stu-form-control">
                                </div>
           
                            </div>
                        </div>

                        <!-- ---------------------------------------------------- -->
                        <!-- SECTION 2: CONTACT & GUARDIAN WRAPPER -->
                        <!-- ---------------------------------------------------- -->
                        <div class="stu-form-group-box">
                            <h3 class="stu-form-group-title">2. Contact & Guardian Details</h3>
                            <div class="row g-4">
                                <!-- Student Email -->
                                <div class="col-md-6 col-lg-4">
                                    <label for="email" class="form-label stu-form-label">Student Email</label>
                                    <input type="email" id="email" name="email" class="form-control stu-form-control" placeholder="student@example.com">
                                </div>
                                <!-- Student Password -->
                                <div class="col-md-6 col-lg-4">
                                    <label for="email" class="form-label stu-form-label">Student Password</label>
                                    <input type="password" id="password" name="password" class="form-control stu-form-control" placeholder="*****">
                                </div>

                                <!-- Student Phone Number -->
                                <div class="col-md-6 col-lg-4">
                                    <label for="phone" class="form-label stu-form-label">Student Phone Number</label>
                                    <input type="tel" id="phone" name="phone_number" class="form-control stu-form-control" maxlength="15">
                                </div>
                                
                                <!-- Language Preference -->
                                <div class="col-md-6 col-lg-4">
                                    <label for="languagePreference" class="form-label stu-form-label">Language Preference</label>
                                    <input type="text" id="languagePreference" name="language_preference" class="form-control stu-form-control" placeholder="e.g., English, Hindi">
                                </div>

                                <!-- Guardian Name -->
                                <div class="col-md-6 col-lg-6">
                                    <label for="guardianName" class="form-label stu-form-label">Guardian Name</label>
                                    <input type="text" id="guardianName" name="guardian_name" class="form-control stu-form-control">
                                </div>

                                <!-- Guardian Phone -->
                                <div class="col-md-6 col-lg-6">
                                    <label for="guardianPhone" class="form-label stu-form-label">Guardian Phone</label>
                                    <input type="tel" id="guardianPhone" name="guardian_phone" class="form-control stu-form-control" maxlength="15">
                                </div>
                            </div>
                        </div>

                        <!-- ---------------------------------------------------- -->
                        <!-- SECTION 3: ADDRESS WRAPPER -->
                        <!-- ---------------------------------------------------- -->
                        <div class="stu-form-group-box">
                            <h3 class="stu-form-group-title">3. Permanent Address</h3>
                            <div class="row g-4">
                                <!-- Address (Full Width) -->
                                <div class="col-12">
                                    <label for="address" class="form-label stu-form-label">Street Address</label>
                                    <textarea id="address" name="address" class="form-control stu-form-control" rows="2"></textarea>
                                </div>

                                <!-- City -->
                                <div class="col-md-6 col-lg-3">
                                    <label for="city" class="form-label stu-form-label">City</label>
                                    <input type="text" id="city" name="city" class="form-control stu-form-control" maxlength="100">
                                </div>

                                <!-- State -->
                                <div class="col-md-6 col-lg-3">
                                    <label for="state" class="form-label stu-form-label">State</label>
                                    <input type="text" id="state" name="state" class="form-control stu-form-control" maxlength="100">
                                </div>

                                <!-- Country -->
                                <div class="col-md-6 col-lg-3">
                                    <label for="country" class="form-label stu-form-label">Country</label>
                                    <input type="text" id="country" name="country" class="form-control stu-form-control" maxlength="100">
                                </div>

                                <!-- Postal Code -->
                                <div class="col-md-6 col-lg-3">
                                    <label for="postalCode" class="form-label stu-form-label">Postal Code</label>
                                    <input type="text" id="postalCode" name="postal_code" class="form-control stu-form-control" maxlength="20">
                                </div>
                            </div>
                        </div>

                        <!-- ---------------------------------------------------- -->
                        <!-- SECTION 4: ENROLLMENT & MEDICAL WRAPPER -->
                        <!-- ---------------------------------------------------- -->
                        <div class="stu-form-group-box">
                            <h3 class="stu-form-group-title">4. Enrollment & Medical Information</h3>
                            <div class="row g-4">
                                <!-- Admission Date -->
                                <div class="col-md-6 col-lg-3">
                                    <label for="admissionDate" class="form-label stu-form-label stu-form-required">Admission Date</label>
                                    <input type="date" id="admissionDate" name="admission_date" class="form-control stu-form-control" required>
                                </div>

                                <!-- Enrollment Number -->
                                <div class="col-md-6 col-lg-3">
                                    <label for="enrollmentNumber" class="form-label stu-form-label">Enrollment Number</label>
                                    <input type="text" id="enrollmentNumber" name="enrollment_number" class="form-control stu-form-control" maxlength="100">
                                </div>

                                <!-- Grade -->
                                <div class="col-md-6 col-lg-3">
                                    <label for="grade" class="form-label stu-form-label">Grade/Class</label>
                                    
                                    <select id="grade" name="grade" class="form-control stu-form-control">
                                        <option value="">Select Class</option>
                                        @foreach($classes as $class)
                                            <option value="{{ $class->class_name }}">
                                                {{ $class->class_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Section -->
                                <div class="col-md-6 col-lg-3">
                                    <label for="section" class="form-label stu-form-label">Section</label>
                                    <select id="grade" name="grade" class="form-control stu-form-control">
                                        <option value="">Select Section</option>
                                        @foreach($classes as $class)
                                            <option value="{{ $class->section }}">
                                                {{ $class->section }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <!-- Profile Picture Upload -->
                                <div class="col-md-6 col-lg-4">
                                    <label for="profilePicture" class="form-label stu-form-label">Profile Picture Upload</label>
                                    <input type="file" id="profilePicture" name="profile_picture" class="form-control stu-form-control">
                                </div>

                                <!-- Blood Group -->
                                <div class="col-md-6 col-lg-4">
                                    <label for="bloodGroup" class="form-label stu-form-label">Blood Group</label>
                                    <input type="text" id="bloodGroup" name="blood_group" class="form-control stu-form-control" maxlength="10" placeholder="e.g., O+">
                                </div>
                                
                                <!-- Status (Display Only) -->
                                <div class="col-md-6 col-lg-4">
                                    <label for="status" class="form-label stu-form-label">Current Status</label>
                                    <input type="text" id="status" name="status" class="form-control stu-form-control" value="Active" disabled>
                                    <!-- Hidden field for the actual default value -->
                                    <input type="hidden" name="status" value="active">
                                </div>

                                <!-- Medical Conditions (Full Width) -->
                                <div class="col-12">
                                    <label for="medicalConditions" class="form-label stu-form-label">Medical Conditions / Allergies</label>
                                    <textarea id="medicalConditions" name="medical_conditions" class="form-control stu-form-control" rows="3" placeholder="List any known allergies, chronic conditions, or special medical needs."></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Hidden Fields -->
                        <input type="hidden" name="is_deleted" value="0">
                        
                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-secondary stu-form-button">Submit Enrollment Application</button>
                    </form>
                </div>
            </section>

              </div>
            </div>
          </div>
        </div>

        <script>
            $(document).ready(function() {

                $('.stu-form-body').on('submit', function(e) {
                    e.preventDefault();
                    const form = this;

                    showConfirm(
                        'Confirm Submission',
                        'Are you sure you want to submit this student enrollment?',
                        function(confirmed) {

                            if (confirmed) {
                                showLoader([
                                    "Submitting student data...",
                                    "Saving record to the database...",
                                    "Please wait...",
                                    "Almost done..."
                                ]);

                                const formData = new FormData(form);

                                $.ajax({
                                    url: "{{ route('tenant.student.store') }}",
                                    method: "POST",
                                    data: formData,
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    contentType: false,
                                    processData: false,

                                    success: function(response) {

                                        hideLoader();
                                        showSuccess(
                                            'Success',
                                            response.message,
                                            function() {
                                                window.location.reload();
                                            }
                                        );
                                    },
                                    error: function(xhr) {
                                        hideLoader();

                                        if (xhr.status === 422) {
                                            let msg = Object.values(xhr.responseJSON.errors)
                                                .map(e => e.join('<br>'))
                                                .join('<br>');

                                            showError('Validation Error', msg);

                                        } else {
                                            showError('Error', 'Something went wrong. Please try again.');
                                        }
                                    }
                                });
                            }
                        }
                    );
                });

            });
        </script>


        {{-- <script>
            $(document).ready(function() {
                // Confirm before submit
                $('.stu-form-body').on('submit', function(e) {
                    e.preventDefault();
                    const form = this;

                    showConfirm(
                        'Confirm Submission',
                        'Are you sure you want to submit this student enrollment?',
                        function(confirmed) {
                            if (confirmed) {
                                // Build FormData for file upload
                                const formData = new FormData(form);

                                $.ajax({
                                    url: "{{ route('tenant.student.store') }}",
                                    method: "POST",
                                    data: formData,
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    contentType: false,
                                    processData: false,
                                    success: function(response) {
                                        showSuccess(
                                            'Success',
                                            response.message,
                                            function() { window.location.reload(); }
                                        );
                                    },
                                    error: function(xhr) {
                                        if (xhr.status === 422) {
                                            let msg = Object.values(xhr.responseJSON.errors)
                                                .map(e => e.join('<br>')).join('<br>');
                                            showError('Validation Error', msg);
                                        } else {
                                            showError('Error', 'Something went wrong. Please try again.');
                                        }
                                    }
                                });
                            }
                        }
                    );
                });
            });
        </script> --}}

@endsection
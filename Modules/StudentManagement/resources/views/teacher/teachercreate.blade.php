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

                        <!-- Header -->
                        <header class="stu-form-header">
                            <div>
                                <h1 class="stu-form-title">Teacher Registration</h1>
                                <p class="stu-form-subtitle">Please provide all necessary details to add a new teacher.</p>
                            </div>

                            <div>
                                <a href="#">
                                    <button type="button" class="btn btn-primary btn-rounded btn-fw" style="background-color:#844fc1;">
                                        Add Bulk Teachers
                                    </button>
                                </a>
                            </div>
                        </header>

                        <!-- Form Start -->
                        <form class="teacher-form-body needs-validation" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- -----------------------------------------------------
                                 SECTION 1: PERSONAL INFORMATION
                            ------------------------------------------------------ -->
                            <div class="stu-form-group-box">
                                <h3 class="stu-form-group-title">1. Personal Details</h3>

                                <div class="row g-4">

                                    <div class="col-md-6 col-lg-3">
                                        <label class="form-label stu-form-label stu-form-required">First Name</label>
                                        <input type="text" name="first_name" class="form-control stu-form-control" required>
                                    </div>

                                    <div class="col-md-6 col-lg-3">
                                        <label class="form-label stu-form-label stu-form-required">Last Name</label>
                                        <input type="text" name="last_name" class="form-control stu-form-control" required>
                                    </div>

                                    <div class="col-md-6 col-lg-3">
                                        <label class="form-label stu-form-label">Email</label>
                                        <input type="email" name="email" class="form-control stu-form-control" required>
                                    </div>

                                    <div class="col-md-6 col-lg-3">
                                        <label class="form-label stu-form-label">Phone Number</label>
                                        <input type="tel" name="phone_number" maxlength="15" class="form-control stu-form-control">
                                    </div>

                                    <!-- DOB -->
                                    <div class="col-md-6 col-lg-3">
                                        <label class="form-label stu-form-label">Date of Birth</label>
                                        <input type="date" name="dob" class="form-control stu-form-control">
                                    </div>

                                    <!-- Gender -->
                                    <div class="col-md-6 col-lg-3">
                                        <label class="form-label stu-form-label">Gender</label>
                                        <select name="gender" class="form-select stu-form-control">
                                            <option value="">Select Gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>

                                    <!-- Nationality -->
                                    <div class="col-md-6 col-lg-3">
                                        <label class="form-label stu-form-label">Nationality</label>
                                        <input type="text" name="nationality" class="form-control stu-form-control">
                                    </div>

                                    <!-- Religion -->
                                    <div class="col-md-6 col-lg-3">
                                        <label class="form-label stu-form-label">Religion</label>
                                        <input type="text" name="religion" class="form-control stu-form-control">
                                    </div>

                                </div>
                            </div>

                            <!-- -----------------------------------------------------
                                 SECTION 2: ADDRESS
                            ------------------------------------------------------ -->
                            <div class="stu-form-group-box">
                                <h3 class="stu-form-group-title">2. Address Information</h3>

                                <div class="row g-4">
                                    <div class="col-12">
                                        <label class="form-label stu-form-label">Full Address</label>
                                        <textarea name="address" class="form-control stu-form-control" rows="2"></textarea>
                                    </div>

                                    <div class="col-md-6 col-lg-3">
                                        <label class="form-label stu-form-label">City</label>
                                        <input type="text" name="city" class="form-control stu-form-control">
                                    </div>

                                    <div class="col-md-6 col-lg-3">
                                        <label class="form-label stu-form-label">State</label>
                                        <input type="text" name="state" class="form-control stu-form-control">
                                    </div>

                                    <div class="col-md-6 col-lg-3">
                                        <label class="form-label stu-form-label">Country</label>
                                        <input type="text" name="country" class="form-control stu-form-control">
                                    </div>

                                    <div class="col-md-6 col-lg-3">
                                        <label class="form-label stu-form-label">Postal Code</label>
                                        <input type="text" name="postal_code" class="form-control stu-form-control">
                                    </div>

                                </div>
                            </div>

                            <!-- -----------------------------------------------------
                                 SECTION 3: PROFESSIONAL DETAILS
                            ------------------------------------------------------ -->
                            <div class="stu-form-group-box">
                                <h3 class="stu-form-group-title">3. Academic & Professional Details</h3>

                                <div class="row g-4">

                                    <div class="col-md-6 col-lg-4">
                                        <label class="form-label stu-form-label">Qualification</label>
                                        <input type="text" name="qualification" class="form-control stu-form-control">
                                    </div>

                                    <div class="col-md-6 col-lg-4">
                                        <label class="form-label stu-form-label">Total Experience (Years)</label>
                                        <input type="text" name="experience_years" class="form-control stu-form-control">
                                    </div>

                                    <div class="col-md-6 col-lg-4">
                                        <label class="form-label stu-form-label stu-form-required">Employee ID</label>
                                        <input type="text" name="employee_id" class="form-control stu-form-control" required>
                                    </div>

                                    <div class="col-md-6 col-lg-4">
                                        <label class="form-label stu-form-label">Joining Date</label>
                                        <input type="date" name="joining_date" class="form-control stu-form-control">
                                    </div>

                                    <div class="col-md-6 col-lg-4">
                                        <label class="form-label stu-form-label">Designation</label>
                                        <input type="text" name="designation" class="form-control stu-form-control">
                                    </div>

                                    <div class="col-md-6 col-lg-4">
                                        <label class="form-label stu-form-label">Specialization</label>
                                        <textarea name="specialization" class="form-control stu-form-control" rows="2"></textarea>
                                    </div>

                                </div>
                            </div>

                            <!-- -----------------------------------------------------
                                 SECTION 4: ADDITIONAL DETAILS
                            ------------------------------------------------------ -->
                            <div class="stu-form-group-box">
                                <h3 class="stu-form-group-title">4. Additional Information</h3>

                                <div class="row g-4">

                                    <div class="col-md-6 col-lg-4">
                                        <label class="form-label stu-form-label">Language Preference</label>
                                        <input type="text" name="language_preference" class="form-control stu-form-control">
                                    </div>

                                    <div class="col-md-6 col-lg-4">
                                        <label class="form-label stu-form-label">Blood Group</label>
                                        <input type="text" name="blood_group" class="form-control stu-form-control">
                                    </div>

                                    <div class="col-md-6 col-lg-4">
                                        <label class="form-label stu-form-label">Profile Picture</label>
                                        <input type="file" name="profile_picture" class="form-control stu-form-control">
                                    </div>

                                    <!-- Status -->
                                    <div class="col-md-6 col-lg-4">
                                        <label class="form-label stu-form-label">Status</label>
                                        <input type="text" class="form-control stu-form-control" value="Active" disabled>
                                        <input type="hidden" name="status" value="active">
                                    </div>

                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-secondary stu-form-button">
                                Submit Teacher Registration
                            </button>

                        </form>
                    </div>
                </section>

            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {

    $('.teacher-form-body').on('submit', function(e) {
        e.preventDefault();
        const form = this;

        showConfirm(
            'Confirm Submission',
            'Are you sure you want to submit this teacher registration?',
            function(confirmed) {

                if (confirmed) {

                    showLoader([
                        "Submitting teacher data...",
                        "Validating information...",
                        "Saving record to the database...",
                        "Please wait...",
                        "Almost done..."
                    ]);

                    const formData = new FormData(form);

                    $.ajax({
                        url: "{{ route('tenant.teacher.teacher-store') }}",
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

                                let msg = Object
                                    .values(xhr.responseJSON.errors)
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



@endsection
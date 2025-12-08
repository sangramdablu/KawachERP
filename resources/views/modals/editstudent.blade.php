<style>
/* 1. Backdrop (Black 0.5) */
.custom-dark-bg.modal.show {
    --bs-modal-backdrop-bg: #000;
    --bs-modal-backdrop-opacity: 0.5;
}

/* 2. Modal Content Card */
.custom-contact-content {
    border-radius: 15px;
    border: none;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    overflow: hidden;
    position: relative;
    background-color: #ffffff; /* Clean white card */
}

/* 3. Close Button */
.custom-close-btn {
    position: absolute;
    top: 20px;
    right: 20px;
    z-index: 10;
    font-size: 1.25rem;
    opacity: 0.8;
    color: #333;
    transition: opacity 0.2s;
}
.custom-close-btn:hover {
    opacity: 1;
}

/* 4. Title and Logo */
.custom-modal-logo-small {
    width: 30px; 
    height: 30px;
    border-radius: 4px; 
    object-fit: cover;
}

.custom-contact-title {
    font-weight: 700;
    color: #333;
    letter-spacing: -0.5px;
    font-size: 1.75rem;
}

/* Subtitles for sections */
.custom-group-subtitle {
    font-size: 1.25rem;
    font-weight: 600;
    color: #555;
    margin-bottom: 1.5rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid #f0f0f0;
}

/* 5. Custom Input Styling (Underline Effect) */
.stu-form-label {
    font-size: 0.9rem;
    font-weight: 500;
    color: #888;
    margin-bottom: 5px;
    display: block;
}

.stu-form-required::after {
    content: ' *';
    color: #e83e8c; 
    margin-left: 1px;
}

.custom-contact-input {
    border: none;
    border-bottom: 1px solid #ccc; /* Subtle initial underline */
    border-radius: 0;
    padding: 8px 0;
    box-shadow: none;
    background-color: transparent;
    transition: border-bottom-color 0.3s;
    color: #333; /* Dark text for contrast on white background */
}

.custom-contact-input:focus {
    border-bottom: 2px solid #e83e8c; /* Pink focus underline */
    box-shadow: none;
    background-color: #fff;
}

/* Disabled/Read-only fields */
.custom-contact-input:disabled,
.custom-contact-input[disabled] {
    background-color: #f7f7f7;
    color: #666;
    border-bottom: 1px solid #e0e0e0;
}


/* 6. Save Changes Button (Gradient and Shadow) */
.custom-submit-btn {
    background: linear-gradient(45deg, #e83e8c, #d12e7e); 
    border: none;
    color: white;
    font-weight: 600;
    padding: 0.75rem 2rem;
    border-radius: 50px; 
    box-shadow: 0 5px 15px rgba(232, 62, 140, 0.4); 
    transition: all 0.3s ease;
    text-transform: uppercase;
    font-size: 0.9rem;
}

.custom-submit-btn:hover {
    filter: brightness(1.1);
    transform: translateY(-1px);
    box-shadow: 0 7px 20px rgba(232, 62, 140, 0.6);
}
</style>

<div class="modal fade custom-dark-bg" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content custom-contact-content">
            <button type="button" class="btn-close custom-close-btn" data-bs-dismiss="modal" aria-label="Close"></button>

            <div class="modal-body p-5">
                <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                    <img src="https://via.placeholder.com/40x40/5D2F6B/FFFFFF?text=LOGO" alt="School Logo" class="me-3 custom-modal-logo-small">
                    <h2 class="modal-title custom-contact-title m-0" id="editStudentModalLabel">
                        Edit Student Enrollment Record
                    </h2>
                </div>
                
                <form id="editStudentForm">
                    
                    <div class="stu-form-group-box mb-5">
                        <h3 class="stu-form-group-title custom-group-subtitle">1. Personal & Identification Details</h3>
                        <div class="row g-4">
                            <div class="col-md-6 col-lg-3">
                                <label for="firstName" class="form-label stu-form-label stu-form-required">First Name</label>
                                <input type="text" id="firstName" name="first_name" class="form-control stu-form-control custom-contact-input" required>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <label for="lastName" class="form-label stu-form-label stu-form-required">Last Name</label>
                                <input type="text" id="lastName" name="last_name" class="form-control stu-form-control custom-contact-input" required>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <label for="fullName" class="form-label stu-form-label">Full Name</label>
                                <input type="text" id="fullName" name="full_name" class="form-control stu-form-control custom-contact-input" disabled placeholder="Generated automatically">
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <label for="dob" class="form-label stu-form-label stu-form-required">Date of Birth (DOB)</label>
                                <input type="date" id="dob" name="dob" class="form-control stu-form-control custom-contact-input" required>
                            </div>
                            <div class="col-md-4 col-lg-3">
                                <label for="gender" class="form-label stu-form-label">Gender</label>
                                <select id="gender" name="gender" class="form-select stu-form-control custom-contact-input">
                                    <option value="">Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="col-md-4 col-lg-3">
                                <label for="nationality" class="form-label stu-form-label">Nationality</label>
                                <input type="text" id="nationality" name="nationality" class="form-control stu-form-control custom-contact-input" placeholder="e.g., Indian">
                            </div>
                            <div class="col-md-4 col-lg-3">
                                <label for="religion" class="form-label stu-form-label">Religion</label>
                                <input type="text" id="religion" name="religion" class="form-control stu-form-control custom-contact-input">
                            </div>
                        </div>
                    </div>

                    <div class="stu-form-group-box mb-5">
                        <h3 class="stu-form-group-title custom-group-subtitle">2. Contact & Guardian Details</h3>
                        <div class="row g-4">
                            <div class="col-md-6 col-lg-4">
                                <label for="email" class="form-label stu-form-label">Student Email</label>
                                <input type="email" id="email" name="email" class="form-control stu-form-control custom-contact-input" placeholder="student@example.com">
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <label for="phone" class="form-label stu-form-label">Student Phone Number</label>
                                <input type="tel" id="phone" name="phone_number" class="form-control stu-form-control custom-contact-input" maxlength="15">
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <label for="languagePreference" class="form-label stu-form-label">Language Preference</label>
                                <input type="text" id="languagePreference" name="language_preference" class="form-control stu-form-control custom-contact-input" placeholder="e.g., English, Hindi">
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <label for="guardianName" class="form-label stu-form-label">Guardian Name</label>
                                <input type="text" id="guardianName" name="guardian_name" class="form-control stu-form-control custom-contact-input">
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <label for="guardianPhone" class="form-label stu-form-label">Guardian Phone</label>
                                <input type="tel" id="guardianPhone" name="guardian_phone" class="form-control stu-form-control custom-contact-input" maxlength="15">
                            </div>
                        </div>
                    </div>

                    <div class="stu-form-group-box mb-5">
                        <h3 class="stu-form-group-title custom-group-subtitle">3. Permanent Address</h3>
                        <div class="row g-4">
                            <div class="col-12">
                                <label for="address" class="form-label stu-form-label">Street Address</label>
                                <textarea id="address" name="address" class="form-control stu-form-control custom-contact-input" rows="2"></textarea>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <label for="city" class="form-label stu-form-label">City</label>
                                <input type="text" id="city" name="city" class="form-control stu-form-control custom-contact-input" maxlength="100">
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <label for="state" class="form-label stu-form-label">State</label>
                                <input type="text" id="state" name="state" class="form-control stu-form-control custom-contact-input" maxlength="100">
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <label for="country" class="form-label stu-form-label">Country</label>
                                <input type="text" id="country" name="country" class="form-control stu-form-control custom-contact-input" maxlength="100">
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <label for="postalCode" class="form-label stu-form-label">Postal Code</label>
                                <input type="text" id="postalCode" name="postal_code" class="form-control stu-form-control custom-contact-input" maxlength="20">
                            </div>
                        </div>
                    </div>

                    <div class="stu-form-group-box mb-4">
                        <h3 class="stu-form-group-title custom-group-subtitle">4. Enrollment & Medical Information</h3>
                        <div class="row g-4">
                            <div class="col-md-6 col-lg-3">
                                <label for="admissionDate" class="form-label stu-form-label stu-form-required">Admission Date</label>
                                <input type="date" id="admissionDate" name="admission_date" class="form-control stu-form-control custom-contact-input" required>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <label for="enrollmentNumber" class="form-label stu-form-label">Enrollment Number</label>
                                <input type="text" id="enrollmentNumber" name="enrollment_number" class="form-control stu-form-control custom-contact-input" maxlength="100">
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <label for="grade" class="form-label stu-form-label">Grade/Class</label>
                                <input type="text" id="grade" name="grade" class="form-control stu-form-control custom-contact-input" maxlength="50" placeholder="e.g., 10th">
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <label for="section" class="form-label stu-form-label">Section</label>
                                <input type="text" id="section" name="section" class="form-control stu-form-control custom-contact-input" maxlength="50" placeholder="e.g., A">
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <label for="profilePicture" class="form-label stu-form-label">Profile Picture Upload</label>
                                <input type="file" id="profilePicture" name="profile_picture" class="form-control stu-form-control custom-contact-input">
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <label for="bloodGroup" class="form-label stu-form-label">Blood Group</label>
                                <input type="text" id="bloodGroup" name="blood_group" class="form-control stu-form-control custom-contact-input" maxlength="10" placeholder="e.g., O+">
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <label for="status" class="form-label stu-form-label">Current Status</label>
                                <input type="text" id="status" name="status" class="form-control stu-form-control custom-contact-input" value="Active" disabled>
                                <input type="hidden" name="status" value="active">
                            </div>
                            <div class="col-12">
                                <label for="medicalConditions" class="form-label stu-form-label">Medical Conditions / Allergies</label>
                                <textarea id="medicalConditions" name="medical_conditions" class="form-control stu-form-control custom-contact-input" rows="3" placeholder="List any known allergies, chronic conditions, or special medical needs."></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end pt-3 mt-4 border-top">
                        <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn custom-submit-btn">
                            Save Changes <i class="fas fa-save ms-2"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $('#studentsTable').on('click', '.edit-btn', function () {
        const studentId = $(this).data('id');
        console.log("Editing student:", studentId);

        // Fetch data via AJAX
        $.ajax({
            url: `/school/student/${studentId}/edit`, // adjust route name if needed
            type: 'GET',
            beforeSend: function () {
                // Optionally, show loading indicator
                $('#editStudentModal').modal('show');
                $('#editStudentForm')[0].reset();
            },
            success: function (response) {
                if (response && response.student) {
                    const s = response.student;
                    // Fill modal form
                    $('#firstName').val(s.first_name || '');
                    $('#editStudentForm').attr('data-id', s.id);
                } else {
                    showSuccess("Error", "Could not fetch student details.");
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                showSuccess("Error", "Failed to fetch student data.");
            }
        });
    });

    $('#saveStudentChanges').on('click', function () {
        const studentId = $('#editStudentForm').attr('data-id');
        const formData = $('#editStudentForm').serialize();

        $.ajax({
            url: `/school/student/update/${studentId}`,
            type: 'POST',
            data: formData,
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            success: function (response) {
                $('#editStudentModal').modal('hide');
                showSuccess("Updated!", "Student details updated successfully.", () => {
                    table.ajax.reload();
                });
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                showSuccess("Error", "Failed to update student details.");
            }
        });
    });
</script>
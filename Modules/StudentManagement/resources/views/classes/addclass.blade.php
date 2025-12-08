@extends('layouts.master')
@section('content')

<style>
    .stat-card-custom {
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      background: #fff;
      border-radius: 12px;
      padding: 1.5rem;
      height: 100%;
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
      transition: transform 0.25s ease;
    }

    .stat-card-custom:hover {
      transform: translateY(-3px);
    }

    .icon-circle-lg {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      font-size: 1.25rem;
      box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.2);
    }

    .icon-circle-red {
      background-color: #dc3545;
    }

    .icon-circle-orange {
      background-color: #fd7e14;
    }

    .icon-circle-pink {
      background-color: #d63384;
    }

    .icon-circle-cyan {
      background-color: #0dcaf0;
    }

    .stat-card-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
    }

    .stat-card-label {
      color: #6c757d;
      font-size: 0.8rem;
      font-weight: 600;
      text-transform: uppercase;
      margin-bottom: 0.2rem;
    }

    .stat-card-value {
      color: #212529;
      font-size: 1.8rem;
      font-weight: 700;
    }

    .stat-card-footer {
      display: flex;
      justify-content: flex-end;
    }

    .stat-card-change {
      font-size: 0.85rem;
      font-weight: 500;
    }

    /* Statistics grid */
    .icons-list {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 15px;
    }

    .bg-light-yellow {
      background-color: #fffde7;
    }

    #customSearchInput {
      border-radius: 0.25rem;
      border: 1px solid #dee2e6;
    }

    #customSearchInput:focus {
      box-shadow: none;
      border-color: #ced4da;
    }

    /* Hide default DataTables filter & length dropdown */
    .dataTables_filter,
    .dataTables_length {
      display: none !important;
    }

    /* Table styling */
    #teachersTable th,
    #teachersTable td {
      border: 0.5px solid #a4a4a4 !important;
      vertical-align: middle;
      padding: 10px 12px;
    }

    #teachersTable th:first-child,
    #teachersTable td:first-child {
      text-align: center;
    }

    #teachersTable thead th {
      background-color: #f8f9fa;
      font-weight: 600;
      color: #343a40;
    }

    #teachersTable tbody tr:hover>td {
      background-color: #f1f3f5 !important;
    }

    /* Table striping */
    #teachersTable.dataTable tbody tr:nth-child(odd)>td {
      background-color: #ffffff !important;
    }

    #teachersTable.dataTable tbody tr:nth-child(even)>td {
      background-color: #ddf9ff !important;
    }

    .dataTables_info,
    .dataTables_paginate {
      padding: 1rem 0;
    }

    /* Make checkbox slightly larger */
    #teachersTable th.text-center input[type="checkbox"] {
      transform: scale(1.1);
    }

    /* Mobile fix */
    @media (max-width: 576px) {
      #teachersTable.dataTable tbody td {
        background-clip: padding-box;
      }
    }
    .metric-value {
        font-size: 2.25rem;
        font-weight: 700;
        margin-top: 0.25rem;
    }
    .metric-label {
        font-size: 0.875rem;
        color: #6c757d;
        font-weight: 500;
    }
    .custom-scroll::-webkit-scrollbar {
        height: 6px;
    }
    .custom-scroll::-webkit-scrollbar-thumb {
        background: #adb5bd;
        border-radius: 10px;
    }
    .border-start-4 {
        border-left: 4px solid !important;
    }
</style>

<style>
    /* Custom Styles to match the Dashboard's Modern Aesthetic */
    :root {
        --bs-primary-light: #a267f6; /* Main Purple/Magenta */
        --bs-success-teal: #00bcd4;  /* Accent Teal/Cyan */
        --bs-body-bg: #f5f6fa; /* Light background */
        --bs-card-bg-gradient: linear-gradient(135deg, #fefefe, #fcfcfc);
    }
    /* Enhanced Card Styling */
    .card.shadow-lg {
        box-shadow: 0 1rem 3rem rgba(162, 103, 246, 0.2) !important; /* Stronger purple shadow */
        background: var(--bs-card-bg-gradient);
        border: none;
    }
    /* Gradient Header Matching Dashboard Cards */
    .card-header-gradient {
        background: linear-gradient(135deg, var(--bs-primary-light) 0%, #7b68ee 100%);
        color: white;
        padding: 1.5rem !important;
    }
    /* Primary Button with Accent Gradient and Strong Shadow */
    .btn-success-gradient {
        background: linear-gradient(90deg, var(--bs-primary-light) 0%, #7b68ee 100%);
        border: none;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 0.5rem 1rem rgba(162, 103, 246, 0.4);
    }
    .btn-success-gradient:hover {
        opacity: 0.9;
        box-shadow: 0 0.8rem 1.5rem rgba(162, 103, 246, 0.5);
        transform: translateY(-2px);
        color: white;
    }
    /* Form Control Focus Style */
    .form-control:focus, .form-select:focus {
        border-color: var(--bs-primary-light);
        box-shadow: 0 0 0 0.25rem rgba(162, 103, 246, 0.25);
    }
    /* Preview Badge Style */
    .class-preview-badge {
        font-size: 1.25rem;
        padding: 0.5rem 1rem;
        background-color: var(--bs-success-teal);
        color: white;
        border-radius: 0.5rem;
        box-shadow: 0 0.2rem 0.5rem rgba(0, 188, 212, 0.4);
        transition: all 0.3s ease;
        min-height: 48px;
        display: inline-flex;
        align-items: center;
    }
</style>

<div class="card">
    <div class="card-body">
    {{-- <header class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">

        <h4 class="card-title mb-3">Class Statistics</h4>
        <div class="d-flex gap-3">
            <button class="btn btn-outline-secondary d-flex align-items-center rounded-5 shadow-sm transition duration-150">
                <i data-lucide="arrow-down-to-line" class="w-4 h-4 me-2"></i>
                Export
            </button>
            <button id="addRowBtn" type="button" class="add-row-btn btn text-white fw-semibold py-2 px-4 rounded-pill d-flex align-items-center shadow-lg" style="background: linear-gradient(45deg, #e83e8c, #d12e7e);">
                <i data-lucide="plus" class="fas fa-plus me-2"></i>
                Add Class
            </button>
        </div>
    </header> --}}
    <!-- Start of the four card columns -->
    <div class="container-fluid py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                
                <!-- Page Header -->
                <header class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                    <h1 class="fs-3 fw-bolder text-dark">
                        <i data-lucide="plus-circle" class="w-6 h-6 me-2 text-primary-light"></i>
                        Create New Class
                    </h1>
                    <a href="#" class="btn btn-outline-secondary d-flex align-items-center rounded-3 shadow-sm">
                        <i data-lucide="layout-dashboard" class="w-4 h-4 me-2"></i>
                        Back to Dashboard
                    </a>
                </header>

                <!-- Success Message Display -->
                <div id="successMessage" class="alert alert-success d-none rounded-3" role="alert">
                    <h4 class="alert-heading"><i data-lucide="check-circle" class="w-5 h-5 me-2"></i> Class Created Successfully!</h4>
                    <p id="successText" class="mb-0"></p>
                </div>

                <!-- Modern Form Card -->
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-header card-header-gradient rounded-top-4">
                        <h2 class="fs-5 fw-semibold mb-0">Class Details Configuration</h2>
                        <p class="text-white-50 mb-0">Fill in the mandatory information to set up the new class section.</p>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <form id="classForm" action="#" method="POST" class="needs-validation" novalidate>
                            
                            <!-- Section 1: Core Identification -->
                            <div class="row g-4 mb-4 pb-4 border-bottom">
                                <h3 class="fs-6 fw-bold text-dark mb-3">1. Identification & Grade</h3>

                                <div class="col-md-6">
                                    <label for="className" class="form-label fw-semibold">Class Name / Section Identifier <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control rounded-3" id="className" name="class_name" placeholder="e.g., Grade 10 - B" required>
                                    <div class="invalid-feedback">Please provide a unique class name.</div>
                                    <small class="form-text text-muted">Unique name for this class section (e.g., Grade 7 A).</small>
                                </div>

                                <div class="col-md-3">
                                    <label for="gradeLevel" class="form-label fw-semibold">Grade Level <span class="text-danger">*</span></label>
                                    <select class="form-select rounded-3" id="gradeLevel" name="grade_level" required>
                                        <option value="" selected disabled>Select Grade</option>
                                        <option value="1">Grade 1 (Primary)</option>
                                        <option value="5">Grade 5 (Intermediate)</option>
                                        <option value="8">Grade 8 (Middle)</option>
                                        <option value="10">Grade 10 (Secondary)</option>
                                        <option value="12">Grade 12 (Senior)</option>
                                    </select>
                                    <div class="invalid-feedback">Please select a grade level.</div>
                                </div>

                                <div class="col-md-3">
                                    <label for="maxCapacity" class="form-label fw-semibold">Max Capacity</label>
                                    <input type="number" class="form-control rounded-3" id="maxCapacity" name="max_capacity" placeholder="e.g., 40" min="1" value="40">
                                </div>
                            </div>
                            
                            <!-- Live Preview Area -->
                            <div class="mb-5 d-flex align-items-center">
                                <span class="fw-semibold me-3 text-dark">Live Class Name Preview:</span>
                                <span id="classPreview" class="class-preview-badge">Class Preview</span>
                            </div>

                            <!-- Section 2: Teacher and Schedule -->
                            <div class="row g-4 mb-4 pb-4 border-bottom">
                                <h3 class="fs-6 fw-bold text-dark mb-3">2. Teacher Assignment & Schedule</h3>

                                <div class="col-md-6">
                                    <label for="classTeacher" class="form-label fw-semibold">Class Teacher <span class="text-danger">*</span></label>
                                    <select class="form-select rounded-3" id="classTeacher" name="class_teacher_id" required>
                                        <option value="" selected disabled>Select Class Teacher</option>
                                        <option value="1001" data-name="Mrs. Jane Doe">Mrs. Jane Doe (ID: 1001)</option>
                                        <option value="1002" data-name="Mr. John Smith">Mr. John Smith (ID: 1002)</option>
                                        <option value="1003" data-name="Dr. Alice Chen">Dr. Alice Chen (ID: 1003)</option>
                                        <option value="0" data-name="Unassigned">Unassigned (To be set later)</option>
                                    </select>
                                    <div class="invalid-feedback">Please select a class teacher.</div>
                                </div>

                                <div class="col-md-6">
                                    <label for="teacherIDDisplay" class="form-label fw-semibold">Selected Teacher ID</label>
                                    <input type="text" class="form-control rounded-3 bg-light" id="teacherIDDisplay" readonly placeholder="ID will appear here">
                                </div>
                                
                                <div class="col-12">
                                    <label for="scheduleTime" class="form-label fw-semibold">Daily Schedule Time</label>
                                    <input type="text" class="form-control rounded-3" id="scheduleTime" name="schedule_time" placeholder="e.g., Mon-Fri, 08:00 AM - 03:00 PM">
                                </div>
                            </div>

                            <!-- Section 3: Subject Configuration -->
                            <div class="row g-4 mb-5">
                                <h3 class="fs-6 fw-bold text-dark mb-3">3. Associated Subjects</h3>

                                <div class="col-12">
                                    <label class="form-label fw-semibold">Select Core Subjects</label>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" value="math" id="subjectMath" name="subjects[]">
                                                <label class="form-check-label" for="subjectMath">Mathematics</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" value="science" id="subjectScience" name="subjects[]">
                                                <label class="form-check-label" for="subjectScience">Science</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" value="history" id="subjectHistory" name="subjects[]">
                                                <label class="form-check-label" for="subjectHistory">History</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" value="language" id="subjectLanguage" name="subjects[]">
                                                <label class="form-check-label" for="subjectLanguage">Language Arts</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" value="art" id="subjectArt" name="subjects[]">
                                                <label class="form-check-label" for="subjectArt">Art & Design</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" value="pe" id="subjectPE" name="subjects[]">
                                                <label class="form-check-label" for="subjectPE">Physical Education</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex justify-content-end gap-3">
                                <button type="reset" class="btn btn-outline-secondary rounded-3">
                                    <i data-lucide="rotate-ccw" class="w-4 h-4 me-2"></i>
                                    Reset Form
                                </button>
                                <button type="submit" class="btn btn-success-gradient rounded-3">
                                    <i data-lucide="check-circle" class="w-4 h-4 me-2"></i>
                                    Create Class
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
    
    <!-- Script to load Lucide icons library -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- Script to initialize Lucide icons, assuming Lucide JS is included in layouts.master -->
    <script>
        lucide.createIcons();
    </script>
@endsection
    
    <script>
        // 1. Initialize Lucide Icons
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
            // Manually set initial preview
            updateClassPreview();
            updateTeacherIdDisplay();
        });

        // Get elements
        const classNameInput = document.getElementById('className');
        const classPreview = document.getElementById('classPreview');
        const classTeacherSelect = document.getElementById('classTeacher');
        const teacherIDDisplay = document.getElementById('teacherIDDisplay');
        const classForm = document.getElementById('classForm');
        const successMessage = document.getElementById('successMessage');
        const successText = document.getElementById('successText');


        // 2. Interactive Class Name Preview
        function updateClassPreview() {
            let name = classNameInput.value.trim();
            if (name.length > 0) {
                classPreview.textContent = name;
                classPreview.style.opacity = 1;
            } else {
                classPreview.textContent = 'Enter Class Name...';
                classPreview.style.opacity = 0.6;
            }
        }
        classNameInput.addEventListener('input', updateClassPreview);


        // 3. Interactive Teacher ID Display
        function updateTeacherIdDisplay() {
            const selectedOption = classTeacherSelect.options[classTeacherSelect.selectedIndex];
            const teacherId = selectedOption.value === '' ? '' : selectedOption.value;
            
            if (teacherId === '0') {
                 teacherIDDisplay.value = 'Unassigned';
                 teacherIDDisplay.classList.add('text-danger');
                 teacherIDDisplay.classList.remove('text-dark');
            } else if (teacherId === '') {
                 teacherIDDisplay.value = '';
                 teacherIDDisplay.classList.remove('text-danger', 'text-dark');
            }
            else {
                teacherIDDisplay.value = teacherId;
                teacherIDDisplay.classList.remove('text-danger');
                teacherIDDisplay.classList.add('text-dark');
            }
        }
        classTeacherSelect.addEventListener('change', updateTeacherIdDisplay);


        // 4. Form Submission and Validation Simulation
        classForm.addEventListener('submit', function (event) {
            event.preventDefault(); // Stop default form submission
            event.stopPropagation();

            classForm.classList.add('was-validated');

            if (classForm.checkValidity()) {
                // Form is valid, simulate successful submission
                
                const className = classNameInput.value;
                const teacherName = classTeacherSelect.options[classTeacherSelect.selectedIndex].getAttribute('data-name') || 'N/A';
                
                // Construct and display success message
                successText.innerHTML = `You have successfully created <b>${className}</b>. <br>Assigned Teacher: <b>${teacherName}</b>.`;
                successMessage.classList.remove('d-none');
                
                // Reset form state after successful submission
                classForm.classList.remove('was-validated');
                classForm.reset();
                
                // Update interactive displays to default
                updateClassPreview();
                updateTeacherIdDisplay();

                // Scroll to the top to show the message
                window.scrollTo({ top: 0, behavior: 'smooth' });

            } else {
                // Form is invalid, ensure message is hidden
                successMessage.classList.add('d-none');
            }
        }, false);
        
        // 5. Form Reset Handler
        classForm.addEventListener('reset', function() {
            // Delay reset of validation state
            setTimeout(() => {
                classForm.classList.remove('was-validated');
                successMessage.classList.add('d-none');
                updateClassPreview();
                updateTeacherIdDisplay();
            }, 50);
        });

    </script>
</body>
</html>
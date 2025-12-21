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

    /* Expand arrow */
    .expand-arrow {
        cursor: pointer;
        color: #444;
        font-size: 14px;
        transition: transform 0.25s ease;
    }

    /* Rotate when expanded */
    .expand-arrow i.rotate {
        transform: rotate(90deg);
    }

    /* Highlight row when expanded */
    .row-expanded {
        background: #e6f9ff !important;
    }

    /* Subtable wrapper */
    .sub-table-wrapper {
        padding: 10px 0;
        animation: glowBorder 2s infinite linear;
    }

    /* Smooth drop animation */
    .subtable-animate {
        animation: dropDown 0.35s ease-out;
    }
    /* Main container holding the connector + subtable */
    .child-connector {
        display: flex;
        padding-left: 40px;
        position: relative;
    }

    /* LONG vertical line auto-adjusts to content height */
    .connector-vertical {
        width: 20px;
        border-left: 2px solid #3b82f6;
        margin-right: 10px;
        position: relative;
    }

    /* Horizontal elbow only at the first row */
    .connector-vertical::after {
        content: "";
        position: absolute;
        top: 22px; /* aligns perfectly with first subject row */
        left: 0;
        width: 15px;
        border-top: 2px solid #3b82f6;
    }

    /* Sub-table itself */
    .connector-content {
        flex: 1;
    }

    @keyframes dropDown {
        from { opacity: 0; transform: translateY(-6px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* Animated glowing border */
    @keyframes glowBorder {
        0%   { border-color: rgba(132, 79, 193, 0.25); }
        50%  { border-color: rgba(132, 79, 193, 0.75); }
        100% { border-color: rgba(132, 79, 193, 0.25); }
    }


</style>

<div class="card">
    <div class="card-body">
    <header class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
        {{-- <h1 class="fs-3 fw-bolder text-dark mb-3 mb-md-0">
            Classes Management Dashboard
        </h1> --}}
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
    </header>
    <!-- Start of the four card columns -->
    <div class="icons-list">
        <!-- CARD 1 -->
        <div class="stat-card-custom" style="border: 1px solid #a4a4a4">
            <div class="stat-card-header">
                <div class="mr-3">
                <p class="stat-card-label">Total Classes</p>
                <p class="stat-card-value text-primary">350</p>
                </div>
                <div class="icon-circle-lg icon-circle-red ml-4">
                <i class="fa fa-area-chart text-center text-white"></i>
                </div>
            </div>
            <div class="stat-card-footer">
                <p class="stat-card-change text-success mb-0">
                <i class="fas fa-plus"></i>
                <span class="text-muted">+2 new this year</span>
                </p>
            </div>
        </div>
        <!-- CARD 2 -->
        <div class="stat-card-custom d-flex flex-column justify-content-between" style="border: 1px solid #a4a4a4">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="mr-3">
                <p class="stat-card-label">Total Students</p>
                <p class="stat-card-value text-success">2,356</p>
                </div>
                <div class="icon-circle-lg icon-circle-orange ml-4">
                <i class="fa fa-pie-chart text-center text-white"></i>
                </div>
            </div>
            <div>
                <p class="stat-card-change text-danger mb-0">
                <i class="fa fa-arrow-down me-1"></i>
                <span class="text-muted">+15% vs last year</span>
                </p>
            </div>
        </div>
        <!-- CARD 3 -->
        <div class="stat-card-custom d-flex flex-column justify-content-between" style="border: 1px solid #a4a4a4">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="mr-3">
                <p class="stat-card-label">Teachers Allocated</p>
                <p class="stat-card-value text-info">924</p>
                </div>
                <div class="icon-circle-lg icon-circle-pink ml-4">
                <i class="fa fa-users text-center text-white"></i>
                </div>
            </div>
            <div>
                <p class="stat-card-change text-danger mb-0">
                <i class="fa fa-arrow-down me-1"></i>
                <span class="text-muted">1 class unassigned</span>
                </p>
            </div>
        </div>
        <!-- CARD 4 -->
        <div class="stat-card-custom d-flex flex-column justify-content-between" style="border: 1px solid #a4a4a4">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="mr-3">
                <p class="stat-card-label">Average Class Size</p>
                <p class="stat-card-value text-danger">49.65%</p>
                </div>
                <div class="icon-circle-lg icon-circle-cyan ml-4">
                <i class="fa fa-percent text-center text-white"></i>
                </div>
            </div>
            <div>
                <p class="stat-card-change text-success mb-0">
                <i class="fa fa-arrow-up me-1"></i>
                <span class="text-muted">Target: 35 students</span>
                </p>
            </div>
        </div>
    </div>
    <!-- End of the four card columns -->
    </div>
</div>

<div class="card">
    <div class="card-body">
        <header class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
            <h4 class="card-title mb-3">Class Statistics</h4>
            <div class="d-flex gap-3">
                {{-- <button class="btn btn-outline-secondary d-flex align-items-center rounded-5 shadow-sm transition duration-150">
                    <i data-lucide="arrow-down-to-line" class="w-4 h-4 me-2"></i>
                    Export
                </button>
                <button id="addRowBtn" type="button" class="add-row-btn btn text-white fw-semibold py-2 px-4 rounded-pill d-flex align-items-center shadow-lg" style="background: linear-gradient(45deg, #e83e8c, #d12e7e);">
                    <i data-lucide="plus" class="fas fa-plus me-2"></i>
                    Add Class
                </button> --}}
            </div>
        </header>
        <div class="table-responsive">
            <table id="classesTable" class="table table-hover w-100">
                <thead class="bg-light-yellow">
                    <tr>
                        <th class="text-center"></th>
                        <th class="text-center">
                            <input type="checkbox" id="selectAllClasses">
                        </th>
                        <th>Class Name</th>
                        <th>Class Teacher</th>
                        <th>Section</th>
                        <th>Subjects</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
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

@push('scripts')
<script>
$(document).ready(function () {
        const table = $('#classesTable').DataTable({
        ajax: {
            url: '{{ route("tenant.class.class-list") }}',
            dataSrc: function (json) {
                if (json.status !== "success") {
                    showError("Error", "Unable to load classes.");
                    return [];
                }
                return json.data;
            },
            error: function () {
                showError("Error", "Server error while fetching classes.");
            }
        },
        columns: [
            {
                className: "details-control text-center",
                orderable: false,
                data: null,
                defaultContent: `
                    <span class="expand-arrow">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                `
            },
            {
                data: null,
                orderable: false,
                className: "text-center",
                render: data => `<input type="checkbox" class="class-row-checkbox" value="${data.id}">`
            },
            { data: "class_name" },

            {
                data: null,
                className: "text-center",
                render: row => row.teacher ? `${row.teacher.first_name} ${row.teacher.last_name}` : `<span class="text-muted">—</span>`
            },

            { data: "section", className: "text-center" },
            { data: "total_subjects", className: "text-center" },

            {
                data: "status",
                className: "text-center",
                render: status => {
                    let color = status === "active" ? "success" : "secondary";
                    return `<span class="badge bg-${color}">${status}</span>`;
                }
            },
            {
                data: null,
                className: "text-center",
                orderable: false,
                render: data => `
                    <div class="d-flex justify-content-center align-items-center">
                        <!-- View Button with eye animation -->
                        <button type="button" class="btn btn-link p-1 mr-1 border-0 text-info action-view" title="View" data-id="${data.id}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" class="eye-icon">
                                <path fill="currentColor" d="M12 9a3 3 0 0 1 3 3a3 3 0 0 1-3 3a3 3 0 0 1-3-3a3 3 0 0 1 3-3m0-4.5c5 0 9.27 3.11 11 7.5c-1.73 4.39-6 7.5-11 7.5S2.73 16.39 1 12c1.73-4.39 6-7.5 11-7.5M3.18 12a9.821 9.821 0 0 0 17.64 0a9.821 9.821 0 0 0-17.64 0z"/>
                            </svg>
                        </button>
                        
                        <!-- Edit Button with pencil animation -->
                        <button type="button" class="btn btn-link p-1 mr-1 border-0 text-success action-edit" title="Edit" data-id="${data.id}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" class="pencil-icon">
                                <path fill="currentColor" d="M20.71 7.04c.39-.39.39-1.04 0-1.41l-2.34-2.34c-.37-.39-1.02-.39-1.41 0l-1.84 1.83l3.75 3.75M3 17.25V21h3.75L17.81 9.93l-3.75-3.75L3 17.25z"/>
                            </svg>
                        </button>
                        
                        <!-- Delete Button with trash animation -->
                        <button type="button" class="btn btn-link p-1 border-0 text-danger action-delete" title="Delete" data-id="${data.id}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 48 48" class="trash-icon">
                                <polygon fill="#9575cd" points="32,10 28,6 20,6 16,10"></polygon>
                                <path fill="#9575cd" d="M11,10v30c0,2.2,1.8,4,4,4h18c2.2,0,4-1.8,4-4V10H11z"></path>
                                <path fill="#7454b3" d="M24.5,39h-1c-0.8,0-1.5-0.7-1.5-1.5v-19c0-0.8,0.7-1.5,1.5-1.5h1c0.8,0,1.5,0.7,1.5,1.5v19 C26,38.3,25.3,39,24.5,39z"></path>
                                <path fill="#7454b3" d="M31.5,39L31.5,39c-0.8,0-1.5-0.7-1.5-1.5v-19c0-0.8,0.7-1.5,1.5-1.5l0,0c0.8,0,1.5,0.7,1.5,1.5v19 C33,38.3,32.3,39,31.5,39z"></path>
                                <path fill="#7454b3" d="M16.5,39L16.5,39c-0.8,0-1.5-0.7-1.5-1.5v-19c0-0.8,0.7-1.5,1.5-1.5l0,0c0.8,0,1.5,0.7,1.5,1.5v19 C18,38.3,17.3,39,16.5,39z"></path>
                                <path fill="#b39ddb" d="M11,8h26c1.1,0,2,0.9,2,2v2H9v-2C9,8.9,9.9,8,11,8z"></path>
                            </svg>
                        </button>
                    </div>`
            }
        ],
        responsive: true,
        pageLength: 10,
        dom: '<"top"i>rt<"bottom"lp><"clear">',
        order: [[1, 'desc']],
        language: {
            info: "Showing _START_ to _END_ of _TOTAL_ classes",
            paginate: {
                next: '<i class="fas fa-chevron-right"></i>',
                previous: '<i class="fas fa-chevron-left"></i>'
            }
        },
        initComplete: function () {
            $('.dataTables_paginate .pagination').addClass('justify-content-end');
        }
    });
    $('#selectAllClasses').on('click', function () {
        $('.class-row-checkbox').prop('checked', this.checked);
    });
    $('#classesTable tbody').on('change', '.class-row-checkbox', function () {
        $('#selectAllClasses').prop(
            'checked',
            $('.class-row-checkbox:checked').length === $('.class-row-checkbox').length
        );
    });

    $('#classesTable tbody').on('click', 'td.details-control', function () {
        let tr = $(this).closest('tr');
        let row = table.row(tr);
        tr.find(".expand-arrow i").addClass("rotate");
        // If already open → close it
        if (row.child.isShown()) {
            row.child.hide();
            tr.find(".expand-arrow i").removeClass("rotate");
            tr.removeClass('row-expanded');
            return;
        }
        // Otherwise, open it
        tr.addClass('row-expanded');
        let classId = row.data().id;
        showLoader(["Loading subjects..."]);
        $.ajax({
            url: "{{ route('tenant.subject.subject-clalist', ['id' => 'CLASS_ID']) }}"
                .replace('CLASS_ID', classId),
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
            },
            success: function (res) {
                hideLoader();
                if (!res.subjects || res.subjects.length === 0) {
                    row.child(`
                        <div class="sub-table-wrapper subtable-animate">
                            <p class="text-muted mb-0">No subjects assigned to this class.</p>
                        </div>
                    `).show();
                    return;
                }
                let html = buildSubjectSubtable(res.subjects);
                row.child(`
                    <div class="child-connector">
                        <div class="connector-vertical"></div>
                        <div class="connector-content sub-table-wrapper subtable-animate">
                            ${html}
                        </div>
                    </div>
                `).show();
            },
            error: function () {
                hideLoader();
                showError("Error", "Unable to load subjects.");
            }
        });
    });


    // Build sub-table rows
    function buildSubjectSubtable(subjects) {
        if (!subjects.length) {
            return `<p class="text-muted p-2">No subjects found for this class.</p>`;
        }
        let rows = subjects.map(s => {
            let color = s.status === "active" ? "success" : "secondary";
            return `
                <tr>
                    <td>${s.subject_name}</td>
                    <td>${s.subject_code}</td>
                    <td>${s.credit_hours}</td>
                    <td><span class="badge bg-${color}">${s.status}</span></td>
                </tr>
            `;
        }).join("");

        return `
            <table class="table table-bordered sub-table mb-0">
                <thead>
                    <tr>
                        <th>Subject Name</th>
                        <th class="text-center">Subject Code</th>
                        <th class="text-center">Credit Hours</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>${rows}</tbody>
            </table>
        `;
    }

    // Open Add Class Modal
    $('#addRowBtn').on('click', function () {

        $('#modalTitle').text("Add New Class");
        $('#modalBody').html(`
            <form id="addClassForm">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="mb-3">
                    <label class="form-label fw-bold">Class Name</label>
                    <input type="text" name="class_name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Class Code</label>
                    <input type="text" name="class_code" class="form-control">
                </div>  

                <div class="mb-3">
                    <label class="form-label fw-bold">Section</label>
                    <input type="text" name="section" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Class Teacher</label>
                    <select name="class_teacher_id" id="teacherSelect" class="form-control">
                        <option value="">Select Teacher</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Description</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Status</label>
                    <select name="status" class="form-control">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary mt-2 w-100">Save Class</button>
            </form>
        `);
        openSidebar();
    });

    function openSidebar() {
        $('#sideModal').addClass('active');
        $('#sidebarOverlay').addClass('active');
    }
    function closeSidebar() {
        $('#sideModal').removeClass('active');
        $('#sidebarOverlay').removeClass('active');
    }

    $(document).on('submit', '#addClassForm', function(e) {
        e.preventDefault();
        showLoader(["Creating Class..."]);
        let formData = new FormData(this);
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
        $.ajax({
            url: "{{ route('tenant.class.class-store') }}",
            method: "POST",
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            processData: false,
            contentType: false,
            success: function (res) {
                hideLoader();

                if (res.status === "success") {
                    closeSidebar();
                    $('#classesTable').DataTable().ajax.reload();
                    showSuccess("Success", "Class added successfully!");
                }
            },
            error: function (xhr) {
                hideLoader();

                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let firstError = Object.values(errors)[0][0];
                    showError("Validation Error", firstError);
                } else {
                    showError("Error", "Failed to add class.");
                }
            }
        });
    });







});


</script>
@endpush

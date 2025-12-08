@extends('layouts.master')
{{-- @include('studentmanagement::modals.editstudent') --}}

@section('content')

<style>
  /* -----------------------------------------
    STATISTICS CARDS
  ------------------------------------------ */
  .stat-card-custom {
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      background: #fff;
      border-radius: 12px;
      padding: 1.5rem;
      height: 100%;
      box-shadow: 0 6px 18px rgba(0,0,0,0.08);
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

  .icon-circle-red { background-color: #dc3545; }
  .icon-circle-orange { background-color: #fd7e14; }
  .icon-circle-pink { background-color: #d63384; }
  .icon-circle-cyan { background-color: #0dcaf0; }

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
  #studentsTable th,
  #studentsTable td {
      border: 0.5px solid #a4a4a4 !important;
      vertical-align: middle;
      padding: 10px 12px;
  }

  #studentsTable th:first-child,
  #studentsTable td:first-child {
      text-align: center;
  }

  #studentsTable thead th {
      background-color: #f8f9fa;
      font-weight: 600;
      color: #343a40;
  }

  #studentsTable tbody tr:hover > td {
      background-color: #f1f3f5 !important;
  }

  /* Table striping */
  #studentsTable.dataTable tbody tr:nth-child(odd) > td {
      background-color: #ffffff !important;
  }
  #studentsTable.dataTable tbody tr:nth-child(even) > td {
      background-color: #ddf9ff !important;
  }

  .dataTables_info,
  .dataTables_paginate {
      padding: 0.2rem 0;
  }

  /* Make checkbox slightly larger */
  #studentsTable th.text-center input[type="checkbox"] {
      transform: scale(1.1);
  }

  /* Mobile fix */
  @media (max-width: 576px) {
      #studentsTable.dataTable tbody td {
          background-clip: padding-box;
      }
  }
/* Student View Sidebar Modal */
/* .sidebar-modal {
    position: fixed;
    top: 4.625rem;
    right: -900px;
    width: 900px;
    height: calc(100vh - 4.625rem);
    background: white;
    z-index: 1050;
    box-shadow: -5px 0 25px rgba(0, 0, 0, 0.15);
    transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
    display: flex;
    flex-direction: column;
    overflow: hidden;
} */
 /* ==== Sidebar initial state ==== */
.sidebar-modal {
    position: fixed;
    top: 4.625rem;
    right: 0;
    transform: translateX(100%);   /* Hides fully always */
    width: 900px;
    max-width: 1200px;
    min-width: 450px;
    height: calc(100vh - 4.625rem);
    background: white;
    z-index: 1055;
    box-shadow: -6px 0 25px rgba(0,0,0,.18);
    transition: transform .38s cubic-bezier(.25,.8,.25,1), width .15s linear;
    overflow: hidden;
    display: flex;
    flex-direction: column;
}

/* ==== Open State ==== */
.sidebar-modal.active{
    transform: translateX(0);    /* Slide in */
}

/* Overlay remains same */
#sidebarOverlay.active{ display:block; }

/* Overlay */
.sidebar-overlay {
    display: none;
    position: fixed;
    top: 4.625rem;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1040;
    transition: opacity 0.3s ease;
}
/* Resizer handle */
.sidebar-resizer{
    width: 8px;
    cursor: ew-resize;
    background: transparent;
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    display:flex;
    align-items:center;
    justify-content:center;
}

.sidebar-resizer::before{
    content:"";
    width:13px;
    height:40px;
    border-radius:10px;
    background: rgba(0,0,0,.18);
    transition:.25s;
    opacity:.7;
}

/* On hover show active drag indicator */
.sidebar-resizer:hover::before{
    background:#844fc1;         /* highlight */
    width:4px;
}

/* Add grip dots aesthetic */
.sidebar-resizer::after{
    content:"";
    position:absolute;
    width:14px;
    height:22px;
    border-radius:4px;
    background:linear-gradient(
        rgba(0,0,0,.4) 25%,
        transparent 25%,
        transparent 50%,
        rgba(0,0,0,.4) 50%,
        rgba(0,0,0,.4) 75%,
        transparent 75%,
        transparent
    );
    right:2px;
    opacity:.6;
}

/* On grab while dragging */
body.resizing .sidebar-resizer::before{
    background:#4f2aa8;
    opacity:10;
}

.sidebar-modal.active {
    right: 0;
}

/* Sidebar Header */
.sidebar-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem;
    background: #844fc1;
    color: white;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.sidebar-header h4 {
    margin: 0;
    font-weight: 600;
    font-size: 1.25rem;
}

.close-sidebar {
    background: rgba(255, 255, 255, 0.2);
    border: none;
    color: white;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.close-sidebar:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: rotate(90deg);
}

/* Sidebar Content */
.sidebar-content {
    flex: 1;
    overflow-y: auto;
    padding: 0;
}

.sidebar-body {
    padding: 1.5rem;
}

/* Student Profile Section */
.student-profile-header {
    text-align: center;
    padding: 1.5rem 0;
    border-bottom: 1px solid #e9ecef;
    margin-bottom: 1.5rem;
}

.profile-avatar {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #e9ecef;
    margin-bottom: 1rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.student-name {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
    color: #343a40;
}

.student-email {
    color: #6c757d;
    font-size: 0.95rem;
}

/* Details Grid */
.details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-top: 1.5rem;
}

.detail-item {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 8px;
    border-left: 4px solid #667eea;
}

.detail-label {
    font-size: 0.85rem;
    color: #6c757d;
    text-transform: uppercase;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.detail-value {
    font-size: 1rem;
    font-weight: 500;
    color: #343a40;
}

.sidebar-overlay.active {
    display: block;
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .sidebar-modal {
        width: 90%;
        right: -90%;
    }
}

@media (max-width: 576px) {
    .sidebar-modal {
        width: 100%;
        right: -100%;
    }
    
    .details-grid {
        grid-template-columns: 1fr;
    }
}
</style>

  <div class="card">
    <div class="card-body">
      <h4 class="card-title mb-3">Students Statistics</h4>
        <!-- Start of the four card columns -->
        <div class="icons-list">
          <!-- CARD 1 -->
          <div class="stat-card-custom" style="border: 1px solid #a4a4a4">
            <div class="stat-card-header">
              <div class="mr-3">
                <p class="stat-card-label">TRAFFIC</p>
                <p class="stat-card-value text-primary">350,897</p>
              </div>
              <div class="icon-circle-lg icon-circle-red ml-4">
                <i class="fa fa-area-chart text-center text-white"></i>
              </div>
            </div>
            <div class="stat-card-footer">
              <p class="stat-card-change text-success mb-0">
                <i class="fa fa-arrow-up me-1"></i>
                3.48% <span class="text-muted">Since last month</span>
              </p>
            </div>
        </div>
          <!-- CARD 2 -->
        <div class="stat-card-custom d-flex flex-column justify-content-between" style="border: 1px solid #a4a4a4">
          <div class="d-flex justify-content-between align-items-start mb-3">
            <div class="mr-3">
              <p class="stat-card-label">NEW USERS</p>
              <p class="stat-card-value text-success">2,356</p>
            </div>
            <div class="icon-circle-lg icon-circle-orange ml-4">
              <i class="fa fa-pie-chart text-center text-white"></i>
            </div>
          </div>
          <div>
            <p class="stat-card-change text-danger mb-0">
              <i class="fa fa-arrow-down me-1"></i>
              3.48% <span class="text-muted">Since last week</span>
            </p>
          </div>
        </div>

        <!-- CARD 3 -->
        <div class="stat-card-custom d-flex flex-column justify-content-between" style="border: 1px solid #a4a4a4">
          <div class="d-flex justify-content-between align-items-start mb-3">
            <div class="mr-3">
              <p class="stat-card-label">SALES</p>
              <p class="stat-card-value text-info">924</p>
            </div>
            <div class="icon-circle-lg icon-circle-pink ml-4">
              <i class="fa fa-users text-center text-white"></i>
            </div>
          </div>
          <div>
            <p class="stat-card-change text-danger mb-0">
              <i class="fa fa-arrow-down me-1"></i>
              1.10% <span class="text-muted">Since yesterday</span>
            </p>
          </div>
        </div>

        <!-- CARD 4 -->
        <div class="stat-card-custom d-flex flex-column justify-content-between" style="border: 1px solid #a4a4a4">
          <div class="d-flex justify-content-between align-items-start mb-3">
            <div class="mr-3">
              <p class="stat-card-label">PERFORMANCE</p>
              <p class="stat-card-value text-danger">49.65%</p>
            </div>
            <div class="icon-circle-lg icon-circle-cyan ml-4">
              <i class="fa fa-percent text-center text-white"></i>
            </div>
          </div>
          <div>
            <p class="stat-card-change text-success mb-0">
              <i class="fa fa-arrow-up me-1"></i>
              1.2% <span class="text-muted">Since last month</span>
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
            <h4 class="card-title mb-3">Student Lists</h4>
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
        <table id="studentsTable" class="table table-hover w-100">
            <thead class="bg-light-yellow"> <tr>
                <th class="text-center">
                    <input type="checkbox" id="selectAllStudents">
                </th>
                <th>ID</th> 
                <th>First Name</th>
                <th>Last Name</th>
                <th>Profile Picture</th>
                <th>Email</th>
                <th>Class</th>
                <th>Created At</th>
                <th>Action</th> </tr>
            </thead>
            <tbody></tbody>
        </table>
      </div>
    </div>
  </div>

    <!-- ======================= Student View Sidebar ======================= -->
    <div id="studentViewSidebar" class="sidebar-modal">
      <div class="sidebar-resizer"></div>
        <div class="sidebar-content">
          <div class="sidebar-header">
            <h4>Student Details</h4>
            <button class="close-sidebar" onclick="closeSidebar()">✕</button>
          </div>
          
          <div id="viewStudentBody" class="sidebar-body">
            <!-- Profile Header -->
            <div class="student-profile-header">
              <img id="viewStudentImage" src="/storage/defaultimage/default-avatar.png" 
                class="profile-avatar" alt="Student Avatar">
              <h5 id="viewStudentFull" class="student-name"></h5>
              <p id="viewStudentEmail" class="student-email"></p>
            </div>
            
            <!-- Details Grid -->
            <div class="details-grid" id="studentDetailsData">
              <!-- Dynamic content will be inserted here -->
            </div>
          </div>
        </div>
    </div>

    <!-- Overlay -->
    <div id="sidebarOverlay" class="sidebar-overlay" onclick="closeSidebar()"></div>
    <!-- =================================================================== -->


@push('scripts')
<script>
$(document).ready(function() {
    const table = $('#studentsTable').DataTable({
        ajax: {
            url: '{{ route("tenant.student.list") }}',
            dataSrc: 'data'
        },
        columns: [
            {
                data: null,
                orderable: false,
                className: 'text-center',
                render: data => `<input type="checkbox" class="row-checkbox" value="${data.id}">`
            },
            { data: 'id', width: '5%', className: 'text-center' },
            { data: 'first_name' },
            { data: 'last_name' },
            {
                data: 'profile_picture',
                render: function(data) {
                    if (!data) {
                        return `<img src="/storage/defaultimage/default-avatar.png" class="rounded-circle" width="40" height="40">`;
                    }

                    return `<img src="/storage/${data}" class="rounded-circle" width="70" height="70">`;
                },
                orderable: false,
                className: 'text-center',
                width: '8%'
            },

            { data: 'email' },
            { 
                data: 'grade',
                render: data => data ? `<span class="badge bg-primary">${data}</span>` : '',
                width: '8%',
                className: 'text-center'
            },
            { 
                data: 'created_at',
                render: data => data ? new Date(data).toLocaleDateString('en-US', {
                    year: 'numeric', month: 'short', day: 'numeric'
                }) : '',
                width: '10%' 
            },
            {
                data: null,
                orderable: false,
                className: 'text-center',
                render: data => `
                <div class="d-flex justify-content-center">
                  <button type="button" class="btn btn-info btn-sm btn-icon-text mr-3" data-id="${data.id}">
                    View
                    <i class="typcn typcn-eye-outline btn-icon-append"></i>
                  </button>
                  <button type="button" class="btn btn-success btn-sm btn-icon-text mr-3" data-id="${data.id}">
                    Edit
                    <i class="typcn typcn-edit btn-icon-append"></i>
                  </button>
                  <button type="button" class="btn btn-danger btn-sm btn-icon-text" data-id="${data.id}">
                    Delete
                    <i class="typcn typcn-delete-outline btn-icon-append"></i>
                  </button>
                </div>`
            }
        ],

        responsive: true,
        pageLength: 10,
        dom: '<"top"i>rt<"bottom"lp><"clear">',
        language: {
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            paginate: {
                next: '<i class="fas fa-chevron-right"></i>',
                previous: '<i class="fas fa-chevron-left"></i>'
            }
        },
        order: [[1, 'desc']],

        initComplete: function () {
            $('.dataTables_paginate .pagination').addClass('justify-content-end');
            $('.dataTables_paginate .page-item:not(.active) .page-link').css({
                'border-radius': '0.25rem',
                'margin-left': '0.25rem',
                'border': '1px solid #dee2e6'
            });
            $('.dataTables_paginate .page-item.active .page-link').css({
                'border-radius': '0.25rem',
                'margin-left': '0.25rem',
                'background-color': '#e83e8c',
                'border-color': '#e83e8c'
            });
        }
    });

    // Custom search
    $('#customSearchInput').on('keyup', function() {
        table.search(this.value).draw();
    });

    // Select all checkbox
    $('#selectAllStudents').on('click', function() {
        $('.row-checkbox').prop('checked', this.checked);
    });

    $('#studentsTable tbody').on('change', '.row-checkbox', function() {
        $('#selectAllStudents').prop('checked',
            $('.row-checkbox:checked').length === $('.row-checkbox').length
        );
    });

    // Button click
    $('#studentsTable tbody').on('click', '.save-player-btn', function() {
        const studentId = $(this).data('id');
        // alert('Saving student with ID: ' + studentId);
    });


    // Sidebar functions
    // Update your JavaScript functions to match the new structure

    // Sidebar functions
    function openSidebar() {
        $('#studentViewSidebar').addClass('active');
        $('#sidebarOverlay').addClass('active');
        $('body').css('overflow', 'hidden'); // Prevent scrolling when sidebar is open
    }

    function closeSidebar() {
        $('#studentViewSidebar').removeClass('active');
        $('#sidebarOverlay').removeClass('active');
        $('body').css('overflow','auto');
    }


    // Handle View click inside datatable
    $('#studentsTable').on('click', '.btn-info', function(){
        let id = $(this).data('id');
        
        showLoader(["Fetching student details..."]);
        
        $.ajax({
            url: "{{ url('tenant/student/student-view') }}/" + id,
            method: "GET",
            success: function(res) {
                hideLoader();
                
                // Update header
                $('#viewStudentFull').text(`${res.first_name} ${res.last_name}`);
                $('#viewStudentEmail').text(res.email || "No email provided");
                
                // Update profile image
                const profileImage = res.profile_picture 
                    ? "/storage/" + res.profile_picture 
                    : "/storage/defaultimage/default-avatar.png";
                $('#viewStudentImage').attr("src", profileImage);
                
                // Create modern details grid
                const detailsHTML = `
                    <div class="detail-item">
                        <div class="detail-label">Class</div>
                        <div class="detail-value">${res.grade || '-'} ${res.section ? `- ${res.section}` : ''}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Phone</div>
                        <div class="detail-value">${res.phone_number || '-'}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Date of Birth</div>
                        <div class="detail-value">${res.dob || '-'}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Gender</div>
                        <div class="detail-value">${res.gender || '-'}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Blood Group</div>
                        <div class="detail-value">${res.blood_group || '-'}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Nationality</div>
                        <div class="detail-value">${res.nationality || '-'}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Religion</div>
                        <div class="detail-value">${res.religion || '-'}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Guardian Name</div>
                        <div class="detail-value">${res.guardian_name || '-'}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Guardian Phone</div>
                        <div class="detail-value">${res.guardian_phone || '-'}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Address</div>
                        <div class="detail-value">
                            ${[res.address, res.city, res.state, res.country].filter(Boolean).join(', ') || '-'}
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Medical Conditions</div>
                        <div class="detail-value">${res.medical_conditions || 'None reported'}</div>
                    </div>
                `;
                
                $('#studentDetailsData').html(detailsHTML);
                
                openSidebar();
            },
            error: function() {
                hideLoader();
                showError("Error", "Unable to fetch student details");
            }
        });
    });

    // Close sidebar on ESC key
    $(document).keydown(function(e) {
        if (e.key === "Escape") {
            closeSidebar();
        }
    });

    // Close sidebar when clicking the X button
    $(document).on('click', '.close-sidebar', function(e) {
        e.stopPropagation();
        closeSidebar();
    });

    // Close sidebar when clicking on overlay
    $(document).on('click', '#sidebarOverlay', function(e) {
        if (e.target === this) {
            closeSidebar();
        }
    });

    // Close sidebar on ESC key
    $(document).keydown(function(e) {
        if (e.key === "Escape" && $('#studentViewSidebar').hasClass('active')) {
            closeSidebar();
        }
    });

    // Prevent sidebar from closing when clicking inside it
    $(document).on('click', '#studentViewSidebar', function(e) {
        e.stopPropagation();
    });

    // Handle Edit button click
    $('#studentsTable').on('click', '.btn-success', function(){
        let id = $(this).data('id');
        loadStudentForEdit(id);
    });

    // Handle Delete button click
    $('#studentsTable').on('click', '.btn-danger', function(){
        let id = $(this).data('id');
        alert('Deleting student with ID: ' + id);
    });

    // Resize Feature
    const sidebar = document.getElementById("studentViewSidebar");
    const resizer = document.querySelector(".sidebar-resizer");

    let isResizing = false;

    resizer.addEventListener("mousedown", function(e){
        isResizing = true;
        document.body.style.userSelect = "none";
    });

    document.addEventListener("mousemove", function(e){
        if(!isResizing) return;

        let newWidth = window.innerWidth - e.clientX;
        if(newWidth < 450) newWidth = 450;
        if(newWidth > 1200) newWidth = 1200;

        sidebar.style.width = newWidth + "px";
    });

    document.addEventListener("mouseup", function(){
        isResizing = false;
        document.body.style.userSelect = "auto";
    });

    resizer.addEventListener("mousedown", function(){
        isResizing = true;
        document.body.classList.add("resizing");
    });

    document.addEventListener("mouseup", function(){
        isResizing = false;
        document.body.classList.remove("resizing");
    });



    // Edit Students


    function loadStudentForEdit(id){
      showLoader(["Loading student for editing..."]);

      $.ajax({
          url: "{{ url('tenant/student/student-view') }}/" + id,
          type:"GET",
          success:function(res){
              hideLoader();
              openSidebar();

              $('#viewStudentFull').html(`
                  <input id="edit_first_name" value="${res.first_name}" class="form-control mb-2">
                  <input id="edit_last_name" value="${res.last_name}" class="form-control">
              `);

              $('#viewStudentEmail').html(`
                  <input id="edit_email" value="${res.email}" class="form-control">
              `);

              $('#viewStudentImage').attr("src",
                  res.profile_picture?"/storage/"+res.profile_picture:"/storage/defaultimage/default-avatar.png"
              );

              $('#studentDetailsData').html(`
                  ${editableField("Class", "edit_grade", res.grade)}
                  ${editableField("Section", "edit_section", res.section)}
                  ${editableField("Phone", "edit_phone", res.phone_number)}
                  ${editableField("Date of Birth", "edit_dob", res.dob, "date")}
                  ${editableField("Gender", "edit_gender", res.gender)}
                  ${editableField("Blood Group", "edit_blood_group", res.blood_group)}
                  ${editableField("Nationality", "edit_nationality", res.nationality)}
                  ${editableField("Religion", "edit_religion", res.religion)}
                  ${editableField("Guardian Name", "edit_guardian_name", res.guardian_name)}
                  ${editableField("Guardian Phone", "edit_guardian_phone", res.guardian_phone)}
                  ${editableField("Address", "edit_address", res.address)}
                  ${editableField("City", "edit_city", res.city)}
                  ${editableField("State", "edit_state", res.state)}
                  ${editableField("Country", "edit_country", res.country)}
                  ${editableField("Medical Conditions", "edit_medical_conditions", res.medical_conditions)}
              `);

              // Add Update button
              $('#studentDetailsData').append(`
                  <div class="mt-4 text-right">
                      <button class="btn btn-primary" onclick="updateStudent(${id})">Save Changes</button>
                  </div>
              `);
          }
      });
  }

  // Helper Function — generates input row
  function editableField(label,id,value,type="text"){
        return `
        <div class="detail-item">
            <label class="detail-label">${label}</label>
            <input type="${type}" id="${id}" value="${value??''}" class="form-control detail-value">
        </div>`;
    }

    function updateStudent(id){
      let formData = {
          first_name: $('#edit_first_name').val(),
          last_name: $('#edit_last_name').val(),
          email: $('#edit_email').val(),
          grade: $('#edit_grade').val(),
          section: $('#edit_section').val(),
          phone_number: $('#edit_phone').val(),
          dob: $('#edit_dob').val(),
          gender: $('#edit_gender').val(),
          blood_group: $('#edit_blood_group').val(),
          nationality: $('#edit_nationality').val(),
          religion: $('#edit_religion').val(),
          guardian_name: $('#edit_guardian_name').val(),
          guardian_phone: $('#edit_guardian_phone').val(),
          address: $('#edit_address').val(),
          city: $('#edit_city').val(),
          state: $('#edit_state').val(),
          country: $('#edit_country').val(),
          medical_conditions: $('#edit_medical_conditions').val(),
          _token: "{{ csrf_token() }}"
      };

      $.ajax({
          url:`{{ url('tenant/student/update') }}/${id}`,
          type:"POST",
          data: formData,
          success:function(res){
              showSuccess("Updated Successfully");
              closeSidebar();
              $('#studentsTable').DataTable().ajax.reload();
          }
      });
  }







});


</script>
@endpush



@endsection
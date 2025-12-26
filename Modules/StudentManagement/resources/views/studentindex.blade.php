@extends('layouts.master')
{{-- @include('studentmanagement::modals.editstudent') --}}

@section('content')

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
        <header class="d-flex mb-2 flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
            <h4 class="card-title mb-3">Student Lists</h4>
            <div class="d-flex gap-3">
                <select id="addClassSelect" class="form-select rounded-pill d-flex align-items-center">
                    <option value="" disabled selected>Select Class</option>
                    <option value="addClass">Add Class</option>
                    <option value="anotherOption">Another Option</option>
                    <option value="moreOptions">More Options</option>
                </select>
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
                console.log(data);
                
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
        dom: `<"row mb-1 align-items-center"<"col-md-6 text-start"i><"col-md-6 text-end"f>>rt<"row mt-1 align-items-center"<"col-md-6 text-start"l><"col-md-6 text-end"p>>`,
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
    $('#studentsTable').on('click', '.action-view', function(){
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
    $('#studentsTable').on('click', '.action-edit', function(){
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
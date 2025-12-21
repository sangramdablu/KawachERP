@extends('layouts.master')
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
        {{-- <header class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
            <h4 class="card-title mb-3">Students Statistics</h4>
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
        <header class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
            <h4 class="card-title mb-3">Students Statistics</h4>
            <div class="d-flex gap-3">
                <button class="btn btn-outline-secondary d-flex align-items-center rounded-5 shadow-sm transition duration-150">
                    <i data-lucide="arrow-down-to-line" class="w-4 h-4 me-2"></i>
                    Export
                </button>
                <select id="addClassSelect" class="form-select fw-semibold rounded-pill d-flex align-items-center shadow-lg" style="background: linear-gradient(45deg, #e83e8c, #d12e7e); border: none;">
                    <option value="" disabled selected>Select Class</option>
                    <option value="addClass">Add Class</option>
                    <option value="anotherOption">Another Option</option>
                    <option value="moreOptions">More Options</option>
                </select>
            </div>
        </header>

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


    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-xl-11 col-lg-12">
                
                <!-- CONTROL PANEL: Date and Class Selection -->
                <div class="card shadow-lg mb-4 rounded-4">
                    <div class="card-body p-4">
                        <div class="row g-3 align-items-center">
                            <div class="col-md-4">
                                <label for="attendanceDate" class="form-label fw-semibold mb-1">Select Attendance Date</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i data-lucide="calendar" class="w-4 h-4"></i></span>
                                    <input type="date" class="form-control rounded-end-3" id="attendanceDate">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="classSelector" class="form-label fw-semibold mb-1">Select Class Section</label>
                                <select class="form-select rounded-3" id="classSelector">
                                    <option value="10A">Grade 10 - A (42 Students)</option>
                                    <option value="5B" selected>Grade 5 - B (38 Students)</option>
                                    <option value="1C">Grade 1 - C (30 Students)</option>
                                    <option value="8A">Grade 8 - A (45 Students)</option>
                                </select>
                            </div>
                            <div class="col-md-4 text-md-end pt-3 pt-md-0">
                                <button class="btn btn-outline-secondary rounded-3 d-inline-flex align-items-center">
                                    <i data-lucide="users" class="w-4 h-4 me-2"></i>
                                    Load Class Roster
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SUMMARY METRICS -->
                <div class="row g-4 mb-5">
                    
                    <!-- Total Students -->
                    <div class="col-md-4">
                        <div class="metric-card d-flex justify-content-between align-items-center">
                            <div>
                                <div class="metric-label">Total Students</div>
                                <div id="totalStudents" class="metric-value text-dark">38</div>
                            </div>
                            <i data-lucide="user-square" class="w-8 h-8 text-secondary opacity-75"></i>
                        </div>
                    </div>

                    <!-- Present Count -->
                    <div class="col-md-4">
                        <div class="metric-card d-flex justify-content-between align-items-center" style="border-left: 5px solid var(--bs-present-green);">
                            <div>
                                <div class="metric-label">Students Present</div>
                                <div id="presentCount" class="metric-value" style="color: var(--bs-present-green);">38</div>
                            </div>
                            <i data-lucide="check-circle" class="w-8 h-8" style="color: var(--bs-present-green);"></i>
                        </div>
                    </div>

                    <!-- Absent Count -->
                    <div class="col-md-4">
                        <div class="metric-card d-flex justify-content-between align-items-center" style="border-left: 5px solid var(--bs-absent-red);">
                            <div>
                                <div class="metric-label">Students Absent</div>
                                <div id="absentCount" class="metric-value" style="color: var(--bs-absent-red);">0</div>
                            </div>
                            <i data-lucide="x-circle" class="w-8 h-8" style="color: var(--bs-absent-red);"></i>
                        </div>
                    </div>
                </div>

                <!-- ATTENDANCE TABLE -->
                <div class="card shadow-lg rounded-4 p-0">
                    <div class="card-header bg-white p-4 border-bottom rounded-top-4">
                        <h3 class="fs-5 fw-bold mb-0">Roster for Grade 5 - B</h3>
                        <p class="text-muted mb-0 text-sm">Click the buttons to toggle student status (Present / Absent).</p>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="fw-medium text-uppercase text-secondary" style="width: 5%;">#</th>
                                    <th class="fw-medium text-uppercase text-secondary" style="width: 30%;">Student Name</th>
                                    <th class="fw-medium text-uppercase text-secondary" style="width: 15%;">ID</th>
                                    <th class="fw-medium text-uppercase text-secondary" style="width: 30%; text-align: center;">Attendance Status</th>
                                    <th class="fw-medium text-uppercase text-secondary" style="width: 20%;">Notes</th>
                                </tr>
                            </thead>
                            <tbody id="studentRoster">
                                <!-- Student rows will be generated here by JS -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- SAVE BUTTON -->
                <div class="text-center mt-5 mb-5">
                    <button id="saveAttendanceBtn" class="btn btn-save-gradient btn-lg rounded-pill d-inline-flex align-items-center">
                        <i data-lucide="save" class="w-6 h-6 me-2"></i>
                        Save Daily Attendance
                    </button>
                    <p id="saveStatus" class="mt-3 text-muted fw-semibold"></p>
                </div>

            </div>
        </div>
    </div>
    
    <!-- Script to load Lucide icons library -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- Custom JavaScript for Interactivity -->
    <script>
        // Data structure for initial roster (simulated fetch)
        const initialRoster = [
            { id: 'S1001', name: 'Alice Johnson', status: 'Present' },
            { id: 'S1002', name: 'Bob Williams', status: 'Present' },
            { id: 'S1003', name: 'Charlie Brown', status: 'Present' },
            { id: 'S1004', name: 'Diana Prince', status: 'Present' },
            { id: 'S1005', name: 'Ethan Hunt', status: 'Present' },
            { id: 'S1006', name: 'Fiona Glenanne', status: 'Present' },
            { id: 'S1007', name: 'George Clooney', status: 'Absent' },
            { id: 'S1008', name: 'Hannah Montana', status: 'Present' },
            // Add more students for a fuller list (38 total in theory)
            { id: 'S1009', name: 'Ivan Drago', status: 'Present' },
            { id: 'S1010', name: 'Jasmine Chen', status: 'Present' },
            { id: 'S1011', name: 'Kyle Reese', status: 'Present' },
            { id: 'S1012', name: 'Laura Palmer', status: 'Present' },
            { id: 'S1013', name: 'Mike Ross', status: 'Present' },
            { id: 'S1014', name: 'Nancy Drew', status: 'Present' },
            { id: 'S1015', name: 'Oscar Wilde', status: 'Present' },
        ];

        // Global elements
        const rosterBody = document.getElementById('studentRoster');
        const presentCountEl = document.getElementById('presentCount');
        const absentCountEl = document.getElementById('absentCount');
        const totalStudentsEl = document.getElementById('totalStudents');
        const attendanceDateInput = document.getElementById('attendanceDate');
        const saveStatusEl = document.getElementById('saveStatus');
        const saveBtn = document.getElementById('saveAttendanceBtn');

        // --- Core Functions ---

        // Sets today's date on the input field
        function setTodayDate() {
            const today = new Date();
            const yyyy = today.getFullYear();
            const mm = String(today.getMonth() + 1).padStart(2, '0'); // Months are 0-based
            const dd = String(today.getDate()).padStart(2, '0');
            attendanceDateInput.value = `${yyyy}-${mm}-${dd}`;
        }

        // Toggles the attendance status for a student row
        function toggleAttendance(e) {
            const target = e.target.closest('.attendance-btn');
            if (!target) return;

            const row = target.closest('tr');
            const studentId = row.dataset.studentId;
            const status = target.dataset.status;

            // Find all buttons in the row
            const presentBtn = row.querySelector('.btn-present');
            const absentBtn = row.querySelector('.btn-absent');

            let newStatus;

            if (status === 'Present') {
                presentBtn.classList.add('active');
                absentBtn.classList.remove('active');
                newStatus = 'Present';
            } else if (status === 'Absent') {
                presentBtn.classList.remove('active');
                absentBtn.classList.add('active');
                newStatus = 'Absent';
            }

            // Update the data attribute on the row
            row.dataset.attendanceStatus = newStatus;
            
            updateSummaryCounts();
        }

        // Renders the student roster table
        function renderRoster(roster) {
            rosterBody.innerHTML = ''; // Clear existing rows
            roster.forEach((student, index) => {
                const isPresent = student.status === 'Present';
                const row = document.createElement('tr');
                row.dataset.studentId = student.id;
                row.dataset.attendanceStatus = student.status;
                row.innerHTML = `
                    <td class="fw-semibold">${index + 1}</td>
                    <td>${student.name}</td>
                    <td class="text-muted">${student.id}</td>
                    <td class="text-center">
                        <button class="attendance-btn btn-present ${isPresent ? 'active' : ''}" data-status="Present">
                            P
                        </button>
                        <button class="attendance-btn btn-absent ${!isPresent ? 'active' : ''} ms-2" data-status="Absent">
                            A
                        </button>
                    </td>
                    <td><input type="text" class="form-control form-control-sm" placeholder="${!isPresent ? 'Reason for absence...' : 'Optional notes'}"></td>
                `;
                rosterBody.appendChild(row);
            });
            // Re-create icons after rendering new HTML
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
            rosterBody.addEventListener('click', toggleAttendance);
            updateSummaryCounts(roster.length);
        }

        // Updates the Present/Absent count metrics
        function updateSummaryCounts(totalOverride) {
            const rows = rosterBody.querySelectorAll('tr');
            let present = 0;
            let absent = 0;

            rows.forEach(row => {
                if (row.dataset.attendanceStatus === 'Present') {
                    present++;
                } else {
                    absent++;
                }
            });

            presentCountEl.textContent = present;
            absentCountEl.textContent = absent;
            
            if (totalOverride) {
                totalStudentsEl.textContent = totalOverride;
            } else {
                totalStudentsEl.textContent = rows.length;
            }
        }

        // Simulates saving the attendance data
        function saveAttendance() {
            saveStatusEl.textContent = 'Saving attendance...';
            saveBtn.disabled = true;

            const date = attendanceDateInput.value;
            const classId = document.getElementById('classSelector').value;
            const students = [];
            
            rosterBody.querySelectorAll('tr').forEach(row => {
                students.push({
                    id: row.dataset.studentId,
                    status: row.dataset.attendanceStatus,
                    notes: row.querySelector('input[type="text"]').value
                });
            });

            // Simulate API latency
            setTimeout(() => {
                saveStatusEl.innerHTML = `<span class="text-success fw-bold"><i data-lucide="bell" class="w-4 h-4 me-1"></i> Attendance for ${classId} on ${date} saved successfully!</span>`;
                saveBtn.disabled = false;
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            }, 1500);
        }

        // --- Event Listeners and Initialization ---

        document.addEventListener('DOMContentLoaded', () => {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
            
            setTodayDate();
            renderRoster(initialRoster);
            
            saveBtn.addEventListener('click', saveAttendance);
        });

    </script>

@endsection
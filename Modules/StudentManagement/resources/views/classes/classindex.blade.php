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
        <header class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
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

        <div class="table-responsive">
            <table id="teachersTable" class="table table-hover w-100">
                <thead class="bg-light-yellow">
                    <tr>
                        <th class="text-center">
                            <input type="checkbox" id="selectAllTeachers">
                        </th>
                        <th>ID</th> 
                        <th>Class Name</th>
                        <th>Class Teacher</th>
                        <th>Students</th>
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

    <div class="card">
        <div class="card-body">
            
            <div class="container-fluid p-0">
                
                <!-- HEADER AND QUICK ACTIONS -->
                <header class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
                    <h1 class="fs-3 fw-bolder text-dark mb-3 mb-md-0">
                        Classes Management Dashboard
                    </h1>
                    <div class="d-flex gap-3">
                        <button class="btn btn-outline-secondary d-flex align-items-center rounded-3 shadow-sm transition duration-150">
                            <i data-lucide="arrow-down-to-line" class="w-4 h-4 me-2"></i>
                            Export Data
                        </button>
                        <button class="btn btn-primary d-flex align-items-center rounded-3 shadow-sm transition duration-150">
                            <i data-lucide="plus" class="w-4 h-4 me-2"></i>
                            Add New Class
                        </button>
                    </div>
                </header>

                <!-- METRIC CARDS -->
                <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4 mb-4">
                    
                    <!-- Card 1: Total Classes -->
                    <div class="col">
                        <div class="dashboard-card border-start-4 border-primary">
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="metric-label">Total Classes</span>
                                <i data-lucide="school" class="w-6 h-6 text-primary"></i>
                            </div>
                            <p class="metric-value text-primary">12</p>
                            <p class="text-xs text-success mt-1">+2 new this year</p>
                        </div>
                    </div>

                    <!-- Card 2: Total Students -->
                    <div class="col">
                        <div class="dashboard-card border-start-4 border-success">
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="metric-label">Total Students</span>
                                <i data-lucide="users" class="w-6 h-6 text-success"></i>
                            </div>
                            <p class="metric-value text-success">485</p>
                            <p class="text-xs text-success mt-1">+15% vs last year</p>
                        </div>
                    </div>

                    <!-- Card 3: Class Teachers Allocated -->
                    <div class="col">
                        <div class="dashboard-card border-start-4 border-warning">
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="metric-label">Teachers Allocated</span>
                                <i data-lucide="graduation-cap" class="w-6 h-6 text-warning"></i>
                            </div>
                            <p class="metric-value text-warning">11 / 12</p>
                            <p class="text-xs text-danger mt-1">1 class unassigned</p>
                        </div>
                    </div>

                    <!-- Card 4: Average Class Size -->
                    <div class="col">
                        <div class="dashboard-card border-start-4 border-info">
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="metric-label">Average Class Size</span>
                                <i data-lucide="bar-chart" class="w-6 h-6 text-info"></i>
                            </div>
                            <p class="metric-value text-info">40.4</p>
                            <p class="text-xs text-secondary mt-1">Target: 35 students</p>
                        </div>
                    </div>
                </div>
                
                <!-- MAIN CONTENT AREA: Chart and Class List -->
                <div class="row g-4">

                    <!-- COLUMN 1 & 2: Class List -->
                    <div class="col-lg-8">
                        <div class="dashboard-card p-0">
                            <div class="p-4 border-bottom d-flex justify-content-between align-items-center">
                                <h2 class="fs-5 fw-semibold text-dark mb-0">List of Active Classes (12)</h2>
                                <input type="text" placeholder="Search classes or teachers..." class="form-control form-control-sm w-auto">
                            </div>
                            
                            <div class="table-responsive custom-scroll">
                                <table class="table table-hover table-sm align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="px-4 py-3 text-start text-xs text-secondary text-uppercase fw-medium">Class Name</th>
                                            <th class="px-4 py-3 text-start text-xs text-secondary text-uppercase fw-medium">Class Teacher</th>
                                            <th class="px-4 py-3 text-start text-xs text-secondary text-uppercase fw-medium">Students</th>
                                            <th class="px-4 py-3 text-start text-xs text-secondary text-uppercase fw-medium">Subjects</th>
                                            <th class="px-4 py-3 text-center text-xs text-secondary text-uppercase fw-medium">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Class Item 1 -->
                                        <tr class="transition duration-100">
                                            <td class="px-4 py-3 text-sm fw-semibold text-primary">Grade 10 - A</td>
                                            <td class="px-4 py-3 text-sm text-secondary">Mrs. Jane Doe</td>
                                            <td class="px-4 py-3 text-sm text-secondary">42</td>
                                            <td class="px-4 py-3 text-sm text-secondary">8</td>
                                            <td class="px-4 py-3 text-center text-sm fw-medium">
                                                <button onclick="console.log('Edit Grade 10-A')" class="btn btn-sm btn-outline-primary p-1 rounded-circle border-0 me-1"><i data-lucide="edit-3" class="w-4 h-4"></i></button>
                                                <button onclick="console.log('Delete Grade 10-A')" class="btn btn-sm btn-outline-danger p-1 rounded-circle border-0"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                                            </td>
                                        </tr>
                                        <!-- Class Item 2 -->
                                        <tr class="transition duration-100">
                                            <td class="px-4 py-3 text-sm fw-semibold text-primary">Grade 5 - B</td>
                                            <td class="px-4 py-3 text-sm text-secondary">Mr. John Smith</td>
                                            <td class="px-4 py-3 text-sm text-secondary">38</td>
                                            <td class="px-4 py-3 text-sm text-secondary">6</td>
                                            <td class="px-4 py-3 text-center text-sm fw-medium">
                                                <button onclick="console.log('Edit Grade 5-B')" class="btn btn-sm btn-outline-primary p-1 rounded-circle border-0 me-1"><i data-lucide="edit-3" class="w-4 h-4"></i></button>
                                                <button onclick="console.log('Delete Grade 5-B')" class="btn btn-sm btn-outline-danger p-1 rounded-circle border-0"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                                            </td>
                                        </tr>
                                        <!-- Class Item 3 (Unassigned) -->
                                        <tr class="table-danger bg-opacity-10 transition duration-100">
                                            <td class="px-4 py-3 text-sm fw-semibold text-primary">Grade 1 - C</td>
                                            <td class="px-4 py-3 text-sm text-danger fw-bold">Unassigned</td>
                                            <td class="px-4 py-3 text-sm text-secondary">30</td>
                                            <td class="px-4 py-3 text-sm text-secondary">5</td>
                                            <td class="px-4 py-3 text-center text-sm fw-medium">
                                                <button onclick="console.log('Assign Grade 1-C')" class="btn btn-sm btn-outline-success p-1 rounded-circle border-0 me-1"><i data-lucide="link" class="w-4 h-4"></i></button>
                                                <button onclick="console.log('Delete Grade 1-C')" class="btn btn-sm btn-outline-danger p-1 rounded-circle border-0"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                                            </td>
                                        </tr>
                                        <!-- More items... -->
                                        <tr class="transition duration-100">
                                            <td class="px-4 py-3 text-sm fw-semibold text-primary">Grade 8 - A</td>
                                            <td class="px-4 py-3 text-sm text-secondary">Dr. Alice Chen</td>
                                            <td class="px-4 py-3 text-sm text-secondary">45</td>
                                            <td class="px-4 py-3 text-sm text-secondary">7</td>
                                            <td class="px-4 py-3 text-center text-sm fw-medium">
                                                <button onclick="console.log('Edit Grade 8-A')" class="btn btn-sm btn-outline-primary p-1 rounded-circle border-0 me-1"><i data-lucide="edit-3" class="w-4 h-4"></i></button>
                                                <button onclick="console.log('Delete Grade 8-A')" class="btn btn-sm btn-outline-danger p-1 rounded-circle border-0"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="p-3 border-top text-sm text-secondary d-flex justify-content-between align-items-center">
                                <span>Showing 1 to 4 of 12 classes</span>
                                <div class="d-flex gap-1">
                                    <button class="btn btn-sm btn-outline-secondary">Prev</button>
                                    <button class="btn btn-sm btn-primary">1</button>
                                    <button class="btn btn-sm btn-outline-secondary">2</button>
                                    <button class="btn btn-sm btn-outline-secondary">3</button>
                                    <button class="btn btn-sm btn-outline-secondary">Next</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- COLUMN 3: Student Distribution Chart -->
                    <div class="col-lg-4">
                        <div class="dashboard-card">
                            <h2 class="fs-5 fw-semibold text-dark mb-4">Student Distribution by Grade</h2>
                            
                            <!-- Simulated Chart Area -->
                            <div class="h-64 d-flex flex-column justify-content-end p-2 bg-light rounded-3 border border-secondary border-opacity-25">
                                <p class="text-xs text-secondary mb-2 opacity-75">Total Students: 485</p>
                                <div class="d-flex justify-content-around align-items-end h-100">
                                    <!-- Bar 1 (Height represents count) -->
                                    <div class="bg-primary rounded-top-3 transition-all duration-500 ease-out" style="width: 2rem; height: 90%;" title="Grade 10: 120 Students"></div>
                                    <!-- Bar 2 -->
                                    <div class="bg-primary opacity-75 rounded-top-3 transition-all duration-500 ease-out" style="width: 2rem; height: 70%;" title="Grade 9: 90 Students"></div>
                                    <!-- Bar 3 -->
                                    <div class="bg-primary opacity-50 rounded-top-3 transition-all duration-500 ease-out" style="width: 2rem; height: 50%;" title="Grade 8: 70 Students"></div>
                                    <!-- Bar 4 -->
                                    <div class="bg-primary opacity-25 rounded-top-3 transition-all duration-500 ease-out" style="width: 2rem; height: 30%;" title="Grade 7: 50 Students"></div>
                                    <!-- Bar 5 -->
                                    <div class="bg-primary opacity-10 rounded-top-3 transition-all duration-500 ease-out" style="width: 2rem; height: 10%;" title="Primary Grades: 155 Students"></div>
                                </div>
                                <div class="d-flex justify-content-around fs-6 fw-semibold mt-2 text-secondary">
                                    <span>10</span>
                                    <span>9</span>
                                    <span>8</span>
                                    <span>7</span>
                                    <span>1-6</span>
                                </div>
                            </div>

                            <div class="mt-4">
                                <h3 class="fs-6 fw-semibold text-dark mb-2">Highest Enrollment:</h3>
                                <p class="text-sm text-secondary">Grade 10 (120 Students)</p>
                                <p class="text-sm text-secondary mt-1">Enrollment Gap (10 vs 9): 30 Students</p>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="mt-4 alert alert-warning border-start border-4 border-warning shadow-sm rounded-3">
                    <h3 class="fs-6 fw-semibold text-warning d-flex align-items-center mb-1">
                        <i data-lucide="alert-triangle" class="w-5 h-5 me-2"></i>
                        Action Required
                    </h3>
                    <p class="text-sm text-warning mb-0">Class Grade 1 - C currently has no assigned class teacher. Please assign a teacher immediately to ensure smooth operation.</p>
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

@push('scripts')
<script>
$(document).ready(function(){

    const table = $('#teachersTable').DataTable({
        ajax:{
            url:'{{ route("tenant.class.class-list") }}',
            dataSrc:'data'
        },
        columns:[
            {
                data:null,
                className:"text-center",
                orderable:false,
                render:data=>`<input type="checkbox" class="class-checkbox" value="${data.id}">`
            },
            { data:"id", className:"text-center", width:"6%" },

            { data:"name" },

            {
                data:null,
                render:d=> d.teacher_first_name 
                    ? `${d.teacher_first_name} ${d.teacher_last_name}`
                    : `<span class="text-muted">No Teacher Assigned</span>`
            },

            {
                data:"total_students",
                className:"text-center",
                render:d=> `<span class="badge bg-primary p-2">${d}</span>`
            },

            {
                data:"total_subjects",
                className:"text-center",
                render:d=> `<span class="badge bg-info p-2">${d}</span>`
            },

            {
                data:"status",
                className:"text-center",
                render:function(status){
                    if(status=="active") 
                        return `<svg width="16" height="16" fill="#28a745"><circle cx="8" cy="8" r="7"/></svg>`;
                    else 
                        return `<svg width="16" height="16" fill="#ffc107"><circle cx="8" cy="8" r="7"/></svg>`;
                }
            },

            {
                data:null,
                orderable:false,
                className:"text-center",
                render:data=>`
                    <button class="btn btn-info btn-sm mr-2" data-id="${data.id}">View</button>
                    <button class="btn btn-success btn-sm mr-2" data-id="${data.id}">Edit</button>
                    <button class="btn btn-danger btn-sm" data-id="${data.id}">Delete</button>
                `
            }
        ],

        responsive:true,
        pageLength:10,
        order:[[1,'desc']]
    });

    // Select All Handling
    $('#selectAllTeachers').on('click',function(){
        $('.class-checkbox').prop('checked',this.checked);
    });

});
</script>
@endpush

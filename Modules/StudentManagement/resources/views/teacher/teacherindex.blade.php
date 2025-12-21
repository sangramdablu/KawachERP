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
  .icons-list {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 15px;
    margin: 0;
    padding: 0;
  }

  .icon-circle-red { background-color: #dc3545; }
  .icon-circle-orange { background-color: #fd7e14; }
  .icon-circle-pink { background-color: #d63384; }
  .icon-circle-cyan { background-color: #0dcaf0; }

  .stat-card-change {
      font-size: 0.85rem;
      font-weight: 500;
  }
  .stat-card-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
  }
  /* Label and value */
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

  /* Footer info (bottom-right aligned) */
  .stat-card-footer {
    display: flex;
    justify-content: flex-end;
  }

  /* Responsive grid wrapper */
  .icons-list {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 15px;
  }
  /* Utility class to simulate the margin around the main content (grid-margin) */
  .content-wrapper {
      /* padding: 1rem; */
  }
  @media (min-width: 992px) {
       .content-wrapper {
          /* padding: 3rem; */
      }
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

  .dataTables_filter {
      display: none;
  }
  .dataTables_length {
      display: none;
  }

  .btn-primary {
      background-color: #e83e8c;
      border-color: #e83e8c;
  }
  .btn-primary:hover {
      background-color: #d12e7e;
      border-color: #d12e7e;
  }

  #studentsTable tbody tr {
      border-bottom: 1px solid #f0f0f0;
      border-collapse: collapse !important;
      width: 100%;
  }
  #studentsTable tbody tr:last-child {
      border-bottom: none;
  }

  .dataTables_info, .dataTables_paginate {
      padding-top: 1rem;
      padding-bottom: 1rem;
  }

  #studentsTable th,
  #studentsTable td {
      border: 0.5px solid #dcdcdc !important;
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

  #studentsTable tbody tr:hover {
      background-color: #f5f5f5;
  }

  #studentsTable th.text-center input[type="checkbox"] {
      transform: scale(1.1);
  }
    .content-wrapper .grid-margin,
    .content-wrapper .icons-list {
        margin: 0 !important;
        padding: 0 !important;
    }

    .stu-form-section {
        width: 100%;
        max-width: 100%;
    }

    .content-wrapper .card {
        border: none !important;
        box-shadow: none !important;
    }

    #studentsTable.dataTable tbody tr.odd > td,
    #studentsTable.dataTable tbody tr:nth-child(odd) > td {
      background-color: #ffffff !important;
    }

    #studentsTable.dataTable tbody tr.even > td,
    #studentsTable.dataTable tbody tr:nth-child(even) > td {
      background-color: #ddf9ff !important;
    }

    #studentsTable.dataTable tbody tr:hover > td {
      background-color: #f1f3f5 !important;
    }

    #studentsTable.dataTable tbody td {
      color: #212529 !important;
    }

    .dataTable.stripe tbody tr.odd > td,
    .dataTable.stripe tbody tr:nth-child(odd) > td {
      background-color: #ffffff !important;
    }
    .dataTable.stripe tbody tr.even > td,
    .dataTable.stripe tbody tr:nth-child(even) > td {
      background-color: #ddf9ff !important;
    }

    @media (max-width: 576px) {
      #studentsTable.dataTable tbody td {
        background-clip: padding-box;
      }
    }

</style>

<div class="content-wrapper">
  <div class="row">
    <div class="col-lg-12 grid-margin">
      <div class="card">

    <div class="container-fluid py-4">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-lg-12 grid-margin">
                        <div class="card bg-transparent border-0">
                            <div class="card-body p-1">
                              <h4 class="card-title mb-3">Students Statistics</h4>
                                <!-- Start of the four card columns -->
                                <div class="icons-list">
                                  <!-- CARD 1 -->
                                  <div class="stat-card-custom">
                                  <div class="stat-card-header">
                                    <div class="mr-3">
                                      <p class="stat-card-label">TRAFFIC</p>
                                      <p class="stat-card-value">350,897</p>
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
                                  <div class="stat-card-custom d-flex flex-column justify-content-between">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                      <div class="mr-3">
                                        <p class="stat-card-label">NEW USERS</p>
                                        <p class="stat-card-value">2,356</p>
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
                                  <div class="stat-card-custom d-flex flex-column justify-content-between">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                      <div class="mr-3">
                                        <p class="stat-card-label">SALES</p>
                                        <p class="stat-card-value">924</p>
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
                                  <div class="stat-card-custom d-flex flex-column justify-content-between">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                      <div class="mr-3">
                                        <p class="stat-card-label">PERFORMANCE</p>
                                        <p class="stat-card-value">49.65%</p>
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
                    </div>
                </div>
            </div>

            <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                <h4 class="card-title mb-3">Teachers List</h4>

                <div class="d-flex justify-content-between align-items-center mb-1">
                    <div class="input-group" style="width: 250px;">
                    <span class="input-group-text bg-white border-end-0 pe-1">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" class="form-control border-start-0 ps-1" id="customSearchInput" placeholder="SEARCH">
                    </div>

                    <div class="d-flex align-items-center">
                    <select class="form-select me-2" style="width: 120px;">
                        <option selected>Save</option>
                        <option value="1">Option 1</option>
                        <option value="2">Option 2</option>
                    </select>
                    <button class="btn btn-primary me-3">Apply</button>
                    <button class="btn btn-outline-secondary">
                        <i class="fas fa-upload me-1"></i> Export
                    </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="teachersTable" class="table table-hover w-100">
                    <thead class="bg-light-yellow">
                        <tr>
                        <th class="text-center">
                            <input type="checkbox" id="selectAllTeachers">
                        </th>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Joining Date</th>
                        <th>Created At</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    </table>
                </div>
                </div>
            </div>
            </div>

        </div>

         </div>
      </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
  const table = $('#teachersTable').DataTable({
    ajax: { 
      url: '{{ route("tenant.teacher.teachers-list") }}',
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
      { data: 'email' },
      { data: 'joining_date' },
    //   { 
    //     data: 'subject',
    //     render: data => data ? `<span class="badge bg-primary">${data}</span>` : '',
    //     width: '10%',
    //     className: 'text-center'
    //   },
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
            <button type="button" class="btn btn-info btn-sm me-2" data-id="${data.id}">
              View <i class="typcn typcn-eye-outline"></i>
            </button>
            <button type="button" class="btn btn-success btn-sm me-2" data-id="${data.id}">
              Edit <i class="typcn typcn-edit"></i>
            </button>
            <button type="button" class="btn btn-danger btn-sm" data-id="${data.id}">
              Delete <i class="typcn typcn-delete-outline"></i>
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
    }
  });

  // Search
  $('#customSearchInput').on('keyup', function() {
    table.search(this.value).draw();
  });

  // Select all checkbox
  $('#selectAllTeachers').on('click', function() {
    $('.row-checkbox').prop('checked', this.checked);
  });

  $('#teachersTable tbody').on('change', '.row-checkbox', function() {
    $('#selectAllTeachers').prop('checked',
      $('.row-checkbox:checked').length === $('.row-checkbox').length
    );
  });
});
</script>
@endpush

@endsection
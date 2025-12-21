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
      padding: 1rem 0;
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

</style>

{{-- <div class="content-wrapper">
  <div class="row">
    <div class="col-lg-12 grid-margin">
      <div class="card"> --}}

      <div class="card">
      <div class="card-body">
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

        {{-- <div class="container-fluid py-4">
            <div class="content-wrapper">
              <div class="row">
                <div class="col-lg-12 grid-margin">
                  <div class="card bg-transparent border-0">

              </div>
            </div>
          </div>
        </div> --}}

      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Student Lists</h4>
          <div class="table-responsive">
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
                <tbody>
                </tbody>
            </table>
          </div>
        </div>
      </div>


        {{-- </div>

         </div>
      </div>
    </div>
</div> --}}

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
        alert('Saving student with ID: ' + studentId);
    });
});
</script>
@endpush



@endsection
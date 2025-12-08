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
  </style>

  <div class="card">
    <div class="card-body">
      <h4 class="card-title mb-3">Teachers Statistics</h4>
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
          <h4 class="card-title">Teachers List</h4>
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
                          <th>Profile Picture</th>
                          <th>Email</th>
                          <th>Joining Date</th>
                          <th>Status</th>
                          <th>Action</th>
                      </tr>
                  </thead>
                  <tbody></tbody>
              </table>
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
              // Checkbox
              {
                  data: null,
                  orderable: false,
                  className: 'text-center',
                  render: data => `<input type="checkbox" class="teacher-row-checkbox" value="${data.id}">`
              },

              { data: 'id', width: '5%', className: 'text-center' },
              { data: 'first_name' },
              { data: 'last_name' },

              // Profile Picture
              {
                  data: 'profile_picture',
                  render: function(data) {
                      let path = data 
                          ? `/storage/${data}` 
                          : `/storage/defaultimage/default-avatar.png`;

                      return `<img src="${path}" class="rounded-circle" width="55" height="55">`;
                  },
                  orderable: false,
                  className: 'text-center',
                  width: '8%'
              },

              { data: 'email' },

              // Joining Date
              {
                  data: 'joining_date',
                  render: data => data 
                      ? new Date(data).toLocaleDateString('en-US', {year:'numeric', month:'short', day:'numeric'}) 
                      : '',
                  className: 'text-center',
                  width: '12%'
              },

              // Status SVG
              {
                  data: 'status',
                  className: 'text-center',
                  render: function(status) {
                  switch(status) {
                    case 'active':
                      return `<span title="Active">
                          <svg width="16" height="16" fill="#28a745"><circle cx="8" cy="8" r="7"/></svg>
                      </span>`;

                    case 'inactive':
                      return `<span title="Inactive">
                          <svg width="16" height="16" fill="#ffc107"><circle cx="8" cy="8" r="7"/></svg>
                      </span>`;

                    case 'terminated':
                    case 'retired':
                    default:
                      return `<span title="Suspended/Terminated">
                          <svg width="16" height="16" fill="red"><circle cx="8" cy="8" r="7"/></svg>
                      </span>`;
                  }
                }
              },

              // Action Buttons
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
          order: [[1, 'desc']],

          language: {
              info: "Showing _START_ to _END_ of _TOTAL_ teachers",
              paginate: {
                  next: '<i class="fas fa-chevron-right"></i>',
                  previous: '<i class="fas fa-chevron-left"></i>'
              }
          },

          initComplete: function () {
              $('.dataTables_paginate .pagination').addClass('justify-content-end');
          }
      });

      // Select All Checkbox
      $('#selectAllTeachers').on('click', function() {
          $('.teacher-row-checkbox').prop('checked', this.checked);
      });

      $('#teachersTable tbody').on('change', '.teacher-row-checkbox', function() {
          $('#selectAllTeachers').prop(
              'checked',
              $('.teacher-row-checkbox:checked').length === $('.teacher-row-checkbox').length
          );
      });

  });
  </script>
  @endpush

@endsection
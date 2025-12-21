@extends('layouts.master')
@section('content')

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
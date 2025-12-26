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

    .fade-out {
        opacity: 0;
        transform: scale(0.98);
        transition: all 0.35s ease;
    }

    .fade-in {
        animation: fadeFlash 0.45s ease forwards;
    }

    @keyframes fadeFlash {
        0% {
            opacity: 0;
            transform: translateY(10px);
            box-shadow: 0 0 0 rgba(0,0,0,0);
        }
        60% {
            opacity: 1;
            transform: translateY(0);
            box-shadow: 0 0 25px rgba(0,123,255,0.25);
        }
        100% {
            box-shadow: 0 0 0 rgba(0,0,0,0);
        }
    }

</style>
  <div class="card">
    <div class="card-body">

        <div id="attendanceContent">
        <header class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
            <h4 class="card-title mb-3">Students Attendance</h4>
            <div class="d-flex gap-3">
                <button class="btn btn-outline-secondary d-flex align-items-center rounded-5 shadow-sm transition duration-150">
                    <i data-lucide="arrow-down-to-line" class="w-4 h-4 me-2"></i>
                    Export
                </button>
                <select id="addClassSelect" class="form-select fw-semibold rounded-pill d-flex align-items-center shadow-lg">
                    <option value="" disabled selected>Select Class</option>
                    <option value="addClass">Add Class</option>
                    <option value="anotherOption">Another Option</option>
                    <option value="moreOptions">More Options</option>
                </select>
            </div>
        </header>

        <!-- Start of the four card columns -->
        <div class="card shadow-lg mb-4 rounded-4">
            <div class="card-body p-4">
                <div class="row g-3 align-items-center">
                    <div class="col-md-4">
                        <label for="attendanceDate" class="form-label fw-semibold mb-1">Select Attendance Date</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i data-lucide="calendar" class="w-4 h-4"></i></span>
                            <input type="text" id="attendanceDate" class="form-control" placeholder="Select date" readonly >
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="classSelector" class="form-label fw-semibold mb-1">
                            Select Class Section
                        </label>

                        <select class="form-select rounded-3" id="classSelector" name="class_id">
                            <option value="" disabled selected>
                                Select Class
                            </option>

                            @forelse ($classes as $class)
                                <option value="{{ $class->id }}">
                                    {{ $class->class_name }}
                                    @if($class->section)
                                        - {{ $class->section }}
                                    @endif
                                    @if($class->total_students)
                                        ({{ $class->total_students }} Students)
                                    @endif
                                </option>
                            @empty
                                <option disabled>No classes available</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="col-md-4 text-md-end pt-3 pt-md-0">
                        <button id="takeAttendanceBtn" class="btn btn-outline-secondary rounded-3 d-inline-flex align-items-center">
                            <i data-lucide="users" class="w-4 h-4 me-2"></i>
                            Take Attendance
                        </button>
                    </div>
                </div>
            </div>
        </div>
        </div>

        <div id="studentAttendanceTable" class="d-none">
            <div class="card shadow-lg rounded-4">
                <div class="card-body">

                    <h5 class="fw-semibold mb-3">Mark Attendance</h5>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Student Name</th>
                                    <th>Roll No</th>
                                    <th class="text-center">Present</th>
                                </tr>
                            </thead>
                            <tbody id="studentTableBody">
                                <!-- JS injects rows -->
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        
    <!-- End of the four card columns -->
    </div>
  </div>


    {{-- <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-xl-11 col-lg-12">
                
                

            </div>
        </div>
    </div> --}}

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    flatpickr("#attendanceDate", {
        dateFormat: "Y-m-d",
        defaultDate: "today",
        allowInput: false
    });
    const takeAttendanceBtn = document.getElementById('takeAttendanceBtn');

    takeAttendanceBtn.addEventListener('click', function () {

        const classId = document.getElementById('classSelector').value;
        const date = document.getElementById('attendanceDate').value;

        console.log('Class:', classId, 'Date:', date);

        if (!classId || !date) {
            alert('Please select date and class');
            return;
        }

        const content = document.getElementById('attendanceContent');
        const tableSection = document.getElementById('studentAttendanceTable');
        const tableBody = document.getElementById('studentTableBody');

        /* Fade out current content */
        content.classList.add('fade-out');

        setTimeout(() => {
            content.style.display = 'none';

            tableSection.classList.remove('d-none');
            tableSection.classList.add('fade-in');

            tableBody.innerHTML = '';

            fetch(`/attendance/students/${classId}?date=${date}`)
                .then(res => res.json())
                .then(students => {

                    students.forEach((student, index) => {
                        tableBody.innerHTML += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${student.name}</td>
                                <td>${student.roll_no}</td>
                                <td class="text-center">
                                    <input type="checkbox" checked>
                                </td>
                            </tr>
                        `;
                    });

                });

        }, 350);
    });

});
</script>

@endpush
@extends('layouts.master')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
:root {
    --primary-accent: #e83e8c;
    --border-color: #dee2e6;
}
.roster-card {
    border-radius: 1rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.roster-grid {
    display: grid;
    grid-template-columns: 40px repeat(8, 1fr) 50px;
    gap: 0;
    align-items: center;
}

.roster-header {
    background-color: #f8f9fa;
    font-weight: 600;
    color: #495057;
    border-bottom: 2px solid var(--border-color);
    border-top-left-radius: 0.8rem;
    border-top-right-radius: 0.8rem;
}
.roster-header > div {
    padding: 12px 10px;
    border-right: 1px solid #e9ecef;
    font-size: 0.85rem;
}
.roster-header > div:last-child {
    border-right: none;
}

.roster-row {
    transition: background-color 0.2s;
    border-bottom: 1px solid #f8f9fa;
}
.roster-row:hover {
    background-color: #f5f5f5;
}
.roster-row:last-child {
    border-bottom: none;
}

.roster-cell {
    padding: 2px 10px;
    min-height: 50px;
    display: flex;
    align-items: center;
}

.roster-input {
    width: 100%;
    height: 36px;
    padding: 4px 8px;
    border: 1px solid #ced4da;
    border-radius: 0.375rem;
    font-size: 0.9rem;
    transition: all 0.2s;
}
.roster-input:focus {
    outline: none;
    border-color: var(--primary-accent);
    box-shadow: 0 0 0 0.25rem rgba(232, 62, 140, 0.25);
}

.roster-cell.sr-no {
    font-weight: 500;
    color: #495057;
    justify-content: center;
    font-size: 0.9rem;
}

@media (max-width: 991.98px) {
    .roster-container {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .roster-table-wrapper {
        min-width: 1200px; 
    }
    
    .roster-grid {
        grid-template-columns: 40px repeat(9, 120px); 
    }
    
    .roster-header > div:last-child,
    .roster-row > .roster-cell:last-child {
        display: none;
    }
}

.add-row-btn {
    background: linear-gradient(45deg, #e83e8c, #d12e7e); 
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(232, 62, 140, 0.4);
    border: none;
}
.add-row-btn:hover {
    filter: brightness(1.1);
    box-shadow: 0 6px 16px rgba(232, 62, 140, 0.6);
    transform: translateY(-1px);
}

.btn-excel-custom {
    background-color: #1d6f42;
    color: white;
    border: none;
    box-shadow: 0 4px 12px rgba(29, 111, 66, 0.3);
    transition: all 0.3s ease;
}
.btn-excel-custom:hover {
    background-color: #1a6039;
    color: white;
}

@media (max-width: 768px) {
    .content-wrapper,
    .content-wrapper .row,
    .content-wrapper .card,
    .content-wrapper .card-body,
    .content-wrapper .grid-margin,
    .content-wrapper .icons-list {
        margin: 0 !important;
        padding: 0 !important;
    }

    .stu-form-section {
        width: 100% !important;
        max-width: 100% !important;
        padding: 10px !important;
    }

    .content-wrapper .card {
        border: none !important;
        box-shadow: none !important;
    }

    .content-wrapper {
        background-color: #f9f9f9 !important;
    }
}
</style>

<div class="content-wrapper">
  <div class="row">
    <div class="col-lg-12 grid-margin">
      <div class="card">
                        
            <div class="container-fluid py-4">

                <div class="card roster-card mx-auto bg-white border-0 mb-4" style="max-width: 1300px;">
                    <div class="card-body p-4">
                        <h5 class="card-title text-dark fw-bold mb-3">Bulk Student Import</h5>
                        <div class="d-flex flex-column flex-md-row gap-3">
                            
                            <!-- CSV Import Button -->
                            <div class="flex-grow-1 p-3 border rounded-3 d-flex align-items-center justify-content-between">
                                <div>
                                    <i class="fas fa-file-csv fs-4 me-3" style="color: var(--primary-accent);"></i>
                                    <span class="fw-semibold text-dark">Import CSV/Excel File (.csv/.excel)</span>
                                </div>
                                <label for="csvFileInput" class="btn add-row-btn fw-semibold py-1 px-3 rounded-pill text-white" title="Select a CSV file to upload">
                                    Choose File
                                </label>
                                <input type="file" id="csvFileInput" accept=".csv" class="d-none">
                            </div>
                           
                        </div>
                        <small class="text-muted mt-3 d-block">
                            * <a href="#" download class="text-muted">Click</a> to Download default template.
                        </small>
                    </div>
                </div>

                <!-- Main Editable Roster Card -->
                <div class="card roster-card mx-auto bg-white border-0" style="max-width: 1300px;">
                    <div class="card-body p-4 p-md-4">
                        <h5 class="card-title text-dark fw-bold mb-3">Add Multiple Students</h5>
                        <!-- Section Header (Search and Stats) -->
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3">
                            <!-- Search Bar -->
                            <div class="position-relative w-100 w-md-50">
                                <input type="text" placeholder="Search by name, father name, mobile, admission no..." class="form-control ps-5 roster-input h-10 border-gray-300">
                                <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                            </div>
                            
                            <!-- Filter Icon and Total Count -->
                            <div class="d-flex align-items-center gap-3">
                                <button class="btn btn-light p-2 rounded-lg text-secondary hover-shadow">
                                    <i class="fas fa-filter fs-5"></i>
                                </button>
                                <span class="fs-6 fw-semibold text-dark">Total Students: <span id="totalStudents">1</span></span>
                            </div>
                        </div>

                        <!-- Table Section -->
                        <div class="roster-container">
                            <div class="roster-table-wrapper">

                                <!-- Table Header Row (Updated to match new fields) -->
                                <div class="roster-grid roster-header">
                                    <div>#</div>
                                    <div>First Name</div>
                                    <div>Last Name</div>
                                    <div>Date of Birth</div>
                                    <div>Gender</div>
                                    <div>Email</div>
                                    <div>Phone</div>
                                    <div>Guardian Name</div>
                                    <div>City</div>
                                    <div class="text-center">Action</div>
                                </div>

                                <!-- Table Body Container -->
                                <div id="rosterBody" class="roster-body">
                                    <!-- Initial Row (Example Data) -->
                                    <div class="roster-grid roster-row">
                                        <div class="roster-cell sr-no">1</div>
                                        <div class="roster-cell"><input type="text" name="first_name[]" class="roster-input" value="" required></div>
                                        <div class="roster-cell"><input type="text" name="last_name[]" class="roster-input" value="" required></div>
                                        <div class="roster-cell"><input type="date" name="dob[]" class="roster-input" value="" required></div>
                                        <div class="roster-cell">
                                            <select name="gender[]" class="roster-input">
                                                <option value="" selected>Select</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                            </select>
                                        </div>
                                        <div class="roster-cell"><input type="email" name="email[]" class="roster-input" value=""></div>
                                        <div class="roster-cell"><input type="tel" name="phone_number[]" class="roster-input" value=""></div>
                                        <div class="roster-cell"><input type="text" name="guardian_name[]" class="roster-input" value=""></div>
                                        <div class="roster-cell"><input type="text" name="city[]" class="roster-input" value=""></div>
                                        <div class="roster-cell justify-content-center">
                                            <button onclick="removeRow(this)" class="btn text-danger p-1 rounded transition-colors" title="Remove Row">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        
                        <!-- Add Row & Submit Buttons (Under the table) -->
                        <div class="d-flex justify-content-start mt-4 gap-3">
                            <button id="addRowBtn" type="button" class="add-row-btn btn text-white fw-semibold py-2 px-4 rounded-pill d-flex align-items-center shadow-lg">
                                <i class="fas fa-plus me-2"></i> Add Row
                            </button>

                            <button id="submitRosterBtn" type="button" class="btn btn-success fw-semibold py-2 px-4 rounded-pill d-flex align-items-center shadow">
                                <i class="fas fa-check me-2"></i> Submit All
                            </button>
                        </div>

                    </div>
                </div>
            </div>


            </div>
        </div>
    </div>
</div>


<script>
    const rosterBody = document.getElementById('rosterBody');
    const addRowBtn = document.getElementById('addRowBtn');
    const submitRosterBtn = document.getElementById('submitRosterBtn');
    const totalStudentsSpan = document.getElementById('totalStudents');
    
    // --- Utility Functions ---

    // Function to update the row numbers and total count
    function updateRoster() {
        const rows = rosterBody.querySelectorAll('.roster-row');
        rows.forEach((row, index) => {
            const srNoCell = row.querySelector('.roster-cell.sr-no');
            if (srNoCell) {
                srNoCell.textContent = index + 1;
            }
        });
        totalStudentsSpan.textContent = rows.length;
    }

    // Function to create a new editable row
    function createNewRow() {
        const newRow = document.createElement('div');
        newRow.className = 'roster-grid roster-row';
        
        const rowContent = `
            <div class="roster-cell sr-no"></div> 
            <div class="roster-cell"><input type="text" name="first_name[]" class="roster-input form-control" required></div>
            <div class="roster-cell"><input type="text" name="last_name[]" class="roster-input form-control" required></div>
            <div class="roster-cell"><input type="date" name="dob[]" class="roster-input form-control" required></div>
            <div class="roster-cell">
                <select name="gender[]" class="roster-input form-select">
                    <option value="">Select</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="roster-cell"><input type="email" name="email[]" class="roster-input form-control"></div>
            <div class="roster-cell"><input type="tel" name="phone_number[]" class="roster-input form-control"></div>
            <div class="roster-cell"><input type="text" name="guardian_name[]" class="roster-input form-control"></div>
            <div class="roster-cell"><input type="text" name="city[]" class="roster-input form-control"></div>
            <div class="roster-cell justify-content-center">
                <button onclick="removeRow(this)" class="btn text-danger p-1 rounded" title="Remove Row">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
        `;

        newRow.innerHTML = rowContent;
        return newRow;
    }
    
    // Function to show a simple confirmation (toast-like alert)
    function showConfirmationMessage(message, isSuccess = true) {
        const msgDiv = document.createElement('div');
        msgDiv.className = `alert alert-${isSuccess ? 'success' : 'danger'} position-fixed bottom-0 end-0 m-3 shadow-lg`;
        msgDiv.style.zIndex = 1050;
        msgDiv.textContent = message;
        document.body.appendChild(msgDiv);

        setTimeout(() => {
            msgDiv.remove();
        }, 3000);
    }

    // --- Event Handlers ---

    // Add new row button click
    addRowBtn.addEventListener('click', () => {
        const newRow = createNewRow();
        rosterBody.appendChild(newRow);
        updateRoster();
        newRow.scrollIntoView({ behavior: 'smooth', block: 'end' });
        const firstInput = newRow.querySelector('[name="first_name[]"]');
        if (firstInput) firstInput.focus();
    });

    // Remove row function
    window.removeRow = function(button) {
        const row = button.closest('.roster-row');
        if (row) {
            row.remove();
            updateRoster();
        }
    };

    // Submit all rows to backend
    submitRosterBtn.addEventListener('click', () => {
        const rows = rosterBody.querySelectorAll('.roster-row');
        if (rows.length === 0) {
            showConfirmationMessage('Please add at least one student before submitting.', false);
            return;
        }

        const formData = new FormData();

        rows.forEach(row => {
            const inputs = row.querySelectorAll('input, select');
            inputs.forEach(input => {
                if (input.name) {
                    formData.append(input.name, input.value);
                }
            });
        });

        // --- Backend API Call ---
        fetch("{{ route('tenant.student.bulkStore') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showConfirmationMessage('Students added successfully!');
                rosterBody.innerHTML = '';
                updateRoster();
            } else {
                showConfirmationMessage('Error: ' + (data.message || 'Failed to save students.'), false);
            }
        })
        .catch(err => {
            console.error(err);
            showConfirmationMessage('An error occurred while saving students.', false);
        });
    });

    // Initial setup
    window.onload = function() {
        updateRoster();
    };
</script>


@endsection
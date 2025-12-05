@extends('layouts.staff.layout')

@section('title', 'Add Patient - Letty\'s Birthing Home')
@section('page-title', 'Add Patient')

@section('content')

    <div class="container-fluid main-content">
        <!-- Tab Navigation -->
        <div class="form-card">
            <div class="tab-navigation">
                <button class="tab-button active" data-tab="existing-patient">
                    <i class="fas fa-user-check me-2"></i>Existing Patient
                </button>
                <button class="tab-button" data-tab="new-patient">
                    <i class="fas fa-user-plus me-2"></i>New Patient
                </button>
            </div>
        </div>

        <!-- Existing Patient Tab -->
        <div class="tab-content active" id="existing-patient-tab">
            <div class="form-card">
                <div class="form-header">
                    <h5>
                        <i class="fas fa-search me-2"></i>
                        Select Existing Patient
                    </h5>
                    <div class="header-actions">
                        <a href="{{ route('currentPatients') }}" class="back-button">
                            <i class="fas fa-arrow-left me-2"></i> Back
                        </a>
                    </div>
                </div>

                <div class="form-section">
                    <div class="search-controls mb-3">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="patientSearchInput">Search Patient</label>
                                <input type="text" class="form-control" id="patientSearchInput" 
                                    placeholder="Type to search by name, phone, or address...">
                            </div>
                            <div class="col-md-3">
                                <label for="entriesPerPage">Show entries</label>
                                <select class="form-select" id="entriesPerPage">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="all">All</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div id="patientsTableContainer">
                        <div class="table-responsive">
                            <table class="table table-hover" id="patientsTable">
                                <thead>
                                    <tr>
                                        <th onclick="sortTable(0)" style="cursor: pointer;">
                                            Patient Name <i class="fas fa-sort"></i>
                                        </th>
                                        <th onclick="sortTable(1)" style="cursor: pointer;">
                                            Phone <i class="fas fa-sort"></i>
                                        </th>
                                        <th onclick="sortTable(2)" style="cursor: pointer;">
                                            Address <i class="fas fa-sort"></i>
                                        </th>
                                        <th onclick="sortTable(3)" style="cursor: pointer;">
                                            Age <i class="fas fa-sort"></i>
                                        </th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="patientsTableBody">
                                    @foreach($patients as $patient)
                                    <tr>
                                        <td>{{ $patient['first_name'] }} {{ $patient['last_name'] }}</td>
                                        <td>{{ $patient['client_phone'] ?? 'N/A' }}</td>
                                        <td>{{ $patient['address'] ?? 'N/A' }}</td>
                                        <td>{{ $patient['age'] ?? 'N/A' }}</td>
                                        <td>
                                            <a href="/staff/patient/{{ $patient['id'] }}/addRecords" class="patient-select-btn">
                                                <i class="fas fa-plus me-1"></i>Add Record
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div id="paginationInfo" class="d-flex justify-content-between align-items-center mt-3">
                            <div id="showingInfo"></div>
                            <div id="paginationControls"></div>
                        </div>
                    </div>

                    <div id="noPatients" style="display: none;" class="alert alert-info mt-3">
                        <i class="fas fa-info-circle me-2"></i>No patients found matching your search.
                    </div>
                </div>
            </div>
        </div>

        <!-- New Patient Tab -->
        <div class="tab-content" id="new-patient-tab">
            <form id="patientForm" method="POST" action="{{ route('storePatientRecord') }}" enctype="multipart/form-data">
                @csrf

                <!-- Patient Information Section -->
                <div class="form-card" id="patientSection">
                    <div class="form-header">
                        <h5>
                            <i class="fas fa-user-plus me-2"></i>
                            Add Patient Information
                        </h5>
                        <div class="header-actions">
                            <a href="{{ route('currentPatients') }}" class="back-button">
                                <i class="fas fa-arrow-left me-2"></i> Back
                            </a>
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="form-section-title">
                            <i class="fas fa-user-circle me-2"></i>
                            Patient Information
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="firstName">First Name <span class="required">*</span></label>
                                <input type="text" class="form-control" id="firstName" name="first_name" required>
                                <div class="invalid-feedback">First name is required</div>
                            </div>

                            <div class="form-group">
                                <label for="middleName">Middle Name</label>
                                <input type="text" class="form-control" id="middleName" name="middle_name">
                            </div>

                            <div class="form-group">
                                <label for="lastName">Last Name <span class="required">*</span></label>
                                <input type="text" class="form-control" id="lastName" name="last_name" required>
                                <div class="invalid-feedback">Last name is required</div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="barangay">Barangay <span class="required">*</span></label>
                                <input type="text" class="form-control" id="barangay" name="barangay" required>
                                <div class="invalid-feedback">Barangay is required</div>
                            </div>
                            <div class="form-group">
                                <label for="municipality">Municipality <span class="required">*</span></label>
                                <input type="text" class="form-control" id="municipality" name="municipality" required>
                                <div class="invalid-feedback">Municipality is required</div>
                            </div>
                            <div class="form-group">
                                <label for="province">Province <span class="required">*</span></label>
                                <input type="text" class="form-control" id="province" name="province" required>
                                <div class="invalid-feedback">Province is required</div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="phone">Phone Number <span class="required">*</span></label>
                                <input type="tel" class="form-control" id="phone" name="phone" pattern="09[0-9]{9}"
                                    placeholder="09XXXXXXXXX" required>
                                <div class="invalid-feedback">Valid 11-digit phone number is required (09XXXXXXXXX)</div>
                            </div>
                            <div class="form-group">
                                <label for="age">Age <span class="required">*</span></label>
                                <input type="number" class="form-control" id="age" name="age" min="1" max="100" required>
                                <div class="invalid-feedback">Age is required</div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="maritalStatus">Marital Status <span class="required">*</span></label>
                                <select class="form-select" id="maritalStatus" name="marital_status_id" required>
                                    <option value="" disabled selected>Select marital status</option>
                                    <option value="1">Single</option>
                                    <option value="2">Married</option>
                                    <option value="3">Separated</option>
                                </select>
                                <div class="invalid-feedback">Marital status is required</div>
                            </div>
                            <div class="form-group">
                                <label for="spouseFName">Spouse First Name</label>
                                <input type="text" class="form-control" id="spouseFName" name="spouse_fname"
                                    placeholder="Enter spouse first name">
                            </div>
                            <div class="form-group">
                                <label for="spouseLName">Spouse Last Name</label>
                                <input type="text" class="form-control" id="spouseLName" name="spouse_lname"
                                    placeholder="Enter spouse last name">
                            </div>
                        </div>
                    </div>

                    <div class="form-section form-actions">
                        <button type="button" class="btnn btn-secondary" onclick="nextStep()">
                            <i class="fas fa-arrow-right me-2"></i> Next
                        </button>
                    </div>
                </div>

                <!-- Prenatal Checkup Section -->
                <div class="form-card section-hidden" id="prenatalSection">
                    <div class="form-header">
                        <h5>
                            <i class="fas fa-plus me-2"></i>
                            Add Prenatal Checkup Record
                        </h5>
                        <div class="header-actions">
                            <button type="button" class="back-button" onclick="showPatientSection()">
                                <i class="fas fa-arrow-left me-2"></i> Back
                            </button>
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="form-section-title">
                            <i class="fas fa-calendar-check me-2"></i>
                            Visit Information
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="visitNumber">Visit Number</label>
                                <input type="number" class="form-control" id="visitNumber" name="visit_number"
                                    value="1" readonly>
                            </div>
                            <div class="form-group">
                                <label for="visitDate">Date</label>
                                <input type="date" class="form-control" id="visitDate" name="visit_date"
                                    value="{{ date('Y-m-d') }}" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="nextVisitBranch">Next Visit Branch</label>
                                <select class="form-control" id="nextVisitBranch" name="branch_id">
                                    <option value="">Select Branch</option>
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="nextVisitDate">Next Visit Date</label>
                                <input type="date" class="form-control" id="nextVisitDate" name="next_visit_date">
                                <div class="invalid-feedback">Next visit date is required</div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="nextVisitTime">Next Visit Time</label>
                                <select class="form-control" id="nextVisitTime" name="next_visit_time" disabled>
                                    <option value="">Select branch and date first</option>
                                </select>
                                <div id="visitTimeSlotHelp" class="time-slot-info" style="display: none;">
                                    <i class="fas fa-info-circle"></i> Loading available time slots...
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="form-section-title">
                            <i class="fas fa-baby me-2"></i>
                            Pregnancy Details
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="lmp">Last Menstrual Period</label>
                                <input type="date" class="form-control" id="lmp" name="lmp">
                                <div class="invalid-feedback">LMP is required</div>
                            </div>
                            <div class="form-group">
                                <label for="edc">Estimated Date of Confinement</label>
                                <input type="date" class="form-control" id="edc" name="edc">
                                <div class="invalid-feedback">EDC is required</div>
                            </div>
                            <div class="form-group">
                                <label for="aog">Age of Gestation</label>
                                <input type="text" class="form-control" id="aog" name="aog" placeholder="e.g., 12 weeks">
                                <div class="invalid-feedback">AOG is required</div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="gravida">Gravida</label>
                                <input type="number" class="form-control" id="gravida" name="gravida" min="0" required>
                                <div class="invalid-feedback">Gravida is required</div>
                            </div>
                            <div class="form-group">
                                <label for="para">Para</label>
                                <input type="number" class="form-control" id="para" name="para" min="0" required>
                                <div class="invalid-feedback">Para is required</div>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="form-section-title">
                            <i class="fas fa-heartbeat me-2"></i>
                            Maternal Vital Signs & Physical Exam
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="fht">Fetal Heart Tones</label>
                                <input type="text" class="form-control" id="fht" name="fht" placeholder="e.g., 140 bpm">
                                <div class="invalid-feedback">FHT is required</div>
                            </div>
                            <div class="form-group">
                                <label for="fh">Fundal Height</label>
                                <input type="text" class="form-control" id="fh" name="fh" placeholder="e.g., 20 cm">
                                <div class="invalid-feedback">FH is required</div>
                            </div>
                            <div class="form-group">
                                <label for="weight">Weight</label>
                                <input type="text" class="form-control" id="weight" name="weight" placeholder="e.g., 60 kg">
                                <div class="invalid-feedback">Weight is required</div>
                            </div>
                            <div class="form-group">
                                <label for="bp">Blood Pressure</label>
                                <input type="text" class="form-control" id="bp" name="bp" placeholder="e.g., 120/80">
                                <div class="invalid-feedback">Blood pressure is required</div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="temp">Temperature</label>
                                <input type="text" class="form-control" id="temp" name="temp" placeholder="e.g., 36.5°C">
                                <div class="invalid-feedback">Temperature is required</div>
                            </div>
                            <div class="form-group">
                                <label for="rr">Respiratory Rate</label>
                                <input type="text" class="form-control" id="rr" name="rr" placeholder="e.g., 18 /min">
                                <div class="invalid-feedback">Respiratory rate is required</div>
                            </div>
                            <div class="form-group">
                                <label for="pr">Pulse Rate</label>
                                <input type="text" class="form-control" id="pr" name="pr" placeholder="e.g., 72 bpm">
                                <div class="invalid-feedback">Pulse rate is required</div>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="form-section-title">
                            <i class="fas fa-sticky-note me-2"></i>Remarks
                        </div>
                        <div class="form-row">
                            <div class="form-group" style="flex: 1 1 100%;">
                                <label for="remarks">Notes / Remarks</label>
                                <textarea class="form-control form-textarea" id="remarks" name="remarks" rows="3"
                                    placeholder="Enter remarks about this visit..."></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="form-row">
                            <div class="form-group">
                                <div>
                                    <input type="checkbox" id="showImmunizationSection" name="show_immunization">
                                    <label for="showImmunizationSection" class="ms-2">Add Immunization Transaction</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-section section-hidden" id="immunizationSection">
                        <div class="form-section-title">
                            <i class="fas fa-syringe me-2"></i>Immunization Details
                        </div>
                        <div id="immunizationEntries">
                            <!-- Dynamic vaccine entries will be added here -->
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <button type="button" class="btnn btn-primary" id="addVaccineBtn">
                                    <i class="fas fa-plus me-2"></i>Add Vaccine
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="form-section section-hidden" id="immunizationRemarksSection">
                        <div class="form-section-title">
                            <i class="fas fa-sticky-note me-2"></i>Immunization Remarks
                        </div>
                        <div class="form-row">
                            <div class="form-group" style="flex: 1 1 100%;">
                                <label for="immunizationNotes">Immunization Notes</label>
                                <textarea class="form-control form-textarea" id="immunizationNotes" name="immunization_notes" rows="3"
                                    placeholder="Enter notes about this immunization..."></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-section form-actions">
                        <button type="submit" class="btnn btn-primary">
                            <i class="fas fa-save me-2"></i> Save Record
                        </button>
                        <button type="button" class="btnn btn-danger" onclick="cancelForm()">
                            <i class="fas fa-times me-2"></i> Cancel
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <style>
        /* Time Slot Info Styles */
        .time-slot-info {
            margin-top: 8px;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 6px;
            animation: fadeIn 0.3s ease-in-out;
        }
        .time-slot-info.loading {
            background-color: #e3f2fd;
            color: #1976d2;
            border: 1px solid #bbdefb;
        }
        .time-slot-info.success {
            background-color: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #c8e6c9;
        }
        .time-slot-info.warning {
            background-color: #fff3e0;
            color: #f57c00;
            border: 1px solid #ffe0b2;
        }
        .time-slot-info.error {
            background-color: #ffebee;
            color: #c62828;
            border: 1px solid #ffcdd2;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-5px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fa-spinner.fa-spin {
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Tab Navigation Styles */
        .tab-navigation {
            display: flex;
            gap: 10px;
            padding: 20px;
            border-bottom: 2px solid #e0e0e0;
        }

        .tab-button {
            padding: 12px 24px;
            background: white;
            border: 2px solid #1e5a8e;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            transition: all 0.3s ease;
            color: #1e5a8e;
        }

        .tab-button:hover {
            background: #1e5a8e;
            color: white;
        }

        .tab-button.active {
            background: #1e5a8e;
            border-color: #1e5a8e;
            color: white;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        /* Table Styles */
        #patientsTable {
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }

        #patientsTable thead th {
            background: #f8f9fa;
            font-weight: 600;
            user-select: none;
        }

        #patientsTable tbody tr {
            transition: background 0.2s ease;
        }

        #patientsTable tbody tr:hover {
            background: #f8f9fa;
        }

        .patient-select-btn {
            padding: 6px 16px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .patient-select-btn:hover {
            background: #218838;
            color: white;
        }

        /* Pagination Styles */
        #paginationControls button {
            margin: 0 2px;
            padding: 6px 12px;
            border: 1px solid #dee2e6;
            background: white;
            cursor: pointer;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        #paginationControls button:hover:not(:disabled) {
            background: #007bff;
            color: white;
            border-color: #007bff;
        }

        #paginationControls button.active {
            background: #007bff;
            color: white;
            border-color: #007bff;
        }

        #paginationControls button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .search-controls label {
            font-weight: 500;
            margin-bottom: 5px;
        }

        /* Section Hidden */
        .section-hidden {
            display: none !important;
        }

        /* Form Validation Styles */
        .is-invalid {
            border-color: #dc3545 !important;
            padding-right: calc(1.5em + 0.75rem);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }

        .is-invalid:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }

        .invalid-feedback {
            display: none;
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .is-invalid ~ .invalid-feedback {
            display: block;
        }

        /* Required Field Asterisk */
        .required {
            color: #dc3545;
            font-weight: bold;
        }

        /* Vaccine Entry Styles */
        .vaccine-entry {
            padding: 15px;
            margin-bottom: 15px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            background: #f8f9fa;
        }

        .vaccine-entry hr {
            margin: 15px 0;
            border-top: 1px solid #dee2e6;
        }

        .btn-remove {
            padding: 8px 16px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.3s ease;
        }

        .btn-remove:hover {
            background: #c82333;
        }

        /* Form Actions */
        .form-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            padding: 20px;
            border-top: 1px solid #e0e0e0;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .tab-navigation {
                flex-direction: column;
            }

            .tab-button {
                width: 100%;
            }

            .form-row {
                flex-direction: column;
            }

            .form-group {
                width: 100%;
            }
        }
    </style>

    <script>
        const vaccines = @json($vaccines);
        const allPatients = @json($patients);
        const visitSlotsUrl = "{{ route('visits.availableSlots') }}";

        // Tab switching functionality
        document.querySelectorAll('.tab-button').forEach(button => {
            button.addEventListener('click', function() {
                const tabName = this.getAttribute('data-tab');
                
                document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
                
                this.classList.add('active');
                document.getElementById(tabName + '-tab').classList.add('active');
            });
        });

        // Patient table management
        let currentPage = 1;
        let entriesPerPage = 5;
        let filteredPatients = [...allPatients];
        let sortDirection = {};

        function renderTable() {
            const tbody = document.getElementById('patientsTableBody');
            const noPatients = document.getElementById('noPatients');
            const tableContainer = document.getElementById('patientsTableContainer');

            if (filteredPatients.length === 0) {
                noPatients.style.display = 'block';
                tableContainer.style.display = 'none';
                return;
            }

            noPatients.style.display = 'none';
            tableContainer.style.display = 'block';

            const start = entriesPerPage === 'all' ? 0 : (currentPage - 1) * entriesPerPage;
            const end = entriesPerPage === 'all' ? filteredPatients.length : start + parseInt(entriesPerPage);
            const pagePatients = filteredPatients.slice(start, end);

            tbody.innerHTML = pagePatients.map(patient => `
                <tr>
                    <td>${patient.first_name} ${patient.last_name}</td>
                    <td>${patient.client_phone || 'N/A'}</td>
                    <td>${patient.address || 'N/A'}</td>
                    <td>${patient.age || 'N/A'}</td>
                    <td>
                        <a href="/staff/patient/${patient.id}/addRecords" class="patient-select-btn">
                            <i class="fas fa-plus me-1"></i>Add Record
                        </a>
                    </td>
                </tr>
            `).join('');

            updatePagination();
        }

        function updatePagination() {
            const showingInfo = document.getElementById('showingInfo');
            const paginationControls = document.getElementById('paginationControls');

            if (entriesPerPage === 'all') {
                showingInfo.textContent = `Showing all ${filteredPatients.length} entries`;
                paginationControls.innerHTML = '';
                return;
            }

            const totalPages = Math.ceil(filteredPatients.length / entriesPerPage);
            const start = (currentPage - 1) * entriesPerPage + 1;
            const end = Math.min(currentPage * entriesPerPage, filteredPatients.length);

            showingInfo.textContent = `Showing ${start} to ${end} of ${filteredPatients.length} entries`;

            let paginationHTML = `
                <button onclick="changePage(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''}>
                    <i class="fas fa-chevron-left"></i>
                </button>
            `;

            for (let i = 1; i <= totalPages; i++) {
                if (i === 1 || i === totalPages || (i >= currentPage - 1 && i <= currentPage + 1)) {
                    paginationHTML += `
                        <button onclick="changePage(${i})" class="${i === currentPage ? 'active' : ''}">
                            ${i}
                        </button>
                    `;
                } else if (i === currentPage - 2 || i === currentPage + 2) {
                    paginationHTML += '<span>...</span>';
                }
            }

            paginationHTML += `
                <button onclick="changePage(${currentPage + 1})" ${currentPage === totalPages ? 'disabled' : ''}>
                    <i class="fas fa-chevron-right"></i>
                </button>
            `;

            paginationControls.innerHTML = paginationHTML;
        }

        function changePage(page) {
            const totalPages = Math.ceil(filteredPatients.length / entriesPerPage);
            if (page >= 1 && page <= totalPages) {
                currentPage = page;
                renderTable();
            }
        }

        function filterPatients() {
            const searchTerm = document.getElementById('patientSearchInput').value.toLowerCase();
            
            filteredPatients = allPatients.filter(patient => {
                const fullName = `${patient.first_name} ${patient.last_name}`.toLowerCase();
                const phone = (patient.client_phone || '').toLowerCase();
                const address = (patient.address || '').toLowerCase();
                
                return fullName.includes(searchTerm) || 
                       phone.includes(searchTerm) || 
                       address.includes(searchTerm);
            });

            currentPage = 1;
            renderTable();
        }

        function sortTable(columnIndex) {
            const column = ['name', 'phone', 'address', 'age'][columnIndex];
            
            if (!sortDirection[column] || sortDirection[column] === 'desc') {
                sortDirection[column] = 'asc';
            } else {
                sortDirection[column] = 'desc';
            }

            filteredPatients.sort((a, b) => {
                let aVal, bVal;

                switch(columnIndex) {
                    case 0: // Name
                        aVal = `${a.first_name} ${a.last_name}`.toLowerCase();
                        bVal = `${b.first_name} ${b.last_name}`.toLowerCase();
                        break;
                    case 1: // Phone
                        aVal = a.client_phone || '';
                        bVal = b.client_phone || '';
                        break;
                    case 2: // Address
                        aVal = a.address || '';
                        bVal = b.address || '';
                        break;
                    case 3: // Age
                        aVal = parseInt(a.age) || 0;
                        bVal = parseInt(b.age) || 0;
                        break;
                }

                if (sortDirection[column] === 'asc') {
                    return aVal > bVal ? 1 : -1;
                } else {
                    return aVal < bVal ? 1 : -1;
                }
            });

            renderTable();
        }

        // Event listeners
        document.getElementById('patientSearchInput').addEventListener('input', filterPatients);
        
        document.getElementById('entriesPerPage').addEventListener('change', function() {
            entriesPerPage = this.value === 'all' ? 'all' : parseInt(this.value);
            currentPage = 1;
            renderTable();
        });

        // Auto-calculate EDC from LMP (280 days / 40 weeks)
        document.getElementById('lmp').addEventListener('change', function() {
            if (this.value) {
                const lmpDate = new Date(this.value);
                const edcDate = new Date(lmpDate);
                edcDate.setDate(edcDate.getDate() + 280);
                
                const year = edcDate.getFullYear();
                const month = String(edcDate.getMonth() + 1).padStart(2, '0');
                const day = String(edcDate.getDate()).padStart(2, '0');
                
                document.getElementById('edc').value = `${year}-${month}-${day}`;
            }
        });

        // ✅ Time Slot Selection Functionality
        const nextVisitBranch = document.getElementById('nextVisitBranch');
        const nextVisitDate = document.getElementById('nextVisitDate');
        const nextVisitTime = document.getElementById('nextVisitTime');
        const visitTimeSlotHelp = document.getElementById('visitTimeSlotHelp');

        function fetchAvailableSlots() {
            const branchId = nextVisitBranch.value;
            const date = nextVisitDate.value;

            // Reset if either field is empty
            if (!branchId || !date) {
                nextVisitTime.disabled = true;
                nextVisitTime.innerHTML = '<option value="">Select branch and date first</option>';
                visitTimeSlotHelp.style.display = 'none';
                return;
            }

            // Show loading state
            visitTimeSlotHelp.style.display = 'flex';
            visitTimeSlotHelp.className = 'time-slot-info loading';
            visitTimeSlotHelp.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading available time slots...';
            nextVisitTime.disabled = true;

            // Fetch available slots
            fetch(`${visitSlotsUrl}?branch_id=${branchId}&date=${date}`)
                .then(response => response.json())
                .then(data => {
                    nextVisitTime.innerHTML = '<option value="">Select time slot</option>';
                    
                    if (data.slots && data.slots.length > 0) {
                        data.slots.forEach(slot => {
                            const option = document.createElement('option');
                            option.value = slot.value;
                            option.textContent = slot.label;
                            nextVisitTime.appendChild(option);
                        });
                        
                        nextVisitTime.disabled = false;
                        visitTimeSlotHelp.className = 'time-slot-info success';
                        visitTimeSlotHelp.innerHTML = `<i class="fas fa-check-circle"></i> ${data.slots.length} time slot(s) available`;
                    } else {
                        nextVisitTime.innerHTML = '<option value="">No slots available</option>';
                        visitTimeSlotHelp.className = 'time-slot-info warning';
                        visitTimeSlotHelp.innerHTML = '<i class="fas fa-exclamation-circle"></i> No time slots available for this date';
                    }
                })
                .catch(error => {
                    console.error('Error fetching slots:', error);
                    nextVisitTime.innerHTML = '<option value="">Error loading slots</option>';
                    visitTimeSlotHelp.className = 'time-slot-info error';
                    visitTimeSlotHelp.innerHTML = '<i class="fas fa-times-circle"></i> Error loading time slots';
                });
        }

        // Add event listeners for time slot fetching
        if (nextVisitBranch && nextVisitDate && nextVisitTime) {
            nextVisitBranch.addEventListener('change', fetchAvailableSlots);
            nextVisitDate.addEventListener('change', fetchAvailableSlots);
        }

        // Initial render
        renderTable();
    </script>

    <script src="{{ asset('script/staff/add-patient.js') }}"></script>
@endsection
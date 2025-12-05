@extends('layouts.staff.layout')

@section('title', 'Add Record - Letty\'s Birthing Home')
@section('page-title', 'Add Patient Record')

@section('content')
<style>
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

/* Section visibility */
.section-hidden {
    display: none !important;
}

/* Required field asterisk */
.required {
    color: #dc3545;
    font-weight: bold;
}

/* Form validation styles */
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

/* Alert styles */
.alert-warning {
    background-color: #fff3cd;
    border-color: #ffecb5;
    color: #856404;
    padding: 12px 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.hidden-section {
    display: none;
}
</style>

<div class="container-fluid main-content">
    <form id="patientForm" method="POST" action="{{ route('patient.prenatal.store', $patient->id) }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="prenatal_status_id" id="prenatalStatusId" value="1">

        <!-- Patient Information Section (Show if incomplete) -->
        <div class="form-card {{ $isPatientInfoIncomplete ? '' : 'section-hidden' }}" id="patientInfoSection">
            <div class="form-header">
                <h5>
                    <i class="fas fa-user-edit me-2"></i>
                    Complete Patient Information
                </h5>
                <div class="header-actions">
                    <a href="{{ route('currentPatients') }}" class="back-button">
                        <i class="fas fa-arrow-left me-2"></i> Back
                    </a>
                </div>
            </div>

            <div class="alert-warning">
                <i class="fas fa-exclamation-triangle"></i>
                <span>Please complete the patient information before proceeding to prenatal checkup.</span>
            </div>

            <div class="form-section">
                <div class="form-section-title">
                    <i class="fas fa-user-circle me-2"></i>
                    Patient Information
                </div>
                
                <!-- Name Fields -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="firstName">First Name <span class="required">*</span></label>
                        <input type="text" class="form-control" id="firstName" name="first_name" 
                            value="{{ old('first_name', $patient->first_name) }}" required>
                        <div class="invalid-feedback">First name is required</div>
                    </div>

                    <div class="form-group">
                        <label for="middleName">Middle Name</label>
                        <input type="text" class="form-control" id="middleName" name="middle_name"
                            value="{{ old('middle_name', $patient->middle_name) }}">
                    </div>

                    <div class="form-group">
                        <label for="lastName">Last Name <span class="required">*</span></label>
                        <input type="text" class="form-control" id="lastName" name="last_name"
                            value="{{ old('last_name', $patient->last_name) }}" required>
                        <div class="invalid-feedback">Last name is required</div>
                    </div>
                </div>

                <!-- Address Fields -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="barangay">Barangay <span class="required">*</span></label>
                        <input type="text" class="form-control" id="barangay" name="barangay"
                            value="{{ old('barangay', $patient->address->village ?? '') }}" required>
                        <div class="invalid-feedback">Barangay is required</div>
                    </div>
                    
                    <div class="form-group">
                        <label for="municipality">Municipality <span class="required">*</span></label>
                        <input type="text" class="form-control" id="municipality" name="municipality"
                            value="{{ old('municipality', $patient->address->city_municipality ?? '') }}" required>
                        <div class="invalid-feedback">Municipality is required</div>
                    </div>
                    
                    <div class="form-group">
                        <label for="province">Province <span class="required">*</span></label>
                        <input type="text" class="form-control" id="province" name="province"
                            value="{{ old('province', $patient->address->province ?? '') }}" required>
                        <div class="invalid-feedback">Province is required</div>
                    </div>
                </div>

                <!-- Contact and Demographics -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="phone">Phone Number <span class="required">*</span></label>
                        <input type="tel" class="form-control" id="phone" name="client_phone" 
                            pattern="09[0-9]{9}" placeholder="09XXXXXXXXX"
                            value="{{ old('client_phone', $patient->client_phone) }}" required>
                        <div class="invalid-feedback">Valid 11-digit phone number is required (09XXXXXXXXX)</div>
                    </div>
                    
                    <div class="form-group">
                        <label for="age">Age <span class="required">*</span></label>
                        <input type="number" class="form-control" id="age" name="age" min="1" max="100"
                            value="{{ old('age', $patient->patient->age ?? '') }}" required>
                        <div class="invalid-feedback">Age is required</div>
                    </div>
                </div>

                <!-- Marital Status and Spouse Information -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="maritalStatus">Marital Status <span class="required">*</span></label>
                        <select class="form-control form-select" id="maritalStatus" name="marital_status_id" required>
                            <option value="">Select marital status</option>
                            @if(isset($maritalStatuses) && $maritalStatuses->count() > 0)
                                @foreach($maritalStatuses as $status)
                                    <option value="{{ $status->id }}" 
                                        {{ old('marital_status_id', $patient->patient->marital_status_id ?? '') == $status->id ? 'selected' : '' }}>
                                        {{ $status->status }}
                                    </option>
                                @endforeach
                            @else
                                <option value="1">Single</option>
                                <option value="2">Married</option>
                                <option value="3">Widowed</option>
                            @endif
                        </select>
                        <div class="invalid-feedback">Marital status is required</div>
                    </div>
                    
                    <div class="form-group">
                        <label for="spouseFName">Spouse First Name</label>
                        <input type="text" class="form-control" id="spouseFName" name="spouse_fname"
                            value="{{ old('spouse_fname', $patient->patient->spouse_fname ?? '') }}"
                            placeholder="Enter spouse first name">
                    </div>
                    
                    <div class="form-group">
                        <label for="spouseLName">Spouse Last Name</label>
                        <input type="text" class="form-control" id="spouseLName" name="spouse_lname"
                            value="{{ old('spouse_lname', $patient->patient->spouse_lname ?? '') }}"
                            placeholder="Enter spouse last name">
                    </div>
                </div>
            </div>

            <div class="form-section form-actions">
                <button type="button" class="btnn btn-secondary" onclick="proceedToCheckup()">
                    <i class="fas fa-arrow-right me-2"></i> Proceed to Checkup
                </button>
            </div>
        </div>

        <!-- Prenatal Checkup Section (Show if patient info is complete) -->
        <div class="form-card {{ $isPatientInfoIncomplete ? 'section-hidden' : '' }}" id="prenatalSection">
            <div class="form-header">
                <h5><i class="fas fa-plus me-2"></i>Add Prenatal Checkup Record</h5>
                <div class="header-actions">
                    @if($isPatientInfoIncomplete)
                        <button type="button" class="back-button" onclick="backToPatientInfo()">
                            <i class="fas fa-arrow-left me-2"></i> Back to Patient Info
                        </button>
                    @else
                        <a href="{{ route('currentPatients') }}" class="back-button">
                            <i class="fas fa-arrow-left me-2"></i> Back
                        </a>
                    @endif
                </div>
            </div>

            <div class="form-section">
                <div class="form-section-title"><i class="fas fa-calendar-check me-2"></i>Visit Information</div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="visitNumber">Visit Number <span class="required">*</span></label>
                        <input type="text" class="form-control" id="visitNumber_display"
                            value="{{ $nextVisitNumber }}{{ $nextVisitNumber == 1 ? 'st' : ($nextVisitNumber == 2 ? 'nd' : ($nextVisitNumber == 3 ? 'rd' : 'th')) }} Visit"
                            readonly>
                        <input type="hidden" name="visit_number" value="{{ $nextVisitNumber }}">
                        <div class="invalid-feedback">Visit number is required</div>
                    </div>
                    <div class="form-group">
                        <label for="visitDate">Date <span class="required">*</span></label>
                        <input type="date" class="form-control" id="visitDate" name="visit_date"
                            value="{{ now()->format('Y-m-d') }}" required>
                        <div class="invalid-feedback">Visit date is required</div>
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
                        <label for="nextVisit">Next Visit Date</label>
                        <input type="date" class="form-control" id="nextVisit" name="next_visit_date">
                        <div class="invalid-feedback">Next visit date is invalid</div>
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
                <div class="form-section-title"><i class="fas fa-baby me-2"></i>Pregnancy Details</div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="lmp">Last Menstrual Period</label>
                        <input type="date" class="form-control" id="lmp" name="lmp">
                        <div class="invalid-feedback">LMP is invalid</div>
                    </div>
                    <div class="form-group">
                        <label for="edc">Estimated Date of Confinement</label>
                        <input type="date" class="form-control" id="edc" name="edc">
                        <div class="invalid-feedback">EDC is invalid</div>
                    </div>
                    <div class="form-group">
                        <label for="aog">Age of Gestation - weeks</label>
                        <input type="text" class="form-control" id="aog" name="aog">
                        <div class="invalid-feedback">AOG is invalid</div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="gravida">Gravida <span class="required">*</span></label>
                        <input type="number" class="form-control" id="gravida" name="gravida" required>
                        <div class="invalid-feedback">Gravida is required</div>
                    </div>
                    <div class="form-group">
                        <label for="para">Para<span class="required">*</span></label>
                        <input type="number" class="form-control" id="para" name="para" required>
                        <div class="invalid-feedback">Para is required</div>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <div class="form-section-title"><i class="fas fa-heartbeat me-2"></i>Maternal Vital Signs & Physical Exam</div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="fht">Fetal Heart Tones - bpm</label>
                        <input type="number" class="form-control" id="fht" name="fht">
                        <div class="invalid-feedback">FHT is invalid</div>
                    </div>
                    <div class="form-group">
                        <label for="fh">Fundal Height - cm</label>
                        <input type="number" class="form-control" id="fh" name="fh">
                        <div class="invalid-feedback">FH is invalid</div>
                    </div>
                    <div class="form-group">
                        <label for="weight">Weight - kg</label>
                        <input type="number" class="form-control" id="weight" name="weight">
                        <div class="invalid-feedback">Weight is invalid</div>
                    </div>
                    <div class="form-group">
                        <label for="bloodPressure">Blood Pressure</label>
                        <input type="text" class="form-control" id="bloodPressure" name="blood_pressure">
                        <div class="invalid-feedback">Blood Pressure is invalid</div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="temperature">Temperature - °C</label>
                        <input type="number" class="form-control" id="temperature" name="temperature">
                        <div class="invalid-feedback">Temperature is invalid</div>
                    </div>
                    <div class="form-group">
                        <label for="respiratoryRate">Respiratory Rate</label>
                        <input type="number" class="form-control" id="respiratoryRate" name="respiratory_rate">
                        <div class="invalid-feedback">Respiratory Rate is invalid</div>
                    </div>
                    <div class="form-group">
                        <label for="pulseRate">Pulse Rate</label>
                        <input type="number" class="form-control" id="pulseRate" name="pulse_rate">
                        <div class="invalid-feedback">Pulse Rate is invalid</div>
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
                        <textarea class="form-control" id="remarks" name="remarks" rows="3"
                            placeholder="Enter remarks about this visit..."></textarea>
                        <div class="invalid-feedback">Remarks is invalid</div>
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

            <div class="form-section hidden-section" id="immunizationSection">
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

            <div class="form-section hidden-section" id="remarksSection">
                <div class="form-section-title">
                    <i class="fas fa-sticky-note me-2"></i>Immunization Remarks
                </div>
                <div class="form-row">
                    <div class="form-group" style="flex: 1 1 100%;">
                        <label for="immunizationNotes">Immunization Notes</label>
                        <textarea class="form-control" id="immunizationNotes" name="immunization_notes" rows="3"
                            placeholder="Enter notes about this immunization..."></textarea>
                    </div>
                </div>
            </div>

            <div class="form-section form-actions">
                <button type="submit" class="btnn btn-primary">
                    <i class="fas fa-save me-2"></i> Add Record
                </button>
               <button type="button" class="btnn btn-complete" onclick="confirmComplete()">
                    <i class="fas fa-check me-2"></i> Complete
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    const vaccines = @json($vaccines);
    const visitSlotsUrl = "{{ route('visits.availableSlots') }}";

    // Function to validate and proceed to checkup
    function proceedToCheckup() {
        const patientInfoSection = document.getElementById('patientInfoSection');
        const requiredFields = patientInfoSection.querySelectorAll('[required]');
        let isValid = true;
        let firstInvalidField = null;
        let missingFields = [];

        // Validate all required fields
        requiredFields.forEach(field => {
            const fieldName = field.getAttribute('name') || field.id;
            const label = field.closest('.form-group')?.querySelector('label')?.textContent.replace('*', '').trim() || fieldName;
            
            if (!field.value || field.value.trim() === '') {
                field.classList.add('is-invalid');
                isValid = false;
                missingFields.push(label);
                if (!firstInvalidField) {
                    firstInvalidField = field;
                }
            } else {
                field.classList.remove('is-invalid');
            }
        });

        // Validate phone number format
        const phoneField = document.getElementById('phone');
        if (phoneField && phoneField.value) {
            const phonePattern = /^09[0-9]{9}$/;
            if (!phonePattern.test(phoneField.value)) {
                phoneField.classList.add('is-invalid');
                isValid = false;
                if (!firstInvalidField) {
                    firstInvalidField = phoneField;
                }
            }
        }

        if (!isValid) {
            Swal.fire({
                title: 'Incomplete Information',
                html: `<p>Please fill in all required patient information fields:</p>
                       <ul style="text-align: left; margin: 10px 20px;">
                           ${missingFields.map(field => `<li>${field}</li>`).join('')}
                       </ul>`,
                icon: 'warning',
                confirmButtonColor: '#113F67',
            });
            
            if (firstInvalidField) {
                firstInvalidField.focus();
                firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            return;
        }

        // Hide patient info section, show prenatal section
        document.getElementById('patientInfoSection').classList.add('section-hidden');
        document.getElementById('prenatalSection').classList.remove('section-hidden');
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // Function to go back to patient info
    function backToPatientInfo() {
        document.getElementById('prenatalSection').classList.add('section-hidden');
        document.getElementById('patientInfoSection').classList.remove('section-hidden');
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // Remove invalid class on input
    document.querySelectorAll('.form-control, .form-select').forEach(field => {
        field.addEventListener('input', function() {
            if (this.value && this.value.trim() !== '') {
                this.classList.remove('is-invalid');
            }
        });
        
        field.addEventListener('change', function() {
            if (this.value && this.value.trim() !== '') {
                this.classList.remove('is-invalid');
            }
        });
    });

    // Set completed status
    function setCompleted() {
        document.getElementById('prenatalStatusId').value = '2';
    }

    // Debug: Log marital status data on page load
    document.addEventListener('DOMContentLoaded', function() {
        const maritalSelect = document.getElementById('maritalStatus');
        console.log('Marital Status Options:', maritalSelect.options.length);
        console.log('Marital Status HTML:', maritalSelect.innerHTML);
    });

    // ✅ Next Visit Time Slot Functionality
    const nextVisitBranch = document.getElementById('nextVisitBranch');
    const nextVisitDate = document.getElementById('nextVisit');
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

    // Add event listeners
    if (nextVisitBranch && nextVisitDate && nextVisitTime) {
        nextVisitBranch.addEventListener('change', fetchAvailableSlots);
        nextVisitDate.addEventListener('change', fetchAvailableSlots);
    }
</script>

<script src="{{ asset('script/staff/add-record.js') }}"></script>
@endsection
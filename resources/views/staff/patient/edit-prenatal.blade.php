@extends('layouts.staff.layout')

@section('title', 'Edit Prenatal Checkup Record - Letty\'s Birthing Home')
@section('page-title', 'Edit Record')

@section('content')

        <div class="container-fluid main-content">
            <div class="form-card" id="prenatalSection">
                <div class="form-header">
                    <h5>
                        <i class="fas fa-edit me-2"></i>
                        Edit Prenatal Checkup Record
                    </h5>
                    <div class="header-actions">
                        <a href="{{ route('currentPatients') }}" class="back-button">
                            <i class="fas fa-arrow-left me-2"></i> Back
                        </a>
                    </div>
                </div>

                <form method="POST" action="{{ route('patient.updateLatestVisit', $patient->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Visit Information --}}
                    <div class="form-section">
                        <div class="form-section-title">
                            <i class="fas fa-calendar-check me-2"></i>
                            Visit Information
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="visitNumber">Visit Number <span class="required">*</span></label>
                                @php
                                    $number = $latestVisitInfo->visit_number ?? 0;
                                    $suffix = match ($number) {
                                        1 => 'st',
                                        2 => 'nd',
                                        3 => 'rd',
                                        default => 'th',
                                    };
                                @endphp

                                <input type="text" class="form-control" id="visitNumber_display"
                                    value="{{ $number }}{{ $suffix }} Visit" readonly>
                                <input type="hidden" name="visit_number" value="{{ $number }}">


                                <div class="invalid-feedback">Visit number is required</div>
                            </div>

                            <div class="form-group">
                                <label for="visitDate">Date <span class="required">*</span></label>
                                <input type="date" class="form-control" id="visitDate" name="visit_date"
                                    value="{{ old('visit_date', $latestVisitInfo->visit_date ?? '') }}" required>
                                <div class="invalid-feedback">Visit date is required</div>
                            </div>
                        </div>


                        <div class="form-row">
                            <div class="form-group">
                                <label for="nextVisit">Next Visit Date</label>
                                <input type="date" class="form-control" id="nextVisit" name="next_visit_date"
                                    value="{{ old('next_visit_date', $latestVisitInfo->next_visit_date ?? '') }}">
                                <div class="invalid-feedback">Next visit date is invalid</div>
                            </div>
                            <div class="form-group">
                                <label for="nextVisitTime">Next Visit Time</label>
                                <input type="time" class="form-control" id="nextVisitTime" name="next_visit_time"
                                    value="{{ old('next_visit_time', $latestVisitInfo->next_visit_time ?? '') }}">
                                <div class="invalid-feedback">Next visit time is invalid</div>
                            </div>
                        </div>
                    </div>

                    {{-- Pregnancy Details --}}
                    <div class="form-section">
                        <div class="form-section-title">
                            <i class="fas fa-baby me-2"></i>
                            Pregnancy Details
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="lmp">LMP (Last Menstrual Period)</label>
                                <input type="date" class="form-control" id="lmp" name="lmp"
                                    value="{{ old('lmp', $latestPrenatal->lmp ?? '') }}">
                                <div class="invalid-feedback">LMP is invalid</div>
                            </div>
                            <div class="form-group">
                                <label for="edc">EDC (Estimated Date of Confinement)</label>
                                <input type="date" class="form-control" id="edc" name="edc"
                                    value="{{ old('edc', $latestPrenatal->edc ?? '') }}">
                                <div class="invalid-feedback">EDC is invalid</div>
                            </div>
                            <div class="form-group">
                                <label for="aog">AOG (Age of Gestation) - weeks</label>
                                <input type="text" class="form-control" id="aog" name="aog"
                                    value="{{ old('aog', $latestPrenatal->aog ?? '') }}">
                                <div class="invalid-feedback">AOG is invalid</div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="gravida">Gravida (G) <span class="required">*</span></label>
                                <input type="number" class="form-control" id="gravida" name="gravida"
                                    value="{{ old('gravida', $latestPrenatal->gravida ?? '') }}" required>
                                <div class="invalid-feedback">Gravida is required</div>
                            </div>
                            <div class="form-group">
                                <label for="para">Para (P) <span class="required">*</span></label>
                                <input type="number" class="form-control" id="para" name="para"
                                    value="{{ old('para', $latestPrenatal->para ?? '') }}" required>
                                <div class="invalid-feedback">Para is required</div>
                            </div>
                        </div>
                    </div>

                    {{-- Maternal Vitals --}}
                    <div class="form-section">
                        <div class="form-section-title">
                            <i class="fas fa-heartbeat me-2"></i>
                            Maternal Vital Signs & Physical Exam
                        </div>
                        @php
                            // Get latest maternal vitals
                            $vitals = $latestPrenatal->maternalVitals->sortByDesc('created_at')->first();
                        @endphp
                        <div class="form-row">
                            <div class="form-group">
                                <label for="fht">FHT (Fetal Heart Tones) - bpm</label>
                                <input type="number" class="form-control" id="fht" name="fht"
                                    value="{{ old('fht', $vitals->fht ?? '') }}">
                                <div class="invalid-feedback">FHT is invalid</div>
                            </div>
                            <div class="form-group">
                                <label for="fh">FH (Fundal Height) - cm</label>
                                <input type="number" class="form-control" id="fh" name="fh"
                                    value="{{ old('fh', $vitals->fh ?? '') }}">
                                <div class="invalid-feedback">FH is invalid</div>
                            </div>
                            <div class="form-group">
                                <label for="weight">WT (Weight) - kg</label>
                                <input type="number" class="form-control" id="weight" name="weight"
                                    value="{{ old('weight', $vitals->weight ?? '') }}">
                                <div class="invalid-feedback">Weight is invalid</div>
                            </div>
                            <div class="form-group">
                                <label for="bloodPressure">BP (Blood Pressure)</label>
                                <input type="text" class="form-control" id="bloodPressure" name="blood_pressure"
                                    value="{{ old('blood_pressure', $vitals->blood_pressure ?? '') }}">
                                <div class="invalid-feedback">Blood Pressure is invalid</div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="temperature">TEMP (Temperature) - °C</label>
                                <input type="number" class="form-control" id="temperature" name="temperature"
                                    value="{{ old('temperature', $vitals->temperature ?? '') }}">
                                <div class="invalid-feedback">Temperature is invalid</div>
                            </div>
                            <div class="form-group">
                                <label for="respiratoryRate">RR (Respiratory Rate)</label>
                                <input type="number" class="form-control" id="respiratoryRate"
                                    name="respiratory_rate"
                                    value="{{ old('respiratory_rate', $vitals->respiratory_rate ?? '') }}">
                                <div class="invalid-feedback">Respiratory Rate is invalid</div>
                            </div>
                            <div class="form-group">
                                <label for="pulseRate">PR (Pulse Rate)</label>
                                <input type="number" class="form-control" id="pulseRate" name="pulse_rate"
                                    value="{{ old('pulse_rate', $vitals->pulse_rate ?? '') }}">
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
                                    placeholder="Enter remarks about this visit...">{{ old('remarks', $latestPrenatal->remarks->notes ?? '') }}</textarea>

                                <div class="invalid-feedback">Remarks is invalid</div>
                            </div>
                        </div>
                    </div>

                    {{-- Form Actions --}}
                    <div class="form-section form-actions">
                        <button type="submit" class="btnn btn-primary">
                            <i class="fas fa-save me-2"></i> Update Record
                        </button>
                    </div>
                </form>
            </div>
        </div>


        <div id="emergency-container">
            @include('partials.emergencyModal')
        </div>
    </main>
 
    <script src="{{ asset('script/staff/edit-prenatal.js') }}"></script>
@endsection

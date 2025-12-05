@extends('layouts.staff.layout')

@section('title', 'Edit Postpartum Record - Letty\'s Birthing Home')
@section('page-title', 'Edit Record')

@section('content')
        <div class="container-fluid main-content">

            <form id="postpartumForm" method="POST" action="{{ route('updatePostpartum', $record->id) }}">
                @csrf
                @method('PUT')

                <div class="stage active" id="postpartumStage">
                    <div class="form-card">
                        <div class="form-header">
                            <h5><i class="fas fa-heart me-2"></i>Edit Postpartum Care</h5>
                            <div class="header-actions">
                                <a href="{{ url()->previous() }}" class="back-button">
                                    <i class="fas fa-arrow-left me-2"></i>Back
                                </a>
                            </div>
                        </div>

                        <!-- Maternal Vital Signs -->
                        <div class="form-section">
                            <div class="form-section-title">
                                <i class="fas fa-notes-medical me-2"></i>Postpartum Vital Signs
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="postpartum_bp">Blood Pressure (BP) <span
                                            class="required">*</span></label>
                                    <input type="text" class="form-control" id="postpartum_bp"
                                        name="postpartum_bp"
                                        value="{{ old('postpartum_bp', $record->postpartumRecord->postpartum_bp) }}"
                                        placeholder="e.g., 120/80 mmHg" required>
                                </div>
                                <div class="form-group">
                                    <label for="postpartum_temp">Temperature (TEMP) <span
                                            class="required">*</span></label>
                                    <input type="text" class="form-control" id="postpartum_temp"
                                        name="postpartum_temp"
                                        value="{{ old('postpartum_temp', $record->postpartumRecord->postpartum_temp) }}"
                                        placeholder="e.g., 36.6 °C" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="postpartum_rr">Respiratory Rate (RR) <span
                                            class="required">*</span></label>
                                    <input type="text" class="form-control" id="postpartum_rr"
                                        name="postpartum_rr"
                                        value="{{ old('postpartum_rr', $record->postpartumRecord->postpartum_rr) }}"
                                        placeholder="e.g., 16 breaths/min" required>
                                </div>
                                <div class="form-group">
                                    <label for="postpartum_pr">Pulse Rate (PR) <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="postpartum_pr"
                                        name="postpartum_pr"
                                        value="{{ old('postpartum_pr', $record->postpartumRecord->postpartum_pr) }}"
                                        placeholder="e.g., 80 bpm" required>
                                </div>
                            </div>
                        </div>

                        <!-- Newborn Data -->
                        <div class="form-section">
                            <div class="form-section-title"><i class="fas fa-ruler me-2"></i>Newborn Data</div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="newborn_weight">Weight (WT) <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="newborn_weight"
                                        name="newborn_weight"
                                        value="{{ old('newborn_weight', $record->postpartumRecord->newborn_weight) }}"
                                        placeholder="e.g., 3.2 kg" required>
                                </div>
                                <div class="form-group">
                                    <label for="newborn_hc">Head Circumference (HC) <span
                                            class="required">*</span></label>
                                    <input type="text" class="form-control" id="newborn_hc" name="newborn_hc"
                                        value="{{ old('newborn_hc', $record->postpartumRecord->newborn_hc) }}"
                                        placeholder="e.g., 34 cm" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="newborn_cc">Chest Circumference (CC) <span
                                            class="required">*</span></label>
                                    <input type="text" class="form-control" id="newborn_cc" name="newborn_cc"
                                        value="{{ old('newborn_cc', $record->postpartumRecord->newborn_cc) }}"
                                        placeholder="e.g., 32 cm" required>
                                </div>
                                <div class="form-group">
                                    <label for="newborn_ac">Abdominal Circumference (AC) <span
                                            class="required">*</span></label>
                                    <input type="text" class="form-control" id="newborn_ac" name="newborn_ac"
                                        value="{{ old('newborn_ac', $record->postpartumRecord->newborn_ac) }}"
                                        placeholder="e.g., 30 cm" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="newborn_length">Length (L) <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="newborn_length"
                                        name="newborn_length"
                                        value="{{ old('newborn_length', $record->postpartumRecord->newborn_length) }}"
                                        placeholder="e.g., 50 cm" required>
                                </div>
                            </div>
                        </div>

                        <!-- Remarks -->
                        <div class="form-section">
                            <div class="form-section-title">
                                <i class="fas fa-sticky-note me-2"></i>Remarks
                            </div>
                            <div class="form-row">
                                <div class="form-group" style="flex: 1 1 100%;">
                                    <label for="remarks">Notes / Remarks</label>
                                    <textarea class="form-control" id="remarks" name="remarks" rows="3"
                                        placeholder="Enter remarks about this visit...">{{ old('remarks', $record->postpartumRecord->remarks->notes ?? '') }}</textarea>
                                    <div class="invalid-feedback">Remarks is invalid</div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="form-section form-actions">
                            <button type="submit" class="btnn">
                                <i class="fas fa-save me-2"></i>Update Record
                            </button>
                        </div>

                    </div>
                </div>
            </form>
        </div>

    </main>

     <script src="{{ asset('script/staff/edit-postpartum.js') }}"></script>
@endsection

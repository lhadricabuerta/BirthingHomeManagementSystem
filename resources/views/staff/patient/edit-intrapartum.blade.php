@extends('layouts.staff.layout')

@section('title', 'Edit Intrapartum Record - Letty\'s Birthing Home')
@section('page-title', 'Edit Record')

@section('content')
        <div class="container-fluid main-content">
            <form id="birthingForm" action="{{ route('updateIntrapartum', $record->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="stage active" id="intrapartumStage">
                    <div class="form-card">
                        <div class="form-header">
                            <h5><i class="fas fa-baby me-2"></i>Update Intrapartum Record</h5>
                            <div class="header-actions">
                                <a href="{{ url()->previous() }}" class="back-button">
                                    <i class="fas fa-arrow-left me-2"></i>Back
                                </a>
                            </div>
                        </div>

                        <!-- Maternal Vital Signs -->
                        <div class="form-section">
                            <div class="form-section-title">
                                <i class="fas fa-notes-medical me-2"></i>Maternal Vital Signs During Labor
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="bp">Blood Pressure <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="bp" name="bp"
                                        value="{{ old('bp', $record->intrapartumRecord->bp ?? '') }}"
                                        placeholder="e.g., 120/80 mmHg" required>
                                </div>
                                <div class="form-group">
                                    <label for="temp">Temperature <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="temp" name="temp"
                                        value="{{ old('temp', $record->intrapartumRecord->temp ?? '') }}"
                                        placeholder="e.g., 36.6 °C" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="rr">Respiratory Rate <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="rr" name="rr"
                                        value="{{ old('rr', $record->intrapartumRecord->rr ?? '') }}"
                                        placeholder="e.g., 16 breaths/min" required>
                                </div>
                                <div class="form-group">
                                    <label for="pr">Pulse Rate <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="pr" name="pr"
                                        value="{{ old('pr', $record->intrapartumRecord->pr ?? '') }}"
                                        placeholder="e.g., 80 bpm" required>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Assessments -->
                        <div class="form-section">
                            <div class="form-section-title"><i class="fas fa-stethoscope me-2"></i>Additional
                                Assessments</div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="fundic_height">Fundic Height <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="fundic_height"
                                        name="fundic_height"
                                        value="{{ old('fundic_height', $record->intrapartumRecord->fundic_height ?? '') }}"
                                        placeholder="e.g., 32 cm" required>
                                </div>
                                <div class="form-group">
                                    <label for="fetal_heart_tone">Fetal Heart Tone <span
                                            class="required">*</span></label>
                                    <input type="text" class="form-control" id="fetal_heart_tone"
                                        name="fetal_heart_tone"
                                        value="{{ old('fetal_heart_tone', $record->intrapartumRecord->fetal_heart_tone ?? '') }}"
                                        placeholder="e.g., 140 bpm" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="internal_exam">Internal Exam (IE: Dilatation, Effacement, Station)
                                        <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="internal_exam"
                                        name="internal_exam"
                                        value="{{ old('internal_exam', $record->intrapartumRecord->internal_exam ?? '') }}"
                                        placeholder="e.g., 4 cm, 50%, 0" required>
                                </div>
                                <div class="form-group">
                                    <label for="bag_of_water">Bag of Water <span class="required">*</span></label>
                                    <select class="form-select" id="bag_of_water" name="bag_of_water" required>
                                        <option value="" disabled>Select status</option>
                                        <option value="intact"
                                            {{ old('bag_of_water', $record->intrapartumRecord->bag_of_water ?? '') == 'intact' ? 'selected' : '' }}>
                                            Intact</option>
                                        <option value="ruptured"
                                            {{ old('bag_of_water', $record->intrapartumRecord->bag_of_water ?? '') == 'ruptured' ? 'selected' : '' }}>
                                            Ruptured</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Delivery Details -->
                        <div class="form-section">
                            <div class="form-section-title"><i class="fas fa-baby-carriage me-2"></i>Delivery Details
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="baby_delivered">Baby Delivered <span class="required">*</span></label>
                                    <select class="form-select" id="baby_delivered" name="baby_delivered" required>
                                        <option value="" disabled>Select status</option>
                                        <option value="yes"
                                            {{ old('baby_delivered', $record->intrapartumRecord->baby_delivered ?? '') == 'yes' ? 'selected' : '' }}>
                                            Yes</option>
                                        <option value="no"
                                            {{ old('baby_delivered', $record->intrapartumRecord->baby_delivered ?? '') == 'no' ? 'selected' : '' }}>
                                            No</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="placenta_delivered">Placenta Delivered <span
                                            class="required">*</span></label>
                                    <select class="form-select" id="placenta_delivered" name="placenta_delivered"
                                        required>
                                        <option value="" disabled>Select status</option>
                                        <option value="yes"
                                            {{ old('placenta_delivered', $record->intrapartumRecord->placenta_delivered ?? '') == 'yes' ? 'selected' : '' }}>
                                            Yes</option>
                                        <option value="no"
                                            {{ old('placenta_delivered', $record->intrapartumRecord->placenta_delivered ?? '') == 'no' ? 'selected' : '' }}>
                                            No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="baby_sex">Baby's Sex <span class="required">*</span></label>
                                    <select class="form-select" id="baby_sex" name="baby_sex" required>
                                        <option value="" disabled>Select sex</option>
                                        <option value="male"
                                            {{ old('baby_sex', $record->intrapartumRecord->baby_sex ?? '') == 'male' ? 'selected' : '' }}>
                                            Male</option>
                                        <option value="female"
                                            {{ old('baby_sex', $record->intrapartumRecord->baby_sex ?? '') == 'female' ? 'selected' : '' }}>
                                            Female</option>
                                    </select>
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
                                        placeholder="Enter remarks about this visit...">{{ old('remarks', $record->intrapartumRecord->remarks->notes ?? '') }}</textarea>
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

    <script src="{{ asset('script/staff/edit-intrapartum.js') }}"></script>
@endsection

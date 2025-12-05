@extends('layouts.staff.layout')

@section('title', 'Edit Baby Registration Record - Letty\'s Birthing Home')
@section('page-title', 'Edit Record')

@section('content')
        <div class="container-fluid main-content">

            <form id="babyRegistrationForm" class="needs-validation" novalidate method="POST"
                action="{{ route('updateRegistration', $record->id) }}">
                @csrf
                @method('PUT')


                <div class="stage active" id="registrationStage">
                    <div class="form-card">
                        <div class="form-header">
                            <h5><i class="fas fa-clipboard-list me-2"></i>
                                {{ isset($babyRegistration) ? 'Edit Baby Registration' : 'Baby Registration' }}
                            </h5>
                        </div>

                        <!-- Baby Information -->
                        <div class="form-section">
                            <div class="form-section-title"><i class="fas fa-file-alt me-2"></i>Baby Information</div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="baby_first_name">First Name <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="baby_first_name"
                                        name="baby_first_name"
                                        value="{{ old('baby_first_name', $babyRegistration->baby_first_name ?? '') }}"
                                        placeholder="First Name" required>
                                    <div class="invalid-feedback">First Name is required</div>
                                </div>
                                <div class="form-group">
                                    <label for="baby_middle_name">Middle Name</label>
                                    <input type="text" class="form-control" id="baby_middle_name"
                                        name="baby_middle_name"
                                        value="{{ old('baby_middle_name', $babyRegistration->baby_middle_name ?? '') }}"
                                        placeholder="Middle Name">
                                </div>
                                <div class="form-group">
                                    <label for="baby_last_name">Last Name <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="baby_last_name"
                                        name="baby_last_name"
                                        value="{{ old('baby_last_name', $babyRegistration->baby_last_name ?? '') }}"
                                        placeholder="Last Name" required>
                                    <div class="invalid-feedback">Last Name is required</div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="sex">Sex <span class="required">*</span></label>
                                    <select class="form-select" id="sex" name="sex" required>
                                        <option value="" disabled
                                            {{ old('sex', $babyRegistration->sex ?? '') == '' ? 'selected' : '' }}>
                                            Select sex</option>
                                        <option value="male"
                                            {{ old('sex', $babyRegistration->sex ?? '') == 'male' ? 'selected' : '' }}>
                                            Male</option>
                                        <option value="female"
                                            {{ old('sex', $babyRegistration->sex ?? '') == 'female' ? 'selected' : '' }}>
                                            Female</option>
                                    </select>
                                    <div class="invalid-feedback">Sex is required</div>
                                </div>
                                <div class="form-group">
                                    <label for="date_of_birth">Date of Birth <span class="required">*</span></label>
                                    <input type="date" class="form-control" id="date_of_birth"
                                        name="date_of_birth"
                                        value="{{ old('date_of_birth', $babyRegistration->date_of_birth ?? '') }}"
                                        required>
                                    <div class="invalid-feedback">Date of Birth is required</div>
                                </div>
                                <div class="form-group">
                                    <label for="time_of_birth">Time of Birth <span class="required">*</span></label>
                                    <input type="time" class="form-control" id="time_of_birth"
                                        name="time_of_birth"
                                        value="{{ old('time_of_birth', $babyRegistration->time_of_birth ?? '') }}"
                                        required>
                                    <div class="invalid-feedback">Time of Birth is required</div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="place_of_birth">Place of Birth <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="place_of_birth"
                                        name="place_of_birth"
                                        value="{{ old('place_of_birth', $babyRegistration->place_of_birth ?? '') }}"
                                        placeholder="Place of Birth" required>
                                    <div class="invalid-feedback">Place of Birth is required</div>
                                </div>
                                <div class="form-group">
                                    <label for="type_of_birth">Type of Birth <span class="required">*</span></label>
                                    <select class="form-select" id="type_of_birth" name="type_of_birth" required>
                                        <option value="" disabled
                                            {{ old('type_of_birth', $babyRegistration->type_of_birth ?? '') == '' ? 'selected' : '' }}>
                                            Select type</option>
                                        <option value="single"
                                            {{ old('type_of_birth', $babyRegistration->type_of_birth ?? '') == 'single' ? 'selected' : '' }}>
                                            Single</option>
                                        <option value="twin"
                                            {{ old('type_of_birth', $babyRegistration->type_of_birth ?? '') == 'twin' ? 'selected' : '' }}>
                                            Twin</option>
                                        <option value="triplet"
                                            {{ old('type_of_birth', $babyRegistration->type_of_birth ?? '') == 'triplet' ? 'selected' : '' }}>
                                            Triplet, etc.</option>
                                    </select>
                                    <div class="invalid-feedback">Type of Birth is required</div>
                                </div>
                                <div class="form-group">
                                    <label for="birth_order">Birth Order</label>
                                    <input type="text" class="form-control" id="birth_order" name="birth_order"
                                        value="{{ old('birth_order', $babyRegistration->birth_order ?? '') }}"
                                        placeholder="Birth Order">
                                </div>
                                <div class="form-group">
                                    <label for="weight_at_birth">Weight at Birth <span
                                            class="required">*</span></label>
                                    <input type="text" class="form-control" id="weight_at_birth"
                                        name="weight_at_birth"
                                        value="{{ old('weight_at_birth', $babyRegistration->weight_at_birth ?? '') }}"
                                        placeholder="Weight in grams" required>
                                    <div class="invalid-feedback">Weight at Birth is required</div>
                                </div>
                            </div>
                        </div>

                        <!-- Mother’s Info -->
                        <div class="form-section">
                            <div class="form-section-title"><i class="fas fa-user me-2"></i>Mother's Information</div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="mother_maiden_first_name">Maiden First Name <span
                                            class="required">*</span></label>
                                    <input type="text" class="form-control" id="mother_maiden_first_name"
                                        name="mother_maiden_first_name"
                                        value="{{ old('mother_maiden_first_name', $mother->patient->client->first_name ?? ($motherInfo['first_name'] ?? '')) }}"
                                        placeholder="First Name" required>
                                    <div class="invalid-feedback">Maiden First Name is required</div>
                                </div>
                                <div class="form-group">
                                    <label for="mother_maiden_middle_name">Maiden Middle Name</label>
                                    <input type="text" class="form-control" id="mother_maiden_middle_name"
                                        name="mother_maiden_middle_name"
                                        value="{{ old('mother_maiden_middle_name', $mother->maiden_middle_name ?? '') }}"
                                        placeholder="Middle Name">
                                </div>
                                <div class="form-group">
                                    <label for="mother_maiden_last_name">Maiden Last Name <span
                                            class="required">*</span></label>
                                    <input type="text" class="form-control" id="mother_maiden_last_name"
                                        name="mother_maiden_last_name"
                                        value="{{ old('mother_maiden_last_name', $mother->patient->client->last_name ?? ($motherInfo['last_name'] ?? '')) }}"
                                        placeholder="Last Name" required>
                                    <div class="invalid-feedback">Maiden Last Name is required</div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="mother_citizenship">Citizenship</label>
                                    <input type="text" class="form-control" id="mother_citizenship"
                                        name="mother_citizenship"
                                        value="{{ old('mother_citizenship', $mother->citizenship ?? '') }}"
                                        placeholder="Citizenship">
                                </div>
                                <div class="form-group">
                                    <label for="mother_religion">Religion</label>
                                    <input type="text" class="form-control" id="mother_religion"
                                        name="mother_religion"
                                        value="{{ old('mother_religion', $mother->religion ?? '') }}"
                                        placeholder="Religion">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="mother_total_children_alive">Total No. of Children Born Alive</label>
                                    <input type="number" class="form-control" id="mother_total_children_alive"
                                        name="mother_total_children_alive"
                                        value="{{ old('mother_total_children_alive', $mother->total_children_alive ?? '') }}"
                                        min="0">
                                </div>
                                <div class="form-group">
                                    <label for="mother_children_still_living">No. of Children Still Living</label>
                                    <input type="number" class="form-control" id="mother_children_still_living"
                                        name="mother_children_still_living"
                                        value="{{ old('mother_children_still_living', $mother->children_still_living ?? '') }}"
                                        min="0">
                                </div>
                                <div class="form-group">
                                    <label for="mother_children_deceased">No. of Children Born Alive but Now
                                        Deceased</label>
                                    <input type="number" class="form-control" id="mother_children_deceased"
                                        name="mother_children_deceased"
                                        value="{{ old('mother_children_deceased', $mother->children_deceased ?? '') }}"
                                        min="0">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="mother_occupation">Occupation</label>
                                    <input type="text" class="form-control" id="mother_occupation"
                                        name="mother_occupation"
                                        value="{{ old('mother_occupation', $mother->occupation ?? '') }}"
                                        placeholder="Occupation">
                                </div>
                                <div class="form-group">
                                    <label for="mother_age">Age <span class="required">*</span></label>
                                    <input type="number" class="form-control" id="mother_age" name="mother_age"
                                        value="{{ old('mother_age', $patient->age ?? '') }}" placeholder="Age"
                                        min="0" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="mother_address">Address <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="mother_address"
                                        name="mother_address"
                                        value="{{ old('mother_address', $client->full_address ?? '') }}"
                                        placeholder="Village, City/Municipality, Province" required>
                                </div>
                            </div>
                        </div>

                        <!-- Father’s Info -->
                        <div class="form-section">
                            <div class="form-section-title"><i class="fas fa-user-tie me-2"></i>Father's Information
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="spouse_fname">First Name <span class="required">*</span></label>
                                    <input type="text" name="spouse_fname"
                                        value="{{ old('spouse_fname', $patient->spouse_fname ?? '') }}"
                                        placeholder="First Name" class="form-control" id="spouse_fname" required>
                                    <div class="invalid-feedback">First Name is required</div>
                                </div>
                                <div class="form-group">
                                    <label for="father_middle_name">Middle Name</label>
                                    <input type="text" class="form-control" id="father_middle_name"
                                        name="father_middle_name"
                                        value="{{ old('father_middle_name', $father->middle_name ?? '') }}"
                                        placeholder="Middle Name">
                                </div>
                                <div class="form-group">
                                    <label for="spouse_lname">Last Name <span class="required">*</span></label>
                                    <input type="text" name="spouse_lname"
                                        value="{{ old('spouse_lname', $patient->spouse_lname ?? '') }}"
                                        placeholder="Last Name" class="form-control" id="spouse_lname" required>
                                    <div class="invalid-feedback">Last Name is required</div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="father_citizenship">Citizenship <span
                                            class="required">*</span></label>
                                    <input type="text" class="form-control" id="father_citizenship"
                                        name="father_citizenship"
                                        value="{{ old('father_citizenship', $father->citizenship ?? '') }}"
                                        placeholder="Citizenship">
                                </div>
                                <div class="form-group">
                                    <label for="father_religion">Religion</label>
                                    <input type="text" class="form-control" id="father_religion"
                                        name="father_religion"
                                        value="{{ old('father_religion', $father->religion ?? '') }}"
                                        placeholder="Religion">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="father_occupation">Occupation <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="father_occupation"
                                        name="father_occupation"
                                        value="{{ old('father_occupation', $father->occupation ?? '') }}"
                                        placeholder="Occupation">
                                </div>
                                <div class="form-group">
                                    <label for="father_age">Age <span class="required">*</span></label>
                                    <input type="number" class="form-control" id="father_age" name="father_age"
                                        value="{{ old('father_age', $father->age ?? '') }}" placeholder="Age"
                                        min="0">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="father_address">Address <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="father_address"
                                        name="father_address"
                                        value="{{ old('father_address', $father->address ?? '') }}"
                                        placeholder="Address">
                                </div>
                            </div>
                        </div>

                        <!-- Marriage Info -->
                        <div class="form-section">
                            <div class="form-section-title"><i class="fas fa-ring me-2"></i>Marriage Information</div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="marriage_date">Date of Marriage</label>
                                    <input type="date" class="form-control" id="marriage_date"
                                        name="marriage_date"
                                        value="{{ old('marriage_date', $additional->marriage_date ?? '') }}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="marriage_place">Place of Marriage</label>
                                    <input type="text" class="form-control" id="marriage_place"
                                        name="marriage_place"
                                        value="{{ old('marriage_place', $additional->marriage_place ?? '') }}"
                                        placeholder="Enter Place">
                                </div>
                            </div>
                        </div>

                        <!-- Additional Info -->
                        <div class="form-section">
                            <div class="form-section-title"><i class="fas fa-user-md me-2"></i>Additional Information
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="birth_attendant">Birth Attendant</label>
                                    <input type="text" class="form-control" id="birth_attendant"
                                        name="birth_attendant"
                                        value="{{ old('birth_attendant', $additional->birth_attendant ?? '') }}"
                                        placeholder="Name">
                                </div>
                            </div>
                        </div>


                        <!-- Actions -->
                        <div class="form-section form-actions">
                            <button type="submit" class="btnn">
                                <i
                                    class="fas fa-save me-2"></i>{{ isset($babyRegistration) ? 'Update Record' : 'Save Record' }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </main>

   <script src="{{ asset('script/staff/edit-registration.js') }}"></script>
@endsection


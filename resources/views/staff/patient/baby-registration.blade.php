@extends('layouts.staff.layout')

@section('title', 'Baby Registration - Letty\'s Birthing Home')
@section('page-title', 'Baby Registration')

@section('content')
        <div class="container-fluid main-content">
           
            <form id="babyRegistrationForm" class="needs-validation" novalidate method="POST"
                action="{{ route('storeBabyRegistration', $delivery->id) }}">
                @csrf
                <div class="stage active" id="registrationStage">
                    <div class="form-card">
                        <div class="form-header">
                            <h5><i class="fas fa-clipboard-list me-2"></i>Baby Registration</h5>
                        </div>

                        {{-- Baby Information --}}
                        <div class="form-section">
                            <div class="form-section-title"><i class="fas fa-file-alt me-2"></i>Baby Information</div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="baby_first_name">First Name <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="baby_first_name"
                                        name="baby_first_name" placeholder="First Name" required>
                                    <div class="invalid-feedback">First Name is required</div>
                                </div>
                                <div class="form-group">
                                    <label for="baby_middle_name">Middle Name</label>
                                    <input type="text" class="form-control" id="baby_middle_name"
                                        name="baby_middle_name" placeholder="Middle Name">
                                </div>
                                <div class="form-group">
                                    <label for="baby_last_name">Last Name <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="baby_last_name"
                                        name="baby_last_name" placeholder="Last Name" required>
                                    <div class="invalid-feedback">Last Name is required</div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="sex">Sex <span class="required">*</span></label>
                                    <select class="form-select" id="sex" name="sex" required>
                                        <option value="" disabled selected>Select sex</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                    <div class="invalid-feedback">Sex is required</div>
                                </div>
                                <div class="form-group">
                                    <label for="date_of_birth">Date of Birth <span class="required">*</span></label>
                                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"
                                        required>
                                    <div class="invalid-feedback">Date of Birth is required</div>
                                </div>
                                <div class="form-group">
                                    <label for="time_of_birth">Time of Birth <span class="required">*</span></label>
                                    <input type="time" class="form-control" id="time_of_birth" name="time_of_birth"
                                        required>
                                    <div class="invalid-feedback">Time of Birth is required</div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="place_of_birth">Place of Birth <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="place_of_birth"
                                        name="place_of_birth" placeholder="Place of Birth" required>
                                    <div class="invalid-feedback">Place of Birth is required</div>
                                </div>
                                <div class="form-group">
                                    <label for="type_of_birth">Type of Birth <span class="required">*</span></label>
                                    <select class="form-select" id="type_of_birth" name="type_of_birth" required>
                                        <option value="" disabled selected>Select type</option>
                                        <option value="single">Single</option>
                                        <option value="twin">Twin</option>
                                        <option value="triplet">Triplet, etc.</option>
                                    </select>
                                    <div class="invalid-feedback">Type of Birth is required</div>
                                </div>
                                <div class="form-group">
                                    <label for="birth_order">Birth Order</label>
                                    <input type="text" class="form-control" id="birth_order" name="birth_order"
                                        placeholder="Birth Order">
                                </div>
                                <div class="form-group">
                                    <label for="weight_at_birth">Weight at Birth <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="weight_at_birth"
                                        name="weight_at_birth" placeholder="Weight in grams" required>
                                    <div class="invalid-feedback">Weight at Birth is required</div>
                                </div>
                            </div>
                        </div>

                        {{-- Mother’s Info --}}
                        <div class="form-section">
                            <div class="form-section-title">
                                <i class="fas fa-user me-2"></i>Mother's Information
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="mother_maiden_first_name">Maiden First Name <span
                                            class="required">*</span></label>
                                    <input type="text" class="form-control" id="mother_maiden_first_name"
                                        name="mother_maiden_first_name"
                                        value="{{ old('mother_maiden_first_name', $motherInfo['first_name'] ?? '') }}"
                                        placeholder="First Name" required>
                                    <div class="invalid-feedback">Maiden First Name is required</div>
                                </div>

                                <div class="form-group">
                                    <label for="mother_maiden_middle_name">Maiden Middle Name</label>
                                    <input type="text" class="form-control" id="mother_maiden_middle_name"
                                        name="mother_maiden_middle_name" placeholder="Middle Name">
                                </div>

                                <div class="form-group">
                                    <label for="mother_maiden_last_name">Maiden Last Name <span
                                            class="required">*</span></label>
                                    <input type="text" class="form-control" id="mother_maiden_last_name"
                                        name="mother_maiden_last_name"
                                        value="{{ old('mother_maiden_last_name', $motherInfo['last_name'] ?? '') }}"
                                        placeholder="Last Name" required>
                                    <div class="invalid-feedback">Maiden Last Name is required</div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="mother_citizenship">Citizenship <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="mother_citizenship"
                                        name="mother_citizenship" placeholder="Citizenship" required>
                                    <div class="invalid-feedback">Citizenship is required</div>
                                </div>

                                <div class="form-group">
                                    <label for="mother_religion">Religion</label>
                                    <input type="text" class="form-control" id="mother_religion"
                                        name="mother_religion" value="{{ old('mother_religion') }}"
                                        placeholder="Religion">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="mother_total_children_alive">Total No. of Children Born Alive <span
                                            class="required">*</span></label>
                                    <input type="number" class="form-control" id="mother_total_children_alive"
                                        name="mother_total_children_alive" placeholder="Number" min="0"
                                        required>
                                    <div class="invalid-feedback">Total No. of Children is required</div>
                                </div>

                                <div class="form-group">
                                    <label for="mother_children_still_living">No. of Children Still Living <span
                                            class="required">*</span></label>
                                    <input type="number" class="form-control" id="mother_children_still_living"
                                        name="mother_children_still_living" placeholder="Number" min="0"
                                        required>
                                    <div class="invalid-feedback">No. of Children Still Living is required</div>
                                </div>

                                <div class="form-group">
                                    <label for="mother_children_deceased">No. of Children Born Alive but Now Deceased</label>
                                    <input type="number" class="form-control" id="mother_children_deceased"
                                        name="mother_children_deceased" placeholder="Number" min="0">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="mother_occupation">Occupation <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="mother_occupation"
                                        name="mother_occupation" placeholder="Occupation" required>
                                    <div class="invalid-feedback">Occupation is required</div>
                                </div>

                                <div class="form-group">
                                    <label for="mother_age">Age <span class="required">*</span></label>
                                    <input type="number" class="form-control" id="mother_age" name="mother_age"
                                        value="{{ old('mother_age', $motherInfo['age'] ?? '') }}" placeholder="Age"
                                        min="0" required>
                                    <div class="invalid-feedback">Age is required</div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="mother_address">Address <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="mother_address"
                                        name="mother_address"
                                        value="{{ old('mother_address', $motherInfo['full_address'] ?? '') }}"
                                        placeholder="Village, City/Municipality, Province" required>
                                    <div class="invalid-feedback">Address is required</div>
                                </div>
                            </div>
                        </div>

                        {{-- Father’s Info --}}
                        <div class="form-section">
                            <div class="form-section-title"><i class="fas fa-user-tie me-2"></i>Father's Information
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="spouse_fname">First Name <span class="required">*</span></label>
                                    <input type="text" name="spouse_fname"
                                        value="{{ old('spouse_fname', optional($delivery->patient)->spouse_fname) }}"
                                        placeholder="First Name" class="form-control" id="spouse_fname" required>
                                    <div class="invalid-feedback">First Name is required</div>
                                </div>
                                <div class="form-group">
                                    <label for="father_middle_name">Middle Name</label>
                                    <input type="text" class="form-control" id="father_middle_name"
                                        name="father_middle_name" placeholder="Middle Name">
                                </div>
                                <div class="form-group">
                                    <label for="spouse_lname">Last Name <span class="required">*</span></label>
                                    <input type="text" name="spouse_lname"
                                        value="{{ old('spouse_lname', optional($delivery->patient)->spouse_lname) }}"
                                        placeholder="Last Name" class="form-control" id="spouse_lname" required>
                                    <div class="invalid-feedback">Last Name is required</div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="father_citizenship">Citizenship <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="father_citizenship"
                                        name="father_citizenship" placeholder="Citizenship" required>
                                    <div class="invalid-feedback">Citizenship is required</div>
                                </div>
                                <div class="form-group">
                                    <label for="father_religion">Religion</label>
                                    <input type="text" class="form-control" id="father_religion"
                                        name="father_religion" placeholder="Religion">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="father_occupation">Occupation <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="father_occupation"
                                        name="father_occupation" placeholder="Occupation" required>
                                    <div class="invalid-feedback">Occupation is required</div>
                                </div>
                                <div class="form-group">
                                    <label for="father_age">Age <span class="required">*</span></label>
                                    <input type="number" class="form-control" id="father_age" name="father_age"
                                        placeholder="Age" min="0" required>
                                    <div class="invalid-feedback">Age is required</div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="father_address">Address <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="father_address"
                                        name="father_address" placeholder="Address" required>
                                    <div class="invalid-feedback">Address is required</div>
                                </div>
                            </div>
                        </div>

                        {{-- Marriage Info --}}
                        <div class="form-section">
                            <div class="form-section-title"><i class="fas fa-ring me-2"></i>Marriage Information</div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="marriage_date">Date of Marriage <span
                                            class="required">*</span></label>
                                    <input type="date" class="form-control" id="marriage_date"
                                        name="marriage_date" required>
                                    <div class="invalid-feedback">Date of Marriage is required</div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="marriage_place">Place of Marriage <span
                                            class="required">*</span></label>
                                    <input type="text" class="form-control" id="marriage_place"
                                        name="marriage_place" placeholder="Enter Place" required>
                                    <div class="invalid-feedback">Place of Marriage is required</div>
                                </div>
                            </div>
                        </div>

                        {{-- Additional Info --}}
                        <div class="form-section">
                            <div class="form-section-title"><i class="fas fa-user-md me-2"></i>Additional Information
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="birth_attendant">Birth Attendant <span
                                            class="required">*</span></label>
                                    <input type="text" class="form-control" id="birth_attendant"
                                        name="birth_attendant" placeholder="Name" required>
                                    <div class="invalid-feedback">Birth Attendant is required</div>
                                </div>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="form-section form-actions">
                            <button type="submit" class="btnn">
                                <i class="fas fa-save me-2"></i>Save Record
                            </button>
                           
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>

 
   <script src="{{ asset('script/staff/baby-registration.js') }}"></script>
@endsection


@extends('layouts.admin.layout')

@section('title', 'Patient Pdf Records - Letty\'s Birthing Home')
@section('page-title', 'Records Management')

@section('content')

    <div class="container-fluid main-content">
        <div class="visits-card">
            <div class="visits-header">
                <h5>
                 <i class="fas fa-user me-2"></i>{{ $patient->first_name }} {{ $patient->last_name }}
                </h5>
            </div>

            <div class="search-filter-section">
                <!-- Search Box -->
                <div class="search-box">
                    <input type="text" id="searchInputVisits" placeholder="Search records..." oninput="applyFilters()">
                    <i class="fas fa-search search-icon"></i>
                </div>

                <!-- Record Type Dropdown -->
                <div class="filter-dropdown">
                    <button class="filter-btn" onclick="toggleFilter('recordTypeFilter')">
                        <span id="selectedRecordType">Record For</span>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </button>
                    <div class="filter-dropdown-menu" id="recordTypeFilter">
                        <div class="filter-option selected" onclick="setRecordType('all')">All Records</div>
                        <div class="filter-option" onclick="setRecordType('prenatal')">Prenatal Visit</div>
                        <div class="filter-option" onclick="setRecordType('registration')">Baby Registration</div>
                        <div class="filter-option" onclick="setRecordType('intrapartum')">Intrapartum</div>
                        <div class="filter-option" onclick="setRecordType('postpartum')">Postpartum</div>
                    </div>
                </div>

                <!-- Date Filter -->
                <div class="filter-dropdown">
                    <button class="filter-btn" onclick="toggleFilter('dateFilterVisits')">
                        <span>Visit Year</span>
                        <div class="d-flex align-items-center">
                            <span id="dateFilterCountVisits" class="filter-count" style="display: none;">0</span>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </button>
                    <div class="filter-dropdown-menu" id="dateFilterVisits">
                        <div class="filter-option selected" onclick="setDateFilter('all')">All Dates</div>
                        <div class="filter-option" onclick="setDateFilter('2025')">2025</div>
                        <div class="filter-option" onclick="setDateFilter('2024')">2024</div>
                        <div class="filter-option" onclick="setDateFilter('2023')">2023</div>
                    </div>
                </div>

                <button class="clear-filters-btn" id="clearFiltersBtnVisits" style="display: none;"
                    onclick="clearAllFilters()">
                    Clear Filters
                </button>
            </div>

          <div class="table-container">
            <table class="visits-table" id="visitsTable">
                <thead>
                    <tr>
                        <th>Visit Date</th>
                        <th>Attending Midwife</th>
                        <th>Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($allPatientPdfRecords as $record)
                        @php
                            if ($record->intrapartumRecord) {
                                $type = 'Intrapartum';
                                $date = $record->intrapartumRecord->created_at ?? null;
                                $generatedBy = 'N/A';
                            } elseif ($record->postpartumRecord) {
                                $type = 'Postpartum';
                                $date = $record->postpartumRecord->created_at ?? null;
                                $generatedBy = 'N/A';
                            } elseif ($record->babyRegistration) {
                                $type = 'Registration';
                                $date = $record->babyRegistration->date_of_birth ?? null;
                                $generatedBy = 'N/A';
                            } elseif ($record->visit) {
                                $type = 'Prenatal';
                                $date = $record->visit->visitInfo->first()->visit_date ?? null;
                                $generatedBy = $record->visit->staff
                                    ? $record->visit->staff->first_name . ' ' . $record->visit->staff->last_name
                                    : 'N/A';
                            } else {
                                $type = 'Other';
                                $date = null;
                                $generatedBy = 'N/A';
                            }

                            $displayDate = $date ? \Carbon\Carbon::parse($date)->format('M d, Y') : 'N/A';
                        @endphp

                        <tr data-type="{{ strtolower($type) }}"
                            data-date="{{ $date ? \Carbon\Carbon::parse($date)->year : '' }}">
                            <td class="visit-date">{{ $displayDate }}</td>
                            <td class="generated-by">{{ $generatedBy }}</td>
                            <td>{{ $type }}</td>
                            <td>
                                {{-- Download --}}
                                <a href="{{ route('admin.downloadRecord', ['patient' => $patient->id, 'record' => $record->id]) }}"
                                    class="action-btn download-btn" title="Download PDF">
                                    <i class="fas fa-file-download"></i>
                                </a>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No PDF records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div id="noResultsVisits" class="no-results" style="display: none;">
                <i class="fas fa-search"></i>
                <p>No visit records found matching your search criteria.</p>
            </div>
        </div>


            <div class="pagination-container" id="visitsPagination">
                <div class="items-per-page">
                    <span>Items per page:</span>
                    <select id="visitsItemsPerPage" onchange="updateItemsPerPage('visits')">
                        <option value="5">5</option>
                        <option value="10" selected>10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                    </select>
                </div>
                <div class="pagination-controls">
                    <button class="pagination-btn" id="visitsPrevPage" onclick="changePage('visits', -1)"
                        disabled>Previous</button>
                    <span id="visitsPageNumbers"></span>
                    <button class="pagination-btn" id="visitsNextPage" onclick="changePage('visits', 1)">Next</button>
                </div>
            </div>
        </div>

        <!-- Emergency Modal Placeholder -->
        <div id="emergency-container">
            @include('partials.emergencyModal')
        </div>
    </div>

    </main>
    <script src="{{ asset('script/admin/patient-pdf-records.js') }}"></script>
@endsection

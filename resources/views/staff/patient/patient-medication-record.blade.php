@extends('layouts.staff.layout')

@section('title', 'Patient Medication List - Letty\'s Birthing Home')
@section('page-title', 'Patient Medication')

@section('content')

    <div class="container-fluid main-content">
        <div class="medication-card">
            <div class="medication-header">
                <h5>
                    <i class="fas fa-prescription-bottle-alt me-2"></i>Patient Medication Record
                </h5>
                <a href="{{ route('patientMedication') }}" class="add-medication-btn" aria-label="Add new medication">
                    <i class="fas fa-plus me-2"></i>Add Medication
                </a>

            </div>

            <div class="search-filter-section">
                <div class="search-box">
                    <input type="text" id="searchInputMedication" placeholder="Search medication records..."
                        oninput="searchMedications()">
                    <i class="fas fa-search search-icon"></i>
                </div>
            </div>

            <div class="table-container">
                <table class="appointments-table" id="medicationTable">
                    <thead>
                        <tr>
                            <th>Patient Name</th>
                            {{-- <th>Remarks</th> --}}
                            <th>Issue Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($medications as $medication)
                            @php
                                $patientName = trim(
                                    ($medication->patient->client->first_name ?? '') .
                                        ' ' .
                                        ($medication->patient->client->last_name ?? '')
                                );
                            @endphp
                            <tr data-id="{{ $medication->id }}">
                                <td class="patient-name">
                                    {{ $medication->patient->client->first_name }}
                                    {{ $medication->patient->client->last_name }}
                                </td>
                                {{-- <td class="remarks">
                                    {{ $medication->notes ?? '—' }}
                                </td> --}}
                                <td class="issue-date">
                                    {{ \Carbon\Carbon::parse($medication->prescribed_at)->format('M d, Y') }}
                                </td>
                                <td class="actions-cell">
                                    <button class="action-btn view-btn" type="button" title="View details"
                                        data-bs-toggle="modal"
                                        data-bs-target="#viewMedicationModal{{ $medication->id }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="action-btn delete-btn" type="button" title="Delete record"
                                        data-delete-id="{{ $medication->id }}"
                                        data-delete-url="{{ route('patientMedication.destroy', $medication->id) }}"
                                        data-delete-label="{{ e($patientName) }}"
                                        onclick="openDeleteModal(this)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr class="no-medications">
                                <td colspan="3" class="text-center">No medication records found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>


                <div id="noResultsMedication" class="no-results" style="display: none;">
                    <i class="fas fa-search"></i>
                    <p>No medication records found matching your search criteria.</p>
                </div>
            </div>

            <div class="pagination-container" id="medicationPagination">
                <div class="items-per-page">
                    <span>Items per page:</span>
                    <select id="medicationItemsPerPage" onchange="updateItemsPerPage()">
                        <option value="5">5</option>
                        <option value="10" selected>10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                    </select>
                </div>
                <div class="pagination-controls">
                    <button class="pagination-btn" id="medicationPrevPage" onclick="changePage(-1)"
                        disabled>Previous</button>
                    <span id="medicationPageNumbers"></span>
                    <button class="pagination-btn" id="medicationNextPage" onclick="changePage(1)">Next</button>
                </div>
            </div>
        </div>
    </div>

    @foreach ($medications as $medication)
        <div class="modal fade" id="viewMedicationModal{{ $medication->id }}" tabindex="-1"
            aria-labelledby="viewMedicationModalLabel{{ $medication->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewMedicationModalLabel{{ $medication->id }}">
                            Medication Details
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Patient:</strong>
                                <div>
                                    {{ $medication->patient->client->first_name }}
                                    {{ $medication->patient->client->last_name }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <strong>Issued:</strong>
                                <div>{{ \Carbon\Carbon::parse($medication->prescribed_at)->format('M d, Y h:i A') }}</div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <strong>Remarks:</strong>
                            <div>{{ $medication->notes ?? '—' }}</div>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th class="text-end">Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($medication->items as $item)
                                        <tr>
                                            <td>{{ $item->item->item_name }}</td>
                                            <td class="text-end">{{ $item->quantity }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Delete Medication Modal -->
    <div class="modal fade" id="deleteMedicationModal" tabindex="-1" aria-labelledby="deleteMedicationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteMedicationModalLabel">Delete Medication Record</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>
                        Are you sure you want to delete the medication record for
                        <strong id="deleteMedicationPatient"></strong>?
                    </p>
                    <form id="deleteMedicationForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" id="deleteMedicationCode" name="id">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('script/staff/medication-record.js') }}"></script>

    <style>
        .item-entry + .item-entry {
            margin-top: 4px;
        }
    </style>
@endsection

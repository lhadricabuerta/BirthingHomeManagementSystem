@extends('layouts.admin.layout')

@section('title', 'Staff Management - Letty\'s Birthing Home')
@section('page-title', 'Staff Management')

@section('content')

<div class="container-fluid main-content">
    <div class="staff-card">
        <div class="staff-header">
            <h5>
                <i class="fas fa-user-nurse me-2"></i>All Midwives Member
            </h5>
            <a href="{{ route('addStaffs') }}" class="add-staff-btn" aria-label="Add new staff">
                <i class="fas fa-plus me-2"></i>Add Midwife
            </a>
        </div>

        <div class="search-filter-section">
            <div class="search-box">
                <input type="text" id="searchInput" placeholder="Search staff members..." oninput="searchStaff()">
                <i class="fas fa-search search-icon"></i>
            </div>
            
            <!-- Removed Work Days filter -->
            
            <div class="filter-dropdown">
                <button class="filter-btn" onclick="toggleFilter('branchFilter')">
                    <span>Branch</span>
                    <div class="d-flex align-items-center">
                        <span id="branchFilterCount" class="filter-count" style="display: none;">0</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </button>
                <div class="filter-dropdown-menu" id="branchFilter">
                    <div class="filter-option selected" onclick="filterStaff('branch', 'all')">All Branches</div>
                    <div class="filter-option" onclick="filterStaff('branch', 'sta. justina')">Santa Justina</div>
                    <div class="filter-option" onclick="filterStaff('branch', 'san pedro')">San Pedro</div>
                </div>
            </div>

            <button class="clear-filters-btn" id="clearFiltersBtn" style="display: none;" onclick="clearAllFilters()">
                Clear All Filters
            </button>
        </div>

        @php
            $avatarPalettes = [
                ['bg' => 'linear-gradient(135deg, #dbeafe, #bfdbfe)', 'color' => '#1d4ed8'],
                ['bg' => 'linear-gradient(135deg, #fecdd3, #fda4af)', 'color' => '#9f1239'],
                ['bg' => 'linear-gradient(135deg, #bbf7d0, #86efac)', 'color' => '#166534'],
                ['bg' => 'linear-gradient(135deg, #fde68a, #fcd34d)', 'color' => '#92400e'],
                ['bg' => 'linear-gradient(135deg, #bae6fd, #7dd3fc)', 'color' => '#0c4a6e'],
                ['bg' => 'linear-gradient(135deg, #e9d5ff, #d8b4fe)', 'color' => '#6d28d9']
            ];
        @endphp

        <div class="table-container">
            <table class="appointments-table" id="staffTable">
                <thead>
                    <tr>
                        <th>Profile</th>
                        <th>Staff Name</th>
                        <th>Branch</th>
                        <th>Shift</th>
                        <th>Account</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($staffs as $staff)
                        <tr data-id="{{ $staff->id }}" data-branch="{{ $staff->branch->branch_name ?? 'N/A' }}">
                            <td>
                                @php
                                    $displayName = trim(($staff->first_name ?? '') . ' ' . ($staff->last_name ?? ''));
                                    $nameParts = array_values(array_filter(preg_split('/\s+/', $displayName)));
                                    $initials = '';
                                    foreach ($nameParts as $part) {
                                        $initials .= strtoupper(substr($part, 0, 1));
                                        if (strlen($initials) >= 2) {
                                            break;
                                        }
                                    }
                                    if ($initials === '') {
                                        $initials = 'ST';
                                    }
                                    $hashSource = strtolower($displayName ?: ('staff-' . $staff->id));
                                    $hashValue = hexdec(substr(sha1($hashSource), 0, 8));
                                    $palette = $avatarPalettes[$hashValue % count($avatarPalettes)];
                                @endphp

                                @if ($staff->avatar_path)
                                    <img src="{{ asset($staff->avatar_path) }}"
                                         alt="{{ $staff->first_name }} {{ $staff->last_name }}"
                                         class="profile-pic"
                                         onclick="openImageModal(this.src, '{{ $staff->first_name }} {{ $staff->last_name }}')">
                                @else
                                    <div class="profile-placeholder profile-placeholder-initials"
                                         style="background: {{ $palette['bg'] }}; color: {{ $palette['color'] }};"
                                         onclick="openImageModal('{{ asset('img/default-avatar.jpg') }}', '{{ $staff->first_name }} {{ $staff->last_name }}')">
                                        {{ $initials }}
                                    </div>
                                @endif
                            </td>
                            <td class="staff-name">{{ $staff->first_name }} {{ $staff->last_name }}</td>
                            <td class="staff-branch">{{ $staff->branch->branch_name ?? 'N/A' }}</td>
                            <td class="staff-shift">{{ optional($staff->workDays->first())->shift ?? 'N/A' }}</td>
                            <td class="staff-account">
                                @if ($staff->user && $staff->user->is_active)
                                    <span class="status-badge status-available">Activated</span>
                                @else
                                    <span class="status-badge status-out">Deactivated</span>
                                @endif
                            </td>
                            <td class="actions-cell" style="white-space: nowrap;">
                                @if ($staff->user)
                                    <button type="button" class="action-btn status-btn"
                                        onclick="openStatusModal('{{ route('staffs.toggleActive', $staff->id) }}', '{{ $staff->first_name }} {{ $staff->last_name }}', {{ $staff->user->is_active ? 1 : 0 }})"
                                        title="{{ $staff->user->is_active ? 'Deactivate' : 'Activate' }}">
                                        <i class="fas {{ $staff->user->is_active ? 'fa-user-slash' : 'fa-user-check' }}"></i>
                                    </button>
                                @endif
                                <a href="{{ route('viewStaffs', ['id' => $staff->id]) }}" class="action-btn view-btn"
                                   title="View" style="display: inline-block; margin-right: 5px;">
                                   <i class="fas fa-eye"></i>
                                </a>
                                <button class="action-btn schedule-btn"
                                        onclick="setSchedule(
                                            {{ $staff->id }},
                                            '{{ $staff->first_name }} {{ $staff->last_name }}',
                                            '{{ optional($staff->workDays->first())->shift ?? '' }}',
                                            '{{ $staff->workDays->pluck('day')->join(',') }}'
                                        )"
                                        title="Set Schedule" style="display: inline-block; margin-right: 5px;">
                                    <i class="fas fa-calendar-alt"></i>
                                </button>
                                <button class="action-btn delete-btn"
                                        onclick="openDeleteModal('{{ route('staffs.delete', $staff->id) }}', '{{ $staff->first_name }} {{ $staff->last_name }}')"
                                        title="Delete" style="display: inline-block;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr class="no-results">
                            <td colspan="8" class="text-center">
                                <i class="fas fa-user-slash"></i>
                                <p>No staff members available.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div id="noResults" class="no-results" style="display: none;">
                <i class="fas fa-search"></i>
                <p>No staff members found matching your search criteria.</p>
            </div>
        </div>

        <div class="pagination-container" id="staffPagination">
            <div class="items-per-page">
                <span>Items per page:</span>
                <select id="staffItemsPerPage" onchange="updateItemsPerPage()">
                    <option value="5">5</option>
                    <option value="10" selected>10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                </select>
            </div>
            <div class="pagination-controls">
                <button class="pagination-btn" id="staffPrevPage" onclick="changePage(-1)" disabled>Previous</button>
                <span id="staffPageNumbers"></span>
                <button class="pagination-btn" id="staffNextPage" onclick="changePage(1)">Next</button>
            </div>
        </div>
    </div>
</div>

    <!-- Image Modal -->
    <div id="imageModal" class="image-modal">
        <span class="image-modal-close" onclick="closeImageModal()">×</span>
        <div class="image-modal-content">
            <img id="modalImage" src="" alt="">
        </div>
    </div>


    <!-- Delete Modal -->
    <div class="modal fade delete-modal" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete <span id="deleteStaffName"></span>? This action cannot be undone.
                    </p>
                </div>
                <div class="modal-footer">
                    <form id="deleteForm" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Schedule Modal -->
    <div class="modal fade schedule-modal" id="scheduleModal" tabindex="-1" aria-labelledby="scheduleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scheduleModalLabel">
                        Set Schedule for <span id="scheduleStaffName"></span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form id="scheduleForm" method="POST" data-action="{{ route('staffs.updateSchedule', ':id') }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="scheduleStaffId" name="staff_id">

                        <!-- Shift -->
                        <div class="mb-3">
                            <label for="shiftSelect" class="form-label">Shift</label>
                            <select class="form-select" id="shiftSelect" name="shift" required>
                                <option value="Day">Day</option>
                                <option value="Night">Night</option>
                            </select>

                        </div>

                        <!-- Work Days -->
                        <div class="mb-3">
                            <label class="form-label">Work Days</label>
                            <div class="checkbox-group">
                                @foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                                    <div class="checkbox-item">
                                        <input type="checkbox" name="workDays[]" id="workDay{{ $day }}"
                                            value="{{ $day }}">
                                        <label for="workDay{{ $day }}">{{ ucfirst($day) }}</label>
                                    </div>
                                @endforeach
                            </div>
                            <div id="workDaysError" class="invalid-feedback d-none">
                                Please select at least one workday.
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Schedule</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Modal -->
    <div class="modal fade delete-modal" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusModalLabel">Confirm Action</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="statusModalMessage"></p>
                </div>
                <div class="modal-footer">
                    <form id="statusForm" method="POST" class="d-inline">
                        @csrf
                        @method('PUT')
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger" id="statusConfirmBtn">Confirm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    </main>
    <script src="{{ asset('script/admin/staff.js') }}"></script>
@endsection

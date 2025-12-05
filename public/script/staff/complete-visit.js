document.addEventListener("DOMContentLoaded", function() {
    const sidebar = document.getElementById("sidebar");
    const sidebarOverlay = document.getElementById("sidebarOverlay");
    const btnOpen = document.getElementById("mobileMenuBtnHeader");
    const btnClose = document.getElementById("mobileMenuBtnSidebar");

    // Sidebar toggle
    if (btnOpen && sidebar && sidebarOverlay) {
        btnOpen.addEventListener("click", function() {
            sidebar.classList.add("mobile-show");
            sidebarOverlay.classList.add("show");
        });
    }

    if (btnClose && sidebar && sidebarOverlay) {
        btnClose.addEventListener("click", function() {
            sidebar.classList.remove("mobile-show");
            sidebarOverlay.classList.remove("show");
        });
    }

    if (sidebarOverlay && sidebar) {
        sidebarOverlay.addEventListener("click", function() {
            sidebar.classList.remove("mobile-show");
            this.classList.remove("show");
        });
    }

    // Dropdown toggle
    window.toggleDropdown = function(element) {
        const icon = element.querySelector('.dropdown-icon');
        if (icon) {
            icon.classList.toggle('rotate');
        }
    };

    // Filter dropdown toggle
    window.toggleFilter = function(id) {
        const dropdown = document.getElementById(id);
        if (dropdown) {
            dropdown.classList.toggle('show');
        }
    };

    // Close filter dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const filterDropdowns = document.querySelectorAll('.filter-dropdown-menu');
        const filterButtons = document.querySelectorAll('.filter-btn');
        if (!Array.from(filterButtons).some(btn => btn.contains(event.target)) &&
            !Array.from(filterDropdowns).some(dropdown => dropdown.contains(event.target))) {
            filterDropdowns.forEach(dropdown => dropdown.classList.remove('show'));
        }
    });

    // Search and filter functionality
    let currentPage = 1;
    let itemsPerPage = parseInt(document.getElementById('currentItemsPerPage')?.value || 10);
    let ageFilter = 'all';
    let searchQuery = '';

    function getVisibleRows() {
        const rows = Array.from(document.querySelectorAll(
            '#currentPatientsTable tbody tr:not(.no-results)'));
        return rows.filter(row => {
            const cells = row.querySelectorAll('td');
            if (cells.length < 6) return false;

            const firstName = cells[1].textContent.toLowerCase();
            const lastName = cells[2].textContent.toLowerCase();
            const address = cells[3].textContent.toLowerCase();
            const ageText = cells[4].textContent;
            const phone = cells[5].textContent.toLowerCase();
            const age = parseInt(ageText) || 0;

            // Search filter
            const matchesSearch = searchQuery === '' ||
                firstName.includes(searchQuery) ||
                lastName.includes(searchQuery) ||
                address.includes(searchQuery) ||
                phone.includes(searchQuery);

            // Age filter
            let matchesAge = true;
            if (ageFilter === 'young') matchesAge = age >= 18 && age <= 25;
            else if (ageFilter === 'adult') matchesAge = age >= 26 && age <= 35;
            else if (ageFilter === 'mature') matchesAge = age >= 36;

            return matchesSearch && matchesAge;
        });
    }

    function updateTable() {
        const rows = Array.from(document.querySelectorAll(
            '#currentPatientsTable tbody tr:not(.no-results)'));
        const visibleRows = getVisibleRows();
        const totalRows = visibleRows.length;
        const totalPages = Math.ceil(totalRows / itemsPerPage);

        // Update filter count
        const filterCount = document.getElementById('ageFilterCountCurrent');
        if (filterCount) {
            filterCount.textContent = ageFilter !== 'all' ? totalRows : '0';
            filterCount.style.display = ageFilter !== 'all' ? 'inline' : 'none';
        }

        const clearFiltersBtn = document.getElementById('clearFiltersBtnCurrent');
        if (clearFiltersBtn) {
            clearFiltersBtn.style.display = ageFilter !== 'all' || searchQuery ? 'block' : 'none';
        }

        // Update pagination
        currentPage = Math.min(currentPage, Math.max(1, totalPages));
        const start = (currentPage - 1) * itemsPerPage;
        const end = start + itemsPerPage;

        // Show/hide rows
        rows.forEach(row => row.style.display = 'none');
        visibleRows.slice(start, end).forEach(row => row.style.display = '');

        // Update no results message
        const noResults = document.getElementById('noResultsCurrent');
        const hasPatients = rows.length > 0;
        const isFiltered = searchQuery !== '' || ageFilter !== 'all';

        if (noResults) {
            // Show noResultsCurrent only when there are patients but none match the search/filter
            noResults.style.display = hasPatients && totalRows === 0 && isFiltered ? 'block' : 'none';
        }

        // Update pagination controls
        const prevBtn = document.getElementById('currentPrevPage');
        const nextBtn = document.getElementById('currentNextPage');
        if (prevBtn) prevBtn.disabled = currentPage === 1;
        if (nextBtn) nextBtn.disabled = currentPage === totalPages || totalPages === 0;

        const pageNumbers = document.getElementById('currentPageNumbers');
        if (pageNumbers) {
            pageNumbers.textContent = totalPages > 0 ? `Page ${currentPage} of ${totalPages}` : 'Page 0 of 0';
        }
    }

    window.searchPatients = function(type) {
        if (type === 'current') {
            const searchInput = document.getElementById('searchInputCurrent');
            if (searchInput) {
                searchQuery = searchInput.value.toLowerCase();
                currentPage = 1;
                updateTable();
            }
        }
    };

    window.filterPatients = function(category, value, type) {
        if (type === 'current' && category === 'age') {
            ageFilter = value;
            const options = document.querySelectorAll('#ageFilterCurrent .filter-option');
            options.forEach(opt => opt.classList.remove('selected'));
            if (event && event.target) {
                event.target.classList.add('selected');
            }
            const filterDropdown = document.getElementById('ageFilterCurrent');
            if (filterDropdown) {
                filterDropdown.classList.remove('show');
            }
            currentPage = 1;
            updateTable();
        }
    };

    window.clearAllFilters = function(type) {
        if (type === 'current') {
            searchQuery = '';
            ageFilter = 'all';
            const searchInput = document.getElementById('searchInputCurrent');
            if (searchInput) {
                searchInput.value = '';
            }
            const options = document.querySelectorAll('#ageFilterCurrent .filter-option');
            options.forEach(opt => opt.classList.remove('selected'));
            if (options.length > 0) {
                options[0].classList.add('selected');
            }
            currentPage = 1;
            updateTable();
        }
    };

    window.updateItemsPerPage = function(type) {
        if (type === 'current') {
            const itemsSelect = document.getElementById('currentItemsPerPage');
            if (itemsSelect) {
                itemsPerPage = parseInt(itemsSelect.value);
                currentPage = 1;
                updateTable();
            }
        }
    };

    window.changePage = function(type, direction) {
        if (type === 'current') {
            const totalRows = getVisibleRows().length;
            const totalPages = Math.ceil(totalRows / itemsPerPage);
            currentPage = Math.min(Math.max(1, currentPage + direction), totalPages);
            updateTable();
        }
    };

    window.openDeleteModal = function(url, name) {
        const patientNameEl = document.getElementById('deletePatientName');
        const deleteFormEl = document.getElementById('deleteForm');
        if (patientNameEl) patientNameEl.textContent = name;
        if (deleteFormEl) deleteFormEl.action = url;
        const modalEl = document.getElementById('deleteModal');
        if (modalEl && typeof bootstrap !== 'undefined') {
            new bootstrap.Modal(modalEl).show();
        }
    };

    // Initialize table
    updateTable();
});
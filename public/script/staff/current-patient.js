
        document.addEventListener("DOMContentLoaded", function () {
            const sidebar = document.getElementById("sidebar");
            const sidebarOverlay = document.getElementById("sidebarOverlay");
            const btnOpen = document.getElementById("mobileMenuBtnHeader");
            const btnClose = document.getElementById("mobileMenuBtnSidebar");
            const patientsTable = document.getElementById("currentPatientsTable");
            const itemsPerPageSelect = document.getElementById("currentItemsPerPage");

            if (!patientsTable || !itemsPerPageSelect) {
                // Exit early so we do not bind handlers when the table is missing.
                return;
            }

            // Sidebar toggle
            if (btnOpen && sidebar && sidebarOverlay) {
                btnOpen.addEventListener("click", function () {
                    sidebar.classList.add("mobile-show");
                    sidebarOverlay.classList.add("show");
                });
            }

            if (btnClose && sidebar && sidebarOverlay) {
                btnClose.addEventListener("click", function () {
                    sidebar.classList.remove("mobile-show");
                    sidebarOverlay.classList.remove("show");
                });
            }

            if (sidebarOverlay && sidebar) {
                sidebarOverlay.addEventListener("click", function () {
                    sidebar.classList.remove("mobile-show");
                    this.classList.remove("show");
                });
            }

            // Dropdown toggle
            window.toggleDropdown = function (element) {
                const icon = element.querySelector(".dropdown-icon");
                if (icon) {
                    icon.classList.toggle("rotate");
                }
            };

            // Filter dropdown toggle
            window.toggleFilter = function (id) {
                const dropdown = document.getElementById(id);
                if (dropdown) {
                    dropdown.classList.toggle("show");
                }
            };

            // Close filter dropdown when clicking outside
            document.addEventListener("click", function (event) {
                const filterDropdowns = document.querySelectorAll(".filter-dropdown-menu");
                const filterButtons = document.querySelectorAll(".filter-btn");
                const clickedFilterButton = Array.from(filterButtons).some((btn) => btn.contains(event.target));
                const clickedDropdown = Array.from(filterDropdowns).some((dropdown) => dropdown.contains(event.target));

                if (!clickedFilterButton && !clickedDropdown) {
                    filterDropdowns.forEach((dropdown) => dropdown.classList.remove("show"));
                }
            });

            // Search and filter functionality
            let currentPage = 1;
            let itemsPerPage = parseInt(itemsPerPageSelect.value, 10) || 10;
            let ageFilter = "all";
            let searchQuery = "";

            function normalizeText(cell) {
                return cell ? cell.textContent.toLowerCase().trim() : "";
            }

            function getAgeValue(cell) {
                const text = cell ? cell.textContent.replace(/[^0-9]/g, "") : "";
                return text ? parseInt(text, 10) : null;
            }

            function getVisibleRows() {
                const rows = Array.from(
                    document.querySelectorAll("#currentPatientsTable tbody tr:not(.no-results)")
                );
                return rows.filter((row) => {
                    const fullName = normalizeText(row.querySelector(".patient-full-name"));
                    const address = normalizeText(row.querySelector(".patient-address"));
                    const phone = normalizeText(row.querySelector(".patient-phone"));
                    const visit = normalizeText(row.querySelector(".patient-visit"));
                    const nextVisit = normalizeText(row.querySelector(".patient-date"));
                    const ageValue = getAgeValue(row.querySelector(".patient-age"));

                    const matchesSearch =
                        searchQuery === "" ||
                        fullName.includes(searchQuery) ||
                        address.includes(searchQuery) ||
                        phone.includes(searchQuery) ||
                        visit.includes(searchQuery) ||
                        nextVisit.includes(searchQuery);

                    let matchesAge = true;
                    if (ageFilter === "young") {
                        matchesAge = ageValue !== null && ageValue >= 18 && ageValue <= 25;
                    } else if (ageFilter === "adult") {
                        matchesAge = ageValue !== null && ageValue >= 26 && ageValue <= 35;
                    } else if (ageFilter === "mature") {
                        matchesAge = ageValue !== null && ageValue >= 36;
                    }

                    return matchesSearch && matchesAge;
                });
            }

            function updateTable() {
                const rows = Array.from(
                    document.querySelectorAll("#currentPatientsTable tbody tr:not(.no-results)")
                );
                const visibleRows = getVisibleRows();
                const totalRows = visibleRows.length;
                const totalPages = Math.ceil(totalRows / itemsPerPage) || 1;

                const filterCount = document.getElementById("ageFilterCountCurrent");
                if (filterCount) {
                    filterCount.textContent = ageFilter !== "all" ? totalRows : "0";
                    filterCount.style.display = ageFilter !== "all" ? "inline" : "none";
                }

                const clearFiltersBtn = document.getElementById("clearFiltersBtnCurrent");
                if (clearFiltersBtn) {
                    clearFiltersBtn.style.display = ageFilter !== "all" || searchQuery ? "block" : "none";
                }

                currentPage = Math.min(currentPage, Math.max(1, totalPages));
                const start = (currentPage - 1) * itemsPerPage;
                const end = start + itemsPerPage;

                rows.forEach((row) => (row.style.display = "none"));
                visibleRows.slice(start, end).forEach((row) => (row.style.display = ""));

                const noResults = document.getElementById("noResultsCurrent");
                const hasPatients =
                    document.querySelectorAll("#currentPatientsTable tbody tr:not(.no-results)").length > 0;
                const isFiltered = searchQuery !== "" || ageFilter !== "all";

                if (noResults) {
                    noResults.style.display = hasPatients && totalRows === 0 && isFiltered ? "block" : "none";
                }

                const prevBtn = document.getElementById("currentPrevPage");
                const nextBtn = document.getElementById("currentNextPage");
                if (prevBtn) {
                    prevBtn.disabled = currentPage === 1;
                }
                if (nextBtn) {
                    nextBtn.disabled = currentPage === totalPages || totalRows === 0;
                }

                const pageNumbers = document.getElementById("currentPageNumbers");
                if (pageNumbers) {
                    const displayTotal = totalRows === 0 ? 0 : totalPages;
                    const displayCurrent = totalRows === 0 ? 0 : currentPage;
                    pageNumbers.textContent = `Page ${displayCurrent} of ${displayTotal}`;
                }
            }

            window.searchPatients = function (type) {
                if (type === "current") {
                    const input = document.getElementById("searchInputCurrent");
                    searchQuery = input ? input.value.toLowerCase() : "";
                    currentPage = 1;
                    updateTable();
                }
            };

            window.filterPatients = function (category, value, type, element) {
                if (type === "current" && category === "age") {
                    ageFilter = value;
                    const options = document.querySelectorAll("#ageFilterCurrent .filter-option");
                    options.forEach((opt) => opt.classList.remove("selected"));
                    if (element) {
                        element.classList.add("selected");
                    } else if (typeof event !== "undefined" && event?.target) {
                        event.target.classList.add("selected");
                    }
                    const dropdown = document.getElementById("ageFilterCurrent");
                    if (dropdown) {
                        dropdown.classList.remove("show");
                    }
                    currentPage = 1;
                    updateTable();
                }
            };

            window.clearAllFilters = function (type) {
                if (type === "current") {
                    searchQuery = "";
                    ageFilter = "all";
                    const searchInput = document.getElementById("searchInputCurrent");
                    if (searchInput) {
                        searchInput.value = "";
                    }
                    const options = document.querySelectorAll("#ageFilterCurrent .filter-option");
                    options.forEach((opt) => opt.classList.remove("selected"));
                    if (options[0]) {
                        options[0].classList.add("selected");
                    }
                    currentPage = 1;
                    updateTable();
                }
            };

            window.updateItemsPerPage = function (type) {
                if (type === "current") {
                    itemsPerPage = parseInt(itemsPerPageSelect.value, 10) || 10;
                    currentPage = 1;
                    updateTable();
                }
            };

            window.changePage = function (type, direction) {
                if (type === "current") {
                    const totalRows = getVisibleRows().length;
                    const totalPages = Math.ceil(totalRows / itemsPerPage) || 1;
                    currentPage = Math.min(Math.max(1, currentPage + direction), totalPages);
                    updateTable();
                }
            };

            window.openDeleteModal = function (url, name) {
                const nameNode = document.getElementById("deletePatientName");
                const form = document.getElementById("deleteForm");
                if (nameNode) {
                    nameNode.textContent = name;
                }
                if (form) {
                    form.action = url;
                }
                const modalElement = document.getElementById("deleteModal");
                if (modalElement) {
                    new bootstrap.Modal(modalElement).show();
                }
            };

            updateTable();
        });
   
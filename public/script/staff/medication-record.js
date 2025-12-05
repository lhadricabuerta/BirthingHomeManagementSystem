
       
        document.addEventListener("DOMContentLoaded", function () {
            const sidebar = document.getElementById("sidebar");
            const sidebarOverlay = document.getElementById("sidebarOverlay");
            const btnOpen = document.getElementById("mobileMenuBtnHeader");
            const btnClose = document.getElementById("mobileMenuBtnSidebar");
            const medicationTable = document.getElementById("medicationTable");
            const itemsPerPageSelect = document.getElementById("medicationItemsPerPage");

            if (!medicationTable || !itemsPerPageSelect) {
                // Required table nodes are missing; bail out to avoid binding handlers unnecessarily.
                return;
            }

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

            let currentPage = 1;
            let itemsPerPage = parseInt(itemsPerPageSelect.value, 10) || 10;
            let searchQuery = "";

            function normalizeText(node) {
                return node ? node.textContent.toLowerCase().trim() : "";
            }

            function getVisibleRows() {
                const rows = Array.from(
                    document.querySelectorAll("#medicationTable tbody tr:not(.no-results):not(.no-medications)")
                );
                return rows.filter((row) => {
                    const patientName = normalizeText(row.querySelector(".patient-name"));
                    const itemName = normalizeText(row.querySelector(".item-name"));
                    const quantity = normalizeText(row.querySelector(".quantity"));
                    const issueDate = normalizeText(row.querySelector(".issue-date"));

                    const matchesSearch =
                        searchQuery === "" ||
                        patientName.includes(searchQuery) ||
                        itemName.includes(searchQuery) ||
                        quantity.includes(searchQuery) ||
                        issueDate.includes(searchQuery);

                    return matchesSearch;
                });
            }

            function updateTable() {
                const rows = Array.from(
                    document.querySelectorAll("#medicationTable tbody tr:not(.no-results):not(.no-medications)")
                );
                const noMedicationsRow = document.querySelector("#medicationTable tbody tr.no-medications");
                const visibleRows = getVisibleRows();
                const totalRows = visibleRows.length;
                const totalPages = Math.max(1, Math.ceil(totalRows / itemsPerPage) || 1);
                const isFiltered = searchQuery !== "";

                currentPage = Math.min(currentPage, Math.max(1, totalPages));
                const start = (currentPage - 1) * itemsPerPage;
                const end = start + itemsPerPage;

                rows.forEach((row) => (row.style.display = "none"));
                visibleRows.slice(start, end).forEach((row) => (row.style.display = ""));

                const noResults = document.getElementById("noResultsMedication");
                if (noMedicationsRow) {
                    noMedicationsRow.style.display = rows.length === 0 && !isFiltered ? "" : "none";
                }
                if (noResults) {
                    noResults.style.display = totalRows === 0 && isFiltered ? "block" : "none";
                }

                const prevBtn = document.getElementById("medicationPrevPage");
                const nextBtn = document.getElementById("medicationNextPage");
                if (prevBtn) {
                    prevBtn.disabled = currentPage === 1 || totalRows === 0;
                }
                if (nextBtn) {
                    nextBtn.disabled = currentPage === Math.ceil(totalRows / itemsPerPage) || totalRows === 0;
                }

                const pageNumbers = document.getElementById("medicationPageNumbers");
                if (pageNumbers) {
                    const displayTotal = totalRows === 0 ? 0 : Math.ceil(totalRows / itemsPerPage);
                    const displayCurrent = totalRows === 0 ? 0 : currentPage;
                    pageNumbers.textContent = `Page ${displayCurrent} of ${displayTotal}`;
                }
            }

            window.searchMedications = function () {
                const input = document.getElementById("searchInputMedication");
                searchQuery = input ? input.value.toLowerCase() : "";
                currentPage = 1;
                updateTable();
            };

            window.updateItemsPerPage = function () {
                itemsPerPage = parseInt(itemsPerPageSelect.value, 10) || 10;
                currentPage = 1;
                updateTable();
            };

            window.changePage = function (direction) {
                const totalRows = getVisibleRows().length;
                const totalPages = Math.max(1, Math.ceil(totalRows / itemsPerPage) || 1);
                currentPage = Math.min(Math.max(1, currentPage + direction), totalPages);
                updateTable();
            };

            window.openDeleteModal = function (trigger) {
                if (!trigger) {
                    return;
                }
                const { deleteId, deleteUrl, deleteLabel } = trigger.dataset;
                const codeInput = document.getElementById("deleteMedicationCode");
                if (codeInput) {
                    codeInput.value = deleteId || "";
                }
                const patientLabel = document.getElementById("deleteMedicationPatient");
                if (patientLabel) {
                    patientLabel.textContent = deleteLabel || "this patient";
                }
                const deleteForm = document.getElementById("deleteMedicationForm");
                if (deleteForm && deleteUrl) {
                    deleteForm.setAttribute("action", deleteUrl);
                }
                const modalElement = document.getElementById("deleteMedicationModal");
                if (modalElement) {
                    new bootstrap.Modal(modalElement).show();
                }
            };

            const addMedicationForm = document.getElementById("addMedicationForm");
            if (addMedicationForm) {
                addMedicationForm.addEventListener("submit", function (e) {
                    e.preventDefault();
                    Swal.fire({
                        icon: "success",
                        title: "Medication Added",
                        text: "The medication record has been added successfully!",
                        confirmButtonText: "OK",
                    });
                });
            }

            updateTable();
        });
  
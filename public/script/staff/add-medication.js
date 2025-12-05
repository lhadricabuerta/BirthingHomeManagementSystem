document.addEventListener("DOMContentLoaded", function() {
    const sidebar = document.getElementById("sidebar");
    const sidebarOverlay = document.getElementById("sidebarOverlay");
    const btnOpen = document.getElementById("mobileMenuBtnHeader");
    const btnClose = document.getElementById("mobileMenuBtnSidebar");
    const form = document.getElementById("billForm");

    // Patient search elements
    const patientSearch = document.getElementById("patientSearch");
    const patientId = document.getElementById("patientId");
    const searchResults = document.getElementById("searchResults");

    btnOpen?.addEventListener("click", () => {
        sidebar.classList.add("mobile-show");
        sidebarOverlay.classList.add("show");
    });
    
    btnClose?.addEventListener("click", () => {
        sidebar.classList.remove("mobile-show");
        sidebarOverlay.classList.remove("show");
    });
    
    sidebarOverlay?.addEventListener("click", function() {
        sidebar.classList.remove("mobile-show");
        this.classList.remove("show");
    });

    // Patient search functionality
    patientSearch?.addEventListener("input", function() {
        const searchTerm = this.value.toLowerCase().trim();
        
        if (searchTerm.length === 0) {
            searchResults.classList.remove("show");
            patientId.value = "";
            return;
        }

        // Filter patients
        const filtered = patients.filter(patient => {
            const fullName = `${patient.client.last_name} ${patient.client.first_name}`.toLowerCase();
            return fullName.includes(searchTerm);
        });

        // Display results
        if (filtered.length > 0) {
            searchResults.innerHTML = filtered.map(patient => `
                <div class="search-result-item" data-id="${patient.id}" data-name="${patient.client.last_name}, ${patient.client.first_name}">
                    ${patient.client.last_name}, ${patient.client.first_name}
                </div>
            `).join("");
            searchResults.classList.add("show");
        } else {
            searchResults.innerHTML = '<div class="no-results">No patients found</div>';
            searchResults.classList.add("show");
        }
    });

    // Handle patient selection
    searchResults?.addEventListener("click", function(e) {
        const item = e.target.closest(".search-result-item");
        if (item) {
            patientSearch.value = item.dataset.name;
            patientId.value = item.dataset.id;
            searchResults.classList.remove("show");
        }
    });

    // Close search results when clicking outside
    document.addEventListener("click", function(e) {
        if (!patientSearch?.contains(e.target) && !searchResults?.contains(e.target)) {
            searchResults?.classList.remove("show");
        }
    });

    form?.addEventListener("submit", function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
            form.classList.add("was-validated");
            return;
        }

        // Allow normal form submit
        form.classList.add("was-validated");
    });
});

function toggleDropdown(element) {
    const icon = element.querySelector('.dropdown-icon');
    icon.classList.toggle('rotate');
    const submenu = element.nextElementSibling;
    submenu.classList.toggle('show');
}

let itemRowIndex = 1;

function addItemRow() {
    const table = document.getElementById("itemsTable").getElementsByTagName("tbody")[0];
    const row = table.insertRow();

    // Get options from hidden template
    const itemOptions = document.getElementById("itemOptions").innerHTML;

    row.innerHTML = `
        <td>
            <select name="items[${itemRowIndex}][type]" class="item-type form-select" required onchange="updateItemOptions(this)">
                <option value="" disabled selected>Select medication type</option>
                <option value="medicine">Medicine</option>
                <option value="supply">Medical Supply</option>
            </select>
        </td>
        <td>
            <select name="items[${itemRowIndex}][item_id]" class="item-name form-select" required>
                <option value="" disabled selected>Select a medication</option>
                ${itemOptions}
            </select>
        </td>
        <td>
            <input type="number" name="items[${itemRowIndex}][quantity]" class="item-quantity form-control" required min="1" value="1">
        </td>
        <td>
            <button type="button" class="remove-item-btn" onclick="removeItemRow(this)"><i class="fas fa-trash"></i></button>
        </td>
    `;

    itemRowIndex++;
    updateRemoveButtons();
}

function removeItemRow(button) {
    button.closest("tr").remove();
    updateRemoveButtons();
}

function updateRemoveButtons() {
    const buttons = document.querySelectorAll(".remove-item-btn");
    buttons.forEach(button => button.disabled = buttons.length === 1);
}

function updateItemOptions(select) {
    const row = select.closest("tr");
    const itemSelect = row.querySelector(".item-name");
    const selectedType = select.value;
    itemSelect.value = "";
    Array.from(itemSelect.options).forEach(option => {
        if (!option.value) return;
        option.style.display = option.dataset.type === selectedType || !option.dataset.type ? "block" : "none";
    });
}
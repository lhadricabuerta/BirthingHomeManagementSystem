// ===============================
// GLOBAL STATE
// ===============================
let currentPage = { all: 1 };
let itemsPerPage = { all: 10 };
let activeFilters = { all: { reason: "all" } };
let searchQuery = { all: "" };


// ===============================
// SEARCH
// ===============================
function searchAppointments(tableKey) {
    searchQuery[tableKey] = document.getElementById("searchInputAll").value.toLowerCase();
    currentPage[tableKey] = 1;
    updateTable(tableKey);
}


// ===============================
// FILTER DROPDOWN
// ===============================
function toggleFilter(id) {
    document.getElementById(id).classList.toggle("show");
}

function filterAppointments(type, value, tableKey) {
    activeFilters[tableKey][type] = value;
    document.getElementById("reasonFilterCountAll").innerText = value === "all" ? "" : "1";
    document.getElementById("reasonFilterCountAll").style.display = value === "all" ? "none" : "inline-block";

    currentPage[tableKey] = 1;

    updateTable(tableKey);
    updateClearButton(tableKey);
}


// ===============================
// CLEAR FILTERS
// ===============================
function clearAllFilters(tableKey) {
    searchQuery[tableKey] = "";
    activeFilters[tableKey].reason = "all";
    currentPage[tableKey] = 1;

    document.getElementById("searchInputAll").value = "";
    document.getElementById("reasonFilterCountAll").style.display = "none";

    updateTable(tableKey);
    updateClearButton(tableKey);
}

function updateClearButton(tableKey) {
    const btn = document.getElementById("clearFiltersBtnAll");
    const hasFilters = searchQuery[tableKey] || activeFilters[tableKey].reason !== "all";

    btn.style.display = hasFilters ? "inline-block" : "none";
}


// ===============================
// PAGINATION
// ===============================
function updateItemsPerPage(tableKey) {
    itemsPerPage[tableKey] = parseInt(document.getElementById("itemsPerPageAll").value);
    currentPage[tableKey] = 1;
    updateTable(tableKey);
}

function changePage(tableKey, direction) {
    currentPage[tableKey] += direction;
    updateTable(tableKey);
}


// ===============================
// MAIN TABLE FUNCTION
// ===============================
function updateTable(tableKey) {
    const table = document.getElementById("appointmentsTableAll");
    const rows = Array.from(table.querySelectorAll("tbody tr")).filter(
        r => !r.classList.contains("no-results")
    );

    let filtered = rows.filter(row => {
        const name = row.querySelector(".patient-full-name")?.innerText.toLowerCase() || "";
        const reason = row.querySelector(".appointment-reason")?.innerText.toLowerCase() || "";

        const matchesSearch = name.includes(searchQuery[tableKey]) || reason.includes(searchQuery[tableKey]);

        const matchesReason =
            activeFilters[tableKey].reason === "all" ||
            reason.includes(activeFilters[tableKey].reason);

        return matchesSearch && matchesReason;
    });

    const noResultsDiv = document.getElementById("noResultsAll");
    noResultsDiv.style.display = filtered.length === 0 ? "block" : "none";

    rows.forEach(r => (r.style.display = "none"));

    let start = (currentPage[tableKey] - 1) * itemsPerPage[tableKey];
    let end = start + itemsPerPage[tableKey];

    filtered.slice(start, end).forEach(r => (r.style.display = "table-row"));

    updatePaginationDisplay(filtered.length, tableKey);
}


// ===============================
// PAGINATION DISPLAY
// ===============================
function updatePaginationDisplay(totalItems, tableKey) {
    const totalPages = Math.ceil(totalItems / itemsPerPage[tableKey]) || 1;

    document.getElementById("prevPageAll").disabled = currentPage[tableKey] === 1;
    document.getElementById("nextPageAll").disabled = currentPage[tableKey] === totalPages;

    document.getElementById("pageNumbersAll").innerText =
        `Page ${currentPage[tableKey]} of ${totalPages}`;
}


// ===============================
// INITIAL LOAD
// ===============================
document.addEventListener("DOMContentLoaded", () => {
    updateTable("all");
});

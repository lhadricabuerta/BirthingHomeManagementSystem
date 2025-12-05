

        document.addEventListener("DOMContentLoaded", function() {
            const sidebar = document.getElementById("sidebar");
            const sidebarOverlay = document.getElementById("sidebarOverlay");
            const btnOpen = document.getElementById("mobileMenuBtnHeader");
            const btnClose = document.getElementById("mobileMenuBtnSidebar");
            const branchSelect = document.getElementById("branchSelect");
            const branchDropdownMenu = document.getElementById("branchDropdownMenu");
            const branchForm = document.getElementById("branchForm");
            const branchInput = document.getElementById("branchInput");

            // Sidebar functionality
            btnOpen.addEventListener("click", function() {
                sidebar.classList.add("mobile-show");
                sidebarOverlay.classList.add("show");
            });

            btnClose.addEventListener("click", function() {
                sidebar.classList.remove("mobile-show");
                sidebarOverlay.classList.remove("show");
            });

            sidebarOverlay.addEventListener("click", function() {
                sidebar.classList.remove("mobile-show");
                this.classList.remove("show");
            });

            // Branch dropdown toggle
            branchSelect.addEventListener("click", function() {
                branchDropdownMenu.classList.toggle("show");
                branchSelect.setAttribute("aria-expanded", branchDropdownMenu.classList.contains("show"));
            });

            // Branch dropdown option click
            branchDropdownMenu.addEventListener("click", function(e) {
                if (e.target.classList.contains("filter-option")) {
                    const selectedBranch = e.target.getAttribute("data-value");

                    // Update dropdown text
                    branchSelect.querySelector(".selected-option").textContent = selectedBranch;

                    // Update hidden input & submit form
                    branchInput.value = selectedBranch;
                    branchForm.submit();
                }
            });

            window.toggleDropdown = function(element) {
                const icon = element.querySelector('.dropdown-icon');
                icon.classList.toggle('rotate');
            };

            // Close dropdown when clicking outside
            document.addEventListener("click", function(e) {
                if (!branchSelect.contains(e.target) && !branchDropdownMenu.contains(e.target)) {
                    branchDropdownMenu.classList.remove("show");
                    branchSelect.setAttribute("aria-expanded", "false");
                }
            });

            // Custom Calendar functionality
            const calendarGrid = document.getElementById("calendarGrid");
            const calendarMonthYear = document.getElementById("calendarMonthYear");
            const calendarTitle = document.getElementById("calendarTitle");
            const prevMonthBtn = document.getElementById("prevMonth");
            const nextMonthBtn = document.getElementById("nextMonth");
            const todayBtn = document.getElementById("todayBtn");
            const eventModal = new bootstrap.Modal(document.getElementById('eventModal'));
            const modalClient = document.getElementById('modalClient');
            const modalReason = document.getElementById('modalReason');
            const modalTime = document.getElementById('modalTime');
            const modalBranch = document.getElementById('modalBranch');

            let currentDate = new Date();
            let currentMonth = currentDate.getMonth();
            let currentYear = currentDate.getFullYear();

            // Set calendar title based on selected branch
            function setCalendarTitle(branch) {
                if (branch === "Combined") {
                    calendarTitle.textContent = "Appointment Calendar For All Branch";
                } else if (branch === "Santa Justina") {
                    calendarTitle.textContent = "Appointment Calendar For Santa Justina";
                } else if (branch === "San Pedro") {
                    calendarTitle.textContent = "Appointment Calendar For San Pedro";
                }
            }

            // Events data
            const events = {};
            appointments.forEach(appt => {
                if (selectedBranch === "Combined" || appt.branch === selectedBranch) {
                    const dateStr = appt.date;
                    const eventText = `${appt.client} - ${appt.reason} (${appt.time}) - ${appt.branch}`;
                    if (!events[dateStr]) {
                        events[dateStr] = [];
                    }
                    events[dateStr].push(eventText);
                }
            });

            function renderCalendar(month, year) {
                const today = new Date();
                const monthNames = [
                    "January", "February", "March", "April", "May", "June",
                    "July", "August", "September", "October", "November", "December"
                ];
                calendarMonthYear.textContent = `${monthNames[month]} ${year}`;
                setCalendarTitle(selectedBranch);

                calendarGrid.innerHTML = '';

                // Add day headers
                const days = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
                days.forEach(day => {
                    const dayHeader = document.createElement("div");
                    dayHeader.classList.add("calendar-day-header");
                    dayHeader.textContent = day;
                    calendarGrid.appendChild(dayHeader);
                });

                // Get first day of the month and number of days
                const firstDay = new Date(year, month, 1).getDay();
                const daysInMonth = new Date(year, month + 1, 0).getDate();

                // Add empty cells for days before the first day
                for (let i = 0; i < firstDay; i++) {
                    const emptyDay = document.createElement("div");
                    emptyDay.classList.add("calendar-day", "empty");
                    calendarGrid.appendChild(emptyDay);
                }

                // Add days of the month
                for (let i = 1; i <= daysInMonth; i++) {
                    const day = document.createElement("div");
                    day.classList.add("calendar-day");
                    const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;

                    // Day number at the top
                    const dayNumber = document.createElement("div");
                    dayNumber.classList.add("day-number");
                    dayNumber.textContent = i;

                    if (
                        i === today.getDate() &&
                        month === today.getMonth() &&
                        year === today.getFullYear()
                    ) {
                        day.classList.add("today");
                    }

                    // Events container
                    const eventsContainer = document.createElement("div");
                    eventsContainer.classList.add("events-container");

                    // Add all events
                    if (events[dateStr]) {
                        events[dateStr].forEach(event => {
                            const eventDiv = document.createElement("div");
                            eventDiv.classList.add("event");
                            eventDiv.textContent = event;
                            eventDiv.addEventListener('click', () => {
                                const [client, reasonTimeBranch] = event.split(' - ');
                                const [reason, timeBranch] = reasonTimeBranch.split(' (');
                                const [time, branchPart] = timeBranch ? timeBranch.split(') - ') : [
                                    '', ''
                                ];
                                modalClient.textContent = client;
                                modalReason.textContent = reason;
                                modalTime.textContent = time;
                                modalBranch.textContent = branchPart || selectedBranch;
                                eventModal.show();
                            });
                            eventsContainer.appendChild(eventDiv);
                        });
                    }

                    day.appendChild(dayNumber);
                    day.appendChild(eventsContainer);
                    calendarGrid.appendChild(day);
                }
            }

            // Initial render
            renderCalendar(currentMonth, currentYear);

            // Event listeners for navigation
            prevMonthBtn.addEventListener("click", () => {
                currentMonth--;
                if (currentMonth < 0) {
                    currentMonth = 11;
                    currentYear--;
                }
                renderCalendar(currentMonth, currentYear);
            });

            nextMonthBtn.addEventListener("click", () => {
                currentMonth++;
                if (currentMonth > 11) {
                    currentMonth = 0;
                    currentYear++;
                }
                renderCalendar(currentMonth, currentYear);
            });

            // Today button event listener
            todayBtn.addEventListener("click", () => {
                const today = new Date();
                currentMonth = today.getMonth();
                currentYear = today.getFullYear();
                renderCalendar(currentMonth, currentYear);
            });
        });
   
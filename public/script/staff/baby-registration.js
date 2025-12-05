
        document.addEventListener("DOMContentLoaded", () => {
            const sidebar = document.getElementById("sidebar");
            const sidebarOverlay = document.getElementById("sidebarOverlay");
            const btnOpen = document.getElementById("mobileMenuBtnHeader");
            const btnClose = document.getElementById("mobileMenuBtnSidebar");
            const form = document.getElementById("babyRegistrationForm");
            const completeButton = document.getElementById("registrationComplete");
            const requiredFields = document.querySelectorAll(
                "#registrationStage input[required], #registrationStage select[required]");

            btnOpen.addEventListener("click", () => {
                sidebar.classList.add("mobile-show");
                sidebarOverlay.classList.add("show");
            });
            btnClose.addEventListener("click", () => {
                sidebar.classList.remove("mobile-show");
                sidebarOverlay.classList.remove("show");
            });
            sidebarOverlay.addEventListener("click", () => {
                sidebar.classList.remove("mobile-show");
                sidebarOverlay.classList.remove("show");
            });

            requiredFields.forEach(field => {
                field.addEventListener("input", () => {
                    const allFilled = Array.from(requiredFields).every(f => f.value);
                    completeButton.disabled = !allFilled;
                });
            });

            form.addEventListener("submit", (event) => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                    form.classList.add("was-validated");
                }
            });

            completeButton.addEventListener("click", () => {
                if (form.checkValidity()) {
                    Swal.fire({
                        title: 'Registration Completed',
                        text: 'All registration requirements have been completed (frontend-only).',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                } else {
                    form.classList.add("was-validated");
                }
            });

            function toggleDropdown(element) {
                const icon = element.querySelector('.dropdown-icon');
                icon.classList.toggle('rotate');
                const submenu = element.nextElementSibling;
                submenu.classList.toggle('show');
            }
        });

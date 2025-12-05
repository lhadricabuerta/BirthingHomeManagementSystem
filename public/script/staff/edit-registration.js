
        document.addEventListener("DOMContentLoaded", () => {
            const sidebar = document.getElementById("sidebar");
            const sidebarOverlay = document.getElementById("sidebarOverlay");
            const btnOpen = document.getElementById("mobileMenuBtnHeader");
            const btnClose = document.getElementById("mobileMenuBtnSidebar");
            const form = document.getElementById("babyRegistrationForm");
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

             window.toggleDropdown = function (element) {
                const icon = element.querySelector(".dropdown-icon");
                icon.classList.toggle("rotate");
            };

            requiredFields.forEach(field => {
                field.addEventListener("input", () => {
                    const allFilled = Array.from(requiredFields).every(f => f.value);
                });
            });

            form.addEventListener("submit", (event) => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
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
  
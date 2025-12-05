
        document.addEventListener("DOMContentLoaded", () => {
            const sidebar = document.getElementById("sidebar");
            const sidebarOverlay = document.getElementById("sidebarOverlay");
            const btnOpen = document.getElementById("mobileMenuBtnHeader");
            const btnClose = document.getElementById("mobileMenuBtnSidebar");
            const form = document.getElementById("birthingForm");
            const requiredFields = document.querySelectorAll(
                "#intrapartumStage input[required], #intrapartumStage select[required]");

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
                });
            });

            function toggleDropdown(element) {
                const icon = element.querySelector('.dropdown-icon');
                icon.classList.toggle('rotate');
                const submenu = element.nextElementSibling;
                submenu.classList.toggle('show');
            }
        });
   
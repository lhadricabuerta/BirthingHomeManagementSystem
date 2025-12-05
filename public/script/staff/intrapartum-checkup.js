
        document.addEventListener("DOMContentLoaded", () => {
            const sidebar = document.getElementById("sidebar");
            const sidebarOverlay = document.getElementById("sidebarOverlay");
            const btnOpen = document.getElementById("mobileMenuBtnHeader");
            const btnClose = document.getElementById("mobileMenuBtnSidebar");
            const form = document.getElementById("birthingForm");
            const cancelDeliveryButton = document.getElementById("cancelDelivery");
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
                    // Note: nextButton is not defined in the HTML, so this may be leftover code
                    // nextButton.disabled = !allFilled;
                });
            });

            cancelDeliveryButton.addEventListener("click", () => {
                Swal.fire({
                    title: 'Cancel Delivery?',
                    text: 'Are you sure you want to cancel the delivery process? This action cannot be undone.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: 'var(--danger-color)',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, cancel it',
                    cancelButtonText: 'No, keep it'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Delivery Cancelled',
                            text: 'The delivery process has been cancelled (frontend-only).',
                            icon: 'info',
                            confirmButtonText: 'OK'
                        });
                        document.getElementById("birthingForm").reset();
                    }
                });
            });

            function toggleDropdown(element) {
                const icon = element.querySelector('.dropdown-icon');
                icon.classList.toggle('rotate');
                const submenu = element.nextElementSibling;
                submenu.classList.toggle('show');
            }
        });
   
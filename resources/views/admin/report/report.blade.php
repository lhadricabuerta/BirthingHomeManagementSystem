<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - Letty's Birthing Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />
    <link rel="icon" type="image/png" href="{{ asset('img/imglogo.png') }}">

    <style>
        :root {
            --primary-color: #113F67;
            --primary-dark: #0d2f4d;
            --primary-gradient: linear-gradient(135deg, #113F67 0%, #0d2f4d 100%);
            --light-bg: #f8fafc;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --border-radius: 12px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --sidebar-width: 250px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
        }

        .sidebar {
            background: var(--primary-gradient);
            box-shadow: var(--card-shadow);
            transition: var(--transition);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            width: var(--sidebar-width);
            z-index: 1050;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
            transition: var(--transition);
            border-radius: var(--border-radius);
            margin: 2px 0;
            font-weight: 500;
            padding: 12px 16px;
            display: flex;
            align-items: center;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff !important;
            background: rgba(255, 255, 255, 0.15);
            transform: translateX(8px);
        }

        .dropdown-submenu {
            background: rgba(255, 255, 255, 0.05);
            border-radius: var(--border-radius);
            margin-top: 4px;
            padding: 8px;
            margin-left: 10px;
        }

        .dropdown-submenu .nav-link {
            font-size: 0.9em;
            padding: 8px 12px;
            margin: 1px 0;
        }

        .dropdown-icon {
            margin-left: auto;
            color: rgba(255, 255, 255, 0.8);
            transition: transform var(--transition);
        }

        .dropdown-icon.rotate {
            transform: rotate(180deg);
        }

        .content {
            margin-left: var(--sidebar-width);
            transition: var(--transition);
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                height: 100%;
                width: var(--sidebar-width);
                transform: translateX(-100%);
                z-index: 1055;
                overflow-y: auto;
            }

            .sidebar.mobile-show {
                transform: translateX(0);
            }

            .content {
                margin-left: 0;
            }

            .sidebar-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.6);
                z-index: 1040;
                display: none;
            }

            .sidebar-overlay.show {
                display: block;
            }

            #mobileMenuBtnSidebar {
                position: absolute;
                top: -10px;
                right: 15px;
                background: none;
                border: none;
                color: #fff;
                font-size: 1.5rem;
                padding: 8px;
                border-radius: 8px;
                transition: var(--transition);
                z-index: 1060;
                cursor: pointer;
            }

            #mobileMenuBtnSidebar:hover {
                background: rgba(255, 255, 255, 0.1);
                transform: scale(1.1);
            }
        }

        .main-header {
            background: rgba(255, 255, 255, 0.95);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: var(--card-shadow);
        }

        .page-title {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
        }

        .notification-dropdown {
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(226, 232, 240, 0.8);
            min-width: 350px;
            max-height: 70vh;
            overflow-y: auto;
        }

        @media (max-width: 576px) {

            .notification-dropdown,
            .profile-dropdown {
                position: fixed !important;
                top: 60px;
                left: 0 !important;
                right: 0 !important;
                width: 100% !important;
                border-radius: 0 0 var(--border-radius) var(--border-radius);
                z-index: 1050;
                max-height: 70vh;
            }
        }

        .notification-item {
            transition: var(--transition);
            border-bottom: 1px solid rgba(226, 232, 240, 0.5);
        }

        .notification-item:hover {
            background: #f0f0f0;
            transform: translateX(4px);
        }

        .notification-badge {
            background: #ef4444 !important;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .mobile-menu-btn {
            background: none;
            border: none;
            color: var(--primary-color);
            font-size: 1.5rem;
            padding: 8px;
            border-radius: 8px;
            transition: var(--transition);
            z-index: 1060;
            cursor: pointer;
        }

        .mobile-menu-btn:hover {
            background: rgba(17, 63, 103, 0.1);
            transform: scale(1.1);
        }

        .user-profile img {
            border: 2px solid rgba(17, 63, 103, 0.2);
            transition: var(--transition);
        }

        .user-profile:hover img {
            border-color: var(--primary-color);
            transform: scale(1.05);
        }

        .profile-dropdown {
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(226, 232, 240, 0.8);
        }

        .profile-dropdown-item {
            transition: var(--transition);
            padding: 12px 20px;
        }

        .profile-dropdown-item:hover {
            background: #ffffff;
            transform: translateX(4px);
        }

        .branch-selector {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 24px;
        }

        .branch-selector-label {
            font-size: 1rem;
            font-weight: 500;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .filter-dropdown {
            position: relative;
        }

        .filter-btn {
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: var(--border-radius);
            padding: 8px 16px;
            font-size: 0.9rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition);
        }

        .filter-btn:hover {
            background: rgba(17, 63, 103, 0.1);
        }

        .filter-dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            min-width: 200px;
            z-index: 1000;
        }

        .filter-dropdown-menu.show {
            display: block;
        }

        .filter-option {
            padding: 10px 16px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .filter-option:hover {
            background: rgba(17, 63, 103, 0.1);
        }

        .chart-row {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 24px;
        }

        .chart-section {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            padding: 20px;
            position: relative;
            flex: 1 1 auto;
            min-height: 400px;
            display: flex;
            flex-direction: column;
        }

        .chart-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-gradient);
        }

        .chart-section h5 {
            font-size: 1.5rem;
            font-weight: 600;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 16px;
        }

        .chart-content {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            align-items: flex-start;
        }

        .chart-container-wrapper {
            flex: 1;
            min-width: 300px;
            max-width: 50%;
        }

        .table-container {
            flex: 1;
            min-width: 300px;
            max-width: 50%;
        }

        .chart-container {
            position: relative;
            height: auto;
            min-height: 200px;
            max-height: 250px;
        }

        .chart-container canvas {
            height: 230px !important;
            width: 100% !important;
        }

        .patient-count {
            font-size: 2.5rem;
            font-weight: 700;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .revenue-label {
            font-size: 0.9rem;
            color: #666;
        }

        .period-controls {
            margin-top: 16px;
        }

        .dropdown-row {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: flex-end;
        }

        .dropdown-inline {
            display: flex;
            flex-direction: column;
            gap: 4px;
            min-width: 120px;
        }

        .dropdown-label {
            font-size: 0.9rem;
            font-weight: 500;
            color: #113F67;
        }

        .form-select-sm {
            font-size: 0.9rem;
            padding: 8px 12px;
            border-radius: 8px;
            border: 1px solid rgba(226, 232, 240, 0.8);
            transition: all 0.3s ease;
        }

        .form-select-sm:focus {
            border-color: #113F67;
            box-shadow: 0 0 0 3px rgba(17, 63, 103, 0.1);
            outline: none;
        }

        .apply-filter-btn {
            background: linear-gradient(135deg, #113F67 0%, #0d2f4d 100%);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 8px 24px;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            height: fit-content;
            margin-top: auto;
        }

        .apply-filter-btn:hover {
            background: linear-gradient(135deg, #0d2f4d 0%, #113F67 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(17, 63, 103, 0.3);
        }

        .apply-filter-btn:active {
            transform: translateY(0);
        }

        .apply-filter-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .apply-filter-btn .spinner {
            display: none;
            width: 14px;
            height: 14px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 0.8s linear infinite;
        }

        .apply-filter-btn.loading .spinner {
            display: inline-block;
        }

        .apply-filter-btn.loading .btn-text {
            display: none;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        @media (max-width: 576px) {
            .dropdown-row {
                flex-direction: column;
            }

            .dropdown-inline {
                width: 100%;
            }

            .apply-filter-btn {
                width: 100%;
                justify-content: center;
            }
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
        }

        .legend-color {
            width: 16px;
            height: 16px;
            border-radius: 4px;
        }

        .legend-percentage {
            font-weight: 500;
            color: var(--primary-color);
        }

        .table-responsive {
            border-radius: var(--border-radius);
            overflow-x: auto;
            max-height: 250px;
        }

        .table th,
        .table td {
            vertical-align: middle;
            font-size: 0.9rem;
        }

        .table thead th {
            background: var(--primary-gradient);
            color: white;
            font-weight: 500;
        }

        .table tbody tr:hover {
            background: rgba(17, 63, 103, 0.05);
        }

        .geography-section {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            padding: 20px;
            margin-bottom: 24px;
            position: relative;
        }

        .geography-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-gradient);
        }

        .geography-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .geography-title {
            font-size: 1.5rem;
            font-weight: 600;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .geography-filter {
            display: flex;
            gap: 10px;
        }

        .filter-btn-geo {
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: var(--border-radius);
            padding: 8px 16px;
            font-size: 0.9rem;
            font-weight: 500;
            transition: var(--transition);
        }

        .filter-btn-geo.active,
        .filter-btn-geo:hover {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .geography-content {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .map-container {
            flex: 1;
            min-width: 300px;
        }

        .location-list {
            flex: 1;
            min-width: 300px;
            max-height: 400px;
            overflow-y: auto;
            padding-right: 8px;
        }

        .location-list::-webkit-scrollbar {
            width: 8px;
        }

        .location-list::-webkit-scrollbar-track {
            background: #e2e8f0;
            border-radius: 4px;
        }

        .location-list::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 4px;
        }

        .location-list-header {
            font-size: 1.2rem;
            font-weight: 600;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 12px;
        }

        .location-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px;
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
            transition: var(--transition);
        }

        .location-item:hover {
            background: rgba(17, 63, 103, 0.05);
        }

        .location-name {
            font-weight: 500;
            color: var(--primary-color);
        }

        .location-address {
            font-size: 0.85rem;
            color: #666;
        }

        .location-stats {
            text-align: right;
        }

        .location-stats .patient-count {
            font-size: 1.2rem;
            font-weight: 700;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .location-stats .percentage {
            font-size: 0.9rem;
            color: var(--primary-color);
        }

        .progress-bar {
            width: 100px;
            height: 6px;
            background: #e2e8f0;
            border-radius: 3px;
            overflow: hidden;
            margin-top: 4px;
        }

        .progress-fill {
            height: 100%;
            background: var(--primary-gradient);
            transition: width var(--transition);
        }

        @media (max-width: 768px) {
            .geography-content {
                flex-direction: column;
            }

            .map-container,
            .location-list {
                min-width: 100%;
            }

            .map-container {
                height: 300px;
            }

            .location-list {
                max-height: 300px;
            }

            .chart-content {
                flex-direction: column;
            }

            .chart-container-wrapper,
            .table-container {
                max-width: 100%;
            }
        }

        @media (max-width: 576px) {

            .geography-title,
            .location-list-header {
                font-size: 1.2rem;
            }

            .filter-btn-geo {
                font-size: 0.8rem;
                padding: 6px 12px;
            }

            .branch-selector {
                flex-direction: column;
                align-items: flex-start;
            }

            .location-list {
                max-height: 250px;
            }
        }
        /* Custom Leaflet Tooltip Styles */
        .custom-tooltip {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border: 2px solid #667eea;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
            padding: 0;
            font-family: 'Inter', sans-serif;
            pointer-events: none;
        }

        .custom-tooltip::before {
            border-top-color: #667eea !important;
        }

        .leaflet-tooltip-top::before {
            border-top-color: #667eea !important;
        }

        /* Location Marker Hover Effect */
        .location-marker {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            outline: none !important; /* Remove focus outline */
        }

        /* Remove Leaflet's default interactive states */
        .leaflet-interactive:focus {
            outline: none !important;
        }

        .leaflet-interactive:active {
            outline: none !important;
        }

        /* Ensure all circle markers have consistent styling */
        path.leaflet-interactive {
            outline: none !important;
        }

        /* Remove any blue selection ring */
        svg.leaflet-zoom-animated path {
            outline: none !important;
        }
    </style>
</head>

<body>
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <div class="sidebar position-fixed top-0 start-0 vh-100 px-0" id="sidebar">
        <div class="position-sticky pt-3">
            <div class="sidebar-header text-center pb-3 border-bottom border-light border-opacity-25 mb-3">
                <div class="logo-container">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <img src="{{ asset('img/imglogo.png') }}" alt="Logo" class="rounded-circle shadow-sm"
                            width="50" height="50">
                    </div>
                    <h6 class="text-white fw-bold mb-0">Letty's Birthing Home</h6>
                </div>
                <button class="mobile-menu-btn d-md-none" id="mobileMenuBtnSidebar" aria-label="Close sidebar menu">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <nav class="nav flex-column px-2">
                <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('staff.dashboard') }}"
                    class="nav-link mb-1 {{ request()->routeIs(auth()->user()->role . '.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt me-2"></i>
                    <span>Dashboard</span>
                </a>

                <div class="mb-1 dropdown-menu-item {{ request()->is('patients*') ? 'open' : '' }}">
                    <a href="#patientsSubmenu" class="nav-link d-flex align-items-center" data-bs-toggle="collapse"
                        aria-expanded="{{ request()->is('patients*') ? 'true' : 'false' }}"
                        onclick="toggleDropdown(this)">
                        <span>
                            <i class="fas fa-users me-2"></i>
                            <span>Patients</span>
                        </span>
                        <i class="fas fa-chevron-down dropdown-icon"></i>
                    </a>
                    <div id="patientsSubmenu"
                        class="dropdown-submenu ms-3 collapse {{ request()->is('patients*') ? 'show' : '' }}">
                        <a href="{{ route('admin.currentPatients') }}"
                            class="nav-link py-1 small {{ request()->routeIs('admin.currentPatients') ? 'active' : '' }}">
                            <i class="fas fa-user me-2"></i>Current Patients
                        </a>
                        <a href="{{ route('admin.patientRecords') }}"
                            class="nav-link py-1 small {{ request()->routeIs('admin.patientRecords') ? 'active' : '' }}">
                            <i class="fas fa-file-medical me-2"></i>Patient Records
                        </a>
                    </div>
                </div>

                <div
                    class="mb-1 dropdown-menu-item {{ request()->is('appointments*') || request()->routeIs('allAppointments') ? 'open' : '' }}">
                    <a href="#appointmentsSubmenu" class="nav-link d-flex align-items-center" data-bs-toggle="collapse"
                        aria-expanded="{{ request()->is('appointments*') || request()->routeIs('allAppointments') ? 'true' : 'false' }}"
                        onclick="toggleDropdown(this)">
                        <span>
                            <i class="fas fa-calendar me-2"></i>
                            <span>Appointments</span>
                        </span>
                        <i class="fas fa-chevron-down dropdown-icon"></i>
                    </a>
                    <div id="appointmentsSubmenu"
                        class="dropdown-submenu ms-3 collapse {{ request()->is('appointments*') || request()->routeIs('allAppointments') ? 'show' : '' }}">
                        <a href="{{ route('admin.appointments') }}"
                            class="nav-link py-1 small {{ request()->routeIs('admin.appointments') ? 'active' : '' }}">
                            <i class="fas fa-calendar-check me-2"></i>Today's Appointments
                        </a>
                        <a href="{{ route('admin.allAppointments') }}"
                            class="nav-link py-1 small {{ request()->routeIs('admin.allAppointments') ? 'active' : '' }}">
                            <i class="fas fa-hourglass-half me-2"></i>All Appointments
                        </a>
                    </div>
                </div>

                <a href="{{ route('staffs') }}"
                    class="nav-link mb-1 {{ request()->routeIs('staffs') ? 'active' : '' }}">
                    <i class="fas fa-user-nurse me-2"></i>
                    <span>Staff</span>
                </a>

                <div class="mb-1 dropdown-menu-item {{ request()->is('admin/medication*') ? 'open' : '' }}">
                    <a href="#adminMedicationSubmenu" class="nav-link d-flex align-items-center"
                        data-bs-toggle="collapse"
                        aria-expanded="{{ request()->is('admin/medication*') ? 'true' : 'false' }}"
                        onclick="toggleDropdown(this)">
                        <span>
                            <i class="fas fa-prescription-bottle-medical me-2"></i>
                            <span>Medical Supply</span>
                        </span>
                        <i class="fas fa-chevron-down dropdown-icon"></i>
                    </a>
                    <div id="adminMedicationSubmenu"
                        class="dropdown-submenu ms-3 collapse {{ request()->is('admin/medication*') ? 'show' : '' }}">
                        <a href="{{ route('admin.inventory.medicines') }}"
                            class="nav-link py-1 small {{ request()->routeIs('admin.inventory.medicines') ? 'active' : '' }}">
                            <i class="fas fa-pills me-2"></i> Medicine
                        </a>
                        <a href="{{ route('admin.inventory.supplies') }}"
                            class="nav-link py-1 small {{ request()->routeIs('admin.inventory.supplies') ? 'active' : '' }}">
                            <i class="fas fa-boxes me-2"></i> Other Supply
                        </a>
                    </div>
                </div>

                <a href="{{ route('reports') }}"
                    class="nav-link mb-1 {{ request()->routeIs('reports') ? 'active' : '' }}">
                    <i class="fas fa-file-alt me-2"></i>
                    <span>Reports</span>
                </a>

                <a href="{{ route('admin.audit-logs') }}"
                    class="nav-link mb-1 {{ request()->routeIs('admin.audit-logs') ? 'active' : '' }}">
                    <i class="fas fa-file-alt me-2"></i>
                    <span>Audit Logs</span>
                </a>
            </nav>
        </div>
    </div>

    <main class="content p-4">
        <header class="main-header navbar navbar-expand-lg navbar-light sticky-top mb-4">
            <div class="container-fluid">
                <div class="d-flex align-items-center">
                    <button class="mobile-menu-btn d-md-none me-3" id="mobileMenuBtnHeader"
                        aria-label="Toggle sidebar menu">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h4 class="page-title mb-0">Reports</h4>
                </div>

                <div class="d-flex align-items-center header-right">
                    @include('partials.admin.notification')

                    @php
                        $user = Auth::user();
                        $avatar =
                            $user->admin && $user->admin->avatar_path
                                ? asset($user->admin->avatar_path)
                                : asset('img/adminProfile.jpg');
                    @endphp
                    <div class="dropdown user-profile">
                        <button class="btn btn-link p-1" data-bs-toggle="dropdown">
                            <img src="{{ $avatar }}" alt="Profile" class="rounded-circle" width="40"
                                height="40">
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end profile-dropdown">
                            <li><a class="dropdown-item profile-dropdown-item" href="{{ route('adminProfile') }}">
                                    <i class="fas fa-user-circle me-2"></i>My Profile
                                </a></li>

                            <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item profile-dropdown-item text-danger" href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </a></li>
                        </ul>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                            style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <div class="container-fluid main-content">
            <div class="branch-selector">
                <label for="branchSelect" class="branch-selector-label">
                    <i class="fas fa-building"></i> Select Branch:
                </label>
                <form method="GET" id="branchForm" action="{{ route('reports') }}">
                    <input type="hidden" name="branch" id="branchInput"
                        value="{{ $selectedBranch ?? 'Combined' }}">
                    <div class="filter-dropdown">
                        <button type="button" class="filter-btn" id="branchSelect" aria-label="Select branch"
                            aria-expanded="false">
                            <span class="selected-option">{{ $selectedBranch ?? 'Combined' }}</span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="filter-dropdown-menu" id="branchDropdownMenu">
                            <div class="filter-option" data-value="Combined">Combined</div>
                            <div class="filter-option" data-value="Santa Justina">Santa Justina</div>
                            <div class="filter-option" data-value="San Pedro">San Pedro</div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Combined Charts Section -->
            <div class="col-12">
                <div class="chart-section">
                    <h5>Patient Statistics Overview</h5>
                    <div class="chart-content">
                        <!-- Monthly Patient Count Chart -->
                        <div class="chart-container-wrapper">
                            <h6 class="mb-3">Monthly Patient Count</h6>
                            <div class="chart-container">
                                <canvas id="barChart" aria-label="Monthly patient count chart"></canvas>
                            </div>
                            <div class="mt-3">
                                <div class="patient-count">{{ $totalPatients ?? 145 }}</div>
                                <div class="period-controls">
                                    <div class="dropdown-row">
                                        <div class="dropdown-inline">
                                            <label class="dropdown-label" for="yearSelect">Year:</label>
                                            <select class="form-select form-select-sm" id="yearSelect">
                                                <option value="2023">2023</option>
                                                <option value="2024">2024</option>
                                                <option value="2025" selected>2025</option>
                                                <option value="2026">2026</option>
                                                <option value="2027">2027</option>
                                            </select>
                                        </div>
                                        <button class="apply-filter-btn" id="applyFilterBtn" type="button">
                                            <div class="spinner"></div>
                                            <i class="fas fa-filter btn-text"></i>
                                            <span class="btn-text">Apply Filter</span>
                                        </button>
                                        <button class="apply-filter-btn ms-2" id="downloadPdfBtn" type="button" onclick="downloadPdfCharts()" title="Download charts as PDF">
                                            <i class="fas fa-download btn-text"></i>
                                            <span class="btn-text">Download PDF</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Delivery Status Breakdown Chart -->
                        <div class="chart-container-wrapper">
                            <h6 class="mb-3">Delivery Status Breakdown</h6>
                            <div class="chart-container">
                                <canvas id="pieChart" aria-label="Delivery status breakdown chart"></canvas>
                            </div>
                            <div class="mt-3">
                                <div class="legend-item">
                                    <div class="legend-color" style="background-color: #FF6B6B;"></div>
                                    <span>Referred Delivery</span>
                                    <span class="legend-percentage" id="cancelledDelivery">30%</span>
                                </div>
                                <div class="legend-item">
                                    <div class="legend-color" style="background-color: #4CAF50;"></div>
                                    <span>Completed Delivery</span>
                                    <span class="legend-percentage" id="completedDelivery">70%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="geography-section">
                <div class="geography-header">
                    <h5 class="geography-title">Patient Geographical Distribution</h5>
                </div>
                <div class="geography-content">
                    <div class="map-container">
                        <div id="map"
                            style="height: 400px; width: 100%; background: #f0f0f0; border-radius: 8px; position: relative;">
                            <div
                                style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; color: #666;">
                                <i class="fas fa-map-marked-alt" style="font-size: 48px; margin-bottom: 15px;"></i>
                                <p>Map is loading...</p>
                            </div>
                        </div>
                    </div>
                    <div class="location-list">
                        <div class="location-list-header">Location Distribution</div>
                        @if ($locationData && $locationData->count() > 0)
                            @foreach ($locationData as $location)
                                <div class="location-item">
                                    <div class="location-info">
                                        <div class="location-name">{{ $location['name'] ?? 'Unknown Location' }}</div>
                                        <div class="location-address">{{ $location['address'] ?? 'Unknown Address' }}
                                        </div>
                                    </div>
                                    <div class="location-stats">
                                        <span class="patient-count">{{ $location['patient_count'] }}</span>
                                        <span class="percentage">{{ $location['percentage'] }}%</span>
                                        <div class="progress-bar">
                                            <div class="progress-fill"
                                                style="width: {{ $location['percentage'] }}%;"></div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="location-item">
                                <div class="location-info">
                                    <div class="location-name">No Data Available</div>
                                    <div class="location-address">Please add patient records</div>
                                </div>
                                <div class="location-stats">
                                    <span class="patient-count">0</span>
                                    <span class="percentage">0%</span>
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: 0%;"></div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script>
        // Register datalabels plugin if available
        if (typeof Chart !== 'undefined' && typeof ChartDataLabels !== 'undefined') {
            try {
                Chart.register(ChartDataLabels);
            } catch (e) {
                console.warn('ChartDataLabels registration skipped:', e);
            }
        }
        const mapLocations = @json($mapLocations ?? []);
        const chartData = @json($chartData ?? []);
        let currentBarChart;
        let currentPieChart;
        let chartDataFromServer = {};

        document.addEventListener("DOMContentLoaded", function() {
            const sidebar = document.getElementById("sidebar");
            const sidebarOverlay = document.getElementById("sidebarOverlay");
            const btnOpen = document.getElementById("mobileMenuBtnHeader");
            const btnClose = document.getElementById("mobileMenuBtnSidebar");
            const branchSelect = document.getElementById("branchSelect");
            const branchDropdownMenu = document.getElementById("branchDropdownMenu");
            const branchForm = document.getElementById("branchForm");
            const branchInput = document.getElementById("branchInput");

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

            branchSelect.addEventListener("click", function() {
                branchDropdownMenu.classList.toggle("show");
                branchSelect.setAttribute("aria-expanded", branchDropdownMenu.classList.contains("show"));
            });

            branchDropdownMenu.addEventListener("click", function(e) {
                if (e.target.classList.contains("filter-option")) {
                    const selectedBranch = e.target.getAttribute("data-value");
                    branchSelect.querySelector(".selected-option").textContent = selectedBranch;
                    branchInput.value = selectedBranch;
                    branchForm.submit();
                }
            });

            document.addEventListener("click", function(e) {
                if (!branchSelect.contains(e.target) && !branchDropdownMenu.contains(e.target)) {
                    branchDropdownMenu.classList.remove("show");
                    branchSelect.setAttribute("aria-expanded", "false");
                }
            });

            setTimeout(function() {
                if (typeof L !== 'undefined' && document.getElementById('map')) {
                    initializeMap();
                }
                initializeCharts();
            }, 300);

            function toggleDropdown(element) {
                const parent = element.parentElement;
                const isOpen = parent.classList.contains('open');
                document.querySelectorAll('.dropdown-menu-item').forEach(item => {
                    item.classList.remove('open');
                    item.querySelector('.dropdown-icon')?.classList.remove('rotate');
                });
                if (!isOpen) {
                    parent.classList.add('open');
                    element.querySelector('.dropdown-icon')?.classList.add('rotate');
                }
            }

            document.addEventListener('click', function(event) {
                if (!event.target.closest('.dropdown-menu-item')) {
                    document.querySelectorAll('.dropdown-menu-item').forEach(item => {
                        item.classList.remove('open');
                        item.querySelector('.dropdown-icon')?.classList.remove('rotate');
                    });
                }
            });

            document.querySelectorAll('.dropdown-submenu').forEach(submenu => {
                submenu.addEventListener('click', function(event) {
                    event.stopPropagation();
                });
            });
        });

        function initializeCharts() {
            if (typeof chartData !== 'undefined' && chartData) {
                chartDataFromServer = chartData;
                createBarChart();
                createPieChart();
                updatePatientCount();
            } else {
                loadChartData();
            }
            setupChartControls();
        }

        function setupChartControls() {
            const yearSelect = document.getElementById('yearSelect');
            const applyBtn = document.getElementById('applyFilterBtn');

            if (applyBtn) {
                applyBtn.addEventListener('click', function() {
                    updateChartsFromControls();
                });
            }

            // Allow Enter key to apply filter
            if (yearSelect) {
                yearSelect.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        updateChartsFromControls();
                    }
                });
            }
        }

        function updateChartsFromControls() {
            const year = parseInt(document.getElementById('yearSelect').value);
            const branch = document.getElementById('branchInput')?.value || 'Combined';
            const applyBtn = document.getElementById('applyFilterBtn');

            // Disable button and show loading state
            if (applyBtn) {
                applyBtn.disabled = true;
                applyBtn.classList.add('loading');
            }

            // Load chart data with selected year and current branch
            loadChartData(year, 1, 12, branch);
        }

        async function loadChartData(year = null, fromMonth = 1, toMonth = 12, branch = null) {
            const applyBtn = document.getElementById('applyFilterBtn');
            const chartContainer = document.querySelector('.chart-section');
            
            try {
                // Show loading state
                if (chartContainer) {
                    chartContainer.style.opacity = '0.6';
                    chartContainer.style.pointerEvents = 'none';
                }

                // Use current values if not provided
                const selectedYear = year || parseInt(document.getElementById('yearSelect').value);
                const selectedBranch = branch || document.getElementById('branchInput')?.value || 'Combined';

                // Build URL parameters
                const params = new URLSearchParams();
                params.append('year', selectedYear);
                params.append('from_month', fromMonth);
                params.append('to_month', toMonth);
                params.append('branch', selectedBranch);

                console.log('Fetching chart data with params:', {
                    year: selectedYear,
                    from_month: fromMonth,
                    to_month: toMonth,
                    branch: selectedBranch
                });

                // Fetch data from server
                const response = await fetch(`/admin/reports/chart-data?${params.toString()}`, {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();
                console.log('Received data from server:', data);
                
                // Validate data structure
                if (!data || typeof data !== 'object') {
                    throw new Error('Invalid data format received');
                }

                chartDataFromServer = data;

                // Update charts with new data
                createBarChart(data.monthly_counts, selectedYear, fromMonth, toMonth);
                createPieChart(data.delivery_breakdown);
                updatePatientCount(data.range_total, data.period);

                // Restore normal state
                if (chartContainer) {
                    chartContainer.style.opacity = '1';
                    chartContainer.style.pointerEvents = 'auto';
                }

                // Success feedback - using toast for better UX
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });

                Toast.fire({
                    icon: 'success',
                    title: 'Chart updated successfully'
                });

            } catch (error) {
                console.error('Error loading chart data:', error);
                
                // Show error message
                Swal.fire({
                    icon: 'error',
                    title: 'Error Loading Data',
                    text: error.message || 'Failed to load chart data. Please try again.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#113F67'
                });

                // Restore normal state
                if (chartContainer) {
                    chartContainer.style.opacity = '1';
                    chartContainer.style.pointerEvents = 'auto';
                }

            } finally {
                // Re-enable button and remove loading state
                if (applyBtn) {
                    applyBtn.disabled = false;
                    applyBtn.classList.remove('loading');
                }
            }
        }

        function createBarChart(monthlyData = null, year = null, fromMonth = 1, toMonth = 12) {
            const ctxBar = document.getElementById('barChart');
            if (!ctxBar) {
                console.error('Bar chart canvas not found');
                return;
            }

            const ctx = ctxBar.getContext('2d');
            
            // Destroy existing chart
            if (currentBarChart) {
                currentBarChart.destroy();
            }

            // Prepare chart data - initialize all 12 months to 0
            let chartDataArray = Array(12).fill(0);
            const selectedYear = year || new Date().getFullYear();
            const selectedFromMonth = fromMonth || 1;
            const selectedToMonth = toMonth || 12;

            // Process the data
            if (monthlyData && Array.isArray(monthlyData)) {
                // If monthlyData is already a 12-element array, use it directly
                if (monthlyData.length === 12) {
                    chartDataArray = monthlyData;
                } else {
                    // Otherwise, place filtered data in correct positions
                    for (let i = 0; i < monthlyData.length; i++) {
                        const monthIndex = selectedFromMonth - 1 + i;
                        if (monthIndex >= 0 && monthIndex < 12) {
                            chartDataArray[monthIndex] = monthlyData[i];
                        }
                    }
                }
            } else if (chartDataFromServer.monthly_counts && Array.isArray(chartDataFromServer.monthly_counts)) {
                if (chartDataFromServer.monthly_counts.length === 12) {
                    chartDataArray = chartDataFromServer.monthly_counts;
                } else {
                    for (let i = 0; i < chartDataFromServer.monthly_counts.length; i++) {
                        const monthIndex = selectedFromMonth - 1 + i;
                        if (monthIndex >= 0 && monthIndex < 12) {
                            chartDataArray[monthIndex] = chartDataFromServer.monthly_counts[i];
                        }
                    }
                }
            } else if (chartDataFromServer.monthly_counts && typeof chartDataFromServer.monthly_counts === 'object') {
                chartDataArray = chartDataFromServer.monthly_counts[selectedYear] || Array(12).fill(0);
            }

            console.log('Chart data array:', chartDataArray);
            console.log('Year:', selectedYear, 'From month:', selectedFromMonth, 'To month:', selectedToMonth);

            // Calculate dynamic max value
            const maxValue = Math.max(...chartDataArray);
            const suggestedMax = maxValue > 0 ? Math.ceil(maxValue * 1.15) : 10;

            // Calculate step size
            let stepSize;
            if (suggestedMax <= 10) {
                stepSize = 1;
            } else if (suggestedMax <= 50) {
                stepSize = 5;
            } else if (suggestedMax <= 100) {
                stepSize = 10;
            } else {
                stepSize = Math.ceil(suggestedMax / 10);
            }

            // Define colors for each month
            const baseColors = [
                '#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FCEA2B', '#FF9FF3',
                '#A8E6CF', '#FFD93D', '#6BCF7F', '#4D96FF', '#9B59B6', '#E67E22'
            ];

            // Create background colors array - all months fully visible
            const backgroundColors = baseColors.map(color => color);

            // Create chart
            currentBarChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                        label: 'Patient Count',
                        data: chartDataArray,
                        backgroundColor: backgroundColors,
                        borderRadius: {
                            topLeft: 8,
                            topRight: 8,
                            bottomLeft: 0,
                            bottomRight: 0
                        },
                        borderSkipped: false,
                        barPercentage: 0.85,
                        categoryPercentage: 0.9
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        datalabels: {
                            color: '#113F67',
                            anchor: 'end',
                            align: 'end',
                            font: { weight: '600', size: 12 },
                            formatter: function(value) { return value; }
                        },
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: function(context) {
                                const dataIndex = context.tooltip.dataPoints[0].dataIndex;
                                return baseColors[dataIndex];
                            },
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            padding: 12,
                            cornerRadius: 8,
                            displayColors: false,
                            callbacks: {
                                title: function(context) {
                                    return context[0].label + ' ' + selectedYear;
                                },
                                label: function(context) {
                                    return 'Patients: ' + context.parsed.y;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: suggestedMax,
                            grid: {
                                color: '#e2e8f0',
                                drawBorder: false
                            },
                            ticks: {
                                stepSize: stepSize,
                                color: '#666',
                                font: {
                                    size: 11,
                                    weight: '500'
                                },
                                padding: 8
                            },
                            border: {
                                display: false
                            }
                        },
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                color: '#666',
                                font: {
                                    size: 11,
                                    weight: '500'
                                },
                                padding: 8
                            },
                            border: {
                                display: false
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    }
                }
            });

            console.log('Bar chart created successfully');
        }

        function createPieChart(deliveryData = null) {
            const ctxPie = document.getElementById('pieChart');
            if (!ctxPie) {
                console.error('Pie chart canvas not found');
                return;
            }

            const ctx = ctxPie.getContext('2d');
            
            // Destroy existing chart
            if (currentPieChart) {
                currentPieChart.destroy();
            }

            // Prepare pie data
            let pieData = [0, 0]; // [Cancelled, Completed]
            
            if (deliveryData) {
                pieData = [
                    deliveryData.cancelled_delivery || 0,
                    deliveryData.completed_delivery || 0
                ];
            } else if (chartDataFromServer.delivery_breakdown) {
                const db = chartDataFromServer.delivery_breakdown;
                pieData = [
                    db.cancelled_delivery || 0,
                    db.completed_delivery || 0
                ];
            }

            // Create chart
            currentPieChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Referred Delivery', 'Completed Delivery'],
                    datasets: [{
                        data: pieData,
                        backgroundColor: ['#FF6B6B', '#4CAF50'],
                        borderWidth: 0,
                        cutout: '70%'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        datalabels: {
                            color: '#ffffff',
                            anchor: 'center',
                            align: 'center',
                            font: { weight: '700', size: 12 },
                            formatter: function(value, context) {
                                const total = context.chart.data.datasets[0].data.reduce((a, b) => a + b, 0) || 0;
                                const pct = total > 0 ? Math.round((value / total) * 100) : 0;
                                return value + ' (' + pct + '%)';
                            }
                        },
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const total = pieData[0] + pieData[1];
                                    const percentage = total > 0 ? Math.round((context.parsed / total) * 100) : 0;
                                    return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                                }
                            }
                        }
                    }
                }
            });

            // Update legend with counts and percentages
            const cancelledEl = document.getElementById('cancelledDelivery');
            const completedEl = document.getElementById('completedDelivery');
            const total = pieData.reduce((a, b) => a + b, 0) || 0;
            const cancelledPct = total > 0 ? Math.round((pieData[0] / total) * 100) : 0;
            const completedPct = total > 0 ? Math.round((pieData[1] / total) * 100) : 0;
            if (cancelledEl) cancelledEl.textContent = `${pieData[0]} (${cancelledPct}%)`;
            if (completedEl) completedEl.textContent = `${pieData[1]} (${completedPct}%)`;

            console.log('Pie chart created with data:', pieData);
        }

        function updatePatientCount(total = null, period = null) {
            const countElement = document.querySelector('.patient-count');
            const labelElement = document.querySelector('.revenue-label');

            if (countElement) {
                const displayTotal = total !== null && total !== undefined ? total : (chartDataFromServer.range_total || chartDataFromServer.total_patients || 0);
                countElement.textContent = displayTotal;
            }

            if (labelElement && period) {
                const monthNames = ['January', 'February', 'March', 'April', 'May', 'June',
                    'July', 'August', 'September', 'October', 'November', 'December'
                ];
                const fromMonthName = monthNames[period.from_month - 1];
                const toMonthName = monthNames[period.to_month - 1];
                labelElement.textContent = `From ${fromMonthName} to ${toMonthName} ${period.year}`;
            } else if (labelElement && chartDataFromServer.period) {
                const p = chartDataFromServer.period;
                const monthNames = ['January', 'February', 'March', 'April', 'May', 'June',
                    'July', 'August', 'September', 'October', 'November', 'December'
                ];
                const fromMonthName = monthNames[p.from_month - 1];
                const toMonthName = monthNames[p.to_month - 1];
                labelElement.textContent = `From ${fromMonthName} to ${toMonthName} ${p.year}`;
            }
        }

        let map;
        let markersLayer;

        function initializeMap() {
            try {
                map = L.map('map').setView([13.4322, 123.5175], 12);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: 'Buhi, Camarines Sur'
                }).addTo(map);
                markersLayer = L.layerGroup().addTo(map);

                if (typeof mapLocations !== 'undefined' && mapLocations.length > 0) {
                    geocodeAndDisplayLocations(mapLocations);
                } else {
                    loadLocationData('all');
                }
            } catch (error) {
                console.error('Map initialization error:', error);
                document.getElementById('map').innerHTML = `
                    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; color: #666;">
                        <i class="fas fa-map-marked-alt" style="font-size: 48px; margin-bottom: 15px;"></i>
                        <p>Map unavailable</p>
                        <small>Geographic data visualization</small>
                    </div>
                `;
            }
        }

        async function geocodeAndDisplayLocations(locations) {
            const geocodePromises = locations.map(location => geocodeAddress(location));
            try {
                const results = await Promise.allSettled(geocodePromises);
                results.forEach((result, index) => {
                    if (result.status === 'fulfilled' && result.value) {
                        addMarkerToMap(result.value, locations[index]);
                    } else {
                        console.warn(`Failed to geocode: ${locations[index].full_address}`);
                    }
                });

                if (markersLayer.getLayers().length > 0) {
                    map.fitBounds(markersLayer.getBounds(), {
                        padding: [20, 20]
                    });
                }
            } catch (error) {
                console.error('Error geocoding locations:', error);
            }
        }

        async function geocodeAddress(location) {
            try {
                const response = await fetch(
                    `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(location.full_address)}&limit=1`
                );
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const data = await response.json();
                if (data && data.length > 0) {
                    return {
                        lat: parseFloat(data[0].lat),
                        lng: parseFloat(data[0].lon)
                    };
                }
                return null;
            } catch (error) {
                console.error(`Geocoding error for ${location.full_address}:`, error);
                return null;
            }
        }

        function addMarkerToMap(coordinates, locationData) {
            if (!coordinates || !coordinates.lat || !coordinates.lng) return;

            // Calculate marker size based on patient count with better scaling
            const baseSize = 8;
            const scaleFactor = 3;
            const markerSize = Math.max(baseSize, Math.min(40, baseSize + Math.sqrt(locationData.patient_count) * scaleFactor));

            const marker = L.circleMarker([coordinates.lat, coordinates.lng], {
                radius: markerSize,
                fillColor: '#667eea',
                color: '#fff',
                weight: 2,
                opacity: 1,
                fillOpacity: 0.7,
                className: 'location-marker',
                bubblingMouseEvents: false,
                interactive: true,
                keyboard: false // Disable keyboard interaction to prevent focus state
            });

            // Create tooltip that follows cursor
            const tooltipContent = `
                <div style="text-align: center; min-width: 150px; padding: 8px;">
                    <strong style="display: block; margin-bottom: 5px; color: #113F67; font-size: 15px;">${locationData.name}</strong>
                    <small style="display: block; color: #666; margin-bottom: 5px; font-size: 12px;">${locationData.full_address}</small>
                    <span style="color: #667eea; font-weight: bold; font-size: 16px;">${locationData.patient_count} patient${locationData.patient_count !== 1 ? 's' : ''}</span>
                </div>
            `;

            // Bind tooltip that shows on hover - positioned away from cursor
            marker.bindTooltip(tooltipContent, {
                permanent: false,
                direction: 'top',
                offset: [0, -markerSize - 5], // Dynamic offset based on marker size
                opacity: 0.95,
                className: 'custom-tooltip',
                interactive: false // Prevents tooltip from intercepting mouse events
            });

            // Add hover effects with debouncing
            let hoverTimeout;
            
            marker.on('mouseover', function(e) {
                clearTimeout(hoverTimeout);
                this.setStyle({
                    fillOpacity: 1,
                    weight: 3,
                    fillColor: '#113F67'
                });
                this.openTooltip();
            });

            marker.on('mouseout', function(e) {
                clearTimeout(hoverTimeout);
                hoverTimeout = setTimeout(() => {
                    this.setStyle({
                        fillOpacity: 0.7,
                        weight: 2,
                        fillColor: '#667eea'
                    });
                }, 50); // Small delay to prevent flickering
            });

            markersLayer.addLayer(marker);
        }

        async function loadLocationData(timeframe = 'all') {
            try {
                const branch = document.getElementById('branchInput')?.value || 'Combined';
                const params = new URLSearchParams({
                    timeframe: timeframe,
                    branch: branch
                });

                const response = await fetch(`/admin/reports/location-data?${params.toString()}`, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();
                console.log('Location data received:', data);

                // Clear existing markers
                if (markersLayer) {
                    markersLayer.clearLayers();
                }

                // Update the location list
                updateLocationList(data.locations || data);

                // Update map markers
                if (data.locations && data.locations.length > 0) {
                    await geocodeAndDisplayLocations(data.locations);
                } else if (data.length > 0) {
                    await geocodeAndDisplayLocations(data);
                } else {
                    // Show "no data" message on map
                    console.log('No location data available');
                }

                // Show success toast
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true
                });

                Toast.fire({
                    icon: 'success',
                    title: `Filtered: ${timeframe === 'all' ? 'All Time' : timeframe === 'month' ? 'This Month' : 'This Quarter'}`
                });

            } catch (error) {
                console.error('Error loading location data:', error);
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error Loading Locations',
                    text: 'Failed to load location data. Please try again.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#113F67'
                });
            }
        }

        function filterByTimeframe(timeframe) {
            // Update active button state
            document.querySelectorAll('.filter-btn-geo').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.classList.add('active');
            
            // Show loading state on the map
            const mapContainer = document.getElementById('map');
            const originalContent = mapContainer.innerHTML;
            
            mapContainer.style.opacity = '0.6';
            mapContainer.style.pointerEvents = 'none';
            
            // Load new location data
            loadLocationData(timeframe).finally(() => {
                mapContainer.style.opacity = '1';
                mapContainer.style.pointerEvents = 'auto';
            });
        }
        function updateLocationList(locations) {
            const locationList = document.querySelector('.location-list');
            if (!locationList) return;

            // Keep the header
            const header = locationList.querySelector('.location-list-header');
            
            if (!locations || locations.length === 0) {
                locationList.innerHTML = `
                    <div class="location-list-header">Location Distribution</div>
                    <div class="location-item">
                        <div class="location-info">
                            <div class="location-name">No Data Available</div>
                            <div class="location-address">No patients found for this period</div>
                        </div>
                        <div class="location-stats">
                            <span class="patient-count">0</span>
                            <span class="percentage">0%</span>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 0%;"></div>
                            </div>
                        </div>
                    </div>
                `;
                return;
            }

            // Calculate total for percentages
            const total = locations.reduce((sum, loc) => sum + (loc.patient_count || 0), 0);

            // Generate location items HTML
            const itemsHTML = locations.map(location => {
                const percentage = total > 0 ? ((location.patient_count / total) * 100).toFixed(1) : 0;
                return `
                    <div class="location-item">
                        <div class="location-info">
                            <div class="location-name">${location.name || 'Unknown Location'}</div>
                            <div class="location-address">${location.address || location.full_address || 'Unknown Address'}</div>
                        </div>
                        <div class="location-stats">
                            <span class="patient-count">${location.patient_count || 0}</span>
                            <span class="percentage">${percentage}%</span>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: ${percentage}%;"></div>
                            </div>
                        </div>
                    </div>
                `;
            }).join('');

            locationList.innerHTML = `
                <div class="location-list-header">Location Distribution</div>
                ${itemsHTML}
            `;
        }

        // (Print button removed) PDF download remains via downloadPdfCharts()

        // Download charts as PDF using html2canvas + jsPDF
        async function downloadPdfCharts() {
            try {
                const downloadBtn = document.getElementById('downloadPdfBtn');
                if (downloadBtn) { downloadBtn.disabled = true; }

                // Try to get monthly data from chartDataFromServer or currentBarChart
                let monthlyCounts = null;
                const monthLabels = ['January','February','March','April','May','June','July','August','September','October','November','December'];

                if (chartDataFromServer && chartDataFromServer.monthly_counts) {
                    if (Array.isArray(chartDataFromServer.monthly_counts)) {
                        monthlyCounts = chartDataFromServer.monthly_counts.slice(0,12);
                    } else if (typeof chartDataFromServer.monthly_counts === 'object') {
                        // pick selected year if available
                        const year = (chartDataFromServer.period && chartDataFromServer.period.year) || document.getElementById('yearSelect')?.value;
                        monthlyCounts = chartDataFromServer.monthly_counts[year] || null;
                    }
                }

                if ((!monthlyCounts || monthlyCounts.length === 0) && window.currentBarChart && currentBarChart.data && currentBarChart.data.datasets && currentBarChart.data.datasets[0]) {
                    monthlyCounts = currentBarChart.data.datasets[0].data.slice(0,12);
                }

                // Fallback to zeros
                if (!monthlyCounts || monthlyCounts.length === 0) {
                    monthlyCounts = Array(12).fill(0);
                }

                // Create PDF
                const pdf = new jspdf.jsPDF({ orientation: 'portrait', unit: 'px', format: 'a4' });
                const pageWidth = pdf.internal.pageSize.getWidth();
                let cursorY = 20;

                // Render a styled header DOM node and capture as image via html2canvas
                const logoUrl = "{{ asset('img/imglogo.png') }}";
                const headerHtml = `
                    <div style="width:820px; padding:15px 30px; box-sizing:border-box; background:#fff; border-bottom:2px solid #333; display:flex; align-items:center; justify-content:center; position:relative; font-family: 'Inter', sans-serif;">
                        <div style="position:absolute; left:30px; width:70px; height:70px; border-radius:50%; overflow:hidden; display:flex; align-items:center; justify-content:center;">
                            <img src="${logoUrl}" style="width:100%; height:100%; object-fit:cover; display:block;" />
                        </div>
                        <div style="text-align:center;">
                            <div style="font-size:18px; font-weight:700; color:#333;">Letty's Birthing Home</div>
                            <div style="font-size:11px; color:#333;">Buhi Camarines Sur, Philippines</div>
                            <div style="font-size:11px; color:#333;">Professional Birthing and Maternity Care Services</div>
                        </div>
                    </div>
                `;

                const tempDiv = document.createElement('div');
                tempDiv.style.position = 'fixed';
                tempDiv.style.left = '-9999px';
                tempDiv.style.top = '0';
                tempDiv.innerHTML = headerHtml;
                document.body.appendChild(tempDiv);

                const headerCanvas = await html2canvas(tempDiv, { scale: 2, backgroundColor: '#ffffff' });
                const headerImg = headerCanvas.toDataURL('image/png');
                // Clean up temp node
                document.body.removeChild(tempDiv);

                const imgPropsH = pdf.getImageProperties(headerImg);
                const headerMaxW = pageWidth - 40; // margin 20 each side
                const headerRatio = imgPropsH.width / imgPropsH.height;
                const headerWidth = headerMaxW;
                const headerHeight = Math.round(headerWidth / headerRatio);

                pdf.addImage(headerImg, 'PNG', 20, cursorY, headerWidth, headerHeight);
                cursorY += headerHeight + 12;

                // Subheader - branch and period (right/left)
                const branch = document.getElementById('branchInput')?.value || 'Combined';
                const year = document.getElementById('yearSelect')?.value || '';
                pdf.setFontSize(11);
                pdf.setTextColor('#333');
                pdf.text(`Branch: ${branch}`, 40, cursorY);
                pdf.text(`Year: ${year}`, pageWidth - 140, cursorY);
                cursorY += 18;

                // Add month-by-month counts as two-column list
                pdf.setFontSize(12);
                pdf.text('Monthly Patient Counts:', 40, cursorY);
                cursorY += 16;

                const colX1 = 40;
                const colX2 = pageWidth / 2 + 10;
                const rowHeight = 16;

                for (let i = 0; i < 6; i++) {
                    const m1 = monthLabels[i];
                    const v1 = monthlyCounts[i] !== undefined ? monthlyCounts[i] : 0;
                    const m2 = monthLabels[i + 6];
                    const v2 = monthlyCounts[i + 6] !== undefined ? monthlyCounts[i + 6] : 0;

                    pdf.text(`${m1}: ${v1}`, colX1, cursorY);
                    pdf.text(`${m2}: ${v2}`, colX2, cursorY);
                    cursorY += rowHeight;
                }

                cursorY += 8;

                // Add bar chart image (if available)
                const barCanvas = document.getElementById('barChart');
                if (barCanvas) {
                    const barImg = barCanvas.toDataURL('image/png');
                    const maxImgWidth = pageWidth - 80;
                    const imgProps = pdf.getImageProperties(barImg);
                    const imgRatio = imgProps.width / imgProps.height;
                    const imgWidth = maxImgWidth;
                    const imgHeight = Math.round(imgWidth / imgRatio);

                    if (cursorY + imgHeight > pdf.internal.pageSize.getHeight() - 40) {
                        pdf.addPage();
                        cursorY = 20;
                    }
                    pdf.text('Monthly Patient Count Chart', 40, cursorY);
                    cursorY += 10;
                    pdf.addImage(barImg, 'PNG', 40, cursorY, imgWidth, imgHeight);
                    cursorY += imgHeight + 12;
                }

                // Add Delivery Status Breakdown counts (like monthly counts)
                let deliveryCounts = [0,0];
                if (chartDataFromServer && chartDataFromServer.delivery_breakdown) {
                    const db = chartDataFromServer.delivery_breakdown;
                    deliveryCounts = [db.cancelled_delivery || 0, db.completed_delivery || 0];
                } else if (typeof pieData !== 'undefined' && pieData && Array.isArray(pieData)) {
                    deliveryCounts = pieData.slice(0,2);
                } else if (window.currentPieChart && currentPieChart.data && currentPieChart.data.datasets && currentPieChart.data.datasets[0]) {
                    deliveryCounts = currentPieChart.data.datasets[0].data.slice(0,2);
                }

                const deliveryTotal = (deliveryCounts[0] || 0) + (deliveryCounts[1] || 0);
                const delCancelledPct = deliveryTotal > 0 ? Math.round((deliveryCounts[0] / deliveryTotal) * 100) : 0;
                const delCompletedPct = deliveryTotal > 0 ? Math.round((deliveryCounts[1] / deliveryTotal) * 100) : 0;

                pdf.setFontSize(12);
                pdf.text('Delivery Status Breakdown:', 40, cursorY);
                cursorY += 14;
                pdf.setFontSize(11);
                pdf.text(`Referred Delivery: ${deliveryCounts[0]} (${delCancelledPct}%)`, 50, cursorY);
                cursorY += 14;
                pdf.text(`Completed Delivery: ${deliveryCounts[1]} (${delCompletedPct}%)`, 50, cursorY);
                cursorY += 18;

                // Add pie chart image (if available)
                const pieCanvas = document.getElementById('pieChart');
                if (pieCanvas) {
                    const pieImg = pieCanvas.toDataURL('image/png');
                    const maxImgWidth = 260; // keep pie smaller
                    const imgProps2 = pdf.getImageProperties(pieImg);
                    const imgRatio2 = imgProps2.width / imgProps2.height;
                    const imgWidth2 = Math.min(maxImgWidth, pageWidth - 80);
                    const imgHeight2 = Math.round(imgWidth2 / imgRatio2);

                    if (cursorY + imgHeight2 > pdf.internal.pageSize.getHeight() - 40) {
                        pdf.addPage();
                        cursorY = 20;
                    }
                    pdf.text('Delivery Status Chart', 40, cursorY);
                    cursorY += 10;
                    pdf.addImage(pieImg, 'PNG', 40, cursorY, imgWidth2, imgHeight2);
                    cursorY += imgHeight2 + 12;
                }

                pdf.save(`reports-charts-${branch.replace(/\s+/g, '-')}-${year}.pdf`);

                if (downloadBtn) { downloadBtn.disabled = false; }

                const Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 1500, timerProgressBar: true });
                Toast.fire({ icon: 'success', title: 'PDF downloaded' });

            } catch (err) {
                console.error('PDF generation error:', err);
                Swal.fire({ icon: 'error', title: 'PDF Error', text: 'Failed to generate PDF. Try printing via browser.' });
                const downloadBtn = document.getElementById('downloadPdfBtn');
                if (downloadBtn) { downloadBtn.disabled = false; }
            }
        }

        @if (session('swal'))
            Swal.fire({
                icon: '{{ session('swal.icon') }}',
                title: '{{ session('swal.title') }}',
                text: '{{ session('swal.text') }}',
                confirmButtonText: 'OK',
                confirmButtonColor: 'var(--primary-color)'
            });
        @endif
    </script>
</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Letty\'s Birthing Home - Staff Dashboard')</title>

    <!-- Keep design resources (matching admin) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('img/imglogo.png') }}">

 <style>
        :root {
            --primary-color: #113F67;
            --primary-dark: #0d2f4d;
            --primary-light: #1a4d7a;
            --primary-gradient: linear-gradient(135deg, #113F67 0%, #0d2f4d 100%);
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --info-color: #3b82f6;
            --light-bg: #f8fafc;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --card-shadow-hover: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --border-radius: 12px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --sidebar-width: 250px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
        }

        .sidebar {
            background: var(--primary-gradient);
            box-shadow: var(--card-shadow);
            backdrop-filter: blur(20px);
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
            position: relative;
            overflow: hidden;
        }

        .sidebar .nav-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: #fff;
            transform: scaleY(0);
            transition: var(--transition);
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff !important;
            background: rgba(255, 255, 255, 0.15);
            transform: translateX(8px);
        }

        .sidebar .nav-link.active::before {
            transform: scaleY(1);
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
            transition: transform var(--transition), color var(--transition);
        }

        .dropdown-icon.rotate {
            transform: rotate(180deg);
        }

        .content {
            margin-left: var(--sidebar-width);
            transition: margin-left var(--transition);
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
                width: var(--sidebar-width);
                z-index: 1055;
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
                backdrop-filter: blur(4px);
            }

            .sidebar-overlay.show {
                display: block;
                animation: fadeIn 0.3s ease-out;
            }

            .sidebar-header {
                position: relative;
                padding: 15px;
            }

            .logo-container {
                display: flex;
                flex-direction: column;
                align-items: center;
                text-align: center;
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

        .stat-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            transition: var(--transition);
            position: relative;
            overflow: visible !important; /* Added: Prevent hiding in mobile */
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-gradient);
        }

        .stat-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: var(--card-shadow-hover);
        }

        .stat-icon {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            color: white;
            font-size: 26px;
            position: relative;
            overflow: hidden;
            display: flex !important; /* Added: Ensure flex centering */
            align-items: center;
            justify-content: center;
        }

        .stat-icon::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .stat-card:hover .stat-icon::before {
            left: 100%;
        }

        .stat-icon.patients {
            background: linear-gradient(135deg, var(--info-color), #2563eb);
        }

        .stat-icon.appointments {
            background: linear-gradient(135deg, var(--success-color), #059669);
        }

        .stat-icon.missed {
            background: linear-gradient(135deg, var(--warning-color), #d97706);
        }

        .stat-icon.reports {
            background: linear-gradient(135deg, var(--danger-color), #dc2626);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .main-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
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
            box-shadow: var(--card-shadow-hover);
            border: 1px solid rgba(226, 232, 240, 0.8);
            overflow: hidden;
            min-width: 350px;
            max-width: 90vw;
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
                min-width: unset !important;
                max-width: unset !important;
                border-radius: 0 0 var(--border-radius) var(--border-radius);
                z-index: 1050;
                max-height: 70vh;
                overflow-y: auto;
            }
        }

        .notification-dropdown li {
            list-style: none;
        }

        .notification-dropdown.show {
            display: block;
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
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
            background: var(--danger-color) !important;
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

        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: 1040;
            display: none;
            backdrop-filter: blur(4px);
        }

        .sidebar-overlay.show {
            display: block;
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
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
            box-shadow: var(--card-shadow-hover);
            border: 1px solid rgba(226, 232, 240, 0.8);
            overflow: hidden;
        }

        .profile-dropdown-item {
            transition: var(--transition);
            padding: 12px 20px;
        }

        .profile-dropdown-item:hover {
            background: #ffffff;
            transform: translateX(4px);
        }

        /* Custom Calendar Styles */
        .calendar-section {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            padding: 20px;
            margin-top: 24px;
            position: relative;
            overflow: hidden;
        }

        .calendar-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-gradient);
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e2e8f0;
            background: #ffffff;
            flex-wrap: wrap;
            gap: 10px;
        }

        .calendar-title {
            font-size: 1.6rem;
            font-weight: 600;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        #calendarMonthYear {
            font-size: 1.4rem;
            font-weight: 500;
            color: var(--primary-dark);
        }

        .calendar-title i {
            color: var(--primary-dark);
        }

        .calendar-controls {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .calendar-btn {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: var(--border-radius);
            font-size: 0.9rem;
            font-weight: 500;
            transition: var(--transition);
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .calendar-btn:hover {
            background: linear-gradient(135deg, #0d2f4d 0%, #082544 100%);
            transform: scale(1.05);
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 4px;
            background: #ffffff;
        }

        .calendar-day-header {
            font-weight: 600;
            color: var(--primary-color);
            padding: 8px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: var(--border-radius);
            text-align: center;
            font-size: 0.9rem;
        }

        .calendar-day {
            padding: 10px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: var(--border-radius);
            transition: var(--transition);
            cursor: pointer;
            position: relative;
            min-height: 120px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            overflow: hidden;
        }

        .calendar-day:hover {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transform: scale(1.02);
        }

        .calendar-day.empty {
            background: transparent;
            border: none;
            cursor: default;
            min-height: 120px;
        }

        .calendar-day.today {
            background: var(--primary-color);
            color: white;
            font-weight: 600;
            border-color: transparent;
        }

        .calendar-day.today .day-number,
        .calendar-day.today .event {
            color: white;
        }

        .calendar-day .day-number {
            font-size: 1rem;
            font-weight: 500;
            margin-bottom: 4px;
            color: var(--primary-dark);
            order: -1;
        }

        .calendar-day .events-container {
            flex: 1;
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 2px;
            overflow-y: auto;
            max-height: 100%;
            scrollbar-width: thin;
            scrollbar-color: #e2e8f0 transparent;
        }

        .calendar-day .event {
            font-size: 0.7rem;
            color: var(--primary-dark);
            background: #e6f0fa;
            padding: 2px 6px;
            border-radius: 4px;
            text-align: left;
            line-height: 1.2;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            cursor: pointer;
        }

        .calendar-day.today .event {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        /* Responsive Adjustments */
        @media (max-width: 992px) {
            .calendar-grid {
                grid-template-columns: repeat(7, 1fr);
                gap: 3px;
            }

            .calendar-day {
                padding: 8px;
                min-height: 100px;
            }

            .calendar-day.empty {
                min-height: 100px;
            }

            .calendar-day .day-number {
                font-size: 0.9rem;
            }

            .calendar-day .event {
                font-size: 0.65rem;
                padding: 2px 4px;
            }

            .calendar-title {
                font-size: 1.4rem;
            }

            #calendarMonthYear {
                font-size: 1.2rem;
            }

            .calendar-btn {
                font-size: 0.8rem;
                padding: 6px 12px;
            }

            .calendar-day-header {
                font-size: 0.8rem;
                padding: 6px;
            }
        }

        @media (max-width: 768px) {
            .calendar-grid {
                grid-template-columns: repeat(7, 1fr);
                gap: 2px;
            }

            .calendar-day {
                padding: 6px;
                min-height: 80px;
            }

            .calendar-day.empty {
                min-height: 80px;
            }

            .calendar-day .day-number {
                font-size: 0.8rem;
            }

            .calendar-day .event {
                font-size: 0.6rem;
                padding: 1px 3px;
            }

            .calendar-title {
                font-size: 1.3rem;
            }

            #calendarMonthYear {
                font-size: 1.1rem;
            }

            .calendar-btn {
                font-size: 0.75rem;
                padding: 5px 10px;
            }

            .calendar-day-header {
                font-size: 0.75rem;
                padding: 5px;
            }
        }

        @media (max-width: 576px) {
            .calendar-section {
                padding: 15px;
            }

            .calendar-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .calendar-title {
                font-size: 1.2rem;
            }

            #calendarMonthYear {
                font-size: 1rem;
            }

            .calendar-controls {
                width: 100%;
                justify-content: flex-end;
            }

            .calendar-btn {
                font-size: 0.7rem;
                padding: 4px 8px;
            }

            .calendar-grid {
                grid-template-columns: repeat(7, 1fr);
                gap: 1px;
            }

            .calendar-day {
                padding: 4px;
                min-height: 60px;
            }

            .calendar-day.empty {
                min-height: 60px;
            }

            .calendar-day .day-number {
                font-size: 0.7rem;
            }

            .calendar-day .event {
                font-size: 0.55rem;
                padding: 1px 2px;
            }

            .calendar-day-header {
                font-size: 0.7rem;
                padding: 4px;
            }
        }

        @media (max-width: 400px) {
            .calendar-grid {
                grid-template-columns: repeat(7, 1fr);
                gap: 1px;
            }

            .calendar-day {
                padding: 3px;
                min-height: 50px;
            }

            .calendar-day.empty {
                min-height: 50px;
            }

            .calendar-day .day-number {
                font-size: 0.65rem;
            }

            .calendar-day .event {
                font-size: 0.5rem;
                padding: 1px;
            }

            .calendar-day-header {
                font-size: 0.65rem;
                padding: 3px;
            }
        }

        @media (prefers-color-scheme: dark) {
            .calendar-section {
                background: #ffffff;
                border: 1px solid #e2e8f0;
            }

            .calendar-header {
                background: #ffffff;
                border-bottom: 1px solid #e2e8f0;
            }

            .calendar-grid {
                background: #ffffff;
            }

            .calendar-day {
                background: #ffffff;
                border: 1px solid #e2e8f0;
                color: var(--primary-dark);
            }

            .calendar-day:hover {
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }

            .calendar-day.today {
                background: var(--primary-color);
                color: white;
            }

            .calendar-day.today .day-number,
            .calendar-day.today .event {
                color: white;
            }

            .calendar-day .day-number {
                color: var(--primary-dark);
            }

            .calendar-day .event {
                color: var(--primary-dark);
                background: #e6f0fa;
            }

            .calendar-day-header {
                background: #ffffff;
                border: 1px solid #e2e8f0;
                color: var(--primary-color);
            }
        }

        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }

       

        /* Modal Styles */
        .modal-content {
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow-hover);
        }

        .modal-header {
            background: var(--primary-gradient);
            color: white;
        }

        .modal-body {
            padding: 20px;
        }

        /* Responsive Modal Styles */
        .modal-dialog {
            max-width: 500px;
            margin: 1.75rem auto;
        }

        @media (max-width: 576px) {
            .modal-dialog {
                max-width: 90vw;
                margin: 1rem auto;
            }

            .modal-content {
                border-radius: calc(var(--border-radius) * 0.75);
            }

            .modal-body {
                padding: 15px;
            }

            .modal-header {
                padding: 12px 15px;
            }

            .modal-footer {
                padding: 10px 15px;
            }

            .modal-title {
                font-size: 1.2rem;
            }

            .btn-close {
                font-size: 0.9rem;
            }
        }

        @media (max-width: 400px) {
            .modal-dialog {
                max-width: 95vw;
                margin: 0.5rem auto;
            }

            .modal-body {
                padding: 10px;
            }

            .modal-title {
                font-size: 1rem;
            }
        }

        /* Branch Selector Styles */
        .branch-selector {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .branch-selector-label {
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
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: var(--border-radius);
            font-size: 0.9rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition);
        }

        .filter-btn:hover {
            background: linear-gradient(135deg, #0d2f4d 0%, #082544 100%);
            transform: scale(1.05);
        }

        .filter-dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            min-width: 150px;
            z-index: 1000;
            display: none;
        }

        .filter-dropdown-menu.show {
            display: block;
            animation: slideDown 0.3s ease-out;
        }

        .filter-option {
            padding: 8px 16px;
            font-size: 0.9rem;
            color: var(--primary-dark);
            cursor: pointer;
            transition: var(--transition);
        }

        .filter-option:hover {
            background: #f0f0f0;
            transform: translateX(4px);
        }

        /* Audit Logs Styles */
        .audit-logs-section {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            padding: 20px;
            margin-top: 24px;
            position: relative;
            overflow: hidden;
        }

        .audit-logs-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-gradient);
        }

        .audit-logs-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e2e8f0;
            flex-wrap: wrap;
            gap: 10px;
        }

        .audit-logs-title {
            font-size: 1.6rem;
            font-weight: 600;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .audit-logs-table-container {
            overflow-x: auto;
        }

        .audit-logs-table {
            width: 100%;
            border-collapse: collapse;
        }

        .audit-logs-table th,
        .audit-logs-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        .audit-logs-table th {
            background: #f8fafc;
            font-weight: 600;
            color: var(--primary-color);
        }

        .audit-logs-table td {
            color: var(--primary-dark);
        }

        .audit-logs-table tr:hover {
            background: #f0f0f0;
        }

        /* Responsive fixes for stat cards and icons */
        @media (max-width: 576px) {
            .stat-card .card-body {
                padding: 1rem !important; /* Reduced padding sa mobile para mas fit */
                flex-direction: row; /* Siguraduhing horizontal pa rin */
                align-items: center;
                overflow: visible !important; /* Prevent hiding */
            }

            .stat-icon {
                width: 48px !important; /* Smaller icon sa mobile */
                height: 48px !important;
                font-size: 20px !important; /* Smaller font para sa icon */
                min-width: 48px; /* Prevent shrinking too much */
                flex-shrink: 0; /* Don't shrink the icon */
                margin-right: 0.75rem !important; /* Adjusted spacing */
            }

            .stat-number {
                font-size: 2rem !important; /* Smaller number */
            }

            .flex-grow-1 {
                overflow: hidden; /* Prevent text overflow */
            }

            .text-muted {
                font-size: 0.875rem; /* Smaller text */
            }

            /* Extra: Kung dalawang cards per row ay masikip, pwde stack vertically pero keep col-6 */
            .stats-row .col-6 {
                padding-left: 0.5rem;
                padding-right: 0.5rem;
            }
        }

        /* Para sa mas maliit pa (e.g., very small phones) */
        @media (max-width: 400px) {
            .stat-icon {
                width: 40px !important;
                height: 40px !important;
                font-size: 18px !important;
            }

            .stat-number {
                font-size: 1.75rem !important;
            }

            .stat-card .card-body {
                padding: 0.75rem !important;
            }
        }

        /* ===========================
           Layout + UI changes to prioritize today's appointments
           while preserving the original look & feel.
           =========================== */

        /* Top area: stats */
        .top-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin-bottom: 1.25rem;
        }

        /* Main dashboard split: left = appointments, right = charts + staff */
        .dashboard-top {
            display: grid;
            grid-template-columns: 1fr 360px;
            gap: 1.25rem;
            align-items: start;
        }

        /* Appointment list card */
        .appointments-card {
            background: linear-gradient(135deg, #ffffff 0%, #fbfdff 100%);
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            padding: 0.75rem;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .appointments-card .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.6rem 0.75rem;
            border-bottom: 1px solid rgba(226,232,240,0.6);
        }

        .appointment-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 0.6rem;
            border-radius: 10px;
            transition: var(--transition);
        }

        .appointment-item:hover {
            background: rgba(17, 63, 103, 0.04);
            transform: translateY(-4px);
        }

        .appointment-left {
            display: flex;
            gap: 0.75rem;
            align-items: center;
            min-width: 0;
            overflow: hidden;
        }

        .appointment-time {
            min-width: 62px;
            text-align: center;
            padding: 6px 8px;
            border-radius: 8px;
            background: linear-gradient(135deg, #eef6ff, #ffffff);
            color: var(--primary-dark);
            font-weight: 700;
            font-size: 0.95rem;
            border: 1px solid rgba(226,232,240,0.8);
        }

        .appointment-meta {
            overflow: hidden;
        }

        .appointment-client {
            font-weight: 700;
            color: var(--primary-dark);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .appointment-reason {
            color: #6b7280;
            font-size: 0.85rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .badge-branch {
            background: rgba(17,63,103,0.08);
            color: var(--primary-dark);
            border-radius: 8px;
            padding: 4px 8px;
            font-weight: 600;
            font-size: 0.75rem;
        }

        .right-column .panel {
            background: #fff;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            padding: 0.75rem;
            margin-bottom: 1rem;
        }

        .staff-list .staff-member {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 0;
            border-bottom: 1px dashed rgba(0,0,0,0.04);
        }

        .staff-list .staff-member:last-child { border-bottom: none; }

        .staff-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(17,63,103,0.06);
        }

        .chart-canvas {
            width: 100% !important;
            height: 160px !important;
        }

        .calendar-compact {
            margin-top: 0.75rem;
            background: #fff;
            border-radius: var(--border-radius);
            padding: 0.75rem;
            box-shadow: var(--card-shadow);
        }

        .cancelled-today-panel .cancelled-badge {
            background: rgba(239, 68, 68, 0.12);
            color: #b91c1c;
            border-radius: 999px;
            padding: 0.2rem 0.75rem;
            font-weight: 600;
        }

        .cancelled-today-panel .cancelled-item {
            display: flex;
            gap: 0.75rem;
            padding: 0.65rem 0;
            border-bottom: 1px dashed rgba(15, 23, 42, 0.08);
        }

        .cancelled-today-panel .cancelled-item:last-child {
            border-bottom: none;
        }

        .cancelled-today-panel .cancelled-time {
            font-weight: 600;
            color: var(--primary-dark);
            font-size: 0.95rem;
        }

        .cancelled-today-panel .cancelled-client {
            font-weight: 600;
            color: #0f172a;
        }

        .cancelled-today-panel .cancelled-reason {
            font-size: 0.8rem;
        }

        /* Appointments by Branch - improved styles */
        .branch-chart-panel {
            display: flex;
            gap: 0.75rem;
            align-items: flex-start;
            flex-direction: column;
        }

        .branch-chart-container {
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-direction: column;
        }

        .appointments-branch-chart-wrapper {
            width: 100%;
        }

        .branch-stats {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }

        .branch-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            justify-content: space-between;
        }

        .branch-left {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            min-width: 0;
            overflow: hidden;
        }

        .branch-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            flex-shrink: 0;
            border: 1px solid rgba(0,0,0,0.06);
        }

        .branch-name {
            font-weight: 600;
            color: var(--primary-dark);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 160px;
        }

        .branch-meta {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .branch-count {
            font-weight: 700;
            color: var(--primary-dark);
            min-width: 36px;
            text-align: right;
        }

        .branch-progress {
            height: 8px;
            background: #f1f5f9;
            border-radius: 999px;
            overflow: hidden;
            flex: 1;
            margin-left: 12px;
            margin-right: 12px;
        }

        .branch-progress > i {
            display: block;
            height: 100%;
            border-radius: 999px;
        }

        .no-branch-data {
            text-align: center;
            color: #6b7280;
            padding: 12px;
            border: 1px dashed #e6eef8;
            border-radius: 8px;
            background: #fbfdff;
        }

        /* Responsive tweaks */
        @media (max-width: 1200px) {
            .dashboard-top { grid-template-columns: 1fr 320px; }
        }

        @media (max-width: 992px) {
            .content { margin-left: 0; padding: 1rem; }
            .dashboard-top { grid-template-columns: 1fr; }
            .top-stats { grid-template-columns: repeat(2,1fr); }
            .appointments-branch-chart-wrapper { width: 100%; }
        }

        @media (max-width: 576px) {
            .top-stats { grid-template-columns: 1fr; }
            .appointment-time { min-width: 56px; font-size: .85rem; }
            .appointments-branch-chart-wrapper { width: 100%; }
        }
    </style>
</head>

<body data-role="{{ auth()->user()->role }}">
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
                <a href="{{ route('staff.dashboard') }}"
                    class="nav-link mb-1 {{ request()->routeIs('staff.dashboard') ? 'active' : '' }}">
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
                        <a href="{{ route('currentPatients') }}"
                            class="nav-link py-1 small {{ request()->routeIs('currentPatients') ? 'active' : '' }}">
                            <i class="fas fa-user me-2"></i>Current Patients
                        </a>
                        <a href="{{ route('completeVisits') }}"
                            class="nav-link py-1 small {{ request()->routeIs('completeVisits') ? 'active' : '' }}">
                            <i class="fas fa-check-circle me-2"></i>Complete Visit
                        </a>
                        <a href="{{ route('patientRecords') }}"
                            class="nav-link py-1 small {{ request()->routeIs('patientRecords') ? 'active' : '' }}">
                            <i class="fas fa-file-medical me-2"></i>Patient Records
                        </a>

                        <a href="{{ route('patientMedication.history') }}"
                            class="nav-link py-1 small {{ request()->routeIs('patientMedication.history') ? 'active' : '' }}">
                            <i class="fas fa-pills me-2"></i>Medication History
                        </a>

                    </div>
                </div>


                <div
                    class="mb-1 dropdown-menu-item {{ request()->is('staff/allAppointments*') || request()->routeIs('allAppointments') ? 'open' : '' }}">
                    <a href="#appointmentsSubmenu" class="nav-link d-flex align-items-center" data-bs-toggle="collapse"
                        aria-expanded="{{ request()->is('staff/allAppointments*') || request()->routeIs('allAppointments') ? 'true' : 'false' }}"
                        onclick="toggleDropdown(this)">
                        <span>
                            <i class="fas fa-calendar me-2"></i>
                            <span>Appointments</span>
                        </span>
                        <i class="fas fa-chevron-down dropdown-icon"></i>
                    </a>
                    <div id="appointmentsSubmenu"
                        class="dropdown-submenu ms-3 collapse {{ request()->is('staff/allAppointments*') || request()->routeIs('allAppointments') ? 'show' : '' }}">
                        <a href="{{ route('todaysAppointments') }}"
                            class="nav-link py-1 small {{ request()->routeIs('todaysAppointments') ? 'active' : '' }}">
                            <i class="fas fa-calendar-check me-2"></i>Today's Appointment
                        </a>
                        <a href="{{ route('pendingAppointment') }}"
                            class="nav-link py-1 small {{ request()->routeIs('pendingAppointment') ? 'active' : '' }}">
                            <i class="fas fa-hourglass-half me-2"></i>Pending Appointment
                        </a>
                    </div>
                </div>



            </nav>
        </div>
    </div>


    <main class="content p-4">
     <header class="main-header navbar navbar-expand-lg navbar-light sticky-top mb-4">
         <div class="container-fluid">
             <div class="d-flex align-items-center">
                 <button class="mobile-menu-btn d-md-none me-3" id="mobileMenuBtnHeader" aria-label="Toggle sidebar menu">
                     <i class="fas fa-bars"></i>
                 </button>
                 <h4 class="page-title mb-0">Staff Dashboard</h4>

             </div>

             <div class="d-flex align-items-center header-right">
                 <!-- Notification Dropdown -->
                   @include('partials.staff.notification')


                 <!-- Profile Dropdown -->
                 @php
                     $staff = Auth::user()->staff;
                     $avatar =
                         $staff && $staff->avatar_path ? asset($staff->avatar_path) : asset('img/adminProfile.jpg');
                 @endphp
                 <div class="dropdown user-profile">
                     <button class="btn btn-link p-1" data-bs-toggle="dropdown">
                         <img src="{{ $avatar }}" alt="Profile" class="rounded-circle" width="40"
                             height="40">
                     </button>
                     <ul class="dropdown-menu dropdown-menu-end profile-dropdown">
                         <li><a class="dropdown-item profile-dropdown-item" href="{{ route('staffProfile') }}">
                                 <i class="fas fa-user-circle me-2"></i>My Profile
                             </a></li>
                         <li><a class="dropdown-item profile-dropdown-item" href="{{ route('schedules') }}">
                                 <i class="fas fa-calendar-check me-2"></i>My Schedule
                             </a></li>
                         <li>
                             <hr class="dropdown-divider">
                         </li>
                         <li><a class="dropdown-item profile-dropdown-item text-danger" href="#"
                                 onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                 <i class="fas fa-sign-out-alt me-2"></i>Logout
                             </a></li>
                     </ul>
                     <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                         @csrf
                     </form>
                 </div>
             </div>
         </div>
     </header>


        <div class="container-fluid main-content">
            <!-- Top quick stats (same look as admin) -->
            <div class="top-stats" role="list">
                <div class="stat-card p-3" role="listitem">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-muted small">Total Patients</div>
                            <div class="stat-number h4 mb-0" id="statTotalPatients">{{ $totalPatients ?? 0 }}</div>
                        </div>
                        <div class="text-end">
                            <i class="fas fa-users fa-2x text-secondary"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card p-3" role="listitem">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-muted small">Today's Appointments</div>
                            <div class="stat-number h4 mb-0" id="statTodaysAppointments">{{ $todaysAppointments ?? 0 }}</div>
                        </div>
                        <div class="text-end">
                            <i class="fas fa-calendar-check fa-2x text-success"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card p-3" role="listitem">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-muted small">Completed Visits</div>
                            <div class="stat-number h4 mb-0" id="statCompleted">{{ $completedVisits ?? 0 }}</div>
                        </div>
                        <div class="text-end">
                            <i class="fas fa-circle-check fa-2x text-info"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card p-3" role="listitem">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                          <div class="text-muted small">Cancelled Appointments</div>
                          <div class="stat-number h4 mb-0" id="statCancelled">{{ $cancelledAppointments ?? 0 }}</div>

                        </div>
                        <div class="text-end">
                            <i class="fas fa-clock fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Top Area: Left = appointments priority, Right = charts + quick actions -->
            <div class="dashboard-top">
                <!-- Left Column: Today's Appointments + compact calendar -->
                <section>
                    <div class="appointments-card" id="appointmentsCard" data-refresh-url="{{ $appointmentsRefreshUrl ?? '' }}">
                        <div class="card-header">
                            <h5 class="mb-0">Today's Appointments</h5>
                            <div class="d-flex align-items-center gap-2">
                                <button class="btn btn-sm btn-outline-secondary" id="refreshAppointments" title="Refresh" aria-label="Refresh appointments"><i class="fas fa-sync-alt"></i></button>
                                <a class="btn btn-sm btn-primary" id="viewAll" href="{{ route('todaysAppointments') }}">View All</a>
                            </div>
                        </div>

                        <div id="appointmentsList" class="appointments-list overflow-auto" style="max-height:520px; padding:0.5rem;">
                            <!-- populated by JS -->
                        </div>

                        <div class="text-muted small mt-2">Showing your upcoming appointments for today.</div>
                    </div>

                    <!-- Compact calendar (kept, collapsed by default) -->
                    <div class="mt-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <h6 class="mb-0">Calendar</h6>
                            <button class="btn btn-sm btn-outline-primary calendar-toggle-btn" data-bs-toggle="collapse" data-bs-target="#calendarCollapse" aria-expanded="false">
                                <i class="fas fa-calendar-alt"></i> Show / Hide
                            </button>
                        </div>

                        <div class="collapse mt-2" id="calendarCollapse">
                            <div class="calendar-compact">
                                <div class="calendar-header d-flex justify-content-between align-items-center mb-2">
                                    <div class="calendar-title">
                                        <i class="fas fa-calendar-alt me-2"></i>
                                        <span id="calendarTitleCompact">Appointment Calendar</span>
                                    </div>
                                    <div>
                                        <button class="btn btn-sm btn-outline-secondary me-1" id="prevMonthSmall"><i class="fas fa-chevron-left"></i></button>
                                        <button class="btn btn-sm btn-outline-secondary me-1" id="todayBtnSmall">Today</button>
                                        <button class="btn btn-sm btn-outline-secondary" id="nextMonthSmall"><i class="fas fa-chevron-right"></i></button>
                                    </div>
                                </div>

                                <div id="calendarGridSmall" class="calendar-grid" aria-live="polite" aria-atomic="true">
                                    <!-- lightweight calendar placeholder (events shown here when expanded) -->
                                </div>

                                <div class="mt-2 text-muted small">Click an event to view details.</div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Right Column -->
                <aside class="right-column">
                    <div class="panel">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="mb-0">Appointments by Hour (Today)</h6>
                            <small class="text-muted" id="chartSubtitle">Updated</small>
                        </div>
                        <canvas id="appointmentsHourChart" class="chart-canvas mb-2"></canvas>
                    </div>

                    <div class="panel cancelled-today-panel">
                        @php $cancelledCount = count($cancelledTodayList ?? []); @endphp
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h6 class="mb-0">Cancelled Appointments (Today)</h6>
                                <small class="text-muted">Auto-updated from the latest schedule</small>
                            </div>
                            <span class="cancelled-badge">{{ $cancelledCount }}</span>
                        </div>

                        <div class="cancelled-list" aria-live="polite" aria-atomic="true">
                            @forelse(($cancelledTodayList ?? []) as $cancelled)
                                <div class="cancelled-item">
                                    <div class="flex-grow-1">
                                        <div class="cancelled-time">{{ $cancelled['time_label'] ?? '—' }}</div>
                                        <div class="cancelled-client">{{ $cancelled['client'] ?? 'Unknown' }}</div>
                                        @if(!empty($cancelled['reason']))
                                            <div class="cancelled-reason text-muted">{{ $cancelled['reason'] }}</div>
                                        @else
                                            <div class="cancelled-reason text-muted">No reason provided.</div>
                                        @endif
                                        @if(!empty($cancelled['branch']))
                                            <div class="text-muted small">{{ $cancelled['branch'] }}</div>
                                        @endif
                                    </div>
                                    @if(!empty($cancelled['view_url']))
                                        <div>
                                            <a href="{{ $cancelled['view_url'] }}" class="btn btn-sm btn-outline-secondary" title="Open appointment">
                                                <i class="fas fa-external-link-alt"></i>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div class="text-muted small">No cancellations recorded for today.</div>
                            @endforelse
                        </div>
                    </div>

                    <div class="panel">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="mb-0">Quick Actions</h6>
                        </div>
                        <div class="d-grid gap-2">
                            <a href="{{ route('addPatient') }}" class="btn btn-outline-primary btn-sm"><i class="fas fa-user-plus me-2"></i>New Patient</a>
                            <a href="{{ route('addAppointment') }}" class="btn btn-outline-success btn-sm"><i class="fas fa-calendar-plus me-2"></i>New Appointment</a>
                            <a href="{{ route('patientRecords') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-file-medical me-2"></i>Patient Records</a>
                        </div>
                    </div>
                </aside>
            </div>

            <!-- Event Modal (kept) -->
            <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="eventModalLabel">Appointment Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Client:</strong> <span id="modalClient"></span></p>
                            <p><strong>Reason:</strong> <span id="modalReason"></span></p>
                            <p><strong>Time:</strong> <span id="modalTime"></span></p>
                            <!-- Branch removed from modal as per request -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
          
        </div>
    </main>

    <div id="emergency-container">
        @include('partials.emergencyModal')
    </div>

    <!-- Server data to JS (staffOnDuty removed) -->
    @php
        // Compute a simple PHP variable to avoid complex expressions inside @json
        $jsSelectedBranch = $selectedBranch ?? optional(Auth::user()->staff->branch)->name ?? 'Combined';
    @endphp
    <script>
        const appointments = @json($todaysAppointmentsList ?? []); // array of appointment objects
        const calendarEvents = @json($calendarEvents ?? []);
        const selectedBranch = @json($jsSelectedBranch);
    </script>

    <!-- Scripts -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('script/emergency.js') }}"></script>

    <script>
        @if (session('swal'))
            Swal.fire({
                icon: '{{ session('swal.icon') }}',
                title: '{{ session('swal.title') }}',
                text: '{{ session('swal.text') }}',
                confirmButtonText: 'OK',
                confirmButtonColor: 'var(--primary-color)'
            });
        @endif

        document.addEventListener("DOMContentLoaded", function() {
            // Sidebar mobile controls
            const sidebar = document.getElementById("sidebar");
            const sidebarOverlay = document.getElementById("sidebarOverlay");
            const btnOpen = document.getElementById("mobileMenuBtnHeader");
            const btnClose = document.getElementById("mobileMenuBtnSidebar");
            if (btnOpen) btnOpen.addEventListener("click", function() {
                sidebar.classList.add("mobile-show");
                sidebarOverlay.classList.add("show");
            });
            if (btnClose) btnClose.addEventListener("click", function() {
                sidebar.classList.remove("mobile-show");
                sidebarOverlay.classList.remove("show");
            });
            if (sidebarOverlay) sidebarOverlay.addEventListener("click", function() {
                sidebar.classList.remove("mobile-show");
                this.classList.remove("show");
            });

            // Utilities for parsing & formatting
            function parseAppointmentDate(appt) {
                if (!appt) return new Date();
                if (appt.datetime) return new Date(appt.datetime);
                if (appt.date && appt.time) {
                    const dp = appt.date.split('-').map(Number);
                    const tp = String(appt.time).split(':').map(Number);
                    return new Date(dp[0], dp[1]-1, dp[2], tp[0] || 0, tp[1] || 0);
                }
                if (appt.time && appt.date === undefined) {
                    const d = new Date(appt.time);
                    if (!isNaN(d)) return d;
                }
                return new Date();
            }

            function formatTime12(time) {
                if (!time && time !== 0) return '';
                if (time instanceof Date) {
                    let h = time.getHours();
                    const m = time.getMinutes();
                    const ampm = h >= 12 ? 'PM' : 'AM';
                    h = h % 12; h = h ? h : 12;
                    return `${h}:${String(m).padStart(2,'0')} ${ampm}`;
                }
                if (typeof time === 'string' && time.indexOf('T') !== -1) {
                    const d = new Date(time);
                    if (!isNaN(d)) return formatTime12(d);
                }
                const parts = String(time).split(':').map(Number);
                if (parts.length < 2 || isNaN(parts[0])) return String(time);
                let h = parts[0];
                const m = parts[1] || 0;
                const ampm = h >= 12 ? 'PM' : 'AM';
                h = h % 12; h = h ? h : 12;
                return `${h}:${String(m).padStart(2,'0')} ${ampm}`;
            }

            // Today's date
            const today = new Date();
            const pad = n => String(n).padStart(2, '0');
            const todayStr = `${today.getFullYear()}-${pad(today.getMonth()+1)}-${pad(today.getDate())}`;

            function getTodaysAppointments() {
                return (appointments || [])
                    .filter(a => (selectedBranch === 'Combined' || !selectedBranch || a.branch === selectedBranch))
                    .filter(a => (a.date ? a.date === todayStr : (a.datetime ? new Date(a.datetime).toISOString().slice(0,10) === todayStr : true)))
                    .map(a => ({ ...a, datetime: parseAppointmentDate(a) }))
                    .sort((x,y) => new Date(x.datetime) - new Date(y.datetime));
            }

            // Render appointments list
            function renderAppointmentsList() {
                const list = document.getElementById('appointmentsList');
                list.innerHTML = '';
                const todays = getTodaysAppointments();
                const maxShow = 8;

                if (!todays.length) {
                    list.innerHTML = '<div class="text-muted p-3">No appointments scheduled for today.</div>';
                    const statEl = document.getElementById('statTodaysAppointments');
                    if (statEl) statEl.textContent = 0;
                    return;
                }

                todays.slice(0, maxShow).forEach(appt => {
                    const item = document.createElement('div');
                    item.className = 'appointment-item';
                    item.tabIndex = 0;

                    const left = document.createElement('div');
                    left.className = 'appointment-left';

                    const time = document.createElement('div');
                    time.className = 'appointment-time';
                    time.textContent = formatTime12(appt.time || appt.start_time || appt.datetime);

                    const meta = document.createElement('div');
                    meta.className = 'appointment-meta';

                    const client = document.createElement('div');
                    client.className = 'appointment-client';
                    client.textContent = appt.client_name || appt.client || appt.patient_name || 'No name';

                    const reason = document.createElement('div');
                    reason.className = 'appointment-reason';
                    reason.textContent = appt.reason || appt.note || '';

                    meta.appendChild(client);
                    meta.appendChild(reason);

                    left.appendChild(time);
                    left.appendChild(meta);

                    const right = document.createElement('div');
                    right.className = 'd-flex align-items-center gap-2';

                    const viewBtn = document.createElement('button');
                    viewBtn.className = 'btn btn-sm btn-outline-primary';
                    viewBtn.innerHTML = '<i class="fas fa-eye"></i>';
                    viewBtn.addEventListener('click', () => showAppointmentModal(appt));

                    right.appendChild(viewBtn);

                    if (appt.view_url) {
                        const ext = document.createElement('a');
                        ext.href = appt.view_url;
                        ext.className = 'btn btn-sm btn-outline-secondary';
                        ext.innerHTML = '<i class="fas fa-external-link-alt"></i>';
                        right.appendChild(ext);
                    }

                    item.appendChild(left);
                    item.appendChild(right);
                    list.appendChild(item);
                });

                if (todays.length > maxShow) {
                    const more = document.createElement('div');
                    more.className = 'text-center text-muted small mt-2';
                    more.textContent = `+ ${todays.length - maxShow} more appointments today — click "View All" to see them.`;
                    list.appendChild(more);
                }

                const statEl = document.getElementById('statTodaysAppointments');
                if (statEl) statEl.textContent = todays.length;
            }

            // Modal
            const eventModal = new bootstrap.Modal(document.getElementById('eventModal'));
            function showAppointmentModal(appt) {
                // prefer explicit client/reason fields; if not present, try to parse from a combined title
                let client = appt.client_name || appt.client || appt.patient_name || '';
                let reason = appt.reason || appt.note || appt.description || '';

                // If title exists and either client or reason is missing, attempt to split on common separators
                if (appt.title && (!client || !reason)) {
                    const parts = String(appt.title).split(/\s*[—–-]\s*/);
                    if (parts.length > 1) {
                        // first part is client, rest joined is reason
                        client = client || parts[0] || client;
                        reason = reason || parts.slice(1).join(' — ');
                    } else if (!client) {
                        client = appt.title;
                    }
                }

                const time = formatTime12(appt.time || appt.start_time || appt.datetime || appt.start || appt.time);

                document.getElementById('modalClient').textContent = client || '—';
                document.getElementById('modalReason').textContent = reason || '—';
                document.getElementById('modalTime').textContent = time || '—';

                // No 'Open' button in modal — just show details
                eventModal.show();
            }

            // Hour chart
            let hourChart = null;
            function renderHourChart() {
                const todays = getTodaysAppointments();
                const hours = Array.from({length:24}, (_,i) => i);
                const countsByHour = hours.map(h => todays.filter(a => new Date(a.datetime).getHours() === h).length);
                const ctx = document.getElementById('appointmentsHourChart')?.getContext('2d');
                if (!ctx) return;
                if (hourChart) hourChart.destroy();
                hourChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: hours.map(h => {
                            const ampm = h >= 12 ? 'PM' : 'AM';
                            let hour12 = h % 12;
                            hour12 = hour12 ? hour12 : 12;
                            return `${hour12} ${ampm}`;
                        }),
                        datasets: [{
                            label: 'Appointments',
                            data: countsByHour,
                            backgroundColor: countsByHour.map(v => v > 0 ? 'rgba(59,130,246,0.95)' : 'rgba(59,130,246,0.12)'),
                            borderRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: { legend: { display: false } },
                        scales: { x: { grid: { display:false } }, y: { beginAtZero:true, ticks:{ stepSize:1 } } },
                        interaction: { intersect: false, mode: 'index' }
                    }
                });
            }

            // Compact calendar rendering (lightweight)
            let calendarRendered = false;
            function renderSmallCalendar() {
                if (calendarRendered) return;
                calendarRendered = true;
                const grid = document.getElementById('calendarGridSmall');
                if (!grid) return;
                grid.innerHTML = '';

                const days = ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"];
                days.forEach(day => {
                    const dh = document.createElement('div');
                    dh.className = 'calendar-day-header';
                    dh.textContent = day;
                    grid.appendChild(dh);
                });

                const now = new Date();
                const month = now.getMonth();
                const year = now.getFullYear();
                const daysInMonth = new Date(year, month+1, 0).getDate();

                for (let d = 1; d <= daysInMonth; d++) {
                    const cell = document.createElement('div');
                    cell.className = 'calendar-day';
                    const dayNumber = document.createElement('div');
                    dayNumber.className = 'day-number';
                    dayNumber.textContent = d;
                    const eventsContainer = document.createElement('div');
                    eventsContainer.className = 'events-container';

                    const dateStr = `${year}-${String(month+1).padStart(2,'0')}-${String(d).padStart(2,'0')}`;

                    // Combine server-provided calendarEvents with appointments (if any) so month view shows both.
                    const apptEvents = (appointments || []).map(a => ({
                        date: a.date || (a.datetime ? new Date(a.datetime).toISOString().slice(0,10) : null),
                        time: a.time || a.start_time || (a.datetime ? new Date(a.datetime).toTimeString().slice(0,5) : null),
                        client: a.client_name || a.client || a.patient_name || a.title || '',
                        appointment: a,
                        view_url: a.view_url || null
                    }));

                    const combined = ((calendarEvents || []).concat(apptEvents)).filter(e => e && e.date === dateStr);

                    combined.slice(0,2).forEach(ev => {
                        const evDiv = document.createElement('div');
                        evDiv.className = 'event';
                        const label = ev.time ? `${formatTime12(ev.time)} ${ev.client || ev.title || ''}` : (ev.client || ev.title || 'Event');
                        evDiv.textContent = label;
                        evDiv.addEventListener('click', (e) => {
                            e.preventDefault();
                            if (ev.appointment) showAppointmentModal(ev.appointment);
                            else showAppointmentModal(ev);
                        });
                        eventsContainer.appendChild(evDiv);
                    });

                    cell.appendChild(dayNumber);
                    cell.appendChild(eventsContainer);
                    grid.appendChild(cell);
                }
            }

            // render when collapse opens
            document.getElementById('calendarCollapse')?.addEventListener('shown.bs.collapse', renderSmallCalendar);

            // Initial renders
            renderAppointmentsList();
            renderHourChart();
            // staff on duty removed

            // Refresh button behavior (tries to fetch refresh url)
            document.getElementById('refreshAppointments')?.addEventListener('click', function() {
                const card = document.getElementById('appointmentsCard');
                const refreshUrl = card?.dataset?.refreshUrl || '';
                if (!refreshUrl) {
                    renderAppointmentsList();
                    renderHourChart();
                    Swal.fire({ toast:true, position:'top-end', icon:'success', title:'Dashboard refreshed', showConfirmButton:false, timer:1200 });
                    return;
                }
                fetch(refreshUrl, {
                    method: 'GET',
                    headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
                    credentials: 'same-origin'
                })
                .then(r => r.ok ? r.json() : Promise.reject(r))
                .then(data => {
                    const newAppts = data.appointments ?? data.data ?? [];
                    while (appointments.length) appointments.pop();
                    newAppts.forEach(a => appointments.push(a));
                    if (typeof data.count !== 'undefined') {
                        const statEl = document.getElementById('statTodaysAppointments');
                        if (statEl) statEl.textContent = data.count;
                    }
                    renderAppointmentsList();
                    renderHourChart();
                    Swal.fire({ toast:true, position:'top-end', icon:'success', title:'Dashboard refreshed', showConfirmButton:false, timer:1200 });
                })
                .catch(() => {
                    renderAppointmentsList();
                    Swal.fire({ toast:true, position:'top-end', icon:'warning', title:'Could not refresh', showConfirmButton:false, timer:1200 });
                });
            });

            // expose toggleDropdown for sidebar submenu toggles
            window.toggleDropdown = function(element) {
                const icon = element.querySelector('.dropdown-icon');
                icon && icon.classList.toggle('rotate');
            };

            // keyboard accessibility for appointment items
            document.getElementById('appointmentsList')?.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    const target = e.target.closest('.appointment-item');
                    if (target) target.querySelector('button')?.click();
                }
            });
        });
    </script>
</body>

</html>
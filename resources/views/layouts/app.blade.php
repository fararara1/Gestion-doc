<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'GestDoc'))</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/choices.js/11.0.13/choices.min.css" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap');

        :root {
            --gold-400: #facc15;
            --gold-500: #eab308;
            --gold-600: #ca8a04;
            --gold-700: #a16207;
            --gold-50: #fefce8;
            --navy-900: #0f172a;
            --navy-800: #1e293b;
            --navy-700: #334155;
            --navy-600: #475569;
            --navy-50: #f8fafc;
            --radius-sm: 8px;
            --radius: 12px;
            --radius-lg: 16px;
            --radius-xl: 20px;
            --shadow-xs: 0 1px 2px 0 rgb(0 0 0 / 0.03);
            --shadow-sm: 0 1px 3px 0 rgb(0 0 0 / 0.04), 0 1px 2px -1px rgb(0 0 0 / 0.04);
            --shadow: 0 4px 12px -2px rgb(0 0 0 / 0.05), 0 2px 4px -2px rgb(0 0 0 / 0.03);
            --shadow-md: 0 6px 16px -4px rgb(0 0 0 / 0.06), 0 2px 6px -2px rgb(0 0 0 / 0.04);
            --shadow-lg: 0 12px 24px -8px rgb(0 0 0 / 0.08), 0 4px 8px -4px rgb(0 0 0 / 0.04);
            --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #f1f5f9;
            color: var(--navy-900);
            line-height: 1.6;
            font-size: 15px;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* ===== TYPOGRAPHY ===== */
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', Georgia, serif;
            font-weight: 600;
            color: var(--navy-900);
            line-height: 1.2;
        }

        .font-sans {
            font-family: 'Inter', sans-serif;
        }

        .font-display {
            font-family: 'Playfair Display', Georgia, serif;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 270px;
            min-height: 100vh;
            background: linear-gradient(180deg, var(--navy-900) 0%, var(--navy-800) 100%);
            color: #e2e8f0;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            overflow-y: auto;
            z-index: 900;
            transition: var(--transition);
            box-shadow: 8px 0 24px rgba(0, 0, 0, 0.12);
            display: flex;
            flex-direction: column;
        }

        .sidebar-brand {
            padding: 28px 24px;
            display: flex;
            align-items: center;
            gap: 14px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            margin-bottom: 4px;
        }

        .sidebar-brand-icon {
            width: 44px;
            height: 44px;
            border-radius: var(--radius-sm);
            background: linear-gradient(135deg, var(--gold-500) 0%, var(--gold-400) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--navy-900);
            font-size: 22px;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(234, 179, 8, 0.25);
        }

        .sidebar-brand span {
            font-family: 'Playfair Display', serif;
            font-size: 22px;
            font-weight: 700;
            color: #f8fafc;
            letter-spacing: -0.3px;
        }

        .sidebar-nav {
            list-style: none;
            padding: 16px 14px;
            margin: 0;
            flex: 1;
        }

        .sidebar-nav li {
            margin-bottom: 6px;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 16px;
            color: #94a3b8;
            text-decoration: none;
            border-radius: var(--radius-sm);
            transition: var(--transition);
            font-weight: 500;
            font-size: 14px;
            position: relative;
        }

        .sidebar-nav a i {
            font-size: 17px;
            width: 20px;
            text-align: center;
            opacity: 0.85;
        }

        .sidebar-nav a:hover {
            background: rgba(255, 255, 255, 0.06);
            color: #f1f5f9;
            transform: translateX(3px);
        }

        .sidebar-nav a.active {
            background: linear-gradient(135deg, var(--gold-500) 0%, var(--gold-400) 100%);
            color: var(--navy-900);
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(234, 179, 8, 0.25);
        }

        .sidebar-nav a.active i {
            opacity: 1;
        }

        .sidebar-section {
            padding: 20px 24px 8px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #64748b;
            font-weight: 600;
        }

        .sidebar-footer {
            padding: 14px;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
        }

        .sidebar-footer form button {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 10px 16px;
            color: #94a3b8;
            background: none;
            border: none;
            border-radius: var(--radius-sm);
            transition: var(--transition);
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            font-family: inherit;
        }

        .sidebar-footer form button:hover {
            background: rgba(239, 68, 68, 0.1);
            color: #fca5a5;
        }

        /* ===== HEADER ===== */
        .top-header {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 14px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: var(--shadow-xs);
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .sidebar-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 22px;
            color: var(--navy-600);
            cursor: pointer;
            padding: 6px;
            border-radius: var(--radius-sm);
            transition: var(--transition);
        }

        .sidebar-toggle:hover {
            background: var(--navy-50);
            color: var(--navy-900);
        }

        .header-search {
            position: relative;
            width: 320px;
        }

        .header-search input {
            width: 100%;
            padding: 9px 14px 9px 38px;
            border: 1px solid #e2e8f0;
            border-radius: var(--radius);
            background: var(--navy-50);
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            transition: var(--transition);
        }

        .header-search input:focus {
            outline: none;
            border-color: var(--gold-500);
            box-shadow: 0 0 0 3px rgba(234, 179, 8, 0.06);
            background: #ffffff;
        }

        .header-search i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--navy-600);
            font-size: 15px;
        }

        .header-user {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            padding: 6px 10px;
            border-radius: var(--radius);
            transition: var(--transition);
        }

        .header-user:hover {
            background: var(--navy-50);
        }

        .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--gold-500) 0%, var(--gold-400) 100%);
            color: var(--navy-900);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
            flex-shrink: 0;
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-weight: 600;
            font-size: 14px;
            color: var(--navy-900);
            line-height: 1.2;
        }

        .user-role {
            font-size: 12px;
            color: var(--navy-600);
            line-height: 1.2;
        }

        /* ===== NOTIFICATIONS ===== */
        .notification-dropdown {
            position: relative;
            margin-right: 12px;
        }
        .notification-toggle {
            background: none;
            border: none;
            font-size: 20px;
            color: var(--navy-700);
            cursor: pointer;
            position: relative;
            padding: 6px;
            border-radius: 50%;
            transition: background 0.15s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .notification-toggle:hover {
            background: var(--navy-50);
            color: var(--navy-900);
        }
        .notification-badge {
            position: absolute;
            top: 2px;
            right: 2px;
            background: #dc2626;
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 5px;
            border-radius: 10px;
            line-height: 1;
            border: 2px solid #fff;
            min-width: 16px;
            text-align: center;
        }
        .notification-menu {
            display: none;
            position: absolute;
            right: 0;
            top: 48px;
            width: 360px;
            max-height: 420px;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: var(--radius);
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.1);
            z-index: 1050;
            overflow: hidden;
        }
        .notification-menu.show {
            display: block;
        }
        .notification-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 16px;
            border-bottom: 1px solid #f1f5f9;
        }
        .notification-title {
            font-weight: 600;
            font-size: 14px;
            color: var(--navy-900);
        }
        .notification-mark-all {
            background: none;
            border: none;
            color: var(--gold-600);
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            padding: 0;
            font-family: 'Inter', sans-serif;
        }
        .notification-mark-all:hover {
            color: var(--gold-700);
            text-decoration: underline;
        }
        .notification-list {
            max-height: 340px;
            overflow-y: auto;
        }
        .notification-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 12px 16px;
            text-decoration: none;
            color: inherit;
            transition: background 0.15s;
            border-bottom: 1px solid #f8fafc;
        }
        .notification-item:hover {
            background: #fefce8;
        }
        .notification-item:last-child {
            border-bottom: none;
        }
        .notification-icon {
            width: 36px;
            height: 36px;
            border-radius: var(--radius-sm);
            background: #fefce8;
            color: var(--gold-600);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }
        .notification-content {
            flex: 1;
            min-width: 0;
        }
        .notification-text {
            font-size: 13px;
            color: var(--navy-800);
            line-height: 1.4;
        }
        .notification-meta {
            font-size: 11px;
            color: var(--navy-600);
            margin-top: 2px;
        }
        .notification-empty {
            padding: 24px 16px;
            text-align: center;
            color: var(--navy-600);
            font-size: 13px;
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            margin-left: 270px;
            min-height: 100vh;
            background: #f1f5f9;
            position: relative;
        }

        .content-wrapper {
            padding: 32px;
            max-width: 1400px;
            position: relative;
            z-index: 1;
        }

        /* ===== PAGE HEADER ===== */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e2e8f0;
        }

        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            font-weight: 700;
            color: var(--navy-900);
            margin: 0;
            letter-spacing: -0.5px;
        }

        .page-subtitle {
            color: var(--navy-600);
            font-size: 15px;
            margin: 6px 0 0;
            font-weight: 400;
        }

        /* ===== CARDS ===== */
        .card {
            border: 1px solid #e2e8f0;
            border-radius: var(--radius-xl);
            background: #ffffff;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            overflow: hidden;
        }

        .card:hover {
            box-shadow: var(--shadow);
        }

        .card-header {
            background: #ffffff;
            border-bottom: 1px solid #f1f5f9;
            padding: 20px 24px;
            font-weight: 600;
            font-size: 16px;
            color: var(--navy-900);
            font-family: 'Inter', sans-serif;
        }

        .card-body {
            padding: 24px;
        }

        /* ===== STAT CARDS ===== */
        .stat-card {
            border-radius: var(--radius-xl);
            padding: 24px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--gold-500) 0%, var(--gold-400) 100%);
            opacity: 0;
            transition: var(--transition);
        }

        .stat-card:hover::before {
            opacity: 1;
        }

        .stat-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-3px);
        }

        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: var(--radius);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 18px;
            background: rgba(234, 179, 8, 0.06);
            color: var(--gold-600);
        }

        .stat-icon.success {
            background: rgba(16, 185, 129, 0.06);
            color: #10b981;
        }

        .stat-icon.warning {
            background: rgba(245, 158, 11, 0.06);
            color: #d97706;
        }

        .stat-icon.danger {
            background: rgba(239, 68, 68, 0.06);
            color: #dc2626;
        }

        .stat-icon.info {
            background: rgba(59, 130, 246, 0.06);
            color: #2563eb;
        }

        .stat-value {
            font-size: 38px;
            font-weight: 700;
            color: var(--navy-900);
            line-height: 1;
            margin-bottom: 6px;
            font-family: 'Playfair Display', serif;
        }

        .stat-label {
            font-size: 13px;
            color: var(--navy-600);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* ===== BUTTONS ===== */
        .btn {
            border-radius: var(--radius-sm);
            padding: 10px 20px;
            font-weight: 600;
            font-size: 14px;
            transition: var(--transition);
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-family: 'Inter', sans-serif;
            text-decoration: none;
            line-height: 1.4;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .btn:active {
            transform: translateY(0);
            box-shadow: var(--shadow-sm);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--gold-500) 0%, var(--gold-400) 100%);
            color: var(--navy-900);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--gold-600) 0%, var(--gold-500) 100%);
        }

        .btn-success {
            background: #16a34a;
            color: white;
        }

        .btn-success:hover {
            background: #15803d;
        }

        .btn-danger {
            background: #dc2626;
            color: white;
        }

        .btn-danger:hover {
            background: #b91c1c;
        }

        .btn-warning {
            background: #d97706;
            color: white;
        }

        .btn-warning:hover {
            background: #b45309;
        }

        /* ===== LOGOUT CONFIRMATION ===== */
        .sidebar-footer .btn-logout-trigger {
            width: 100%;
            text-align: left;
            background: transparent;
            border: 1px solid #dc2626;
            color: #dc2626;
            padding: 12px 16px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s;
            display: flex;
            align-items: center;
            gap: 10px;
            font-family: 'Inter', sans-serif;
            border-radius: var(--radius-sm);
            margin-top: 8px;
        }
        .sidebar-footer .btn-logout-trigger:hover {
            background: #fef2f2;
            color: #b91c1c;
            border-color: #b91c1c;
            transform: translateY(-1px);
        }
        .sidebar-footer .btn-logout-trigger:active {
            transform: translateY(0);
        }
        .logout-confirm-text {
            font-family: 'Inter', sans-serif;
            font-size: 15px;
            color: var(--navy-700);
            margin: 0;
            line-height: 1.5;
        }
        #logoutConfirmModal .modal-title {
            font-family: 'Playfair Display', serif;
            color: var(--navy-900);
        }
        #logoutConfirmModal .modal-content {
            border-radius: var(--radius);
            border: none;
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.15);
        }
        #logoutConfirmModal .modal-header {
            border-bottom: 1px solid #f1f5f9;
            padding: 20px 24px;
        }
        #logoutConfirmModal .modal-body {
            padding: 24px;
        }
        #logoutConfirmModal .modal-footer {
            border-top: 1px solid #f1f5f9;
            padding: 16px 24px;
            gap: 10px;
        }

        .btn-outline-primary {
            background: transparent;
            color: var(--gold-700);
            border: 1px solid var(--gold-400);
        }

        .btn-outline-primary:hover {
            background: var(--gold-500);
            color: var(--navy-900);
        }

        .btn-outline-secondary {
            background: transparent;
            color: var(--navy-600);
            border: 1px solid #e2e8f0;
        }

        .btn-outline-secondary:hover {
            background: var(--navy-50);
            color: var(--navy-900);
        }

        .btn-icon {
            width: 36px;
            height: 36px;
            padding: 0;
            border-radius: var(--radius-sm);
        }

        .btn-icon.btn-sm {
            width: 32px;
            height: 32px;
            padding: 0;
            font-size: 13px;
        }

        .btn-sm {
            padding: 6px 14px;
            font-size: 13px;
            border-radius: var(--radius-sm);
        }

        .btn-lg {
            padding: 12px 24px;
            font-size: 15px;
            border-radius: var(--radius);
        }

        /* ===== TABLES ===== */
        .table {
            border-radius: var(--radius-xl);
            overflow: hidden;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            box-shadow: var(--shadow-sm);
        }

        .table thead {
            background: var(--navy-900);
            color: #f1f5f9;
        }

        .table thead th {
            border: none;
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 16px;
            font-family: 'Inter', sans-serif;
        }

        .table tbody td {
            padding: 15px 16px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
        }

        .table tbody tr {
            transition: var(--transition);
        }

        .table tbody tr:hover {
            background: var(--gold-50);
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        /* ===== FORMS ===== */
        .form-control,
        .form-select {
            border-radius: var(--radius-sm);
            border: 1px solid #e2e8f0;
            padding: 10px 14px;
            font-size: 14px;
            transition: var(--transition);
            background: white;
            font-family: 'Inter', sans-serif;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--gold-500);
            box-shadow: 0 0 0 3px rgba(234, 179, 8, 0.06);
            outline: none;
        }

        .form-label {
            font-weight: 600;
            font-size: 13px;
            color: var(--navy-600);
            margin-bottom: 6px;
            font-family: 'Inter', sans-serif;
        }

        /* ===== ALERTS ===== */
        .alert {
            border: none;
            border-radius: var(--radius-xl);
            padding: 14px 20px;
            box-shadow: var(--shadow-sm);
            border-left: 4px solid transparent;
            font-size: 14px;
        }

        .alert-success {
            background: #f0fdf4;
            border-left-color: #16a34a;
            color: #15803d;
        }

        .alert-danger {
            background: #fef2f2;
            border-left-color: #dc2626;
            color: #991b1b;
        }

        .alert-info {
            background: #eff6ff;
            border-left-color: #2563eb;
            color: #1e40af;
        }

        .alert-warning {
            background: #fffbeb;
            border-left-color: #d97706;
            color: #92400e;
        }

        /* ===== BADGES ===== */
        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 12px;
            letter-spacing: 0.2px;
        }

        .badge.bg-primary {
            background: linear-gradient(135deg, var(--gold-500) 0%, var(--gold-400) 100%) !important;
            color: var(--navy-900) !important;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .badge.bg-success {
            background: #f0fdf4 !important;
            color: #15803d !important;
            font-weight: 600;
        }

        .badge.bg-light {
            background: #f8fafc !important;
            color: var(--navy-600) !important;
            font-weight: 600;
            text-transform: uppercase;
        }

        .badge.bg-warning {
            background: #fffbeb !important;
            color: #92400e !important;
            font-weight: 600;
        }

        /* ===== PAGINATION ===== */
        .pagination-custom {
            gap: 8px;
            justify-content: center;
            flex-wrap: nowrap;
        }

        .pagination-custom .page-link {
            width: 40px;
            height: 40px;
            padding: 0;
            border-radius: 50%;
            border: 1px solid #d1d5db;
            background: #fff;
            color: #4b5563;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
            text-decoration: none;
        }

        .pagination-custom .page-item.active .page-link {
            background: #FFC107;
            border-color: #FFC107;
            color: #0F172A;
            box-shadow: 0 2px 8px rgba(255, 193, 7, 0.35);
        }

        .pagination-custom .page-item:not(.active):not(.disabled) .page-link:hover {
            background: #FFC107;
            border-color: #FFC107;
            color: #0F172A;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(255, 193, 7, 0.25);
        }

        .pagination-custom .page-item.disabled .page-link {
            background: #f3f4f6;
            border-color: #e5e7eb;
            color: #9ca3af;
            cursor: not-allowed;
            opacity: 0.7;
        }

        .pagination-custom .page-item.disabled .page-link:hover {
            transform: none;
            box-shadow: none;
        }

        .pagination-text {
            font-size: 13px;
            font-weight: 500;
            font-family: 'Inter', sans-serif;
            color: #6b7280;
            text-align: center;
            margin-top: 4px;
        }

        @media (max-width: 576px) {
            .pagination-custom {
                gap: 6px;
            }

            .pagination-custom .page-link {
                width: 36px;
                height: 36px;
                font-size: 13px;
            }

            .pagination-text {
                font-size: 12px;
            }
        }

        /* ===== MODALS ===== */
        .modal-content {
            border: none;
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-lg);
        }

        .modal-header {
            border-bottom: 1px solid #f1f5f9;
            padding: 18px 24px;
        }

        .modal-footer {
            border-top: 1px solid #f1f5f9;
            padding: 14px 24px;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
            .content-wrapper {
                padding: 24px;
            }
            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }
            .page-title {
                font-size: 26px;
            }
            .header-search {
                display: none;
            }
            .sidebar-toggle {
                display: block;
            }
            .user-info {
                display: none;
            }
        }

        @media (max-width: 576px) {
            .content-wrapper {
                padding: 16px;
            }
            .page-title {
                font-size: 22px;
            }
            .top-header {
                padding: 10px 16px;
            }
            .stat-card {
                padding: 18px;
            }
            .stat-value {
                font-size: 28px;
            }
        }

        /* ===== SCROLLBAR ===== */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 20px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* ===== UTILITY CLASSES ===== */
        .text-navy-600 { color: var(--navy-600); }
        .text-navy-900 { color: var(--navy-900); }
        .detail-row { padding: 10px 0; border-bottom: 1px solid #f1f5f9; font-size: 0.88rem; }
        .detail-row:last-child { border-bottom: none; }

        .text-gradient {
            background: linear-gradient(135deg, var(--gold-500) 0%, var(--gold-400) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .bg-gradient {
            background: linear-gradient(135deg, var(--navy-900) 0%, var(--navy-800) 100%);
        }

        .section-alt {
            background: #fefce8;
            border-radius: var(--radius-xl);
            padding: 28px;
            margin: 24px 0;
            border: 1px solid #fef08a;
        }

        .input-group-text {
            background: var(--navy-50);
            border: 1px solid #e2e8f0;
            color: var(--navy-600);
        }

        /* ===== ANIMATIONS ===== */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.4s ease-out forwards;
        }

        .stagger-1 { animation-delay: 0.05s; }
        .stagger-2 { animation-delay: 0.1s; }
        .stagger-3 { animation-delay: 0.15s; }
        .stagger-4 { animation-delay: 0.2s; }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <nav class="sidebar d-flex flex-column" id="sidebar">
            <div class="sidebar-brand">
                <div class="sidebar-brand-icon">
                    <i class="bi bi-folder2-open"></i>
                </div>
                <span>GestDoc</span>
            </div>

            <div class="sidebar-section">Menu principal</div>
            <ul class="sidebar-nav">
                <li>
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>

                @auth
                    @if(auth()->user()->isAdmin())
                        <li>
                            <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                                <i class="bi bi-people"></i> Utilisateurs
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('departments.index') }}" class="{{ request()->routeIs('departments.*') ? 'active' : '' }}">
                                <i class="bi bi-building"></i> Départements
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('projects.index') }}" class="{{ request()->routeIs('projects.*') ? 'active' : '' }}">
                                <i class="bi bi-kanban"></i> Projets
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">
                                <i class="bi bi-tags"></i> Catégories
                            </a>
                        </li>
                    @endif
                @endauth

                <li>
                    <a href="{{ route('documents.index') }}" class="{{ request()->routeIs('documents.*') ? 'active' : '' }}">
                        <i class="bi bi-file-earmark-text"></i> Documents
                    </a>
                </li>
                <li>
                    <a href="{{ route('meetings.index') }}" class="{{ request()->routeIs('meetings.*') ? 'active' : '' }}">
                        <i class="bi bi-calendar-event"></i> Réunions
                    </a>
                </li>
            </ul>

            <div class="sidebar-section">Compte</div>
            <ul class="sidebar-nav">
                <li>
                    <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.*') ? 'active' : '' }}">
                        <i class="bi bi-person-circle"></i> Profil
                    </a>
                </li>
            </ul>

            <div class="sidebar-footer">
                <button type="button" class="btn-logout-trigger" data-bs-toggle="modal" data-bs-target="#logoutConfirmModal">
                    <i class="bi bi-box-arrow-right"></i> Déconnexion
                </button>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="main-content flex-grow-1">
            <!-- Top Header -->
            <header class="top-header">
                <div class="header-left">
                    <button class="sidebar-toggle" id="sidebarToggle">
                        <i class="bi bi-list"></i>
                    </button>
                    <div class="header-search">
                        <i class="bi bi-search"></i>
                        <input type="text" placeholder="Rechercher...">
                    </div>
                </div>
                <div class="header-user">
                    <div class="notification-dropdown" id="notificationDropdown">
                        <button class="notification-toggle" id="notificationToggle" type="button">
                            <i class="bi bi-bell"></i>
                            @php
                                $unreadCount = auth()->user()->unreadNotifications->count();
                            @endphp
                            @if($unreadCount > 0)
                                <span class="notification-badge">{{ $unreadCount > 99 ? '99+' : $unreadCount }}</span>
                            @endif
                        </button>
                        <div class="notification-menu" id="notificationMenu">
                            <div class="notification-header">
                                <span class="notification-title">Notifications</span>
                                @if($unreadCount > 0)
                                    <form method="POST" action="{{ route('notifications.markAllRead') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="notification-mark-all">Tout marquer comme lu</button>
                                    </form>
                                @endif
                            </div>
                            <div class="notification-list">
                                @php
                                    $notifications = auth()->user()->unreadNotifications->take(10);
                                @endphp
                                @forelse($notifications as $notification)
                                    <a href="{{ $notification->data['document_url'] ?? '#' }}" class="notification-item">
                                        <div class="notification-icon">
                                            <i class="bi bi-file-earmark-text"></i>
                                        </div>
                                        <div class="notification-content">
                                            <div class="notification-text">
                                                <strong>{{ $notification->data['shared_by_name'] ?? 'Quelqu\'un' }}</strong> a partagé le document <strong>{{ $notification->data['document_titre'] ?? '' }}</strong>
                                            </div>
                                            <div class="notification-meta">
                                                Droit : {{ $notification->data['droit'] ?? '' }} · {{ $notification->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <div class="notification-empty">Aucune notification non lue</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <div class="user-avatar">
                        {{ strtoupper(mb_substr(Auth::user()->prenom, 0, 1) . mb_substr(Auth::user()->nom, 0, 1)) }}
                    </div>
                    <div class="user-info">
                        <span class="user-name">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</span>
                        <span class="user-role">{{ ucfirst(Auth::user()->role) }}</span>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <div class="content-wrapper">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-circle-fill me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/choices.js/11.0.13/choices.min.js"></script>
    <script>
        (function () {
            function cleanModalState() {
                document.querySelectorAll('.modal-backdrop').forEach(function (el) {
                    if (el.parentNode) {
                        el.parentNode.removeChild(el);
                    }
                });
                document.body.classList.remove('modal-open');
                document.body.style.overflow = '';
                document.body.style.paddingRight = '';
            }

            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('.modal').forEach(function (modalEl) {
                    var modal = bootstrap.Modal.getInstance(modalEl);
                    if (!modal) {
                        modal = new bootstrap.Modal(modalEl, {
                            backdrop: true,
                            keyboard: true,
                            focus: true
                        });
                    }

                    modalEl.addEventListener('hidden.bs.modal', function () {
                        cleanModalState();
                    });

                    modalEl.addEventListener('transitionend', function (e) {
                        if (e.propertyName === 'opacity' || e.propertyName === 'visibility') {
                            cleanModalState();
                        }
                    });
                });

                document.addEventListener('click', function (e) {
                    if (e.target.classList.contains('modal-backdrop')) {
                        cleanModalState();
                    }
                });

                window.addEventListener('load', cleanModalState);

                // Sidebar toggle
                var sidebar = document.getElementById('sidebar');
                var toggleBtn = document.getElementById('sidebarToggle');
                if (toggleBtn && sidebar) {
                    toggleBtn.addEventListener('click', function () {
                        sidebar.classList.toggle('show');
                    });
                }

                // Close sidebar when clicking outside on mobile
                document.addEventListener('click', function (e) {
                    if (window.innerWidth <= 992 &&
                        sidebar &&
                        toggleBtn &&
                        sidebar.classList.contains('show') &&
                        !sidebar.contains(e.target) &&
                        e.target !== toggleBtn &&
                        !toggleBtn.contains(e.target)) {
                        sidebar.classList.remove('show');
                    }
                });

                // Notifications dropdown
                var notificationToggle = document.getElementById('notificationToggle');
                var notificationMenu = document.getElementById('notificationMenu');
                if (notificationToggle && notificationMenu) {
                    notificationToggle.addEventListener('click', function (e) {
                        e.stopPropagation();
                        notificationMenu.classList.toggle('show');
                    });
                    document.addEventListener('click', function (e) {
                        if (!notificationToggle.contains(e.target) && !notificationMenu.contains(e.target)) {
                            notificationMenu.classList.remove('show');
                        }
                    });
                }

                // Logout confirmation
                var confirmLogoutBtn = document.getElementById('confirmLogoutBtn');
                var logoutConfirmForm = document.getElementById('logoutConfirmForm');
                if (confirmLogoutBtn && logoutConfirmForm) {
                    confirmLogoutBtn.addEventListener('click', function () {
                        logoutConfirmForm.submit();
                    });
                }
            });
        })();
    </script>
    @stack('scripts')

    <!-- Modal de confirmation de déconnexion -->
    <div class="modal fade" id="logoutConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmer la déconnexion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('logout') }}" id="logoutConfirmForm">
                        @csrf
                        <p class="logout-confirm-text">Êtes-vous sûr de vouloir vous déconnecter de GestDoc ?</p>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-danger btn-sm" id="confirmLogoutBtn">Se déconnecter</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

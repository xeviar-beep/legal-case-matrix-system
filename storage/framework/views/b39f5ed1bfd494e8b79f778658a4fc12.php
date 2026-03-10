<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="color-scheme" content="light dark">
    <title><?php echo $__env->yieldContent('title'); ?> - LAO Case Tracking System</title>
    
    <!-- CRITICAL: Dark Mode Flash Prevention - Must be first script -->
    <script>
        // Apply dark mode IMMEDIATELY - synchronous execution before any rendering
        (function() {
            try {
                const darkMode = localStorage.getItem('darkMode');
                if (darkMode === 'enabled') {
                    // Apply styles directly to HTML element with !important
                    const html = document.documentElement;
                    html.style.cssText = 'background-color: #0f172a !important; transition: none !important;';
                    html.className = 'dark-mode-instant';
                    
                    // Also create and inject critical CSS immediately
                    const style = document.createElement('style');
                    style.id = 'dark-mode-critical';
                    style.textContent = `
                        html, body {
                            background-color: #0f172a !important;
                            color: #ffffff !important;
                            transition: none !important;
                        }
                        * {
                            transition: none !important;
                        }
                    `;
                    document.head.appendChild(style);
                }
            } catch(e) {
                console.error('Dark mode init error:', e);
            }
        })();
    </script>
    
    <style>
        /* CRITICAL: Dark mode base styles - highest priority */
        html.dark-mode-instant {
            background-color: #0f172a !important;
            transition: none !important;
        }
        
        html.dark-mode-instant body,
        html.dark-mode-instant body * {
            background-color: inherit;
            transition: none !important;
        }
        
        html.dark-mode-instant body {
            background-color: #0f172a !important;
            color: #ffffff !important;
        }
    </style>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --navy-blue: #001F3F;
            --navy-blue-light: #003D7A;
            --navy-blue-dark: #001528;
            --soft-gold: #C6A85E;
            --soft-gold-light: #D4B76F;
            --soft-gold-dark: #B39653;
            --olive-green: #6B8E4F;
            --olive-green-dark: #5A7A42;
            --light-gray: #F4F6F9;
            --border-color: #E2E8F0;
            
            /* Light Mode Text Colors - Automatically changes in Dark Mode */
            --text-title: #1F2937;         /* Main titles - Dark gray/black */
            --text-primary: #1F2937;       /* Primary text - Dark gray/black */
            --text-secondary: #4B5563;     /* Secondary text - Medium gray */
            --text-muted: #6B7280;         /* Muted text - Light gray */
            --text-bold: #000000;          /* Bold text - Black */
            
            --white: #FFFFFF;
            --status-success: #2E7D32;
            --status-warning: #ED6C02;
            --status-danger: #C62828;
            --status-info: #1565C0;
            --sidebar-width: 280px;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.05);
            --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.08);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
            overflow-y: scroll;
            /* Prevent automatic scroll anchoring */
            overflow-anchor: none;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--light-gray);
            color: var(--text-primary);
            font-size: 14px;
            line-height: 1.6;
            overflow-x: hidden;
            font-weight: 400;
            letter-spacing: 0;
            /* Prevent body from resetting scroll on updates */
            overflow-anchor: none;
        }

        /* ============================================
           GLOBAL TEXT COLOR CLASSES
           These automatically adapt to Light/Dark Mode
           ============================================ */
        
        /* Titles and Headings */
        .text-title,
        h1, h2, h3, h4, h5, h6 {
            color: var(--text-title) !important;
        }

        /* Primary Text - Main content */
        .text-primary,
        p, span, div, td, th, label, li, a {
            color: var(--text-primary);
        }

        /* Secondary Text - Subtitles and descriptions */
        .text-secondary {
            color: var(--text-secondary) !important;
        }

        /* Muted Text - Less important info */
        .text-muted {
            color: var(--text-muted) !important;
        }

        /* Bold Text - Emphasis */
        .text-bold,
        strong, b {
            color: var(--text-bold) !important;
            font-weight: 600 !important;
        }

        /* Specific overrides for inline styles */
        [style*="color: #000000"],
        [style*="color: #000"],
        [style*="color:#000000"],
        [style*="color:#000"],
        [style*="color: black"],
        [style*="color:black"] {
            color: var(--text-bold) !important;
        }

        /* Card text colors */
        .card-title {
            color: var(--text-title) !important;
        }

        .card-text {
            color: var(--text-secondary) !important;
        }

        /* Table text colors */
        table td,
        table th {
            color: var(--text-primary) !important;
        }

        table th {
            font-weight: 600 !important;
        }

        /* Form text colors */
        .form-label {
            color: var(--text-primary) !important;
        }

        .form-control {
            color: var(--text-primary) !important;
        }

        /* Button text adapts automatically */
        .btn {
            transition: all 0.2s ease;
        }

        /* Navigation text */
        .nav-link {
            color: var(--text-primary);
        }

        /* Paragraph text */
        p {
            color: var(--text-primary);
        }

        /* List text */
        ul li,
        ol li {
            color: var(--text-primary);
        }

        /* Icons that need text color */
        .bi {
            transition: color 0.2s ease;
        }

        /* Sidebar */
        .lao-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--white);
            border-right: 1px solid var(--border-color);
            overflow-y: auto;
            z-index: 1000;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.05);
        }

        .lao-sidebar-header {
            padding: 24px 20px;
            border-bottom: 1px solid var(--border-color);
            background: var(--white);
            color: var(--text-primary);
        }

        .lao-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: var(--text-primary);
        }

        .lao-logo-icon {
            width: 48px;
            height: 48px;
            background: var(--navy-blue);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: var(--white);
            font-weight: 600;
            box-shadow: 0 2px 4px rgba(30, 42, 56, 0.2);
            border: none;
        }

        .lao-logo-text h6 {
            margin: 0;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--text-secondary);
        }

        .lao-logo-text h5 {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
            letter-spacing: -0.02em;
            color: var(--navy-blue);
        }

        .lao-nav {
            padding: 12px 0;
        }

        .lao-nav-section {
            margin-top: 20px;
        }

        .lao-nav-section-title {
            padding: 8px 20px;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: var(--text-secondary);
        }

        .lao-nav-item {
            margin: 2px 12px;
        }

        .lao-nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 16px;
            color: var(--text-primary);
            text-decoration: none;
            border-radius: 6px;
            transition: all 0.2s ease;
            font-size: 14px;
            font-weight: 400;
            letter-spacing: 0;
            cursor: pointer;
            user-select: none;
        }

        .lao-nav-link span,
        .lao-nav-link div,
        .lao-nav-link div span {
            color: inherit;
        }

        .lao-nav-link:hover {
            background: var(--light-gray);
            color: var(--text-primary);
        }

        .lao-nav-link:hover span,
        .lao-nav-link:hover div,
        .lao-nav-link:hover div span {
            color: inherit;
        }

        .lao-nav-link.active {
            background: var(--navy-blue);
            color: var(--white);
            font-weight: 500;
            box-shadow: 0 2px 4px rgba(30, 42, 56, 0.2);
        }

        .lao-nav-link.active span,
        .lao-nav-link.active div,
        .lao-nav-link.active div span {
            color: inherit;
        }

        .lao-nav-link i {
            font-size: 18px;
            width: 20px;
            text-align: center;
        }

        /* Dropdown Navigation */
        .lao-nav-item.has-dropdown {
            position: relative;
            user-select: none;
        }

        .lao-nav-item.has-dropdown .lao-nav-link {
            justify-content: space-between;
            cursor: pointer;
        }

        .lao-nav-item.has-dropdown .lao-nav-link .dropdown-arrow {
            font-size: 12px;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            margin-left: auto;
        }

        /* Hide ALL dropdowns by default - including cases */
        .lao-nav-dropdown {
            display: block !important;
            margin-left: 48px;
            margin-top: 0;
            padding-top: 4px;
            padding-left: 8px;
            padding-bottom: 4px;
            border-left: 2px solid rgba(201, 169, 97, 0.5);
            max-height: 0 !important;
            opacity: 0 !important;
            overflow: hidden !important;
            transform: translateY(-10px);
            pointer-events: none;
            transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1), 
                        opacity 0.3s cubic-bezier(0.4, 0, 0.2, 1),
                        transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Show dropdown on hover - applies to ALL dropdowns including cases */
        .lao-nav-item.has-dropdown:hover .lao-nav-dropdown {
            max-height: 2000px !important;
            opacity: 1 !important;
            transform: translateY(0) !important;
            pointer-events: auto !important;
            overflow: visible !important;
        }

        /* Rotate arrow on hover - applies to ALL dropdowns including cases */
        .lao-nav-item.has-dropdown:hover .dropdown-arrow {
            transform: rotate(90deg);
        }

        /* Keep dropdown open when it has dropdown-active class (for clicks) */
        .lao-nav-item.has-dropdown.dropdown-active .lao-nav-dropdown {
            max-height: 2000px !important;
            opacity: 1 !important;
            transform: translateY(0) !important;
            pointer-events: auto !important;
            overflow: visible !important;
        }

        .lao-nav-item.has-dropdown.dropdown-active .dropdown-arrow {
            transform: rotate(90deg);
        }

        .lao-nav-dropdown-item {
            margin: 4px 0;
            min-height: 20px;
            opacity: 1;
        }

        .lao-nav-item.has-dropdown:hover .lao-nav-dropdown-item,
        .lao-nav-item.has-dropdown.dropdown-active .lao-nav-dropdown-item {
            animation: fadeInUp 0.3s ease forwards;
            opacity: 1;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(5px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .lao-nav-dropdown-item:nth-child(1) { animation-delay: 0.05s; }
        .lao-nav-dropdown-item:nth-child(2) { animation-delay: 0.08s; }
        .lao-nav-dropdown-item:nth-child(3) { animation-delay: 0.11s; }
        .lao-nav-dropdown-item:nth-child(4) { animation-delay: 0.14s; }
        .lao-nav-dropdown-item:nth-child(5) { animation-delay: 0.17s; }
        .lao-nav-dropdown-item:nth-child(6) { animation-delay: 0.20s; }
        .lao-nav-dropdown-item:nth-child(7) { animation-delay: 0.23s; }
        .lao-nav-dropdown-item:nth-child(8) { animation-delay: 0.26s; }
        .lao-nav-dropdown-item:nth-child(9) { animation-delay: 0.29s; }
        .lao-nav-dropdown-item:nth-child(10) { animation-delay: 0.32s; }
        .lao-nav-dropdown-item:nth-child(n+11) { animation-delay: 0.35s; }

        .lao-nav-dropdown-item:empty {
            display: none;
        }

        .lao-nav-dropdown-link {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            color: var(--text-primary);
            text-decoration: none;
            border-radius: 5px;
            font-size: 13px;
            font-weight: 500;
            white-space: nowrap;
            background: transparent;
            margin-bottom: 2px;
            transition: all 0.3s ease;
            opacity: 1;
        }

        .lao-nav-dropdown-link span,
        .lao-nav-dropdown-link i {
            color: inherit;
        }

        .lao-nav-dropdown-link:hover {
            background: var(--navy-blue) !important;
            color: var(--white) !important;
            transform: translateX(2px);
        }

        .lao-nav-dropdown-link:hover span,
        .lao-nav-dropdown-link:hover i {
            color: inherit !important;
        }

        .lao-nav-dropdown-link.active {
            background: var(--navy-blue) !important;
            color: var(--white) !important;
            font-weight: 600;
            box-shadow: 0 2px 4px rgba(0, 31, 63, 0.2);
        }

        .lao-nav-dropdown-link.active span,
        .lao-nav-dropdown-link.active i {
            color: inherit !important;
        }

        .lao-nav-dropdown-link i {
            font-size: 14px;
            width: 16px;
            flex-shrink: 0;
            transition: transform 0.2s ease;
        }

        .lao-nav-dropdown-link:hover i {
            transform: scale(1.1);
        }

        .lao-nav-dropdown-link span {
            flex: 1;
        }

        /* Top Bar */
        .lao-topbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: 70px;
            background: var(--white);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 0 32px;
            z-index: 999;
            box-shadow: var(--shadow-sm);
        }

        .lao-topbar-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .lao-datetime {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 16px;
            background: var(--light-gray);
            border-radius: 8px;
            margin-right: 20px;
            border: 2px solid var(--navy-blue);
        }

        .lao-date-display,
        .lao-time-display {
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 6px;
        }

        .lao-date-label,
        .lao-time-label {
            display: none;
        }

        .lao-date-value,
        .lao-time-value {
            font-size: 13px;
            font-weight: 600;
            color: var(--navy-blue);
            font-variant-numeric: tabular-nums;
            font-family: 'Inter', monospace;
            letter-spacing: 0.3px;
        }

        .lao-datetime-divider {
            width: 1px;
            height: 16px;
            background: var(--border-color);
            opacity: 0.6;
        }

        @media (max-width: 768px) {
            .lao-datetime {
                display: none;
            }
        }

        .lao-notification-wrapper {
            position: relative;
        }

        .lao-notification {
            position: relative;
            width: 44px;
            height: 44px;
            border-radius: 8px;
            background: #F8F9FA;
            border: 2px solid #E2E8F0;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            color: #F59E0B;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .lao-notification:hover {
            background: var(--white);
            border-color: var(--navy-blue);
            color: #F59E0B;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
        }

        /* Dark Mode Toggle */
        .lao-dark-mode-toggle {
            position: relative;
            width: 44px;
            height: 44px;
            border-radius: 8px;
            background: #F8F9FA;
            border: 2px solid #E2E8F0;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.35s ease;
            color: #001F3F;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .lao-dark-mode-toggle:hover {
            background: var(--white);
            border-color: var(--navy-blue);
            transform: rotate(20deg);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
        }

        /* Test Notification Toggle */
        .lao-test-notification-toggle {
            position: relative;
            width: 44px;
            height: 44px;
            border-radius: 8px;
            background: #FEF3C7;
            border: 2px solid #F59E0B;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.35s ease;
            color: #D97706;
            box-shadow: 0 1px 2px rgba(245, 158, 11, 0.2);
        }

        .lao-test-notification-toggle:hover {
            background: #FDE68A;
            border-color: #D97706;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(245, 158, 11, 0.3);
        }

        .lao-test-notification-toggle:active {
            transform: translateY(0);
            box-shadow: 0 1px 2px rgba(245, 158, 11, 0.2);
        }

        /* Dark Mode Variables */
        body.dark-mode {
            --navy-blue: #2563eb;
            --navy-blue-light: #3b82f6;
            --navy-blue-dark: #1e40af;
            --light-gray: #0f172a;
            --border-color: #2a3446;
            
            /* Dark Mode Text Colors - White and light grays for readability */
            --text-title: #FFFFFF;         /* Main titles - White */
            --text-primary: #FFFFFF;       /* Primary text - White */
            --text-secondary: #CBD5E1;     /* Secondary text - Light gray */
            --text-muted: #94A3B8;         /* Muted text - Medium gray */
            --text-bold: #FFFFFF;          /* Bold text - White */
            
            --white: #111827;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.5);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.5);
            --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.6);
        }

        body.dark-mode {
            background: #0f172a;
            color: #ffffff;
        }

        body.dark-mode .lao-sidebar {
            background: #0f172a;
            border-right-color: #2a3446;
        }

        body.dark-mode .lao-sidebar-header {
            background: #0f172a;
            border-bottom-color: #2a3446;
        }

        body.dark-mode .lao-logo-text h6 {
            color: #94a3b8;
        }

        body.dark-mode .lao-logo-text h5 {
            color: #ffffff;
        }

        body.dark-mode .lao-nav-link {
            color: #cbd5e1;
        }

        body.dark-mode .lao-nav-link span,
        body.dark-mode .lao-nav-link div,
        body.dark-mode .lao-nav-link div span {
            color: inherit;
        }

        body.dark-mode .lao-nav-link:hover {
            background: #1e293b;
            color: #ffffff;
        }

        body.dark-mode .lao-nav-link:hover span,
        body.dark-mode .lao-nav-link:hover div,
        body.dark-mode .lao-nav-link:hover div span {
            color: inherit;
        }

        body.dark-mode .lao-nav-dropdown-link {
            color: #cbd5e1;
        }

        body.dark-mode .lao-nav-dropdown-link span,
        body.dark-mode .lao-nav-dropdown-link i {
            color: inherit;
        }

        body.dark-mode .lao-nav-dropdown-link:hover {
            background: #1e293b;
            color: #ffffff;
        }

        body.dark-mode .lao-nav-dropdown-link:hover span,
        body.dark-mode .lao-nav-dropdown-link:hover i {
            color: inherit;
        }

        body.dark-mode .lao-nav-link.active {
            background: #2563eb;
            color: #ffffff;
        }

        body.dark-mode .lao-nav-link.active span,
        body.dark-mode .lao-nav-link.active div,
        body.dark-mode .lao-nav-link.active div span {
            color: inherit;
        }

        body.dark-mode .lao-nav-dropdown-link.active {
            background: #2563eb;
            color: #ffffff;
        }

        body.dark-mode .lao-nav-dropdown-link.active span,
        body.dark-mode .lao-nav-dropdown-link.active i {
            color: inherit;
        }

        body.dark-mode .lao-topbar {
            background: #111827;
            border-bottom-color: #2a3446;
        }

        body.dark-mode .lao-datetime {
            background: #1e293b;
            border-color: #334155;
        }

        body.dark-mode .lao-date-value,
        body.dark-mode .lao-time-value {
            color: #ffffff;
        }

        body.dark-mode .lao-notification,
        body.dark-mode .lao-dark-mode-toggle {
            background: #1e293b;
            border-color: #334155;
            color: #fbbf24;
        }

        body.dark-mode .lao-notification:hover,
        body.dark-mode .lao-dark-mode-toggle:hover {
            background: #334155;
            border-color: #2563eb;
        }

        body.dark-mode .lao-test-notification-toggle {
            background: #422006;
            border-color: #F59E0B;
            color: #FDE68A;
        }

        body.dark-mode .lao-test-notification-toggle:hover {
            background: #78350f;
            border-color: #FDE68A;
        }

        body.dark-mode .lao-user-profile {
            background: #1e293b;
            border-color: #334155;
        }

        body.dark-mode .lao-user-profile:hover {
            background: #334155;
            border-color: #2563eb;
        }

        body.dark-mode .lao-user-name {
            color: #ffffff;
        }

        body.dark-mode .lao-user-role {
            color: #cbd5e1;
        }

        body.dark-mode .user-dropdown {
            background: #111827;
            border-color: #2a3446;
        }

        body.dark-mode .user-dropdown-header {
            background: #0f172a;
            border-bottom-color: #2a3446;
        }

        body.dark-mode .user-dropdown-user h6 {
            color: #ffffff;
        }

        body.dark-mode .user-dropdown-user p {
            color: #cbd5e1;
        }

        body.dark-mode .user-dropdown-item {
            color: #cbd5e1;
        }

        body.dark-mode .user-dropdown-item:hover {
            background: #1e293b;
        }

        body.dark-mode .lao-main {
            background: #0f172a;
        }

        body.dark-mode .lao-page-header {
            background: #0f172a;
            border-bottom-color: #2a3446;
        }

        body.dark-mode .lao-page-title {
            color: #ffffff;
        }

        body.dark-mode .lao-page-subtitle {
            color: #94a3b8;
        }

        body.dark-mode .matrix-container {
            background: #111827;
            border-color: #2a3446;
        }

        body.dark-mode .matrix-controls {
            background: #0f172a;
            border-bottom-color: #2a3446;
        }

        body.dark-mode .matrix-search-input {
            background: #1e293b;
            border-color: #334155;
            color: #ffffff;
        }

        body.dark-mode .matrix-search-input:focus {
            border-color: #2563eb;
        }

        body.dark-mode .matrix-table tbody td {
            background: #111827;
            color: #ffffff;
            border-bottom-color: #2a3446;
            border-right-color: #2a3446;
        }

        body.dark-mode .matrix-table tbody tr:hover td {
            background: #1e293b;
        }

        body.dark-mode .notification-dropdown {
            background: #111827;
            border-color: #2a3446;
        }

        body.dark-mode .notification-dropdown-header {
            background: #0f172a;
            border-bottom-color: #2a3446;
        }

        body.dark-mode .notification-dropdown-header h6 {
            color: #ffffff;
        }

        body.dark-mode .notification-item {
            border-bottom-color: #2a3446;
        }

        body.dark-mode .notification-item:hover {
            background: #1e293b;
        }

        body.dark-mode .notification-title {
            color: #ffffff;
        }

        body.dark-mode .notification-message {
            color: #cbd5e1;
        }

        /* Additional comprehensive dark mode styles */
        body.dark-mode .lao-card,
        body.dark-mode .lao-stat-card {
            background: #111827;
            border-color: #2a3446;
        }

        body.dark-mode .lao-stat-label {
            color: #94a3b8;
        }

        body.dark-mode .lao-stat-value {
            color: #ffffff;
        }

        body.dark-mode h1,
        body.dark-mode h2,
        body.dark-mode h3,
        body.dark-mode h4,
        body.dark-mode h5,
        body.dark-mode h6 {
            color: #ffffff;
        }

        body.dark-mode p,
        body.dark-mode span,
        body.dark-mode label,
        body.dark-mode div {
            color: inherit;
        }

        /* Buttons in dark mode */
        body.dark-mode .btn-primary,
        body.dark-mode .btn-lao-primary {
            background: #2563eb;
            color: #ffffff;
            border-color: #2563eb;
        }

        body.dark-mode .btn-primary:hover,
        body.dark-mode .btn-lao-primary:hover {
            background: #3b82f6;
            color: #ffffff;
            border-color: #3b82f6;
        }

        body.dark-mode .btn-secondary {
            background: #334155;
            color: #ffffff;
            border-color: #334155;
        }

        body.dark-mode .btn-secondary:hover {
            background: #475569;
            color: #ffffff;
        }

        body.dark-mode .btn-success {
            background: #047857;
            color: #e2e8f0;
            border-color: #047857;
        }

        body.dark-mode .btn-success:hover {
            background: #059669;
            color: #ffffff;
        }

        body.dark-mode .btn-danger {
            background: #b91c1c;
            color: #e2e8f0;
            border-color: #b91c1c;
        }

        body.dark-mode .btn-danger:hover {
            background: #dc2626;
            color: #ffffff;
        }

        body.dark-mode .btn-warning {
            background: #d97706;
            color: #e2e8f0;
            border-color: #d97706;
        }

        body.dark-mode .btn-warning:hover {
            background: #f59e0b;
            color: #ffffff;
        }

        body.dark-mode .btn-info {
            background: #0369a1;
            color: #e2e8f0;
            border-color: #0369a1;
        }

        body.dark-mode .btn-info:hover {
            background: #0284c7;
            color: #ffffff;
        }

        body.dark-mode .btn-light {
            background: #1e293b;
            color: #ffffff;
            border-color: #334155;
        }

        body.dark-mode .btn-light:hover {
            background: #334155;
            color: #ffffff;
        }

        body.dark-mode .btn-outline-primary {
            color: #3b82f6;
            border-color: #3b82f6;
            background: transparent;
        }

        body.dark-mode .btn-outline-primary:hover {
            background: #2563eb;
            color: #ffffff;
            border-color: #2563eb;
        }

        body.dark-mode .btn-outline-secondary {
            color: #cbd5e1;
            border-color: #334155;
        }

        body.dark-mode .btn-outline-secondary:hover {
            background: #334155;
            color: #ffffff;
        }

        body.dark-mode .btn-outline-success {
            color: #34d399;
            border-color: #34d399;
        }

        body.dark-mode .btn-outline-success:hover {
            background: #047857;
            color: #ffffff;
            border-color: #047857;
        }

        body.dark-mode .btn-outline-danger {
            color: #f87171;
            border-color: #f87171;
        }

        body.dark-mode .btn-outline-danger:hover {
            background: #b91c1c;
            color: #ffffff;
            border-color: #b91c1c;
        }

        body.dark-mode .btn-outline-info {
            color: #38bdf8;
            border-color: #38bdf8;
        }

        body.dark-mode .btn-outline-info:hover {
            background: #0369a1;
            color: #ffffff;
            border-color: #0369a1;
        }

        body.dark-mode .btn-excel {
            background: #047857 !important;
            color: #ffffff !important;
        }

        body.dark-mode .btn-excel:hover {
            background: #059669 !important;
        }

        body.dark-mode .btn-pdf {
            background: #b91c1c !important;
            color: #ffffff !important;
        }

        body.dark-mode .btn-pdf:hover {
            background: #dc2626 !important;
        }

        /* Form elements in dark mode */
        body.dark-mode .form-control,
        body.dark-mode .form-select,
        body.dark-mode input,
        body.dark-mode select,
        body.dark-mode textarea {
            background: #1e293b;
            border-color: #334155;
            color: #ffffff;
        }

        body.dark-mode .form-control:focus,
        body.dark-mode .form-select:focus,
        body.dark-mode input:focus,
        body.dark-mode select:focus,
        body.dark-mode textarea:focus {
            background: #1e293b;
            border-color: #2563eb;
            color: #ffffff;
        }

        body.dark-mode .form-control::placeholder,
        body.dark-mode input::placeholder,
        body.dark-mode textarea::placeholder {
            color: #64748b;
        }

        body.dark-mode .form-label,
        body.dark-mode label {
            color: #cbd5e1;
        }

        /* Tables in dark mode */
        body.dark-mode .table,
        body.dark-mode .lao-table {
            color: #ffffff;
        }

        body.dark-mode .table thead th,
        body.dark-mode .lao-table thead th {
            background: #1e293b;
            color: #ffffff !important;
            border-color: #334155;
        }

        body.dark-mode .table tbody td,
        body.dark-mode .lao-table tbody td {
            background: #111827;
            color: #ffffff;
            border-color: #2a3446;
        }

        body.dark-mode .table tbody tr:hover td,
        body.dark-mode .lao-table tbody tr:hover td {
            background: #1e293b;
        }

        body.dark-mode .table-striped tbody tr:nth-of-type(odd) {
            background: #111827;
        }

        body.dark-mode .table-striped tbody tr:nth-of-type(even) {
            background: #0f172a;
        }

        /* Badges and status indicators */
        body.dark-mode .badge {
            background: #374151;
            color: #e2e8f0;
        }

        body.dark-mode .badge-primary {
            background: #1a4d8f;
            color: #e2e8f0;
        }

        body.dark-mode .badge-success {
            background: #047857;
            color: #e2e8f0;
        }

        body.dark-mode .badge-danger {
            background: #b91c1c;
            color: #e2e8f0;
        }

        body.dark-mode .badge-warning {
            background: #d97706;
            color: #e2e8f0;
        }

        body.dark-mode .badge-info {
            background: #0369a1;
            color: #e2e8f0;
        }

        body.dark-mode .badge-overdue {
            background: #b91c1c;
            color: #ffffff;
        }

        body.dark-mode .badge-due-soon {
            background: #d97706;
            color: #ffffff;
        }

        body.dark-mode .badge-active {
            background: #047857;
            color: #ffffff;
        }

        body.dark-mode .cell-status {
            color: #ffffff;
        }

        /* Alerts in dark mode */
        body.dark-mode .alert {
            background: #111827;
            border-color: #2a3446;
            color: #ffffff;
        }

        body.dark-mode .alert-success {
            background: #064e3b;
            border-color: #047857;
            color: #d1fae5;
        }

        body.dark-mode .alert-danger {
            background: #7f1d1d;
            border-color: #b91c1c;
            color: #fecaca;
        }

        body.dark-mode .alert-warning {
            background: #78350f;
            border-color: #d97706;
            color: #fde68a;
        }

        body.dark-mode .alert-info {
            background: #0c4a6e;
            border-color: #0369a1;
            color: #bae6fd;
        }

        /* Modals in dark mode */
        body.dark-mode .modal-content {
            background: #111827;
            border-color: #2a3446;
            color: #ffffff;
        }

        body.dark-mode .modal-header {
            background: #1e293b;
            border-bottom-color: #334155;
            color: #ffffff;
        }

        body.dark-mode .modal-body {
            background: #111827;
            color: #ffffff;
        }

        body.dark-mode .modal-footer {
            background: #0f172a;
            border-top-color: #2a3446;
        }

        body.dark-mode .modal-title {
            color: #ffffff;
        }

        body.dark-mode .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%);
        }

        /* Links in dark mode */
        body.dark-mode a {
            color: #3b82f6;
        }

        body.dark-mode a:hover {
            color: #60a5fa;
        }

        /* Dropdown menus */
        body.dark-mode .dropdown-menu {
            background: #111827;
            border-color: #2a3446;
        }

        body.dark-mode .dropdown-item {
            color: #cbd5e1;
        }

        body.dark-mode .dropdown-item:hover {
            background: #1e293b;
            color: #ffffff;
        }

        body.dark-mode .dropdown-divider {
            border-color: #2a3446;
        }

        /* Pagination */
        body.dark-mode .pagination .page-link {
            background: #1e293b;
            border-color: #334155;
            color: #cbd5e1;
        }

        body.dark-mode .pagination .page-link:hover {
            background: #334155;
            color: #ffffff;
        }

        body.dark-mode .pagination .page-item.active .page-link {
            background: #2563eb;
            border-color: #2563eb;
        }

        body.dark-mode .pagination .page-item.disabled .page-link {
            background: #111827;
            color: #64748b;
        }

        /* Row status backgrounds in dark mode */
        body.dark-mode .matrix-table tbody tr.row-overdue td {
            background: #7f1d1d !important;
            border-left-color: #6c757d;
        }

        body.dark-mode .matrix-table tbody tr.row-overdue:hover td {
            background: #991b1b !important;
        }

        body.dark-mode .matrix-table tbody tr.row-due-soon td {
            background: #78350f !important;
            border-left-color: #6c757d;
        }

        body.dark-mode .matrix-table tbody tr.row-due-soon:hover td {
            background: #92400e !important;
        }

        body.dark-mode .matrix-table tbody tr.row-active td {
            background: #111827 !important;
            border-left-color: #6c757d;
        }

        body.dark-mode .matrix-table tbody tr.row-active:hover td {
            background: #1e293b !important;
        }

        /* Text colors */
        body.dark-mode .text-muted {
            color: #94a3b8 !important;
        }

        body.dark-mode .text-primary {
            color: #3b82f6 !important;
        }

        body.dark-mode .text-secondary {
            color: #cbd5e1 !important;
        }

        body.dark-mode .text-success {
            color: #34d399 !important;
        }

        body.dark-mode .text-danger {
            color: #f87171 !important;
        }

        body.dark-mode .text-warning {
            color: #fbbf24 !important;
        }

        body.dark-mode .text-info {
            color: #38bdf8 !important;
        }

        body.dark-mode .text-dark {
            color: #ffffff !important;
        }

        /* Background colors */
        body.dark-mode .bg-light {
            background: #1e293b !important;
        }

        body.dark-mode .bg-white {
            background: #111827 !important;
        }

        /* Case-specific elements */
        body.dark-mode .cell-case-number {
            color: #ffffff;
        }

        body.dark-mode .td-case-title {
            color: #ffffff !important;
        }

        /* Filter controls */
        body.dark-mode .matrix-filters .btn-success,
        body.dark-mode .matrix-filters .btn-danger {
            color: #ffffff !important;
        }

        /* Empty states */
        body.dark-mode .matrix-empty {
            color: #9ca3af;
        }

        body.dark-mode .matrix-empty i {
            color: #6b7280;
        }

        /* List groups */
        body.dark-mode .list-group-item {
            background: #111827;
            border-color: #2a3446;
            color: #ffffff;
        }

        body.dark-mode .list-group-item:hover {
            background: #1e293b;
        }

        /* Cards and panels */
        body.dark-mode .card {
            background: #111827;
            border-color: #2a3446;
            color: #ffffff;
        }

        body.dark-mode .card-header {
            background: #0f172a;
            border-bottom-color: #2a3446;
            color: #ffffff;
        }

        body.dark-mode .card-body {
            background: #111827;
            color: #ffffff;
        }

        body.dark-mode .card-footer {
            background: #0f172a;
            border-top-color: #2a3446;
            color: #ffffff;
        }

        body.dark-mode .card-title {
            color: #ffffff;
        }

        body.dark-mode .card-text {
            color: #cbd5e1;
        }

        /* Breadcrumbs in dark mode */
        body.dark-mode .breadcrumb {
            background: #1e293b;
        }

        body.dark-mode .breadcrumb-item {
            color: #94a3b8;
        }

        body.dark-mode .breadcrumb-item.active {
            color: #ffffff;
        }

        body.dark-mode .breadcrumb-item a {
            color: #3b82f6;
        }

        /* Tooltips and popovers */
        body.dark-mode .tooltip-inner {
            background: #0f172a;
            color: #ffffff;
        }

        body.dark-mode .tooltip .tooltip-arrow::before {
            border-top-color: #0f172a;
        }

        body.dark-mode .popover {
            background: #111827;
            border-color: #2a3446;
        }

        body.dark-mode .popover-header {
            background: #0f172a;
            border-bottom-color: #2a3446;
            color: #ffffff;
        }

        body.dark-mode .popover-body {
            color: #cbd5e1;
        }

        /* Progress bars */
        body.dark-mode .progress {
            background: #1e293b;
        }

        /* Spinners and loaders */
        body.dark-mode .spinner-border,
        body.dark-mode .spinner-grow {
            color: #3b82f6;
        }

        /* Nav tabs */
        body.dark-mode .nav-tabs {
            border-bottom-color: #2a3446;
        }

        body.dark-mode .nav-tabs .nav-link {
            color: #94a3b8;
            background: transparent;
        }

        body.dark-mode .nav-tabs .nav-link:hover {
            color: #ffffff;
            border-color: #334155;
        }

        body.dark-mode .nav-tabs .nav-link.active {
            background: #111827;
            border-color: #2a3446;
            color: #ffffff;
        }

        /* Nav pills */
        body.dark-mode .nav-pills .nav-link {
            color: #94a3b8;
        }

        body.dark-mode .nav-pills .nav-link:hover {
            background: #1e293b;
            color: #ffffff;
        }

        body.dark-mode .nav-pills .nav-link.active {
            background: #2563eb;
            color: #ffffff;
        }

        /* Accordion */
        body.dark-mode .accordion-item {
            background: #111827;
            border-color: #2a3446;
        }

        body.dark-mode .accordion-button {
            background: #111827;
            color: #ffffff;
        }

        body.dark-mode .accordion-button:not(.collapsed) {
            background: #0f172a;
            color: #ffffff;
        }

        body.dark-mode .accordion-body {
            background: #111827;
            color: #cbd5e1;
        }

        /* Toasts */
        body.dark-mode .toast {
            background: #111827;
            border-color: #2a3446;
            color: #ffffff;
        }

        body.dark-mode .toast-header {
            background: #0f172a;
            border-bottom-color: #2a3446;
            color: #ffffff;
        }

        body.dark-mode .toast-body {
            color: #cbd5e1;
        }

        /* Offcanvas */
        body.dark-mode .offcanvas {
            background: #111827;
            color: #ffffff;
        }

        body.dark-mode .offcanvas-header {
            border-bottom-color: #2a3446;
        }

        body.dark-mode .offcanvas-title {
            color: #ffffff;
        }

        /* Code blocks */
        body.dark-mode code {
            background: #1e293b;
            color: #fbbf24;
        }

        body.dark-mode pre {
            background: #0f172a;
            color: #ffffff;
            border-color: #2a3446;
        }

        /* HR dividers */
        body.dark-mode hr {
            border-color: #2a3446;
            opacity: 1;
        }

        /* Small text */
        body.dark-mode small {
            color: #94a3b8;
        }

        /* Mark/highlight */
        body.dark-mode mark {
            background: #78350f;
            color: #fde68a;
        }

        /* Blockquotes */
        body.dark-mode blockquote {
            border-left-color: #334155;
            color: #cbd5e1;
        }

        /* User Profile Wrapper */
        .lao-user-profile-wrapper {
            position: relative;
        }

        /* Notification Dropdown */
        .notification-dropdown {
            position: absolute;
            top: calc(100% + 12px);
            right: 0;
            width: 420px;
            max-height: 500px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.15);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 1000;
            overflow: hidden;
        }

        .notification-dropdown.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .notification-dropdown-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--light-gray);
        }

        .notification-dropdown-body {
            max-height: 400px;
            overflow-y: auto;
        }

        .notification-item {
            padding: 16px 20px;
            display: flex;
            gap: 12px;
            border-bottom: 1px solid var(--border-color);
            cursor: pointer;
            transition: background 0.2s;
            text-decoration: none;
            color: inherit;
        }

        .notification-link:hover {
            text-decoration: none;
        }

        .notification-item:hover {
            background: var(--light-gray);
        }

        .notification-item.unread {
            background: rgba(21, 101, 192, 0.05);
        }

        .notification-item.unread:hover {
            background: rgba(21, 101, 192, 0.08);
        }

        .notification-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            flex-shrink: 0;
        }

        .notification-content {
            flex: 1;
            min-width: 0;
        }

        .notification-text {
            margin: 0;
            font-size: 14px;
            color: var(--text-primary);
            line-height: 1.5;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .notification-time {
            font-size: 12px;
            color: var(--text-secondary);
        }

        .notification-dropdown-footer {
            padding: 12px 20px;
            border-top: 1px solid #e2e8f0;
            background: #f9fafb;
        }

        .lao-notification-badge {
            position: absolute;
            top: 2px;
            right: 2px;
            min-width: 20px;
            height: 20px;
            padding: 0 5px;
            background: #EF4444;
            color: white;
            border-radius: 10px;
            font-size: 11px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .lao-user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 6px 12px 6px 6px;
            border-radius: 6px;
            background: var(--light-gray);
            border: 1px solid var(--border-color);
            cursor: pointer;
            transition: all 0.2s;
        }

        .lao-user-profile:hover {
            background: var(--white);
            border-color: var(--navy-blue);
        }

        .lao-user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 6px;
            background: var(--navy-blue);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 13px;
            flex-shrink: 0;
            overflow: hidden;
            position: relative;
        }

        .lao-user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .lao-user-info {
            text-align: left;
        }

        .lao-user-name {
            font-size: 13px;
            font-weight: 600;
            line-height: 1.2;
            color: var(--text-primary);
        }

        .lao-user-role {
            font-size: 11px;
            color: var(--text-secondary);
            line-height: 1.2;
        }

        /* User Dropdown */
        .user-dropdown {
            position: absolute;
            top: calc(100% + 12px);
            right: 0;
            width: 260px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.15);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 1000;
            overflow: hidden;
        }

        .user-dropdown.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .user-dropdown-header {
            padding: 20px;
            border-bottom: 1px solid var(--border-color);
            background: var(--navy-blue);
            color: white;
        }

        .user-dropdown-user {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-dropdown-avatar {
            width: 48px;
            height: 48px;
            border-radius: 8px;
            background: var(--lao-primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 16px;
            flex-shrink: 0;
            overflow: hidden;
        }

        .user-dropdown-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .user-dropdown-info h6 {
            margin: 0;
            font-size: 15px;
            font-weight: 700;
            color: #ffffff !important;
        }

        .user-dropdown-info p {
            margin: 0;
            font-size: 12px;
            color: #e5e7eb !important;
        }

        .user-dropdown-body {
            padding: 8px;
        }

        .user-dropdown-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 8px;
            color: var(--text-primary);
            text-decoration: none;
            transition: all 0.2s;
            cursor: pointer;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            font-size: 14px;
        }

        .user-dropdown-item i {
            width: 20px;
            font-size: 16px;
            color: var(--text-secondary);
        }

        .user-dropdown-item:hover {
            background: #f9fafb;
            color: var(--navy-blue);
        }

        .user-dropdown-item:hover i {
            color: var(--navy-blue);
        }

        .user-dropdown-item.logout {
            color: #dc2626;
        }

        .user-dropdown-item.logout i {
            color: #dc2626;
        }

        .user-dropdown-item.logout:hover {
            background: #fef2f2;
        }

        /* Main Content */
        .lao-main {
            margin-left: var(--sidebar-width);
            margin-top: 70px;
            padding: 32px;
            min-height: calc(100vh - 70px);
            background: var(--light-gray);
        }

        /* Page Header */
        .lao-page-header {
            margin-bottom: 28px;
        }

        .lao-page-title {
            font-size: 28px;
            font-weight: 800;
            color: var(--navy-blue);
            margin-bottom: 6px;
            letter-spacing: -0.02em;
        }

        .lao-page-subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            font-weight: 500;
        }

        /* Cards */
        .lao-card {
            background: var(--white);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: var(--shadow-sm);
            transition: all 0.2s ease;
        }

        .lao-stat-card {
            background: var(--white);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 24px;
            transition: all 0.2s ease;
            box-shadow: var(--shadow-sm);
        }

        .lao-stat-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
            border-color: var(--border-color);
        }

        .lao-stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 16px;
        }

        .lao-stat-icon.primary {
            background: rgba(30, 42, 56, 0.1);
            color: var(--navy-blue);
        }

        .lao-stat-icon.success {
            background: rgba(46, 125, 50, 0.1);
            color: var(--status-success);
        }

        .lao-stat-icon.warning {
            background: rgba(237, 108, 2, 0.1);
            color: var(--status-warning);
        }

        .lao-stat-icon.danger {
            background: rgba(198, 40, 40, 0.1);
            color: var(--status-danger);
        }

        .lao-stat-label {
            font-size: 12px;
            color: var(--text-secondary);
            font-weight: 600;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .lao-stat-value {
            font-size: 32px;
            font-weight: 700;
            color: var(--text-primary);
            line-height: 1;
            margin-bottom: 4px;
        }

        /* Buttons */
        .btn-lao-primary {
            background: var(--navy-blue);
            color: var(--white);
            border: none;
            padding: 11px 22px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.2s ease;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
            letter-spacing: 0;
        }

        .btn-lao-primary:hover {
            background: var(--navy-blue-light);
            color: var(--white);
            transform: translateY(-1px);
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.12);
        }

        /* Tables */
        .lao-table {
            width: 100%;
            border-collapse: collapse;
        }

        .lao-table thead th {
            background: var(--navy-blue);
            padding: 14px 16px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            color: #ffffff !important;
            border-bottom: 2px solid var(--navy-blue-light);
            letter-spacing: 0.8px;
        }

        .lao-table tbody td {
            padding: 16px;
            border-bottom: 1px solid var(--border-color);
            font-size: 13px;
        }

        .lao-table tbody tr:hover {
            background: var(--light-gray);
        }

        .lao-table tbody tr.status-green {
            border-left: 3px solid var(--status-success);
            background: rgba(46, 125, 50, 0.03);
        }

        .lao-table tbody tr.status-yellow {
            border-left: 3px solid var(--status-warning);
            background: rgba(237, 108, 2, 0.03);
        }

        .lao-table tbody tr.status-red {
            border-left: 3px solid var(--status-danger);
            background: rgba(198, 40, 40, 0.03);
        }

        /* Badges */
        .lao-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 5px 12px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .lao-badge.badge-success {
            background: rgba(46, 125, 50, 0.1);
            color: var(--status-success);
            border: 1px solid rgba(46, 125, 50, 0.2);
        }

        .lao-badge.badge-warning {
            background: rgba(237, 108, 2, 0.1);
            color: var(--status-warning);
            border: 1px solid rgba(237, 108, 2, 0.2);
        }

        .lao-badge.badge-danger {
            background: rgba(198, 40, 40, 0.1);
            color: var(--status-danger);
            border: 1px solid rgba(198, 40, 40, 0.2);
        }

        .lao-badge.badge-secondary {
            background: rgba(74, 85, 104, 0.08);
            color: var(--text-secondary);
            border: 1px solid rgba(74, 85, 104, 0.15);
        }

        /* Alert Styles */
        .alert {
            border-radius: 8px;
            border: none;
            padding: 16px;
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            animation: slideInDown 0.5s ease-out;
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert.fade-out {
            opacity: 0;
            transform: translateY(-20px);
            transition: all 1.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .alert-dismissible .btn-close {
            transition: all 0.3s ease;
        }

        .alert-dismissible .btn-close:hover {
            transform: rotate(90deg);
            opacity: 0.7;
        }

        /* Bootstrap Card Overrides */
        .card {
            background: var(--white);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: var(--shadow-sm);
            margin-bottom: 24px;
        }

        .card-header {
            background: var(--navy-blue);
            color: white;
            border-bottom: 2px solid var(--soft-gold);
            padding: 16px 20px;
            font-weight: 700;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-radius: 12px 12px 0 0 !important;
        }

        .card-header h6 {
            color: white;
            margin: 0;
            font-size: 14px;
            font-weight: 700;
        }

        .card-body {
            padding: 24px;
        }

        .card:hover {
            box-shadow: var(--shadow-md);
        }

        /* Enhanced Text Clarity for Case Information */
        .table td.fw-bold,
        .fw-bold {
            font-weight: 700 !important;
            color: var(--navy-blue);
        }

        .table tbody td {
            color: var(--text-primary);
            font-weight: 500;
        }

        .table thead th {
            font-weight: 700;
            color: #36454F;
        }

        /* Case-specific text enhancement */
        .table td:first-child {
            font-weight: 600;
            color: #000000;
        }

        /* Bootstrap Primary Color Override - Law Theme */
        .text-primary {
            color: var(--soft-gold) !important;
        }

        .bg-primary {
            background-color: var(--soft-gold) !important;
        }

        .border-primary {
            border-color: var(--soft-gold) !important;
        }

        .btn-primary {
            background-color: var(--navy-blue);
            border-color: var(--navy-blue);
            color: var(--white);
            font-weight: 500;
            letter-spacing: 0;
            padding: 10px 20px;
            border-radius: 6px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .btn-primary:hover,
        .btn-primary:focus {
            background-color: var(--navy-blue-light);
            border-color: var(--navy-blue-light);
            color: var(--white);
            transform: none;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
        }

        .btn-success {
            background-color: var(--status-success);
            border-color: var(--status-success);
            color: var(--white);
            font-weight: 500;
            letter-spacing: 0;
            padding: 10px 20px;
            border-radius: 6px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .btn-success:hover,
        .btn-success:focus {
            background-color: #25692A;
            border-color: #25692A;
            color: var(--white);
            transform: none;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
        }

        .btn-danger {
            background-color: var(--status-danger);
            border-color: var(--status-danger);
            color: var(--white);
            font-weight: 500;
            letter-spacing: 0;
            padding: 10px 20px;
            border-radius: 6px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .btn-danger:hover,
        .btn-danger:focus {
            background-color: #A71E1E;
            border-color: #A71E1E;
            color: var(--white);
            transform: none;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
        }

        .btn-outline-primary {
            color: var(--navy-blue);
            border-color: var(--navy-blue);
            border-width: 1px;
            font-weight: 500;
            letter-spacing: 0;
            background-color: transparent;
        }

        .btn-outline-primary:hover,
        .btn-outline-primary:focus {
            background-color: var(--navy-blue);
            border-color: var(--navy-blue);
            color: var(--white);
        }

        .btn-outline-danger {
            color: var(--status-danger);
            border-color: var(--status-danger);
            border-width: 1px;
            font-weight: 500;
            letter-spacing: 0;
            background-color: transparent;
        }

        .btn-outline-danger:hover,
        .btn-outline-danger:focus {
            background-color: var(--status-danger);
            border-color: var(--status-danger);
            color: var(--white);
        }

        .btn-outline-success {
            color: var(--status-success);
            border-color: var(--status-success);
            border-width: 1px;
            font-weight: 500;
            letter-spacing: 0;
            background-color: transparent;
        }

        .btn-outline-success:hover,
        .btn-outline-success:focus {
            background-color: var(--status-success);
            border-color: var(--status-success);
            color: var(--white);
        }

        /* Small button adjustments */
        .btn-sm.btn-primary,
        .btn-sm.btn-success,
        .btn-sm.btn-danger {
            font-weight: 500;
            padding: 6px 12px;
        }

        .btn-sm.btn-outline-primary,
        .btn-sm.btn-outline-success,
        .btn-sm.btn-outline-danger {
            font-weight: 500;
            padding: 6px 12px;
        }

        .badge.bg-primary {
            background-color: var(--navy-blue) !important;
            color: var(--white) !important;
            font-weight: 500;
        }

        .badge.bg-success {
            background-color: var(--status-success) !important;
            color: var(--white) !important;
            font-weight: 500;
        }

        .badge.bg-warning {
            background-color: var(--status-warning) !important;
            color: var(--white) !important;
            font-weight: 500;
        }

        .badge.bg-warning.text-dark {
            background-color: var(--status-warning) !important;
            color: var(--white) !important;
            font-weight: 500;
        }

        .badge.bg-danger {
            background-color: var(--status-danger) !important;
            color: var(--white) !important;
            font-weight: 500;
        }

        .badge.bg-info {
            background-color: var(--status-info) !important;
            color: var(--white) !important;
            font-weight: 500;
        }

        .badge.bg-secondary {
            background-color: var(--text-secondary) !important;
            color: var(--white) !important;
            font-weight: 500;
        }

        .nav-link.active,
        .nav-tabs .nav-link.active {
            color: var(--navy-blue) !important;
            border-color: var(--border-color) var(--border-color) var(--navy-blue) !important;
            font-weight: 700;
        }

        .form-check-input:checked {
            background-color: var(--navy-blue);
            border-color: var(--navy-blue);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--navy-blue);
            box-shadow: 0 0 0 0.25rem rgba(30, 42, 56, 0.25);
        }

        /* Link Colors */
        a:not(.btn):not(.nav-link):not(.lao-nav-link):not(.lao-logo) {
            color: var(--navy-blue);
            font-weight: 500;
        }

        a:not(.btn):not(.nav-link):not(.lao-nav-link):not(.lao-logo):hover {
            color: var(--olive-green);
        }

        /* Card Styles */
        .card {
            background: var(--white);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: var(--shadow-sm);
            margin-bottom: 24px;
            overflow: hidden;
        }

        .card-header {
            background: var(--white);
            border-bottom: 1px solid var(--border-color);
            padding: 16px 20px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .card-body {
            padding: 20px;
        }

        .card-title {
            color: var(--text-primary);
            font-weight: 600;
            font-size: 16px;
            margin-bottom: 8px;
        }

        .card h3 {
            font-weight: 700;
            font-size: 32px;
            line-height: 1;
        }

        .card .text-muted {
            color: var(--text-secondary) !important;
            font-size: 13px;
        }

        .card.border-success {
            border-left: 3px solid var(--status-success);
        }

        /* Dashboard Stat Cards */
        .card .text-primary {
            color: var(--navy-blue) !important;
        }

        .card .text-success {
            color: var(--status-success) !important;
        }

        .card .text-warning {
            color: var(--status-warning) !important;
        }

        .card .text-info {
            color: var(--status-info) !important;
        }

        .card .text-danger {
            color: var(--status-danger) !important;
        }

        .card .text-secondary {
            color: var(--text-secondary) !important;
        }

        /* Tables */
        .table {
            color: var(--text-primary);
        }

        .table-light {
            background-color: #F8F9FA;
            border-bottom: 2px solid var(--border-color);
        }

        .table thead th {
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-secondary);
            padding: 12px 16px;
        }

        .table tbody td {
            padding: 14px 16px;
            vertical-align: middle;
            color: var(--text-primary);
        }

        .table-hover tbody tr:hover {
            background-color: rgba(198, 168, 94, 0.03);
        }

        /* Alerts */
        .alert {
            border-radius: 8px;
            border-width: 1px;
            padding: 14px 18px;
            font-size: 14px;
        }

        .alert-success {
            background-color: rgba(46, 125, 50, 0.08);
            border-color: var(--status-success);
            color: #1B5E20;
        }

        .alert-danger {
            background-color: rgba(198, 40, 40, 0.08);
            border-color: var(--status-danger);
            color: #8B1C1C;
        }

        .alert-warning {
            background-color: rgba(237, 108, 2, 0.08);
            border-color: var(--status-warning);
            color: #B85400;
        }

        .alert-info {
            background-color: rgba(21, 101, 192, 0.08);
            border-color: var(--status-info);
            color: #0D4380;
        }

        /* Modals */
        .modal-content {
            border-radius: 12px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-lg);
        }

        .modal-header {
            background: var(--white);
            border-bottom: 1px solid var(--border-color);
            padding: 18px 24px;
        }

        .modal-title {
            font-weight: 600;
            font-size: 18px;
            color: var(--text-primary);
        }

        .modal-body {
            padding: 24px;
        }

        .modal-footer {
            background: var(--white);
            border-top: 1px solid var(--border-color);
            padding: 16px 24px;
        }

        /* Form Elements */
        .form-label {
            font-weight: 600;
            color: #1a202c;
            margin-bottom: 6px;
            font-size: 13px;
        }

        .form-control,
        .form-select {
            border-color: var(--border-color);
            color: #1a202c;
            font-size: 14px;
            padding: 8px 12px;
            border-radius: 6px;
        }

        .form-select {
            padding-right: 2.5rem !important;
            background-position: right 0.75rem center !important;
        }

        .form-control::placeholder {
            color: var(--text-secondary);
            opacity: 0.6;
        }

        /* Typography */
        h1, h2, h3, h4, h5, h6 {
            color: var(--text-primary);
            font-weight: 600;
            line-height: 1.3;
        }

        h1 {
            font-size: 32px;
        }

        h2 {
            font-size: 26px;
        }

        h3 {
            font-size: 22px;
        }

        h4 {
            font-size: 18px;
        }

        h5 {
            font-size: 16px;
        }

        h6 {
            font-size: 14px;
        }

        .text-muted {
            color: var(--text-secondary) !important;
        }

        /* Page Sections */
        .container-fluid {
            padding: 24px 28px;
        }

        .section-title {
            color: var(--text-primary);
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Breadcrumbs */
        .breadcrumb-item.active {
            color: var(--navy-blue);
            font-weight: 500;
        }

        .breadcrumb-item a {
            color: var(--navy-blue);
            font-weight: 500;
        }

        .breadcrumb-item a:hover {
            color: var(--navy-blue-light);
        }

        /* Chart Bar Colors */
        .chart-bar-fill.bg-primary {
            background-color: var(--navy-blue) !important;
        }

        /* Custom Icon Colors by Type */
        .icon-folder {
            color: #d97706 !important; /* Amber - for folders/sections */
        }

        .icon-building {
            color: #475569 !important; /* Slate gray - for courts/buildings */
        }

        .icon-shield {
            color: #2563eb !important; /* Blue - for authority/ombudsman */
        }

        .icon-people {
            color: #059669 !important; /* Emerald - for community/NCIP */
        }

        .icon-innovation {
            color: #eab308 !important; /* Yellow - for special/IP */
        }

        .icon-location {
            color: #0891b2 !important; /* Cyan - for regions/geography */
        }

        .icon-calendar {
            color: var(--navy-blue) !important;
        }

        .icon-chart {
            color: #8b5cf6 !important; /* Purple - for analytics */
        }

        .icon-archive {
            color: #6b7280 !important; /* Gray - for other/archive */
        }

        /* Action Icon Colors */
        .bi-save, .bi-check-circle, .bi-check, .bi-check2, .bi-plus-circle, .bi-upload {
            color: var(--status-success) !important; /* Green - for save/success actions */
        }

        .bi-pencil, .bi-pencil-square, .bi-pen {
            color: var(--status-info) !important; /* Blue - for edit actions */
        }

        .bi-trash, .bi-trash3, .bi-x-circle, .bi-x {
            color: var(--status-danger) !important; /* Red - for delete/remove actions */
        }

        .bi-eye, .bi-eye-fill, .bi-info-circle, .bi-info-circle-fill {
            color: var(--status-info) !important; /* Blue - for view/info actions */
        }

        .bi-download, .bi-file-earmark-arrow-down {
            color: #8B5CF6 !important; /* Purple - for download actions */
        }

        .bi-search, .bi-zoom-in {
            color: var(--text-secondary) !important; /* Gray - for search actions */
        }

        .bi-bell, .bi-bell-fill {
            color: var(--status-warning) !important; /* Amber - for notifications */
        }

        .bi-gear, .bi-gear-fill, .bi-sliders {
            color: var(--text-secondary) !important; /* Gray - for settings */
        }

        .bi-printer, .bi-printer-fill {
            color: #475569 !important; /* Slate - for print actions */
        }

        .bi-share, .bi-share-fill {
            color: #06B6D4 !important; /* Cyan - for share actions */
        }

        .bi-lock, .bi-lock-fill, .bi-shield-lock {
            color: var(--status-danger) !important; /* Red - for security/lock */
        }

        .bi-unlock, .bi-unlock-fill {
            color: var(--status-success) !important; /* Green - for unlock */
        }

        .bi-star, .bi-star-fill {
            color: var(--status-warning) !important; /* Amber - for favorites */
        }

        .bi-file-earmark-text, .bi-file-text {
            color: #6366F1 !important; /* Indigo - for documents */
        }

        /* Override icon colors in buttons to use button's text color */
        .btn i {
            color: inherit !important;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .lao-sidebar {
                transform: translateX(-100%);
            }

            .lao-topbar,
            .lao-main {
                margin-left: 0;
            }
        }
    </style>

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <!-- CRITICAL: Apply dark mode to body immediately -->
    <script>
        if (localStorage.getItem('darkMode') === 'enabled') {
            document.body.classList.add('dark-mode');
            document.body.style.cssText = 'background-color: #0f172a !important; color: #ffffff !important;';
        }
    </script>
    
    <!-- Sidebar -->
    <aside class="lao-sidebar">
        <div class="lao-sidebar-header">
            <a href="<?php echo e(route('dashboard')); ?>" class="lao-logo">
                <div class="lao-logo-icon">
                    <i class="bi bi-briefcase"></i>
                </div>
                <div class="lao-logo-text">
                    <h6>Legal Affairs Office</h6>
                    <h5>Case Tracking System</h5>
                </div>
            </a>
        </div>

        <nav class="lao-nav">
            <div class="lao-nav-section">
                <div class="lao-nav-item">
                    <a href="<?php echo e(route('dashboard')); ?>" class="lao-nav-link <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>">
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </div>
                
                <div class="lao-nav-item has-dropdown" data-dropdown-id="cases-dropdown">
                    <a href="javascript:void(0)" class="lao-nav-link <?php echo e(request()->routeIs('cases.*') ? 'active' : ''); ?>" data-toggle-dropdown>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <i class="bi bi-folder-fill"></i>
                            <span>Cases</span>
                        </div>
                        <i class="bi bi-chevron-right dropdown-arrow"></i>
                    </a>
                    <div class="lao-nav-dropdown">
                        <div class="lao-nav-dropdown-item">
                            <a href="<?php echo e(route('cases.index')); ?>" class="lao-nav-dropdown-link <?php echo e(request()->routeIs('cases.index') && !request()->routeIs('cases.information') ? 'active' : ''); ?>">
                                <i class="bi bi-list-ul"></i>
                                <span>All Cases</span>
                            </a>
                        </div>
                        <div class="lao-nav-dropdown-item">
                            <a href="<?php echo e(route('cases.information')); ?>" class="lao-nav-dropdown-link <?php echo e(request()->routeIs('cases.information') ? 'active' : ''); ?>">
                                <i class="bi bi-info-circle"></i>
                                <span>Case Information</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lao-nav-section">
                <div class="lao-nav-section-title">Filters & Classification</div>
                
                <div class="lao-nav-item has-dropdown" data-dropdown-id="sections-dropdown">
                    <a href="javascript:void(0)" class="lao-nav-link <?php echo e(request()->routeIs('sections.*') ? 'active' : ''); ?>" data-toggle-dropdown>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <i class="bi bi-diagram-3-fill"></i>
                            <span>Sections</span>
                        </div>
                        <i class="bi bi-chevron-right dropdown-arrow"></i>
                    </a>
                    <div class="lao-nav-dropdown">
                        <div class="lao-nav-dropdown-item">
                            <a href="<?php echo e(route('cases.index', ['section' => 'Criminal'])); ?>" class="lao-nav-dropdown-link <?php echo e(request()->get('section') == 'Criminal' ? 'active' : ''); ?>">
                                <i class="bi bi-shield-exclamation"></i>
                                <span>Criminal</span>
                            </a>
                        </div>
                        <div class="lao-nav-dropdown-item">
                            <a href="<?php echo e(route('cases.index', ['section' => 'Civil'])); ?>" class="lao-nav-dropdown-link <?php echo e(request()->get('section') == 'Civil' ? 'active' : ''); ?>">
                                <i class="bi bi-file-text"></i>
                                <span>Civil</span>
                            </a>
                        </div>
                        <div class="lao-nav-dropdown-item">
                            <a href="<?php echo e(route('cases.index', ['section' => 'Labor'])); ?>" class="lao-nav-dropdown-link <?php echo e(request()->get('section') == 'Labor' ? 'active' : ''); ?>">
                                <i class="bi bi-briefcase"></i>
                                <span>Labor</span>
                            </a>
                        </div>
                        <div class="lao-nav-dropdown-item">
                            <a href="<?php echo e(route('cases.index', ['section' => 'Administrative'])); ?>" class="lao-nav-dropdown-link <?php echo e(request()->get('section') == 'Administrative' ? 'active' : ''); ?>">
                                <i class="bi bi-building"></i>
                                <span>Administrative</span>
                            </a>
                        </div>
                        <div class="lao-nav-dropdown-item">
                            <a href="<?php echo e(route('cases.index', ['section' => 'Special'])); ?>" class="lao-nav-dropdown-link <?php echo e(request()->get('section') == 'Special' ? 'active' : ''); ?>">
                                <i class="bi bi-star"></i>
                                <span>Special Proceedings</span>
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="lao-nav-item has-dropdown" data-dropdown-id="courts-dropdown">
                    <a href="javascript:void(0)" class="lao-nav-link <?php echo e(request()->routeIs('courts.*') ? 'active' : ''); ?>" data-toggle-dropdown>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <i class="bi bi-bank"></i>
                            <span>Courts & Agencies</span>
                        </div>
                        <i class="bi bi-chevron-right dropdown-arrow"></i>
                    </a>
                    <div class="lao-nav-dropdown">
                        <div class="lao-nav-dropdown-item">
                            <a href="<?php echo e(route('cases.index', ['court' => 'SC'])); ?>" class="lao-nav-dropdown-link <?php echo e(request()->get('court') == 'SC' ? 'active' : ''); ?>">
                                <i class="bi bi-trophy"></i>
                                <span>Supreme Court</span>
                            </a>
                        </div>
                        <div class="lao-nav-dropdown-item">
                            <a href="<?php echo e(route('cases.index', ['court' => 'CA'])); ?>" class="lao-nav-dropdown-link <?php echo e(request()->get('court') == 'CA' ? 'active' : ''); ?>">
                                <i class="bi bi-building"></i>
                                <span>Court of Appeals</span>
                            </a>
                        </div>
                        <div class="lao-nav-dropdown-item">
                            <a href="<?php echo e(route('cases.index', ['court' => 'RTC'])); ?>" class="lao-nav-dropdown-link <?php echo e(request()->get('court') == 'RTC' ? 'active' : ''); ?>">
                                <i class="bi bi-bank2"></i>
                                <span>Regional Trial Court</span>
                            </a>
                        </div>
                        <div class="lao-nav-dropdown-item">
                            <a href="<?php echo e(route('cases.index', ['court' => 'OMB'])); ?>" class="lao-nav-dropdown-link <?php echo e(request()->get('court') == 'OMB' ? 'active' : ''); ?>">
                                <i class="bi bi-shield-check"></i>
                                <span>Office of the Ombudsman</span>
                            </a>
                        </div>
                        <div class="lao-nav-dropdown-item">
                            <a href="<?php echo e(route('cases.index', ['court' => 'NCIP'])); ?>" class="lao-nav-dropdown-link <?php echo e(request()->get('court') == 'NCIP' ? 'active' : ''); ?>">
                                <i class="bi bi-people"></i>
                                <span>NCIP</span>
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="lao-nav-item has-dropdown" data-dropdown-id="regions-dropdown">
                    <a href="javascript:void(0)" class="lao-nav-link <?php echo e(request()->routeIs('regions.*') ? 'active' : ''); ?>" data-toggle-dropdown>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <i class="bi bi-geo-alt-fill"></i>
                            <span>Regions</span>
                        </div>
                        <i class="bi bi-chevron-right dropdown-arrow"></i>
                    </a>
                    <div class="lao-nav-dropdown">
                        <div class="lao-nav-dropdown-item">
                            <a href="<?php echo e(route('cases.index', ['region' => 'NCR'])); ?>" class="lao-nav-dropdown-link <?php echo e(request()->get('region') == 'NCR' ? 'active' : ''); ?>">
                                <i class="bi bi-geo-alt"></i>
                                <span>NCR</span>
                            </a>
                        </div>
                        <div class="lao-nav-dropdown-item">
                            <a href="<?php echo e(route('cases.index', ['region' => 'Region I'])); ?>" class="lao-nav-dropdown-link <?php echo e(request()->get('region') == 'Region I' ? 'active' : ''); ?>">
                                <i class="bi bi-geo-alt"></i>
                                <span>Region I - Ilocos</span>
                            </a>
                        </div>
                        <div class="lao-nav-dropdown-item">
                            <a href="<?php echo e(route('cases.index', ['region' => 'Region II'])); ?>" class="lao-nav-dropdown-link <?php echo e(request()->get('region') == 'Region II' ? 'active' : ''); ?>">
                                <i class="bi bi-geo-alt"></i>
                                <span>Region II - Cagayan Valley</span>
                            </a>
                        </div>
                        <div class="lao-nav-dropdown-item">
                            <a href="<?php echo e(route('cases.index', ['region' => 'Region III'])); ?>" class="lao-nav-dropdown-link <?php echo e(request()->get('region') == 'Region III' ? 'active' : ''); ?>">
                                <i class="bi bi-geo-alt"></i>
                                <span>Region III - Central Luzon</span>
                            </a>
                        </div>
                        <div class="lao-nav-dropdown-item">
                            <a href="<?php echo e(route('cases.index', ['region' => 'Region IV-A'])); ?>" class="lao-nav-dropdown-link <?php echo e(request()->get('region') == 'Region IV-A' ? 'active' : ''); ?>">
                                <i class="bi bi-geo-alt"></i>
                                <span>Region IV-A - CALABARZON</span>
                            </a>
                        </div>
                        <div class="lao-nav-dropdown-item">
                            <a href="<?php echo e(route('cases.index', ['region' => 'Region V'])); ?>" class="lao-nav-dropdown-link <?php echo e(request()->get('region') == 'Region V' ? 'active' : ''); ?>">
                                <i class="bi bi-geo-alt"></i>
                                <span>Region V - Bicol</span>
                            </a>
                        </div>
                        <div class="lao-nav-dropdown-item">
                            <a href="<?php echo e(route('cases.index', ['region' => 'Region IV-B'])); ?>" class="lao-nav-dropdown-link <?php echo e(request()->get('region') == 'Region IV-B' ? 'active' : ''); ?>">
                                <i class="bi bi-geo-alt"></i>
                                <span>Region IV-B - MIMAROPA</span>
                            </a>
                        </div>
                        <div class="lao-nav-dropdown-item">
                            <a href="<?php echo e(route('cases.index', ['region' => 'Region VI'])); ?>" class="lao-nav-dropdown-link <?php echo e(request()->get('region') == 'Region VI' ? 'active' : ''); ?>">
                                <i class="bi bi-geo-alt"></i>
                                <span>Region VI - Western Visayas</span>
                            </a>
                        </div>
                        <div class="lao-nav-dropdown-item">
                            <a href="<?php echo e(route('cases.index', ['region' => 'Region VII'])); ?>" class="lao-nav-dropdown-link <?php echo e(request()->get('region') == 'Region VII' ? 'active' : ''); ?>">
                                <i class="bi bi-geo-alt"></i>
                                <span>Region VII - Central Visayas</span>
                            </a>
                        </div>
                        <div class="lao-nav-dropdown-item">
                            <a href="<?php echo e(route('cases.index', ['region' => 'Region VIII'])); ?>" class="lao-nav-dropdown-link <?php echo e(request()->get('region') == 'Region VIII' ? 'active' : ''); ?>">
                                <i class="bi bi-geo-alt"></i>
                                <span>Region VIII - Eastern Visayas</span>
                            </a>
                        </div>
                        <div class="lao-nav-dropdown-item">
                            <a href="<?php echo e(route('cases.index', ['region' => 'Region IX'])); ?>" class="lao-nav-dropdown-link <?php echo e(request()->get('region') == 'Region IX' ? 'active' : ''); ?>">
                                <i class="bi bi-geo-alt"></i>
                                <span>Region IX - Zamboanga Peninsula</span>
                            </a>
                        </div>
                        <div class="lao-nav-dropdown-item">
                            <a href="<?php echo e(route('cases.index', ['region' => 'Region X'])); ?>" class="lao-nav-dropdown-link <?php echo e(request()->get('region') == 'Region X' ? 'active' : ''); ?>">
                                <i class="bi bi-geo-alt"></i>
                                <span>Region X - Northern Mindanao</span>
                            </a>
                        </div>
                        <div class="lao-nav-dropdown-item">
                            <a href="<?php echo e(route('cases.index', ['region' => 'Region XI'])); ?>" class="lao-nav-dropdown-link <?php echo e(request()->get('region') == 'Region XI' ? 'active' : ''); ?>">
                                <i class="bi bi-geo-alt"></i>
                                <span>Region XI - Davao</span>
                            </a>
                        </div>
                        <div class="lao-nav-dropdown-item">
                            <a href="<?php echo e(route('cases.index', ['region' => 'Region XII'])); ?>" class="lao-nav-dropdown-link <?php echo e(request()->get('region') == 'Region XII' ? 'active' : ''); ?>">
                                <i class="bi bi-geo-alt"></i>
                                <span>Region XII - SOCCSKSARGEN</span>
                            </a>
                        </div>
                        <div class="lao-nav-dropdown-item">
                            <a href="<?php echo e(route('cases.index', ['region' => 'Region XIII'])); ?>" class="lao-nav-dropdown-link <?php echo e(request()->get('region') == 'Region XIII' ? 'active' : ''); ?>">
                                <i class="bi bi-geo-alt"></i>
                                <span>Region XIII - Caraga</span>
                            </a>
                        </div>
                        <div class="lao-nav-dropdown-item">
                            <a href="<?php echo e(route('cases.index', ['region' => 'CAR'])); ?>" class="lao-nav-dropdown-link <?php echo e(request()->get('region') == 'CAR' ? 'active' : ''); ?>">
                                <i class="bi bi-geo-alt"></i>
                                <span>CAR - Cordillera</span>
                            </a>
                        </div>
                        <div class="lao-nav-dropdown-item">
                            <a href="<?php echo e(route('cases.index', ['region' => 'BARMM'])); ?>" class="lao-nav-dropdown-link <?php echo e(request()->get('region') == 'BARMM' ? 'active' : ''); ?>">
                                <i class="bi bi-geo-alt"></i>
                                <span>BARMM</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lao-nav-section">
                <div class="lao-nav-section-title">Tracking & Alerts</div>
                
                <div class="lao-nav-item">
                    <a href="<?php echo e(route('deadlines.index')); ?>" class="lao-nav-link <?php echo e(request()->routeIs('deadlines.*') ? 'active' : ''); ?>">
                        <i class="bi bi-calendar-check"></i>
                        <span>Deadlines</span>
                    </a>
                </div>
                
                <div class="lao-nav-item">
                    <a href="<?php echo e(route('cases.index', ['status' => 'completed'])); ?>" class="lao-nav-link <?php echo e(request()->get('status') == 'completed' ? 'active' : ''); ?>">
                        <i class="bi bi-check-circle"></i>
                        <span>Completed Cases</span>
                    </a>
                </div>
                
                <div class="lao-nav-item">
                    <a href="<?php echo e(route('notifications.index')); ?>" class="lao-nav-link <?php echo e(request()->routeIs('notifications.*') ? 'active' : ''); ?>">
                        <i class="bi bi-bell-fill"></i>
                        <span>Notifications</span>
                    </a>
                </div>
            </div>

            <div class="lao-nav-section">
                <div class="lao-nav-section-title">Reports & Admin</div>
                
                <div class="lao-nav-item">
                    <a href="<?php echo e(route('reports.index')); ?>" class="lao-nav-link <?php echo e(request()->routeIs('reports.*') ? 'active' : ''); ?>">
                        <i class="bi bi-graph-up icon-chart"></i>
                        <span>Reports</span>
                    </a>
                </div>
                
                <div class="lao-nav-item">
                    <a href="<?php echo e(route('admin.index')); ?>" class="lao-nav-link <?php echo e(request()->routeIs('admin.*') ? 'active' : ''); ?>">
                        <i class="bi bi-people-fill icon-people"></i>
                        <span>Admin Panel</span>
                    </a>
                </div>
            </div>
        </nav>
    </aside>

    <!-- Top Bar -->
    <header class="lao-topbar">
        <div class="lao-topbar-actions">
            <!-- Date and Time -->
            <div class="lao-datetime">
                <div class="lao-date-display">
                    <span class="lao-date-label">DATE</span>
                    <span class="lao-date-value" id="current-date"></span>
                </div>
                <div class="lao-datetime-divider"></div>
                <div class="lao-time-display">
                    <span class="lao-time-label">TIME</span>
                    <span class="lao-time-value" id="current-time"></span>
                </div>
            </div>

            <!-- Dark Mode Toggle -->
            <div class="lao-dark-mode-toggle" onclick="toggleDarkMode()" title="Toggle Dark Mode">
                <i class="bi bi-moon-fill" id="dark-mode-icon" style="font-size: 18px;"></i>
            </div>

            <!-- Test Notification Button -->
            <div class="lao-test-notification-toggle" onclick="sendTestNotification()" title="Send Test Notification to All Users">
                <i class="bi bi-send-fill" style="font-size: 16px;"></i>
            </div>

            <!-- Notifications -->
            <div class="lao-notification-wrapper">
                <div class="lao-notification" onclick="toggleNotificationDropdown()">
                    <i class="bi bi-bell-fill" style="font-size: 20px;"></i>
                    <span class="lao-notification-badge" id="notification-count" style="display: none;">0</span>
                </div>
                
                <!-- Notification Dropdown -->
                <div class="notification-dropdown" id="notificationDropdown">
                    <div class="notification-dropdown-header">
                        <h6 class="mb-0 text-title" style="font-weight: 700;">Notifications</h6>
                        <a href="<?php echo e(route('notifications.index')); ?>" class="text-primary small">View All</a>
                    </div>
                    <div class="notification-dropdown-body" id="notification-list">
                        <!-- Loading state -->
                        <div class="text-center py-4" id="notification-loading">
                            <div class="spinner-border spinner-border-sm text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="text-muted small mt-2 mb-0">Loading notifications...</p>
                        </div>
                        <!-- Notifications will be loaded here dynamically -->
                    </div>
                    <div class="notification-dropdown-footer">
                        <!-- Push Notification Controls -->
                        <button id="enable-notifications-btn" 
                                onclick="enablePushNotifications()" 
                                class="btn btn-sm btn-success w-100 mb-2"
                                style="display: block;">
                            <i class="bi bi-bell-fill me-1"></i> Enable Push Notifications
                        </button>
                        <button id="disable-notifications-btn" 
                                onclick="disablePushNotifications()" 
                                class="btn btn-sm btn-outline-secondary w-100 mb-2"
                                style="display: none;">
                            <i class="bi bi-bell-slash me-1"></i> Disable Push Notifications
                        </button>
                        
                        <!-- Test Notification Button -->
                        <button id="test-notification-btn" 
                                onclick="sendTestNotification()"
                                class="btn btn-sm btn-outline-warning w-100 mb-2">
                            <i class="bi bi-send me-1"></i> Test Notification
                        </button>
                        
                        <!-- Debug Button -->
                        <button id="debug-notification-btn" 
                                onclick="checkNotificationStatus()" 
                                class="btn btn-sm btn-outline-info w-100 mb-2"
                                style="display: none;">
                            <i class="bi bi-info-circle me-1"></i> Check Status
                        </button>
                        
                        <a href="<?php echo e(route('notifications.index')); ?>" class="btn btn-sm btn-outline-primary w-100">See All Notifications</a>
                    </div>
                </div>
            </div>

            <!-- User Profile -->
            <div class="lao-user-profile-wrapper">
                <div class="lao-user-profile" onclick="toggleUserDropdown()">
                    <div class="lao-user-avatar">
                        <?php if(Auth::user()->profile_picture): ?>
                            <img src="<?php echo e(Auth::user()->profile_picture_url); ?>" alt="<?php echo e(Auth::user()->name); ?>">
                        <?php else: ?>
                            <?php echo e(Auth::user()->initials); ?>

                        <?php endif; ?>
                    </div>
                    <div class="lao-user-info d-none d-md-block">
                        <div class="lao-user-name"><?php echo e(Auth::user()->name); ?></div>
                        <div class="lao-user-role"><?php echo e(ucfirst(Auth::user()->role)); ?></div>
                    </div>
                    <i class="bi bi-chevron-down d-none d-md-block text-muted" style="font-size: 12px;"></i>
                </div>
                
                <!-- User Dropdown -->
                <div class="user-dropdown" id="userDropdown">
                    <div class="user-dropdown-header">
                        <div class="user-dropdown-user">
                            <div class="user-dropdown-avatar">
                                <?php if(Auth::user()->profile_picture): ?>
                                    <img src="<?php echo e(Auth::user()->profile_picture_url); ?>" alt="<?php echo e(Auth::user()->name); ?>" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                                <?php else: ?>
                                    <?php echo e(Auth::user()->initials); ?>

                                <?php endif; ?>
                            </div>
                            <div class="user-dropdown-info">
                                <h6><?php echo e(Auth::user()->name); ?></h6>
                                <p><?php echo e(Auth::user()->email); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="user-dropdown-body">
                        <a href="<?php echo e(route('profile.show')); ?>" class="user-dropdown-item">
                            <i class="bi bi-person-circle"></i>
                            <span>My Profile</span>
                        </a>
                        <a href="<?php echo e(route('dashboard')); ?>" class="user-dropdown-item">
                            <i class="bi bi-speedometer2"></i>
                            <span>Dashboard</span>
                        </a>
                        <?php if(Auth::user()->isAdmin()): ?>
                        <a href="<?php echo e(route('admin.index')); ?>" class="user-dropdown-item">
                            <i class="bi bi-shield-lock"></i>
                            <span>Admin Panel</span>
                        </a>
                        <?php endif; ?>
                        <button onclick="document.getElementById('logout-form').submit();" class="user-dropdown-item logout">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Logout</span>
                        </button>
                    </div>
                </div>
            </div>
            
            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                <?php echo csrf_field(); ?>
            </form>
        </div>
    </header>

    <!-- Main Content -->
    <main class="lao-main">
        <!-- Page Header -->
        <div class="lao-page-header">
            <h1 class="lao-page-title"><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?></h1>
            <p class="lao-page-subtitle"><?php echo $__env->yieldContent('page-subtitle', 'Welcome to LAO Case Tracking System'); ?></p>
        </div>

        <!-- Alerts -->
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i><?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle-fill me-2"></i><?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if(session('warning')): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i><?php echo e(session('warning')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if(session('info')): ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="bi bi-info-circle-fill me-2"></i><?php echo e(session('info')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Page Content -->
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Scroll Position Management -->
    <!--
        Enhanced scroll behavior for sidebar navigation:
        - Preserves scroll position when navigating between sidebar sub-sections
        - Prevents automatic scroll-to-top on page navigation
        - Handles filter links (sections, courts, regions) intelligently
        - Maintains user position during dynamic content updates
        - Early restoration prevents "flash" of scroll-to-top
    -->
    <script>
        // Enable scroll restoration with smooth behavior
        if ('scrollRestoration' in history) {
            history.scrollRestoration = 'manual';
        }

        // Prevent automatic scroll to top on page load
        window.addEventListener('beforeunload', function() {
            // Save current scroll position before page unload
            const shouldPreserve = sessionStorage.getItem('shouldPreserveScroll');
            if (shouldPreserve === 'true') {
                sessionStorage.setItem('scrollPosition', window.scrollY.toString());
            }
        });

        // Early restoration to prevent flash of scroll-to-top
        (function() {
            const shouldPreserve = sessionStorage.getItem('shouldPreserveScroll');
            const savedPosition = sessionStorage.getItem('scrollPosition');
            
            if (shouldPreserve === 'true' && savedPosition && !window.location.hash) {
                // Immediately restore scroll on script execution (before DOM ready)
                window.scrollTo(0, parseInt(savedPosition));
                
                // Additional restoration on DOMContentLoaded to handle late-loading content
                document.addEventListener('DOMContentLoaded', function() {
                    window.scrollTo({
                        top: parseInt(savedPosition),
                        behavior: 'instant'
                    });
                });
                
                // Multiple restoration attempts to catch all content loading scenarios
                [50, 100, 150, 250, 500].forEach(delay => {
                    setTimeout(function() {
                        const currentSaved = sessionStorage.getItem('scrollPosition');
                        if (currentSaved && window.scrollY < parseInt(currentSaved) - 10) {
                            window.scrollTo({
                                top: parseInt(currentSaved),
                                behavior: 'instant'
                            });
                        }
                    }, delay);
                });
            }
        })();

        // Global scroll lock to prevent any unwanted scroll-to-top
        let preservedScrollPosition = null;
        window.addEventListener('load', function() {
            const shouldPreserve = sessionStorage.getItem('shouldPreserveScroll');
            const savedPosition = sessionStorage.getItem('scrollPosition');
            if (shouldPreserve === 'true' && savedPosition) {
                preservedScrollPosition = parseInt(savedPosition);
                window.scrollTo(0, preservedScrollPosition);
            }
        });
    </script>
    
    <!-- Push Notifications -->
    <script src="<?php echo e(asset('js/push-notifications.js')); ?>"></script>
    
    <script>
        // Notification Dropdown Toggle
        function toggleNotificationDropdown() {
            const dropdown = document.getElementById('notificationDropdown');
            dropdown.classList.toggle('show');
            event.stopPropagation();
        }

        // User Dropdown Toggle
        function toggleUserDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('show');
            event.stopPropagation();
        }

        // Dark Mode Toggle
        function toggleDarkMode() {
            const body = document.body;
            const icon = document.getElementById('dark-mode-icon');
            
            body.classList.toggle('dark-mode');
            
            // Update icon
            if (body.classList.contains('dark-mode')) {
                icon.classList.remove('bi-moon-fill');
                icon.classList.add('bi-sun-fill');
                localStorage.setItem('darkMode', 'enabled');
            } else {
                icon.classList.remove('bi-sun-fill');
                icon.classList.add('bi-moon-fill');
                localStorage.setItem('darkMode', 'disabled');
            }
        }

        // Load dark mode preference on page load
        document.addEventListener('DOMContentLoaded', function() {
            const darkMode = localStorage.getItem('darkMode');
            const icon = document.getElementById('dark-mode-icon');
            
            if (darkMode === 'enabled') {
                // Clean up instant mode and apply full dark mode
                document.documentElement.classList.remove('dark-mode-instant');
                document.documentElement.style.cssText = ''; // Clear inline styles from html
                document.body.style.cssText = ''; // Clear inline styles from body
                document.body.classList.add('dark-mode');
                
                // Remove critical CSS if it exists
                const criticalStyle = document.getElementById('dark-mode-critical');
                if (criticalStyle) {
                    criticalStyle.remove();
                }
                
                if (icon) {
                    icon.classList.remove('bi-moon-fill');
                    icon.classList.add('bi-sun-fill');
                }
            }
        });

        // Close notification dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const notificationDropdown = document.getElementById('notificationDropdown');
            const notificationBtn = document.querySelector('.lao-notification');
            
            if (notificationDropdown && !notificationDropdown.contains(event.target) && !notificationBtn.contains(event.target)) {
                notificationDropdown.classList.remove('show');
            }

            const userDropdown = document.getElementById('userDropdown');
            const userProfileBtn = document.querySelector('.lao-user-profile');
            
            if (userDropdown && !userDropdown.contains(event.target) && !userProfileBtn.contains(event.target)) {
                userDropdown.classList.remove('show');
            }
        });

        // Prevent dropdown from closing when clicking inside it
        document.addEventListener('DOMContentLoaded', function() {
            // Real-time Date and Time Update
            function updateDateTime() {
                const now = new Date();
                
                // Format date: "Feb 11, 2026"
                const dateOptions = { month: 'short', day: 'numeric', year: 'numeric' };
                const dateString = now.toLocaleDateString('en-US', dateOptions);
                
                // Format time: "2:45:30 PM"
                const timeOptions = { hour: 'numeric', minute: '2-digit', second: '2-digit', hour12: true };
                const timeString = now.toLocaleTimeString('en-US', timeOptions);
                
                // Update DOM elements
                const dateElement = document.getElementById('current-date');
                const timeElement = document.getElementById('current-time');
                
                if (dateElement) dateElement.textContent = dateString;
                if (timeElement) timeElement.textContent = timeString;
            }
            
            // Update immediately on page load
            updateDateTime();
            
            // Update every second
            setInterval(updateDateTime, 1000);
            
            // Handle scroll position restoration and anchor navigation
            // Multiple timing attempts to catch all rendering scenarios
            [50, 100, 200].forEach(delay => {
                setTimeout(() => {
                    // Check if URL has a hash (anchor)
                    if (window.location.hash) {
                        const targetId = window.location.hash.substring(1);
                        const targetElement = document.getElementById(targetId);
                        
                        if (targetElement) {
                            // Only scroll on first attempt
                            if (delay === 50) {
                                // Scroll to the target element with smooth behavior
                                targetElement.scrollIntoView({ 
                                    behavior: 'smooth', 
                                    block: 'center' 
                                });
                                
                                // Add a subtle highlight effect
                                targetElement.style.transition = 'background-color 0.5s ease';
                                const originalBg = targetElement.style.backgroundColor;
                                targetElement.style.backgroundColor = 'rgba(52, 152, 219, 0.1)';
                                setTimeout(() => {
                                    targetElement.style.backgroundColor = originalBg;
                                }, 1500);
                            }
                            
                            // Clear sessionStorage to prevent conflict
                            sessionStorage.removeItem('scrollPosition');
                            sessionStorage.removeItem('shouldPreserveScroll');
                        }
                    } else {
                        // Check if we should preserve scroll position
                        const shouldPreserve = sessionStorage.getItem('shouldPreserveScroll');
                        const savedPosition = sessionStorage.getItem('scrollPosition');
                        
                        if (shouldPreserve === 'true' && savedPosition) {
                            const targetPos = parseInt(savedPosition);
                            // Restore scroll position aggressively
                            if (Math.abs(window.scrollY - targetPos) > 5) {
                                window.scrollTo({
                                    top: targetPos,
                                    behavior: 'instant'
                                });
                            }
                        }
                    }
                }, delay);
            });

            // Final cleanup after restoration attempts
            setTimeout(() => {
                const shouldPreserve = sessionStorage.getItem('shouldPreserveScroll');
                if (shouldPreserve !== 'true') {
                    // Clear the flags after restoration
                    sessionStorage.removeItem('scrollPosition');
                }
            }, 300);

            // Global navigation handler - preserve scroll for ALL internal navigation
            document.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', function(e) {
                    const href = this.getAttribute('href');
                    
                    // Skip only for: hash links, javascript:void(), external URLs, and logout
                    if (!href || href === '#' || href.startsWith('javascript:void') || 
                        href.includes('logout') || (href.startsWith('http') && !href.includes(window.location.hostname))) {
                        return;
                    }
                    
                    // For ALL other internal links, preserve scroll position
                    // This includes sidebar, filters, buttons, and any navigation element
                    const isInternalNavigation = href.startsWith('/') || !href.startsWith('http');
                    
                    if (isInternalNavigation) {
                        // Save current scroll position
                        sessionStorage.setItem('scrollPosition', window.scrollY.toString());
                        sessionStorage.setItem('shouldPreserveScroll', 'true');
                        sessionStorage.setItem('navigationTime', Date.now().toString());
                    }
                });
            });

            // Additional handler for dynamically added links
            document.body.addEventListener('click', function(e) {
                const link = e.target.closest('a');
                if (link && !link.hasAttribute('data-scroll-handled')) {
                    const href = link.getAttribute('href');
                    if (href && href.startsWith('/') && !href.includes('logout')) {
                        sessionStorage.setItem('scrollPosition', window.scrollY.toString());
                        sessionStorage.setItem('shouldPreserveScroll', 'true');
                    }
                }
            });

            // Preserve scroll on form submissions (except logout)
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    const action = this.getAttribute('action');
                    // Preserve scroll unless it's logout or has data-no-preserve attribute
                    if (action && !action.includes('logout') && !this.hasAttribute('data-no-preserve')) {
                        sessionStorage.setItem('scrollPosition', window.scrollY.toString());
                        sessionStorage.setItem('shouldPreserveScroll', 'true');
                    }
                });
            });

            // Watch for new forms added dynamically
            const formObserver = new MutationObserver(function(mutations) {
                mutations.forEach(mutation => {
                    mutation.addedNodes.forEach(node => {
                        if (node.nodeType === 1) { // Element node
                            if (node.tagName === 'FORM') {
                                node.addEventListener('submit', function(e) {
                                    const action = this.getAttribute('action');
                                    if (action && !action.includes('logout') && !this.hasAttribute('data-no-preserve')) {
                                        sessionStorage.setItem('scrollPosition', window.scrollY.toString());
                                        sessionStorage.setItem('shouldPreserveScroll', 'true');
                                    }
                                });
                            }
                            const forms = node.querySelectorAll ? node.querySelectorAll('form') : [];
                            forms.forEach(form => {
                                form.addEventListener('submit', function(e) {
                                    const action = this.getAttribute('action');
                                    if (action && !action.includes('logout') && !this.hasAttribute('data-no-preserve')) {
                                        sessionStorage.setItem('scrollPosition', window.scrollY.toString());
                                        sessionStorage.setItem('shouldPreserveScroll', 'true');
                                    }
                                });
                            });
                        }
                    });
                });
            });

            formObserver.observe(document.body, {
                childList: true,
                subtree: true
            });

            // Continuously save scroll position as backup for all pages
            let scrollTimeout;
            window.addEventListener('scroll', function() {
                clearTimeout(scrollTimeout);
                scrollTimeout = setTimeout(() => {
                    // Save for all pages, not just /cases
                    sessionStorage.setItem('lastScrollPosition', window.scrollY.toString());
                    
                    // If we have shouldPreserveScroll flag, update the saved position
                    if (sessionStorage.getItem('shouldPreserveScroll') === 'true') {
                        sessionStorage.setItem('scrollPosition', window.scrollY.toString());
                    }
                }, 150);
            });

            // Prevent automatic scroll on window focus
            window.addEventListener('focus', function() {
                const shouldPreserve = sessionStorage.getItem('shouldPreserveScroll');
                const savedPosition = sessionStorage.getItem('scrollPosition');
                if (shouldPreserve === 'true' && savedPosition) {
                    setTimeout(() => {
                        window.scrollTo({
                            top: parseInt(savedPosition),
                            behavior: 'instant'
                        });
                    }, 10);
                }
            });

            // Aggressive prevention of unwanted scroll-to-top on dynamic content updates
            const observer = new MutationObserver(function(mutations) {
                // If content changes but we have a saved position, maintain it
                const shouldPreserve = sessionStorage.getItem('shouldPreserveScroll');
                const savedPos = sessionStorage.getItem('scrollPosition');
                
                if (shouldPreserve === 'true' && savedPos) {
                    const targetPos = parseInt(savedPos);
                    // If scroll position has changed unexpectedly, restore it
                    if (Math.abs(window.scrollY - targetPos) > 50) {
                        window.scrollTo({
                            top: targetPos,
                            behavior: 'instant'
                        });
                    }
                }
            });

            // Observe the main content area for changes
            const mainContent = document.querySelector('.lao-main');
            if (mainContent) {
                observer.observe(mainContent, {
                    childList: true,
                    subtree: true,
                    attributes: false
                });
            }

            // Additional observer for the entire body
            const bodyObserver = new MutationObserver(function(mutations) {
                const shouldPreserve = sessionStorage.getItem('shouldPreserveScroll');
                const savedPos = sessionStorage.getItem('scrollPosition');
                
                if (shouldPreserve === 'true' && savedPos && window.scrollY === 0) {
                    window.scrollTo(0, parseInt(savedPos));
                }
            });

            bodyObserver.observe(document.body, {
                childList: true,
                subtree: false
            });

            // Prevent any programmatic scroll-to-top attempts
            const originalScrollTo = window.scrollTo;
            window.scrollTo = function(...args) {
                const shouldPreserve = sessionStorage.getItem('shouldPreserveScroll');
                const savedPos = sessionStorage.getItem('scrollPosition');
                
                // If trying to scroll to 0 but we should preserve, ignore it
                if (shouldPreserve === 'true' && savedPos && args[0] === 0 && args[1] === 0) {
                    return originalScrollTo.call(window, 0, parseInt(savedPos));
                }
                return originalScrollTo.apply(window, args);
            };

            const notificationDropdown = document.getElementById('notificationDropdown');
            if (notificationDropdown) {
                notificationDropdown.addEventListener('click', function(event) {
                    event.stopPropagation();
                });
            }

            const userDropdown = document.getElementById('userDropdown');
            if (userDropdown) {
                userDropdown.addEventListener('click', function(event) {
                    event.stopPropagation();
                });
            }

            // Navigation Dropdown Behavior - Stay open after click
            const navDropdowns = document.querySelectorAll('.lao-nav-item.has-dropdown');
            const dropdownStates = new Map();

            // Auto-detect which dropdown should be open based on URL parameters ONLY
            // DO NOT auto-open Cases dropdown - let it work with hover like others
            const urlParams = new URLSearchParams(window.location.search);
            const hasSection = urlParams.has('section');
            const hasCourt = urlParams.has('court');
            const hasRegion = urlParams.has('region');
            
            let autoOpenDropdown = null;
            if (hasSection) autoOpenDropdown = 'sections-dropdown';
            else if (hasCourt) autoOpenDropdown = 'courts-dropdown';
            else if (hasRegion) autoOpenDropdown = 'regions-dropdown';
            // Cases dropdown is NOT auto-opened - it uses hover only

            // Clear cases-dropdown from storage if no filters (ensure hover works)
            const savedDropdownId = sessionStorage.getItem('activeDropdown');
            if (savedDropdownId === 'cases-dropdown' && !hasSection && !hasCourt && !hasRegion) {
                sessionStorage.removeItem('activeDropdown');
            }

            // Restore dropdown state on page load (only if manually saved)
            const finalDropdownId = sessionStorage.getItem('activeDropdown') || autoOpenDropdown;
            if (finalDropdownId) {
                navDropdowns.forEach(item => {
                    const dropdownId = item.getAttribute('data-dropdown-id');
                    if (dropdownId === finalDropdownId) {
                        item.classList.add('dropdown-active');
                        dropdownStates.set(item, { isLocked: true });
                    } else {
                        dropdownStates.set(item, { isLocked: false });
                    }
                });
            } else {
                navDropdowns.forEach(item => {
                    dropdownStates.set(item, { isLocked: false });
                });
            }

            navDropdowns.forEach(item => {
                let leaveTimer = null;
                if (!dropdownStates.has(item)) {
                    dropdownStates.set(item, { isLocked: false });
                }

                const navLink = item.querySelector('.lao-nav-link');
                const dropdown = item.querySelector('.lao-nav-dropdown');
                const dropdownId = item.getAttribute('data-dropdown-id');

                // On click, toggle lock state
                if (navLink) {
                    navLink.addEventListener('click', function(e) {
                        // Always prevent default for dropdown toggles
                        if (navLink.hasAttribute('data-toggle-dropdown')) {
                            e.preventDefault();
                            e.stopPropagation();
                            
                            const state = dropdownStates.get(item);
                            
                            // Close other dropdowns
                            navDropdowns.forEach(otherItem => {
                                if (otherItem !== item) {
                                    otherItem.classList.remove('dropdown-active');
                                    dropdownStates.get(otherItem).isLocked = false;
                                }
                            });
                            
                            state.isLocked = !state.isLocked;
                            if (state.isLocked) {
                                item.classList.add('dropdown-active');
                                sessionStorage.setItem('activeDropdown', dropdownId);
                                if (leaveTimer) clearTimeout(leaveTimer);
                            } else {
                                item.classList.remove('dropdown-active');
                                sessionStorage.removeItem('activeDropdown');
                            }
                        }
                    });
                }

                // Prevent clicks inside dropdown from closing it
                if (dropdown) {
                    dropdown.addEventListener('click', function(e) {
                        e.stopPropagation();
                        
                        // When clicking a filter link, save the dropdown state and scroll position
                        const clickedLink = e.target.closest('.lao-nav-dropdown-link');
                        if (clickedLink) {
                            const state = dropdownStates.get(item);
                            state.isLocked = true;
                            item.classList.add('dropdown-active');
                            sessionStorage.setItem('activeDropdown', dropdownId);
                            
                            // Ensure scroll position is saved
                            sessionStorage.setItem('scrollPosition', window.scrollY.toString());
                            sessionStorage.setItem('shouldPreserveScroll', 'true');
                        }
                    });
                }

                // Clear timer on mouse enter
                item.addEventListener('mouseenter', function() {
                    if (leaveTimer) {
                        clearTimeout(leaveTimer);
                        leaveTimer = null;
                    }
                });

                // Delayed close on mouse leave (only if not locked)
                item.addEventListener('mouseleave', function() {
                    const state = dropdownStates.get(item);
                    if (!state.isLocked) {
                        leaveTimer = setTimeout(() => {
                            if (!state.isLocked) {
                                item.classList.remove('dropdown-active');
                            }
                        }, 100);
                    }
                });

                // Keep dropdown open when hovering over dropdown items
                if (dropdown) {
                    dropdown.addEventListener('mouseenter', function() {
                        if (leaveTimer) {
                            clearTimeout(leaveTimer);
                            leaveTimer = null;
                        }
                    });
                }
            });

            // Close all dropdowns when clicking outside
            document.addEventListener('click', function(e) {
                const clickedDropdown = e.target.closest('.lao-nav-item.has-dropdown');
                if (!clickedDropdown) {
                    navDropdowns.forEach(item => {
                        item.classList.remove('dropdown-active');
                        dropdownStates.get(item).isLocked = false;
                    });
                }
            });

            // Handle active state for dropdown links - ensure only one is active at a time
            const allDropdownLinks = document.querySelectorAll('.lao-nav-dropdown-link');
            allDropdownLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    // Remove active class from all dropdown links across all dropdowns
                    allDropdownLinks.forEach(otherLink => {
                        otherLink.classList.remove('active');
                    });
                    
                    // Add active class to the clicked link
                    this.classList.add('active');
                });
            });

            // Prevent any hash-based navigation from affecting scroll
            window.addEventListener('hashchange', function(e) {
                const shouldPreserve = sessionStorage.getItem('shouldPreserveScroll');
                const savedPos = sessionStorage.getItem('scrollPosition');
                
                if (shouldPreserve === 'true' && savedPos) {
                    e.preventDefault();
                    window.scrollTo({
                        top: parseInt(savedPos),
                        behavior: 'instant'
                    });
                }
            });

            // Final safeguard: Monitor and prevent unexpected scroll-to-top
            let lastKnownScrollPosition = window.scrollY;
            let scrollMonitorInterval = null;

            // Start monitoring when navigation occurs
            document.addEventListener('click', function(e) {
                const link = e.target.closest('a');
                if (link && link.href && link.href.includes(window.location.hostname)) {
                    lastKnownScrollPosition = window.scrollY;
                    
                    // Monitor for 2 seconds after click
                    clearInterval(scrollMonitorInterval);
                    let checkCount = 0;
                    scrollMonitorInterval = setInterval(() => {
                        const shouldPreserve = sessionStorage.getItem('shouldPreserveScroll');
                        const savedPos = sessionStorage.getItem('scrollPosition');
                        
                        if (shouldPreserve === 'true' && savedPos) {
                            const targetPos = parseInt(savedPos);
                            if (window.scrollY < targetPos - 10) {
                                window.scrollTo(0, targetPos);
                            }
                        }
                        
                        checkCount++;
                        if (checkCount >= 20) { // Stop after 2 seconds (100ms * 20)
                            clearInterval(scrollMonitorInterval);
                        }
                    }, 100);
                }
            });

            // Prevent scroll on page show (back/forward cache)
            window.addEventListener('pageshow', function(event) {
                const shouldPreserve = sessionStorage.getItem('shouldPreserveScroll');
                const savedPos = sessionStorage.getItem('scrollPosition');
                
                if (shouldPreserve === 'true' && savedPos) {
                    setTimeout(() => {
                        window.scrollTo({
                            top: parseInt(savedPos),
                            behavior: 'instant'
                        });
                    }, 0);
                }
            });

            // Smooth Alert Auto-Dismiss
            const alerts = document.querySelectorAll('.alert-dismissible');
            alerts.forEach(alert => {
                // Auto-dismiss after 5 seconds
                setTimeout(() => {
                    alert.classList.add('fade-out');
                    setTimeout(() => {
                        alert.remove();
                    }, 1200); // Wait for animation to complete
                }, 5000);

                // Handle manual close button with smooth animation
                const closeBtn = alert.querySelector('.btn-close');
                if (closeBtn) {
                    closeBtn.addEventListener('click', (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        alert.classList.add('fade-out');
                        setTimeout(() => {
                            alert.remove();
                        }, 1200);
                    });
                }
            });
            
            // Check subscription status and update UI
            setTimeout(async () => {
                if ('serviceWorker' in navigator && 'PushManager' in window) {
                    try {
                        const registration = await navigator.serviceWorker.getRegistration();
                        if (registration) {
                            const subscription = await registration.pushManager.getSubscription();
                            const enableBtn = document.getElementById('enable-notifications-btn');
                            const disableBtn = document.getElementById('disable-notifications-btn');
                            const testBtn = document.getElementById('test-notification-btn');
                            const debugBtn = document.getElementById('debug-notification-btn');
                            
                            if (subscription) {
                                // User is subscribed
                                if (enableBtn) enableBtn.style.display = 'none';
                                if (disableBtn) disableBtn.style.display = 'block';
                                if (testBtn) testBtn.style.display = 'block';
                                if (debugBtn) debugBtn.style.display = 'none';
                                console.log('✓ Push notifications are enabled');
                            } else {
                                // User is not subscribed
                                if (enableBtn) enableBtn.style.display = 'block';
                                if (disableBtn) disableBtn.style.display = 'none';
                                if (testBtn) testBtn.style.display = 'none';
                                if (debugBtn) debugBtn.style.display = 'block';
                                console.log('Push notifications not enabled yet');
                            }
                        }
                    } catch (error) {
                        console.log('Could not check subscription status:', error.message);
                    }
                }
            }, 500);

            // Load notifications on page load
            loadNotifications();
            
            // Auto-refresh notifications every 30 seconds
            setInterval(loadNotifications, 30000);
            
            // Initialize push notifications
            if (typeof PushNotifications !== 'undefined') {
                PushNotifications.init().catch(error => {
                    console.log('Push notifications initialization skipped:', error.message);
                });
            }
        });
        
        // Function to load notifications from server
        function loadNotifications() {
            fetch('<?php echo e(route('notifications.get')); ?>')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateNotificationUI(data);
                    } else {
                        showNotificationError();
                    }
                })
                .catch(error => {
                    console.error('Error loading notifications:', error);
                    showNotificationError();
                });
        }
        
        // Function to update notification UI
        function updateNotificationUI(data) {
            const notificationList = document.getElementById('notification-list');
            const notificationCount = document.getElementById('notification-count');
            const loadingElement = document.getElementById('notification-loading');
            
            // Update badge count
            if (notificationCount) {
                const count = data.unread_count || 0;
                notificationCount.textContent = count;
                if (count > 0) {
                    notificationCount.style.display = 'flex';
                } else {
                    notificationCount.style.display = 'none';
                }
            }
            
            // Hide loading
            if (loadingElement) {
                loadingElement.style.display = 'none';
            }
            
            // Clear existing notifications
            if (notificationList) {
                // Keep only the loading element
                const existingItems = notificationList.querySelectorAll('.notification-item, .no-notifications');
                existingItems.forEach(item => item.remove());
                
                if (data.notifications && data.notifications.length > 0) {
                    // Add each notification
                    data.notifications.forEach(notification => {
                        const notificationItem = createNotificationElement(notification);
                        notificationList.appendChild(notificationItem);
                    });
                } else {
                    // Show empty state
                    const emptyState = document.createElement('div');
                    emptyState.className = 'text-center py-4 no-notifications';
                    emptyState.innerHTML = `
                        <i class="bi bi-bell-slash text-muted" style="font-size: 2rem;"></i>
                        <p class="text-muted small mt-2 mb-0">No notifications</p>
                    `;
                    notificationList.appendChild(emptyState);
                }
            }
        }
        
        // Function to create notification element
        function createNotificationElement(notification) {
            const link = document.createElement('a');
            link.href = notification.url || '#';
            link.className = 'notification-item ' + (notification.is_read ? '' : 'unread') + ' notification-link';
            link.onclick = (e) => {
                e.preventDefault();
                markNotificationAsRead(notification.id, notification.url);
            };
            
            // Determine icon based on notification title
            let icon = 'bi-info-circle-fill';
            let iconBg = 'bg-info';
            
            if (notification.title.includes('Overdue') || notification.title.includes('🚨')) {
                icon = 'bi-exclamation-triangle-fill';
                iconBg = 'bg-danger';
            } else if (notification.title.includes('Deadline') || notification.title.includes('⏰')) {
                icon = 'bi-clock-fill';
                iconBg = 'bg-warning';
            } else if (notification.title.includes('Assignment') || notification.title.includes('📋')) {
                icon = 'bi-person-fill-check';
                iconBg = 'bg-success';
            } else if (notification.title.includes('Hearing') || notification.title.includes('📅')) {
                icon = 'bi-calendar-event-fill';
                iconBg = 'bg-primary';
            }
            
            link.innerHTML = `
                <div class="notification-icon ${iconBg}">
                    <i class="${icon}"></i>
                </div>
                <div class="notification-content">
                    <p class="notification-text"><strong>${notification.title}</strong></p>
                    <p class="notification-text">${notification.body}</p>
                    <span class="notification-time">${notification.time_ago}</span>
                </div>
            `;
            
            return link;
        }
        
        // Mark notification as read
        function markNotificationAsRead(notificationId, url) {
            fetch(`/notifications/${notificationId}/read`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reload notifications to update count
                    loadNotifications();
                    // Navigate to URL if provided
                    if (url && url !== '#') {
                        window.location.href = url;
                    }
                }
            })
            .catch(error => {
                console.error('Error marking notification as read:', error);
                // Still navigate even if marking as read fails
                if (url && url !== '#') {
                    window.location.href = url;
                }
            });
        }
        
        // Function to show error state
        function showNotificationError() {
            const notificationList = document.getElementById('notification-list');
            const loadingElement = document.getElementById('notification-loading');
            
            if (loadingElement) {
                loadingElement.style.display = 'none';
            }
            
            if (notificationList) {
                const existingItems = notificationList.querySelectorAll('.notification-item, .no-notifications');
                existingItems.forEach(item => item.remove());
                
                const errorState = document.createElement('div');
                errorState.className = 'text-center py-4 no-notifications';
                errorState.innerHTML = `
                    <i class="bi bi-exclamation-triangle text-warning" style="font-size: 2rem;"></i>
                    <p class="text-muted small mt-2 mb-0">Could not load notifications</p>
                `;
                notificationList.appendChild(errorState);
            }
        }
        
        // Enable push notifications
        async function enablePushNotifications() {
            if (typeof PushNotifications !== 'undefined') {
                await PushNotifications.subscribe();
                // Refresh button states
                setTimeout(() => location.reload(), 1000);
            } else {
                console.error('PushNotifications object not loaded');
                alert('Push notification system is loading. Please try again in a moment.');
            }
        }
        
        // Disable push notifications
        async function disablePushNotifications() {
            if (typeof PushNotifications !== 'undefined') {
                await PushNotifications.unsubscribe();
                // Refresh button states
                setTimeout(() => location.reload(), 1000);
            } else {
                alert('Push notification system not available.');
            }
        }
        
        // Function to show in-app toast notifications
        function showToast(message, type = 'success', duration = 4000, url = null) {
            const toastContainer = document.querySelector('.toast-container');
            if (!toastContainer) return;
            
            // Create unique ID for this toast
            const toastId = 'toast-' + Date.now();
            
            // Determine icon and colors based on type
            let icon, bgClass, textClass, customStyle = '';
            switch(type) {
                case 'notification':
                    icon = 'bi-bell-fill';
                    bgClass = '';
                    textClass = 'text-white';
                    customStyle = 'background: #001f3f !important; color: #ffffff !important;';
                    break;
                case 'success':
                    icon = 'bi-check-circle-fill';
                    bgClass = 'bg-success';
                    textClass = 'text-white';
                    break;
                case 'error':
                    icon = 'bi-x-circle-fill';
                    bgClass = 'bg-danger';
                    textClass = 'text-white';
                    break;
                case 'warning':
                    icon = 'bi-exclamation-triangle-fill';
                    bgClass = 'bg-warning';
                    textClass = 'text-dark';
                    break;
                case 'info':
                    icon = 'bi-info-circle-fill';
                    bgClass = 'bg-info';
                    textClass = 'text-white';
                    break;
                default:
                    icon = 'bi-bell-fill';
                    bgClass = 'bg-primary';
                    textClass = 'text-white';
            }
            
            // Create toast element
            const cursorStyle = url ? 'cursor: pointer;' : '';
            const allWhiteStyle = type === 'notification' ? 'color: #ffffff !important;' : '';
            const bodyContentStyle = type === 'notification' ? 'color: #ffffff !important; * { color: #ffffff !important; }' : '';
            const toastHtml = `
                <div id="${toastId}" class="toast ${bgClass} ${textClass}" role="alert" aria-live="assertive" aria-atomic="true" style="${customStyle} min-width: 350px; ${cursorStyle}">
                    <div class="toast-header ${bgClass} ${textClass} border-0" style="${customStyle} ${allWhiteStyle}">
                        <i class="bi ${icon} me-2" style="${allWhiteStyle}"></i>
                        <strong class="me-auto" style="${allWhiteStyle} font-weight: 600;">Notification</strong>
                        <small style="${allWhiteStyle}">just now</small>
                        <button type="button" class="btn-close ${textClass === 'text-white' ? 'btn-close-white' : ''}" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body ${bgClass} ${textClass}" style="${customStyle} ${allWhiteStyle}">
                        <div style="${bodyContentStyle}">${message}</div>
                    </div>
                </div>
            `;
            
            // Add to container
            toastContainer.insertAdjacentHTML('beforeend', toastHtml);
            
            // Get the toast element and show it
            const toastElement = document.getElementById(toastId);
            
            // Force all child elements in notification body to be white (for light/dark mode compatibility)
            if (type === 'notification') {
                const bodyElements = toastElement.querySelectorAll('.toast-body, .toast-body *');
                bodyElements.forEach(el => {
                    el.style.color = '#ffffff';
                    el.style.setProperty('color', '#ffffff', 'important');
                });
            }
            
            const bsToast = new bootstrap.Toast(toastElement, {
                autohide: true,
                delay: duration
            });
            
            // Show the toast
            bsToast.show();
            
            // Add click handler if URL is provided
            if (url) {
                toastElement.addEventListener('click', function(e) {
                    // Don't navigate if clicking the close button
                    if (!e.target.classList.contains('btn-close')) {
                        window.location.href = url;
                    }
                });
            }
            
            // Remove from DOM after it's hidden
            toastElement.addEventListener('hidden.bs.toast', function() {
                toastElement.remove();
            });
        }
        
        // Send test notification - Make sure it's globally accessible
        window.sendTestNotification = async function() {
            console.log('='.repeat(50));
            console.log('🔔 TEST NOTIFICATION FUNCTION CALLED');
            console.log('='.repeat(50));
            console.log('Test notification button clicked');
            
            try {
                // Check notification support
                if (!('Notification' in window)) {
                    console.error('❌ Notifications not supported');
                    alert('Notifications not supported in this browser');
                    return;
                }
                
                console.log('✅ Notification API supported');
                console.log('Current permission:', Notification.permission);
                
                // Check notification permission
                if (Notification.permission === 'default') {
                    console.log('⚠️  Permission not yet requested, requesting now...');
                    const permission = await Notification.requestPermission();
                    console.log('Permission result:', permission);
                    
                    if (permission !== 'granted') {
                        alert('Notification permission denied. Please allow notifications in your browser settings.');
                        return;
                    }
                }
                
                if (Notification.permission !== 'granted') {
                    console.error('❌ Permission not granted:', Notification.permission);
                    alert('Please allow notifications! Click the "Enable Push Notifications" button or check your browser settings.');
                    return;
                }
                
                console.log('✅ Permission granted');
                
                // First, try a basic browser notification (simplest test)
                console.log('Testing basic browser notification first...');
                try {
                    const basicNotif = new Notification('✨ Basic Test', {
                        body: 'If you see this, basic notifications work!',
                        icon: '/favicon.ico',
                        tag: 'basic-test-' + Date.now()
                    });
                    console.log('✅ Basic notification created:', basicNotif);
                } catch (basicError) {
                    console.error('❌ Basic notification failed:', basicError);
                }
                
                // Now try service worker notification
                if (!('serviceWorker' in navigator)) {
                    console.warn('⚠️  Service Worker not supported, basic notification was sent');
                    alert('Basic notification sent! Service Worker not available in this browser.');
                    return;
                }
                
                console.log('✅ Service Worker API supported');
                console.log('Getting service worker registration...');
                
                // Get service worker registration
                const registration = await navigator.serviceWorker.ready;
                console.log('✅ Service worker is ready:', registration);
                console.log('Service worker scope:', registration.scope);
                console.log('Service worker state:', registration.active ? registration.active.state : 'no active worker');
                
                // Fetch real case data from server
                console.log('Fetching real case data from server...');
                const response = await fetch('<?php echo e(route("cases.testNotificationData")); ?>', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                
                console.log('Server response status:', response.status, response.statusText);
                
                if (!response.ok) {
                    throw new Error('Failed to fetch case data: ' + response.statusText);
                }
                
                const result = await response.json();
                console.log('✅ Received case data:', result);
                
                if (!result.success) {
                    throw new Error('Failed to get notification data from server');
                }
                
                const notification = result.notification;
                console.log('Notification type:', notification.title);
                console.log('Full notification object:', notification);
                
                // Build case URL if case_id is provided
                const caseUrl = result.case_id ? `/cases/${result.case_id}` : '<?php echo e(route("dashboard")); ?>';
                console.log('Case URL:', caseUrl);
                
                // Check if we can show notifications
                console.log('Notification permission:', Notification.permission);
                console.log('Registration state:', registration.active ? 'active' : 'not active');
                
                // Create unique tag with timestamp to ensure each notification is new
                const uniqueTag = 'test-' + Date.now();
                
                console.log('About to call showNotification with tag:', uniqueTag);
                
                const notificationOptions = {
                    body: notification.body,
                    icon: '/favicon.ico',
                    badge: '/favicon.ico',
                    tag: uniqueTag,
                    requireInteraction: notification.requireInteraction || false,
                    actions: [
                        { action: 'view', title: 'View Case' },
                        { action: 'dismiss', title: 'Dismiss' }
                    ],
                    data: {
                        url: caseUrl,
                        timestamp: new Date().getTime()
                    },
                    vibrate: [200, 100, 200],
                    silent: false
                };
                
                console.log('Notification options:', notificationOptions);
                
                try {
                    console.log('Calling registration.showNotification()...');
                    const notif = await registration.showNotification(notification.title, notificationOptions);
                    console.log('✓ showNotification() completed successfully');
                    console.log('Notification result:', notif);
                    
                    // Also try browser notification as fallback - THIS should definitely show up
                    if (Notification.permission === 'granted') {
                        console.log('Also creating DIRECT browser notification...');
                        const browserNotif = new Notification('🔔 ' + notification.title, {
                            body: notification.body,
                            icon: '/favicon.ico',
                            tag: 'browser-test-' + Date.now(),
                            requireInteraction: true // Force it to stay visible
                        });
                        console.log('✅ Direct browser notification created:', browserNotif);
                        
                        // Add event handlers
                        browserNotif.onclick = function() {
                            console.log('Notification clicked!');
                            window.focus();
                            if (caseUrl) {
                                window.location.href = caseUrl;
                            }
                            browserNotif.close();
                        };
                        
                        browserNotif.onshow = function() {
                            console.log('✅✅✅ NOTIFICATION IS NOW SHOWING ON SCREEN!');
                        };
                        
                        browserNotif.onerror = function(err) {
                            console.error('❌ Notification error:', err);
                        };
                        
                        browserNotif.onclose = function() {
                            console.log('Notification closed');
                        };
                    }
                } catch (notifError) {
                    console.error('Error in showNotification:', notifError);
                    throw notifError;
                }
                
                console.log('✓ Test notification process completed!');
                
                // Show in-app toast notification with actual notification content
                const toastMessage = `<strong>${notification.title}</strong><br>${notification.body}`;
                showToast(toastMessage, 'notification', 6000, caseUrl);
                
            } catch (error) {
                console.error('Error sending test notification:', error);
                console.error('Error stack:', error.stack);
                showToast('❌ Error sending notification: ' + error.message, 'error', 5000);
            }
        }
        
        // Check notification status (debug helper)
        async function checkNotificationStatus() {
            let status = '📊 Push Notification Status:\n\n';
            
            // Check browser support
            if (!('serviceWorker' in navigator)) {
                status += '❌ Service Worker: Not supported\n';
                alert(status);
                return;
            }
            status += '✅ Service Worker: Supported\n';
            
            if (!('PushManager' in window)) {
                status += '❌ Push Manager: Not supported\n';
                alert(status);
                return;
            }
            status += '✅ Push Manager: Supported\n';
            
            if (!('Notification' in window)) {
                status += '❌ Notifications: Not supported\n';
                alert(status);
                return;
            }
            status += '✅ Notifications: Supported\n';
            
            // Check permission
            status += `\n🔔 Permission: ${Notification.permission}\n`;
            
            if (Notification.permission !== 'granted') {
                status += '\n⚠️ Please enable notifications first!\n';
                status += 'Click "Enable Push Notifications" button.\n';
                alert(status);
                return;
            }
            
            try {
                // Check service worker registration
                const registration = await navigator.serviceWorker.getRegistration();
                if (!registration) {
                    status += '\n❌ Service Worker: Not registered\n';
                    status += 'Registering service worker...\n';
                    
                    try {
                        await navigator.serviceWorker.register('/service-worker.js');
                        status += '✅ Service Worker registered successfully!\n';
                    } catch (err) {
                        status += '❌ Failed to register: ' + err.message + '\n';
                    }
                    
                    alert(status);
                    return;
                }
                status += '✅ Service Worker: Registered\n';
                
                // Check push subscription
                const subscription = await registration.pushManager.getSubscription();
                if (!subscription) {
                    status += '\n❌ Push Subscription: Not subscribed\n';
                    status += '\n⚠️ Click "Enable Push Notifications" button to subscribe.\n';
                    alert(status);
                    return;
                }
                status += '✅ Push Subscription: Active\n';
                status += `\nEndpoint: ${subscription.endpoint.substring(0, 50)}...\n`;
                
                status += '\n\n🎉 Everything is ready!\n';
                status += 'The "Test Notification" button should be visible.\n';
                status += 'Click it to send a test notification.\n';
                
                // Show the test button if everything is ready
                const testBtn = document.getElementById('test-notification-btn');
                if (testBtn) {
                    testBtn.style.display = 'block';
                    status += '\n✅ Test button is now visible!';
                }
                
            } catch (error) {
                status += '\n\n❌ Error: ' + error.message + '\n';
                console.error(error);
            }
            
            alert(status);
            console.log(status);
        }
    </script>
    
    <!-- Toast Container for In-App Notifications -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 9999;"></div>
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\DELL\Desktop\LAO Case Matrix System\CASE MATRIX SYSTEM\resources\views/layouts/app.blade.php ENDPATH**/ ?>
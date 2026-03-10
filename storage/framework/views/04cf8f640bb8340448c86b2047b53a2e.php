

<?php $__env->startSection('title', 'Case Matrix'); ?>
<?php $__env->startSection('page-title', 'Legal Case Matrix'); ?>
<?php $__env->startSection('page-subtitle', 'Excel-style case tracking and management system'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* CSS Variables for Cases Section */
    :root {
        --lao-navy: #001F3F;
        --lao-navy-light: #003D7A;
        --lao-navy-dark: #001a33;
        --lao-gray: #f8fafc;
        --lao-text-light: #64748b;
        --lao-text-dark: #0f172a;
        --danger-red: #ef4444;
        --warning-yellow: #f59e0b;
        --success-green: #10b981;
        --border-color: #dee2e6;
    }

    /* Excel-style table styling */
    .matrix-container {
        background: white;
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .matrix-controls {
        padding: 20px 24px;
        background: #f8f9fa;
        border-bottom: 1px solid #ddd;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    /* Search Row */
    .matrix-datetime-search {
        display: flex;
        justify-content: flex-start;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .matrix-search-wrapper {
        flex: 1;
        max-width: 500px;
        min-width: 300px;
    }

    .matrix-search-input {
        width: 100%;
        padding: 10px 15px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        font-size: 14px;
        font-weight: 400;
        color: #495057;
        transition: border-color 0.15s ease;
        background: white;
    }

    .matrix-search-input:focus {
        outline: none;
        border-color: #001F3F;
        box-shadow: 0 0 0 0.2rem rgba(0, 31, 63, 0.25);
    }

    /* Filters Row */
    .matrix-filters-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .matrix-table-wrapper {
        overflow-x: auto;
        overflow-y: auto;
        max-height: calc(100vh - 280px);
        position: relative;
        border: 1px solid #dee2e6;
        border-top: none;
        /* Force scrollbar to always show to prevent layout shift */
        overflow-y: scroll;
    }
    
    /* Ensure scrollbar doesn't cause misalignment */
    .matrix-table-wrapper::-webkit-scrollbar {
        width: 12px;
        height: 12px;
    }
    
    .matrix-table-wrapper::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    
    .matrix-table-wrapper::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 6px;
    }
    
    .matrix-table-wrapper::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    .matrix-table {
        width: 100%;
        min-width: 3400px; /* Sum of all column widths to prevent compression */
        border-collapse: collapse; /* Changed to collapse for perfect alignment */
        font-size: 13px;
        table-layout: fixed; /* Fixed layout ensures header and body columns align */
        margin: 0;
        padding: 0;
    }

    /* Ensure all table cells align perfectly */
    .matrix-table th,
    .matrix-table td {
        margin: 0;
        position: relative;
    }

    .matrix-table thead {
        position: sticky;
        top: 0;
        z-index: 10;
        box-shadow: 0 2px 2px -1px rgba(0,0,0,0.1); /* Add shadow to separate from body */
    }

    .matrix-table thead th {
        background: #001F3F;
        color: white !important;
        padding: 12px 15px;
        text-align: left;
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-right: 1px solid #003D7A;
        border-bottom: 2px solid #003D7A;
        white-space: nowrap;
        cursor: pointer;
        user-select: none;
        transition: background-color 0.15s ease;
        box-sizing: border-box;
        height: 45px; /* Fixed height for consistency */
        vertical-align: middle; /* Ensure vertical alignment */
    }

    /* Case Title column - allow wrapping */
    .matrix-table thead th.th-case-title,
    .matrix-table tbody td.td-case-title {
        white-space: normal;
        word-wrap: break-word;
        line-height: 1.5;
        padding: 12px 15px; /* Same padding as other cells */
    }

    .matrix-table tbody td.td-case-title {
        font-weight: 600;
        color: #000000;
        font-size: 14px;
    }

    .matrix-table thead th:hover {
        background: #003D7A;
    }

    .matrix-table tbody td {
        padding: 12px 15px; /* Match header padding exactly */
        border-bottom: 1px solid #dee2e6;
        border-right: 1px solid #dee2e6;
        vertical-align: middle;
        background: white;
        color: #212529;
        font-weight: normal;
        transition: background-color 0.15s ease;
        box-sizing: border-box;
        overflow: hidden;
        text-overflow: ellipsis;
        min-height: 45px; /* Match header height for consistency */
    }

    .matrix-table tbody td:last-child {
        border-right: none;
    }

    .matrix-table thead th:last-child {
        border-right: none;
    }

    .matrix-table tbody tr:hover td {
        background: #f5f5f5;
    }

    /* Row color coding */
    .matrix-table tbody tr.row-overdue td {
        background: #f8d7da;
        border-left: 3px solid #6c757d;
    }

    .matrix-table tbody tr.row-overdue:hover td {
        background: #f1b0b7;
    }

    .matrix-table tbody tr.row-due-soon td {
        background: #fff3cd;
        border-left: 3px solid #6c757d;
    }

    .matrix-table tbody tr.row-due-soon:hover td {
        background: #ffe69c;
    }

    .matrix-table tbody tr.row-active td {
        border-left: 3px solid #6c757d;
    }

    .matrix-table tbody tr.row-active:hover td {
        background: #d4edda;
    }

    /* Cell styling */
    .cell-case-number {
        font-weight: 700;
        color: #000000;
        font-size: 14px;
        white-space: nowrap;
    }

    .cell-bold-text {
        font-weight: 600;
        color: #000000;
    }

    .cell-status {
        display: inline-block;
        font-size: 11px;
        font-weight: 600;
        padding: 5px 10px;
        border-radius: 4px;
        white-space: nowrap;
        text-transform: uppercase;
    }

    /* Status Badge Colors */
    .badge-overdue {
        background: #ef4444;
        color: white;
    }

    .badge-due-soon {
        background: #f59e0b;
        color: white;
    }

    .badge-active {
        background: #10b981;
        color: white;
    }

    .badge-completed {
        background: #6366f1;
        color: white;
    }

    .badge-archived {
        background: #94a3b8;
        color: white;
    }

    .cell-date {
        font-size: 13px;
        color: #1a1a1a;
        white-space: nowrap;
        font-weight: 600;
    }

    .cell-notes {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-size: 13px;
        color: #1a1a1a;
        font-weight: 500;
    }

    /* Action buttons in cells */
    .cell-actions {
        display: flex;
        gap: 6px;
        white-space: nowrap;
        justify-content: center;
        align-items: center;
    }

    .cell-action-btn {
        width: 34px;
        height: 34px;
        border: none;
        background: #f1f5f9;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 15px;
        color: #64748b;
        position: relative;
    }

    .cell-action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    /* View button - Blue */
    .cell-action-btn.btn-view {
        background: #dbeafe;
        color: #2563eb;
    }

    .cell-action-btn.btn-view:hover {
        background: #2563eb;
        color: white;
    }

    /* Edit button - Orange */
    .cell-action-btn.btn-edit {
        background: #fed7aa;
        color: #ea580c;
    }

    .cell-action-btn.btn-edit:hover {
        background: #ea580c;
        color: white;
    }

    /* Complete button - Indigo */
    .cell-action-btn.btn-complete {
        background: #e0e7ff;
        color: #6366f1;
    }

    .cell-action-btn.btn-complete:hover {
        background: #6366f1;
        color: white;
    }

    /* Reopen button - Green */
    .cell-action-btn.btn-reopen {
        background: #d1fae5;
        color: #059669;
    }

    .cell-action-btn.btn-reopen:hover {
        background: #059669;
        color: white;
    }

    /* Delete button - Red */
    .cell-action-btn.btn-delete {
        background: #fee2e2;
        color: #dc2626;
    }

    .cell-action-btn.btn-delete:hover {
        background: #dc2626;
        color: white;
    }

    /* Modal styling */
    .modal-content {
        border-radius: 16px;
        border: none;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }

    .modal-header {
        background: #001F3F;
        color: white !important;
        border-radius: 16px 16px 0 0;
        padding: 24px 28px;
        border-bottom: none;
    }

    .modal-header .modal-title {
        color: white !important;
    }

    .modal-header .btn-close {
        filter: brightness(0) invert(1);
        opacity: 0.9;
    }

    .modal-header .btn-close:hover {
        opacity: 1;
    }

    .modal-body {
        padding: 28px;
    }

    .btn-excel {
        background: #16a34a;
        color: white;
        border: none;
        font-weight: 600;
        padding: 10px 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(22, 163, 74, 0.2);
        transition: all 0.3s;
    }

    .btn-excel:hover {
        background: #15803d;
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(22, 163, 74, 0.3);
    }

    .btn-pdf {
        background: #ef4444;
        color: white;
        border: none;
        font-weight: 600;
        padding: 10px 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(239, 68, 68, 0.2);
        transition: all 0.3s;
    }

    .btn-pdf:hover {
        background: #dc2626;
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(239, 68, 68, 0.3);
    }

    /* Filter controls */
    .matrix-filters {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        align-items: center;
    }

    .matrix-filters .btn {
        font-weight: 600;
        border-radius: 8px;
        padding: 8px 16px;
        transition: all 0.3s;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
    }

    .matrix-filters .btn-success {
        background: #10b981;
        border: none;
        color: white;
    }

    .matrix-filters .btn-success:hover {
        background: #059669;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.3);
    }

    .matrix-filters .btn-danger {
        background: #ef4444;
        border: none;
        color: white;
    }

    .matrix-filters .btn-danger:hover {
        background: #dc2626;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px -1px rgba(239, 68, 68, 0.3);
    }

    .matrix-filters .form-select {
        border: 2px solid var(--border-color);
        border-radius: 8px;
        font-weight: 600;
        padding: 8px 14px;
        transition: all 0.3s;
        background: white;
    }

    .matrix-filters .form-select:hover {
        border-color: #001F3F;
    }

    .matrix-filters .form-select:focus {
        border-color: #001F3F;
        box-shadow: 0 0 0 3px rgba(0, 31, 63, 0.1);
    }

    /* Form controls enhanced visibility */
    .form-select,
    .form-control {
        color: #000000 !important;
        font-weight: 600 !important;
        font-size: 14px !important;
    }

    .form-select {
        padding-right: 2.5rem !important;
        background-position: right 0.75rem center !important;
    }

    .form-select option {
        color: #000000 !important;
        font-weight: 600 !important;
    }

    .form-label {
        color: #000000 !important;
        font-weight: 700 !important;
        font-size: 13px !important;
        margin-bottom: 6px;
    }

    .modal-body {
        color: #000000 !important;
    }

    .modal-body .form-label {
        color: #000000 !important;
        font-weight: 700 !important;
        font-size: 14px !important;
    }

    .modal-body .form-control,
    .modal-body .form-select {
        color: #000000 !important;
        font-weight: 600 !important;
        font-size: 14px !important;
    }

    .modal-body .text-muted {
        color: #6b7280 !important;
    }

    .modal-body input::placeholder,
    .modal-body textarea::placeholder,
    .modal-body select::placeholder {
        color: #9ca3af !important;
        opacity: 1;
    }

    .modal-body .alert {
        color: #000000 !important;
    }

    .modal-body small {
        color: #6b7280 !important;
    }

    /* Empty state */
    .matrix-empty {
        padding: 80px 40px;
        text-align: center;
        background: linear-gradient(to bottom, #ffffff 0%, #f8fafc 100%);
        border-radius: 12px;
        margin: 20px;
    }

    .matrix-empty h5 {
        color: var(--lao-text-dark);
        font-weight: 700;
        font-size: 1.5rem;
    }

    .matrix-empty .btn-primary {
        background: #001F3F;
        border: none;
        font-weight: 600;
        padding: 12px 28px;
        border-radius: 10px;
        box-shadow: 0 4px 6px -1px rgba(0, 31, 63, 0.3);
        transition: all 0.3s;
    }

    .matrix-empty .btn-primary:hover {
        background: #003D7A;
        transform: translateY(-2px);
        box-shadow: 0 6px 10px -1px rgba(0, 31, 63, 0.4);
    }

    /* Loading overlay */
    .matrix-loading {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255,255,255,0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 20;
    }

    /* Modal Improvements */
    #caseModal .modal-content {
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        border: none;
    }

    #caseModal .modal-header {
        background: linear-gradient(135deg, #001F3F 0%, #003D7A 100%);
        border-bottom: none;
        border-radius: 10px 10px 0 0;
        padding: 1rem 1.25rem;
    }

    #caseModal .modal-header .modal-title {
        color: #ffffff !important;
        font-weight: 700;
        font-size: 1.25rem;
    }

    #caseModal .modal-header .btn-close {
        filter: brightness(0) invert(1);
        opacity: 1;
    }

    #caseModal .modal-body {
        padding: 1.5rem;
        padding-bottom: 0;
        background: #ffffff;
        max-height: calc(85vh - 120px);
        overflow-y: auto;
        border-radius: 0 0 10px 10px;
    }

    #caseModal .modal-body::-webkit-scrollbar {
        width: 8px;
    }

    #caseModal .modal-body::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    #caseModal .modal-body::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }

    #caseModal .modal-body::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    /* Form Button Container (inside modal-body) */
    #caseModal .form-button-container {
        margin-top: 1.75rem;
        padding: 1.25rem 1.5rem 1.5rem 1.5rem;
        border-top: 2px solid #e5e7eb;
        display: flex;
        justify-content: flex-end;
        gap: 0.75rem;
        background: transparent;
    }

    #caseModal .form-button-container .btn {
        padding: 0.5rem 1.75rem;
        font-weight: 600;
        border-radius: 6px;
        transition: all 0.4s;
        min-width: 110px;
    }

    #caseModal .form-button-container .btn-secondary {
        background: #64748b;
        border: none;
        font-weight: 600;
        box-shadow: 0 2px 4px rgba(100, 116, 139, 0.2);
    }

    #caseModal .form-button-container .btn-secondary:hover {
        background: #475569;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(100, 116, 139, 0.3);
    }

    #caseModal .form-button-container .btn-success {
        background: #10b981;
        border: none;
        font-weight: 600;
        box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);
    }

    #caseModal .form-button-container .btn-success:hover {
        background: #059669;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(16, 185, 129, 0.3);
    }

    #caseModal .form-label {
        font-weight: 700;
        color: var(--lao-text-dark);
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
        letter-spacing: 0.3px;
    }

    #caseModal .form-label .text-danger {
        color: var(--danger-red) !important;
    }

    #caseModal .form-control,
    #caseModal .form-select {
        border: 2px solid var(--border-color);
        border-radius: 8px;
        padding: 0.75rem 1rem;
        font-size: 0.9rem;
        transition: all 0.4s;
        background: white;
    }

    #caseModal .form-control:focus,
    #caseModal .form-select:focus {
        border-color: #001F3F;
        box-shadow: 0 0 0 4px rgba(0, 31, 63, 0.1);
        outline: none;
        transform: translateY(-1px);
    }

    #caseModal .alert {
        margin-bottom: 1rem;
        border-left: 4px solid;
        border-radius: 10px;
        padding: 1rem;
        font-weight: 500;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
    }

    #caseModal .alert-info {
        border-left: 4px solid #001F3F !important;
        background: linear-gradient(to right, #e0f2fe 0%, #eff6ff 100%);
        color: #001F3F !important;
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    #caseModal .alert-info strong {
        color: #001F3F !important;
        font-weight: 700;
    }

    #caseModal .alert-info i {
        color: #001F3F !important;
        margin-right: 8px;
    }

    #caseModal .alert-success {
        border-left-color: #10b981;
        background: linear-gradient(to right, #d1fae5 0%, #ecfdf5 100%);
        color: #047857;
    }
        border-left-color: #10b981;
        background-color: #d1fae5;
        color: #065f46;
    }

    #caseModal .alert-danger {
        border-left-color: #ef4444;
        background-color: #fee2e2;
        color: #991b1b;
    }

    #caseModal .row.g-3 {
        margin-bottom: 0.5rem;
    }

    #caseModal textarea.form-control {
        resize: vertical;
        min-height: 80px;
    }

    #caseModal small.text-muted,
    #caseModal small.form-text {
        color: #6b7280 !important;
        font-size: 0.8125rem;
    }

    /* Dark Mode Specific Styles for Cases Page */
    body.dark-mode .matrix-table thead th {
        color: #ffffff !important;
    }

    body.dark-mode .cell-case-number {
        color: #e2e8f0 !important;
    }

    body.dark-mode .cell-bold-text {
        color: #e2e8f0 !important;
    }

    body.dark-mode .matrix-table tbody td.td-case-title {
        color: #e2e8f0 !important;
    }

    body.dark-mode .cell-date {
        color: #e2e8f0 !important;
    }

    body.dark-mode .cell-notes {
        color: #d1d5db !important;
    }

    body.dark-mode .form-select,
    body.dark-mode .form-control {
        color: #e2e8f0 !important;
        background: #2d3748 !important;
        border-color: #4a5568 !important;
    }

    body.dark-mode .form-select option {
        color: #e2e8f0 !important;
        background: #2d3748 !important;
    }

    body.dark-mode .form-label {
        color: #d1d5db !important;
    }

    body.dark-mode .modal-body .form-label {
        color: #d1d5db !important;
    }

    body.dark-mode .modal-body .form-control,
    body.dark-mode .modal-body .form-select {
        color: #e2e8f0 !important;
        background: #2d3748 !important;
        border-color: #4a5568 !important;
    }

    body.dark-mode #caseModal {
        background: rgba(0, 0, 0, 0.8);
    }

    /* Keep modal background white in dark mode with black text for visibility */
    body.dark-mode #caseModal .modal-content {
        background: #ffffff !important;
    }

    body.dark-mode #caseModal .modal-header {
        background: linear-gradient(135deg, #001F3F 0%, #003D7A 100%) !important;
    }

    body.dark-mode #caseModal .modal-header .modal-title {
        color: #ffffff !important;
    }

    body.dark-mode #caseModal .modal-body {
        background: #ffffff !important;
        color: #000000 !important;
    }

    body.dark-mode #caseModal .modal-body .form-label {
        color: #000000 !important;
    }

    body.dark-mode #caseModal .form-control,
    body.dark-mode #caseModal .form-select {
        background: #ffffff !important;
        border-color: #d1d5db !important;
        color: #000000 !important;
    }

    body.dark-mode #caseModal .form-control::placeholder,
    body.dark-mode #caseModal .form-select::placeholder,
    body.dark-mode #caseModal textarea::placeholder {
        color: #9ca3af !important;
    }

    body.dark-mode #caseModal .form-control:focus,
    body.dark-mode #caseModal .form-select:focus {
        background: #ffffff !important;
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1) !important;
    }

    body.dark-mode #caseModal .form-button-container .btn-secondary {
        background: #4a5568 !important;
        color: #ffffff !important;
    }

    body.dark-mode #caseModal .form-button-container .btn-secondary:hover {
        background: #5a6578 !important;
    }

    body.dark-mode #caseModal .form-button-container .btn-success {
        background: #047857 !important;
        color: #ffffff !important;
    }

    body.dark-mode #caseModal .form-button-container .btn-success:hover {
        background: #059669 !important;
    }

    body.dark-mode #caseModal .alert-info {
        border-left: 4px solid #0369a1 !important;
        background: #dbeafe !important;
        color: #1e3a8a !important;
        padding: 12px 16px;
        border-radius: 8px;
    }

    body.dark-mode #caseModal .alert-info strong {
        color: #1e3a8a !important;
        font-weight: 700;
    }

    body.dark-mode #caseModal .alert-info i {
        color: #0369a1 !important;
        margin-right: 8px;
    }

    body.dark-mode #caseModal .alert-success {
        border-left-color: #047857 !important;
        background-color: #d1fae5 !important;
        color: #065f46 !important;
    }

    body.dark-mode #caseModal .alert-danger {
        border-left-color: #b91c1c !important;
        background-color: #fecaca !important;
        color: #7f1d1d !important;
    }

    body.dark-mode #caseModal small.text-muted,
    body.dark-mode #caseModal small.form-text {
        color: #6b7280 !important;
    }

    body.dark-mode #caseModal .form-select option {
        color: #000000 !important;
        background: #ffffff !important;
    }

    body.dark-mode .matrix-empty h3,
    body.dark-mode .matrix-empty h5 {
        color: #9ca3af !important;
    }

    body.dark-mode .matrix-empty p {
        color: #6b7280 !important;
    }

    body.dark-mode .matrix-empty i {
        color: #4b5563 !important;
    }

    body.dark-mode .matrix-empty .btn-primary {
        background: #1a4d8f !important;
        color: #e2e8f0 !important;
    }

    body.dark-mode .matrix-empty .btn-primary:hover {
        background: #2563eb !important;
        color: #ffffff !important;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<?php if($errors->any()): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Validation Errors:</strong>
    <ul class="mb-0 mt-2">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><?php echo e($error); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
    <button type="button" class="btn-close"></button>
</div>
<?php endif; ?>

<?php if(session('import_errors') && count(session('import_errors')) > 0): ?>
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Import Warnings:</strong>
    <ul class="mb-0 mt-2" style="max-height: 200px; overflow-y: auto;">
        <?php $__currentLoopData = session('import_errors'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><?php echo e($error); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<div class="matrix-container">
    <!-- Matrix Controls -->
    <div class="matrix-controls">
        <!-- Search Row -->
        <div class="matrix-datetime-search">
            <div class="matrix-search-wrapper">
                <input type="text" id="matrixSearchInput" class="matrix-search-input" placeholder="Search by Case No., Client Name, or Case Title...">
            </div>
        </div>

        <!-- Filters and Actions Row -->
        <div class="matrix-filters-row">
            <div class="matrix-filters">
            <select id="filterStatus" class="form-select form-select-sm" style="width: auto;">
                <option value="">All Status</option>
                <option value="overdue">Overdue</option>
                <option value="due_soon">Due Soon</option>
                <option value="active">Active</option>
            </select>

            <select id="filterType" class="form-select form-select-sm" style="width: auto;">
                <option value="">All Types</option>
                <option value="Civil">Civil</option>
                <option value="Criminal">Criminal</option>
                <option value="Labor">Labor</option>
                <option value="Administrative">Administrative</option>
            </select>

            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#caseModal" onclick="openNewCaseModal()">
                <i class="bi bi-plus-circle"></i> Add New Case
            </button>

            <a href="<?php echo e(route('cases.export.excel', request()->only(['status', 'search']))); ?>" class="btn btn-excel btn-sm">
                <i class="bi bi-file-earmark-excel"></i> Export Excel
            </a>

            <a href="<?php echo e(route('cases.export.pdf', request()->only(['status', 'search']))); ?>" class="btn btn-pdf btn-sm">
                <i class="bi bi-file-earmark-pdf"></i> Export PDF
            </a>

            <?php if($cases->count() > 0): ?>
            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteAllModal">
                <i class="bi bi-trash-fill"></i> Delete All Cases
            </button>
            <?php endif; ?>
        </div>
        </div>
    </div>

    <!-- Matrix Table -->
    <div class="matrix-table-wrapper">
        <?php if($cases->count() > 0): ?>
        <table class="matrix-table">
            <thead>
                <tr>
                    <th style="width: 100px;">Case No.</th>
                    <th style="width: 130px;">Docket No.</th>
                    <th style="width: 120px;">Old Folder No.</th>
                    <th class="th-case-title" style="width: 300px;">Case Title</th>
                    <th style="width: 180px;">Client Name</th>
                    <th style="width: 120px;">Case Type</th>
                    <th style="width: 120px;">Section</th>
                    <th style="width: 120px;">Court/Agency</th>
                    <th style="width: 120px;">Region</th>
                    <th style="width: 180px;">Assigned Lawyer</th>
                    <th style="width: 180px;">Handling Counsel (NCIP)</th>
                    <th style="width: 110px;">Date Filed</th>
                    <th style="width: 110px;">Deadline Date</th>
                    <th style="width: 110px;">Hearing Date</th>
                    <th style="width: 200px;">Actions Taken</th>
                    <th style="width: 200px;">Action</th>
                    <th style="width: 250px;">Issues/Grounds</th>
                    <th style="width: 200px;">Prayers (Relief)</th>
                    <th style="width: 150px;">New SC No.</th>
                    <th style="width: 150px;">Remarks</th>
                    <th style="width: 200px;">Note</th>
                    <th style="width: 100px;">Status</th>
                    <th style="width: 170px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $cases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $case): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="row-<?php echo e($case->status); ?>" data-case-id="<?php echo e($case->id); ?>">
                    <td class="cell-case-number" style="width: 100px;"><?php echo e($case->case_number ?: '-'); ?></td>
                    <td class="cell-bold-text" style="width: 130px;"><?php echo e($case->docket_no ?: '-'); ?></td>
                    <td class="cell-bold-text" style="width: 120px;"><?php echo e($case->old_folder_no ?: '-'); ?></td>
                    <td class="td-case-title" style="width: 300px;"><?php echo e($case->case_title ?: '-'); ?></td>
                    <td class="cell-bold-text" style="width: 180px;"><?php echo e($case->client_name ?: '-'); ?></td>
                    <td style="width: 120px;"><?php echo e($case->case_type ?: '-'); ?></td>
                    <td style="width: 120px;"><?php echo e($case->section ?: '-'); ?></td>
                    <td style="width: 120px;"><?php echo e($case->court_agency ?: '-'); ?></td>
                    <td style="width: 120px;"><?php echo e($case->region ?: '-'); ?></td>
                    <td class="cell-bold-text" style="width: 180px;"><?php echo e($case->assigned_lawyer ?: '-'); ?></td>
                    <td class="cell-bold-text" style="width: 180px;"><?php echo e($case->handling_counsel_ncip ?: '-'); ?></td>
                    <td style="width: 110px;"><?php echo e($case->date_filed ? \Carbon\Carbon::parse($case->date_filed)->format('Y-m-d') : '-'); ?></td>
                    <td style="width: 110px;"><?php echo e($case->deadline_date ? \Carbon\Carbon::parse($case->deadline_date)->format('Y-m-d') : '-'); ?></td>
                    <td style="width: 110px;"><?php echo e($case->hearing_date ? \Carbon\Carbon::parse($case->hearing_date)->format('Y-m-d') : '-'); ?></td>
                    <td class="cell-notes" style="width: 200px;" title="<?php echo e($case->actions_taken); ?>"><?php echo e(Str::limit($case->actions_taken, 50) ?: '-'); ?></td>
                    <td class="cell-notes" style="width: 200px;" title="<?php echo e($case->action); ?>"><?php echo e(Str::limit($case->action, 50) ?: '-'); ?></td>
                    <td class="cell-notes" style="width: 250px;" title="<?php echo e($case->issues_grounds); ?>"><?php echo e(Str::limit($case->issues_grounds, 60) ?: '-'); ?></td>
                    <td class="cell-notes" style="width: 200px;" title="<?php echo e($case->prayers_relief); ?>"><?php echo e(Str::limit($case->prayers_relief, 50) ?: '-'); ?></td>
                    <td class="cell-bold-text" style="width: 150px;"><?php echo e($case->new_sc_no ?: '-'); ?></td>
                    <td class="cell-notes" style="width: 150px;" title="<?php echo e($case->remarks); ?>"><?php echo e($case->remarks ?: '-'); ?></td>
                    <td class="cell-notes" style="width: 200px;" title="<?php echo e($case->notes); ?>"><?php echo e(Str::limit($case->notes, 50) ?: '-'); ?></td>
                    <td style="width: 100px;">
                        <?php if($case->status === 'completed'): ?>
                            <span class="cell-status badge-completed">
                                <i class="bi bi-check-circle-fill"></i> COMPLETED
                            </span>
                        <?php elseif($case->status === 'archived'): ?>
                            <span class="cell-status badge-archived">
                                <i class="bi bi-archive-fill"></i> ARCHIVED
                            </span>
                        <?php elseif($case->status === 'overdue'): ?>
                            <span class="cell-status badge-overdue">
                                <i class="bi bi-x-circle-fill"></i> OVERDUE
                            </span>
                        <?php elseif($case->status === 'due_soon'): ?>
                            <span class="cell-status badge-due-soon">
                                <i class="bi bi-clock-fill"></i> DUE SOON
                            </span>
                        <?php else: ?>
                            <span class="cell-status badge-active">
                                <i class="bi bi-check-circle-fill"></i> ACTIVE
                            </span>
                        <?php endif; ?>
                    </td>
                    <td style="width: 170px;">
                        <div class="cell-actions">
                            <a href="<?php echo e(route('cases.show', $case)); ?>" class="cell-action-btn btn-view" title="View Case">
                                <i class="bi bi-eye-fill"></i>
                            </a>
                            <button type="button" class="cell-action-btn btn-edit" title="Edit Case" onclick="editCase(<?php echo e($case->id); ?>)">
                                <i class="bi bi-pencil-fill"></i>
                            </button>
                            <?php if($case->status === 'completed'): ?>
                            <form action="<?php echo e(route('cases.reopenCase', $case)); ?>" method="POST" style="display: inline;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <button type="submit" class="cell-action-btn btn-reopen" title="Reopen Case">
                                    <i class="bi bi-arrow-clockwise"></i>
                                </button>
                            </form>
                            <?php else: ?>
                            <form action="<?php echo e(route('cases.markAsCompleted', $case)); ?>" method="POST" style="display: inline;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <button type="submit" class="cell-action-btn btn-complete" title="Mark as Completed">
                                    <i class="bi bi-check-circle-fill"></i>
                                </button>
                            </form>
                            <?php endif; ?>
                            <button type="button" class="cell-action-btn btn-delete" title="Delete" onclick="deleteCase(<?php echo e($case->id); ?>)">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <?php else: ?>
        <div class="matrix-empty">
            <i class="bi bi-table" style="font-size: 72px; color: #cbd5e1;"></i>
            <h5 class="mt-4 mb-2">No Cases in Matrix</h5>
            <p class="text-muted">Add your first case to start tracking deadlines</p>
            <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#caseModal" onclick="openNewCaseModal()">
                <i class="bi bi-plus-circle"></i> Add New Case
            </button>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Case Entry/Edit Modal -->
<div class="modal fade" id="caseModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="caseModalTitle">
                    <i class="bi bi-folder-plus"></i> Add New Case
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="caseForm" method="POST" action="<?php echo e(route('cases.store')); ?>" novalidate>
                <?php echo csrf_field(); ?>
                <input type="hidden" id="caseId" name="_method" value="">
                
                <div class="modal-body">
                    <?php if($errors->any()): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Validation Errors:</strong>
                        <ul class="mb-0 mt-2">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php endif; ?>

                    <!-- Court/Agency Selection (Always Visible) -->
                    <div class="row g-3 mb-3">
                        <div class="col-12">
                            <label for="court_agency" class="form-label">Select Court/Agency</label>
                            <select class="form-select form-select-lg" id="court_agency" name="court_agency" onchange="toggleFormFields()">
                                <option value="">-- Select Court/Agency First --</option>
                                <option value="SC">Supreme Court (SC)</option>
                                <option value="CA">Court of Appeals (CA)</option>
                                <option value="RTC">Regional Trial Court (RTC)</option>
                                <option value="MTC">Municipal Trial Court (MTC)</option>
                                <option value="OMB">Office of the Ombudsman (OMB)</option>
                                <option value="ADMIN">Administrative</option>
                                <option value="NCIP">NCIP</option>
                                <option value="REGIONS">Regions</option>
                                <option value="OJ">Office of Justice (OJ)</option>
                                <option value="Others">Others</option>
                            </select>
                            <small class="text-muted">Choose the court/agency to display the appropriate form fields</small>
                        </div>
                    </div>

                    <!-- Supreme Court Specific Fields -->
                    <div id="sc-fields" style="display: none;">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> <strong>Supreme Court Form</strong> - Fill in SC-specific information
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="case_number_sc" class="form-label">Case Number</label>
                                <input type="text" class="form-control" id="case_number_sc" name="case_number" placeholder="e.g., 1001">
                            </div>
                            
                            <div class="col-md-6">
                                <label for="docket_no_sc" class="form-label">Docket No.</label>
                                <input type="text" class="form-control" id="docket_no_sc" name="docket_no" placeholder="e.g., G.R. No. 123456">
                            </div>
                            
                            <div class="col-md-6">
                                <label for="new_sc_no" class="form-label">New SC No.</label>
                                <input type="text" class="form-control" id="new_sc_no" name="new_sc_no" placeholder="Enter new SC number">
                            </div>
                            
                            <div class="col-md-6">
                                <label for="old_folder_no_sc" class="form-label">Old Folder No.</label>
                                <input type="text" class="form-control" id="old_folder_no_sc" name="old_folder_no" placeholder="Enter old folder number">
                            </div>
                            
                            <div class="col-12">
                                <label for="case_title_sc" class="form-label">Case Title</label>
                                <input type="text" class="form-control" id="case_title_sc" name="case_title" placeholder="Enter case title">
                            </div>
                            
                            <div class="col-md-6">
                                <label for="client_name_sc" class="form-label">Client Name</label>
                                <input type="text" class="form-control" id="client_name_sc" name="client_name" placeholder="Enter client name">
                            </div>
                            
                            <div class="col-md-6">
                                <label for="section_sc" class="form-label">Section</label>
                                <select class="form-select" id="section_sc" name="section">
                                    <option value="">Select Section</option>
                                    <option value="Criminal">Criminal</option>
                                    <option value="Civil">Civil</option>
                                    <option value="Labor">Labor</option>
                                    <option value="Administrative">Administrative</option>
                                    <option value="Special/IP">Special/IP</option>
                                    <option value="OJ">OJ</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="handling_counsel_ncip_sc" class="form-label">Handling Counsel for NCIP</label>
                                <input type="text" class="form-control" id="handling_counsel_ncip_sc" name="handling_counsel_ncip" placeholder="Enter NCIP handling counsel name">
                            </div>

                            <div class="col-md-5">
                                <label for="date_filed_sc" class="form-label">Date Filed</label>
                                <input type="date" class="form-control" id="date_filed_sc" name="date_filed" onchange="calculateDeadline()">
                            </div>

                            <div class="col-md-3">
                                <label for="deadline_days_sc" class="form-label">Deadline Period</label>
                                <input type="number" class="form-control" id="deadline_days_sc" name="deadline_days" list="deadline_options" placeholder="Enter days" onchange="calculateDeadline()" oninput="calculateDeadline()">
                                <datalist id="deadline_options_sc">
                                    <option value="15">
                                    <option value="30">
                                    <option value="45">
                                    <option value="60">
                                    <option value="90">
                                </datalist>
                                <small class="text-muted">Enter deadline days</small>
                            </div>

                            <div class="col-md-4">
                                <label for="deadline_date_sc" class="form-label">Deadline Date</label>
                                <input type="date" class="form-control" id="deadline_date_sc" name="deadline_date_display" readonly style="background: #f3f4f6;">
                            </div>
                            
                            <div class="col-12">
                                <label for="action" class="form-label">Action</label>
                                <textarea class="form-control" id="action" name="action" rows="3" placeholder="Describe the action..."></textarea>
                            </div>
                            
                            <div class="col-12">
                                <label for="issues_grounds" class="form-label">Issues/Grounds for Allowance of the Petition</label>
                                <textarea class="form-control" id="issues_grounds" name="issues_grounds" rows="3" placeholder="Enter issues and grounds..."></textarea>
                            </div>
                            
                            <div class="col-12">
                                <label for="prayers_relief" class="form-label">Prayers (Relief)</label>
                                <textarea class="form-control" id="prayers_relief" name="prayers_relief" rows="3" placeholder="Enter prayers and relief sought..."></textarea>
                            </div>
                            
                            <div class="col-12">
                                <label for="remarks" class="form-label">Remarks</label>
                                <input type="text" class="form-control" id="remarks" name="remarks" placeholder="Enter remarks">
                            </div>
                            
                            <div class="col-12">
                                <label for="notes_sc" class="form-label">Notes</label>
                                <textarea class="form-control" id="notes_sc" name="notes" rows="2" placeholder="Add case notes..."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Default Fields for Other Courts -->
                    <div id="default-fields" style="display: none;">
                        <div class="alert alert-success">
                            <i class="bi bi-info-circle"></i> <strong>Case Information Form</strong> - Fill in case details
                        </div>
                        <div class="row g-3">
                        <div class="col-md-6">
                            <label for="case_number_default" class="form-label">Case Number</label>
                            <input type="text" class="form-control" id="case_number_default" name="case_number">
                            <small class="form-text text-muted">Enter numeric case number only (e.g., 1001, 2025)</small>
                        </div>

                        <div class="col-md-6">
                                    <label for="docket_no_default" class="form-label">Docket Number <small class="text-muted">(alphanumeric)</small></label>
                                    <input type="text" class="form-control" id="docket_no_default" name="docket_no" placeholder="e.g., G.R. No. 123456">
                                    <small class="form-text text-muted">For identifiers like "G.R. No. 123456" or "RTC-001-2026"</small>
                                </div>

                                <div class="col-md-6">
                                    <label for="old_folder_no_default" class="form-label">Old Folder No.</label>
                                    <input type="text" class="form-control" id="old_folder_no_default" name="old_folder_no" placeholder="Enter old folder number">
                                </div>

                                <div class="col-12">
                                    <label for="case_title_default" class="form-label">Case Title</label>
                                    <input type="text" class="form-control" id="case_title_default" name="case_title">
                                </div>

                                <div class="col-md-6">
                                    <label for="client_name" class="form-label">Client Name</label>
                                    <input type="text" class="form-control" id="client_name" name="client_name">
                                </div>

                                <div class="col-md-6">
                                    <label for="assigned_lawyer" class="form-label">Assigned Lawyer</label>
                                    <input type="text" class="form-control" id="assigned_lawyer" name="assigned_lawyer" placeholder="Enter lawyer name">
                                </div>

                                <div class="col-md-6">
                                    <label for="section" class="form-label">Section</label>
                                    <select class="form-select" id="section" name="section">
                                        <option value="">Select Section</option>
                                        <option value="Criminal">Criminal</option>
                                        <option value="Civil">Civil</option>
                                        <option value="Labor">Labor</option>
                                        <option value="Administrative">Administrative</option>
                                        <option value="Special/IP">Special/IP</option>
                                        <option value="OJ">OJ (Office of Justice)</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="case_type" class="form-label">Case Type</label>
                                    <input type="text" class="form-control" id="case_type" name="case_type" placeholder="e.g., Homicide, Breach of Contract">
                                </div>

                                <div class="col-md-6">
                                    <label for="region" class="form-label">Region</label>
                                    <select class="form-select" id="region" name="region">
                                        <option value="">Select Region</option>
                                        <option value="NCR">NCR</option>
                                        <option value="Region I">Region I</option>
                                        <option value="Region II">Region II</option>
                                        <option value="Region III">Region III</option>
                                        <option value="Region IV-A">Region IV-A (CALABARZON)</option>
                                        <option value="Region IV-B">Region IV-B (MIMAROPA)</option>
                                        <option value="Region V">Region V</option>
                                        <option value="Region VI">Region VI</option>
                                        <option value="Region VII">Region VII</option>
                                        <option value="Region VIII">Region VIII</option>
                                        <option value="Region IX">Region IX</option>
                                        <option value="Region X">Region X</option>
                                        <option value="Region XI">Region XI</option>
                                        <option value="Region XII">Region XII</option>
                                        <option value="Region XIII">Region XIII</option>
                                        <option value="BARMM">BARMM</option>
                                    </select>
                                </div>

                                <div class="col-md-5">
                                    <label for="date_filed" class="form-label">Date Filed</label>
                                    <input type="date" class="form-control" id="date_filed" name="date_filed" onchange="calculateDeadline()">
                                </div>

                                <div class="col-md-3">
                                    <label for="deadline_days" class="form-label">Deadline Period</label>
                                    <input type="number" class="form-control" id="deadline_days" name="deadline_days" list="deadline_options" placeholder="Enter days" onchange="calculateDeadline()" oninput="calculateDeadline()">
                                    <datalist id="deadline_options">
                                        <option value="15">
                                        <option value="30">
                                        <option value="45">
                                        <option value="60">
                                        <option value="90">
                                    </datalist>
                                    <small class="text-muted">Enter deadline days</small>
                                </div>

                                <div class="col-md-4">
                                    <label for="deadline_date" class="form-label">Deadline Date</label>
                                    <input type="date" class="form-control" id="deadline_date" name="deadline_date" readonly style="background: #f3f4f6;">
                                </div>

                                <div class="col-md-6">
                                    <label for="hearing_date" class="form-label">Hearing Date (Optional)</label>
                                    <input type="date" class="form-control" id="hearing_date" name="hearing_date">
                                </div>

                                <div class="col-md-6">
                                    <label for="handling_counsel_ncip_default" class="form-label">Handling Counsel for NCIP</label>
                                    <input type="text" class="form-control" id="handling_counsel_ncip_default" name="handling_counsel_ncip" placeholder="Enter NCIP handling counsel name">
                                </div>

                                <div class="col-12">
                                    <label for="actions_taken_default" class="form-label">Actions Taken / Documents Filed</label>
                                    <textarea class="form-control" id="actions_taken_default" name="actions_taken" rows="3" placeholder="Describe actions taken or documents filed..."></textarea>
                                </div>

                                <div class="col-12">
                                    <label for="notes" class="form-label">Notes / Remarks</label>
                                    <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Add case notes or remarks..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Button Container (inside modal-body) -->
                    <div class="form-button-container">
                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-success px-4" id="saveCaseBtn">
                            <i class="bi bi-save"></i> Save Case
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete All Cases Modal with Strong Warning -->
<div class="modal fade" id="deleteAllModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-danger">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle-fill"></i> ⚠️ DANGER: Delete All Cases
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('cases.destroyAll')); ?>" method="POST" id="deleteAllForm">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <div class="modal-body">
                    <div class="alert alert-danger border-danger mb-3">
                        <h6 class="alert-heading mb-2">
                            <i class="bi bi-shield-exclamation"></i> <strong>CRITICAL WARNING</strong>
                        </h6>
                        <p class="mb-2"><strong>This action will permanently delete ALL <?php echo e($cases->count()); ?> case(s) in the system.</strong></p>
                        <hr>
                        <p class="mb-1"><strong>This includes:</strong></p>
                        <ul class="mb-2">
                            <li>All case details and information</li>
                            <li>All associated documents</li>
                            <li>All case history and notes</li>
                            <li>All reminders and notifications</li>
                        </ul>
                        <p class="mb-0 text-danger"><strong><i class="bi bi-x-circle-fill"></i> THIS CANNOT BE UNDONE!</strong></p>
                    </div>

                    <div class="alert alert-warning border-warning">
                        <p class="mb-2"><strong><i class="bi bi-info-circle"></i> Before proceeding:</strong></p>
                        <ul class="mb-0">
                            <li>Make sure you have exported your cases to Excel/PDF</li>
                            <li>Verify you have proper backup of all documents</li>
                            <li>Confirm this action is authorized</li>
                        </ul>
                    </div>

                    <div class="mb-3">
                        <label for="confirmation_text" class="form-label">
                            <strong>To confirm deletion, type exactly:</strong>
                            <span class="text-danger fw-bold ms-2">DELETE ALL CASES</span>
                        </label>
                        <input 
                            type="text" 
                            class="form-control form-control-lg text-center" 
                            id="confirmation_text" 
                            name="confirmation" 
                            placeholder="Type: DELETE ALL CASES" 
                            required
                            autocomplete="off"
                            style="font-family: monospace; font-weight: bold; border: 2px solid #dc3545;">
                        <small class="text-muted">Confirmation is case-sensitive</small>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="understand_checkbox" required>
                        <label class="form-check-label" for="understand_checkbox">
                            <strong>I understand this action is permanent and cannot be undone</strong>
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-danger" id="confirmDeleteAllBtn" disabled>
                        <i class="bi bi-trash-fill"></i> DELETE ALL CASES
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Toggle form fields based on Court/Agency selection
    function toggleFormFields() {
        const courtAgency = document.getElementById('court_agency').value;
        const scFields = document.getElementById('sc-fields');
        const defaultFields = document.getElementById('default-fields');
        
        // Helper function to disable/enable all inputs in a section
        function toggleInputs(section, enable) {
            const inputs = section.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                input.disabled = !enable;
            });
        }
        
        if (courtAgency === 'SC') {
            scFields.style.display = 'block';
            defaultFields.style.display = 'none';
            toggleInputs(scFields, true);  // Enable SC fields
            toggleInputs(defaultFields, false);  // Disable default fields
        } else if (courtAgency === '') {
            scFields.style.display = 'none';
            defaultFields.style.display = 'none';
            toggleInputs(scFields, false);
            toggleInputs(defaultFields, false);
        } else {
            scFields.style.display = 'none';
            defaultFields.style.display = 'block';
            toggleInputs(scFields, false);  // Disable SC fields
            toggleInputs(defaultFields, true);  // Enable default fields
        }
    }

    // Handle form submission
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize form fields on page load
        toggleFormFields();
        
        const caseForm = document.getElementById('caseForm');
        const caseModal = document.getElementById('caseModal');
        
        // Reset form when modal is shown
        if (caseModal) {
            caseModal.addEventListener('shown.bs.modal', function() {
                // Reset the Court/Agency dropdown
                const courtAgencySelect = document.getElementById('court_agency');
                if (courtAgencySelect) {
                    courtAgencySelect.value = '';
                }
                // Toggle fields to hide all sections initially
                toggleFormFields();
            });
        }
    });

    // Auto-calculate deadline date
    function calculateDeadline() {
        // Check which form is active (SC or default)
        const scFields = document.getElementById('sc-fields');
        const isSCForm = scFields && scFields.style.display !== 'none';
        
        // Get the appropriate field IDs based on active form
        const dateFiledId = isSCForm ? 'date_filed_sc' : 'date_filed';
        const deadlineDaysId = isSCForm ? 'deadline_days_sc' : 'deadline_days';
        const deadlineDateId = isSCForm ? 'deadline_date_sc' : 'deadline_date';
        
        const dateFiledEl = document.getElementById(dateFiledId);
        const deadlineDaysEl = document.getElementById(deadlineDaysId);
        const deadlineDateEl = document.getElementById(deadlineDateId);
        
        if (!dateFiledEl || !deadlineDaysEl || !deadlineDateEl) return;
        
        const dateFiled = dateFiledEl.value;
        const deadlineDaysInput = deadlineDaysEl.value;
        const deadlineDays = parseInt(deadlineDaysInput);
        
        if (dateFiled && deadlineDaysInput && !isNaN(deadlineDays) && deadlineDays > 0 && deadlineDays <= 365) {
            const filed = new Date(dateFiled);
            const deadline = new Date(filed);
            deadline.setDate(deadline.getDate() + deadlineDays);
            
            const year = deadline.getFullYear();
            const month = String(deadline.getMonth() + 1).padStart(2, '0');
            const day = String(deadline.getDate()).padStart(2, '0');
            
            deadlineDateEl.value = `${year}-${month}-${day}`;
        } else {
            // Clear deadline date if inputs are invalid
            deadlineDateEl.value = '';
        }
    }

    // Open new case modal
    function openNewCaseModal() {
        document.getElementById('caseModalTitle').innerHTML = '<i class="bi bi-folder-plus"></i> Add New Case';
        document.getElementById('caseForm').action = '<?php echo e(route("cases.store")); ?>';
        document.getElementById('caseForm').reset();
        document.getElementById('caseId').value = '';
        document.querySelector('[name="_method"]').value = '';
    }

    // Edit case
    function editCase(id) {
        // Redirect to edit page
        window.location.href = `/cases/${id}/edit`;
    }

    // Delete case
    function deleteCase(id) {
        if (confirm('Are you sure you want to delete this case? This action cannot be undone.')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/cases/${id}`;
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '<?php echo e(csrf_token()); ?>';
            
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';
            
            form.appendChild(csrfToken);
            form.appendChild(methodField);
            document.body.appendChild(form);
            form.submit();
        }
    }

    // Search functionality
    document.getElementById('matrixSearchInput').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('.matrix-table tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });

    // Filter functionality
    document.getElementById('filterStatus').addEventListener('change', applyFilters);
    document.getElementById('filterType').addEventListener('change', applyFilters);

    function applyFilters() {
        const statusFilter = document.getElementById('filterStatus').value;
        const typeFilter = document.getElementById('filterType').value;
        const rows = document.querySelectorAll('.matrix-table tbody tr');
        
        rows.forEach(row => {
            let showRow = true;
            
            if (statusFilter && !row.classList.contains(`row-${statusFilter}`)) {
                showRow = false;
            }
            
            if (typeFilter) {
                const typeCell = row.querySelector('td:nth-child(2)').textContent.trim();
                if (!typeCell.includes(typeFilter)) {
                    showRow = false;
                }
            }
            
            row.style.display = showRow ? '' : 'none';
        });
    }

    // Column sorting
    document.querySelectorAll('.matrix-table thead th').forEach((th, index) => {
        if (index < 10) { // Don't make actions column sortable
            th.addEventListener('click', function() {
                sortTable(index);
            });
        }
    });

    function sortTable(columnIndex) {
        const table = document.querySelector('.matrix-table');
        const tbody = table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));
        
        rows.sort((a, b) => {
            const aValue = a.cells[columnIndex].textContent.trim();
            const bValue = b.cells[columnIndex].textContent.trim();
            return aValue.localeCompare(bValue);
        });
        
        rows.forEach(row => tbody.appendChild(row));
    }

    // Form submission logging for debugging
    document.addEventListener('DOMContentLoaded', function() {
        const caseForm = document.getElementById('caseForm');
        const saveBtn = document.getElementById('saveCaseBtn');
        
        if (caseForm) {
            caseForm.addEventListener('submit', function(e) {
                console.log('✅ Form submit event triggered!');
                console.log('Form action:', caseForm.action);
                console.log('Form method:', caseForm.method);
                
                const formData = new FormData(caseForm);
                console.log('Form fields:');
                for (let [key, value] of formData.entries()) {
                    console.log(`  ${key}: ${value}`);
                }
                
                // Let it submit normally - don't prevent
                return true;
            });
        }
        
        if (saveBtn) {
            saveBtn.addEventListener('click', function(e) {
                console.log('🔘 Save button clicked!');
                console.log('Button type:', this.type);
            });
        }
    });

    // Delete All Cases Confirmation Logic
    document.addEventListener('DOMContentLoaded', function() {
        const deleteAllForm = document.getElementById('deleteAllForm');
        const confirmationInput = document.getElementById('confirmation_text');
        const understandCheckbox = document.getElementById('understand_checkbox');
        const confirmDeleteBtn = document.getElementById('confirmDeleteAllBtn');
        const deleteAllModal = document.getElementById('deleteAllModal');

        // Function to check if form is valid
        function validateDeleteAllForm() {
            const confirmationText = confirmationInput?.value || '';
            const isChecked = understandCheckbox?.checked || false;
            const isTextMatch = confirmationText === 'DELETE ALL CASES';
            
            if (confirmDeleteBtn) {
                confirmDeleteBtn.disabled = !(isTextMatch && isChecked);
            }
        }

        // Add event listeners
        if (confirmationInput) {
            confirmationInput.addEventListener('input', validateDeleteAllForm);
            confirmationInput.addEventListener('keyup', validateDeleteAllForm);
        }

        if (understandCheckbox) {
            understandCheckbox.addEventListener('change', validateDeleteAllForm);
        }

        // Reset form when modal is closed
        if (deleteAllModal) {
            deleteAllModal.addEventListener('hidden.bs.modal', function () {
                if (deleteAllForm) {
                    deleteAllForm.reset();
                }
                if (confirmDeleteBtn) {
                    confirmDeleteBtn.disabled = true;
                }
            });
        }

        // Final confirmation before submit
        if (deleteAllForm) {
            deleteAllForm.addEventListener('submit', function(e) {
                const confirmationText = confirmationInput?.value || '';
                
                if (confirmationText !== 'DELETE ALL CASES') {
                    e.preventDefault();
                    alert('Please type the exact confirmation text: DELETE ALL CASES');
                    return false;
                }

                if (!understandCheckbox?.checked) {
                    e.preventDefault();
                    alert('Please confirm you understand this action cannot be undone.');
                    return false;
                }

                // Final browser confirmation
                if (!confirm('⚠️ FINAL CONFIRMATION: Are you absolutely sure you want to delete ALL cases? This cannot be undone!')) {
                    e.preventDefault();
                    return false;
                }

                console.log('✅ Delete all cases confirmed - proceeding with deletion');
                return true;
            });
        }

        // Import form handling
        const importForm = document.getElementById('importForm');
        const importBtn = document.getElementById('importBtn');
        const importFileInput = document.getElementById('import_file');

        if (importForm) {
            importForm.addEventListener('submit', function(e) {
                if (!importFileInput || !importFileInput.files || importFileInput.files.length === 0) {
                    e.preventDefault();
                    alert('Please select a file to import');
                    return false;
                }

                // Show loading state
                if (importBtn) {
                    importBtn.disabled = true;
                    importBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Importing...';
                }

                console.log('✅ Import started:', importFileInput.files[0].name);
                return true;
            });
        }

        // Show file name when selected
        if (importFileInput) {
            importFileInput.addEventListener('change', function(e) {
                if (this.files && this.files.length > 0) {
                    const fileName = this.files[0].name;
                    const fileSize = (this.files[0].size / 1024 / 1024).toFixed(2); // MB
                    console.log('📁 File selected:', fileName, '(' + fileSize + ' MB)');
                }
            });
        }
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\LAO Case Matrix System\CASE MATRIX SYSTEM\resources\views/cases/index.blade.php ENDPATH**/ ?>
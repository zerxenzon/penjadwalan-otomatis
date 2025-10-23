<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Penjadwalan Otomatis')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #858796;
            --success-color: #1cc88a;
            --danger-color: #e74c3c;
            --warning-color: #f39c12;
            --info-color: #3498db;
        }

        body {
            background-color: #f8f9fc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .sidebar {
            background-color: #f8f9fa;
            border-right: 1px solid #e3e6f0;
            min-height: 100vh;
            position: sticky;
            top: 0;
        }

        .nav-link {
            color: #858796;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: #4e73df;
            background-color: #e8eef7;
            border-left: 4px solid #4e73df;
            padding-left: calc(1.5rem - 4px);
        }

        .nav-link.active {
            color: #4e73df;
            background-color: #e8eef7;
            border-left: 4px solid #4e73df;
            padding-left: calc(1.5rem - 4px);
        }

        .card {
            border: none;
            border-radius: 0.35rem;
            margin-bottom: 1.5rem;
        }

        .card.border-left-primary {
            border-left: 0.25rem solid #4e73df !important;
        }

        .card.border-left-success {
            border-left: 0.25rem solid #1cc88a !important;
        }

        .card.border-left-warning {
            border-left: 0.25rem solid #f39c12 !important;
        }

        .card.border-left-danger {
            border-left: 0.25rem solid #e74c3c !important;
        }

        .card.border-left-info {
            border-left: 0.25rem solid #3498db !important;
        }

        .card.border-left-secondary {
            border-left: 0.25rem solid #858796 !important;
        }

        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
        }

        .btn-primary:hover {
            background-color: #2e59ce;
            border-color: #2e59ce;
        }

        .form-control:focus,
        .form-control.focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }

        .text-primary {
            color: #4e73df !important;
        }

        .text-success {
            color: #1cc88a !important;
        }

        .text-danger {
            color: #e74c3c !important;
        }

        .text-warning {
            color: #f39c12 !important;
        }

        .text-info {
            color: #3498db !important;
        }

        .badge {
            padding: 0.35rem 0.65rem;
            font-size: 0.75rem;
            font-weight: 600;
        }

        main {
            overflow-y: auto;
        }

        .opacity-50 {
            opacity: 0.5;
        }
    </style>
</head>
<body>
    @yield('content')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    @yield('scripts')
    @stack('scripts')
</body>
</html>
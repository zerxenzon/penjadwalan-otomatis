<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Penjadwalan Otomatis')</title>
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- Custom CSS -->
    <style>
        /* ===== VARIABLES ===== */
        :root {
            /* Fire theme colors */
            --fire-primary: #ff6600;
            --fire-secondary: #ff8844;
            --fire-dark: #cc4400;
            --fire-light: #ffaa66;
            --fire-glow: rgba(255, 100, 0, 0.4);
            
            /* Status colors */
            --success: #00cc66;
            --danger: #ff3333;
            --warning: #ffaa00;
            --info: #4488ff;
            
            /* Background colors */
            --bg-primary: rgba(20, 10, 5, 0.95);
            --bg-secondary: rgba(30, 15, 10, 0.9);
            --bg-card: rgba(30, 15, 10, 0.85);
            --bg-hover: rgba(255, 100, 0, 0.15);
            
            /* Text colors */
            --text-primary: #ffcc99;
            --text-secondary: #ffaa66;
            --text-muted: #ff8844;
            --text-white: #ffffff;
            
            /* Border colors */
            --border-primary: rgba(255, 100, 0, 0.3);
            --border-secondary: rgba(255, 100, 0, 0.2);
            
            /* Shadows */
            --shadow-sm: 0 2px 8px rgba(255, 69, 0, 0.15);
            --shadow-md: 0 4px 20px rgba(255, 69, 0, 0.25);
            --shadow-lg: 0 6px 30px rgba(255, 69, 0, 0.35);
            --shadow-xl: 0 8px 40px rgba(255, 69, 0, 0.45);
            
            /* Transitions */
            --transition-fast: all 0.15s ease;
            --transition-normal: all 0.3s ease;
            --transition-slow: all 0.5s ease;
            
            /* Spacing */
            --spacing-xs: 0.25rem;
            --spacing-sm: 0.5rem;
            --spacing-md: 1rem;
            --spacing-lg: 1.5rem;
            --spacing-xl: 2rem;
            
            /* Border radius */
            --radius-sm: 0.25rem;
            --radius-md: 0.5rem;
            --radius-lg: 0.75rem;
            --radius-xl: 1rem;
        }

        /* ===== GLOBAL STYLES ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(180deg, #1a0000 0%, #000000 50%, #0d0500 100%);
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            color: var(--text-primary);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(10, 5, 0, 0.5);
            border-radius: var(--radius-md);
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, var(--fire-primary) 0%, var(--fire-dark) 100%);
            border-radius: var(--radius-md);
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, var(--fire-secondary) 0%, var(--fire-primary) 100%);
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            background: linear-gradient(180deg, var(--bg-primary) 0%, rgba(10, 5, 0, 0.98) 100%);
            border-right: 2px solid var(--border-primary);
            min-height: 100vh;
            position: sticky;
            top: 0;
            box-shadow: 4px 0 20px var(--fire-glow);
            backdrop-filter: blur(10px);
        }

        .sidebar-brand {
            padding: var(--spacing-lg);
            border-bottom: 1px solid var(--border-secondary);
            text-align: center;
            background: linear-gradient(135deg, rgba(255, 69, 0, 0.2) 0%, transparent 100%);
        }

        .sidebar-brand img {
            width: 64px;
            height: auto;
            filter: drop-shadow(0 0 15px var(--fire-glow));
            transition: var(--transition-normal);
        }

        .sidebar-brand:hover img {
            transform: scale(1.05) rotate(5deg);
            filter: drop-shadow(0 0 25px var(--fire-glow));
        }

        .sidebar-brand h5 {
            color: var(--fire-primary);
            margin-top: var(--spacing-sm);
            font-weight: 700;
            text-shadow: 0 0 15px var(--fire-glow);
            font-size: clamp(0.9rem, 1.2vw, 1.1rem);
        }

        .sidebar-menu {
            padding: var(--spacing-md);
        }

        .nav-link {
            color: var(--text-secondary);
            padding: 0.85rem 1.25rem;
            transition: var(--transition-normal);
            border-radius: var(--radius-lg);
            margin: var(--spacing-xs) 0;
            display: flex;
            align-items: center;
            gap: var(--spacing-md);
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 0;
            background: linear-gradient(90deg, var(--fire-primary) 0%, transparent 100%);
            transition: var(--transition-normal);
            z-index: -1;
        }

        .nav-link:hover {
            color: var(--fire-primary);
            background: var(--bg-hover);
            transform: translateX(8px);
            box-shadow: var(--shadow-sm);
        }

        .nav-link:hover::before {
            width: 100%;
        }

        .nav-link.active {
            color: var(--text-white);
            background: linear-gradient(135deg, var(--fire-primary) 0%, var(--fire-secondary) 100%);
            box-shadow: var(--shadow-md);
            font-weight: 600;
            border-left: 4px solid #ffaa00;
        }

        .nav-link.active::before {
            width: 100%;
        }

        .nav-link i {
            font-size: 1.15rem;
            min-width: 24px;
            text-align: center;
        }

        /* ===== CARDS ===== */
        .card {
            background: linear-gradient(135deg, var(--bg-card) 0%, var(--bg-secondary) 100%);
            border: 1px solid var(--border-primary);
            border-radius: var(--radius-lg);
            margin-bottom: var(--spacing-lg);
            box-shadow: var(--shadow-md);
            color: var(--text-primary);
            transition: var(--transition-normal);
            overflow: hidden;
        }

        .card:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-2px);
        }

        .card-header {
            background: linear-gradient(135deg, rgba(255, 69, 0, 0.25) 0%, rgba(255, 100, 0, 0.15) 100%);
            border-bottom: 2px solid var(--border-primary);
            color: var(--fire-secondary);
            font-weight: 700;
            padding: var(--spacing-md) var(--spacing-lg);
            backdrop-filter: blur(5px);
        }

        .card-body {
            color: var(--text-primary);
            padding: var(--spacing-lg);
        }

        /* Card border variations */
        .card.border-left-primary {
            border-left: 5px solid var(--fire-primary) !important;
        }

        .card.border-left-success {
            border-left: 5px solid var(--success) !important;
        }

        .card.border-left-warning {
            border-left: 5px solid var(--warning) !important;
        }

        .card.border-left-danger {
            border-left: 5px solid var(--danger) !important;
        }

        .card.border-left-info {
            border-left: 5px solid var(--info) !important;
        }

        .card.border-left-secondary {
            border-left: 5px solid var(--fire-secondary) !important;
        }

        /* ===== BUTTONS ===== */
        .btn {
            padding: 0.65rem 1.5rem;
            border-radius: var(--radius-lg);
            font-weight: 600;
            transition: var(--transition-normal);
            border: none;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--fire-primary) 0%, var(--fire-secondary) 100%);
            color: var(--text-white);
            box-shadow: var(--shadow-sm);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--fire-secondary) 0%, #ffaa00 100%);
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }

        .btn-success {
            background: linear-gradient(135deg, #00aa55 0%, var(--success) 100%);
            color: var(--text-white);
            box-shadow: var(--shadow-sm);
        }

        .btn-success:hover {
            background: linear-gradient(135deg, var(--success) 0%, #00ee77 100%);
            box-shadow: 0 4px 15px rgba(0, 200, 100, 0.4);
            transform: translateY(-2px);
        }

        .btn-danger {
            background: linear-gradient(135deg, #dd2222 0%, var(--danger) 100%);
            color: var(--text-white);
            box-shadow: var(--shadow-sm);
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, var(--danger) 0%, #ff5555 100%);
            box-shadow: 0 4px 15px rgba(255, 50, 50, 0.4);
            transform: translateY(-2px);
        }

        .btn-warning {
            background: linear-gradient(135deg, #ee9900 0%, var(--warning) 100%);
            color: var(--text-white);
            box-shadow: var(--shadow-sm);
        }

        .btn-warning:hover {
            background: linear-gradient(135deg, var(--warning) 0%, #ffcc00 100%);
            box-shadow: 0 4px 15px rgba(255, 170, 0, 0.4);
            transform: translateY(-2px);
        }

        .btn-info {
            background: linear-gradient(135deg, #3377ee 0%, var(--info) 100%);
            color: var(--text-white);
            box-shadow: var(--shadow-sm);
        }

        .btn-info:hover {
            background: linear-gradient(135deg, var(--info) 0%, #66aaff 100%);
            box-shadow: 0 4px 15px rgba(70, 130, 255, 0.4);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #666 0%, #888 100%);
            color: var(--text-white);
            box-shadow: var(--shadow-sm);
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #888 0%, #aaa 100%);
            box-shadow: var(--shadow-sm);
            transform: translateY(-2px);
        }

        /* ===== FORMS ===== */
        .form-label {
            color: var(--text-secondary);
            font-weight: 600;
            margin-bottom: var(--spacing-sm);
        }

        .form-control,
        .form-select {
            background: rgba(30, 15, 10, 0.6);
            border: 1px solid var(--border-primary);
            border-radius: var(--radius-md);
            color: var(--text-primary);
            padding: 0.65rem 1rem;
            transition: var(--transition-normal);
        }

        .form-control:focus,
        .form-select:focus {
            background: rgba(30, 15, 10, 0.9);
            border-color: var(--fire-primary);
            color: var(--text-primary);
            box-shadow: 0 0 15px var(--fire-glow);
            outline: none;
        }

        .form-control::placeholder {
            color: var(--text-muted);
            opacity: 0.6;
        }

        /* ===== TABLES ===== */
        .table {
            color: var(--text-primary);
            border-radius: var(--radius-md);
            overflow: hidden;
        }

        .table thead th {
            background: linear-gradient(135deg, rgba(255, 69, 0, 0.3) 0%, rgba(255, 100, 0, 0.2) 100%);
            border-color: var(--border-primary);
            color: var(--fire-secondary);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            padding: 1rem;
        }

        .table tbody tr {
            background: rgba(30, 15, 10, 0.4);
            border-color: var(--border-secondary);
            transition: var(--transition-normal);
        }

        .table tbody tr:hover {
            background: var(--bg-hover);
            transform: scale(1.01);
            box-shadow: var(--shadow-sm);
        }

        .table tbody td {
            padding: 0.85rem 1rem;
            vertical-align: middle;
        }

        /* ===== BADGES ===== */
        .badge {
            padding: 0.45em 0.85em;
            font-weight: 600;
            border-radius: var(--radius-md);
            font-size: 0.8rem;
            letter-spacing: 0.3px;
        }

        .badge.bg-success {
            background: linear-gradient(135deg, #00aa55 0%, var(--success) 100%) !important;
            box-shadow: 0 2px 8px rgba(0, 200, 100, 0.3);
        }

        .badge.bg-danger {
            background: linear-gradient(135deg, #dd2222 0%, var(--danger) 100%) !important;
            box-shadow: 0 2px 8px rgba(255, 50, 50, 0.3);
        }

        .badge.bg-warning {
            background: linear-gradient(135deg, #ee9900 0%, var(--warning) 100%) !important;
            box-shadow: 0 2px 8px rgba(255, 170, 0, 0.3);
        }

        .badge.bg-primary {
            background: linear-gradient(135deg, var(--fire-primary) 0%, var(--fire-secondary) 100%) !important;
            box-shadow: 0 2px 8px var(--fire-glow);
        }

        .badge.bg-info {
            background: linear-gradient(135deg, #3377ee 0%, var(--info) 100%) !important;
            box-shadow: 0 2px 8px rgba(70, 130, 255, 0.3);
        }

        /* ===== ALERTS ===== */
        .alert {
            border-radius: var(--radius-lg);
            border-width: 2px;
            padding: 1rem 1.25rem;
            backdrop-filter: blur(5px);
        }

        .alert-success {
            background: rgba(0, 200, 100, 0.15);
            border-color: rgba(0, 200, 100, 0.5);
            color: #00ff88;
        }

        .alert-danger {
            background: rgba(255, 50, 50, 0.15);
            border-color: rgba(255, 50, 50, 0.5);
            color: #ff6666;
        }

        .alert-warning {
            background: rgba(255, 170, 0, 0.15);
            border-color: rgba(255, 170, 0, 0.5);
            color: #ffcc66;
        }

        .alert-info {
            background: rgba(70, 130, 255, 0.15);
            border-color: rgba(70, 130, 255, 0.5);
            color: #88bbff;
        }

        /* ===== TEXT UTILITIES ===== */
        .text-primary { color: var(--fire-primary) !important; }
        .text-success { color: var(--success) !important; }
        .text-danger { color: var(--danger) !important; }
        .text-warning { color: var(--warning) !important; }
        .text-info { color: var(--info) !important; }
        .text-muted { color: var(--text-muted) !important; }

        h1, h2, h3, h4, h5, h6 {
            color: var(--fire-secondary);
            font-weight: 700;
            text-shadow: 0 0 10px rgba(255, 100, 0, 0.2);
        }

        /* ===== MAIN CONTENT ===== */
        main {
            overflow-y: auto;
            padding: var(--spacing-xl);
            min-height: 100vh;
        }

        /* ===== ANIMATIONS ===== */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-30px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        .slide-in-left {
            animation: slideInLeft 0.5s ease-out;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .sidebar {
                position: relative;
                min-height: auto;
            }

            main {
                padding: var(--spacing-md);
            }

            .nav-link {
                padding: 0.65rem 1rem;
            }

            .card-body {
                padding: var(--spacing-md);
            }
        }

        /* ===== UTILITIES ===== */
        .opacity-50 { opacity: 0.5; }
        .shadow-sm { box-shadow: var(--shadow-sm); }
        .shadow-md { box-shadow: var(--shadow-md); }
        .shadow-lg { box-shadow: var(--shadow-lg); }
        .shadow-xl { box-shadow: var(--shadow-xl); }
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

    <script>
        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }, 5000);
            });

            // Add fade-in animation to cards
            const cards = document.querySelectorAll('.card');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
                card.classList.add('fade-in');
            });
        });
    </script>

    @yield('scripts')
    @stack('scripts')
</body>
</html>
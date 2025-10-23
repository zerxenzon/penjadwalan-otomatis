@extends('layouts.app')

@push('styles')
<style>
    /* Override default styles - Fire Theme Dashboard */
    body {
        background: linear-gradient(180deg, #1a0000 0%, #000000 50%, #1a0a00 100%) !important;
        color: #ffcc99 !important;
    }
    
    .container-fluid {
        background: transparent !important;
    }
    
    /* Sidebar Fire Theme */
    .sidebar {
        min-height: 100vh !important;
        background: linear-gradient(180deg, rgba(20, 10, 5, 0.95) 0%, rgba(10, 5, 2, 0.98) 100%) !important;
        border-right: 2px solid rgba(255, 100, 0, 0.3) !important;
        box-shadow: 4px 0 20px rgba(255, 69, 0, 0.2) !important;
    }
    
    .sidebar .nav-link {
        color: #ffaa66 !important;
        padding: .7rem 1rem !important;
        border-radius: 8px !important;
        margin: 0 .5rem !important;
        transition: all 0.3s ease !important;
        border: 1px solid transparent !important;
    }
    
    .sidebar .nav-link:hover {
        background: rgba(255, 100, 0, 0.2) !important;
        color: #ff6600 !important;
        border-color: rgba(255, 100, 0, 0.3) !important;
        transform: translateX(5px) !important;
    }
    
    .sidebar .nav-link.active {
        background: linear-gradient(135deg, #ff4500 0%, #ff6600 100%) !important;
        color: white !important;
        border-color: #ff8800 !important;
        box-shadow: 0 4px 15px rgba(255, 69, 0, 0.4) !important;
    }
    
    .sidebar .nav-link i {
        color: #ff8844 !important;
    }
    
    .sidebar .nav-link.active i {
        color: white !important;
    }
    
    .sidebar-heading {
        font-size: .75rem !important;
        font-weight: bold !important;
        color: #ff8844 !important;
        text-transform: uppercase !important;
        letter-spacing: 1px !important;
    }
    
    .nav-section {
        border-top: 1px solid rgba(255, 100, 0, 0.2) !important;
        margin-top: 1rem !important;
        padding-top: .5rem !important;
    }
    
    /* User Info Section */
    .sidebar .text-muted {
        color: #ffaa66 !important;
    }
    
    .sidebar h6 {
        color: #ff8844 !important;
    }
    
    .sidebar .badge {
        background: linear-gradient(135deg, #ff4500 0%, #ff6600 100%) !important;
        color: white !important;
    }
    
    /* Main Content Area */
    main {
        background: transparent !important;
    }
    
    /* Cards Fire Theme */
    .card {
        background: linear-gradient(135deg, rgba(30, 15, 10, 0.9) 0%, rgba(20, 10, 5, 0.95) 100%) !important;
        border: 1px solid rgba(255, 100, 0, 0.3) !important;
        box-shadow: 0 4px 20px rgba(255, 69, 0, 0.2) !important;
        color: #ffcc99 !important;
    }
    
    .card-header {
        background: linear-gradient(135deg, rgba(255, 69, 0, 0.3) 0%, rgba(255, 100, 0, 0.2) 100%) !important;
        border-bottom: 1px solid rgba(255, 100, 0, 0.3) !important;
        color: #ff8844 !important;
        font-weight: 600 !important;
    }
    
    .card-body {
        color: #ffcc99 !important;
    }
    
    .card-title {
        color: #ff8844 !important;
    }
    
    .text-muted {
        color: #ffaa66 !important;
    }
    
    /* Border color variants */
    .border-left-primary {
        border-left: 4px solid #ff4500 !important;
    }
    
    .border-left-success {
        border-left: 4px solid #00cc66 !important;
    }
    
    .border-left-warning {
        border-left: 4px solid #ffaa00 !important;
    }
    
    .border-left-danger {
        border-left: 4px solid #ff3333 !important;
    }
    
    /* Text colors */
    .text-primary {
        color: #ff6600 !important;
    }
    
    .text-success {
        color: #00cc66 !important;
    }
    
    .text-warning {
        color: #ffaa00 !important;
    }
    
    .text-danger {
        color: #ff3333 !important;
    }
    
    .text-info {
        color: #4488ff !important;
    }
    
    /* Headings */
    h1, h2, h3, h4, h5, h6 {
        color: #ff8844 !important;
    }
    
    /* Alerts */
    .alert {
        border-radius: 10px !important;
        border-width: 2px !important;
    }
    
    .alert-success {
        background: rgba(0, 200, 100, 0.15) !important;
        border-color: rgba(0, 200, 100, 0.4) !important;
        color: #00ff88 !important;
    }
    
    .alert-danger {
        background: rgba(255, 50, 50, 0.15) !important;
        border-color: rgba(255, 50, 50, 0.4) !important;
        color: #ff6666 !important;
    }
    
    .alert-warning {
        background: rgba(255, 170, 0, 0.15) !important;
        border-color: rgba(255, 170, 0, 0.4) !important;
        color: #ffcc66 !important;
    }
    
    .alert-info {
        background: rgba(70, 130, 255, 0.15) !important;
        border-color: rgba(70, 130, 255, 0.4) !important;
        color: #88bbff !important;
    }
    
    /* Tables */
    .table {
        color: #ffcc99;
    }
    
    .table thead th {
        background: rgba(255, 100, 0, 0.2);
        color: #ff8844;
        border-color: rgba(255, 100, 0, 0.3);
    }
    
    .table-striped tbody tr:nth-of-type(odd) {
        background: rgba(255, 100, 0, 0.05);
    }
    
    .table-hover tbody tr:hover {
        background: rgba(255, 100, 0, 0.15);
    }
    
    .table td {
        border-color: rgba(255, 100, 0, 0.2);
    }
    
    /* Buttons */
    .btn-primary {
        background: linear-gradient(135deg, #ff4500 0%, #ff6600 100%);
        border: none;
        color: white;
        box-shadow: 0 4px 15px rgba(255, 69, 0, 0.4);
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, #ff6600 0%, #ff8800 100%);
        box-shadow: 0 6px 20px rgba(255, 100, 0, 0.6);
        transform: translateY(-2px);
    }
    
    .btn-success {
        background: linear-gradient(135deg, #00aa55 0%, #00cc66 100%);
        border: none;
        color: white;
    }
    
    .btn-success:hover {
        background: linear-gradient(135deg, #00cc66 0%, #00ee77 100%);
        transform: translateY(-2px);
    }
    
    .btn-warning {
        background: linear-gradient(135deg, #ff8800 0%, #ffaa00 100%);
        border: none;
        color: white;
    }
    
    .btn-danger {
        background: linear-gradient(135deg, #cc0000 0%, #ff3333 100%);
        border: none;
        color: white;
    }
    
    .btn-secondary {
        background: rgba(100, 100, 100, 0.6);
        border: 1px solid rgba(150, 150, 150, 0.4);
        color: #cccccc;
    }
    
    .btn-secondary:hover {
        background: rgba(120, 120, 120, 0.7);
        color: white;
    }
    
    .btn-link {
        color: #ff8844;
    }
    
    .btn-link:hover {
        color: #ff6600;
    }
    
    /* Badges */
    .badge {
        padding: 0.5em 0.8em;
        border-radius: 6px;
        font-weight: 600;
    }
    
    .bg-primary, .badge.bg-primary {
        background: linear-gradient(135deg, #ff4500 0%, #ff6600 100%) !important;
    }
    
    .bg-success, .badge.bg-success {
        background: linear-gradient(135deg, #00aa55 0%, #00cc66 100%) !important;
    }
    
    .bg-warning, .badge.bg-warning {
        background: linear-gradient(135deg, #ff8800 0%, #ffaa00 100%) !important;
    }
    
    .bg-danger, .badge.bg-danger {
        background: linear-gradient(135deg, #cc0000 0%, #ff3333 100%) !important;
    }
    
    .bg-info, .badge.bg-info {
        background: linear-gradient(135deg, #3366ff 0%, #4488ff 100%) !important;
    }
    
    .bg-secondary, .badge.bg-secondary {
        background: rgba(100, 100, 100, 0.6) !important;
    }
    
    /* Forms */
    .form-control, .form-select {
        background: rgba(40, 20, 10, 0.8);
        border: 1px solid rgba(255, 100, 0, 0.3);
        color: #ffcc99;
    }
    
    .form-control:focus, .form-select:focus {
        background: rgba(50, 25, 10, 0.9);
        border-color: #ff6600;
        box-shadow: 0 0 0 3px rgba(255, 100, 0, 0.3);
        color: #ffcc99;
    }
    
    .form-control::placeholder {
        color: #aa7744;
    }
    
    .form-label {
        color: #ffaa66;
        font-weight: 600;
    }
    
    /* Logout Button */
    .text-danger {
        color: #ff6666 !important;
    }
    
    form button[type="submit"].btn-link {
        color: #ff6666 !important;
    }
    
    form button[type="submit"].btn-link:hover {
        color: #ff3333 !important;
        background: rgba(255, 50, 50, 0.1);
    }
    
    /* Scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    
    ::-webkit-scrollbar-track {
        background: rgba(255, 100, 0, 0.1);
    }
    
    ::-webkit-scrollbar-thumb {
        background: rgba(255, 100, 0, 0.4);
        border-radius: 4px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 100, 0, 0.6);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .sidebar {
            border-right: none;
            border-bottom: 2px solid rgba(255, 100, 0, 0.3);
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-2 d-md-block sidebar">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <div class="position-sticky pt-3">
                <!-- User Info -->
                <div class="px-3 mb-4">
                    <h6 class="text-muted text-uppercase">{{ auth()->user()->nama }}</h6>
                    <small class="text-muted">
                        <span class="badge bg-primary">{{ auth()->user()->role->nama }}</span>
                    </small>
                </div>

                <!-- Menu Navigation -->
                <ul class="nav flex-column">
                    <!-- Dashboard -->
                    <li class="nav-item">
                        <a href="{{ route('dashboard.' . auth()->user()->role->nama) }}" 
                           class="nav-link {{ request()->routeIs('dashboard.*') && !request()->is('*/data-master*') ? 'active' : '' }}">
                            <i class="bi bi-house-door me-2"></i>
                            Dashboard
                        </a>
                    </li>

                    <!-- Menu Dekan -->
                    @if(auth()->user()->role->nama === 'dekan')
                        <div class="nav-section">
                            <h6 class="sidebar-heading px-3 mt-2 mb-2">Menu Dekan</h6>
                            
                            <li class="nav-item">
                                <a href="{{ route('surat-tugas.index') }}" 
                                   class="nav-link {{ request()->routeIs('surat-tugas.*') ? 'active' : '' }}">
                                    <i class="bi bi-file-text me-2"></i>
                                    Surat Tugas
                                </a>
                            </li>
                        </div>
                    @endif

                    <!-- Menu Kaprodi -->
                    @if(in_array(auth()->user()->role->nama, ['kaprodi', 'dekan']))
                        <div class="nav-section">
                            <h6 class="sidebar-heading px-3 mt-2 mb-2">Menu Kaprodi</h6>
                            
                            <li class="nav-item">
                                <a href="/mata-kuliah" 
                                   class="nav-link {{ request()->is('mata-kuliah*') ? 'active' : '' }}">
                                    <i class="bi bi-book me-2"></i>
                                    Mata Kuliah
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="/kelas" 
                                   class="nav-link {{ request()->is('kelas*') ? 'active' : '' }}">
                                    <i class="bi bi-people me-2"></i>
                                    Kelas
                                </a>
                            </li>
                        </div>
                    @endif

                    <!-- Menu Dosen -->
                    @if(in_array(auth()->user()->role->nama, ['dosen', 'kaprodi', 'dekan']))
                        <div class="nav-section">
                            <h6 class="sidebar-heading px-3 mt-2 mb-2">Menu Dosen</h6>
                            
                            <li class="nav-item">
                                <a href="/charter-jadwal" 
                                   class="nav-link {{ request()->is('charter-jadwal*') ? 'active' : '' }}">
                                    <i class="bi bi-calendar-plus me-2"></i>
                                    Charter Jadwal
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="/barter-jadwal" 
                                   class="nav-link {{ request()->is('barter-jadwal*') ? 'active' : '' }}">
                                    <i class="bi bi-arrow-left-right me-2"></i>
                                    Barter Jadwal
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('pindah-jadwal.dosen-index') }}" 
                                   class="nav-link {{ request()->routeIs('pindah-jadwal.dosen-index') || request()->routeIs('pindah-jadwal.create') ? 'active' : '' }}">
                                    <i class="bi bi-clock-history me-2"></i>
                                    Pindah Jadwal
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="/jadwal" 
                                   class="nav-link {{ request()->is('jadwal*') && !request()->routeIs('pindah-jadwal.*') ? 'active' : '' }}">
                                    <i class="bi bi-calendar-week me-2"></i>
                                    Jadwal Mengajar
                                </a>
                            </li>
                        </div>
                    @endif

                    <!-- Menu Kosma -->
                    @if(auth()->user()->role->nama === 'kosma')
                        <div class="nav-section">
                            <h6 class="sidebar-heading px-3 mt-2 mb-2">Menu Kosma</h6>
                            
                            <li class="nav-item">
                                <a href="{{ route('pindah-jadwal.index') }}" 
                                   class="nav-link {{ request()->routeIs('pindah-jadwal.*') ? 'active' : '' }}">
                                    <i class="bi bi-clock-history me-2"></i>
                                    Permintaan Pindah Jadwal
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('kosma.jadwal-kelas') }}" 
                                   class="nav-link {{ request()->routeIs('kosma.jadwal-kelas') ? 'active' : '' }}">
                                    <i class="bi bi-calendar3 me-2"></i>
                                    Jadwal Kelas
                                </a>
                            </li>
                        </div>
                    @endif

                    <!-- Menu Mahasiswa -->
                    @if(auth()->user()->role->nama === 'mahasiswa')
                        <div class="nav-section">
                            <h6 class="sidebar-heading px-3 mt-2 mb-2">Menu Mahasiswa</h6>
                            
                            <li class="nav-item">
                                <a href="{{ route('dashboard.mahasiswa') }}" 
                                   class="nav-link {{ request()->routeIs('dashboard.mahasiswa') ? 'active' : '' }}">
                                    <i class="bi bi-calendar-week me-2"></i>
                                    Jadwal Kuliah
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('mahasiswa.jadwal.export-pdf') }}" 
                                   class="nav-link" target="_blank">
                                    <i class="bi bi-file-earmark-pdf me-2"></i>
                                    Export PDF
                                </a>
                            </li>
                        </div>
                    @endif

                    <!-- Menu Sekprodi -->
                    @if(auth()->user()->role->nama === 'sekprodi')
                        <div class="nav-section">
                            <h6 class="sidebar-heading px-3 mt-2 mb-2">Menu Sekprodi</h6>
                            
                            <li class="nav-item">
                                <a href="/mata-kuliah" 
                                   class="nav-link {{ request()->is('mata-kuliah*') ? 'active' : '' }}">
                                    <i class="bi bi-book me-2"></i>
                                    Mata Kuliah
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="/kelas" 
                                   class="nav-link {{ request()->is('kelas*') ? 'active' : '' }}">
                                    <i class="bi bi-people me-2"></i>
                                    Kelas
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="/ruangan" 
                                   class="nav-link {{ request()->is('ruangan*') ? 'active' : '' }}">
                                    <i class="bi bi-building me-2"></i>
                                    Ruangan
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="/surat-tugas" 
                                   class="nav-link {{ request()->is('surat-tugas*') ? 'active' : '' }}">
                                    <i class="bi bi-file-text me-2"></i>
                                    Surat Tugas Mengajar
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="/jadwal" 
                                   class="nav-link {{ request()->is('jadwal*') ? 'active' : '' }}">
                                    <i class="bi bi-calendar-week me-2"></i>
                                    Jadwal Kuliah
                                </a>
                            </li>
                        </div>
                    @endif
                </ul>

                <hr>

                <!-- Logout -->
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-link nav-link text-danger w-100 text-start">
                        <i class="bi bi-box-arrow-right me-2"></i>
                        Logout
                    </button>
                </form>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="col-md-10 ms-sm-auto px-md-4">
            <!-- Alert Messages -->
            @if ($message = Session::get('sukses'))
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    <strong>Sukses!</strong> {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                    <strong>Error!</strong> {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Content Section -->
            <section class="py-4">
                @yield('dashboard-content')
            </section>
        </main>
    </div>
</div>
@endsection
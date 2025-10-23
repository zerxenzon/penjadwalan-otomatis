@extends('layouts.app')

@push('styles')
<style>
    /* Sidebar Styling */
    .sidebar {
        min-height: 100vh;
        box-shadow: 0 0 10px rgba(0,0,0,.1);
    }
    
    .sidebar .nav-link {
        color: #333;
        padding: .7rem 1rem;
        border-radius: 5px;
        margin: 0 .5rem;
    }
    
    .sidebar .nav-link:hover {
        background-color: rgba(13, 110, 253, .1);
        color: #0d6efd;
    }
    
    .sidebar .nav-link.active {
        background-color: #0d6efd;
        color: white;
    }
    
    .sidebar-heading {
        font-size: .75rem;
        font-weight: bold;
    }
    
    .nav-section {
        border-top: 1px solid #eee;
        margin-top: 1rem;
        padding-top: .5rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-2 d-md-block bg-light sidebar">
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
                                <a href="{{ route('mahasiswa.jadwal.pdf') }}" 
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
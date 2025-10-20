@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-2 d-md-block bg-light sidebar">
            <div class="position-sticky pt-3">
                <!-- User Info -->
                <div class="px-3 mb-4">
                    <h6 class="text-muted text-uppercase">{{ auth()->user()->nama }}</h6>
                    <small class="text-muted">
                        <span class="badge bg-primary">{{ auth()->user()->role->nama }}</span>
                    </small>
                </div>

                <hr>

                <!-- Menu Navigation -->
                <ul class="nav flex-column">
                    <!-- Dekan Menu -->
                    @if (auth()->user()->role->nama === 'dekan')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard.dekan') }}">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                    @endif

                    <!-- Kaprodi Menu -->
                    @if (auth()->user()->role->nama === 'kaprodi' || auth()->user()->role->nama === 'dekan')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard.kaprodi') }}">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                    @endif

                    <!-- Dosen Menu -->
                    @if (in_array(auth()->user()->role->nama, ['dosen', 'kaprodi', 'dekan']))
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard.dosen') ? 'active' : '' }}" 
                               href="{{ route('dashboard.dosen') }}">
                                <i class="bi bi-speedometer2"></i> Dashboard Dosen
                            </a>
                        </li>
                        
                        <!-- Surat Tugas Menu -->
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('surat-tugas.*') ? 'active' : '' }}" 
                               href="{{ route('surat-tugas.index') }}">
                                <i class="bi bi-file-text"></i> Surat Tugas
                            </a>
                        </li>
                    @endif

                    <!-- KOSMA Menu -->
                    @if (auth()->user()->role->nama === 'kosma')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard.kosma') }}">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                    @endif

                    <!-- Mahasiswa Menu -->
                    @if (auth()->user()->role->nama === 'mahasiswa')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard.mahasiswa') }}">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                    @endif

                    <!-- Sekprodi Menu -->
                    @if (auth()->user()->role->nama === 'sekprodi')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard.sekprodi') }}">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                    @endif
                </ul>

                <hr>

                <!-- Logout -->
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-link nav-link text-danger">
                        <i class="bi bi-box-arrow-right"></i> Logout
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

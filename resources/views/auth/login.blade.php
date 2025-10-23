@extends('layouts.app')

@section('title', 'Login - Sistem Penjadwalan Otomatis')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
    :root {
        --primary-color: #4a55e1;
        --secondary-color: #6c5ce7;
        --background-color: #f4f6f9; /* Latar belakang lebih netral */
        --card-bg: #ffffff;
        --text-color: #1a202c;
        --shadow-soft: 0 4px 10px rgba(0, 0, 0, 0.08); /* Bayangan lebih lembut */
    }

    body {
        background-color: var(--background-color);
        background-image: linear-gradient(135deg, #799afc 0%, #4a55e1 100%); /* Gradien yang lebih kalem */
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
    }

    .logo-img {
        width: 80px; /* Ukuran logo lebih kecil */
        height: auto;
        margin-bottom: 1rem;
        transition: none; /* Hilangkan animasi pada logo */
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.05));
    }

    .card {
        background: var(--card-bg);
        border: none;
        border-radius: 12px; /* Sudut lebih kecil */
        box-shadow: var(--shadow-soft);
        transition: box-shadow 0.3s ease;
    }

    .card-body h2 {
        color: var(--primary-color);
        font-weight: 600; /* Font lebih tipis */
        font-size: 1.5rem; /* Ukuran judul lebih kecil */
        margin-bottom: 1.5rem;
    }

    /* Input Styling */
    .input-wrapper {
        position: relative;
        margin-bottom: 1rem;
    }

    .password-wrapper {
        position: relative;
    }

    .password-toggle {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        border: none;
        background: none;
        cursor: pointer;
        padding: 5px 10px;
        color: #6B7280;
        z-index: 10;
        font-size: 1rem;
        transition: color 0.2s ease;
    }

    .password-toggle:hover {
        color: var(--primary-color);
    }

    .password-toggle:focus {
        outline: none;
    }

    .password-toggle i {
        pointer-events: none;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 2.25rem 0.75rem 1rem;
        border: 1px solid #E5E7EB;
        border-radius: 0.5rem;
        font-size: 1rem;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(74, 85, 225, 0.2);
    }

    .form-label {
        font-weight: 500; /* Font label lebih tipis */
        margin-bottom: 0.4rem;
        font-size: 0.9rem;
    }

    /* Button Styling */
    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        border: none;
        padding: 0.65rem 1.2rem; /* Padding tombol lebih kecil */
        font-weight: 600;
        border-radius: 8px;
        transition: background 0.3s ease;
        box-shadow: 0 2px 6px rgba(74, 85, 225, 0.2); /* Bayangan tombol lebih ringan */
    }

    .btn-primary:hover {
        opacity: 0.95;
        /* HILANGKAN: transform: translateY(-2px); */
        box-shadow: 0 4px 10px rgba(74, 85, 225, 0.3); /* Bayangan hover lebih halus */
    }

    /* Info Demo */
    .alert-info {
        font-size: 0.85rem;
        padding: 0.8rem 1rem;
    }
</style>

    <div class="container min-vh-100 d-flex align-items-center justify-content-center">
        <div class="col-md-5 col-lg-4"> 
            <div class="card shadow-lg">
                <div class="card-body p-4"> <div class="text-center mb-4">
                        <img src="{{ asset('logo.png') }}" alt="Logo" class="logo-img">
                    </div>

                    <form method="POST" action="{{ route('login.proses') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <div class="input-wrapper">
                                <input 
                                    type="text" 
                                    class="form-control @error('username') is-invalid @enderror"
                                    id="username" 
                                    name="username" 
                                    value="{{ old('username') }}"
                                    required
                                    autocomplete="username"
                                >
                            </div>
                            @error('username')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password input field -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="password-wrapper">
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       required>
                                <button type="button" class="password-toggle" id="togglePassword">
                                    <i class="fa-solid fa-eye" id="eyeIcon"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="text-end mb-4">
                            <small>
                                Lupa password? <a href="#" class="forgot-password" id="contactAdmin">Hubungi admin</a>
                            </small>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary fw-semibold">
                                <i class="fa-solid fa-sign-in-alt me-2"></i> Login
                            </button>
                        </div>
                    </form>
                    
                    <hr class="my-4">
                    <div class="alert alert-info" role="alert">
                        <p class="mb-1 fw-bold">
                            <i class="fa-solid fa-info-circle me-1"></i> Akun Demo:
                        </p>
                        <small class="d-block">
                            <strong class="d-inline-block" style="width: 80px;">Dekan:</strong> dekan123 / dekan123<br>
                            <strong class="d-inline-block" style="width: 80px;">Kaprodi:</strong> kaprodi123 / kaprodi123<br>
                            <strong class="d-inline-block" style="width: 80px;">Dosen:</strong> dosen123 / dosen123<br>
                            <strong class="d-inline-block" style="width: 80px;">Dosen2:</strong> dosen1234 / dosen1234<br>
                            <strong class="d-inline-block" style="width: 80px;">Dosen2:</strong> dosen12345 / dosen12345<br>
                            <strong class="d-inline-block" style="width: 80px;">KOSMA:</strong> kosma123 / kosma123<br>
                            <strong class="d-inline-block" style="width: 80px;">Mahasiswa:</strong> mahasiswa123 / mahasiswa123 <br>
                            <strong class="d-inline-block" style="width: 80px;">Sekprodi:</strong> sekprodi123 / sekprodi123
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        const contactAdmin = document.getElementById('contactAdmin');

        // Toggle password visibility
        if (togglePassword && passwordInput && eyeIcon) {
            togglePassword.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Toggle type
                const type = passwordInput.type === 'password' ? 'text' : 'password';
                passwordInput.type = type;
                
                // Toggle icon
                if (type === 'password') {
                    eyeIcon.classList.remove('fa-eye-slash');
                    eyeIcon.classList.add('fa-eye');
                } else {
                    eyeIcon.classList.remove('fa-eye');
                    eyeIcon.classList.add('fa-eye-slash');
                }
            });
        }

        // Fungsionalitas Contact Admin Alert
        if (contactAdmin) {
            contactAdmin.addEventListener('click', function(e) {
                e.preventDefault();
                alert('Silakan hubungi admin melalui:\n\n📧 Email: muhammadnurjaman50@gmail.com\n📱 WhatsApp: 081224625130\n\nAtau kunjungi ruangan admin di Garut');
            });
        }
    });
    </script>
    @endpush

@endsection
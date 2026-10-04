<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Portal - MUSEUM WASAKA</title>
    
    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Fonts: Menggunakan Google Fonts yang Elegan -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&family=Playfair+Display:ital,wght@0,600;0,700;1,500&display=swap" rel="stylesheet">

    <style>
        :root {
            --gold: #c5a059;
            --dark-bg: #111111;
            --dark-surface: #1a1a1a;
        }

        body {
            background-color: #f8f9fa; /* Background halaman tetap terang agar data jelas terbaca */
            font-family: 'Montserrat', sans-serif; 
            color: #333333;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        h1, h2, h3, h4, h5, .navbar-brand {
            font-family: 'Playfair Display', serif; 
        }

        /* --- NAVBAR ELEGANT --- */
        .navbar-museum {
            background-color: var(--dark-bg);
            border-bottom: 3px solid var(--gold);
        }
        
        .nav-link {
            color: rgba(255,255,255,0.7) !important;
            transition: 0.3s;
        }
        .nav-link:hover, .nav-link.active {
            color: var(--gold) !important;
        }

        /* --- TOMBOL & CARD --- */
        .btn-gold {
            background-color: var(--gold);
            color: #111;
            border: none;
        }
        .btn-gold:hover {
            background-color: #d4b26f;
            color: #000;
        }

        .card-museum {
            border: none;
            border-top: 4px solid var(--dark-bg);
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        main { flex: 1; }

        footer { background: #fff; }
    </style>
    @stack('styles')
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-museum shadow-sm py-3">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4" href="{{ auth()->check() ? '/dashboard' : '/' }}" style="color: var(--gold);">
                <i class="bi bi-bank me-2"></i>MUSEUM WASAKA
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    @auth
                        <li class="nav-item me-3">
                            <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="/dashboard">Dashboard</a>
                        </li>
                        @if(auth()->user()->role == 'admin')
                            <li class="nav-item me-3">
                                <a class="nav-link {{ request()->is('koleksi') ? 'active' : '' }}" href="/koleksi">Koleksi</a>
                            </li>
                            <li class="nav-item me-3">
                                <a class="nav-link {{ request()->is('kegiatan') ? 'active' : '' }}" href="/kegiatan">Kegiatan</a>
                            </li>
                        @endif
                        <li class="nav-item me-3">
                            <a class="nav-link {{ request()->is('kelola-pengunjung') ? 'active' : '' }}" href="/kelola-pengunjung">Pengunjung</a>
                        </li>
                        <li class="nav-item me-4">
                            <a class="nav-link {{ request()->is('laporan-internal') ? 'active' : '' }}" href="{{ route('laporan.internal') }}">Laporan Kendala</a>
                        </li>
                        
                        {{-- User Info --}}
                        <li class="nav-item me-3 d-none d-lg-block border-start ps-3" style="border-color: rgba(255,255,255,0.2) !important;">
                            <span class="small text-white-50">User:</span><br>
                            <span class="fw-bold" style="color: var(--gold);">{{ auth()->user()->name }}</span>
                        </li>

                        {{-- Logout --}}
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-light btn-sm px-3 rounded-pill">Keluar</button>
                            </form>
                        </li>
                    @endauth

                    @guest
                        <li class="nav-item text-white-50 small">
                            <i class="bi bi-lock-fill me-1"></i> Portal Admin & Petugas
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="container mt-5 pb-5">
        @yield('content')
    </main>

    <footer class="text-center py-3 mt-auto border-top small text-muted">
        <div class="container">&copy; {{ date('Y') }} Museum Wasaka. All Rights Reserved.</div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
@extends('layouts.app')

@section('content')
<!-- Tambahan CSS Khusus Halaman Login -->
<style>
    /* =========================================================
       EFEK BACKGROUND BATIK FADING & TEMA EKSKLUSIF (TERANG)
       ========================================================= */
    body {
        background-color: #f8f9fa;
        background-image: 
            linear-gradient(to bottom, rgba(248, 249, 250, 0.3) 0%, rgba(248, 249, 250, 0.95) 50%, #f8f9fa 100%),
            url('/images/batik%20white4.jpg');
        background-repeat: repeat;
        background-position: top center;
        background-size: 500px;
        background-attachment: fixed;
        color: #333333;
        font-family: 'Montserrat', sans-serif; /* Disamakan dengan font dashboard */
    }
    .login-wrapper {
        min-height: 85vh;
    }
    .brand-title {
        font-family: 'Playfair Display', serif; /* Font serif untuk kesan klasik/museum */
        color: #111111; 
        letter-spacing: 2px;
    }
    .text-gold {
        color: #c5a059;
    }
    .card-login {
        background: rgba(255, 255, 255, 0.97);
        backdrop-filter: blur(5px);
        border: none;
        border-top: 4px solid #111111; /* Aksen hitam tegas selaras dengan dashboard */
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    }
    .form-control-custom {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        color: #333333;
    }
    .form-control-custom:focus {
        background-color: #ffffff;
        border-color: #c5a059;
        color: #111111;
        box-shadow: 0 0 0 0.2rem rgba(197, 160, 89, 0.25);
    }
    .btn-gold {
        background-color: #c5a059;
        color: #111111;
        border: none;
        transition: all 0.3s ease;
    }
    .btn-gold:hover {
        background-color: #d4b26f;
        color: #000000;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(197, 160, 89, 0.2);
    }
</style>

<div class="row justify-content-center align-items-center login-wrapper">
    <div class="col-md-5 col-lg-4">
        
        <div class="text-center mb-4">
            <h2 class="fw-bold brand-title mb-2">MUSEUM <span class="text-gold">WASAKA</span></h2>
            <p class="text-muted" style="font-size: 0.9rem;">Sistem Manajemen Informasi & Operasional</p>
        </div>

        <div class="card card-login">
            <div class="card-body p-4 p-md-5">
                
                <h5 class="fw-bold mb-4 text-center" style="color: #111111; font-family: 'Playfair Display', serif;">Otorisasi Sistem</h5>
                
                <!-- PERHATIKAN: Saya mempertahankan id="loginForm" di sini -->
                <form id="loginForm">
                    
                    <div class="mb-3">
                        <label for="email" class="form-label text-muted small text-uppercase fw-bold">Email / Username</label>
                        <input type="email" class="form-control form-control-lg form-control-custom" id="email" placeholder="Masukkan email..." required>
                    </div>
                    
                    <div class="mb-4">
                        <label for="password" class="form-label text-muted small text-uppercase fw-bold">Password</label>
                        <input type="password" class="form-control form-control-lg form-control-custom" id="password" placeholder="Masukkan password..." required>
                    </div>
                    
                    <div class="d-grid mt-5">
                        <!-- PERHATIKAN: Saya mempertahankan id="btnSubmit" -->
                        <button type="submit" id="btnSubmit" class="btn btn-gold btn-lg fw-bold">MASUK SISTEM</button>
                    </div>

                </form>

            </div>
        </div>
        
        <div class="text-center mt-5 text-muted" style="font-size: 0.8rem; letter-spacing: 1px;">
            &copy; {{ date('Y') }} PEMBANGUNAN PROJECT TUGAS AKHIR<br>
            <span class="text-gold fw-bold">WAJA SAMPAI KAPUTING</span>
        </div>

    </div>
</div>

<!-- ========================================== -->
<!-- SCRIPT JAVASCRIPT UNTUK INTEGRASI API      -->
<!-- ========================================== -->
<script>
    document.getElementById('loginForm').addEventListener('submit', async function(e) {
        e.preventDefault(); // Mencegah halaman refresh bawaan browser

        // 1. Ambil nilai yang diketik user
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const btnSubmit = document.getElementById('btnSubmit');

        // Ubah tombol jadi "Loading"
        btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...';
        btnSubmit.disabled = true;

        try {
            // 2. Kirim data ke API Backend (URL /api/login)
            const response = await fetch('/api/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    email: email,
                    password: password
                })
            });

            // 3. Baca respon dari API
            const result = await response.json();

            if (response.ok) {
                localStorage.setItem('token', result.token || result.data.token);
                localStorage.setItem('role', result.role);
                localStorage.setItem('name', result.data.name);
                
                window.location.href = '/dashboard';
            } else {
                // JIKA GAGAL
                alert('Login Gagal: ' + (result.message || 'Periksa kembali email dan password Anda.'));
                btnSubmit.innerHTML = 'MASUK SISTEM';
                btnSubmit.disabled = false;
            }

        } catch (error) {
            alert('Terjadi kesalahan pada server. Pastikan server API menyala.');
            btnSubmit.innerHTML = 'MASUK SISTEM';
            btnSubmit.disabled = false;
        }
    });
</script>
@endsection
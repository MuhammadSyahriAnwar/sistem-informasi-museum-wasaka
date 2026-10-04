<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Museum Wasaka</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons (Untuk Ikon di Tombol Surat) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        /* Menggunakan background gambar dengan lapisan (overlay) gelap transparan */
        body {
            /* Pastikan gambar bjm.png/jpg ada di folder public/images/ */
            background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url("{{ asset('images/bjm.png') }}");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            font-family: sans-serif;
            color: #f4f4f4;
            min-height: 100vh;
        }
        
        .navbar-custom {
            background-color: transparent;
        }

        /* Desain Glassmorphism (Efek Kaca) untuk membungkus Profil */
        .profile-card {
            background: rgba(20, 20, 20, 0.5); /* Warna dasar semi-transparan */
            backdrop-filter: blur(10px); /* Efek kaca buram */
            -webkit-backdrop-filter: blur(10px);
            padding: 40px 30px;
            border-radius: 20px;
            border: 1px solid rgba(197, 160, 89, 0.3); /* Garis tepi tipis warna emas */
            max-width: 350px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .profile-card:hover {
            transform: translateY(-10px); /* Efek melayang saat di-hover */
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.5);
        }

        /* Styling Foto Profil */
        .profile-card img {
            width: 180px; 
            height: 180px; 
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #c5a059; /* Bingkai Emas */
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
            filter: grayscale(100%);
            transition: transform 0.5s ease, filter 0.5s ease;
            margin-bottom: 20px;
        }

        .profile-card img:hover { 
            filter: grayscale(0%);
            transform: scale(1.05);
        }

        /* Styling Hover untuk Tombol Legalitas */
        .legality-section button:hover {
            background-color: #c5a059 !important;
            color: #1a1a1a !important;
            box-shadow: 0 0 15px rgba(197, 160, 89, 0.5);
        }
    </style>
</head>
<body>

    <!-- NAVBAR HEADER -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom pt-4">
        <div class="container border-bottom border-secondary pb-3">
            <a class="navbar-brand fw-bold fs-4" style="letter-spacing: 3px; color: #fff;" href="/">MUSEUM WASAKA</a>
            
            <div class="d-flex gap-4 align-items-center">
                <a href="/" class="text-white text-decoration-none small" style="letter-spacing: 1px;">BERANDA</a>
                <a href="/login" class="text-white text-decoration-none small" style="letter-spacing: 1px;">LOGIN</a>
            </div>
        </div>
    </nav>

    <!-- KONTEN ABOUT US -->
    <section class="about-us-container" style="padding: 60px 20px; text-align: center;">
        
        <!-- Judul Halaman -->
        <h1 style="font-family: 'Playfair Display', serif; font-size: 3.5rem; color: #c5a059; margin-bottom: 15px; text-shadow: 2px 2px 4px rgba(0,0,0,0.7);">
            ARSITEK DIGITAL
        </h1>
        
        <!-- Teks Pengantar -->
        <p style="font-style: italic; max-width: 750px; margin: 0 auto 50px auto; color: #e0e0e0; line-height: 1.8; text-shadow: 1px 1px 3px rgba(0,0,0,0.8);">
            "Menyatukan jejak sejarah dengan inovasi masa depan. Sistem Informasi Museum Wasaka ini didesain secara khusus untuk mendigitalisasi nilai-nilai perjuangan, menghadirkan akses publik yang inklusif, dan menciptakan pengalaman eksplorasi tanpa batas ruang dan waktu."
        </p>

        <!-- Grid Profil Pengembang -->
        <div class="team-grid" style="display: flex; justify-content: center; gap: 40px; flex-wrap: wrap;">
            
            <!-- Profil Syahri -->
            <div class="profile-card">
                <img src="{{ asset('images/syahri.jpeg') }}" alt="Muhammad Syahri Anwar">
                <h5 style="font-weight: bold; letter-spacing: 1px; color: #fff;">MUHAMMAD SYAHRI ANWAR</h5>
                <p style="font-size: 0.95rem; color: #c5a059; font-weight: bold; margin-bottom: 10px;">NIM: C030323144</p>
                <p style="font-size: 0.85rem; color: #ddd; margin-bottom: 20px;">Frontend, Backend, Database & UI/UX</p>
                <p style="font-style: italic; color: #bbb; margin-bottom: 20px;">"Tuntaskan apa yang sudah dituai tanpa keluhan."</p>
                <a href="https://instagram.com/_syahre" target="_blank" style="color: #c5a059; text-decoration: none; font-weight: bold;">@_syahre</a>
            </div>

            <!-- Profil Rifqi -->
            <div class="profile-card">
                <img src="{{ asset('images/rifqi.jpeg') }}" alt="Muhammad Rifqi Ihsani">
                <h5 style="font-weight: bold; letter-spacing: 1px; color: #fff;">MUHAMMAD RIFQI IHSANI</h5>
                <p style="font-size: 0.95rem; color: #c5a059; font-weight: bold; margin-bottom: 10px;">NIM: C030323143</p>
                <p style="font-size: 0.85rem; color: #ddd; margin-bottom: 20px;">Backend & Technical Documentation</p>
                <p style="font-style: italic; color: #bbb; margin-bottom: 20px;">"Carilah peluang usaha walau kamu tidak menyukainya."</p>
                <a href="https://instagram.com/rfqiihsni_" target="_blank" style="color: #c5a059; text-decoration: none; font-weight: bold;">@rfqiihsni_</a>
            </div>

        </div>

        <!-- ========================================== -->
        <!-- SEKSI LEGALITAS & SURAT RESMI              -->
        <!-- ========================================== -->
        <div class="legality-section" style="margin-top: 80px; text-align: center;">
            <h4 style="font-family: 'Playfair Display', serif; color: #c5a059; letter-spacing: 2px;">DUKUNGAN INSTANSI & LEGALITAS</h4>
            <p style="color: #e0e0e0; max-width: 600px; margin: 10px auto 25px auto; font-size: 0.9rem; text-shadow: 1px 1px 3px rgba(0,0,0,0.8);">
                Seluruh data koleksi artefak dan informasi pameran yang disajikan dalam sistem ini telah melalui proses kurasi dan mendapatkan izin publikasi resmi dari pihak pengelola Museum Wasaka Kota Banjarmasin.
            </p>
            
            <!-- Tombol untuk memunculkan Modal Surat -->
            <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#suratModal" style="background-color: transparent; border: 2px solid #c5a059; color: #c5a059; padding: 10px 30px; font-weight: bold; border-radius: 30px; transition: 0.3s;">
                <i class="bi bi-file-earmark-text me-2"></i> Lihat Surat Izin Resmi
            </button>
        </div>

    </section>

    <!-- ========================================== -->
    <!-- MODAL POP-UP UNTUK SURAT RESMI             -->
    <!-- ========================================== -->
    <div class="modal fade" id="suratModal" tabindex="-1" aria-labelledby="suratModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="background-color: #1a1a1a; border: 1px solid #c5a059; border-radius: 15px;">
                <div class="modal-header" style="border-bottom: 1px solid rgba(197, 160, 89, 0.3);">
                    <h5 class="modal-title" id="suratModalLabel" style="color: #c5a059; font-weight: bold;">Surat Izin Pengambilan Data</h5>
                    <!-- Tombol Close (X) warna putih agar terlihat di background gelap -->
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center" style="padding: 30px;">
                    <!-- Pastikan file scan surat resmi bernama surat-resmi.jpg dan berada di folder public/images/ -->
                    <img src="{{ asset('images/surat resmi.png') }}" alt="Surat Izin Resmi Museum Wasaka" style="max-width: 100%; height: auto; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.5);">
                </div>
                <div class="modal-footer" style="border-top: none; justify-content: center;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 20px; padding: 8px 25px;">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (Wajib agar Modal bisa muncul dan ditutup) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
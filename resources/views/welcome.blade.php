<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Museum Wasaka | Waja Sampai Kaputing</title>
    
    <!-- CSS Dependencies -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;1,600&family=Plus+Jakarta+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        /* =================================================== */
        /* 1. PENGATURAN UMUM & SCROLLBAR                      */
        /* =================================================== */
        ::-webkit-scrollbar { width: 10px; }
        ::-webkit-scrollbar-track { background: #fcfcfc; }
        ::-webkit-scrollbar-thumb { background: #C5A059; border-radius: 10px; border: 2px solid #fcfcfc; }
        ::-webkit-scrollbar-thumb:hover { background: #7A1C1C; }

        html, body {
            max-width: 100%;
            overflow-x: hidden; 
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #fcfcfc;
        }

        h1, h2, h3, h4, h5, .navbar-brand { 
            font-family: 'Playfair Display', serif; 
        }

        /* =================================================== */
        /* 2. NAVBAR                                           */
        /* =================================================== */
        .navbar-custom { 
            position: absolute; 
            top: 0; 
            width: 100%; 
            z-index: 10; 
            background: transparent; 
        }

        /* =================================================== */
        /* 3. HERO SECTION (SPLIT SCREEN)                      */
        /* =================================================== */
        .hero-banjar {
            position: relative;
            width: 100%;
            min-height: 100vh;
            display: flex;
            align-items: center;
            background-color: #1a1a1a; 
            overflow: hidden;
        }

        .hero-banjar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 60%; 
            height: 100%;
            background: linear-gradient(to right, rgba(26,26,26,0.3) 0%, rgba(26,26,26,1) 90%), url('{{ asset('images/batik.jpg') }}');
            background-size: cover;
            background-position: left center;
            z-index: 1;
            opacity: 0.45; 
        }

        .hero-banjar::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 50%;
            height: 100%;
            background: linear-gradient(to right, #1a1a1a 0%, rgba(26,26,26,0.1) 100%), url('{{ asset('images/preview-museum.jpg') }}');
            background-size: cover;
            background-position: center;
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2; 
        }

        /* =================================================== */
        /* EFEK BACKGROUND BATIK TERANG (UNTUK FOOTER & MAPS)  */
        /* =================================================== */
        .bg-white-batik {
            background-image: 
                linear-gradient(to bottom, rgba(255, 255, 255, 0.94), rgba(255, 255, 255, 0.98)),
                url('{{ asset('images/batik.jpg') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed; /* Menambahkan efek parallax halus saat di-scroll */
        }

        /* =================================================== */
        /* TOMBOL MENU KOTAK (QUICK ACCESS)                    */
        /* =================================================== */
        .btn-quick-access {
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(197, 160, 89, 0.3);
            color: #fff;
            transition: all 0.3s ease;
            border-radius: 12px;
            display: block;
            text-decoration: none;
            backdrop-filter: blur(2px);
            -webkit-backdrop-filter: blur(2px);
        }
        
        .btn-quick-access:hover {
            background-color: #C5A059;
            color: #1a1a1a !important;
            transform: translateY(-5px);
            border-color: #C5A059;
            box-shadow: 0 10px 20px rgba(197, 160, 89, 0.2);
        }
        
        .btn-quick-access:hover i {
            color: #1a1a1a !important;
        }

        @media (max-width: 991px) {
            .hero-banjar::before {
                width: 100%;
                background: linear-gradient(to bottom, rgba(26,26,26,0.4) 0%, rgba(26,26,26,1) 100%), url('{{ asset('images/batik.jpg') }}');
                opacity: 0.3;
            }
            .hero-banjar::after {
                width: 100%;
                opacity: 0.3; 
            }
            .hero-banjar {
                padding-top: 80px;
                padding-bottom: 40px;
            }
        }

        /* =================================================== */
        /* 4. TOMBOL MELAYANG (MUSIK & BACK TO TOP)            */
        /* =================================================== */
        #btnBackToTop {
            position: fixed; 
            bottom: 30px; 
            right: 30px; 
            z-index: 999; 
            display: none;
            background-color: #2c2c2c; 
            color: #C5A059; 
            width: 50px; 
            height: 50px;
            border-radius: 50%; 
            border: 2px solid #C5A059; 
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        #btnBackToTop:hover { 
            background-color: #C5A059; 
            transform: scale(1.1); 
            color: #1a1a1a; 
        }

        #btnMusicToggle {
            position: fixed;
            bottom: 30px;
            left: 30px;
            z-index: 999;
            background-color: #2c2c2c;
            color: #C5A059;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 2px solid #C5A059;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        #btnMusicToggle:hover {
            background-color: #C5A059;
            transform: scale(1.1);
            color: #1a1a1a;
        }
    </style>
</head>
<body>

<!-- ========================================== -->
<!-- 1. NAVBAR                                  -->
<!-- ========================================== -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom pt-4">
    <div class="container border-bottom border-secondary pb-3">
        <a class="navbar-brand fw-bold fs-4" style="letter-spacing: 3px;" href="#">MUSEUM WASAKA</a>
        
        <div class="d-flex gap-4 align-items-center">
            <a href="/about-us" class="text-white text-decoration-none small" style="letter-spacing: 1px;">ABOUT US</a>
            <a href="{{ asset('berkas/Manual_Book_Museum_Wasaka.pdf') }}" target="_blank" class="text-white text-decoration-none small" style="letter-spacing: 1px;">
                <i class="bi bi-book me-1"></i> PANDUAN </a>
            <a href="/lapor-kendala" onclick="window.location.href='/lapor-kendala'; return false;" class="nav-link text-white text-uppercase" style="font-size: 0.85rem; letter-spacing: 1px;">Lapor Kendala</a>
            <a href="/login" class="text-white text-decoration-none small" style="letter-spacing: 1px;">LOGIN</a>
        </div>
    </div>
</nav>

<!-- ========================================== -->
<!-- 2. HERO SECTION (MENU UTAMA)               -->
<!-- ========================================== -->
<div class="hero-banjar">
    <div class="container hero-content">
        <div class="row">
            <div class="col-lg-6 col-md-12 pt-5 mt-4">
                <p class="text-uppercase mb-2" style="color: #C5A059; letter-spacing: 3px; font-weight: 600;" data-aos="fade-up">Selamat Datang Di</p>
                <h1 class="fw-bold text-white mb-3" style="font-size: 3.8rem; line-height: 1.1;" data-aos="fade-up" data-aos-delay="100">Waja Sampai<br>Kaputing</h1>
                
                <div class="d-flex align-items-center mt-4 mb-5 text-light" data-aos="fade-up" data-aos-delay="200">
                    <i class="bi bi-clock-history fs-4 me-3" style="color: #C5A059;"></i>
                    <div>
                        <p class="mb-0 small text-uppercase" style="letter-spacing: 1px;">Jam Operasional (Selasa - Minggu)</p>
                        <p class="mb-0 fw-bold">09:00 WITA &mdash; 15:00 WITA</p>
                    </div>
                </div>

                <div class="row g-3 pe-lg-5" data-aos="fade-up" data-aos-delay="300">
                    <div class="col-6">
                        <a href="/galeri" class="btn-quick-access w-100 p-3 p-md-4 text-start">
                            <i class="bi bi-bank fs-2 d-block mb-2" style="color: #C5A059;"></i>
                            <span class="fw-bold d-block" style="font-size: 0.95rem; letter-spacing: 1px;">Koleksi Utama</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="/agenda" class="btn-quick-access w-100 p-3 p-md-4 text-start">
                            <i class="bi bi-calendar-event fs-2 d-block mb-2" style="color: #C5A059;"></i>
                            <span class="fw-bold d-block" style="font-size: 0.95rem; letter-spacing: 1px;">Agenda Kegiatan</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="/jelajah" class="btn-quick-access w-100 p-3 p-md-4 text-start">
                            <i class="bi bi-badge-vr fs-2 d-block mb-2" style="color: #C5A059;"></i>
                            <span class="fw-bold d-block" style="font-size: 0.95rem; letter-spacing: 1px;">Virtual Tour 360°</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="/buku-tamu" class="btn-quick-access w-100 p-3 p-md-4 text-start">
                            <i class="bi bi-book-half fs-2 d-block mb-2" style="color: #C5A059;"></i>
                            <span class="fw-bold d-block" style="font-size: 0.95rem; letter-spacing: 1px;">Isi Buku Tamu</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- 3. KUNJUNGI KAMI (PETA & KONTAK)           -->
<!-- ========================================== -->
<!-- REVISI: Mengganti bg-white menjadi bg-white-batik -->
<div class="container-fluid px-0 bg-white-batik shadow-sm" style="position: relative; z-index: 5;">
    <div class="row g-0 align-items-center">
        <div class="col-lg-4 text-dark p-5 d-flex flex-column justify-content-center" data-aos="fade-right">
            <h3 class="fw-bold mb-4" style="color: #C5A059;">Kunjungi Kami</h3>
            
            <div class="d-flex align-items-start mb-4">
                <i class="bi bi-geo-alt-fill fs-4 me-3" style="color: #C5A059;"></i>
                <div>
                    <h6 class="fw-bold mb-1">Alamat Museum</h6>
                    <p class="mb-0 text-secondary small">Gg. H. Andir, Sungai Jingah, Kec. Banjarmasin Utara, Kota Banjarmasin, Kalimantan Selatan 70122</p>
                </div>
            </div>

            <div class="d-flex align-items-start mb-4">
                <i class="bi bi-clock-fill fs-4 me-3" style="color: #C5A059;"></i>
                <div>
                    <h6 class="fw-bold mb-1">Jam Operasional</h6>
                    <p class="mb-0 text-secondary small">Selasa - Minggu: 09.00 - 15.00 WITA<br>(Senin & Hari Libur Nasional Tutup)</p>
                </div>
            </div>

            <div class="d-flex align-items-start">
                <i class="bi bi-telephone-fill fs-4 me-3" style="color: #C5A059;"></i>
                <div>
                    <h6 class="fw-bold mb-1">Kontak Informasi</h6>
                    <p class="mb-0 text-secondary small">Email: info@museumwasaka.id<br>Telp: 081903551836 </p>
                </div>
            </div>
        </div>

        <div class="col-lg-8 pe-lg-5 py-lg-4 ps-lg-0 p-4" data-aos="fade-left">
            <iframe src="https://maps.google.com/maps?q=Museum%20Wasaka%20Banjarmasin&t=&z=16&ie=UTF8&iwloc=&output=embed" width="100%" height="320" style="border:0; border-radius: 12px; box-shadow: 0 10px 20px rgba(0,0,0,0.1);" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- 4. FOOTER                                  -->
<!-- ========================================== -->
<!-- REVISI: Mengganti bg-white menjadi bg-white-batik -->
<footer class="bg-white-batik text-dark text-center py-4 border-top">
    <div class="mb-3" style="border-top: 1px solid #c8a97e; padding-top: 15px; width: 90%; margin: 0 auto;">
        <p class="mb-0" style="font-size: 0.85rem; color: #555;">
            <i class="bi bi-bar-chart-fill me-1" style="color: #c8a97e;"></i> Statistik Pengunjung Website: 
            <span class="mx-2">Hari Ini: <strong style="color: #c8a97e;">{{ $pengunjungHariIni ?? 0 }}</strong></span> | 
            <span class="mx-2">Total: <strong style="color: #c8a97e;">{{ $totalPengunjung ?? 0 }}</strong></span>
        </p>
    </div>
    
    <p class="mb-0 small text-secondary" style="letter-spacing: 1px;">&copy; {{ date('Y') }} MUSEUM WASAKA BANJARMASIN. All rights reserved.</p>
</footer>

<!-- ========================================== -->
<!-- 5. PEMUTAR MUSIK BANJAR                    -->
<!-- ========================================== -->
<audio id="bgMusic" loop>
    <source src="{{ asset('audio/instrumen-banjar.mp3') }}" type="audio/mpeg">
</audio>

<button id="btnMusicToggle" onclick="toggleMusic()" title="Putar Musik Banjar">
    <i class="bi bi-volume-mute-fill fs-4" id="musicIcon"></i>
</button>

@include('musik')

<!-- ========================================== -->
<!-- 6. SCRIPTS                                 -->
<!-- ========================================== -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
    // Inisialisasi AOS (Animasi Scroll)
    AOS.init({
        duration: 800,
        once: true, 
        offset: 50
    });
</script>

</body>
</html>
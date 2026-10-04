<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda & Kegiatan | Museum Wasaka</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;1,600&family=Plus+Jakarta+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        /* 🔥 STYLING BARU: Latar Belakang Batik Pudar (Konsistensi Tema Indoisme) 🔥 */
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #fcfcfc;
            /* Gradient transparan dengan gambar batik */
            background-image: linear-gradient(rgba(252, 252, 252, 0.75), rgba(252, 252, 252, 0.95)), url('/images/batik white2.jpg');
            background-repeat: repeat;
            background-size: cover;
            background-attachment: fixed;
            background-position: center top;
        }
        
        .navbar-custom { background-color: #1a1a1a; }
        .section-title { text-align: center; font-weight: bold; letter-spacing: 3px; text-transform: uppercase; margin-bottom: 20px; color: #1a1a1a; font-family: 'Playfair Display', serif; }
        
        /* Efek Animasi & Card Premium */
        .card-hover-container { 
            overflow: hidden; 
            border-radius: 12px;
        }
        .card {
            box-shadow: 0 4px 15px rgba(0,0,0,0.05) !important;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background-color: #ffffff !important; /* Warna solid agar teks tetap terbaca di atas batik */
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.12) !important;
        }
        .img-zoom-out { transform: scale(1.08); transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94); }
        .card:hover .img-zoom-out { transform: scale(1); }

        /* Custom Scrollbar Mewah */
        ::-webkit-scrollbar { width: 10px; }
        ::-webkit-scrollbar-track { background: #fcfcfc; }
        ::-webkit-scrollbar-thumb { background: #C5A059; border-radius: 10px; border: 2px solid #fcfcfc; }
        ::-webkit-scrollbar-thumb:hover { background: #7A1C1C; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom py-3 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4" style="letter-spacing: 3px; font-family: 'Playfair Display', serif;" href="/">MUSEUM WASAKA</a>
            <div class="d-flex">
                <a href="/" class="btn btn-outline-light btn-sm rounded-pill px-4 fw-bold" style="letter-spacing: 1px;">Kembali ke Beranda</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5 pt-4">
        <h1 class="section-title" data-aos="fade-down">Agenda & Kegiatan</h1>
        <div style="width: 60px; height: 3px; background-color: #C5A059; margin: 0 auto 20px auto;" data-aos="fade-up"></div>
        <p class="text-center text-muted mb-5" data-aos="fade-up" data-aos-delay="100">Ikuti berbagai acara, pameran, dan kegiatan edukasi sejarah yang berlangsung di Museum Wasaka.</p>
        
        <div id="wadah-semua-kegiatan" class="row g-4 mb-5">
            <div class="col-12 text-center py-5">
                <div class="spinner-border text-dark" role="status"></div>
                <p class="mt-3 text-muted">Memuat jadwal kegiatan...</p>
            </div>
        </div>

        <div class="text-center mt-4 mb-5 pb-5" data-aos="fade-up">
            <button id="btnLoadMore" onclick="tampilkanSebagian()" class="btn btn-dark rounded-pill px-5 py-2 shadow-sm" style="display: none; font-weight: 600; letter-spacing: 1.5px; transition: all 0.3s ease;">
                MUAT LEBIH BANYAK <span class="ms-2 fw-bold">&darr;</span>
            </button>
        </div>
    </div>

    <!-- Modal Detail Kegiatan -->
    <div class="modal fade" id="modalDetailKegiatan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow: hidden;">
                <div class="modal-header border-0 pb-0 position-absolute top-0 end-0 z-3">
                    <button type="button" class="btn-close bg-white rounded-circle p-2 m-3 shadow-sm" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body p-4 pt-5 text-center position-relative">
                    <img id="detailImg" src="" class="img-fluid rounded mb-4 shadow-sm" style="max-height: 400px; object-fit: contain; background-color: #f4f4f4; width: 100%;" alt="">
                    
                    <span id="detailTanggal" class="badge bg-dark text-white mb-3 px-3 py-2 shadow-sm text-uppercase" style="letter-spacing: 1px;">
                        <i class="bi bi-calendar3 me-2" style="color: #C5A059;"></i>
                    </span>
                    <h3 id="detailJudul" class="fw-bold mb-3" style="color: #7A1C1C; font-family: 'Playfair Display', serif;"></h3>
                    <div style="width: 60px; height: 3px; background-color: #C5A059; margin: 0 auto 20px auto;"></div>
                    
                    <p id="detailDeskripsi" class="text-muted" style="line-height: 1.8; white-space: pre-wrap; text-align: justify; font-size: 1rem;"></p>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-4 mt-5">
        <p class="mb-0 small" style="letter-spacing: 1px;">&copy; 2026 MUSEUM WASAKA BANJARMASIN. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        // Inisialisasi Animasi Scroll
        AOS.init({ duration: 800, once: true, offset: 50 });

        let kegiatanGlobal = []; 
        let itemDitampilkan = 0; 
        const batasPerHalaman = 6; 

        function bukaDetailKegiatan(id) {
            const item = kegiatanGlobal.find(k => k.id === id);
            if(item) {
                let namaFile = item.foto_kegiatan || item.foto || item.gambar || item.poster || null;
                
                document.getElementById('detailJudul').innerText = item.nama_kegiatan;
                document.getElementById('detailDeskripsi').innerText = item.deskripsi;
                document.getElementById('detailTanggal').innerHTML = `<i class="bi bi-calendar3 me-2" style="color: #C5A059;"></i>${item.tanggal_pelaksanaan || item.tanggal || 'Segera Hadir'}`;
                
                const imgEl = document.getElementById('detailImg');
                imgEl.src = namaFile ? `/storage/kegiatan/${namaFile}` : 'https://via.placeholder.com/600x400?text=Tanpa+Foto';
                imgEl.onerror = function() { this.src = 'https://via.placeholder.com/600x400?text=Gambar+Error'; };
                
                new bootstrap.Modal(document.getElementById('modalDetailKegiatan')).show();
            }
        }

        function tampilkanSebagian() {
            const container = document.getElementById('wadah-semua-kegiatan');
            const dataPotongan = kegiatanGlobal.slice(itemDitampilkan, itemDitampilkan + batasPerHalaman);

            dataPotongan.forEach((item, index) => {
                let namaFile = item.foto_kegiatan || item.foto || item.gambar || item.poster || null;
                let imgSrc = namaFile ? `/storage/kegiatan/${namaFile}` : 'https://via.placeholder.com/400x250?text=Tanpa+Foto';
                let tanggalText = item.tanggal_pelaksanaan || item.tanggal || 'Segera Hadir';
                let delay = (index % 3) * 100; 

                container.innerHTML += `
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="${delay}">
                        <div class="card h-100 border-0 card-hover-container" style="cursor: pointer;" onclick="bukaDetailKegiatan(${item.id})">
                            
                            <div class="position-relative overflow-hidden" style="border-radius: 12px 12px 0 0;">
                                <img src="${imgSrc}" class="card-img-top w-100 img-zoom-out" style="height: 220px; object-fit: cover; background-color: #f4f4f4;" alt="${item.nama_kegiatan}" onerror="this.onerror=null; this.src='https://via.placeholder.com/400x250?text=Gambar+Error';">
                                
                                <div class="position-absolute top-0 start-0 bg-dark text-white px-3 py-2 m-3 shadow-sm z-2" style="border-radius: 6px; font-size: 0.85rem; font-weight: 600; letter-spacing: 0.5px;">
                                    <i class="bi bi-calendar3 me-2" style="color: #C5A059;"></i>${tanggalText}
                                </div>
                            </div>
                            
                            <div class="card-body p-4 d-flex flex-column text-start z-1">
                                <h5 class="fw-bold mb-3" style="font-family: 'Playfair Display', serif; color: #1a1a1a;">${item.nama_kegiatan}</h5>
                                <p class="text-muted small mb-0" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.6; text-align: justify;">${item.deskripsi}</p>
                                
                                <div class="mt-4 pt-3 border-top text-center w-100 mt-auto">
                                    <span class="fw-bold" style="font-size: 0.85rem; letter-spacing: 1px; color: #C5A059;">LIHAT DETAIL &rarr;</span>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });

            itemDitampilkan += dataPotongan.length;
            document.getElementById('btnLoadMore').style.display = (itemDitampilkan >= kegiatanGlobal.length) ? 'none' : 'inline-block';
        }

        async function loadSemuaKegiatan() {
            try {
                const response = await fetch('/api/kegiatan');
                const result = await response.json();

                if (response.ok && result.data.length > 0) {
                    document.getElementById('wadah-semua-kegiatan').innerHTML = ''; 
                    kegiatanGlobal = result.data.reverse(); 
                    itemDitampilkan = 0; 
                    tampilkanSebagian(); 
                } else {
                    document.getElementById('wadah-semua-kegiatan').innerHTML = '<p class="text-center w-100 text-muted mt-4">Belum ada kegiatan yang diagendakan.</p>';
                }
            } catch (e) {
                document.getElementById('wadah-semua-kegiatan').innerHTML = '<p class="text-center w-100 text-danger mt-4">Koneksi server terputus. Pastikan database aktif.</p>';
            }
        }

        document.addEventListener('DOMContentLoaded', loadSemuaKegiatan);
    </script>
    @include('musik')
</body>
</html>
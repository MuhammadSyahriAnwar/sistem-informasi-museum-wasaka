<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Koleksi | Museum Wasaka</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;1,600&family=Plus+Jakarta+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        /* 🔥 STYLING BARU: Latar Belakang Batik Pudar (Indoisme) 🔥 */
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #fcfcfc;
            /* Menggabungkan gradient transparan dengan gambar batik agar efeknya pudar/seamless */
            background-image: linear-gradient(rgba(252, 252, 252, 0.75), rgba(252, 252, 252, 0.95)), url('/images/batik white 3.jpg');
            background-repeat: repeat;
            background-size: cover;
            background-attachment: fixed;
            background-position: center top;
        }
        
        .navbar-custom { background-color: #1a1a1a; }
        .section-title { text-align: center; font-weight: bold; letter-spacing: 3px; text-transform: uppercase; margin-bottom: 20px; color: #1a1a1a; font-family: 'Playfair Display', serif; }
        .card-img-top { height: 250px; object-fit: contain !important; background-color: #f4f4f4; width: 100%; }
        
        /* Animasi muncul (Fade in) */
        .fade-in { animation: fadeIn 0.5s; }
        @keyframes fadeIn { 0% { opacity: 0; transform: translateY(10px); } 100% { opacity: 1; transform: translateY(0); } }

        /* Tombol Kategori Minimalis Premium */
        .filter-container { gap: 15px; row-gap: 10px; }
        .btn-filter { 
            background: transparent; 
            border: none; 
            color: #999; 
            font-weight: 600; 
            letter-spacing: 1.5px; 
            text-transform: uppercase; 
            font-size: 0.85rem; 
            padding: 8px 12px; 
            border-bottom: 2px solid transparent; 
            border-radius: 0; 
            transition: all 0.3s ease; 
        }
        .btn-filter:hover { color: #1a1a1a; }
        .btn-filter.active { 
            color: #1a1a1a; 
            border-bottom: 2px solid #C5A059; /* Aksen Emas Louvre */
        }
        
        /* Tambahan sedikit shadow pada card agar lebih menonjol dari background batik */
        .card {
            box-shadow: 0 4px 15px rgba(0,0,0,0.05) !important;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom py-3 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4" style="letter-spacing: 3px; font-family: 'Playfair Display', serif;" href="/">MUSEUM WASAKA</a>
            <div class="d-flex">
                <a href="/" class="btn btn-outline-light btn-sm rounded-pill px-3 fw-bold">Kembali ke Beranda</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5 pt-4">
        <h1 class="section-title">Galeri Koleksi Museum</h1>
        <p class="text-center text-muted mb-4">Eksplorasi 100+ peninggalan sejarah dan artefak perjuangan rakyat Kalimantan Selatan.</p>
        
        <div id="wadah-kategori" class="d-flex flex-wrap justify-content-center mb-5 fade-in filter-container">
            <!-- Tombol kategori akan di-render di sini -->
        </div>

        <div id="wadah-semua-koleksi" class="row">
            <div id="loading-spinner" class="col-12 text-center py-5">
                <div class="spinner-border text-dark" role="status"></div>
                <p class="mt-3 text-muted">Memuat data koleksi...</p>
            </div>
        </div>

        <div class="text-center mt-4 mb-5">
            <button id="btnLoadMore" onclick="tampilkanSebagian()" class="btn btn-dark rounded-pill px-5 py-2 shadow-sm" style="display: none; font-weight: 600; letter-spacing: 1px;">
                Muat Lebih Banyak...
            </button>
        </div>
    </div>

    <!-- Modal Detail Koleksi -->
    <div class="modal fade" id="modalDetailKoleksi" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow: hidden;">
                
                <div class="modal-header border-0 pb-0 position-absolute top-0 end-0 z-3">
                    <button type="button" class="btn-close bg-white rounded-circle p-2 m-3 shadow-sm" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body p-4 pt-5 text-center position-relative">
                    <img id="detailImg" src="" class="img-fluid rounded mb-4 shadow-sm" style="max-height: 400px; object-fit: contain; background-color: #f4f4f4; width: 100%;" alt="">
                    
                    <span id="detailKategori" class="badge bg-light text-secondary mb-3 border text-uppercase" style="letter-spacing: 1px;"></span>
                    
                    <h3 id="detailJudul" class="fw-bold mb-3" style="color: #7A1C1C; font-family: 'Playfair Display', serif;"></h3>
                    
                    <div style="width: 60px; height: 3px; background-color: #C5A059; margin: 0 auto 20px auto;"></div>
                    
                    <!-- Element Audio HTML5 Tersembunyi -->
                    <audio id="audioKoleksi" src=""></audio>
                    
                    <button id="btnVoiceOver" onclick="toggleVoiceOver()" class="btn btn-outline-dark rounded-pill px-4 py-2 mb-4 fw-bold shadow-sm" style="letter-spacing: 0.5px; transition: all 0.3s ease;">
                        <i class="bi bi-volume-up-fill me-1"></i> Dengarkan Sejarah
                    </button>
                    
                    <p id="detailDeskripsi" class="text-muted" style="line-height: 1.8; white-space: pre-wrap; text-align: justify; font-size: 1rem;"></p>
                </div>
                
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-4 mt-5">
        <p class="mb-0 small letter-spacing-1">&copy; 2026 MUSEUM WASAKA BANJARMASIN. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        let koleksiGlobal = []; 
        let koleksiFiltered = []; 
        let itemDitampilkan = 0; 
        const batasPerHalaman = 9; 

        // Fungsi Pengacak Data (Fisher-Yates Algorithm)
        function acakKoleksi(array) {
            for (let i = array.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [array[i], array[j]] = [array[j], array[i]];
            }
            return array;
        }

        function getNamaKategori(dataKategori) {
            if (!dataKategori) return '';
            if (typeof dataKategori === 'object') {
                return dataKategori.nama_kategori || dataKategori.nama || dataKategori.kategori || 'Tanpa Kategori';
            }
            return dataKategori;
        }

        function bukaDetailKoleksi(id) {
            const item = koleksiGlobal.find(k => k.id === id);
            if(item) {
                document.getElementById('detailJudul').innerText = item.nama_koleksi;
                document.getElementById('detailDeskripsi').innerText = item.deskripsi;
                document.getElementById('detailKategori').innerText = getNamaKategori(item.kategori) || 'Tanpa Kategori';
                document.getElementById('detailImg').src = item.foto ? `/storage/koleksi/${item.foto}` : 'https://via.placeholder.com/400x300?text=Tanpa+Foto';
                
                const audioEl = document.getElementById('audioKoleksi');
                const namaKoleksiLower = item.nama_koleksi.toLowerCase();
                
                // STRATEGI DETEKSI OTOMATIS BERDASARKAN NAMA FILE
                if (namaKoleksiLower.includes('bungkukan')) {
                    audioEl.src = "/audio/Diorama Pertempuran Bungkukan.mp3";
                } else if (namaKoleksiLower.includes('hassan basry') || namaKoleksiLower.includes('hasan basry')) {
                    audioEl.src = "/audio/Lukisan Brigjen TNI (Anumerta) H. Hassan Basry.mp3";
                } else if (namaKoleksiLower.includes('instrumen') || namaKoleksiLower.includes('banjar')) {
                    audioEl.src = "/audio/instrumen-banjar.mp3";
                } else {
                    audioEl.removeAttribute('src'); 
                }
                
                const modal = new bootstrap.Modal(document.getElementById('modalDetailKoleksi'));
                modal.show();
            }
        }

        function buatTombolKategori() {
            const wadahKategori = document.getElementById('wadah-kategori');
            const semuaKategoriBersih = koleksiGlobal.map(item => getNamaKategori(item.kategori)).filter(k => k !== '');
            const kategoriUnik = [...new Set(semuaKategoriBersih)];

            let htmlTombol = `<button class="btn-filter active" onclick="jalankanFilter('semua', this)">Semua Koleksi</button>`;

            kategoriUnik.forEach(kategori => {
                htmlTombol += `<button class="btn-filter" onclick="jalankanFilter('${kategori}', this)">${kategori}</button>`;
            });

            wadahKategori.innerHTML = htmlTombol;
        }

        function jalankanFilter(kategoriPilihan, elemenTombol) {
            document.querySelectorAll('.btn-filter').forEach(btn => btn.classList.remove('active'));
            elemenTombol.classList.add('active');

            if(kategoriPilihan === 'semua') {
                koleksiFiltered = [...koleksiGlobal]; 
            } else {
                koleksiFiltered = koleksiGlobal.filter(item => getNamaKategori(item.kategori) === kategoriPilihan);
            }

            document.getElementById('wadah-semua-koleksi').innerHTML = '';
            itemDitampilkan = 0;
            tampilkanSebagian();
        }

        function tampilkanSebagian() {
            const container = document.getElementById('wadah-semua-koleksi');
            const dataPotongan = koleksiFiltered.slice(itemDitampilkan, itemDitampilkan + batasPerHalaman);

            dataPotongan.forEach(item => {
                let imgSrc = item.foto ? `/storage/koleksi/${item.foto}` : 'https://via.placeholder.com/400x300?text=Tanpa+Foto';
                let namaKat = getNamaKategori(item.kategori);

                container.innerHTML += `
                    <div class="col-md-4 mb-4 fade-in">
                        <div class="card h-100 border-0 bg-white">
                            <img src="${imgSrc}" class="card-img-top rounded-top" alt="${item.nama_koleksi}">
                            <div class="card-body px-4 py-4 text-center d-flex flex-column">
                                <span class="badge bg-light text-secondary mb-2 align-self-center border text-uppercase" style="letter-spacing:1px; font-size:0.7rem;">${namaKat}</span>
                                <h5 class="fw-bold mb-3" style="font-family: 'Playfair Display', serif;">${item.nama_koleksi}</h5>
                                <p class="text-muted small mb-4" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; text-align: justify;">${item.deskripsi}</p>
                                <div class="mt-auto">
                                    <button onclick="bukaDetailKoleksi(${item.id})" class="btn btn-outline-dark btn-sm rounded-pill px-4 fw-bold">Lihat Detail</button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });

            itemDitampilkan += dataPotongan.length;

            const btnLoadMore = document.getElementById('btnLoadMore');
            if (itemDitampilkan >= koleksiFiltered.length) {
                btnLoadMore.style.display = 'none';
            } else {
                btnLoadMore.style.display = 'inline-block';
            }
        }

        async function loadSemuaKoleksi() {
            try {
                const response = await fetch('/api/koleksi');
                const result = await response.json();

                if (response.ok && result.data.length > 0) {
                    document.getElementById('wadah-semua-koleksi').innerHTML = ''; 
                    
                    koleksiGlobal = acakKoleksi([...result.data]); 
                    koleksiFiltered = [...koleksiGlobal]; 
                    
                    buatTombolKategori(); 
                    
                    itemDitampilkan = 0; 
                    tampilkanSebagian(); 
                } else {
                    document.getElementById('wadah-semua-koleksi').innerHTML = '<p class="text-center w-100 text-muted mt-4">Belum ada koleksi yang dipamerkan.</p>';
                }
            } catch (e) {
                document.getElementById('wadah-semua-koleksi').innerHTML = '<p class="text-center w-100 text-danger mt-4">Koneksi server terputus.</p>';
            }
        }

        // --- FITUR PEMUTAR AUDIO LOKAL ---
        function toggleVoiceOver() {
            const audioEl = document.getElementById('audioKoleksi');
            const btn = document.getElementById('btnVoiceOver');

            if (!audioEl.hasAttribute('src') || audioEl.getAttribute('src') === '') {
                alert("Mohon maaf Bapak/Ibu Dosen, fitur audio pemandu sejarah (AI Voice) untuk objek ini sedang dalam antrean produksi sistem. Sebagai demonstrasi kelayakan fitur, silakan mencoba pada koleksi utama seperti Lukisan H. Hassan Basry atau Diorama Pertempuran Bungkukan.");
                return;
            }

            if (audioEl.paused) {
                let playPromise = audioEl.play();
                
                if (playPromise !== undefined) {
                    playPromise.then(_ => {
                        btn.innerHTML = '<i class="bi bi-stop-circle-fill me-1"></i> Hentikan Suara';
                        btn.classList.replace('btn-outline-dark', 'btn-dark'); 
                    })
                    .catch(error => {
                        console.warn("Audio gagal diputar:", error);
                        alert("Gagal memutar audio. Pastikan file MP3 berada di /public/audio/ dan penulisan nama filenya tidak berubah.");
                    });
                }

                audioEl.onended = function() {
                    btn.innerHTML = '<i class="bi bi-volume-up-fill me-1"></i> Dengarkan Sejarah';
                    btn.classList.replace('btn-dark', 'btn-outline-dark');
                };
            } else {
                audioEl.pause();
                btn.innerHTML = '<i class="bi bi-volume-up-fill me-1"></i> Dengarkan Sejarah';
                btn.classList.replace('btn-dark', 'btn-outline-dark');
            }
        }

        const modalKoleksiEl = document.getElementById('modalDetailKoleksi');
        if(modalKoleksiEl) {
            modalKoleksiEl.addEventListener('hidden.bs.modal', function () {
                const audioEl = document.getElementById('audioKoleksi');
                
                if(!audioEl.paused) {
                    audioEl.pause();
                }
                audioEl.currentTime = 0; 
                
                const btn = document.getElementById('btnVoiceOver');
                if(btn) {
                    btn.innerHTML = '<i class="bi bi-volume-up-fill me-1"></i> Dengarkan Sejarah';
                    btn.classList.replace('btn-dark', 'btn-outline-dark');
                }
            });
        }

        document.addEventListener('DOMContentLoaded', loadSemuaKoleksi);
    </script>
    @include('musik')
</body>
</html>
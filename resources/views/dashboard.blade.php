@extends('layouts.app')

@section('content')
<style>
    /* =========================================================
       EFEK BACKGROUND BATIK FADING
       ========================================================= */
    body {
        background-color: #f8f9fa; /* Warna dasar abu-abu sangat terang */
        /* Penumpukan Layer: Gradien memudar + Gambar Batik */
        background-image: 
            linear-gradient(to bottom, rgba(248, 249, 250, 0.3) 0%, rgba(248, 249, 250, 0.95) 50%, #f8f9fa 100%),
            url('/images/batik%20white1.jpg'); /* %20 adalah spasi pada nama file Anda */
        background-repeat: repeat; /* Mengulang pola agar memenuhi layar */
        background-position: top center;
        background-size: 500px; /* Atur angka ini (misal 300px/600px) untuk membesarkan/mengecilkan motif */
        background-attachment: fixed; /* Membuat background diam saat halaman di-scroll */
    }

    /* Memastikan card tidak terlalu transparan agar tulisan tetap terbaca jelas */
    .card {
        background-color: rgba(255, 255, 255, 0.97) !important;
        backdrop-filter: blur(4px); /* Efek kaca tipis jika ada elemen batik di belakangnya */
    }

    /* =========================================================
       STYLING KOMPONEN DASHBOARD
       ========================================================= */
    .title-museum {
        font-family: 'Playfair Display', serif;
        color: #111111;
    }
    .text-gold { color: #c5a059; }
    .bg-black { background-color: #111111; }
    
    .card-stat {
        border-radius: 10px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .card-stat:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(197, 160, 89, 0.15) !important;
    }
    .btn-outline-gold {
        color: #c5a059;
        border-color: #c5a059;
    }
    .btn-outline-gold:hover {
        background-color: #c5a059;
        color: #111;
    }
    .btn-black {
        background-color: #111111;
        color: #fff;
    }
    .btn-black:hover {
        background-color: #2a2a2a;
        color: #c5a059;
    }
</style>

<div class="row mb-4">
    <div class="col-md-12">
        <h2 class="fw-bold title-museum border-bottom pb-2" style="border-color: #c5a059 !important;">Dashboard Operasional</h2>
        <p class="text-muted mt-2">Ringkasan statistik dan kendali utama Sistem Informasi Museum Wasaka.</p>
    </div>
</div>

<!-- Baris Statistik Utama -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card card-stat h-100 shadow-sm border-0" style="border-bottom: 4px solid #111;">
            <div class="card-body p-4 text-center">
                <h6 class="text-muted text-uppercase fw-bold mb-3" style="letter-spacing: 1px;">Traffic Web</h6>
                <h1 class="display-4 fw-bold text-gold">{{ $totalPengunjung ?? 0 }}</h1>
                <span class="text-muted small d-block mt-2">Total pengunjung *real-time*</span>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card card-stat h-100 shadow-sm border-0" style="border-bottom: 4px solid #c5a059;">
            <div class="card-body p-4 text-center">
                <h6 class="text-muted text-uppercase fw-bold mb-3" style="letter-spacing: 1px;">Buku Tamu</h6>
                <h1 class="display-4 fw-bold text-gold" id="stat_pengunjung">...</h1>
                <a href="/kelola-pengunjung" id="link-kelola-pengunjung" class="btn btn-sm btn-outline-gold mt-2 px-3 rounded-pill">Kelola Data</a>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card card-stat h-100 shadow-sm border-0" style="border-bottom: 4px solid #111;">
            <div class="card-body p-4 text-center">
                <h6 class="text-muted text-uppercase fw-bold mb-3" style="letter-spacing: 1px;">Koleksi Artefak</h6>
                <h1 class="display-4 fw-bold text-gold" id="stat_koleksi">...</h1>
                <a href="/koleksi" id="link-kelola-koleksi" class="btn btn-sm btn-outline-gold mt-2 px-3 rounded-pill">Kelola Data</a>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card card-stat h-100 shadow-sm border-0" style="border-bottom: 4px solid #c5a059;">
            <div class="card-body p-4 text-center">
                <h6 class="text-muted text-uppercase fw-bold mb-3" style="letter-spacing: 1px;">Agenda & Publikasi</h6>
                <h1 class="display-4 fw-bold text-gold" id="stat_kegiatan">...</h1>
                <a href="/kegiatan" id="link-kelola-kegiatan" class="btn btn-sm btn-outline-gold mt-2 px-3 rounded-pill">Kelola Data</a>
            </div>
        </div>
    </div>
</div>

<!-- Baris Aksi & Laporan (Ekspor & Kendala) -->
<div class="row mb-4 align-items-stretch">
    <!-- Bagian Ekspor Laporan (Sebelah Kiri) -->
    <div class="col-md-8 mb-3">
        <div class="card shadow-sm border-0 h-100" style="border-left: 5px solid #111 !important;">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-4" style="color: #111;"><i class="bi bi-printer-fill me-2 text-gold"></i>Ekspor Laporan Pengunjung</h6>
                
                <form action="{{ route('laporan.pengunjung') }}" method="GET" target="_blank" class="row g-3" id="formCetakDashboard">
                    <div class="col-lg-7 align-self-end">
                        <label for="periode" class="form-label fw-bold text-muted small">Pilih Periode Waktu Laporan</label>
                        <select name="periode" id="periode" class="form-select border-secondary shadow-sm" onchange="cekPeriodeKustom()">
                            <option value="semua">Semua Waktu (Seluruh Data)</option>
                            <option value="hari_ini">Hari Ini</option>
                            <option value="minggu_ini">7 Hari Terakhir (Minggu Ini)</option>
                            <option value="bulan_ini">Bulan Ini</option>
                            <option value="triwulan">3 Bulan Terakhir (Triwulan)</option>
                            <option value="semester">6 Bulan Terakhir (Semester)</option>
                            <option value="tahun_ini">Tahun Ini</option>
                            <option value="kustom" class="fw-bold" style="color: #c5a059;">Pilih Rentang Tanggal (Kustom)...</option>
                        </select>
                    </div>
                    
                    <div class="col-lg-5 align-self-end">
                        <button type="submit" class="btn btn-black px-4 py-2 fw-bold shadow-sm w-100">
                            <i class="bi bi-file-earmark-pdf-fill me-1 text-gold"></i> Unduh Dokumen PDF
                        </button>
                    </div>

                    <!-- Input Kustom (Disembunyikan secara default) -->
                    <div class="col-md-12 d-none mt-3" id="form-kustom-dashboard">
                        <div class="p-3 bg-white border border-light rounded shadow-sm row">
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-bold">Dari Tanggal</label>
                                <input type="date" name="start_date" id="start_date" class="form-control border-secondary">
                            </div>
                            <div class="col-md-6 mt-2 mt-md-0">
                                <label class="form-label text-muted small fw-bold">Sampai Tanggal</label>
                                <input type="date" name="end_date" id="end_date" class="form-control border-secondary">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bagian Pelaporan Kendala (Sebelah Kanan) -->
    <div class="col-md-4 mb-3">
        <div class="card shadow-sm border-0 h-100" style="background: linear-gradient(135deg, #1a1a1a 0%, #111 100%); color: white;">
            <div class="card-body p-4 d-flex flex-column justify-content-center align-items-center text-center">
                <div class="mb-3 p-3 rounded-circle" style="background-color: rgba(197, 160, 89, 0.2);">
                    <i class="bi bi-exclamation-triangle-fill fs-3 text-gold"></i>
                </div>
                <h6 class="fw-bold mb-2">Pusat Kendala Sistem</h6>
                <p class="text-secondary small mb-4" id="teks-kendala">Memuat akses...</p>
                <a href="#" id="btn-kendala" class="btn w-100 fw-bold border-0" style="background-color: #c5a059; color: #111;">
                    <i class="bi bi-arrow-clockwise me-1"></i> Mohon Tunggu
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row mb-5">
    <div class="col-md-12">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4 title-museum"><i class="bi bi-journal-bookmark-fill me-2 text-gold"></i>Buku Tamu Terbaru</h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="py-3 text-uppercase small text-muted">Tanggal</th>
                                <th class="py-3 text-uppercase small text-muted">Nama Pengunjung</th>
                                <th class="py-3 text-uppercase small text-muted">Instansi / Asal</th>
                                <th class="py-3 text-uppercase small text-muted">Tujuan Kunjungan</th>
                            </tr>
                        </thead>
                        <tbody id="tabel_buku_tamu">
                            <tr>
                                <td colspan="4" class="text-center text-muted py-5">
                                    <div class="spinner-border spinner-border-sm text-secondary" role="status"></div>
                                    Memuat data pengunjung...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function cekPeriodeKustom() {
        const periode = document.getElementById('periode').value;
        const formKustom = document.getElementById('form-kustom-dashboard');
        const startDate = document.getElementById('start_date');
        const endDate = document.getElementById('end_date');
        
        if (periode === 'kustom') {
            formKustom.classList.remove('d-none');
            startDate.setAttribute('required', 'required');
            endDate.setAttribute('required', 'required');
        } else {
            formKustom.classList.add('d-none');
            startDate.removeAttribute('required');
            endDate.removeAttribute('required');
            startDate.value = '';
            endDate.value = '';
        }
    }

    document.addEventListener('DOMContentLoaded', async () => {
        const token = localStorage.getItem('token');
        const role = localStorage.getItem('role'); 
        
        if (!token) {
            window.location.href = '/login';
            return;
        }

        const btnKendala = document.getElementById('btn-kendala');
        const teksKendala = document.getElementById('teks-kendala');

        if (role === 'admin') {
            btnKendala.href = '/laporan-internal'; 
            btnKendala.innerHTML = '<i class="bi bi-clipboard2-check-fill me-1"></i> Kelola Laporan';
            teksKendala.innerText = 'Tinjau dan perbarui status kendala.';
        } else if (role === 'petugas') {
            btnKendala.href = '/lapor-kendala'; 
            btnKendala.innerHTML = '<i class="bi bi-megaphone-fill me-1"></i> Lapor Kendala';
            teksKendala.innerText = 'Laporkan masalah operasional.';
        }

        if (role === 'petugas') {
            const btnKoleksi = document.getElementById('link-kelola-koleksi');
            const btnKegiatan = document.getElementById('link-kelola-kegiatan');
            
            if (btnKoleksi) btnKoleksi.style.display = 'none';
            if (btnKegiatan) btnKegiatan.style.display = 'none';
        }

        const headersDenganToken = {
            'Authorization': 'Bearer ' + token,
            'Accept': 'application/json'
        };

        try {
            const resKoleksi = await fetch('/api/koleksi');
            const dataKoleksi = await resKoleksi.json();
            if (resKoleksi.ok) document.getElementById('stat_koleksi').innerText = dataKoleksi.data.length;

            const resKegiatan = await fetch('/api/kegiatan');
            const dataKegiatan = await resKegiatan.json();
            if (resKegiatan.ok) document.getElementById('stat_kegiatan').innerText = dataKegiatan.data.length;

            const resPengunjung = await fetch('/api/pengunjung', { headers: headersDenganToken });
            const resultPengunjung = await resPengunjung.json();
            
            const tbody = document.getElementById('tabel_buku_tamu');
            
            if (resPengunjung.ok) {
                const arrPengunjung = resultPengunjung.data || [];
                document.getElementById('stat_pengunjung').innerText = arrPengunjung.length;

                tbody.innerHTML = ''; 
                if (arrPengunjung.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="4" class="text-center text-muted py-5">Buku tamu masih kosong.</td></tr>';
                } else {
                    const limaTerbaru = arrPengunjung.slice(0, 5);
                    limaTerbaru.forEach(p => {
                        let tgl = p.created_at ? new Date(p.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) : '-';
                        let nama = p.nama || '-';
                        let instansi = p.asal_instansi || '-'; 
                        let tujuan = p.tujuan_kunjungan || '-';

                        tbody.innerHTML += `
                            <tr>
                                <td><span class="badge bg-light text-dark border border-secondary px-2 py-1">${tgl}</span></td>
                                <td class="fw-bold" style="color: #111;">${nama}</td>
                                <td class="text-secondary">${instansi}</td>
                                <td>${tujuan}</td>
                            </tr>
                        `;
                    });
                }
            } else {
                tbody.innerHTML = '<tr><td colspan="4" class="text-center text-danger">Gagal memuat data buku tamu.</td></tr>';
            }
        } catch (error) {
            document.getElementById('tabel_buku_tamu').innerHTML = '<tr><td colspan="4" class="text-center text-danger">Terjadi kesalahan koneksi server.</td></tr>';
        }
    });
</script>
@endsection
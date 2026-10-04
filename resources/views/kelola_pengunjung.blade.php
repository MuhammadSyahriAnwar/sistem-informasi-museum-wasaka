@extends('layouts.app')

@section('content')
<style>
    /* =========================================================
       EFEK BACKGROUND BATIK FADING & TEMA EKSKLUSIF
       ========================================================= */
    body {
        background-color: #f8f9fa;
        background-image: 
            linear-gradient(to bottom, rgba(248, 249, 250, 0.4) 0%, rgba(248, 249, 250, 0.95) 50%, #f8f9fa 100%),
            url('/images/batik%20white4.jpg');
        background-repeat: repeat;
        background-position: top center;
        background-size: 500px;
        background-attachment: fixed;
    }
    .card {
        background-color: rgba(255, 255, 255, 0.97) !important;
        backdrop-filter: blur(4px);
        border: none;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }
    .title-museum { font-family: 'Playfair Display', serif; color: #111; }
    .text-gold { color: #c5a059; }
    .btn-gold { background-color: #c5a059; color: #111; transition: 0.3s; border: none; }
    .btn-gold:hover { background-color: #d4b26f; color: #000; transform: translateY(-2px); }
    .btn-black { background-color: #111111; color: #fff; transition: 0.3s; }
    .btn-black:hover { background-color: #2a2a2a; color: #c5a059; }
</style>

<div class="row mb-4" data-aos="fade-down">
    <div class="col-md-8">
        <h2 class="fw-bold title-museum border-bottom pb-2" style="border-color: #c5a059 !important; display: inline-block;">Manajemen Pengunjung</h2>
        <p class="text-muted mt-2">Kelola data kunjungan, pantau statistik, dan cetak laporan secara periodik.</p>
    </div>
    <div class="col-md-4 text-end my-auto">
        <div class="dropdown d-inline-block">
            <button class="btn btn-gold fw-bold px-4 dropdown-toggle shadow-sm" type="button" id="dropdownCetakLaporan" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-file-earmark-pdf-fill me-2"></i>Cetak Laporan PDF
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownCetakLaporan">
                <li><h6 class="dropdown-header text-uppercase" style="color: #c5a059;">Periode Laporan</h6></li>
                <li><a class="dropdown-item" target="_blank" href="{{ route('laporan.pengunjung', ['periode' => 'hari_ini']) }}"><i class="bi bi-calendar-event me-2 text-muted"></i>Hari Ini</a></li>
                <li><a class="dropdown-item" target="_blank" href="{{ route('laporan.pengunjung', ['periode' => 'minggu_ini']) }}"><i class="bi bi-calendar-range me-2 text-muted"></i>Minggu Ini</a></li>
                <li><a class="dropdown-item" target="_blank" href="{{ route('laporan.pengunjung', ['periode' => 'bulan_ini']) }}"><i class="bi bi-calendar-month me-2 text-muted"></i>Bulan Ini</a></li>
                <li><a class="dropdown-item" target="_blank" href="{{ route('laporan.pengunjung', ['periode' => 'triwulan']) }}"><i class="bi bi-calendar3 me-2 text-muted"></i>3 Bulan Terakhir</a></li>
                <li><a class="dropdown-item" target="_blank" href="{{ route('laporan.pengunjung', ['periode' => 'semester']) }}"><i class="bi bi-calendar4-week me-2 text-muted"></i>6 Bulan Terakhir</a></li>
                <li><a class="dropdown-item" target="_blank" href="{{ route('laporan.pengunjung', ['periode' => 'tahun_ini']) }}"><i class="bi bi-calendar-check me-2 text-muted"></i>Tahunan</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item fw-bold text-dark" href="#" data-bs-toggle="modal" data-bs-target="#modalCetakKustom"><i class="bi bi-calendar-date-fill me-2 text-gold"></i>Cetak Rentang Kustom...</a></li>
                <li><a class="dropdown-item fw-bold" target="_blank" href="{{ route('laporan.pengunjung', ['periode' => 'semua']) }}" style="color: #111;"><i class="bi bi-file-earmark-pdf me-2"></i>Cetak Semua Data</a></li>
            </ul>
        </div>
    </div>
</div>

<div class="row mb-5" id="rowStatistik" data-aos="fade-up" data-aos-delay="100">
    <div class="col-md-4 mb-3">
        <div class="card h-100" style="border-top: 4px solid #111;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <h6 class="card-title text-muted text-uppercase fw-bold mb-0 mt-1">Kunjungan Hari Ini</h6>
                    <div class="bg-light rounded-circle p-2 d-flex align-items-center justify-content-center border" style="width: 45px; height: 45px;">
                        <i class="bi bi-person-check-fill fs-5 text-gold"></i>
                    </div>
                </div>
                <h1 class="display-4 fw-bold" style="color: #111;" id="statHariIni">0</h1>
                <p class="card-text mt-3 mb-0"><small class="text-muted">Orang yang berkunjung hari ini</small></p>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card h-100" style="border-top: 4px solid #c5a059;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <h6 class="card-title text-muted text-uppercase fw-bold mb-0 mt-1">Kunjungan Bulan Ini</h6>
                    <div class="bg-light rounded-circle p-2 d-flex align-items-center justify-content-center border" style="width: 45px; height: 45px;">
                        <i class="bi bi-calendar3 fs-5" style="color: #111;"></i>
                    </div>
                </div>
                <h1 class="display-4 fw-bold" style="color: #111;" id="statBulanIni">0</h1>
                <p class="card-text mt-3 mb-0"><small class="text-muted">Total pengunjung selama bulan ini</small></p>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card h-100" style="border-top: 4px solid #111;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <h6 class="card-title text-muted text-uppercase fw-bold mb-0 mt-1">Total Akumulasi</h6>
                    <div class="bg-light rounded-circle p-2 d-flex align-items-center justify-content-center border" style="width: 45px; height: 45px;">
                        <i class="bi bi-bar-chart-fill fs-5 text-gold"></i>
                    </div>
                </div>
                <h1 class="display-4 fw-bold" style="color: #111;" id="statTotal">0</h1>
                <p class="card-text mt-3 mb-0"><small class="text-muted">Seluruh pengunjung yang tercatat</small></p>
            </div>
        </div>
    </div>
</div>

<div class="row" data-aos="fade-up" data-aos-delay="200">
    <div class="col-md-12">
        <div class="card" style="border-top: 4px solid #c5a059;">
            <div class="card-body p-4">
                
                <div class="row mb-4 justify-content-end">
                    <div class="col-md-4">
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-white border-end-0 text-gold"><i class="bi bi-search"></i></span>
                            <input type="text" id="cariPengunjung" class="form-control bg-white border-start-0" placeholder="Cari nama atau instansi..." onkeyup="filterTabelPengunjung()">
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="tabelPengunjungUtama">
                        <thead class="table-light">
                            <tr>
                                <th width="20%" class="text-uppercase small text-muted">Nama Pengunjung</th>
                                <th width="15%" class="text-uppercase small text-muted">Kategori</th>
                                <th width="20%" class="text-uppercase small text-muted">Instansi/Asal Daerah</th>
                                <th width="10%" class="text-center text-uppercase small text-muted">Sesi</th>
                                <th width="10%" class="text-center text-uppercase small text-muted">Rombongan</th>
                                <th width="15%" class="text-center text-uppercase small text-muted">Waktu Isi</th>
                                <th width="10%" class="text-center text-uppercase small text-muted">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tabelDataPengunjung">
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <div class="spinner-border text-secondary" role="status"></div>
                                    <p class="mt-2 mb-0">Sedang menyinkronkan data buku tamu...</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Pengunjung -->
<div class="modal fade" id="modalDetailTujuan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
            <div class="modal-header text-white" style="background-color: #111; border-bottom: 3px solid #c5a059;">
                <h5 class="modal-title fw-bold title-museum" style="color: #c5a059;"><i class="bi bi-info-circle-fill me-2"></i>Detail Kunjungan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="fw-bold text-muted small text-uppercase">Nama Kontak Utama</label>
                    <p class="fw-bold fs-5 mb-0" id="detNama" style="color: #111;"></p>
                </div>
                <div class="mb-3">
                    <label class="fw-bold text-muted small text-uppercase">Nomor HP / WhatsApp</label>
                    <p class="mb-0 fw-semibold text-secondary" id="detHp"></p>
                </div>
                <div class="mb-0">
                    <label class="fw-bold text-muted small text-uppercase">Maksud & Tujuan Kunjungan</label>
                    <div class="p-3 bg-light rounded mt-1" id="detTujuan" style="white-space: pre-wrap; text-align: justify; font-size: 0.95rem; border-left: 3px solid #c5a059;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Cetak Laporan Kustom -->
<div class="modal fade" id="modalCetakKustom" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
            <div class="modal-header text-white" style="background-color: #111; border-bottom: 3px solid #c5a059;">
                <h5 class="modal-title fw-bold title-museum" style="color: #c5a059;"><i class="bi bi-printer-fill me-2"></i>Cetak Rentang Kustom</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('laporan.pengunjung') }}" method="GET" target="_blank">
                <div class="modal-body p-4">
                    <input type="hidden" name="periode" value="kustom">
                    <p class="text-muted small mb-3">Tentukan rentang tanggal awal dan akhir untuk menarik rekap data kunjungan secara spesifik.</p>
                    
                    <div class="mb-3">
                        <label class="fw-bold text-muted small text-uppercase">Dari Tanggal (Mulai)</label>
                        <input type="date" name="start_date" class="form-control border-secondary" required>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold text-muted small text-uppercase">Sampai Tanggal (Akhir)</label>
                        <input type="date" name="end_date" class="form-control border-secondary" required>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top-0">
                    <button type="button" class="btn btn-outline-dark px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-gold fw-bold px-4"><i class="bi bi-file-earmark-pdf-fill me-1"></i> Buat Dokumen</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let dataPengunjungGlobal = [];

    async function initHalamanPengunjung() {
        const token = localStorage.getItem('token');
        
        try {
            const resTabel = await fetch('/api/pengunjung', { 
                method: 'GET',
                headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' }
            });
            const resultTabel = await resTabel.json();
            
            if (resTabel.ok) {
                const tbody = document.getElementById('tabelDataPengunjung');
                tbody.innerHTML = '';
                dataPengunjungGlobal = resultTabel.data;

                if (dataPengunjungGlobal.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="7" class="text-center text-muted py-4">Belum ada catatan kunjungan masuk di buku tamu.</td></tr>';
                } else {
                    dataPengunjungGlobal.forEach(item => {
                        let tgl = new Date(item.created_at);
                        let formatWaktu = tgl.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }) + ' ' + tgl.toLocaleTimeString('id-ID', { hour: '2-digit', minute:'2-digit' }) + ' WITA';

                        tbody.innerHTML += `
                            <tr>
                                <td class="fw-bold" style="color: #111;">${item.nama}</td>
                                <td><span class="badge bg-light text-dark border border-secondary">${item.kategori}</span></td>
                                <td class="text-secondary">${item.asal_instansi || '-'}</td>
                                <td class="text-center"><small class="fw-semibold">${item.sesi_kunjungan}</small></td>
                                <td class="text-center"><span class="badge bg-dark px-2 text-gold">${item.jumlah_rombongan} Orang</span></td>
                                <td class="text-center text-muted small">${formatWaktu}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-dark me-1 shadow-sm" onclick="lihatDetailTujuan(${item.id})"><i class="bi bi-eye"></i></button>
                                    <button class="btn btn-sm btn-outline-danger shadow-sm" onclick="hapusDataPengunjung(${item.id})"><i class="bi bi-trash"></i></button>
                                </td>
                            </tr>
                        `;
                    });
                }
            }
        } catch (e) {
            document.getElementById('tabelDataPengunjung').innerHTML = '<tr><td colspan="7" class="text-center text-danger">Gagal menyinkronkan data tabel.</td></tr>';
        }

        try {
            const resStat = await fetch('/api/pengunjung/statistik', { 
                method: 'GET',
                headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' }
            });
            const resultStat = await resStat.json();

            if(resStat.ok && resultStat.data) {
                document.getElementById('statHariIni').innerText = resultStat.data.pengunjung_hari_ini;
                document.getElementById('statBulanIni').innerText = resultStat.data.pengunjung_bulan_ini;
                document.getElementById('statTotal').innerText = resultStat.data.total_keseluruhan;
            }
        } catch(e) {
            console.log("Statistik gagal dimuat.");
        }
    }

    function lihatDetailTujuan(id) {
        const pengunjung = dataPengunjungGlobal.find(item => item.id === id);
        if(pengunjung) {
            document.getElementById('detNama').innerText = pengunjung.nama;
            document.getElementById('detHp').innerText = pengunjung.no_hp ? pengunjung.no_hp : 'Tidak mencantumkan nomor HP';
            document.getElementById('detTujuan').innerText = pengunjung.tujuan_kunjungan ? pengunjung.tujuan_kunjungan : 'Kunjungan biasa / Wisata edukasi.';
            new bootstrap.Modal(document.getElementById('modalDetailTujuan')).show();
        }
    }

    function filterTabelPengunjung() {
        let input = document.getElementById("cariPengunjung").value.toLowerCase();
        let table = document.getElementById("tabelPengunjungUtama");
        let tr = table.getElementsByTagName("tr");

        for (let i = 1; i < tr.length; i++) {
            let tdNama = tr[i].getElementsByTagName("td")[0];
            let tdInstansi = tr[i].getElementsByTagName("td")[2];
            if (tdNama || tdInstansi) {
                let txtNama = tdNama.textContent || tdNama.innerText;
                let txtInstansi = tdInstansi.textContent || tdInstansi.innerText;
                if (txtNama.toLowerCase().indexOf(input) > -1 || txtInstansi.toLowerCase().indexOf(input) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    async function hapusDataPengunjung(id) {
        if (!confirm('Hapus data kunjungan ini?')) return;

        const token = localStorage.getItem('token');
        try {
            const response = await fetch('/api/pengunjung/' + id, { 
                method: 'DELETE',
                headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' }
            });

            if (response.ok) {
                alert('Data kunjungan berhasil dihapus.');
                initHalamanPengunjung();
            } else {
                alert('Gagal menghapus data.');
            }
        } catch (error) {
            alert('Kesalahan jaringan.');
        }
    }

    document.addEventListener('DOMContentLoaded', initHalamanPengunjung);
</script>
@endsection
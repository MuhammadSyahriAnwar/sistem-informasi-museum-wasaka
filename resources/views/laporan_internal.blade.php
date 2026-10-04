@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2 class="fw-bold mb-4" style="color: #7A1C1C;">Laporan Kendala Internal</h2>

    <!-- ==========================================
         BAGIAN 1: FORM UNTUK PETUGAS (Disembunyikan default)
         ========================================== -->
    <div id="formContainer" class="card mb-4 shadow-sm border-0" style="display:none;">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-4"><i class="bi bi-megaphone-fill text-danger me-2"></i>Buat Laporan Baru</h5>
            <form id="formLaporan" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold small text-muted">Kategori Kendala</label>
                        <select id="kategori" class="form-select border-secondary shadow-sm" required>
                            <option value="" selected disabled>Pilih Kategori...</option>
                            <option value="Koleksi">Koleksi Artefak / Pameran</option>
                            <option value="Fasilitas">Fasilitas Museum (Toilet, AC, dll)</option>
                            <option value="Keamanan">Keamanan / Ketertiban</option>
                            <option value="Lainnya">Lainnya (Barang Hilang, dll)</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold small text-muted">Judul Laporan</label>
                        <input type="text" id="judul" class="form-control border-secondary shadow-sm" placeholder="Singkat dan jelas..." required>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="fw-bold small text-muted">Deskripsi Detail</label>
                        <textarea id="deskripsi" class="form-control border-secondary shadow-sm" rows="3" placeholder="Jelaskan kendala yang terjadi di lapangan..." required></textarea>
                    </div>
                    <div class="col-12 mb-4">
                        <label class="fw-bold small text-muted">Upload Foto Bukti (Opsional)</label>
                        <input type="file" id="foto" class="form-control border-secondary shadow-sm" accept="image/*">
                        <small class="text-muted" style="font-size: 0.75rem;">Format: JPG, PNG. Maksimal 5MB.</small>
                    </div>
                    
                    <div class="col-12 text-end">
                        <button type="submit" class="btn fw-bold px-4 shadow-sm" style="background-color: #7A1C1C; color: white;">
                            <i class="bi bi-send-fill me-2"></i> Kirim Laporan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- ==========================================
         BAGIAN 2: TABEL KELOLA UNTUK ADMIN (Disembunyikan default)
         ========================================== -->
    <div id="containerDaftarLaporan" class="card shadow-sm border-0" style="display:none;">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-4">Daftar Laporan Masuk</h5>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="20%" class="py-3">Pelapor</th>
                            <th width="45%" class="py-3">Detail Laporan</th>
                            <th width="15%" class="text-center py-3">Status</th>
                            <th width="20%" class="text-center py-3">Tindakan (Admin)</th>
                        </tr>
                    </thead>
                    <tbody id="tabelLaporan">
                        <tr>
                            <td colspan="4" class="text-center text-muted py-5">
                                <div class="spinner-border spinner-border-sm text-secondary me-2"></div> Memuat data laporan...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script>
    // 1. Ambil data autentikasi dari LocalStorage
    const userRole = localStorage.getItem('role');
    const token = localStorage.getItem('token');

    if (!token) {
        window.location.href = '/login';
    }

    document.addEventListener('DOMContentLoaded', () => {
        // Logika Pintar: Tampilkan UI sesuai Role
        if (userRole === 'petugas') {
            document.getElementById('formContainer').style.display = 'block';
            setupFormPetugas();
        } else if (userRole === 'admin') {
            document.getElementById('containerDaftarLaporan').style.display = 'block';
            loadLaporanAdmin();
        } else {
            alert('Peran pengguna tidak dikenali.');
            window.location.href = '/dashboard';
        }
    });

    // ==========================================
    // FUNGSI KHUSUS PETUGAS (KIRIM LAPORAN)
    // ==========================================
    function setupFormPetugas() {
        const formLaporan = document.getElementById('formLaporan');
        
        formLaporan.addEventListener('submit', async function(e) {
            e.preventDefault();

            const btnSubmit = this.querySelector('button[type="submit"]');
            const originalBtnText = btnSubmit.innerHTML;
            btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mengirim...';
            btnSubmit.disabled = true;

            const formData = new FormData();
            formData.append('kategori', document.getElementById('kategori').value);
            formData.append('judul_laporan', document.getElementById('judul').value);
            formData.append('deskripsi', document.getElementById('deskripsi').value);
            formData.append('jenis_pelapor', 'Petugas'); 
            
            const fileFoto = document.getElementById('foto').files[0];
            if (fileFoto) {
                formData.append('foto', fileFoto);
            }

            try {
                const response = await fetch('/api/laporan-internal', {
                    method: 'POST',
                    headers: { 
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    },
                    body: formData
                });
                
                const result = await response.json();
                
                if(response.ok) {
                    alert('Laporan kendala berhasil dikirim ke Admin.');
                    formLaporan.reset(); 
                } else {
                    alert('Gagal mengirim laporan: ' + (result.message || 'Cek kembali isian Anda.'));
                }
            } catch (error) {
                alert('Terjadi kesalahan jaringan.');
            } finally {
                btnSubmit.innerHTML = originalBtnText;
                btnSubmit.disabled = false;
            }
        });
    }

    // ==========================================
    // FUNGSI KHUSUS ADMIN (TAMPILKAN & KELOLA DATA)
    // ==========================================
    async function loadLaporanAdmin() {
        try {
            const res = await fetch('/api/laporan-internal', {
                method: 'GET',
                headers: { 
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                }
            });
            
            const result = await res.json();
            const tbody = document.getElementById('tabelLaporan');
            tbody.innerHTML = '';

            if (res.ok && result.data && result.data.length > 0) {
                result.data.forEach(item => {
                    // Tombol Aksi (Tindakan)
                    let btnSelesai = item.status !== 'Selesai' 
                        ? `<button onclick="updateStatus(${item.id}, 'Selesai')" class="btn btn-sm btn-success me-2 shadow-sm" title="Tandai Selesai"><i class="bi bi-check2-circle"></i> Selesai</button>` 
                        : '';
                    
                    let aksiTd = `
                        <div class="d-flex justify-content-center align-items-center">
                            ${btnSelesai}
                            <button onclick="hapusLaporan(${item.id})" class="btn btn-sm btn-danger shadow-sm" title="Hapus Laporan"><i class="bi bi-trash-fill"></i></button>
                        </div>
                    `;

                    // Warna Status
                    let badgeColor = item.status === 'Selesai' ? 'bg-success' : 'bg-warning text-dark';
                    
                    // Format Tombol Bukti Foto (Hijau / Abu-abu)
                    let linkFoto = '';
                    if (item.foto) {
                        linkFoto = `<div class="mt-2"><a href="${item.foto}" target="_blank" class="badge bg-success text-white text-decoration-none p-2 shadow-sm"><i class="bi bi-image me-1"></i> Lihat Foto Bukti</a></div>`;
                    } else {
                        linkFoto = `<div class="mt-2"><span class="badge bg-secondary text-light p-2 shadow-sm" style="opacity: 0.7;"><i class="bi bi-image-alt me-1"></i> Tidak Ada Foto</span></div>`;
                    }

                    // Identifikasi Pelapor
                    let namaPelapor = item.jenis_pelapor === 'Pengunjung' 
                        ? `Pengunjung: ${item.nama_pelapor}` 
                        : (item.user ? item.user.name : 'Petugas / Internal');
                    let noHp = item.no_hp ? item.no_hp : '-';

                    // Bangun baris HTML yang persis dengan desain referensi
                    tbody.innerHTML += `
                        <tr class="border-bottom">
                            <td class="align-top py-3">
                                <span class="fw-bold text-dark" style="font-size: 1.05rem;">${namaPelapor}</span><br>
                                <small class="text-muted">${noHp}</small>
                            </td>
                            <td class="align-top py-3">
                                <span class="badge bg-light text-dark border mb-2 px-2 py-1">${item.kategori}</span><br>
                                <span class="fw-bold d-block mb-1" style="font-size: 1.1rem; color: #333;">${item.judul_laporan}</span>
                                <span class="text-muted d-block" style="font-size: 0.95rem;">${item.deskripsi}</span>
                                ${linkFoto}
                            </td>
                            <td class="text-center align-middle py-3">
                                <span class="badge ${badgeColor} px-3 py-2" style="font-size: 0.9rem;">${item.status}</span>
                            </td>
                            <td class="align-middle py-3">
                                ${aksiTd}
                            </td>
                        </tr>
                    `;
                });
            } else {
                tbody.innerHTML = '<tr><td colspan="4" class="text-center text-muted py-5">Belum ada catatan laporan saat ini.</td></tr>';
            }
        } catch (error) {
            document.getElementById('tabelLaporan').innerHTML = '<tr><td colspan="4" class="text-center text-danger py-5">Gagal memuat data dari server.</td></tr>';
        }
    }

    // Fungsi Ubah Status (Khusus Admin)
    async function updateStatus(id, status) {
        if(!confirm('Tandai laporan ini sebagai "Selesai"?')) return;
        
        try {
            const response = await fetch(`/api/laporan-internal/${id}/status`, {
                method: 'PUT',
                headers: { 
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ status: status })
            });
            
            if(response.ok) {
                loadLaporanAdmin(); 
            } else {
                alert('Gagal memperbarui status laporan.');
            }
        } catch (error) {
            alert('Terjadi kesalahan jaringan.');
        }
    }

    // Fungsi Hapus Laporan (Khusus Admin)
    async function hapusLaporan(id) {
        if(!confirm('Yakin ingin menghapus laporan ini secara permanen?')) return;
        
        try {
            const response = await fetch(`/api/laporan-internal/${id}`, {
                method: 'DELETE',
                headers: { 
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json' 
                }
            });
            
            if(response.ok) {
                loadLaporanAdmin();
            } else {
                alert('Gagal menghapus laporan.');
            }
        } catch (error) {
            alert('Terjadi kesalahan jaringan.');
        }
    }
</script>
@endsection
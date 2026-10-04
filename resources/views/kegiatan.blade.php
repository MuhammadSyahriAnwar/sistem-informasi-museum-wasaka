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
            url('/images/batik%20white 3.jpg');
        background-repeat: repeat;
        background-position: top center;
        background-size: 500px;
        background-attachment: fixed;
    }
    .card {
        background-color: rgba(255, 255, 255, 0.97) !important;
        backdrop-filter: blur(4px);
        border: none;
        border-top: 4px solid #111;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }
    .title-museum { font-family: 'Playfair Display', serif; color: #111; }
    .text-gold { color: #c5a059; }
    .btn-gold { background-color: #c5a059; color: #111; transition: 0.3s; border: none; }
    .btn-gold:hover { background-color: #d4b26f; color: #000; transform: translateY(-2px); }
    .btn-black { background-color: #111111; color: #fff; transition: 0.3s; }
    .btn-black:hover { background-color: #2a2a2a; color: #c5a059; }
    
    /* Styling Modal agar elegan */
    .modal-header-elegant {
        background-color: #111;
        border-bottom: 3px solid #c5a059;
        color: #fff;
    }
</style>

<!-- Header Halaman Kegiatan -->
<div class="row mb-4">
    <div class="col-md-8">
        <h2 class="fw-bold title-museum border-bottom pb-2" style="border-color: #c5a059 !important; display: inline-block;">Manajemen Kegiatan</h2>
        <p class="text-muted mt-2">Kelola data acara, pameran, dan kegiatan yang berlangsung di Museum Wasaka.</p>
    </div>
    <div class="col-md-4 text-end my-auto">
        <button type="button" class="btn btn-black fw-bold px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahKegiatan">
            <i class="bi bi-plus-circle me-1 text-gold"></i> Tambah Kegiatan Baru
        </button>
    </div>
</div>

<!-- Tabel Daftar Kegiatan -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="10%" class="text-uppercase small text-muted">Foto</th>
                                <th width="20%" class="text-uppercase small text-muted">Nama Kegiatan</th>
                                <th width="15%" class="text-uppercase small text-muted">Tanggal</th>
                                <th width="35%" class="text-uppercase small text-muted">Deskripsi</th>
                                <th width="20%" class="text-center text-uppercase small text-muted">Aksi</th>
                            </tr>
                        </thead>
                        
                        <tbody id="tabelDataKegiatan">
                            <tr>
                                <td colspan="5" class="text-center text-muted py-5">
                                    <div class="spinner-border text-secondary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <p class="mt-2 mb-0">Sedang memuat data kegiatan...</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- KUMPULAN MODAL (POP-UP)                    -->
<!-- ========================================== -->

<!-- 1. Modal Tambah Kegiatan -->
<div class="modal fade" id="modalTambahKegiatan" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header modal-header-elegant">
                <h5 class="modal-title fw-bold title-museum text-gold" id="modalTambahLabel">Formulir Kegiatan Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body p-4">
                <form id="formTambahKegiatan">
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label fw-bold small text-muted text-uppercase">Nama Kegiatan</label>
                            <input type="text" id="nama_kegiatan" class="form-control border-secondary bg-light" placeholder="Contoh: Pameran Hari Pahlawan" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold small text-muted text-uppercase">Tanggal Pelaksanaan</label>
                            <input type="date" id="tanggal_pelaksanaan" class="form-control border-secondary bg-light" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted text-uppercase">Deskripsi Kegiatan</label>
                        <textarea id="deskripsi" class="form-control border-secondary bg-light" rows="4" placeholder="Jelaskan detail acara ini..." required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted text-uppercase">Upload Foto Kegiatan</label>
                        <input type="file" id="foto_kegiatan" class="form-control border-secondary bg-light" accept="image/*" required>
                        <div class="form-text mt-2 text-muted">Format: JPG, JPEG, PNG. Maks: 5MB.</div>
                    </div>
                    
                    <div class="text-end mt-4">
                        <button type="button" class="btn btn-outline-dark px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" id="btnSimpanKegiatan" class="btn btn-gold fw-bold px-4 ms-2">Simpan Kegiatan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- 2. Modal Edit Kegiatan -->
<div class="modal fade" id="modalEditKegiatan" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header modal-header-elegant">
                <h5 class="modal-title fw-bold title-museum text-gold" id="modalEditLabel">Edit Data Kegiatan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body p-4">
                <form id="formEditKegiatan">
                    <input type="hidden" id="edit_id_kegiatan">

                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label fw-bold small text-muted text-uppercase">Nama Kegiatan</label>
                            <input type="text" id="edit_nama_kegiatan" class="form-control border-secondary bg-light" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold small text-muted text-uppercase">Tanggal Pelaksanaan</label>
                            <input type="date" id="edit_tanggal_pelaksanaan" class="form-control border-secondary bg-light" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted text-uppercase">Deskripsi Kegiatan</label>
                        <textarea id="edit_deskripsi" class="form-control border-secondary bg-light" rows="4" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted text-uppercase">Upload Foto Baru (Opsional)</label>
                        <input type="file" id="edit_foto_kegiatan" class="form-control border-secondary bg-light" accept="image/*">
                        <div class="form-text mt-2 text-muted">*Biarkan kosong jika tidak mengubah foto saat ini.</div>
                    </div>
                    
                    <div class="text-end mt-4">
                        <button type="button" class="btn btn-outline-dark px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" id="btnUpdateKegiatan" class="btn btn-gold fw-bold px-4 ms-2">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- SCRIPT JAVASCRIPT FULL CRUD KEGIATAN       -->
<!-- ========================================== -->
<script>
    let dataKegiatanGlobal = [];

    // ==========================================
    // 1. READ (Menampilkan Data)
    // ==========================================
    async function loadDataKegiatan() {
        const token = localStorage.getItem('token');
        const tbody = document.getElementById('tabelDataKegiatan');

        try {
            const response = await fetch('/api/kegiatan', {
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                }
            });

            const result = await response.json();

            if (response.ok) {
                tbody.innerHTML = ''; 
                dataKegiatanGlobal = result.data; 

                if (dataKegiatanGlobal.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="5" class="text-center text-muted py-5">Belum ada data kegiatan.</td></tr>';
                    return;
                }

                dataKegiatanGlobal.forEach(item => {
                    let imgHtml = `<div style="width: 60px; height: 60px; background-color: #e9ecef; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #6c757d;"><small>No Image</small></div>`;
                    
                    if (item.foto_kegiatan) {
                        imgHtml = `<img src="/storage/kegiatan/${item.foto_kegiatan}" alt="${item.nama_kegiatan}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">`;
                    }

                    let tgl = new Date(item.tanggal_pelaksanaan);
                    let formatTgl = tgl.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });

                    let row = `
                        <tr>
                            <td>${imgHtml}</td>
                            <td class="fw-bold" style="color: #111;">${item.nama_kegiatan}</td>
                            <td><span class="badge bg-light text-dark border border-secondary px-2">${formatTgl}</span></td>
                            <td class="text-secondary text-truncate" style="max-width: 250px;">${item.deskripsi}</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-dark me-1 shadow-sm" onclick="bukaModalEdit(${item.id})"><i class="bi bi-pencil-square"></i></button>
                                <button class="btn btn-sm btn-outline-danger shadow-sm" onclick="hapusKegiatan(${item.id})"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                    `;
                    tbody.innerHTML += row;
                });
            } else {
                tbody.innerHTML = `<tr><td colspan="5" class="text-center text-danger py-4">Gagal memuat data.</td></tr>`;
            }
        } catch (error) {
            tbody.innerHTML = `<tr><td colspan="5" class="text-center text-danger py-4">Terjadi kesalahan koneksi.</td></tr>`;
        }
    }

    document.addEventListener('DOMContentLoaded', loadDataKegiatan);

    // ==========================================
    // 2. CREATE (Tambah Data)
    // ==========================================
    const formTambah = document.getElementById('formTambahKegiatan');
    if (formTambah) {
        formTambah.addEventListener('submit', async function(e) {
            e.preventDefault(); 

            const btnSubmit = document.getElementById('btnSimpanKegiatan');
            btnSubmit.innerHTML = 'Menyimpan...';
            btnSubmit.disabled = true;

            const token = localStorage.getItem('token');
            const formData = new FormData();
            formData.append('nama_kegiatan', document.getElementById('nama_kegiatan').value);
            formData.append('tanggal_pelaksanaan', document.getElementById('tanggal_pelaksanaan').value);
            formData.append('deskripsi', document.getElementById('deskripsi').value);
            formData.append('foto_kegiatan', document.getElementById('foto_kegiatan').files[0]);

            try {
                const response = await fetch('/api/kegiatan', {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                if (response.ok) {
                    alert('Berhasil! Kegiatan baru ditambahkan.');
                    window.location.reload(); 
                } else {
                    const result = await response.json();
                    alert('Gagal: ' + JSON.stringify(result));
                    btnSubmit.innerHTML = 'Simpan Kegiatan';
                    btnSubmit.disabled = false;
                }
            } catch (error) {
                alert('Terjadi kesalahan server.');
                btnSubmit.innerHTML = 'Simpan Kegiatan';
                btnSubmit.disabled = false;
            }
        });
    }

    // ==========================================
    // 3. DELETE (Hapus Data)
    // ==========================================
    async function hapusKegiatan(id) {
        if (!confirm('Hapus kegiatan ini?')) return;

        const token = localStorage.getItem('token');
        try {
            const response = await fetch('/api/kegiatan/' + id, {
                method: 'DELETE',
                headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' }
            });

            if (response.ok) loadDataKegiatan(); 
            else alert('Gagal menghapus data.');
        } catch (error) {
            alert('Kesalahan jaringan.');
        }
    }

    // ==========================================
    // 4. UPDATE (Edit Data)
    // ==========================================
    function bukaModalEdit(id) {
        const dataEdit = dataKegiatanGlobal.find(item => item.id === id);
        if(dataEdit) {
            document.getElementById('edit_id_kegiatan').value = dataEdit.id;
            document.getElementById('edit_nama_kegiatan').value = dataEdit.nama_kegiatan;
            
            document.getElementById('edit_tanggal_pelaksanaan').value = dataEdit.tanggal_pelaksanaan.substring(0, 10); 
            
            document.getElementById('edit_deskripsi').value = dataEdit.deskripsi;
            document.getElementById('edit_foto_kegiatan').value = ''; 

            new bootstrap.Modal(document.getElementById('modalEditKegiatan')).show();
        }
    }

    const formEdit = document.getElementById('formEditKegiatan');
    if (formEdit) {
        formEdit.addEventListener('submit', async function(e) {
            e.preventDefault();
            const btnSubmit = document.getElementById('btnUpdateKegiatan');
            btnSubmit.innerHTML = 'Menyimpan...';
            btnSubmit.disabled = true;

            const token = localStorage.getItem('token');
            const idKegiatan = document.getElementById('edit_id_kegiatan').value;

            const formData = new FormData();
            formData.append('nama_kegiatan', document.getElementById('edit_nama_kegiatan').value);
            formData.append('tanggal_pelaksanaan', document.getElementById('edit_tanggal_pelaksanaan').value);
            formData.append('deskripsi', document.getElementById('edit_deskripsi').value);
            
            const fotoBaru = document.getElementById('edit_foto_kegiatan').files[0];
            if(fotoBaru) formData.append('foto_kegiatan', fotoBaru); 

            try {
                const response = await fetch('/api/kegiatan/' + idKegiatan, {
                    method: 'POST', 
                    headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' },
                    body: formData
                });

                if (response.ok) {
                    alert('Data diperbarui!');
                    window.location.reload(); 
                } else {
                    alert('Gagal update.');
                    btnSubmit.innerHTML = 'Simpan Perubahan';
                    btnSubmit.disabled = false;
                }
            } catch (error) {
                alert('Kesalahan server.');
                btnSubmit.innerHTML = 'Simpan Perubahan';
                btnSubmit.disabled = false;
            }
        });
    }
</script>
@endsection
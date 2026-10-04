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
            url('/images/batik%20white2.jpg');
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

<div class="row mb-4">
    <div class="col-md-8">
        <h2 class="fw-bold title-museum border-bottom pb-2" style="border-color: #c5a059 !important; display: inline-block;">Manajemen Koleksi</h2>
        <p class="text-muted mt-2">Kelola data peninggalan sejarah dan artefak perjuangan Museum Wasaka.</p>
    </div>
    <div class="col-md-4 text-end my-auto">
        <button type="button" class="btn btn-black fw-bold px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahKoleksi">
            <i class="bi bi-plus-circle me-1 text-gold"></i> Tambah Koleksi Baru
        </button>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="10%" class="text-uppercase small text-muted">Foto</th>
                                <th width="20%" class="text-uppercase small text-muted">Nama Koleksi</th>
                                <th width="20%" class="text-uppercase small text-muted">Kategori</th> 
                                <th width="35%" class="text-uppercase small text-muted">Deskripsi Singkat</th>
                                <th width="15%" class="text-center text-uppercase small text-muted">Aksi</th>
                            </tr>
                        </thead>
                        
                        <tbody id="tabelDataKoleksi">
                            <tr>
                                <td colspan="5" class="text-center text-muted py-5">
                                    <div class="spinner-border text-secondary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <p class="mt-2 mb-0">Sedang memuat data koleksi...</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH -->
<div class="modal fade" id="modalTambahKoleksi" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header modal-header-elegant">
                <h5 class="modal-title fw-bold title-museum text-gold" id="modalTambahLabel">Formulir Koleksi Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body p-4">
                <form id="formTambahKoleksi">
                    <div class="row">
                        <div class="col-md-7 mb-3">
                            <label class="form-label fw-bold small text-muted text-uppercase">Nama Koleksi / Artefak</label>
                            <input type="text" id="nama_koleksi" class="form-control border-secondary bg-light" placeholder="Contoh: Keris Pusaka..." required>
                        </div>
                        
                        <div class="col-md-5 mb-3">
                            <label class="form-label fw-bold small text-muted text-uppercase">Kategori</label>
                            <select id="kategori_id" class="form-select border-secondary bg-light" required>
                                <option value="" selected disabled>Memuat Kategori...</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted text-uppercase">Deskripsi Sejarah</label>
                        <textarea id="deskripsi" class="form-control border-secondary bg-light" rows="4" placeholder="Ceritakan nilai sejarah dari koleksi ini..." required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted text-uppercase">Upload Foto Koleksi</label>
                        <input type="file" id="foto_koleksi" class="form-control border-secondary bg-light" accept="image/*" required>
                        <div class="form-text mt-2 text-muted">
                            Format yang didukung: JPG, JPEG, PNG. Maksimal ukuran file 5MB.
                        </div>
                    </div>
                    
                    <div class="text-end mt-4">
                        <button type="button" class="btn btn-outline-dark px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" id="btnSimpanKoleksi" class="btn btn-gold fw-bold px-4 ms-2">Simpan Koleksi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- MODAL EDIT -->
<div class="modal fade" id="modalEditKoleksi" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header modal-header-elegant">
                <h5 class="modal-title fw-bold title-museum text-gold" id="modalEditLabel">Edit Data Koleksi</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body p-4">
                <form id="formEditKoleksi">
                    <input type="hidden" id="edit_id_koleksi">

                    <div class="row">
                        <div class="col-md-7 mb-3">
                            <label class="form-label fw-bold small text-muted text-uppercase">Nama Koleksi / Artefak</label>
                            <input type="text" id="edit_nama_koleksi" class="form-control border-secondary bg-light" required>
                        </div>
                        
                        <div class="col-md-5 mb-3">
                            <label class="form-label fw-bold small text-muted text-uppercase">Kategori</label>
                            <select id="edit_kategori_id" class="form-select border-secondary bg-light" required>
                                <option value="" selected disabled>Memuat Kategori...</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted text-uppercase">Deskripsi Sejarah</label>
                        <textarea id="edit_deskripsi" class="form-control border-secondary bg-light" rows="4" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted text-uppercase">Upload Foto Baru (Opsional)</label>
                        <input type="file" id="edit_foto_koleksi" class="form-control border-secondary bg-light" accept="image/*">
                        <div class="form-text mt-2 text-muted">
                            *Biarkan kosong jika tidak ingin mengubah foto saat ini.
                        </div>
                    </div>
                    
                    <div class="text-end mt-4">
                        <button type="button" class="btn btn-outline-dark px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" id="btnUpdateKoleksi" class="btn btn-gold fw-bold px-4 ms-2">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let dataKoleksiGlobal = [];

    // ==========================================
    // FUNGSI KHUSUS: Mengambil Data Kategori untuk Dropdown
    // ==========================================
    async function loadKategori() {
        const token = localStorage.getItem('token');
        try {
            const response = await fetch('/api/kategori', {
                headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' }
            });
            const result = await response.json();
            
            if(response.ok) {
                const selectTambah = document.getElementById('kategori_id');
                const selectEdit = document.getElementById('edit_kategori_id');
                
                let opsi = '<option value="" selected disabled>Pilih Kategori...</option>';
                result.data.forEach(kat => {
                    opsi += `<option value="${kat.id}">${kat.nama_kategori}</option>`;
                });

                selectTambah.innerHTML = opsi;
                selectEdit.innerHTML = opsi;
            }
        } catch (e) {
            console.log("Gagal memuat kategori", e);
        }
    }

    // ==========================================
    // 1. READ (Menampilkan Data)
    // ==========================================
    async function loadDataKoleksi() {
        const token = localStorage.getItem('token');
        const tbody = document.getElementById('tabelDataKoleksi');

        try {
            const response = await fetch('/api/koleksi', {
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                }
            });

            const result = await response.json();

            if (response.ok) {
                tbody.innerHTML = ''; 
                dataKoleksiGlobal = result.data; 

                if (dataKoleksiGlobal.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="5" class="text-center text-muted py-5">Belum ada data koleksi yang terdaftar.</td></tr>';
                    return;
                }

                dataKoleksiGlobal.forEach(item => {
                    let imgHtml = `<div style="width: 60px; height: 60px; background-color: #e9ecef; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #6c757d;"><small>No Image</small></div>`;
                    if (item.foto) {
                        imgHtml = `<img src="/storage/koleksi/${item.foto}" alt="${item.nama_koleksi}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">`;
                    }
                    
                    let namaKategori = item.kategori ? item.kategori.nama_kategori : '-';

                    let row = `
                        <tr>
                            <td>${imgHtml}</td>
                            <td class="fw-bold" style="color: #111;">${item.nama_koleksi}</td>
                            <td><span class="badge bg-light text-dark border border-secondary px-2">${namaKategori}</span></td>
                            <td class="text-secondary text-truncate" style="max-width: 250px;">${item.deskripsi}</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-dark me-1 shadow-sm" onclick="bukaModalEdit(${item.id})"><i class="bi bi-pencil-square"></i></button>
                                <button class="btn btn-sm btn-outline-danger shadow-sm" onclick="hapusKoleksi(${item.id})"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                    `;
                    tbody.innerHTML += row;
                });
            } else {
                tbody.innerHTML = `<tr><td colspan="5" class="text-center text-danger py-4">Gagal memuat data.</td></tr>`;
            }
        } catch (error) {
            tbody.innerHTML = `<tr><td colspan="5" class="text-center text-danger py-4">Terjadi kesalahan koneksi server.</td></tr>`;
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        loadKategori();
        loadDataKoleksi();
    });

    // ==========================================
    // 2. CREATE (Tambah Data)
    // ==========================================
    const formTambah = document.getElementById('formTambahKoleksi');
    if (formTambah) {
        formTambah.addEventListener('submit', async function(e) {
            e.preventDefault(); 

            const btnSubmit = document.getElementById('btnSimpanKoleksi');
            btnSubmit.innerHTML = 'Mengupload...';
            btnSubmit.disabled = true;

            const token = localStorage.getItem('token');
            if(!token) {
                alert('Sesi Anda habis. Silakan login ulang.');
                window.location.href = '/';
                return;
            }

            const formData = new FormData();
            formData.append('nama_koleksi', document.getElementById('nama_koleksi').value);
            formData.append('kategori_id', document.getElementById('kategori_id').value);
            formData.append('deskripsi', document.getElementById('deskripsi').value);
            formData.append('foto', document.getElementById('foto_koleksi').files[0]);

            try {
                const response = await fetch('/api/koleksi', {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                if (response.ok) {
                    alert('Berhasil! Koleksi baru ditambahkan.');
                    window.location.reload(); 
                } else {
                    alert('Gagal menyimpan: Cek kembali form Anda.');
                    btnSubmit.innerHTML = 'Simpan Koleksi';
                    btnSubmit.disabled = false;
                }
            } catch (error) {
                alert('Terjadi kesalahan server.');
                btnSubmit.innerHTML = 'Simpan Koleksi';
                btnSubmit.disabled = false;
            }
        });
    }

    // ==========================================
    // 3. DELETE (Hapus Data)
    // ==========================================
    async function hapusKoleksi(id) {
        const konfirmasi = confirm('Apakah Anda yakin ingin menghapus data koleksi ini?');
        if (!konfirmasi) return;

        const token = localStorage.getItem('token');
        try {
            const response = await fetch('/api/koleksi/' + id, {
                method: 'DELETE',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                }
            });

            if (response.ok) {
                alert('Berhasil dihapus!');
                loadDataKoleksi(); 
            } else {
                alert('Gagal menghapus data.');
            }
        } catch (error) {
            alert('Terjadi kesalahan server.');
        }
    }

    // ==========================================
    // 4. UPDATE (Edit Data)
    // ==========================================
    function bukaModalEdit(id) {
        const dataEdit = dataKoleksiGlobal.find(item => item.id === id);
        
        if(dataEdit) {
            document.getElementById('edit_id_koleksi').value = dataEdit.id;
            document.getElementById('edit_nama_koleksi').value = dataEdit.nama_koleksi;
            document.getElementById('edit_kategori_id').value = dataEdit.kategori_id; 
            document.getElementById('edit_deskripsi').value = dataEdit.deskripsi;
            document.getElementById('edit_foto_koleksi').value = ''; 

            const modalEdit = new bootstrap.Modal(document.getElementById('modalEditKoleksi'));
            modalEdit.show();
        }
    }

    const formEdit = document.getElementById('formEditKoleksi');
    if (formEdit) {
        formEdit.addEventListener('submit', async function(e) {
            e.preventDefault();

            const btnSubmit = document.getElementById('btnUpdateKoleksi');
            btnSubmit.innerHTML = 'Menyimpan...';
            btnSubmit.disabled = true;

            const token = localStorage.getItem('token');
            const idKoleksi = document.getElementById('edit_id_koleksi').value;

            const formData = new FormData();
            formData.append('nama_koleksi', document.getElementById('edit_nama_koleksi').value);
            formData.append('kategori_id', document.getElementById('edit_kategori_id').value);
            formData.append('deskripsi', document.getElementById('edit_deskripsi').value);
            
            const fotoBaru = document.getElementById('edit_foto_koleksi').files[0];
            if(fotoBaru) {
                formData.append('foto', fotoBaru);
            }

            try {
                const response = await fetch('/api/koleksi/' + idKoleksi, {
                    method: 'POST', 
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                if (response.ok) {
                    alert('Berhasil! Data telah diperbarui.');
                    window.location.reload(); 
                } else {
                    alert('Gagal update data.');
                    btnSubmit.innerHTML = 'Simpan Perubahan';
                    btnSubmit.disabled = false;
                }
            } catch (error) {
                alert('Terjadi kesalahan server.');
                btnSubmit.innerHTML = 'Simpan Perubahan';
                btnSubmit.disabled = false;
            }
        });
    }
</script>
@endsection
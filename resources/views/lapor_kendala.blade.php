@extends('layouts.guest')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap');

    html, body {
        background-color: #f8f9fa;
        font-family: 'Plus Jakarta Sans', sans-serif;
        overflow-x: hidden !important; 
    }

    /* =========================================================
       EFEK BACKGROUND BATIK FADING TERANG
       ========================================================= */
    .bg-light-batik {
        background-image: 
            linear-gradient(to bottom, rgba(248, 249, 250, 0.85), rgba(248, 249, 250, 0.98)),
            url('{{ asset('images/sasirangan.png') }}');
        background-size: 500px; 
        background-repeat: repeat; 
        background-position: center top;
        background-attachment: fixed; 
        
        width: 100vw;
        position: relative;
        left: 50%;
        transform: translateX(-50%);
    }

    .card-museum-proportional {
        background-color: rgba(255, 255, 255, 0.95) !important;
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.08) !important;
        border: 1px solid rgba(0, 0, 0, 0.05) !important;
        border-top: 4px solid #111111 !important; /* Disamakan dengan dashboard/login */
        border-radius: 12px !important;
    }

    .form-control, .form-select {
        background-color: #fcfcfc !important;
        border: 1px solid #ced4da;
        border-radius: 6px;
        padding: 0.7rem 1rem;
        font-size: 0.9rem;
        color: #333333 !important;
        transition: all 0.3s ease;
    }

    .form-control::placeholder {
        color: #999999;
        font-weight: 300;
        font-size: 0.85rem;
    }

    .form-control:focus, .form-select:focus {
        border-color: #C5A059;
        box-shadow: 0 0 0 2px rgba(197, 160, 89, 0.2);
        background-color: #ffffff !important;
        outline: none;
    }

    option {
        background-color: #ffffff;
        color: #333333;
    }

    .form-label-custom {
        font-size: 0.75rem;
        font-weight: 700;
        color: #555555;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .text-danger { color: #dc3545 !important; }

    .btn-submit-proportional {
        background: #C5A059; 
        color: #111111;
        border: none;
        border-radius: 6px;
        padding: 0.85rem 1.5rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }

    .btn-submit-proportional:hover {
        background: #d4b26f;
        color: #000000;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(197, 160, 89, 0.25);
    }
    
    input[type=file]::file-selector-button {
        background: rgba(197, 160, 89, 0.1);
        border: 1px solid rgba(197, 160, 89, 0.3);
        color: #111111;
        padding: 0.3rem 0.8rem;
        border-radius: 4px;
        margin-right: 10px;
        transition: all 0.2s;
        font-size: 0.85rem;
        font-weight: 600;
    }
    
    input[type=file]::file-selector-button:hover {
        background: rgba(197, 160, 89, 0.3);
    }
</style>

<div class="bg-light-batik py-5" style="min-height: 100vh; display: flex; align-items: center;">
    <div class="container">
        <div class="row justify-content-center">
            
            <div class="col-xl-7 col-lg-8 col-md-10">
                
                <!-- Header -->
                <div class="text-center mb-4">
                    <h2 class="fw-bold mb-2" style="letter-spacing: 3px; text-transform: uppercase; color: #111111; font-family: 'Playfair Display', serif;">
                        Lapor Kendala
                    </h2>
                    <div style="width: 40px; height: 3px; background-color: #C5A059; margin: 0 auto;"></div>
                </div>

                <!-- Form Card -->
                <div class="card card-museum-proportional border-0 p-4 p-md-5">
                    <form id="formLaporKendala" enctype="multipart/form-data">
                        
                        <div class="row g-4">
                            
                            <!-- BARIS 1 -->
                            <div class="col-md-6">
                                <label class="form-label-custom">Nama Pelapor <span class="text-danger">*</span></label>
                                <input type="text" id="nama_pelapor" class="form-control" placeholder="Masukkan Nama" required>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label-custom">No. Telepon / WA <span class="text-danger">*</span></label>
                                <input type="tel" id="no_hp" class="form-control" placeholder="0812xxxxxx" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                            </div>

                            <!-- BARIS 2 -->
                            <div class="col-md-5">
                                <label class="form-label-custom">Kategori <span class="text-danger">*</span></label>
                                <select id="kategori" class="form-select" required>
                                    <option value="" selected disabled>Pilih Kategori...</option>
                                    <option value="Koleksi">Koleksi Artefak / Pameran</option>
                                    <option value="Fasilitas">Fasilitas Museum</option>
                                    <option value="Keamanan">Keamanan / Ketertiban</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>

                            <div class="col-md-7">
                                <label class="form-label-custom">Judul Laporan <span class="text-danger">*</span></label>
                                <input type="text" id="judul" class="form-control" placeholder="Cth: Lampu area Diorama redup" required>
                            </div>

                            <!-- BARIS 3 -->
                            <div class="col-12">
                                <label class="form-label-custom" style="display: flex; justify-content: space-between; width: 100%;">
                                    <span>Upload Bukti Foto <span style="text-transform: none; color: #888; font-weight: 400;">(Opsional)</span></span>
                                    <span style="text-transform: none; color: #888; font-weight: 400; font-size: 0.75rem;">Maks: 5MB</span>
                                </label>
                                <input type="file" id="foto" class="form-control" accept="image/jpeg, image/png, image/jpg" style="padding: 0.45rem 0.8rem;">
                            </div>

                            <!-- BARIS 4 -->
                            <div class="col-12">
                                <label class="form-label-custom">Deskripsi Detail <span class="text-danger">*</span></label>
                                <textarea id="deskripsi" class="form-control" rows="5" placeholder="Tuliskan detail kendala serta lokasi spesifiknya secara lengkap di sini..." required></textarea>
                            </div>

                            <!-- BARIS 5 -->
                            <div class="col-12 mt-4">
                                <button type="submit" id="btnSubmitLaporan" class="btn btn-submit-proportional w-100">
                                    <i class="bi bi-send-fill me-2"></i> KIRIM PESAN LAPORAN
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    <!-- Pesan Sukses -->
                    <div id="pesanSukses" class="text-center d-none py-5">
                        <i class="bi bi-shield-check" style="font-size: 4rem; color: #C5A059;"></i>
                        <h4 class="fw-bold mt-3" style="font-family: 'Playfair Display', serif; color: #111111;">Laporan Diterima</h4>
                        <div style="width: 30px; height: 3px; background-color: #C5A059; margin: 15px auto;"></div>
                        <p class="mb-4 text-muted" style="font-size: 0.95rem;">Terima kasih atas kepedulian Anda. Petugas kami akan segera menindaklanjutinya.</p>
                        <a href="/" class="btn btn-outline-dark px-4 py-2" style="border-radius: 50px; font-size: 0.9rem; letter-spacing: 1px;">KEMBALI KE BERANDA</a>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const formLapor = document.getElementById('formLaporKendala');
    
    if (formLapor) {
        formLapor.addEventListener('submit', async function(e) {
            e.preventDefault();

            const btnSubmit = document.getElementById('btnSubmitLaporan');
            const originalBtnText = btnSubmit.innerHTML;
            btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>MENGIRIM...';
            btnSubmit.disabled = true;

            const formData = new FormData();
            formData.append('nama_pelapor', document.getElementById('nama_pelapor').value);
            formData.append('no_hp', document.getElementById('no_hp').value);
            formData.append('jenis_pelapor', 'Pengunjung'); 
            
            formData.append('kategori', document.getElementById('kategori').value);
            formData.append('judul_laporan', document.getElementById('judul').value);
            formData.append('deskripsi', document.getElementById('deskripsi').value);
            
            const fileFoto = document.getElementById('foto').files[0];
            if (fileFoto) {
                if(fileFoto.size > 5 * 1024 * 1024) {
                    Swal.fire({ icon: 'warning', title: 'File Terlalu Besar', text: 'Maksimal ukuran foto adalah 5MB.', confirmButtonColor: '#C5A059' });
                    btnSubmit.innerHTML = originalBtnText;
                    btnSubmit.disabled = false;
                    return;
                }
                formData.append('foto', fileFoto);
            }

            try {
                const response = await fetch('/api/lapor_kendala', {
                    method: 'POST',
                    headers: { 
                        'Accept': 'application/json' 
                    },
                    body: formData
                });
                
                const result = await response.json();
                
                if(response.ok) {
                    formLapor.classList.add('d-none'); 
                    document.getElementById('pesanSukses').classList.remove('d-none');
                } else {
                    let errorMsg = result.message || 'Gagal mengirim laporan. Periksa kembali form Anda.';
                    if(result.errors) {
                        errorMsg = Object.values(result.errors).flat().join('\n');
                    }
                    Swal.fire({ icon: 'error', title: 'Gagal', text: errorMsg, confirmButtonColor: '#C5A059' });
                }
            } catch (error) {
                Swal.fire({ icon: 'error', title: 'Koneksi Terputus', text: 'Terjadi kesalahan pada jaringan atau server peladen.', confirmButtonColor: '#C5A059' });
            } finally {
                btnSubmit.innerHTML = originalBtnText;
                btnSubmit.disabled = false;
            }
        });
    }
</script>
@endsection
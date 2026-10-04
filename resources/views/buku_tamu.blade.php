@extends('layouts.guest')

@section('content')

<style>
    .bg-sasirangan-watermark {
        /* Latar belakang sasirangan dengan efek pudar/gradasi */
        background-image: 
            linear-gradient(to bottom, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.75) 100%),
            url('{{ asset('images/batik white4.jpg') }}');
        
        background-size: 400px; /* Gunakan 'cover' jika ingin 1 gambar ditarik full tanpa diulang */
        background-repeat: repeat; 
        background-position: center;
        background-attachment: fixed; 

        /* Trik CSS untuk menembus batas container bawaan agar full width ke ujung layar */
        width: 100vw;
        position: relative;
        left: 50%;
        right: 50%;
        margin-left: -50vw;
        margin-right: -50vw;
    }
</style>

<!-- Class bg-sasirangan-watermark diterapkan pada div pembungkus utama -->
<div class="bg-sasirangan-watermark py-4" style="min-height: 100vh;">
    <!-- Container tambahan untuk menjaga agar form tetap rapi di tengah -->
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-7">
                
                <div class="text-center mb-4 p-3 rounded" style="background-color: rgba(255,255,255,0.8);">
                    <h2 class="fw-bold mb-2" style="letter-spacing: 2px; text-transform: uppercase; color: #1a1a1a; font-family: 'Playfair Display', serif;">
                        Buku Tamu Digital
                    </h2>
                    <div style="width: 50px; height: 3px; background-color: #C5A059; margin: 0 auto;"></div>
                    <p class="mt-2 text-muted mb-0" style="font-size: 0.9rem;">Silakan isi data kunjungan Anda sebagai bentuk dokumentasi kehadiran di Museum Wasaka.</p>
                </div>

                <div class="card card-museum border-0 shadow-sm mb-3" style="border-left: 4px solid #C5A059; background-color: #ffffff;">
                    <div class="card-body p-2 px-3 d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px; border: 1px solid #C5A059;">
                                <div class="spinner-border spinner-border-sm text-secondary" id="loadingCuaca" role="status"></div>
                                <img id="ikonCuaca" src="" alt="Ikon Cuaca" style="width: 40px; display: none;">
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0" style="color: #1a1a1a; font-size: 0.85rem;">Cuaca Daerah Hari Ini</h6>
                                <p class="mb-0 text-muted" id="deskripsiCuaca" style="font-size: 0.75rem;">Memuat pantauan cuaca...</p>
                            </div>
                        </div>
                        <div class="text-end">
                            <h3 class="fw-bold mb-0" style="color: #C5A059;" id="suhuCuaca">--°C</h3>
                            <small class="text-muted" style="font-size: 0.7rem;">Banjarmasin</small>
                        </div>
                    </div>
                </div>

                <div class="card card-museum shadow-lg p-3 p-md-4" style="border-top: 4px solid #C5A059; border-radius: 8px; background-color: #ffffff;">
                    <form id="formBukuTamu">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="fw-bold text-muted mb-1" style="font-size: 0.8rem;">Nama Lengkap / Rombongan</label>
                                <input type="text" id="input_nama" class="form-control bg-light" placeholder="Contoh: Budi Santoso" required>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="fw-bold text-muted mb-1" style="font-size: 0.8rem;">Kategori Pengunjung</label>
                                <select id="input_kategori" class="form-select bg-light" required>
                                    <option value="" selected disabled>Pilih Kategori...</option>
                                    <option value="Pelajar/Mahasiswa">Pelajar / Mahasiswa</option>
                                    <option value="Umum">Masyarakat Umum</option>
                                    <option value="Instansi">Instansi / Peneliti</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="fw-bold text-muted mb-1" style="font-size: 0.8rem;">Instansi / Asal Daerah</label>
                                <input type="text" id="input_instansi" class="form-control bg-light" placeholder="Contoh: Universitas Lambung Mangkurat">
                            </div>

                            <div class="col-md-6">
                                <label class="fw-bold text-muted mb-1" style="font-size: 0.8rem;">Nomor HP / WhatsApp</label>
                                <input type="tel" id="input_hp" class="form-control bg-light" placeholder="Contoh: 0812xxxxxx" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                <small class="text-muted mt-1 d-block" style="font-size: 0.7rem;">*Opsional, dapat dikosongkan</small>
                            </div>

                            <div class="col-md-6">
                                <label class="fw-bold text-muted mb-1" style="font-size: 0.8rem;">Sesi Kunjungan</label>
                                <select id="input_sesi" class="form-select bg-light" required>
                                    <option value="" selected disabled>Pilih Sesi...</option>
                                    <option value="Sesi Pagi (09.00 - 12.00 WITA)">Sesi Pagi (09.00 - 12.00 WITA)</option>
                                    <option value="Sesi Siang (13.00 - 15.00 WITA)">Sesi Siang (13.00 - 15.00 WITA)</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="fw-bold text-muted mb-1" style="font-size: 0.8rem;">Jumlah Rombongan</label>
                                <input type="number" id="input_jumlah" class="form-control bg-light" placeholder="Misal: 1" min="1" max="30" value="1" required>
                            </div>

                            <div class="col-12">
                                <label class="fw-bold text-muted mb-1" style="font-size: 0.8rem;">Tujuan Kunjungan</label>
                                <textarea id="input_tujuan" class="form-control bg-light" rows="2" placeholder="Contoh: Tugas sejarah, wisata edukasi, dll."></textarea>
                            </div>

                            <div class="col-12 text-center mt-3">
                                <button type="submit" id="btnSubmitTamu" class="btn btn-museum px-4 py-2 fw-bold w-100" style="letter-spacing: 1px; background: linear-gradient(135deg, #2b2b2b 0%, #000000 100%); color: #C5A059; border: 1px solid #C5A059; border-radius:6px; transition: 0.3s; font-size: 0.95rem;">
                                    <i class="bi bi-send-fill me-2"></i> KIRIM KEHADIRAN
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    <div id="pesanSukses" class="text-center d-none py-4">
                        <i class="bi bi-check-circle-fill" style="font-size: 4rem; color: #C5A059;"></i>
                        <h4 class="fw-bold mt-3" style="font-family: 'Playfair Display', serif;">Terima Kasih!</h4>
                        <p class="text-muted" style="font-size: 1rem;">Data kunjungan Anda telah berhasil dicatat di buku tamu digital kami.</p>
                        <a href="/" class="btn btn-outline-dark rounded-pill px-4 mt-2 fw-bold" style="font-size: 0.9rem;">Kembali ke Beranda</a>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // 1. Fungsi Tarik Data Cuaca
    async function tarikDataCuaca() {
        const apiKey = '813b6806e1bf073d6a3a46651f894e6d'; 
        const kota = 'Banjarmasin';
        const url = `https://api.openweathermap.org/data/2.5/weather?q=${kota}&appid=${apiKey}&units=metric&lang=id`;

        try {
            const response = await fetch(url);
            const data = await response.json();

            if (response.ok) {
                document.getElementById('loadingCuaca').style.display = 'none';
                const imgIcon = document.getElementById('ikonCuaca');
                imgIcon.style.display = 'block';
                imgIcon.src = `https://openweathermap.org/img/wn/${data.weather[0].icon}@2x.png`;
                
                let deskripsi = data.weather[0].description;
                deskripsi = deskripsi.split(' ').map(kata => kata.charAt(0).toUpperCase() + kata.slice(1)).join(' ');
                
                document.getElementById('deskripsiCuaca').innerText = deskripsi;
                document.getElementById('suhuCuaca').innerText = Math.round(data.main.temp) + '°C';
            } else {
                document.getElementById('loadingCuaca').style.display = 'none';
                document.getElementById('deskripsiCuaca').innerText = 'Cuaca tidak tersedia';
            }
        } catch (error) {
            document.getElementById('loadingCuaca').style.display = 'none';
            document.getElementById('deskripsiCuaca').innerText = 'Koneksi cuaca terputus';
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        tarikDataCuaca();
    });

    // 2. Logika Form Buku Tamu
    const formTamu = document.getElementById('formBukuTamu');
    if (formTamu) {
        const timezoneWITA = { timeZone: 'Asia/Makassar', weekday: 'long' };
        const hariIni = new Intl.DateTimeFormat('id-ID', timezoneWITA).format(new Date()).toLowerCase();
        
        const sesiSelect = document.getElementById('input_sesi');
        const btnSubmit = document.getElementById('btnSubmitTamu');
        const allInputs = formTamu.querySelectorAll('input, select, textarea');

        // Logika Museum Tutup Hari Senin
        if (hariIni === 'senin') {
            allInputs.forEach(input => input.disabled = true);
            btnSubmit.innerHTML = '<i class="bi bi-lock-fill me-2"></i>Museum Tutup';
            btnSubmit.disabled = true;
            // Warna tombol saat disabled disesuaikan
            btnSubmit.style.background = '#e9ecef';
            btnSubmit.style.color = '#6c757d';
            btnSubmit.style.border = 'none';
            
            const alertLibur = document.createElement('div');
            alertLibur.className = 'alert alert-danger text-center fw-bold shadow-sm mb-4 border-0';
            alertLibur.style.backgroundColor = '#ffe5e5';
            alertLibur.style.color = '#cc0000';
            alertLibur.innerHTML = '<i class="bi bi-exclamation-triangle-fill me-2"></i>Mohon maaf, Museum Wasaka tutup pada hari Senin.';
            formTamu.prepend(alertLibur);
            
        } else if (hariIni === 'jumat') {
            sesiSelect.innerHTML = `
                <option value="" selected disabled>Pilih Sesi...</option>
                <option value="Sesi Pagi (09.00 - 12.00 WITA)">Sesi Pagi (09.00 - 12.00 WITA)</option>
            `;
            const alertJumat = document.createElement('div');
            // Sedikit mengubah warna alert Jumat agar tidak terlalu mencolok (lebih kalem)
            alertJumat.className = 'alert text-center small py-2 mb-3 border-0 shadow-sm';
            alertJumat.style.backgroundColor = '#fdfbf7';
            alertJumat.style.color = '#856404';
            alertJumat.style.borderLeft = '3px solid #C5A059';
            alertJumat.innerHTML = '<i class="bi bi-info-circle-fill me-2"></i>Khusus hari Jumat, museum hanya beroperasi untuk Sesi Pagi.';
            formTamu.prepend(alertJumat);
        }

        formTamu.addEventListener('submit', async function(e) {
            e.preventDefault(); 
            
            if (hariIni === 'senin') {
                Swal.fire({ icon: 'error', title: 'Museum Tutup', text: 'Mohon maaf, museum tutup hari ini.' });
                return;
            }

            const jumlahRombongan = parseInt(document.getElementById('input_jumlah').value);
            if (jumlahRombongan > 30) {
                Swal.fire({ 
                    icon: 'warning', 
                    title: 'Batas Rombongan Terlampaui', 
                    text: 'Mohon maaf, jumlah rombongan maksimal yang dapat diinput adalah 30 orang.',
                    confirmButtonColor: '#C5A059'
                });
                return; 
            }

            btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mengirim...';
            btnSubmit.disabled = true;

            const formData = new FormData();
            formData.append('nama', document.getElementById('input_nama').value);
            formData.append('asal_instansi', document.getElementById('input_instansi').value);
            formData.append('kategori', document.getElementById('input_kategori').value);
            formData.append('jumlah_rombongan', document.getElementById('input_jumlah').value);
            formData.append('tujuan_kunjungan', document.getElementById('input_tujuan').value);
            formData.append('no_hp', document.getElementById('input_hp').value);
            formData.append('sesi_kunjungan', document.getElementById('input_sesi').value);

            try {
                const response = await fetch('/api/pengunjung', {
                    method: 'POST',
                    headers: { 'Accept': 'application/json' },
                    body: formData
                });

                const result = await response.json();

                if (response.ok) {
                    formTamu.classList.add('d-none'); 
                    document.getElementById('pesanSukses').classList.remove('d-none');
                } else {
                    let errorMsg = result.message || 'Cek kembali isian Anda.';
                    if(result.errors) {
                        errorMsg = Object.values(result.errors).flat().join('\n');
                    }
                    Swal.fire({ icon: 'warning', title: 'Data Tidak Lengkap', text: errorMsg, confirmButtonColor: '#C5A059' });
                    btnSubmit.innerHTML = '<i class="bi bi-send-fill me-2"></i> KIRIM KEHADIRAN';
                    btnSubmit.disabled = false;
                }
            } catch (error) {
                Swal.fire({ icon: 'error', title: 'Koneksi Terputus', text: 'Terjadi kesalahan jaringan atau server.', confirmButtonColor: '#C5A059' });
                btnSubmit.innerHTML = '<i class="bi bi-send-fill me-2"></i> KIRIM KEHADIRAN';
                btnSubmit.disabled = false;
            }
        });
    }
</script>
@endsection
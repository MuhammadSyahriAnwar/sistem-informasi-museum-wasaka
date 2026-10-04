<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengunjung - Museum Wasaka</title>
    <style>
        /* Pengaturan kertas dasar */
        @page {
            size: A4 portrait;
            margin: 20px; 
        }
        
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt; 
            color: #000;
            line-height: 1.3;
            /* INI KUNCINYA: Memaksa space putih 60px di kiri dan kanan agar tabel tidak mentok */
            margin: 20px 60px; 
        }

        /* --- DESAIN KOP SURAT --- */
        .kop-surat {
            text-align: center;
        }
        .kop-surat h2 {
            margin: 0;
            font-size: 14pt;
            font-weight: bold;
        }
        .kop-surat h3 {
            margin: 0;
            font-size: 16pt;
            font-weight: bold;
        }
        .kop-surat p {
            margin: 4px 0 0 0;
            font-size: 10pt;
        }
        .garis-kop {
            border-top: 3px solid black;
            border-bottom: 1px solid black;
            height: 2px;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        /* --- JUDUL LAPORAN --- */
        .judul {
            text-align: center;
            margin-bottom: 20px;
        }
        .judul h4 {
            margin: 0;
            font-size: 12pt;
            text-decoration: underline;
            text-transform: uppercase;
        }
        .judul p {
            margin: 5px 0 0 0;
            font-size: 11pt;
        }

        /* --- TABEL DATA PENGUNJUNG --- */
        table.tabel-data {
            width: 100%; /* Lebar akan menyesuaikan margin body, jadi tetap compact */
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        table.tabel-data th, table.tabel-data td {
            border: 1px solid black;
            padding: 5px 6px; 
        }
        table.tabel-data th {
            background-color: #e9ecef;
            text-align: center;
            vertical-align: middle;
            font-weight: bold;
        }
        .center { text-align: center; }

        /* --- LAYOUT BAWAH (RINGKASAN & TTD) --- */
        table.layout-bawah {
            width: 100%;
            border: none;
        }
        table.layout-bawah td.kolom-kiri {
            width: 55%;
            vertical-align: top;
            border: none;
        }
        table.layout-bawah td.kolom-kanan {
            width: 45%;
            vertical-align: top;
            border: none;
            text-align: right;
        }

        table.tabel-ringkasan {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }
        table.tabel-ringkasan td {
            border: none;
            padding: 3px 0;
            font-size: 11pt;
        }

        /* Area Tanda Tangan */
        .ttd {
            display: inline-block;
            text-align: center;
            width: 230px;
        }
        .ttd p {
            margin: 0 0 5px 0;
        }
        .ttd-space {
            height: 65px;
        }
    </style>
</head>
<body>

    <div class="kop-surat">
        <h2>PEMERINTAH PROVINSI KALIMANTAN SELATAN</h2>
        <h2>DINAS PENDIDIKAN DAN KEBUDAYAAN</h2>
        <h3>MUSEUM WASAKA</h3>
        <p>Jl. Kampung Kenanga Ulu, Kec. Banjarmasin Utara, Kota Banjarmasin, Kalimantan Selatan 70122</p>
        <div class="garis-kop"></div>
    </div>

    <div class="judul">
        <h4>LAPORAN REKAPITULASI PENGUNJUNG MUSEUM</h4>
        <p>Periode: {{ strtoupper($teksPeriode) }}</p>
    </div>

    <table class="tabel-data">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Tanggal</th>
                <th width="25%">Nama / Ketua Rombongan</th>
                <th width="20%">Instansi / Asal</th>
                <th width="15%">Kategori</th>
                <th width="10%">Sesi</th>
                <th width="10%">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dataPengunjung as $index => $p)
            <tr>
                <td class="center">{{ $index + 1 }}</td>
                <td class="center">{{ \Carbon\Carbon::parse($p->created_at)->translatedFormat('d M Y') }}</td>
                <td>{{ $p->nama }}</td>
                <td>{{ $p->asal_instansi }}</td>
                <td>{{ $p->kategori }}</td>
                <td class="center">{{ str_contains($p->sesi_kunjungan, 'Pagi') ? 'Pagi' : 'Siang' }}</td>
                <td class="center">{{ $p->jumlah_rombongan }} Org</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="center"><em>Tidak ada data kunjungan pada periode ini.</em></td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <table class="layout-bawah">
        <tr>
            <td class="kolom-kiri">
                <strong><u>Ringkasan Kunjungan:</u></strong>
                <table class="tabel-ringkasan">
                    <tr>
                        <td width="60%">Total Kategori Umum</td>
                        <td width="5%">:</td>
                        <td width="35%">{{ $totalUmum }} Orang</td>
                    </tr>
                    <tr>
                        <td>Total Kategori Pelajar/Mahasiswa</td>
                        <td>:</td>
                        <td>{{ $totalPelajar }} Orang</td>
                    </tr>
                    <tr>
                        <td>Total Kategori Instansi</td>
                        <td>:</td>
                        <td>{{ $totalInstansi }} Orang</td>
                    </tr>
                    <tr>
                        <td><strong>Total Keseluruhan</strong></td>
                        <td><strong>:</strong></td>
                        <td><strong>{{ $totalOrang }} Orang</strong></td>
                    </tr>
                </table>
            </td>
            
            <td class="kolom-kanan">
                <div class="ttd">
                    <p>Banjarmasin, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                    <p>Mengetahui,<br>Kepala Museum Wasaka</p>
                    <div class="ttd-space"></div>
                    <p><strong><u>_________________________</u></strong><br>NIP. ....................................</p>
                </div>
            </td>
        </tr>
    </table>

</body>
</html>
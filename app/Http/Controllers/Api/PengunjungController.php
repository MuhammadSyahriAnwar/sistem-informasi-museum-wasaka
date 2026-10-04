<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengunjung; 

class PengunjungController extends Controller
{
    // Fungsi untuk menampilkan semua data pengunjung (Read)
    public function index()
    {
        $pengunjung = Pengunjung::latest()->get();
        return response()->json([
            'status' => 'success',
            'data' => $pengunjung
        ], 200);
    }

    // Fungsi untuk menyimpan data pengunjung baru (Create)
    public function store(Request $request)
    {
    // 1. Validasi inputan agar tidak ada yang kosong/salah format
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'asal_instansi' => 'nullable|string|max:255',
            // UBAH BARIS KATEGORI MENJADI SEPERTI INI:
            'kategori' => 'required|in:Pelajar/Mahasiswa,Masyarakat Umum,Instansi/Peneliti,Wisatawan Asing',
            'jumlah_rombongan' => 'required|integer|min:1',
            'sesi_kunjungan' => 'required|string|max:255',
            'tujuan_kunjungan' => 'nullable|string'
        ]);

        // 2. Simpan ke database
        $pengunjung = Pengunjung::create($request->all());

        // 3. Berikan balasan (response) ke frontend
        return response()->json([
            'status' => 'success',
            'message' => 'Data pengunjung berhasil dicatat',
            'data' => $pengunjung
        ], 201);
    }

// Tambahkan fungsi ini ke PengunjungController.php
    public function destroy($id)
    {
        $pengunjung = Pengunjung::findOrFail($id);
        $pengunjung->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data pengunjung berhasil dihapus'
        ], 200);
    }

    // Fungsi untuk menampilkan statistik/rekapitulasi pengunjung
    public function statistik()
    {
        // Mendapatkan tanggal dan bulan saat ini
        $hariIni = now()->format('Y-m-d');
        $bulanIni = now()->month;
        $tahunIni = now()->year;

        // Menghitung total ORANG (bukan cuma entri), menggunakan sum() pada kolom jumlah_rombongan
        $totalHariIni = Pengunjung::whereDate('created_at', $hariIni)->sum('jumlah_rombongan');
        
        $totalBulanIni = Pengunjung::whereMonth('created_at', $bulanIni)
                                   ->whereYear('created_at', $tahunIni)
                                   ->sum('jumlah_rombongan');

        $totalKeseluruhan = Pengunjung::sum('jumlah_rombongan');

        // Mengelompokkan total pengunjung berdasarkan Kategori
        $rekapKategori = Pengunjung::selectRaw('kategori, SUM(jumlah_rombongan) as total_orang')
                                   ->groupBy('kategori')
                                   ->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Data statistik berhasil dimuat',
            'data' => [
                'pengunjung_hari_ini' => (int) $totalHariIni,
                'pengunjung_bulan_ini' => (int) $totalBulanIni,
                'total_keseluruhan' => (int) $totalKeseluruhan,
                'rekap_berdasarkan_kategori' => $rekapKategori
            ]
        ], 200);
    }
}
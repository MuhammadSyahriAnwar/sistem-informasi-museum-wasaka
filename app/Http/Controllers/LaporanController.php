<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Pengunjung; // Pastikan model ini sesuai (misal: Pengunjung)

class LaporanController extends Controller
{
    public function cetakPengunjung(Request $request)
    {
        // 1. Mulai Query dasar
        $query = Pengunjung::query();
        $periode = $request->periode;
        
        // Variabel untuk tulisan "Periode: ..." di kop surat PDF
        $teksPeriode = 'SEMUA WAKTU';

        // 2. Logika Filter Data & Penentuan Teks Periode
        if ($periode == 'hari_ini') {
            $query->whereDate('created_at', Carbon::today());
            $teksPeriode = Carbon::today()->translatedFormat('d F Y');
            
        } elseif ($periode == 'minggu_ini') {
            $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
            $teksPeriode = 'MINGGU INI';
            
        } elseif ($periode == 'bulan_ini') {
            $query->whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year);
            $teksPeriode = 'BULAN ' . Carbon::now()->translatedFormat('F Y');
            
        } elseif ($periode == 'triwulan') {
            $query->whereBetween('created_at', [Carbon::now()->subMonths(3)->startOfDay(), Carbon::now()->endOfDay()]);
            $teksPeriode = '3 BULAN TERAKHIR';
            
        } elseif ($periode == 'semester') {
            $query->whereBetween('created_at', [Carbon::now()->subMonths(6)->startOfDay(), Carbon::now()->endOfDay()]);
            $teksPeriode = '6 BULAN TERAKHIR';
            
        } elseif ($periode == 'tahun_ini') {
            $query->whereYear('created_at', Carbon::now()->year);
            $teksPeriode = 'TAHUN ' . Carbon::now()->year;
            
        } elseif ($periode == 'kustom') {
            if ($request->has('start_date') && $request->has('end_date')) {
                $mulai = $request->start_date . ' 00:00:00';
                $selesai = $request->end_date . ' 23:59:59';
                $query->whereBetween('created_at', [$mulai, $selesai]);
                
                // Format teks: "10 Juni 2026 s/d 18 Juli 2026"
                $teksPeriode = Carbon::parse($request->start_date)->translatedFormat('d F Y') . ' s/d ' . Carbon::parse($request->end_date)->translatedFormat('d F Y');
            }
        }

        // 3. Eksekusi Query
        $dataPengunjung = $query->orderBy('created_at', 'desc')->get();

        // 4. Hitung Rekapitulasi untuk Tabel Ringkasan PDF
        $totalUmum = 0;
        $totalPelajar = 0;
        $totalInstansi = 0;
        $totalOrang = 0;

        foreach ($dataPengunjung as $p) {
            // Ambil field jumlah_rombongan, jika kosong/null anggap 1 orang
            $jumlah = $p->jumlah_rombongan ?? 1; 
            $totalOrang += $jumlah;

            $kategori = strtolower($p->kategori);
            if (str_contains($kategori, 'umum')) {
                $totalUmum += $jumlah;
            } elseif (str_contains($kategori, 'pelajar') || str_contains($kategori, 'mahasiswa')) {
                $totalPelajar += $jumlah;
            } elseif (str_contains($kategori, 'instansi')) {
                $totalInstansi += $jumlah;
            }
        }

        // 5. Kembalikan ke View PDF
        // Ubah dari 'auth.laporan.pdf-pengunjung' menjadi 'laporan.pdf-pengunjung'
        return view('laporan.pdf-pengunjung', compact(
            'dataPengunjung', 
            'periode', 
            'teksPeriode', 
            'totalUmum', 
            'totalPelajar', 
            'totalInstansi', 
            'totalOrang'
        ));
    }
}
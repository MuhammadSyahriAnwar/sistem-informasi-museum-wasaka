<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaporanController;
use App\Models\Visitor; 
use Carbon\Carbon;     
use Illuminate\Http\Request; 

// 1. HALAMAN UTAMA (FRONTEND PUBLIK) + FITUR VISITOR TRACKER
Route::get('/', function (Request $request) {
    $ip = $request->ip();
    $date = Carbon::now()->toDateString();

    $hasVisited = Visitor::where('ip_address', $ip)
                         ->where('visit_date', $date)
                         ->exists();

    if (!$hasVisited) {
        Visitor::create([
            'ip_address' => $ip,
            'visit_date' => $date
        ]);
    }

    $pengunjungHariIni = Visitor::where('visit_date', $date)->count();
    $totalPengunjung = Visitor::count();

    return view('welcome', compact('pengunjungHariIni', 'totalPengunjung'));
});

// 2. HALAMAN LOGIN
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// 3. HALAMAN DASHBOARD
Route::get('/dashboard', function () {
    $totalPengunjung = \App\Models\Visitor::count(); 
    return view('dashboard', compact('totalPengunjung'));
});

// RUTE LAPORAN (Backend)
Route::get('/admin/laporan/pengunjung', [LaporanController::class, 'cetakPengunjung'])->name('laporan.pengunjung');

// 4. MANAJEMEN DATA
Route::get('/koleksi', function () { return view('koleksi'); });
Route::get('/kegiatan', function () { return view('kegiatan'); });
Route::get('/galeri', function () { return view('galeri'); });
Route::get('/agenda', function () { return view('agenda'); });
Route::get('/jelajah', function () { return view('pengunjung.jelajah'); });
Route::get('/buku-tamu', function () { 
    return view('buku_tamu'); 
});

// Rute Kelola Pengunjung (Pastikan penutupnya benar)
Route::get('/kelola-pengunjung', function () {
    return view('kelola_pengunjung');
});

// Rute Laporan Internal (Cukup satu saja)
Route::get('/laporan-internal', function () {
    return view('laporan_internal');
})->name('laporan.internal');

Route::get('/lapor-kendala', function () {
    return view('lapor_kendala'); // HARUS SAMA DENGAN NAMA FILE laporan_kendala.blade.php
})->name('lapor.kendala');

// Rute By-Pass Gambar (Ini benar di web.php karena diakses via browser)
use App\Http\Controllers\KelolaLaporanController;
Route::get('/lihat-foto-kendala/{filename}', [KelolaLaporanController::class, 'getFoto']);
Route::get('/about-us', function () {
    return view('about-us');
});
Route::delete('/laporan-internal/{id}', [App\Http\Controllers\KelolaLaporanController::class, 'destroy']);


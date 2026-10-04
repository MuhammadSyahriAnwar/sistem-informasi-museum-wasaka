<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Koleksi;
use App\Models\KategoriKoleksi; // Import model Kategori

class KoleksiController extends Controller
{
    // ==========================================
    // FUNGSI KHUSUS: Mengambil Daftar Kategori
    // ==========================================
    public function getKategori()
    {
        $kategori = KategoriKoleksi::all();
        return response()->json([
            'status' => 'success',
            'data' => $kategori
        ], 200);
    }

    // ==========================================
    // 1. Melihat daftar koleksi (Read)
    // ==========================================
    public function index()
    {
        // PENTING: Gunakan with('kategori') untuk membawa data nama kategorinya (Eager Loading)
        $koleksi = Koleksi::with('kategori')->latest()->get();
        
        return response()->json([
            'status' => 'success',
            'data' => $koleksi
        ], 200);
    }

    // ==========================================
    // 2. Menambah koleksi baru (Create)
    // ==========================================
    public function store(Request $request)
    {
        // Validasi inputan (TAMBAHKAN KATEGORI_ID)
        $request->validate([
            'kategori_id' => 'required|exists:kategori_koleksis,id', // Pastikan ID Kategori valid
            'nama_koleksi' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:5120' 
        ]);

        $data = $request->all();

        // Proses upload foto (CARA KLASIK / JALUR DARURAT)
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');

            if (!$file->isValid()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Upload foto gagal! PHP Error: ' . $file->getError()
                ], 400);
            }

            // Buat nama file rapi
            $namaFile = time() . '_' . $file->getClientOriginalName();
            
            // Pindahkan file SECARA PAKSA langsung ke folder tujuan
            $file->move(public_path('storage/koleksi'), $namaFile);
            
            $data['foto'] = $namaFile;
        }

        // Simpan data ke database
        $koleksi = Koleksi::create($data);

        // Ambil ulang data yang baru di-create BESERTA kategorinya biar resposenya lengkap
        $koleksi = Koleksi::with('kategori')->find($koleksi->id);

        return response()->json([
            'status' => 'success',
            'message' => 'Koleksi berhasil ditambahkan',
            'data' => $koleksi
        ], 201);
    }

    // ==========================================
    // 3. Mengedit data koleksi (Update)
    // ==========================================
    public function update(Request $request, $id)
    {
        // Cari data berdasarkan ID
        $koleksi = Koleksi::find($id);
        if (!$koleksi) {
            return response()->json(['status' => 'error', 'message' => 'Data Koleksi tidak ditemukan'], 404);
        }

        // Validasi opsional untuk update
        $request->validate([
            'kategori_id' => 'nullable|exists:kategori_koleksis,id', // Boleh null jika tidak diubah
            'nama_koleksi' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:5120' 
        ]);

        $data = $request->all();

        // Jika Admin mengupload foto baru
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            if (!$file->isValid()) return response()->json(['status' => 'error', 'message' => 'Error file'], 400);

            // Hapus foto lama
            $fotoLama = public_path('storage/koleksi/' . $koleksi->foto);
            if (file_exists($fotoLama) && $koleksi->foto != null) {
                unlink($fotoLama); 
            }

            // Simpan foto baru
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/koleksi'), $namaFile);
            $data['foto'] = $namaFile;
        }

        // Update ke database
        $koleksi->update($data);

        // Ambil ulang data yang baru di-update BESERTA kategorinya
        $koleksi = Koleksi::with('kategori')->find($koleksi->id);

        return response()->json([
            'status' => 'success',
            'message' => 'Koleksi berhasil diupdate',
            'data' => $koleksi
        ], 200);
    }

    // ==========================================
    // 4. Menghapus data koleksi (Delete)
    // ==========================================
    public function destroy($id)
    {
        $koleksi = Koleksi::find($id);
        if (!$koleksi) {
            return response()->json(['status' => 'error', 'message' => 'Data Koleksi tidak ditemukan'], 404);
        }

        // Hapus file foto fisiknya dari folder
        $fotoLama = public_path('storage/koleksi/' . $koleksi->foto);
        if (file_exists($fotoLama) && $koleksi->foto != null) {
            unlink($fotoLama); 
        }

        // Hapus data dari database
        $koleksi->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Koleksi berhasil dihapus'
        ], 200);
    }
}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kegiatan;

class KegiatanController extends Controller
{
    // 1. Publik: Melihat daftar kegiatan (diurutkan dari yang terbaru pelaksanaannya)
    public function index()
    {
        $kegiatan = Kegiatan::orderBy('tanggal_pelaksanaan', 'desc')->get();
        return response()->json([
            'status' => 'success',
            'data' => $kegiatan
        ], 200);
    }

    // 2. Admin: Menambah kegiatan
    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'tanggal_pelaksanaan' => 'required|date',
            'deskripsi' => 'required|string',
            'foto_kegiatan' => 'nullable|image|mimes:jpeg,png,jpg|max:5120' 
        ]);

        $data = $request->all();

        // Upload foto menggunakan cara klasik
        if ($request->hasFile('foto_kegiatan')) {
            $file = $request->file('foto_kegiatan');

            if (!$file->isValid()) {
                return response()->json(['status' => 'error', 'message' => 'PHP Error: ' . $file->getError()], 400);
            }

            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/kegiatan'), $namaFile);
            $data['foto_kegiatan'] = $namaFile;
        }

        $kegiatan = Kegiatan::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Kegiatan berhasil ditambahkan',
            'data' => $kegiatan
        ], 201);
    }

    // 3. Admin: Mengedit data kegiatan
    public function update(Request $request, $id)
    {
        $kegiatan = Kegiatan::find($id);
        if (!$kegiatan) {
            return response()->json(['status' => 'error', 'message' => 'Data Kegiatan tidak ditemukan'], 404);
        }

        $data = $request->all();

        // Jika Admin mengupload foto baru
        if ($request->hasFile('foto_kegiatan')) {
            $file = $request->file('foto_kegiatan');
            
            if (!$file->isValid()) {
                return response()->json(['status' => 'error', 'message' => 'Error file'], 400);
            }

            // Hapus foto lama agar penyimpanan server tidak membengkak
            $fotoLama = public_path('storage/kegiatan/' . $kegiatan->foto_kegiatan);
            if (file_exists($fotoLama) && $kegiatan->foto_kegiatan != null) {
                unlink($fotoLama); 
            }

            // Simpan foto baru
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/kegiatan'), $namaFile);
            $data['foto_kegiatan'] = $namaFile;
        }

        $kegiatan->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Kegiatan berhasil diupdate',
            'data' => $kegiatan
        ], 200);
    }

    // 4. Admin: Menghapus data kegiatan
    public function destroy($id)
    {
        $kegiatan = Kegiatan::find($id);
        if (!$kegiatan) {
            return response()->json(['status' => 'error', 'message' => 'Data Kegiatan tidak ditemukan'], 404);
        }

        // Hapus file foto fisik dari folder penyimpanan
        $fotoLama = public_path('storage/kegiatan/' . $kegiatan->foto_kegiatan);
        if (file_exists($fotoLama) && $kegiatan->foto_kegiatan != null) {
            unlink($fotoLama); 
        }

        $kegiatan->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Kegiatan berhasil dihapus'
        ], 200);
    }
}
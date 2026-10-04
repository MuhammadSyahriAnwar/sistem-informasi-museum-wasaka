<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;
use Illuminate\Support\Facades\Storage;

class KelolaLaporanController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->role === 'petugas') {
            $laporan = Laporan::with('user')->where('user_id', $request->user()->id)->orderBy('created_at', 'desc')->get();
        } else {
            $laporan = Laporan::with('user')->orderBy('created_at', 'desc')->get();
        }
        return response()->json(['success' => true, 'data' => $laporan], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required|string',
            'judul_laporan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'jenis_pelapor' => 'required|in:Petugas,Pengunjung',
            'nama_pelapor' => 'nullable|string',
            'no_hp' => 'nullable|string',
        ]);

        $input = $request->all();
        $input['status'] = 'Menunggu';

        $user = auth('sanctum')->user();
        if ($request->jenis_pelapor === 'Petugas' && $user) {
            $input['user_id'] = $user->id;
        } else {
            $input['user_id'] = null;
            $input['jenis_pelapor'] = 'Pengunjung'; 
        }

        // Simpan LANGSUNG ke folder public agar tidak kena masalah izin Windows
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('foto_laporan'), $filename);
            $input['foto'] = '/foto_laporan/' . $filename;
        }

        

        $laporan = Laporan::create($input);
        return response()->json(['success' => true, 'message' => 'Laporan berhasil!', 'data' => $laporan], 201);
    }

// 4. Admin menghapus laporan
    public function destroy($id)
    {
        $laporan = Laporan::find($id);

        if (!$laporan) {
            return response()->json(['success' => false, 'message' => 'Laporan tidak ditemukan'], 404);
        }

        // Hapus file fisik foto jika ada
        if ($laporan->foto) {
            $filePath = public_path($laporan->foto);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $laporan->delete();

        return response()->json(['success' => true, 'message' => 'Laporan berhasil dihapus'], 200);
    }

    public function updateStatus(Request $request, $id)
    {
        $laporan = Laporan::find($id);
        if (!$laporan) return response()->json(['success' => false], 404);
        $laporan->update(['status' => $request->status]);
        return response()->json(['success' => true], 200);
    }
}
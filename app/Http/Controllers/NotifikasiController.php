<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    /**
     * Daftar notifikasi milik user yang sedang login (untuk mengisi dropdown
     * lonceng notifikasi saat halaman pertama kali dimuat / fallback polling).
     */
    public function index()
    {
        $notifikasis = Auth::user()->notifikasis()->limit(20)->get()->map(function ($n) {
            return [
                'id' => $n->id,
                'tipe' => $n->tipe,
                'judul' => $n->judul,
                'pesan' => $n->pesan,
                'data' => $n->data,
                'is_read' => $n->is_read,
                'created_at' => $n->created_at->diffForHumans(),
            ];
        });

        return response()->json([
            'notifikasis' => $notifikasis,
            'jumlah_belum_dibaca' => Auth::user()->notifikasis()->where('is_read', false)->count(),
        ]);
    }

    /**
     * Jumlah notifikasi belum dibaca saja — dipakai untuk badge lonceng
     * tanpa harus mengambil seluruh daftar (lebih ringan, dipoll berkala
     * sebagai fallback jika koneksi websocket terputus).
     */
    public function jumlahBelumDibaca()
    {
        return response()->json([
            'jumlah_belum_dibaca' => Auth::user()->notifikasis()->where('is_read', false)->count(),
        ]);
    }

    /**
     * Tandai satu notifikasi sebagai sudah dibaca.
     */
    public function tandaiDibaca(Request $request, $id)
    {
        $notifikasi = Auth::user()->notifikasis()->findOrFail($id);
        $notifikasi->tandaiDibaca();

        return response()->json(['success' => true]);
    }

    /**
     * Tandai seluruh notifikasi milik user sebagai sudah dibaca sekaligus,
     * misalnya saat dropdown lonceng dibuka.
     */
    public function tandaiSemuaDibaca()
    {
        Auth::user()->notifikasis()->where('is_read', false)->update([
            'is_read' => true,
            'read_at' => now(),
        ]);

        return response()->json(['success' => true]);
    }
}
